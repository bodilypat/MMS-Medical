<?php
include 'config.php';

if (isset($_GET['id'])) {
    $record_id = $_GET['id'];
    $sql = "SELECT * FROM medical_records WHERE record_id = $record_id";
    $result = $conn->query($sql);
    $record = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $patient_id = $_POST['patient_id'];
    $appointment_id = $_POST['appointment_id'];
    $diagnosis = mysqli_real_escape_string($conn, $_POST['diagnosis']);
    $treatment_plan = mysqli_real_escape_string($conn, $_POST['treatment_plan']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);
    $status = $_POST['status'];
    $updated_by = $_POST['updated_by'];  // Assuming this is from the logged-in user
    $attachments = mysqli_real_escape_string($conn, $_POST['attachments']);  // File path/URL for attachments

    // Update query
    $sql = "UPDATE medical_records 
            SET patient_id='$patient_id', appointment_id='$appointment_id', diagnosis='$diagnosis', 
                treatment_plan='$treatment_plan', note='$note', status='$status', 
                updated_by='$updated_by', attachments='$attachments'
            WHERE record_id = $record_id";

    if ($conn->query($sql) === TRUE) {
        echo "Medical record updated successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!-- HTML Form to Update Medical Record -->
<form method="POST" action="update_medical_record.php?id=<?php echo $record['record_id']; ?>">
    <label for="patient_id">Patient ID:</label>
    <input type="number" name="patient_id" value="<?php echo $record['patient_id']; ?>" required><br>

    <label for="appointment_id">Appointment ID:</label>
    <input type="number" name="appointment_id" value="<?php echo $record['appointment_id']; ?>" required><br>

    <label for="diagnosis">Diagnosis:</label>
    <input type="text" name="diagnosis" value="<?php echo $record['diagnosis']; ?>" required><br>

    <label for="treatment_plan">Treatment Plan:</label>
    <textarea name="treatment_plan"><?php echo $record['treatment_plan']; ?></textarea><br>

    <label for="note">Note:</label>
    <textarea name="note"><?php echo $record['note']; ?></textarea><br>

    <label for="status">Status:</label>
    <select name="status">
        <option value="Active" <?php echo $record['status'] == 'Active' ? 'selected' : ''; ?>>Active</option>
        <option value="Archived" <?php echo $record['status'] == 'Archived' ? 'selected' : ''; ?>>Archived</option>
        <option value="Inactive" <?php echo $record['status'] == 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
    </select><br>

    <label for="updated_by">Updated By (User ID):</label>
    <input type="number" name="updated_by" value="<?php echo $record['updated_by']; ?>" required><br>

    <label for="attachments">Attachments (File Path/URL):</label>
    <input type="text" name="attachments" value="<?php echo $record['attachments']; ?>"><br>

    <button type="submit">Update Medical Record</button>
</form>