<?php
require_once __DIR__ . '/vendor/autoload.php';
use App\Classes\User;

echo "Enter Admin Name: ";
$name = trim(fgets(STDIN));
echo "Enter Admin Email: ";
$email = trim(fgets(STDIN));
echo "Enter Admin Password: ";
$password = trim(fgets(STDIN));
$user = new User(); 

$result = $user->createAdmin($name, $email, $password);
if ($result) {
    echo "Admin created successfully.\n";
} else {
    echo "Failed to create admin. Email already exists.\n";
}
