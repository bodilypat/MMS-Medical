<?php
    function check_login()
    {
        if(strlen($_SESSION['logi'])==0)
        {
            $host = $_SERVE['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $extra = '../admin.php';
            $_SESSION['login']="";
            header("Location: http://$host$uri/$extra");
        }
    }