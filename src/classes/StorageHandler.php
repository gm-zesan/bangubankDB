<?php

namespace App\Classes;

use Exception;

abstract class StorageHandler
{
    protected static $instance;

    public static function getInstance(){
        if (self::$instance === null) {
            $config = include(__DIR__ . '/../config.php');
            $storageType = $config['storage'];

            if ($storageType === 'file') {
                self::$instance = new FileStorage($config['file_paths']);
            } elseif ($storageType === 'database') {
                self::$instance = new DatabaseStorage();
            } else {
                throw new Exception('Invalid storage type specified in config.');
            }
        }
        return self::$instance;
    }
    abstract public function store(string $component, array $data): void;
    abstract public function transactionStore(string $component, array $data): void;
    abstract public function retrieve(string $component): array;
    abstract public function getUserByEmail(string $email): ?array;
}
