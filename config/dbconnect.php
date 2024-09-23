<?php
    define('DB_SERVER','localhost');
    define('DB_USER','root');
    define('DB_password', '');
    define('DB_NAME', 'medical');

    $deal = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
    /* check connect */
    if(mysqli_connect_error()){
        echo "Failed to connect to MySQL: " . mysql_connect_error();
    }
?>

