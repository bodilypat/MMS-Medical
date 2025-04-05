CREATE DATABASE MEDICAL;

USE MEDICAL ;

CREATE TABLE users(
    id INT AUTO_INCREMENT PRIMARY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email  VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') DEFAULT 'user' NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
); 


CREATE TABLE patients (
    patient_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,  -- Changed from 'patient_name' to 'first_name' for clarity
    last_name VARCHAR(100) NOT NULL,
    date_of_birth DATE NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,  -- Fixed case inconsistency
    email VARCHAR(100) UNIQUE,  -- Added UNIQUE constraint for email
    phone_number VARCHAR(20) UNIQUE NOT NULL,  -- Increased size for phone number and made it UNIQUE
    address VARCHAR(255),
    insurance_provider VARCHAR(100),
    insurance_policy_number VARCHAR(100),  -- Increased size for insurance policy number
    primary_care_physician VARCHAR(100),
    medical_history TEXT,  -- Corrected typo 'medical_hostory' to 'medical_history'
    allergies TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive', 'deceased') DEFAULT 'active'  -- Standardized enum values to lowercase
);

CREATE TABLE doctors (
    doctor_id INT AUTO_INCREMENT PRIMARY KEY,  -- Doctor ID as primary key
    first_name VARCHAR(100) NOT NULL,  -- First Name (non-nullable)
    last_name VARCHAR(100) NOT NULL,   -- Last Name (non-nullable)
    specialization VARCHAR(100) NOT NULL,  -- Specialization field (non-nullable)
    email VARCHAR(255) UNIQUE NOT NULL,  -- Unique email (non-nullable)
    phone_number VARCHAR(20) UNIQUE NOT NULL,  -- Adjusted phone_number size to handle international numbers
    department VARCHAR(100),  -- Department (nullable, if available)
    birthdate DATE,  -- Added birthdate for the doctor (optional, nullable)
    address VARCHAR(255),  -- Added address (optional, nullable)
    status ENUM('active', 'inactive', 'retired') DEFAULT 'active',  -- Added status for better doctor record management
    notes TEXT,  -- Added notes field for any special remarks
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Timestamp when the record was created
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  -- Timestamp for updates
    CONSTRAINT check_phone_number CHECK (phone_number REGEXP '^[0-9]{10,15}$')  -- Optional check constraint for phone number
);

CREATE TABLE appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,  -- Auto-incrementing unique identifier for the appointment
    patient_id INT NOT NULL,  -- Foreign key to the patient
    doctor_id INT NOT NULL,   -- Foreign key to the doctor
    appointment_date DATETIME NOT NULL,  -- Date and time of the appointment
    reason_for_visit VARCHAR(255),  -- Optional reason for the visit (up to 255 characters)
    status ENUM('Scheduled', 'Completed', 'Cancelled', 'No-Show') DEFAULT 'Scheduled',  -- Appointment status
    duration INT,  -- Duration of the appointment in minutes (optional)
    appointment_type VARCHAR(100),  -- Type of appointment (e.g., "Consultation", "Follow-up", etc.)
    notes TEXT,  -- Optional field for additional notes about the appointment
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Timestamp when the appointment is created
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  -- Timestamp for updates
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id),  -- Foreign key to the patient table
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id),  -- Foreign key to the doctor table
    INDEX (patient_id),  -- Index to improve search performance for patient_id
    INDEX (doctor_id),   -- Index to improve search performance for doctor_id
    CONSTRAINT check_appointment_date CHECK (appointment_date >= CURRENT_TIMESTAMP)  -- Ensure appointment is not in the past
);

CREATE TABLE medical_records (
    record_id INT AUTO_INCREMENT PRIMARY KEY,  -- Unique record identifier
    patient_id INT NOT NULL,  -- Foreign key to the patient table
    appointment_id INT NOT NULL,  -- Foreign key to the appointment table
    diagnosis VARCHAR(500),  -- Increased size to handle longer diagnosis descriptions
    treatment_plan TEXT,  -- Detailed treatment plan (can be longer text)
    note TEXT,  -- Additional notes for medical records
    status ENUM('Active', 'Archived', 'Inactive') DEFAULT 'Active',  -- Status of the record
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Timestamp of record creation
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  -- Timestamp of record update
    created_by INT,  -- User who created the record (could link to a users table)
    updated_by INT,  -- User who last updated the record (could link to a users table)
    attachments VARCHAR(255),  -- File paths or URLs to any associated files or images
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id),  -- Linking patient_id to the patients table
    FOREIGN KEY (appointment_id) REFERENCES appointments(appointment_id),  -- Linking appointment_id to the appointments table
    INDEX (patient_id),  -- Index for performance improvement on patient-based queries
    INDEX (appointment_id),  -- Index for performance improvement on appointment-based queries
    CONSTRAINT check_diagnosis_length CHECK (CHAR_LENGTH(diagnosis) <= 500)  -- Optional: Limiting diagnosis length if desired
);

