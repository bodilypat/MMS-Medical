<?php

    include('../includes/functions.php');

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
            <thead>
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
            </thead>
            <tbody>
                <?php foreach($patients as $patient): ?>
                <tr>
                     <td><?php echo htmlspecialchars($patient['id']);?></td>
                     <td><?php echo htmlspecialchars($patient['name']);?></td>
                     <td><?php echo htmlspecialchars($patient['email']);?></td>
                     <td><?php echo htmlspecialchars($patient['date_of_birth']);?></td>
                     <td><?php echo htmlspecialchars($patient['gender']);?></td>
                     <td><?php echo htmlspecialchars($patient['phone']);?></td>
                     <td><?php echo htmlspecialchars($patient['address']);?></td>
                     <td>
                          <a href="edit_patient.php?id=<?php echo $patient['id'];?>">Edit</a>
                          <a href="delete_patients.php?id=<?php echo $patient['id'];?>"
                             onClick="return confirm('Are you sure you want to delete this patient');">Delete</a>
                     </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_patient.php">Add New Patient</a>
    </body>
</html>