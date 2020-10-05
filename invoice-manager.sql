-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 05, 2020 at 10:44 AM
-- Server version: 10.5.5-MariaDB
-- PHP Version: 7.4.10

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

-- --------------------------------------------------------

--
-- Table structure for table `employer`
--

CREATE TABLE `employer` (
  `ID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `companyName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Triggers `invoice`
--
DELIMITER $$
CREATE TRIGGER `INVOICE_UPDATED` AFTER UPDATE ON `invoice` FOR EACH ROW UPDATE invoice SET invoice.updatedAt = CURRENT_TIMESTAMP()
WHERE INSERTED.ID = invoice.ID
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `invoiceItem`
--

CREATE TABLE `invoiceItem` (
  `ID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoiceID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `workSessionID` char(16) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `ID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employerID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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