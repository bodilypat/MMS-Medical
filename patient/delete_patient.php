<?php

    include '../includes/dbconnect.php';

    if(isset($_GET['id'])){
        $patient_id = $_GET['id'];
        $stmt = $pdo->prepare("DELETE FROM patients WHERE id= ? ");

        if($stmt->execute([$patient_id])){
            echo "Patient deleted successfull!";
            header("Location:view_patients.php");
            exit();
        } else {
            echo "Error: Could not delete patient.";
        }
    } else {
        die("Patient ID not provided.");
    }
?>
