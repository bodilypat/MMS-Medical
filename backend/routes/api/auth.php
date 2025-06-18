<?php
	require_once __DIR__ . '/../../storage/database.php';
	require_once __DIR__ . '/../../helpers/response.php';
	require_once __DIR__ . '/../../helpers/auth.php';
	
	$method = $_SERVER['REQUEST_METHOD'];
	$action = $_GET['action'] ?? '';
	
	$db = Database::getConnection();
	session_start();
	
	switch ($method) {
		case 'POST':
			if ($action === 'login') {
				login($db);
			} elseif ($action === 'logout') {
				logout();
			} else {
				sendJson(400, ['error' => 'Invalid POST action']);
			}
			break;
			
		case 'GET':
			if ($action === 'me') {
				getCurrentUser();
			} else {
				sendJson(400, ['error' => 'Invalid GET action']);
			}
			break;
		
		default: 
			sendJson(405, ['error' => 'Mothod not allowed']);
			break;
	}
	
	/* FUNCTION DEFINITION */
	function login($db) {
		$input = json_decode(file_get_contents("php://input"), true);
		
		$usernameOrEmail = $input['username'] ?? '';
		$password = $input['password'] ?? '';
		
		if (empty($usernameOrEmail) || empty($password)) {
			sendJson(422, ['error' => 'Username/email and password are required']);
		}
		
		$stmt = $db->prepare("SELECT * FROM users WHERE username = :u OR email = :u LIMIT 1");
		$stmt->execute(['u' => $usernameOrEmail]);
		$user = $stmt->fetch();
		
		if (!$user || !password_verify($password, $user['password_hash'])) {
			sendJson(401, ['error' => 'Invalid credentials']);
		}
		
		if (!$user['is_active']) {
			sendJson(403, ['error' => 'Account is inactive']);
		}
		
		/* Set session */
		$_SESSION['user'] = [
			'id' => $user['id'],
			'username' => $user['username'],
			'email' => $user['email'],
			'role' => $user['role']
		];
		
		sendJson(200, ['message' => 'Login successful', 'user' => $_SESSION['user']]);
	}
	
	function logout() {
		session_unset();
		session_destroy();
		sendJson(200, ['message' => 'Logout successful']);
	}
	
	function getCurrentUser() {
		if (isset($_SESSION['user'])) {
			sendJson(200, $_SESSION['user']);
		} else {
			sendJson(401, ['error' => 'Not authenticated']);
		}
	}
	
	
		
		
	