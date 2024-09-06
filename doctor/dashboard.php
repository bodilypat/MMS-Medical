<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(strlen($_SESSION['id']==0)) {
        header('location:logout.php');
    } else {
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Doctor | Dashboard</title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color">
    </head>
<body>
    <div id="app">
        <?php include('../define/sidebar.php');?>
        <div class="app-content">
            <?php include('../define/header.php');?>
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    <!-- page title -->
                    <select id="page-title">
                         <div class="row">
                             <ol class="breadcrumb"> 
                                  <li><span>User</span></li>
                                  <li class="active"><span>Dashboard</span></li>
                             </ol>
                         </div>
                    </section>
                    <!-- page content -->
                     <div class="container-fluid container-full bg-white">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="panel panel-white no-radius text-center">
                                        <span class="fa-stack fa-2x">
                                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                                            <i class="fa fa-smile-o fa-stack-1x fa-inverse"></i>                                            
                                        </span>
                                        <h2 class="StepTitle">My Profile</h2>
                                        <p class="links cl-effect-1">
                                            <a href="editProfile.php">Update Profile</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                          <div class="col-sm-4">
                               <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                         <span class="fa-stack fa-2x">
                                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                                            <i class="fa fa-paperclip fa-stack-1x fa-inverse"></i>
                                         </span>
                                         <h2 class="StepTitle">My Appointment</h2>
                                         <p class="cl-effect-1">
                                            <a href="appointmentHistory.php">Info appointment History</a>
                                         </p>
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
    <!-- custom javascript -->
    <script src="../assign/js/main.js"></script>
    <script src="../assign/js/formElements.js"></script>
    <script>
         jQuery(document).ready(function(){
            Main.init();
            FormElements.init();
         });
    </script>
</body>
</html>
<?php    } ?>