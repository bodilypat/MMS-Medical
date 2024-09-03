<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(strlen($_SESSION['id'])) {
        header('location:logout.php');
    } else {
        if(isset($_POST['submit'])) {
            $pageTitle = $_POST['pagetitle'];
            $pageDes = $_POST['pagedescription'];
            $contactno = $_POST['contactnumber'];
            $qCon = mysqli_query($deal,"UPDATE tblpage SET pageTitle='$pagetitle', pageDescrition='$pageDes','email='$email', contactno='$contactno'
                                        WHERE  pageType='$contactus'");

            if($qCon) {
                echo "<script>alert('Contact Us has been Updated.')</script>";
            } else {
                echo "<script>alert('Someting Went Wrong. Please try again.')</script>";
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Contact Us</title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/thems/theme-1.css" id="skin_color">
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
                            <div class="col-sm-8"><h1 class="mainTitle">Admin | Update the Contact us Content</h1></div>
                            <ol class="breadcrumb">
                                 <li><span>Admin</span></li>
                                 <li class="active"><span>Update the Contact us Content</span></li>
                            </ol>
                        </div>
                    </section>   
                    <!-- page content -->  
                    <div class="container-fluid container-full bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="form-contact" method="post">
                                <?php
                                    $qPage = mysqli_query($deal,"SELECT * FROM tblpage WHERE pageType='$contactus' ");
                                    $count =1;
                                    while($result = mysqli_fetch_array($qPage)){
                                ?>
                                    <div class="form-group">
                                        <label for="PageTitle">Page Title</label>
                                        <input type="text" name="pagetitle" class="form-control" required="true" 
                                               value="<?php echo $result['pageTitle'];?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="PageDescription">Page Description</label>
                                        <textarea class="form-control" name="pagedescription" id="pagedescription" rows="5" 
                                                  value="<?php echo $result['pageDescription'];?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="Email">Email</label>
                                        <input type="email" class="form-control" name="email" 
                                               value="<?php echo $result['email'];?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="ContactNumber">Contact Number</label>
                                        <input type="text" class="form-control" name="mobilenumber" 
                                               value="<?php echo $result['contactno'];?>">
                                    </div>
                                <?php $count = $count+1;  } ?>
                                    <button type="submit" class="btn btn-primary mr-2" name="submit">Update<button>
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
    <script src="../assign/js/formElements.php"></script>
    <script>
        jQuery(document).ready(function(){
            Main.init();
            FormElements.init();
        });
    </script>
</body>
</html>
<?php  } ?>