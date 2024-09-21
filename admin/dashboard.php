<?php
    session_start();
    error_report(0);
    include('../config/dbconnect.php');

    if(strlen($_SESSION['id'] ==0))
    {
        header('location:logout.php');
    } else {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Dashboard</title>
        <!-- custom css -->
        <link rel="stylesheet" href="../assets/css/styles.css">
        <link rel="stylesheet" href="../assets/css/plugins.css">
        <link rel="stylesheet" href="../assets/css/theme-1.css">
    </head>
<body>
<!-- section app -->
    <div id="app">
        <?php include('layouts/sidebar.php');?>
        <div class="app-content">
            <?php include('layouts/header.php');?>
            <div class="main-content">
                <div class="wrapper-content container" id="container">
                     <!-- PAGE TITLE -->
                    <section id="page-title">
                        <div class="row">
                              <div class="col-sm-8"><h1 class="mainTitle">Admin | Dashboard</div>
                              <ol class="breadcrumb">
                                   <li><span>Admin</span></li>
                                   <li class="active"><span>Dashboard</span></li>
                              </ol>
                        </div>
                    </section>
                    <!-- END PAGE TITLE -->
                    <div class="container-fluid container-full bg-white">
                        <div class="row">

                            <!-- Doctor panel -->
                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="fa fa-quare fa-stack-2x text-primary"></i>
                                            <i class="fa fa-smaile-0 fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">Manage Doctors</h2>
                                        <p class="links cl-effect-1">
                                            <a href="Manage-doctors.php">
                                                <?php
                                                    $qDoc = mysqli_query($deal,"SELECT * FROM doctors");
                                                    $numRows = mysqli_num_rows($qDoc)
                                                    {
                                                ?>
                                                        Total Doctors : <?php echo htmlentities($numRows); 
                                                    } ?>
                                            </a>                                                     
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Appointment panel -->
                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                                            <i class="fa fa-smail-o fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">Manage Appointments</h2>
                                        <p class="links cl-effect-1">
                                            <a href="manage-appointments.php">
                                                <?php
                                                    $qApp = mysqli_query($deal,"SELECT * FROM appointments");
                                                    $numRows = mysqli_num_rows($qApp)
                                                    {
                                                ?>
                                                    Total Appointments = <?php echo htmlentities($numRows);
                                                    }  ?>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Patient panel  -->
                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                                            <i class="fa fa-smail-o fa-stack-1 fa-inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">Manage Patients</h2>
                                        <p class="links cl-effect-1">
                                            <a href="manage-patients.php">
                                                <?php 
                                                    $qPat = mysqli_query($deal,"SELECT * FROM patients");
                                                    $numRows = mysqli_num_rows($qPat)
                                                    {
                                                ?>
                                                    Total Patients = <?php echo htmlentities($numRows);
                                                    } ?>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>                            
                            <!-- Prescription panel -->
                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                                            <i class="fa fa-smaile-o fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">Manage Medical Records</h2>
                                        <p class="links cl-effect-1">
                                            <a href="manage-medical-records.php">
                                                <?php
                                                    $qMd = mysqli_query($deal,"SELECT * FROM medical_records");
                                                    $numRows = mysqli_num_rows($qMd)
                                                    {
                                                ?>
                                                    Total Medical-records = <?php echo htmlentities($numRows)
                                                    } ?>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Prescription panel -->
                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span>
                                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                                            <i class="fa fa-smail-0 fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">Manage Prescriptions</h2>
                                        <p class="links effect-1">
                                            <a href="manage-prescriptions.php">
                                                <?php 
                                                    $qPre = mysqli_query($deal,"SELECT * FROM prescriptions");
                                                    $numRows = mysqli_num_rows($qPre)
                                                    {
                                                ?>
                                                    Total Prescriptions = <?php echo htmlentities($qPre);
                                                    } ?>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Billings panal -->
                            <div class="panel panel-white no-radius text-center">
                                <div class="panel-body">
                                    <span>
                                        <i class="fa fa-squire fa-stack-2x text-center"></i>
                                        <i class="fa fa-smail-o fa-stack-1x fa-inverse"></i>
                                    </span>
                                    <h2 class="StepTitle">Manage Billings</h2>
                                    <p class="links effect-1">
                                        <a href="manage-billings.php">
                                            <?php
                                                $qBil = mysqli_query($deal,"SELECT * FROM billings");
                                                $numRows = mysqli_num_rows($qBil)
                                                {
                                            ?>
                                                Totol Billings = <?php echo htmlentities($qBil);
                                                } ?>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('layouts/footer.php');?>
        <?php include('layouts/setting.php');?>
    </div>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/form-elements.js"></script>
    <script>
        jQuery(document).ready(function(){
            Main.init();
            Form-elements.init();
        });
    </script>
</body>
</html>
<?php
    }
?>