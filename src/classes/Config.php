<?php

namespace App\Classes;

class Config
{
    private $configFile;
    private $config;

    public function __construct(string $configFile){
        $this->configFile = $configFile;
        $this->config = require $configFile;
    }

    public function get(string $key){
        return $this->config[$key] ?? null;
    }

    public function set(string $key, $value): void{
        $this->config[$key] = $value;
        $configContent = "<?php\n\nreturn " . var_export($this->config, true) . ";\n";
        file_put_contents($this->configFile, $configContent);
    }
}
