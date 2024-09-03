<?php
    require_once('../define/config.php');
    if(!empty($_POST['email'])) {
        $email = $_POST['email'];
        $qDoc = mysqli_query($deal,"SELECT docEmail FROM doctors WHERE docEmail = '$email' ");
        $count = mysqli_num_rows($qDoc);
        if($count > 0) {
            echo '<span style="color:red">Email already exists.</span>';
            echo '<script>$('submit').prop('disabled',true);</script>';
        } else {
            echo '<span style='color:green'>Email available for Registration .</span>';
            echo '<script>$("#submit").prop('disabled',false);</script>';
        }
    }
?>
