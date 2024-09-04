<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(isset($_POST['submit'])) {
        $userName = $_POST['username'];
        $userPass = $_POST['password'];

        $qAdmin = mysqli_query($deal,"SELECT * FROM admin WHERE username =' $userName' ");
        $result = mysqli_fetch_array($qAdmin);
        if($result > 0) {
            $_SESSION['login'] = $_POST['username'];
            $_SESSION['id'] = $result['id'];
            header('location: dasboard.php');
        } else {
            $_SESSION['errmsg'] = "Invalid username or password ";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin-login</title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/theme/theme-1.css">
    </head>
<body>
    <div id="login">
        <div class="row">
            <div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
                <div class="logo margin-top-30"><h2>Admin Login</div>
                <div class="box-login">
                    <form class="form-login" method="post">
                        <fieldset><legend>Sign in to your account</legend>
                            <p>Enter username and password .</br> />
                                <span style="color:red;">
                                    <?php echo htmlentities($_SESSION['errmsg']);?>
                                    <?php echo htmlentities($_SESSION['errmsg']="");?>
                                </span>
                            </p>
                            <div class="form-group"></div>
                            <div class="form-group form-action"></div>
                            <div class="form-action">
                                <button type="submit" class="btn btn-primary pull-right" name="submit">
                                    Login<i class="fa fa-arrow-circle-right"></i>
                                </button>
                            </div>
                            <a href="../../index.php">Back to Home Page</a>
                        </fieldset>
                    </form>
                    <div>
                        <span class="text-bold text-uppercase">Medical Management System</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
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