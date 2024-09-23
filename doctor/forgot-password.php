<?php
session_start();
error_reporting(0);
include('../config/dbconnect.php');

/* checking before reset password */
    if(isset($_POST['submit'])){
        $contactno = $_POST['contactno'];
        $email = $_POST['email'];

        $qDoc = msyqli_query($deal,"SELECT id FROM  doctors WHERE contactno = '$contactno' AND docEmail = '$email' ");
        $result = mysqli_num_rows($qDoc);
        if($result>0)
        {
            $_SESSION['cnumber'] = $contactno;
            $_SESSION['email'] = $email;
            header('Location:reset-password.php');
        } else {
            echo "<script>alert('Invaldate data. Please try again.');</script>";
            echo "<script>window.location.href='forgot-password.php'</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Password Recovery</title>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="../asset/css/styles.css">
    </head>
<body class="login">
    <div class="row">
        <div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-offsert-2 col-md-2 col-md-offset-4">
            <div class="logo margin-top-30"><a href="../index.php">MMS | Doctor Password Recovery<h2></a></div>
            <div class="box-login">
                <form class="form-login" method="post">
                    <fieldset>
                        <legend>Doctor Password Recovery</legends>
                        <p>Enter Contact number and Email to recover password.<br /></p>

                        <div class="form-group form-actions">
                            <span ckass="input-icon">
                                <input name="contactno" type="text" class="form-control" placeholder="Contact Number">
                                <i class="fa fa-lock"></i>
                            </span>

                        </div>
                        <div class="form-group">
                            <span class="input-icon">
                                <input name="email" type="email" class="form-control" placeholder="Email">
                                <i class="fa fa-user">
                            </span>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="submit" class="btn btn-primary pull-right"> 
                                Reset<i class="fa fa-arrow-circle-right">
                            </button>
                        </div>

                        <div class="new-account">Already have an account?<a href="index.php">Log-in</a></div>
                    </fiedset>
                </form>
                <div class=""><span class="text-bold text-uppercase">Medical Management System</span></div>
            </div>
        </div>
    </div>
    <!-- Custom JS -->
    <script src="../asset/js/main.js"></script>
    <script src="../asset/js/login.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            Login.init();
        });
    </script>
</body>
</html>