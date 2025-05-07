<?php
	use App\Controllers\DoctorController;
	
	$uri = parse_url($_SERVER['REQUEST_URI'), PHP_URL_PATH);
	$method = $_SERVER['REQUEST_METHOD'];
	$input = json_decode(file_get_contents('php://input', true);
	
	$controller = new DoctorController();
	
	if ($uri === '/api/doctors' && $method === 'GET') {
		$controller->index();
	} elseif (preg_match('/\/api\/doctors\/(\d+)/', $uri, $matches)) {
		$id = $matches[1];
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
