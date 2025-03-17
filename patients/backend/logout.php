<?php
    /* Start session */
    session_start();

    /* Destory session */
    session_unset();
    session_destroy();

    /* Redirect to login page */
    header("Location: patient_login.php");
    exit();
?>
