<?php

    include('../includes/functions.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $patient_id = $_POST['patient_id'];
        $medical_record_id = $_POST['medical_record_id'];
        $amount = (float)($_POST['amount']);
        $billing_date = $_POST['billing_date'];
        $status = $_POST['status'];

        if(updateBilling($billing['id'], $patient_id, $medical_record_id, $amount, $billing_date, $status)) {
            header("Location:manage_billings.php");
            exit();
        } else {
            $error = "Failed to update billing.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit Billing</title>
    </head>
    <body>
        <?php if(isset($error)) echo "<p style='<p style:'color:red;'>$error</p>" ?>
        <form method="post" name="form-billing">
            <?php $billing = getBillingById(); ?>
            <div class="form-group">
                <input type="hidden" name="id" value="<?php $billing['id'] ?>">
            </div>
            <div class="form-group">
                <label for="Patient">Patient</label>
                <select name="patient_id" value="<?php echo $billing['patient_id']; ?>" required>
                    <?php $billings = getBillings();
                        foreach($billings as $billing) : ?>
                        <option value="<?php echo $billing['patient_id'];?>"><?php echo billing['name'];?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="Treatment">Treatment</label>
                <select name="medical_record_id" value="<?php $billing['Medical_record_id']; ?>" required>
                    <?php
                        $billings = getBillings();
                        foreach ($billing as $billing): ?>
                        <option value="<?php $billing['billing_id'];?>"><?php echo $billing['treatment']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="Amount">Amount</label>
                <input type="number" name="amount" value="<? php echo $billing['amount'];?>" required>
            </div>
            <div class="form-group">
                <label for="billingDate">Billing Date</label>
                <input type="datetime-locate" name="billing_date" value="<?php echo $billing['billing_date'];?>" requried>
            </div>
            <div class="form-group">
                <label for="Status">Status</label>
                <select name="status"  class="form-control" require>
                      <option value="Paid" <?php $billing['status'] == 'Paid' ? 'selected' : ''?>>Paid</option>
                      <option value="Padding" <?php $billings['status'] == 'Padding' ? 'selected' : ''?>>Padding</option>
                      <option value="Cancelled" <?php $billings['status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>
        </div>
    </body>
</html>
