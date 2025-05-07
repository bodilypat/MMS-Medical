<?php
	header('Content-Type: application/json');
	include '../config/dbconnect.php';
	
	$method = $_SERVER['REQUEST_METHOD'];
	$input = json_decode(file_get_contents("php://input"), true);
	
	/* Handle method override for clients that only support POST */
	if ($method === 'POST' && isset($_POST['_method'])) {
		$method = strtoupper($_POST['_method']);
	}

	/* Handle Medical record logic */
	switch ($method) {
		case 'GET':
			if (isset($_GET['record_id'])) {
				getMedicalRecord($pdo, $_GET['record_id']);
			else {
				getMedicalRecords($pdo);
			}
			break;
		case 'POST':
			createMedicalRecord($pdo, $input);
			break;
		case 'PUT':
			updateMedicalRecord($pdo, $input);
			break;
		case 'DELETE':
			deleteMedicalRecord($pdo, $input);
			break;
		default:
			sendResponse(405, ['message' => ' Method Not Allowed']);
	}
	
	/* ==== response helper ==== */
	function sendResponse($code, $data) {
		http_response_code($code);
		echo json_encode($data);
	}
	
	/* ==== Validation logic  ==== */
	function validateMedicalRecordInput($data) {
		if (!$data) return 'Invalid JSON payload';
		
		/* Validate required field */
		if (empty($data['patient_id']) || empty($data['appointment_id']) || empty($data['diagnosis'])) {
			return 'Missing required fields: patient_id, appointment_id, diagnosis';
		}
		
		/* Validate the diagnosis */
		if (strlen($data['diagnosis']) > 500) {
		    return 'Diagnosis exceeds 500 characters';
		}
		return true;
	}
	
	/* ==== GET all medical record ==== */
	function getMedicalRecords($pdo, $record_id) {
		try {
			$stmt = $pdo->query('SELECT * FROM medical_records');
			$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
			sendResponse(200, $stmt->fetchAll(PDO::FETCH_ASSOC));
		} catch (PDOException $e) {
			sendResponse(500,['error' => $e->getMessage()]);
		}
	}
	
	/* ==== GET single record ==== */
	function getMedicalRecord($pdo, $record_id) {
		try {
			$stmt = $pdo->prepare('SELECT * FROM medical_records WHERE record_id = :record_id');
			$stmt->execute(['record_id' => $record_id]);
			$record= $stmt->fetch(PDO::FETCH_ASSOC);
			
			if ($record) {
				sendResponse(200, $record);
			} else {
				sendRespone(404,['message' => 'Medical record not found']); // Not Found 
			}
		} catch (PDOException $e) {
			sendResponse(500,['error'] => $e->getMessage()]);
		}
	}
	
	/* ==== Create record ==== */
	function createMedicalRecord($pdo, $data) {
		$validation = validateMedicalRecordInput($data);
		
		if (!$validation !== true) {
			return sendResponse(400, ['message' => $validation]); 
		}
		
		try {
			/* Check if the patient exists */
			$stmt = $pdo->prepare('SELECT 1 FROM patients WHERE patient_id = :patient_id');
			$stmt->execute(['patient_id' => $data['patient_id']]);
			
			if (!$stmt->fetch()) {
				sendResponse(404, ['message' => 'Patient not found']); // Not Found 
			}
			
			/* check if the appointment exists */
			$stmt = $pdo->prepare('SELECT * FROM appointments WHERE appointment_id = :appointment_id');
			$stmt->execute['appointment_id' => $data['appointment_id']]);
			
			if (!$stmt->fetch()) {
				return sendResponse(404, ['message'] => 'Appointment not found'); 
			}
			
			/* Insert the medical records */
			$stmt = $pdo->prepare('
				INSERT INTO medical_records 
					(patient_id, appointment_id, diagnosis, treatment_plan, note, status, created_by, update_by, attactments)
				VALUES
					(:patient_id, :appointment_id, :diagnosis, :treatment_plan, :note, :status, :created_by,:updated_by, :attactments)
				');
				$stmt->execute([
					'patient_id' => $data['patient_id'],
					'appointment_id' => $data['appointment_id'],
					'diagnosis' => $data['diagnosis'],
					'treatment_plan' => $data['treatment_plan'] ?? null,
					'note' => $data['note'] ?? null,
					'status' => data['status'] ?? 'Active',
					'created_by' => $data['created_by'] ?? null,
					'updated_by' => $data['updated_by'] ?? null,
					'attachments' => $data['attachments'] ?? null
				]);	
				sendResponse(201, ['message' => 'Midical Record created successfully']); 
		} catch (PDOException $e) {
			sendReponse(500, ['error' => $e->Message()]); 
		}
	}
	
	/* PUT Update Record */
	function updateMedicalRecord($pdo, $data) {
		if (empty($data['record_id'])) {
			return sendResponse(400, ['message' => 'Medical Record ID is reuqired']);
		}
		
		$validation = validateMedicalRecordInput($data);
		
		if ($validation !== true) {
			return sendResponse(400, ['message' => $validation]);
		}
		try {
			/* Check existing record */
			$stmt = $pdo->prepare('SELECT * FROM medical_records WHERE record_id = :record_id');
			$stmt->execute(['record_id' => $data['record_id']]);
			$record = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (!$record) {
				return sendReponse(404, ['message' => 'Medical Record not found']);
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
				'patient_id' => $data['patient_id'], 
				'appointment_id' => $data['appointment_id'],,
				'diagnosis' => $data['diagnosis'] ?? $record['diagnosis'],
				'treatment_plan' => $data['treatment_plan'],,
				'note' => $data['note'] ?? null,
				'status' => $data['status'] ?? 'Active',
				'updated_by' => $data['updated_by'] ?? null,
				'attactments' => $data['attachments'] ?? null,
				'record_id' => $data['record_id']
			]);
		
			sendResponse(200, ['message' => 'Medical Record updated successfully']);
		} catch (PDOException $e) {
			sendReponse(500, ['error' => $e->getMessage()]);
		}
	}
	
	/* ==== DELETE record ==== */
	function deleteMedicalRecord($pdo, $data) {
		if (empty($data['record_id'])) {
			return sendReponse(400, ['message' => 'Medical record ID is required']);
		}
		
		try {
			$stmt = $pdo->prepare('SELECT 1 FROM medical_records WHERE record_id = : record_id');
			$stmt->execute(['record_id' => $data['record_id']]);
			
			if (!$stmt->fetch()) {
				return sendResponse(404, ['message' => 'Medical Record not found']);
			}
			$stmt = $pdo->prepare('DELETE FROM medical_records WHERE record_id = :record_id');
			$stmt->execute(['record_id'] => $data['record_id']]);
			
			sendReponse(200, ['message' => 'Medical Record deleted successfully']);
		} catch (PDOException $e) {
			return sendResponse(500, ['error' => $e->getMessage()]);
		}
	}
?>
		
				
