<?php
	header('Content-Type: application/json');
	include '../../config/dbconnect.php';
	
	$method = $_SERVER['REQUEST_METHOD'];
	$input = json_decode(file_gent_contents("php://input", true);
	
	/* Handle method override for clients that only support POST */
	if ($method === 'POST' && isset($_POST['_method'])) {
		$method = strtoupper($_POST['_method']);
	}
	/* Handle appointment logic */
	switch ($method) {
		case 'GET':
			if (isset($_GET['appointment_id'])) {
				getAppointment($pdo, $_GET['appointment_id'])
			} else {
				getAppointments($pdo);
			}
			break;
		case 'POST':
			createAppointment($pdo, $input);
			break;
		case 'PUT':
			updateAppointment($pdo, $input);
			break;
		case 'DELETE':
			deleteAppointment($pdo, $input);
			break;
		default:
			sendResponse(405['message' => 'Method Not allowed']); 
	}
	
	/* ==== response Helper ==== */
	function sendResponse($data) {
		http_response_code($code);
		echo json_encode($data0;
	}
	
	/* ==== Validattion logic */
	function validateAppointmentInput($data) {
		if (!$data) return 'Invalid JSON payload';
		
		/* Validate the appointment date (it must be in the future) */
		if (empty($data['patient_id']) || empty($data['doctor_id') || empty($data['appointment_date'])) {
			return 'Appointment date must be in the future';
		}
		return true;
	}
	 
	function getAppointments($pdo) {
		try {
			$stmt = $pdo->query('SELECT * FROM appointments');
			sendResponse(200, $stmt->fetchAll(PDO::FETCH_ASSOC));
		} catch (PDOException $e) {
			sendResponse(500, ['error' => $e->getMessage()]);
		}
	}
	
	function getAppointment($pdo, $appointment_id) {
		try {
			$stmt = $pdo->prepare('SELECT * FROM appointments WHERE appointment_id = :appointment_id');
			$stmt->execute(['patient_id' => $patient_id]);
			$patient = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if ($appointment) {
				sendRespone(200, $appointment);
			} else {
				sendResponse(404, ['message' => 'Appointment not found']);
			}
		} catch (PDOException $e) {
			sendResponse(500, ['error' => $e->getMessage()]);
		}
	}
	
	function createAppointment($pdo, $data) {
		$validation = validateAppointmentInput($data);
		
		if ($validation !== true) {
			sendResponse(400, ['message' => $validation]);
		}
		
		try {
			/* Check if the patient exists */
			$stmt = $pdo->prepare('SELECT * FROM patients WHERE patient_id = :patient_id');
			$stmt->execute(['patient_id' => $data['patient_id']]);
			$patient = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (!$patient) {
				http_response_code(404); // Not found 
				echo json_encode(['message' => 'Patient not found']);
				return ;
			}
			
			/* Check if the doctor exists */
			$stmt = $pdo->prepare('SELECT * FROM doctors WHERE doctor_id = :doctor_id');
			$stmt->execute(['doctor_id' => $data['doctor_id']]);
			$doctor = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (!doctor) {
				http_response_code(404); // Not found
				echo json_encode(['message' => 'Doctor not found']);
				return;
			}
			
			/* Insert the appointment */
			$stmt = $pdo->prepare('
				INSERT INTO appointments(patient_id, doctor_id, appointment_date, reason_for_visit, status, duration, appointment_type, notes)
				VALUES (:patient_id, :doctor_id, :appointment_date, :reason_for_visit, :status, :duration, :appointment_type, notes)
			');
			$stmt->execute([
				'patient_id' => $data['patient_id'],
				'doctor' => $data['doctor_id'],
				'appointment_date' => $data['appointment_date'],
				'reason_for_visit' => $data['reson_for_visit'] ?? null,
				'status' => $data['status'] ?? 'Scheduled',
				'duration' => $data['duration'] ?? 30, // Default duration is 30 minutes
				'appointment_type' => $data['appointment_type'] ?? 'In-Person',
				'notes' => $data['notes'] ?? null
			]);
			http_response_code(201); // created 
			echo json_encode(['message' => 'Appointment created successfully']);
		} catch (PDOException $e) {
			http_response_code(500); // Internal Server Error 
			echo json_encode(['error' => $e->getMessage()]);
		}
	}
	
	function updateAppointment($pdo, $data) {
		if (empty($data['appointment_id'])) {
			http_response_code(400); // bad request
			echo json_encode(['message' => 'Appointment ID is required']);
			return;
		}
		
		$validation = validateAppointmentInput($data);
		if ($validation !== true) {
			http_response_code(400); 
			echo json_encode(['message' => $validation]);
			return;
		}
		
		try {
			/* Check if the appointment exists */
			$stmt = $pdo->prepare('SELECT * FROM appointments WHERE appointment_id = :appointment_id');
			$stmt->execute(['appointment_id' => $data['appointment_id']]);
			$appointment = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (!$appointment) {
				http_response_code(404); // Not found 
				echo json_encode(['message' => 'Appointment not found']);
				return;
			}
			
			/* update appointment details */
			$stmt = $pod->prepare('
				UPDATE appointments 
				SET patient_id = :patient_id, doctor_id = :doctor_id, appointment_date = :appointment_date,
					reason_for_visit = :reason-for_visit, status = :status, duration = :duration,
					appointment_type = :appointment_type, notes = :notes, updated_at = : CURRENT_TIMESTAMP
				WHERE appointment_id = :appointment_id 
			');
			
			$stmt->execute([ 
				'paatient_id' => $data['patient_id'] ?? $appointment['patient_id'],
				'doctor_id' = $data['doctor_id'] ?? $appointment['doctor_id'],
				'appointment_date' => $data['appointment_date'] ?? $appointment['appointment_date'],
				'reson_for_visit' => $data['reson_for_visit'] ?? $appointment['reason_for_visit'],
				'status' => $data['status' ?? $appointment['status'],
				'duration' => $data['duration'] ?? $appointment['duration'],
				'appointment_type' => $data['appointment_type'] ?? $appointment['appointment_type'],
				'notes' => $data['notes'] ?? $appointment['notes'],
				'appointment_id' => $data['appointment_id']
			]);
			
			http_response_code(200); // ok 
			echo json_encode(['message' => 'Appointment updated successfully']);
		} catch (PDOException $e) {
			http_response_code(500); // Internal Server Error 
			echo json_encode(['error' => $e->getMessage()]);
		}
	}
	
	function deleteAppointment($pdo, $data) {
		if (empty($data['appointment_id'])) {
			http_response_code(400); // Bad request
			echo json_encode(['message' => 'Appointments ID is required']);
			return;
		}
		try {
				/* Check if the appointment exists */
				$stmt = $pdo->prepare('SELECT * FROM appointments WHERE appointment_id = :appointment_i');
				$stmt->execute(['appointment_id' => $data['appointment_id']]);
				$appointment = $stmt->fetch(PDO::FETCH_ASSOC);
				
				if (!$appointment) {
					http_response_code(400); // Not found
					echo json_encode('message' => 'Appointment not found']);
					return;
				}
				/* delete the appointment */
				$stmt = $pdo->prepare('DELETE FROM appointments WHERE appointment_id = :appointment_id');
				$stmt->execute(['appointment_id' => $data['appointment_id']]]);
				
				http_response_code(200); // OK
				echo json_encode(['message' => 'Appointment deleted successfully']);
		} catch (PDOException $e) {
			http_response_code(500); //Internal Server Error 
			echo json_encode(['error' => $e->getMessage()]]);
		}
	}
?>
			