-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 05, 2020 at 05:34 AM
-- Server version: 10.5.8-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `invoice-manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `ID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employerID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hourlyRate` int(15) NOT NULL,
  `job` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`ID`, `userID`, `employerID`, `hourlyRate`, `job`) VALUES
('5bf33089-06da-11eb-983a-84fdd1be0091', '2e40c516-06da-11eb-983a-84fdd1be0091', '081388ea-06da-11eb-983a-84fdd1be0091', 5000, 'testee');

-- --------------------------------------------------------

--
-- Table structure for table `employer`
--

CREATE TABLE `employer` (
  `ID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `companyName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employer`
--

INSERT INTO `employer` (`ID`, `userID`, `companyName`) VALUES
('081388ea-06da-11eb-983a-84fdd1be0091', 'dc0591bc-06cd-11eb-983a-84fdd1be0091', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `ID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employerID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`ID`, `employerID`, `created`, `updated`) VALUES
('4ffa2d42-36b5-11eb-b8e2-84fdd1be0091', '081388ea-06da-11eb-983a-84fdd1be0091', '2020-12-05 14:49:52', '2020-12-05 15:12:55');

-- --------------------------------------------------------

--
-- Table structure for table `invoiceItem`
--

CREATE TABLE `invoiceItem` (
  `ID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoiceID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `workSessionID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoiceItem`
--

INSERT INTO `invoiceItem` (`ID`, `invoiceID`, `workSessionID`) VALUES
('884c1263-36b8-11eb-b8e2-84fdd1be0091', '4ffa2d42-36b5-11eb-b8e2-84fdd1be0091', '72d7f9a5-2798-11eb-bedf-84fdd1be0091');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `ID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userID` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userAgent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`ID`, `userID`, `timestamp`, `ip`, `userAgent`, `action`) VALUES
('34c07d12-3502-11eb-bc56-84fdd1be0091', NULL, '2020-12-03 10:55:15', '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36', '/api/auth/login'),
('3c5b0ac5-3502-11eb-bc56-84fdd1be0091', NULL, '2020-12-03 10:55:28', '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36', '/api/auth/login');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `ID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employerID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`ID`, `employerID`, `title`, `client`, `description`) VALUES
('803b45b3-06da-11eb-983a-84fdd1be0091', '081388ea-06da-11eb-983a-84fdd1be0091', 'test projecter', 'test', 'test'),
('e6469de1-221a-11eb-98a7-84fdd1be0091', '081388ea-06da-11eb-983a-84fdd1be0091', 'Test Project', 'Tester', 'dwdwdwddw');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` char(60) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `email`, `firstName`, `lastName`, `password`) VALUES
('2e40c516-06da-11eb-983a-84fdd1be0091', 'testemployee@test.com', 'test', 'test', '$2y$10$WVEjutsNCupxEgZr6IOv8u/4BAuT1V8QcCix4lobvidQHn27w7drm'),
('dc0591bc-06cd-11eb-983a-84fdd1be0091', 'testemployer@test.com', 'test', 'test', '$2y$10$WVEjutsNCupxEgZr6IOv8u/4BAuT1V8QcCix4lobvidQHn27w7drm');

-- --------------------------------------------------------

--
-- Table structure for table `workSession`
--

