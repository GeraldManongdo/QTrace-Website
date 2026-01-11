-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2026 at 08:29 AM
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
-- Database: `qtrace`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_table`
--

CREATE TABLE `account_table` (
  `Account_Id` int(11) NOT NULL,
  `Image_Path` varchar(100) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Middle_Name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Role` int(11) NOT NULL,
  `Contact_Number` bigint(20) NOT NULL,
  `Created_At` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contractor_documents_table`
--

CREATE TABLE `contractor_documents_table` (
  `Contractor_Documents_Id` int(11) NOT NULL,
  `Contractor_Id` int(11) NOT NULL,
  `Document_Type` varchar(100) NOT NULL,
  `Document_Path` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contractor_expertise_table`
--

CREATE TABLE `contractor_expertise_table` (
  `Contractor_Expertise_Id` int(11) NOT NULL,
  `Contractor_Id` int(11) NOT NULL,
  `Expertise` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contractor_table`
--

CREATE TABLE `contractor_table` (
  `Contractor_Id` int(11) NOT NULL,
  `Contractor_Logo_Path` varchar(100) NOT NULL,
  `Contractor_Name` varchar(50) NOT NULL,
  `Owner_Name` varchar(50) NOT NULL,
  `Company_Address` varchar(100) NOT NULL,
  `Contact_Number` bigint(20) NOT NULL,
  `Company_Email_Address` varchar(50) NOT NULL,
  `Years_Of_Experience` int(11) NOT NULL,
  `Additional_Notes` varchar(250) NOT NULL,
  `Created_At` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projectmilestone_table`
--

CREATE TABLE `projectmilestone_table` (
  `projectMilestone_PhotoID` int(11) NOT NULL,
  `Project_ID` int(11) NOT NULL,
  `projectMilestone_FileLocation` varchar(50) DEFAULT NULL,
  `projectMilestone_Caption` varchar(255) DEFAULT NULL,
  `projectMilestone_Phase` enum('Foundation','Before','After') DEFAULT NULL,
  `projectMilestone_UploadedAT` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projectsdocument_table`
--

CREATE TABLE `projectsdocument_table` (
  `ProjectDocument_ID` int(11) NOT NULL,
  `Project_ID` int(11) NOT NULL,
  `ProjectDocument_FileLocation` varchar(255) DEFAULT NULL,
  `ProjectDocument_Type` varchar(50) DEFAULT NULL,
  `ProjectDocument_UploadedAt` datetime DEFAULT current_timestamp(),
  `ProjectDocument_UpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects_table`
--

CREATE TABLE `projects_table` (
  `Project_ID` int(11) NOT NULL,
  `Contractor_ID` int(11) NOT NULL,
  `Project_Title` varchar(50) NOT NULL,
  `Project_Description` varchar(255) NOT NULL,
  `Project_Status` varchar(50) NOT NULL,
  `Project_LatitudeAndLongitude` varchar(20) NOT NULL,
  `Project_Budget` double NOT NULL,
  `Project_StartedDate` date DEFAULT NULL,
  `Project_EndDate` date DEFAULT NULL,
  `Project_CreatedAt` date DEFAULT curdate(),
  `Project_UpdatedAT` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_table`
--

CREATE TABLE `report_table` (
  `report_ID` int(11) NOT NULL,
  `Project_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `report_type` varchar(50) DEFAULT NULL,
  `report_description` varchar(255) DEFAULT NULL,
  `report_evidencesPhoto_URL` varchar(255) DEFAULT NULL,
  `report_status` varchar(50) DEFAULT NULL,
  `report_CreatedAt` datetime DEFAULT current_timestamp(),
  `reportParent_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_ID` int(11) NOT NULL,
  `QC_ID_Number` int(11) NOT NULL,
  `user_lastName` varchar(50) NOT NULL,
  `user_firstName` varchar(50) NOT NULL,
  `user_middleName` varchar(20) DEFAULT NULL,
  `user_Email` varchar(20) NOT NULL,
  `user_Password` varchar(20) NOT NULL,
  `user_Role` enum('citizen','admin') NOT NULL,
  `user_birthDate` date NOT NULL,
  `user_sex` enum('female','male','other') NOT NULL,
  `user_contactInformation` bigint(20) NOT NULL,
  `user_address` varchar(100) NOT NULL,
  `created_At` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_ID`, `QC_ID_Number`, `user_lastName`, `user_firstName`, `user_middleName`, `user_Email`, `user_Password`, `user_Role`, `user_birthDate`, `user_sex`, `user_contactInformation`, `user_address`, `created_At`) VALUES
(1, 0, 'Manongdo', 'Gerald', 'Pavillon', 'ipoglang@gmail.com', '$2y$10$hr0Tc0IEObKIR', 'admin', '2005-09-12', 'male', 9082938218, 'blk 51 lt 49 noche buena st. ', '2026-01-09'),
(2, 2147483647, 'Clifford', 'Kurt', 'Eyong', 'TEst1@gmail.com', '$2y$10$xYxJX5HeB.Bm3', 'citizen', '2007-09-12', 'other', 12312312, 'blk 51 lt 49 noche buena st. ', '2026-01-09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contractor_documents_table`
--
ALTER TABLE `contractor_documents_table`
  ADD PRIMARY KEY (`Contractor_Documents_Id`),
  ADD KEY `fk_documents_contractor` (`Contractor_Id`);

--
-- Indexes for table `contractor_expertise_table`
--
ALTER TABLE `contractor_expertise_table`
  ADD PRIMARY KEY (`Contractor_Expertise_Id`),
  ADD KEY `fk_expertise_contractor` (`Contractor_Id`);

--
-- Indexes for table `contractor_table`
--
ALTER TABLE `contractor_table`
  ADD PRIMARY KEY (`Contractor_Id`);

--
-- Indexes for table `projectmilestone_table`
--
ALTER TABLE `projectmilestone_table`
  ADD PRIMARY KEY (`projectMilestone_PhotoID`),
  ADD KEY `fk_projectMilestone_projects` (`Project_ID`);

--
-- Indexes for table `projectsdocument_table`
--
ALTER TABLE `projectsdocument_table`
  ADD PRIMARY KEY (`ProjectDocument_ID`),
  ADD KEY `fk_projectsDocument_projects` (`Project_ID`);

--
-- Indexes for table `projects_table`
--
ALTER TABLE `projects_table`
  ADD PRIMARY KEY (`Project_ID`),
  ADD KEY `idx_projects_contractor_id` (`Contractor_ID`);

--
-- Indexes for table `report_table`
--
ALTER TABLE `report_table`
  ADD PRIMARY KEY (`report_ID`),
  ADD KEY `fk_report_projects` (`Project_ID`),
  ADD KEY `fk_report_user` (`user_ID`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contractor_expertise_table`
--
ALTER TABLE `contractor_expertise_table`
  MODIFY `Contractor_Expertise_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contractor_table`
--
ALTER TABLE `contractor_table`
  MODIFY `Contractor_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_table`
--
ALTER TABLE `report_table`
  MODIFY `report_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contractor_documents_table`
--
ALTER TABLE `contractor_documents_table`
  ADD CONSTRAINT `fk_documents_contractor` FOREIGN KEY (`Contractor_Id`) REFERENCES `contractor_table` (`Contractor_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contractor_expertise_table`
--
ALTER TABLE `contractor_expertise_table`
  ADD CONSTRAINT `fk_document_contractor` FOREIGN KEY (`Contractor_Id`) REFERENCES `contractor_table` (`Contractor_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_expertise_contractor` FOREIGN KEY (`Contractor_Id`) REFERENCES `contractor_table` (`Contractor_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projectmilestone_table`
--
ALTER TABLE `projectmilestone_table`
  ADD CONSTRAINT `fk_projectMilestone_projects` FOREIGN KEY (`Project_ID`) REFERENCES `projects_table` (`Project_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `projectsdocument_table`
--
ALTER TABLE `projectsdocument_table`
  ADD CONSTRAINT `fk_projectsDocument_projects` FOREIGN KEY (`Project_ID`) REFERENCES `projects_table` (`Project_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `projects_table`
--
ALTER TABLE `projects_table`
  ADD CONSTRAINT `fk_projects_contractor` FOREIGN KEY (`Contractor_ID`) REFERENCES `contractor_table` (`Contractor_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `report_table`
--
ALTER TABLE `report_table`
  ADD CONSTRAINT `fk_report_projects` FOREIGN KEY (`Project_ID`) REFERENCES `projects_table` (`Project_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_report_user` FOREIGN KEY (`user_ID`) REFERENCES `user_table` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
