<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(strlen($_SESSION['id']==0)){ 
        header('location: logout.php');
    } else {
        date_default_timezone_set('America/Monterrey');
        $currentTime = date('d-m-Y h:i:s A', time () );

        if(isset($_POST['submit'])) {
            $currentPass = md5($_POST['currentpassword']);
            $docID = $_SESSION['id'];
            $qDoc = mysqli_query($deal,"SELECT password FROM doctors WHERE password='$currentPass' && id='$docID' ");
            $result = mysqli_fetch_array($qDoc);
            if($result > 0) {
                $newPass = md5($_POST['newpass']);
                $qDoc = mysql_query($deal,"UPDATE doctors SET password='$newPass', updationDate='$currentTime' WHERE id='$docID' ");
                $_SESSION['msg'] = "Password Changed Successfull !!";
            } else {
                $_SESSION['msg'] = "Old Password not match !!";
            }
        }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Doctor | Change Password</title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/themes/themes-1.css" id="skin_color" />
        <script type="text/javascript">
            function valid() {
                if(document.changpwd.cPassword.value==""){
                    alert("Current Password Filed is Empty !!");
                    document.changpwd.cPassword.focus();
                    return false;
                } else if(document.changpwd.nPassword.value==""){
                    alert("New Password Filed is Empty !!");
                    document.changpwd.nPassword.focus();
                    return false;
                } else if(document.changpwd.cfPassword.value=="") {
                    alert("Confirm Password filed is Empty !!");
                    document.changpwd.cfPassword.focus();
                    return false;
                } else if(document.changpwd.nPassword.value != document.changpwd.cfPassword.value){
                    alert("Password and Confirm Password Filed do not match !!");
                    document.changpwd.cfPassword.focus();
                    return false;
                }
                return true;
            }
        </script>
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
                            <div class="col-sm-8"><h1 class="mainTitle">Doctor | Change Password</h1></div>
                            <ol class="breadcrumb">
                                 <li><span>Doctor</span></li>
                                 <li class="active">Change Password</li>
                            </lo>
                        </div>
                    </section>
                    <!-- page content -->
                    <div class="container-fluid container-full bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row margin-top-30">
                                    <div class="col-lg-8 col-md-12">
                                        <div class="panel panel-white">
                                            <h1 class="panel-title">Change  Password</h5>
                                        </div>
                                        <div class="panel-body">
                                            <?php echo htmlentities($_SESSION['msg']);?>
                                            <?php echo htmlentities($_SESSION['msg']);?>
                                        </div>
                                        <form role="form" name="changpwd" method="post" onSubmit="return valid();">
                                            <div class="form-group">
                                                <label for="CurrentPassword">Current Password</label>
                                                <input type="password" name="cPassword" class="form-control" placeholder="Current Password">
                                            </div>
                                            <div class="form-group">
                                                <label for="NewPassword">New Password</label>
                                                <input type="password" name="nPassword" class="form-control" placehoder="New Password">
                                            </div>
                                            <div class="form-group">
                                                <label for="ConfirmPassword">Confirm Password</label>
                                                <input type="password" name="cfPassword" class="form-control" placeholder="confirm Password">
                                            </div>
                                            <button type="submit" name="submit" class="btn btn-o btn-primary">Submit</button>
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
    <script src="../assign/js/main.js"></script>
    <script src="../assign/js/formElements.js"></script>
    <script>
            jQuery(document).ready(function(){})
    </script>
</body>
</html>
<?php    } ?>