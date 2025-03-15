<?php
    session_start();
    include('../include/dbconfig.php');

    if(!isset($_SESSION['user_id'])) {
        header("Locatiion: login.php");
        exit();
    }

    $appointment_id = $_GET['id'];

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $patient_id = $_POST['patient_id'];
        $appointment_date = $_POST['appointment_date'];
        $status = $_POST['status'];
        $doctor_id = $_SESSION['user_id'];

        /* Update the appointment in the database */
        $sql_app = "UPDATE appointments SET patient_id = ?, appointment_date = ?, status = ?
                    WHERE id = ?";
        $stmt = $pdo->prepare($sql_app);
        $stmt->execute([$patient_id, $appointment_date, $status, $appointment_id]);

        header('Location: deal_appointments.php'); /* Redirect to appointments page  */
        exit();
    }

    /* Fetch the existing appointment details */
    $qApp = "SELECT * FROM appointments WHERE id = ?";
    $stmt = $pdo->prepare($qApp);
    $stmt->execute();
    $patient = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset = "UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Appointemnt</title>
    </head>
    <body>
        <h2>Edit Appointment</h2>
        <form>
            <div class="form-group">
                <label for="patient_id">Select Patient: </label>
                <select name="patient_id" required>
                    <?php foreach($patients as $patient): ?>
                        <option value="<?php echo $patient['id']; ?>" <?php if ($patient['id'] == $appointment['patient_id']) echo 'selected'; ?>>
                            <?php echo $patient['first_name'] . ' ' . $patient['last_name']; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="appointment_date">Appointment Date: </label>
                <input type="datetime-local" name="appointment_date" 
                       value="<?php echo date('Y-m-d\TH:i', strtotime($appointment['appointment_date'])); ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status : </label>
                <select name="status" required>
                    <option value="Scheduled" <?php if ($appointment['status'] == 'Scheduled') echo 'Selected'; ?>>Scheduled</option>
                    <option value="Completed" <?php if ($appointment['status'] == 'Completed') echo 'Selected'; ?>>Completed</option>
                    <option value="Canceled" <?php if ($appointment['status'] == 'Canceled') echo 'Selected'; ?>>Cancceled</option>
                </select>
            </div>
            <button type="submit">Update Appointment</button>
        </form>
    </body>
</html>