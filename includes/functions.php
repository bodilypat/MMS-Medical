<?php
    session_start();

    function registerUser($name, $mail, $password){
        global $pdo;

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users(name,email,password) VALUES(?,?,?,?)");
        return $stmt->execute($name, $email, $hashedPassword);
    }
    
    function loginUser($email, $password){
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM user WHERE email= ?");
        $stm->execute([$email]);
        $user= $stmt->fetch();

        if($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            return true;
        }
        return false;
    }

    function isloggedIn(){
        return isset($_SESSION['user_id']);
    }

    function login() {
        session_start();
        session_destroy();
        header("Location: login.php");
        exit();
    }

    function addDoctor($name, $email, $specialization, $phone) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO doctors(name, email, specialization, phone) VALUES(?,?,?,?)");
        return $stmt->execute([$name,$mail,$specialization, $phone]);
    }

    function getDoctors(){
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM doctors");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getDoctor($id){
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM doctors WHERE id = ? ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSC);
    }

    function updateDoctor($id, $name, $email, $specialization, $phone){
        global $pdo;
        $stmt = $pdo->prepare("UPDATE doctors SET name = ? , email = ?, specialization = ?, phone = ?  WHERE id = ? ");
        return $stmt->execute([$name, $email,$specialization, $phone, $id])
    }

    function deleteDoctor($id){
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM doctors WHERE id = ? ");
        return $stmt->execute([id]);
    }

    function addPatient($name, $email, $date_of_birth, $gender, $phone, $address) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO patients(name, email, date_of_birth, gender, phone, address) VALUES(?, ?, ?, ?,?) ");
        return $stmt->execute([$name, $email, $date_of_birth, $gender, $phone, $address]);
    }

    function getPatients(){
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM patients");
        return $stmt->execute(PDO::FETCH_ASSOC);
    }

    function getPatient($id) {
        global $pdo;
        $stmt = $stmt->prepare("SELECT * FROM patients WHERE id = ?");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    function updatePatient($id, $name, $email, $date_of_birth, $gender, $phone, $address){
        global $pdo;
        $stmt = $pdo->prepare("UPDATE patients SET name = ?, email = ?, date_of_birth = ?, gender = ?, phone = ?, address = ? WHERE id = ? ");
        return $stmt->execute([$name, $email, $date_of_birth, $gender, $phone, $address, $id]);
    }

    function deletePatient($id){
        global $pdo;
        $stmt = $stmt->prepare("DELETE FROM patients WHERE id = ? ");
        return $stmt->execute([$id])
    }

    function addAppointment($patient_name, $doctor_name, $appointment_date){
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO appointments(patient_name, doctor_name, appointment_date) VALUES(?, ?, ?)");
        return $stmt->execute([$patient_name, $doctor_name, $appointment_date]);
    }

    function getAppointments() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM appointments");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getAppointment($id) {
        global $pdo;
        $stm = $pdo->prepare("SELECT * FROM appointments WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function updateAppointment($id, $patient_name, $doctor_name, $addpointment_date){
        global $pdo;
        $stm = $pdo->prepare("UPDATE appointments SET patient_name = ? , doctor_name = ?, appointment_date = ?  WHERE id = ?");
        return $stmt->execute([$patient_name, $doctor_name, $appointment_date, $id]);
    }

    function searchAppointments($keyword){
        global $pdo;
        $stmt = $pdo->prepare("SELECT  *
                               FROM appointments 
                               WHERE patient_id (SELECT id FROM  patients WHERE name LIKE ?)
                               OR doctor_id IN (SELECT id FROM doctors WHERE name LIKE ?)");
        $stmt->execute(['%' . $keyword . '%', '%' . $keyword . '%']);
        return $stmt->fetall(PDO::FETCH_ASSOC);
    }

    function deleteAppointment($id){
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = ? ");
        return $stmt->execute([$id]);
    }

    function addPrescription ($patient_name, $doctor_name, $medication, $dosage, $instruction){
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO prescriptions(patient_name, doctor_name, medication, dosage, instruction) VALUES(?, ?, ?, ?, ?)");
        return $stmt->execute([$patient_name, $doctor_name, $medication, $dosage, $instruction]);
    }

    function getPrescriptions() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM prescriptions");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getPrescription($id){
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM prescriptions WHERE id = ? ");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function updatePrescription($id, $patient_name, $doct_name, $medication, $dosage, $instruction){
        global $pdo;
        $stmt = $pdo->prepare("UPDATE prescriptions SET patient_name = ?, doctor_name = ?, medical = ?, dasaage = ?, instruction = ? WHERE id = ? ");
        return $stmt->execute([$patient_name, $doctor_name, $medication, $dosage, $instruction, $id]);
    }

    function searchPrescriptions($keyword){
        global $pdo;
        $stmt = $pdo->prepare("SELECT  *
                               FROM prescriptions 
                               WHERE patient_id (SELECT id FROM  patients WHERE name LIKE ?)
                               OR doctor_id IN (SELECT id FROM doctors WHERE name LIKE ?)");
        $stmt->execute(['%' . $keyword . '%', '%' . $keyword . '%']);
        return $stmt->fetall(PDO::FETCH_ASSOC);
    }

    function deletePrescription($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM prescriptions WHERE in = ? ");
        return $stmt->execute([$id]);
    }

    function addMedicalHistory($patient_name, $date_of_visit, $symtoms, $diagnosis, $treatment){
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO medical_history(patient_name, date_of_visit, symptoms, diagnosis, treatment) VALUES(?, ?, ?, ?, ?) ");
        return $stmt->execute([$patient_name, $date_of_visit, $symptoms, $diagnosis, $treatment]);
    }

    function getMedicalHistories() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM medical_history");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getMedicalHistory($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM medical_history WHERE id = ? ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function updateMedicalHistory($id, $patient_name, $date_of_visit, $symptoms, $diagnosis, $treatment){
        global $pdo;
        $stmt = $pdo->prepare("UPDATE medical_history SET patient_name = ?, date_of_visit = ?, symptoms = ?, diagnosis = ?, treatment = ? WHERE id = ? ");
        return $stmt->execute([$patient_name, $date_of_visit, $symptoms, $diagnosis, $treatment, $id]);
    }

    function deleteMedicalHistory($id){
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM medical_history WHERE id = ?");
        return $stmt->execute([$id]);
    }

    function addInvoice($client_name, $invoice_date, $due_date,$total_amount){
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO invoices(client_name, invice_date, due_date, total_amount) VALUES(?,?,?,?,) ");
        return $stmt->execute([$client_name, $invoice_date, $due_date, $total_amount]);
    }

    function getInvoices(){
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM invoices");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function updateInvoice($id, $client_name, $invoice_date, $due_date, $total_amount, $status){
        global $pdo;
        $stmt = $pdo->prepare("UPDATE invoices SET client_name = ?, invoice = ?, due_date = ?, total_amount = ?, status = ? WHERE id= ? ");
        return $stmt->execute([$client_name, $invoice_date, $due_date, $total_amount, $status, $id]);
    }

    function deletingInvoice($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM invoices WHERE id = ? ");
        return $stmt->execute(['$id']);
    }

    function getDoctorAppointment($doctor_id)
    {
        global  $pdo;
        $stmt = $pdo->prepare("SELECT a.id , p.name , a.appointment_date, a.status
                               FROM appointments a
                               JOIN patients p ON a.patient_id = p.id
                               WHERE a.doctor_id = ? 
                               ORDER BY a.appointment_date ASC");
        $stmt->execute([$doctor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getDoctorProfile($doctor_id)
    {
        $stmt = $pdo->prepare("SELECT * FROM doctors WHERE id = ? ");
        $stmt->execute([$doctor_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
?>
