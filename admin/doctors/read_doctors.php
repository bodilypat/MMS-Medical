<?php
include 'config.php';

$sql = "SELECT * FROM doctors";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr>
			<th>Doctor ID</th>
			<th>Name</th>
			<th>Specialization</th>
			<th>Email</th>
			<th>Phone Number</th>
			<th>Department</th>
			<th>Status</th>
			<th>Actions</th>
		</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["doctor_id"] . "</td>";
        echo "<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>";
        echo "<td>" . $row["specialization"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["phone_number"] . "</td>";
        echo "<td>" . $row["department"] . "</td>";
        echo "<td>" . $row["status"] . "</td>";
        echo "<td>
            <a href='update_doctor.php?id=" . $row["doctor_id"] . "'>Edit</a> |
            <a href='delete_doctor.php?id=" . $row["doctor_id"] . "'>Delete</a>
        </td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No doctors found.";
}

$conn->close();
?>