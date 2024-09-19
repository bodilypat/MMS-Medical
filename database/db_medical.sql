CREATE TABLE doctors(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    specialization VARCHAR(100) NOT NULL,
    email VARCHAR NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE medical_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    record_date DATETIME NOT NULL,
    diagnosis TEXT NOT NULL,
    notes TEXT,
    teatment TEXT NOT NULL,
    created_at TIMESTAMP CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (doctor_id) REFERENCES doctors(id),
);

CREATE TABLE appointments(
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    appointment_date DATETIME NOT NULL,
    reason TEXT,
    status ENUM('Scheduled','completed','Cancelled') DEFAULT 'Scheduled',
    created_at TIMESTAMP CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN key (doctor_id) REFERENCES doctors(id)
);

CREATE TABLE prescriptions(
    int INT AUTO_INCREMENT PRIMARY KEY,
    patent_id INT NOT NULL,
    doctor_id INT NOT NULL,
    medication VARCHAR(100) NOT NULL,
    dosage VARCHAR(100) NOT NULL,
    frequency VARCHAR(100) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patent_id) REFERENCES patents(id),
    FOREIGN KEY (doctor_id) REFERENCES doctors(id)
);

CREATE TABLE patients(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    age INT NULL,
    gender ENUM('male','Female','Other') NOT NULL,
    medical_history TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE billing (
    id INT AUTO_INCREMENT PRIMARY key,
    patient_id INT, NOT NULL,
    appointment_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    billing_date DATETIME CURRENT_TIMESTAMP,
    status ENUM('Paid','Pending', 'cancelled') DEFAULT 'Pending',
    create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patent_id) REFERENCES patients(id),
    FOREIGN KEY (appointment_id) REFERENCES medical_appointments(id)
);
