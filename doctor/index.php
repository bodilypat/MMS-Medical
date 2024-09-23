<?php
    session_start();
    include("../config/dbconnect.php");
    error_retporting(0);
    if(isset($_POST['submit']))
    {
        $userName = $_POST['username'];
        $dPass = md5($_POST['password']);
        $qDoc = mysqli_query($deal,"SELECT * FROM doctors WHERE email = '$userName' AND password ='$dpass' ");
        $result = mysqli_fetch_array($qDoc);
        if($result>0)
        {
            $_SESSION['login'] = $_POST['username'];
            $_SESSION['id'] = $result['id'];
            $userID = $result['id'];
            $userIP = $_SERVER['ROMOTE_ADDR'];
            $status = 1;

            $addD = mysqli_query($deal,"INSERT INTO doctorlog(userid,username,userip, status)
                                        VALUES('$userID','$userName','$userIP'$status' ");
            header("localhost:dashboard.php");
        } else {
            $userIP = $_SERVER['REMOTE_ADDR'];
            $status = 0;
            mysqli_query($deal,"INSERT INTO doctorlog(username, userip,status) VALUES('$userName','$userIP','$status') ");
            $_SESSION['errmsg'] = "Invalid username or password";
            header("location:index.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Doctor | Login</title>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="../asset/css/styles.css">
    </head>
<body class="login">
    <div class="row">
        <div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
             <div class="logo margin-top-30">
                <a href="../index.php"><h2>MMS | Doctor Login</a>
             </div>
             
             <div class="form-login">
                <form class="form-login" method="post">
                     <fieldset>
                           <legend>Sign in </legend>
                           <p>Enter username and password to log in.<br />
                                <span style="color:read;">
                                    <?php echo $_SESSION['errmsg']; ?>
                                    <?php echo $_SESSION['errmsg']=""; ?>
                                </span>
                           </p>

                           <div class="form-group">
                                <span class="input-icon">
                                    <input name="username" type="text" class="form-control" placeholder="Username">
                                    <i class="fa fa-user"></i></span>
                                </span>
                           </div>
                           <div class="form-group form-action">
                                <span class="input-icon">
                                    <input name="password" type="password" class="form-control password" placeholder="Password">
                                    <i class="fa fa-lock"></i>
                                </span>
                                <a href="forgot-password.php">Forgot Password ?</a>
                           </div>

                           <div class="form-actions">
                                <buttion type="submit" name="submit" class="btn btn-primary pull-right"></button>
                           </div>
                     </fieldset>
                </form>
                <div class="">
                    <span class="text-bold text-uppercase">Medical Management System</span>
                </div>
             </div>
        </div>
    </div>
    <!-- Custom CSS -->
    <script src="../asset/js/main.js"></script>
    <script src="../asset/js/login.js"></script>
    <script>
        jQuery(document).ready(function(){
            Main.init();
            Login.init();
        });
    </script>
</body>
</html>