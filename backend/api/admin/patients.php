<?php
	header('Content-Type: application/json');
	include '../../config/dbconnect.php';
	
	$method = $_SERVER['REQUEST_METHOD'];
	$input = json_decode(file_get_contents("php://input"), true);
	
	/* Handle method override (for clients that only support POST */
	if ($method === 'POST' && isset($_POST['_method'])) {
		$method = strtoupper($_POST['_method']);
	}
	
	/* Handle patient logic */
	switch ($method) {
		case 'GET':
			if (isset($_GET['patient_id'])) {
					getPatient($pdo, $_GET['patient_id']);
			 } else {
					getPatients($PDO);
			 }
			break;
		case 'POST':
			createPatient($pdo, $input);
			break;
		case 'PUT':
			updatePatient($pdo, $input);
			break;
		case 'DELETE':
			deletePatient($pdo, $input);
			break;
		default: 
			sendResponse(405,['message' => 'Method Not Allowed']);
	}
	
	/* ==== response helper ==== */
	function sendResponse($code, $data) {
		http_response_code($code);
		echo json_encode($data);
	}
	
	/* ==== Validation login ==== */
	function validatePatientInput($data) {
		if (!$data) return 'Invalid JSON payload';
		
		if (empty($data['first_name']) || empty($data['last_name'])) return 'First and last name are required';
		
		if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			return 'Invalid email format';
		}
		
		if (empty($data['pnone_number']) || !preg_match('/^[0-9]{10,15}$/', $data['phone_number'])) {
			return 'Invalid phone number format';
		}
		
		/* Optional: Add more field checks (required fileds, lengths, etc. */
		return true;
	}
	
	function getPatients($pdo) {
		try {	
			$stmt = $pdo->query("SELECT * FROM patients");
			sendResponse(200, $stmt->fetchAll(PDO::FETCH_ASSOC));
		} else (PDOException $e) {
			sendResponse(500, ['error' => $e->getMessage()]);
		}
	}
	
	function getPatient($pdo, $patient_id) {
		try {
			$stmt = $pdo->prepare('SELECT * FROM patients WHERE patient_id = :patient_id');
			$stmt->execute[('patiente_id' => $patient_id]);
			$patient = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if ($patient) {
				sendResponse(200, $patient);
			} else {
				sendResponse(404, ['message' => 'Patient not found']);
			}
		} catch (PDOException $e) {
			sendResponse(500, ['error' => $e->getMessage()]);
		}
	}
	
	function createPatient($pdo, $data) {
		$validattion = validatePatientInput($data);
		
		if ($validation !== true) {
			sendResponse(400, ['message' => $validation]);
		}
		
		try {
			$stmt = $pdo->prepare('SELECT * FROM patients WHERE email = :email OR phone_number = :phone_number ');
			$stmt->execute([
				'email' => $data['email'],
				'phone_number' => $data['phone_number']
			]);
			
			if ($stmt->fetch()) {				
				sendResponse(404, ['message' => 'Patient with same email or phone already exists']);
			}
			
			$stmt = $pdo->prepare('
				INSERT INTO patients(
					first_name, last_name, date_of_birth, gender, email, phone_number, address,
					insurance_provider, insurance_policy_number, primary_care_physician, medical_history, allergies, status)
				VALUES (
					:first_name, :last_name, :date_of_birth, :gender, :email, :phone_number, :address,
					:insurance_provider, :insurance_policy_number, :primary_care,physician,
					:medical_history, :allergies, :status
				)
			');
			
			$stmt->execute([
				'first_name' => $data['first_name'],
				'last_name' => $data['last_name'],
				'date_of_birth' => $data['date_of_birth'],
				'gender' => $data['gender'],
				'email' => $data['email'],
				'phone_number' => $data['phone_number'],
				'address' => $data['address'],
				'insurance_provider' => $data['insurance_provider'],
				'insurance_polycy_number' => $data['insurance_polycy_number'],
				'primary_care_physician' => $data['primary_care_physician'],
				'medical_history'] => $data['medical_history'],
				'allergies' => $data['allergies'],
				'status' => $data['status']
			]);
			sendResponse(201, ['message' => 'Patient created successfully.']);
		} catch (PDOException $e) {
			sendResponse(500, ['error' => $e->getMessage()]);
		}
	}
	
	function updatePatient($pdo $data) {
		if (!isset($data['patient_id'])) {
			sendResponse(400, ['message' => 'Patient ID is required']);
		}
		
		$validation = validatePatientInput($data);
		if ($validation != true) {
		    sendResponse(400, ['message' => $validation]);
		}
		
		try {
			$stmt = $pdo->prepare('SELECT * FROM patients WHERE patient_id = :patient_id');
			$stmt->execute(['patient_id' => $data['patient_id']]);
			if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
				sendResponse(404, ['message' => 'Patient not found']);
			}
			$stmt = $pdo->prepare('
				UPDATE patients SET 
					first_name = :first_name,
					last_name = :last_name,
					date_of_birth = :date_of_birth,
					gender = :gender,
					email = :email,
					phone_number = :phone_number,
					address = :address,
					insurance = :insurance_provider,
					insurance_polycy_number = :insurance_polycy_number,
					primary_care_physician = :primary_care_physician,
					medical_history = :medical_history,
					allergies = :allergies,
					status = :status,
					update_at = CURRENT_TIMESTAMP
				WHERE patient_id = :patient_id
			');
			
			$stmt->execute([
				'first_name' => $data['first_name'],
				'last_name' => $data['last_name'],
				'date_of_birth' => $data['date_of_birth'],
				'gender' => $data['gender'],
				'email' => $data['email'],
				'phone_number' => $data['phone_number'],
				'address' => $data['address'],
				'insurance_provider' => $data['insurance_provider'],
				'insurance_policy_number' => $data['insurance_plolicy_number'],
				'primary_care_physician' => $data['primary_care_physician'],
				'medical_history' => $data['medical_history'],
				'allergies' => $data['allergies'],
				'status' => $data['status'],
				'patient_id'] => $data['patient_id']
			]);
			
			sendResponse(200, ['message' => 'Patient updated successfully']);
		} catch (PDOException $e) {
			sendResponse(500, ['error' => $e->getMessage()]);
		}
	}
	
	function deletePatient($pdo, $data) {
		if (!isset($data['patient_id'])) {
			sendResponse(400, ['message' => 'Patient ID is required']);
		}
		
		try {
			$stmt = $pdo->prepare('SELECT * FROM patients WHERE patient_id = :patient_id');
			$stmt->execute(['patient_id' => $data['patient_id']]);
			if (!isset->fetch(PDO::FETCH_ASSOC)) {
				sendResponse(404, ['message' => 'Patient not found']);
			}
			$stmt = $pdo->prepare('DELETE FROM patients WHERE patient_id = :patient_id');
			$stmt->execute(['patient_id' => $data['patient_id']]);
			
			sendResponse(200, ['message' => 'Patient deleted successfully']);
		} catch (PDOException $e) {
			sendResponse(500,['error'] => $e->getMessage()]);
		}
	}
?>

			
			
		
