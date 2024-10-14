<?php

    include('../includes/functions.php');

    $services = getServices();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charet="UTF-8">
        <title>Service list</title>
    </head>
    <body>
        <h2>Service list</h2>
        <table border="1" name="service-table">
            <thead>
                <tr>
                      <th>ID</th>
                      <th>Description</th>
                      <th>Cost</th>
                      <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($services as $service): ?>
                <tr>
                     <td><?php echo $service['id'];?></td>
                     <td><textarea name="description class="form-control"><?php echo  htmlspecialchars($service['descrption']);?></textarea></td>
                     <td><?php echo htmlspecialchars($service['cost']);?></td>
                     <td>
                        <a href="edit_service.php?id=<?php echo $service['d'];?>">Edit</a>||
                        <a href="deleteService.php?id=<?php echo $service['id'];?>" 
                           onClick="Confirm('Are you sure you want to delete this service?');">Delete</a>
                     </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </form>
        <a href="add_billing.php">Add New Service</a>
    </body>
</html>