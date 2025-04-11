<?php
header('Content-Type: application/json');
include 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['test_id'])) {
            getLabTest($pdo, $_GET['test_id']);
        } else {
            getLabTests($pdo);
        }
        break;
    case 'POST':
        createLabTest($pdo);
        break;
    case 'PUT':
        updateLabTest($pdo);
        break;
    case 'DELETE':
        deleteLabTest($pdo);
        break;
    default:
        echo json_encode(['message' => 'Method not allowed']);
        break;
}

// Get all lab tests
function getLabTests($pdo) {
    $stmt = $pdo->query('SELECT * FROM lab_tests');
    $tests = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tests);
}

// Get a single lab test
function getLabTest($pdo, $test_id) {
    $stmt = $pdo->prepare('SELECT * FROM lab_tests WHERE test_id = :test_id');
    $stmt->execute(['test_id' => $test_id]);
    $test = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $test ? json_encode($test) : json_encode(['message' => 'Lab test not found']);
}

// Create a new lab test
function createLabTest($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['patient_id'], $data['appointment_id'], $data['test_name'], $data['test_date'])) {
        echo json_encode(['message' => 'Missing required fields']);
        return;
    }

    // Check if patient and appointment exist
    $stmt = $pdo->prepare('SELECT 1 FROM patients WHERE patient_id = :pid');
    $stmt->execute(['pid' => $data['patient_id']]);
    if (!$stmt->fetch()) {
        echo json_encode(['message' => 'Patient not found']);
        return;
    }

    $stmt = $pdo->prepare('SELECT 1 FROM appointments WHERE appointment_id = :aid');
    $stmt->execute(['aid' => $data['appointment_id']]);
    if (!$stmt->fetch()) {
        echo json_encode(['message' => 'Appointment not found']);
        return;
    }

    // Check unique constraint
    $stmt = $pdo->prepare('
        SELECT 1 FROM lab_tests 
        WHERE patient_id = :patient_id AND appointment_id = :appointment_id AND test_name = :test_name
    ');
    $stmt->execute([
        'patient_id' => $data['patient_id'],
        'appointment_id' => $data['appointment_id'],
        'test_name' => $data['test_name']
    ]);
    if ($stmt->fetch()) {
        echo json_encode(['message' => 'This test already exists for the given patient and appointment']);
        return;
    }

    // Insert
    $stmt = $pdo->prepare('
        INSERT INTO lab_tests (patient_id, appointment_id, test_name, test_date, results, test_status)
        VALUES (:patient_id, :appointment_id, :test_name, :test_date, :results, :test_status)
    ');
    $stmt->execute([
        'patient_id' => $data['patient_id'],
        'appointment_id' => $data['appointment_id'],
        'test_name' => $data['test_name'],
        'test_date' => $data['test_date'],
        'results' => $data['results'] ?? null,
        'test_status' => $data['test_status'] ?? 'Pending'
    ]);

    echo json_encode(['message' => 'Lab test created successfully']);
}

// Update an existing lab test
function updateLabTest($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['test_id'])) {
        echo json_encode(['message' => 'Test ID is required']);
        return;
    }

    $stmt = $pdo->prepare('SELECT * FROM lab_tests WHERE test_id = :test_id');
    $stmt->execute(['test_id' => $data['test_id']]);
    $test = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$test) {
        echo json_encode(['message' => 'Lab test not found']);
        return;
    }

    // Update record
    $stmt = $pdo->prepare('
        UPDATE lab_tests
        SET patient_id = :patient_id, appointment_id = :appointment_id, test_name = :test_name,
            test_date = :test_date, results = :results, test_status = :test_status,
            updated_at = CURRENT_TIMESTAMP
        WHERE test_id = :test_id
    ');
    $stmt->execute([
        'patient_id' => $data['patient_id'] ?? $test['patient_id'],
        'appointment_id' => $data['appointment_id'] ?? $test['appointment_id'],
        'test_name' => $data['test_name'] ?? $test['test_name'],
        'test_date' => $data['test_date'] ?? $test['test_date'],
        'results' => $data['results'] ?? $test['results'],
        'test_status' => $data['test_status'] ?? $test['test_status'],
        'test_id' => $data['test_id']
    ]);

    echo json_encode(['message' => 'Lab test updated successfully']);
}

// Delete a lab test
function deleteLabTest($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['test_id'])) {
        echo json_encode(['message' => 'Test ID is required']);
        return;
    }

    $stmt = $pdo->prepare('SELECT 1 FROM lab_tests WHERE test_id = :test_id');
    $stmt->execute(['test_id' => $data['test_id']]);
    if (!$stmt->fetch()) {
        echo json_encode(['message' => 'Lab test not found']);
        return;
    }

    $stmt = $pdo->prepare('DELETE FROM lab_tests WHERE test_id = :test_id');
    $stmt->execute(['test_id' => $data['test_id']]);

    echo json_encode(['message' => 'Lab test deleted successfully']);
}
?>