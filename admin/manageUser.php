<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(strlen($_SESSION['id']==0)) {
        header('location: logout.php');
    } else {
        if(isset($_GET['delid'])) {
            $delID = $_GET['delid'];
            mysql_query($deal,"DELETE FORM tblusers WHERE ID='$delid' ");
            $_SESSION['msg'] = "data deleted";
        }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Manage User | Admin Management System</title>
        <!-- custom css -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/theme/theme-1.css" id="skin_color">
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
                            <div class="col-sm-8"><h1 class="mainTitle">Admin | Manage Users<h1></div>
                            <ol class="breadcrumb">
                                 <li><span>Admin</span></li>
                                 <li class="active"><span>Manage Users</li>
                            </ol>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="over-title margin-bottom 15">Manage<span class="text-bold">Users</span></h5>
                                <p style="color:red;"><?php echo htmlentities($_SESSION['msg']);?>
                                    <?php echo htmlentities($_SESSION['msg']);?>
                                </p>
                                <table class="table table-hover" id="users-table">
                                    <thead>
                                        <tr>
                                              <th class="center">#</th>
                                              <th>Full Name</th>
                                              <th class="hidden-xs">Address</th>
                                              <th>City</th>
                                              <th>Gender</th>
                                              <th>Email</th>
                                              <th>Creation Date</th>
                                              <th>Updation Date</th>
                                              <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $qUser = mysqli_query($deal,"SELECT * FROM users");
                                        $count = 1;
                                        while($result=mysqli_fetch_array($qUser)){
                                    ?>
                                        <tr>
                                              <td class="center"><?php echo $count;?>.</td>
                                              <td class="hidden-xs"><?php echo $result['fullName'];?></td>
                                              <td><?php echo $result['address'];?></td>
                                              <td><?php echo $result['city'];?></td>
                                              <td><?php echo $result['gender'];?></td>
                                              <td><?php echo $result['email'];?></td>
                                              <td><?php echo $result['regDate'];?></td>
                                              <td><?php echo $result['updationDate'];?></td>
                                              <td>
                                                   <div class="visible-md  visible-lg hidden-sm hidden-xs">
                                                        <a href="manageUsers.php?delid=<?php echo $result['id'];?>&del=delete" 
                                                            onClick="return confirm('Are you sure want to delete?')"
                                                            class="btn btn-transparent btn-xs tooltip" tooltip-placement="top" tooltip="remove">
                                                            <i class="fa fa-items fa-fa-white"></i>
                                                        </a>
                                                   </div>
                                                   <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                        <button type="btn group" dropdown is-open="status.isopen">
                                                             <i class="fa fa-cog">&nbsp;<span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu pull-right dropdown-light" role="menu">
                                                            <li><a href="#editUser.php">Edit</a></li>
                                                            <li><a href="#">Share</li>
                                                            <li><a href="#manageUsers.php">Remove</a></li>
                                                        </ul>
                                                   </div>
                                              </td>
                                        </tr>
                                    <?php $count = $count+1; } ?>
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
    <!-- custom javascrpt -->
    <scritp src="../assign/js/main.js"></script>
    <script src="../assign/js/formElements.php"></script>
    <script>
        jQuery(document).ready(function(){
            Main.init();
            FormElements.init();
        });
    </script>
</body>
</html>
<?php    } ?>