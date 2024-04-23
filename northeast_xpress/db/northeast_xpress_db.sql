-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2024 at 03:46 AM
-- Server version: 8.0.35
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `northeast_xpress_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `MessageID` int NOT NULL,
  `UserID` int DEFAULT NULL,
  `MessageContent` text COLLATE utf8mb4_general_ci,
  `Timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `sender` enum('user','admin') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user',
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `isRequest` tinyint(1) NOT NULL DEFAULT '0',
  `requestID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`MessageID`, `UserID`, `MessageContent`, `Timestamp`, `sender`, `read`, `isRequest`, `requestID`) VALUES
(1, 3, 'Hey', '2024-04-19 23:39:20', 'user', 1, 0, 0),
(2, 3, 'Hey', '2024-04-19 23:39:26', 'user', 1, 0, 0),
(3, 3, 'Hey', '2024-04-19 23:39:44', 'user', 1, 0, 0),
(4, 3, 'Hey', '2024-04-19 23:39:53', 'user', 1, 0, 0),
(5, 3, 'I\'m here.', '2024-04-19 23:40:35', 'user', 1, 0, 0),
(6, 3, 'I\'m here.', '2024-04-19 23:40:43', 'user', 1, 0, 0),
(7, 3, 'I\'m here.', '2024-04-19 23:41:17', 'user', 1, 0, 0),
(8, 3, 'Yes Sir.', '2024-04-19 23:43:24', 'admin', 1, 0, 0),
(9, 3, 'Hey sir, kindly approve the spot for my <a href=\"vehicle-details.php?id=3\">vehicle</a>.', '2024-04-19 23:53:51', 'user', 1, 0, 0),
(10, 3, 'Hey sir, kindly approve the spot for my <a href=\"vehicle-details.php?id=3\">vehicle</a>.', '2024-04-19 23:54:24', 'user', 1, 0, 0),
(11, 3, 'aa', '2024-04-20 01:33:48', 'admin', 1, 0, 0),
(12, 3, 'hey', '2024-04-20 01:34:44', 'user', 1, 0, 0),
(13, 3, 'aa', '2024-04-20 01:36:06', 'admin', 1, 0, 0),
(14, 3, 'aasdsha dsad jsdjsasa', '2024-04-20 01:38:55', 'user', 1, 0, 0),
(15, 3, '<b>Subject:</b> Vehicle Repair Request\r\n    <b>From:</b> Syed Muhammad Anas Bukhari\r\n    <b>Email:</b> f4futuretech@gmail.com\r\n    <b>Message:</b> Want to get my vehicle done.', '2024-04-20 01:39:53', 'user', 1, 0, 0),
(16, 3, '<b>Subject:</b> Vehicle Repair Request<br>\r\n    <b>From:</b> Syed Muhammad Anas Bukhari <br>\r\n    <b>Email:</b> f4futuretech@gmail.com <br>\r\n    <b>Message:</b> Abcd', '2024-04-20 01:40:17', 'user', 1, 0, 0),
(17, 3, 'aa', '2024-04-20 01:41:12', 'admin', 1, 0, 0),
(21, 3, 'Helloo', '2024-04-22 20:56:43', 'user', 1, 0, 0),
(22, 4, 'Hi admin.', '2024-04-22 20:57:44', 'user', 0, 0, 0),
(23, 4, 'Hi admin.', '2024-04-22 20:57:48', 'user', 1, 0, 0),
(24, 4, 'How are you', '2024-04-22 20:57:56', 'user', 1, 0, 0),
(25, 4, 'Requesting parking space starting Apr 11, 2024 for this <a href=\"vehicle-details.php?id=\">vehicle</a>.', '2024-04-23 00:48:04', 'user', 1, 1, 4),
(26, 4, 'Requesting parking space starting <b>April 163012, 2024</b> for this <a href=\"vehicle-details.php?id=\">vehicle</a>.', '2024-04-23 00:49:00', 'user', 1, 1, 4),
(27, 4, 'Requesting parking space starting <b>April 12, 2024</b> for this <a href=\"vehicle-details.php?id=\">vehicle</a>.', '2024-04-23 00:49:21', 'user', 1, 1, 4),
(28, 4, '<b>Subject: Vehicle Repair Request</b><br>\r\n    <b>From:</b> Syed Muhammad Anas Bukhari <br>\r\n    <b>Email:</b> f4futuretech@gmail.com <br>\r\n    <b>Message:</b> aaaa', '2024-04-23 01:23:25', 'user', 1, 0, 0),
(29, 2, 'Hey', '2024-04-23 01:24:05', 'admin', 0, 0, 0),
(30, 2, 'Hey', '2024-04-23 01:24:08', 'admin', 1, 0, 0),
(31, 2, 'hey', '2024-04-23 01:24:40', 'admin', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int NOT NULL,
  `FirstName` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `LastName` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Phone` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'user',
  `CreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `otp` varchar(6) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `FirstName`, `LastName`, `Email`, `Phone`, `Password`, `Role`, `CreatedAt`, `otp`) VALUES
(2, 'Admin', 'First', 'abc@xyz.com', '1234123412', '$2y$10$BN4Kn.Q/EAWV8vQJD.Z9bu8aPH/0pOE01y5lIjbgPr913idXp53XK', 'admin', '2024-04-19 20:18:05', NULL),
(3, 'TEST', 'test', 'abc1@xyz.com', '1234123412', '$2y$10$8ASOtQlUelFWWsrS2l.8v.hmwy5SwxQJ9v.NzhwE2DZmGAaQ7JBoe', 'user', '2024-04-19 22:21:26', NULL),
(4, 'Syed Muhammad Anas', 'Bukhari', 'abc2@xyz.com', '0345786869', '$2y$10$Si8GfqaVRxcObTIzt1JZc.XmaU87zfNoVs2aiTXNzMEoWbTQR5NZe', 'user', '2024-04-22 20:57:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int NOT NULL,
  `vehicleType` enum('Truck','Trailer') COLLATE utf8mb4_general_ci NOT NULL,
  `companyName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `truckNumber` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `truckMake` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `truckPlateNumber` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `DOTNumber` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `MCNumber` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `insurancePolicyNumber` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `insurancePolicyExpirationDate` date NOT NULL,
  `federalInspectionExpirationDate` date NOT NULL,
  `stateInspectionExpirationDate` date NOT NULL,
  `approved` tinyint(1) DEFAULT '0',
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UserID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `vehicleType`, `companyName`, `truckNumber`, `truckMake`, `truckPlateNumber`, `DOTNumber`, `MCNumber`, `insurancePolicyNumber`, `insurancePolicyExpirationDate`, `federalInspectionExpirationDate`, `stateInspectionExpirationDate`, `approved`, `createdAt`, `UserID`) VALUES
(2, 'Truck', 'Toyota', '12341234123412341', 'Corolla', 'ABG1234', '12341234', '1234123', '1bMBSKkEbd', '2024-04-26', '2024-04-27', '2024-04-22', 0, '2024-04-19 21:34:39', 2),
(3, 'Truck', 'Honda', '12341234123412341', 'Corolla', '1234213', '12341234', '1234123', '85OzfQdoYe', '2024-04-26', '2024-04-27', '2024-04-22', 0, '2024-04-19 22:21:57', 3),
(4, 'Truck', 'CHEVY', '12341234123412341', 'Ford', '12341234', '12341234', '1234123', '12344231', '2024-04-26', '2024-04-27', '2024-06-07', 2, '2024-04-23 00:24:53', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`MessageID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_UserID` (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `MessageID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `FK_UserID` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
