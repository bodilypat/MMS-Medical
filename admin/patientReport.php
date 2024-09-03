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
        <title>Admin  | Info Patients</title>
        <!-- custom style -->
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
                    <!-- page title -->
                    <section class="page-title">
                        <div class="row">
                            <div class="col-sm-8"><h1 class="mainTitle"> Info Patients Report | Admin Management</h1></div>
                            <ol class="breadcrumb">
                                <li><span>Admin</span></li>
                                <li class="active">Info Patients</li>
                            </ol>
                        </div>
                    </section>
                    <div class="container-fluid container-full bg-white">
                        <div class="row">
                            <div class="col-md-12"><h4 class="title-agileits mb-4">Infor Reports</div>
                            <?php   
                                $formDate = $_POST['fromdate'];
                                $toDate = $_POST['toDate'];
                            ?>
                            <h5 align="center" style="color:blue">Report Form<?php echo $formDate ?> To <?php echo $toDate ?> </h5>
                            <table class="table table-hover" id="patient-able">
                                <thead>
                                    <tr>
                                         <th class="center">#</th>
                                         <th>Patient Name</th>
                                         <th>Patient Contact Number</th>
                                         <th>Patient Gender</th>
                                         <th>Creation Date</th>
                                         <th>Updation Date</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $qPat = mysqli_query($deal,"SELECT * FROM patients WHERE date(creationDate) BETWEEN '$fromDate' and '$toDate' ");
                                        $count =1;
                                        while($result=mysqli_fetch_array($qPat)) {
                                    ?>
                                    <tr>
                                         <td class="center"><?php echo $count;?>.</td>
                                         <td class="hidden-xs"><?php echo $result['patientName'];?></td>
                                         <td><?php echo $result['patientContn'];?></td>
                                         <td><?php echo $result['patientGender'];?></td>
                                         <td><?php echo $result['cretionDate'];?></td>
                                         <td><?php echo $result['UpdationDate'];?></td>
                                         <td>
                                              <a href="infoPatient.php?infoid=<?php echo $result['ID'];?>"><i class="fa fa-eye"></i></a>
                                         </td>
                                    </tr>
                                    <?php   $count = $count+1;  }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FOOTER -->
        <?php include('../define/footer');?>
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

