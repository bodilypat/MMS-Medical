<?php 

    require '../includes/functions.php';

    if(isset($_GET['id'])){
        deleteAppointment($_GET['id']);
        header("Location:view_appointments.php");
        exit();
    } else {
        header("Location:view_appointments.php");
        exit();
    }
?>
