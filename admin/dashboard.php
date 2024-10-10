
<?php
    session_start();
    error_reporting(0);
    include('../includes/functions.php');
    if(strlen($_SESSION['id']==0)){
        header('location:logout.php');
    } else {

?>
<!DOCTYPE html>
<html lang="en"></html>
    <head>
        <title>Admin | Dashboard</title>
        <!-- custom stype -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
    </head>
<body>
    <div id="app">
        <?php include('../outlines/sidebar.php');?>
        <div class="app-content">
            <?php include('../outlines/header.php');?>
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    <section id="page-title">
                        <!-- page title -->
                         <div class="row"><h1 class="mainTitle">Admin | dashboard</h1></div>
                         <ol>
                              <li class="breadcrumb"><span>Admin</span></li>
                              <li class="active"><span>Dashboard</span></li>
                         </ol>
                    </section>
                    <!-- page content -->
                     <div class="container-fluid container-full bg-white">
                        <div class="row">
                            <!-- User Panal -->
                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                                            <i class="fa fa-smile-o fa-stack-1x fa-inverse"></i>
                                            <h2 class="StepTitle">Manage Users</h2>
                                            <p class="link cl-effect-1">
                                                <a href="manage_users.php">
                                                    <?php $users = getUsers();
                                                        $countUser = num_rows($users);
                                                        {
                                                    ?>
                                                        Total Users : <?php echo htmlentities($countUser); } ?>
                                                </a>
                                            </p>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Doctor Panel -->
                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa fa-stack fa-2x">
                                            <i class="fa fa-square fa-stack-2x text-primaryy"></i>
                                            <i class="fa fa-smile-o fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">Doctors</h2>
                                        <p class="cl-effect-1">
                                            <a href="manage_doctors.php">
                                                <?php  $doctors = getDoctors();
                                                $countDoc = num_rows($doctors);
                                                {
                                            ?>
                                                Total Doctors : <?php echo htmlentities($countDoc); } ?>                                                
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Appointment Panel -->
                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                                            <i class="fa fa-smile-o fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">Appointment</h2>
                                        <p class="link cl-effect-1">
                                            <a href="manage_appointments.php">                                                
                                                <?php
                                                    $Appointments = getAppointments();
                                                    $countApp = num_rows($Appointments);
                                                    {
                                                ?>
                                                    Total Appointment : <?php echo htmlentities($countApp); } ?>
                                                </a>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Patient Panel -->
                            <div class="col-sm-4">
                                <div class="panel panel-white no radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="ti-files fa-1x text-primary"></i>
                                            <i class="fa fa-terminal fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">Patients</h2>
                                        <p class="link cl-effect-1">
                                             <a href="manage_patients.php">                                                
                                                    <?php
                                                          $patients = getPatients();
                                                          $countPat = num_rows($patients);
                                                    ?>
                                                    Total Patients : <?php echo htmlentities($countPat); ?>
                                                 </a>
                                             </a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Medical Record panel -->
                            <div class="col-sm-4">
                                <div class="panel panel-white no radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="ti-files fa-1x text-primary"></i>
                                            <i class="fa fa-terminal fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">Medical Records</h2>
                                        <p class="link cl-effect-1">
                                             <a href="manage_medical_records.php">                                                
                                                    <?php
                                                          $medical_records = getMedical_records();
                                                          $countMdr = num_rows($medical_records);
                                                    ?>
                                                    Total Medical_record : <?php echo htmlentities($countMdr); ?>
                                                 </a>
                                             </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Prescription Panel -->
                            <div class="col-sm-4">
                                <div class="panel panel-white no radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="ti-files fa-1x text-primary"></i>
                                            <i class="fa fa-terminal fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">Prescriptions</h2>
                                        <p class="link cl-effect-1">
                                             <a href="manage_prescription.php">                                                
                                                    <?php
                                                          $prescriptions = getPrescriptions();
                                                          $countPre = num_rows($prescriptions);
                                                    ?>
                                                    Total Prescription : <?php echo htmlentities($countPre); ?>
                                                 </a>
                                             </a>
                                        </p>
                                    </div>
                                </div>
                            </div> 
                            
                            <!-- Billings panel -->
                            <div class="col-sm-4">
                                <div class="panel panel-white no radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="ti-files fa-1x text-primary"></i>
                                            <i class="fa fa-terminal fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">Billings</h2>
                                        <p class="link cl-effect-1">
                                             <a href="manage_billing.php">                                                
                                                    <?php
                                                          $billings = getbillings();
                                                          $countBill = num_rows($billings);
                                                    ?>
                                                    Total Billing : <?php echo htmlentities($countBill); ?>
                                                 </a>
                                             </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>
        <!-- FOOTER -->
        <?php include('../outlines/footer.php');?>
        <?php include('../outlines/setting.php');?>
    </div>
    <!-- custom javascript -->
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/formElements.js"></script>
    <script>
        jQuery(document).ready(function(){
            Main.init();
            FormElements.init();
        });
    </script>
</body>
</html>
<?php } ?>