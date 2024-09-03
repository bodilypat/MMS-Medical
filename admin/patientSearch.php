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
        <title>Admin | Info Patients</title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/theme/theme-1.css" id="skin_color" />
    </head>
<body>
    <div id="app">
        <?php include('../define/sidebar.php');?>
        <div class="app-content">
            <?php include('../define/header.php');?>
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    <!-- page title -->
                    <section id="page-title">
                           <div class="row">
                                <div class="col-sm-8"><h1 class="mainTitle">Admin | Info Patient</h1></div>
                                <ol class="breadcrumb">
                                     <li><span>Admin</span></li>
                                     <li class="active"><span>Info Patient</span></li>
                                </ol>
                           </div>
                    </section>
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <form name="search" method="post" role="form">
                                <?php   
                                    if(isset($_POST['search'])){
                                        $searchData = $_POST['searchdata'];
                                ?>
                                    <h4 align="center">Result against"<?php echo $searchDate;?>" keyword</h4>
                                    <table class="table table-hover" id="patient-table">
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
                                            $qPat = mysql_query($deal,"SELECT * tblpatient WHERE patientName like '%searchData% || patientContno '%searchDate' ");
                                            $numRow = mysqli_num_rows($qPat);
                                            if($numRow > 0) {
                                                $count = 1;
                                                while($result=mysqli_fetch_array($qPat)) {
                                        ?>
                                            <tr>
                                                <td class="center"><?php echo $count;?>.</td>
                                                <td class="hidden-xs"><?php echo $resultt['patientName'];?></td>
                                                <td><?php echo $result['patientContno'];?></td>
                                                <td><?php echo $result['patientGender'];?></td>
                                                <td><?php echo $result['creationDate'];?></td>
                                                <td><?php echo $result['updationDate'];?></td>
                                                <td><a href="infoPatient.php?infoid=<?php echo $result['ID'];?>"><i class="fa fa-eye"></i></td>
                                            </tr>
                                            <?php $count=$count+1;  }
                                            } else { ?> 
                                            <tr>
                                                 <td colspan="8">No record found against this search</td>
                                            </tr>
                                       <?php } } ?>
                                        </tbody>
                                    </table>
                                </form>
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
<?php  } ?>