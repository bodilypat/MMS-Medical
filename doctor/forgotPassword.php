<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    /* check details for reset password */
    if(isset($_POST['submit'])) {
        $contactNo = $_POST['contactno'];
        $docEmail = $_POST['email'];
        $qDoc = mysqli_query($deal,"SELECT * id FROM doctors WHERE contactno = '$contactno' and doctorEmail ='$docEmail' ");
        $result = mysqli_num_rows($qDoc);
        if($ressult > 0) {
            $_SESSION['contactno'] = $contactNo;
            $_SESSION['doctorEmail'] = $docEmail;
            header('location: resetPassword.php');
        } else {
            echo "<script>alert('Invalid details. Please try to valid details');</script>";
            echo "<script>window.location.href = 'forgotPassword.php'</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Password Recovery</title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color" />
    </head>
<body class="login">
    <div class="row">
        <div class="main-login">
            <div class="logo margin-top-30"><a href="../../index.php"><h2>MMS | Doctor Password Recovery</h2></a></div>
            <div class="box-login">
                <form class="form-login" method="post">
                    <fieldset>
                        <legend>Doctor Password Recovery</legend>
                        <p>Enter contact number and email to recovery your password.<br /></p>
                        <div class="form-group form-action">
                            <span class="input-icon">
                                <input type="text" class="form-control" name="contactno"  placeholder="Registred Contact Number">
                                <i class="fa fa-lock"></i>
                            </span>
                        </div>
                        <div class="form-actiion">
                            <span class="input-icon">
                                <input type="email" class="form-control"  name="email" placeholder="Registred Email">
                                <i class="fa fa-user"></i>
                            </span>
                        </div>
                        <div class="form-action">
                            <button type="submit" class="btn btn-primary pull-right" name="submit">
                                Reset<i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </fieldset>
                </form>
                <div class="">
                    <span class="text-bold text-uppercase">Medical Management System</span>
                </div>
            </div>
        </div>
    </div>
    <!-- custom javascript -->
    <script src="../assign/js/main.js"></script>
    <script src="../assign/js/formElements.js"></script>
    <script>
        jQuery(document).ready(function(){
            Main.init();
            Login.init();
        });
    </script>
</body>
</html>