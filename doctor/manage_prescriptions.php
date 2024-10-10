<?php

    include ('../includes/functions.php');

      if(!isset($_SESSION['user_id'])) {
        header('Location:login.php');
        exit();
      } else {
        $prescription = getPrescriptions($patient_id);
      }
  
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UFT-8">
        <title>Prescriptions List</title>
    </head>
    <body>
        <h2>Prescriptions List</h2>
        <table border="1" name="prescription-table">
            <tr>
                 <th>ID</th>
                 <th>Patient Name</th>
                 <th>Doctor Name</th>
                 <th>Medications</th>
                 <th>Dosage</th>
                 <th>Instructions</th>
                 <th>Actions</th>
            </tr>
            <?php foreach($prescription as $prescription): ?>
            <tr>
                 <td><?php echo $prescription['id'];?></td>
                 <td><?php echo $prescription['patient_name'];?></td>
                 <td><?php echo $prescription['doctor_name'];?></td>
                 <td><?php echo $prescription['medication'];?></td>
                 <td><?php echo $prescription['dosage'];?></td>
                 <td><?php echo $prescription['instruction'];?></td>
                 <td>
                    <a href="edit_prescription.php?id=<?php echo $prescription['id']; ?>">Edit</a>
                    <a href="delete_prescription.php?id=<?php echo $prescription['id']; ?>" onClick=" Confirm('Are you sure you want to delete this prescription?');">Delete</a>
                    <a href="view_prescriptions.php?id=<?php echo $prescription['id']; ?>">View</a>
                 </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <a href="add_prescription.php">Add New Prescription</a>
    </body>
</html>
