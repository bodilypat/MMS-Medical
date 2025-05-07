<?php
	use App\Controllers\DoctorController;
	use App\Core\Response;
	
	
	$uri = parse_url($_SERVER['REQUEST_URI'), PHP_URL_PATH);
	$method = $_SERVER['REQUEST_METHOD'];
	$input = json_decode(file_get_contents('php://input', true);
	
	/* Notmalize URI to prevent trailing slash issues */
	$uri = rtrim($uri, '/');
	
	$controller = new DoctorController();
	
	/* Route: GET /api/doctors */
	if ($uri === '/api/doctors' && $method === 'GET') {
		$controller->index();
		
		/* Route: POST/api/doctors */
	} elseif ($uri === '/api/doctors' && $method === 'PSOT' ) {
		$controller->store($input);
		
		/* Routes: /api/doctors/{id}  */
	} elseif (preg_match('#^/api/doctors/(\d+)$#',  $uri, $matches)) {
		
		$id = $matches[1];
		
		switch ($method) {
			case 'GET':
			$controller->show($id);
			break;
		case 'PUT':
			$input['doctor_id'] = $id;
			$controller->update($input);
			break;
		case 'DELETE':
			$controller->delete($id);
			break;
		default:
			Response::json(405, ['message' => 'Method Not Allowed']);
			break;
		}
	} else {
		Response::json(404, ['message' => 'Route not found']);
	}
	
		if ($method  === 'GET') {
			$controller->show($id);
		} elseif ($method === 'DELETE') {
			$controller->delete($id);
		} elseif ($method === 'PUT') {
			$input['doctor_id'] = $id;
			$controller->update($input);
		}
	} elseif ($url === '/api/doctors' && $method === 'POST') {
		$controller->store($input);
	} else {
		\App\Core\Response::json(404, ['message' => 'Route not found']);
	}
	
?>
