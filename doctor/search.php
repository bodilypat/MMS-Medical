<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(strlen($_SESSION['id']==0)) {
        header('location: logout.php');
    } else {
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Doctor | Search Patients</title>
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
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8"><h1 class="mainTitle">Doctor | Search Patients</h1></div>
                            <ol class="breadcrumb">
                                 <li><span>Doctor</span></li>
                                 <li class="active"><span>Search Patients</span>
                            </ol>
                        </div>
                    </section>
                    <!-- page content -->
                    <div class="container-fluid container-full bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" method="post" name="search">
                                    <div class="form-group">
                                        <label for="DoctorName">Search by Name / Mobile No.</label>
                                        <input type="text" name="searchdata" id="searchdata" class="form-control" value="" required="ture">
                                    </div>
                                    <button type="submit" name="search" id="submit" class="btn btn-o btn-primary">Search<button>
                                </form>
                                <?php 
                                    if(isset($_POST['search'])){
                                        $searchData = $_POST['searchdata'];
                                ?>
                                    <h4 aliign="center">Result against "<?php echo $searchData;?>" keyword </h4>
                                    <table class="table table-hover" id="patients-table">
                                        <thead>
                                            <tr>
                                                  <th class="center">#</th>
                                                  <th>Patient Name</th>
                                                  <th>Patient contact Number</th>
                                                  <th>Patient Gender</th>
                                                  <th>Creation Date</th>
                                                  <th>Updation Date</th>
                                                  <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $qPat = mysqli_query($deal,"SELECT * FROM patients WHERE patientName like '%searchData%' || patientContno link '%searchData%' ");
                                            $numRows = mysqli_num_rows($qPat);
                                            if($numRows > 0) {
                                                $count = 1;
                                                while($result = mysql_fetch_array($qPat)) {
                                        ?>
                                            <tr>
                                                 <td class="center"><?php echo $count;?>.</td>
                                                 <td class="hidden-xs"><?php echo $result['patientcontno'];?></td>
                                                 <td><?php echo $result['patientGender'];?></td>
                                                 <td><?php echo $result['creationDate'];?></td>
                                                 <td><?php echo $result['UpdationDate'];?></td>
                                                 <td>
                                                      <a href="editPatient.php?editid=<?php echo $result['ID'];?>"><i class="fa fa-edit"></i></a> ||
                                                      <a href="infoPatient.php?infoid=<?php echo $result['ID'];?>"><i class="fa fa-eye"></i></a>
                                                 </td>
                                            </tr>
                                            <?php $count = $count+1;
                                                }
                                            } else { ?> 
                                            <tr>
                                                 <td colspan="8">No record found against this search</td>
                                            </tr>
                                            <?php }} ?>
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