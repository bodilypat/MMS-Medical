<?php

    include '../includes/funtions.php';

    if(!isset($_GET['id'])){
        header("Location: view_patients.php");
        exit();
    }
    $patients = getPatient($_GET['id']);

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $date_of_birth = $_POST['date_of_birth'];
            $gender = $_POST['gender'];
            $address = $_POST['address'];
            $medical_history = $_POST['medical_history'];

            if (updatePatient($name, $email, $date_of_birth, $gender, $phone, $address, $medical_history)){
                header("Location:view_patients.php");
                exit();
            } else {
                $error = "Failed to update patient. ";
            }       
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
                                                        <lable for="Phone">Phone</label>
                                                        <input type="text" name="phone" value="<?php echo htmlspecialchars($patient['address']);?>" requried >
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Address">Address</label>
                                                        <textarea name="address" value="<?php echo htmlspecialchars($patient['address']);?>" required>
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