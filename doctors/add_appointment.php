<?php
    session_start();
    include('../include/dbconfig.php');

    if(!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $patient_id = $_POST['patient_id'];
        $appoint_date = $_POST['appointment_date'];
        $status = $_POST['status'];
        $doctor_id = $_SESSION['user_id'];

        /* Insert the new appointment into the database */
        $sql_app = "INSERT INTO appointments(patient_id, doctor_id, appointment_date, status)
                    VALUES(?, ?, ?, )";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$patient_id, $doctor_id, $appointment_date, $status]);

        header('Location: deal_appointments.php'); /* Redirect to appointments page */
        exit();
    }

    /* Fetch patients for the dropdown */
    $sql_pat = "SELECT patient_id, first_name, last_name FROM patients";
    $stmt = $pdo->prepare($sql_pat);
    $stmt->execute();
    $patients = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width-device-width, intial-scale=1.0">
        <title>Add New Appointment</title>
    </head>
    <body>
        <h2>Add New Appointment</h2>
        <form method="POST">
            <div class="form-group">
                <label for="patient_id">Select Patient: </label>
                <select name="patient_id" required>
                    <?php foreach($patients as $patient): ?>
                        <option value="<?php echo $patient['id']; ?>">
                            <?php echo $patient['first_name'] . ' ' . $patient['last_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="appointment_date">Appointment Date: </label>
                <input type="datetime-local" name="appointment_date" required>
            </div>
            <div class="form-group">
                <select name="status" required>
                    <option value="Scheduled">Scheduled</option>
                    <option value="Completed">Completed</option>
                    <option value="Canceled">Canceled</option>
                </select>
            </div>
            <button type="submit">Save Appointment</button>
        </form>
    </body>
</html>