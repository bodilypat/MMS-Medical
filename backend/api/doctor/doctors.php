<?php
header('Content-Type: application/json');
include 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['doctor_id'])) {
            getDoctor($pdo, $_GET['doctor_id']);
        } else {
            getDoctors($pdo);
        }
        break;
    case 'POST':
        createDoctor($pdo);
        break;
    case 'PUT':
        updateDoctor($pdo);
        break;
    case 'DELETE':
        deleteDoctor($pdo);
        break;
    default:
        echo json_encode(['message' => 'Method Not Allowed']);
        break;
}

function getDoctors($pdo) {
    $stmt = $pdo->query('SELECT * FROM doctors');
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($doctors);
}

function getDoctor($pdo, $doctor_id) {
    $stmt = $pdo->prepare('SELECT * FROM doctors WHERE doctor_id = :doctor_id');
    $stmt->execute(['doctor_id' => $doctor_id]);
    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($doctor) {
        echo json_encode($doctor);
    } else {
        echo json_encode(['message' => 'Doctor not found']);
    }
}

function createDoctor($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Validate input data
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['message' => 'Invalid email format']);
        return;
    }

    if (!preg_match('/^[0-9]{10,15}$/', $data['phone_number'])) {
        echo json_encode(['message' => 'Invalid phone number format']);
        return;
    }

    // Check if doctor with the same email or phone number already exists
    $stmt = $pdo->prepare('SELECT * FROM doctors WHERE email = :email OR phone_number = :phone_number');
    $stmt->execute([
        'email' => $data['email'],
        'phone_number' => $data['phone_number']
    ]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['message' => 'Doctor with the same email or phone number already exists']);
        return;
    }

    // Insert doctor into database
    $stmt = $pdo->prepare('
        INSERT INTO doctors (first_name, last_name, specialization, email, phone_number, department, birthdate, address, status, notes)
        VALUES (:first_name, :last_name, :specialization, :email, :phone_number, :department, :birthdate, :address, :status, :notes)
    ');
    
    $stmt->execute([
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'specialization' => $data['specialization'],
        'email' => $data['email'],
        'phone_number' => $data['phone_number'],
        'department' => $data['department'],
        'birthdate' => $data['birthdate'],
        'address' => $data['address'],
        'status' => $data['status'],
        'notes' => $data['notes']
    ]);

    echo json_encode(['message' => 'Doctor created successfully']);
}

function updateDoctor($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['doctor_id'])) {
        echo json_encode(['message' => 'Doctor ID is required']);
        return;
    }

    $stmt = $pdo->prepare('SELECT * FROM doctors WHERE doctor_id = :doctor_id');
    $stmt->execute(['doctor_id' => $data['doctor_id']]);
    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$doctor) {
        echo json_encode(['message' => 'Doctor not found']);
        return;
    }

    $stmt = $pdo->prepare('
        UPDATE doctors 
        SET first_name = :first_name, last_name = :last_name, specialization = :specialization, 
            email = :email, phone_number = :phone_number, department = :department, birthdate = :birthdate, 
            address = :address, status = :status, notes = :notes, updated_at = CURRENT_TIMESTAMP
        WHERE doctor_id = :doctor_id
    ');
    
    $stmt->execute([
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'specialization' => $data['specialization'],
        'email' => $data['email'],
        'phone_number' => $data['phone_number'],
        'department' => $data['department'],
        'birthdate' => $data['birthdate'],
        'address' => $data['address'],
        'status' => $data['status'],
        'notes' => $data['notes'],
        'doctor_id' => $data['doctor_id']
    ]);

    echo json_encode(['message' => 'Doctor updated successfully']);
}

function deleteDoctor($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['doctor_id'])) {
        echo json_encode(['message' => 'Doctor ID is required']);
        return;
    }

    $stmt = $pdo->prepare('SELECT * FROM doctors WHERE doctor_id = :doctor_id');
    $stmt->execute(['doctor_id' => $data['doctor_id']]);
    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$doctor) {
        echo json_encode(['message' => 'Doctor not found']);
        return;
    }

    $stmt = $pdo->prepare('DELETE FROM doctors WHERE doctor_id = :doctor_id');
    $stmt->execute(['doctor_id' => $data['doctor_id']]);

    echo json_encode(['message' => 'Doctor deleted successfully']);
}
?>
