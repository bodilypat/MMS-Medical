<?php
header('Content-Type: application/json');
include 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['appointment_id'])) {
            getAppointment($pdo, $_GET['appointment_id']);
        } else {
            getAppointments($pdo);
        }
        break;
    case 'POST':
        createAppointment($pdo);
        break;
    case 'PUT':
        updateAppointment($pdo);
        break;
    case 'DELETE':
        deleteAppointment($pdo);
        break;
    default:
        echo json_encode(['message' => 'Method Not Allowed']);
        break;
}

function getAppointments($pdo) {
    $stmt = $pdo->query('SELECT * FROM appointments');
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($appointments);
}

function getAppointment($pdo, $appointment_id) {
    $stmt = $pdo->prepare('SELECT * FROM appointments WHERE appointment_id = :appointment_id');
    $stmt->execute(['appointment_id' => $appointment_id]);
    $appointment = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($appointment) {
        echo json_encode($appointment);
    } else {
        echo json_encode(['message' => 'Appointment not found']);
    }
}

function createAppointment($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Validate input data
    if (!isset($data['patient_id']) || !isset($data['doctor_id']) || !isset($data['appointment_date'])) {
        echo json_encode(['message' => 'Missing required fields']);
        return;
    }

    // Validate the appointment date (it must be in the future)
    if (strtotime($data['appointment_date']) < time()) {
        echo json_encode(['message' => 'Appointment date must be in the future']);
        return;
    }

    // Check if the patient and doctor exist
    $stmt = $pdo->prepare('SELECT * FROM patients WHERE patient_id = :patient_id');
    $stmt->execute(['patient_id' => $data['patient_id']]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare('SELECT * FROM doctors WHERE doctor_id = :doctor_id');
    $stmt->execute(['doctor_id' => $data['doctor_id']]);
    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$patient) {
        echo json_encode(['message' => 'Patient not found']);
        return;
    }

    if (!$doctor) {
        echo json_encode(['message' => 'Doctor not found']);
        return;
    }

    // Insert appointment into database
    $stmt = $pdo->prepare('
        INSERT INTO appointments (patient_id, doctor_id, appointment_date, reason_for_visit, status, duration, appointment_type, notes)
        VALUES (:patient_id, :doctor_id, :appointment_date, :reason_for_visit, :status, :duration, :appointment_type, :notes)
    ');

    $stmt->execute([
        'patient_id' => $data['patient_id'],
        'doctor_id' => $data['doctor_id'],
        'appointment_date' => $data['appointment_date'],
        'reason_for_visit' => $data['reason_for_visit'] ?? null,
        'status' => $data['status'] ?? 'Scheduled',
        'duration' => $data['duration'] ?? 30, // Default duration is 30 minutes
        'appointment_type' => $data['appointment_type'] ?? 'In-Person',
        'notes' => $data['notes'] ?? null
    ]);

    echo json_encode(['message' => 'Appointment created successfully']);
}

function updateAppointment($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['appointment_id'])) {
        echo json_encode(['message' => 'Appointment ID is required']);
        return;
    }

    $stmt = $pdo->prepare('SELECT * FROM appointments WHERE appointment_id = :appointment_id');
    $stmt->execute(['appointment_id' => $data['appointment_id']]);
    $appointment = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$appointment) {
        echo json_encode(['message' => 'Appointment not found']);
        return;
    }

    // Update appointment details
    $stmt = $pdo->prepare('
        UPDATE appointments 
        SET patient_id = :patient_id, doctor_id = :doctor_id, appointment_date = :appointment_date, 
            reason_for_visit = :reason_for_visit, status = :status, duration = :duration, 
            appointment_type = :appointment_type, notes = :notes, updated_at = CURRENT_TIMESTAMP
        WHERE appointment_id = :appointment_id
    ');

    $stmt->execute([
        'patient_id' => $data['patient_id'] ?? $appointment['patient_id'],
        'doctor_id' => $data['doctor_id'] ?? $appointment['doctor_id'],
        'appointment_date' => $data['appointment_date'] ?? $appointment['appointment_date'],
        'reason_for_visit' => $data['reason_for_visit'] ?? $appointment['reason_for_visit'],
        'status' => $data['status'] ?? $appointment['status'],
        'duration' => $data['duration'] ?? $appointment['duration'],
        'appointment_type' => $data['appointment_type'] ?? $appointment['appointment_type'],
        'notes' => $data['notes'] ?? $appointment['notes'],
        'appointment_id' => $data['appointment_id']
    ]);

    echo json_encode(['message' => 'Appointment updated successfully']);
}

function deleteAppointment($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['appointment_id'])) {
        echo json_encode(['message' => 'Appointment ID is required']);
        return;
    }

    $stmt = $pdo->prepare('SELECT * FROM appointments WHERE appointment_id = :appointment_id');
    $stmt->execute(['appointment_id' => $data['appointment_id']]);
    $appointment = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$appointment) {
        echo json_encode(['message' => 'Appointment not found']);
        return;
    }

    $stmt = $pdo->prepare('DELETE FROM appointments WHERE appointment_id = :appointment_id');
    $stmt->execute(['appointment_id' => $data['appointment_id']]);

    echo json_encode(['message' => 'Appointment deleted successfully']);
}
?>