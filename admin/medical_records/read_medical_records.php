<?php
include 'config.php';

$sql = "SELECT mr.record_id, p.first_name AS patient_first_name, p.last_name AS patient_last_name, 
               a.appointment_date, mr.diagnosis, mr.treatment_plan, mr.status 
        FROM medical_records mr
        JOIN patients p ON mr.patient_id = p.patient_id
        JOIN appointments a ON mr.appointment_id = a.appointment_id
        ORDER BY a.appointment_date DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Record ID</th>
                <th>Patient Name</th>
                <th>Appointment Date</th>
                <th>Diagnosis</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["record_id"] . "</td>
                <td>" . $row["patient_first_name"] . " " . $row["patient_last_name"] . "</td>
                <td>" . $row["appointment_date"] . "</td>
                <td>" . $row["diagnosis"] . "</td>
                <td>" . $row["status"] . "</td>
                <td>
                    <a href='update_medical_record.php?id=" . $row["record_id"] . "'>Edit</a> |
                    <a href='delete_medical_record.php?id=" . $row["record_id"] . "'>Delete</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No medical records found.";
}

$conn->close();
?>