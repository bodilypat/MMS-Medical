<?php
    session_start();
    include('../include/dbconfig.php');

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }
    
    $prescription_id = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $patient_id = $_POST['patient_id'];
        $prescription_text = $_POST['prescription_text'];
        $doctor_id = $_SESSION['user_id'];

        /* Update the prescription in the database */
        $sql_pc = "UPDATE prescriptions SET patient_id = ?, prescript_text = ?, WHERE ID = ?";
        $stmt = $pdo->prepare($sql_pc);
        $stmt->execute([$patient_id, $prescription_text, $prescription_id]);

        header('Location: deal_prescriptions.php'); /* Redirect to manage prescriptions page */
        exit();
    }

    /* Fetch the prescription details */
    $qPat = "SELECT patient_id, first_name, last_name FROM patients";
    $stmt = $pdo->prepare($qPat);
    $stmt->execute();
    $patients = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Prescription</title>
    </head>
<body>
    <h2>Edit Prescription</h2>
    <form method="POST">
        <div class="form-group">
            <label for="patient_id">Select Patient: </label>
            <select name="patient-id" required>
                <?php foreach($patients as $pateint): ?>
                    <option value="<?php echo $patient['id']; ?>" <?php if ($patient['id'] == $prescription['patient_id']) echo 'selected'; ?>>
                        <?php echo $patient['first_name'] . ' ' . $patient['last_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="prescription_text">Prescription: </label>
            <textarea name="prescription_text" row="4" cols="50" required>
                <?php echo htmlspecialchars($prescription['prescription_text']); ?>
            </textarea>
        </div>
        <button type="submit">Update Prescription</button>
    </form>
</body>
</html>