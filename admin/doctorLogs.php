<?php
    session_start();
    include('../define/config.php');
    if(strlen($_SESSION['id']==0)){
        header('location:logout.php');
    } else {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Doctor Session Logs</title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/theme/theme-1.css" id="skin_color">
    </head>
<body>
    <div id="app">
        <?php include('../define/sidebar.php');?>
        <div class="app-content">
            <?php include('../defin/header.php');?>
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    <!-- page title -->
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8"><h1 class="mainTitle">Admin | Doctor Session Logs</h1></div>
                            <ol class="breadcrumb">
                                <li><span>admin</span></li>
                                <li class="active"><span>Doctor Session Logs</span></li>
                            </ol>
                        </div>
                    </section>
                     <!-- page content -->
                    <div class="table table-hover" id="user-table-1">
                        <div class="row">
                            <div class="col-md-12">
                                <p style="color:red;">
                                    <?php echo htmlentities($_SESSION['msg']);?>
                                    <?php echo htmlentities($_SESSION['msg']);?>
                                </p>
                                <table class="table table-hover" id="user-table-1">
                                    <thead>
                                        <tr>
                                            <th class="center">#</th>
                                            <th class="hidden-xs">User ID</th>
                                            <th>Username</th>
                                            <th>User IP</th>
                                            <th>Login Time</th>
                                            <th>Logout Time</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $qDocl = mysqli_query($deal,"SELECT * FROM doctorlog ");
                                            $count = 1;
                                            while($result = mysqli_fetch_array($qDocl)){
                                        ?>                                            
                                        <tr>
                                             <td class="center"><?php echo $count; ?>.</td>
                                             <td class="hidden-xs"><?php echo $result['userID'];?></td>
                                             <td class="hidden-xs"><?php echo $result['username'];?></td>
                                             <td><?php echo $result['userIP'];?></td>
                                             <td><?php echo $ressult['loginTime'];?></td>
                                             <td><?php echo $result['logout'];?></td>
                                             <td>
                                                <?php
                                                    if($result['status']==1){
                                                        echo "Success";
                                                    } else {
                                                        echo "Failed";
                                                    }
                                                ?>
                                             </td>
                                        </tr>
                                        <?php $count=$count+1; }?>
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
        jQuery(document).ready(function(){
            Main.init();
            FormElements.init();
        });
    </script>
</body>
</html>
<?php    } ?>