<?php
	function sendJson($code, $data) {
		http_response_code($code);
		echo json_encode($data);
	}
