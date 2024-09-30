<?php

    include '../includes/functions.php';

    /* Fetch patients, doctors */
    $patients = getPatients();
    $doctors = getDoctors()

    if($_SERVER["REQUEST_METHOD"] == 'POST'){
        $patient_id = $_POST['patient_id'];
        $doctor_id = $_POST['doctor_id'];
        $medication = $_POST['medication'];
        $dosage = $_POST['dosage'];
        $instruction = $_POST['instruction'];

        if (addPrescription($patient_name, $doctor_name, $medication, $dosage, $instructions)){
            header("Location: view_prescriptions.php");
            exit();
        } else {
            $error = "Failed to add appointment.";
        }
   }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Patient | Add Prescription</title>
        <!-- Custom CSS -->
        <link rel="styleshee" href="../asset/css/styles.css">
    </head>
    <body>
        <div class="app">
            <!-- Outline : sidebar -->
            <?php include('../outline/sidebar.php');?>
            <div class="app-content">
                <!-- Outline: header -->
                <?php include('../outline/header.php');?>
                <div class="main-content">
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8">
                                 <h1 class="mainTitle">Patients | Add Prescription</h1>
                            </div>
                        </div>
                    </section>
                    <div class="container bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-white">
                                    <div class="panel-heading"><h5 class="panel-title">Add Prescription</div>
                                    <div class="panel-body">
                                        <form role="form" name="patient-form" method="post">

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
                                            
                                            <div class="form-group">
                                                <label for="DoctorName">Doctor Name</label>
                                                <?php foreach($doctors as $doctor): ?>
                                                <select name="doctor_id" class="form-control" required>
                                                    <option value="<?php echo htmlspecialchars($doctor['id']);?>">
                                                        <?php echo htmlspecialchars($doctor['name']);?>
                                                    </option>
                                                </section>
                                                <?php endforeasch; ?>                                                
                                            </div>

                                            <div class="form-group">
                                                <label for="Medication">Medication</label>
                                                <input type="text" name="Medications" class="form-control" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="Dosage">Dosage</label>
                                                <input type="text" name="dosage" class="form-control" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="Instruction">Instructions</label>
                                                <textare name="instructions" class="form-control" required>
                                            </div>
                                            <button type="submit">Add Prescription</button>
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

