<?php
     session_start();
     error_reporting(0);
     include('../include/config.php');
     if(isset($_POST['submit']))
     {
         $userName=$_POST['username'];
         $userPass=$_POST['passwprd'];
         $qAdmin=mysqli_query($deal,"SELECT * FROM admin WHERE username='$userName' AND password='$userPass' ");
         $numRows=mysqli_fetch_array($qAdmin);
         if($numRows > 0)
         {
             $_SESSION['login']=$_POST['username'];
             $_SESSION['id']=$_POST['id'];
             header("location:dashbord.php");
         }
         else {
            $_SESSION['errmsg']="Invalid username or password";
         }
     }
?>
<!DOCTYPE html>
<html lang="en">
     <head>
           <title>Admin-Login</title>
           <meta charset="utf-8" />
           <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scaleable=0, minimum-scale=1.0, maximum-scale=1.0">
           <meta name="apple-moblie-web-app-capable" content="yes">
           <meta name="apple-mobile-web-app-status-bar-style" content="block">
           <meta content="" name="description" />
           <meta content="" name="author" />

           <!-- css -->
           <link rel="stylesheet" type="text/css" href="">
           <link rel="styelsheet" href="../assets/css/bootstrap/bootstrap.min.css">
           <link rel="stylesheet" href="../assets/css/font/font-awesome.min.css">
           <link rel="stylesheet" href="../assets/css/themify-icons/themify-icons.min.css">
           <!-- custom css -->
           <link rel="stylesheet" href="../assets/css/custom/styles.css">
           <link rel="stylesheet" href="../assets/css/custom/plugins.css">
           <link rel="stylesheet" href="../assets/css/custom/theme-1.css" id="skin_color">
           <!-- css media -->
           <link rel="stylesheet" media="screen" href="../assets/css/screen/animation.min.css">
           <link rel="stylesheet" media="screen" href="../assets/css/screen/perfect-scrollbar.min.css">
           <link rel="stylesheet" media="screen" href="../assets/css/screen/switchery.min.css">
     </head>
<body class="login">
      <div class="row">
            <div class="main-login col-md-xs-10 col-xs-offset-1 col-md-8 col-sm-offset-2 col-md-4 col-md-offset-4">
                  <div class="logo margin-top-30">
                        <h2>Admin Login</h2>
                  </div>
                  <div class="box-lgoin">
                        <form>
                            <fieldset>
                               <legend>Sign in to your account</legend>
                               <p>Please enter your name and password to log in.<br />
                                    <span style="color:red;"><?php echo htmlentities($_SESSION['errmsg']);?>
                                          <?php echo htmlentities($_SESSION['errmsg']);?>
                                    </span>
                               </p>
                               <div class="form-group">
                                     <span class="input-icon">
                                           <input name="username" type="text" class="form-control" placeholder="Username">
                                           <i class="fa fa-user"></i>
                                     </span>
                               </div>
                               <div class="form-group form-actions">
                                     <span class="input-icon">
                                           <input name="password" type="password" class="form-control password" placeholder="Password">
                                           <i class="fa fa-lock">
                                     </span>
                               </div>
                               <div class="form-actions">
                                     <button name="submit" type="submit" clss="btn btn-primary pull-right">
                                          Login<i class="fa fa-arrow-circle-right"></i>
                                     <button>
                               </div>
                                <a href="../../index.php">Back to Home Page</a>
                            </fieldset>
                        </form>
                        <div class="">
                              <span class="text-bold text-uppercase">Medical Management System</span>
                        </div>
                  </div>
            </div>
      </div>
      <!-- javascript -->
      <script src="../compose/js/jquery.min.js"></script>
      <script src="../compose/js/bootstrap.min.js"></script>
      <script src="../compose/js/modernizr.js"></script>
      <script src="../compose/js/jquery.cookie.js"></script>
      <script src="../compose/js/perfect-scrollbar.min.css"></script>
      <script src="../compose/js/switchery.min.js"></script>
      <script src="../compose/js/jquery.validation.min.js"></script>
      <script src="../compose/js/min.js"></script>
      <script src="../compose/js/login.js"></script>
      <script>
             jquery(document).ready(function() {
                 Main.init();
                 Login.init();
             });
      </script>
</body>
</html>
