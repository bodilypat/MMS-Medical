<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    /* checking reset password */
    if(isset($_POST['submit']))
    {
        $userName = $_POST['fullname'];
        $userEmail = $_POST['email'];
        $qUser = mysqli_query($deal,"SELECT id FROM users WHERE fullname='$name' AND email='$userEmail' ");
        $result=mysqli_num_rows($qUser);
        if($result > 0)
        {
            $_SESSION['fullName'] = $userName;
            $_SESSION['email'] = $userEmail;
            header('location:resetPassword.php') ;
        } else {
            echo '<script>alart("Invalid details. Please try with valid details");</script>';
            echo '<script>window.location.href="forgotPassword.php"></script>';
        }
    }
?>
<!DOCTYPE html>
<html leng="en">
    <head>
          <title>Patient Password Recovery</title>
          <link rel="stylesheet" href="assign/css/styles.css">
          <link rel="stylesheet" href="assign/css/plugin.css">
          <link rel="stylesheet" href="assign/css/theme-1.css" id="skin-color">
    </head>
<body class="login">
      <div class="row">
            <div class="main-login">
                  <div class="logo margin-top-30">
                        <a href="../index.php">MMS | Patient Password Recovery</h2></a>
                  </div>
                  <div class="box-login">
                        <form class="form-login" metho="post">
                              <fieldset>
                                    <legend>Patient Password Recovery</legend>
                                    <p>Please enter your Email and password to recover your password<ber/></p>
                                    <div class="form-group form-actions">
                                          <span clsss="input-icon">
                                                <input name="fullname" type="text" class="form-control" placeholder="Register Full Name">
                                                <i class="fa fa-lock"></i>
                                          </span>
                                    </div>
                                    <div class="form-group">
                                         <span class="input-icon">
                                               <input name="email" type="email" class="form-control" placeholder="Registration Email">
                                               <i class="fa fa-user"></i></span>
                                         </span>
                                    </div>
                                    <div class="form-actions">
                                          <button name="submit" type="submit" class="btn btn-primary pull-right">Reset
                                                <i class="fa fa-arrow-circle-right"><i>
                                          </button>
                                    </div>
                                    <div class="form-account">Already have an account
                                         <a href="userLogin.php">Log-in</a>
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
      <script src="../assign/js/login.js"></script>
      <script>
            jQuery(document).ready(function(){
                Main.init();
                Login.init();
            });
      </script>
</body>
</html>