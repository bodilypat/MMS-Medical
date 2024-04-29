<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    include('../define/checklogin');
    check_login();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Registration User |  Medicail History</title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/theme/theme-1-1.css" id="skin_color" />
    </head>
    <body>
        <div id="Application">
            <?php include('../define/sidebar.php');?>
            <div class="application-content">
                <?php include('../define/header.php');?>
                <div class="main-content">
                     <div id="container" class="wrap-content container" >
                        <!-- section: page title -->
                        <section id="page-title">
                            <div class="row">
                                <div class="col-sm-8"><h1 class="mainTitle">Users | Medical History</h1></div>
                                <ol>
                                     <li><span>Users</span></li>
                                     <li class="active">Data Medical History<span></span></li>
                                </ol>
                            </div>
                        </section>
                        <!-- section: content -->
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="over-title margin-bottom-15">Data<span class="text-bold">Medical History</span></h5>
                                    <table id="patient-table" class="table table-hover" >
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
                                                $userid=$_POST['id'];
                                                $qPat=mysqli_query($deal,"SELECT patients.* 
                                                                           FROM patient JOIN users ON users.email=patientEmail 
                                                                           WHERE users.id='$userid' ");
                                                $count=1;
                                                while($result=mysql_fetch_array($qPat))
                                                {
                                            ?>
                                            <tr>
                                                <td class="center"><?php echo $count;?>.</td>
                                                <td class="hidden-xs"><?php echo $result['patientContno'];?></td>
                                                <td><?php echo $result['patientGender'];?></td>
                                                <td><?php echo $result['createDate'];?></td>
                                                <td><?php echo $result['updateDate'];?></td>
                                                <td>
                                                    <a href="dataMedhistory.php?did=<?php echo $result['id'];?>"><i class="fa fa-eye"></i></a>
                                                </td>
                                            </tr>
                                                <?php  } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
            <!-- FOOTER -->
            <script src="../assign/js/main.js"></script>
            <script src="../assign/js/form-elements.js"></script>
            <!-- javascript -->
            <script src="../assign/js/main.js"></script>
            <script src="../assign/js/form-elements.js"></script>
            <script>
                jQuery(document).ready(function(){
                    Main.init();
                    formElements.init();
                })
            </script>
        </div>
    </body>
</html>