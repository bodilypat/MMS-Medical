CREATE DATABASE IF NOT EXISTS MEDICAL;

USE MEDICAL;

-- Table to store user information
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,  
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'doctor','norse','receptionist','lab_technician','user') DEFAULT 'user' NOT NULL,
	is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
);

-- Table to store patient information
CREATE TABLE IF NOT EXISTS patients (
    patient_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    date_of_birth DATE NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone_number VARCHAR(20) UNIQUE NOT NULL,
    address VARCHAR(255),
    primary_care_physician VARCHAR(100),
    medical_history TEXT,
    allergies TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive', 'deceased') DEFAULT 'active'
);


-- Table to store appointment information
CREATE TABLE IF NOT EXISTS appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    appointment_date DATETIME NOT NULL,
	check_in_time DATETIME DEFAULT NULL,
	check_out_time DATETIME DEFAULT NULL,
    reason_for_visit VARCHAR(255) NOT NULL,
	appointment_type ENUM('Consultation','Follow-up','Surgery','Lab Test','Emergency') DEFAULT 'Consultation' NOT NULL,
    status ENUM('Scheduled', 'Checked-In', 'Cancelled', 'No-Show') DEFAULT 'Scheduled' NOT NULL,
    duration_minutes INT (duration_minutes > 0),
   
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id) ON DELETE SET NULL,
	FOREIGN KEY (created_by) REFERENCES users(id),
	FOREIGN KEY (updated_by) REFERENCES users(id),
	
    INDEX idx_patient_id (patient_id),
    INDEX idx_doctor_id (doctor_id),
	INDEX idx_appointment_date (appointment_date),
    CONSTRAINT check_appointment_date CHECK (appointment_date >= CURRENT_TIMESTAMP)
);

-- Table to store doctor information
CREATE TABLE IF NOT EXISTS doctors (
    doctor_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
	full_name AS (CONCAT(first_name, '' , Last_name)) STORED,
    specialization VARCHAR(100) NOT NULL,
	department VARCHAR(100),
    email VARCHAR(150) UNIQUE NOT NULL,
    phone_number VARCHAR(20) UNIQUE NOT NULL,
	birthdate DATE,
	gender ENUM('male','female','other') DEFAULT 'other',
	address VARCHAR(255),
	status ENUM('active', 'inactive', 'retired','on_leave') DEFAULT 'active',
	hire_date DATE DEFAULT CURRENT_DATE,
	retirement_date DATE DEFAULT NULL,
	notes TEXT,
	created_by INT,
	updated_by INT, 
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,

    CONSTRAINT chk_phone_format CHECK (phone_number REGEXP '^[0-9]{10,15}$'),
	CONSTRAINT chk_birthdate_valid CHECK (birthdate <= CURRENT_DATE), 
	
	FOREIGN KEY (created_by) REFERENCES users(id),
	FOREIGN KEY (updated_by) REFERENCES users(id),
	
	INDEX idx_specialization (specialization),
	INDEX idx_status (status) 
);


-- Table to store medical records of patients
CREATE TABLE IF NOT EXISTS medical_records (
    record_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    appointment_id INT NOT NULL,
    diagnosis VARCHAR(500),
    treatment_plan TEXT,
    note TEXT,
    status ENUM('Active', 'Archived', 'Inactive') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by INT,
    updated_by INT,
    attachments VARCHAR(255),
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
    FOREIGN KEY (appointment_id) REFERENCES appointments(appointment_id),
	FOREIGN KEY (created_by) REFERENCES users(id),
	FOREIGN KEY (updated_by) REFERENCES users(id),
    INDEX (patient_id),
    INDEX (appointment_id),
);

-- Table to store lab tests performed on patients
CREATE TABLE IF NOT EXISTS lab_tests (
    test_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    appointment_id INT NOT NULL,
    test_name VARCHAR(150) NOT NULL,
	test_code VARCHAR(50),
	test_category ENUM('Blood','Imaging','Urine','Pathology','Genetic','Other') DEFAULT 'Other',
    test_date DATE NOT NULL,
	test_time TIME DEFAULT NULL,
    result_summary TEXT,
	result_details TEXT,
	result_file_url VARCHAR(255),
    test_status ENUM('Pending', 'In Progress', 'Completed', 'Failed','Cancelled') DEFAULT 'Pending' NOT NULL,
	reviewed_by INT DEFAULT NULL,
	created_by INT DEFAULT NULL,
	updated_by INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (appointment_id) REFERENCES appointments(appointment_id) ON DELETE CASCADE,
	FOREIGN KEY (created_by) REFERENCES users(id),
	FOREIGN KEY (updated_by) REFERENCES users(id),
	FOREIGN KEY (reviewed_by) REFERENCES users(id),
	
    INDEX idx_patient_id (patient_id),
    INDEX idx_appointment_id (appointment_id),
	INDEX idx_test_date (test_date),
	INDEX idx_test_status (test_status),
	
    CONSTRAINT uc_patient_app_test UNIQUE (patient_id, appointment_id, test_name)
);

-- Table to store prescriptions given to patients
CREATE TABLE IF NOT EXISTS prescriptions (
    prescription_id INT AUTO_INCREMENT PRIMARY KEY,
    record_id INT NOT NULL,
    medication_name VARCHAR(255) NOT NULL,
    dosage VARCHAR(50) NOT NULL,
    frequency VARCHAR(50) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE,
    instructions TEXT,
    status ENUM('Active', 'Completed', 'Expired', 'Cancelled') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by INT,
    updated_by INT,
    FOREIGN KEY (record_id) REFERENCES medical_records(record_id),
    INDEX (record_id),
    INDEX (medication_name),
    CONSTRAINT check_dosage CHECK (CHAR_LENGTH(dosage) <= 50)
);



-- Table to store payment information
CREATE TABLE IF NOT EXISTS payments (
    billing_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    appointment_id INT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    amount_paid DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    balance_due DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    payment_status ENUM('Paid', 'Pending', 'Partially Paid') DEFAULT 'Pending' NOT NULL,
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    insurance_claimed_amount DECIMAL(10, 2) DEFAULT NULL,
    insurance_status ENUM('Approved', 'Pending', 'Denied') DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (appointment_id) REFERENCES appointments(appointment_id) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_patient_id (patient_id),
    INDEX idx_appointment_id (appointment_id),
    INDEX idx_payment_date (payment_date),
    CONSTRAINT uc_patient_appointment UNIQUE (patient_id, appointment_id)
);

-- Table to store pharmacy information
CREATE TABLE IF NOT EXISTS pharmacies (
    pharmacy_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL UNIQUE,
    phone_number VARCHAR(15) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT chk_phone_number CHECK (phone_number REGEXP '^[0-9]+$')
);

-- Table to store insurance details of patients
CREATE TABLE IF NOT EXISTS insurance (
    insurance_id INT AUTO_INCREMENT PRIMARY KEY,
    provider_name VARCHAR(255) NOT NULL,
    policy_number VARCHAR(50) NOT NULL UNIQUE,
    coverage_type ENUM('Full', 'Partial') DEFAULT 'Partial',
    coverage_amount DECIMAL(10, 2) DEFAULT 0.00,
    patient_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    CONSTRAINT chk_dates CHECK (start_date <= end_date)
);
