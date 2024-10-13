<?php

    require '../includes/functions.php';

    if(isset($_GET['id'])){

        deletePrescription($_GET['id']);
        header("Location:manage_billings.php");
        exit();
    } else {
        header("Location: manage_billings.php");
        exit();
    }
?>