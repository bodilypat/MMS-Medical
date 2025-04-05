<?php
header("Content-Type: application/json");

// Include the database connection
include('../dbconnect.php');

// Handle different API methods
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // If an ID is provided, fetch a single prescription
            $id = intval($_GET['id']);
            get_prescription($id);
        } else {
            // Otherwise, fetch all prescriptions
            get_prescriptions();
        }
        break;
        
    case 'POST':
        // Create a new prescription
        create_prescription();
        break;

    case 'PUT':
        // Update an existing prescription
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            update_prescription($id);
        }
        break;

    case 'DELETE':
        // Delete a prescription
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            delete_prescription($id);
        }
        break;

    default:
        // Invalid method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_prescriptions() {
    global $conn;

    $sql = "SELECT * FROM prescriptions";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $prescriptions = array();
        while($row = $result->fetch_assoc()) {
            $prescriptions[] = $row;
        }
        echo json_encode($prescriptions);
    } else {
        echo json_encode(array("message" => "No prescriptions found"));
    }
}

function get_prescription($id) {
    global $conn;

    $sql = "SELECT * FROM prescriptions WHERE prescription_id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $prescription = $result->fetch_assoc();
        echo json_encode($prescription);
    } else {
        echo json_encode(array("message" => "Prescription not found"));
    }
}

function create_prescription() {
    global $conn;

    // Get input data from POST request
    $data = json_decode(file_get_contents("php://input"), true);

    $record_id = $data['record_id'];
    $medication_name = $data['medication_name'];
    $dosage = $data['dosage'];
    $frequency = $data['frequency'];
    $start_date = $data['start_date'];
    $end_date = isset($data['end_date']) ? $data['end_date'] : null;  // End date is optional
    $instructions = isset($data['instructions']) ? $data['instructions'] : null;
    $status = isset($data['status']) ? $data['status'] : 'Active';  // Default to 'Active'
    $created_by = $data['created_by'];
    $updated_by = $data['updated_by'];

    // Insert data into the database
    $sql = "INSERT INTO prescriptions (record_id, medication_name, dosage, frequency, start_date, end_date, instructions, status, created_by, updated_by)
            VALUES ('$record_id', '$medication_name', '$dosage', '$frequency', '$start_date', '$end_date', '$instructions', '$status', '$created_by', '$updated_by')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "New prescription created successfully", "prescription_id" => $conn->insert_id));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}

function update_prescription($id) {
    global $conn;

    // Get input data from PUT request
    $data = json_decode(file_get_contents("php://input"), true);

    $medication_name = $data['medication_name'];
    $dosage = $data['dosage'];
    $frequency = $data['frequency'];
    $start_date = $data['start_date'];
    $end_date = isset($data['end_date']) ? $data['end_date'] : null;
    $instructions = isset($data['instructions']) ? $data['instructions'] : null;
    $status = isset($data['status']) ? $data['status'] : 'Active';  // Default to 'Active'
    $updated_by = $data['updated_by'];

    // Update prescription data in database
    $sql = "UPDATE prescriptions 
            SET medication_name = '$medication_name', dosage = '$dosage', frequency = '$frequency', start_date = '$start_date', end_date = '$end_date', 
            instructions = '$instructions', status = '$status', updated_by = '$updated_by'
            WHERE prescription_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Prescription updated successfully"));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}

function delete_prescription($id) {
    global $conn;

    // Delete prescription from database
    $sql = "DELETE FROM prescriptions WHERE prescription_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Prescription deleted successfully"));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}
?>