<?php

    require '../include/dbconnect.php';
    require '../include/functions.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if(registerUser($name, $email, $password)) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Registration failed Plase try agin.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Register</title>
    </head>
<body>
    <?php if(isset('$error')) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" name="form-register">
        <input type="text" name="ame" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>