<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(strlen($_SESSION['id']==0)) {
        header('location:logout.php');
    } else {
        if(isset($_POST['submit'])) {
            $docID = $_SESSION['id'];
            $patName = $_POST['patientname'];
            $patContactno = $_POST['patcontact'];
            $patEmail = $_POST['patientemail'];
            $patGender = $_POST['gender'];
            $patAddress = $_POST['patientaddress']
            $patAge = $_POST['patientage'];
            $patMDH = $_POST['medicalpress'];

            $addPat = mysqli_query($deal,"INSERT INTO patients(docid, patientName, patientContno, patientEmail, patientGender, patientAdd, patientAge, patientMedhis)
                                          VALUES('$docID','$patName','$patContactno','$patEmail','$patGender','$patAge','$patMDH' ");
            if($addPat) {
                echo "<script>alert('Patient info added Successfully ');</script>";
                header('location:addPatient.php');
            }
        }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Add Patient | Doctor</title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color" />
        <script>
            function userAvailability() {
                $('#loaderIcon').show();
                jQuery.jax({
                    url : "checkAvailability.php",
                    data : 'email=' + $('#patEmail').val(),
                    type : "POST",
                    success : function(data) {
                        $('#user-availability-status').html(data);
                        $('#loaderIcon').hide();
                    },
                    error : function() {}
                });
            }
        </script>
    </head>
<body>
    <div id="app">
        <?php include('../define/sidebar.php');?>
        <div class="app-content">
            <?php include('../define/header.php');?>
            <div class="main-content">
                <div class="wrap-content container" id="container"></div>
                <!-- page title -->
                <section id="page-title">
                    <div class="row">
                        <div class="col-sm-8"><h1 class="mainTitle">Patient | Add Patient</h1></div>
                        <ol class="breadcrumb">
                             <li><span>Patient</span></li>
                             <li class="active"><span>Add Patient</span></li>
                        </ol>
                    </div>
                </section>
                <!-- page content -->
                <div class="Container-fluid container-full bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row margin-top-30">
                                <div class="col-lg-8 col-md-12">
                                    <div class="panel panel-white">
                                        <div class="panel-heading"><h5 class="page-title">Add Patient</h5></div>
                                        <div class="panel-body">
                                            <form name="formPatient" role="form" method="post">
                                                <div class="form-group">
                                                    <label for="PatientName">Full Name</label>
                                                    <input type="text" name="patientname" class="form-control" placeholder="Patient Name" required="true">
                                                </div>
                                                <div class="form-group">
                                                    <lable for="PatientContact">Contact Number</label>
                                                    <input type="text" name="patientcontact" class="form-control" placeholder="Contact Number" required="true" maxlength="10" pattern="[0-9]+">
                                                </div>
                                                <div class="form-group">
                                                    <label for="PatientEmail">Email</label>
                                                    <input type="email" id="patientemail" class="form-control" placeholder="Email" required="true" onBlur="userAvailability()">
                                                    <span id="user-avalability-status" style="font-size:12px;"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="block" for="Gender">Gender</label>
                                                    <div class="clip-radio radio-primary" >
                                                          <input type="radio" id="rg-female" name="gender" value="female">
                                                          <label for="rg-female">Female</label>
                                                          <input type="radio" id="male" name="gender" value="male">
                                                          <label for="rg-male">Male</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="PatientAddress">Address</label>
                                                    <textarea name="patientaddress" class="form-control" placeholder="Address" required="true"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="PatientAe">Age</label>
                                                    <input type="text" name="patientage" class="form-control" placholder="Patient Age" required="true">
                                                </div>
                                                <div class="form-group">
                                                    <label for="MedicalHistory">Medical History</label>
                                                    <textarea type="text" name="medicalpress" class="form-control" placeholder="Patient Medical History(if any)" required="true"></textarea>
                                                </div>
                                                <button type="submit" name="submit" id="submit" class="btn-btn-o btn-primary">Add</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="panel panel-white"></div>
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