CREATE DATABASE MEDICAL;

USE MEDICAL ;

CREATE TABLE users(
    id INT AUTO_INCREMENT PRIMARY,
    username VARCHAR(255) NOT NULL,
    email  VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') DEFAULT 'user',
    created_at TIMESTAMP CURRENT_TIMESTAMP
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
design Frontend patients flow with HTML



connect database using MySQLi with PHP
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
Frontend  doctor management  using HTML

Doctor Management: Adding and managing doctor profiles.

Patient Management: Storing patient details and appointment history.

Appointment Booking: Patients can book appointments based on the doctor’s availability.

Appointment Cancellation/Rescheduling: Allows patients or doctors to cancel or reschedule appointments.

Dashboard: For both doctors and patients to view upcoming appointments.


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
Design Frontend appointments management using HTML 

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
create backend with PHP

SQL Select Query
SELECT mr.record_id, p.first_name AS patient_first_name, p.last_name AS patient_last_name, 
       a.appointment_date, mr.diagnosis, mr.treatment_plan, mr.status
FROM medical_records mr
JOIN patients p ON mr.patient_id = p.patient_id
JOIN appointments a ON mr.appointment_id = a.appointment_id
WHERE p.patient_id = 1
ORDER BY a.appointment_date DESC;

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
connect database with mysqli
create backend with PHP 

SQL Select Query
SELECT p.prescription_id, p.medication_name, p.dosage, p.frequency, p.start_date, p.end_date, p.status, p.instructions, 
       p.created_at, p.updated_at, p.created_by, p.updated_by
FROM prescriptions p
JOIN medical_records mr ON p.record_id = mr.record_id
WHERE mr.patient_id = 1 AND p.status = 'Active'
ORDER BY p.start_date DESC;

CREATE TABLE lab_tests(
    test_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    appointment_id INT,
    test_name VARCHAR(255),
    test_date DATE,
    results TEXT,
    test_status ENUM('Pending','Completed','Failed') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
    FOREIGN KEY (appointment_id) REFERENCES appointments(appointment_id)
)

CREATE TABLE payments (
    billing_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT, 
    appointment_id INT,
    total_amount DECIMAL(10, 2),
    amount_paid DECIMAL(10, 2),
    balance_due DECIMAL(10, 2),
    payment_status ENUM('Pain','Pending','Partially Paid') DEFAULT 'Pending',
    payment_date TIMESTAMP,
    insurance_claimed_amount DECIMAL(10, 2),
    insurance_status ENUM('Approved','Pending','Denied') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
    FOREIGN KEY (appointment_id) REFERENCES appointments(appointment_id)
);

CREATE TABLE payments (
    billing_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT, 
    appointment_id INT,
    total_amount DECIMAL(10, 2),
    amount_paid DECIMAL(10, 2),
    balance_due DECIMAL(10, 2),
    payment_status ENUM('Paid','Pending','Partially Paid') DEFAULT 'Pending',  -- Fixed typo 'Pain' to 'Paid'
    payment_date TIMESTAMP,
    insurance_claimed_amount DECIMAL(10, 2) DEFAULT NULL,  -- Set default as NULL if insurance info is optional
    insurance_status ENUM('Approved','Pending','Denied') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,  -- Adding cascading delete for better integrity
    FOREIGN KEY (appointment_id) REFERENCES appointments(appointment_id) ON DELETE CASCADE,  -- Adding cascading delete for better integrity
    INDEX idx_patient_id (patient_id),  -- Adding index on patient_id
    INDEX idx_appointment_id (appointment_id),  -- Adding index on appointment_id
    INDEX idx_payment_date (payment_date)  -- Adding index on payment_date for better querying performance
);
create backend by PHP
 
CREATE TABLE pharmacies (
    pharmacy_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    phone_number VARCHAR(15) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT chk_phone_number CHECK (phone_number REGEXP '^[0-9]+$')  -- Optional: ensuring only numbers for phone
);

CREATE TABLE insurance (
    insurance_id INT AUTO_INCREMENT PRIMARY KEY,
    provider_name VARCHAR(255) NOT NULL,
    policy_number VARCHAR(50) NOT NULL UNIQUE,
    coverage_type ENUM('Full', 'Partial') DEFAULT 'Partial',
    coverage_amount DECIMAL(10, 2) DEFAULT 0.00,  -- Assuming a default value of 0 for coverage_amount
    patient_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
    CONSTRAINT chk_dates CHECK (start_date <= end_date)  -- Ensuring start_date is before or equal to end_date
);

CREATE TABLE  insurance (
    insurance_id INT AUTO_INCREMENT PRIMARY KEY,
    provider_name VARCHAR(255),
    policy_number VARCHAR(50),
    coverage_type ENUM('Full','Partial') DEFAULT 'Partial',
    converage_amount DECIMAL(10, 2),
    patient_id INT,
    start_date DATE,
    end_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id)
);

ER-Diagram (Entity-Relationalship Diagram)
    This database structure can be visualized as an ER diagram, where:
Patients are related to Appointments , Medical_records, Prescriptions, Lab_tests and billing.
Appointments link Patients to Doctors and Medical Records.
Prescriptions are linked to Medical Records.
Billing is connected to Patients and Appointments.
Insurance is liked to Patients to handle coverage.





