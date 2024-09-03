<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(strlen($_SESSION['id']==0)){
        hreader('location: logout.php');
    } else {
        if(isset($_POST['submit'])){
            $docSpecialized = $_POST['doctorSpecialized'];
            $addDS = mysqli_query($deal,"INSERT INTO doctorSpecialization(specialized)VALUES('$docSpecialized')");
            $_SESSION['msg'] = "Doctor Specialization added successfully !!";
        }
        /* code Deletion */
        if(isset($_GET['delid'])){
            $delID = $_GET['delid'];
            mysqli_query($deal,"DELETE FROM doctorSpecialization WHERE ID='$delID' ");
            $_SESSION['msg'] = "data deleted !!";
        }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title> Doctor Specialization | Admin Management System</title>
        <!-- custom css -->
        <link ref="stylesheet" href="../assign/css/styles.css">
        <link ref="stylesheet" href="../assign/css/plugins.css">
        <link ref="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color" />
    </head>
<body>
    <div id="app">
        <?php include('../define/sideber.php');?>
        <div class="app-content">
            <?php include('../define/header.php');?>
            <div class="wrap-content container" id="container">
                <!-- page title -->
                <section id="page-title">
                    <div class="row">
                        <div class="col-sm-8"><h1 class="mainTitle">Add Doctor Specialization | Admin Management System</h1></div>
                        <ol class="breadcrumb">
                             <li><span>Admin</span></li>
                             <li><span>Add Doctor Specialization</span></li>
                        </ol>
                    </div>
                </section>
                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row margin-top-30">
                                <div class="col-lg-6 col-md-12">
                                    <div class="panel-heading"><h5 class="panel-title">Doctor Specialization</h5></div>
                                    <div class="panel-body">
                                        <p style="color:red;">
                                            <?php echo htmlentities($_SESSION['msg']);?>
                                            <?php echo htmlentities($_SESSION['msg']="");?>
                                        </p>
                                        <form role="form" name="formDoctorSpecialized" method="post">
                                            <div class="form-group">
                                                <label for="Specialized">Doctor Specialization</label>
                                                    <input type="text" name="doctorspecialized" class="form-control" placeholder="Doctor Specialization">
                                            </div>
                                            <button type="submit" name="submit" class="btn btn-o btn-primary">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="over-title margin-bottom-15">Manage<span class="text-bold">Doctor Specialization</span></h5>
                            <table class="table table-hover" id="specialized-table">
                                <thead>
                                    <tr>
                                         <th class="center">#</th>
                                         <th>Specialization</th>
                                         <th class="hidden-xs">Creation Date</th>
                                         <th>Updation Date</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $qDs = mysqli_query($deal,"SELECT * FROM doctorSpecialization");
                                        $count  =1;
                                        while($result = mysqli_fetch_array($qDs)){
                                    ?>
                                    <tr>
                                        <td class="center"><?php echo $count;?></td>
                                        <td class="hidden-xs"><?php echo $result['specialized'];?></td>
                                        <td><?php echo $result['creationDate'];?></td>
                                        <td><?php echo $result['updationDate'];?></td>
                                        <td>
                                            <div class="visible-md visible-lg hidden-sm hidden-xs">                                                
                                                <a href="editDoctorSpecial.php?editid=<?php echo $result['id'];?>"
                                                    class="btn btn-transparent btn-xs" tooltip-placement="top" tooltip="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a href="doctorSpecial.php?delid=<?php echo $result['id']?>&del=delete" 
                                                   onClick="return confirm('Are you sure you want to delete?')"
                                                   class="btn btn-transparent btn-xs tooltip" tooltip-placement="top" tooltip="Remove">
                                            </div>
                                            <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                <div class="btn-group" dropdown is-open="status.isopen">
                                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle"  dropdown-toggle>
                                                        <i class="fa fa-cog"></i>&nbsp;<span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu pull-right dropdown-light" role="menu">
                                                         <li><a href="#editDoctorSpecial.php">Edit</a></li>
                                                         <li><a href="#">Share</a></li>
                                                         <li><a href="#doctorSpecial.php">Remove</a></li>
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
        <!-- FOOTER -->
        <?php include('../define/footer.php');?>
        <?php include('../define/setting.php');?>
    </div>
    <!-- custom javascript -->
    <script src="../assign/js/min.js"></script>
    <script src="../assign/js/formElememt.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            FormElement.init();
        })
    </script>
</body>
</html>
    }