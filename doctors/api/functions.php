<?php
header('Content-Type: application/json'); // Set header to JSON for API responses

// Include database connection
require_once 'dbconnect.php';

// Get the HTTP method of the request
$request_method = $_SERVER['REQUEST_METHOD'];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            getDoctor($_GET['id']);  // Get a specific doctor by ID
        } else {
            getDoctors();  // Get all doctors
        }
        break;

    case 'POST':
        addDoctor();  // Add a new doctor
        break;

    case 'PUT':
        updateDoctor();  // Update a doctor's details
        break;

    case 'DELETE':
        deleteDoctor();  // Delete a doctor by ID
        break;

    default:
        echo json_encode(['message' => 'Invalid request method']);
        break;
}

// Function to get all doctors
function getDoctors()
{
    global $conn;
    $sql = "SELECT * FROM doctors";
    $result = $conn->query($sql);
    $doctors = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $doctors[] = $row;
        }
        echo json_encode($doctors);
    } else {
        echo json_encode(['message' => 'No doctors found']);
    }
}

// Function to get a specific doctor by ID
function getDoctor($id)
{
    global $conn;
    $sql = "SELECT * FROM doctors WHERE doctor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $doctor = $result->fetch_assoc();

    if ($doctor) {
        echo json_encode($doctor);
    } else {
        echo json_encode(['message' => 'Doctor not found']);
    }
}

// Function to add a new doctor
function addDoctor()
{
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true); // Get data from POST body

    if (!empty($data)) {
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $specialization = $data['specialization'];
        $email = $data['email'];
        $phone_number = $data['phone_number'];
        $department = $data['department'];

        $sql = "INSERT INTO doctors (first_name, last_name, specialization, email, phone_number, department)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $first_name, $last_name, $specialization, $email, $phone_number, $department);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Doctor added successfully']);
        } else {
            echo json_encode(['message' => 'Failed to add doctor']);
        }
    } else {
        echo json_encode(['message' => 'Invalid data']);
    }
}

// Function to update a doctor's details
function updateDoctor()
{
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true); // Get data from PUT body

    if (isset($data['doctor_id'])) {
        $doctor_id = $data['doctor_id'];
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $specialization = $data['specialization'];
        $email = $data['email'];
        $phone_number = $data['phone_number'];
        $department = $data['department'];

        $sql = "UPDATE doctors SET first_name = ?, last_name = ?, specialization = ?, email = ?, phone_number = ?, department = ? WHERE doctor_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $first_name, $last_name, $specialization, $email, $phone_number, $department, $doctor_id);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Doctor updated successfully']);
        } else {
            echo json_encode(['message' => 'Failed to update doctor']);
        }
    } else {
        echo json_encode(['message' => 'Doctor ID is required']);
    }
}

// Function to delete a doctor by ID
function deleteDoctor()
{
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true); // Get data from DELETE body

    if (isset($data['doctor_id'])) {
        $doctor_id = $data['doctor_id'];

        $sql = "DELETE FROM doctors WHERE doctor_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $doctor_id);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Doctor deleted successfully']);
        } else {
            echo json_encode(['message' => 'Failed to delete doctor']);
        }
    } else {
        echo json_encode(['message' => 'Doctor ID is required']);
    }
}

$conn->close(); // Close database connection
?>
