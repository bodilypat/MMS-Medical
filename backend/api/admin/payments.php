<?php
header('Content-Type: application/json');
include '../../config/dbconnect.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input),true);

/* Method override for legacy clients */
if ($method === 'POST' && isset($_POST['_METHOD'])) {
    $method = strtoupper($_POST['_METHOD']);
}

switch ($method) {
    case 'GET':
        isset($_GET['billing_id']) ? getPayment($pdo, $_GET['billing_id']) : getAllPayments($pdo);
        break;
    case 'POST':
        createPayment($pdo);
        break;
    case 'PUT':
        updatePayment($pdo);
        break;
    case 'DELETE':
        deletePayment($pdo);
        break;
    default:
        echo json_encode(['message' => 'Invalid request method']);
        break;
}
// Reusable response function
function sendResponse($code, $data) {
    http_response_code($code0;
    ech json_encode($data);
}
// Validte input 
function validatePaymetnInput($dta) {
    if (!$data) return 'Invalid JSON payload';
    


//  GET All
function getAllPayments($pdo) {
    $stmt = $pdo->query("SELECT * FROM payments");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

//  GET One
function getPayment($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM payments WHERE billing_id = :id");
    $stmt->execute(['id' => $id]);
    $payment = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $payment ? json_encode($payment) : json_encode(['message' => 'Payment not found']);
}

//  CREATE
function createPayment($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);

    $required = ['patient_id', 'appointment_id', 'total_amount', 'amount_paid'];
    foreach ($required as $field) {
        if (!isset($data[$field])) {
            echo json_encode(['message' => "$field is required"]);
            return;
        }
    }

    $balance_due = $data['total_amount'] - $data['amount_paid'];
    $payment_status = 'Pending';

    if ($balance_due <= 0) {
        $payment_status = 'Paid';
        $balance_due = 0;
    } elseif ($data['amount_paid'] > 0) {
        $payment_status = 'Partially Paid';
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO payments (
                patient_id, appointment_id, total_amount, amount_paid, balance_due,
                payment_status, insurance_claimed_amount, insurance_status
            ) VALUES (
                :patient_id, :appointment_id, :total_amount, :amount_paid, :balance_due,
                :payment_status, :insurance_claimed_amount, :insurance_status
            )
        ");
        $stmt->execute([
            'patient_id' => $data['patient_id'],
            'appointment_id' => $data['appointment_id'],
            'total_amount' => $data['total_amount'],
            'amount_paid' => $data['amount_paid'],
            'balance_due' => $balance_due,
            'payment_status' => $payment_status,
            'insurance_claimed_amount' => $data['insurance_claimed_amount'] ?? null,
            'insurance_status' => $data['insurance_status'] ?? null
        ]);
        echo json_encode(['message' => 'Payment created successfully']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Create failed: ' . $e->getMessage()]);
    }
}

//  UPDATE
function updatePayment($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (empty($data['billing_id'])) {
        echo json_encode(['message' => 'billing_id is required']);
        return;
    }

    $stmt = $pdo->prepare("SELECT * FROM payments WHERE billing_id = :id");
    $stmt->execute(['id' => $data['billing_id']]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existing) {
        echo json_encode(['message' => 'Payment not found']);
        return;
    }

    $amount_paid = $data['amount_paid'] ?? $existing['amount_paid'];
    $total_amount = $data['total_amount'] ?? $existing['total_amount'];
    $balance_due = $total_amount - $amount_paid;

    $payment_status = 'Pending';
    if ($balance_due <= 0) {
        $payment_status = 'Paid';
        $balance_due = 0;
    } elseif ($amount_paid > 0) {
        $payment_status = 'Partially Paid';
    }

    try {
        $stmt = $pdo->prepare("
            UPDATE payments SET
                total_amount = :total_amount,
                amount_paid = :amount_paid,
                balance_due = :balance_due,
                payment_status = :payment_status,
                insurance_claimed_amount = :insurance_claimed_amount,
                insurance_status = :insurance_status,
                updated_at = CURRENT_TIMESTAMP
            WHERE billing_id = :billing_id
        ");
        $stmt->execute([
            'total_amount' => $total_amount,
            'amount_paid' => $amount_paid,
            'balance_due' => $balance_due,
            'payment_status' => $payment_status,
            'insurance_claimed_amount' => $data['insurance_claimed_amount'] ?? $existing['insurance_claimed_amount'],
            'insurance_status' => $data['insurance_status'] ?? $existing['insurance_status'],
            'billing_id' => $data['billing_id']
        ]);
        echo json_encode(['message' => 'Payment updated successfully']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Update failed: ' . $e->getMessage()]);
    }
}

//  DELETE
function deletePayment($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (empty($data['billing_id'])) {
        echo json_encode(['message' => 'billing_id is required']);
        return;
    }

    $stmt = $pdo->prepare("SELECT 1 FROM payments WHERE billing_id = :id");
    $stmt->execute(['id' => $data['billing_id']]);
    if (!$stmt->fetch()) {
        echo json_encode(['message' => 'Payment not found']);
        return;
    }

    $stmt = $pdo->prepare("DELETE FROM payments WHERE billing_id = :id");
    $stmt->execute(['id' => $data['billing_id']]);
    echo json_encode(['message' => 'Payment deleted successfully']);
}
?>
