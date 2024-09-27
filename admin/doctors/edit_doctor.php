<?php
    require '../incldues/functions.php';

    if(!isset($_GET['id'])){
        header("Location:view_doctors.php");
        exit();
    }

    $doctors = getDoctor($_GET['id'])

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $specialization = $_POST['specialization'];
        $phone = $_POST['phone'];

        if(updateDoctor($doctor['id'], $name, $email, $specialization, $phone)){
            header('Location:view_doctors.php');
            exist();
        } else {
            $error = "Failed to update doctor.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit Doctpr</title>
    </head>
<body>
    <h2>Edit Doctor</h2>
    <?php if(isset($error)) echo "<p style='color:read;'>$error</p>"; ?>
    <form method="post" name="form-doctor">
        <input type="text" name="name" value="<?php echo htmlspecialchars($doctor['name']);?>" requied>
        <input type="email" name="email" value="<?php echo htmlspecialchars($doctor['email']);?>" required>
        <input type="text" name="specialization" value="<?php htmlspecialchars($doctor['specialization']);?>" required>
        <input type="text" name="phone" value="<?php htmlspecialchars($dotor['phone']);?>" required>
        <button type="submit">Update Doctor</button>
    </form>
    <a href="view_doctors.php">Cancel</a>
</body>
</html>