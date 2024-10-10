<?php
    session_start();
    error_report(0);
    include('../includes/functions.php');

    if(strlen($_SESSION['id'] ==0))
    {
        header('location:logout.php');
    } else {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Dashboard</title>
        <!-- Custom css -->
        <link rel="stylesheet" href="../asset/css/styles.css">
        <link rel="stylesheet" href="../asset/css/plugins.css">
        <link rel="stylesheet" href="../asset/css/theme-1.css">
    </head>
<body>
<!-- section app -->
    <div id="app">
        <!-- Outline: Navbar -->
        <?php include('../outlines/sidebar.php');?>
        <div class="app-content">
            <!-- Outline : Header -->
            <?php include('../outlines/header.php');?>
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
                                            <a href="manage_doctors.php">
                                                <?php
                                                    $qDoc = getDoctors();
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
                                            <a href="manage_appointments.php">
                                                <?php
                                                    $qApp = getAppointments();
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
                                        <h2 class="StepTitle">Manage Medical Records</h2>
                                        <p class="links cl-effect-1">
                                            <a href="manage_medical_records.php">
                                                <?php 
                                                    $qMdh = getMedicalRecords();
                                                    $numRows = mysqli_num_rows($qMdh)
                                                    {
                                                ?>
                                                    Total Medical Records = <?php echo htmlentities($numRows);
                                                    } ?>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>                            
                            <!-- Midical Records panel -->
                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                                            <i class="fa fa-smaile-o fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">Manage Prescriptions</h2>
                                        <p class="links cl-effect-1">
                                            <a href="manage_prescriptions.php">
                                                <?php
                                                    $qPre = getPrescriptions();
                                                    $numRows = mysqli_num_rows($qPre)
                                                    {
                                                ?>
                                                    Total Prescriptions = <?php echo htmlentities($numRows)
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
                                        <h2 class="StepTitle">Manage prescriptions</h2>
                                        <p class="links effect-1">
                                            <a href="manage_patients.php">
                                                <?php 
                                                    $qPre = getPatients();
                                                    $numRows = mysqli_num_rows($qPat)
                                                    {
                                                ?>
                                                    Total Patients = <?php echo htmlentities($qPat);
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
                                        <a href="manage_billings.php">
                                            <?php
                                                $qBil = getBills();
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
        <?php include('../outlines/footer.php');?>
        <?php include('../outlines/setting.php');?>
    </div>
    <script src="../asset/js/main.js"></script>
    <script src="../asset/js/form-elements.js"></script>
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