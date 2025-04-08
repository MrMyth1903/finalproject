-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2025 at 10:32 AM
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
(24, 'SURYA', 'TIWARY', 'tiwarysurya861@gmail.com', '6789034567', '234567899876', ''),
(26, 'CHANDAN', 'SINGH', 'chaandaan42@gmail.com', '8340300338', '876589345632', 'JH/05/CH/1688');

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
(1, 'tiwarysurya861@gmail.com', 2, 400.00, '2025-04-08 12:10:35'),
(2, 'tiwarysurya861@gmail.com', 30, 9000.00, '2025-04-08 12:11:11'),
(3, 'tiwarysurya861@gmail.com', 30, 9000.00, '2025-04-08 13:05:16'),
(4, 'tiwarysurya861@gmail.com', 30, 9000.00, '2025-04-08 13:09:43'),
(5, 'tiwarysurya861@gmail.com', 27, 13500.00, '2025-04-08 13:11:02'),
(6, 'tiwarysurya861@gmail.com', 22, 9900.00, '2025-04-08 13:11:51'),
(7, 'chaandaan42@gmail.com', 20, 17000.00, '2025-04-08 13:26:09'),
(8, 'chaandaan42@gmail.com', 30, 28500.00, '2025-04-08 13:33:04'),
(9, 'chaandaan42@gmail.com', 12, 6720.00, '2025-04-08 13:35:52'),
(10, 'tiwarysurya861@gmail.com', 14, 9800.00, '2025-04-08 13:36:03'),
(11, 'chaandaan42@gmail.com', 24, 19200.00, '2025-04-08 13:44:44'),
(12, 'tiwarysurya861@gmail.com', 25, 20000.00, '2025-04-08 13:44:54'),
(13, 'chaandaan42@gmail.com', 2, 600.00, '2025-04-08 13:45:16'),
(14, 'chaandaan42@gmail.com', 9, 7200.00, '2025-04-08 13:47:24'),
(15, 'tiwarysurya861@gmail.com', 6, 4800.00, '2025-04-08 13:48:35');

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
(53, '4 Wheelers HYUNDAI', 'JH/05/DH/5301', 'mrinmoykumarmahato@gmail.com', '8340300338', 'Brake Shoe Change', '2025-04-07', 800, 2, 'ELECTRONIC CITY BANGALORE'),
(54, '4 Wheelers TYOTA', 'JH/05/DL/9834', 'mrinmoykumarmahato@gmail.com', '8340300338', 'Diesel Tank', '2025-04-07', 900, 2, 'Sonari'),
(55, '2 Wheelers BMW', 'JH/05/CH/1688', 'chaandaan42@gmail.com', '8340300338', 'Coolent Change', '2025-04-07', 700, 2, 'Gamharia ,Jagannathpur');

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
(24, 'MRINMOY KUMAR', 'MAHATO', 8340300338, 'mrinmoykumarmahato@gmail.com', 'P@ssw0rd', '2004-05-29', 'Sonari'),
(25, 'CHANDAN', 'SINGH', 8340300338, 'chaandaan42@gmail.com', 'P@ssw0rd', '2004-05-29', 'JAMSHEDPUR');

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
(12, 'SURYA PRAKASH TIWARI', '8765234564', 'sohamchakraborty252005@gmail.com', 'ELECTRONIC CITY BANGALORE', '834030033823'),
(13, 'SURYA PRAKASH TIWARI', '876523426734', 'tiwarisurea@gmail.com', 'ELECTRONIC CITY, NTTF BOYS HOSTEL', '8340300338');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`ID`);

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
  ADD KEY `email` (`email`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`email`) REFERENCES `members` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
