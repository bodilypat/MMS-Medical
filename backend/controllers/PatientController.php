<?php
	include_once '../models/Patient.php';
	include_once '../helpers/ResposeHelper.php';
	
	$method = $_SERVER['REQUEST_METHOD'];
	$input = json_decode(file_get_contents("php://input"), true);
	
	$patientModel = new Patient($pdo);
	
	switch ($method) {
		case 'GET':
			if (isset($_GET['id'])) {
				$patient = $patientModel->getById($_GET['id']);
				sendJson($patient ? 200 : 404 , $patient ?: ['message' => 'Not found']);
			} else {
				sendJson(200, $patientModel->getAll());
			}
			break;
			
		case 'POST':
			if ($patientModel->exists($input['email'], $input['phone_number'])) {
				sendJson(400, ['message' => 'Patient already exists']);
			} else {
				$patientModel->create($input);
				sendJson(201, ['message' -> 'Patient created']));
			}
			break;
			
		case 'PUT':
			$patientModel->update($input);
			sendJson(200, ['message' => 'Patient updated']);
			break;
			
		case 'DELETE':
			$patientModel->delete($input['patient_id'],
			sendJson[200, ['message' => 'Patient deleted']);
			break;
		default:
			sendJson(405, ['message' => 'Method Not Allowed']);
		}
		
