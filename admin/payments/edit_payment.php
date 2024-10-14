<?php

    include('../includes/functions.php');

    if(!isset($_GET['id'])) {
        header("Loocation:manage_appointments.php");
        exit();
    }

    $payment = getPaymentById($_GET['id']);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $billing_id = $_POST['billing'];
        $payment_date = $_POST['payment_date'];
        $amount = $_POST['amount'];
        $method = $_POST['method'];

        if(updatePayment($_GET['id'], $payment_date, $amount, $method)) {
            header("Location:manage_payments.php");
            exit();
        } else {
            $error = "Failed to update payment";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit Payment</title>
    </head>
    <body>
        <<h2>Edit Payment</h2>
        <?php if(isset($error)) echo "<p style='color:red;'> $error" ?>
        <form method="post" name="form-payment">
            <div class="form-group">
                <input type="hidden" name="id" value="<?php $payment['id'] ?>">
            </div>
            <div class="form-group">
                <label for="PatientName">Patient Name</label>
                <select name="billing_id" value="<?php echo $payment['billing_id'] ?>" required>
                    <?php
                        $billings = getBillings();
                        foreach($billings as $billing): ?>
                            <option value="<?php echo $billing['billing_id'] ?>"><?php echo $billing['patient_id']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-grooup">
                <label for="payment_date">Payment Date</label>
                <input type="datetime-locate" name="payment_date" value="<?php echo $payment['payment_date']; ?>" requried>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" value="<?php echo $payment['amount']; ?>" required>
            </div>
            <div class="form-group">
                <label for="method">Method</label>
                <select name="status" class="form-control" required>
                    <option value="Cash" <?php $payment['status'] == 'cash' ? 'selected' : '' ?>>Cash</option>
                    <option value="Credit_card" <?php $payment['status'] == 'credit_card' : '' ?>>Credit_card</option>
                    <option value="Insurance" <?php $payment['status'] == 'Insurance' : '' ?>>Insurance</option>
                </select>
            </div>
            <button type="submit" name="edit" value="update payment">Update Payment</button>
        </form>
        <a href="manage_payments.php">View payment</a>
    </body>
</html>