CREATE TABLE prescriptions (
    prescription_id INT AUTO_INCREMENT PRIMARY KEY,  -- Unique identifier for the prescription
    record_id INT NOT NULL,  -- Foreign key linking to the medical_records table
    medication_name VARCHAR(255) NOT NULL,  -- Name of the medication (non-nullable)
    dosage VARCHAR(50) NOT NULL,  -- Dosage instructions (non-nullable)
    frequency VARCHAR(50) NOT NULL,  -- Frequency of medication (e.g., daily, twice a day, etc.)
    start_date DATE NOT NULL,  -- Start date for the prescription (non-nullable)
    end_date DATE,  -- End date for the prescription, can be NULL if ongoing
    instructions TEXT,  -- Detailed instructions on how the medication should be taken
    status ENUM('Active', 'Completed', 'Expired', 'Cancelled') DEFAULT 'Active',  -- Status of the prescription
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Timestamp when the prescription was created
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  -- Timestamp when the prescription was last updated
    created_by INT,  -- User who created the prescription record (can link to users table)
    updated_by INT,  -- User who last updated the prescription (can link to users table)
    FOREIGN KEY (record_id) REFERENCES medical_records(record_id),  -- Link to medical record
    INDEX (record_id),  -- Index to speed up queries on record_id
    INDEX (medication_name),  -- Index to speed up queries on medication_name
    CONSTRAINT check_dosage CHECK (CHAR_LENGTH(dosage) <= 50)  -- Ensure the dosage length is appropriate
);

CREATE TABLE lab_tests (
    test_id INT AUTO_INCREMENT PRIMARY KEY,  -- Auto-incrementing test ID
    patient_id INT NOT NULL,  -- Foreign key to the patient table (cannot be null)
    appointment_id INT NOT NULL,  -- Foreign key to the appointment table (cannot be null)
    test_name VARCHAR(255) NOT NULL,  -- Name of the test (cannot be null)
    test_date DATE NOT NULL,  -- Date when the test is performed (cannot be null)
    results TEXT,  -- Test results (can be null initially or updated later)
    test_status ENUM('Pending', 'Completed', 'Failed', 'In Progress') DEFAULT 'Pending',  -- Status of the test
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Timestamp when the record is created
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  -- Timestamp for updates
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id),  -- Foreign key linking to patients table
    FOREIGN KEY (appointment_id) REFERENCES appointments(appointment_id),  -- Foreign key linking to appointments table
    INDEX (patient_id),  -- Index for improved performance when querying by patient_id
    INDEX (appointment_id),  -- Index for improved performance when querying by appointment_id
    CONSTRAINT uc_patient_appointment UNIQUE (patient_id, appointment_id, test_name)  -- Ensure that each patient has one test per appointment
);

CREATE TABLE payments (
    billing_id INT AUTO_INCREMENT PRIMARY KEY,  -- Unique billing ID
    patient_id INT NOT NULL,  -- Foreign key to the patient table (cannot be null)
    appointment_id INT NOT NULL,  -- Foreign key to the appointment table (cannot be null)
    total_amount DECIMAL(10, 2) NOT NULL,  -- Total amount to be paid (cannot be null)
    amount_paid DECIMAL(10, 2) NOT NULL DEFAULT 0.00,  -- Amount already paid (cannot be null)
    balance_due DECIMAL(10, 2) NOT NULL DEFAULT 0.00,  -- Balance due (cannot be null)
    payment_status ENUM('Paid', 'Pending', 'Partially Paid') DEFAULT 'Pending' NOT NULL,  -- Payment status (cannot be null)
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,  -- Timestamp of payment (default to current time)
    insurance_claimed_amount DECIMAL(10, 2) DEFAULT NULL,  -- Optional: Amount claimed from insurance (nullable)
    insurance_status ENUM('Approved', 'Pending', 'Denied') DEFAULT NULL,  -- Insurance claim status (nullable, only used if insurance_claimed_amount is not NULL)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Timestamp when the record was created
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  -- Timestamp when the record was last updated
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE ON UPDATE CASCADE,  -- Cascade delete and update for patient
    FOREIGN KEY (appointment_id) REFERENCES appointments(appointment_id) ON DELETE CASCADE ON UPDATE CASCADE,  -- Cascade delete and update for appointment
    INDEX idx_patient_id (patient_id),  -- Index for improved performance on queries filtering by patient_id
    INDEX idx_appointment_id (appointment_id),  -- Index for improved performance on queries filtering by appointment_id
    INDEX idx_payment_date (payment_date),  -- Index for better querying performance by payment date
    CONSTRAINT uc_patient_appointment UNIQUE (patient_id, appointment_id)  -- Ensure only one payment per appointment per patient
);

CREATE TABLE pharmacies (
    pharmacy_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL UNIQUE,
    phone_number VARCHAR(15) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT chk_phone_number CHECK (phone_number REGEXP '^[0-9]+$')
);

CREATE TABLE  insurance (
    insurance_id INT AUTO_INCREMENT PRIMARY KEY,
    provider_name VARCHAR(255) NOT NULL,
    policy_number VARCHAR(50) NOT NULL UNIQUE,
    coverage_type ENUM('Full','Partial') DEFAULT 'Partial',
    converage_amount DECIMAL(10, 2) DEFAULT 0.00,
    patient_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id)
	CONSTRAINT chk_dates CHECK (start_date <= end_date) 
);



