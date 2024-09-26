<?php
    include('../config/dbconnect.php');
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $patient_id = $_POST['patient_id'];
        $doctor_id = $_POST['doctor_id'];
        $prescription_date = $_POST['prescription_date'];
        $medication = $_POST['medication'];
        $dosage = $_POST['dosage'];
        $instructions = $_POST['instruction'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        $addStmt = mysqli_query($deal,"INSERT INTO prescriptions(patient_id, doctor_id, prescription_date, medication, dosage, instruction, start_date, end_date)
                                       VALUES('$patient_id','$doctor_id','$prescription','$medication','$dosage','$instruction','$start_date','$end_date' )");
        
        if($addStmt){
            echo "Add Medical-record successfull!";
            header('Location: manage-medical_record.php');
        } else {
            echo "Error:" . $editStmt->error;
        }
        $editStmt->clsoe();
    }
    /* Fetch Patients, Doctors for downdrop */
    $patients = mysqli_query($deal,"SELECT * FROM patients")->fetchAll();
    $doctors = mysqli_query($deal,"SELECT * FROM doctors")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Add Prescriptions</title>
        <!-- Customer CSS -->
        <link rel="stylesheet" href="../asset/css/styles.css">
    </head>
<body>
    <div id="app">
        <!-- Outline: Navbar -->
        <?php include('../layouts/sidebar.php');?>
        <div class="app-content">
            <!-- Outline: Header -->
            <?php include('../layouts/header.php');?>
            <div class="main-content">  
                <div class="wrap-content container" id="contrainer">
                    <!-- Page Title -->
                    <section id="page-title"></section>
                        <!--Page Body -->
                    <div class="container-fluid container-full  bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row margin-top-30">
                                    <div class="panel panel-white">
                                        <div class="panel-heading"><h5 class="panel-title">Add Prescription</h5></div>
                                        <div class="panel-body">
                                            <form name="addPrescription" action="" method="post">

                                                <div class="form-group">
                                                    <label for="PatientName">Patient Name</label>
                                                    <select name="patient_id" id="patient_id" class="form-control" requried>
                                                        <?php foreach($patients as $patient): ?>
                                                            <option value="<?php echo $patient['id'];?>"><?php echo $patient['name'];?></option>
                                                        <?php endforeach; ?>
                                                    </section>
                                                </div>

                                                <div class="form-group">
                                                    <label for="DoctorName">Doctor Name</label>
                                                    <select name="doctor_id" id="doctor_id" class="form-control" required>
                                                        <?php foreach($doctors as $doctor): ?>
                                                            <option value="<?php echo $doctor['id'];?>"><?php echo $doctor['name'];?></option>
                                                        <?php endforeach; ?>
                                                    </section>
                                                </div>

                                                <div class="form-group">
                                                    <label for="Medication">Medication</label>
                                                    <textarea name="medication" id="medication" class="form-control" required></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="dosage">Dosage</label>
                                                    <textarea name="dosage" id="dosage" class="form-control" required></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="Instructions">Instructions</label>
                                                    <textarea name="instructions" id="instructions" class="form-control" required></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="StartDate">Start Date</label>
                                                    <input type="date" name="start_date" id="end_date" class="form-control" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="EndDate">End Date</label>
                                                    <input type="date" name="endd_date" id="end_date" class="form-control" required>
                                                </div>
                                                 <button type="submit">Add Prescriptions</button>                                                
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
        <!-- Outline : Footer -->
        <?php include('../layouts/footer.php');?>
        <?php include('../layouts/setting.php');?>
    </div>
    <!-- Custom JS -->
    <script src="../asset/js/main.js"></script>
    <script src="../asset/js/form-elements.js"></script>
    <script>
        jQuery.init();
        Form-elements.init();
    </script>
</body>
</html>