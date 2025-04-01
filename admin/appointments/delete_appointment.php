<?php
include 'config.php';

if (isset($_GET['id'])) {
    $appointment_id = $_GET['id'];
    $sql = "DELETE FROM appointments WHERE appointment_id = $appointment_id";

    if ($conn->query($sql) === TRUE) {
        echo "Appointment deleted successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>