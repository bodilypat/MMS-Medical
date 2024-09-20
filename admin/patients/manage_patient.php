<?php 
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(strlen($_SESSION['id']==0)) {
        header('location:logout.php');
    } else {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title> Display Patient | Admin Medical Management System</title>
        <!-- custom css -->
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
                <div class="wrap-content container" id="container">
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8"><h1 class="mainTitle"> Admin | Display Patients</h1></div>
                                <ol class="breadcrumb">
                                    <li><span>Admin</span></li>
                                    <li class="active"><span>Display Patients</span></li>      
                                </ol>      
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12"><h5 class="over-title margin-button-15">Display<span class="text-bold">Patients</span></h5>
                            <table class="table table-hover" id="patient-table">
                                <thead>
                                    <tr>
                                        <th class="center">#</th>
                                        <th>Patient Name</th>
                                        <th>Patient Contact Number</th>
                                        <th>Patient Gender</th>
                                        <th>Creation Date</th>
                                        <th>Updating Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $qPat = mysqli_query($deal,"SELECT * FROM tblpatient");
                                    $count = 1;
                                    while($result=mysqli_fetch_array($qPat)) {
                                ?>
                                    <tr>
                                         <td class="center"><?php echo $count;?>.</td>
                                         <td class="hidden-xs"><?php echo $result['patientName'];?></td>
                                         <td><?php echo $result['patientContno'];?></td>
                                         <td><?php echo $result['patientGender'];?></td>
                                         <td><?php echo $result['createDate'];?></td>
                                         <td><?php echo $result['updateDate'];?></td>
                                         <td>
                                            <a href="infoPaitent.php?patid=<?php echo $result['ID'];?>"><i class="fa fa-eye"></i></a>
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
        <!-- FOOTER -->
        <?php include('../define/footer.php');?>
        <?php include('../define/setting.php');?>
    </div>
    <!-- custom javascript -->
    <script src="../assign/js/min.js"></script>
    <script src="../assign/js/formElements.php"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            FormElements.init();
        });
    </script>
</body>
</html>
<?php   } ?>