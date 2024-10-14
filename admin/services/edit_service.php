<?php

    include('../includes/functions.php');

    if(!isset($_GET['id'])) {
        header("Location:manage_services.php");
        exit();
    }

    $service = getService($_GET['id']);
    if($_SERVER['REQUEST_METHOD'] =='POST') {
        $description = $_POST['description'];
        $cost = $_POST['cost'];

        if(updateService($_GET['id'],$description, $cost)) {
            header("Location:manage_services.php");
            exit();
        } else {
            $error = "Failed to update service";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit Service</title>
    </head>
    <body>
        <?php if(isset($error)) echo "<p style:'color:red;'>$error</p>"; ?>
        <form method="post" name="form-service">
            <div class="form-group">
                <input type="hidden" name="id" value="<?php $service['id']?>" >
            </div>
            <div class="form-group">
                <label for="Description">Description</label>
                <textarea name="description" class="form-control" required><?php echo $server['description'];?><textarea>
            </div>
            <div class="form-group">
                <label for="Cost">Cost</label>
                <input type="number" name="cost" value="<?php echo $service['cost'];?>" >
            </div>
            <button type="submit" name="update" value="update_service">Update Service</button>
        </form>
        <a href="manage_services.php"></a>
    </body>
</html>