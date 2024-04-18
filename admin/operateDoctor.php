<?php
     session_start();
     error_reporting(0);
     include('../include/config.php');
     if(strlen($_SESSION['id']==0))
     {
         header('location:logout.php');
     } else {
              
          if(isset($_GET['del'])) /* get id for delete */
          {
               $docID=$_GET['id'];
               mysqli_query($deal,"DELETE FROM doctors WHERE id='$docID' ");
               $_SESSEION['msg']="data deleted !!";
          }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
          <title>Admin | Manage Doctors</title>
          <!-- css -->
          <link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
          <link rel="stylesheet" href="../assets/css/font/font-awesome.min.css">
          <link rel="stylesheet" href="../assets/css/themify/themify-icons.min.css">
          <!-- css custom -->
          <link rel="stylesheet" href="../assets/css/custom/styles.css">
          <link rel="stylesheet" href="../assets/css/custom/plugins.css">
          <link rel="styelsheet" href="../assets/css/custom/theme-1.css" id="skid_color">
          <!-- css media -->
          <link rel="stylesheet" href="../assets/css/animate.min.css">
          <link rel="stylesheet" href="../assets/css/perfect-scrollbar.min.css">
          <link rel="stylesheet" href="../assets/css/switchery.min.css">
          <link rel="stylesheet" href="../assets/css/jquery.bootstrap-touchspin.min.css">
          <link rel="stylesheet" href="../assets/css/select2.min.css">
          <link rel="stylesheet" href="../assets/css/bootstrap-datapicker3.standalone.min.css">
          <link rel="stylesheet" href="../assets/css/bootstrap-timepicker.min.css">
    </head>
<body>
       <div id="application">
             <?php include('../include/sidebar.php');?>
             <div class="application-content">
                   <?php include('../include/header.php');?>
                   <div class="main-content">
                         <div id="container" class="wrap-content container" >
                               <!-- page title -->
                               <section id="page-title">
                                        <div class="row">
                                              <div class="col-sm-8">
                                                   <h1></h1>
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
                                                 <h5></h5>
                                                 <p></p>
                                                 <table id="infoDoctors" class="table table-hover">
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
                                                              $qDoc=mysqli_query($deal,"SELECT * FROM doctors ");
                                                              $count=1;
                                                              while($infoset=mysqli_fetch_array($Doc))
                                                              {
                                                          ?>
                                                              <tr>
                                                                   <td class="center"><?php echo $count;?>.</td>
                                                                   <td class="hiden-xs"><?php echo $infoset['specialization'];?></td>
                                                                   <td><?php echo $infoset['docName'];?></td>
                                                                   <td><?php echo $infoset['creationDate'];?></td>
                                                                   <td>
                                                                       <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                                             <a href="editDoctor.php?id=<?php echo $infoset['id'];?>"
                                                                                class="btn btn-transparent btn-xs" tooltip-placement="top"
                                                                                tooltip="edit"><i class="fa fa-pencil"></i>
                                                                             </a>
                                                                             <a href="operateDoctor.php?id=<?php echo $infoset['id'];?>&del=delete"
                                                                                onClick="return confirm('Are you sure want to delete?')"
                                                                                class="btn btn-transparent btn-xs tooltips"
                                                                                tooltip-placement="top" tooltip="Remove">
                                                                                <i class="fa fa-times fa fa-white"></i>
                                                                             </a>
                                                                       </div>
                                                                       <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                                             <div class="btn-group" dropdown is-open="status.isopen">
                                                                                   <button>
                                                                                         <i class="fa fa-cog"></i>&nbsp;<span class="caret"></span>
                                                                                   </button>
                                                                                   <ul class="dropdown-menu pull-right dropdown-light" role="menu">
                                                                                        <li><a href="#">Edit</a></li>
                                                                                        <li><a href="#">Share</a></li>
                                                                                        <li><a href="#">Remove</a></li>
                                                                                   </ul>
                                                                             </div>
                                                                       </div>
                                                                    </td>
                                                              </tr>
                                                            <?php } ?>
                                                       </tbody>
                                                 </table>
                                           </div>
                                     </div>
                               </div>
                         </div>
                   </div>
             </div>
             <!-- footer -->
             <?php include('../include/footer.php');?>
             <?php include('../include/setting.php');?>
       </div>
       <!-- javascript -->
       <script src="../compose/js/jquery.min.js"></script>
       <script src="../compose/js/boostrap.min.js"></script>
       <script src="../compose/js/modernir.js"></script>
       <script src="../compose/js/jquery.cookie.js"></script>
       <script src="../compose/js/perfect-scrollbar.min.js"></script>
       <script src="../compose/js/switchery.min.js"></script>
       <script src="../compose/js/jquery.maskedinput.min"></script>
       <script src="../compose/js/jquery.bootstrap-touchspin.min.js"></script>
       <script src="../compose/js/autosize.js"></script>
       <script src="../compose/js/classie.js"></script>
       <script src="../compose/js/slectFx.js"></script>
       <script src="../compose/js/selectFx.js"></script>
       <script src="../compose/js/bootstrap-datepicker.min.js"></script>
       <script src="../compose/js/bootstrap-timepicker.min.js"></script>
       <!-- js custom -->
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
