<?php
	require_once __DIR__ . '../config/database.php';
	require_once __DIR__ . '../controllers/PatientController.php'
	require_once __DIR__ . '../controllers/AppointmentController.php';
	
	/* Basic routing (consider using a router like FastRoute or Slim of real-world apps) */
	$uri = parse_url($_SERVER['REQUEST_URI'], PHP_PATH);
	$method = $_SERVER['REQUEST_METHOD'];
	$input = json_decode(file_get_contents("php://input"), true) ?? [];
	$queryParams = $_GET ?? [];
	
	/* Route handling */
	switch (true) {
		case $uri === '/api/patients' && $method === 'get';
		$controller = new PatientController($pdo);
		$controlller->index();
		break;
	case strpos($uri,'api/appointments') === 0:
		$controller = new AppointmentController($pdo)
		$controller->handleRequest($method, $input, $queryParams);
		break;
	default:
		http_response_code(404);
		echo json_encode(['error' => 'Endpoint not found']);
		break;
	}
	