<?php

    require '../includes/functions.php';

    if(isset($_GET['id'])){

        deletePrescription($_GET['id']);
        header("Location:view_prescriptions.php");
        exit();
    } else {
        header("Location: view_prescriptions.php");
        exit();
    }
?>