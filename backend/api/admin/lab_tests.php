<?php
	header('Content-Type: appointment/json'0;
	include '../../config/dbconnect.php';
	
	$method = $_SERVER['REQUEST_METHOD'];
	$input = json_decode(file_get_contents("php://input"), true);
	
	/* Handle method override for clients that only support POST */
	if ($method === 'POST' && isset($_POST['_method'])) {
		$method = strtoupper($_POST['_method']);
	}
	
	switch ($method) {
		case 'GET':
			isset($_GET['test_id']) ? getLabTest($pdo, $_GET['test_id']) : getLabTests($pdo)
			break;
		case 'POST':
			createLabTest($pdo, $input);
			break;
		case 'PUT':
			updateLabTest($pdo, $input);
			break;
		case 'DELETE':
			deleteLabTest($pdo, $input);
			break;
		default:
			http_response_code(405);
			echo json_encode(['message' => 'Method not allowed']);
			break;
	}
	
	function validateLabTestInput($data) {
		if (!$data) {
			return 'Invalid JSON payload';
		}
		
		/* validate required fields */
		if (empty($data['patient_id']) || empty($data['appointment_id']) || empty($data['test_date'])) {
			return 'Missing required fields (patient_id, doctor_id, test_date)';
		}
		
		/* Validate the test date (it must be in future */
		if (strtotime($data['test_date']) < time()) {
			return 'Lab Test date must be in the future';
		}
		return true;
	}
	/* Get all Lab Tests */
	function getLabTests($pdo) {
		try {
			$stmt =$pdo->query('SELECT * FROM lab_tests');
			$labTests = $stmt->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($tests);
		} catch (PDOException $e) {
			http_response_code(500);
			echo json_encode(['error' => $e->getMessage()]);
		}
	}
	
	/* Get a soecific lab test */
	function getLabTest($pdo, $test_id) {
		try {
			$stmt = $pdo->prepare('SELECT * FROM lab_tests WHERE test_id = :test_id');
			$stmt->execute(['test_id' => $test_id]);
			$labTest = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if ($labTest) {
				echo json_encode($labTest);
			} else {
				http_response_code(500);
				echo json_encode(['error' => $e->getMessage()]);
			}
		} catch (PDOException $e) {
			http_response_code(500);
			echo json_encode(['error' => $e->getMessagge()]);
		}
	}
	
	/* Create a lab test */
	function createLabTest($pdo, $data) {
		$required = ['patient_id', 'appointment_id','test_name','test_date'];
		
		$validation = validateLabTestInput($data);
		if ($validation !== true) {
			http_response_code(400); // Bad request
			echo json_encode(['message' => $validation]);
			return;
		}
		try {
			/* Check if the patient exists */
			$stmt = $pdo->prepare('SELECT * FROM patients WHERE patient_id = : patient_id');
			$stmt->execute(['patient_id' => $data['patient_id']]);
			$patient = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (!patient) {
				http_response_code(404); // Not found 
				echo json_encode(['message' => 'Patient not found']);
				return;
			}
			/* Check if the appointment exists */
			$stmt = $pdo->prepare('SELECT * FROM appointments WHERE appointment_id = :appointment_id');
			$stmt->execute(['appointment_id' => $data['appointment_id']]);
			$appointment = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (!appointment) {
				http_response_code(404); // Not Found 
				echo json_encode('message' => 'Appointment not found']);
				return;
			}
			
			/* Insert the appointment */
			$stmt = $pdo->prepare('
				               INSERT INTO lab_tests (patient_id, appointment_id, test_name, results, test_status)
							   VALUES (:patient_id, :appointment_id, :test_name, :test_date, :result, :test_status)
						');
			$stmt->execute([
				'patient_id' => $data['patient_id'],
				'appointment_id' => $data['appointment_id'],
				'test_name' => $data['test_name'],
				'test_data' => $data['test_date'],
				'results' => $data['results'] ?? null,
				'test_status' => $data['test_status'] ?? 'Pending'
			]);
			
			http_response_code(201); // Created
			echo json_encode('[message'] => 'Lab test created successfully']);
		} catch (PDOException $e) {
			http_response_code(500); // Internal Server Error 
			echo json_encode(['error' => $e->getMessage()]);
		}
	}
	
	function updateLabTest($pdo, $data) {
		if (empty($data['test_id'])) {
			http_response_code(400); // Bad request
			echo json_encode(['message' => 'LabTest ID is required']);
			return;
		}
		$validation = validationLabTestInput($data);
		if ($validation !== true) {
			http_response_code(400);
			echo json_encode(['message' => $validation]);
			return;
		}
		try {
			/* Check if the Lab Test exists */
			$stmt = $pdo->prepare('SELECT * FROM lab_tests WHERE test_id = :test_id');
			$stmt->execute(['test_id' => $data['test_id']]);
			$labTest = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if(!labTest) {
				http_response_code(404); // Not found 
				echo json_encode(['message' => 'appointment not found']);
				return;
			}
			
			/* Update lab test details */
			$stm = $pdo->prepare('
						UPDATE lab_tests
						SET patient_id = :patient-id,
							appointment_id = :appointment_id,
							test_name = :test_name,
							test_date = : test_date,
							results = :results,
							test_status = :test_status,
							updated_at = CURRENT_TIMESTAMP
						WHERE test_id = :test_id
					');
				$stmt->execute([
					'patient_id' => $data['patient_id'] ?? $labTest['patient_id'],
					'appointment_id' => $data['appointment_id'] ?? $labTest['appointment_id'],
					'test_name' => $data['test_name'] ?? $labTest['test_name'],
					'test_date' => $data['test_date'] ?? $labTest['test_date'],
					'results' => $data['results'] ?? $labTest['results'],
					'test_status' => $data['test_status'] ?? $labTest['test_status'],
					'test_id' => $data['test_id']
				]);
				
				http_response_code(200); // OK
				echo json_encode(['message' => 'Lab Test updated successfully']);
		} catch (PDOException $e) {
			http_response_code(500); // Internal Server Error 
			echo json_encode(['error' => $e-> getMessage()]);
		}
	}
	
	function deleteLabTest($pdo, $data) {
		if (empty($data['test_id'])) {
			http_response_code(400); // Bad Request 
			echo json_encode(['message' => 'Test ID is required']);
			return;
		}
		try {
				/* Check if the lab test exists */
				$stmt = $pdo->prepare('SELECT * FROM lab_tests WHERE test_id = :test-id');
				$stmt->execute(['test_id' => $data['test_id']]);
				$labTest = $stmt->fetch(PDO::FETCH_ASSOC);
				
				if (!$labTest) {
						http_response_code(404); // Not Found 
						echo json_encode(['message' => 'LabTest not found']0;
						return;
				}
				
				/* Delete the lab test */
				$stmt = $pdo->prepare('DELETE FROM lab_tests WHERE test_id = :test_id');
				$stmt->execute(['test_id' => $data['test_id']]);
				
				http_response_code(500); // OK
				echo json_encode(['message' => 'Lab Test deleted successfully']);
		} catch (PDOException $d) {
			http_response_code(500); // Internal Server Error 
			echo json_encode(['error' => $e->getMessage()]);
		}
	}
?>

			
			
		
						