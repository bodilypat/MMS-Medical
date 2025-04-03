<?php
// Include database connection
include('db_connect.php');

// Fetch all patients
$sql = "SELECT * FROM patients";
$result = $deal->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients List</title>
</head>
<body>
    <h1>Patients List</h1>
    <a href="add_patient.php">Add New Patient</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['patient_id']; ?></td>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['phone_number']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td>
                        <a href="edit_patient.php?id=<?php echo $row['patient_id']; ?>">Edit</a>
                        <a href="delete_patient.php?id=<?php echo $row['patient_id']; ?>" onclick="return confirm('Are you sure you want to delete this patient?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>

<?php
// Close the database connection
$deal->close();
?>