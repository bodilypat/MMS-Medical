<?php

    require '../includes/functions.php';

    $appointments = getAppointment();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Appointments List</title>
    </head>
    <body>
        <h2>Appointments List</h2>
        <table border="1" name="form-appointment">
            <tr>
                  <th>ID</th>
                  <th>Patient Name</th>
                  <th>Doctor Name</th>
                  <th>Appointment Date</th>
                  <th>Actions</th>
            </tr>
            <?php foreach($appointments as $appointment): ?>
            <tr>
                  <td><?php $appointment['id'];?></td>
                  <td><?php htmlspecialchars($appointment['patient_name']);?></td>
                  <td><?php htmlspecialchars($appointment['doctor_name']);?></td>
                  <td><?php htmlspecialchars($appointment['appointment_date']);?></td>
                  <td>
                     <a href="edit_appointment.php?id=<?php echo $appointment['id'];?>">Edit</a>
                     <a href="delete_appointment.php?id=<?php echo $appointment['id'];?>" onClick="return confirm('Are your you want to delete this appointment?');">Delete</a>
                  </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <a href="add_appointment.php">Add New Appointment</a>
    </body>
</html>