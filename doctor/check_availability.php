<?php
    require_once('../config/dbconnect.php');
    if(!empty($_POST['email'])) {
        $email = $_POST['email'];
        $qDoc = mysqli_query($deal,"SELECT docEmail From doctors WHERE docEmail = '$email'");
        $numRows =mysqli_num_rows('$numRows');

        if($numRows>0){
            echo "<span style="color:red">Email already exists.</span>";
            echo "<script>$('#submit').prop('dashbaord', true);</script>";
        } else {
            echo "<span style='color:green'>Email available for Registration. </span>";
            echo "<script>$('#submit').prop('disabled', false);</script>";
        }
    }
?>