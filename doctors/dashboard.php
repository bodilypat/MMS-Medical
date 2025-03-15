<?php
    session_start();
    error_reporting(0);
    include('../includes/functions.php');
    
    /* Assuming the doctor is logged in, we have their ID stored in session */
    $doctor_id = $_SESSION['doctor_id'];

    /* Fetch upcoming appointments */
    $sql_app = "SELECT a.id as appointment_id, p.name as patient_name, a.appointment_date, a.status
            FROM appointment a
            JOIN patients  p ON a.patient_id = p.id
            WHERE a.doctor_id = $doctor_id AND a.appointment_date >= NOW() 
            ORDER BY a.appointment_date ASC";
    $app_result = $deal->query($sql_app);

    /* Fetch all patients */    
    $sql_pat = "SELECT * FROM patients";
    $pat_result = $deal->query($sql_pat);

    if(strlen($_SESSION['doctor_id'] == 0)){
        header('Location:logout.php');
    } else {
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Doctor | Dashboard</title>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="../asset/css/styles.css">
    </head>
<body>
    <div id="app">
        <!-- Outline  -->
        <?php include('../outline/sidebar.php');?>
        <div class="app-content">
            <?php include('../outlines/header');?>
            <!-- END: outline -->
            <div class="main-content">
                <div id="container" class="wrap-content container">
                    <!-- page title -->
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8"><h1 class="mainTitle">Doctor | Dashboard<h1></div>
                            <ol class="breadcrumb">
                                 <li><span>Doctor</span></li>
                                 <li>Dashboard</li>
                            </ol>
                        </div>
                    </section>
                    <div class="container-fluid container-full bg-white">
                        <div class="row">
                            
                        <!-- Manage Doctor -->
                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                                            <i class="fa fa-smail-o fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2>Doctors</h2>
                                        <p class="links cl-effect-1">
                                            <a href="doctor.php"></a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Upcoming Appointment  -->
                            <div class="col-sm-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa-stack fa-2x">
                                            <i class="fa fa-square fa-stack-2x text primary"></i>
                                            <i class="fa fa-smail-o fa-stack-1x inverse"></i>
                                        </span>
                                        <h2 class="StepTitle">Upcomming Appointments</h2>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Patient Name</th>
                                                    <th>Appointment Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while($row = $app_result->fetch_assoc()) { ?>
                                                <tr>
                                                    <td><?php echo $row['patient_name']; ?></td>
                                                    <td><?php echo date("Y-m-d H:i", strtotime($row['appointment_date'])); ?></td>
                                                    <td><?php echo $row['status']; ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!--  Prescription Medication -->
                            <div class="col-md-4">
                                <div class="panel panel-white no-radius text-center">
                                    <div class="panel-body">
                                        <span class="fa fa-stack-2x">
                                             <i class="fa fa-square fa-stack-2x text-primary"></i>
                                             <i class="fa fa-samil-o fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <h2>Prescriptions Medication</h2>
                                        <form action="prescription.php" method="POST">
                                            <label for="patient">Select Patient: </label>
                                            <select name="patient_id" id="patient">
                                                <?php while($patient = $pat_result->fetch_assoc()) { ?>
                                                    <option value="<?php echo $patient['id'] ?>"><?php echo $patient['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <br>
                                            <label for="prescription_text">Prescription : </label>
                                            <textarea name="prescription_text" id="prescription_text" row="4" required></textarea>
                                            <br>
                                            <button type="submit">Submit Prescription</button>
                                        </form>      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Outline: Footer -->
        <?php include('../outlines/footer.php');?>
        <!--  Outline: Setting -->
        <?php include('../outlines/setting.php');?>
    </div>
    <!-- Custom JS -->
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/form-element.js"></script>
    <script>
        jQuery(document).ready(function(){
            Main.init();
            Form-elements.init();
        });
    </script>
</body>
</html>
<?php
    }
?>