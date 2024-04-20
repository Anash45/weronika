-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2024 at 02:07 AM
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
  `sender` enum('user','admin') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`MessageID`, `UserID`, `MessageContent`, `Timestamp`, `sender`) VALUES
(1, 3, 'Hey', '2024-04-19 23:39:20', 'user'),
(2, 3, 'Hey', '2024-04-19 23:39:26', 'user'),
(3, 3, 'Hey', '2024-04-19 23:39:44', 'user'),
(4, 3, 'Hey', '2024-04-19 23:39:53', 'user'),
(5, 3, 'I\'m here.', '2024-04-19 23:40:35', 'user'),
(6, 3, 'I\'m here.', '2024-04-19 23:40:43', 'user'),
(7, 3, 'I\'m here.', '2024-04-19 23:41:17', 'user'),
(8, 3, 'Yes Sir.', '2024-04-19 23:43:24', 'admin'),
(9, 3, 'Hey sir, kindly approve the spot for my <a href=\"vehicle-details.php?id=3\">vehicle</a>.', '2024-04-19 23:53:51', 'user'),
(10, 3, 'Hey sir, kindly approve the spot for my <a href=\"vehicle-details.php?id=3\">vehicle</a>.', '2024-04-19 23:54:24', 'user');

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
(3, 'TEST', 'test', 'abc1@xyz.com', '1234123412', '$2y$10$8ASOtQlUelFWWsrS2l.8v.hmwy5SwxQJ9v.NzhwE2DZmGAaQ7JBoe', 'user', '2024-04-19 22:21:26', NULL);

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
(3, 'Truck', 'Honda', '12341234123412341', 'Corolla', '1234213', '12341234', '1234123', '85OzfQdoYe', '2024-04-26', '2024-04-27', '2024-04-22', 0, '2024-04-19 22:21:57', 3);

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
  MODIFY `MessageID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
