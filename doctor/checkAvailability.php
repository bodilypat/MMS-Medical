<?php
    require_once('../define/config.php');
    if(!empty($_POST['email'])) {
        $patEmail =$_POST['email'];
        $qPat = mysqli_query($deal,"SELECT patientEmail FROM patients WHERE patientEmail = '$patEmail' ");
        $result = mysqli_num_rows($qPat);
        if($result > 0 ){
            echo "<span style='color:red'>Email already exists.</span>";
            echo "<scrip>$('#submit').prop('disabled',true);</scrript>";
        } else {
            echo "<span style='color:green'>Email available for Registration.</span>";
            echo "<script>$('#submit').prop('disabled',false);</script>";
        }
    }
?>
