<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(strlen($_SESSION['id']==0)){
        header('location:logout.php');
    } else {
        if(isset($_POST['submit'])){
            $docSpecialize = $_POST['doctorspecialize'];
            $docName = $_POST['doctorName'];
            $docAddress = $_POST['address'];
            $docFees = $_POST['consultfees'];
            $docContactno = $_POST['contactno'];
            $docEmail = $_POST['email'];
            $docPass = $_POST['password'];
            $qAdd = mysqli_query($deal,"INSERT INTO doctors(specialize, doctorName, address, doctorFees,contactno, doctorEmail,password)
                                        VALUES('$docSpecialize','$docName','$docAddress','$docFees','$docContactno','$docEmail','$docPass')");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Add Doctor | Admin Management System</title>
        <!-- custom style --> 
        <link ref="stylesheet" href="assign/css/styles.css">
        <link ref="stylesheet" href="assign/css/plugin.css">
        <link ref="stylesheet" href="assign/css/themes/themes-1.css" id="skin_color" />
        <script type="text/javascript">
            function valid()
            {
                if(document.adddoc.newPassword.value != document.adddoc.cfPassword.value) {
                    alert('Password and Confirm Password field do not match !!');
                    document.adddoc.cfpassword.focus();
                    return false;
                }
                return true;
            }
        </script>
        <script>
            function checkEmailAvailability() {
                $('#loaderIcon').show();
                jQuery.ajax({
                    url : "checkAvailability.php",
                    data : 'emailID=' + $("#docEmail").val(),
                    type : "POST",
                    success : function(data) {
                        $("#email-availability-status").html(data);
                        $("#loaderIcon").hide();
                    },
                    error:function() {}
                });
            }
        </script>
    </head>
<body>
    <div id="app">
         <?php include('../define/sidebar.php');?>
         <div class="app-content">
              <?php  include('../define/header.php');?>
              <div class="main-content">
                   <div class="wrap-content container" id="container">
                        <!-- page title -->
                        <section id="page-title">
                            <div class="row">
                                <div class="col-sm-8"><h1 class="mainTitle">Add Doctor | Admin Management System</h1></div>
                                <ol class="breadcrumb">
                                     <li><span>Admin</span></li>
                                     <li class="active"><span>Add Doctor</span></li>
                                </ol>
                            </div>
                        </section>
                        <!-- content -->
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-white">
                                        <div class="panel-heading"><h5 class="panel-title">Add Doctor</h5></div>
                                        <div class="panel-body">
                                            <form role="form" name="adddoc" method="post" onSubmit="return valid();">
                                                 <div class="form-group">
                                                      <label for="DoctorSpecial">Doctor Specialize</label>
                                                      <select name="doctorSpecial" class="form-control" requried="true">
                                                    <?php $qDs=mysqli_query($deal,"SELECT * FROM doctorSpecialized");
                                                        while($result=mysqli_fetch_array($qDs)){
                                                    ?>
                                                            <option value="<?php echo htmlentities($result['specialized']);?>">
                                                                 <?php echo htmlentities($result['specialized']);?>
                                                            </option>
                                                    <?php } ?>
                                                      </select>
                                                 </div>
                                                 <div class="form-group">
                                                      <lable for="DoctorName">Doctor Name</label>
                                                      <input type="text" name="doctorname" class="form-control" placeholder="Enter Doctor Clinic Address" requried="true">
                                                 </div>
                                                 <div class="form-group">
                                                      <label for="ConsultFees">Consultancy Fees</label>
                                                      <input type="text" name = "consualtfees" class="form-control" placeholder="Doctor Consultancy Fees" required="true">
                                                 </div>
                                                 <div class="form-group">
                                                      <label for="ClinicAddress">Clinic Address</label>
                                                      <textarea type="text" name="clinicaddress" class="form-control" placeholder="Clinic Address" required="true"></textarea>
                                                 </div>
                                                 <div class="form-group">
                                                      <label for="contactno">Contact Number</label>
                                                      <input type="text" name="contactno" class="form-control" placeholder="Contact Number" required="true">                                                    
                                                 </div>
                                                 <div class="form-group">
                                                      <label for="Email">Email</label>
                                                      <input type="email" name="doctorEmail" id="docEmail" class="form-control" placeholder="Email" required="true" onBlur="checkEmailAvailability()">
                                                      <span id="email-availability-status"></span>
                                                 </div>
                                                 <div class="form-group">
                                                      <label for="NewPasswrod">Password</label>
                                                      <input type="password" name="newpassword" class="form-control" placeholder="New Password" required="required" >
                                                 </div>
                                                 <div class="form-group">
                                                      <label for="ConfirmPassword">Confirm Password</label>
                                                      <input type="password" name="cfpassword" class="form-control" placeholder="Confirm Password" required="required">
                                                 </div>
                                                 <button type="submit" name="submit" id="submit" class="btn btn-o btn-priamry">Submit</button>S
                                            </form>
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
    <script src="../assign/js/min.js"></script>
    <script src="../assign/js/formElements.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            FormElement.init();
        });
    </script>
</body>
</html>
