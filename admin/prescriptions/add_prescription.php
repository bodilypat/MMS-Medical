<?php

    require '../includes/functions.php';

    /* Fetch patients, doctors,  */
    $patients = getPatient();
    $doctors = getDoctor();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $patient_name = $_POST['patient_name'];
        $doctor_name = $_POST['doctor_name'];
        $medication = $_POST['medication'];
        $dosage = $_POST['dosage'];
        $instructions = $_POST['instructions'];

        if(addPrescription($patient_name, $doctor_name, $medication, $dosage, $instructions)){
            header("Location: view_prescriptions.php");
            exit();
        } else {
            $error = "Failed to add prescription. ";
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
            <input type="text" name="patient_name" placeholder="Patient Name" required>
            <input type="text" name="doctor_name" placeholder="Doctor Name" required>
            <input type="text" name="medication" placeholder="Medication" required>
            <input type="text" name="dosage" placeholder="Dosage" required>
            <textarea name="instruction" placeholder="Instructions" required></textarea>
            <button type="submit">Add Prescription</button>
        </form>
        <a href="view_prescriptions.php">View Prescription</a>
    </head>
</html>