<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(isset($_POST['submit']))
    {
        $userName = $_POST['username'];
        $userPass = $_POST['password'];
        $qUser=mysqli_query($deal,"SELECT * FROM users WHERE email = '$userName' AND password='$userPass' ");
        $result = mysqli_query($qUser);
        if($result > 0){
            $_SESSION['login'] = $_POST['username'];
            $_SESSION['id'] = $result['id'];
            $userID = $result['id'];
            $host = $_SERVER['HTTP_HOST'];
            $userIP = $_SERVER['REMOTE_ADDR'];
            $status=1;

            /* for storing log if user login  successfull */
            $addLog = mysqli_query($deal,"INSERT INTO  userlog(id,username, userip, status)
                                               VALUES('$userID','$usernName','$userIP','$status')");
            header("location:dashboard.php");
        } else {
            /* user login unsuccessfull */
            $_SESSION['login']=$_POST['username'];
            $userIP=$_SERVER['REMOTE_ADDR'];
            $status=0;
            mysqli_query($deal,"INSERT INTO userlog(username, userip, status)
                                     VALUES('$userName','$userIP','$status') ");
            $_SESSION("location:userLogin.php")
        }
    }
?>

<body class="login">
    <div class="row">
          <div class="col-xs-10">
                <div class="logo margin-top-30"><a href="../index.php"><h2> MMS | Patient Login</h2></a></div>
                <div class="box-login">
                      <form class="form-login" method="post">
                            <fieldset>
                                <legend>Sign to your account</legend>
                                <p>Enter name and Password log in.<br/>
                                    <span style="color:red;">
                                        <?php echo $_SESSION['errmsg']; ?>
                                        <?php echo $_SESSION['errmsg']; ?>
                                    </span>
                                </p>
                                <div class="form-group">
                                      <span class="input-icon">
                                            <input type="password" name="username" class="form-control" placeholder="Username">
                                            <i class="fa fa-user"></i>
                                      </span>
                                </div>
                                <div class="form-group form-actions">
                                      <span class="input-icon">
                                            <input type="password" name="password" class="form-control password" placeholder="Password">
                                            <i class="fa fa-lock"></i>
                                      </span>
                                </div>
                                <div class="form-actions">
                                      <button type="submit" name="submit" class="btn btn-primary pull-right">
                                           Login<i class="fa fa-arrow-circle-right"></i>
                                      </button>
                                </div>
                                <div class="new-account">
                                      Don't have an account yet?<a href="registration.php">Create an account</a>
                                </div>                                
                            </fieldset>
                      </form>
                      <div>
                            <span class="text-bold text-uppercase">Medical Management System</span>
                      </div>
                </div>
          </div>
    </div>
    <script src="assign/js/main.js"></script>
    <script src="assign/js/login.js"></script>
    <script>
         jQuery(document).ready(function(){
              Main.init();
              Login.init();
         });
    </script>
</body>
