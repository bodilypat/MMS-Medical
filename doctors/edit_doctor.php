<?php

/* Include database connection */
include('dbconnect.php');

/* Fetch doctor data based on ID */
	if (isset($_GET['id'])) {
		$doctor_id = $_GET['id'];
		$qDoctor = "SELECT * FROM doctors WHERE doctor_id = $doctor_id";
		$result = $conn->query($qDoctor);
		if ($result->num_rows > 0 ) {
			$doctor = $result->fetch_assoc();
		} else {
			echo "Doctor not found.";
		}
	}

	/* Handle from submission */
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		/* Sanitize and validate input */
		$doctor_id = mysqli_real_escape_string($deal,$_POST['doctor_id']);
		$first_name = mysqli_real_escape_string($deal, $_POST['first_name']);
		$last_name = mysqli_real_escape_string($deal, $_POST['last_name']);
		$specialization = $_POST['specialization']);
		$email = mysqli_real_escape_string($deal, $_POST['email']);
		$phone_number = mysqli_real_escape_string($deal, $_POST['phone_number']);
		$department = mysqli_real_escape_string($deal, $_POST['department']);
		$birthdate = mysqli_real_escape_string($deal, $_POST['birthdate']);
		$address = mysqli_real_escape_string($deal, $_POST['address']);
		$status = mysqli_real_escape_string($deal, $_POST['status']);
		$notes = mysqli_real_escape_string($deal, $_POST['notes']);

		$sql = "UPDATE doctors SET first_name = '$first_name', last_name = '$last_name', specialization = '$specialization', 
									   email = '$email', phone_number = '$phone_number', department = '$department', birthdate = '$birthdate', 
									   address = '$address', status = '$status',notes='$notes' 
								   WHERE doctor_id = $doctor_id";

		if ($deal->query($sql) === TRUE)) {
			header("Location: doctor_list.php");
			exit();
		} else {
			echo "Error: " . $sql . "<br>" . $deal->error;
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor</title>
</head>
<body>
    <h1>Edit Doctor Details</h1>
    <form action="edit_doctor.php?id=<?php echo $doctor['doctor_id']; ?>" method="POST">
	
		/*  Pre-fill form list exiting doctor data  */
        <input type="hidden" name="doctor_id" value="<?php echo $doctor['doctor_id']; ?>">

        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="<?php echo $doctor['first_name']; ?>" required><br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="<?php echo $doctor['last_name']; ?>" required><br><br>

        <label for="specialization">Specialization:</label>
        <input type="text" name="specialization" value="<?php echo $doctor['specialization']; ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $doctor['email']; ?>" required><br><br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" value="<?php echo $doctor['phone_number']; ?>" required><br><br>

        <label for="department">Department:</label>
        <input type="text" name="department" value="<?php echo $doctor['department']; ?>"><br><br>

        <label for="birthdate">Birthdate:</label>
        <input type="date" name="birthdate" value="<?php echo $doctor['birthdate']; ?>"><br><br>

        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo $doctor['address']; ?>"><br><br>

        <label for="status">Status:</label>
        <select name="status">
            <option value="active" <?php if ($doctor['status'] == 'active') echo 'selected'; ?>>Active</option>
            <option value="inactive" <?php if ($doctor['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
            <option value="retired" <?php if ($doctor['status'] == 'retired') echo 'selected'; ?>>Retired</option>
        </select><br><br>
		
		<label for="notes">Notes:</label>
        <textarea name="notes"><?php echo $doctor['notes']; ?></textarea><br><br>

        <button type="submit">Update Doctor</button>
    </form>
</body>
</html>

<?php $deal->close(); ?>