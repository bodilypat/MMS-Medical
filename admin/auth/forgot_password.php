<?php
    include '../includes/functions.php';

    /* handle form submission */
    if($_SERVER["REQUEST_METHOD"] ==='POST'){
        $email = trim($_POST['email']);
        $message = requestPasswordReset($email);
    }
?>


<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <body>
        <h2>Forgot Password</h2>
        <?php if(isset($message)) echo "<p style='color:red;'>$message</p>"; ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
                <input type="submit" value="Request Reset">
            </div>
        </form>
    </body>
</html>