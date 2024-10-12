<?php

    include('../includes/functions.php');

    if(isset($_GET['id'])) {
        header("Location:manage_prescriptions.php");
        exit();
    }

    $id = intval($_GET['id']) // get value 
    
    $prescriptions = getPrescription($id);
    $doctor = getDoctor($id);
    $patient = getPatient($id);

    if($_SERVER['REQUEST_METHOD'] == 'id'){
        $patient_id = $['patient_id'];
        $doctor_id = $['doctor_id'];
        $medication = $_POST['medication'];
        $dosage = $_POST['dosage'];
        $instruction = $_POST['instruction'];

        if(updatePrescription($prescription['id'], $patient_id, $doctor_id, $medication, $dosage, $instructions)){
            header("Location:manage_prescriptions.php");
            exit();
        } else {
            $error = "Failed to update prescription.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit Prescription</title>
    </head>
    <body>
        <?php if(isset($error)) echo "<p style:'color:red;'>$error</p>" ?>
        <form method="post" name="form-prescription">
        <!-- Patient -->
            <div class="form-group">
                <label for="PatientName">Patient Name</label>
                <select name="patient_id" value="<?php echo $patient['patient_name'];?>" required>
                    <?php 
                        /* Fetch data prescription */
                        $prescription =  getPrescriptions();
                        foreach($prescriptions as $prescription: ) ?>
                            <option value="<?php $prescription['patient_id'];?>"><?php echo $prescription['patient_name'];?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Doctor -->
            <div class="form-group">
                <label for="doctor_id">Doctor Name</label>
                <select name="doctor_id" value="<?php $doctor['doctor_name'];?>" required>
                    <?php 
                        $doctors = getDoctors();
                        foreach($doctors as $doctor:) ?>
                            <option value="<?php echo $doctor['patient_id'];?>"><?php echo $prescriptions['doctor_name'];?></option>
                        <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="Medication">Medication</label>
                <input type="text" name="medication" value="<?php echo $prescription['medication'];?>" required>
            </div>
            <div class="form-group">
                <label for="Dosage">Dosage</label>
                <input type="text" name="dosage" value="<?php $prescript['dosage'];?>" required>
            </div>
            <div class="form-group">
                <label for="Instructions">Instructions</label>
                <textarea name="instructions" value="<?php echo $prescription['instruction'];?>" required></textarea>
            </div>
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="datetime-locate" name="start_date" value="<?php $prescription['start_date'];?>" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="datetime-locate" name="end_date" value="<?php $prescription['end_date'];?>" required>
            </div>
            <button type="submit" name="update" value="update prescription" >Update Prescription</button>
        </form>
        <a href="manage_prescriptions.php"></a>
    </body>
</html>