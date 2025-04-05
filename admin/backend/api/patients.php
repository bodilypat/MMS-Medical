<?php
header("Content-Type: application/json");

// Include the database connection
include('../dbconnect.php');

// Handle different API methods
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // If an ID is provided, fetch a single patient
            $id = intval($_GET['id']);
            get_patient($id);
        } else {
            // Otherwise, fetch all patients
            get_patients();
        }
        break;
        
    case 'POST':
        // Create a new patient
        create_patient();
        break;

    case 'PUT':
        // Update an existing patient
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            update_patient($id);
        }
        break;

    case 'DELETE':
        // Delete a patient
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            delete_patient($id);
        }
        break;

    default:
        // Invalid method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_patients() {
    global $conn;

    $sql = "SELECT * FROM patients";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $patients = array();
        while($row = $result->fetch_assoc()) {
            $patients[] = $row;
        }
        echo json_encode($patients);
    } else {
        echo json_encode(array("message" => "No patients found"));
    }
}

function get_patient($id) {
    global $conn;

    $sql = "SELECT * FROM patients WHERE patient_id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
        echo json_encode($patient);
    } else {
        echo json_encode(array("message" => "Patient not found"));
    }
}

function create_patient() {
    global $conn;

    // Get input data from POST request
    $data = json_decode(file_get_contents("php://input"), true);

    $first_name = $data['first_name'];
    $last_name = $data['last_name'];
    $date_of_birth = $data['date_of_birth'];
    $gender = $data['gender'];
    $email = $data['email'];
    $phone_number = $data['phone_number'];
    $address = $data['address'];
    $insurance_provider = $data['insurance_provider'];
    $insurance_policy_number = $data['insurance_policy_number'];
    $primary_care_physician = $data['primary_care_physician'];
    $medical_history = $data['medical_history'];
    $allergies = $data['allergies'];
    $status = $data['status'];

    // Insert data into database
    $sql = "INSERT INTO patients (first_name, last_name, date_of_birth, gender, email, phone_number, address, insurance_provider, insurance_policy_number, primary_care_physician, medical_history, allergies, status)
            VALUES ('$first_name', '$last_name', '$date_of_birth', '$gender', '$email', '$phone_number', '$address', '$insurance_provider', '$insurance_policy_number', '$primary_care_physician', '$medical_history', '$allergies', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "New patient created successfully", "patient_id" => $conn->insert_id));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}

function update_patient($id) {
    global $conn;

    // Get input data from PUT request
    $data = json_decode(file_get_contents("php://input"), true);

    $first_name = $data['first_name'];
    $last_name = $data['last_name'];
    $date_of_birth = $data['date_of_birth'];
    $gender = $data['gender'];
    $email = $data['email'];
    $phone_number = $data['phone_number'];
    $address = $data['address'];
    $insurance_provider = $data['insurance_provider'];
    $insurance_policy_number = $data['insurance_policy_number'];
    $primary_care_physician = $data['primary_care_physician'];
    $medical_history = $data['medical_history'];
    $allergies = $data['allergies'];
    $status = $data['status'];

    // Update patient data in database
    $sql = "UPDATE patients 
            SET first_name = '$first_name', last_name = '$last_name', date_of_birth = '$date_of_birth', gender = '$gender', email = '$email', phone_number = '$phone_number', address = '$address', 
            insurance_provider = '$insurance_provider', insurance_policy_number = '$insurance_policy_number', primary_care_physician = '$primary_care_physician', 
            medical_history = '$medical_history', allergies = '$allergies', status = '$status'
            WHERE patient_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Patient updated successfully"));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}

function delete_patient($id) {
    global $conn;

    // Delete patient from database
    $sql = "DELETE FROM patients WHERE patient_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Patient deleted successfully"));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}
?>