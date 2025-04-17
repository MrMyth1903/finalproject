-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2025 at 06:39 AM
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
  `EMAIL` varchar(50) NOT NULL,
  `VEHICLE_NO` varchar(14) NOT NULL,
  `ENGINEE` int(20) NOT NULL,
  `CHASIS` int(20) NOT NULL,
  `PRICE` varchar(100) NOT NULL,
  `PHONE_NUMBER` bigint(10) NOT NULL,
  `SPHERE_PART` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`ID`, `LEVEL`, `SERVICE`, `TIME`, `DATE`, `NAME`, `EMAIL`, `VEHICLE_NO`, `ENGINEE`, `CHASIS`, `PRICE`, `PHONE_NUMBER`, `SPHERE_PART`) VALUES
(72, 'Customized Service', 'Car Maintenance', '15:57:00', '2025-04-16', 'SNEHA CHANDAN SINGH', 'chaandaan42@gmail.com', 'JH/05/DL/2345', 345667, 874567, '17000', 8340300338, 'Fuel Injectors,oil filter'),
(73, 'Customized Service', 'Car Maintenance', '16:41:00', '2025-04-16', 'MANGU RAM HEMBRAM', 'chaandaan42@gmail.com', 'JH/05/DL/0005', 345667, 874567, '11000', 7050601433, 'Brake Rotors,Brake Lines,Brake Shoe'),
(75, 'Level 3', 'Car Maintenance', '12:00:00', '2025-04-18', 'BHARGAV KUMAR', 'kumarbhargav45943@gmail.com', 'JH/05/MK/9834', 456789, 234567, '25000', 8340300338, ''),
(76, 'Customized Service', 'Bike Servicing', '23:01:00', '2025-04-17', 'BHARGAV KUMAR', 'kumarbhargav45943@gmail.com', 'JH/05/SH/9834', 456789, 234567, '26000', 8340300338, 'Brake Pads, Brake Rotors');

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
(21, 'tiwarysurya861@gmail.com', '2025-04-12', 'Present'),
(22, 'tiwarysurya861@gmail.com', '2025-04-13', 'Present'),
(23, 'tiwarysurya861@gmail.com', '2025-04-14', 'Present'),
(24, 'manguramhembram@gmail.com', '2025-04-14', 'Present'),
(25, 'tiwarysurya861@gmail.com', '2025-04-15', 'Present'),
(26, 'manguramhembram@gmail.com', '2025-04-15', 'Present'),
(27, 'kumarbhargav45943@gmail.com', '2025-04-15', 'Absent');

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
(29, 'SURYA PRAKASH TIWARY', 'chaandaan42@gmail.com', 'python-essentials-2 (1).png', 'Good environment of Meri Gaddi !'),
(30, 'SNEHA SINGH', 'snehasingh@gmail.com', 'python-essentials-2 (1).png', 'Good and talented worker they have !'),
(31, 'BHARGAV', 'kumarbhargav45943@gmail.com', 'Blue Gold Minimalist Car Showroom Logo.png', 'Good work by meri gaddi team !');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `vendor_name` varchar(255) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `date_time` varchar(10) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_name`, `price`, `quantity`, `vendor_name`, `total_price`, `date_time`) VALUES
(8, 'Filter', 350.00, 7, 'SOHAM CHAKROBARTY', 2450.00, '2025-04-13'),
(9, 'Filter', 300.00, 4, 'SOHAM CHAKROBARTY', 1200.00, '2025-04-13');

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
(39, 'SURYA', 'TIWARY', 'tiwarysurya861@gmail.com', '6789034567', '409843437788', 'JH/05/DL/2345'),
(40, 'MANGU', 'HEMBRAM', 'manguramhembram@gmail.com', '7903428956', '789623457638', 'JH/05/CH/2345'),
(41, 'BHARGAV', 'KUMAR', 'kumarbhargav45943@gmail.com', '8340300338', '897634567856', 'JH/05/MK/9834');

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
(37, 'tiwarysurya861@gmail.com', 1, 500.00, '2025-04-12 13:54:41'),
(38, 'tiwarysurya861@gmail.com', 2, 1000.00, '2025-04-13 12:07:19'),
(44, 'manguramhembram@gmail.com', 2, 1000.00, '2025-04-15 23:08:26'),
(45, 'tiwarysurya861@gmail.com', 4, 2000.00, '2025-04-15 23:08:29'),
(46, 'kumarbhargav45943@gmail.com', 1, 500.00, '2025-04-15 23:08:49'),
(47, 'manguramhembram@gmail.com', 2, 1000.00, '2025-04-15 23:08:54'),
(48, 'tiwarysurya861@gmail.com', 4, 2000.00, '2025-04-15 23:08:58');

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
  `WANT` varchar(500) NOT NULL,
  `DATE` date NOT NULL DEFAULT current_timestamp(),
  `PRICE` int(100) NOT NULL,
  `QUANTITY` int(10) NOT NULL,
  `ADDRESS` varchar(50) NOT NULL,
  `SESSION_ID` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`ID`, `V_TYPE`, `V_NUMBER`, `EMAIL`, `PHONE`, `WANT`, `DATE`, `PRICE`, `QUANTITY`, `ADDRESS`, `SESSION_ID`) VALUES
(82, '2 Wheelers BMW', 'JH/05/CH/2345', 'manguramhembram@gmail.com', '8340300338', 'Tire Change', '2025-04-14', 2000, 4, 'Gamharia ,Jagannathpur', ''),
(83, 'Audi SUV', 'JH/05/CH/2345', 'chaandaan42@gmail.com', '7050601433', 'Intercooler', '2025-04-14', 18000, 2, 'Gamharia ,Jagannathpur', ''),
(84, 'Audi SUV', 'JH/05/CH/2345', 'chaandaan42@gmail.com', '7050601433', 'Expansion Valve', '2025-04-14', 4000, 1, 'Gamharia ,Jagannathpur', ''),
(85, 'Audi SUV', 'JH/05/CH/2345', 'chaandaan42@gmail.com', '7050601433', 'Tire Change,Mobil Ch', '2025-04-14', 3600, 3, 'Gamharia ,Jagannathpur', ''),
(86, '2 Wheelers AUDI', 'JH/05/CH/2345', 'chaandaan42@gmail.com', '7050601433', 'Mobil Change,Brake S', '2025-04-14', 1050, 1, 'ELECTRONIC CITY, NTTF BOYS HOSTEL', ''),
(94, '4 Wheelers Tata', 'JH/05/CH/2345', 'chaandaan42@gmail.com', '8340300338', 'Brake Pads,Brake Rotors', '2025-04-14', 13000, 1, 'Gamharia ,Jagannathpur', '');

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
(35, 'CHANDAN ', ' SINGH', 8340300338, 'chaandaan42@gmail.com', 'AarChaRan@1903', '2004-05-29', 'JAMSHEDPUR'),
(36, 'BHARGAV', 'KUMAR', 8340300338, 'kumarbhargav45943@gmail.com', 'P@ssw0rd', '2004-05-29', 'BANGALORE');

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
(18, 'SURYA PRAKASH TIWARI', '876523456734', 'suryatiwari66825@gmail.com', 'ELECTRONIC CITY, NTTF BOYS HOSTEL', '8340300338'),
(19, 'BHARGAV', '876523456789', 'kumarbhargav45943@gmail.com', 'ELECTRONIC CITY NTTF BOYS HOSTEL', '8340300338');

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
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `emergency_appointment`
--
ALTER TABLE `emergency_appointment`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
