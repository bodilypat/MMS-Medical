<?php

require_once __DIR__ . '/../../storage/database.php';
require_once __DIR__ . '/../../helpers/response.php';
require_once __DIR__ . '/../../helpers/auth.php';

session_start();
$db = Database::getConnection();
$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

switch ($method) {
    case 'POST':
        switch ($action) {
            case 'login':
                login($db);
                break;
            case 'logout':
                logout();
                break;
            default:
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
        sendJson(405, ['error' => 'Method not allowed']);
}


/* ----------------------------------
   FUNCTION DEFINITIONS
----------------------------------- */

function login($db)
{
    $input = json_decode(file_get_contents("php://input"), true);

    $usernameOrEmail = trim($input['username'] ?? '');
    $password = $input['password'] ?? '';

    if (!$usernameOrEmail || !$password) {
        sendJson(422, ['error' => 'Username/email and password are required']);
    }

    $stmt = $db->prepare("SELECT * FROM users WHERE username = :u OR email = :u LIMIT 1");
    $stmt->execute(['u' => $usernameOrEmail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($password, $user['password_hash'])) {
        sendJson(401, ['error' => 'Invalid credentials']);
    }

    if (!$user['is_active']) {
        sendJson(403, ['error' => 'Account is inactive']);
    }

    // Regenerate session to prevent session fixation
    session_regenerate_id(true);

    $_SESSION['user'] = [
        'id'       => $user['id'],
        'username' => $user['username'],
        'email'    => $user['email'],
        'role'     => $user['role']
    ];

    sendJson(200, [
        'message' => 'Login successful',
        'user'    => $_SESSION['user']
    ]);
}

function logout()
{
    session_unset();
    session_destroy();

    sendJson(200, ['message' => 'Logout successful']);
}

function getCurrentUser()
{
    if (!empty($_SESSION['user'])) {
        sendJson(200, $_SESSION['user']);
    } else {
        sendJson(401, ['error' => 'Not authenticated']);
    }
}
