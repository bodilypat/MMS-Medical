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
          <title>Admin | View Patients</title>
          <!-- css -->
          <link rel="stylesheet" type="text/css" href="">
          <link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
          <link rel="stylesheet" href="../assets/css/font/font-awesome.min.css">
          <link rel="stylesheet" href="../assets/css/themify/themify-cons.min.css">
          <!-- css custom -->
          <link rel="stylesheet" href="../assets/css/styles.css">
          <link rel="stylesheet" href="../assets/css/plugins.css">
          <link rel="stylesheet" href="../assets/css/theme/theme-1.css" id="skin_color">
          <!-- css media -->
          <link rel="stylesheet" href="../assets/css/animate.min.css">
          <link rel="stylesheet" href="../assets/css/perfect-scrollbar.min.css">
          <link rel="stylesheet" href="../assets/css/switchery.min.css">
          <link rel="stylesheet" href="../assets/css/jquery.bootstrap-touchspin.min.css">
          <link rel="stylesheet" href="../assets/css/select2.min.css">
          <link rel="stylesheet" href="../assets/css/bootstrap-datepicker.min.css">
          <link rel="stylesheet" href="../assets/css/bootstrap-timepicker.min.css">

    </head>
<body>
      <div id="application">
            <?php include('../include/sidebar.php');?>
            <div class="application-content">
                  <?php include('../include/header.php');?>
                  <div class="main-content">
                        <div id="container" class="wrap-content container">
                              <!-- page title -->
                              <section id="section">
                                    <div class="row">
                                            <div class="col-sm-8">
                                                <h1 class="mainTitle"><span>Admin | View Patients</span></h1>
                                            </div>
                                            <ol>
                                                <li><span>Admin</span></li>
                                                <li class="active"><span>View Patients</span></li>
                                            </ol>
                                    </div>
                              </section> 
                              <!-- content --> 
                              <div class="container-fluid container-fullw bg-white">
                                    <div class="row">
                                          <div class="col-md-12">
                                                <h5 class="over-title margin-bottom-15">View<span class="text-bold">Patients</h5>
                                                <table id="infoPatient" class="table table-hover">
                                                       <thead>
                                                               <tr>
                                                                    <th class="center">#</th>
                                                                    <th>Patient Name</th>
                                                                    <th>Patient Contact number</th>
                                                                    <th>Patient Gender</th>
                                                                    <th>Creation Date</th>
                                                                    <th>Updation Date</th>                                                                    
                                                                    <th>Action</th>
                                                               </tr>
                                                       </thead>
                                                       <tbody>
                                                           <?php 
                                                                $qPat=mysqli_query($deal,"SELECT * FROM tblpatient");
                                                                $count=1;
                                                                while($infopat=mysqli_fetch_array($qPat))
                                                                {
                                                            ?>  <tr>
                                                                     <td class="center"><?php echo $count;?>.</td>
                                                                     <td class="hidden-xs"><?php echo $infopat['PatientName'];?></td>
                                                                     <td><?php $infopat['PatientContno'];?></td>
                                                                     <td><?php $infopat['PatientGender'];?></td>
                                                                     <td><?php $infopat['CreationDate'];?></td>
                                                                     <td><?php $infopat['UpdationDate'];?></td>
                                                                     <td>
                                                                          <a href="viewPatient.php?viewid=<?php echo $infopat['ID'];?>">
                                                                             <i class="fa fa-eye"></i>
                                                                          </a>
                                                                     </td>
                                                                </tr>
                                                        <?php
                                                                }
                                                            ?>
                                                       </tbody>
                                                </table>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
            <!-- footer -->
            <?php include('../include/footer.php');?>
            <?php include('../incldue/setting.php');?>
      </div>
      <!-- javascript -->
      <script src="../compose/js/jquery.min.js"></script>
      <script src="../compose/js/bootstrap.min.js"></script>
      <script src="../compose/js/modernir.js"></script>
      <script src="../compose/js/jquery.cookie.js"></script>
      <script src="../compose/js/perfect-scrollbar.min.js"></script>
      <script src="../compose/js/switchery.min.js"></script>
      <script src="../compose/js/jquery.maskedinput.min.js"></script>
      <script src="../compose/js/jquery.bootstrap-touchspin.min.js"></script>
      <script src="../compose/js/autosize.min.js"></script>
      <script src="../compose/js/selectFx.js"></script>
      <script src="../compose/js/select2.min.js"></script>
      <script src="../compose/js/bootstrap-datepicker.min.js"></script>
      <script src="../compose/js/bootstrap-timepicker.min.js"></script>
      <!-- js custom -->
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