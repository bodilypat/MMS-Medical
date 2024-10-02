<?php
    session_start();
    include '../includes/functions.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $username = $_POST['username'];
        $password = $_POST['password'];

        /* Fatch user form the database , call login function*/
        $result = login($username, $password);
        
        if($result > 0)
        {
            $_SESSION['login'] = $_POST['username'];
            $_SESSION['id'] = $result['id'];
            header('Location:deshbord.php');
        }
    }
?>
    <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin login</title>
        <link ref="stylesheet" href="../asset/css/styles.css">
    </head>
    <body>
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="Login">Login</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <lable for="Password">Password</lable>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </body>
</html>