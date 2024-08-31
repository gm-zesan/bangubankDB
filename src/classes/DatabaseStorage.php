<?php

namespace App\Classes;
use PDO;
use Exception;

class DatabaseStorage extends StorageHandler{
    private $pdo;
    private $tables;
    private $email;

    public function __construct(){
        $config = include(__DIR__ . '/../config.php');
        $dbConfig = $config['db'];
        try {
            $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']}";
            $this->pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
        $this->tables = $dbConfig['tables'];
    }

    public function store(string $component, array $data): void{
        
        if (!isset($this->tables[$component])) {
            throw new \Exception("Invalid component: $component");
        }
        $table = $this->tables[$component];
        if (!is_array($data) || !isset($data['email'])) {
            throw new \Exception("Invalid data format. Expected associative array with 'email' key.");
        }

        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $user = $this->getUserByEmail($data['email']);

        if ($user !== null && $component === 'users') {
            $stmt = $this->pdo->prepare("UPDATE $table SET balance = ? WHERE email = ?");
            $stmt->execute([$data['balance'], $data['email']]);
            return;
        }
        $stmt = $this->pdo->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");
        $stmt->execute(array_values($data));
        
    }

    


    public function retrieve(string $component): array{
        if (!isset($this->tables[$component])) {
            throw new \Exception("Invalid component: $component");
        }
        $table = $this->tables[$component];
        $stmt = $this->pdo->query("SELECT * FROM $table");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function transactionStore(string $component, array $data): void{
        if (!isset($this->tables[$component])) {
            throw new \Exception("Invalid component: $component");
        }
        $table = $this->tables[$component];
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $stmt = $this->pdo->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");
        $stmt->execute(array_values($data));
    }

    public function getUserByEmail(string $email): ?array{
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() === 0) {
            return null;
        }
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
