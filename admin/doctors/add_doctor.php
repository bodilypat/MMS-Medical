<?php
    require '../includes/functions.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $specialization = $_POST['specialization'];
        $phone = $_POST['phone'];

        if(addDoctor($name, $email, $specialzation, phone)){
            header('Location: view_doctors.php');
            exit();
        } else {
            $error = "Failed to add doctor.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add Doctor</title>
    </head>
<body>
    <h2>Add Doctor</h2>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post" name="form-doctor">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="specialization" placeholder="Specialization" required>
        <input type="text" name="phone" placeholder="phone" required>
        <button type="submit">add Doctor</button>
    </form>
    <a href="view.doctor.php">View Doctors</a>
</body>
</html>

