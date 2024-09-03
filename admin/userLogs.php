<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(strlen($_SESSION['id'])) {
        header('location: logout.php');
    } else {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>User Session Logs | Admin</title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/pluins.css">
        <link rel="styelsheet" href="../assign/css/theme/theme-1.css" id="skin_color">
    </head>
<body>
    <div id="app">
        <?php include('../define/sidebar.php');?>
        <div class="app-content">
            <?php include('../define/header.php');?>
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8"><h1 class="mainTitle">User Session Logs | Admin <h1></div>
                            <ol class="breadcrumb">
                                 <li><span>Admin</span></li>
                                 <li class="active"><span>User Session Logs</span></li>
                            </ol>
                        </div>
                    </section>
                    <!-- content -->
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <p style="color:red;">
                                <?php echo htmlentities($_SESSION['msg']);?>
                                <?php echo htmlentities($_SESSION['msg']=="");?>
                            </p>
                            <table class="table table-hover" id="userLog-table">
                                <thead>
                                     <tr>
                                           <th class="center">#</th>
                                           <th class="hidden-xs">User ID</th>
                                           <th>Username</th>
                                           <th>User IP</th>
                                           <th>Login time</th>
                                           <th>Logout Time</th>
                                           <th>Status</th>
                                     </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $qUser = mysqli_query($deal,"SELECT * FROM userLog");
                                    $count = 1;
                                    while($result = mysqli_fetch_array($qUser)) {
                                ?>
                                     <tr>
                                           <td class="center"><?php echo $count;?>.</td>
                                           <td class="hidden-xs"><?php echo $result['userID'];?></td>
                                           <td class="hidden-xs"><?php echo $result['userName'];?></td>
                                           <td><?php echo $result['userIP'];?></td>
                                           <td><?php echo $result['loginTime'];?></td>
                                           <td><?php echo $result['logout'];?></td>
                                           <td>
                                                <?php if($result['']==1){
                                                    echo 'success';
                                                } else {
                                                    echo 'Failed';
                                                } ?>
                                           </td>
                                     </tr>
                                    <?php $count $count+1; }?>
                                </tbody>
                            </table>                     
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
            FormElement.init();
        });
    </script>
</body>
</html>
    }