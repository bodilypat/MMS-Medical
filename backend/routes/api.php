<?php
	require_once BASE_PATH . '/config/dbconenct.php';
	require_once BASE_PATH . '/helpers/ResponseHelper.php';
	
	/* Import controller */
	require_once BASE_PATH . '/controllers/DoctorController.php';
	require_once BASE_PATH . '/controllers/PatientController.php';
	require_once BASE_PATH . '/controllers/AppointmentController.php';
	require_once BASE_PATH . '/controllers/LabTestController.php';
	require_once BASE_PATH . '/controllers/MedicalRecordController.php';
	require_once BASE_PATH . '/controllers/PrescriptionController.php';
	require_once BASE_PATH . '/controllers/PharmacyController.php';
	require_once BASE_PATH . '/controllers/PaymentController.php';
	require_once BASE_PATH . '/controllers/InsuranceController.php';	
	
	/* Parse request */
	$method = $_SERVER['REQUEST_METHOD'];
	$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
	
	/* Get input data */
	$input = json_decode(file_get_contents('php://input'), true) ?? [];
	$queryParams = $_GET ?? [];

	$pdo = require BASE_PATH  . '/config/dbconnect.php';
	
	/* Remove api prefix if exists */
	$path = preg_replace('#^api/#', '', $uri);
		
	/* Route Dispatcher */
	switch (true) {
		case $path === 'patients':
			(new PatientController($pdo))->handleRequest($method, $data, $queryParams);
			break;
	
		case $path === 'appointments':
			(new AppointmentController($pdo))->handleRequest($method, $data, $queryParams);
			break;
			
		case $path === 'doctors':
			(new DoctorController($pdo))->handleRequest($method, $data, $queryParams);
			break;
			
		case $path === 'lab-tests':
			(new LabTestController($pdo))->handleRequest($method, $data, $queryParams);
			break;
		
		case $path === 'medical-records':
			(new MedicalRecordController))->handleRequest($method, $data, $queryParams);
			break;
			
		case $path === 'prescriptions':
			(new PrescriptionController($pdo))->handleRequest($method, $data, $queryParams);
			break; 
			
		case $path === 'pharmacies':
			(new PharmacyController($pdo))->handleRequest($method, $data, $queryParams);
			break;
			
		case $path === 'payments': 
			(new PaymentController($pdo))->handleRequest($method, $data, $queryParams);
			break;
		
		case $path === 'insurance': 
			(new InsuranceController($pdo))->handleRequest($method, $data, $queryParams);
			break;
			
		default: 
			http_response_code(404);
			echo json_encode(['error' => 'API endpoint not found']);
			
		}
		