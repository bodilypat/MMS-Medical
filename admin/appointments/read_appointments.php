<?php
include 'config.php';

$sql = "SELECT a.appointment_id, p.first_name AS patient_first_name, p.last_name AS patient_last_name, 
               d.first_name AS doctor_first_name, d.last_name AS doctor_last_name, 
               a.appointment_date, a.status 
        FROM appointments a
        JOIN patients p ON a.patient_id = p.patient_id
        JOIN doctors d ON a.doctor_id = d.doctor_id
        ORDER BY a.appointment_date ASC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Appointment ID</th>
                <th>Patient Name</th>
                <th>Doctor Name</th>
                <th>Appointment Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["appointment_id"] . "</td>
                <td>" . $row["patient_first_name"] . " " . $row["patient_last_name"] . "</td>
                <td>" . $row["doctor_first_name"] . " " . $row["doctor_last_name"] . "</td>
                <td>" . $row["appointment_date"] . "</td>
                <td>" . $row["status"] . "</td>
                <td>
                    <a href='update_appointment.php?id=" . $row["appointment_id"] . "'>Edit</a> |
                    <a href='delete_appointment.php?id=" . $row["appointment_id"] . "'>Delete</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No appointments found.";
}

$conn->close();
?>