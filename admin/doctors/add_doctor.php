<?php
session_start();
error_report(0);
include('../config/dbconnect.php');

    if($_SERVER["REQUEST_METHOD"] == "POST") {
    
            $docname = $_POST['name'];
            $specialty = $_POST['specialty'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];

            $aPat = mysqli_query($deal,"INSERT INTO patients(name,specialty, phone, email)
                                        VALUES('$name','$specialty','$phone','$email')");
            if($aPat)
            {
                echo "<script>alert('patient info added successfully');</script>";
                header('Location:manage-doctors.php');
        }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Doctor | add Patient</title>
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
                                 <div class="col-sm-8"><h1 class="mainTitle"> Doctor | Add Doctor</h1></div>
                            </div>
                      </section>
                      <div class="container bg-white">
                            <form name="addDoctor" method="post">

                                <div class="form-group">
                                    <label for="DoctorName">Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                                </div>

                                <div class="form-group">
                                    <label for="Specialty">Specialty</label>
                                    <input type="date" name="specialty"  class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="Phone">Phone</label>
                                    <input type="text" name="phone" class="form-control" placeholder="phone">
                                </div>
                                
                                <div class="form-group">
                                    <lable for="Email">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                </div>
                                <button type="submit">Add Doctor</button>
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
