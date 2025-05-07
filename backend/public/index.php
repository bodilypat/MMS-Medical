<?php
	declare(strict_types=1);
	
	require_once __DIR__ . '../config/database.php';
	require_once __DIR__ . '../controllers/PatientController.php'
	require_once __DIR__ . '../controllers/AppointmentController.php';
	
	/* Set JSON response header */
	header('Content-Type: application/json');
	
	/* Parse request */
	$uri = parse_url($_SERVER['REQUEST_URI'], PHP_PATH);
	$method = $_SERVER['REQUEST_METHOD'];
	$input = json_decode(file_get_contents("php://input"), true) ?? [];
	$queryParams = $_GET ?? [];
	
	/* Basic routing */
	$path = preg_replace('#^/api#', '', $uri);
	
	/* Basic routing */
	try {
			if ($path === '/patients' && $method === 'GET') {
					$controller = new PatientController($pdo);
					$controlller->index();
			} elseif (preg_match('#^/appointments#', $path)) {
				$controller = new AppointmentController($pdo);
				$controller->handleRequest($method, $input, $queryParams);
			} else {
				http_response_code(404);
				echo json_encode(['error' => 'Endpoint not found']);
			}
		} catch (Exception $e) {
			http_response_code(500);
			echo json_encode(['error' => 'Server error', 'message' => $e->getMessage()]);
		}
	
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
	