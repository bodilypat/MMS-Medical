<?php
    session_start();
    include('../include/dbconfig..php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        /* Query to check if the username and password match */
        $sql_user = "SELECT * FROM users WHERE username = ?";
        $stmt = $pdo->prepare($sql_user);
        $stmt -> execute([$username]);
        $resultUser = $stmt->fetch();

        if ($resultUser && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $resultUser['id'];
            $_SESSION['role'] = $resultUser['role'];
            header('Location: dashboard.php'); /* Redirect to dashboard */
            exit();
        } else {
            $error = "Invalid username or password";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="Width=device-width, initial-scale= 1.0">
        <title>Doctor Login</title>
    </head>
    <body>
        <h2>Login</h2>
        <form method="POST">
            <div for="form-group">
                <label for="username">Username: </label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password: </label>
                <input type="password" name="password" required>
            </div>
        </form>
        <?php if(isset($error)) { echo "<p>$error</p>"; } ?>
    </body>
</html>
