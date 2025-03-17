<?php
    /* Database connection (update with your own credentials) */
    $server = "localhost";
    $username = 'root';
    $password = "";
    $dbname = 'dbmedical';

    /* Create connection */
    $dbcon = new mysqli($servername, $username, $password, $dbname);

    /* Check connection */
    if ($dbcon->connect_error) {
        die("Connection failed" . $dbcon->connect_errot);
    }

    /* Chec if form is submitted */
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        /* Get the POST data form to form */
        $firstName = $dbcon->real_escape_string($_POST['first_name']);
        $lastName = $dbcon->real_escape_string($_POST['last_name']);
        $dob = $dbcon->real_escape_string($_POST['dob']);
        $gender = $dbcon->real_escape_string($_POST['gender']);
        $phone = $dbcon->real_escape_string($_POST['phone']);
        $email = $dbcon->real_escape_string($_POST['email']);
        $address = $dbcon->real_escape_string($_POST['address']);
        $city = $dbcon->real_escape_string($_POST['city']);
        $state = $dbcon->real_escape_string($_POST['state']);
        $zipcode = $dbcon->real_escape_string($_POST['zipcode']);
        $allergies = isset($_POST['allergies']) ? $dbcon->real_escape_string($_POST['allergies']) : null;
        $medications = isset($_POST['medications']) ? $dbcon->real_escape_string($_POST['medications']) : null;
        $previousConditions = isset($_POST['previous_conditions']) ? $dbcon->real_escape_string($_POST['previous_condition']) : null;
        $emergencyName = $dbcon->real_escape_string($_POST['emergency_name']);
        $emergencyPhone = $dbcon->real_escape_string($_POST['emargency_phone']);
        $insuranceProvider = isset($_POST['insurance_provider']) ? $dbcon->real_escape_string($_POST['insurance_provider']) : null;
        $policyNumber = isset($_POST['policy_number']) ? $dbcon->real_escape_string($_POST['policy_number']) : null;
    }

    /* Basic validation  */
    if (empty(firstName) || empty($lastName) || empty($dob) || empty($phone) || empty($email) || empty($address) || empty($city) || empty($state) || empty($zipcode) || empty($emergencyName) || empty($emergencyPhone)) {
        echo "Please fill in all required fileds.";
        exit;
    }

    /* Insert patient data into the database */
        $sql = "INSERT INTO patients (first_name, last_name, dob, gender, phone, email, address, city, state, zipcode, allergies, medications, previous_conditions, emergency_name, emergency_phone, insurance_provider, policy_number)
                VALUES('$firstName','$lastName','$dob','$gender','$phone','$email','$address','$city','$state','$zipcode','$allergies','$medicattions','$previousConditions','$emergencyName',$emergencyPhone','$insuranceProvider','$policyNumber)";

        if ($dbcon->query($sql) === TRUE) {
            echo "New patient registered successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $dbcon->error;
        } 
    } else {
        echo "Invalid request.";
    }
    /* Close the database connection */
