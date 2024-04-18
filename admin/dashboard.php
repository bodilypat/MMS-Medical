<?php 
    session_start();
    error_reporting(0);
    include('../include/config.php');
    if(strlen($_SESSION['id']==0))
    {
         header('location:logout.php');
    } else {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
          <title>Admin | Dashboard</title>
          <link rel="stylesheet" type="text/css" hrf="">
          <!-- css -->
          <link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
          <link rel="stylesheet" href="../assets/css/font/font-awesome.min.css">
          <link rel="styelsheet" href="../assets/css/themify/themify-incons.min.css">
          <!-- css custom -->
          <link rel="stylesheet" href="../assets/css/custom/styles.com">
          <link rel="stylesheet" href="../assets/css/custom/plugins.css">
          <link rel="stylesheet" href="../assets/css/custom/theme-1.css" id="skid_color" />
          <!-- css media -->
          <link rel="stylesheet" media="screen" href="../assets/css/animation.min.css">
          <link rel="stylesheet" media="screen" href="../assets/css/perfect-scrollbar.min.css">
          <link rel="stylesheet" media="screen" href="../assets/css/switchery.min.css">
          <link rel="stylesheet" media="screen" href="../assets/css/jquery.bootstrap-touchspin.min.css">
          <link rel="stylesheet" media="screen" href="../assets/css/select2.min.css">
          <link rel="stylesheet" media="screen" href="../assets/css/bootstrap-datepicker.standalone.min.css">
          <link rel="stylesheet" media="screen" href="../assets/css/bootstrap-timepicker.min.css">

    </head>
<body>
      <div id="application">
            <?php include('../include/sidebar.php');?>
            <div class="application-content">
                  <?php include('../include/header.php');?>
                  <div class="main-content">
                        <div class="wrap-content container" id="container">
                            <!-- title -->
                              <section id="page-title">
                                     <div class="row">
                                           <div class="col-sm-8">
                                                <h1 class="mainTitle">Admin | Dashboard</h1>
                                           </div>
                                           <ol class="breadcrumb">
                                                <li><span>Admin</span></li>
                                                <li class="active"><span>Dashboard</span></li>
                                           </ol>
                                     </div>
                              </section>
                              <!-- content -->
                              <div class="container-fluid container-fullw bg-blue">
                                    <div class="row">
                                          <div class="col-sm-4">
                                                <div class="panel panel-white no-radius text-center">
                                                     <div class="panel-body">
                                                           <span class="fa-stack fa-2x">
                                                                 <i class="fa fa-square fa-stack-2x text-primary"></i>
                                                                 <i class="fa fa-smaile-o fa-stack-1x fa-inverse"></i>
                                                           </span>
                                                           <h2 class="StepTitle">Manage User</h2>
                                                           <p class="links cl-effect-1">
                                                               <a href="operateeUser.php">
                                                                    <?php 
                                                                         $qUser=mysqli_query($deal,"SELECT * FROM users ");
                                                                         $numUser=mysqli_num_rows($qUser);
                                                                         {
                                                                    ?>
                                                                            Total Users :<?php echo htmlentities($numUser); } ?>                                                                         
                                                               </a>
                                                           </p>
                                                     </div>                                                     
                                                </div>
                                          </div>
                                          <div class="col-sm-4">
                                               <div class="panel panel-white no-rdius text-center">
                                                    <div class="pannel-body">
                                                         <span class="fa-stack fa-2x">
                                                               <i class="fa fa-square fa-stack-2x text-primary"></i>
                                                               <i class="fa fa-users fa-stack-1x fa-inverse"></i>
                                                         </span>
                                                         <h2 class="StepTitle">Manage Doctors</h2>
                                                         <p class="cl-effect-1">
                                                              <a href="operateDoctors.php">
                                                                  <?php 
                                                                       $qDoc=mysqli_query($deal,"SELECT * FROM doctors ");
                                                                       $numDoc=mysqli_num_rows($qDoc);
                                                                       {
                                                                    ?>    Total Doctors :<?php echo htmlentities($numDoc); 
                                                                       } ?>
                                                              </a>
                                                         </p>
                                                    </div>
                                                </div>
                                          </div>                                            
                                          <div class="col-sm-4">
                                                <div class="panel panel-white no-radius text-center">
                                                      <div class="panel-body">
                                                            <span class="fa-stack fa-2x">
                                                                     <i class="fa fa-square fa-stack-2x text-primary"></i>
                                                                     <i class="fa fa-terminal fa-stack-1x fa-inverse"></i>
                                                            </span>
                                                            <h2 class="mainTitle">Appointments</h2>
                                                            <p class="links cl-effect-1">
                                                                  <a href="bookAppointment.php">
                                                                        <?php 
                                                                             $qApp=mysqli_query($deal,"SELECT * FROM appointment");
                                                                             $numApp=mysqli_num_rows($qApp);
                                                                             {
                                                                        ?>
                                                                                Total Appointment:<?php echo htmlentities($numApp); 
                                                                             } ?>
                                                                  </a>
                                                            </p>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col-sm-4">
                                                <div class="fanel panel-white no-radius text-center">
                                                      <div class="panel-body">
                                                            <span class="fa-stack fa-2x">
                                                                  <i class="fa-stack fa-stack-2x text-primary"></i>
                                                                  <i class="fa fa-smile-o fa-stack-1x"></i>
                                                            </span>
                                                            <h2 class="Steptitle">Manage Patient</h2>
                                                            <p class="links cl-effect-1">
                                                                  <a href="operatePatient.php">
                                                                  <?php 
                                                                        $qPat=mysqli_query($deal,"SELECT * FROM tblpatient ");
                                                                        $numPat=mysqli_num_rows($qPat);
                                                                        {
                                                                    ?>
                                                                        Total Patients:<?php echo htmentities($numPat);
                                                                        } ?>
                                                                    </a>
                                                            </p>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="col-sm-4">
                                                  <div class="panel panel-white no-radius text-center">
                                                         <div class="fa-stack fa-2x">
                                                              <span class="fa-stack fa-2x">
                                                                    <i class="ti-file fa-1x text-primary"></i>
                                                                    <i class="fa fa-terminal fa-stack-1x fa-inverse"></i>
                                                              </span>
                                                              <h2 class="StepTitle">New Quaries</h2>
                                                              <p class="links cl-effect-1">
                                                                   <a href="bookAppointment.php">
                                                                       <a href="unreadQueries.php">
                                                                           <?php
                                                                                $qRead=mysqli_query($deal,"SELECT * FROM tblcontactus 
                                                                                                           WHERE IsRead is null ");
                                                                            ?>
                                                                            Total New Queries: <?php echo htmlentities($numRead);?>
                                                                       </a>
                                                                   </a>
                                                              </p>
                                                         </div>
                                                    </div>
                                               </div>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
            <!-- footer -->
            <?php include('../include/footer.php');?>
            <?php include('../include/setting.php');?>
      </div>
      <!-- javascript -->
      <script src="../compose/js/jquery.min.js"></script>
      <script src="../compose/js/bootstrap.min.js"></script>
      <script src="../compose/js/modernizr.js"></script>
      <script src="../compose/js/jquery.cookie.js"></script>
      <script src="../compose/js/perfect-scrollbar.min.js"></script>
      <script src="../compose/js/switchery.min.js"></script>
      <script src="../compose/js/jquery.maskedinput.min.js"></script>
      <script src="../compose/js/jquery.bootstrap-touchspin.min.js"></script>
      <script src="../compose/js/autosize.min.js"></script>
      <script src="../compose/js/classie.js"></script>
      <script src="../compose/js/selectFx.js"></script>
      <script src="../compose/js/select2.min.js"></script>
      <script src="../compose/js/bootstrap-datepicker.min.js"></script>
      <script src="../compose/js/bootstrap-tiempicker.min.js"></script>
      <!-- js custom -->
      <script src="../compose/js/main.js"></script>
      <script src="../compose/js/form-eleements.js"></script>
      <script>
             jQuery(document).ready(function() {
                Main.init();
                FormElements.init();
             });
      </script>
</body>
</html>
<?php
    }
?>
