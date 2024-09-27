<?php

    require '../includes/functions.php';

    if(!isset($_GET['id'])){

        header("Location:view-medical_history.php");
        exit();
    }
    
    $history = getMedicalHistory($_GET['id']);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $patient_name = $_POST['patient_name'];
        $date_of_visit = $_POST['date_of_visit'];
        $symptoms = $_POST['symptoms'];
        $diagnosis = $_POST['diagnosis'];
        $treatment = $_POST['treatment'];
        
        if(updateMedicalHistory($history['id'], $patient_name, $date_of_visit, $symptoms, $diagnosis)){
            header("Location: view_medical_history.php");
            exit();
        } else {
            $error = "Failed to update medical history.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Edit Medical History</title>
    </head>
    <body>
        <h2>Edit Medical History</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="post" name="form-mdh">
            <input type="text" name="patient_name" value="<?php echo htmlspecialchars($history['patient_name']); ?>" requried>
            <input type="date" name="date_of_visit" value="<?php echo htmlspecialchars($history['date_of_visit']);?>" required>
            <textarea name="symptoms" required><?php echo htmlspecialchars($history['symptoms']);?></textarea>
            <textarea name="diagnosis" required><?php echo htmlspecialchars($history['diagnosis']);?></textarea>
            <textarea name="treatment" required><?php echo htmlspecialchars($history['treatment']);?></textarea>
            <button type="submit">Update Medical History</button>
        </form>
        <a href="view_medical_history.php">Cancel</a>
    </body>
</html>
