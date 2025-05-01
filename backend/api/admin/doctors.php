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
	
	/* Doctor Logic */
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
			http_response_code(405);
			echo json_encode('message' => 'Method Not Allowed']);
			break;
		}
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
			
			$stmt = $pdo->prepare('
				INSERT INTO doctors (first_name, last_name, specialization, email, phone_number, department, birthdate, address, status, notes)
				VALUES (:first_name, :last_name, :specialization, :email, :phone_number, :department, birthdate, :address, :status, :notes) 
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
	
	/*  Reusable response */
	function sendResponse($code, $data) {
		http_response_code($code);
		echo json_encode($data);
	}
	
?>

	
				
	