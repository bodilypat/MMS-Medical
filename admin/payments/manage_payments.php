<?php

    include('../include/functions.php');

    $payments = getPayments();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF=8">
        <title>Payment List</title>
    </head>
    <body>
        <h2>Payment List</h2>
        <table border="1" name="payment-table">
            <tr>
                 <th>ID</th>
                 <th>Patient Name</th>
                 <th>Payment Date</th>
                 <th>Amount</th>
                 <th>Method</th>
                 <th>Actions</th>
            </tr>
            <?php foreach($payments as $payment): ?>
            <tbody>
                <tr>
                     <td><?php echo $payment['id'];?></td>
                     <td><?php echo htmlspecialchars($payment['patient_name']);?></td>
                     <td><?php echo htmlspecialchars($payment['payment_date']);?></td>
                     <td><?php echo htmlspecialchars($payment['amount']);?></td>
                     <td><?php echo htmlspecialchars($payment['method']);?></td>
                     <td>
                        <a href="edit_payment.php?id=<?php echo $payment['id'];?>">Edit</a>||
                        <a href="delete_payment.php?id=<?php echo $payment['id'];?>"
                           onClick="Confirm('Are you sure you want to delete this payment?');"> Delete</a>
                     </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <a href="view_payment.php">View Payment</a>
    </body>
</html>