<?php
     session_start();
     error_reporting(0);
     include('../include/config.php');
     if(strlen('location:logout.php'))
     {
        header('location:logout.php');
     } else {
          if(isset($_POST['submit']))
          {
              $vid=$_GET['viewid'];

          }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
          <title>Doctor | manage Patient</title>
          <!-- css -->
          <link rel="stylesheet" type="text/css" href="">
          <link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
          <link rel="stylesheet" href="../assets/css/font/font-awesome.min.css">
          <link rel="stylesheet" href="../assets/css/themify/themify-icons.min.css">
          <!-- css custom -->
          <link rel="stylesheet" href="../assets/css/styles.css">
          <link rel="stylesheet" href="../assets/css/custom/plugins.css">
          <link rel="stylesheet" href="../assets/css/custom/theme-1.css" id="skin_color">
          <!-- css media -->
          <link rel="stylesheet" media="screen" href="../assets/css/animate.min.css">
          <link rel="stylesheet" media="screen" href="../assets/css/perfect-scrollbar.min.css">
          <link rel="stylesheet" media="screen" href="../assets/css/switchery.min.css">
          <link rel="stylesheet" media="screen" href="../assets/css/jquery.bootstrap-touchspin.min.css">
          <link rel="styelsheet" media="screen" href="../assets/css/select2.min.css">
          <link rel="stylesheet" media="screen" href="../assets/css/bootstrap-datepicker3.standalone.min.css">
          <link rel="stylesheet" media="screen" href="../assets/css/bootstrap-timepicker.min.css" >

    </head>
<body>
      <div id="application">
            <?php include('../include/sidebar.php');?>
            <div class="application-content">
                 <?php include('../include/header.php');?>
                <div class="main-content">
                      <div id="container" class="wrap-content container">
                        <!-- page title -->
                            <section id="page-title">
                                  <div class="row">
                                        <div class="col-sm-8">
                                              <h1 class="mainTitle">Doctor | manage Patients</h1>
                                        </div>
                                        <ol class="breadcrumb">
                                              <li><span>Doctor</span></li>
                                              <li class="active"><span>Manage Patients</span></li>
                                        </ol>
                                  </div>
                            </section>
                            <!-- content -->
                            <div class="container-fluid container-fullw bg-white">
                                  <div class="row">
                                        <div class="col-md-12">
                                              <h5></h5>
                                              <?php
                                                   $vid=$_GET['viewid'];
                                                   $qPat=mysqli_query($deal,"SELECT * FROM tblpatient WHERE ID='$vid'");
                                                   $count=1;
                                                   while($infoPat=mysqli_fetch_array($qPat))
                                                   {
                                                ?>
                                                <table class="table table-bordered" border="1">
                                                    <tr align="center">
                                                         <td colspan="4" style="font size:20px;color:blue">Patient Details</td>
                                                    </tr>
                                                    <tr>
                                                          <th scope>Patient Name</th>
                                                              <td><?php echo $infoPat['PatientName'];?></td>
                                                          <th scope>Patient Email</th>
                                                              <td><?php echo $infoPat['PatietEmail'];?></td>
                                                    </tr>
                                                    <tr>
                                                           <th scope>Patient Mobile Number</th>
                                                               <td><?php echo $infoPat['PatientContno'];?></td>
                                                            <th scope>Patient Address</th>
                                                                <td><?php echo $infoset['PatientAdd'];?></td>
                                                    </tr>
                                                    <tr>
                                                            <th>Patient Gender</th>
                                                                <td><?php echo $infoPat['PatientGender'];?></td>
                                                            <th>Patient Age</th>
                                                                <td><?php echo $infoPat['PatientAbe'];?></td>
                                                    </tr>
                                                    <tr>
                                                            <th>Patient Medical History</th>
                                                                <td><?php echo $infoPat['PatientMedhis'];?></td>
                                                            <th>Patient Reg Date</th>
                                                                <td><?php echo $infoPat['CreationDate'];?></td>
                                                    </tr>
                                            <?php   }?>
                                                </table>
                                                <?php
                                                     $qMedhis=mysqli_query($deal,"SELECT * 
                                                                                  FROM tblmedicalhistory 
                                                                                  WHERE PatientID='$vid' ");
                                                    ?>
                                                <table id="dataPatient" class="table table-bordered dt-responsive nowrap"
                                                       style="border-collapse: collapse; border-spacing:0; width:100%;">
                                                        <tr align="center">
                                                             <th colspan="8">Medical History</th>
                                                        </tr>
                                                        <tr>
                                                             <th>#</th>
                                                             <th>Blood Pressure</th>
                                                             <th>Weight</th>
                                                             <th>Blood Suger</th>
                                                             <th>Tempareture</th>
                                                             <th>Medical Prescription</th>
                                                             <th>Visit Date</th>
                                                        </tr>
                                                    <?php 
                                                        while($infomdh=mysqli_fetch_array($qMedhis))
                                                        {
                                                    ?>
                                                        <tr>
                                                             <td><?php echo $count;?></td>
                                                             <td><?php echo $infomdh['BloodPressure'];?></td>
                                                             <td><?php echo $infomdh['Weight'];?></td>
                                                             <td><?php echo $infomdh['BloodSuger'];?></td>
                                                             <td><?php echo $infomdh['Temperature'];?></td>
                                                             <td><?php echo $infomdh['MedicalPres'];?></td>
                                                             <td><?php echo $infomdh['CreationDate'];?></td>
                                                        </tr>
                                                    <?php $count=$count+1;
                                                        } ?>
                                                </table>
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
       <script src="../compose/js/jquery.boostrap-touchspin.min.js"></script>
       <script src="../compose/js/autosize.min.js"></script>
       <script src="../compose/js/selectFx.js"></script>
       <script src="../compose/js/select2.min.js"></script>
       <script src="../compose/js/bootstrap-datepicker.min.js"></script>
       <script src="../compose/js/bootstrap-timepicker.min.js"></script>
       <!-- javascript -->
       <script src="../compose/js/main.js"></script>
       <script src="../compose/js/form-elements.js"></script>
       <script>
             jQuery(document).ready(function(){
                 Main.init();
                 FormElements.init();
             });
       </script>
</body>
</html>
<?php
     }
?>