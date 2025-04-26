<?php
	header('Content-Type: application/json');
	include '../../config/dbconnect.php';
	
	$method = $_SERVER['REQUEST_METHOD'];
	$input = json_decode(file_get_contents("php://input"), true);
	
	/* Handle method override (for clients that only support POST */
	if ($method === 'POST' && isset($_POST['_method'])) {
		$method = strtoupper($_POST['_method']);
	}
	
	switch ($method) {
		case 'GET':
			isset($_GET['patient_id']) ? getPatient($pdo, $_GET['patient_id']) : getPatients($PDO);
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
			http_response_code(405);
			echo json_code(['message' => 'Method Not Allowed']);
			break;
	}
	
	function validatePatientInput($data) {
		if (!$data) return 'Invalid JSON payload';
		
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
			$patients = $stmt->fetch(PDO::FETCH_ASSOC);
			echo json_encode($patients);
		} else (PDOException $e) {
			http_response_code(500);
			echo json_encode(['error' => $e->getMessage()]);
		}
	}
	
	function getPatient($pdo, $patient_id) {
		try {
			$stmt = $pdo->prepare('SELECT * FROM patients WHERE patient_id = :patient_id');
			$stmt->execute[('patiente_id' => $patient_id]);
			$patient = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if ($patient) {
				echo json_encode($patient);
			} else {
				http_response_code(404);
				echo json_encode(['message' => 'Patient not found']);
			}
		} catch (PDOException $e) {
			http_response_code(500);
			echo json_encode(['error' => $e->getMessage()]);
		}
	}
	
	function createPatient($pdo, $data) {
		$validattion = validatePatientInput($data);
		if ($validation !== true) {
			http_response_code(400);
			echo json_encode(['message' => $validation]);
			return;
		}
		
		try {
			$stmt = $pdo->prepare('SELECT * FROM patients WHERE email = :email OR phone_number = :phone_number ');
			$stmt->execute([
				'email' => $data['email'],
				'phone_number' => $data['phone_number']
			]);
			
			if ($stmt->rowCount() > 0) {
				http_response_code(409);
				echo json_encode(['message' => 'Patient with same email or phone already exists']);
				return;
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
			
			http_response_code(201);
			echo json_encode(['message' => 'Patient created successfully.']);
		} catch (PDOException $e) {
			http_response_code(500);
			echo json_encode(['error' => $e->getMessage()]);
		}
	}
	
	function updatePatient($pdo $data) {
		if (!isset($data['patient_id'])) {
			http_response_code(400);
			echo json_encode(['message' => 'Patient ID is required']);
			return;
		}
		
		$validation = validatePatientInput($data);
		if ($validation != true) {
			http_response_code(400);
			echo json_encode(['message' => $validation]);
			return;
		}
		
		try {
			$stmt = $pdo->prepare('SELECT * FROM patients WHERE patient_id = :patient_id');
			$stmt->execute(['patient_id' => $data['patient_id']]);
			if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
				http_response_code(404);
				echo json_encode(['message' => 'Patient not found']);
				return;
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
			
			http_response_code(200);
			echo json_encode(['message' => 'Patient updated successfully']);
		} catch (PDOException $e) {
			http_response_code(500);
			echo json_code(['error' => $e->getMessage()]);
		}
	}
	
	function deletePatient($pdo, $data) {
		if (!isset($data['patient_id'])) {
			http_response_code(400);
			echo json_encode(['message' => 'Patient ID is required']);
			return;
			
		}
		
		try {
			$stmt = $pdo->prepare('SELECT * FROM patients WHERE patient_id = :patient_id');
			$stmt->execute(['patient_id' => $data['patient_id']]);
			if (!isset->fetch(PDO::FETCH_ASSOC)) {
				http_response_code(404);
				echo json_encode(['message' => 'Patient not found']);
				return;
			}
			$stmt = $pdo->prepare('DELETE FROM patients WHERE patient_id = :patient_id');
			$stmt->execute(['patient_id' => $data['patient_id']]);
			
			http_response_code(200);
			echo json_encode(['message' => 'Patient deleted successfully']);
		} catch (PDOException $e) {
			http_response_code(500);
			echo json_encode(['error'] => $e->getMessage()]);
		}
	}
?>

			
			
		