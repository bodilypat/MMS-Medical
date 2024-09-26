<?php
    session_start();

    include('../config/dbconnect.php');
    if(strlen($_SESSION['id']==0)){
        header('Location:login.php');
    } else {
        $patient_id = $_GET['editid'] ?? null;
        $preStmt = mysqli_query($deal,"SELECT p.*, p.name as patient_name, d.name as doctor_name
                                       FROM prescriptions pre JOIN patient p ON pre.patient_id = p.id 
                                                              JOIN doctor d ON pre.doctor_id = d.id
                                       WHERE pre.patient_id = '$patient_id' ");

        $prescriptions = $preStmt->fetchAll();

        $patients = mysqli_query($deal,"SELECT * FROM patients")->fetchAll();
        $doctors = mysqli_query($deal,"SELECT * FROM doctors")->fetchAll();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Manage Prescriptions</title>
        <!-- Customer CSS -->
        <link rel="stylesheet" href="../asset/css/styles.css">
    </head>
<body>
    <div id="app">
        <!-- Outline : Navbar -->
         <?php include('../layouts/sidebar.php');?>
        <div class="app-content">
            <!-- Outline : Header -->
             <?php include('../layouts/header.php');?>
            <div class="main-content">
                <!-- PAGE TITLE -->
                <section id="page-title"></section>
                <!-- container -->
                <div class="container-fluid container-full bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Manage<span class="text-bold">Prescriptions</span></h5>
                            <table class="table table-over" id="prescription-table">
                                <thead>
                                    <tr>
                                          <th>ID</th>
                                          <th>Patient Name</th>
                                          <th>Doctor Name</th>
                                          <th>Medication</th>
                                          <th>Dosage</th>
                                          <th>Instruction</th>
                                          <th>Start Date</th>
                                          <th>End Date</th>
                                          <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($prescriptions as $prescription): ?>
                                    <tr>
                                          <td><?php echo $prescription['id'];?></td>
                                          <td><?php echo $prescription['patient_name'];?></td>
                                          <td><?php echo $prescription['doctor_name'];?></td>
                                          <td><?php echo $prescription['medication'];?></td>
                                          <td><?php echo $prescription['dosage'];?></td>
                                          <td><?php echo $prescription['instructions'];?></td>
                                          <td><?php echo $prescription['start_date'];?></td>
                                          <td><?php echo $prescription['end_start'];?></td>
                                          <td>
                                                <a href="edit-prescript.php?editid=<?php echo $prescription['id'];?>"><i class="fa fa-edit"></i>Edit</a>
                                                <a href="delete-prescription.php?delid=<?php echo $prescription['id'];?>"><i class="fa fa-minus"></i>Delete</a>
                                                <a href="view-prescription.php?viewid=<?php echo $prescription['id'];?>"><i class="fa fa-eye"></i>View Prescriptions</a>
                                          </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Outline: Footer -->
        <?php include('../layouts/footer.php');?>
        <?php include('../layouts/setting.php');?>
    </div>
    <!-- Custom JS -->
    <script src="../asset/js/main.js"></script>
    <script src="../asset/js/form-elements.js"></script>
    <script>
        jQuery(document).ready(function(){
            Main.init();
            Form-elements.init();
        });
    </script>
</body>
</html>