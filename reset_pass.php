<?php
require 'config/paths.php';
require 'vendor/autoload.php';

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Authentication\PasswordHasher\DefaultPasswordHasher;

$hasher = new DefaultPasswordHasher();
$adminPass = $hasher->hash('Admin@123');
$custPass = $hasher->hash('Customer@123');

$pdo = new PDO('mysql:host=localhost;dbname=mybake', 'root', '');
$pdo->exec("UPDATE users SET password = '$adminPass' WHERE email = 'admin@mybake.com'");
$pdo->exec("UPDATE users SET password = '$custPass' WHERE email = 'zahid@gmail.com'");
echo "Passwords reset successfully.\n";
