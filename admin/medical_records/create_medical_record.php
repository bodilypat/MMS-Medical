<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $patient_id = $_POST['patient_id'];
    $appointment_id = $_POST['appointment_id'];
    $diagnosis = mysqli_real_escape_string($conn, $_POST['diagnosis']);
    $treatment_plan = mysqli_real_escape_string($conn, $_POST['treatment_plan']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);
    $status = $_POST['status'];
    $created_by = $_POST['created_by'];  // Assuming this is from the logged-in user
    $updated_by = $_POST['updated_by'];  // Assuming this is from the logged-in user
    $attachments = mysqli_real_escape_string($conn, $_POST['attachments']);  // File path/URL for attachments

    // Insert query to create a new record
    $sql = "INSERT INTO medical_records (patient_id, appointment_id, diagnosis, treatment_plan, note, status, created_by, updated_by, attachments)
            VALUES ('$patient_id', '$appointment_id', '$diagnosis', '$treatment_plan', '$note', '$status', '$created_by', '$updated_by', '$attachments')";

    if ($conn->query($sql) === TRUE) {
        echo "New medical record created successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!-- HTML Form to Create Medical Record -->
<form method="POST" action="create_medical_record.php">
    <label for="patient_id">Patient ID:</label>
    <input type="number" name="patient_id" required><br>

    <label for="appointment_id">Appointment ID:</label>
    <input type="number" name="appointment_id" required><br>

    <label for="diagnosis">Diagnosis:</label>
    <input type="text" name="diagnosis" required><br>

    <label for="treatment_plan">Treatment Plan:</label>
    <textarea name="treatment_plan"></textarea><br>

    <label for="note">Note:</label>
    <textarea name="note"></textarea><br>

    <label for="status">Status:</label>
    <select name="status">
        <option value="Active">Active</option>
        <option value="Archived">Archived</option>
        <option value="Inactive">Inactive</option>
    </select><br>

    <label for="created_by">Created By (User ID):</label>
    <input type="number" name="created_by" required><br>

    <label for="updated_by">Updated By (User ID):</label>
    <input type="number" name="updated_by" required><br>

    <label for="attachments">Attachments (File Path/URL):</label>
    <input type="text" name="attachments"><br>

    <button type="submit">Create Medical Record</button>
</form>