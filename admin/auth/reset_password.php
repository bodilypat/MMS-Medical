<?php
    include '../includes/functions.php';

    /* handle form submission */
    if(isset($_GET['token'])){
        $token = $_GET['token'];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $newPassword = $_POST['password'];
            $message = resetPassword($token, $newPassword);
        }
    } else {
        die("No Token provided.");
    }
?>


<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <body>
        <h2>Reset Password</h2>
        <?php if(isset($message)) echo "<p style='color:red;'>$message</p>"; ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="password">new password</label>
                <input type="password" name="password" required>
                <input type="submit" value="Reset Password">
            </div>
        </form>
    </body>
</html>