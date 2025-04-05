<?php
header("Content-Type: application/json");

// Include the database connection
include('../dbconnect.php');

// Handle different API methods
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // If an ID is provided, fetch a specific pharmacy record
            $id = intval($_GET['id']);
            get_pharmacy($id);
        } else {
            // Otherwise, fetch all pharmacy records
            get_pharmacies();
        }
        break;

    case 'POST':
        // Create a new pharmacy record
        create_pharmacy();
        break;

    case 'PUT':
        // Update an existing pharmacy record
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            update_pharmacy($id);
        }
        break;

    case 'DELETE':
        // Delete a pharmacy record
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            delete_pharmacy($id);
        }
        break;

    default:
        // Invalid method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_pharmacies() {
    global $conn;

    $sql = "SELECT * FROM pharmacies";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $pharmacies = array();
        while ($row = $result->fetch_assoc()) {
            $pharmacies[] = $row;
        }
        echo json_encode($pharmacies);
    } else {
        echo json_encode(array("message" => "No pharmacies found"));
    }
}

function get_pharmacy($id) {
    global $conn;

    $sql = "SELECT * FROM pharmacies WHERE pharmacy_id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $pharmacy = $result->fetch_assoc();
        echo json_encode($pharmacy);
    } else {
        echo json_encode(array("message" => "Pharmacy not found"));
    }
}

function create_pharmacy() {
    global $conn;

    // Get input data from POST request
    $data = json_decode(file_get_contents("php://input"), true);

    $name = $data['name'];
    $address = $data['address'];
    $phone_number = $data['phone_number'];
    $email = $data['email'];

    // Insert data into the database
    $sql = "INSERT INTO pharmacies (name, address, phone_number, email)
            VALUES ('$name', '$address', '$phone_number', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "New pharmacy created successfully", "pharmacy_id" => $conn->insert_id));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}

function update_pharmacy($id) {
    global $conn;

    // Get input data from PUT request
    $data = json_decode(file_get_contents("php://input"), true);

    $name = $data['name'];
    $address = $data['address'];
    $phone_number = $data['phone_number'];
    $email = $data['email'];

    // Update pharmacy data in the database
    $sql = "UPDATE pharmacies
            SET name = '$name', address = '$address', phone_number = '$phone_number', email = '$email'
            WHERE pharmacy_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Pharmacy updated successfully"));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}

function delete_pharmacy($id) {
    global $conn;

    // Delete pharmacy record from the database
    $sql = "DELETE FROM pharmacies WHERE pharmacy_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Pharmacy deleted successfully"));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}
?>