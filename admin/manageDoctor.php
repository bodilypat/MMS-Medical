<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(strlen($_SESSION['id']==0)) {
        header('location: logout.php');
    } else {
        if(isset($_GET['delid'])) {
            $docID = $_GET['delid'];
            mysqli_query($deal,"DELETE FROM doctors WHERE id='$delID' ");
            $_SESSION['msg'] = "data deleted !!";
        }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Manage Doctor | Admin Management system</title>
        <!-- custom styles -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color">
    </head>
<body>
    <div id="app">
        <?php include('../define/sidebar.php');?>
        <div class="app-content">
            <?php include('../define/header.php');?>
            <!-- main content -->
            <div class="main-content">
                 <div class="wrap-content container" id="container">
                    <!-- page title -->
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8"><h1 class="mainTitle">Admin | Manage Doctors</h1></div>
                            <ol class="breadcrumb">
                                <li><span>Admin</span></li>
                                <li class="active"><span>Manage Doctors</span></li>
                            </ol>
                        </div>
                    </section>
                    <div class="container-fluid containser-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="over-title margin-bottom-15">Manage<span class="text-bold">Doctors</span></h5>
                                <p style="color:red;">
                                    <?php echo htmlentities($_SESSION['msg']);?>
                                    <?php htmlentities($_SESSION['msg']=="");?>
                                </p>
                                <table class="table table-hover" id="doctor-table">
                                    <thead>
                                        <tr>
                                             <th class="center">#</th>
                                             <th>Specialization</th>
                                             <th class="hidden-xs">Doctor Name</th>
                                             <th>Creation Date</th>
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $qDoc = mysqli_query($deal,"SELECT * FROM doctors");
                                            $count = $count +1;
                                            while($result=mysqli_fetch_array($qDoc)){
                                        ?>
                                        <tr>
                                             <td class="center"><?php echo $count;?>.</td>
                                             <td class="hidden-xs"><?php echo $result['specialized'];?></td>
                                             <td><?php echo $result['doctorName'];?></td>
                                             <td><?php echo $result['creationDate'];?></td>
                                             <td>
                                                  <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                       <a  href="editDoctor.php?editid=<?php echo $result['id'];?>" class="btn btn-transparent btn-xs" 
                                                           tooltip-placement="top" tooltip="Edit"><i class="fa fa-pancil"></i>
                                                       </a>
                                                       <a  href="manageDoctor.php?delid=<?php echo $result['id'];?>$del=delete" onClick="return confirm('Are you sure wan to delete?')"
                                                           class="btn btn-transparent btn-xs tooltips" tooltip-placement="top" tooltip="remove">
                                                           <i class="fa fa-times fa fa-white"></i>
                                                      </a>
                                                  </div>
                                                  <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                       <button type="button" class="btn btn-primary btn-o btn-sm dropdown-toggle" dropdown-toggle>
                                                            <i class="fa fa-cog"></i>&nbsp;<span class="caret"></span>
                                                       </button>
                                                       <ul class="dropdown-menu pull-right dropdown-ligh" role="menu">
                                                            <li><a href="#editDoctor.php"> Edit </li>
                                                            <li><a href="#"></a></li>
                                                            <li><a href="#manageDoctor.php"></a>Remove</li>
                                                       </ul>
                                                  </div>
                                             </td>
                                        </tr>
                                        <?php  } ?>
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