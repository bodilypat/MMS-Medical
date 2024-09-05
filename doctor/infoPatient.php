<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(strlen($_SESSION['id']==0)) {
        header('location:logout.php');
    } else {
        if(isset($_POST['submit'])) {
            $infoID = $_GET['infoid'];
            $bloodPressure = $_POST['bloodpressure'];
            $bloodSuger = $_POST['bloodsuger'];
            $weight = $_POST['weight'];
            $temperature = $_POST['temperature'];
            $medPress = $_POST['medicalpress'];

            $addMed = mysqli_query($deal,"INSERT INTO medicalHistory(patientID, bloodPressure, bloodSuger, weight, temperature, medicalPress)
                                        VALUES ('$infoID','$bloodPressure','$bloodSuger','$weight','$temparature','$medPress' ");
            if($addMed) {
                echo "<script>alert('Medical History has been added.');</script>";
                echo "script>window.location.href='managePatient'</script>";
            } else {
                echo "<script>alert('something went wrong. Please try again')</script>";
            }
        }
?>
<!DOCTYPE html> 
<html lang="en">
    <head>
        <title>Doctor | Info Patients<title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css " >
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color">
    </head>
<body>
    <div id="app">
        <?php include('../define/sidebar.php');?>
        <div class="app-content">
            <?php include('../define/header.php');?>
            <div class="main-content">
                <div class="wrap-centent container" id="container">
                    <!-- page title -->
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8"><h1 class="mainTitle">Doctor | Info Patients</h1></div>
                            <ol class="breadcrumb">
                                 <li><span>Doctor</span></li>
                                 <li class="active">Info Patients</li>
                            </ol>
                        </div>
                    </section>
                    <!-- page content -->
                    <div class="container-fluid container-full bg-white">
                        <div class="row">
                            <div clsss="col-d-12">
                                <h5 class="over-title margin-bottom-15">Info<span class="text-bold">Patient</span></h5>
                                <?php $infoID = $_GET['infoid'];
                                      $qPat = mysqli_query($deal,"SELECT * FORM patients WHERE ID = '$infoID' ");
                                      $count = 1;
                                      while($result = mysqli_fetch_array($qPat)) {
                                ?>
                                <table borderr="1" class="table table-bordered">
                                    <tr align = "center">
                                         <td colspan="4" style = "font-size:20px; color:bold">Patient Info</td>
                                    </tr>
                                    <tr>
                                         <th scope>Patient Name</th>
                                         <td><?php echo $result['patientName'];?>
                                         <th scope>Patient Email</th>
                                         <td><?php ech $result['patientEmail'];?>
                                    </tr>
                                    <tr>
                                         <th scope>Patient contact Number</th>
                                         <id><?php echo $result['patientContno'];?>
                                         <th>Patient Address</th>
                                         <td><?php echo $result['patientAddress'];?>
                                    </tr>
                                    <tr>
                                         <th>Patient Gender</th>
                                         <td><?php echo $result['patientGender'];?>
                                         <th>Patient Age</th>
                                         <td><?php echo $result['patientAge'];?>
                                    </tr>
                                    <tr>
                                         <th>Patient Medical History</th>
                                         <td><?php echo $result['patientMedhis'];?>
                                         <th>Patient Reg Date</th>
                                         <td><?php ecch $result['creationDate'];?></td>
                                    </tr>
                                    <?php } ?>
                                </table> 
                                <?php $qMdh = mysqli_query($deal,"SELECT * FROM medicalhistory WHERE patientID = '$infoID' "); ?>
                                <table id="datatable" clas="table table-bordered dt-responsive nowrap" style="border-collapse; border-specing:0; width : 100%;">
                                    <tr align="center">
                                         <th colspan="8">Medical History</th>
                                    </tr>
                                    <tr>
                                         <th>#</th>
                                         <th>Blood Pressure</th>
                                         <th>Weight</th>
                                         <th>Blood Suger</th>
                                         <th>Body Temperature</th>
                                         <th>Medical Prescription</th>
                                         <th>Visit Date</th>
                                    </tr>
                                    <tr><?php
                                            while($data=mysqli_fetch_array($qMdh)) {
                                        ?>
                                    <tr>
                                         <td><?php echo $count;?>.</td>
                                         <td><?php echo $data['bloodPressure'];?></td>
                                         <td><?php echo $data['weight'];?></td>
                                         <td><?php echo $data['bloodSuger'];?></td>
                                         <td><?php echo $data['temperature'];?></td>
                                         <td><?php echo $data['medicalPress'];?></td>
                                         <td><?php echo $data['creationDate'];?></td>
                                    </tr>
                                        <?php $count=$count+1; } ?>
                                </table>
                                <p align="center">
                                    <button class="btn btn-primary wave-effect wave-light w-lg" data-toggle="modal" data-target="#myModal">
                                        Add Medical History
                                    </button>
                                </p>
                                <?php ?>
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modallabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">                                                
                                                <h5 class="modal-title" id="modallabel">Add Medical History</h5>
                                                <button type="button" class="role" data-dismiss="modal" aria-label="Close">
                                                     <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-bordered table-hover data-tables">
                                                    <form method="post" name="submit">
                                                        <tr>
                                                             <th>Blood Pressure : </th>
                                                             <td><input name="bloodpressure" placeholder="Blood Pressure" class="form-control wd-400" required="true"></td>
                                                        </tr>
                                                        <tr>
                                                             <th>Blood Suger</th>
                                                             <td><input name="bloodsuger" placeholder="Blood Suger" class="form-control wd-450" required="true"></td>
                                                        </tr>
                                                        <tr>
                                                             <th>Weight : </th>
                                                             <td><input name="weight" placeholder="Weight" class="form-control wd-450" required="true"></td>
                                                        </tr>
                                                        <tr>
                                                             <th>Body Temperature</th>
                                                             <td><input name="temperature" placeholder="Blood Suger" class="form-control wd-450" required="true"></td>
                                                        </tr>
                                                        <tr>
                                                             <th>Prescription</th>
                                                             <td><textarea type="medicalprescription" placeholder="Medical Prescription" rows="14"  class="form-control wd-450" required="true"></textarea></td>
                                                        </tr>
                                                    </form>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                 <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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
        <?php include('../define/footer.php');?>
        <?php include('../define/setting.php');?>
    </div>
    <!-- custome javascript -->
    <script src="../assign/js/main.js"></script>
    <script srrc="../assign/js/formElements.js"></script>
    <script>
        jQuery(document).ready(function(){
            Main.init();
            FormElements.init();
        });
    </script>
</body>
</html>
<?php    } ?>