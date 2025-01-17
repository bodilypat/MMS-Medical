<?php
    /* Start the session or resume the existing session */
    session_start();


    /* enable error reporting for development purpose display for production */
    ini_set('display_errors', 1);

    /* Include the configuration file, connection database */
    include('../include/dbconnect.php');

    /* Check if session ID is not set or invalid */
    if(!isset($_SESSIN['id']) || $_SESSION['id'] == 0) {

        /* if the session is not valid, redirect to logout page and stop further execution */
        header('Location:logout.php');
        exit; /* Ensure no further cide is excuted after the redirect */
    } else {
        /* protected content for authenticated users */
?>
        
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Doctor | Dashboard</title>
        <link rel="stylesheet" href="../assets/css/styles.css">
        <link rel="stylesheet" href="../assets/css/plugin.css">
        <link rel="stylesheet" href="../assets/css/theme-1.css" id="skin_color">
    </head>
    <body>
        <div id="app">
            <?php include('../outline/sidebar.php'); ?>
            <div class="app-content">
                <?php include('../outline/header.php'); ?>
                    <!-- navbar -->
                <div class="main-content">
                    <div class="wrap-content container" id="container">
                        <!-- title -->
                        <section id="page-title">
                            <div class="row">
                                <div class="col-sm-8"><h1 class="main-title">Doctors | Dashboard</h1></div>
                                <ol class="borad">
                                    <li><span>Doctor</span></li>
                                    <li class="active"><span>Dashboard</span></li>
                                </ol>
                            </div>
                        </section>
                        <div class="container-bg">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="panel-style">
                                        <div class="panel-body">
                                            <span class="fa-stack">
                                                <i class="fa fa-square"></i>
                                                <i class="fa fa-smale">></i>
                                            </span>
                                            <h2 class="step-title" >Profile</h2>
                                            <p class="anchor-effect"><a href="editProfile.php">Update Profile</a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        <span class="fa-stack">
                                            <i class="fa square"></i>
                                            <i class="fa smaile"></i>
                                        </span>
                                        <h2 class="step-title">Appointments</h2>
                                        <p class="anchor-effect"><a href="appointmentHistory.php">View Appointment</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer app-->
            <?php include('../outline/footer.php'); ?>
            <?php include('../outline/setting.php'); ?>
        </div>
        <!-- JavaScript -->
        <script src="../assets/js/main.js"></script>
        <script src="../assets/js/login.js"></script>
        <script>
            jQuery(document).ready(function() {
                Main.init();
                FormElements.init();
            });
        </script>
    </body>
</html>
<?php  } ?>