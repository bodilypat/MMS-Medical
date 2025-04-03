<?php

/* Include database connect */
include('dbconnect.php');

/* Check if ID is set and delete the doctor */
if (isset($_GET['id'])) {
    $doctor_id = $_GET['id'];
	
	/* Delete query */
    $sql = "DELETE FROM doctors WHERE doctor_id = $doctor_id";

    if ($deal->query($sql) === TRUE) {
        echo "Doctor deleted successfully!";
        header("Location: doctor_list.php"); // Redirect to the doctors list
		exit();
    } else {
        echo "Error: " . $deal->error;
    }
}

$deal->close();
?>