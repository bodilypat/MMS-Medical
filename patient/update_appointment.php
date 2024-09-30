<?php

    include '../includes/funtions.php';

    if(!isset($_GET['id'])){
        header("Location: view_patients.php");
        exit();
    }
    $patient=getPatients();
    $doctort=getDoctors();

    $appointments = getAppointment($_GET['id']);

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $patient_id = $_POST['patient_id'];
            $doctor_id = $_POST['doctor_id'];
            $appointment_date = $_POST['appointment_date'];
            $status = $_POST['status'];
            $notes = $_POST['notes'];

            if (updateAppointment($patient_id, $doctor_id, $appointment_date, $status, $notes)){
                header("Location:view_Appointments.php");
                exit();
            } else {
                $error = "Failed to update appointment. ";
            }       
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit Appointemnts</title>
    </head>
    <body>
        <div id="app">
            <!-- Outline : sidebar -->
            <?php include('../outline/sidebar.php');?>
            <div class="app-content">
                <!-- Outline : Header -->
                <?php include('../outline/header.php');?>
                <div class="main-content">
                      <!-- PAGE TITLE -->
                     <section id="page-title"></section>
                     <div class="continer bg-white">
                          <div class="row">
                               <div class="col-md-12">
                                    <div class="panel panel-white">
                                         <div class="panel-heading"><h5 class="page-title">Edit Appointment</h5></div>
                                         <div class="panel-body">
                                              <form name="form-patient" method="post">

                                                    <div class="form-group">
                                                        <label for="PatientName">Patient Name</label>                                                        
                                                        <select value="patient_id" class="form-control" required>
                                                        <?php foreach($patients as $patient): ?>
                                                            <option value="<?php echo htmlspecialchars($patient['patient_id']);?>">
                                                                <?php echo htmlspecialchars($patient['name']);?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                        </section>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="DoctorName">Doctor Name</label>
                                                        <select name="doctor_id" class="form-control" reqired>
                                                            <?php foreach($doctors as $doctor): ?>
                                                            <option value="<?php echo htmlspecialchars($patient['doctor_id']);?>">
                                                                <?php echo htmlspecialchars($doctor['name']);?>
                                                            </option>
                                                            <?php endforeach; ?>
                                                        </section>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="AppointmentName">Appoitment Name</label>
                                                        <input type="date" name="appointment_date" value="<?php echo htmlspecialchars($appointment['appointment_date']);?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="Status">Status</label>
                                                        <select name="status" required>
                                                             <option value="Scheduled"<?php echo $appointment['status'] ==='Scheduled' ? 'selected' : '';?>>Scheduled</option>
                                                             <option value="Completed"><?php echo $appointment['status'] === 'Completed' ? 'selected' : '';?>>Completed</option>
                                                             <option value="Cancelled"><?php echo $appointment['status'] === 'Cancelled' ? 'selected' : '' ;?>>Cancelled</option>
                                                        </select>                                                        
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="Notes">Notes</label>
                                                        <textarea name="notes" value="<?php echo htmlspecialchars($patient['notes']);?>" required>
                                                    </div>
                                                    
                                                    <button type="submit" name="submit" class="btn btn-primary">Update appointment</button>
                                              </form>
                                         </div>
                                    </div>
                               </div>
                          </div>
                     </div>
                </div>
            </div>
            <!-- Outline: Footer -->
            <?php include('../outline/footer');?>
            <?php include('../outline/setting');?>
        </div>
        <!-- Custom js -->
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