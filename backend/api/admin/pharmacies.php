<?php
header('Content-Type: application/json');
include 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        isset($_GET['pharmacy_id']) ? getPharmacy($pdo, $_GET['pharmacy_id']) : getAllPharmacies($pdo);
        break;
    case 'POST':
        createPharmacy($pdo);
        break;
    case 'PUT':
        updatePharmacy($pdo);
        break;
    case 'DELETE':
        deletePharmacy($pdo);
        break;
    default:
        echo json_encode(['message' => 'Unsupported HTTP method']);
        break;
}

//  GET All Pharmacies
function getAllPharmacies($pdo) {
    $stmt = $pdo->query('SELECT * FROM pharmacies');
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

//  GET One Pharmacy
function getPharmacy($pdo, $id) {
    $stmt = $pdo->prepare('SELECT * FROM pharmacies WHERE pharmacy_id = :id');
    $stmt->execute(['id' => $id]);
    $pharmacy = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $pharmacy ? json_encode($pharmacy) : json_encode(['message' => 'Pharmacy not found']);
}

//  CREATE Pharmacy
function createPharmacy($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);

    // Validation
    $required = ['name', 'address', 'phone_number', 'email'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            echo json_encode(['message' => "$field is required"]);
            return;
        }
    }

    if (!preg_match('/^[0-9]+$/', $data['phone_number'])) {
        echo json_encode(['message' => 'Phone number must be numeric only']);
        return;
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO pharmacies (name, address, phone_number, email)
            VALUES (:name, :address, :phone_number, :email)
        ");
        $stmt->execute([
            'name' => $data['name'],
            'address' => $data['address'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email']
        ]);
        echo json_encode(['message' => 'Pharmacy created successfully']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Insert failed: ' . $e->getMessage()]);
    }
}

//  UPDATE Pharmacy
function updatePharmacy($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (empty($data['pharmacy_id'])) {
        echo json_encode(['message' => 'pharmacy_id is required']);
        return;
    }

    $stmt = $pdo->prepare('SELECT * FROM pharmacies WHERE pharmacy_id = :id');
    $stmt->execute(['id' => $data['pharmacy_id']]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existing) {
        echo json_encode(['message' => 'Pharmacy not found']);
        return;
    }

    if (!empty($data['phone_number']) && !preg_match('/^[0-9]+$/', $data['phone_number'])) {
        echo json_encode(['message' => 'Phone number must be numeric only']);
        return;
    }

    try {
        $stmt = $pdo->prepare('
            UPDATE pharmacies SET 
                name = :name,
                address = :address,
                phone_number = :phone_number,
                email = :email,
                updated_at = CURRENT_TIMESTAMP
            WHERE pharmacy_id = :id
        ');
        $stmt->execute([
            'name' => $data['name'] ?? $existing['name'],
            'address' => $data['address'] ?? $existing['address'],
            'phone_number' => $data['phone_number'] ?? $existing['phone_number'],
            'email' => $data['email'] ?? $existing['email'],
            'id' => $data['pharmacy_id']
        ]);
        echo json_encode(['message' => 'Pharmacy updated successfully']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Update failed: ' . $e->getMessage()]);
    }
}

//  DELETE Pharmacy
function deletePharmacy($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (empty($data['pharmacy_id'])) {
        echo json_encode(['message' => 'pharmacy_id is required']);
        return;
    }

    $stmt = $pdo->prepare('SELECT 1 FROM pharmacies WHERE pharmacy_id = :id');
    $stmt->execute(['id' => $data['pharmacy_id']]);
    if (!$stmt->fetch()) {
        echo json_encode(['message' => 'Pharmacy not found']);
        return;
    }

    $stmt = $pdo->prepare('DELETE FROM pharmacies WHERE pharmacy_id = :id');
    $stmt->execute(['id' => $data['pharmacy_id']]);
    echo json_encode(['message' => 'Pharmacy deleted successfully']);
}
?>