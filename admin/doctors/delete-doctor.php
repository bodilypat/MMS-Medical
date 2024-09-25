<?php
    session_start();
    if(!isset($_SESSION['user_id'])) {
        header('Location:login.php');
        exit();
    }
    include('../config/dbconnect.php');

    $did = $_GET['id'];
    $dDoc = mysqli_query($deal,"DELETE FROM doctors WHERE id='$did' ");
    header('Location:manage-doctors.php');
?>