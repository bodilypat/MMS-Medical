<?php
	$host = 'localhost';
	$db = 'dbmedical';
	$user = 'medical';
	$pass = '';
	$charset = 'utf8mb4';
	
	try {
			$handle = new PDO("mysql:$host;dbname=$db;charset=$charset",$user, $pass);
			$handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERROR_EXCEPTION);
	} catch (PDOException $e) {
		http_response_code(500);
		echo json_encode('error' => 'Database connection failed']);
		exit;
	}
?>
