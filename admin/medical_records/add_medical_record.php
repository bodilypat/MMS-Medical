<?php

    include('../includes/functions.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $patient_id = $_POST['patient_id'];
        $doctor_id = $_POST['doctor_id'];
        $record_date = $_POST['record_date'];
        $diagnosis = $_POST['diagnosis'];
        $treatment = $_POST['treatment'];
        $notes = $_POST['notes'];
        

        if(addMedicationHistory($patient_id, $doctor_id, $record_date, $dianosis, $treatment, $notes )) {
            header("Location:manage_medical_records.php");
            exit();
        } else {
            $error = "Failed to add medical records.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add Medical History</title>
    </head>
    <body>
        <h2>Add Medical History</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="post" name="form-medical-history">
            <!-- Medical Patient_id -->
            <div class="form-group">
                <label for="PatientName">Patient Name</label>
                <select type="text" name="patient_id" class="form-control" required>
                    <?php 
                        /* Fetch Patient name */
                        $patients = getPatients();
                        foreach($patients as $patient): ?>
                        <option value="<?php echo $patient['id'];?>"><?php echo $patient['patient_name'];?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Doctor Doctor_id -->
            <div class="form-group">
                <label for="DoctorName">Doctor Name</label>
                <select type="text" name="doctor_id" class="form-control" required>
                    <?php 
                        /* Fetch Doctor name */
                        $doctors = getDoctors();
                        foreach($doctors as $doctor): ?>
                        <option value="<?php echo $doctor['id'];?>"><?php echo $doctor['doctor_name'];?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="record_date">Record Date</label>
                <input type="date" name="record_date" class="form-control" placeholder="Record Date" required>
            </div>
            
            <div class="form-group">
                <label for="Diagnosis">Diagnosis</label>
                <textarea name="diagnosis" class="form-control" placehodler="Diagnosis" required></textarea>
            </div>

            <div class="form-group">
                <label for="Treatment">Treatment</label>
                <textarea name="treatment" class="form-control" placeholder="treatment" required></textarea>
            </div>
            
        </form>
        <a href="manage_medical_records.php">View Medical History</a>
    </body>
</html>
