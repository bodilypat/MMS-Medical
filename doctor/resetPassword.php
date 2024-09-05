<?php
    session_start();
    include('../define/config.php');
    /* code for updating password */
    if(strlen($_POST['change'])) {
        $contactno = $_SESSION['contactnumber'];
        $docEmail = $_SESSION['email'];
        $newPass = md5($_POST['password']);
        $editDoc = mysqli_query($deal,"UPDATE doctors SET password='$newPass' WHERE contactno ='$contactno' AND doctorEmail ='$docEmail' ");
        if($editDoc) {
            echo "<script>alert('Password successfully updated.');</script>";
            echo "<script>window.location.href='index.php'</script>";
        }
    }
?>

<!DOCTYPE html>
<html leang="en">
    <head>
        <title>Password Reset</title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color" />
        <script type="text/javascript">
            function valid() {
                if(document.passwordreset.password.value != document.passwordreset.confirmPassword.value){
                    alert("Password and Confirm Password Filed to do not match !!");
                    document.passwordreset.confirmPassword.focus();
                    return false;
                } 
                return true;
            }
        </script>
    </head>
<body class="login">
    <div class="row">
        <div class="main-login">
            <div class="logo margin-top-30"><a href="../index.php">MMS | Patient Reset Password</h2></a></div>
            <div class="box-login">
                <form class="form-login" name="passwordreset" method="post" onSubmit="return valid(); ">
                    <fieldset>
                        <legend>Patient Reset Password</legand>
                        <p>Enter new password.<br />
                            <span style="color:red;"><?php echo $_SESSION['errmsg'];?><?php echo $_SESSION['errmsg'];?></span>
                        </p>
                        <div class="form-group">
                            <span class="input-incon">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                <i class="fa fa-lock"></i>
                            </span>
                        </div>
                        <div class="form-action">
                            <span class="input-icon">
                                <input type="password" class="foorm-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                                <i class="fa fa-lock"></i>
                            </span>
                        </div>
                        <div class="form-action">
                            <button type="submit" class="btn btn-primary pull-right" name="change" >
                                Change <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                        <div class="new-account">Already have an account? 
                            <a href="index.php">Log-in</a>
                        </div>
                        <div class="">
                            <span class="text-bold text-uppercase">Medical Management System</span>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <!-- custom javascript -->
    <script src="../assign/js/main.js"></script>
    <script src="../assign/js/login.js"></script>
    <script>
        jQuery(document).ready(function(){
            Main.init();
            Login.init();
        });
    </script>
</body>
</html>