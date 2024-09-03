<?php
    session_start();
    error_reporting(0);
    include('../define/congig.php');
    if(strlen($_SESSION['id']==0)) {
        header('location:logout.php');
    } else {
        if(isset($_POST['update'])) {
            $editID = intval($_GET['id']);
            $adminRemark = $_POST['adminremark'];
            $isRead = 1;
            $editEnq = mysqli_query($deal,"UPDATE tblcontactus SET adminRemark='$adminRemark', isRead='$isRead' WHERE id='$editID' ");
            if($editEnq) {
                echo "<script>alert('Admin Remark updated successfully. ');</script>";
                echo "<script>window.location.hrf='readEnquiry.php'</script>";
            }
        }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Enquiry Details | Admin Management </title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color"/>
    </head>
<body>
    <div id="app">
        <?php include('../define/sidebar.php');?>
        <div class="app-content">
            <?php include('../define/header.php');?>
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    <!-- page title -->
                    <select id="page-title">
                        <div class="row">
                            <ol class="breadcrumb">
                                 <li><span>Admin</span></li>
                                 <li class="active"><span>Enquiry Detials</span></li>
                            </ol>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="over-title margin-bottom-15">Manage<span class="text-bold">Enquiry Details</span><//h5>
                                <table class="table table-hover" id="enquiry-table">
                                     <tbody>
                                        <?php
                                            $enqID = $_GET['enqid'];
                                            $qEnq = mysqli_query($deal,"SELECT * FROM tblcontactus WHERE id='$enqID' ");
                                            $count =1;
                                            while($result=mysqli_fetch_array($qEnq)) {
                                        ?>
                                           <tr>
                                                <th>Full Name</th>
                                                <td><?php echo $result['fullname'];?></td>      
                                           </tr>
                                           <tr>
                                                <th>Email ID</th>
                                                <td><?php echo $result['email'];?></td>
                                           </tr>
                                           <tr>
                                                <th>Contact Number</th>
                                                <td><?php echo $result['contactno'];?></td>
                                           </tr>
                                           <tr>
                                                <th>Message</th>
                                                <td><?php echo $result['message'];?></td>
                                           </tr>
                                           <tr>
                                                <th>Enquiry Date</th>
                                                <td><?php echo $result['postDate'];?></td>
                                           </tr>
                                           <?php if($result['adminRemark' ==""]) { ?>
                                            <form name="enquiry" method="post">
                                                <tr>
                                                     <th>Admin Remark</th>
                                                     <td><textarea name="adminremark" class="form-control" required="true"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <button type="submit" class="btn btn-primary pull-left" name="update">update
                                                        <i class="fa fa-arrow-circle-right"></i>
                                                    </button>
                                                </tr>
                                            </form>
                                            <?php }  else {?>
                                                <tr>
                                                    <th>Admin Remark</th>
                                                    <td><?php echo $result['adminRemark'];?></td>
                                                </tr>
                                                <tr>
                                                    <th>Last  Updation Date</th>
                                                    <td><?php echo $result['lastUpdationDate'];?></td>
                                                </tr>
                                            <?php 
                                            }} ?>
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
        jQuery(document).ready(function() {
            Main.init();
            FormElements.init();
        });
    </script>
</body>
</html>
<?php    } ?>