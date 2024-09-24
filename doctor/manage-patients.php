<?php
    session_start();
    error_reporting(0);
    include('../config/dbconnect.php');
    if(strlen($_SESSION['id']==0)){
        header('location:logout.php')
    } else {
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Doctor | Manage Patients</title>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="../asset/css/styles.css">
    </head>
<body>
    <div id="app">
        <!-- Outline : Navbar -->
        <?php include('../layouts/sidebar.php');?>
        <div class="app-content">
            <!-- Outline : Header -->
            <?php include('../layouts/header.php');?>
            <div class="main-content">
                <div id="container" class="wrap-content container">
                     <!-- PAGE TITLE -->
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8"><h1 class="maintTitle">Doctors | Manage Patient<h1></div>
                            <ol>
                                 <li></li>
                                 <li></li>
                            </ol>
                        </div>
                    </section>
                    <!-- Detail Content -->
                    <div class="container-fluid container-full bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="over-title margin-bottom-15">Manage<span class="text-bold">Patients</span>
                                <table class="table table-hover" id="patient-table">
                                    <thead>
                                        <tr>
                                             <th class="center">#</th>
                                             <th>Patient Name</th>
                                             <th>Patient Contactno</th>
                                             <th>Patient Email</th>
                                             <th>Patient Genger</th>
                                             <th>Doctor Name</th>
                                             <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $qPat = mysqli_query($deal,"SELECT * FROM patients WHERE docid = '$did' ");
                                        $count = 1;
                                        while($result=mysqli_fetch_array($qPat))
                                        {
                                    ?>
                                        <tr>
                                             <td class="center"></td>
                                             <td><?php echo $result['name'];?></td>
                                             <td><?php echo $result['contactno'];?></td>
                                             <td><?php echo $result['email'];?></td>
                                             <td><?php echo $result['gender'];?></td>
                                             <td><?php echo $result['docname'];?><td>
                                                 <a href="edit-patient.php?eid=<?php $result['id'];?>"><i class="fa fa-edit"></i></a>||
                                                 <a href="review-patient.php?rvid=<?php $result['id'];?>"><i class="fa fa-eye"></i></a>
                                             </td>
                                        </tr>
                                        <?php $count=$count+1 } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Outline : footer -->
        <?php include('../layouts/footer.php');?>
        <?php include('../layouts/setting.php');?>
    </div>
    <!-- Custom JS -->
    <script src="../asset/js/main.js"></script>
    <script src="../asset/js/form-elements.js"></script>
    <script>
        jQuery(document).ready(function(){
            Main.init();
            FormElements.init();
        });
    </script>
</body>
</html>
<?php
    }
?>  