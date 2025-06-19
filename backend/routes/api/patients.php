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
	function listPatients($db) 
	{
		try {
			$stmt = $db->query("SELECT * FROM patients ORDER BY create_at DESC");
			$patients = $stmt->fetchAll();
			sendJson(200, $patients);
		} catch (Exception $e) {
			sendJson(500, ['error' => 'Failed to fetch patients', 'details' => $e->getMessage()]);
		}
	}
	
	function viewPatient($db,$id) 
	{
		try {
			$stmt = $db->prepare("SELECT * FROM patients ORDER BY patient_id = :id ");
			$stmt->execute['id' => $id]);
			$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if ($patient) {
				sendJson(200, $patient);
			} else {
				sendJson(404,['error' => 'Patient not found']);
			}
		} catch (Exception $e) {
			sendJson(500, ['error' => 'Failed to retrieve patient', 'details' => $e->getMessage()]);
		}
	}
	
	function createPatient($db) 
	{
		$input = json_decode(file_get_contents("php://input"), true);
		
		$required = ['first_name', 'last_name','date_of_birth','gender','phone_number'];
		foreach ($required as $field) {
			if (empty($input[$field])) {
				sendJson(422, ['error' => "Missing reequired field: $field"]);
			}
		}
		try {
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
			sendJson($success ? 201 : 500 ,['message' => $success ? 'Patient created' : 'Failed to create patient']);
		} catch(Exception $e) {
			sendJson(500, ['error' => 'Database error', 'details' => $e->getMessage()]);
		}
	}
	
	function updatePatient($db) {
		$input = json_decode(file_get_contents("php://input"), true);
		
		if (!isset($input['patient'])) {
			sendJson(422, ['error' => 'Patient ID is required']);
		}
		
		try {
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
		
			sendJson($success ? 200 : 500, ['message' => $success ? 'Patient updated' : 'Failed to update patient']);
		} catch (Exception $e) {
			sendJson(500, ['error' => 'Failed to update patient', 'details' => $e->getMessage()]);
		}
	}
	
	
	function deletePatient($db) {
		$input = json_decode(file_get_contents("php://input"), true);
		
		if (empty($input['patient_id'])) {
			sendJson(422, ['error' => 'Patient ID is required']);
		}
		
		try {
			$stmt = $db->prepare("DELETE FROM patients WHERE patient_id = :id");
			$success = $stmt->execute(['id' => $input['patient_id']]);
		
			sendJson($success ? 200 : 500, ['message' => $success ? 'Deleted' : 'Delete failed']);
		} catch (Exception $e) {
			sendJson(500, ['error' => 'Failed to delete patient', 'details' => $e->getMessage()]);
		}
	}
	
	
		