-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2026 at 11:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `meditrack_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `doctor_id`, `appointment_date`, `status`) VALUES
(1, 1, 1, '2026-02-05', 'Scheduled'),
(2, 2, 2, '2026-02-05', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `bill_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `bill_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`bill_id`, `patient_id`, `amount`, `description`, `bill_date`) VALUES
(1, 1, 2500.00, 'Consultation and Blood Test', '2026-02-05'),
(2, 2, 1800.00, 'Pediatric Consultation', '2026-02-05');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `date_sent` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `date_sent`) VALUES
(1, 'Edu', 'jose@gmail.com', 'hey', '2026-02-10 21:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `discharge`
--

CREATE TABLE `discharge` (
  `discharge_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `discharge_date` date DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discharge`
--

INSERT INTO `discharge` (`discharge_id`, `patient_id`, `discharge_date`, `remarks`) VALUES
(1, 2, '2026-02-05', 'Patient stable and discharged');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `doctor_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `full_name`, `specialization`, `phone`) VALUES
(1, 'Dr. John Mwangi', 'General Physician', '0700111222'),
(2, 'Dr. Alice Njeri', 'Pediatrics', '0700222333');

-- --------------------------------------------------------

--
-- Table structure for table `lab_requests`
--

CREATE TABLE `lab_requests` (
  `lab_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `test_name` varchar(100) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_requests`
--

INSERT INTO `lab_requests` (`lab_id`, `patient_id`, `test_name`, `request_date`, `status`) VALUES
(1, 1, 'Blood Test', '2026-02-05', 'Pending'),
(2, 2, 'Malaria Test', '2026-02-05', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `offer_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `valid_until` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`offer_id`, `title`, `description`, `valid_until`) VALUES
(1, 'Free Blood Pressure Check', 'Complimentary BP check for all walk-in patients.', '2026-02-25'),
(2, '20% Lab Discount', 'Discount on selected laboratory tests this month.', '2026-03-12'),
(3, 'Maternity Package', 'Affordable maternity care including scans and delivery.', '2026-03-27');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date_registered` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `user_id`, `full_name`, `gender`, `age`, `phone`, `address`, `date_registered`) VALUES
(1, 4, 'Peter Kamau', 'Male', 29, '0712345678', 'Nairobi', '2026-02-05'),
(2, NULL, 'Jane Wanjiku', 'Female', 34, '0723456789', 'Kiambu', '2026-02-05'),
(3, 6, 'patrick macharia', 'Male', 22, '0110100508', 'nairobi', '2026-02-11'),
(4, 7, 'patrick macharia', 'Male', 22, '0110100508', 'nairobi', '2026-02-11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','doctor','receptionist','patient') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `username`, `password`, `phone`, `role`) VALUES
(1, 'Patrick Macharia', 'admin', '123', '0794839492', 'admin'),
(2, 'Dr. John Mwangi', 'drjohn', 'doctor123', '0700111222', 'doctor'),
(3, 'Mary Reception', 'reception', 'recept123', '0700333444', 'receptionist'),
(4, 'Peter Kamau', 'peter', 'patient123', '0712345678', 'patient'),
(6, 'patrick macharia', 'mach', '123', '0110100508', 'patient'),
(7, 'patrick macharia', 'jane', '123', '0110100508', 'patient');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discharge`
--
ALTER TABLE `discharge`
  ADD PRIMARY KEY (`discharge_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`doctor_id`);

--
-- Indexes for table `lab_requests`
--
ALTER TABLE `lab_requests`
  ADD PRIMARY KEY (`lab_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`offer_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`),
  ADD KEY `fk_patient_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `discharge`
--
ALTER TABLE `discharge`
  MODIFY `discharge_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lab_requests`
--
ALTER TABLE `lab_requests`
  MODIFY `lab_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `offer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`);

--
-- Constraints for table `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `billing_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);

--
-- Constraints for table `discharge`
--
ALTER TABLE `discharge`
  ADD CONSTRAINT `discharge_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);

--
-- Constraints for table `lab_requests`
--
ALTER TABLE `lab_requests`
  ADD CONSTRAINT `lab_requests_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `fk_patient_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
