<?php
    session_start();
    include('../define/config.php');
    include('../define/checkLogin.php');
    check_login();
    data_default_timezone_set('America/LostAngels');/* change time zone */
    $currentTime = date('d-m-Y h:i:s A', time() );
    if(isset($_POST['sucmit'])){
        $qUser=mysqli_query($deal,"SELECT password users WHERE password=' " .md5($_POST['cpass'])." ' && id=' ".$_SESSION['id']. "'");
        $result=mysqli_fetch_array($qUser);
        if($result > 0){
            $editUser=mysqli_query($deal,"UPDATE users
                                          SET password='".md5($_POST['npass'])."', updateDate='$currentTime' 
                                          WHERE id='".$SESSION['id']. "'");
            $_SESSION['msg'] = "Password Changed Successfully !! ";
        } else {
            $_SESSION['msg']="Old password not match !! ";
        }
    }
?>
<!-- script change password -->
    <script>
         function valid(){
            if(document.changepwd.cpass.value ==""){
                alert('Current Password filed is Empty !!');
                document.changepwd.cpass.focus();
                return false;
            } else if(document.changepwd.npass.value ==""){
                alert('New Password Filed is Empty !!');
                document.changepwd.npass.focus();
                return false;
            } else if(document.changepwd.cfpass.value == ""){
                alert('Confirm Password Filed is Empty !!');
                document.changepwd.cfpass.focus();
                return false;
            } else if(document.changepwd.npass.value != document.changepwd.cfpass.value){
                alert('Password and Confirm Password Filed do not match !!');
                document.changepwd.cfpass.focus();
                return false;
            }
            return true,
         }
    </script>
    <!-- application  -->
<body>
    <div id="application">
          <div class="application-content">
                <div class="main-content">
                      <div id="container" class="wrap-content container">
                            <!-- section: page title -->
                            <section id="page-title">
                                  <div class="row">
                                        <div class="col-sm-8"><h1 class="mainTitle">User | Change Password</h1></div>
                                        <ol>
                                             <li><span>User</span></li>
                                             <li class="Active"><span>Change Password</span></li>
                                        </ol>
                                  </div>
                            </section>
                            <!-- section: change password -->
                            <div class="contain-fluid container-fullw bg-white">
                                  <div class="row">
                                        <div class="col-md-12">
                                              <div class="row margin-top-30">
                                                    <div class="col-lg-8 col-md-12">
                                                        <div class="panel panel-white">
                                                            <div class="panel-white">
                                                                <div class="panel-heading"><h5 class="panel-title">Change Password</h5></div>
                                                                <div class="panel-body">
                                                                      <p style="color:red;">
                                                                           <?php echo htmlentities($_SESSION['msg']); ?>
                                                                           <?php echo htmlentities($_SESSION['msg']=""); ?>
                                                                      </p>
                                                                      <form name="changepwd" role="form" method="post" onSubmit="return value();">
                                                                            <div class="form-group">
                                                                                 <label for="CurrentPassword"></label>
                                                                                 <input name="cpass" type="password" class="form-control" placeholder="Current Password">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                 <label for="NewPassword">New Password</label>
                                                                                 <input name="npass" type="password" class="form-control" placeholder="New Password">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                 <label for="ConfirmPassword">Confirm Password</label>
                                                                                 <input name="cfpass" type="password" class="form-control" placeholder="Confirm Password" >
                                                                            </div>
                                                                            <button name="submit" type="submit" class="btn btn-o btn-primary">Submit</button>
                                                                      </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                              </div>
                                        </div>
                                  </div>
                            </div>
                      </div>
                </div>
          </div>
    </div>
    <!-- javascript -->
    <script src="../assets/js/min.js"></script>
    <script src="../assets/js/form-elements.js"></script>
    <script>
          jQuery(document).ready(function(){
              Main.init();
              FormElements.init();
          });
    </script>
</body>