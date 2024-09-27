<?php

    include '../includes/dbconnect.php';

    if(isset($_GET['id'])){
        $patient_id = $_GET['id'];
        
        $stmt = $pdo->prepare("SELECT * FROM patients WHERE id = ? ");
        $stmt->execute([$patient_id]);

        $patient = $stmt->fetch();

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $date_of_birth = $_POST['date_of_birth'];
            $gender = $_POST['gender'];
            $medical_history = $_POST['medical_history'];

            $edit_stmt = $pdo->prepare("UPDATE patients SET name = ?, email = ?, date_of_birth = ?, gender = ?, gender = ?, medical_history = ? WHERE id = ? ");
            if($edit_stmt->execute([$name, $email, $date_of_birth, $gender, $medical_history, $patient_id])){
                echo "Patient updated successfully!";
                header("Location:view_patients.php");
                exit();
            }
        }
    } else {
        die("Patient ID not provided.");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit Patients</title>
    </head>
    <body>
        <div id="app">
            <!-- Outline : sidebar -->
            <?php include('../layouts/sidebar.php');?>
            <div class="app-content">
                <!-- Outline : Header -->
                <?php include('../layouts/header.php');?>
                <div class="main-content">
                      <!-- PAGE TITLE -->
                     <section id="page-title"></section>
                     <div class="continer bg-white">
                          <div class="row">
                               <div class="col-md-12">
                                    <div class="panel panel-white">
                                         <div class="panel-heading"><h5 class="page-title">Edit Patient</h5></div>
                                         <div class="panel-body">
                                              <form name="form-patient" method="post">
                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" name="name" value="<?php echo htmlspecialchars($patient['name']);?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Email">Email</label>
                                                        <input type="email" name="email" value="<?php echo htmlspecialchars($patient['email']);?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="date_of_birth">Date of Birth</label>
                                                        <input type="date" name="date_of_birth" value="<?php echo htmlspecialchars($patient['date_of_birth']);?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Gender">Gender</label>
                                                        <select name="gender" required>
                                                             <option value="Male"<?php echo $patient['gender'] ==='Male' ? 'selected' : '';?>>Male</option>
                                                             <option value="Female"><?php echo $patient['gender'] === 'Female' ? 'selected' : '';?>></option>
                                                             <option value="Other"><?php echo $patient['gender'] === 'Other' ? 'selected' : '' ;?>></option>
                                                        </select>                                                        
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Medical_History">Medical History</label>
                                                        <textarea name="medical_history"><?php echo htmlspecialchars($patient['medical_history']);?></textarea>
                                                    </div>
                                                    <button type="submit" name="submit" class="btn btn-primary">Update Patient</button>
                                              </form>
                                         </div>
                                    </div>
                               </div>
                          </div>
                     </div>
                </div>
            </div>
            <!-- Outline: Footer -->
            <?php include('../layouts/footer');?>
            <?php include('../layouts/setting');?>
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