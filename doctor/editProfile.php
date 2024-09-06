<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(strlen($_SESSION['id']==0)) { 
        header('location:logout.php');
    } else {
        if(isset($_POST['submit'])) {
            $docSpecialized = $_POST['doctorspecialized'];
            $docAddress = $_POST['clinicaddress'];
            $docFees = $_POST['consultfees'];
            $docContact = $_POST['contactNO'];
            $docEmail = $_POST['email'];
            
            $editDoc = mysqli_query($deal,"Update doctors set specialized='$docSpecialized', doctorName='$docName',
                                           address = '$docAddress', doctorFees='$docFees', contactno = '$docContact'
                                           WHERE id = '" . $_SESSION['id']. "'");
            if($editDoc) {
                echo "<script>alert('Doctor details updated successully ');</script>";
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Doctor  | Edit Doctor Details</title>
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
                    <!-- custom title -->
                    <section id="page-title">
                         <div class="row">
                              <div class="col-sm-8"><h1 class="mainTitle">Doctor | Edit Doctor Details<h1></div>
                              <ol class="breadcrmb">
                                   <li><span>Doctor</span></li>
                                   <li class="active"><span>Edit Doctor Details</span></li>
                              </ol>
                         </div>     
                    </section>
                    <div class="container-fluid container-full bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row margin-top-30">
                                    <div class="col-lg-8 col-md-12">
                                        <div class="panel panel-white">
                                            <div class="panel-heading"><h5 class="panel-title">Edit Doctor</h5></div>
                                            <div class="panel-body">
                                                <?php   
                                                    $docID = $_SESSION['docid'];
                                                    $qDoc = mysqli_query($deal,"SELECT * FROM doctors WHERE doctorEmail ='$docID' ");
                                                    while($result = mysqli_fetch_array($qDoc)) {
                                                ?>
                                                <h4><?php echo htmlentities($result['doctorName']);?>'s profile</h4>
                                                <p><b>Profile Reg. Date : </b><?php echo htmlentities($result['creationDate']);?></p>
                                                <?php if($result['updationDate']) { ?>
                                                    <p><b>Profile Last Updation Date: </b><?php echo htmlentities($result['updationDate']);?></p>
                                                <?php } ?>
                                                <form role="form" name="adddoc" method="post" onSubmit="return valid();">
                                                    <div class="form-group">
                                                        <label for="DoctorName">Doctor Name</label>
                                                        <input type="text" name="doctorname" class="form-control" 
                                                              value="<?php echo htmlentities($result['doctorName']);?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="DoctorAddress">Address</label>
                                                        <textarea type="text" name="clinicaddress" class="form-control">
                                                              <?php echo htmlentities($result['address']);?>
                                                        </textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ConsultFees">Doctor Consultancy Fees</label>
                                                        <input type="text" name="doctorconsult" class="form-control" required="required"
                                                              value="<?php echo htmlentities($result['doctorFees']);?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ContactNumber">Contact Number</label>
                                                        <input type="text" name="contactno" class="form-control" required="required"
                                                              value="<?php echo htmlentities($result['contactno']);?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="DoctorEmail">Email</label>
                                                        <input type="email" name="doctorEmail" class="form-control" readonly="readonly"
                                                             value="<?php echo htmlenities($result['doctorEmail']);?>">
                                                    </div>
                                                    <?php } ?>
                                                    <button type="submit" name="submit" class="btn btn-o btn-primary">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
