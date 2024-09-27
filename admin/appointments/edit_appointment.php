<?php

    require '../includes/functions.php';

    if(!isset($_GET['id'])){
        header("Location:view_appointments.php");
        exit();
    }

    $appointment = getAppointment($_GET['id']);

    if($_SERVER['REQUEST_METHOD'] =='POST'){
    
        $patient_name = $_POST['patient_name'];
        $doctor_name = $_POST['doctor_name'];
        $appointment_date = $_POST['appointment_date'];

        if(updateAppointment($appointment['id'], $patient_name, $doctor_name, $appointment_date)) {
            header("Location: view_appointments.php");
            exit();
        } else {
            $error ="Failed to update appointment.";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Edit Appointment</title>
    </head>
    <body>
        <h2>Edit Appointment</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>$error"; ?>
        <form method="POST" name="form-appointment">
            <input type="text" name="patient_name" value="<?php echo htmlspecialchars($appointment['patient_name']); ?>" required>
            <input type="text" name="doctor_name" value="<?php echo htmlspecialchars($appointment['doctor_name']); ?>" required>
            <input type="datetime-local" name="appointment_date" value="<?php echo date('Y-m-d\TH:i', strtotime($appointment['appointment_date'])); ?>" required>
            <button type="submit">Update Appointment</button>
        </form>
        <a href="view_appointments.php">Cancel</a>
    </body>
</html>