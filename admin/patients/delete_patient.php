<?php
    require '../includes/functions.php';

    if($isset($_GET['id'])){
        deletePatient($_GET['id']);
        header("Location:view_patients.php");
        exit();
    } else {
        header("Location:view_patients.php");
        exit();
    }
?>
