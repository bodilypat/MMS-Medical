<?php
header("Content-Type: application/json");

// Include the database connection
include('../dbconnect.php');

// Handle different API methods
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // If an ID is provided, fetch a single appointment
            $id = intval($_GET['id']);
            get_appointment($id);
        } else {
            // Otherwise, fetch all appointments
            get_appointments();
        }
        break;
        
    case 'POST':
        // Create a new appointment
        create_appointment();
        break;

    case 'PUT':
        // Update an existing appointment
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            update_appointment($id);
        }
        break;

    case 'DELETE':
        // Delete an appointment
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            delete_appointment($id);
        }
        break;

    default:
        // Invalid method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_appointments() {
    global $conn;

    $sql = "SELECT * FROM appointments";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $appointments = array();
        while($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
        echo json_encode($appointments);
    } else {
        echo json_encode(array("message" => "No appointments found"));
    }
}

function get_appointment($id) {
    global $conn;

    $sql = "SELECT * FROM appointments WHERE appointment_id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $appointment = $result->fetch_assoc();
        echo json_encode($appointment);
    } else {
        echo json_encode(array("message" => "Appointment not found"));
    }
}

function create_appointment() {
    global $conn;

    // Get input data from POST request
    $data = json_decode(file_get_contents("php://input"), true);

    $patient_id = $data['patient_id'];
    $doctor_id = $data['doctor_id'];
    $appointment_date = $data['appointment_date'];
    $reason_for_visit = $data['reason_for_visit'];
    $status = $data['status'];
    $duration = $data['duration'];
    $appointment_type = $data['appointment_type'];
    $notes = $data['notes'];

    // Insert data into database
    $sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, reason_for_visit, status, duration, appointment_type, notes)
            VALUES ('$patient_id', '$doctor_id', '$appointment_date', '$reason_for_visit', '$status', '$duration', '$appointment_type', '$notes')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "New appointment created successfully", "appointment_id" => $conn->insert_id));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}

function update_appointment($id) {
    global $conn;

    // Get input data from PUT request
    $data = json_decode(file_get_contents("php://input"), true);

    $patient_id = $data['patient_id'];
    $doctor_id = $data['doctor_id'];
    $appointment_date = $data['appointment_date'];
    $reason_for_visit = $data['reason_for_visit'];
    $status = $data['status'];
    $duration = $data['duration'];
    $appointment_type = $data['appointment_type'];
    $notes = $data['notes'];

    // Update appointment data in database
    $sql = "UPDATE appointments 
            SET patient_id = '$patient_id', doctor_id = '$doctor_id', appointment_date = '$appointment_date', reason_for_visit = '$reason_for_visit', 
            status = '$status', duration = '$duration', appointment_type = '$appointment_type', notes = '$notes'
            WHERE appointment_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Appointment updated successfully"));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}

function delete_appointment($id) {
    global $conn;

    // Delete appointment from database
    $sql = "DELETE FROM appointments WHERE appointment_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Appointment deleted successfully"));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}
?>