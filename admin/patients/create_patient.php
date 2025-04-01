<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $insurance_provider = $_POST['insurance_provider'];
    $insurance_policy_number = $_POST['insurance_policy_number'];
    $primary_care_physician = $_POST['primary_care_physician'];
    $medical_history = $_POST['medical_history'];
    $allergies = $_POST['allergies'];
    $status = $_POST['status'];

    $sql = "INSERT INTO patients (first_name, last_name, date_of_birth, gender, email, phone_number, address, insurance_provider, insurance_policy_number, primary_care_physician, medical_history, allergies, status)
    VALUES ('$first_name', '$last_name', '$date_of_birth', '$gender', '$email', '$phone_number', '$address', '$insurance_provider', '$insurance_policy_number', '$primary_care_physician', '$medical_history', '$allergies', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<form method="POST" action="create_patient.php">
    <input type="text" name="first_name" placeholder="First Name" required>
    <input type="text" name="last_name" placeholder="Last Name" required>
    <input type="date" name="date_of_birth" required>
    <select name="gender" required>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
    </select>
    <input type="email" name="email" placeholder="Email">
    <input type="text" name="phone_number" placeholder="Phone Number" required>
    <input type="text" name="address" placeholder="Address">
    <input type="text" name="insurance_provider" placeholder="Insurance Provider">
    <input type="text" name="insurance_policy_number" placeholder="Insurance Policy Number">
    <input type="text" name="primary_care_physician" placeholder="Primary Care Physician">
    <textarea name="medical_history" placeholder="Medical History"></textarea>
    <textarea name="allergies" placeholder="Allergies"></textarea>
    <select name="status">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
        <option value="deceased">Deceased</option>
    </select>
    <button type="submit">Create Patient</button>
</form>