<?php

    include('../includes/functions.php');

    if($_SERVER['REQEUST_METHOD'] == 'POST'){
        $billing_id = $_POST['billing_id'];
        $payment_date = $_POST['payment_date'];
        $amount = $_POST['amount'];

        if(addPayment($billing_id, $payment_date, $amount)){
            header('Location:manage_payments.php');
            exit();
        } else {
            $error = "Failed to add payment";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UFT-8">
        <title>Add Payments</title>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </head>
    <body>
        <div class="container">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="billing_id">Patient Name:</label>
                    <select name="billing_id" class="form-control"  required>
                        <?php
                            $billings = getBillings();
                            foreach($billings as $billing) : ?>
                                <option value="<?php echo $billing['id'];?>"><?php echo $billing['patient_name'];?>></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for ="PaymentDate">Payment Date</label>
                    <input type="datetime-locate" name="payment_day" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount : </label>
                    <input type="number" name="amount" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="method">Mmethod</label>
                    <select name="method" id="method">
                        <option value="Cash">Cash</option>
                        <option value="Credit_card">Credit card</option>
                        <option value="insurance">Insurance</option>
                    </select>
                </div>
                <button type="email" name="add" value="add billing">Add payment</button>
            </form>
            <a href="manage_payments.php">View Payments</a>
        </div>
    </body>
</html>
