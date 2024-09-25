<?php
    session_start();
    error_reporting(0);
    
    include('../config/dbconnect.php');
    if(strlen($_SESSION['id']==0)){
        header('location:login.php');
    } else {
?>
<!DOCTYPE html>
<head>
    <title>Doctor | Manage Doctors</title>
    <!-- Custom Css -->
    <link rel="stylesheet" href="../asset/css/styles.css">
</head>
<body>
    <div id="app">
        <!-- Outline: Navbar -->
        <?php include('../layouts/sidebar.php');?>
        <div class="app-content">
            <!-- Outline: header -->
            <?php include('../layouts/header.php');?>
            <div class="main-content">
                <!-- PAGE TITLE -->
                <section id="page-title">
                    <div class="row">
                        <div class="col-sm-8"><h1 class="mainTitle">Doctor | Manage Doctors</h1></div>
                        <ol>
                             <li><span>Doctors</span></li>
                             <li class="active"><span>Manage Doctors</span></li>
                        </ol>
                    </div>
                </section>
                <!-- container -->
                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Manage<span class="text-bold">Doctor</span></h5>
                            <table class="table table-over" id="doctor-table">
                                <thead>
                                    <tr>
                                         <th>ID</th>
                                         <th>Name</th>
                                         <th>Specialty</th>
                                         <th>Phone</th>
                                         <th>Email</th>
                                         <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $docId = $_SESSION['id'];
                                    $qDoc = mysqli_query($deal,"SELECT * FROM doctors ");
                                    $count = 1;
                                    while($result=mysqli_query($qDoc))
                                    {
                                ?>
                                    <tr>
                                         <td class="center"><?php echo $count; ?></td>
                                         <td class="hidden-xs"><?php echo $result['name'];?></td>
                                         <td><?php echo $result['specialty'];?></td>
                                         <td><?php echo $result['phone'];?></td>
                                         <td><?php echo $result['email'];?></td>
                                         <td>
                                            <a href="edit-doctor.php?editid=<?php echo $result['id'];?>"><i class="fa fa-edit"></i></a>||
                                            <a href="delete-doctor.php?delid=<?php echo $result['id'];?>"><i class="fa fa-minus"></i></a>||
                                            <a href="view-doctors.php?viewid=<?php echo $result['id'];?>"><i class="fa fa-eye"></i></a>
                                         </td>
                                    </tr>
                                    <?php $count=$count+1; }  ?>
                                </tbody>
                            </table>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Outline : FOOTER -->
        <?php include('../layouts/footer.php');?>
        <?php include('../layouts/setting.php');?>
    </div>
    <!-- Custom JS -->
    <script>
        
    </script>
</body>
<?php
    }
?>
