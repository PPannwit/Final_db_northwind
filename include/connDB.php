<?php

$host = 'localhost';
$db   = 'db_northwind';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';


$dsn = "mysql:host=$host;dbname=$db;charset=$charset";


try {

    $pdo = new PDO($dsn, $user, $pass);


} catch (\PDOException $e) {

    echo "Connection failed: " . $e->getMessage();
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
