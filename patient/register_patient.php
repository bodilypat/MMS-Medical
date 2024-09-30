<?php

    required '../includes/functions.php';

    if($_SERVER["REQUEST_METHOD"] == 'POST'){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $date_of_birth = $_POST['date_of_birth'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $medical_history = $_POST['medical_history'];

        if (addPatient($name, $email, $date_of_birth, $gender, $phone ,$address, $medical_history)){
            header("Location: view_patients.php");
            exit();
        } else {
            $error = "Failed to add patient.";
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
                                                <label for="Gender">Gender</label>
                                                <select name="gender" required>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="Phone">Phone</label>
                                                <input type="text" name="phone" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="Address">Address</label>
                                                <textarea type="text" name="Address" class="form-control" required>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="Medical_History">Medical History</label>
                                                <textarea type="text" name="medical_history" class="form-control" required>
                                            </div>
                                            <button type="submit">Add Patient</button>
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

