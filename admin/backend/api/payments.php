<?php
header("Content-Type: application/json");

// Include the database connection
include('../dbconnect.php');

// Handle different API methods
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // If an ID is provided, fetch a specific payment record
            $id = intval($_GET['id']);
            get_payment($id);
        } else {
            // Otherwise, fetch all payment records
            get_payments();
        }
        break;

    case 'POST':
        // Create a new payment record
        create_payment();
        break;

    case 'PUT':
        // Update an existing payment record
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            update_payment($id);
        }
        break;

    case 'DELETE':
        // Delete a payment record
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            delete_payment($id);
        }
        break;

    default:
        // Invalid method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_payments() {
    global $conn;

    $sql = "SELECT * FROM payments";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $payments = array();
        while ($row = $result->fetch_assoc()) {
            $payments[] = $row;
        }
        echo json_encode($payments);
    } else {
        echo json_encode(array("message" => "No payments found"));
    }
}

function get_payment($id) {
    global $conn;

    $sql = "SELECT * FROM payments WHERE billing_id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $payment = $result->fetch_assoc();
        echo json_encode($payment);
    } else {
        echo json_encode(array("message" => "Payment not found"));
    }
}

function create_payment() {
    global $conn;

    // Get input data from POST request
    $data = json_decode(file_get_contents("php://input"), true);

    $patient_id = $data['patient_id'];
    $appointment_id = $data['appointment_id'];
    $total_amount = $data['total_amount'];
    $amount_paid = $data['amount_paid'];
    $balance_due = $data['balance_due'];
    $payment_status = $data['payment_status'];
    $insurance_claimed_amount = isset($data['insurance_claimed_amount']) ? $data['insurance_claimed_amount'] : NULL;
    $insurance_status = isset($data['insurance_status']) ? $data['insurance_status'] : NULL;

    // Insert data into the database
    $sql = "INSERT INTO payments (patient_id, appointment_id, total_amount, amount_paid, balance_due, payment_status, insurance_claimed_amount, insurance_status)
            VALUES ('$patient_id', '$appointment_id', '$total_amount', '$amount_paid', '$balance_due', '$payment_status', '$insurance_claimed_amount', '$insurance_status')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "New payment created successfully", "billing_id" => $conn->insert_id));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}

function update_payment($id) {
    global $conn;

    // Get input data from PUT request
    $data = json_decode(file_get_contents("php://input"), true);

    $total_amount = $data['total_amount'];
    $amount_paid = $data['amount_paid'];
    $balance_due = $data['balance_due'];
    $payment_status = $data['payment_status'];
    $insurance_claimed_amount = isset($data['insurance_claimed_amount']) ? $data['insurance_claimed_amount'] : NULL;
    $insurance_status = isset($data['insurance_status']) ? $data['insurance_status'] : NULL;

    // Update payment data in the database
    $sql = "UPDATE payments
            SET total_amount = '$total_amount', amount_paid = '$amount_paid', balance_due = '$balance_due', payment_status = '$payment_status',
                insurance_claimed_amount = '$insurance_claimed_amount', insurance_status = '$insurance_status'
            WHERE billing_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Payment updated successfully"));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}

function delete_payment($id) {
    global $conn;

    // Delete payment record from the database
    $sql = "DELETE FROM payments WHERE billing_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Payment deleted successfully"));
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }
}
?>