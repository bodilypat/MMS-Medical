<?php
    session_start();
    error_reporting(0);
    include('../config/dbconnect.php');
    if(strlen($_SESSION['id']==0)){
        header('location:logout.php');
    } else {
        date_default_timesize_set('UTC');
        $currentTime = date('d-m-Y h:i:s A', time() );

        if(isset($_POST['submit'])){
            $cPass=md5($_POST['cpass']);
            $did=$_SESSION['id'];
            $qDoc=mysqli_query($deal,"SELECT password FROM doctors WHERE password='$cPass' && id='$did' ");
            $result=mysqli_fetch_array($qDoc);

            if($result>0){
                $nPass=md5($_POST['npass']);
                $eDoc = mysqli_query($deal,"UPDATE doctors SET password='$nPass', updatingDate='$currentTime' WHERE id='$did' ");
                $_SESSION['msg']="Password Changed Successfully !!";
            } else {
                $_SESSION['msg']="Old Password not match !!";
            }
        }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Doctor | change Password</title>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="../asset/css/styles.css">
        <script type="text/javascript">
            function valid()
            {
                if(document.changpwd.cpass.value=="")
                {
                    alert("Current Password Filed is Empty !!");
                    document.changpwd.cpass.focus();
                    return false;
                } else if(document.changpwd.npass.value==""){
                    alert("New Password Filed is Empty !!");
                    document.changpwd.cfpass.focus();
                    return false;
                } else if(document.changpwd.cfpass.value==""){
                    alert('Confirm Password Filed is Empty !!');
                    document.changpwd.cfpass.focus();
                    return false;
                } else if(document.changpwd.npass.value!=document.changpwd.cfpass.value){
                    alert('Password and Confirm Password Field do not match !!');
                    document.changpwd.cfpass.focus()
                }
                return true;
            }
        </script>

    </head>
<body>
    <div id="app">
        <!-- Outline : Layouts -->
        <?php include('../layouts/sidebar.php');?>
        <div class="app-content">
            <?php include('../layouts/header.php');?>
            <div class="main-content">
                <div id="container" class="wrap-content container" >
                    <!-- PAGE TITLE -->
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8"><h2 class="mainTitle">Doctor | Change Password</h1></div>
                            <ol class="breadcrumb">
                                 <li><span>Doctor</span></li>
                                 <li class="active"><span>Change Password</span></li>
                            </ol>
                        </div>
                    </section>
                    <!-- Container -->
                    <div class="container-fluid container full bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row margin-top-30">
                                    <div class="col-lg-8 col-md-12">
                                        <div class="panel panel-white">
                                            <div class="panel-heading"><h5 class="panel-title">Change Password</h5></div>
                                            <div class="panel-body">
                                                <p style="color:red;">
                                                    <?php echo htnlentities($_SESSION['msg']);?>
                                                    <?php echo htmlentities($_SESSION['msg']);?>
                                                </p>
                                                <form  role="form" name="changpwd" method="post" onSubmit="return valid();">
                                                    <div class="form-group">
                                                        <label for="CurrentPassword">Current Password</label>
                                                        <input type="password" name="cpass" class="form-control" placeholder="Current Password">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="NewPassword">New Password</label>
                                                        <input type="password" name="npass" class="form-control" placeHolder="New Password">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ConfirmPassword">Confirm Password</label>
                                                        <input type="password" name="cfpass" class="form-contrpl" placeholder="Confirm Password">
                                                    </div>
                                                    <button type="submit" name="submit" class="btn btn-o btn-primary"></button>
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
        <!-- Outline : Footer -->
        <?php include('../layouts/footer.php');?>
        <?php include('../layout/setting.php');?>
    </div>
    <!-- Custom JS -->
    <script src="../asset/js/main.js"></script>
    <script src="../asset/js/form-elements.js"></script>
    <script>
        jQuery(document).ready(function(){
            Main.init();
            Form-elements.init();
        });
    </script>
</body>
</html>
<?
    }
?>