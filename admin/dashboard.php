<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
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
        <link rel="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color" />
    </head>
<body>
    <div id="app">
        <?php include('../define/sidebar.php');?>
        <div class="app-content">
            <?php include('../define/header.php');?>
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
                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                                            <i class="fa fa-smile-o fa-stack-1x fa-inverse"></i>
                                            <h2 class="StepTitle">Manage Users</h2>
                                            <p class="link cl-effect-1">
                                                <a href="manageUser.php">
                                                    <?php $qUser = mysqli_query($deal,"SELECT * FROM users");
                                                        $numUser = mysqli_num_rows($qUser);
                                                        {
                                                    ?>
                                                        Total Users : <?php echo htmlentities($numUser); } ?>
                                                </a>
                                            </p>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa fa-stack fa-2x">
                                            <i class="fa fa-square fa-stack-2x text-primaryy"></i>
                                            <i class="fa fa-smile-o fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">Manage Doctors</h2>
                                        <p class="cl-effect-1">
                                            <a href="manageDoctor.php">
                                                <?php  $qDoc = mysqli_query($deal,"SELECT * FROM doctors");
                                                $numDoc = mysqli_num_rows($qDoc);
                                                {
                                            ?>
                                                Total Doctors : <?php echo htmlentities($numDoc); } ?>                                                
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                                            <i class="fa fa-smile-o fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">Appointment</h2>
                                        <p class="link cl-effect-1">
                                            <a href="bookAppointment.php">
                                                <a href="appointmentHistory.php">
                                                <?php
                                                    $qApp = mysqli_query($deal,"SELECT * FROM appointment");
                                                    $numApp = mysqli_num_rows($qApp);
                                                    {
                                                ?>
                                                    Total Appointment : <?php echo htmlentities($numApp); } ?>
                                                </a>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="panel panel-white no radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="ti-files fa-1x text-primary"></i>
                                            <i class="fa fa-terminal fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">New Enquiries</h2>
                                        <p class="link cl-effect-1">
                                             <a href="bookAppointment.php">
                                                 <a href="ureadEnquiry.php">
                                                    <?php
                                                          $qCon = mysqli_query($deal,"SELECT * FROM tblcontactus WHERE isRead is null");
                                                          $numCon = mysqli_num_rows($qCon);
                                                    ?>
                                                    Total New Enquiries : <?php echo htmlentities($qCon); ?>
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
<?php } ?>