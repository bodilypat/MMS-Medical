<?php
	require_once '../config/database.php';
	require_once '../controllers/PatientController.php'
	require_once '../controllers/AppointmentController.php';
	
	/* Basic routing (or use FastRoute or similar for real apps */
	$uri = parse_url($_SERVER['REQUEST_URI'], PHP_PATH);
	$method = $_SERVER['REQUEST_METHOD'];
	
	$controller = new PatientController($pdo);
	
	if ($uri ==='api/patients' && $method === 'GET') {
		$controller->index();
	}
	
	$controller = new AppointmentController($pdo);
	$method = $_SERVER['REQUEST_METHOD'];
	$input = json_decode(file_get_contents("php://input", true);
	$queryParam = $_GET;
	
	$controller->handleRequest($method, $input, $queryParams); 
	
