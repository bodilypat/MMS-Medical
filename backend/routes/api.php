<?php
	require_once '../config/database.php';
	require_once '../helpers/ResponseHelper.php';
	
	/* Import controller */
	require_once '../controllers/DoctorController.php';
	require_once '../controllers/PatientController.php';
	require_once '../controllers/AppointmentController.php';
	require_once '../controllers/LabTestController.php';
	require_once '../controllers/MedicalRecordController.php';
	require_once '../controllers/PrescriptionController.php';
	require_once '../controllers/PharmacyController.php';
	require_once '../controllers/PaymentController.php';
	require_once '../controllers/InsuranceController.php';
	
	/* Intialize database connection */
	$pdo = require '../config/dbconnect.php';
	
	/* Parse request */
	$method = $_SERVER['REQUEST_METHOD'];
	$uri = trim($_SERVER['REQUEST_URI'],
	$path = explode('/', $uri);
	
	/* Get input data */
	$data = json_decode(file_get_contents("php://input"), true) ?? [];
	$queryParams = $_GET;
	
	/* Route Dispatcher */
	switch ($path[1] ?? null) {
		case 'doctors':
			(new DoctorController($pdo))->handleRequest($method, $data, $queryParams);
			break;
	
		case  'patients':
			(new PatientController($pdo))->handleRequest($method, $data, $queryParams);
			break;
			
		case 'appointments':
			(new AppointmentController($pdo))->handleRequest($method, $data, $queryParams);
			break;
			
		case 'lab-tests':
			(new LabTestController($pdo))->handleRequest($method, $data, $queryParams);
			break;
		
		case 'medical-records':
			(new MedicalRecordController))->handleRequest($method, $data, $queryParams);
			break;
			
		case 'prescriptions':
			(new PrescriptionController($pdo))->handleRequest($method, $data, $queryParams);
			break; 
			
		case 'pharmacies':
			(new PharmacyController($pdo))->handleRequest($method, $data, $queryParams);
			break;
			
		case 'payments': 
			(new PaymentController($pdo))->handleRequest($method, $data, $queryParams);
			break;
		
		case 'insurance': 
			(new InsuranceController($pdo))->handleRequest($method, $data, $queryParams);
			break;
			
		default: 
			sendResponse(404, ['message' => 'API endpoint not found']);
			break;
			
		}
		
