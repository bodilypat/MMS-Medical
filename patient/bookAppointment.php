<?php
    session_start();
    include('../define/config.php');
    include('../define/checkLogin.php');
    check_login();
    if(isset($_POST['submit']))
    {
        $docSpecialized=$_POST['doctorspecial'];
        $docid=$_POST['doctor'];
        $userid=$_POST['user'];
        $docConsult=$_POST['consultfees'];
        $appDate=$_POST['appointmentdate'];
        $appTime=$_POST['appointmenttime'];
        $uStatus=1;
        $docStatus=1;

        $qAdd=mysqli_query($deal,"INSERT INTO appointment(doctorSpecial,doctorId, userId,consultFees, appoinDate, appointTime,userStatus,doctorstatus)
                                    VALUES('$docSpecial','$docid','$userid','$docConsult','$appDate','$appTime',$uStataus','$docStatus')");
        if($qAdd)
        {
            echo "<script>alert('Your appointment successfully booled');</script>"
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>User | Book Appointment</title>
        <!-- custom style -->
        <link rel="styelsheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/theme/theme-1.css" id="skin_color /">
        <script>
            function getDoctor(val)
            {
                $.ajax({
                    url:"getDoctor.php",
                    data: 'specialized='+val,
                    success: function(data){
                        $("#doctor").html(data);
                    }
                });
            }
        </script>
        <script>
            function getFees(val){
            $.ajax({
                type: "POST",
                url: 'getDoctot.php',
                data:'doctor='+val(),
                success: function(data){
                    $("#consultFees").html(data);
                }
            });
        }
        </script>
    </head>
    <body>
        <div id="application">
            <div class="application-content">
                <?php include('../define/sidebar.php');?>
                <div class="main-content">
                    <div class="wrap-content container" id="container">
                         <!-- section: page title -->
                         <section id="page-title">
                               <div class="row">
                                    <div clas="col-sm-8"><h1 class="mainTitle">User | Book Appointment</h1></div>
                               </div>
                               <ol>
                                    <li><span>User</span></li>
                                    <li class="active"><span>Book Appointment</span></li>
                               </ol>
                         </section>
                         <!-- content -->
                         <div class="container-fluid container-fullw bg-white">
                              <div class="row">
                                    <div class="col-md-12">
                                         <div class="row margin-top-30">
                                               <div class="col-lg-8 col-md-12">
                                                    <div class="panel panel-white">
                                                         <div class="panel heading"><h5 class="panel-title">Book Appointment</div>
                                                    </div>
                                                    <div class="panel-body">
                                                        <p style="color:red;">
                                                            <?php echo htmlentities($_SESSION['msg']);?>
                                                            <?php echo htmlentities($_SESSION['msg']=="");?>
                                                        </p> 
                                                        <form name="book-app" role="form" method="post">
                                                            <div class="form-group">
                                                                <label for="DoctorSpecial">Doctor Specialization </label>
                                                                <select name="doctorspecial" class="form-control" 
                                                                        onChange="getDoctor(this.value);" required="required">
                                                                    <option value="">Select Specialization</option>
                                                                        <?php $qDS=mysqli_query($deal,"SELECT * FROM doctorSpecialized");
                                                                            while($resultds=mysqli_fetch_array($qDS))
                                                                            {
                                                                        ?>
                                                                    <option value="<?php echo htmlentities($resultds['specialized']); ?>">
                                                                        <?php echo htmlentities($resultds['specialized']); ?>
                                                                    </option>
                                                                    <?php  } ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Doctor">Doctors</label>
                                                                <select name="doctor" class="form-control" 
                                                                        onChange="getfee(this.value);" required="required">
                                                                    <option value="">Select Doctor</option>
                                                                        <?php $qDoc=mysqli_query($deal,"SELECT * FROM doctors");
                                                                              while($resultdoc=mysqli_fetch_array($qDoc))
                                                                              {
                                                                        ?>
                                                                    <option value="<?php echo htmlentities($resultdoc['doctorName']); ?>">
                                                                        <?php echo htmlentities($resultdoc['doctorName']); ?>
                                                                    </option>
                                                                        <?php  } ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ConsultFee">Consultancy Fees</label>
                                                                <input name="consultfees" id="form-control" class="form-control" required="required" >
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Appointmention">Apointment Date</label>
                                                                <input name="appointdate" class="form-control datepicker" data-date-formate="yyyy-mm-dd">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="AppointmentTime">Appointment Time</label>
                                                                <input name="appointtime" id="timepicker1" class="form-control" required="required">
                                                            </div>
                                                            <button name="submit" type="submit" class="btn btn-o btn-primary">
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
            <!-- FOOTER -->
            <?php include('../define/footer.php');?>
            <?php include('../define/setting.php');?>
        </div>
        <!-- javascript -->
        <script src="../assign/js/main.js"></script>
        <script src="../assign/js/form-elements.js"></script>
        <script>
            jQuery(document).ready(function(){
                Main.init();
                FormElement.init();
            });
            $('.datapicker').datepicker({})
        </script>
    </body>
</html>