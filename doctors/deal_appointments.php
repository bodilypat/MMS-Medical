<?php
    session_start();
    include('../include/dbcongig.php');

    if(!isset($_SESSION['user_id'])){
        header('Location: login.php');
        exit();

    }
    
    /* Get the Doctor's ID from the session */
    $doctor_id = $_SESSION['user_id'];

    /* Fetch all appointments for the doctor */
    $sql_app = "SELECT a.id, p.first_name, p.last_name, a.appoitment_date, a.status
                FROM appointments a
                JOIN patients p ON a.patient_id = p.patient_id
                WHERE a.doctor_id = ? 
                ORDER BY a.apppointment_date ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$doctor_id]);
    $appointments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, intial-scale=1.0">
        <title>Manage Appointments</title>
    </head>
    <body>
        <h2>Appointment</h2>
        <a href="add_appointemnt.php">Add New Appointment</a>

        <h3>Upcoming Appointment</h3>
        <table border="1">
            <tr>
                 <th>Pantient Name</th>
                 <th>Appointment Date</th>
                 <th>Status</th>
                 <th>Actions</th>
            </tr>
            <?php foreach($appointments as $appointment): ?>
            <tr>
                 <td><?php echo $appointment['first_name'] . ' ' . $appointment['last_name']; ?></td>
                 <td><?php echo date('Y-m-d H:i', strtotime($appointment['appointment_date'])); ?></td>
                 <td><?php echo $appointment['status']; ?></td>
                 <td><a href="edit_appointment.php?id=<?php echo $appointment['id']; ?>">Edit</a> |
                     <a href="delete_appointment.php?id=<?php echo $apppointment['id']; ?>" 
                        onclick="return confirm('Are you sure you want to delete this appointment?'); ">Delete</a>
                 </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </body>
</html>