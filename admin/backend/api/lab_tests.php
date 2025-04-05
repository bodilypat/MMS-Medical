<?php
header("Content-Type: application/json");

// Include the database connection
include('../dbconnect.php');

// Handle different API methods
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // If an ID is provided, fetch a specific lab test
            $id = intval($_GET['id']);
            get_lab_test($id);
        } else {
            // Otherwise, fetch all lab tests
            get_lab_tests();
        }
        break;

    case 'POST':
        // Create a new lab test
        create_lab_test();
        break;

    case 'PUT':
        // Update an existing lab test
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            update_lab_test($id);
        }
        break;

    case 'DELETE':
        // Delete a lab test
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            delete_lab_test($id);
        }
        break;

    default:
        // Invalid method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_lab_tests() {
    global $conn;

    $sql = "SELECT * FROM lab_tests";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $tests = array();
        while($row = $result->fetch_assoc()) {
            $tests[] = $row;
        }
        echo json_encode($tests);
    } else {
        echo json_encode(array("message" => "No lab tests found"));
    }
}

function get_lab_test($id) {
    global $conn;

    $sql = "SELECT * FROM lab_tests WHERE test_id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $test = $result->fetch_assoc();
        echo json_encode($test);
    } else {
        echo json_encode(array("message" => "Lab test not found"));
    }
}

function create_lab_test() {
    global $conn;

    // Get input data from POST request
    $data = json_decode(file_get_contents("php://input"), true);

    $patient_id = $data['patient_id'];
    $appointment_id = $data['appointment_id'];
    $test_name = $data['test_name'];
    $test_date = $data['test_date'];
    $results = isset($data['results']) ? $data['results'] : null;
    $test_status = isset($data['test_status']) ? $data['test_status'] : 'Pending';  // Default to 'Pending'

    // Insert data into the database
    $sql = "INSERT INTO lab_tests (patient_id, appointment_id, test_name, test_date, results, test_status)
            VALUES ('$patient_id', '$appointment_id', '$test_name', '$test_date', '$results', '$test_status')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "New lab test created successfully", "test_id" => $conn->insert_id));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}

function update_lab_test($id) {
    global $conn;

    // Get input data from PUT request
    $data = json_decode(file_get_contents("php://input"), true);

    $test_name = $data['test_name'];
    $test_date = $data['test_date'];
    $results = isset($data['results']) ? $data['results'] : null;
    $test_status = isset($data['test_status']) ? $data['test_status'] : 'Pending';  // Default to 'Pending'

    // Update lab test data in the database
    $sql = "UPDATE lab_tests 
            SET test_name = '$test_name', test_date = '$test_date', results = '$results', test_status = '$test_status'
            WHERE test_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Lab test updated successfully"));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}

function delete_lab_test($id) {
    global $conn;

    // Delete lab test from the database
    $sql = "DELETE FROM lab_tests WHERE test_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Lab test deleted successfully"));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}
?>