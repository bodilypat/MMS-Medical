<?php
    require '../includes/functions.php';

    if(!isset($_GET['id'])){
        header("Location: view_patients.php");
        exist();
    }

    $patient = getPatient($_GET['id']);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $name = $_POST['name'];
        $email = $_POST['email'];
        $date_of_birth = $_POST['date_of_birth'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];
        $addres = $_POST['address'];

        if(updatePatient($patient['id'], $name, $email, $date_of_birth, $gender, $phone, $address)){
            header("Location:view_patients.php");
            exit();
        } else {
            $error = "Failed to update patient.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit Patients</title>
    </head>
    <body>
        <h2>Edit Patients</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>";?>
        <form method="POST" name="form-patient">
            <input type="text" name="name" value="<?php echo htmlspecialchars($patient['name']);?>" required>
            <input type="email" name="email" value="<?php echo htmlspecialchars($patient['email']);?>" required>
            <input type="date" name="date_of_birth" value="<?php echo htmlspecialchars($patient['date_of_birth']);?>" required>
            <select ame="gender" required>
                <option value="male" <?php if($patient['gender']=='male') echo 'selected';?>>Male</option>
                <option value="female" <?php if($patent['gender']=='female') echo 'selected';?>></option>
                <option value="other" <?php if($patient['gender']=='other') echo 'selected';?>></option>
            </select>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($patient['phone']);?>" required>
            <textarea name="address" required><?php echo htmlspecialchars($patient['address']);?></textarea>
            <button type="submit">Update Patient</button>
        </form>
        <a href="view_patients.php"></a>
    </body>
</html>