<?php
    session_start();
    error_reporting(0);
    include('../includes/functions.php');
    
    if(strlen($_SESSION['id'] == 0)){
        header('Location:logout.php');
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
        <?php include('../outline/sidebar.php');?>
        <div class="app-content">
            <?php include('../outlines/header');?>
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
                            
                        <!-- Manage Doctor -->
                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                                            <i class="fa fa-smail-o fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2>Doctors</h2>
                                        <p class="links cl-effect-1">
                                            <a href="manage_doctor.php"></a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Manage Appointment  -->
                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="fa fa-square fa-stack-2x text primary"></i>
                                            <i class="fa fa-smail-o fa-stack-1x inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">Appointments</h2>
                                        <p class="links cl-effect-1">
                                            <a href="manage_appointment.php"></a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Manage Prescription -->
                            <div class="col-md-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa fa-stack-2x">
                                             <i class="fa fa-square fa-stack-2x text-primary"></i>
                                             <i class="fa fa-samil-o fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2>Prescriptions</h2>
                                        <p class="links cl-effect-1">
                                            <a href="manage_prescripts.php"></a>
                                        </p>        
                                    </div>
                                </div>
                            </div>

                            <!-- Manage Patients -->
                            <div class="col-md-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa fa-stack-2x">
                                             <i class="fa fa-square fa-stack-2x text-primary"></i>
                                             <i class="fa fa-samil-o fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2>Patients</h2>
                                        <p class="links cl-effect-1">
                                            <a href="manage_patients.php"></a>
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
        <?php include('../outlines/footer.php');?>
        <!--  Outline: Setting -->
        <?php include('../outlines/setting.php');?>
    </div>
    <!-- Custom JS -->
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/form-element.js"></script>
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