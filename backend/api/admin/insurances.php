<?php
header('Content-Type: application/json');
include '../../config/dbconnect.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"), true);;

// Method override for legacy clients 
if ($emthod === 'POST' && isset($_POST['_METHOD'])) {
    $method = strtoupper($_POST['_METHOD']);
}
// Route by method
switch ($method) {
    case 'GET':
        isset($_GET['insurance_id']) ? getInsurance($pdo, $_GET['insurance_id']) : getAllInsurance($pdo);
        break;
    case 'POST':
        createInsurance($pdo,$input);
        break;
    case 'PUT':
        updateInsurance($pdo, $input);
        break;
    case 'DELETE':
        deleteInsurance($pdo, $input);
        break;
    default:
        echo json_encode(['message' => 'Invalid request method']);
        break;
}
// Send JSON response 
function sendResponse($code, $data) {
    http_response_code($code);
    echo json_code($data);
}
// Validate input 
function validateInsuranceInput($data) {
    $required = ['provider_name', 'policy_number', 'patient_id', 'start_date', 'end_date'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            return "$field is required";
        }
    }
    return true;
}
//  Get all insurance
function getAllInsurance($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM insurance");
        sendResponse(200, $stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $e) {
        sendResponse(500, ['error' => $e->getMessage()]);
    }
}
//  Get single insurance
function getInsurance($pdo, $insurance_id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM insurance WHERE insurance_id = :insurance_id");
        $stmt->execute(['insurance_id' => $insurance_id]);
        $insurance = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($insurance) {
            sendResponse(200, $insurance);
        } else {
            sendResponse(404, ['message' => 'Payment not found']);
        }
    } catch (PDOException $e) {
        sendResponse(500, ['error'] => $e->getMessage()]);
}

//  Create insurance
function createInsurance($pdo) {
    $validation = ValidateInsuranceInput($data);
    if($validation !== true) {
        return sendResponse(400, '['message' => $validation]);
    }
    $required = ['provider_name', 'policy_number', 'patient_id', 'start_date', 'end_date'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            echo json_encode(['message' => "$field is required"]);
            return;
        }
    }

    if ($data['start_date'] > $data['end_date']) {
        echo json_encode(['message' => 'Start date cannot be after end date']);
        return;
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO insurance (
                provider_name, policy_number, coverage_type, coverage_amount,
                patient_id, start_date, end_date
            ) VALUES (
                :provider_name, :policy_number, :coverage_type, :coverage_amount,
                :patient_id, :start_date, :end_date
            )
        ");
        $stmt->execute([
            'provider_name' => $data['provider_name'],
            'policy_number' => $data['policy_number'],
            'coverage_type' => $data['coverage_type'] ?? 'Partial',
            'coverage_amount' => $data['coverage_amount'] ?? 0.00,
            'patient_id' => $data['patient_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date']
        ]);

        echo json_encode(['message' => 'Insurance created successfully']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Creation failed: ' . $e->getMessage()]);
    }
}

//  Update insurance
function updateInsurance($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (empty($data['insurance_id'])) {
        echo json_encode(['message' => 'insurance_id is required']);
        return;
    }

    $stmt = $pdo->prepare("SELECT * FROM insurance WHERE insurance_id = :id");
    $stmt->execute(['id' => $data['insurance_id']]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existing) {
        echo json_encode(['message' => 'Insurance not found']);
        return;
    }

    if (!empty($data['start_date']) && !empty($data['end_date']) && $data['start_date'] > $data['end_date']) {
        echo json_encode(['message' => 'Start date cannot be after end date']);
        return;
    }

    try {
        $stmt = $pdo->prepare("
            UPDATE insurance SET
                provider_name = :provider_name,
                policy_number = :policy_number,
                coverage_type = :coverage_type,
                coverage_amount = :coverage_amount,
                patient_id = :patient_id,
                start_date = :start_date,
                end_date = :end_date,
                updated_at = CURRENT_TIMESTAMP
            WHERE insurance_id = :insurance_id
        ");
        $stmt->execute([
            'provider_name' => $data['provider_name'] ?? $existing['provider_name'],
            'policy_number' => $data['policy_number'] ?? $existing['policy_number'],
            'coverage_type' => $data['coverage_type'] ?? $existing['coverage_type'],
            'coverage_amount' => $data['coverage_amount'] ?? $existing['coverage_amount'],
            'patient_id' => $data['patient_id'] ?? $existing['patient_id'],
            'start_date' => $data['start_date'] ?? $existing['start_date'],
            'end_date' => $data['end_date'] ?? $existing['end_date'],
            'insurance_id' => $data['insurance_id']
        ]);

        echo json_encode(['message' => 'Insurance updated successfully']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Update failed: ' . $e->getMessage()]);
    }
}

//  Delete insurance
function deleteInsurance($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (empty($data['insurance_id'])) {
        echo json_encode(['message' => 'insurance_id is required']);
        return;
    }

    $stmt = $pdo->prepare("DELETE FROM insurance WHERE insurance_id = :id");
    $stmt->execute(['id' => $data['insurance_id']]);
    echo json_encode(['message' => 'Insurance record deleted']);
}
?>
