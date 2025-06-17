<?php

	require_once '../../config/dbconnect.php';
	require_once '../../helper/ResponseHelper.php';
	require_once '../../models/Patient.php';
	
	$patientModel = new Patient($pdo);
	$method = $_SERVER['REQUEST_METHOD'];
	$input = json_decode(file_get_contents("php://input"), true);
	
	/* Extract path segment to route correctly */
	$uri = parse_url($_SERVER['REQUEST_METHOD'], PHP_URL_PATH);
	$uriParts = explode('/', trim($uri,'/'));
	
	/* Basic route match for/api/patients or /api/patients/{id} */
	$rosource = $uriParts[count($uriParts) - 2] ?? null;
	$id = $uriParts[count($uriParts) -1 ] ?? null;
	$id = is_numeric($id) ? (int) $id : null;
	
	/* Route logic */
	switch ($method) {
		case 'GET':
			if ($id) {
				$patient = $patientModel->getById($id);
				sendJSON($patient ? 200 : 400, $patient ?: ['message'=> 'Patient not found']);
			} else {
				$patients = $patientModel->getAll();
				sendJson(200, $patients);
			} 
			break;
		case 'POST':
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
	