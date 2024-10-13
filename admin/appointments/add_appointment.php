<?php

    include('../includes/functions.php');

    if ($_SERVER['REQUEST_METHOD'] =='POST') {
        $patient_id = $_POST['patient_id'];
        $doctor_id = $_POST['doctor_id'];
        $appointment_date = $_POST['appointment_date'];
        $notes = $_POST['notes'];

        if(addAppointment($patient_id, $doctor_id, $appointment_date, $staus, $notes)) {
            header("Location:manage_appointments.php");
            exit();
        } else {
            $error = "Failed to add appointment.";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add Appointment</title>
    </head>
    <body>
        <h2>Add Appointment</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="post" name="form-appointment">

            <!-- select patient name-->
            <div class="form-group">
                <label for="PatientName">Patient Name</label>
                <select name="patient_id" class="form-control" required>
                    <?php foreach($patients as $patient): ?>
                         <option value="<?php echo $patient['id'];?>"><?php echo $patient['name'];?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Fetch doctor name-->
            <div class="form-group">
                <label for="DoctorName">Doctor Name</label>
                <select name="doctor_id" class="form-control" required>
                    <?php foreach($doctors as $doctor): ?>
                        <option value="<?php echo $doctor['id'];?>"><?php echo $doctor['name'];?></option>
                    <?php endforeach; ?>
                </section>
            </div>

            <!-- appointment date -->
            <div class="form-group">
                <label for="AppointmentDate">Appointment date</label>
                <input type="datetime-local" name="appointment_date" required>
            </div>

            <!-- notes -->
            <div class="form-group">
                <label for="Notes">Notes</label>
                <textarea name="notes" class="form-control"></textarea>
            </div>
            <button type="submit" name="add" value="add appointmnet">Add Appointments</button>
        </form>
        <a href="manage_appointments.php">View Appointments</a>
    </body>
</html>