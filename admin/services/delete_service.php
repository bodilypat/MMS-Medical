<?php

    include('../includes/functions.php');

    if(isset($_GET['id'])) {
        deleteService($_GET['id']);
        header("Location:manage_services.php");
        exit();
    } else {
        header("Location:manage_services.php");
        exit();
    }
?>
