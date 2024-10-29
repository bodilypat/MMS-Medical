<?php
function dbconnect(){
    /* dbconnect.php */
    $host = 'localhost';
    $db = 'dbmedical';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    try {
        // Create a PDO instance
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        // set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "Connected successfully"; // for testing purposes

    } catch (\PDOException $e) {
        // Handle connection errors
        echo "Connection failed: " .$e->getMessage();
    }
}