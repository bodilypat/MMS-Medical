<?php
    require '../includes/functions.php';

    $patients = getPatients();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Patients List</title>
    </head>
    <body>
        <h2>Patients List</h2>
        <table border="1">
            <tr>
                 <th>ID</th>
                 <th>Name</th>
                 <th>Email</th>
                 <th>Date of Birth</th>
                 <th>Gender</th>
                 <th>Phone</th>
                 <th>Address</th>
                 <th>Actions</th>
            </tr>
            <?php foreach($patients as $patient): ?>
            <tr>
                 <td><?php echo $patient['id'];?></td>
                 <td><?php echo htmlspecialchars($patient['name']);?></td>
                 <td><?php echo htmlspecialchars($patient['email']);?></td>
                 <td><?php echo htmlspecialchars($pathent['date_of_birth']);?></td>
                 <td><?php echo htmlspecialchars($patient['gender']);?></td>
                 <td><?php echo htmlspecialchars($patient['phone']);?></td>
                 <td><?php echo htmlspecialchars($patient['address']);?></td>
                 <td>
                    <a href="edit_patients.php?id=<?php echo $patient['id'];?>">Edit</a>
                    <a href="delete_patient.php?id=<?php echo $patient['id'];?>" onclick="return confirm('Are you sure you want to delete this patients?');">Delete</a>
                 </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <a href="add_patient.php">Add New Patient</a>
    </body>
</html>