<?php
    session_start();
    include('../assign/config.php');
    /* code updating password */
    if(isset($_POST['change']))
    {
        $userName = $_SESSIONN['fullName'];
        $userEmail = $_SESSION['email'];
        $nPass = md5($_POST['password']);
        $qUser = mysqli_query($dbcon,"UPDATE users SET password='$nPass' WHERE fullname='$userName' AND email='$email' ");
        if($qUser)
        {
            echo '<script>alert("Password successfully updated.");</script>';
            echo '<script>window.location.href ="userLogin.php"</script>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Password Reset</title>
        <!-- custom style -->
        <link rel="stylesheet" href="assign/css/styles.css">
        <link rel="styelsheet" href="assign/css/plugins.css">
        <link rel="stylesheet" href="assign/css/theme-1.css" id="skin-color">
        <script typ="text/javascript">
            function valid()
            {
                 if(document.passwordreset.password.value != document.passwordreset.cfpassword.value)
                 {
                    alert("Password and Confirm Password Field do not match !!");
                    document.passwordreset.cfpassword.focus();
                    return false;
                 }
                 return true;
            }
        </script>
    </head>
    <body class="login">
        <div class="row">
            <div class="main-login">
               <div class="logo margin-top-30">
                     <a href="../index.php"><h2>MMS | Patient Reset Password</h2></a>
               </div>
               <div class="box-login">
                     <form name="passwordreset" method="post" class="form-login" onSubmit="return valid();">
                            <fieldset>
                                <legend>Patient Reset Password</legend>
                                <p>Please set you Password.<br >
                                    <span style="color:red;">
                                        <?php echo $_SESSION['errmsg']; ?>
                                        <?php echo $_SESSION['errmsg']=""; ?>
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
                                            <input name="cfpassword" id="cfpassword" type="password" class="form-control" Placeholder="Password Again" required>
                                            <i class="fa fa-lock"></i>
                                      </span>
                                </div>
                                <div class="form-actions">
                                      <button name="change" type="submit" class="btn btn-primary pull-right">Change
                                              <i class="fa fa-arrow-circle-right"></i>
                                      </button>
                                </div>
                                <div class="new-accounrt">
                                      Already have an account
                                      <a href="userLogin.php">Log-in</a>
                                </div>
                            </fieldset>
                    </form>
                    <div class="">
                           <span class="text-bold text-uppercase">Medical Management System</spam>
                    </div>
               </div>
            </div>
        </div>
        <!-- custom javascript -->
        <script src="assign/js/main.js"></script>
        <script src="assign/js/login.js"></script>
        <script>
            jQuery(document).ready(function(){
                Main.init();
                login.init();
            });
        </script>
    </body>
</html>