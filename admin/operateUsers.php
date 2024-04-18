<?php
     session_start();
     error_reporting(0);
     include('../include/config.php');
     if(strlen($_SESSION['id']==0))
     {
         header('location:logout.php');
     } else {
                if(isset($_GET['id']))
                {

                }
?>
<!DOCTYPE html>
<html>
     <head>
           <title>Admin | Manage User</title>
           <!-- css -->
           <link rel="stylesheet" href="">
           <link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.js">
           <link rel="stylesheet" href="../assets/css/font/font-awesome.min.css">
           <link rel="stylesheet" href="../assets/css/themify/themify-icon.min.css">
           <!-- css custom -->
           <link rel="stylesheet" href="../assets/css/custom/styles.com">
           <link rel="stylesheet" herf="../assest/css/custom/plugins.css">
           <link rel="stylesheet" href="../assest/css/cust/theme/theme-1.css" id="skin_color">
           <!-- css media -->
           <link rel="stylesheet" media="screen"  href="../assets/css/animate.min.css">
           <link rel="stylesheet" media="screen"  href="../assets/css/perfect-scrollbar.min.css">
           <link rel="stylesheet" media="screen"  href="../assets/css/switchery.min.css">
           <link rel="stylesheet" media="screen"  href="../assets/css/jquery.bootstrap-touchspin.min.css">
           <link rel="stylesheet" media="screen"  href="../assets/css/select2.min.css">
           <link rel="stylesheet" media="screen"  href="../assets/css/bootstrap-datepicker3.standalone.min.css">
           <link rel="stylesheet" media="screen"  href="../assets/css/bootstrap-timepicker.min.css">

     </head>
<body>
       <div id="application">
             <div class="application-content">
                  <div class="main-content">
                        <div id="container" class="wrap-content container">
                             <!-- page title -->
                             <section id="page-title">
                                     <div class="row">
                                           <div class="col-sm-8">
                                                <h1><span>Admin | Manage Users</span></h1>
                                           </div>
                                           <ol>
                                                <li><span>Admin</span></li>
                                                <li class="active"><span>Manage Users</span></li>
                                           </ol>
                                     </div>
                             </section>
                             <!-- content -->
                             <div class="container-fluid container-fullw bg-white">
                                   <div class="row">
                                         <div class="col-md-12">
                                              <h5 class="over-title margin-bottom-15">Manage<span class="text-bold">Users</h5>
                                         </div>
                                         <p><?php echo htmlentities($_SESSION['msg']);?>
                                            <?php echo htmlentities($_SESSION['msg']=="");?>
                                        </p>
                                         <table id="infoUser" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="center">#</th>
                                                    <th>Full Name</th>
                                                    <th>City</th>
                                                    <th>Genger</th>
                                                    <th>Email</th>
                                                    <th>Creation Date</th>
                                                    <th>Updation Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $qUser=mysqli_query($deal,"SELECT * FROM users");
                                                    $count=1;
                                                    while($infouser=mysqli_fetch_array($qUser))
                                                    {
                                                ?>
                                                <tr>
                                                    <td class="center"><?php echo $count;?>.</td>
                                                    <td class="hidden-xs"><?php $infopat['fullName'];?></td>
                                                    <td><?php echo $infofpat['address'];?></td>
                                                    <td><?php echo $infopat['city'];?></td>
                                                    <td><?php echo $infopat['gender'];?></td>
                                                    <td><?php echo $infopat['email'];?></td>
                                                    <td><?php echo $infopat['regDate'];?></td>
                                                    <td><?php echo $infoPat['updationDate'];?></td>
                                                    <td>
                                                        <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                            <a href="operateUsers.php?id=<?php echo $infouser['id']?>&del=delete"
                                                               onClick="return confirm('Are you sure you want to delete?')"
                                                               class="btn btn-tranparent btn-xs tooltips"
                                                               tooltip-placement="top" tooltip="remove">
                                                            </a>
                                                        </div>
                                                        <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                            <div class="btn-group" drapdown is-open="status.isopen">
                                                                <button type ="button" class="btn btn-primary btn-o btn-sm dropdown-toggle" dropdown-toggle>
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
             <div>
            <!-- footer -->
       </div>
       <!-- javascript -->
       <script src="../compose/js/jquery.min.js"></script>
       <script src="../compose/js/bootstrap.min.js"></script>
       <script src="../compose/js/modernizr.js"></script>
       <script src="../compose/js/jquery.cookie.js"></script>
       <script src="../compose/js/perfect-scrollbar.min.js"></script>
       <script src="../compose/js/switchery.min.js"></script>
       <script src="../compose/js/jquery.maskedinput.min.js"></script>
       <script src="../compose/js/jquery.bootstrap-touchspin.min.js"></script>
       <script src="../compose/js/autosize.min.js"></script>
       <script src="../compose/js/classie.js"></script>
       <script src="../compose/js/selectFx.js"></script>
       <script src="../compose/js/select2.min.js"></script>
       <!-- js custom -->
       <script src="../compose/js/main.js"></script>
       <script src="../compose/js/form-elements.js"></script>
       <script>
              jQuery(document).ready(function() {
                  Main.init();
                  FormElements.inits();
              });
       </script>
</body>
</html>
<?php
     }
?>
