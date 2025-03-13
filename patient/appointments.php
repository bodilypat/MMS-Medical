<?php

    include '../includes/functions.php';

    /* Fetch patients, doctors */
    $patients = getPatients();
    $doctors = getDoctors();

    if($_SERVER["REQUEST_METHOD"] == 'POST'){
        $patient_id = $_POST['patient_id'];
        $doctor_id = $_POST['doctor_id'];
        $appointment_date = $_POST['appointment_date'];
        $status = $_POST['status'];
        $note = $_POST['notes'];
        $address = $_POST['address'];
        $medical_history = $_POST['medical_history'];

        if (addAppointment($patient_name, $doctor_name, $appointment_date, $status, $notes)){
            header("Location: view_appointments.php");
            exit();
        } else {
            $error = "Failed to add appointment.";
        }
   }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Doctor | Add Patient</title>
        <!-- Custom CSS -->
        <link rel="styleshee" href="../asset/css/styles.css">
    </head>
    <body>
        <div class="app">
            <!-- Outline : sidebar -->
            <?php include('../outlines/sidebar.php');?>
            <div class="app-content">
                <!-- Outline: header -->
                <?php include('../outlines/header.php');?>
                <div class="main-content">
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8">
                                 <h1 class="mainTitle">Patients | Add appointment</h1>
                            </div>
                        </div>
                    </section>
                    <div class="container bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-white">
                                    <div class="panel-heading"><h5 class="panel-title">Add Appointment</div>
                                    <div class="panel-body">
                                        <form role="form" name="patient-form" method="post">
                                            
                                            <!-- Patient Information -->
                                            <div class="form-group">                                                
                                                <label for="Name">Patient Name</label>
                                                <?php foreach($patients as $patient): ?>
                                                <select name="patient_id" class="form-control" required>
                                                    <option value="<?php echo htmlspecialchars($patient['id']);?>">
                                                        <?php echo htmlspecialchars($patient['name']);?>
                                                    </option>
                                                </section>
                                                <?php endforeach; ?>
                                            </div>
                                            
                                            <!-- Appointment Type -->
                                            <div class="form-group">
                                                <label for="AppointmentType">Appointment Type</label>
                                                <select id="appointmentType" name="appointmentType" required>
                                                    <option value="checkup">Checkup</option>
                                                    <option value="surgery">Surgery</option>
                                                    <option value="consultation">Consulation</option>
                                                    <option value="follow_up">Follow-up Visit</option>
                                                    <option value="emergency">Emergency</option>
                                                </select>
                                            </div>

                                            <!-- Doctor Assigned -->
                                            <div class="form-group">
                                                <label for="doctorAssigned">Doctor Assigned</label>
                                                <?php foreach($doctors as $doctor): ?>
                                                <select name="doctor_id" class="form-control" required>
                                                    <option value="<?php echo htmlspecialchars($doctor['id']);?>">
                                                        <?php echo htmlspecialchars($doctor['name']);?>
                                                    </option>
                                                </section>
                                                <?php endforeasch; ?>                                                
                                            </div>
                                            
                                            <!-- Appointment Date -->
                                            <div class="form-group">
                                                <label for="appointmnetDate">Preferred Date</label>
                                                <input type="date" id="appointment_date" name="appointment_date" class="form-control" required>
                                            </div>
                                            
                                            <!-- Appointment Time -->
                                            <div class="form-group">
                                                <label for="appointmentTime">Preferred Time</label>
                                                <input type="time" id="appointment_time" name="appointment_time" required>
                                            </div>

                                            <!-- Appointment Note  -->
                                            <div class="form-group">
                                                <lable for="appointmentNotes">Appointment Notes</label>
                                                <textarea id="appointment_notes" name="appointment_notes" placehodler="additional instructions or notes"><textarea>
                                            </div>
                                            
                                            <!-- Submit & Cancel Buttons -->
                                            <div class="form-group">
                                                <button type="submit" class="btn">Submit</button>
                                                <button ttype="button" class="btn cancel-btn" onclick="">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Outline : Footer -->
            <?php include('../outline/footer.php');?>
            <!-- Outlien : setting -->
            <?php include('../outline/setting.php');?>
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

