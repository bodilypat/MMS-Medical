<?php
include 'config.php';

if (isset($_GET['id'])) {
    $patient_id = $_GET['id'];
    $sql = "DELETE FROM patients WHERE patient_id = $patient_id";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
