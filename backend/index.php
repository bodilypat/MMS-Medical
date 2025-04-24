<?php
	/* index.php */
	$path = $_SERVAR['REQUEST_URI'];
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