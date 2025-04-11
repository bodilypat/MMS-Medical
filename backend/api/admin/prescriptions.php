<?php
header('Content-Type: application/json');
include 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['prescription_id'])) {
            getPrescription($pdo, $_GET['prescription_id']);
        } else {
            getAllPrescriptions($pdo);
        }
        break;
    case 'POST':
        createPrescription($pdo);
        break;
    case 'PUT':
        updatePrescription($pdo);
        break;
    case 'DELETE':
        deletePrescription($pdo);
        break;
    default:
        echo json_encode(['message' => 'Unsupported request method']);
        break;
}

//  Get All Prescriptions
function getAllPrescriptions($pdo) {
    $stmt = $pdo->query('SELECT * FROM prescriptions');
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

//  Get Single Prescription
function getPrescription($pdo, $prescription_id) {
    $stmt = $pdo->prepare('SELECT * FROM prescriptions WHERE prescription_id = :id');
    $stmt->execute(['id' => $prescription_id]);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $record ? json_encode($record) : json_encode(['message' => 'Prescription not found']);
}

//  Create New Prescription
function createPrescription($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);

    // Validate required fields
    $required = ['record_id', 'medication_name', 'dosage', 'frequency', 'start_date'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            echo json_encode(['message' => "$field is required"]);
            return;
        }
    }

    if (strlen($data['dosage']) > 50) {
        echo json_encode(['message' => 'Dosage must not exceed 50 characters']);
        return;
    }

    // Check record_id exists
    $stmt = $pdo->prepare('SELECT 1 FROM medical_records WHERE record_id = :record_id');
    $stmt->execute(['record_id' => $data['record_id']]);
    if (!$stmt->fetch()) {
        echo json_encode(['message' => 'Invalid medical record ID']);
        return;
    }

    // Insert prescription
    $stmt = $pdo->prepare('
        INSERT INTO prescriptions 
        (record_id, medication_name, dosage, frequency, start_date, end_date, instructions, status, created_by, updated_by)
        VALUES 
        (:record_id, :medication_name, :dosage, :frequency, :start_date, :end_date, :instructions, :status, :created_by, :updated_by)
    ');

    $stmt->execute([
        'record_id' => $data['record_id'],
        'medication_name' => $data['medication_name'],
        'dosage' => $data['dosage'],
        'frequency' => $data['frequency'],
        'start_date' => $data['start_date'],
        'end_date' => $data['end_date'] ?? null,
        'instructions' => $data['instructions'] ?? null,
        'status' => $data['status'] ?? 'Active',
        'created_by' => $data['created_by'] ?? null,
        'updated_by' => $data['updated_by'] ?? null,
    ]);

    echo json_encode(['message' => 'Prescription created']);
}

//  Update Prescription
function updatePrescription($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (empty($data['prescription_id'])) {
        echo json_encode(['message' => 'prescription_id is required']);
        return;
    }

    $stmt = $pdo->prepare('SELECT * FROM prescriptions WHERE prescription_id = :id');
    $stmt->execute(['id' => $data['prescription_id']]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existing) {
        echo json_encode(['message' => 'Prescription not found']);
        return;
    }

    if (!empty($data['dosage']) && strlen($data['dosage']) > 50) {
        echo json_encode(['message' => 'Dosage must not exceed 50 characters']);
        return;
    }

    $stmt = $pdo->prepare('
        UPDATE prescriptions SET 
            record_id = :record_id,
            medication_name = :medication_name,
            dosage = :dosage,
            frequency = :frequency,
            start_date = :start_date,
            end_date = :end_date,
            instructions = :instructions,
            status = :status,
            updated_by = :updated_by,
            updated_at = CURRENT_TIMESTAMP
        WHERE prescription_id = :prescription_id
    ');

    $stmt->execute([
        'record_id' => $data['record_id'] ?? $existing['record_id'],
        'medication_name' => $data['medication_name'] ?? $existing['medication_name'],
        'dosage' => $data['dosage'] ?? $existing['dosage'],
        'frequency' => $data['frequency'] ?? $existing['frequency'],
        'start_date' => $data['start_date'] ?? $existing['start_date'],
        'end_date' => $data['end_date'] ?? $existing['end_date'],
        'instructions' => $data['instructions'] ?? $existing['instructions'],
        'status' => $data['status'] ?? $existing['status'],
        'updated_by' => $data['updated_by'] ?? $existing['updated_by'],
        'prescription_id' => $data['prescription_id']
    ]);

    echo json_encode(['message' => 'Prescription updated']);
}

//  Delete Prescription
function deletePrescription($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (empty($data['prescription_id'])) {
        echo json_encode(['message' => 'prescription_id is required']);
        return;
    }

    $stmt = $pdo->prepare('SELECT 1 FROM prescriptions WHERE prescription_id = :id');
    $stmt->execute(['id' => $data['prescription_id']]);
    if (!$stmt->fetch()) {
        echo json_encode(['message' => 'Prescription not found']);
        return;
    }

    $stmt = $pdo->prepare('DELETE FROM prescriptions WHERE prescription_id = :id');
    $stmt->execute(['id' => $data['prescription_id']]);

    echo json_encode(['message' => 'Prescription deleted']);
}
?>