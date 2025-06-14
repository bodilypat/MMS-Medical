
	require_once '../../config/database.php';
	require_once '../../models/User.php';
	require_once '../../helpers/response.php';
	
	header('Content-Type: application/json');
	
	/* ensyre it's a POST request */
	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
		return jsonResponse(['message' => 'Only POST requests allowed'], 405);
	}
	
	/* Get input data */
	$data = json_decode(file_get_contents('php://input'), true);
	$username = $data['username'] ?? '';
	$password = $data['password'] ?? '';
	
	/* Basic Validation */
	if (empty($username) || empty($password)) {
		return jsonResponse(['message' => 'Username and password required'], 400);
	}
	
	/* Initialize DB and user model */
	$db = new Database();
	$conn = $db->connect();
	$user = new User($conn);
	
	/* Try to authenticate */
	$foundUser = $user->findByUsername($username);
	
	if ($foundUser && password_verify($password, $foundUser['password'])) {
		/* Create a session or return a mack token */
		session_start();
		$_SESSION['user_0id'] = $foundUser['id'];
		return jsonResponse([
			'success' => true,
			'message' => 'Login suuccessful',
			'token' => session_id(); // or JWT if perfered
		]);
	} else {
		return jsonResponse(['success' => false,'message' => 'Invalid credentials'], 401);
	}
	
