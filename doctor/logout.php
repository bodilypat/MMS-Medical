<?php
    session_start();
    include('../include/dbconnect.php');

    /* Correct the session variable assignment  */
    $_SESSION['login'] = "";

    /* set the timezone for correct date/time */
    date_default_timeone_set('America/Monterrey');
    $ldate = date('d-m-Y: h:i:s A', time()); /* Get current logout date and time */
    $did = $_SESSION['id']; /* Get the user id from session */

    /* Ensure the session is valid and the doctor ID is set before executing the query */
    if(isset($did) && !empty($did)) {

        /* update the logout in the database for the current doctor user */
        $qDlog = "UPDATE doctorslog SET logout = '$ldate' WHERE uid = '$did' ORDER BY id DESC LIMIT 1";
        mysqli_query($deal, $qDlog)
    }

    /* Clear all session variable */
    session_unset();

    /* Destroy the session completely (remove all session data) */
    session_destroy();

    /* Set a logout message to inform the user */
    $_SESSION['errmsg'] = "You have successfully logged out.";

    /* Redirect the user to the home page after logout */
    echo "<script type='text/javascript'>
        window.location.href='../index.php'; 
        </script>";
?>
