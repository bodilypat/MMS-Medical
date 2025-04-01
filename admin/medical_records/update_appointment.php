<?php

    include('../includes/functions.php');

    if(!isset($_GET['id'])){
        header("Location:manage_appointments.php");
        exit();
    }

    $appointment = getAppointment($_GET['id']);

    if($_SERVER['REQUEST_METHOD'] =='POST'){
        $patient_id = $_POST['patient_id'];
        $doctor_id = $_POST['doctor_id'];
        $appointment_date = $_POST['appointment_date'];
        $notes = $_POST['notes'];

        if(updateAppointment($appointment['id'], $patient_id, $doctor_id, $appointment_date, $note)){
            header("Location:manage_appointments.php");
            exit();
        } else {
            $error = "Failed to update appointment";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit Appointment</title>
    </head>
    <body>
        <h2>Edit Appointment</title>
        <?php if(isset($error)) echo "<p style='color:red;'>$error" ?>
        <form method="post" name="form-appointment">
            <input type="hidden" name="id" value="<?php $appointment['id'] ?>">

            <!-- Fetch  patient name -->
            <div class="form-group">
                <label for="PatientName">Patient Name</label>
                <select name="patient_id" class="form-control"  value="<?php $appointments['patient_id']; ?>" required>
                    <?php 
                        $patients = getPatients();
                        foreach ($patients as $patient) : ?>
                            <option value="<?php echo $patient['id'];?>"><?php echo htmlspecialchars($patients['name']);?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Fetch doctor name -->
            <div class="form-group">
                <select name="doctor_id" value="<?php $appointment['doctor_id']; ?>" required>
                    <?php
                        $doctors = getDoctors();
                        foreach ($doctors as $doctor): ?>
                            <option value="<?php echo $doctor['id'];?>"><?php echo htmlspecialchars($doctor['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="AppointmentDate">Appointment Date</label>
                <input type="datetime-local" name="appointment_date" value="<?php echo date('Y-md-d\TH:i', strtotime($appointment['appoint_date'])); ?>" required>
            </div>
            <div class="form-group">
                <label for="Status">Status</label>
                <select name="status"  class="form-control" require>
                      <option value="Scheduled" <?php $appointment['status'] == 'Scheduled' ? 'selected' : ''?>>Scheduled</option>
                      <option value="Completed" <?php $appointment['status'] == 'Completed' ? 'selected' : ''?>>Completed</option>
                      <option value="Cancelled" <?php $appointment['status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>
            <div class="form-group">
                <label for="Note">Notes</label>
                <textarea name="notes"><?php $appointment['notes'] ?></textarea>
            </div>
             <button type="submit" name="update" value="update Appointment" >Update Appointment</button>
        </form>
        <a href="manage_appointments.php">Cancel</a>
    </body>
</html>
