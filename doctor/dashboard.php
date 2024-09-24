<?php
    session_start();
    error_reporting(0);
    include('../config/dbconnect.php');
    if(strlen($_SESSION['id'])){
        header('location:logout.php');
    } else {
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Doctor | Dashboard</title>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="../asset/css/styles.css">
    </head>
<body>
    <div id="app">
        <!-- Outline  -->
        <?php include('../layouts/sidebar.php');?>
        <div class="app-content">
            <?php include('../layouts/header');?>
            <!-- END: outline -->
            <div class="main-content">
                <div id="container" class="wrap-content container">
                    <!-- page title -->
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8"><h1 class="mainTitle">Doctor | Dashboard<h1></h1></div>
                            <ol class="breadcrumb">
                                 <li><span>Doctor</span></li>
                                 <li>Dashboard</li>
                            </ol>
                        </div>
                    </section>
                    <div class="container-fluid container-full bg-white">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                                            <i class="fa fa-smail-o fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2>medical records</h2>
                                        <p class="links cl-effect-1">
                                            <a href="manage-medical-record.php"></a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="fa fa-square fa-stack-2x text primary"></i>
                                            <i class="fa fa-smail-o fa-stack-1x inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">Appointment</h2>
                                        <p class="links cl-effect-1">
                                            <a href="manage-appointment.php"></a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa fa-stack-2x">
                                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                                            <i class="fa fa-smail-o fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">Prescription</h2>
                                        <p class="links cl-effect-1">
                                            <a href="manage-prescription.php"></a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa fa-stack-2x">
                                             <i class="fa fa-square fa-stack-2x text-primary"></i>
                                             <i class="fa fa-samil-o fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2>Doctors</h2>
                                        <p class="links cl-effect-1">
                                            <a href="manage-patients.php"></a>
                                        </p>        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                         <span class="fa fa-stack-2x">
                                              <i class="fa fa-square fa-stack-2x text-primary"></i>
                                              <i class="fa fa-smail-o fa-stacck-1x fa-inverse"></i>                                              
                                         </span>
                                         <h2>Patients</h2>
                                        <p class="links cl-effect-1">
                                            <a href="manage-doctors.php"></p>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Outline: Footer -->
        <?php include('../layouts/footer.php');?>
        <!--  Outline: Setting -->
        <?php include('../layout/setting.php');?>
    </div>
    <!-- Custom JS -->
    <script src="../asset/js/main.js"></script>
    <script src="../asset/js/form-element.js"></script>
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