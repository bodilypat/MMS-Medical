<?php
    session_start();
    error_report();
    include('../define/config.php');
    include('../define/checklogin.php');
    check_login();
    if(isset($_POST['submit']))    
    {
        $userEmail = $_POST['email'];
        $qUser=mysqli_query($dbcon,"UPDATE users SET email='$userEmail' WHERE id='".$_SESSION['id']."'");
        if($qUser)
        {
            $msg="Your email updated Successfully";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
     <head>
            <title>User | Edit Profile</title>
            <!-- custom style -->
            <link rel="stylesheet" href="../assign/css/styles.css">
            <link rel="stylesheet" href="../assign/css/plugins.css">
            <link rel="Stylesheet" href="../assign/css/theme/theme-1" id="skin_color" />
     </head>
    <body>
        <div class="application">
            <div class="application-content">
                 <div class="main-content">
                      <div id="container" class="wrap-content container">
                           <!-- section: page title -->
                           <section id="page-title">
                                <div class="row">
                                    <div class="col-sm-8"><h1 class="mainTitle">User | Edit Profile</h1></div>
                                    <ol class="breadcrumb">
                                        <li><span>User</span></li>
                                        <li class="active"><span>Edit Profile</span></li>
                                    </ol>
                                </div>
                           </section>
                           <!-- get email -->
                           <div calss="container-fluid container-fullw bg-white">
                                <div class="row">
                                    <div class="col-md-12">
                                          <h5 style="color:green; font:size:8px;"><?php echo if(msg) { echo htmlentities($msg); }?></h5>
                                          <div class="row margin-top-30">
                                               <div class="col-lg-8 col-md-12">
                                                     <div class="panel-heading"><h5 class="panel-title">Edit Profile</h5></div>
                                                     <div class="panel-body">
                                                           <form name="getEmail" id="updateEmail" method="post">
                                                                <div class="form-group">
                                                                    <label for="UserEmail">User Email</label>
                                                                    <input name="email" id="email" type="email" class="form-control" 
                                                                           onBlur="userAvailability()" placeholder="Get Email" required>
                                                                           <span id="user-availability-status" style="font-size:12px;"></span>
                                                                </div>
                                                                <button name="submit" id="submit" type="submit" class="btn btn-o btn-primary">
                                                                    updated
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
            <!-- FOOTER -->
            <?php include('../define/footer.php');?>
            <?php include('../define/setting.php');?>
        </div>
        <<!-- custom javascript -->
        <script src="../assign/js/main.js"></script>
        <script src="../assign/js/form-elements.js"></script>
        <script>
            jQuery(document).ready(function(){
                Main.init();
                FormElement.init();
            });
        </script>
        <script>
            function userAvailability(){
                $("#loaderIcon").show();
                jQuery.ajax({
                    url: "checkAvailability.php",
                    data: 'email='+$('#email').val(),
                    $type: "POST",
                    success:function(data)
                    {
                        $("user-availability-status").html(data);
                        $("#loaderIcon").hide();
                    },
                    error:function(){}
                });
            }
        </script>
    </body>
</html>
