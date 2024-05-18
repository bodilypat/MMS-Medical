<?php
    session_start();
    error_reporting(0);
    include('../define/config');
    if(isset($_POST['submit'])){
        $docName=$_POST['username'];
        $docPass=$_POST['password'];
        $qDoc=mysqli_query($deal,"SELECT * FROM doctors WHERE doctorEmail='$docName' AND password='docPass' ");
        $result=mysqli_fetch_array($qDoc);
        if($result > 0){
            $_SESSION['dlogin']=$_POST['username'];
            $_SESSION['id']=$result['id'];
            $docID=$result['id'];
            $docIP=$_SERVER['REMOTE_ADDR'];
            $status=1;
            $adlog=mysqli_query($deal,"INSERT INTO doctorslog(userId, username, userip, status)
                                       VALUES('$docID','$docName','$docIP','$status') ");

        } else{
            $docIP=$_SERVER['REMOTE_ADDR'];
            $status=0;
            mysqli_query($deal,"SELECT INTO doctorlog(username,userip, status)
                                VALUES('$docName','$docIP','$status') ");
            header("location: index.php");
        }
    }
?>
<body class="login">
    <div class="row">
          <div class="main-login">
                <div class="logo margin-top-30">
                      <a href="../index.php"><h2>Medical | Doctor Login</h2></a>
                </div>
                <div class="box-login">
                      <form class="form-login" method="post">
                            <fieldset>
                                  <legend>Sign in to your account</legend>
                                  <p>Please enter your name and password to log in.</br >
                                       <span style="color:red;">
                                            <?php echo $_SESSION['errmsg'];?>
                                            <?php echo $_SESSION['errmsg']="";?>
                                       </span>
                                  </p>
                                  <div class="form-group">
                                        <span class="input-icon">
                                             <input name="password" type="text" class="form-control" placeholder="Password">
                                             <i class="fa fa user"></i>
                                        </span>
                                  </div>
                                  <div class="form-group">
                                        <span class="input-icon">
                                             <input name="password" type="password" class="form-control password" placeholder="Password">
                                             <in class="fa fa-lock"></i>
                                        </div>
                                  </div>
                                  <div class="form-actions">
                                        <button name="submit" type="submit" class="btn btn-primary pull-right">
                                               Login<i class="fa fa-arrow-circle-right"></i>
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
    <!-- javascript -->
    <script src="../assets/js/min.js"></script>
    <script src="../assets/js/login.js"></script>
    <script>
         jQuery(document).ready(function(){
             Main.init();
             Login.init();
         });
    </script>
</body>