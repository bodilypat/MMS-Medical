<?php

    include '../includes/dbconnect.php';

    if(isset($_GET['id'])){
        deleteAppointment($_GET['id']);
        header("Location:view_appointments.php");
        exit();
    } else {
        header("location: view_appointments.php");
    }
?>
