<?php

	require_once __DIR__ . '/../../storage/database.php';
	require_once __DIR__ . '/../../helpers/response.php';
	require_once __DIR__ . '/../../helpers/auth.php';
	
	$method = $_SERVER['REQUEST_METHOD'];
	$action = $_GET['action'] ?? 'list';
	
	$db = Database::getConnection();
	
	switch ($method) {
		case 'GET':
			if ($action === 'list') {
				listAppointments($db);
			} else {
				sendJson(400, ['error' => 'Invalid GET action']);
			}
			break;
			
		case 'POST':
			switch ($action) {
				case 'create':
					createAppointment($db);
					break;
					
				case 'update':
					updateAppointment($db);
					break;
					
				case 'delete':
					deleteAppointment($db);
					break;
					
				case 'status':
					updateStatus($db);
					break;
					
				default:
					sendJson(400, ['error' => 'Invalid POST action']);
			}
			break;	
		default:
			sendJson(405, ['error' => 'Method not allowed']);
			break;
	}
	/* FUNCTION DEFINITION */
	function listAppointments($db) 
	{
		try {
			$stmt = $db->query("
				SELECT a.*,
					CONCAT(p.first_name, ' ', p.last_name) AS patient_name,
					CONCAT(d.first_name, ' ', d.last_name) AS doctor_name
				FROM appointments a 
				JOIN patients p ON a.patient_id = p.patient_id
				JOIN doctors d ON a.doctor_id = d.doctor_id 
				ORDER BY a.appointment_date DESC 
			");
			$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
			sendJson(200, $appointments);
		} catch (Exception $e) {
			sendJson(500, ['error' => 'Failed to list appointments', 'details' => $e->getmessage()]);
		}
	}
	
	function createAppointment($db) 
	{
		$input = json_decode(file_get_contents("php://input"), true);
		
		if (!isset($input['patient_id'], $input['doctor_id'], $input['appointment_date'], $input['reason_for_visit'])) {
			sendJson(422,['error' => 'Missing required fields']);
		}
		
		try {
			$stmt = $db->prepare("
				INSERT INTO appointments
					(patient_id, doctor_id, appointment_date, reason_for_visit, appointment_type, status)
				VALUES 
					(:patient_id, :doctor_id, :appointment_date, :reason_for_visit, :appointment_type, :status)
				");
				
				$success = $stmt->execute([
					'patient_id' => $input['patient_id'],
					'doctor_id' => $input['doctor_id'],
					'appointment_date' => $input['appointment_date'],
					'reason_for_visit' => $input['reason_for_visit'],
					'appointment_type' => $input['appointment_type'] ?? 'Consultation',
					'status' => 'Scheduled',
					'created_by' => getCurrentUserId() ?? 1,
				]);
				
				sendJson($success ? 201 : 500, ['message' => $success ? 'Appointment created' : 'Failed to create appointment']);
		} catch (Exception $e) {
			sendJson(500, ['error' => 'Database error', 'details' => $e->getMessage()]);
		}
	}
	
	function updateAppointment($db) 
	{
		$input = json_decode(file_get_contents("php://input"), true);
		
		if (!isset($input['appointment_id'])) {
			sendJson(422, ['error' => 'Appointment ID is required']);
		}
		
		try {
			$stmt = $db->prepare("
				UPDATE appointments 
				SET appointment_date = :appointment_date,
					reason_for_visit = :reason_for_visit,
					appointment_type = :appointment_type,
					doctor_id = :doctor_id,
					updated_by = :updated_by 
				WHERE appointment_id = :appointment_id 
			");
			
			$success = $stmt->execute([
				'appointment_date' => $input['appointment_date'],
				'reason_for_visit' => $input['reason_for_visit'],
				'appointment_type' => $input['appointment_type'],
				'doctor_id' => $input['doctor_id'],
				'updated_by' => getCurrentUserId() ?? 1,
				'appointment_id' => $input['appointment_id'],
			]);
			
			sendJson($success ? 200 : 500, ['message' => $success ? 'Appointment updated' : 'Failed to delete appointment']);
		} catch (Exception $e) {
			sendJson(500, ['error' => 'Error updating appointment', 'details' => $e->getMessage()]);
		}
	}
	
	function deleteAppointment($db) 
	{
		$input = json_decode(file_get_contents("php://input"), true);
		
		if (!isset($input['appointment_id'])) {
			sendJson(422, ['error' => 'Appointment ID required']);
		}
		try {
			$stmt = $db->prepare("DELETE FROM appointments WHERE appointment_id = :id");
			$success = $stmt->execute(['id' => $input['appointment_id']]);
			
			sendJson($success ? 200 : 500, ['error' => $success ? 'Appointment deleted' : 'Failed to delete appointment']);
		} catch (Exception $e) {
			sendJson(500, ['error' => 'Error deleting appointment', 'details' => $e->getMessage()]);
		}
	}
	
	function updateStatus($db) 
	{
		$input = json_decode(file_get_contents("php://input"), true);
		
		if (!isset($input['appointment_id'], $input['status'])) {
			sendJson(422, ['error' => 'Appointment ID and status required']);
		}
		
		try {
				$stmt = $db->prepare("
					UPDATE appointments 
					SET status = :status, updated_by = :updated_by
					WHERE appointment_id = :id 
				");
				
				$success = $stmt->execute([
					'status' => $input['status'],
					'updated_by' => getCurrentUserId() ?? 1,
					'id' => $input['appointment_id'],
				]);
				
				sendJson($success ? 200 : 500, ['message' => $success ? 'Status updated' : 'Failed to update status']);
		} catch (Exception $e) {
			sendJson(500, ['error' => 'Error updating status', 'details' => $e->getMessage()]);
		}
	}
	