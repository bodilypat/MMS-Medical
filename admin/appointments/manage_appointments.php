<?php

    include ('../include/functions.php');
    $appointments = getAppointments();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Appointments List</title>
    </head>
    <body>
        <h2>Appointment List</h2>
        <table border="1" name="form-appointment">
            <thead></thead>
            <tr>
                 <th>ID</th>
                 <th>Patient Name</th>
                 <th>Doctor Name</th>
                 <th>Appointment Date</th>
                 <th>Status</th>
                 <th>Notes</th>
                 <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($appointments as $appointment): ?>
                <tr>
                     <td><?php echo $appointment['id'];?></td>
                     <td><?php echo htmlspecialchars($appointment['patient_name']);?></td>
                     <td><?php echo htmlspecialchars($appointment['doctor_name']);?></td>
                     <td><?php echo htmlspecialchars($appointment['appointment_date']);?></td>
                     <td><?php echo htmlspecialchars($appointment['status']);?></td>
                     <td><?php echo htmlspecialchars($appointment['notes']); ?></td>
                     <td>
                        <a href="edit_appointment.php?id=<?php $appointment['id'];?>">Edit</a> ||
                        <a href="delete_appointment.php?id=<?php $appointment['id'];?>" 
                           onclick="return confirm('Are you sure you want to delete this appointment?');"> Delete</a>
                     </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_appointment.php">Add new Appointmentment</a>
    </body>
</html>