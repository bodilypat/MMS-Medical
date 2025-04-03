<?php
// Include database connection
include('dbconnect.php');

// Fetch patient data based on ID
if (isset($_GET['id'])) {
    $patient_id = $_GET['id'];
    $sql = "SELECT * FROM patients WHERE patient_id = $patient_id";
    $result = $deal->query($sql);

    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
    } else {
        echo "Patient not found.";
        exit;
    }
}
// Handle form submission for updating the patient
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate inputs
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
    
    // Update the patient record
    $sql = "UPDATE patients SET first_name='$first_name', last_name='$last_name', date_of_birth='$date_of_birth', 
            gender='$gender', email='$email', phone_number='$phone_number', address='$address', 
            insurance_provider='$insurance_provider', insurance_policy_number='$insurance_policy_number', 
            primary_care_physician='$primary_care_physician', medical_history='$medical_history', allergies='$allergies', 
            status='$status' WHERE patient_id=$patient_id";
    
	if ($deal->query($sql) === TRUE) {
        echo "Patient updated successfully";
        header("Location: manage_patients.php"); // Redirect to patient list
    } else {
        echo "Error: " . $sql . "<br>" . $deal->error;
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient</title>
</head>
<body>
<h1>Edit Patient</h1>
    <form action="edit_patient.php?id=<?php echo $patient['patient_id']; ?>" method="POST">
        <!-- Pre-fill form with existing patient data -->
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="<?php echo $patient['first_name']; ?>" required><br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="<?php echo $patient['last_name']; ?>" required><br><br>

        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" name="date_of_birth" value="<?php echo $patient['date_of_birth']; ?>" required><br><br>

        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="male" <?php echo $patient['gender'] == 'male' ? 'selected' : ''; ?>>Male</option>
            <option value="female" <?php echo $patient['gender'] == 'female' ? 'selected' : ''; ?>>Female</option>
            <option value="other" <?php echo $patient['gender'] == 'other' ? 'selected' : ''; ?>>Other</option>
        </select><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $patient['email']; ?>"><br><br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" value="<?php echo $patient['phone_number']; ?>" required><br><br>

        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo $patient['address']; ?>"><br><br>

        <label for="insurance_provider">Insurance Provider:</label>
        <input type="text" name="insurance_provider" value="<?php echo $patient['insurance_provider']; ?>"><br><br>

        <label for="insurance_policy_number">Insurance Policy Number:</label>
        <input type="text" name="insurance_policy_number" value="<?php echo $patient['insurance_policy_number']; ?>"><br><br>

        <label for="primary_care_physician">Primary Care Physician:</label>
        <input type="text" name="primary_care_physician" value="<?php echo $patient['primary_care_physician']; ?>"><br><br>

        <label for="medical_history">Medical History:</label>
        <textarea name="medical_history"><?php echo $patient['medical_history']; ?></textarea><br><br>

        <label for="allergies">Allergies:</label>
        <textarea name="allergies"><?php echo $patient['allergies']; ?></textarea><br><br>

        <label for="status">Status:</label>
        <select name="status">
            <option value="active" <?php echo $patient['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
            <option value="inactive" <?php echo $patient['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
            <option value="deceased" <?php echo $patient['status'] == 'deceased' ? 'selected' : ''; ?>>Deceased</option>
        </select><br><br>

        <input type="submit" value="Update Patient">
    </form>
</body>
</html>