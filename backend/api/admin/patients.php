<?php
header('Content-Type: application/json');
include 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['patient_id'])) {
            getPatient($pdo, $_GET['patient_id']);
        } else {
            getPatients($pdo);
        }
        break;
    case 'POST':
        createPatient($pdo);
        break;
    case 'PUT':
        updatePatient($pdo);
        break;
    case 'DELETE':
        deletePatient($pdo);
        break;
    default:
        echo json_encode(['message' => 'Method Not Allowed']);
        break;
}

function getPatients($pdo) {
    $stmt = $pdo->query('SELECT * FROM patients');
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($patients);
}

function getPatient($pdo, $patient_id) {
    $stmt = $pdo->prepare('SELECT * FROM patients WHERE patient_id = :patient_id');
    $stmt->execute(['patient_id' => $patient_id]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($patient) {
        echo json_encode($patient);
    } else {
        echo json_encode(['message' => 'Patient not found']);
    }
}

function createPatient($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Validate input data
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) && !empty($data['email'])) {
        echo json_encode(['message' => 'Invalid email format']);
        return;
    }

    if (!preg_match('/^[0-9]{10,15}$/', $data['phone_number'])) {
        echo json_encode(['message' => 'Invalid phone number format']);
        return;
    }

    // Check if patient with the same email or phone number already exists
    $stmt = $pdo->prepare('SELECT * FROM patients WHERE email = :email OR phone_number = :phone_number');
    $stmt->execute([
        'email' => $data['email'],
        'phone_number' => $data['phone_number']
    ]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['message' => 'Patient with the same email or phone number already exists']);
        return;
    }

    // Insert patient into database
    $stmt = $pdo->prepare('
        INSERT INTO patients (first_name, last_name, date_of_birth, gender, email, phone_number, address, 
                              insurance_provider, insurance_policy_number, primary_care_physician, medical_history, allergies, status)
        VALUES (:first_name, :last_name, :date_of_birth, :gender, :email, :phone_number, :address, 
                :insurance_provider, :insurance_policy_number, :primary_care_physician, :medical_history, :allergies, :status)
    ');
    
    $stmt->execute([
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'date_of_birth' => $data['date_of_birth'],
        'gender' => $data['gender'],
        'email' => $data['email'],
        'phone_number' => $data['phone_number'],
        'address' => $data['address'],
        'insurance_provider' => $data['insurance_provider'],
        'insurance_policy_number' => $data['insurance_policy_number'],
        'primary_care_physician' => $data['primary_care_physician'],
        'medical_history' => $data['medical_history'],
        'allergies' => $data['allergies'],
        'status' => $data['status']
    ]);

    echo json_encode(['message' => 'Patient created successfully']);
}

function updatePatient($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['patient_id'])) {
        echo json_encode(['message' => 'Patient ID is required']);
        return;
    }

    $stmt = $pdo->prepare('SELECT * FROM patients WHERE patient_id = :patient_id');
    $stmt->execute(['patient_id' => $data['patient_id']]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$patient) {
        echo json_encode(['message' => 'Patient not found']);
        return;
    }

    $stmt = $pdo->prepare('
        UPDATE patients 
        SET first_name = :first_name, last_name = :last_name, date_of_birth = :date_of_birth, 
            gender = :gender, email = :email, phone_number = :phone_number, address = :address, 
            insurance_provider = :insurance_provider, insurance_policy_number = :insurance_policy_number, 
            primary_care_physician = :primary_care_physician, medical_history = :medical_history, 
            allergies = :allergies, status = :status, updated_at = CURRENT_TIMESTAMP
        WHERE patient_id = :patient_id
    ');
    
    $stmt->execute([
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'date_of_birth' => $data['date_of_birth'],
        'gender' => $data['gender'],
        'email' => $data['email'],
        'phone_number' => $data['phone_number'],
        'address' => $data['address'],
        'insurance_provider' => $data['insurance_provider'],
        'insurance_policy_number' => $data['insurance_policy_number'],
        'primary_care_physician' => $data['primary_care_physician'],
        'medical_history' => $data['medical_history'],
        'allergies' => $data['allergies'],
        'status' => $data['status'],
        'patient_id' => $data['patient_id']
    ]);

    echo json_encode(['message' => 'Patient updated successfully']);
}

function deletePatient($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['patient_id'])) {
        echo json_encode(['message' => 'Patient ID is required']);
        return;
    }

    $stmt = $pdo->prepare('SELECT * FROM patients WHERE patient_id = :patient_id');
    $stmt->execute(['patient_id' => $data['patient_id']]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$patient) {
        echo json_encode(['message' => 'Patient not found']);
        return;
    }

    $stmt = $pdo->prepare('DELETE FROM patients WHERE patient_id = :patient_id');
    $stmt->execute(['patient_id' => $data['patient_id']]);

    echo json_encode(['message' => 'Patient deleted successfully']);
}
?>