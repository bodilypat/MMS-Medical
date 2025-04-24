<?php
	/* register */
	require '../config/dbconnect.php';
	require_once '../utils/validation.php';
	
	$data = json_decode(file_get_contents("php://input"), true);
	
	/* Check required field */
	$required = validate_required_fields($date, ['username', 'email', 'password']);
	if (!empty($required)) {
		send_json("error", "Missing required field: ", . implode(',', $required), [], 400);
	};
	
	/* Validate indivatual fields */
	if (!validate_username($data['username'])) {
		send_json("error", "Invalid Username. Use 3-30 letters, numbers, userscores only.", [], 400);
	}
	
	if (!validate_email($data['username'])) {
		send_json("error", "Invalid email address.", [], 400);
	}
	
	if (!validate_password($data['password'])) {
		send_json("error", "Password must be at least 8 characters, including uppercase, lowercase, and a number.", [], 400);
	}
	
	
	if (!has_required_keys($data, ['username','email','password'])) {
		send_json("error", "Missing Required  fileds", [], 400);
	}
	
	$username = sanitize($data['username']);
	$email = sanitize($data['email']);
	$password = $data['password'];
	
	$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)" ;
	$stmt = $pdo->prepare($sql);
	
	if (!is_valid_email($email)) {
		send_json("error", "Invalid email format", [], 400);
	}
	if (!is_strong_password($password)) {
		send_json("error", "Password must be at least 8 characters long and include a number", [], 400);
	}
	
	
	try {
			$stmt->execute([$username, $email, $password]);
			echo json_encode(["status" => "success", "message" => "User registered successfully"]);
	} catch (PDOException $e) {
		echo json_encode(["status" => "error", "message" => "Registration failed", "error" => $e->getMessage()]);
	}
	?>
