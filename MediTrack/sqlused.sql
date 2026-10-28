-- ===============================
-- MediTrack HMS FULL DATABASE SETUP
-- Admin: Patrick Macharia | Password: 123
-- ===============================

DROP DATABASE IF EXISTS meditrack_db;
CREATE DATABASE meditrack_db;
USE meditrack_db;

-- ===============================
-- USERS TABLE (NO HASHING)
-- ===============================
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    phone VARCHAR(20),
    role ENUM('admin','doctor','receptionist','patient') NOT NULL
);

INSERT INTO users (full_name, username, password, phone, role) VALUES
('Patrick Macharia', 'admin', '123', '0794839492', 'admin'),
('Dr. John Mwangi', 'drjohn', 'doctor123', '0700111222', 'doctor'),
('Mary Reception', 'reception', 'recept123', '0700333444', 'receptionist'),
('Peter Kamau', 'peter', 'patient123', '0712345678', 'patient');

-- ===============================
-- PATIENTS TABLE
-- ===============================
CREATE TABLE patients (
    patient_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100),
    gender VARCHAR(10),
    age INT,
    phone VARCHAR(20),
    address TEXT,
    date_registered DATE
);

INSERT INTO patients VALUES
(1,'Peter Kamau','Male',29,'0712345678','Nairobi',CURDATE()),
(2,'Jane Wanjiku','Female',34,'0723456789','Kiambu',CURDATE());

-- ===============================
-- DOCTORS TABLE
-- ===============================
CREATE TABLE doctors (
    doctor_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100),
    specialization VARCHAR(100),
    phone VARCHAR(20)
);

INSERT INTO doctors VALUES
(1,'Dr. John Mwangi','General Physician','0700111222'),
(2,'Dr. Alice Njeri','Pediatrics','0700222333');

-- ===============================
-- APPOINTMENTS TABLE
-- ===============================
CREATE TABLE appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    doctor_id INT,
    appointment_date DATE,
    status VARCHAR(50),
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id)
);

INSERT INTO appointments VALUES
(1,1,1,CURDATE(),'Scheduled'),
(2,2,2,CURDATE(),'Completed');

-- ===============================
-- LAB REQUESTS
-- ===============================
CREATE TABLE lab_requests (
    lab_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    test_name VARCHAR(100),
    request_date DATE,
    status VARCHAR(50),
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id)
);

INSERT INTO lab_requests VALUES
(1,1,'Blood Test',CURDATE(),'Pending'),
(2,2,'Malaria Test',CURDATE(),'Completed');

-- ===============================
-- BILLING
-- ===============================
CREATE TABLE billing (
    bill_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    amount DECIMAL(10,2),
    description TEXT,
    bill_date DATE,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id)
);

INSERT INTO billing VALUES
(1,1,2500.00,'Consultation and Blood Test',CURDATE()),
(2,2,1800.00,'Pediatric Consultation',CURDATE());

-- ===============================
-- DISCHARGE
-- ===============================
CREATE TABLE discharge (
    discharge_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    discharge_date DATE,
    remarks TEXT,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id)
);

INSERT INTO discharge VALUES
(1,2,CURDATE(),'Patient stable and discharged');

-- ===============================
-- END
-- ===============================

MediTrack/
├── config/
│   └── db.php
├── includes/
│   ├── header.php
│   └── footer.php
├── assets/
│   ├── css/
│   │   └── style.css
│   └── images/
├── auth/
│   ├── login.php
│   └── logout.php
├── admin/
│   └── dashboard.php
├── doctor/
│   └── dashboard.php
├── receptionist/
│   └── dashboard.php
├── patient/
│   └── dashboard.php
├── reports/
├── index.php
└── dashboard.php

offline with no hash passwords to be used with xampp.......project name "MediTrack Hospital Information Management  System ".... general objectives "To develop an integrated Hospital Management Information System that streamlines hospital operations, enhances patient care, and improves the efficiency of healthcare service delivery."...specific objectives  ..."To register and manage patients information. To schedule and manage doctor appointments. To generate billing and medical reports. To store and retrieve  patients records. To discharge patients. To help patients request a lab test."...our theme color for the project to use is white and blue