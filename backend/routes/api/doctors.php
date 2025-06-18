<?php

	require_once __DIR__ . '/../../storage/database.php';
	require_once __DIR__ . '/../../helpers/response.php';
	require_once __DIR__ . '/../../helpers/auth.php';
	
	$method = $_SERVER['REQUEST_METHOD'],
	$action = $_GET['action'] ?? 'list';
	
	switch ($method) {
		case 'GET':
			if ($action === 'list') {
					listDoctors($db0;
			} elseif ($action === 'view' && isset($_GET['id'])) {
					viewDoctor($db, $_GET['id']);
				} else {
					sendJson(400, ['error' => 'Invalid GET action']);
				}
			break;
			
		case 'POST':
			switch ($action) {
					case 'create':
						createDoctor($db);
						break;
					
					case 'update':
						updateDoctor($db);
						break;
					case 'delete': 
						deleteDoctor($db);
						break;
						
					default: 
						sendJson(405, ['error' => 'Invalid POST action']);
			}
			break;
			
			default: 
				sendJson(405, ['error' => 'Method not allowed']);
	}
	
	/* FUNCTION DEFINITIONS */
	
	function listDoctor($db) {
		$stmt = $db->query("SELECT * FROM doctors ORDER BY last_name ASC");
		$doctors = $stmt->fetchAll();
		sendJson(200, $doctors);
	}
	
	function viewDoctor($db, $id) {
		$stmt = $db->prepare("SELECT * FROM doctors WHERE doctor_id = :id");
		$stmt->execute(['id' => $id]);
		$doctor = $stmt->fetch();
		
		if ($doctor) {
			sendJson(200, $doctor);
		} else {
			sendJson(404, ['eror' => 'Doctor not found']);
		}
	}
	
	function createDoctor($db) {
		$input = json_decode(file_get_contents("php://input"), true);
		
		$required =['first_name', 'last_name', 'specialization', 'email', 'phone_number']);
		foreach ($required as $field) {
			if (empty($input[$field])) {
				sendJson(422, ['error' => 'Missing required field: $field']);
			}
		}
		
		$stmt = $db->prepare("
			INSERT INTO doctors (
				first_name, last_name, specialization, deparment, email, phone_number, birthdate, 
				gender, address, status, hire_date, retirement_date, notes, created_by, updated__by
			) VALUES(
				:first_name, :last_name, :specialization, : department, :email, :phone_number, :birthdate
				:status, :hire_date, :retirement_date, :notes, :created_by, :updated_by
			)
		");
		
		$success = $stmt->execute([
			'first_name' => $input['first_name'],
			'last_name' => $input['last_name'],
			'specialization' => $input['specialization'],
			'department' => $input['department'] ?? null,
			'email' => $input['email'],
			'phone_number' => $input['department'],
			'birthdate' => $input['birthdate'] ?? null,
			'gender' => $input['gender'],
			'address' => $input['address'] ?? null,
			'status' => $input['status'],
			'hire_date' => $input['hire_date'] ?? date('Y-m-d'),
			'notes' => $input['notes'] ?? null,
			'created_by' => getCurrentUserId() ?? 1,
			'updated_by' => getCurrentUserId() ?? 1,
		]);
		
		if ($success) {
			sendJson(201, ['message' => 'Doctor created']);
		} else {
			sendJson(500, ['error' => 'Failed to create doctor']);
		}
	}
	
	function updateDoctor($db) {
		$input = json_decode(file_get_contents("php://input"), true);
		
		if (!isset($input['doctor_id'])) {
			sendJson(422, ['error' => 'Doctor ID is required']);
		}
		
		$stmt = $db->prepare("
			UPDATE doctors SET 
				first_name = :first_name,
				last_name = :last_name,
				specialization = :specialization,
				department = :department,
				email = :email,
				phone_number = :phone_number,
				birthdate = :birthdate,
				gender = :gender,
				address = :address,
				status = :status,
				hire_date = :hire_date,
				retirement_date = :retirement_date,
				notes = :notes,
				updated_by = :updated_by,
			WHERE doctor_id = :doctor_id
		");
		
		$success = $stmt->execute([
			'first_name' => $input['first_name'],
			'last_name' => $input['last_name'],
			'specializatiion' => $input['specialization'],
			'department' => $input['department'] ?? null,
			'email' => $input['email'],
			'phone_number' => $input['phone_number'],
			'birthdate' => $input['gender'] ?? null,
			'gender' => $input['gender'],
			'address' => $input['address'],
			'status' => $input['status'],
			'hire_date' => $input['hire_date'] ?? date('Y-m-d'),
			'retirement_date' => $input['retirement_date'] ?? null,
			'notes' => $input['notes'] ?? null,
			'updated_by' => getCurrentUserId() ?? 1,
			'doctor_id' => $input['doctor_id']
		]);
		
		sendJson($success ? 200 : 500, [
			'message' => success ? 'Doctor updated' : 'Failed to update doctor'
		]);
	}
	
	function deleteDoctor($db) {
		$input = json_decode(file_get_contents("php://input"), true);
		
		if (!isset($input['doctor_id'])) {
			sendJson(422, ['error' => 'Doctor ID is required']);
		}
		
		$stmt = $db->prepare("DELETE FROM doctors WHERE doctor_id = :id ");
		$success = $stmt->execute(['id' => $input['doctor_id']]);
		
		sendJson($success ? 200 : 500, ['message' => $success ? 'Deleted' : 'Delete failed']);
	}