<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(strlen($_SESSION['id'])){
        header('location:logout.php');
    } else {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Patient Appointment History | Admin Management</title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/theme/theme-1.css" id="skin_color">
    </head>
<body>
    <div id="app">
        <?php include('../define/sidebar.php');?>
        <div class="app-content">
            <?php include('../define/header.php');?>
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    <!-- page title -->
                    <section class="pagetitle">
                        <div class="row">
                            <div class="col-sm-8"><h1 class="mainTitle">Patient | Appointment History</h1></div>
                            <ol class="breadcrumb">
                                <li><span>Patients</span></li>
                                <li class="active"><span>Appointment History</span></li>
                            </ol>
                        </div>
                    </section>
                    <!-- page content -->
                    <div class="container-fluid container-full bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <p style="color:red;">
                                    <?php echo htmlentities($_SESSION['msg']);?>
                                    <?php echo htmlentities($_SESSION['msg']="");?>
                                </p>
                                <table class="table table-hover" id="patient table">
                                    <thead>
                                        <tr>
                                             <th class="center">#</th>
                                             <th class="hidden-xs">Doctor Name</th>
                                             <th>Patient Name</th>
                                             <th>Specialization</th>
                                             <th>Cosultancy Fee</th>
                                             <th>Appointment Date</th>
                                             <th>Appointment Creation Date</th>
                                             <th>Current Status</th>
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $qApp = mysql_query($deal,"SELECT doctors.doctorName as docName,
                                                                          users.fullName as patName, appointment.* 
                                                                   FROM appointment JOIN doctors on doctors.id = appointment.doctorID 
                                                                        JOIN users on users.id = appointment.userID");
                                        $count = 1;
                                        while($result=mysqli_fetch_array($qApp)) {
                                    ?>
                                        <tr>
                                             <td class="center"><?php echo $count;?>.</td>
                                             <td class="hidden-xs"><?php echo $result['docName'];?></td>
                                             <td class="hidden-xs"><?php echo $result['patName'];?></td>
                                             <td><?php echo $result['doctorSpecialized'];?></td>
                                             <td><?php echo $result['consultFees'];?></td>
                                             <td><?php echo $result['appointDate'];?> / <?php echo $result['appointTime'];?></td>                                        
                                             <td><?php echo $result['postingDate'];?></td>
                                             <td>
                                                 <?php if(($result['userStatus']==1) && ($result['doctorStatus'])){
                                                             echo 'active';
                                                        } 
                                                        if(($result['userStatus']==0) && ($result['doctorStatus']==1)) {
                                                            echo 'Cancle by Patient';
                                                        }
                                                        if(($result['userStatus']==1) && ($result['doctorStatus']==0)) {
                                                            echo 'Cancel by Doctor';
                                                        }
                                                    ?>
                                             </td>
                                             <td>
                                                  <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                       <?php
                                                           if(($result['userStatus']==1) && ($result['doctorStatus']==1)){
                                                                echo 'No Action yet';
                                                           } else {
                                                            echo 'Canceled';
                                                           }
                                                        ?>
                                                  </div>
                                                  <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                        <div class="btn-group" dropdown is-open="status.isopen">
                                                            <button type="button" class="btn btn-primary btn-o btn-sm dropdown-toggle"
                                                                    dropdown-toggle>
                                                            </button>
                                                            <ul class="dropdown-menu pull-right dropdown-light" role="menu">
                                                                <li><a href="#">Edit</a></li>
                                                                <li><a href="appointmentHistory.php">Show</a></li>
                                                                <li><a href="#">Remove</a></li>
                                                            </ul>
                                                        </div>
                                                  </div>
                                             </td>
                                        </tr>
                                       <?php $count=$count+1; } ?>
                                    </tbody>
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
<?php    } ?>