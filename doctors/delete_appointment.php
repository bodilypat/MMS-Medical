<?php
    session_start();
    include('../include/dbconfig.php');

    if(!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

    $appointment_id = $_GET['id'];

    /* Delete the appointment */
    $qApp = "DELETE FROM appointments WHERE id = ?";
    $stmt = $pdo->prepare($qApp);
    $stmt->execute([$appointment_id]);

    header('Location: deal_appointments.php'); /* Redirect to appointments page */
    exit();
?>
