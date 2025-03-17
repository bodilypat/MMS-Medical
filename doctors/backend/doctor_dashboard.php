<?php
    /* Start session */
    session_start();

    /* If user is not logged in or not a doctor, redirect to login page */
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
        header('Location: login.php');
        exit();
    }

    /* Get doctor details form session */
    $doctor_first_name = $_SESSION['first_name'];
    $doctor_last_name = $_SESSION['last_name'];

    /* Database connection (optional, to fetch additional doctor-specific data) */
    $dbcon = new mysqli("location","username","password","dbmedical");

    /* Check the connection */
    if ($dbcon->connect_error) {
        die("Connect failed: " . $dbcon->connect_error);
    }
?>
