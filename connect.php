<?php

$host = 'd118823.mysql.zonevs.eu';
$db   = 'd118823_bookss';
$user = 'd118823sa456410';
$pass = 'DABABY4321';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {

    die("Connection failed: " . $e->getMessage());
}

echo "Connected successfully!";
