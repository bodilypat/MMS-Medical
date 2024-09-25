<?php
session_start();

if(!isset($_SESSION['user_id'])) {
        header('Location:login.php');
        exit();
    }

    include('../config/dbconnect.php');

    if($_SERVER["REQUEST_METHOD"] == "POST") {
    
            $name = $_POST['name'];
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
            $phone = $_POST['phone'];
            $mail = $_POST['email'];
            $address = $_POST['address']

            $aPat = mysqli_query($deal,"INSERT INTO patients(name, dob, gender, phone, email, address)
                                        VALUES('$name','$dob','$gender','$phone','$email', $address')");
            if($aPat)
            {
                echo "<script>alert('patient info added successfully');</script>";
                header('localhost:manage-patients.php');
        }
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Patient | Add Patient</title>
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
            <div class="main-content">
                 <div id="container" class="wrap-content container">
                      <section id="page-title">
                            <div class="row">
                                 <div class="col-sm-8"><h1 class="mainTitle"> Patient | Add Patient</h1></div>
                            </div>
                      </section>
                      <div class="container bg-white">
                            <form name="addPatient" method="post">
                                <div class="form-group">
                                    <label for="PatietName">Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="DateOfBirth">Date of Birth</label>
                                    <input type="date" name="dob"  class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="Gender">Gender</label>
                                    <select name="gender" required>
                                         <option value="male">Male</option>
                                         <option value="female">Female</option>
                                         <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="Phone">Phone</label>
                                    <input type="text" name="phone" class="form-control" placeholder="phone">
                                </div>
                                <div class="form-group">
                                    <lable for="Email">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                </div>
                                <div class="form-group">
                                     <label for="Address">Address</label>
                                     <textarea name="address" placeholder="Address"></textarea>
                                </div>
                                <button type="submit">Add Patient</button>
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
<?php } ?>
