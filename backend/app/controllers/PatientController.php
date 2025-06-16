<?php
	include_once '../models/Patient.php';
	include_once '../helpers/ResposeHelper.php';
	include_once '../config/dbconnect.php'; // Ensure PDO is available
	
	
	$method = $_SERVER['REQUEST_METHOD'];
	$input = json_decode(file_get_contents("php://input"), true);
	
	$patientModel = new Patient($pdo);
	
	switch ($method) {
		case 'GET':
			if (isset($_GET['id'])) {
				$patient = $patientModel->getById($_GET['id']);
				sendJson($patient ? 200 : 404 , $patient ?: ['message' => 'Patient Not found']);
			} else {
				sendJson(200, $patientModel->getAll());
			}
			break;
			
		case 'POST':
			if (!$input || !isset($input['email'], $input['phone_number'])) {
				sendJson(400, ['message' => 'Missing required fields']);
				break;
				
			} 
			if ($patientModel->exists($input['email'], $input['phone_number'])) {
				$patientModel->create($input);
				sendJson(400, ['message' -> 'Patient already exists']);
			} else {
				try {
					$patientModel->create($input);
					sendJson(201, ['message' => 'Patient created']);
				} catch (Exception $e) {
					sendJson(500, ['error' => $e->getMessage()]);
				}
			}
			break;
			
		case 'PUT':
			if (!$input || !isset($input['patient_id'])) {
				sendJson(400, ['message' => 'Patient ID is required']);
			break;
			} 
			try {
					$patientModel->update($input);
					sendJson(200, ['message' => 'Patient updated']);
			} catch (Exception $e) {
				sendJson(500, ['error' => $e->getMessage()]);
			}
			break;
			
			
		case 'DELETE':
			if (!input || !isset($input['patient_id'])) {
				sendJson[400, ['message' => 'Patient ID is required']);
			break;
			}
			try {
				$patientModel->delete($input['patient-id']);
				sendJson(200, ['message' => 'Patient deleted']);
			} catch (Exception $e) {
				sendJson(500, ['error' => $e->getMessage()]);
			}
			break;
			
		default:
			sendJson(405, ['message' => 'Method Not Allowed']);
		}
		