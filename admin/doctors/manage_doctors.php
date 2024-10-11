<?php

    include('../includes/functions.php');
    $doctors = getDoctors();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Doctors List</title>
    </head>
    <body>
        <h2>Doctors List</h2>
        <table border="1">
            <thead>
                  <tr>
                       <th>ID</th>
                       <th>Name</th>
                       <th>Specialization</th>
                       <th>Phone</th>
                       <th>Action</th>
                  </tr>
            </thead>
            <tbody>
                <?php foreach($doctors as $doctor): ?>
                <tr>
                     <td><?php echo htmlspecialchars($doctor['id']);?></td>
                     <td><?php echo htmlspecialchars($doctor['name']);?></td>
                     <td><?php echo htmlspecialchars($doctor['specialty']);?></td>
                     <td><?php echo htmlspecialchars($doctor['phne']);?></td>
                     <td>
                        <a href="edit_doctor.php?id=<?php echo $doctor['id'];?>">Edit</a>
                        <a href="delete_doctor.php?id=<?php echo $doctor['id'];?>" 
                           onClick="return confirm('Are you sure you want to delete this doctor?');">Delete</a>
                     </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_doctor.php">Add New Doctor</a>
    </body>
</html>