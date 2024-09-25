<?php
    session_start();
    include('../config/dbconnect.php');

    $app_id = $_GET['appointment_id'];

    if($app_id){
        $appStmt = mysqli_query($deal,"SELECT a.*, p.name as patient_name, d.name as doctor_name
                                       FROM appointments a JOIN patients p ON a.patient_id = p.id
                                                           JOIN doctors d ON a.doctor_id = d.id
                                       WHERE a.id = '$app_id' ");
        $appointments = $appStmt->fetch();

        (!$appointment){
            echo "appointment not found!"
            exit();
        }
    
        /* deal from submit */
        if(isset($_POST['submit'])){

            $patient_id = (int)$_POST['patient_id'];
            $doctor_id = (int)$_POST['doctor_id'];
            $appointment_date = $_POST['appointment_date'];
            $status = $_POST['status'];
            $notes = $_POST['notes'];

            $editStmt = mysqli_query($deal,"UPDATE appointment SET patient_id ='$patient_id', 
                                                                doctor_id='$doctor_id', 
                                                                appointment_date='$appointment_date', 
                                                                status='$status',
                                                                note='$notes' ");

            /* Fetch Patients,Doctors for downdrop */     
            $patients = mysqli_query($deal,"SELECT * FORM patients")->fetchAll();                                               
            $doctors = mysqli_query($deal,"SELECT * FROM doctors")->fetchAll();
            
            if($editStmt)
            {
                echo "Edit appointment record  successfully";
                header('Location:manage-appointment');
            } else {
                echo "Error:" . $editStmt ->error;
            }
            $addStmt->close();
            
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Edit Doctor</title>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="../asset/css/styles.css">
    </head>
</html>
<body>
    <div id="app">
        <!-- Outline : Navber -->
        <?php include('../layouts/sidebar.php');?>
        <div class="app-content">
            <!-- Outline : Header -->
            <?php include('../layouts/header.php');?>
            <div class="main-content">
                <div class="wrap-content container" id="container">
                     <!-- PAGE TITLE -->
                    <section id="pate-title">
                        <div class="row">
                            <div class="col-sm-8"><h1 class="mainTitle">Admin | Edit Doctor</h1></div>
                            <ol>
                                 <li><span>Admin</span></li>
                                 <li class="active"><span>Edit Doctor</span></li>
                            </ol>
                        </div>
                    </select>
                    <!-- BODY -->
                    <div class="container-fluid container-full bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 style="color: green; font-size:18px; "><?php if($msg) { echo htmlentities($msg);} ?></h5>
                                <div class="row margin-top-30">
                                    <div class="col-lg-8 col-md-12">
                                        <div class="panel panel-white">
                                            <div class="panel-heading"><h5 class="panel-title">Edit Doctor</h5></div>
                                            <div class="panel-body">
                                                
                                                <form name="addAppointment" method="post" >

                                                    <div class="form-group">
                                                        <label for="Patient_Name">Patient Name</label>
                                                        <select name="patient_id" id="patient_id" required>
                                                            <?php foreach ($patients as $patient);?>
                                                                <option value="<?php $patient['id'];?>"<?php echo $patient['id'] == $appointment['id']? 'selected' : '' ?>>
                                                                    <?php echo $patient['name'];?>
                                                                </option>                                                                
                                                            </select>
                                                    </div>
                                                                                                        
                                                    <div class="form-group">
                                                        <label for="Doctor_Name">Patient Name</label>
                                                        <select name="doctor_id" id="doctor_id" required>
                                                            <?php 
                                                                foreach($doctors as $doctor);?>
                                                                <option value="<?php echo $doctor['id'];?>"<?php echo $doctor['id'] == $appointment['id']? 'selected' : '' ?>>
                                                                        <?php echo $doctor['name']; ?>
                                                                </option>
                                                                <?php endforeach ?>
                                                            </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="Appointnent_date">Appointment Date</label>
                                                        <input type="text" name="appointment_date" id="appointment_date" class="form-control"
                                                               value="<?php echo $appointment['specialty'];?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="Status">Status</label>
                                                        <input type="text" name="status" id="status" class="form-control"
                                                               value="<?php echo $appointment['status'];?>" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="Notes">Note</label>
                                                        <input type="text" name="note" id="note" class="form-control"
                                                               value="<?php echo $appointment['email'];?>" required>
                                                    </div>

                                                    <button type="submit" name="submit" class="btn btn-o btn-primary">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
