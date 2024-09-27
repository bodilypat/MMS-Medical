<?php

    required '../includes/dbconnect.php';
    if($_SERVER["REQUEST_METHOD"] == 'POST'){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $date_of_birth = $_POST['date_of_birth'];
        $gender = $_POST['gender'];
        $medical_history = $_POST['medical_history'];

        $stmt = $pdo->prepare("INSERT INTO patients(name, email, phone, date_of_birth, gender, medical_history) VALUES(?, ?, ?, ?, ?) ");
        if($stmt-execute([$name, $email, $phone, $date_of_birth, $gender, $medical_history])){
            echo "Patient registered successfull! ";
        } else {
            echo "Error Cound not register patient.;"
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
            <?php include('../layouts/sidebar.php');?>
            <div class="app-content">
                <!-- Outline: header -->
                <?php include('../layouts/header.php');?>
                <div class="main-content">
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8">
                                 <h1 class="mainTitle">Patients | Add Patient</h1>
                            </div>
                        </div>
                    </section>
                    <div class="container bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-white">
                                    <div class="panel-heading"><h5 class="panel-title">Add Patient</div>
                                    <div class="panel-body">
                                        <form role="form" name="patient-form" method="post">
                                            <div class="form-group">
                                                <label for="Name">Name</label>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="Email">Email</label>
                                                <input type="email" name="email" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="DateOfBirth">Date of Birth</label>
                                                <input type="date" name="date_of_birth" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="Phone">Phone</label>
                                                <input type="text" name="phone" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="Gender">Gender</label>
                                                <select name="gender" required>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="Medical_History">Medical History</label>
                                                <textarea type="text" name="medical_history" class="form-control" required>
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
            <?php include('../layouts/footer.php');?>
            <!-- Outlien : setting -->
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

