<?php

    include('../includes/functions.php');

    if($_SERVER['REQUEST_METHOD'] =='POST') {
        $description = $_POST['description'];
        $cost = $_POST['cost'];

        if(addService($description, $cost)) {
            header("Location:manage_services.php");
            exit();
        } else {
            $error = "Failed to add service";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add Service</title>
    </head>
    <body>
        <h2>Add Service</h2>
        <?php if(isset($error)) echo "<p style='color:red; '>$error</p>"; ?>
        <form method="post" name="form-service">
            <div class="form-group">
                <label for="Description">Description</label>
                <textarea name="description" class="form-control" placeholder="Description" required></textarea>
            </div>
            <div class="form-group">
                <label for="Cost">Cost</label>
                <input type="number" name="cost" class="form-control" placeholder="Cost" required>
            </div>
            <button type="submit" name="add" value="add service">Add Service</button>
        </form>
        <a href="manage_services.php"></a>
    </body>
</html>
