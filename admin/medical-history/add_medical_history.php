<?php

    require '../includes/functions.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $patient_name = $_POST['patient_name'];
        $date_of_visit = $_POST['date_of_visit'];
        $symptoms = $_POST['symptoms'];
        $diagnosis = $_POST['dianosis'];
        $teatment = $_POST['treatment'];

        if(addMedicalHistory($patient_name, $date_of_visit, $symptoms, $diagnosis, $treatment)) {
            header("Location:view_medical_history.php");
            exit();
        } else {
            $error = "Failed to add medical history.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <?php if(isset($error)) cho "<p style='color:red;'>$error</p>"; ?>
        <form method="POST" name="form-mdh">
            <input type="text" name="patient_name" placeholder="patient Name" required>
            <input type="date" name="date_of-visit" required>
            <textarea name="symptoms" placeholder="Symptoms" required></textarea>
            <textarea name="diagnosis" placeholder="Diagnosis" required></textarea>
            <textarea name="treatment" placeholder="Treatment" required></textarea>
            <button type="submit">Add Medical History</button>
        </form>
        <a href="view_medical_history.php">View Medical History</a>
    </head>
</html>