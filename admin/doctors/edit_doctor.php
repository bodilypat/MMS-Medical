<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(strlen($_SESSION['id'])) {
        header('location: logout.php');
    } else {
        $docID = intval($_SESSION['editid']){
            $docSpecial = $_POST['doctorSpecialized'];
            $docName = $_POST['doctorname'];
            $docAddress = $_POST['clinicaddress'];
            $docFees = $_POST['consultfees'];
            $docContactno = $_POST['contactno'];
            $docEmail = $_POST['email'];

            $editDoc = mysqli_query($deal,"UPDATE doctors SET specialized = '$docSpecial', 
                                                              doctorName = '$docName', 
                                                              address = '$docAddress',
                                                              doctorFees = '$docFees',
                                                              contactno = '$docContactno',
                                                              doctorEmail = '$docEmail'
                                           WHERE id= '$docID' ");
            if($editDoc) {
                $msg = "Doctor Details Updated Successfully";
            }
        }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Edit Doctor Management | Admin</title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugin.css">
        <link rel="stylesheet" href="../assign/css/theme-1.css" id="skin_color" />
    </head>
<body>
    <div id="app">
        <?php include('../define/sidebar.php');?>
        <div class="app-content">
            <?php include('../define/header.php');?>
            <div class="main-content">
                 <div class="wrap-content container" id="container">
                      <!-- page title -->
                       <selection id="page-title">
                            <div class="row">
                                 <div class="col-sm-8"><h1 class="mainTitle"> Edit Doctor Management | Admin</h1></div>
                                 <ol class="breadcrumb">
                                      <li><span>Admin</span></li>
                                      <li><span>Edit Doctor Management</span></li>
                                 </ol>
                            </div>
                       </section>
                       <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 style="corlor:green; font-size: 18px; "><?php if($msg) { echo htmlentities($msg);}?></h5>
                                    <div class="row margin-top-30">
                                        <div class="col-lg-8 col-md-12">
                                            <div class="panel panel-white">
                                                <div class="panel-heading"><h5 class="panel-title">Edit Doctor Info</h5></div>                                            
                                                <div class="panel-body">
                                                    <?php $qDoc = mysqli_query($deal,"SELECT * FROM doctors WHERE id='$docID'");
                                                          while($result=mysqli_fetch_array($qDoc)){
                                                    ?>
                                                    <h4><?php echo htmlentities($result['doctorName']);?>'s Profile</h4>
                                                    <p><b>Profile Reg. Date : </b><?php echo htmlentities($result['creationDate']);?></p>
                                                        <?php if($result['updationDate']) { ?> 
                                                        <p></b>Profile Last Updation Date: </b><?php echo htmlentities($result['updationDate']);?></p>
                                                    <?php } ?>
                                                    <form role ="form" name="adddoc" method="post" onSubmit="return valid();">
                                                        <div class="form-group">
                                                            <label for="DoctorSpecial">Doctor Specialization</label>
                                                            <select name="doctorSpecial" class="form-control" required="required">
                                                                <option value="<?php echo htmlentities($result['specialized']);?>">
                                                                               <?php echo htmlentities($result['specialized']);?>
                                                                </option>
                                                                <?php $qDS = mysqli_query($deal,"SELECT * FROM doctorSpecialization");
                                                                    while($datads = mysqli_fetch_array($qDs)){
                                                                ?>
                                                                <option value="<?php echo htmlentities($datads['specialized']);?>">
                                                                               <?php eccho htmlentities($datads['specialized']);?>
                                                                </option>
                                                                <?php } ?>              
                                                            </section>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="DoctorName">Doctor Name</label>
                                                            <input type="text" name="doctorname" class="form-control"
                                                                   value="<?php echo htmlentities($result['doctorName']);?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="ClinicAddress">Clinic Address</label>
                                                            <textarea name="clinicaddress" class="form-control" 
                                                                      value="<?php echo htmlentities($result['address']);?>">
                                                            </textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="ConsultFees">Consultancy Fees</label>
                                                            <input type="text" name="consultfees" class="form-control" required="required" 
                                                                   value="<?php echo htmlentities($result['doctorFees']);?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Custact Number">Contact Number</label>
                                                            <input type="text" name="contactno" class="form-control" required="required" 
                                                                   value="<?php echo htmlentities($result['contactno']);?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="DoctorEmail">Doctor Email</label>
                                                            <input type="text" name="doctorEmail" class="form-control" readonly="readonly" 
                                                                   value="<?php echo htmlentities($result['doctorEmail']);?>">
                                                        </div>
                                                        <?php  } ?>
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
<?php    } ?>
