<?php
    
    include ('../includes/functions.php');

      if(!isset($_SESSION['user_id'])) {
        header('Location:login.php');
        exit();
      } else {
        $doctors = getDoctors();
      }
    
    $doctors = getDoctors();
?>
<!DOCTYPE Hhtml>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Doctors List</title>
    </head>
<body>
    <h2>Doctors List</h2>
    <table border="1">
        <tr>
             <th>ID</th>
             <th>Name</th>
             <th>Email</th>
             <th>Specialization</th>
             <th>Phone</th>
             <th>Action</th>
        </tr>
        <?php foreach($doctors as $doctors): ?>
        <tr>
            <td><?php echo htmlspecialchars($doctor['id']);?></td>
            <td><?php echo htmlspecialchars($doctor['name']);?></td>
            <td><?php echo htmlspecialchars($doctor['specialization']);?></td>
            <td><?php echo htmlspecialchars($doctor['phone']);?></td>
            <td>
                <a href="edit_doctor.php?id=<?php echo $doctor['id'];?>">Edit</a>
                <a href="delete_doctor.php?id=<?php echo $doctor['id'];?>" 
                    onClick="return confirm('Are you sure you want to delete this doctor?');">Delete</a>
                <a href="view_doctors.php?id=<?php echo $doctor['id']; ?>">View</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="add_doctor.php">Add New Doctor</a>
</body>
</html>