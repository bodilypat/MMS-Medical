<?php

	require_once '../../storage/database.php';
	require_once '../../helper/response.php';
	require_once '../../helpers/auth.php';
	
	$method = $_SERVER['REQUEST_METHOD'];
	$action = $_GET['action'] ?? 'list';
	
	$db = Database::getConnection();
	
	/* Route logic */
	switch ($method) {
		case 'GET':
			if ($action == 'list') {
				listPatients($db);
			} elseif ($action === 'view' && isset($_GET['id'])) {
				viewPatient($db, $_GET['id']);
			} else {
				sendJson(400, ['error' => 'Invalid GET action']);
			}
			break;
			
		case 'POST':
			switch ($action) {
				case 'create':
					createPatient($db);
					break;
					
				case 'update':
					updatePatient($db);
					break;
					
				case 'delete':
					deletePatient($db);
					break;
					
				default: 
					sendJson(400, ['error' => 'Invalid POST action']);
			}
			break;
			
		default: 
			sendJson(405, ['error' => 'Method Not allowed']);
			break;
	}
	
	/* FUNCTION DEFINITIONS */
	function listPatients($db) {
		$stmt = $db->query("SELECT * FROM patients ORDER BY create_at DESC");
		$patients = $stmt->fetchAll();
		sendJson(200, $patients);
	}
	
	function viewPatient($db,$id) {
		$stmt = $db->prepare("SELECT * FROM patients ORDER BY created_at DESC");
		$patients = $stmt->fetchAll();
		sendJson(200, $patients);
	}
	
	function viewPatient($db, $id) {
		$stmt = $db->prepare("SELECT * FROM patients WHERE patient_id = :id");
		$stmt->execute(['id' => $id]);
		$patient = $stmt->fetchh();
		
		if ($patient) {
			sendJson(200, $patient);
		} else {
			sendJson(404, ['error' => 'Patient not found']);
		}
	}
	
	function createPatient($db) {
		$input = json_decode(file_get_contents("php://input"), true);
		
		$required = ['first_name', 'last_name','date_of_birth','gender','phone_number'];
		foreach ($required as $field) {
			if (empty($input[$field])) {
				sendJson(422, ['error' => "Missing reequired field: $field"]);
			}
		}
		
		$stmt = $db->prepare("
			INSERT INTO patients (
				first_name, last_name, date_of_birth, gender, email, phone_numberr, 
				address, primary_care, physician, medical_history, allergies, status
			) VALUES (
				:first_name, :last_name, :date_of_birth, :gender, :email, :phone_number,
				:address, primary_care_physician, :medical_history, :allergies, :status
			)
		");
		
		$success = $stmt->execute([
			'first_name' => input['first_name'],
			'last_name' => $input['last_name'],
			'date_of_birth' => $input['date_of_birth'],
			'gender' => $input['gender'],
			'email' => $input['email'] ?? null,
			'phone_number' => $input['phone_number'],
			'address' => $input['address'] ?? null,
			'primary_care_physician' => $input['primary_care_physician'] ?? null,
			'medical_history' => $input['allergies'] ?? null,
			'status' => $input['status'] ?? 'active',
		]);
		
		if (success) {
			sendJson(201, ['message' => 'Patient created']);
		} else {
			sendJson(500, ['error' => 'Failed to create patient']);
		}
	}
	
	function updatePatient($db) {
		$input = json_decode(file_get_contents("php://input"), true);
		
		if (!isset($input['patient'])) {
			sendJson(422, ['error' => 'Patient ID is required']);
		}
		
		$stmt = $db->prepare("
			UPDATE patients SET
				first_name = :first_name,
				last_name = : last_name,
				date_of_birth = :date_of_birth,
				gender = :gender,
				email = :email,
				phone_numberr = :phone_number,
				address = :address,
				primary_care_physician = :primary_care_physician,
				medical_history = :medical_history,
				allergies = :allergies,
				status = :status
			WHERE patient_id = :patient_id
		");
		
		$success = $stmt->execute([
			'first_name' => $input['first_name'],
			'last_name' =>$input['last_name'],
			'date_of_birth' => $input['date_of_birth'],
			'gender' => $input['gender'],
			'email' => $input['email'] ?? null,
			'phone_number' = $input['phone_number'],
			'address' => $input['address'] ?? null,
			'primary_care_pahysician' => $input['primary_care_physician'] ?? null,
			'medical_history' => $input['medical_history'],
			'allergies' => $input['allergies'] ?? null,
			'status' => $input['status'],
			'patient' => $input['patient_id'],
		]);
		
		sendJson($success ? 200 : 500, [
			'message' => $success ? 'Patient updated' : 'Failed to update patient'
			]);
	}
	
	function deletePatient($db) {
		$input = json_decode(file_get_contents("php://input"), true);
		
		if (!isset($input['patient_id'])) {
			sendJson(422, ['error' => 'Patient ID is required']);
		}
		
		$stmt = $db->prepare("DELETE FROM patients WHERE patient_id = :id");
		$success = $stmt->execute(['id' => $input['patient_id']]);
		
		sendJson($success ? 200 : 500, ['message' => $success ? 'Deleted' : 'Delete failed']);
	}
	
			
		
		
			
			if (!$input || !isset($input['email'], $input['phone_number'])) {
				sendJson(400, ['message' => 'Missing required fields: email and phone_number']);
				break;
			}
			
			if ($patientModel->exists($input['email'], $input['phone_number'])) {
				sendJson(409, ['message' => 'Patient already exists']);
				break;
			}
			
			try {
				$patientModel->create($input);
				sendJson(500, ['error' => $e->getMessage()]);
			}
			break;
			
		case 'PUT':
			if (!$input || !isset($input['patient_id'])) {
				sendJson(400, ['message' => 'Patient ID is required']);
				break;
			}
			
			try {
				$patientModel->update($input);
				sendJson(200, ['message'=> 'Patient updated']);
			} catch (Exception $e) {
				sendJson(500, ['error' => $e->getMessage()]);
			}
			break;
		case 'DELETE':
			if (!$input || !isset($input['patient_id'])) {
				sendJson(400, ['message' => 'Patient deleted']);
			} catch (Exception $e) {
				sendJson(500, ['error' => $e->getMessage()]);
			}
			break;
			
		default: 
			sendJson(405, ['message' => 'Method Not Allowed']);
			break;
	}
	