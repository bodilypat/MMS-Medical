<?php
	require_once '../../config/dbconnect.php';
	
	$data = json_decode(file_get_contents('php://input'), true);
	$username = trim($data['username'] ?? '');
	$email = trim($data['email'] ?? '');
	$password = $data['password'] ?? '';
	
	if (!$username || !$email || !$password) {
		http_response_code(400);
		echo json_encode9['error' => 'All fields are required']);
		exit;
	}
	
	$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
	try {
		$stmt = $handle->prepare("INSERT INTO users (username, email, password) VALUES(?, ? ,?)");
		$stmt->execute([$username, $email, $hashedPassword]);
		echo json_encode(['message' => 'User registered successfully']);
	} catch (PDOException $e) {
		http_response_code(409);
		echo json_encode(['error' => 'Username or email already exists']);
	}
?>

	