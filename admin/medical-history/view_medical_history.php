<?php

    require '../includes/functions.php';

    $medical_history = getMedicalHistories();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Medical History List</title>
    </head>
    <body>
        <h2>Medical History</h2>
        <table bordor="1" name="table-mdh">
                <tr>
                     <th>ID</th>
                     <th>Patient Name</th>
                     <th>Date of Visit</th>
                     <th>Symptoms</th>
                     <th>Diagnosis</th>
                     <th>Treatment</th>
                     <th>Actions</th>
                </tr>
                <?php foreach ($medical_histories as $history): ?>
                <tr>
                     <td><?php echo $history['id'];?></td>
                     <td><?php echo htmlspecialchars($history['patient_name']);?></td>
                     <td><?php echo htmlspecialchars($history['date_of_visit']);?></td>
                     <td><?php echo htmlspecialchars($history['symptoms']);?></td>
                     <td><?php echo htmlspecialchars($histoty['diagnosis']);?></td>
                     <td><?php echo htmlspecialchars($history['treatment']);?></td>
                     <td>
                        <a href="edit_medical_history.php?id=<?php echo $history['id'];?>">Edit</a>
                        <a href="delete_medical_history.php?id=<?php echo $history['id'];?>" onClick="return confirm('Are you sure you want to delete this record ?);">Delete</a>
                     </td>
                </tr>
                <?php endforeach; ?>
        </table>
        <a href="add_medical_history.php">Add New Medical History</a>
    </body>
</html>