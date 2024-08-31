<?php
    require 'vendor/autoload.php';
    use App\Classes\Config;
    $configFile = __DIR__ . '/src/config.php';

    $config = new Config($configFile);

    // Check if an argument was provided
    if ($argc < 2) {
        echo "Usage: php change_storage.php [file|database]\n";
        exit(1);
    }

    $storageType = $argv[1];

    if (!in_array($storageType, ['file', 'database'])) {
        echo "Invalid storage type. Choose 'file' or 'database'.\n";
        exit(1);
    }

    $config->set('storage', $storageType);

    echo "Storage type successfully updated to '$storageType'.\n";
?>
