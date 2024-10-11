<?php

    include('../includes/functions.php');

    if(!isset($_GET['id'])){
        $delePat = deletePatient($_GET['id']);
        
        if($delStmt) {
            header('Location:manage_patients.php');
            exit(); 
        } else {
                echo"Error deleting patient.";
            }
        } else { 
            header("Location:manage_patients.php");
            exit();
    }
?>