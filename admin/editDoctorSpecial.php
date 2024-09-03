<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(strlen($_SESSION['id']==0)){
        header('location: logout.php');
    } else {
        $editID = intval($_GET['editid']);
        if(isset($_POST['submit'])){
            $docSpecialized = $_POST['doctorSpecialized'];
            $editDS = mysqli_query($deal,"UPDATE doctorSpecialized SET specialized = '$docSpecialized' WHERE id='$editid' ");
            $_SESSION['msg'] = "Doctor Specialization Updated Successfull !!";
        }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Edit Doctor Specialization | Admin Management</title>
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
                <!-- page title -->
                <section id="page-title">
                    <div class="row">
                        <div class="col-sm-8"><h1 class="mainTitle"> Edit Doctor Specialization | Admin management</h1></div>
                        <ol class="breadcrumb">
                             <li><span>Admin</span></li>
                             <li><span>Edit Doctor Specialization</span></li>
                        </ol>
                    </div>
                </section>
                <!-- body content -->
                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                         <div class="col-md-12">
                              <div class="row margin-top-30">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="panel panel-white">
                                            <div class="panel-heading"><h5 class="panel-title">Edit Doctor Specialization</h5></div>     
                                            <div class="panel-body">
                                                <p style="color:red;">
                                                    <?php echo htmlentities($_SESSION['msg']);?>
                                                    <?php echo htmlentities($_SESSION['msg']=="");?>
                                                </p>
                                                <form role="form" name="doctorSpecial" method="post">
                                                    <div class="form-group">
                                                        <label for="DoctorSpecialized">Edit Doctor Specialization</label>
                                                        <?php
                                                            $editID = intval($_GET['editid']);
                                                            $qDS = mysqli_query($deal,"SELECT * FROM doctorSpecialization WHERE id='$editID' ");
                                                            while($result=mysql_fetch_array($qDS)){
                                                        ?>
                                                        <input type="text" name="doctorspecialized" class="form-control" 
                                                               value="<?php echo $result['specialized'];?>">
                                                        <?php  } ?>
                                                    </div>
                                                    <button type="submit" name="submit" class="btn btn-o btn-primary">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                              </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="panel panel-white"></div>
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