<?php

    include ('../includes/functions.php');

    if(isset($_GET['id'])){
        $delStmt = deleteAppointment($_GET['id']);

        if($delStmt){            
            header("Location:manage_appointments.php");
            exit();
        } else {
            echo "Error deleting appointment."
        }
    } else {
        header("Location:manage_appointments.php");
        exit();
    }
?>
