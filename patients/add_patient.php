<?php
// Include database connection
include('dbconnect.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate form inputs
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $insurance_provider = mysqli_real_escape_string($conn, $_POST['insurance_provider']);
    $insurance_policy_number = mysqli_real_escape_string($conn, $_POST['insurance_policy_number']);
    $primary_care_physician = mysqli_real_escape_string($conn, $_POST['primary_care_physician']);
    $medical_history = mysqli_real_escape_string($conn, $_POST['medical_history']);
    $allergies = mysqli_real_escape_string($conn, $_POST['allergies']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    // Insert the new patient into the database
    $sql = "INSERT INTO patients (first_name, last_name, date_of_birth, gender, email, phone_number, address, 
            insurance_provider, insurance_policy_number, primary_care_physician, medical_history, allergies, status) 
            VALUES ('$first_name', '$last_name', '$date_of_birth', '$gender', '$email', '$phone_number', '$address', 
            '$insurance_provider', '$insurance_policy_number', '$primary_care_physician', '$medical_history', 
            '$allergies', '$status')";

    if ($deal->query($sql) === TRUE) {
        echo "New patient added successfully";
        header("Location: patients.php"); // Redirect to the list of patients
    } else {
        echo "Error: " . $sql . "<br>" . $deal->error;
    }

    // Close the connection
    $deal->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Patient</title>
</head>
<body>
    <h1>Add New Patient</h1>
    <form action="add_patient.php" method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" required><br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" required><br><br>

        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" name="date_of_birth" required><br><br>

        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email"><br><br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" required><br><br>

        <label for="address">Address:</label>
        <input type="text" name="address"><br><br>

        <label for="insurance_provider">Insurance Provider:</label>
        <input type="text" name="insurance_provider"><br><br>

        <label for="insurance_policy_number">Insurance Policy Number:</label>
        <input type="text" name="insurance_policy_number"><br><br>

        <label for="primary_care_physician">Primary Care Physician:</label>
        <input type="text" name="primary_care_physician"><br><br>

        <label for="medical_history">Medical History:</label>
        <textarea name="medical_history"></textarea><br><br>

        <label for="allergies">Allergies:</label>
        <textarea name="allergies"></textarea><br><br>

        <label for="status">Status:</label>
        <select name="status">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="deceased">Deceased</option>
        </select><br><br>

        <input type="submit" value="Add Patient">
    </form>
</body>
</html>