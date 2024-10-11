<?php
function dbconnect(){
    /* dbconnect.php */
    $host = 'localhost';
    $db = 'db_inventory';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    /* Data source name */
    $dsn = "mysql:host=$host;dbname=$db;charest=$charset";

    /* Options for the PDO connection */

    $options = [
        PDO::ATTR_ERRMODE           => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAUT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARE   => false,
    ];

    try {
        // Create a PDO instance
        $pdo = new PDO($dsn, $user, $pass, $option);
        echo "Connected successfully!";

    } catch (\PDOException $e) {
        // Handle connection errors
        die("Connection failed: ", .$e->getMessage(), (int)$e->getCode());
    }
}