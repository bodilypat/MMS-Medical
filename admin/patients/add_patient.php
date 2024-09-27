<?php
    requrie '../incldues/functions.php';

    if($_SERVER[REQUEST_METHOD] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $date_of_birth = $_POST['date_of_birth'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        if(addPatient($name, $email, $date_of_brirth, $gender, $phone, $address)) {
            header("Location: view_patients.php");
            exit();
        } else {
            $error = "Failed to add patient. ";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add Patient<title>
    </head>
    <body>
        <h2>Add Patient</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="post" name="form-patient">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="date"  name="date_of_birth" required>
            <select name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            <input type="text" name="phone" placeholder="Phone" required>
            <textarea name="address" placeholder="Address" required></textarea>
            <button type="submit">Add Patient</button>
        </form>
        <a href="view_patients.php"></a>
    </body>
</html>