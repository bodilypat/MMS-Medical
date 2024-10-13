<?php
    session_start();
    include('../includes/functions.php');

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $patient_id = (int)$_POST['patient_id'];
        $medical_recors_id = (int)$_POST['medical_records_id'];
        $amount = (float)($_POST['amount']);
        $billing_date = $_POST['billing_date'];
        $status = $_POST['status'];

        if(addBilling($patient_id, $medical_records_id, $amount, $billing_date, $status)){
            header("Location:manage_billings.php");
            exit();
        } else {
            $error = "Failed to add billing";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add Billings</title>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>";?>
    </head>
    <body>
        <div class="container">
            <h2>Add Billing New Record</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="patent_id">Name:</label>
                    <select name="patient_id" id="patient_id" required>
                        <?php 
                            $patients = getPatients();
                            foreach($patients as $patient): ?>
                                <option value="<?php echo $patient['patient_id'];?>"><?php echo $patient['patient_name'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="appointment_id">Appointment :</label>
                    <select name="doctor_id" class="form-control"  required>
                        <?php
                            $medical_records = getMedical_records();
                            foreach($medical_records as $md_record): ?>
                                <option value="<?php echo $md_record['medical_records_id'];?>"><?php echo $md_record['medical_record_id'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="amount">Amount :</label>
                    <input type="number" step="0.01" name="amount" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="status">Status :</label>
                    <select name="status" id="status">
                        <option value="Paid" selected>Paid</option>
                        <option value="Unpaid">Unpaid</option>
                        <option value="Cancelled">Cancelled"></option>
                    </select>            
                </div>
                <button type="submit" name="add" value="Add billing"></button>
            </form>
            <a href="manage_medical_records.php">View Prescription</a>
        </div>
    </body>
</html>
