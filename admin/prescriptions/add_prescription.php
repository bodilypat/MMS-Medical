<?php

    include('../includes/functions.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $patient_id = $_POST['patient_id'];
        $doctor_id = $_POST['doctor_id'];
        $medication = $_POST['medication'];
        $dosage = $_POST['dosaage'];
        $instructions = $_POST['instruction'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        if(addPrescriptiion($patient_id, $doctor_id, $medication, $dosage, $instructions, $start_date, $end_date)){
            header("Location : manage_prescriptions.php");
            exit();
        } else {
            $error = "Failed to add prescription.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add Prescription</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="post" name="form-prescription">
            <!-- select patients -->
            <div class="form-group">
                <label for="PatientName">Patient Name</label>
                <select name="patient_id" form="form-control" placeholder="Patient Name" required>
                    <?php 
                        /* fetch data patients */
                        $patients = getPatients();
                        foreach($patients as $patient): ?>
                            <option value="<?php echo $patient['patient_id'];?>"><?php echo $patient['patient_name'];?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- select doctor -->
            <div class="form-group">
                <label for="DoctorName">Doctor Name</label>
                <select name="doctor_id" class="form-control" placeholder="Doctor Name" required>
                    <?php 
                    /* fetch data doctors */
                        $dortors = getDoctors();
                        foreach($doctors as $doctor): ?>
                            <option value="<?php echo $doctor['doctor_id'];?>"><?php echo $doctor['doctor_name'];?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="medication">Medication</label>
                <input type="text" name="medication" class="form-control" placeholder="Medication" required>
            </div>
            <div class="form-group">
                <label for="dosage">Dosage</label>
                <input type="text" name="dosage" class="form-control" placeholder = "Dosage" required>
            </div>
            <div class="form-group">
                <label for="Instruction">Instruction</label>
                <textarea name="instruction" placeholder="Instruction" required></textarea>
            </div>
            <div class="form-group">
                <label for="StartDate">Start Date</label>
                <input type="datetime-locate" name="start_date" class="form-control" placeholder="Start Date" required>
            </div>
            <div class="form-group">
                <label for="EndDate">End Date</label>
                <input type="datetime-locate" name="end_date" class="form-control" placeholder="End Date" required>
            </div>
            <button type="submit" name="add" value="add Prescription" >Add Prescription</button>
        </form>
        <a href="manage_prescriptions.php">View Prescription</a>
    </head>
</html>