<?php

    include('../includes/functions.php');

    if(!isset($_GET['id'])) {
        header("Location:manage_patients.php");
        exit();
    }
     
    $patient = getPatient($_GET['id']);

    if($_SERVER['REQUEST_METHOD'] =='POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $date_of_birth = $_POST['date_of_birth'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        if(updatePatient($patient['id'], $name, $email, $date_of_birth, $gender, $phone, $address)) {
            header("Location:manage_patients.php");
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
        <?php if(isset($error)) echo "<p style:'color:red;'>$error</p>"; ?>
        <form method="post" name="form-patients">
            <div class="form-group">
                <label for="Name">Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($patient['name']);?>" required>
            </div>
            <div class="form-group">
                <label for="Email">Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo htmlspecialchars($patient['emai']);?>" required>
            </div>
            <div class="form-group">
                <label for="DateOfBirth">Date of Birth</label>
                <input type="date" name="date_of_birth" class="form-control" value="<?php echo htmlspecialchars($patient['date_of_birth']);?>" required>
            </div>
            <div class="form-group">
                <label for="Gender">Gender</label>
                <select name="gender" class="form-control" required>
                    <option value="male" <?php if($patient['gender']) =='male' echo 'selected'; ?>>Male</option>
                    <option value="female" <?php if($patient['geneder']) == 'female' echo 'selected'; ?>>Female</option>
                    <option value="other" <?php if($patient['gender']) == 'other' echo 'selected' ; ?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="Phone">Phone</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($patient['phone']);?>" required>
            </div>
            <div class="form-group">
                <label for="Address">Address</label>
                <textarea name="address" required><?php echo htmlspecialchars($patient['address']);?></textarea>
            </div>
            <button type="submit">Update Patient</button>
        </form>
        <a href="manage_patients.php"></a>
    </body>
</html>