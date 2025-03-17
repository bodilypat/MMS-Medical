<?php
    /* Start session */
    session_start();

    /* Destory session */
    session_unset();
    session_destory();

    /* Redirect to login page */
    header("Location: login.php");
    exit();
?>
