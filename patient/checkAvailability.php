<?php
    require_once('../define/config.php');
    if(!empty($_POST['EMAIL'])){
        $email=$_POST['email'];
        $qUser = mysqli_query($deal,"SELECT email from users WHERE email='$email' ");
        $cRows = mysqli_num_rows(qUser);
        if($cRows > 0)
        {
            echo "<script style='color:red'>Email already exists.</script>";
            echo "<script>$('#submit').prop('disabled', true);</script>";
        }else 
        {
            echo "<span style='color:green'>Email available for Register.</span>";
            echo "<script>$(#submit).prop('disabled',false);</script>";
        }
    }
?>