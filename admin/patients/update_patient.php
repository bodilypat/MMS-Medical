<?php
include 'dbconnect.php';

if (isset($_GET['ID'])) {
    $patient_id = $_GET['id'];
    $sql = "SELECT * FROM patients WHERE patient_id = $patient_id";
    $result = $deal->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Patient not found.";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /*  collect form data */
    $patient_id = mysqli_real_escape_strint($deal, $_POST['patient_id']);
    $first_name = mysqli_real_escape_strint($deal,$_POST['first_name']);
    $last_name = mysqli_real_escape_strint($deal,$_POST['last_name']);
    $date_of_birth = mysqli_real_escape_strint($deal,$_POST['date_of_birth']);
    $gender = mysqli_real_escape_strint($deal,$_POST['gender']);
    $email = mysqli_real_escape_strint($deal,$_POST['email']);
    $phone_number = mysqli_real_escape_strint($deal,$_POST['phone_number']);
    $address = mysqli_real_escape_strint($deal,$_POST['address']);
    $insurance_provider = mysqli_real_escape_strint($deal,$_POST['insurance_provider']);
    $insurance_policy_number = mysqli_real_escape_strint($deal,$_POST['insurance_policy_number']);
    $primary_care_physician = mysqli_real_escape_strint($deal,$_POST['primary_care_physician']);
    $medical_history = mysqli_real_escape_strint($deal,$_POST['medical_history']);
    $allergies = mysqli_real_escape_strint($deal,$_POST['allergies']);
    $status = mysqli_real_escape_strint($deal,$_POST['status']);

    $sql = "UPDATE patients SET first_name='$first_name', 
                                last_name='$last_name', 
                                date_of_birth='$date_of_birth', 
                                gender='$gender', 
                                email='$email', 
                                phone_number='$phone_number', 
                                address='$address', 
                                insurance_provider='$insurance_provider', 
                                insurance_policy_number='$insurance_policy_number', 
                                primary_care_physician='$primary_care_physician', 
                                medical_history='$medical_history', 
                                allergies='$allergies', status='$status' 
            WHERE patient_id=$patient_id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<form method="POST" action="update_patient.php?id="<?php echo $patient_id; ?>" >
    <input type="number" name="patient_id" placeholder="Patient ID" required>
    <input type="text" name="first_name" placeholder="First Name" value="<?php echo $row['first_name']; ?>" required>
    <input type="text" name="last_name" placeholder="Last Name" value ="<?php echo $row['last_name']; ?>" required>
    <input type="date" name="date_of_birth" value="<?php echo row['date_of_birth'; ?>" required>
    <select name="gender" required>
        <option value="male" <?php if ($row['gender'] == 'male') echo 'selected'; ?>>Male</option>
        <option value="female" <?php if ($row['gender'] == 'female') echo 'selected'; ?>>Female</option>
        <option value="other" <?php if ($row['gender'] == 'female') echo 'selected; ?>>Other</option>
    </select>
    <input type="email" name="email" placeholder="Email" value="<?php echo $row['email']; ?>">
    <input type="text" name="phone_number" placeholder="Phone Number" value="<?php echo $row['phone_number']; ?>" required>
    <textarea type="text" name="address" placeholder="Address" ><?php echo $row['address']; ?><textarea>
    <input type="text" name="insurance_provider" placeholder="Insurance Provider" value="<?php echo $row['insurance_provider']; ?>" >
    <input type="text" name="insurance_policy_number" placeholder="Insurance Policy Number" value="<?php echo $row['insurance_polycy_number']; ?>" >
    <input type="text" name="primary_care_physician" placeholder="Primary Care Physician" value="<?php echo $row['primary_care_physician']; ?>" >
    <textarea name="medical_history" placeholder="Medical History"><?php echo $row['medical_history']; ?></textarea>
    <textarea name="allergies" placeholder="Allergies"><?php echo $row['allergies']; ?></textarea>
    <select name="status">
        <option value="active" <?php if ($row['status'] == 'active') echo 'selected'; ?>>Active</option>
        <option value="inactive" <?php if ($row['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
        <option value="deceased" <?php if ($row['status'] == 'deceased') echo 'selected'; ?>>Deceased</option>
    </select>
    <button type="submit">Update Patient</button>
</form>
