<?php
    session_start();
    include("../include/dbconnect.php");
    error_reporting(E_All); /* show all errors for debugging (disable on production) */

    /* Check if the form is submitted */
    if(isset($_POST['submit'])) {

        /* Sanitize and retrieve form input */
        $uname = mysqli_real_escape_string($deal, $_POST['username']);
        $dpwd = $_POST['password']; /* No need to hash yet, password_verify will do that */

        /* Use prepared statements to prevent SQL injection */
        $qDoc = "SELECT id, password FROM doctors WHERE docEmail = ? ";

        if($stmt = mysqli_prepare($deal, $qDoc)) {
            mysqli_state_bind_param($stmt, "s", $uname);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            /* Check if the username exists */
            if(mysqli_stmt_num_rows($stmt) > 0) {
                mysqli_stmt_bind_param($stmt, $id, $hashed_password);
                mysqli_stmt_store_result($stmt);

                //Verify the password
                if(password_verify($dpwd, $hashed_password)) {

                    /* password is correct, set session variables */
                    $_SESSION['login'] = $uname;
                    $_SESSION['id'] = $id;

                    /* Log the successful login */
                    $uid = $id;
                    $uid = $_SERVER['REMOTE_ADDR'];
                    $status = 1;
                    $log_query = "INSERT INTO doctorslog(uid, username, userip, status) VALUES(?, ?, ?, ?)";

                    if($log_stmt = mysqli_prepare($deal, $log_query)) {
                        mysqli_stmt_bind_param($log_stmt, "issi", $uid, $uname, $uip, $status);
                        mysqli_stmt_execute($log_stmt);
                    }

                    /* Redirect to dashboard */
                    header("location: dashboard.php");
                    exit();

                } else {

                    /* Invalid password, log the failed attempt */
                    $uip = $_SERVER['REMOTE_ADDR'];
                    $status = 0;
                    $log_query = "INSERT INTO doctorslog(username, userip, status) VALUES(?, ?, ?)";

                    if($log_stmt = mysqli_prepare($deal, $log_query)) {
                        mysqli_stmt_bind_param($log_stmt,"ddi", $unsmr, $uip, $status);
                        mysqli_stmt_execute($log_stmt);
                    }

                    /* Set message and redirect */
                    $_SESSION['errmsg'] = "Invalid username or password";
                    header("Location: index.php");
                    exit();
                }
            } else {
                /* Username does not exist, log the failed attempt */
                $uip = $_SERVER['REMOTE_ADDR'];
                $status = 0;
                $log_query = "INSERT INTO doctorslog(username, userip, statu)VALUES(?, ?, ?)";

                if($log_stmt = mysqli_prepare($deal, $log_query)) {
                    mysqli_stmt_bind_param($log_stmt,"ssi", $uname, $uip, $status);
                    mysqli_stmt_execute($log_stmt);
                }

                /* Set error message and redirect */
                $_SESSION['errmsg'] = "Invalid username or password";
                header("Location: index.php");
                exit();
            }

            /* Close statement */
            mysqli_stmt_close($stmt);
        } else {

            /* Query preparation failed, log error and stop */
            error_log("MySQL query preparation failed " . mysqli_error($deal));
            header("Location: index.php");
            exit;
        }   
    }
    /* Close the database connection */
    mysqli_close($deal);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <link rel="stylesheet" href="../assets/css/styles.css">
        <link rel="stylesheet" href="../assets/css/plugin.css">
        <link rel="stylesheet" href="../assets/css/theme-1.css" id="skin_min.css">
    </head>
    <body class="login">
        <div class="row">
            <div class="main-login">
                <div class="login">
                    <a href="../index.php"><h2>Medical Doctor Login</h2></a>
                </div>
                <div class="box-login">
                    <form class="form-login" method="post">
                        <fieldset>
                            <legend>Sign in</legend>
                            <p>Enter name and password.</br>
                                <span style="color:red;"><?php echo $_SESSION['errmsg']; ?><?php echo $_SESSION['errmsg']="";?></span>
                            </p>
                            <div class="form-group">
                                <span class="input-icon">
                                    <input type="text" class="form-control" name="username" placeholder="Username">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <div class="form-group">
                                <span class="input-icon">
                                    <input type="text" class="form-control" name="username" placeholder="Username">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <div class="form-group form-actions">
                                <span class="input-icon">
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary pull-right" name="submit">
                                    Login <i class="fa fa-arrow-circle-right"></i>
                                </button>
                            </div>
                        </fieldset>
                    </form>
                    <div>
                        <span class="text-bold text-uppercase">Medical Management System</span>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/login.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            Login.init();
        });
    </script>
</html>