<?php
    require_once('../define/config.php');
    if(!empty($_POST['email'])){
        $userEmail = $_POST['email'];
        $qUser = mysqli_query($deal,"SELECT email FROM users WHERE email='$email' ");
        $numRow = mysqli_num_rows(qUser);
        if($numRows > 0)
        {
            echo "<script style='colr:green'>Email availale for registration.</script>";
            echo "<script>$(#submit).prop('disabled', false);</script>";
        }
    }
?>