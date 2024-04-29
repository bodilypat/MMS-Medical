<?php
    session_start();
    include('../define/config.php');
    include('../define/checkLogin.php');
    check_login();
    if(isset($_POST['submit']))
    {
        $userName=$_POST['fullname'];
        $userAdd = $_POST['address'];
        $uCity = $_POST['city'];
        $userGen = $_POST['gender'];

        $qUser=mysqli_query($deal,"UPDATE users set fullname='$userName', address='$userAdd',' city='$uCity',' gender='$userGen',' 
                                    WHERE id='".$_SESSION['id']."'");
        if($qUser)
        {
            $msg="Your Profile updated Successfully";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
         <title>User | Edit Profile</title>
         <!-- custom style -->
         <link rel="stylesheet" href="../assign/css/styless.css">
         <link rel="stylesheet" href="../assign/css/plugins.css">
         <link rel="stylesheet" href="../assign/css/theme/theme-1.css" id="skin_color" />
    </head>
    <body>
        <div class="application">
            <div class="application-content">
                <div class="main-content">
                    <div class="wrap-content container" id="container">
                         <!-- section: page title -->
                        <section id="page-title">
                               <div class="row">
                                    <div class="col-sm-8"><h1 class="mainTitle">User | Edit Profile</h1></div>
                                    <ol class="breadcrumb">
                                         <li><span>User</span></li>
                                         <li><span>Edit Profile</span></li>
                                    </ol>
                               </div>
                        </section>
                         <!-- get data -->
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12"><h5 style="color: green; font-size:18px;"><?php if(msg) { echo htmlentities($msg);}?></h5>
                                    <div class="row margin-top-30">
                                        <div class="col-lg-8 col-md-12">
                                            <div class="panel panel-white">
                                                 <div class="panel-heading"><h5 class="page-title">Edit Profile</div>
                                                 <div class="panel-body">
                                                    <?php
                                                        $qUser=myqli_query($deal,"SELECT * FROM users WHERE id='".$_SESSION['id']."'");
                                                        while($result=mysqli_fetch_array($qUser))
                                                        {
                                                    ?>
                                                    <h4><?php eho htmlentities($result['fullname']);?>'s Profile'</h4>
                                                    <p><b>Profile Registration Date:</b><?php echo htmlentities($result['regisDate']);?></p>
                                                    <?php if($result['updateDate']){ ?> 
                                                        <p><b>Profile Last Updation Date: </b><?php echo htmlentities($result['updateDate']);?></p>
                                                        <?php  }?>
                                                        <br />
                                                    <form name="editProfile" role="form" method="post">
                                                        <div class="form-group">
                                                            <label for="FullName">User Name</label>
                                                            <input name="fullname" type="text" class="form-control"
                                                                   value="<?php echo htmlentities($result['fullname']);?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Address">Address<label>
                                                            <textarea name="address" type="text" class="form-control" >
                                                                <?php echo htmlentities($result['address']);?>
                                                            <textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="city">City</label>
                                                            <input name="city" type="text" control="form-control" 
                                                                   value="<?php echo htmlentities($result['city']);?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Gender">Gender</label>
                                                            <select>
                                                                <option value="<?php echo htmlentities($result['gender']);?>">
                                                                    <?php echo htmlentities($result['gender']);?></option>
                                                                </option>
                                                                <option value="male">Male</option>
                                                                <option value="female">Female</option>
                                                                <option value="other">Other</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="UserEmail">User Email<label>
                                                            <input name="email" type="email" class="form-control" readonly="readonly"
                                                                   value="<?php echo htmlentities($result['email']);?>">
                                                                <a href="changeEmail.php">Update your Email id</a>
                                                        </div>
                                                        <button name="submit" type="submit" class="btn btn-0 btn-primary">
                                                            Update
                                                        </button>
                                                    </form>
                                                     <?php   } ?>
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
        <!-- javascript -->
        <script src="../assign/js/main.js"></script>
        <script src="../assign/js/form-element.js"></script>
        <script>
            jQuery(document).ready(function(){
                Main.init();
                Form.init();
            });
        </script>
    </body>
</html>