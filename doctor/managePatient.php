<?php
    session_start();
    error_reporting(0);
    incldue('../define/config.php');
    if(strlen($_SESSION['id']==0)) {
        header('location:logout.php');
    } else {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Doctor | Manage Patients</title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styless.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color" />
    </head>
<body>
    <div id="app">
        <?php include('../defiine/sidebar.php');?>
        <div class="app-content">
            <?php include('../define/header.php');?>
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    <!-- page title -->
                    <section class="page-title">
                        <div class="row">
                            <div class="col-sm-8"><h1 class="mainTitle"> Doctor | Manage Patient</h1></div>
                            <ol class="breadcrumb">
                                <li><span>Doctor</span></li>
                                <li><span>Manage Patients</span></li>
                            </ol>
                        </div>
                    </section>
                    <!-- page content -->
                    <div class="container-fluid container-full bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="over-title margin-bottom-15">Manage <span class="text-bold">Patients<span></h5>
                                <table class="table table-hover" id="patient-table">
                                    <theadd>
                                        <tr>
                                             <th class="center">#</th>
                                             <th>Patient Name</th>
                                             <th>Patient Contact No</th>
                                             <th>Patient Gender</th>
                                             <th>Creation Date</th>
                                             <th>Updation Date</th>
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $docID = $_SESSION['docID'];
                                            $qPat = mysqli_query($deal,"SELECT * FROM patients WHERE docID = '$docID' ");
                                            $count = 1;
                                            while($result = mysqli_fetch_array($qPat)){
                                        ?>
                                        <tr>
                                            <td class="center"><?php echo $count;?>.</td>
                                            <td class="hidden-xs"><?php echo $result['patientName'];?></td>
                                            <td><?php echo $result['patientContact'];?></td>
                                            <td><?php echo $result['patientGender'];?></td>
                                            <td><?php echo $result['creationDate'];?></td>
                                            <td><?php echo $result['UpdationDate'];?></td>
                                            <td>
                                                 <a href="editPatient.php?editid=<?php echo $result['ID'];?>"><i class="fa fa-edit"></i></a>||
                                                 <a href="infoPatient.php?infoid=<?php echo $result['ID'];?>"><i class="fa fa-eye"></i></a>
                                            </td>
                                        </tr>
                                        <?php $count=$count+1;    } ?>
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
    <!-- custome javascript -->
    <script src="../assign/js/main.js"></script>
    <script src="../assign/js/formElements.js"></script>
    <script>
        jQuery(document).ready(function(){
            Main.init();
            FormEleemnts.init();
        });
    </script>
</body>
</html>
    }