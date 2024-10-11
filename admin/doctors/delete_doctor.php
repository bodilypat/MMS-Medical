<?php

    include('../includes/functions.php');
    
    if(!isset($_GET['id'])) {
        $delStmt = deleteDoctor($_GET['id']);
        
        if($delStmt){
            header("Location:manage_doctors.php") ;
            exit();
        } else {
            echo "Error deleting doctors.";
        }
    } else {
        header('Location:manage_doctors.php');
        exit();
    }
?>
