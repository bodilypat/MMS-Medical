<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(strlen($_SESSION['id'])) {
        header('location:logout.php')
    } else {
        if(isset($_POST['submit'])){
            $patID = $_GET['infoid'];
            $bloodPress = $_POST['bloodpressure']
            $bloodsu = $_POST['bloodsuger'];
            $weight = $_POST['weight'];
            $temparature = $_POS['temperature'];
            $medicalPress = $_POST['pressure']

            $addMDH = mysqli_query($deal,"INSERT INTO tblmedicalhistory(patientID, bloodPresure, bloodSuger, weight, temperature, medicalPressure)
                                          VALUES('$patID','$bloodPress','$bloodSu','$weight','$temperature','$medicalPress') ");
            if($addMDH) {
                echo "<script>alert('Medical history has been added.')</script>";
                echo "<script>window.location.href='managePatient.php'</script>";
            } else {
                echo '<script>alert ("Something Went Wrong. Please try again")</script>';
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Info Patient Management</title>
        <!-- custome style --> 
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="styelsheet" href="../assign/css/plugins.css">
        <link rel="Stylesheet" href="../assign/css/theme/theme-1.css" id="skin_color">
    </head>
<body>
    <div id="app">
        <?php include('../define/sidebar.pphp');?>
        <div clas="app-content">
            <?php include('../define/header.php');?>
            <div class="main-content">
                <div class="wrap-content cotanier" id="container">
                    <!-- page title -->
                    <section id="page-title">
                        <div class="row">
                             <div class="col-sm-8"><h1 class="mainTitle"> Admin | Manage Patient</h1></div>
                             <ol class="breadcrumb">
                                  <li><span>Admin</span></li>
                                  <li classs="active"><span>Manage Patient</span></li>
                             </ol>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                             <div class="col-md-12">
                                  <h5 class="over-title margin-bottom-15">Manage <span class="text-bold">Patient</span></h5>
                                <?php
                                    $qPat = mysqli_query($deal,"SELECT * FROM tblpatient WHERE ID ='$patID' ");
                                    $count = 1;
                                    while($result = mysqli_fetch_array($qPat)) {
                                ?>
                                <table bordor="1" class="table table-bordered">
                                    <tr align="center">
                                        <td colspan="4" style="font-size:20px;color:blue">Patient Details</td>
                                    </tr>
                                    <tr>
                                        <th scope>Patient Name</th>
                                        <td><?php echo $result['patientName'];?></td>
                                        <th scope>Patient Email</th>
                                        <td><?phpe cho $result['patientEmail'];?></td>                                        
                                    </tr>
                                    <tr>
                                        <th scope>Patient Contact no</th>
                                        <td><?php echo $result['patientContno'];?></td>
                                        <th>Patient Address</th>
                                        <td><?php echo $result['patientAddress'];?></td>
                                    </tr>
                                    <tr>
                                        <th>Patient Gender</th>
                                        <td><?php echo $result['patientGender'];?></td>
                                        <th>Patient Age</th>
                                        <td><?php echo $result['patientAge'];?></td>
                                    </tr>
                                    <tr>
                                        <th>Patient Medical History</th>
                                        <td><?php echo $result['patientMedhis'];?></td>
                                        <th>Patent Reg. Date</th>
                                        <td><?php echo $result['creationDate'];?></td>
                                    </tr>                                
                                    <?php $count = $count +1; } ?>
                                </table>
                                <?php 
                                    $qMDH = mysqli_query($deal,"SELECT * FROM tblmedicalhistory WHERE  patientID='$patID' ");
                                ?>
                                <table id="datatable" class="table table-bordered dt-responsive newrap" style="border-collapse; border-spacing:0; width: 100%;">
                                      <tr>
                                            <th colspan="8">Medical History</th>
                                      </tr>
                                      <tr>
                                            <th>#</th>
                                            <th>Blood Pressure</th>
                                            <th>Weight</th>
                                            <th>Blood Suger</th>
                                            <th>Temparature</th>
                                            <th>Medical Prescription</th>
                                            <th>Visit Date</th>
                                      </tr>
                                      <?php
                                          while($info=mysql_fetch_array($qMDH)){
                                      ?>
                                        <tr>
                                            <td><?php echo $count;?>.</td>
                                            <td><?php echo $info['bloodPressure'];?></td>
                                            <td><?php echo $info['weight'];?></td>
                                            <td><?php echo $info['bloodSuger'];?></td>
                                            <td><?php echo $info['temperature'];?></td>
                                            <td><?php echo $info['medicalPress'];?></td>
                                            <td><?php echo $info['creationDate'];?></td>
                                        </tr>
                                        <?php $count=$count+1;  } ?>
                                </table>
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
<?php  } ?>