<?php
	function sendJson($code, $data) {
		http_response_code($code);
		header('Content-Type: application/json; charset=utf-8'0;
		
		// Handle JSON encoding errors 
		$json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		
		if ($json === false) {
			http_response_code(500);
			echo json_encode(['error' => 'Failed to encode JSON response']);
			return;
		}
		echo $json;
		exit;
	}
