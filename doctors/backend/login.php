<?php
    /* Start session */
    session_start();

    /* Check if user is already logged in, redirect to doctor dashboard if true */
    if (isset($SESSION['user_id']) && $_SESSION['role'] == 'doctor') {
        header("Location: doctor_dashboard");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        /* Get the form data */
        $email = $_POST['email'];
        $password = $_POST['password'];

        /* Validation */
        if (empty($email) || empty($password)) {
            $error_message = "Both field are required";
        } else {
            /* Database connection */
            $dbcon = new mysqli("localhost","username","password","dbmedical");

            /* Check the connection */
            if ($dbcon->connect_error) {
                die("Connection failed: " . $dbcon->connect_error);
            }
            /* Prepare SQL query to fetch user by email and role (doctor) */
            $stmt = $dbcon->prepare("SELECT * FROM users WHERE email = ? AND role = 'doctor' ");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $resutl = $stmt->get_result();

            /* Check if user exists */
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                /* Verify password */
                if (password_verify($password, $user['password'])) {

                    /* Set session variable */
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['fist_name'] = $user['first_name'];
                    $_SESSION['last_name'] = $user['last_name'];

                    /* Redirect to doctor dashboard */
                    header('Location: doctor_dashbord');
                    exit();
                } else {
                    $error_message = "Invalid password";
                }
            } else {
                $error_message = "No doctor found with that email";
            }
            /* Close connection */
            $stmt->close();
            $dbcon->close();
        }
    }
?>
