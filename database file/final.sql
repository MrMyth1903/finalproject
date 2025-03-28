-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2025 at 05:06 PM
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

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`ID`, `SERVICE`, `TIME`, `DATE`, `NAME`, `VEHICLE_NO`, `WANT`, `SPHERE_PART`, `PHONE_NUMBER`) VALUES
(8, 'Car Maintenance', '21:42:00', '2025-03-27', 'VISHAL', 'JH/05/CH/2345', 'Other', '', 7050601433);

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
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) NOT NULL,
  `phoneNumber` varchar(15) NOT NULL,
  `aadharNo` varchar(20) NOT NULL,
  `vehicle` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `firstname`, `middlename`, `lastname`, `phoneNumber`, `aadharNo`, `vehicle`) VALUES
(14, 'Sukhbir', '', 'Singh', '07050603314', '2342654876897', 'JH/05/EF/2345'),
(15, 'NAVIN', 'KUMAR', 'SHARMA', '8340300338', '234567892378', 'JH/05/DL/9013');

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
(15, '2 Wheelers', 'jh/05/dl/9834', '', '8340300338', 'Tire Change', '2025-03-27', 2000, 4, 'GAMHARIA'),
(16, '2 Wheelers', 'JH/05/DL/9834', '', '8340300338', 'Mobile Tank', '2025-03-27', 1050, 3, 'safs'),
(17, '2 Wheelers', 'JH/05/DL/9834', '', '8340300338', 'Mobile Tank', '2025-03-27', 1050, 3, 'safs'),
(18, '2 Wheelers', 'JH/05/DL/9834', '', '8340300338', 'Deeper', '2025-03-27', 1000, 1, 'hgjh'),
(19, '2 Wheelers', 'JH/05/DL/9834', '', '8340300338', 'Head Light', '2025-03-27', 600, 4, 'dfgdf'),
(20, '2 Wheelers', 'JH/05/DL/9834', '', '8340300338', 'Diesel Tank', '2025-03-28', 1800, 4, 'fghrt'),
(21, '2 Wheelers', 'JH/05/DL/9834', '', '8340300338', 'Diesel Tank', '2025-03-28', 1800, 4, 'jhj jkhj'),
(22, '2 Wheelers', 'JH/05/DL/9834', '', '8340300338', 'Brake Issue', '2025-03-28', 2400, 4, 'jhass jkash '),
(23, '2 Wheelers', 'JH/05/DL/9834', '', '8340300338', 'Brake Issue', '2025-03-28', 2400, 4, 'jhass jkash '),
(26, '2 Wheelers', 'JH/05/DL/9834', 'ranjan@gmail.com', '8340300338', 'Brake Issue', '2025-03-28', 600, 1, 'mbh'),
(27, '4 Wheelers', 'JH/05/DL/9834', 'chaandaan42@gmail.co', '8340300338', 'Diesel Tank', '2025-03-28', 900, 2, 'Gamharia ,Jagannathpur'),
(28, '4 Wheelers', 'JH/05/DL/9834', 'ranjan@gmail.com', '8340300338', 'Diesel Tank', '2025-03-28', 900, 2, 'Gamharia ,Jagannathpur'),
(29, '4 Wheelers', 'JH/05/DL/9834', 'chaandaan42@gmail.com', '8340300338', 'Coolent Change', '2025-03-28', 350, 1, 'hgjh'),
(30, '4 Wheelers', 'JH/05/DL/9834', 'chaandaan42@gmail.com', '8340300338', 'Coolent Change', '2025-03-28', 350, 1, 'hgjh'),
(31, '2 Wheelers', 'JH/05/DL/9834', 'soham@gmail.com', '8340300338', 'Coolent Change', '2025-03-28', 1050, 3, 'Gmaharia');

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
(7, 'CHANDAN SINGH', 'CHANDAN SINGH', 8340300338, 'chaandaan42@gmail.com', 'P@ssw0rd', '2004-05-29', 'JAMSHEDPUR'),
(10, 'RANJAN', 'SINGH', 8340300338, 'ranjan@gmail.com', 'P@ssw0rd', '2004-02-09', 'JAMSHEDPUR'),
(11, 'SOHAM', 'CHAKROBARTY', 8340300338, 'soham@gmail.com', 'P@ssw0rd', '2025-03-05', 'KARNATAKA');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `ID` int(100) NOT NULL,
  `VEN_NAME` varchar(50) NOT NULL,
  `AADHAR_NO` varchar(12) NOT NULL,
  `EMAIL` varchar(20) NOT NULL,
  `ADDRESS` varchar(100) NOT NULL,
  `PHONE` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`ID`, `VEN_NAME`, `AADHAR_NO`, `EMAIL`, `ADDRESS`, `PHONE`) VALUES
(5, 'CHANDAN SINGH', '234567892191', 'chaandaan42@gmail.co', 'Gamharia ,Jagannathpur', '2147483647'),
(6, 'CHANDAN SINGH', '234567892191', 'chaandaan42@gmail.co', 'Gamharia ,Jagannathpur', '8340300338');

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
  ADD UNIQUE KEY `aadharNo` (`aadharNo`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