CREATE TABLE `workSession` (
  `ID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employeeID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `projectID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` datetime NOT NULL,
  `finish` datetime NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workSession`
--

INSERT INTO `workSession` (`ID`, `employeeID`, `projectID`, `start`, `finish`, `description`) VALUES
('3a439b07-1277-11eb-b6d1-013c2a1d130c', '5bf33089-06da-11eb-983a-84fdd1be0091', '803b45b3-06da-11eb-983a-84fdd1be0091', '2020-10-20 11:54:00', '2020-10-21 04:35:00', 'fwfwf'),
('415a843e-06f7-11eb-983a-84fdd1be0091', '5bf33089-06da-11eb-983a-84fdd1be0091', '803b45b3-06da-11eb-983a-84fdd1be0091', '2020-10-05 16:15:52', '2020-10-05 19:15:13', 'test description'),
('49f7af45-11a5-11eb-bb72-84fdd1be0091', '5bf33089-06da-11eb-983a-84fdd1be0091', '803b45b3-06da-11eb-983a-84fdd1be0091', '2020-10-19 10:51:00', '2020-10-19 11:51:00', ''),
('6267dd7a-22e6-11eb-8d56-8a325e3e1cd5', '5bf33089-06da-11eb-983a-84fdd1be0091', 'e6469de1-221a-11eb-98a7-84fdd1be0091', '2020-11-10 23:50:00', '2020-11-12 14:50:00', 'wdw'),
('65b5ad25-11a5-11eb-bb72-84fdd1be0091', '5bf33089-06da-11eb-983a-84fdd1be0091', '803b45b3-06da-11eb-983a-84fdd1be0091', '2020-10-19 10:51:00', '2020-10-19 11:51:00', ''),
('72d7f9a5-2798-11eb-bedf-84fdd1be0091', '5bf33089-06da-11eb-983a-84fdd1be0091', 'e6469de1-221a-11eb-98a7-84fdd1be0091', '2020-11-16 13:19:00', '2020-11-16 15:15:00', 'test work session'),
('7b1869e7-11a5-11eb-bb72-84fdd1be0091', '5bf33089-06da-11eb-983a-84fdd1be0091', '803b45b3-06da-11eb-983a-84fdd1be0091', '2020-10-19 10:51:00', '2020-10-19 11:51:00', 'hi'),
('8c834929-11a5-11eb-bb72-84fdd1be0091', '5bf33089-06da-11eb-983a-84fdd1be0091', '803b45b3-06da-11eb-983a-84fdd1be0091', '2020-10-19 10:53:00', '2020-10-19 11:53:00', 'dwd'),
('9207556b-06da-11eb-983a-84fdd1be0091', '5bf33089-06da-11eb-983a-84fdd1be0091', '803b45b3-06da-11eb-983a-84fdd1be0091', '2020-10-05 17:15:14', '2020-10-05 20:15:14', 'test'),
('c3776f6d-1272-11eb-b6d1-013c2a1d130c', '5bf33089-06da-11eb-983a-84fdd1be0091', '803b45b3-06da-11eb-983a-84fdd1be0091', '2020-10-20 11:22:00', '2020-10-20 12:22:00', ''),
('d75a6e05-11a7-11eb-bb72-84fdd1be0091', '5bf33089-06da-11eb-983a-84fdd1be0091', '803b45b3-06da-11eb-983a-84fdd1be0091', '2020-10-19 11:09:00', '2020-10-19 12:09:00', 'test 4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `USER_ID` (`userID`) USING BTREE,
  ADD KEY `EMPLOYER_ID` (`employerID`);

--
-- Indexes for table `employer`
--
ALTER TABLE `employer`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `USER_ID` (`userID`) USING BTREE;

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `EMPLOYER_ID` (`employerID`);

--
-- Indexes for table `invoiceItem`
--
ALTER TABLE `invoiceItem`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `INVOICE_ID` (`invoiceID`),
  ADD KEY `WORK_SESSION_ID` (`workSessionID`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `USER_ID` (`userID`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `EMPLOYER_ID` (`employerID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `EMAIL` (`email`);

--
-- Indexes for table `workSession`
--
ALTER TABLE `workSession`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `EMPLOYEE_ID` (`employeeID`),
  ADD KEY `PROJECT_ID` (`projectID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `EMPLOYEE_EMPLOYER_ID` FOREIGN KEY (`employerID`) REFERENCES `employer` (`ID`),
  ADD CONSTRAINT `EMPLOYEE_USER_ID` FOREIGN KEY (`userID`) REFERENCES `user` (`ID`);

--
-- Constraints for table `employer`
--
ALTER TABLE `employer`
  ADD CONSTRAINT `EMPLOYER_USER_ID` FOREIGN KEY (`userID`) REFERENCES `user` (`ID`);

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `INVOICE_EMPLOYER_ID` FOREIGN KEY (`employerID`) REFERENCES `employer` (`ID`);

--
-- Constraints for table `invoiceItem`
--
ALTER TABLE `invoiceItem`
  ADD CONSTRAINT `INVOICE_ITEM_INVOICE_ID` FOREIGN KEY (`invoiceID`) REFERENCES `invoice` (`ID`),
  ADD CONSTRAINT `INVOICE_ITEM_WORK_SESSION_ID` FOREIGN KEY (`workSessionID`) REFERENCES `workSession` (`ID`);

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `LOG_USER_ID` FOREIGN KEY (`userID`) REFERENCES `user` (`ID`);

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `PROJECT_EMPLOYER_ID` FOREIGN KEY (`employerID`) REFERENCES `employer` (`ID`);

--
-- Constraints for table `workSession`
--
ALTER TABLE `workSession`
  ADD CONSTRAINT `WORK_SESSION_EMPLOYEE_ID` FOREIGN KEY (`employeeID`) REFERENCES `employee` (`ID`),
  ADD CONSTRAINT `WORK_SESSION_PROJECT_ID` FOREIGN KEY (`projectID`) REFERENCES `project` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
