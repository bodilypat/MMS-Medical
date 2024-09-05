<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(strlen($_SESSION['id']==0)) {
        header('location:logout.php');
    } else {
        if(isset($_POST['submit'])) {
            $editID = $_GET['editid'];
            $patName = $_POST['patientname'];
            $patContact = $_POST['ontactnumber'];
            $patEmail = $_POST['email'];
            $patGender = $_POST['gender'];
            $patAddress = $_POST['address'];
            $patAge = $_POST['patientage'];
            $patMedhis = $_POST['medicalhis'];

            $editPat = mysqli_query($deal,"UPDATE SET patientName = '$patName',
                                                   patientContact = '$patContact',
                                                   patientEmail = '$patEmail',
                                                   patientGender = '$patGender',
                                                   patientAddress = '$patAddress',
                                                   patientAge = '$patAge',
                                                   patientMedhis = '$patMedhis' 
                                        WHERE ID= '$editID' ");
            if($editPat){
                echo "<script>alert('Patient infoo updated successfully')</script>";
                header('location: managePatient');
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Doctor | Edit Patient</title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color" />
    </head>
<body>
    <div id="app">
        <?php include('../define/sidebar.php');?>
        <div class="app-content">
            <?php include('../define/heade.php');?>
            <div class="main-content">
                <div class="wrap content container" id="contaienr">
                    <!-- page title -->
                    <section class="page-title">
                        <div class="row">
                            <div class="col-sm-8"><h1 class="mainTitle"> Patient | Edit Patient</h1></div>
                            <ol class="breadcrumb">
                                <li><span>Patient</span></li>
                                <li class="active"><span>Edit Patient</span></li>
                            </ol>
                        </div>
                    </section>
                    <!-- page content -->
                    <div class="container-fluid container-full bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row margin-top-30">
                                    <div class="col-lg-8 col-md-12">
                                        <div class="panel panel-white">
                                            <div class="panel-heading"><h5 class="panel-title">Edit Patient</h5></div>
                                            <div class="panel-body">
                                                <form name="patientForm" role="form" method="post">
                                                <?php
                                                    $editID = $_GET['editid'];
                                                    $qPat = mysqli_query($deal,"SELECT * FROM patients WHERE ID= '$editID' ");
                                                    $count = 1;
                                                    while($result = mysqli_fetch_array($qPat)){
                                                ?>
                                                    <div class="form-group">
                                                        <label for="PatientName">Full Name </label>
                                                        <input type="text" name="patientname" class="form-control" 
                                                            value="<?php echo $result['patientName'];?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="PatientContact">Contact Number</label>
                                                        <input type="text" name="contactNumber" class="form-control" 
                                                            value="<?php echo $result['patientContact'];?>" required="true" maxlength="10" pattern="[0-9]+">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="PatientEmail">Email</label>
                                                        <input type="email" name="email" class="form-control" 
                                                            value="<?php echo $result['patientEmail'];?>" readonly="true">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label" for="Gender">Gender:</label>
                                                        <?php if($result['patientGenger']=="female") { ?> 
                                                            <input type="radio" name="gender" id="gender" value="female" checked="true">Female
                                                            <input type="radio" name="gender" id="gender" value="malle">Male
                                                        <?php } ?>
                                                        <label>
                                                            <input type="radio" name="gender" id="gender" value="female" checked="true">Female
                                                            <input type="radio" name="gender" id="gender" value="male" checked="true">Male
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="PatientAddress">Address</label> 
                                                        <textarea name="address" class="form-control" required="true">
                                                            <?php echo $result['patientAddress'];?>
                                                        </textarea>
                                                            
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="PatientAge">Age</label>
                                                        <input type="text" name="patientAge" class="form-control" required="true"
                                                            value="<?php echo $result['patientAge'];?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="MedicalHistory">Medical History</label>
                                                        <textarea type="text" name="medicalhis" class="form-control" placeholder="Medical History (if any) "required="true" >
                                                            <?php echo $result['patientMedhis'];?>
                                                        </textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Creation Date">Creation Date</label>
                                                        <input type="text" class="form-control" value="<?php echo $result['creationDate'];?>" readonly="true">
                                                    </div>
                                                     <?php    } ?>
                                                    <button type="submit" name="submit" id="submit" class="btn btn-o btn-primary">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-md-12">
                                <div class="panel panel-white"></div>
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