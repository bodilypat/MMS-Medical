<?php
include 'config.php';

if (isset($_GET['id'])) {
    $appointment_id = $_GET['id'];
    $sql = "SELECT * FROM appointments WHERE appointment_id = $appointment_id";
    $result = $conn->query($sql);
    $appointment = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $reason_for_visit = mysqli_real_escape_string($conn, $_POST['reason_for_visit']);
    $status = $_POST['status'];
    $duration = $_POST['duration'];
    $appointment_type = mysqli_real_escape_string($conn, $_POST['appointment_type']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);

    // Update query
    $sql = "UPDATE appointments 
            SET patient_id='$patient_id', doctor_id='$doctor_id', appointment_date='$appointment_date', reason_for_visit='$reason_for_visit', 
                status='$status', duration='$duration', appointment_type='$appointment_type', notes='$notes'
            WHERE appointment_id = $appointment_id";

    if ($conn->query($sql) === TRUE) {
        echo "Appointment updated successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!-- HTML Form to Update Appointment -->
<form method="POST" action="update_appointment.php?id=<?php echo $appointment['appointment_id']; ?>">
    <label for="patient_id">Patient ID:</label>
    <input type="number" name="patient_id" value="<?php echo $appointment['patient_id']; ?>" required><br>

    <label for="doctor_id">Doctor ID:</label>
    <input type="number" name="doctor_id" value="<?php echo $appointment['doctor_id']; ?>" required><br>

    <label for="appointment_date">Appointment Date:</label>
    <input type="datetime-local" name="appointment_date" value="<?php echo $appointment['appointment_date']; ?>" required><br>

    <label for="reason_for_visit">Reason for Visit:</label>
    <input type="text" name="reason_for_visit" value="<?php echo $appointment['reason_for_visit']; ?>"><br>

    <label for="status">Status:</label>
    <select name="status">
        <option value="Scheduled" <?php echo $appointment['status'] == 'Scheduled' ? 'selected' : ''; ?>>Scheduled</option>
        <option value="Completed" <?php echo $appointment['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
        <option value="Cancelled" <?php echo $appointment['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
        <option value="No-Show" <?php echo $appointment['status'] == 'No-Show' ? 'selected' : ''; ?>>No-Show</option>
    </select><br>

    <label for="duration">Duration (in minutes):</label>
    <input type="number" name="duration" value="<?php echo $appointment['duration']; ?>"><br>

    <label for="appointment_type">Appointment Type:</label>
    <input type="text" name="appointment_type" value="<?php echo $appointment['appointment_type']; ?>"><br>

    <label for="notes">Notes:</label>
    <textarea name="notes"><?php echo $appointment['notes']; ?></textarea><br>

    <button type="submit">Update Appointment</button>
</form>