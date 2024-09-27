<?php 
    require '../include/functions.php';

    if(isset($_GET['id'])) {
        deleteDoctor($_GET['id']);
        header("Location:view_doctors.php");
        exit();
    } else {
        header('Location:view_doctors.php');
        exit();
    }
?>