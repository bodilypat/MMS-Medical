<?php
    session_start();
    include('../include/dbconnect.php');

    if(!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

    $sql_pat = "SEELCT * FROM patients";
    $stmt = $pdo->prepare($sql_pat);
    $stmt->execute();
    $patients = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage Patients</title>
    </head>
<body>
    <h2>Patients</h2>
    <a href="add_patient.php">Add Patient</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Contact</th>
            <th>Actions</th>
        </tr>
        <?php foreach($patients as $patient) : ?>
        <tr>
            <td><?php echo $patient['id']; ?></td>
            <td><?php echo $patient['first_name'] . ' ' .$patient['last_name']; ?></td>
            <td><?php echo $patient['contact_numbber']; ?></td>
            <td><a href="edit_patient.php?id=<?php echo $patient['id']; ?>">Edit</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>