<?php
    session_start();
    error_reporting(0);
    include('../includes/dbconnect.php');
    
    if(strlen($_SESSION['id'] == 0)){
        header('location:logout.php');
    } else {
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Patients | Dashboard</title>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="../asset/css/styles.css">
    </head>
<body>
    <div id="app">
        <!-- Outline  -->
        <?php include('../outlines/sidebar.php');?>
        <div class="app-content">
            <?php include('../outlines/header');?>
            <!-- END: outline -->
            <div class="main-content">
                <div id="container" class="wrap-content container">
                    <!-- page title -->
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8"><h1 class="mainTitle">Patients | Dashboard<h1></h1></div>
                            <ol class="breadcrumb">
                                 <li><span>Patients</span></li>
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
                                        <h2>Patients</h2>
                                        <p class="links cl-effect-1">
                                            <a href="patients.php"></a>
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
                                        <h2 class="StepTitle">Appointments</h2>
                                        <p class="links cl-effect-1">
                                            <a href="appointments.php"></a>
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
                                        <h2>Medical Records</h2>
                                        <p class="links cl-effect-1">
                                            <a href="medical_records.php"></a>
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
                                        <h2>Prescriptions</h2>
                                        <p class="links cl-effect-1">
                                            <a href="prescriptions.php"></a>
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
                                        <h2>Billing</h2>
                                        <p class="links cl-effect-1">
                                            <a href="billing.php"></a>
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
                                        <h2>Lab Tests</h2>
                                        <p class="links cl-effect-1">
                                            <a href="lab_test.php"></a>
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
                                        <h2>Reports</h2>
                                        <p class="links cl-effect-1">
                                            <a href="reposts.php"></a>
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
                                        <h2>Settings</h2>
                                        <p class="links cl-effect-1">
                                            <a href="settings.php"></a>
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
        <?php include('../outline/footer.php');?>
        <!--  Outline: Setting -->
        <?php include('../outline/setting.php');?>
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
