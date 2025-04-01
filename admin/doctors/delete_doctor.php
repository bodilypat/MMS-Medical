<?php
include 'config.php';

if (isset($_GET['id'])) {
    $doctor_id = $_GET['id'];
    $sql = "DELETE FROM doctors WHERE doctor_id = $doctor_id";

    if ($conn->query($sql) === TRUE) {
        echo "Doctor record deleted successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>