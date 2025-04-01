<?php
include 'config.php';

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

    // Insert query
    $sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, reason_for_visit, status, duration, appointment_type, notes)
            VALUES ('$patient_id', '$doctor_id', '$appointment_date', '$reason_for_visit', '$status', '$duration', '$appointment_type', '$notes')";

    if ($conn->query($sql) === TRUE) {
        echo "New appointment created successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!-- HTML Form to Create Appointment -->
<form method="POST" action="create_appointment.php">
    <label for="patient_id">Patient ID:</label>
    <input type="number" name="patient_id" required><br>

    <label for="doctor_id">Doctor ID:</label>
    <input type="number" name="doctor_id" required><br>

    <label for="appointment_date">Appointment Date:</label>
    <input type="datetime-local" name="appointment_date" required><br>

    <label for="reason_for_visit">Reason for Visit:</label>
    <input type="text" name="reason_for_visit"><br>

    <label for="status">Status:</label>
    <select name="status">
        <option value="Scheduled">Scheduled</option>
        <option value="Completed">Completed</option>
        <option value="Cancelled">Cancelled</option>
        <option value="No-Show">No-Show</option>
    </select><br>

    <label for="duration">Duration (in minutes):</label>
    <input type="number" name="duration"><br>

    <label for="appointment_type">Appointment Type:</label>
    <input type="text" name="appointment_type"><br>

    <label for="notes">Notes:</label>
    <textarea name="notes"></textarea><br>

    <button type="submit">Create Appointment</button>
</form>