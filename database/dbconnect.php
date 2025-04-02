<?php
     $servername = "localhost";
     $username = "pacha";
     $password = "";
     $dbname = "dbmedical";

     /* Create connection */
     $deal = new mysqli($servername, $username, $password, $dbname);

     /* Check connection */
     if ($deal->connect_error) {
          die("Connection failed: " . $deal->connect_error);
     }
     echo "Connected successfully";

     /* Close the connection */
     $conn->close();
?>
