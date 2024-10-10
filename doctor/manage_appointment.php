<?php

    session_start();
    include ('../includes/dbconnect.php');
    include ('../includes/functions.php');

    if(!isset($_SESSION['doctor_id'])) {
        header('Location: login.php');
        exit();
    }

    $doctor_id = $_SESSION['doctor_id'];
    /* Fetch appointments */
    $appointments = searchAppointment($doctor_id);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Manage Appointments</title>
    </head>
    <body>
        <h1>Management Appointment</h1>
        <h2>Current Appointments</h2>
        <table>
            <thead>
                 <tr>
                      <th>Appointment ID</th>
                      <th>Patient Name</th>
                      <th>Appoint Nanme</th>
                      <th>Appointment date</th>
                      <th>Status</th>
                 </tr>
            </thead>
            <tbody>
                <?php foreach($appointments as $appointment): ?>
                 <tr>
                       <td><?php echo htmlspecialchars($appointment['id']); ?></td>
                       <td><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
                       <td><?php echo htmlspecialchars($appointment['doctor_name']); ?></td>
                       <td><?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($appointment['appointment_date']))); ?></td>
                       <td><?php echo htmlspecialchars(ucfirst($appointment['status'])); ?></td>
                 </tr>
                 <?php endforeach; ?>
            </tbody>
        </table>
    </body>
</html>