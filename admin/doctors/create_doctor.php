<?php
include 'config.php';

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

    // Insert query
    $sql = "INSERT INTO doctors (first_name, last_name, specialization, email, phone_number, department, birthdate, address, status, notes)
            VALUES ('$first_name', '$last_name', '$specialization', '$email', '$phone_number', '$department', '$birthdate', '$address', '$status', '$notes')";

    if ($conn->query($sql) === TRUE) {
        echo "New doctor record created successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!-- HTML Form to Create Doctor -->
<form method="POST" action="create_doctor.php">
    <input type="text" name="first_name" placeholder="First Name" required><br>
    <input type="text" name="last_name" placeholder="Last Name" required><br>
    <input type="text" name="specialization" placeholder="Specialization" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="text" name="phone_number" placeholder="Phone Number" required><br>
    <input type="text" name="department" placeholder="Department"><br>
    <input type="date" name="birthdate" placeholder="Birthdate"><br>
    <textarea name="address" placeholder="Address"></textarea><br>
    <select name="status">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
        <option value="retired">Retired</option>
    </select><br>
    <textarea name="notes" placeholder="Notes"></textarea><br>
    <button type="submit">Create Doctor</button>
</form>