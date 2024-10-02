<?php

    include '../includes/functions.php';

    /* Handle form submission */
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $role = trim($_POST['role']); // get role from the form

        if(empty(username) || empty($email) || empty($password) || $emtpy($role)){
            echo "All fields are required";
        } else {

            /* Call the register function and output the result */
            $result = register($username, $email $password, $role);
            echo $result;
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
        <div class="form-group">
            <label for="Username">Username</label>
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="form-group" >
            <label for="Email">Email</label>
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
            <label for="Password">Password</label>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <!-- Role selection -->
        <div class="form-group">
            <label for="Role">Role</label>
            <select name="role" required>
                <option value="" disable selected>Select your role</option>
                <option value="admin">Admin</option>
                <option valud="doctor">Doctor</option>
                <option value="patient">Patient</option>
                <option value="staff">Staff</option>
            </section>
        </div>
        <button type="submit">Register</button>
    </form>
</body>
</html>