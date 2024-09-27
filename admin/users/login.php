<?php

    require '../includes/dbconect.php';
    require '../includes/functions.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email = $_POST['email'];
        $password = $_POST['password'];

        if(loginUser($email,$password)) {
            header('Location:index.php'); /* Redirect to a protected page */
            exit();
        } else {
            $error = "Invalid email or password";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
<body>
    <h1>Login</h1>
    <?php if(isset($error)) echo "<p style:'color:red;>'$error</p>" ;?>
    <form method="post" name="form-login">
        <input type="email" name="email" placeholde="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p>Do not have an account?<a href="register.php">Register here</a>.</p>
</body>
</html>