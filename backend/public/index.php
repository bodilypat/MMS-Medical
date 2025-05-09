<?php
	declare(strict_types=1);
	
	/* === Set response type and CORS headers === */
	header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-methods: GET, POST, PUT, DELETE, OPTIONS");
	header("Access-Control-Allow-Headers: Content-Type, Authorization");
	
	/* === Handle preflight OPTIONS requests === */
	if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
		http_response_code(200);
		exit();
	}
	
	/* === Define base path content === */
	define('BASE_PATH', dirname(__DIR__));
	
	/* === load route dispatchar === */
	require_once BASE_PATH . '/routes/api.php';
	
	
	