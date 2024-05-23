<?php
    requrie_once("define/config.php");
    if(!empty($_POST['emailid'])){
        $email=$_POST['emailid'];
        $qDoc=mysqli_query($deal,"SELECT doctorEmail FROM doctors WHERE doctorEmail='$email' ");
        $count=mysqli_num_rows($qDoc);
        if($count > 0)
        {
            echo "<script style='color:red'>Email already exists .</script>";
            echo "<script>$('#submit').prop('disabled', true);</script>";
        } else {
            echo "<script style='color:green'>Email available for Registration .</span>";
            echo "<script>$('#submit').prop('disabled', false);</script>";
        }
    }
?>
