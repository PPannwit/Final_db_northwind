<?php
// --- Step 1: Your Connection Info ---
$host = 'localhost';
$db   = 'db_northwind';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';

// --- Step 2: Create the DSN ---
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// --- Step 3: Connect and Catch Errors ---
try {
    // Create the PDO object that represents the database connection
    $pdo = new PDO($dsn, $user, $pass);
    // echo "Successfully connected to the database: " . $db;

} catch (\PDOException $e) {
    // If the connection fails, this code runs
    echo "Connection failed: " . $e->getMessage();
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
