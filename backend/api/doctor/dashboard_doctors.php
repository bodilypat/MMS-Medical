<?php
	header('Content-Type: application/json');
	include '../../config/dbconnect.php';
	
	/* Get request method and input */
	$method = $_SERVER['REQUEST_METHOD'];
	$input =  json_decode(file_get_contents("php://input"), true);
	
	/* Allow method overrid via _method param  */
	if ($method === 'POST' && isset($_POST['_method'])) {
		$method = strtoupper($_POST['_method']);
	}
	
	/* Handle  doctor routes */
	if (isset($_GET['type']) && $_GET['type'] === 'doctor') {
		$handleDoctorRequest($mdthod, $pdo, $input);
	}
	
	/* Handle medical record routes */
		elseif (isset($_GET['type']) && $_GET['type'] === 'medical_record') {
			handleMedicalRecordRequest($method, $pdo, $input);
		} else {
			sendResponse(400, ['message' => 'Invalid API type']);
		}
		
	/* Doctor Logic */
	function handleDoctorRequest($method, $pdo, $input) {
			
		switch ($method) {
			case 'GET': 
				isset($_GET['doctor_id']) ? getDoctor($pdo, $_GET['doctor_id']) : getDoctors($pdo);
				break;
			case 'POST':
				createDoctor($pdo, $input);
				break;
			case 'PUT':
				updateDoctor($pdo, $input);
				break;
			case 'DELETE':
				deleteDoctor($pdo, $input);
				break;
			default: 
				sendResponse(405, 'message' => 'Method Not Allowed']);
			}
	}
	
	/* CRUD : DOCTOR */
	function getDoctors($pdo) {
		try {
			$stmt = $pdo->query('SELECT * FROM doctors');
			echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			sendResponse(500, ['error' => $e->getMessage()]);
		}
	}
	
	function getDoctor($pdo, $doctor_id) {
		try {
			$stmt = $pdo->prepare('SELECT * FROM doctors WHERE doctor_id = :doctor_id');
			$stmt->execute(['doctor_id' => $doctor_id]);
			$doctor = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if ($doctor) {
				echo json_encode($doctor);
			} else {
				sendResponse(404,['message' => 'Doctor not found']);
			}
		} catch (PDOException $e) 
			response(500,['error' => $e->getMessage()]);
		}
	}
	
	function createDoctor($pdo, $data) {
		$validation = validateDoctorInput($data);
		if ($validation !== true) {
			return sendResponse(400, ['message' => $validation]);
		}
		
		try {
			$stmt = $pdo->prepare('SELECT 1 FROM doctors WHERE email = :email OR phone_number = :phone_number');
			$stmt->execute([
				'email' => $data['email'],
				'phone_number' => $data['phone_number']
			]);
			
			if ($stmt->fetch()) {
				return sendResponse(409, ['message' => 'Doctor with the same email or phone number already exists']);
			}
			
			$stmt = $pdo->prepare("
				INSERT INTO doctors (first_name, last_name, specialization, email, phone_number, department, birthdate, address, status, notes)
				VALUES (:first_name, :last_name, :specialization, :email, :phone_number, :department, birthdate, :address, :status, :notes) 
			");
			$stmt->execute([
				'first_name' => $data['first_name'],
				'last_name' => $data['last_name'],
				'specialization' => $data['specialization'],
				'email' => $data['email'],
				'phone_number' => $data['phone_number'],
				'department' => $data['department'],
				'birthdate' => $data['birthdate'],
				'address' => $data['address'],
				'status' => $data['status'],
				'notes' => $data['notes']
			]);
			sendResponse(500,['message' => 'Doctor created successfully']);
		} catch (PDOException $e) {
			sendResponse(500, ['error' => $e->getMessage()]);
		}
	}
	
	function updateDoctor($pdo, $data) {
		if (empty($data['doctor_id'])) {
			return sendResponse(400,['message' => 'Doctor ID is required']);
		}
		
		$validation = validateDoctorInput($data);
		if ($validation !== true) {
			return sendResponse(400, ['message' => $validation]);
		}
		
		try {
			$stmt = $pdo->prepare('SELECT 1 FROM doctors WHERE doctor_id = :dictor_id');
			$stmt->execute(['doctor_id' => $data['doctor_id']]);
			if (!$stmt->fetch()) {
				return sendResponse(404, ['message' => 'Doctor not found']);
			}
			
			$stmt = $pdo->prepare('
				UPDATE doctors 
				SET first_name = :first_name, 
				last_name = :last_name, 
				specialization = :specialization, 
				email = :email, 
				phone_number = :phone_number,
				department = :department,
				birthdate = :birthdate,
				address = :address,
				status = :status,
				notes = :notes,
				updated_at = CURRENT_TIMESTAMP
				WHERE doctor_id = :doctor_id
			');
			
			$stmt->execute([
				'first_name' => $data['first_name'],
				'last_name' => $data['last_name'],
				'specialization' => $data['specialization'],
				'email' => $data['email'],
				'phone_number' => $data['phone_number'],
				'department' => $data['department'],
				'birthdate' => $data['birthdate'],
				'address' => $data['address'],
				'status' => $data['status'],
				'notes' => $data['notes'],
				'doctor_id' => $data['doctor_id']
			]);
			sendResponse(400, ['message' => 'Doctor update successfully']);
		} catch (PDOException $e) {
			sendResponse(500, ['error' => $e->getMessage()]);
		}	
	}
	
	function deleteDoctor($pdo, $data) {
		if (empty($data['doctor_id'])) {
			return sendResponse(400, ['message' => 'Doctor ID is required']);
		}
		
		try {
			$stmt = $pdo->prepare('SELECT 1 FROM doctors WHERE doctor_id = :doctor_id');
			$stmt->execute(['doctor_id' => $data['doctor_id']]);
			
			if (!$stmt->fetch()) {
				return sendResponse(404, ['message' => 'Doctor not found']);
			}
			$stmt = $pdo->prepare('DELETE FROM doctors WHERE doctor_id = :doctor_id');
			$stmt->execute(['doctor_id' => $data['doctor_id']]);
			
			sendResponse(200, ['message' => 'Doctor deleted successfully']);
		} catch (PDOException $e) {
			http_response_code(500);
			sendResponse(500, ['error' => $e->getMessage()]);
		}
	}
	
	/* Validation Doctor */
	function validateDoctorInput($data) {
		if (!$data) return 'Invalid JSON payload';
		
		if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			return 'Invalid or missing email format';
		}
		
		if (empty($data['phone_number']) || !preg_match('/^[0-9]{10,15}$/', $data['phone_number'])) {
			return 'Invalid or missing phone number format';
		}
		
		// Add more field-specific validations if needed 
		return true;
	}
	
	/* Medical Record Logic */
	function handleMedicalRecordRequest($method, $pdo, $input) {
		
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
				sendResponse(405, ['message' => ' Method Not Allowed']);
		}
	}
	
	/* Validation logic */
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
	
	
	/* CRUD : Medical record */
	function getMedicalRecords($pdo, $record_id) {
		try {
			$stmt = $pdo->query('SELECT * FROM medical_records');
			$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
			sendResponse(200, $records);
		} catch (PDOException $e) {
			sendResponse(500,['error' => $e->getMessage()]);
		}
	}
	
	/* GET single record */
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
	
	/* Create record */
	function createMedicalRecord($pdo, $data) {
		$validation = validateMedicalRecordInput($data);
		
		if (!$validation !== true) {
			return sendResponse(400, ['message' => $validation]); 
		}
		
		try {
			/* Check if the patient exists */
			$stmt = $pdo->prepare('SELECT * FROM patients WHERE patient_id = :patient_id');
			$stmt->execute(['patient_id' => $data['patient_id']]);
			
			if (!stmt->fetch()) {
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
				'patient_id' => $data['patient_id'] ?? $record['patient_id'],
				'appointment_id' => $data['appointment_id'] ?? $record['appointment_id'],
				'diagnosis' => $data['diagnosis'] ?? $record['diagnosis'],
				'treatment_plan' => $data['treatment_plan'] ?? $record['treatment_plan'],
				'note' => $data['note'] ?? $record['note'],
				'status' => $data['status'] ?? $record['status'],
				'updated_by' => $data['updated_by'] ?? $record['updated_by'],
				'attactments' => $data['attachments'] ?? $record['attachments'],
				'record_id' => $data['record_id']
			]);
		
			sendResponse(200, ['message' => 'Medical Record updated successfully']);
		} catch (PDOException $e) {
			sendReponse(500, ['error' => $e->getMessage()]);
		}
	}
	
	/* DELETE record */
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
	
	/*  Reusable response */
	function sendResponse($code, $data) {
		http_response_code($code);
		echo json_encode($data);
	}
	
?>

	
				
	