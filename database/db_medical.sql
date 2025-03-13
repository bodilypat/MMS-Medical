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

CREATE TABLE patients(
    patient_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    date_of_birth DATE NOT NULL,
    gender ENUM('male','Female','Other') NOT NULL,
    email VARCHAR(100),
    phone_number VARCHAR(15) UNIQUE NOT NULL,
    address VARCHAR(255),
    insurance_provider VARCHAR(100),
    insurance_policy_number VARCHAR(50),
    primary_care_physician VARCHAR(100),
    medical_hostory TEXT,
    allergies TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('Active','Inaction','Deceased') DEFAULT 'Active'
);

CREATE TABLE doctors(
    doctor_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    specialization VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone_number VARCHAR(15) UNIQUE NOT NULL,
    department VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE medical_records (
    record_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    appointment_id INT,
    diagnosis VARCHAR(255),
    treatment_plan TEXT,
    note TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (appointment_id) REFERENCES appointments(appointment_id)
);

CREATE TABLE appointments(
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    appointment_date DATETIME NOT NULL,
    reason_for_visit VARCHAR(255),
    status ENUM('Scheduled','completed','Cancelled','No-Show') DEFAULT 'Scheduled',
    created_at TIMESTAMP CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
    FOREIGN key (doctor_id) REFERENCES doctors(doctor_id)
);

CREATE TABLE prescriptions(
    prescription_id INT AUTO_INCREMENT PRIMARY KEY,
    record_id INT,
    medication_name VARCHAR(255),
    dosage VARCHAR(50),
    frequency VARCHAR(50),
    start_date DATE,
    end_date DATE,
    instructions TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (records_id) REFERENCES medical_records(record_id)
);

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

CREATE TABLE billing (
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

CREATE TABLE pharmacies (
    pharmacy_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    address VARCHAR(255),
    phone_number VARCHAR(15),
    email VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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





