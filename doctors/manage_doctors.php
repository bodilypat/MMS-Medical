<?php
	include('dbconnect.php');

	// Fetch all doctors from the database
	$qDoctor = "SELECT * FROM doctors";
	$result = $deal->query($qDoctor);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors List</title>
</head>
<body>
    <h1>Doctors List</h1>
    <a href="add_doctor.php">Add New Doctor</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
				<th>Name</th>
				<th>Specialization</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Department</th>
				<th>Status</th>
				<th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($doctor = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $doctor['doctor_id']; ?></td>
					<td><?php echo $doctor['first_name'] . " " . $doctor['last_name']; ?></td>
                    <td><?php echo $doctor['specialization']; ?></td>
                    <td><?php echo $doctor['email']; ?></td>
                    <td><?php echo $doctor['phone_number']; ?></td>
					<td><?php echo $doctor['department']; ?></td>
					<td><?php echo $doctor['status']; ?></td>
                    <td>
                        <a href="edit_doctor.php?id=<?php echo $doctor['doctor_id']; ?>">Edit</a> |
                        <a href="delete_doctor.php?id=<?php echo $doctor['doctor_id']; ?>" onclick="return confirm('Are you sure you want to delete this doctor?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; } ?>
        </tbody>
    </table>
</body>
</html>

<?php $deal->close(); ?>