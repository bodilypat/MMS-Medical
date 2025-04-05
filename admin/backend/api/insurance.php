<?php
header("Content-Type: application/json");

// Include the database connection
include('../dbconnect.php');

// Handle different API methods
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // If an ID is provided, fetch a specific insurance record
            $id = intval($_GET['id']);
            get_insurance($id);
        } else {
            // Otherwise, fetch all insurance records
            get_insurances();
        }
        break;

    case 'POST':
        // Create a new insurance record
        create_insurance();
        break;

    case 'PUT':
        // Update an existing insurance record
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            update_insurance($id);
        }
        break;

    case 'DELETE':
        // Delete an insurance record
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            delete_insurance($id);
        }
        break;

    default:
        // Invalid method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_insurances() {
    global $conn;

    $sql = "SELECT * FROM insurance";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $insurances = array();
        while ($row = $result->fetch_assoc()) {
            $insurances[] = $row;
        }
        echo json_encode($insurances);
    } else {
        echo json_encode(array("message" => "No insurance records found"));
    }
}

function get_insurance($id) {
    global $conn;

    $sql = "SELECT * FROM insurance WHERE insurance_id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $insurance = $result->fetch_assoc();
        echo json_encode($insurance);
    } else {
        echo json_encode(array("message" => "Insurance record not found"));
    }
}

function create_insurance() {
    global $conn;

    // Get input data from POST request
    $data = json_decode(file_get_contents("php://input"), true);

    $provider_name = $data['provider_name'];
    $policy_number = $data['policy_number'];
    $coverage_type = $data['coverage_type'];
    $coverage_amount = $data['coverage_amount'];
    $patient_id = $data['patient_id'];
    $start_date = $data['start_date'];
    $end_date = $data['end_date'];

    // Insert data into the database
    $sql = "INSERT INTO insurance (provider_name, policy_number, coverage_type, coverage_amount, patient_id, start_date, end_date)
            VALUES ('$provider_name', '$policy_number', '$coverage_type', '$coverage_amount', '$patient_id', '$start_date', '$end_date')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "New insurance record created successfully", "insurance_id" => $conn->insert_id));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}

function update_insurance($id) {
    global $conn;

    // Get input data from PUT request
    $data = json_decode(file_get_contents("php://input"), true);

    $provider_name = $data['provider_name'];
    $policy_number = $data['policy_number'];
    $coverage_type = $data['coverage_type'];
    $coverage_amount = $data['coverage_amount'];
    $patient_id = $data['patient_id'];
    $start_date = $data['start_date'];
    $end_date = $data['end_date'];

    // Update insurance data in the database
    $sql = "UPDATE insurance
            SET provider_name = '$provider_name', policy_number = '$policy_number', coverage_type = '$coverage_type', coverage_amount = '$coverage_amount', patient_id = '$patient_id', start_date = '$start_date', end_date = '$end_date'
            WHERE insurance_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Insurance record updated successfully"));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}

function delete_insurance($id) {
    global $conn;

    // Delete insurance record from the database
    $sql = "DELETE FROM insurance WHERE insurance_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Insurance record deleted successfully"));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}
?>