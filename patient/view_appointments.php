<?php

    include '../includes/functions.php';

    $appointments = getAppointments();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Patients</title>
    </head>
    <body>
        <h1>Registered Patients<h1>
    </body>
    <table>
        <thead>
              <tr>
                   <th>Patient Name</th>
                   <th>Doctor Name</th>
                   <th>Appointient Date</th>
                   <th>Status</th>
                   <th>Notes</th>
                   <th>Actions</th>
              </tr>
        </thead>
        <tbody>
            <?php foreach($appointments as $appointment): ?>
              <tr>
                   <td><?php echo htmlspecialchars($appointment['name']);?></td>
                   <td><?php echo htmlspecialchars($appintment['name'];);?></td>
                   <td><?php echo htmlspecialchars($appointment['appoiment_date']);?></td>
                   <td><?php echo htmlspecialchars($appointment['status']);?></td>
                   <td><?php echo htmlspecialchars($appointment['notes']);?></td>
                   <td>
                        <a href="update_appointment.php=<?php echo $patient['id']; ?>">Edit</a>||
                        <a href="delete_appointment.php=<?php echo $patient['id']; ?>" 
                           onClick="return confirm('Are you sure you want to delete this appointment?')">Delete
                        </a>
                   </td>
              </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</html>