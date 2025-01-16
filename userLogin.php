<?php
    session_start();
    error_reporting(0);
    include("../include/config.php");

    if(isset($_POST['submit'])) {
        $uname = $_POST['username'];
        $pwd=md5($_POST['password']);

        /* Use prepared statement to prevent SQL injection */
        $state = $deal->prepare("SELECT id, password FROM users WHERE email = ? ");
        $stat->bind_param('s', $uname); /* "s" denotes the string type for email */
        $stmt->execute();
        $state->store_result();

        if($stmt->num_rows > 0) {
            $num_rows = $result->fetch_assoc();
            
            /* Verify the password using password_verify() */
            if(password_verify($pwd, $num_rows['password'])) {
                $_SESSION['login'] = $_POST['username'];
                $_SESSION['id'] = $num_rows['id'];
                $uid = $num_rows['id'];
                $host = $_SERVER['HTTP_HOST'];
                $uip = $_SERVER['REMOTE_ADDR'];
                $status = 1;

                /* For storing log if user login successful */
                $log = $deal->prepare("INSERT INTO userlog(uid, username, userip, status) VALUES(?, ?, ?, ?)");
                $log->bind_param("issi", $pid, $uname, $uip, $status); /* argument ("issi") specifies type i:integer, s:string*/ 
                $log->execute();

                header("location:dashboard.php");
            } else {
                /* For storing log if user login unsuccessful */
                $uip = $_SERVER['REMOTE_ADDR'];
                $status = 0;
                $log = $deal->prepare("INSERT INTO userlog(username, userip, status) VALUES(?,?,?) ");
                $log->bind_param("ssi", $uname, $uip, $status);
                $log->execute();

                $_SESSION['errmsg'] = "Invalid username or password";
                header("location:userLogin.php");
            }
        } else {
            /* User not found in database */
            $_SESSIOM['errmsg'] = "Invalid username of password";
            header("location:userLogin.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>User-Login</title>
        <!-- Custom CSS -->
         <link rel="stylesheet" href="../assets/css/styles.css">
         <link rel="stylesheet" href="../assets/css/plugins.css">
         <link rel="stylesheet" href="../assets/css/theme-1.css" id="skin_color" />
    </head>
    <body>
        <div class="row">
            <div class="main-login">
                <div class="logo"><a href="../../index.php"><h2>Medical | Patient Login</h2></a></div>
                <div class="box-login">
                    <form class="form-login" method="post">
                        <fieldset>
                            <legend>Sign Account</legend>
                            <p>Please Enter name and password. <br/>
                                <span style="color:red;"><?php echo $_SESSION['errmsg']; ?><?php echo $_SESSION['errms']="";?></span>
                            </p>
                            <div class="form-group ">
                                <span class="input-icon">
                                    <input type="text" class="form-control" name="username" placeholder="Username">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <div class="form-group form-actions">
                                <span class="input-icon">
                                    <input type="password" class="form-control password" anme="password" placeholder="Password">
                                    <i class="fa fa-lock"></i>
                                </span>
                                <a href="forgotPassword.php">Forgot Password ?</a>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary pull-right" name="submit">
                                    Login <i class="fa fa-arrow-circle-right"></i>
                                </button>
                            </div>
                            <div class="new-account">Don't have an account yet? <a href="registration.php">Create an account</a>
                        </fieldset>
                    </form>
                    <div>
                        <span class="text-bold text-uppercase">Medical Management System</span>
                    </div>
                </div>
            </div>
        </div>
        <script src="../assets/js/main.js"></script>
        <script src="../assets/js/login.js"></script>
        <script>
            jQuery(document).ready(function() {
                Main.init();
                Login.init();
            });
        </script>
    </body>
</html>