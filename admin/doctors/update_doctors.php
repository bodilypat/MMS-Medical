<?php
include 'config.php';

if (isset($_GET['id'])) {
    $doctor_id = $_GET['id'];
    $sql = "SELECT * FROM doctors WHERE doctor_id = $doctor_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Doctor not found.";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);

    // Update query
    $sql = "UPDATE doctors SET first_name='$first_name', 
							   last_name='$last_name', 
							   specialization='$specialization', 
							   email='$email', 
							   phone_number='$phone_number', 
							   department='$department', 
							   irthdate='$birthdate',
							   address='$address', 
							   status='$status', 
							   otes='$notes' 
						   WHERE doctor_id=$doctor_id";

    if ($conn->query($sql) === TRUE) {
        echo "Doctor record updated successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!-- HTML Form to Update Doctor -->
<form method="POST" action="update_doctor.php?id=<?php echo $doctor_id; ?>">
    <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" required><br>
    <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" required><br>
    <input type="text" name="specialization" value="<?php echo $row['specialization']; ?>" required><br>
    <input type="email" name="email" value="<?php echo $row['email']; ?>" required><br>
    <input type="text" name="phone_number" value="<?php echo $row['phone_number']; ?>" required><br>
    <input type="text" name="department" value="<?php echo $row['department']; ?>"><br>
    <input type="date" name="birthdate" value="<?php echo $row['birthdate']; ?>"><br>
    <textarea name="address"><?php echo $row['address']; ?></textarea><br>
    <select name="status">
        <option value="active" <?php if ($row['status'] == 'active') echo 'selected'; ?>>Active</option>
        <option value="inactive" <?php if ($row['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
        <option value="retired" <?php if ($row['status'] == 'retired') echo 'selected'; ?>>Retired</option>
    </select><br>
    <textarea name="notes"><?php echo $row['notes']; ?></textarea><br>
    <button type="submit">Update Doctor</button>
</form>