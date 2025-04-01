<?php
$servername = "localhost";
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$dbname = "dbmedical"; // Change to your database name

// Create connection
$deal = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($deal->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
