<?php
    require '../include/functions.php';

    if(!isloginIn()) {
        header('Location:login.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php htmlspecialchars($_SESSION['user_name']);?>!</h2>
    <p><a href="login.php">Login</a></p>
</body>
</html>