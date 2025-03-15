<?php
    session_start();

    if(!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }
    include('../include/dbconnect.php'); /* Database connection */

    /* Fetch doctor details */
    $doctor_id = $_SESSION['user_id'];
    $sql_user = "SELECT * FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql_user);
    $stmt->execute([$doctor_id]);
    $doctor = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Doctor Dashboard</title>
    </head>
    <body>
        <h2>Welcome, <?php echo $doctor['username']; ?>!</h2>
        <a href="logout.php">Logout</a>
        <h3>Manage Patients</h3>
        <a href="deal_patients.php">View Patients</a>

        <h3>Manage Appointments</h3>
        <a href="deal_appointments.php">View Appointments</a>

        <h3>Manage Prescriptions</h3>
        <a href="deal_prescriptions.php">View Prescriptions</a>
    </body>
</html>