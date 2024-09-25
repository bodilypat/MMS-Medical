<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('Location:login.php');
        exit();
    }
    include('../config/dbconnect.php');
    $delid = $_GET['id'];
    $dPat = mysqli_query($deal,"DELETE FROM patients WHERE id='$delid' ");
    header('Location:manage-patients.php');
?>