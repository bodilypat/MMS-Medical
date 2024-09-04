<?php
    session_start();
    include('../define/config.php');
    error_reporting(0);
    if(isset($_POST['submit'])) {
        $userName = $_POST['username'];
        $docPass = $_POST['password'];
        $qDoc = mysqli_query($deal,"SELECT * FROM doctors WHERE doctorEmail = '$userName' and password='$docPass' ");
        $result = mysqli_fetch_array($qDoc);

        if($result > 0) {
            $_SESSION['dlogin'] = $_POST['username'];
            $_SESSION['id'] = $result['id'];
            $userID = $result['id'];
            $userIP = $_SERVER['REMOTE_ADDR'];
            $status = 1;
            $qDocl = mysqli_query($deal,"INSERT INTO doctorlog(userID, username, userIP, status)
                                         VALUES('$userID','$userName','$userID','$userIP','$status' ");
            header('location : dashboard.php');
        } else {
            $userIP = $_SERVAR['ROMOTE_ADDR'];
            $status = 0;
            mysqli_query($deal,"INSERT INTO doctorlog(username, userIP, status)VALUES('$username','$userIP','$status') ");
            $_SESSION['errmsg'] = "Invalid username or password";
            header('location: index.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Doctor Login</title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/thems/theme-1.css" id="skin_color" />
    </head>
<body>
    <div class="login">
        <div class="row">
            <div class="main-login">
                <div class="logo margin-top-30">
                    <a href="../../index.php"> MMS | Doctor Login</h2></a>
                </div>
                <div class="box-login">
                    <form class="form-login" method="post">
                        <fieldset>
                            <legend>Sign in to your account</legend>
                            <p>Enter username and password . <br />
                                <span style="color:red;">
                                     <?php echo $_SESSION['errmsg'];?>
                                     <?php echo $_SESSION['errmsg']=="";?>
                                </span>
                            </p>
                            <div class="form-group"></div>
                            <div class="form-group form-action">
                                <span class="input-icon">
                                    <input type="text" class="form-control" name="username" placeholder="Username">
                                    <i class="fa fa-user"></i></span> 
                                </span>
                            </div>
                            <div class="form-group form-action">
                                <span class="input-icon">
                                    <input type="password" class="form-control password" name="password" placeholder="Password">
                                    <i class="fa fa-lock"></i>
                                </span>
                                <a href="forgotPassword.php">Forgot Password ?</a>
                            </div>
                            <div class="form-action">
                                <button type="submit" class="btn btn-primary pull-right" name="submit" >
                                    Login <i class="fa fa-arrow-circle-right"></i>
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