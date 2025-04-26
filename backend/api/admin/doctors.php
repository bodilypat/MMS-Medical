<?php
	header('Content-Type: application/json');
	include '../../config/dbconnect.php';
	
	$method = $_SERVER['REQUEST_METHOD'];
	$input =  json_decode(file_get_contents("php://input"), true);
	
	// Optional method override for clients that can't use PUT/DELETE 
	if ($method === 'POST' && isset($_POST['_method'])) {
		$method = strtoupper($_POST['_method']);
	}
	
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
	function valdiateDoctorInput($data) {
		if (!$data) {
			return 'Invalid JSON payload';
		}
		if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			return 'Invalid or missing email format';
		}
		
		if (empty($data['phone_number']) || !preg_match('/^[0-9]{10,15}$/', $data['phone_number'])) {
			return 'Invalid or missing phone number format';
		}
		
		// Add more field-specific validations if needed 
		return true;
	}
	
	function getDoctors($pdo) {
		try {
			$stmt = $pdo->query('SELECT * FROM doctors');
			$doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($doctors);
		} catch (PDOException $e) {
			http_response_code(500);
			echo json_encode(['error' => $e->getMessage()]);
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
				http_response_code(404);
				echo json_encode('[message' => 'Doctor not found']);
			}
		} catch (PDOException $e) {
			http_response_code(500);
			echo json_encode('error' => $e->getMessage()]);
		}
	}
	
	function createDoctor($pdo, $data) {
		$validation = validateDoctorInput($data);
		if ($validation != true) {
			http_response_code(400);
			echo json_encode(['message' => $validation]);
			return;
		}
		try {
			$stmt = $pdo->prepare('SELECT * FROM doctors WHERE email = :email OR phone_number = :phone_number');
			$stmt->execute([
				'email' => $data['email'],
				'phone_number' => $data['phone_number']
			]);
			
			if ($stmt->rowCount() > 0 ) {
				http_response_code(409);
				echo json_encode(['message' => 'Doctor with the same email or phone number already exists']);
				return;
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
			
			http_response_code(201);
			echo json_encode(['message' => 'Doctor created successfully']);
		} catch (PDOException $e) {
			http_response_code(500);
			echo json_encode(['error' => $e->getMessage()]);
		}
	}
	
	function updateDoctor($pdo, $data) {
		if (!isset($data['doctor_id'])) {
			http_response_code(400);
			echo json_encode(['message' => 'Doctor ID is required']);
			return;
		}
		
		$validation = validateDoctorInput($data);
		if ($validation != true) {
			http_response_code(400);
			echo json_encode(['message' => $validation]);
			return;
		}
		try {
			$stmt = $pdo->prepare('SELECT *FROM doctors WHERE doctor_id = :dictor_id');
			$stmt->execute(['doctor_id' => $data['doctor_id']]);
			if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
				http_response_code(404);
				echo json_encode(['message' => 'Doctor not found']);
				return;
			}
			$stmt = $pdo->prepare('
				UPDATE doctors 
				SET first_name = :first_name, last_name = :last_name, specialization = :specialization, 
				    email = :email, phone_number = :phone_number, department = :department, birthdate = :birthdate,
					address = :address, status = :status, notes = :notes, updated_at = CURRENT_TIMESTAMP
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
			http_response_code(200);
			echo json_encode(['message' => 'Doctor update successfully']);
		} catch (PDOException $e) {
			http_response_code(500);
			echo json_encode('[error' => $e->getMessage()]);
		}	
	}
	
	function deleteDoctor($pdo, $data) {
		if (!isset($data['doctor_id'])) {
			http_response_code(400);
			echo json_encode(['message' => 'Doctor ID is required']);
			return;
		}
		try {
			$stmt = $pdo->prepare('SELECT * FROM doctors WHERE doctor_id = :doctor_id');
			$stmt->execute(['doctor_id' => $data['doctor_id']]);
			if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
				http_response_code(404);
				echo json_encode(['message' => 'Doctor not found']);
				return;
			}
			$stmt = $pdo->prepare('DELETE FROM doctors WHERE doctor_id = :doctor_id');
			$stmt->execute(['doctor_id' => $data['doctor_id']]);
			
			http_response_code(200);
			echo json_encode(['message' => 'Doctor deleted successfully']);
		} catch (PDOException $e) {
			http_response_code(500);
			echo json_encode(['error' => $e->getMessage()]);
		}
	}
?>

	
				
	