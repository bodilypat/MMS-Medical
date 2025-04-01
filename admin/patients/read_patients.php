<?php
include 'config.php';

$sql = "SELECT * FROM patients";
$result = $deal->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr>
            <th>ID</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["patient_id"] . "</td>";
        echo "<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>";
        echo "<td>" . $row["gender"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["phone_number"] . "</td>";
        echo "<td>" . $row["status"] . "</td>";
        echo "<td>
            <a href='update_patient.php?id=" . $row["patient_id"] . "'>Edit</a> |
            <a href='delete_patient.php?id=" . $row["patient_id"] . "'>Delete</a>
        </td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No patients found.";
}

$conn->close();
?>
