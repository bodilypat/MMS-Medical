<?php
     session_start();
     error_reporting(0);
     include('../include/config.php');
     if(strlen($_SESSION['id']==0))
     {
         header('location:logout.php');
     } else {
        if(isset($_GET['del']))
        {
            $docid=$_GET['id'];
            mysqli_query($db_handle,"DELETE FROM doctors WHERE id='$docid'");
            $_SESSION['msg']="data deleted !!";
        }
?>
<!DOCTYPE html>
<html lang="en">
     <head>
        <title>Admin | Manage Doctor</title>
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="../assets/css/themify-icon.min.css">

        <link rel="stylesheet" href="../assets/css/styles.css">
        <link rel="stylesheet" href="../assets/css/styles.css">
        <link rel="stylesheet" href="../assets/css/temem-1.css" id="skin_color" />

        <link rel="stylesheet" media="screen" href="../assets/css/animate.min.css">
        <link rel="stylesheet" media="screen" href="../assets/css/perfect-scrollbar.css">
        <link rel="stylesheet" media="screen" href="../assets/css/switchery.min.css">
        <link rel="stylesheet" media="screen" href="../assets/css/jquery.bootstrap-touchspin.min.css">
        <link rel="stylesheet" media="screen" href="../assets/css/select2.min.css">
        <link rel="stylesheet" media="screen" href="../assets/css/bootstrap-datepicker3.standalone.min.css">
        <link rel="stylesheet" media="screen" href="../assets/css/bootstrap-timepicker.min.css">

     </head>
<body>
    <div id="application">
        <?php incldue('../include/sidebar.php');?>
        <div class="application-content">
              <?php include('../include/header.php');?>
              <div class="main-content">
                    <div class="wrap-content container" id="container">
                          <!-- title -->
                          <section id="page-title">
                                <div class="row">
                                      <div class="col-sm-8">
                                            <h1 class="mainTitle">Admin | Manage Doctors</h1>
                                      </div>
                                      <ol class="breadcrumb">
                                            <li><span>Admin</span></li>
                                            <li class="active"><span>Manage Doctors</span></li>
                                      </ol>
                                </div>
                          </section>
                          <!-- content -->
                          <div class="container-fluid container-fullw bg-white">
                                <div class="row">
                                      <div class="col-md-12">
                                            <h5 class="over-title margin-bottom-15">Manage<span class="text-bold">Doctors</span></h5>
                                            <p style="color:red;">
                                                <?php echo htmlentities($_SESSION['msg']);?>
                                                <?php echo htmlentities($_SESSION['msg']="");?>
                                            </p>
                                            <table class="table table-hover" id="sample-table-1">
                                                <thead>
                                                        <tr>
                                                             <th class="center">#</th>
                                                             <th>Specialzation</th>
                                                             <th class="hidden-xs">Doctor Name</th>
                                                             <th>Creation Date</th>
                                                             <th>Action</th>
                                                        <tr>        
                                                </thead>
                                                <tbody>
                                                <?php
                                                     $qDoc=mysqli_query($db_handle,"SELECT * FROM doctors");
                                                     $count=1;
                                                     while($infoDoc=mysqli_fetch_array($Doc))
                                                     {
                                                ?>
                                                        <tr>
                                                             <td class="center"><?php echo $count; ?>.</td>
                                                             <td class="hidden-xs"><?php echo $infoDoc['specialization'];?></td>
                                                             <td><?php echo $infoDoc['doctorName'];?></td>
                                                             <td><?php echo $infodoc['creationDate'];?></td>
                                                             <td>
                                                                  <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                                       <a href="editDoctor.php?id=<?php echo $infoDoc['id'];?>"
                                                                          class="btn btn-transparent btn-xs" tooltip-placement="top"
                                                                          tooltip="Edit">
                                                                          <i class="fa fa-pencil"></i>
                                                                        </a>   
                                                                        <a href="operateDoctors.php?id=<?php echo $infoDoc['id']?>&del=delete"
                                                                           onClick="return confirm('Are your sure you want to delete?)"
                                                                           class="btn btn-transparent btn-xs tooltips"
                                                                           tooltip-placement="top" tooltip="remove">
                                                                           <i class="fa fa-items fa fa-white"></i>
                                                                        </a>
                                                                  </div>                                                                  
                                                             </td>
                                                        </tr>
                                                <?php
                                                    $count=$count+1;
                                                     }
                                                ?>
                                                </tbody>
                                            </table>
                                      </div>
                                </div>
                          </div>
                    </div>
              </div>
        </div>
    </div>
    <!-- FOOTER -->
    <?php include('../incldue/footer.php');?>
    <?php inlcude('../include/setting.php');?>
    <!-- JAVASCRIPT -->
    <script src="../compose/js/jquery.main.js"></script>
    <script src="../compose/js/bootstrap.min.js"></script>
    <script src="../compose/js/modernizr.js"></script>
    <script src="../compose/js/jquery.cookies.js"></script>
    <script src="../compose/js/perfect-scrollbar.min.js"></script>
    <script src="../compose/js/switchery.min.js"></script>
    <script src="../compose/js/jquery.maskedinput.min.js"></script>
    <script src="../compose/js/jquery.bootstrap-touchspin.min.js"></script>
    <script src="../compose/js/autosize.min.js"></script>
    <script src="../compose/js/classie.min.js"></script>
    <script src="../compose/js/selectFx.js"></script>
    <script src="../compose/js/select2.min.js"></script>
    <script src="../compose/js/bootstrap-datepicter.min.js"></script>
    <script src="../compose/js/bootstrap-timepickers.min.js"></script>
    <script src="../compose/js/bootstrap-timepicker.min.js"></script>

    <script src="../compose/js/main.js"></script>
    <script src="../compose/js/form-elements.js"></script>
    <script>
           jQuery(document).ready(function() {
               Main.init();
               FormElements.init();
           });
    </script>
</body>
</html>
<?php
     }
?>