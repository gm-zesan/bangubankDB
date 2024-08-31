<?php
    namespace APP\classes;

    use App\Classes\StorageHandler;
    use App\classes\ValidateTrait;
    class Transaction{
        use ValidateTrait;
    
        protected $storageHandler;
        protected $balance;
        
        protected $errors = array();

        public function __construct(){
            $this->storageHandler = StorageHandler::getInstance();
        }

        public function getTransactions(){
            return $this->storageHandler->retrieve('transactions');
        }

        public function deposit($amount, $email){
            if ($this->validate('amount', $amount) === false || $amount <= 0) {
                return false;
            }
            $users = $this->storageHandler->retrieve('users');
            foreach ($users as $user) {
                if ($user['email'] === $email) {
                    $this->balance = $user['balance'] + $amount;
                }
            }
            $this->updateUserBalance($this->balance, $email);
            $this->logTransaction($email, 'deposit', $amount);
            return true;
        }

        public function withdraw($amount, $email){
            if ($this->validate('amount', $amount) === false || $amount <= 0) {
                return false;
            }
            $users = $this->storageHandler->retrieve('users');
            foreach ($users as $user) {
                if ($user['email'] === $email) {
                    $this->balance = $user['balance'] - $amount;
                }
            }

            $this->updateUserBalance($this->balance, $email);
            $this->logTransaction($email, 'withdraw', $amount);
            return true;
        }

        public function transfer($amount, $fromEmail, $toEmail){
            $this->errors = [];
            if ($this->validate('amount', $amount) === false) {
                $this->errors[] = ['error' => 'Amount is required', 'field' => 'amount'];
            }
            if ($this->validate('email', $toEmail) === false) {
                $this->errors[] = ['error' => 'Recipient email is required', 'field' => 'email'];
            }
            if (!empty($this->errors)) {
                return $this->errors;
            }

            $users = $this->storageHandler->retrieve('users');
            $recipientFound = false;

            foreach ($users as &$user) {
                if ($user['email'] === $fromEmail) {
                    if ($user['balance'] < $amount) {
                        return false; 
                    }
                    $user['balance'] -= $amount;
                    $this->storageHandler->store('users', $user);
                }
                if ($user['email'] === $toEmail) {
                    $user['balance'] += $amount;
                    $recipientFound = true;
                    $this->storageHandler->store('users', $user); 
                }
            }

            if (!$recipientFound) {
                return false;
            }

            $this->logTransaction($fromEmail, 'transfer', $amount, $toEmail);
            $this->logTransaction($toEmail, 'received', $amount, $fromEmail);

            return true;
        }

        public function getTransactionByUser($email){
            $transactions = $this->storageHandler->retrieve('transactions');
            $userTransactions = [];
            foreach ($transactions as $transaction) {
                if ($transaction['email'] === $email || (isset($transaction['recipient']) && $transaction['recipient'] === $email)) {
                    $userTransactions[] = $transaction;
                }
            }
            return $userTransactions;
        }

        private function updateUserBalance($balance, $email){
            $users = $this->storageHandler->retrieve('users');
            foreach ($users as &$user) {
                if ($user['email'] === $email) {
                    $user['balance'] = $balance;
                    $this->storageHandler->store('users', $user);
                    return true;
                }
            }
            return false;
        }
        
        private function logTransaction($email, $type, $amount, $recipient = null) {
            // $transactions = $this->storageHandler->retrieve('transactions') ?? [];
            $transaction = [
                'email' => $email,
                'type' => $type,
                'amount' => $amount,
                'date' => date('d M Y, H:i:s'),
                'recipient' => $recipient
            ];
            $this->storageHandler->transactionStore('transactions', $transaction);
        }
    }
