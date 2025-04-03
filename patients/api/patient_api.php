<?php
header('Content-Type: application/json'); // Set header to JSON for API responses

// Include database connection
require_once 'db_config.php';

// Handle different HTTP methods (GET, POST, PUT, DELETE)
$request_method = $_SERVER['REQUEST_METHOD'];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            getPatient($_GET['id']);  // Get patient by ID
        } else {
            getPatients();  // Get all patients
        }
        break;

    case 'POST':
        addPatient();  // Add a new patient
        break;

    case 'PUT':
        updatePatient();  // Update patient details
        break;

    case 'DELETE':
        deletePatient();  // Delete a patient by ID
        break;

    default:
        echo json_encode(['message' => 'Invalid request method']);
        break;
}

// Function to get all patients
function getPatients()
{
    global $conn;
    $sql = "SELECT * FROM patients";
    $result = $conn->query($sql);
    $patients = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $patients[] = $row;
        }
        echo json_encode($patients);
    } else {
        echo json_encode(['message' => 'No patients found']);
    }
}

// Function to get a specific patient by ID
function getPatient($id)
{
    global $conn;
    $sql = "SELECT * FROM patients WHERE patient_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $patient = $result->fetch_assoc();

    if ($patient) {
        echo json_encode($patient);
    } else {
        echo json_encode(['message' => 'Patient not found']);
    }
}

// Function to add a new patient
function addPatient()
{
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true); // Get data from POST body

    if (!empty($data)) {
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

        $sql = "INSERT INTO patients (first_name, last_name, date_of_birth, gender, email, phone_number, address, insurance_provider, insurance_policy_number, primary_care_physician, medical_history, allergies, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssssss", $first_name, $last_name, $date_of_birth, $gender, $email, $phone_number, $address, $insurance_provider, $insurance_policy_number, $primary_care_physician, $medical_history, $allergies, $status);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Patient added successfully']);
        } else {
            echo json_encode(['message' => 'Failed to add patient']);
        }
    } else {
        echo json_encode(['message' => 'Invalid data']);
    }
}

// Function to update a patient's details
function updatePatient()
{
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true); // Get data from PUT body

    if (isset($data['patient_id'])) {
        $patient_id = $data['patient_id'];
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

        $sql = "UPDATE patients SET first_name = ?, last_name = ?, date_of_birth = ?, gender = ?, email = ?, phone_number = ?, address = ?, insurance_provider = ?, insurance_policy_number = ?, primary_care_physician = ?, medical_history = ?, allergies = ?, status = ? WHERE patient_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssssssi", $first_name, $last_name, $date_of_birth, $gender, $email, $phone_number, $address, $insurance_provider, $insurance_policy_number, $primary_care_physician, $medical_history, $allergies, $status, $patient_id);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Patient updated successfully']);
        } else {
            echo json_encode(['message' => 'Failed to update patient']);
        }
    } else {
        echo json_encode(['message' => 'Patient ID is required']);
    }
}

// Function to delete a patient by ID
function deletePatient()
{
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true); // Get data from DELETE body

    if (isset($data['patient_id'])) {
        $patient_id = $data['patient_id'];

        $sql = "DELETE FROM patients WHERE patient_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $patient_id);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Patient deleted successfully']);
        } else {
            echo json_encode(['message' => 'Failed to delete patient']);
        }
    } else {
        echo json_encode(['message' => 'Patient ID is required']);
    }
}

$conn->close(); // Close database connection
?>
