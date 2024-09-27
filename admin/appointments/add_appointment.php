<?php
    require '../includes/functions.php';

    if($_SERVER['REQUEST_METHOD'] =='POST') {

        $patient_name = $_POST['patient_name'];
        $doctor_name = $_POST['doctor_name'];
        $appointment_date = $_POST['appointment_date'];

        if(addAppointment($patient_name, $doctor_name, $appointment_date)){
            header("Location: view_appointments.php");
            exit();
        } else {
            $error = "Failed to add appointment.";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add Appointment</title>
    </head>
    <body>
        <h2>Add Appointment</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST" name="form-appointment">
            <input type="texy" name="patient_name" placeholder="Patient name" required>
            <input type="text" name="doctor_name" placeholder="Doctor name" required>
            <input type="detetime-local" name="appoint_date" required>
            <button type="submit">Add Appointments</button>
        </form>
        <a href="view_appointments.php">View Appointments</a>
    </body>
</html>