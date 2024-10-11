<?php

    include('../includes/functions.php');
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $specialty = $_POST['specialty'];
        $phone = $_POST['phone'];

        if(addDoctor($name, $email, $specialty, $phone)) {
            header("Location:manage_doctors.php");
            exit();
        } else {
            $error = "Failed to add Doctor.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add Doctors</title>
    </head>
    <body>
        <h2>Add Doctors</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </body>
    <form method="post" name="form-doctor">
        <div class="form-group">
            <label for="DoctorName">Name</label>
            <input type="name" class="form-control" placeholder="Name"  placeholder="Name" reqired>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="form-group">
            <label for="Specialty">Specialization</label>
            <input type="type" name="specilaty" class="form-control" placeholder="Specialization" required>

        </div>
        <div class="form-group">
            <label for="Phone">Phone</label>
            <input type="text" name="phone" placeholder="Phone" required>
        </div>
        <a href="manage_doctors.php">View Doctor</a>
    </form>
</html>