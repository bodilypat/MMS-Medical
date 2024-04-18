<?php
     session_start();
     include('../include/config.php');
     include('../include/checkLoing.php');
     check_login();
     if(isset($_POST['submit']))
     {
         $docSpecial=$_POST['doctorSpecial'];
         $docid=$_POST['doctor'];
         $userid=$_SESSION['id'];
         $docFees=$_POST['fees'];
         $appDate=$_POST['appdate'];
         $appTime=$_POST['apptime'];
         $userStatus=1;
         $docStatus=1;
         $qApp=mysqli_query($deal,"INSERT INTO appointment(doctorSpecial,doctorId, userId, consulatancyFees, appointmentDate, appointmentTime,userStatus, doctorStatus)
                                   VALUES('$docSpecial','$docId','$userID','$docFees','$appDate','$appTime','$userStatus','$docStatus')");
         if($qApp)
         {
             echo "<script>alert('Your appointment successfully booked');<script>";
         }
     }
?>
<!DOCTYPE html>
<html lang="en">
      <head>
            <title>User | Book Appointment</title>
            <!-- css -->
            <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
            <link rel="stylesheet" href="../assets/css/font/font-awesome.min.css">
            <link rel="stylesheet" href="../assets/css/themify-icons.min.css">
            <!-- css custom -->
            <link rel="stylesheet" href="../assets/css/custom/styles.css">
            <link rel="stylesheet" href="../assets/css/custom/plugins.css">
            <link rel="stylesheet" href="../assets/css/custom/theme-1.css" id="skin_color">
            <!-- css media -->
            <link rel="stylesheet" media="screen" href="../assets/css/media/animate.min.css">
            <link rel="stylesheet" media="screen" href="../assets/css/media/perfect-scrollbar.min.css">
            <link rel="stylesheet" media="screen" href="../assets/css/media/switchery.min.css">
            <link rel="stylesheet" media="screen" href="../assets/css/media/jquery.bootstrap-touchspin.min.css">
            <link rel="stylesheet" media="screen" href="../assets/css/media/sselect2.min.css">
            <link rel="stylesheet" media="screen" href="../assets/css/media/bootstrap-datepicker3.standalone.min.css">
            <link rel="stylesheet" media="screen" href="../assets/css/media/bootstrap-timepicker.min.css">
    <script>
        function getdoctor()
        {
            $.ajax({
                type="POST",
                url: "POST",
                data: 'specialization='+val(),
                success: function(data)
                {
                    $("#doctor").html(data);
                }
            });
        }
    </script>
    <script>
           function getfee(val){
                   $.ajax({
                       type: "POST",
                       url: "getDoctor.php",
                       data: 'doctor='+val,
                       success: function(data) {
                            $("#fees").html(data);
                       }
                   });
           }
    </script>
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
                                               <h1 class="mainTitle">User | Book Appointment</h1>
                                          </div>
                                          <ol>
                                                <li><span>User</span></li>
                                                <li class="active"><span>Book Appointment</span></li>
                                          </ol>
                                    </div>
                             </section>
                             <div class="container-fluid container-fullw bg-white">
                                  <div class="row">
                                        <div class="col-md-12">
                                              <div class="row margin-top-30">
                                                    <div class="col-lg-8 col-md-12">
                                                          <div class="panel panel-white">
                                                                <div class="panel-heading">
                                                                     <h5 class="panel-title">Book appointment</h5>
                                                                </div>
                                                                <div class="panel-body">
                                                                     <p style="color:read;">
                                                                          <?php echo htmlentities($_SESSION[msg]);?>
                                                                          <?php echo htmlentities($_SESSION[msg]="");?>
                                                                     </p>
                                                                     <form name="book" method="post" role="form">
                                                                           <div class="form-group">
                                                                                <lable for="DoctorSpecial">Doctor Specialization</label>
                                                                                <select name="docSpecial" class="form-control" 
                                                                                        onChange="getdoctor(this.value);" required="required">
                                                                                    <?php $qDocs=mysqli_query($deal,"SELECT * 
                                                                                                                     FROM dSepcialization");
                                                                                          while($resultds=mysqli_fetch_array($qdocs))
                                                                                          {
                                                                                    ?>  
                                                                                        <option value="<?php echo htmlentities($resultds['specialization']);?>">
                                                                                                 <?php echo htmlentities($resultds['specialization']);?>
                                                                                        </option>
                                                                                    <?php    
                                                                                          }
                                                                                        ?>
                                                                                </select>
                                                                           </div>
                                                                           <div class="form-group">
                                                                                <label for="doctor">Doctor</label>
                                                                                <select id="doctor" name="doctor" class="form-control" 
                                                                                        onChange="getfee(this.value);" required="required">
                                                                                        <option value="">Select Doctor</option>
                                                                                      <?php 
                                                                                           $qDocs=mysqli_query($deal,"SELECT *
                                                                                                                      FROM doctors");
                                                                                            while($resultdoc=mysqli_fetch_array($qDoc))
                                                                                            {
                                                                                    ?>
                                                                                        <option value="<?php echo htmlentities($resultdoc['docName']);?>">
                                                                                                <?php echo htmlentities($resultdoc['docName']);?>
                                                                                        </option>
                                                                                    <?php
                                                                                            }
                                                                                        ?>
                                                                                </section>
                                                                           </div>
                                                                           <div class="form-group">
                                                                                <label for="ConsultancyFees">Consultancy fees</label>
                                                                                <select id="fees" name="consultfees" class="form-control" readonly></select>
                                                                           </div>
                                                                           <div class="form-group">
                                                                                 <label for="appointmentDate">Date</label>
                                                                                 <input name="appdate" class="form-control datepicker" required="required"
                                                                                        data-date-format="yyyy-mm-dd">
                                                                           </div>
                                                                           <div class="form-group">
                                                                                 <label for="AppointmentTime">Time</label>
                                                                                 <inpt name="apptime" id="timepicker" class="form-control" 
                                                                                       required="required">eg : 10: PM
                                                                           </div>
                                                                           <button name="Submit" type="Submit" class="btn brn-o btn-primary">Submit</button>
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
      <script src="../compose/js/selects.min.js"></script>

      <!-- javascript -->
      <script src="../compose/js/main.js"></script>
      <script src="../compose/form-elements.js"></script>
      <script>
              jQuery(document).ready(function() {
                  Main.init();
                  FormElements.init();
              });
              $('.datapicker').datepicker({
                  format:'yyyy-mm-dd',
                  startDate:'-3d'
              });
      </script>
      <script type="text/javascript">
            $('#timepicker1').timepicker();
      </script>
</body>
</html>