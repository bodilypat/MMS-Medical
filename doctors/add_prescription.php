<?php
    session_start();
    include('../include/dbconfig.php');

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

    if ($_SESSION["REQUEST_METHOD"] == "POST") {
        $patient_id = $_POST['patient_id'];
        $prescription_text = $_POST['prescription_text'];
        $doctor_id = $_SESSION['user_id'];
        $prescription_date = date('Y-m-d H:i');

        /* Insert the new prescription into the database */
        $sql_pc = "INSERT INTO prescriptions (patient_id, doctor_id, prescription_text, prescription_date)
                   VALUES(?, ?, ?,)";
        $stmt = $pdo->prepare($sql_pc);
        $stmt->execute([$patient_id, $doctor_id, $prescription_text, $prescription_date]);

        header('Location: manage_prescriptions.php'); /* Redirect to manage prescriptions page  */
        exit();
    }

    /* Fetch patients for the dropdown */
    $qPat = "SELECT partient_id, first_name, last_name FROM patients";
    $stmt = $pdo->prepare($qPat);
    $stmt->execute();
    $patients = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset = "UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add New Prescription</title>
    </head>
<body>
    <h2>Add New Prescription</h2>
    <form method="POST">
        <div class="form-group">
            <label for="patient_id">Selec Patient: </label>
            <select name="patient_id">
                <?php foreach($patients as $patient): ?>
                    <option value="<?php echo $patient['id']; ?>"><?php echo $patient['first_name'] . ' ' . $patient['last_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="prescription_text">Prescription: </label>
            <textarea name="prescription_text" rows="50" required></textarea>
        </div>
        <button type="submit">Save Prescription</button>
    </form>
</body>
</html>