<?php
    session_start();
    include('../include/dbconfig.php');

    if(!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

    /* Get the doctor's ID from the session */
    $doctor_id = $_SESSION['user_id'];

    /* Fetch all prescriptions for the doctor */
    $qpc = "SELECT pc.prescription_id, p.first_name, p.last_name, ps.prescription_text, pc.prescript_date
             FROM prescriptions pc
             JOIN patients p ON p.patient_id = p.patient_id 
             WHERE p.doctor_id = ?
             ORDER BY pc.prescription_date DESC ";
    $stmt = $pdo->prepare($qpc);
    $stmt->execute([$doctor_id]);
    $prescriptions = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset= "utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage Prescriptions</title>
    </head>
    <body>
        <h2>Manage Prescriptions</h2>
        <a href="add_prescription.php">Add New Prescription</a>
        <h3>Prescriptions List</h3>
        <table border="1">
            <tr>
                 <th>Patient Name</th>
                 <th>Prescription Date</th>
                 <th>Prescription Text</th>
                 <th>Actions</th>
            </tr>
            <?php foreach($prescriptions as $prescription): ?>
            <tr>
                 <td><?php echo $prescription['first_name'] . ' ' . $prescription['last_name']; ?></td>
                 <td><?php echo date('Y-m-d H:i', strtotime($prescription['prescription_date'])); ?></td>
                 <td><?php echo $prescription['prescription_text']; ?></td>
                 <td>
                      <a href="edit_prescription.php?id=<?php echo $prescription['prescription_id']; ?>">Edit</a> |
                      <a href="delete_prescription.php?id=<?php echo $prescription['prescription_id']; ?>" 
                         onclick="return confirm('Are you sure you want to delete this prescription?');">Delete</a>
                 </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </body>
</html>