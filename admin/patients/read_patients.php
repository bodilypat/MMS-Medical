<?php
include 'config.php';

$sql = "SELECT * FROM patients";
$result = $deal->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["patient_id"]. " - Name: " . $row["first_name"]. " " . $row["last_name"]. "<br>";
        echo "Date of Birth: " . $row["date_of_birth"]. "<br>";
        echo "Gender: " . $row["gender"]. "<br>";
        echo "Email: " . $row["email"]. "<br>";
        echo "Phone: " . $row["phone_number"]. "<br>";
        echo "Address: " . $row["address"]. "<br>";
        echo "Insurance Provider: " . $row["insurance_provider"]. "<br>";
        echo "Policy Number: " . $row["insurance_policy_number"]. "<br>";
        echo "Primary Care Physician: " . $row["primary_care_physician"]. "<br>";
        echo "Medical History: " . $row["medical_history"]. "<br>";
        echo "Allergies: " . $row["allergies"]. "<br>";
        echo "Status: " . $row["status"]. "<br>";
        echo "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>
