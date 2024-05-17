<?php
    session_start();
    error_report();
    include('../define/config.php');
    include('../define/checklogin.php');
    check_login();
    if(isset($_POST['submit'])){
        $userEmail = $_POST['email'];
        $editUser = mysqli_query($deal,"UPDATE users SET email='$userEmail' WHERE id='".$_SESSION['id']. "'");
        if($editUser){
            $msg ="your email updated Successfully";
        }
    }
?>
<!-- Change Email -->
<body>
    <div class="application">
         <div class="application-content">
               <div class="main-content">
                    <div id="container" class="wrap-content container">
                         <!-- section: page title -->       
                         <section id="page-title">
                               <div class="row">
                                     <div class="col-sm-8"><h1 class="mainTitle">User | Edit Profile</h1></div>
                                     <ol>
                                          <li><span>User</span></li>
                                          <li class="active"><span>Change Password</span></li>
                                     </ol>
                               </div>
                        </section>
                         <!-- container -->
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row margin-top-30">
                                        <div class="col-lg-8 col-md-12">
                                            <div class="panel panel-white">
                                                <div class="panel-heading"><h5 class="panel-title">Change Password</h5></div>
                                                <div class="panel-body">
                                                      <p style="color:red;">
                                                           <?php echo entities($_SESSION['msg']); ?>
                                                           <?php echo entities($_SESSION['msg']=""); ?>
                                                      </p>
                                                      <form role="form" name="changpwd" method="post" onSubmit="return valid(); ">
                                                           <div class="form-group">
                                                                <label for="Email">Current Password</label>
                                                                <input type="password" name="cpass" class="form-control" placeholder="Current Password">
                                                           </div>
                                                           <div class="form-group">
                                                                 <label for="Password">New Password</label>
                                                                 <input type="password" name="npass" class="form-control" placeholder="New Password">
                                                           </div>
                                                           <div class="form-group">
                                                                 <label for="ConfirmPassword">Confirm Password</label>
                                                                 <input type="password" name="cfpass" class="form-control" placeholder="Confirm Password">
                                                            </div>
                                                            <button type="submit" name="submit" class="btn btn-o btn-primary">
                                                                  Submit
                                                            </button>                                                           
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
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/form-elements.js"></script>
    <script>
            jQuery(document).ready(function(){
                Main.init();
                FormElements.init();
            });
    </script>
</body>

