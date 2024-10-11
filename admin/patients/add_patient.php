<?php

    include('../includes/functions.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = $_POST['NAME'];
        $email = $_POST['email'];
        $date_of_birth = $_POST['date_of_birth'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        if(addPatient($name, $email, $date_of_birth, $gender, $phone, $address)){
            header("Location:manage_patients.php");
            exit();
        } else {
            $error = "Failed to add patient.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add Patient<title>
    </head>
    <body>
        <h2>Add Patient</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="post" name="form-patient">
            <div class="form-group">
                <label for="Name">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="form-group">
                <label for="Email">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="DateOfBirth">Date of Birth</label>
                <input type="date" name="date_of_birth" required>
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
                <input type="text" name="phone" class="form-control" placeholder="Phone" required>
            </div>
            <div class="form-group">
                <label for="Address">Address</label>
                <textarea name="address" placeholder="Address" required ></textarea>
            </div>
            <button type="submit">Add Patient</button>
        </form>
        <a href="manage_patients.php"></a>
    </body>
</html>