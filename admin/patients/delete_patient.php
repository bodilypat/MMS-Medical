<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST['patient_id'];

    $sql = "DELETE FROM patients WHERE patient_id=$patient_id";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<form method="POST" action="delete_patient.php">
    <input type="number" name="patient_id" placeholder="Patient ID" required>
    <button type="submit">Delete Patient</button>
</form>