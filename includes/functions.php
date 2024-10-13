<?php
    session_start();
    
    require 'dbconnect.php';

    /*  Function manage Auth */

    function register($username, $email, $password, $role){
        $pdo = dbconnect();

        /* hash the password */
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        /* Prepare the SQL statement */
        $stmt = $pdo->prepare("INSERT INTO users(username,email,password,role) VALUES(?,?,?,?)");

        /* Execute and check for success */
        if ($stmt->execute($username, $email, $hashedPassword,$role)){
            return "User registered successfully!";
        } else {
            return "Error: Could not register user";
        }
    }
    
    function login($username, $password){
        $pdo = dbconnect();

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stm->execute([$username]);
        $user= $stmt->fetch();

        if($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            return "login successfull! Welcome," . htmlspecialchars($username) . "!";

        } else{
        /* Invalid credential */
            return "Invalid username or password";
        }
    }

    function requestPasswordReset($email) {
        $pdo = dbconnect();

        /* check email exists */
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? ");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user) {
            /* Generaate a unique reset token */
            $token = bin2hex(random_bytes(50));
            $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

            /* update user record with the token and expiration time */
            $stmt = $pdo->prepare("UPDATE users SET reset_token  = ? , reset_expires = ? WHERE email = ? ");
            $stmt->execute([$token, $expires->format('Y-m-d H:i:s'), $email]);

            /* Send email with the reset link */

            $resetLink = "http://mdhcare.com/reset_password.php?token=" . $token;
            $subject = "Password Reset Request";
            $message ="Click the link to reset your password: " . $resetLink;
            mail($email, $subject, $message);

            return "Password reset link has been sent to your email..";
        } else {
            return "No user found that email address.";
        }
    }

    function resetPassword($token, $newPassword){
        $pdo = dbconnect();

        /* validate to token */
        $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ? and token_expiry > NOW()");
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user){
            /* Update the password and clearr the reset toke */
            $hashedPassword = password_hash($newPassword,PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expiry = NULL WHERE id = ?");
            $stmt->execute([$hashedPassword, $user['id']]);

            return "Your password has been reset successfully!";
        } else {
            return "Invalid or expired token.";
        }
    }

    function isloggedIn(){
        return isset($_SESSION['user_id']);
    }

    function logout() {
        session_start();
        session_destroy();
        header("Location: login.php");
        exit();
    }

    /* Function manage Doctor */
    function addDoctor($name, $email, $specialization, $phone) {
        $pdo = dbconnect();
        $stmt = $pdo->prepare("INSERT INTO doctors(name, email, specialization, phone) VALUES(?,?,?,?)");
        return $stmt->execute([$name,$mail,$specialization, $phone]);
    }

    function getDoctors(){
        $pdo = dbconnect();
        $stmt = $pdo->prepare("SELECT * FROM doctors");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getDoctor($id){
        $pdo = dbconnect();
        $stmt = $pdo->prepare("SELECT * FROM doctors WHERE id = ? ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSC);
    }

    function updateDoctor($id, $name, $email, $specialization, $phone){
        $pdo = dbconnect();
        $stmt = $pdo->prepare("UPDATE doctors SET name = ? , email = ?, specialization = ?, phone = ?  WHERE id = ? ");
        return $stmt->execute([$name, $email,$specialization, $phone, $id])
    }

    function listDoctors() {
        $pdo = dbconnect();
        $stmt = $pdo->query("SELECT * FROM doctors");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function searchDoctors(){
        $pdo = dbconnect();
        $stmt = $pdo->query("SELECT * FROM doctors
                             WHERE name LIKE ? OR speicalialty LIKE ?");;
        $stmt->execute(['%' . $keyword . '%', '%' . $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function deleteDoctor($id){
        $pdo = dbconnect();
        $stmt = $pdo->prepare("DELETE FROM doctors WHERE id = ? ");
        return $stmt->execute([$id]);
    }

    /* Function manage Patients */
    function addPatient($name, $email, $date_of_birth, $gender, $phone, $address) {
        $pdo = dbconnect();
        $stmt = $pdo->prepare("INSERT INTO patients(name, email, date_of_birth, gender, phone, address) VALUES(?, ?, ?, ?,?) ");
        return $stmt->execute([$name, $email, $date_of_birth, $gender, $phone, $address]);
    }

    function getPatients(){
        $pdo = dbconnect();
        $stmt = $pdo->query("SELECT * FROM patients");
        return $stmt->execute(PDO::FETCH_ASSOC);
    }

    function getPatient($id) {
        $pdo = dbconnect();
        $stmt = $stmt->prepare("SELECT * FROM patients WHERE id = ?");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    function updatePatient($id, $name, $email, $date_of_birth, $gender, $phone, $address){
        $pdo = dbconnect();
        $stmt = $pdo->prepare("UPDATE patients SET name = ?, email = ?, date_of_birth = ?, gender = ?, phone = ?, address = ? WHERE id = ? ");
        return $stmt->execute([$name, $email, $date_of_birth, $gender, $phone, $address, $id]);
    }

    function listPatients(){
        $pdo = dbconnect();
        $stmt = $pdo->query("SELECT * FROM patients");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function searchPatient($keyword){
        $pdo = dbconnect();
        $stmt = $pdo->prepare("SELECT * FROM patients WHERE name LIKE ? ");
        $stmt->execute(['%' . $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function deletePatient($id){
        $pdo = dbconnect();
        $stmt = $stmt->prepare("DELETE FROM patients WHERE id = ? ");
        return $stmt->execute([$id])
    }

    /* Function mange Appontments */
    function addAppointment($patient_id, $doctor_id, $appointment_date, $status, $notes){
        $pdo = dbconnect();
        $stmt = $pdo->prepare("INSERT INTO appointments(patient_id, doctor_id, appointment_date,status, notes ) VALUES(?, ?, ?, ?, ?)");
        return $stmt->execute([$patient_id, $doctor_id, $appointment_date, $status, $notes]);
    }

    function getAppointmentById($id) {
        $pdo = dbconnect();
        $sql = $pdo->query("SELECT appointments.id,
                                    patients.name as patient_name,
                                    doctors.name as doctor_name,
                             FROM appointments 
                             JOIN patients ON appointments.patient_id = patients.id
                             JOIN doctors  ON appointments.doctor_id = doctors.id
                             WHERE id = ? ");
        $stmt->execute($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getAppointments() {
        $pdo = dbconnect();
        $sql = $pdo->query("SELECT appointments.id,
                                   patients.name as patient_name,
                                   doctors.name as patient_name,
                                   appointments.appointment_date,
                                   appointments.status,
                                   appointments.notes
                              FROM appointments 
                              JOIN patients  ON appointments.patient_id = patients.id 
                              JOIN doctors ON apointments.doctors_id = doctors.id
                              ORDER BY appointments.appointment_date ASC");

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam('doctor_id' => $doctor_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function updateAppointment($appointment_id, $patient_id, $doctor_id, $appointment_date, $status, $notes){
        $pdo = dbconnect();
        $stm = $pdo->prepare("UPDATE appointments SET patient_id = ? , doctor_id = ?, appointment_date = ? , status = ?, notes = ? WHERE id = ?");
        return $stmt->execute([$patient_id, $doctor_id, $appointment_date, $status, $notes, $appointment_id]);
    }

    function searchAppointment($keyword){
        $pdo = dbconnect();
        $stmt = $pdo->prepare(" SELECT * FROM appointments 
                                WHERE patient_id IN(SELECT id FROM patients WHERE name LIKE ?)
                                OR doctor_id IN(SELECT id FROM doctors WHERE name LIKE ?) ");
        $stmt->execute(['%' . $keyword . '%' , '%' $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function deleteAppointment($appointment_id){
        $pdo = dbconnect();
        $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = ? ");
        return $stmt->execute([$appintment_id]);
    }

    /* Function Manage Prescription */
    function addPrescription ($patient_id, $medic_id, $instructions, $instructions, $dosage, $start_date, $end_date){
        $pdo = dbconnect();
        $stmt = $pdo->prepare("INSERT INTO prescriptions(patient_id, medical_record_id, medication, instructions,dosage, start_date, end_date) VALUES(?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$patient_id, $doctor_id, $medication, $dosage, $instructions, $start_date, $end_date]);
    }

    function getPrescriptions() {
        $pdo = dbconnect();
        $stmt = $pdo->query("SELECT prescriptions.id, patients.name as patient_name, 
                                    medical_records.name as medical_record_name, 
                                    prescriptions.dosage, 
                                    prescriptions.start_date,
                                    prescriptions.end_date
                             FROM prescriptions 
                             JOIN patients ON prescriptions.patient_id = patients.id 
                             JOIN doctors  ON prescriptions.doctors_id = doctors.id 
                             ORDER BY id ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getPrescription($id){
        $pdo = dbconenct();
        $stmt = $pdo->query("SELECT prescriptions.id ,
                                    patients.name as patient_name,
                                    medical_records.name  as doctor_name,
                                    prescriptions.instructions,
                                    prescriptions.dosage,
                                    prescriptions.start_date,
                                    prescription.end_date,                                    
                             FROM prescriptions 
                             JOIN patient ON prescriptions.patient_id = patients.id 
                             JOIN doctors ON prescript.doctor_id = doctors.id 
                             WHERE id = ? ");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function updatePrescription($id, $patient_id, $medical_record_id, $medication, $instruction, $instruction, $start_date, $end_date){
        $pdo = dbconnect();
        $stmt = $pdo->prepare("UPDATE prescriptions SET  patient_id = ?, 
                                                         medical_record = ?,
                                                         medication = ?, 
                                                         instructions = ?,
                                                         dasage = ?, 
                                                         start_date = ?, 
                                                         end_date = ? 
                                                    WHERE id = ? ");
        return $stmt->execute([$patient_id, $mecation_record_id, $medication, $instructions, $dosage, $start_date, $end_date, $id]);
    }

    function searchPrescriptions($keyword){
        $pdo = dbconnect();
        $stmt = $pdo->prepare("SELECT  *
                               FROM prescriptions 
                               WHERE patient_id (SELECT id FROM  patients WHERE name LIKE ?)
                               OR doctor_id IN (SELECT id FROM doctors WHERE name LIKE ?)");
        $stmt->execute(['%' . $keyword . '%', '%' . $keyword . '%']);
        return $stmt->fetall(PDO::FETCH_ASSOC);
    }

    function listPrescriptions(){
        $pdo = dbconnect();
        $stmt = $pdo->query("SELECT * FROM Prescriptions");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function searchPrescription($keyword){
        $pdo = dbconnect();
        $stmt = $pdo->prepare("SELECT * FROM prescriptions
                               WHERE medication LIKE ?
                               OR patient_id IN (SELECT ID FROM patient WHERE nam like ?)" );
        $stmt->execute(['%' . $keyword . '%', '%' . $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function deletePrescription($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM prescriptions WHERE id = ? ");
        return $stmt->execute([$id]);
    }

    /* Function manage Medical_recrods */

    function addMedicalRecord($patient_id, $doctor_id, $record_date, $symtoms, $diagnosis, $treatment){
        $pdo = dbconnect();
        $stmt = $pdo->prepare("INSERT INTO medical_history(patient_id, doctors_id, record_date, symptoms, diagnosis, treatment) VALUES(?, ?, ?, ?, ?, ?) ");
        return $stmt->execute([$patient_id, $doctor_id, $record_date, $symptoms, $diagnosis, $treatment]);
    }

    function getMedicalRecords() {
        $pdo = dbconnect();
        $stmt = $pdo->query("SELECT medical_records.id , 
                                    patients.name as patient_name,
                                    doctors.name as doctor_name,
                                    medical_records.record_date,
                                    medical_records.symptoms,
                                    medical_records.diagnosis,
                                    medical_records.treatment
                             FROM medical_records 
                             JOIN patients  ON medical_records.patient_id = patients.id 
                             JOIN doctors  ON medical_records.doctor_id = doctors.id 
                             ORDER BY record_date ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getMedicalRecordById($id) {
        $pdo = dbconnect();
        $stmt = $pdo->prepare("SELECT medical_records.id,
                                      patients.name as patient_name,
                                      doctors.name as doctor_name,
                                      medical_records.record_date,
                                      medical_records.symptoms, 
                                      medical_records.diagnosis,
                                      medical_records.treatment
                               FROM medical_records 
                               JOIN patients  ON medical_records.patient_id = patients.id 
                               JOIN doctors d ON medical_records.doctor_id = doctors.id 
                               WHERE id = ? ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function updateMedicalRecord($id, $patient_id, $doctor_id,$record_date, $symptoms, $diagnosis, $treatment){
        $pdo = dbconnect();
        $stmt = $pdo->prepare("UPDATE medical_history SET  patient_id = ?, doctor_id = ?, record_date = ?, symptoms = ?, diagnosis = ?, treatment = ? 
                               WHERE id = ? ");
        return $stmt->execute([$patient_id,$doctor_id, $record_date,  $symptoms, $diagnosis, $treatment, $id]);
    }

    function listMedicalRecords($patient_id){
        $pdo = dbconnect();
        $stmt = $pdo->prepare("SELECT * FROM medical_records WHERE patient_id = ? ");
        $stmt->execute([$patient-id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function searchMedicalRecord($keyword){
        $pdo = dbconnect();
        $stmt = $pdo->perpare("SELECT * FROM medical_records WHERE condition LIKE ? ");
        $stmt->execute(['%' . $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSCO);
    }

    function deleteMedicalRecord($id){
        $pdo = dbconnect();
        $stmt = $pdo->prepare("DELETE FROM medical_records WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /* Function Manage Billings */

    function addbilling($patient_id, $service_id, $date_of_service, $amount, $status){
        $pdo = dbconnect();
        $stmt = $pdo->prepare("INSERT INTO billing(patient_id, service_id, date_of_service, amount, status) VALUES(?, ?, ?, ?, ? ) ");
        return $stmt->execute([$patient_id, $service_id, $date_of_service, $date_of_service, $amount, $status]);
    }

    function getBillings(){
        $pdo = dbconnect();
        $stmt = $pdo->query("SELECT billings.id, 
                                    patients.name as patient_name, 
                                    services.description as service_description,
                                    billings.date_of_service,
                                    billings.amount,
                                    billings.status
                             FROM billings 
                             JOIN patients ON billings.patient_id = patients.id 
                             JOIN services ON billings.service_id = services.id
                             ORDER BY billings.billing_date ASC ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getBillingById($id)
    {
        $pdo = dbconnect();
        $stmt = $pdo->prepare("SELECT billings.id , 
                                      patients.name as patient_name,
                                      services.description as service_description,
                                      bilings.date_of_service,
                                      billings.amount,
                                      billings.status
                               FROM billings 
                               JOIN patients  ON billings.patient_id = patients.id 
                               JOIN services  ON billings.service_id = services.id
                               WHERE id = ? ");
        $stmt->execute([$id]);
        return 4stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function updateBilling($id,$patient_id,$service_id, $date_of_service, $amount, $status){
        $pdo = dbconnect();
        $stmt = $pdo->prepare("UPDATE billings SET patient_id = ?, service_id = ?, date_of_service = ?, amount = ?, status = ? WHERE id= ? ");
        return $stmt->execute([$patient_id, $service_id,$date_of_service,$amount, $status, $id]);
    }

    function deleteBilling($id) {
        $pdo = dbconnect();
        $stmt = $pdo->prepare("DELETE FROM billings WHERE id = ? ");
        return $stmt->execute([$id]);
    }

    function listBillingByPatient($patient_id){
        $pdo = dbconnect();
        $stmt = $pdo->prepare("SELECT * FROM billings WHERE patient_id = ?");
        $stmt->execute([$patient_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function searchBilling($keyword){
        $pdo = dbconnect();
        $stmt = $pdo->prepare(" SELECT * FROM billings WHERE status LIKE ?
                                OR patient_id IN ('SELECT id FROM patients WHERE name like ? ')");
        $stmt->execute(['%' . $keyword . '%' , '%' . $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Function manage Payemnt */
    function addPayment($billing_id, $payment_date, $amount, $method){
        $pdo = dbconnect();

        $stmt = $pdo->prepare("INSERT INTO payments(billing_date, payment_date, amount, method) VALUES(?,?,?,?) ");
        $stmt->execute([$billing_id, $payment_date, $amount, $method]);
        return $stmt;
    }

    function getPayments() {
        $pdo = dbconnect();
        $stmt = $pdo->query("SELECT payments.id , 
                                    billings.date_of_service as billing_date_of_service,
                                    payments.payment_date,
                                    payments.amount,
                                    payments.method
                            FROM payments 
                            JOIN billings ON payments.billing_id = billings.id 
                            ORDER BY payments.payment_date ");
    }

    function getPaymentById(){
        $pdo = dbconnect();

        $sql = $pdo->query("SELECT payments.id ,
                                    billigs.date_of_service as billing_date_of_service,
                                    payments.payment_date,
                                    payments.amount,
                                    payments.method
                            FROM payments 
                            JOIN billings ON payments.billing_id = billings.id ");
        $stmt->execute($sql);
        return $stmt;
    }

    function updatePaymemt($id, $billling_id, $payment_date, $amount, $method){
        $pdo = dbconnect();

        $stmt= $pdo->prepare("UPDATE payments SET billing_id = ?, payment_date = ?, amount =?, method =? WHERE id = ? ");
        return $stmt->execute([$billing_id, $payment_date, $amount, $method, $id]);
    }

    function deletePayment($id){
        $pdo = dbconnect();

        $stmt = $pdo->prepare("DELETE FROM payments WHERE id = ? ");
        return $stmt->execute([$id]);
    }

    /* Function manage service */
    function addService(){
        $pdo = dbconnect();

        $stmt = $pdo->prepare("INSERT INTO services(description, cost) VALUES(?,?) ");
        return $stmt->execute([$description, $cost]);
    }

    function getServices(){
        $pdo = dbconnect();

        $stmt = $pod->query("SELECT * FROM services ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getServiceById($id){
        $pdo = dbconnect();

        $stmt = $pdo->query("SELECT * FROM services WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function updateService($id,$description, $cost){
        $pdo = dbconnect();

        $stmt = $pdo->prepare("UPDATE services SET description = ?, cost = ? WHERE id = ? ");
        return $stmt->execute([$description, $cost, $id]);
    }

    function deleteService($id){
        $pdo = dbconnect();

        $stmt = $pdo->prepare("DELETE FROM services WHERE id = ? ");
        return $stmt->execute([$id]);
    }


    function getDoctorProfile($doctor_id)
    {
        $pdo = $dbconnect();
        $stmt = $pdo->prepare("SELECT * FROM doctors WHERE id = ? ");
        $stmt->execute([$doctor_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }  

    function num_rows($tablename){
        $pdo = dbconnect();
        $sql = "SELECT * FROM(*) FROM " . $tablename;
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

?>
