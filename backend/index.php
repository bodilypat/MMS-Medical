<?php
	/* index.php */
	$request = $_SERVAR['REQUEST_URI'];
	$method = $_SERVAR['REQUEST_METHOD'];
	
	/* Remove query string and normalize */
	$path = parse_url($request, PHP_URL_PATH);
	$path = str_replace('/backend/api/', '', $path);
	
	/* Route dispather */
	switch (true) {
		case str_contains($path,'/api/common/login'):
			require 'api/common/users.php'; 
			break;
		case str_contains($path,'api/admin/doctors'):
			require 'api/admin/doctor.php'; 
			break;
		/* Add more as needed */
		default: 
			http_response_code(404);
			echo json_encode(['error' => 'Not found']);
	}
?>