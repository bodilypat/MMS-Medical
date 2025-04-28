<?php
	header('Content-Type: application/json');
	include '../../config/dbconnect.php';

	$method = $_SERVER['REQUEST_METHOD'];
	$input = json_decode(file_get_contents("php://input"),true);

	/* Method override for legacy clients */
	if ($method === 'POST' && isset($_POST['_METHOD'])) {
		$method = strtoupper($_POST['_METHOD']);
	}

	switch ($method) {
		case 'GET':
			isset($_GET['billing_id']) ? getPayment($pdo, $_GET['billing_id']) : getAllPayments($pdo);
			break;
		case 'POST':
			createPayment($pdo, $input);
			break;
		case 'PUT':
			updatePayment($pdo, $input);
			break;
		case 'DELETE':
			deletePayment($pdo, $input);
			break;
		default:
			sendResponse(405, ['message' => 'Invalid request method']);
			break;
	}
	/* Reusable response function */
	function sendResponse($code, $data) {
		http_response_code($code0;
		echo json_encode($data);
	}
	/* Validte input  */
	function validatePaymetnInput($data) {
		$required = ['patient_id', 'appointment_id', 'total_amount', 'amount_paid'];
		foreach ($required as $field) {
			if (empty($data[$field])) {
				return "$field is required"; 
			}
		}
		return true;
	}
	
	/* GET All Payments*/
	function getAllPayments($pdo) {
		try {
			$stmt = $pdo->query("SELECT * FROM payments");
			sendResponse(200, $stmt->fetchAll(PDO::FETCH_ASSOC));
		} catch (PDOException $e) {
			sendResponse(500, ['error' => $e->getMessage()]);
		}
	}
	
	/* GET: Single payment */
	function getPayment($pdo, $billing_id) {
		try {
			$stmt = $pdo->prepare("SELECT * FROM payments WHERE billing_id = :billing_id");
			$stmt->execute(['billing_id' => $billing_id]);
			$payment = $stmt->fetch(PDO::FETCH_ASSOC);
		
			if ($payment) {
				sendResponse(200, $payment);
			} else {
				sendResponse(404, ['message' => 'Payment not found']);
			}
		} catch (PDOException $e) {
			sendResponse(500, ['error'] => $e->getMessage()]);
		}
	}

	/* POST: Create payment */
	function createPayment($pdo) {
		$validation = validatePaymentInput($data);
		if ($validation !== true) {
			return sendResponse(400, ['message' => $validation]);
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
				sendResponse(201, ['message' => 'Payment created successfully']);
			} catch (PDOException $e) {
				sendReponse(500, ['error' => 'Create failed: ' . $e->getMessage()]);
		}
	}

	/* PUT : Update payment */
	function updatePayment($pdo, $data) {
	   
		if (empty($data['billing_id'])) {
			return sendResponse(400, ['message' => 'billing_id is required']);
		}

		$stmt = $pdo->prepare("SELECT * FROM payments WHERE billing_id = :billing_id");
		$stmt->execute(['billing_id' => $data['billing_id']]);
		$existing = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$existing) {
			return sendResponse(404, ['message' => 'Payment not found']);
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
			echo json_encode(200,['message' => 'Payment updated successfully']);
		} catch (PDOException $e) {
			echo json_encode(500, ['error' => 'Update failed: ' . $e->getMessage()]);
		}
	}

	/* DELETE: delete payment */
	function deletePayment($pdo, $data) {
		
		if (empty($data['billing_id'])) {
			return sendResponse(['message' => 'billing_id is required']);
		}
		try {
			$stmt = $pdo->prepare("SELECT 1 FROM payments WHERE billing_id = :id");
			$stmt->execute(['billing_id' => $data['billing_id']]);
			
			if (!$stmt->fetch()) {
				return sendReponse(404, ['message' => 'Payment not found']);
				return;
			}

			$stmt = $pdo->prepare("DELETE FROM payments WHERE billing_id = :billing_id");
			$stmt->execute(['billing_id' => $data['billing_id']]);
			sendResponse(200, ['message' => 'Payment deleted successfully']);
		} catch (PDOException $e) {
			sendResponse(500, ['error' => 'Delete failed: ' . $e->getMessage()]);
		}
	}
	
?>
