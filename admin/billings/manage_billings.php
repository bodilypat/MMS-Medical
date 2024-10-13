<?php

    require '../includes/functions.php';

    $billings = getBillings();
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
                 <th>Treatment</th>
                 <th>Amounts</th>
                 <th>Billing Date</th>
                 <th>status</th>
                 <th>Actions</th>
            </tr>
            <?php foreach($billings as $billing): ?>
            <tr>
                 <td><?php echo $billing['id'];?></td>
                 <td><?php echo $billing['patient_name'];?>
                 <td><?php echo $billing['treatment'];?></td>
                 <td><?php echo $billing['amount'];?></td>
                 <td><?php echo $billing['billing_date'];?></td>
                 <td><?php echo $billing['amount'];?></td>
                 <td><?php echo $billinh['status'];?></td>
                 <td>
                    <a href="edit_billing.php?id=<?php echo $billing['id']; ?>">Edit</a>
                    <a href="delete_billing.php?id=<?php echo $billing['id']; ?>" 
                       onClick=" Confirm('Are you sure you want to delete this billing?');">Delete</a>
                 </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <a href="add_prescription.php">Add New Prescription</a>
    </body>
</html>
