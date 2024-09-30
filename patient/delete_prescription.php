<?php

    include '../includes/dbconnect.php';

    if(isset($_GET['id'])){
        deletePrescription($_GET['id']);
        header("Location:view_prescriptions.php");
        exit();
    } else {
        header("location: view_prescriptions.php");
    }
?>
