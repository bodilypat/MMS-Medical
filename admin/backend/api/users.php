<?php
header("Content-Type: application/json");

// Include database connection file
include('../dbconnect.php');

// Handle different API methods
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // If an ID is provided, fetch a specific user
            $id = intval($_GET['id']);
            get_user($id);
        } else {
            // Otherwise, fetch all users
            get_users();
        }
        break;

    case 'POST':
        // Create a new user
        create_user();
        break;

    case 'PUT':
        // Update an existing user
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            update_user($id);
        }
        break;

    case 'DELETE':
        // Delete a user
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            delete_user($id);
        }
        break;

    default:
        // Invalid method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_users() {
    global $conn;

    $sql = "SELECT id, username, email, role, created_at, updated_at FROM users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $users = array();
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        echo json_encode($users);
    } else {
        echo json_encode(array("message" => "No users found"));
    }
}

function get_user($id) {
    global $conn;

    $sql = "SELECT id, username, email, role, created_at, updated_at FROM users WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode($user);
    } else {
        echo json_encode(array("message" => "User not found"));
    }
}

function create_user() {
    global $conn;

    // Get input data from POST request
    $data = json_decode(file_get_contents("php://input"), true);

    $username = $data['username'];
    $email = $data['email'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT); // Hash the password
    $role = $data['role'];

    // Insert the new user into the database
    $sql = "INSERT INTO users (username, email, password, role)
            VALUES ('$username', '$email', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "New user created successfully", "user_id" => $conn->insert_id));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}

function update_user($id) {
    global $conn;

    // Get input data from PUT request
    $data = json_decode(file_get_contents("php://input"), true);

    $username = $data['username'];
    $email = $data['email'];
    $role = $data['role'];

    // Optional: Check if password is provided in the request to update
    if (!empty($data['password'])) {
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE users
                SET username = '$username', email = '$email', password = '$password', role = '$role'
                WHERE id = $id";
    } else {
        $sql = "UPDATE users
                SET username = '$username', email = '$email', role = '$role'
                WHERE id = $id";
    }

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "User record updated successfully"));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}

function delete_user($id) {
    global $conn;

    // Delete user from the database
    $sql = "DELETE FROM users WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "User record deleted successfully"));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}
?>