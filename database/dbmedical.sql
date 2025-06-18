CREATE DATABASE IF NOT EXISTS MEDICAL;

USE MEDICAL;

-- Table to store user information
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,  
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'doctor','nurse','receptionist','lab_technician','user') DEFAULT 'user' NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_by INT NULL,
    last_login TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
    FOREIGN KEY (created_by) REFERENCES users(id)
    INDEX idx_users_email (email) 
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
	FOREIGN KEY (created_by) REFERENCES users(user_id),
	FOREIGN KEY (updated_by) REFERENCES users(user_id),
);

-- Table to store doctor information
CREATE TABLE IF NOT EXISTS doctors (
    doctor_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
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
	
	FOREIGN KEY (created_by) REFERENCES users(id),
	FOREIGN KEY (updated_by) REFERENCES users(id),
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
);

-- Table to store insurance details of patients
CREATE TABLE IF NOT EXISTS insurance (
    insurance_id INT AUTO_INCREMENT PRIMARY KEY,
	patient_id INT NOT NULL,
    provider_name VARCHAR(255) NOT NULL,
    policy_number VARCHAR(50) NOT NULL,
	plan_name VARCHAR(100),
	group_number VARCHAR(50),
    coverage_type ENUM('Full', 'Partial','nONE') DEFAULT 'Partial',
	coverage_percentage DECIMAL(5,2) DEFAULT 0.00 CHECK (coverage_percentage BETWEEN 0 AND 100),
    coverage_amount DECIMAL(10, 2) DEFAULT 0.00 CHECK (coverage_amount >= 0),
	is_primary BOOLEAN DEFAULT TRUE,
	status ENUM('Active','Expired','Terminated','Pending Verification') DEFAULT 'Active',
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
	renwal_date DATE,
	contact_number VARCHAR(20),
	provider_email VARCHAR(100),
	notes TEXT,
	created_by INT,
	updated_by INT,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
	FOREIGN KEY (created_by) REFERENCES users(id),
	FOREIGN KEY (updated_by) REFERENCES users(id),
	
    CONSTRAINT uc_policy_per_patient UNIQUE (policy_number, patient_id),
	CONSTRAINT chk_valid_dates CHECK (start_date <= end_date) 
);

-- Table to store payment information
CREATE TABLE IF NOT EXISTS payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    appointment_id INT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL CHECK (total_amount >= 0),
    amount_paid DECIMAL(10, 2) NOT NULL DEFAULT 0.00 CHECK (amount_paid >= 0),
    balance_due AS (total_amount - amount_paid) STORED,
    payment_status ENUM('Paid','Partially Paid','Pending','overdue','Refunded') DEFAULT 'Pending' NOT NULL,
	payment_method ENUM('Cash','Credit Card','Debit Card','Insurance','Online','Bank Transfer','Other') DEFAULT 'Cash',
	transaction_reference VARCHAR(100),
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    insurance_claimed_amount DECIMAL(10, 2) DEFAULT 0.00 CHECK (insurance_claimed_amount >= 0),
    insurance_status ENUM('Approved', 'Pending', 'Denied','Not Applicable') DEFAULT 'Not Applicable',
	insurance_provider VARCHAR(100),
	notes TEXT,
	refund_amount DECIMAL(10, 2) DEFAULT 0.00 CHECK (refund_amount >= 0),
	created_by INT,
	updated_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (appointment_id) REFERENCES appointments(appointment_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (created_by) REFERENCES users(id),
	FOREIGN KEY (updated_by) REFERENCES users(id),
);

-- Table to store prescriptions given to patients
CREATE TABLE IF NOT EXISTS prescriptions (
    prescription_id INT AUTO_INCREMENT PRIMARY KEY,
    record_id INT NOT NULL,
	patient_id INT NOT NULL,
	doctor_id INT NOT NULL,
	appointment_id INT, 
    medication_name VARCHAR(150) NOT NULL,
	generic_name VARCHAR(150),
    dosage VARCHAR(50) NOT NULL,
    unit ENUM('mg','ml','g','units','tablet','capsule','drop','patch') DEFAULT 'mg',
	frequency VARCHAR(100) NOT NULL,
	route ENUM ('Oral','IV','IM','Topical','Subcutaneous','Nasal','Other') DEFAULT 'Oral',
	duration_days INT,
	start_date DATE NOT NULL,
	end_date DATE,
    instructions TEXT,
	notes TEXTS,
	refill_count INT DEFAULT 0,
    status ENUM('Active', 'Completed', 'Expired', 'Cancelled') DEFAULT 'Active',
	created_by INT,
	updated_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,

    FOREIGN KEY (record_id) REFERENCES medical_records(record_id) NO DELETE CASCADE,
	FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
	FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id),
	FOREIGN KEY (appointment_id) REFERENCES appointments(appointment_id),
	FOREIGN KEY (create_by) REFERENCES users(id),
	FOREIGN KEY (updated_by) REFERENCES users(id),
);

-- Table to store pharmacy information
CREATE TABLE IF NOT EXISTS pharmacies (
    pharmacy_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL UNIQUE,
	city VARCHAR(100) NOT NULL,
	state VARCHAR(100) NOT NULL,
	post_code VARCHAR(20) NOT NULL,
	country VARCHAR(100) DEFAULT 'USA'
    phone_number VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
	license_number VARCHAR(100) UNIQUE,
	license_expiry_date DATE,
	operating_hours TEXT,
	contact_person VARCHAR(100),
	status ENUM('Active','Inactive','Pending Verification') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	created_by INT,
	created_by INT,
	UNIQUE (email),
	UNIQUE (phone_number),
	
    CONSTRAINT chk_phone_number CHECK (phone_number REGEXP '^[0-9]{7,15}$'),
	CONSTRAINT chk_postal_code CHECK (postal_code REGEXP '^[0-9A-Za-z -]{4, 10}$')
);

