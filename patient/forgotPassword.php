<?php
    session_start();
    error_report(0);
    include('../define/config.php');
    /* checking reset password  */
    if(isset($_POST['submit'])){
        $userName = $_POST['fullname'];
        $userEmail = $_POST['email'];
        $qUser = mysqli_query($deal,"SELECT id FROM users WHERE fullname='$userName' AND email='$userEmail' ");
        $result = mysqli_num_rows($qUser);
        if($result > 0){
            $_SESSION['fullname'] =  $userName;
            $_SESSION['email'] = $userEmail;
            header('location:resetPassword.php');
        } else {
            echo '<script>alert ("Invalid details. Please try with valid details");</script>';
            echo '<script>window.location.href="forgotPassword.php"></script>';
        }
    }
?>
<body class="login">
      <div class="row">
            <div class="main-login">
                <div class="logo margin-to-30"><a href="../index.php"> MMS |  Patient Password Recovery</h2><a></div>
                <div class="box-login">
                    <form class="form-login" method="post">
                        <fieldset>
                               <legend>Patient Password Recovery</legend>
                               <p>Enter Email and Password to recovery password<br/></p>
                               <div class="form-group form-actions">
                                     <span class="input-icon">
                                           <input type="text" name="fullname" class="form-control" placeholder="Register full Name">
                                           <i class="fa fa-lock"></i>
                                     </span>
                               </div>
                               <div class="form-group">
                                    <span class="input-icon">
                                        <input type="email" name="email" class="form-control" placeholder="Registration Email">
                                        <i class="fa fa-user"></i>
                                    </span>
                               </div>
                               <div class="form-actions">
                                     <button name="submit" type="submit" class="btn btnn-primary pull-right">Reset
                                            <i class="fa fa-arrow-circle-right"></i>
                                     </button>
                               </div>
                               <div class="form-account">already have an account<a href="userLogin.php">Log-in</a></div>
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