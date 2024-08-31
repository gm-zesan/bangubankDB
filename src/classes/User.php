<?php
    namespace APP\classes;
    use App\classes\Helpers as ClassesHelpers;
    use App\Classes\StorageHandler;
    use App\classes\ValidateTrait;


    class User extends ClassesHelpers {
        use ValidateTrait;

        protected $email;
        protected $balance;
        protected $storageHandler;
        protected $transaction;
        protected $errors = array();

        public function __construct(){
            $this->storageHandler = StorageHandler::getInstance();
        }

        public function createAdmin($name, $email, $password) {
            $adminData = [
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'balance' => 0,
                'isAdmin' => true
            ];
            $users = $this->storageHandler->retrieve('users');
            foreach ($users as $user) {
                if ($user['email'] === $email) {
                    return false;
                }
            }
            $this->storageHandler->store('users', $adminData);
            return true;
        }
        
        
        public function register($name, $email, $password){
            if ($this->validate('name', $name) === false) {
                $this->errors[] = array('error' => 'Name is required', 'field' => 'name');
            }
            if ($this->validate('email', $email) === false) {
                $this->errors[] = array('error' => 'Email is required', 'field' => 'email');
            }
            if ($this->validate('password', $password) === false) {
                $this->errors[] = array('error' => 'Password is required', 'field' => 'password');
            }
            if (!empty($this->errors)) {
                return $this->errors;
            }
            $users = $this->storageHandler->retrieve('users');
            foreach ($users as $user) {
                if ($user['email'] === $email) {
                    return false;
                }
            }
            $newUser = [
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'balance' => 0,
                'isAdmin' => false
            ];
            $this->storageHandler->store('users', $newUser);

            return true;
        }

        public function login($email, $password){
            if ($this->validate('email', $email) === false) {
                $this->errors[] = array('error' => 'Email is required', 'field' => 'email');
            }
            if ($this->validate('password', $password) === false) {
                $this->errors[] = array('error' => 'Password is required', 'field' => 'password');
            }
            if (!empty($this->errors)) {
                return $this->errors;
            }
            $users = $this->storageHandler->retrieve('users');
            foreach ($users as $user) {
                if ($user['email'] === $email && password_verify($password, $user['password'])) {
                    $this->email = $email;
                    $this->balance = $user['balance'];
                    return $user;
                }
            }
            return false;
        }



        public function getAllUsers(){
            return $this->storageHandler->retrieve('users');
        }

        public function getUserNameByEmail($email) {
            if ($email) {
                $users = $this->storageHandler->retrieve('users');
                foreach ($users as $user) {
                    if ($user['email'] === $email) {
                        return $user['name'];
                    }
                }
            }
            return 'Unknown';
        }

        
        public function getInitials($fullName) {
            $nameParts = explode(' ', $fullName);
            if (count($nameParts) > 1) {
                $initials = '';
                foreach ($nameParts as $part) {
                    $initials .= strtoupper($part[0]);
                }
                return substr($initials, 0, 2);
            } else {
                return strtoupper(substr($fullName, 0, 2));
            }
        }

        
        public function getBalance($email){
            if ($email) {
                $users = $this->storageHandler->retrieve('users');
                foreach ($users as $user) {
                    if ($user['email'] === $email) {
                        return $user['balance'];
                    }
                }
            }
            return 0;
        }
    }
?>