<?php
    session_start();
    include("../config/dbconnect.php");
    if(isset($_POST))
    {
        $cno = $_SESSION['cnumber'];
        $email = $_SESSION['email'];
        $newPass = md5($_POST['password']);

        $eDoc = mysqli_query($deal,"UPDATE doctors SET password='newPass' WHERE contacno = '$cno' AND docEmail = '$email' ");

        if($eDoc){
            echo "<scriiot>alert('password successfully updated.');</script>";
            echo "<script>window.location.href=index.php'></script>"
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Password Reset</title>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="../asset/css/styels.css">
        <script type="text/javascript">
            function valid()
            {
                if (document.passwordReset.password.value != document.passwordReset.confrim_password.value)
                {
                    alert("Password and Confirm password do not match!!");
                    document.passwordreset.confirm_password.forcus();
                    return false;
                }
                return true;
            }
        </script>
    </head>
<body class="login">
    <div class="row">
        <div class="main-login col-xs-1 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
            <div class="logo margin-to-30"><a href="../index.php"><h2>MMS | Doctor Reset Password<h2></a></div>

            <div class="box-login">
                <form class="form-login" name="passwordReset" method="post" onSubmit="return valid();">
                    <fieldset>
                        <legend>Doctor Reset Password</legend>
                        <p>Please enter new password<br/>
                            <span style="color:red;">
                                <?php echo $_SESSION['errmsg'];?>
                                <?php echo $_SESSION['errmsg'];?>
                            </span>
                        </p>

                        <div class="form-group">
                            <span class="input-icon">
                                <input name="password" id="password" type="password" class="form-control" placeholder="Password" required>
                                <i class="fa fa-lock"></i>
                            </span>
                        </div>
                        <div class="form-group">
                            <span class="input-icon">
                                <input name="confirm_password" id="confirm_password" type="password" class="form-control" placehodler="Confirm Password" required>
                                <i class="fa fa-lock">
                            </span>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary pull-right" name="change">
                                Change<i class="fa fa-arrow-circle-right"></i>
                            <button>
                        </div>
                        <div class="new-account">Already have an account? <a href="index.php">Login-in</a></div>
                    </fieldset>
                </form>
                <div class=""><span class="text-bold text-uppercase">Medical Management System</spa></div>
            </div>
        </div>
    </div>
    <!-- Custom JS -->
    <script src="../asset/js/main.js"></script>
    <script src="../asset/js/login.js"></script>
    <script>
        jQuery(document).ready(function(){
            Main.init();
            Login.init();
        });
</body>
</html>