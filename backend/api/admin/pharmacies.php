<?php
header('Content-Type: application/json');
include '../../config/dbconnect.php';

	$method = $_SERVER['REQUEST_METHOD'];
	$input = json_decode(file_get_contents("php://input"), true);

	/* Method override for legacy clients */
	if ($method === 'POST' && isset($_POST['_METHOD'])) {
		$method = strtoupper($_POST['_METHOD']);
	}

	/* Route based on method */
	switch ($method) {
		case 'GET':
			isset($_GET['pharmacy_id']) ? getPharmacy($pdo, $_GET['pharmacy_id']) : getAllPharmacies($pdo);
			break;
		case 'POST':
			createPharmacy($pdo,$input);
			break;
		case 'PUT':
			updatePharmacy($pdo, $input);
			break;
		case 'DELETE':
			deletePharmacy($pdo, $input);
			break;
		default:
			sendResponse(405, ['message' => 'Invalid request method']);
			break;
	}

	/* Standardized JSON response */
	function sendResponse($code, $data) {
		http_response_code($code);
		echo json_encode($data);
	}

	/* Validate input for insurance creation/updating */
	function validatePharmacieInput($data) {
		$required = ['name', 'address', 'phone_number', 'email'];
		foreach ($required as $field) {
			if (empty($data[$filed])) {
				return "$field is required";
			}
		}
		if (!preg_match('/^[0-9]+$/', $data['phone_number'])) {
			return "Phone number must be numeric";
		}
		if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			return 'Invalid email format';
		}
		return true;
	}

	/*  GET All Pharmacies */
	function getAllPharmacies($pdo) {
		try {
			$stmt = $pdo->query('SELECT * FROM pharmacies');
			sendResponse(200, $stmt->fetchAll(PDO::FETCH_ASSOC));
		} catch (PDOException $e) {
			sendResponse(500, ['error' => $e->getMessage()]);
		}
	}

	/*  GET a single pharmacy record */
	function getPharmacy($pdo, $pharmacy_id) {
		try {
			$stmt = $pdo->prepare('SELECT * FROM pharmacies WHERE pharmacy_id = :pharmacy_id');
			$stmt->execute(['pharmacy_id' => $pharmacy_id]);
			$pharmacy = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($pharmacy) {
				sendResponse(200, $pharmacy);
			} else {
				sendResponse(404, ['message' => 'pharmacy not found']);
			}
		} catch (PDOException $e) {
			sendResponse(500, ['error' => $e->getMessage()]);
		}
	}

	/* CREATE Pharmacy */
	function createPharmacy($pdo, $data) {
		$validation = validatePharmacyInput($data);

		/* validate  */
		if ($validation !== true) {
			return sendResponse(400, ['message' => $validation]);
		}
		
		try {
				$stmt = $pdo->prepare("
					INSERT INTO pharmacies (name, address, phone_number, email)
					VALUES (:name, :address, :phone_number, :email)
				");
				$stmt->execute([
					'name' => $data['name'],
					'address' => $data['address'],
					'phone_number' => $data['phone_number'],
					'email' => $data['email']
				]);
					sendResponse(201, ['message' => 'Pharmacy created successfully']);
			} catch (PDOException $e) {
			sendReponse(500, ['error' => 'Insert failed: ' . $e->getMessage()]);
		}
	}

	/* UPDATE Pharmacy */
	function updatePharmacy($pdo) {
		
		if (empty($data['pharmacy_id'])) {
			return sendResponse(400, ['message' => 'pharmacy_id is required']);
		}
		try {
			$stmt = $pdo->prepare('SELECT * FROM pharmacies WHERE pharmacy_id = :pharmacy_id');
			$stmt->execute(['pharmacy_id' => $data['pharmacy_id']]);
			$existing = $stmt->fetch(PDO::FETCH_ASSOC);

			if (!$existing) {
				return sendResponse(404, ['message' => 'Pharmacy not found']);
			}

			if (!empty($data['phone_number']) && !preg_match('/^[0-9]+$/', $data['phone_number'])) {
				return sendResponse(400, ['message' => 'Phone number must be numeric only']);
			}
			
			if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
				return sendResponse(400, ['message'] => 'Invalid email format']);
			}
		
			$stmt = $pdo->prepare('
				UPDATE pharmacies SET 
					name = :name,
					address = :address,
					phone_number = :phone_number,
					email = :email,
					updated_at = CURRENT_TIMESTAMP
				WHERE pharmacy_id = :pharmacy_id
			');
			$stmt->execute([
				'name' => $data['name'] ?? $existing['name'],
				'address' => $data['address'] ?? $existing['address'],
				'phone_number' => $data['phone_number'] ?? $existing['phone_number'],
				'email' => $data['email'] ?? $existing['email'],
				'pharmacy_id' => $data['pharmacy_id']
			]);
				sendResponse(200, ['message' => 'Pharmacy updated successfully']);
			} catch (PDOException $e) {
				sendReponse(500, ['error' => 'Update failed: ' . $e->getMessage()]);
		}
	}

	/* DELETE Pharmacy */
	function deletePharmacy($pdo, $data) {
	   
		if (empty($data['pharmacy_id'])) {
			return sendResponse(400, ['message' => 'pharmacy_id is required']);
		}
		try {
			$stmt = $pdo->prepare('SELECT 1 FROM pharmacies WHERE pharmacy_id = :id');
			$stmt->execute(['id' => $data['pharmacy_id']]);
			if (!$stmt->fetch()) {
				echo json_encode(['message' => 'Pharmacy not found']);
				return;
			}

			$stmt = $pdo->prepare('DELETE FROM pharmacies WHERE pharmacy_id = :pharmacy_id');
			$stmt->execute(['pharmacy_id' => $data['pharmacy_id']]);
			sendReponse(200, ['message' => 'Pharmacy deleted successfully']);
		} catch (PDOException $e) {
			sendResponse(500, ['error' => 'Delete failed: ' . $e->getMessage()]);
		}
	}
?>
