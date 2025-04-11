<?php
header('Content-Type: application/json');
include 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['record_id'])) {
            getRecord($pdo, $_GET['record_id']);
        } else {
            getAllRecords($pdo);
        }
        break;
    case 'POST':
        createRecord($pdo);
        break;
    case 'PUT':
        updateRecord($pdo);
        break;
    case 'DELETE':
        deleteRecord($pdo);
        break;
    default:
        echo json_encode(['message' => 'Invalid request method']);
        break;
}

// GET All Records
function getAllRecords($pdo) {
    $stmt = $pdo->query('SELECT * FROM medical_records');
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

//  GET Single Record
function getRecord($pdo, $record_id) {
    $stmt = $pdo->prepare('SELECT * FROM medical_records WHERE record_id = :id');
    $stmt->execute(['id' => $record_id]);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $record ? json_encode($record) : json_encode(['message' => 'Record not found']);
}

//  POST Create Record
function createRecord($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['patient_id'], $data['appointment_id'])) {
        echo json_encode(['message' => 'patient_id and appointment_id are required']);
        return;
    }

    // Optional length check on diagnosis
    if (!empty($data['diagnosis']) && strlen($data['diagnosis']) > 500) {
        echo json_encode(['message' => 'Diagnosis exceeds 500 characters']);
        return;
    }

    $stmt = $pdo->prepare('
        INSERT INTO medical_records 
        (patient_id, appointment_id, diagnosis, treatment_plan, note, status, created_by, updated_by, attachments)
        VALUES 
        (:patient_id, :appointment_id, :diagnosis, :treatment_plan, :note, :status, :created_by, :updated_by, :attachments)
    ');

    $stmt->execute([
        'patient_id' => $data['patient_id'],
        'appointment_id' => $data['appointment_id'],
        'diagnosis' => $data['diagnosis'] ?? null,
        'treatment_plan' => $data['treatment_plan'] ?? null,
        'note' => $data['note'] ?? null,
        'status' => $data['status'] ?? 'Active',
        'created_by' => $data['created_by'] ?? null,
        'updated_by' => $data['updated_by'] ?? null,
        'attachments' => $data['attachments'] ?? null
    ]);

    echo json_encode(['message' => 'Medical record created']);
}

//  PUT Update Record
function updateRecord($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['record_id'])) {
        echo json_encode(['message' => 'record_id is required']);
        return;
    }

    $stmt = $pdo->prepare('SELECT * FROM medical_records WHERE record_id = :id');
    $stmt->execute(['id' => $data['record_id']]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existing) {
        echo json_encode(['message' => 'Record not found']);
        return;
    }

    $stmt = $pdo->prepare('
        UPDATE medical_records
        SET patient_id = :patient_id,
            appointment_id = :appointment_id,
            diagnosis = :diagnosis,
            treatment_plan = :treatment_plan,
            note = :note,
            status = :status,
            updated_by = :updated_by,
            attachments = :attachments,
            updated_at = CURRENT_TIMESTAMP
        WHERE record_id = :record_id
    ');

    $stmt->execute([
        'patient_id' => $data['patient_id'] ?? $existing['patient_id'],
        'appointment_id' => $data['appointment_id'] ?? $existing['appointment_id'],
        'diagnosis' => $data['diagnosis'] ?? $existing['diagnosis'],
        'treatment_plan' => $data['treatment_plan'] ?? $existing['treatment_plan'],
        'note' => $data['note'] ?? $existing['note'],
        'status' => $data['status'] ?? $existing['status'],
        'updated_by' => $data['updated_by'] ?? $existing['updated_by'],
        'attachments' => $data['attachments'] ?? $existing['attachments'],
        'record_id' => $data['record_id']
    ]);

    echo json_encode(['message' => 'Medical record updated']);
}

//  DELETE Record
function deleteRecord($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['record_id'])) {
        echo json_encode(['message' => 'record_id is required']);
        return;
    }

    $stmt = $pdo->prepare('SELECT 1 FROM medical_records WHERE record_id = :id');
    $stmt->execute(['id' => $data['record_id']]);
    if (!$stmt->fetch()) {
        echo json_encode(['message' => 'Record not found']);
        return;
    }

    $stmt = $pdo->prepare('DELETE FROM medical_records WHERE record_id = :id');
    $stmt->execute(['id' => $data['record_id']]);

    echo json_encode(['message' => 'Medical record deleted']);
}
?>