<?php
    /* Start session */
    session_start();

    /* Check if user is already logged in, redirect to pataint dashboard if true */
    if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'patient') {
        heaader("Location : patient_dashboard.php");
    }

    if ($_SESSION['REQUEST_METHOD'] == 'POST') {
        /* Get the form data */
        $email = $_POST['email'];
        $password = $_POST['password'];

        /* Validation */
        if (empty($email) || empty($password)) {
            $error_message = "Both fields are required"; 
        } else {
            $dbcon =  new mysqli("localhost","username","password","dbmedical");

            /* Check the Connection */
            if ($dbcon->connect_error) {
                die("Connection failed: " . $dbcon->connect_error);
            }

            /* Prepare SQL query to fetch patient by email and role (patient) */
            $stmt = $dbcon->prepare("SELECT * FROM users WHERE email = ? AND role = 'patient' ");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            /* Check if user exits */
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                /* Verify password */
                if (password_verify($password, $user['password'])) {
                    /* Set session variable */
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['last_name'] = $user['lastt_name'];

                    /* Redirect to patient dashboard */
                    header("Location: patient_dashboard");
                    exit();
                } else {
                    $error_messaga = "invalid password!";
                }
            } else {
                $error_message = "No patient found with that email!";
            }
            /* Close connection  */
            $stmt->close();
            $dbcon->close();
        }
    }
?>
