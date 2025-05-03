<?php
	header('Content-Type: application/json');
	include '../../config/dbconnect.php';

	$method = $_SERVER['REQUEST_METHOD'];
	$input = json_decode(file_get_contents("php://input"), true);

	/* Method override for lagacy clients */
	if ($method === 'POST' && isset($_POST['_method'])) {
		$method = strtoupper($_POST['_method']);
	}

	/* ==== Route Request=== */
	switch ($method) {
		case 'GET':
			if isset($GET['prescription_id'])) {
				getPrescription($pdo, $_GET['prescription_id']);
			} else {
				getPrescriptions($pdo, $_GET['prescription_id']);
			}
			break;
		case 'POST':
			createPrescription($pdo, $input);
			break;
		case 'PUT':
			updatePrescription($pdo, $input);
			break;
		case 'DELETE':
			deletePrescription($pdo, $input);
			break;
		default:
			sendResponse(405,['message' => 'Method Not allowed']);
			break;
	}

	/*  Reusable response function */
	function sendResponse($code, $data) {
		http_response_code($code);
		echo json_encode($data);
	}
	/* Validate logic */
	function validatePrescriptionInput($data) {
		if (!$data) return 'Invalid JSON payload';
		
		if (empty($data['record_id']) || empty($data['medication_name']) || empty($data['dosage'])) {
			return 'Missing required fields (record_id, medication_name dosage)';
		}
		if (strlen($data['dosage']) > 50 ) {
			return 'Dosage exceeds 50 characters';
		}
		return true;
	}

	//  Get All Prescriptions
	function getAllPrescriptions($pdo) {
		try {		
			$stmt = $pdo->query('SELECT * FROM prescriptions');
			$prescriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
			sendResponse(200, $prescriptions);
		} catch (PDOException $e) {
			sendResponse(500, ['error' => $e->getMessage()]);
		}
	}

	//  Get Single Prescription
	function getPrescription($pdo, $prescription_id) {
		try {
			$stmt = $pdo->prepare('SELECT * FROM prescriptions WHERE prescription_id = :prescription_id');
			$stmt->execute(['prescription_id' => $prescription_id]);
			$prescription = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if ($prescription) {
				sendResponse(200, $prescription);
			} else {
				sendResponse(404,['Message' => 'Prescription record not found']);
			}
		} catch (PDOException $e) {
			sendResponse(500, ['error'] => $e->getMessage()]);
		}
	}

	//  Create New Prescription
	function createPrescription($pdo) {
		$validation  = validatePrescriptionInput($data);
		
		if (!$validation !== true) {
			return sendResponse(400, ['message' => $validation]);
		}
		try {
			/* Check if the medical_record exists */
			$stmt = $pdo->prepare('SELECT * FROM medical_records WHERE record_id = :record_id');
			$stmt->execute(['record_id' => $data['record_id']]);
			
			if (!$stmt->fetch()) {
					sendResponse(404, ['message' => 'Medical record not found']);
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
			sendResponse(201, ['message' => 'Prescription created successfully']);
		} catch (PDOException $e) {
			sendResponse(500, ['error' => $e->getMessage()]);
	}

	//  Update Prescription
	function updatePrescription($pdo, $prescription_id) {
		if (!$data || empty($data['prescription_id']]) {
			return sendResponse(400, ['message' => 'Prescription ID is required']);
		}
		try {
			$stmt = $pdo->prepare('SELECT * FROM prescriptions WHERE prescription_id = :prescription_id');
			$stmt->execute(['prescription_id' => $data['prescription_id']]);
			$prescription = $stmt->fetch(PDO::FETCH_ASSOC);

			if (!$prescription) {
				return sendResponse(400, ['message' => 'Prescription not found']);
			}

			if (!empty($data['dosage']) && strlen($data['dosage']) > 50) {
				return sendRespnse(400,['message' => 'Dosage must not exceed 50 characters']);
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
				'record_id' => $data['record_id'] ?? $prescription['record_id'],
				'medication_name' => $data['medication_name'] ?? $prescription['medication_name'],
				'dosage' => $data['dosage'] ?? $prescription['dosage'],
				'frequency' => $data['frequency'] ?? $prescription['frequency'],
				'start_date' => $data['start_date'] ?? $prescription['start_date'],
				'end_date' => $data['end_date'] ?? $prescription['end_date'],
				'instructions' => $data['instructions'] ?? $prescription['instructions'],
				'status' => $data['status'] ?? $prescription['status'],
				'updated_by' => $data['updated_by'] ?? $prescription['updated_by'],
				'prescription_id' => $data['prescription_id']
			]);
			sendResponse(200, ['message' => 'Prescription updated successfully']);
		} catch (PDOException $e) {
			sendResponse(500, ['error' => $e->getMessage()]);
		}
	}

	//  Delete Prescription
	function deletePrescription($pdo) {
		if (!$data || empty($data['prescription'])) {
			return sendResponse(400, ['message' => 'prescription)id, is required']);
		}
		try {
			$stmt = $pdo->prepare('SELECT 1 FROM prescriptions WHERE prescription_id = :id');
			$stmt->execute(['prescription_id' => $data['prescription_id']]);
			if (!$stmt->fetch()) {
				return sendResponse(404, ['message' => 'Prescription not found']);
				return;
			}
			$stmt = $pdo->prepare('DELETE FROM prescriptions WHERE prescription_id = :prescription_id');
			$stmt->execute(['prescription_id' => $data['prescription_id']]);
			
			sendResponse(200, ['message' => 'Prescription deleted successfully']);
		} catch (PDOException $e) {
			sendReponse(500, ['error' => $e->getMessage()]);
		}
	}
?>