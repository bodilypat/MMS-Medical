<?php
    session_start();
    error_reporting(0);
    include("../define/config.php");
    if(isset($_POST['submit']))
    {
        $userName = $_POST['username'];
        $userPass = $_POST['password'];
        $qUser = mysqli_query($deal,"SELECT * FROM users WHERE email='$userName' AND password='$userPass' ");
        $result = mysql_fetch_array($qUser);
        if($result > 0)
        {
            $_SESSION['login'] = $_POST['username'];
            $_SESSION['id'] = $result['id'];
            $userid = $result['id'];
            $host = $_SERVER['HTTP_HOST'];
            $userip = $_SERVER['REMOTE_ADDR'];
            $status=1;
            /* storing user login  */
            $userL = mysqli_query($deal,"INSERT INTO userlog(userId,username,userip,status)
                                          VALUES('$userid','$userName','$userip','$status') ");
            header("location:dashboard.php")
        }
        else {
            /* login unsuccessful */
            $_SESSION['login'] = $_POST['usernam'];
            $userip = $_SERVER['REMOTE_ADDR'];
            $status=0;
            mysqli_query($deal,"INSERT INTO userlog(username,userip,status)
                                 VALUES('$userName','$userip','$status')");
            $_SESSION['errmsg'] = "Invalid username or password";
            header("location:userLong.php")
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>User-Login</title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color" />
    </head>
<body>
    <div class="row">
          <div class="main-login">
                <div class="logo margin-top-30">
                      <a href="../index.php"><h2> MMS | Patient Login</h2></a>
                </div>
                <div class="box-login">
                      <form class="form-login" method="post">
                            <fieldset>
                                <legend>Sign in to your account</legend>
                                    <p>Enter your name and password to log in.<br/>
                                        <span style="color:red;">
                                            <?php echo $_SESSION['errmsg'];?>
                                            <?php echo $_SESSION['errmsg']="";?>
                                        </span>
                                    </p>
                                    <div class="form-group">
                                        <span class="input-icon">
                                            <input name="username" type="text" class="form-control" placeholder="Username">
                                            <i class="fa-fa-user"></i>
                                        </span>
                                    </div>
                                    <div class="form-group form-actions">
                                        <span class="input-icon">
                                            <input name="password" type="password" class="form-control password" placeholder="Password">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                        <a href="forgotPassword.php">Forgot Password? </a>
                                    </div>
                                    <div class="form-actions">
                                        <button name="submit" type="submit" class="btn btn-primary pull-right">Login
                                                <i class="fa fa-arrow-circle-right"></i>
                                        </button>
                                    </div>
                                    <div class="new-account">
                                        Don't have an account yet? 
                                        <a href="registration.php">Create an account</a>
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
            jquery(document).ready(function() {
                Main.init();
                Login.init();
            })
    </script>
</body>
</html>