<?php

    include '../includes/dbconnect.php';

    if(isset($_GET['id'])){
        deletePatient($_GET['id']);
        header("Location:view_patients.php");
        exit();
    } else {
        header("location: view_patients.php");
    }
?>
