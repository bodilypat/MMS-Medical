<?php
    session_start();
    error_reporting(0);
    
    include('../config/dbconnect.php');
    if(strlen($_SESSION['id']==0)){
        header('location:login.php');
    } else {
        $patient_id = $_GET['editapp']?? null;

    $appStmt = mysqli_query($deal,"SELECT a.*, p.name as patient_name, d.name as doctor_name
                                        FROM appointments a JOIN patients p ON a.patient_id = p.id 
                                                            JOIN doctors d ON a.doctor_id = d.id  
                                        WHERE a.patient_id = '$patient_id' ");
    $appointments = $appStmt->fetchAll();

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
                            <h5>Manage<span class="text-bold">Appointment</span></h5>
                            <table class="table table-over" id="doctor-table">
                                <thead>
                                    <tr>
                                         <th>ID</th>
                                         <th>Patient Name</th>
                                         <th>Doctor Name</th>
                                         <th>Appointment Date</th>
                                         <th>Status</th>
                                         <th>Notes</th>
                                         <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach($appointments as $appointment): ?>
                                    <tr>
                                         <td><?php echo $appointment['id'];?></td>
                                         <td><?php echo $appointment['patient_name'];?></td>
                                         <td><?php echo $appointment['doctor_name'];?></td>
                                         <td><?php echo $appointment['appointment_date'];?></td>
                                         <td><?php echo $appointment['status'];?></td>
                                         <td><?php echo $appointment['notes'];?></td>
                                         <td>
                                            <a href="edit-doctor.php?editid=<?php echo $result['id'];?>"><i class="fa fa-edit"></i></a>||
                                            <a href="delete-doctor.php?delid=<?php echo $result['id'];?>"><i class="fa fa-minus"></i></a>||
                                            <a href="view-doctors.php?viewid=<?php echo $result['id'];?>"><i class="fa fa-eye"></i></a>
                                         </td>
                                    </tr>
                                    <?php endforeach ?>
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
