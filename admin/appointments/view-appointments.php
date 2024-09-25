<?php

    include('../congig/dbconnect.php');

    $patient_id = $_GET['editapp']?? null;

    $appStmt = mysqli_query($deal,"SELECT a.*, p.name as patient_name, d.name as doctor_name
                                        FROM appointments a JOIN patients p ON a.patient_id = p.id 
                                                            JOIN doctors d ON a.doctor_id = d.id  
                                        WHERE a.patient_id = '$patient_id' ");
    $appointments = $appStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Appointment for Patient ID <?php echo $patient_id; ?></title>
    </head>
<body>
    <h1>Appointments</h1>
    <table>
        <thead>
                <tr>
                     <th>ID</th>
                     <th>Patient Name</th>
                     <th>Doctor Name</th>
                     <th>Appointment Date</th>
                     <th>Status</th>
                     <th>Notes</th>
                     <th>Actions</th>
                </tr>
                <?php foreach($appointment as $appointment): ?>
                <tr>
                     <td><?php echo $appointment['id'];?></td>
                     <td><?php echo $appointment['patient_name'];?></td>
                     <td><?php echo $appointment['doctor_name'];?></td>
                     <td><?php echo $appointment['appointment_date'];?></td>
                     <td><?php echo $appointment['status'];?></td>
                     <td><?php echo $appointment['notes'];?></td>
                     <td>
                         <a href="edit-appointment.php?editapp=<?php echo $appointment['id'];?>">Edit</a>
                         <a href="delete-appointment.php?delapp=<?php echo $appointment['id'];?>">Delete</a>
                         <a href="view-appointment.php?vapp=<?php echo $appointment['id'];?>">view</a>
                     </td>
                </tr>
                <?php endforeach; ?>
        </thead>
    </table>
    <a href="add-appointment.php?patient_id=<?php $patient_id; ?>">Add Appointment</a>
    <br/>
    <a href="manage-patient.php">Back to Patients</a>
</body>
</html>
