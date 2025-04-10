-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2025 at 12:17 PM
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
  `LEVEL` varchar(20) NOT NULL,
  `SERVICE` varchar(100) NOT NULL,
  `TIME` time NOT NULL,
  `DATE` date NOT NULL,
  `NAME` varchar(30) NOT NULL,
  `VEHICLE_NO` varchar(14) NOT NULL,
  `ENGINEE` int(20) NOT NULL,
  `CHASIS` int(20) NOT NULL,
  `PRICE` varchar(100) NOT NULL,
  `PHONE_NUMBER` bigint(10) NOT NULL,
  `SPHERE_PART` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`ID`, `LEVEL`, `SERVICE`, `TIME`, `DATE`, `NAME`, `VEHICLE_NO`, `ENGINEE`, `CHASIS`, `PRICE`, `PHONE_NUMBER`, `SPHERE_PART`) VALUES
(10, 'Level 1', 'Bike Servicing', '12:15:00', '2025-04-23', 'CHANDAN SINGH', 'JH/05/CH/1688', 3456, 2343, '9999', 8340300338, ''),
(11, 'Level 1', 'Car Maintenance', '12:54:00', '2025-04-14', 'SNEHA SINGH', 'JH/05/CH/1688', 3456, 2343, '9999', 8340300338, ''),
(12, 'Level 2', 'Bike Servicing', '14:14:00', '2025-04-21', 'SNEHA SINGH', 'JH/05/CH/1688', 3456, 2343, '15000', 8340300338, ''),
(13, 'Level 3', 'Car Maintenance', '14:14:00', '2025-04-12', 'SNEHA SINGH', 'JH/05/EF/2345', 3456, 2343, '35000', 8340300338, '');

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
(13, 'amansharma22299@gmail.com', '2025-04-09', 'Present'),
(14, 'sohamchakroborty232005@gmail.com', '2025-04-09', 'Leave'),
(15, 'mrinmoykumarmahato@gmail.com', '2025-04-10', 'Absent'),
(16, 'amansharma22299@gmail.com', '2025-04-10', 'Present'),
(17, 'sohamchakroborty232005@gmail.com', '2025-04-10', 'Present');

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
(19, 'Sumit Gope', 'sumitgope00006@gmail.com', '200.webp', 'fgh gfhbj jjgh'),
(20, 'Sumit Gope', 'sumitgope00006@gmail.com', '', 'service is very good and the workers are very talented');

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
(37, 'aman', 'sharma', 'amansharma22299@gmail.com', '1234567890', '234554322346', NULL),
(38, 'MANGU RAM', 'HEMBRAM', 'sohamchakroborty232005@gmail.com', '7050601433', '409843437786', NULL);

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
(31, 'amansharma22299@gmail.com', 2, 1000.00, '2025-04-10 15:38:55'),
(32, 'mrinmoykumarmahato@gmail.com', 3, 1470.00, '2025-04-10 15:39:00'),
(33, 'sohamchakroborty232005@gmail.com', 1, 510.00, '2025-04-10 15:39:05');

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
(57, '4 Wheelers SUZUKI', 'JH/05/DL/9013', 'rntc0822031@nttf.co.in', '8884949597', 'Mobil Change', '2025-04-09', 300, 1, 'Bistupur'),
(58, '2 Wheelers BMW', 'JH/05/DL/9013', 'chaandaan42@gmail.com', '8340300338', 'Shock Absorbers', '2025-04-10', 5000, 2, 'Gamharia ,Jagannathpur'),
(59, '4 Wheelers HONDA', 'JH/05/DL/9013', 'chaandaan42@gmail.com', '8340300338', 'Diesel Filter', '2025-04-10', 1200, 2, 'ELECTRONIC CITY, NTTF BOYS HOSTEL'),
(60, '2 Wheelers BMW', 'JH/05/DL/9013', 'sohamchakroborty2005@gmail.com', '8340300338', 'Wiper Blade Replacem', '2025-04-10', 4000, 10, 'Gamharia ,Jagannathpur'),
(61, 'Audi SUV', 'JH/05/DL/9013', 'chaandaan42@gmail.com', '8340300338', 'Crankshaft Sensor', '2025-04-10', 4000, 2, 'ELECTRONIC CITY, NTTF BOYS HOSTEL'),
(62, '4 Wheelers HONDA', 'JH/05/DL/9013', 'chaandaan42@gmail.com', '8340300338', 'Timing Belt', '2025-04-10', 6000, 3, 'Bistupur'),
(63, '4 Wheelers FORD', 'JH/05/DL/9013', 'chaandaan42@gmail.com', '8340300338', 'Engine Mounts', '2025-04-10', 7000, 2, 'ELECTRONIC CITY, NTTF BOYS HOSTEL'),
(64, '2 Wheelers BMW', 'JH/05/DL/9013', 'chaandaan42@gmail.com', '8340300338', 'Camshaft', '2025-04-10', 48000, 4, 'ELECTRONIC CITY, NTTF BOYS HOSTEL'),
(65, '2 Wheelers SUZUKI', 'JH/05/DL/9013', 'chaandaan42@gmail.com', '8340300338', 'Engine Mounts', '2025-04-10', 21000, 6, 'ELECTRONIC CITY BANGALORE');

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
(26, 'Nikita', 'Kumari', 8884949597, 'rntc0822031@nttf.co.in', 'Nikitakumari@190', '2004-11-06', 'JAMSHEDPUR'),
(27, 'CHANDAN ', 'SINGH', 8340300338, 'chaandaan42@gmail.com', 'P@ssw0rd', '2004-05-29', 'JAMSHEDPUR'),
(28, 'MANGU', 'HEMBRAM', 7050601433, 'sohamchakroborty2005@gmail.com', 'P@ssw0rd', '2016-06-15', 'KARNATAKA');

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
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `emergency_appointment`
--
ALTER TABLE `emergency_appointment`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
