<?php
	requrie_once '../../config/dbconnect.php';
	requrie_once '../../lib/session.php';
	
	$data = json_decode(file_get_contents('php://input'), true);
	$email = $data['email'] ?? '';
	$password = $data['password'] ?? '';
	
	
	if (!$email || !$password) {
		http_response_code(400);
		echo json_encode('error' => 'Email and password are requried']);
		exit;
	}
	
	$stmt = $handle->prepare("SELECT * FROM users WHERE email = ?");
	$stmt->execute([$email]);
	$user = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if ($user && password_verify($password, $user['password'])) {
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['username'] = $user['username'];
		$_SESSION['role'] = $user['role'];
		
		echo json_encode([
			'message' => 'Login successful', 
			'user' => currentUser()
			]);
		} else {
			http_response_code(401);
			echo json_encode(['error' = 'Invalid credentials']);
		}
	?>
	