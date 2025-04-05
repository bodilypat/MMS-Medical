<?php
header("Content-Type: application/json");

// Include the database connection
include('../dbconnect.php');

// Handle different API methods
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // If an ID is provided, fetch a single doctor
            $id = intval($_GET['id']);
            get_doctor($id);
        } else {
            // Otherwise, fetch all doctors
            get_doctors();
        }
        break;
        
    case 'POST':
        // Create a new doctor
        create_doctor();
        break;

    case 'PUT':
        // Update an existing doctor
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            update_doctor($id);
        }
        break;

    case 'DELETE':
        // Delete a doctor
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            delete_doctor($id);
        }
        break;

    default:
        // Invalid method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_doctors() {
    global $conn;

    $sql = "SELECT * FROM doctors";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $doctors = array();
        while($row = $result->fetch_assoc()) {
            $doctors[] = $row;
        }
        echo json_encode($doctors);
    } else {
        echo json_encode(array("message" => "No doctors found"));
    }
}

function get_doctor($id) {
    global $conn;

    $sql = "SELECT * FROM doctors WHERE doctor_id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $doctor = $result->fetch_assoc();
        echo json_encode($doctor);
    } else {
        echo json_encode(array("message" => "Doctor not found"));
    }
}

function create_doctor() {
    global $conn;

    // Get input data from POST request
    $data = json_decode(file_get_contents("php://input"), true);

    $first_name = $data['first_name'];
    $last_name = $data['last_name'];
    $specialization = $data['specialization'];
    $email = $data['email'];
    $phone_number = $data['phone_number'];
    $department = $data['department'];
    $birthdate = $data['birthdate'];
    $address = $data['address'];
    $status = $data['status'];
    $notes = $data['notes'];

    // Insert data into database
    $sql = "INSERT INTO doctors (first_name, last_name, specialization, email, phone_number, department, birthdate, address, status, notes)
            VALUES ('$first_name', '$last_name', '$specialization', '$email', '$phone_number', '$department', '$birthdate', '$address', '$status', '$notes')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "New doctor created successfully", "doctor_id" => $conn->insert_id));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}

function update_doctor($id) {
    global $conn;

    // Get input data from PUT request
    $data = json_decode(file_get_contents("php://input"), true);

    $first_name = $data['first_name'];
    $last_name = $data['last_name'];
    $specialization = $data['specialization'];
    $email = $data['email'];
    $phone_number = $data['phone_number'];
    $department = $data['department'];
    $birthdate = $data['birthdate'];
    $address = $data['address'];
    $status = $data['status'];
    $notes = $data['notes'];

    // Update doctor data in database
    $sql = "UPDATE doctors 
            SET first_name = '$first_name', last_name = '$last_name', specialization = '$specialization', email = '$email', phone_number = '$phone_number', department = '$department', 
            birthdate = '$birthdate', address = '$address', status = '$status', notes = '$notes'
            WHERE doctor_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Doctor updated successfully"));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}

function delete_doctor($id) {
    global $conn;

    // Delete doctor from database
    $sql = "DELETE FROM doctors WHERE doctor_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Doctor deleted successfully"));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}
?>
