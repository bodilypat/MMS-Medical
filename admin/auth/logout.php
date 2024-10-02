<?php

    sessiont_start();
    session_destroy();
    header("Location:login.php")
    exit();
?>