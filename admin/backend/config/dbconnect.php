<?php
$host = 'psmedical.com'; // Database host
$user = 'pacha';      // Database username
$pass = '';          // Database password
$dbname = 'dbmedical'; // Database name

// Create connection
$deal = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $deal->connect_error);
}
?>
