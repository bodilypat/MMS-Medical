<?php
session_start();
error_report(0);
include('../config/dbconnect.php');

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $patient_id = (int)$_POST['patient_id'];
        $doctor_id = (int)$_POST['doctor_id'];
        $appointment_date = $_POST['appointment_date'];
        $status = $_POST['status'];
        $notes = $_POST['notes'];
        
        /* insert to database */
        $addStmt= mysqli_query($deal,"INSERT INTO appointments(patient_id, doctor_id,appointment_date, status, notes) 
                                    VALUES ('$patient_id','$doctor_id','$appointment_date',$status',$notes') ");
        if($addStmt)
        {
            echo "New appointment record created successfully";
            header('Location:manage-appointment');
        } else {
            echo "Error:" . $addStmt ->error;
        }
        $addStmt->close();

    }
    

    $patients = mysqli_query($deal,"SELECT * FROM patients")->fetchall();
    $doctors = mysql->query($deal,"SELECT * FROM doctors")->fetchall();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Doctor | add Patient</title>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="../asset/css/styles.css">
    </head>
<body>
    <div class="app">
        <!-- Outline: navbar -->
        <?php include('../layouts/navbar.php');?>
         <div class="app-content">
            <!-- Outline : header -->
            <?php include('../layouts/header.php');?>
            <!-- container -->
            <div class="main-content">
                <div id="container" class="wrap-content container">
                    <section id="page-title">
                            <div class="row">
                                 <div class="col-sm-8"><h1 class="mainTitle"> Appointment | Add Appointment</h1></div>
                            </div>
                    </section>

                    <!-- body container -->
                    <div class="container bg-white">
                        <form name="addAppointment" method="post">

                            <div class="form-group">
                                <label for="DoctorName">Name</label>
                                <select name="patient_id" id="patient_id" required>
                                    <?php foreach($patients as $patient) ?>
                                        <option value="<?php echo $doctor['id'];?>"><?php echo $patient['name'];?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="DoctorName">Doctor name</label>
                                <select name="doctor_id" name="doctor_id" class="form-control" required>
                                    <?php foreach($doctors as $doctor) ?>
                                        <option value="<?php echo $doctor['id'];?>"><?php doctor['name'];?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                                
                            <div class="form-group">
                                <label for="AppointmentDate">Appointment Date</label>
                                <input type="datetime_local" name="appointment_date" id="appointment_date" class="form-control" placeholder="appointment_date" required>
                            </div>
                            <div class="form-group">
                                <label for="Status">Status</label>
                                <select  name="status" id="status" class="form-control" placeholder="Status" required>
                                    <option value="schedulled">Schedulled</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                                
                            <div class="form-group">
                                <lable for="Notes">Notes</label>
                                <textarea name="note" id="notes" class="form-control" placeholder="Status" required></textarea>
                            </div>
                                <button type="submit">Add Doctor</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Outline : Footer -->
    <?php include('../layouts/footer.php');?>
    <?php include('../layouts/setting.php');?>
    <!-- Custom JS -->
    <script src="../asset/js/main.js"></script>
    <script src="../asset/js/form-element.js"></script>
    <script>
        jQuery.init();
        Form-elements.init();
    </script>
</body>
</html>

