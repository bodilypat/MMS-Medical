<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(strlen($_SESSION['id']==0)) {
        header('location: logout.php');
    } else {
        if(isset($_GET['cencel'])) {
            mysqli_query($deal,"UPDATE appointment SET doctorStaus = '0' WHERE id = '".$_GET['id']. "'");
            $_SESSION['msg'] = "Appointment canceled !! ";
        }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Doctor | Appointment History</title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color" />
    </head>
<body>
    <div id="app">
        <?php include('../define/sidebar.php');?>
        <div class="app-centent">
            <?php include('../define/header.php');?>
            <div class="main-content">
                <div class="wrap-content-container" id="container">
                    <!-- page title -->
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8"><h1 class="mainTitle">Doctor | Appointment History</h1></div>
                            <ol class="breadcrumb">
                                <li><span>Doctor</span></li>
                                <li class="active"><span>Appointment History</span></li>
                            </ol>
                        </div>
                    </section>
                    <div class="container-fluid container-full bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <p style = "color-md-12">
                                    <?php echo htmlentities($_SESSION['msg']);?>
                                    <?php echo htmlentities($_SESSION['msg']="");?>
                                </p>
                                <table class="table table-hover" id="user-table">
                                    <thead>
                                        <tr>
                                             <th class="center">#</th>
                                             <th class="hidden-xs">Patient Name</th>
                                             <th>Specialazation</th>
                                             <th>Consultancy</th>
                                             <th>Appointment Date</th>
                                             <th>Appointment Creation Date</th>
                                             <th>Current Status</th>
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $qUser = mysqli_query($deal,"SELECT users.fullName as username , appointment.* 
                                                                           FROM appointment JOIN users ON users.id=appointment.userID
                                                                           WHERE appointment.doctorID = '" . $_SESSION['id']. "' ");
                                              $count = 1;
                                              while($result = mysqli_fetch_array($qUser)) {
                                        ?>
                                        <tr>
                                             <td class="center"><?php echo $count;?>.</td>
                                             <td class="hidden-xs"><?php echo $result['username'];?></td>
                                             <td><?php echo $result['doctorSpecialized'];?></td>
                                             <td><?php echo $result['consultFees'];?></td>
                                             <td><?php echo $result['appointmentDate'];?></td>
                                             <td><?php echo $result['postingDate'];?></td>
                                             <td>
                                                <?php 
                                                    if(($result['userStatus']==1) && ($ressult['doctorStatus']==1)){
                                                        echo "Active";
                                                    } 
                                                    if(($result['userStatus']==0) && ($result['doctorStatus']==1)) {
                                                        echo "Cancel by Patient";
                                                    } 
                                                    if(($result['userStatus']==1) && ($result['doctorStatus']==0)) {
                                                        echo "cancel by doctor" ;
                                                    }
                                                ?>
                                             </td>
                                             <td>
                                                  <div class="vasible-md visible-lg hidden-sm hidden-xs">
                                                      <?php if(($result['userStatus']==1) && ($result['doctorStatus']==1))
                                                          { ?>
                                                            <a href="appointmentHistory.php?id=<?php echo $result['id'];?>&cencel=update"
                                                               onClick="return confirm('Are you sure you want to cancel this appointment ?')"
                                                               class="btn btn-transparent btn-xs tooltips" title="Cancel Appointment" 
                                                               tooltip-placement="top" tooltip="remove">Cancel</a>
                                                            <?php  } else {
                                                                echo "Canceled";
                                                             } ?>
                                                  </div>
                                             </td>
                                        </tr>
                                        <?php $count = $count+1;  } ?>
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
    }