<?php
include('dbconnect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = mysqli_real_escape_string($deal, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($deal,$_POST['last_name']);
    $specialization = mysqli_real_escape_string($deal, $_POST['specialization']);
    $email = mysqli_real_escape_string($deal$_POST['email']);
    $phone_number = mysqli_real_escape_string($deal,$_POST['phone_number']);
    $department = mysqli_real_escape_string($deal,$_POST['department']);
    $birthdate = mysqli_real_escape_string($deal,$_POST['birthdate']);
    $address = mysqli_real_escape_string($deal,$_POST['address']);
    $status = mysqli_real_escape_string($deal,$_POST['status']);
	$notes = mysqli_real_escape_string($conn, $_POST['notes']);

    $qDoctor = "INSERT INTO doctors (first_name, last_name, specialization, email, phone_number, department, birthdate, address, status)
              VALUES ('$first_name', '$last_name', '$specialization', '$email', '$phone_number', '$department', '$birthdate', '$address', '$status','$note')";
			  
	 if ($deal->query($qDoctor) === TRUE) {
        header("Location: doctor_list.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $deal->error;
    }
	$deal->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor</title>
</head>
<body>
    <h1>Add New Doctor</h1>
    <form action="add_doctor.php" method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" required><br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" required><br><br>

        <label for="specialization">Specialization:</label>
        <input type="text" name="specialization" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" required><br><br>

        <label for="department">Department:</label>
        <input type="text" name="department"><br><br>

        <label for="birthdate">Birthdate:</label>
        <input type="date" name="birthdate"><br><br>

        <label for="address">Address:</label>
        <input type="text" name="address"><br><br>

        <label for="status">Status:</label>
        <select name="status">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="retired">Retired</option>
        </select><br><br>
		
		<label for="notes">Notes:</label>
        <textarea name="notes" id="notes"></textarea><br><br>

        <button type="submit">Add Doctor</button>
    </form>
</body>
</html>
