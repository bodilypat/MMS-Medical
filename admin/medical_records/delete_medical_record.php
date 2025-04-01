<?php
include 'config.php';

if (isset($_GET['id'])) {
    $record_id = $_GET['id'];
    $sql = "DELETE FROM medical_records WHERE record_id = $record_id";

    if ($conn->query($sql) === TRUE) {
        echo "Medical record deleted successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>