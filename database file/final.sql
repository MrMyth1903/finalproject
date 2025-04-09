-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2025 at 11:10 AM
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
-- Database: `final`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `ID` int(100) NOT NULL,
  `SERVICE` varchar(100) NOT NULL,
  `TIME` time NOT NULL,
  `DATE` date NOT NULL,
  `NAME` varchar(30) NOT NULL,
  `VEHICLE_NO` varchar(14) NOT NULL,
  `WANT` varchar(100) NOT NULL,
  `SPHERE_PART` varchar(100) NOT NULL,
  `PHONE_NUMBER` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `email`, `date`, `status`) VALUES
(1, 'mrinmoykumarmahato@gmail.com', '2025-04-09', 'Present'),
(2, 'tiwarysurya861@gmail.com', '2025-04-09', 'Absent'),
(3, 'mrinmoykumarmahato@gmail.com', '2025-04-09', 'Present'),
(4, 'tiwarysurya861@gmail.com', '2025-04-09', 'Present'),
(5, 'mrinmoykumarmahato@gmail.com', '2025-04-09', 'Half-Day'),
(6, 'tiwarysurya861@gmail.com', '2025-04-09', 'Present'),
(7, 'mrinmoykumarmahato@gmail.com', '2025-04-09', 'Absent'),
(8, 'mrinmoykumarmahato@gmail.com', '2025-04-09', 'Present'),
(9, 'mrinmoykumarmahato@gmail.com', '2025-04-09', 'Half-Day'),
(10, 'mrinmoykumarmahato@gmail.com', '2025-04-09', 'Absent'),
(11, 'mrinmoykumarmahato@gmail.com', '2025-04-09', 'Absent'),
(12, 'chaandaan42@gmail.com', '2025-04-09', 'Present'),
(13, 'amansharma22299@gmail.com', '2025-04-09', 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `emergency_appointment`
--

CREATE TABLE `emergency_appointment` (
  `ID` int(100) NOT NULL,
  `SERVICE` varchar(20) NOT NULL DEFAULT 'EMERG APPOINT',
  `DATE` date NOT NULL,
  `TIME` time(6) NOT NULL,
  `NAME` varchar(20) NOT NULL,
  `VEHICLE_NO` varchar(14) NOT NULL,
  `WANT` varchar(100) NOT NULL,
  `SPHERE_PART` varchar(10) NOT NULL,
  `PHONE_NUMBER` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emergency_appointment`
--

INSERT INTO `emergency_appointment` (`ID`, `SERVICE`, `DATE`, `TIME`, `NAME`, `VEHICLE_NO`, `WANT`, `SPHERE_PART`, `PHONE_NUMBER`) VALUES
(1, 'Emergency Repair', '2025-02-18', '00:00:00.000000', 'CHANDAN SINGH ', '', '', '', 0),
(2, 'Emergency Repair', '2025-02-18', '23:00:00.000000', 'SNEHA SINGH', '', '', '', 0),
(3, 'Emergency Repair', '2025-02-21', '14:11:00.000000', 'SNEHA SINGH', '', '', '', 0),
(4, 'Emergency Repair', '2025-02-13', '14:33:00.000000', 'Soham ', '', '', '', 0),
(5, 'Emergency Repair', '2025-02-13', '14:33:00.000000', 'Soham ', '', '', '', 0),
(6, 'Emergency Repair', '2004-02-20', '17:04:00.000000', 'Sukhbir Singh', '', '', '', 0),
(7, 'Emergency Repair', '2025-03-04', '14:12:00.000000', 'CHANDAN SINGH', 'JH/05/DL/9834', 'Brake Issue', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `ID` int(100) NOT NULL,
  `NAME` varchar(50) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `IMAGE` varchar(255) NOT NULL,
  `FEEDBACK` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`ID`, `NAME`, `EMAIL`, `IMAGE`, `FEEDBACK`) VALUES
(18, 'Sumit Gope', 'sumitgope00006@gmail.com', 'python-essentials-1.1.png', 'xzccsdc'),
(19, 'Sumit Gope', 'sumitgope00006@gmail.com', '200.webp', 'fgh gfhbj jjgh');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `phoneNumber` varchar(15) NOT NULL,
  `aadharNo` varchar(20) NOT NULL,
  `vehicle` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `firstname`, `lastname`, `email`, `phoneNumber`, `aadharNo`, `vehicle`) VALUES
(34, 'MRINMOY KUMAR', 'MAHATO', 'mrinmoykumarmahato@gmail.com', '8340300338', '234554322345', 'JH/05/EF/2343'),
(37, 'aman', 'sharma', 'amansharma22299@gmail.com', '1234567890', '234554322346', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `working_days` int(11) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `email`, `working_days`, `amount_paid`, `payment_date`) VALUES
(23, 'mrinmoykumarmahato@gmail.com', 20, 8000.00, '2025-04-09 10:25:26'),
(24, 'tiwarysurya861@gmail.com', 10, 3500.00, '2025-04-09 10:27:55'),
(25, 'mrinmoykumarmahato@gmail.com', 4, 2000.16, '2025-04-09 14:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `ID` int(11) NOT NULL,
  `TITLE` varchar(100) NOT NULL,
  `IMAGE` varchar(255) NOT NULL,
  `CONTENT` varchar(500) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `DATE` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`ID`, `TITLE`, `IMAGE`, `CONTENT`, `NAME`, `DATE`) VALUES
(37, 'Environment', 'uploads/200.webp', 'Good work by meri gaddi!', 'Sumit Gope', '2025-03-27');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `ID` int(100) NOT NULL,
  `V_TYPE` varchar(20) NOT NULL,
  `V_NUMBER` varchar(14) NOT NULL,
  `EMAIL` varchar(30) NOT NULL,
  `PHONE` varchar(12) NOT NULL,
  `WANT` varchar(20) NOT NULL,
  `DATE` date NOT NULL DEFAULT current_timestamp(),
  `PRICE` int(100) NOT NULL,
  `QUANTITY` int(10) NOT NULL,
  `ADDRESS` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`ID`, `V_TYPE`, `V_NUMBER`, `EMAIL`, `PHONE`, `WANT`, `DATE`, `PRICE`, `QUANTITY`, `ADDRESS`) VALUES
(50, '2 Wheelers AUDI', 'JH/05/CH/1688', 'snehasingh@gmail.com', '7050603314', 'Mobile Tank', '2025-04-03', 350, 1, 'Gmaharia'),
(51, '4 Wheelers MERCIDISE', 'JH/05/CH/1688', 'snehasingh@gmail.com', '7050603314', 'Mobile Tank', '2025-04-03', 350, 1, 'ELECTRONIC CITY, NTTF BOYS HOSTEL'),
(56, '4 Wheelers SUZUKI', 'JH/05/DL/9013', 'rntc0822031@nttf.co.in', '8884949597', 'Tire Change', '2025-04-09', 1000, 2, 'Bistupur'),
(57, '4 Wheelers SUZUKI', 'JH/05/DL/9013', 'rntc0822031@nttf.co.in', '8884949597', 'Mobil Change', '2025-04-09', 300, 1, 'Bistupur');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(12) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  `Phone` bigint(10) NOT NULL,
  `Mail` varchar(30) NOT NULL,
  `Password` varchar(16) NOT NULL,
  `DOB` date NOT NULL,
  `City` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `FirstName`, `LastName`, `Phone`, `Mail`, `Password`, `DOB`, `City`) VALUES
(26, 'Nikita', 'Kumari', 8884949597, 'rntc0822031@nttf.co.in', 'Nikitakumari@190', '2004-11-06', 'JAMSHEDPUR');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `ID` int(100) NOT NULL,
  `VEN_NAME` varchar(50) NOT NULL,
  `AADHAR_NO` varchar(12) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `ADDRESS` varchar(100) NOT NULL,
  `PHONE` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`ID`, `VEN_NAME`, `AADHAR_NO`, `EMAIL`, `ADDRESS`, `PHONE`) VALUES
(17, 'SURYA PRAKASH TIWARI', '876523456734', 'chaandaan42@gmail.com', 'ELECTRONIC CITY BANGALORE', '8340300338');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emergency_appointment`
--
ALTER TABLE `emergency_appointment`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phoneNumber` (`phoneNumber`),
  ADD UNIQUE KEY `aadharNo` (`aadharNo`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_child_id` (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `emergency_appointment`
--
ALTER TABLE `emergency_appointment`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
