<?php
	header('Content-Type: application/json');
	include '../../config/dbconnect.php';
	
	$method = $_SERVER['REQUEST_METHOD'];
	$input = json_decode(file_get_contents("php://input"), true);
	
	/* Handle method override for clients that only support POST */
	if ($method === 'POST' && isset($_POST['_method'])) {
		$method = strtoupper($_POST['_method']);
	}

	switch ($method) {
		case 'GET':
			isset($_GET['record_id']) ? getMedicalRecord($pdo, $_GET['record_id']) : getMedicalRecords($pdo)
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
			http_response_code(405); // Method Not Allowed
			echo json_encode(['message' => ' Method Not Allowed']);
			break;
	}
	
	function validateMedicalRecordInput($data) {
		if (!$data) {
			return 'Invalid JSON payload';
		}
		
		/* Validate required field */
		if (empty($data['patient_id']) || empty($data['appointment_id']) || empty($data['diagnosis'])) {
			return 'Missing required fields: patient_id, appointment_id, diagnosis';
		}
		
		/* Validate the diagnosis */
		if (strlen($data['diagnosis']) > 500) {
		    echo json_encode(['message' => 'Diagnosis exceeds 500 characters']);
			return;
		}
		return true;
	}
	/* GET single medical record */
	function getMedicalRecords($pdo, $record_id) {
		try {
			$stmt = $pdo->query('SELECT * FROM medical_records');
			$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($records);
		} catch (PDOException $e) {
			http_response_code(500);
			echo json_encode('error' => $e->getMessage()]);
		}
	}
	
	function getMedicalRecord($pdo, $record_id) {
		try {
			$stmt = $pdo->prepare('SELECT * FROM medical_records WHERE record_id = :record_id');
			$stmt->execute(['record_id' => $record_id]);
			$record= $stmt->fetch(PDO::FETCH_ASSOC);
			
			if ($record) {
				echo json_encode($record);
			} else {
				http_response_code(404); // Not Found 
				echo json_encode(['message' => 'Medical Record ot found']);
			}
		} catch (PDOException $e) {
			http_response_code(500);
			echo json_encode(['error' => $e->getMessage()]);
		}
	}
	
	function createMedicalRecord($pdo, $data) {
		$validation = validateMedicalRecordInput($data);
		
		if (!$validation !== true) {
			http_response_code(400); // Bad Request
			echo json_encode(['message' => $validation]);
			return;
		}
		
		try {
			/* Check if the patient exists */
			$stmt = $pdo->prepare('SELECT * FROM patients WHERE patient_id = :patient_id');
			$stmt->execute(['patient_id' => $data['patient_id']]);
			$patient = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (!$patient) {
				http_response_code(404); // Not Found 
				echo json_encode(['message' => 'Patient not found']);
				return;
			}
			
			/* check if the appointment exists */
			$stmt = $pdo->prepare('SELECT * FROM appointments WHERE appointment_id = :appointment_id');
			$stmt->execute['appointment_id' => $data['appointment_id']]);
			$appointment = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (!$appointment) {
				http_response_code(404); // Not Found 
				echo json_encode(['message' => 'Appointment not found']);
				return;
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
				http_response_code(201); // Create
				echo json_encode(['message'=> 'Medical record created successfully']);
		} catch (PDOException $e) {
			http_response_code(500); // Interal Server Error
			echo json_encode(['error' => $e->getMessage()]);
		}
	}
	/* PUT Update Record */
	function updateMedicalRecord($pdo, $data) {
		if (empty($data['record_id'])) {
			http_response_code(400);
			echo json_encode(['message' => 'Medical Records ID is required']);
			return;
		}
		
		$validation = validateMedicalRecordInput($data);
		
		if ($validation !== true) {
			http_response_code(400);
			echo json_encode(['message' => $validation]);
			return;
		}
		try {
			$stmt = $pdo->prepare('SELECT * FROM medical_records WHERE record_id = :record_id');
			$stmt->execute(['record_id' => $data['record_id']]);
			$existingRecord = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (!$existingRecord) {
				http_response_code(404);
				echo json_encode(['message' => 'Medical Record not found']);
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
				'patient_id' => $data['patient_id'] ?? $existingRecord['patient_id'],
				'appointment_id' => $data['appointment_id'] ?? $existingRecord['appointment_id'],
				'diagnosis' => $data['diagnosis'] ?? $exingRecord['diagnosis'],
				'treatment_plan' => $data['treatment_plan'] ?? $existingRecord['treatment_plan'],
				'note' => $data['note'] ?? $existingRecord['note'],
				'status' => $data['status'] ?? $exisitingRecord['status'],
				'updated_by' => $data['updated_by'] ?? $existingRecord['updated_by'],
				'attactments' => $data['attachments'] ?? $existingRecord['attachments'],
				'record_id' => $data['record_id']
			]);
		
			http_response_code(200);
			echo json_encode(['message' => 'Medical Record updated successfully']);
		} catch (PDOException $e) {
			http_response_code(500);
			echo json_encode(['error' => $e->getMessage()]);
		}
	}
	
	/* DELETE record */
	function deleteMedicalRecord($pdo, $data) {
		if (empty($data['record_id'])) {
			http_response_code(400);
			echo json_encode(['message' => 'Medical Records ID is requried']);
			return;
		}
		
		try {
			$stmt = $pdo->prepare('SELECT * FROM medical_records WHERE record_id = : record_id');
			$stmt->execute(['record_id' => $data['record_id']]);
			$record = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (!$record) {
				http_response_code(404);
				echo json_encode(['message' => 'Medical Record not found']);
				return;
			}
			$stmt = $pdo->prepare('DELETE FROM medical_records WHERE record_id = :record_id');
			$stmt->execute(['record_id'] => $data['record_id']]);
			
			http_response_code(200);
			echo json_encode(['message' => 'Medical Record deleted successuflly']);
		} catch (PDOException $e) {
			http_response_code(500);
			echo json_encode(['error' => $e->getMessage()]);
		}
	}
?>
		
				