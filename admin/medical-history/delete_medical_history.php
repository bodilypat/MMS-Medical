<?php

    require '../includes/functions.php';

    if(isset($_GET['id'])) {
        deleteMedicalHistory($_GET['id']);
        header("Location:view_medical_history.php");
        exit();
    } else {
        header('Location:view_medical_history.php');
        exit();
    }
?>
