<?php

    include('../includes/functions.php');

    if(!isset($_GET['id'])) {
        header("Location:view_doctors.php");
        exit();
    }

    $doctors = getDoctor($_GET['id']);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $specialty = $_POST['specialty'];
        $phone = $_POST['phone'];

        if(updateDoctor($doctor['id'], $name, $email, $specialty, $phone)) {
            header("location:manage_doctors.php");
            exit();
        } else {
            $error = "Failed to update doctor. ";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit Doctor</title>
    </head>
    <body>
        <h2>Edit Doctor</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="post" name="form-doctor">
            <div class="form-group">
                <label for="Name">Name</lebel>
                <input type="text" name="name" value="<?php  echo htmlspecialchars($doctor['name']);?>" required >
            </div>
            <div class="form-group">
                <label for="Email">Email</label>
                <input type="email" name="email" value="<?pho echo htmlspecialchars($doctor['email']);?>" required >
            </div>
            <div class="form-group">
                <label for="Specialty">Specialization</label>
                <input type="text" name="specialty" value="<?php echo htmlspecialchars($doctor['specialty']);?>">
            </div>
            <div class="form-group">
                <label for="Phone">Phone</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($doctor['phone']);?>">
            </div>
        </form>
        <a href="manage_doctors.php">Cancel</a>
    </body>
</html>
