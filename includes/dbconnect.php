<?php
    $host = 'localhost';
    $db = 'medical_namagement';
    $user = 'root';
    $pass = '';
try {
        $pdo = new PDO("mysql:host=$host;dbname:$db", $user, $pass);
        $pdo->setAttibute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){

        die("Connection failed: " $e->getMessage()) ;
    }
?>