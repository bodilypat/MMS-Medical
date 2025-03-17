<?php
    /* Start session */
    session_start();

    /* If user is not logged in or not a patient, redirect to login page */
    if (!isset($_SESSION['user_id']) || $_SESSIION['role'] !== 'patient') {
        header("Location: patient_login.php");
        exit();
    }

    /* Get patient details from session */
    $patient_first_name = $_SESSION['first_name'];
    $patient_lasst_name = $_SESSION['last_name'];

    /* Database connection (optional to fetch additional patient-specific data) */
    $dbcon = new mysqli("localhost","username","password","dbmedical");

    /* Check the connection */
    if ($dbcon->connect_error) {
        die("Connection failed: " . $dbcon->connect_error);
    }
?>
