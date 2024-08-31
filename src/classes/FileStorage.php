<?php

namespace App\Classes;

class FileStorage extends StorageHandler{
    
    private $filePaths;

    public function __construct(array $filePaths){
        $this->filePaths = $filePaths;
    }

    public function retrieve(string $component): array{
        if (!isset($this->filePaths[$component])) {
            throw new \Exception("Invalid component: $component");
        }
        if (!file_exists($this->filePaths[$component])) {
            return [];
        }
        $jsonContent = file_get_contents($this->filePaths[$component]);
        $data = json_decode($jsonContent, true);
        if ($data === null) {
            return [];
        }
        return $data;
    }


    // public function store(string $component, array $data): void
    // {
    //     if (!isset($this->filePaths[$component])) {
    //         throw new \Exception("Invalid component: $component");
    //     }
    //     file_put_contents($this->filePaths[$component], json_encode($data, JSON_PRETTY_PRINT));
    // }

    public function store(string $component, array $data): void{
        if (!isset($this->filePaths[$component])) {
            throw new \Exception("Invalid component: $component");
        }
        $filePath = $this->filePaths[$component];
        $existingData = [];
        if (file_exists($filePath)) {
            $jsonContent = file_get_contents($filePath);
            $existingData = json_decode($jsonContent, true);
            if (!is_array($existingData)) {
                $existingData = [];
            }
        }
        $userExists = false;
        foreach ($existingData as &$existingUser) {
            if ($existingUser['email'] === $data['email']) {
                $existingUser['balance'] = $data['balance'];
                $userExists = true;
                break;
            }
        }
        if (!$userExists) {
            $existingData[] = $data;
        }
        file_put_contents($filePath, json_encode($existingData, JSON_PRETTY_PRINT));
    }

    public function transactionStore(string $component, array $data): void{
        if (!isset($this->filePaths[$component])) {
            throw new \Exception("Invalid component: $component");
        }
        $filePath = $this->filePaths[$component];
        $existingData = [];
        if (file_exists($filePath)) {
            $jsonContent = file_get_contents($filePath);
            $existingData = json_decode($jsonContent, true);
            if (!is_array($existingData)) {
                $existingData = [];
            }
        }
        $existingData[] = $data;
        
        file_put_contents($filePath, json_encode($existingData, JSON_PRETTY_PRINT));
    }


    public function getUserByEmail(string $email): ?array
    {
        $users = $this->retrieve('users');
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                return $user;
            }
        }
        return null;
    }
}
