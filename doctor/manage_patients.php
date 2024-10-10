<?php

    include ('../includes/functions.php');

      if(!isset($_SESSION['user_id'])) {
        header('Location:login.php');
        exit();
      } else {
        $patients = getPatients();
      }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Patients</title>
    </head>
    <body>
        <h1>Registered Patients<h1>
    </body>
    <table>
        <thead>
              <tr>
                   <th>Name</th>
                   <th>Email</th>
                   <th>Date of Birth</th>
                   <th>Gender</th>
                   <th>Address</th>
                   <th>Medical History</th>
                   <th>Actions</th>
              </tr>
        </thead>
        <tbody>
            <?php foreach($patients as $patient): ?>
              <tr>
                   <td><?php echo htmlspecialchars($patient['name']);?></td>
                   <td><?php echo htmlspecialchars($patient['email'];);?></td>
                   <td><?php echo htmlspecialchars($patient['date_of_birth']);?></td>
                   <td><?php echo htmlspecialchars($patient['gender']);?></td>
                   <td><?php echo htmlspecialchars($patient['phone']);?></td>
                   <td><?php echo htmlspecialchars($patient['address']);?></td>
                   <td><?php echo htmlspecialchars($patient['medical_history']);?></td>
                   <td>
                        <a href="update_patient.php?id=<?php echo $patient['id']; ?>">Edit</a>
                        <a href="delete_patient.php?id=<?php echo $patient['id'];?>" onClick="return confirm('Are you sure you want to delete this patients?');">Delete</a>
                        <a href="view_patients.php?id=<?php echo $patient['id']; ?>">View</a>
                   </td>
              </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</html>