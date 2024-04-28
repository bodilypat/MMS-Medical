<?php
    session_start();
    include('../define/config.php');
    include('../define/checkLogin.php');
    check_login();
    data_default_timezone_set('America/Los_Angeles');/* checge time zone */
    $currentTime = date('d-m-Y h:i:s A', time() );
    if(isset($_POST['submit']))
    {
        $qUser=mysql_query($dbcon,"SELECT password users WHERE password='".md5($_POST['cpass'])."' && id='".$_SESSION['id']."'" );
        $result=mysqli_fetch_array($qUser);
        if($result>0)
        {
            $eUser=mysqli_query($dbcon,"UPDATE users 
                                        set password='".md5($_POST['npass'])."' , updateDate='$currentTime' 
                                        WHERE  id='".$_SESSION['id']."'");
            $_SESSION['msg']="Password Changed Successfully !!";
        }else {
            $_SESSION['msg']="Old password not match !!";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>User | Change Password</title>
        <!-- custom style -->
        <link rel="stylesheet" href="assign/css/styles.css">
        <link rel="stylesheet" href="assign/css/plugins.css">
        <link rel="stylesheet" href="assign/css/theme/theme-1.css" id="skin_color" />
        <!-- check password -->
        <script>
            function valid()
            {
                if(document.changepwd.cpass.value==""){
                    alert("Current Password Filed is Empty !!");
                    document.changepwd.cpass.focus();
                    return false;
                }
                else if(document.changepwd.npass.value==""){
                    alert("New Password Filed is Empty !!");
                    document.changepwd.npass.focus();
                    return false;
                } 
                else if(document.changepwd.cfpassword.value==""){
                    alert("Confirm Password Filed is Empty !! ");
                    document.changepwd.cfpass.focus();
                    return false;
                } else if(document.changepwd.npassword.value != document.changepwd.cfpass.value){
                    alert("Password and Confirm Password Filed do not match !!");
                    document.changepwd.cfpass.focus();
                    return false;
                }
                return true;
            }
        </script>
    </head>
    <body>
        <div id="application">
            <?php include('../define/sidebar.php')?>
            <div class="application-content">
                  <?php include('../define/header.php');?>
                  <div class="main-content">
                        <div id="container" class="wrap-content container" >
                              <!-- section: page title  -->
                              <section id="page-title">
                                   <div class="row">
                                        <div class="col-sm-8"><h1 class="mainTitle">User | change password</h1></div>
                                        <ol class="breadcrumb">
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
                                                                  <div class="panel-heading"><h5 clas="panel-title">Change Password</h5></div>
                                                                  <div class="panel-body">
                                                                       <p style="color:red;">
                                                                            <?php echo htmlentities($_SESSION['msg']); ?>
                                                                            <?php echo htmlentities($_SESSION['msg']="");?>
                                                                       <p>
                                                                        <form name="changepwd" role="form" method="post" onSubmit="return value();">
                                                                            <div class="form-group">
                                                                                <label for="CurrentPassword"></label>
                                                                                <input name="cpass" type="password" class="form-control" placeholder="Current Password">
                                                                            </div>
                                                                            <form class="form-group">
                                                                                <label for="NewPassword">New Password</label>
                                                                                <input name="npass" type="password" class="form-control" placeholder="New Password">
                                                                            </div>
                                                                            <form class="form-group">
                                                                                <label for="ConfirmPassword">Confirm Password</label>
                                                                                <input name="cfpass" type="passwprd" class="form-control" placeholder="Confirm Password" >
                                                                            </div>
                                                                            <buttom name="submit" type="submit" class="btn btn-o btn-primary">Submit</button>
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
            <!-- FOOTER -->
            <?php include('../define/footer.php'); ?>
            <?php include('../define/setting.php'); ?>
            <!-- javacript -->
            <script src="../assign/js/main.js"></script>
            <script src="../assign/js/main.js"></script>
            <script>
                  jQuery(document).ready(function(){
                    Main.init();
                    FormElement.init();
                  });
            </script>
        </div>
    </body>
</html>