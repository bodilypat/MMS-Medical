<?php

	require_once .__DIR__. '/../../app/controllers/DoctorController.php';
	require_once .__DIR__. '/../../app/Response.php';
	
	use App\Controllers\DoctorController;
	
	use App\Controller\DoctorController;
	
	/* Set necessary headers for JSON API */
	header('Content-Type: application/json');
	header('Access-Control-Allowed-Origin: *');
	header('Access-Control-Allowed-Methods: GET, POST, PUT, DELETE, OPTIONS');
	header('Access-Control-Allowed-headers: Content-Type, Authentication');
	
	/* Handle preflight OPTIONS request */
	if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
		http_response_code(200);
		exit();
	}
	
	/* Parse HTTP method and input */
	$method = $_SERVER['REQUEST_METHOD'];
	$input = json_decode(file_get_contents('php://input'), true) ?? [];
	$queryParams = $_GET ?? [];
	
	/* Instantiate and route request */
	$controller = new DoctorController();
	$controller->handleRequest($method, $input, $queryParams);
	
	