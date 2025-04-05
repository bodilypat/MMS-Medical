<?php
header("Content-Type: application/json");

// Include the database connection
include('../dbconnect.php');

// Handle different API methods
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // If an ID is provided, fetch a specific medical record
            $id = intval($_GET['id']);
            get_medical_record($id);
        } else {
            // Otherwise, fetch all medical records
            get_medical_records();
        }
        break;
        
    case 'POST':
        // Create a new medical record
        create_medical_record();
        break;

    case 'PUT':
        // Update an existing medical record
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            update_medical_record($id);
        }
        break;

    case 'DELETE':
        // Delete a medical record
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            delete_medical_record($id);
        }
        break;

    default:
        // Invalid method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_medical_records() {
    global $conn;

    $sql = "SELECT * FROM medical_records";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $records = array();
        while($row = $result->fetch_assoc()) {
            $records[] = $row;
        }
        echo json_encode($records);
    } else {
        echo json_encode(array("message" => "No medical records found"));
    }
}

function get_medical_record($id) {
    global $conn;

    $sql = "SELECT * FROM medical_records WHERE record_id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $record = $result->fetch_assoc();
        echo json_encode($record);
    } else {
        echo json_encode(array("message" => "Medical record not found"));
    }
}

function create_medical_record() {
    global $conn;

    // Get input data from POST request
    $data = json_decode(file_get_contents("php://input"), true);

    $patient_id = $data['patient_id'];
    $appointment_id = $data['appointment_id'];
    $diagnosis = $data['diagnosis'];
    $treatment_plan = $data['treatment_plan'];
    $note = isset($data['note']) ? $data['note'] : null;
    $status = isset($data['status']) ? $data['status'] : 'Active';  // Default to 'Active'
    $created_by = $data['created_by'];
    $updated_by = $data['updated_by'];
    $attachments = isset($data['attachments']) ? $data['attachments'] : null;

    // Insert data into the database
    $sql = "INSERT INTO medical_records (patient_id, appointment_id, diagnosis, treatment_plan, note, status, created_by, updated_by, attachments)
            VALUES ('$patient_id', '$appointment_id', '$diagnosis', '$treatment_plan', '$note', '$status', '$created_by', '$updated_by', '$attachments')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "New medical record created successfully", "record_id" => $conn->insert_id));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}

function update_medical_record($id) {
    global $conn;

    // Get input data from PUT request
    $data = json_decode(file_get_contents("php://input"), true);

    $diagnosis = $data['diagnosis'];
    $treatment_plan = $data['treatment_plan'];
    $note = isset($data['note']) ? $data['note'] : null;
    $status = isset($data['status']) ? $data['status'] : 'Active';  // Default to 'Active'
    $updated_by = $data['updated_by'];
    $attachments = isset($data['attachments']) ? $data['attachments'] : null;

    // Update medical record data in database
    $sql = "UPDATE medical_records 
            SET diagnosis = '$diagnosis', treatment_plan = '$treatment_plan', note = '$note', status = '$status', updated_by = '$updated_by', attachments = '$attachments'
            WHERE record_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Medical record updated successfully"));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}

function delete_medical_record($id) {
    global $conn;

    // Delete medical record from the database
    $sql = "DELETE FROM medical_records WHERE record_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Medical record deleted successfully"));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}
?>