-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2026 at 03:21 AM
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
-- Table structure for table `articles_table`
--

CREATE TABLE `articles_table` (
  `article_ID` int(11) NOT NULL,
  `Project_ID` int(11) NOT NULL,
  `user_ID` int(11) DEFAULT NULL,
  `article_type` varchar(50) NOT NULL COMMENT 'Article, Update, Milestone, etc.',
  `article_description` longtext NOT NULL,
  `article_photo_url` varchar(255) DEFAULT NULL,
  `article_status` varchar(20) DEFAULT 'Draft' COMMENT 'Draft, Published, Archived',
  `article_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `article_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `audit_log_id` binary(16) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `action` varchar(50) NOT NULL,
  `resource_type` varchar(50) NOT NULL,
  `resource_id` varchar(36) NOT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`audit_log_id`, `user_id`, `action`, `resource_type`, `resource_id`, `old_values`, `new_values`, `created_at`) VALUES
(0x30303262303433372d663431332d3131, '6', 'UPDATE', 'users', '6', '{\"user_sex\":\"male\"}', '{\"user_sex\":\"other\"}', '2026-01-18 02:11:29'),
(0x30383263323462612d663534302d3131, '9', 'UPDATE', 'Project', '19', '{\"Contractor_ID\":18,\"Project_Status\":\"Ongoing\",\"Project_Category\":\"Infrastructure\",\"Project_Title\":\"MRT-7 (New Line)\",\"Project_Description\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla p\",\"Project_Budget\":62007000000,\"Location\":\"Commonwealth Avenue, Holy Spirit, 1127\",\"Started_Date\":\"2017-06-07\",\"End_Date\":\"2028-06-29\"}', '{\"Contractor_ID\":18,\"Project_Status\":\"Ongoing\",\"Project_Category\":\"Infrastructure\",\"Project_Title\":\"MRT-7 (New Line)\",\"Project_Description\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla p\",\"Project_Budget\":62007000000,\"Location\":\"Commonwealth Avenue, Holy Spirit, 1127\",\"Started_Date\":\"2017-06-07\",\"End_Date\":\"2028-06-30\"}', '2026-01-19 14:06:21'),
(0x30383531653439662d663535332d3131, '9', 'CREATE', 'users', '17', NULL, '{\"name\":\"Julianne Vance\",\"role\":\"citizen\",\"email\":\"j.vance@gmail.com\",\"qc_id\":\"33094395895\"}', '2026-01-19 16:22:21'),
(0x30396630613861622d663431322d3131, '6', 'UPDATE', 'users', '8', '{\"user_firstName\":\"Uno\"}', '{\"user_firstName\":\"Dos\"}', '2026-01-18 02:04:36'),
(0x32306337396565662d663534322d3131, '9', 'CREATE', 'Project', '24', NULL, '{\"Contractor_ID\":16,\"Project_Status\":\"Ongoing\",\"Project_Category\":\"Environmental\",\"Project_Title\":\"Ermita\\u00f1o Creek Rehabilitation\",\"Project_Description\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla placerat, egestas turpis id, rhoncus arcu. Aliquam maximus at nulla eu vehicula. Curabitur consequat volutpat pharetra. Pellentesque eget lorem in est facilisis egestas. Fusce posuere augue id diam elementum, quis laoreet augue faucibus.\\\\r\\\\n\\\\r\\\\nProin gravida, ipsum ac sollicitudin hendrerit, mauris mauris feugiat justo, et pulvinar nunc quam vitae eros. Aliquam condimentum velit non neque iaculis, eget interdum risus interdum. Donec laoreet id purus in suscipit. Etiam ullamcorper dolor non dui aliquam scelerisque. Pellentesque quis massa imperdiet, feugiat elit sed, finibus risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce eget lectus diam. Suspendisse varius sem arcu, eu sagittis mauris blandit vitae. Vestibulum et porttitor lorem. Etiam quis imperdiet libero. Suspendisse viverra ante ac vulputate ultricies.\\\\r\\\\n\\\\r\\\\nNunc vitae accumsan enim. Aliquam vehicula, ante id fringilla tempor, enim quam venenatis sem, non pretium neque elit vitae est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi hendrerit nisi nec aliquet convallis. Nulla at aliquam felis. Vivamus ante risus, dictum placerat mauris vitae, volutpat mattis quam. Integer iaculis tortor felis, vitae consequat diam convallis nec. Maecenas facilisis venenatis rutrum. Nam congue massa eget lacus luctus mattis. Duis ornare sem vel dapibus congue. In hac habitasse platea dictumst. Ut odio tellus, lobortis in elit quis, faucibus sollicitudin nunc. Phasellus vitae mi interdum, luctus ligula nec, efficitur turpis. Praesent porta tellus non dolor tempor tristique.\\\\r\\\\n\\\\r\\\\nInteger id lacinia ipsum, ac elementum turpis. Mauris magna lectus, accumsan non risus in, interdum consequat neque. Praesent gravida urna at nibh sodales, sed ornare urna vestibulum. Sed a urna nec mi volutpat lacinia non nec enim. Integer eu posuere ipsum, nec ornare lorem. Duis pulvinar vestibulum justo, sed faucibus libero. Nunc vitae tincidunt lorem, quis scelerisque tellus. In efficitur orci pellentesque lobortis imperdiet.\\\\r\\\\n\\\\r\\\\nVivamus fringilla, purus vitae rhoncus dictum, tellus augue dignissim eros, finibus gravida dolor dolor quis metus. Integer faucibus vitae nunc nec consequat. Nam venenatis orci convallis est tristique, non hendrerit libero aliquet. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam iaculis tortor non nibh pulvinar euismod. Integer elementum ex at hendrerit finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam a sapien turpis.\",\"Project_Budget\":13500000,\"Location\":\"Commonwealth Avenue Cycleway, Diliman, 1128\",\"Started_Date\":\"2025-11-20\",\"End_Date\":\"2026-02-05\"}', '2026-01-19 14:21:21'),
(0x32353237663666312d663534622d3131, '8', 'CREATE', 'Contractor', '26', NULL, '{\"Company_Name\":\"CoolArctic Air Conditioning Services\",\"Owner_Name\":\"Elena V. Rodriguez\",\"Company_Address\":\"Suite 201, Frost Building, Commonwealth Ave, Quezon City, 1121 Metro Manila\",\"Contact_Number\":\"31667788998\",\"Company_Email\":\"service@coolarctic.com\",\"Years_Of_Experience\":7,\"Logo_Path\":\"\\/QTrace-Website\\/uploads\\/contractors\\/logos\\/CoolArctic_Air_Conditioning_Services_logo.jpg\",\"Additional_Notes\":\"Offers 24\\/7 emergency repair services for data centers and cold storage facilities.\"}', '2026-01-19 15:25:54'),
(0x32376435366665622d663533362d3131, '8', 'CREATE', 'Project', '17', NULL, '{\"Contractor_ID\":11,\"Project_Status\":\"Ongoing\",\"Project_Category\":\"Infrastructure\",\"Project_Title\":\"Metro Manila Subway\",\"Project_Description\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla placerat, egestas turpis id, rhoncus arcu. Aliquam maximus at nulla eu vehicula. Curabitur consequat volutpat pharetra. Pellentesque eget lorem in est facilisis egestas. Fusce posuere augue id diam elementum, quis laoreet augue faucibus.\\\\r\\\\n\\\\r\\\\nProin gravida, ipsum ac sollicitudin hendrerit, mauris mauris feugiat justo, et pulvinar nunc quam vitae eros. Aliquam condimentum velit non neque iaculis, eget interdum risus interdum. Donec laoreet id purus in suscipit. Etiam ullamcorper dolor non dui aliquam scelerisque. Pellentesque quis massa imperdiet, feugiat elit sed, finibus risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce eget lectus diam. Suspendisse varius sem arcu, eu sagittis mauris blandit vitae. Vestibulum et porttitor lorem. Etiam quis imperdiet libero. Suspendisse viverra ante ac vulputate ultricies.\\\\r\\\\n\\\\r\\\\nNunc vitae accumsan enim. Aliquam vehicula, ante id fringilla tempor, enim quam venenatis sem, non pretium neque elit vitae est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi hendrerit nisi nec aliquet convallis. Nulla at aliquam felis. Vivamus ante risus, dictum placerat mauris vitae, volutpat mattis quam. Integer iaculis tortor felis, vitae consequat diam convallis nec. Maecenas facilisis venenatis rutrum. Nam congue massa eget lacus luctus mattis. Duis ornare sem vel dapibus congue. In hac habitasse platea dictumst. Ut odio tellus, lobortis in elit quis, faucibus sollicitudin nunc. Phasellus vitae mi interdum, luctus ligula nec, efficitur turpis. Praesent porta tellus non dolor tempor tristique.\\\\r\\\\n\\\\r\\\\nInteger id lacinia ipsum, ac elementum turpis. Mauris magna lectus, accumsan non risus in, interdum consequat neque. Praesent gravida urna at nibh sodales, sed ornare urna vestibulum. Sed a urna nec mi volutpat lacinia non nec enim. Integer eu posuere ipsum, nec ornare lorem. Duis pulvinar vestibulum justo, sed faucibus libero. Nunc vitae tincidunt lorem, quis scelerisque tellus. In efficitur orci pellentesque lobortis imperdiet.\\\\r\\\\n\\\\r\\\\nVivamus fringilla, purus vitae rhoncus dictum, tellus augue dignissim eros, finibus gravida dolor dolor quis metus. Integer faucibus vitae nunc nec consequat. Nam venenatis orci convallis est tristique, non hendrerit libero aliquet. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam iaculis tortor non nibh pulvinar euismod. Integer elementum ex at hendrerit finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam a sapien turpis.\",\"Project_Budget\":355000000000,\"Location\":\"Mindanao Avenue, Villa Florencia Subdivision, 1116\",\"Started_Date\":\"2019-02-27\",\"End_Date\":\"2029-06-20\"}', '2026-01-19 12:55:39'),
(0x32383463393466352d663535332d3131, '9', 'CREATE', 'users', '18', NULL, '{\"name\":\"Dominic Thorne\",\"role\":\"citizen\",\"email\":\"d.thorne@gmail.com\",\"qc_id\":\"80100760397\"}', '2026-01-19 16:23:15'),
(0x32623032333665372d663535322d3131, '9', 'CREATE', 'users', '12', NULL, '{\"name\":\"Mikhale Pua\",\"role\":\"citizen\",\"email\":\"r.pua@gmail.com\",\"qc_id\":\"78195285403\"}', '2026-01-19 16:16:10'),
(0x32633132373365642d663534392d3131, '6', 'CREATE', 'Contractor', '22', NULL, '{\"Company_Name\":\"VoltArc Electrical Services\",\"Owner_Name\":\"Maria Clara Reyes\",\"Company_Address\":\"15-B Industrial Way, Barangay Ugong, Pasig City, 1604 Metro Manila\",\"Contact_Number\":\"3318987654\",\"Company_Email\":\"m.reyes@voltarc.com\",\"Years_Of_Experience\":8,\"Logo_Path\":\"\\/QTrace-Website\\/uploads\\/contractors\\/logos\\/VoltArc_Electrical_Services_logo.jpg\",\"Additional_Notes\":\"Preferred vendor for eco-friendly housing projects. Known for high safety standards.\"}', '2026-01-19 15:11:46'),
(0x34336664646330302d663535302d3131, '9', 'CREATE', 'Project', '30', NULL, '{\"Contractor_ID\":20,\"Project_Status\":\"Delayed\",\"Project_Category\":\"Infrastructure\",\"Project_Title\":\"PCMC New Building (Legacy Hospital Project)\",\"Project_Description\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla placerat, egestas turpis id, rhoncus arcu. Aliquam maximus at nulla eu vehicula. Curabitur consequat volutpat pharetra. Pellentesque eget lorem in est facilisis egestas. Fusce posuere augue id diam elementum, quis laoreet augue faucibus.\\\\r\\\\n\\\\r\\\\nProin gravida, ipsum ac sollicitudin hendrerit, mauris mauris feugiat justo, et pulvinar nunc quam vitae eros. Aliquam condimentum velit non neque iaculis, eget interdum risus interdum. Donec laoreet id purus in suscipit. Etiam ullamcorper dolor non dui aliquam scelerisque. Pellentesque quis massa imperdiet, feugiat elit sed, finibus risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce eget lectus diam. Suspendisse varius sem arcu, eu sagittis mauris blandit vitae. Vestibulum et porttitor lorem. Etiam quis imperdiet libero. Suspendisse viverra ante ac vulputate ultricies.\\\\r\\\\n\\\\r\\\\nNunc vitae accumsan enim. Aliquam vehicula, ante id fringilla tempor, enim quam venenatis sem, non pretium neque elit vitae est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi hendrerit nisi nec aliquet convallis. Nulla at aliquam felis. Vivamus ante risus, dictum placerat mauris vitae, volutpat mattis quam. Integer iaculis tortor felis, vitae consequat diam convallis nec. Maecenas facilisis venenatis rutrum. Nam congue massa eget lacus luctus mattis. Duis ornare sem vel dapibus congue. In hac habitasse platea dictumst. Ut odio tellus, lobortis in elit quis, faucibus sollicitudin nunc. Phasellus vitae mi interdum, luctus ligula nec, efficitur turpis. Praesent porta tellus non dolor tempor tristique.\\\\r\\\\n\\\\r\\\\nInteger id lacinia ipsum, ac elementum turpis. Mauris magna lectus, accumsan non risus in, interdum consequat neque. Praesent gravida urna at nibh sodales, sed ornare urna vestibulum. Sed a urna nec mi volutpat lacinia non nec enim. Integer eu posuere ipsum, nec ornare lorem. Duis pulvinar vestibulum justo, sed faucibus libero. Nunc vitae tincidunt lorem, quis scelerisque tellus. In efficitur orci pellentesque lobortis imperdiet.\\\\r\\\\n\\\\r\\\\nVivamus fringilla, purus vitae rhoncus dictum, tellus augue dignissim eros, finibus gravida dolor dolor quis metus. Integer faucibus vitae nunc nec consequat. Nam venenatis orci convallis est tristique, non hendrerit libero aliquet. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam iaculis tortor non nibh pulvinar euismod. Integer elementum ex at hendrerit finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam a sapien turpis.\",\"Project_Budget\":25600000000,\"Location\":\"Quezon Avenue, San Jose, 1100\",\"Started_Date\":\"2024-06-17\",\"End_Date\":\"2025-11-20\"}', '2026-01-19 16:02:33'),
(0x34626538366631342d663535332d3131, '9', 'CREATE', 'users', '19', NULL, '{\"name\":\"Elara Sterling\",\"role\":\"citizen\",\"email\":\"e.sterling@gmail.com\",\"qc_id\":\"18342082231\"}', '2026-01-19 16:24:15'),
(0x34633339663136612d663535312d3131, '9', 'CREATE', 'Project', '31', NULL, '{\"Contractor_ID\":14,\"Project_Status\":\"Planning\",\"Project_Category\":\"Safety\",\"Project_Title\":\"QC Biogas Plant (Waste-to-Energy)\",\"Project_Description\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla placerat, egestas turpis id, rhoncus arcu. Aliquam maximus at nulla eu vehicula. Curabitur consequat volutpat pharetra. Pellentesque eget lorem in est facilisis egestas. Fusce posuere augue id diam elementum, quis laoreet augue faucibus.\\\\r\\\\n\\\\r\\\\nProin gravida, ipsum ac sollicitudin hendrerit, mauris mauris feugiat justo, et pulvinar nunc quam vitae eros. Aliquam condimentum velit non neque iaculis, eget interdum risus interdum. Donec laoreet id purus in suscipit. Etiam ullamcorper dolor non dui aliquam scelerisque. Pellentesque quis massa imperdiet, feugiat elit sed, finibus risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce eget lectus diam. Suspendisse varius sem arcu, eu sagittis mauris blandit vitae. Vestibulum et porttitor lorem. Etiam quis imperdiet libero. Suspendisse viverra ante ac vulputate ultricies.\\\\r\\\\n\\\\r\\\\nNunc vitae accumsan enim. Aliquam vehicula, ante id fringilla tempor, enim quam venenatis sem, non pretium neque elit vitae est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi hendrerit nisi nec aliquet convallis. Nulla at aliquam felis. Vivamus ante risus, dictum placerat mauris vitae, volutpat mattis quam. Integer iaculis tortor felis, vitae consequat diam convallis nec. Maecenas facilisis venenatis rutrum. Nam congue massa eget lacus luctus mattis. Duis ornare sem vel dapibus congue. In hac habitasse platea dictumst. Ut odio tellus, lobortis in elit quis, faucibus sollicitudin nunc. Phasellus vitae mi interdum, luctus ligula nec, efficitur turpis. Praesent porta tellus non dolor tempor tristique.\\\\r\\\\n\\\\r\\\\nInteger id lacinia ipsum, ac elementum turpis. Mauris magna lectus, accumsan non risus in, interdum consequat neque. Praesent gravida urna at nibh sodales, sed ornare urna vestibulum. Sed a urna nec mi volutpat lacinia non nec enim. Integer eu posuere ipsum, nec ornare lorem. Duis pulvinar vestibulum justo, sed faucibus libero. Nunc vitae tincidunt lorem, quis scelerisque tellus. In efficitur orci pellentesque lobortis imperdiet.\\\\r\\\\n\\\\r\\\\nVivamus fringilla, purus vitae rhoncus dictum, tellus augue dignissim eros, finibus gravida dolor dolor quis metus. Integer faucibus vitae nunc nec consequat. Nam venenatis orci convallis est tristique, non hendrerit libero aliquet. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam iaculis tortor non nibh pulvinar euismod. Integer elementum ex at hendrerit finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam a sapien turpis.\",\"Project_Budget\":50000000,\"Location\":\"San Lucas Street, Payatas, 1119\",\"Started_Date\":\"2026-01-20\",\"End_Date\":\"2026-02-05\"}', '2026-01-19 16:09:56'),
(0x34643337373736392d663533622d3131, '8', 'CREATE', 'Project', '21', NULL, '{\"Contractor_ID\":17,\"Project_Status\":\"Planning\",\"Project_Category\":\"Environmental\",\"Project_Title\":\"Quezon City Elevated Promenade\",\"Project_Description\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla placerat, egestas turpis id, rhoncus arcu. Aliquam maximus at nulla eu vehicula. Curabitur consequat volutpat pharetra. Pellentesque eget lorem in est facilisis egestas. Fusce posuere augue id diam elementum, quis laoreet augue faucibus.\\\\r\\\\n\\\\r\\\\nProin gravida, ipsum ac sollicitudin hendrerit, mauris mauris feugiat justo, et pulvinar nunc quam vitae eros. Aliquam condimentum velit non neque iaculis, eget interdum risus interdum. Donec laoreet id purus in suscipit. Etiam ullamcorper dolor non dui aliquam scelerisque. Pellentesque quis massa imperdiet, feugiat elit sed, finibus risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce eget lectus diam. Suspendisse varius sem arcu, eu sagittis mauris blandit vitae. Vestibulum et porttitor lorem. Etiam quis imperdiet libero. Suspendisse viverra ante ac vulputate ultricies.\\\\r\\\\n\\\\r\\\\nNunc vitae accumsan enim. Aliquam vehicula, ante id fringilla tempor, enim quam venenatis sem, non pretium neque elit vitae est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi hendrerit nisi nec aliquet convallis. Nulla at aliquam felis. Vivamus ante risus, dictum placerat mauris vitae, volutpat mattis quam. Integer iaculis tortor felis, vitae consequat diam convallis nec. Maecenas facilisis venenatis rutrum. Nam congue massa eget lacus luctus mattis. Duis ornare sem vel dapibus congue. In hac habitasse platea dictumst. Ut odio tellus, lobortis in elit quis, faucibus sollicitudin nunc. Phasellus vitae mi interdum, luctus ligula nec, efficitur turpis. Praesent porta tellus non dolor tempor tristique.\\\\r\\\\n\\\\r\\\\nInteger id lacinia ipsum, ac elementum turpis. Mauris magna lectus, accumsan non risus in, interdum consequat neque. Praesent gravida urna at nibh sodales, sed ornare urna vestibulum. Sed a urna nec mi volutpat lacinia non nec enim. Integer eu posuere ipsum, nec ornare lorem. Duis pulvinar vestibulum justo, sed faucibus libero. Nunc vitae tincidunt lorem, quis scelerisque tellus. In efficitur orci pellentesque lobortis imperdiet.\\\\r\\\\n\\\\r\\\\nVivamus fringilla, purus vitae rhoncus dictum, tellus augue dignissim eros, finibus gravida dolor dolor quis metus. Integer faucibus vitae nunc nec consequat. Nam venenatis orci convallis est tristique, non hendrerit libero aliquet. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam iaculis tortor non nibh pulvinar euismod. Integer elementum ex at hendrerit finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam a sapien turpis.\",\"Project_Budget\":84004000,\"Location\":\"North Avenue, San Jose, 1100\",\"Started_Date\":\"2024-10-19\",\"End_Date\":\"2026-01-22\"}', '2026-01-19 13:32:29'),
(0x35306432303066662d663534332d3131, '6', 'CREATE', 'Project', '25', NULL, '{\"Contractor_ID\":19,\"Project_Status\":\"Completed\",\"Project_Category\":\"Environmental\",\"Project_Title\":\"Commonwealth Detention Basin\",\"Project_Description\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla placerat, egestas turpis id, rhoncus arcu. Aliquam maximus at nulla eu vehicula. Curabitur consequat volutpat pharetra. Pellentesque eget lorem in est facilisis egestas. Fusce posuere augue id diam elementum, quis laoreet augue faucibus.\\\\r\\\\n\\\\r\\\\nProin gravida, ipsum ac sollicitudin hendrerit, mauris mauris feugiat justo, et pulvinar nunc quam vitae eros. Aliquam condimentum velit non neque iaculis, eget interdum risus interdum. Donec laoreet id purus in suscipit. Etiam ullamcorper dolor non dui aliquam scelerisque. Pellentesque quis massa imperdiet, feugiat elit sed, finibus risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce eget lectus diam. Suspendisse varius sem arcu, eu sagittis mauris blandit vitae. Vestibulum et porttitor lorem. Etiam quis imperdiet libero. Suspendisse viverra ante ac vulputate ultricies.\\\\r\\\\n\\\\r\\\\nNunc vitae accumsan enim. Aliquam vehicula, ante id fringilla tempor, enim quam venenatis sem, non pretium neque elit vitae est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi hendrerit nisi nec aliquet convallis. Nulla at aliquam felis. Vivamus ante risus, dictum placerat mauris vitae, volutpat mattis quam. Integer iaculis tortor felis, vitae consequat diam convallis nec. Maecenas facilisis venenatis rutrum. Nam congue massa eget lacus luctus mattis. Duis ornare sem vel dapibus congue. In hac habitasse platea dictumst. Ut odio tellus, lobortis in elit quis, faucibus sollicitudin nunc. Phasellus vitae mi interdum, luctus ligula nec, efficitur turpis. Praesent porta tellus non dolor tempor tristique.\\\\r\\\\n\\\\r\\\\nInteger id lacinia ipsum, ac elementum turpis. Mauris magna lectus, accumsan non risus in, interdum consequat neque. Praesent gravida urna at nibh sodales, sed ornare urna vestibulum. Sed a urna nec mi volutpat lacinia non nec enim. Integer eu posuere ipsum, nec ornare lorem. Duis pulvinar vestibulum justo, sed faucibus libero. Nunc vitae tincidunt lorem, quis scelerisque tellus. In efficitur orci pellentesque lobortis imperdiet.\\\\r\\\\n\\\\r\\\\nVivamus fringilla, purus vitae rhoncus dictum, tellus augue dignissim eros, finibus gravida dolor dolor quis metus. Integer faucibus vitae nunc nec consequat. Nam venenatis orci convallis est tristique, non hendrerit libero aliquet. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam iaculis tortor non nibh pulvinar euismod. Integer elementum ex at hendrerit finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam a sapien turpis.\",\"Project_Budget\":4000000000,\"Location\":\"Maliwanag Street, Diliman, 1101\",\"Started_Date\":\"2024-02-19\",\"End_Date\":\"2025-06-17\"}', '2026-01-19 14:29:51'),
(0x35313437616462302d663535322d3131, '9', 'CREATE', 'users', '13', NULL, '{\"name\":\"John Doe\",\"role\":\"citizen\",\"email\":\"j.doe@gmail.com\",\"qc_id\":\"40881637885\"}', '2026-01-19 16:17:14'),
(0x35333035343335302d663534662d3131, '9', 'CREATE', 'Project', '29', NULL, '{\"Contractor_ID\":26,\"Project_Status\":\"Ongoing\",\"Project_Category\":\"Social Services\",\"Project_Title\":\"QC E-Sports & Innovation Hub\",\"Project_Description\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla placerat, egestas turpis id, rhoncus arcu. Aliquam maximus at nulla eu vehicula. Curabitur consequat volutpat pharetra. Pellentesque eget lorem in est facilisis egestas. Fusce posuere augue id diam elementum, quis laoreet augue faucibus.\\\\r\\\\n\\\\r\\\\nProin gravida, ipsum ac sollicitudin hendrerit, mauris mauris feugiat justo, et pulvinar nunc quam vitae eros. Aliquam condimentum velit non neque iaculis, eget interdum risus interdum. Donec laoreet id purus in suscipit. Etiam ullamcorper dolor non dui aliquam scelerisque. Pellentesque quis massa imperdiet, feugiat elit sed, finibus risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce eget lectus diam. Suspendisse varius sem arcu, eu sagittis mauris blandit vitae. Vestibulum et porttitor lorem. Etiam quis imperdiet libero. Suspendisse viverra ante ac vulputate ultricies.\\\\r\\\\n\\\\r\\\\nNunc vitae accumsan enim. Aliquam vehicula, ante id fringilla tempor, enim quam venenatis sem, non pretium neque elit vitae est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi hendrerit nisi nec aliquet convallis. Nulla at aliquam felis. Vivamus ante risus, dictum placerat mauris vitae, volutpat mattis quam. Integer iaculis tortor felis, vitae consequat diam convallis nec. Maecenas facilisis venenatis rutrum. Nam congue massa eget lacus luctus mattis. Duis ornare sem vel dapibus congue. In hac habitasse platea dictumst. Ut odio tellus, lobortis in elit quis, faucibus sollicitudin nunc. Phasellus vitae mi interdum, luctus ligula nec, efficitur turpis. Praesent porta tellus non dolor tempor tristique.\\\\r\\\\n\\\\r\\\\nInteger id lacinia ipsum, ac elementum turpis. Mauris magna lectus, accumsan non risus in, interdum consequat neque. Praesent gravida urna at nibh sodales, sed ornare urna vestibulum. Sed a urna nec mi volutpat lacinia non nec enim. Integer eu posuere ipsum, nec ornare lorem. Duis pulvinar vestibulum justo, sed faucibus libero. Nunc vitae tincidunt lorem, quis scelerisque tellus. In efficitur orci pellentesque lobortis imperdiet.\\\\r\\\\n\\\\r\\\\nVivamus fringilla, purus vitae rhoncus dictum, tellus augue dignissim eros, finibus gravida dolor dolor quis metus. Integer faucibus vitae nunc nec consequat. Nam venenatis orci convallis est tristique, non hendrerit libero aliquet. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam iaculis tortor non nibh pulvinar euismod. Integer elementum ex at hendrerit finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam a sapien turpis.\",\"Project_Budget\":3000000,\"Location\":\"General Aguinaldo Avenue, Cubao, 1109\",\"Started_Date\":\"2024-08-15\",\"End_Date\":\"2026-05-20\"}', '2026-01-19 15:55:49'),
(0x35333132303661652d663431322d3131, '6', 'UPDATE', 'users', '6', '{\"user_middleName\":\"P.\",\"user_contactInformation\":3123123214}', '{\"user_middleName\":\"Pavillon\",\"user_contactInformation\":\"09562184010\"}', '2026-01-18 02:06:38'),
(0x35343939636439362d663533382d3131, '8', 'CREATE', 'Project', '19', NULL, '{\"Contractor_ID\":18,\"Project_Status\":\"Ongoing\",\"Project_Category\":\"Infrastructure\",\"Project_Title\":\"MRT-7 (New Line)\",\"Project_Description\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla placerat, egestas turpis id, rhoncus arcu. Aliquam maximus at nulla eu vehicula. Curabitur consequat volutpat pharetra. Pellentesque eget lorem in est facilisis egestas. Fusce posuere augue id diam elementum, quis laoreet augue faucibus.\\\\r\\\\n\\\\r\\\\nProin gravida, ipsum ac sollicitudin hendrerit, mauris mauris feugiat justo, et pulvinar nunc quam vitae eros. Aliquam condimentum velit non neque iaculis, eget interdum risus interdum. Donec laoreet id purus in suscipit. Etiam ullamcorper dolor non dui aliquam scelerisque. Pellentesque quis massa imperdiet, feugiat elit sed, finibus risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce eget lectus diam. Suspendisse varius sem arcu, eu sagittis mauris blandit vitae. Vestibulum et porttitor lorem. Etiam quis imperdiet libero. Suspendisse viverra ante ac vulputate ultricies.\\\\r\\\\n\\\\r\\\\nNunc vitae accumsan enim. Aliquam vehicula, ante id fringilla tempor, enim quam venenatis sem, non pretium neque elit vitae est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi hendrerit nisi nec aliquet convallis. Nulla at aliquam felis. Vivamus ante risus, dictum placerat mauris vitae, volutpat mattis quam. Integer iaculis tortor felis, vitae consequat diam convallis nec. Maecenas facilisis venenatis rutrum. Nam congue massa eget lacus luctus mattis. Duis ornare sem vel dapibus congue. In hac habitasse platea dictumst. Ut odio tellus, lobortis in elit quis, faucibus sollicitudin nunc. Phasellus vitae mi interdum, luctus ligula nec, efficitur turpis. Praesent porta tellus non dolor tempor tristique.\\\\r\\\\n\\\\r\\\\nInteger id lacinia ipsum, ac elementum turpis. Mauris magna lectus, accumsan non risus in, interdum consequat neque. Praesent gravida urna at nibh sodales, sed ornare urna vestibulum. Sed a urna nec mi volutpat lacinia non nec enim. Integer eu posuere ipsum, nec ornare lorem. Duis pulvinar vestibulum justo, sed faucibus libero. Nunc vitae tincidunt lorem, quis scelerisque tellus. In efficitur orci pellentesque lobortis imperdiet.\\\\r\\\\n\\\\r\\\\nVivamus fringilla, purus vitae rhoncus dictum, tellus augue dignissim eros, finibus gravida dolor dolor quis metus. Integer faucibus vitae nunc nec consequat. Nam venenatis orci convallis est tristique, non hendrerit libero aliquet. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam iaculis tortor non nibh pulvinar euismod. Integer elementum ex at hendrerit finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam a sapien turpis.\",\"Project_Budget\":62007000000,\"Location\":\"Commonwealth Avenue, Holy Spirit, 1127\",\"Started_Date\":\"2017-06-07\",\"End_Date\":\"2028-06-29\"}', '2026-01-19 13:11:13'),
(0x36396539333933392d663533392d3131, '8', 'CREATE', 'Project', '20', NULL, '{\"Contractor_ID\":10,\"Project_Status\":\"Ongoing\",\"Project_Category\":\"Infrastructure\",\"Project_Title\":\"MRT-7 North Avenue Common Station (Area Segment A)\",\"Project_Description\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla placerat, egestas turpis id, rhoncus arcu. Aliquam maximus at nulla eu vehicula. Curabitur consequat volutpat pharetra. Pellentesque eget lorem in est facilisis egestas. Fusce posuere augue id diam elementum, quis laoreet augue faucibus.\\\\r\\\\n\\\\r\\\\nProin gravida, ipsum ac sollicitudin hendrerit, mauris mauris feugiat justo, et pulvinar nunc quam vitae eros. Aliquam condimentum velit non neque iaculis, eget interdum risus interdum. Donec laoreet id purus in suscipit. Etiam ullamcorper dolor non dui aliquam scelerisque. Pellentesque quis massa imperdiet, feugiat elit sed, finibus risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce eget lectus diam. Suspendisse varius sem arcu, eu sagittis mauris blandit vitae. Vestibulum et porttitor lorem. Etiam quis imperdiet libero. Suspendisse viverra ante ac vulputate ultricies.\\\\r\\\\n\\\\r\\\\nNunc vitae accumsan enim. Aliquam vehicula, ante id fringilla tempor, enim quam venenatis sem, non pretium neque elit vitae est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi hendrerit nisi nec aliquet convallis. Nulla at aliquam felis. Vivamus ante risus, dictum placerat mauris vitae, volutpat mattis quam. Integer iaculis tortor felis, vitae consequat diam convallis nec. Maecenas facilisis venenatis rutrum. Nam congue massa eget lacus luctus mattis. Duis ornare sem vel dapibus congue. In hac habitasse platea dictumst. Ut odio tellus, lobortis in elit quis, faucibus sollicitudin nunc. Phasellus vitae mi interdum, luctus ligula nec, efficitur turpis. Praesent porta tellus non dolor tempor tristique.\\\\r\\\\n\\\\r\\\\nInteger id lacinia ipsum, ac elementum turpis. Mauris magna lectus, accumsan non risus in, interdum consequat neque. Praesent gravida urna at nibh sodales, sed ornare urna vestibulum. Sed a urna nec mi volutpat lacinia non nec enim. Integer eu posuere ipsum, nec ornare lorem. Duis pulvinar vestibulum justo, sed faucibus libero. Nunc vitae tincidunt lorem, quis scelerisque tellus. In efficitur orci pellentesque lobortis imperdiet.\\\\r\\\\n\\\\r\\\\nVivamus fringilla, purus vitae rhoncus dictum, tellus augue dignissim eros, finibus gravida dolor dolor quis metus. Integer faucibus vitae nunc nec consequat. Nam venenatis orci convallis est tristique, non hendrerit libero aliquet. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam iaculis tortor non nibh pulvinar euismod. Integer elementum ex at hendrerit finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam a sapien turpis.\",\"Project_Budget\":2008000000,\"Location\":\"North Avenue, Diliman, 1148\",\"Started_Date\":\"2020-10-08\",\"End_Date\":\"2028-02-24\"}', '2026-01-19 13:18:58'),
(0x36633835343132322d663431312d3131, '6', 'CREATE', 'users', '8', NULL, '{\"name\":\"Uno Tarun\",\"role\":\"admin\",\"email\":\"unotarun@gmail.com\",\"qc_id\":\"13285297641\"}', '2026-01-18 02:00:12'),
(0x36636161613534652d663535332d3131, '9', 'CREATE', 'users', '20', NULL, '{\"name\":\"Kellan Montgomery\",\"role\":\"citizen\",\"email\":\"k.montgomery@gmail.com\",\"qc_id\":\"51588060498\"}', '2026-01-19 16:25:10'),
(0x37613034633164322d663534642d3131, '8', 'CREATE', 'Project', '28', NULL, '{\"Contractor_ID\":24,\"Project_Status\":\"Ongoing\",\"Project_Category\":\"Environmental\",\"Project_Title\":\"La Mesa Water Treatment Plant 2 (Rehabilitation)\",\"Project_Description\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla placerat, egestas turpis id, rhoncus arcu. Aliquam maximus at nulla eu vehicula. Curabitur consequat volutpat pharetra. Pellentesque eget lorem in est facilisis egestas. Fusce posuere augue id diam elementum, quis laoreet augue faucibus.\\\\r\\\\n\\\\r\\\\nProin gravida, ipsum ac sollicitudin hendrerit, mauris mauris feugiat justo, et pulvinar nunc quam vitae eros. Aliquam condimentum velit non neque iaculis, eget interdum risus interdum. Donec laoreet id purus in suscipit. Etiam ullamcorper dolor non dui aliquam scelerisque. Pellentesque quis massa imperdiet, feugiat elit sed, finibus risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce eget lectus diam. Suspendisse varius sem arcu, eu sagittis mauris blandit vitae. Vestibulum et porttitor lorem. Etiam quis imperdiet libero. Suspendisse viverra ante ac vulputate ultricies.\\\\r\\\\n\\\\r\\\\nNunc vitae accumsan enim. Aliquam vehicula, ante id fringilla tempor, enim quam venenatis sem, non pretium neque elit vitae est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi hendrerit nisi nec aliquet convallis. Nulla at aliquam felis. Vivamus ante risus, dictum placerat mauris vitae, volutpat mattis quam. Integer iaculis tortor felis, vitae consequat diam convallis nec. Maecenas facilisis venenatis rutrum. Nam congue massa eget lacus luctus mattis. Duis ornare sem vel dapibus congue. In hac habitasse platea dictumst. Ut odio tellus, lobortis in elit quis, faucibus sollicitudin nunc. Phasellus vitae mi interdum, luctus ligula nec, efficitur turpis. Praesent porta tellus non dolor tempor tristique.\\\\r\\\\n\\\\r\\\\nInteger id lacinia ipsum, ac elementum turpis. Mauris magna lectus, accumsan non risus in, interdum consequat neque. Praesent gravida urna at nibh sodales, sed ornare urna vestibulum. Sed a urna nec mi volutpat lacinia non nec enim. Integer eu posuere ipsum, nec ornare lorem. Duis pulvinar vestibulum justo, sed faucibus libero. Nunc vitae tincidunt lorem, quis scelerisque tellus. In efficitur orci pellentesque lobortis imperdiet.\\\\r\\\\n\\\\r\\\\nVivamus fringilla, purus vitae rhoncus dictum, tellus augue dignissim eros, finibus gravida dolor dolor quis metus. Integer faucibus vitae nunc nec consequat. Nam venenatis orci convallis est tristique, non hendrerit libero aliquet. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam iaculis tortor non nibh pulvinar euismod. Integer elementum ex at hendrerit finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam a sapien turpis.\",\"Project_Budget\":56000000000,\"Location\":\"Mathew Street, Commonwealth, 1121\",\"Started_Date\":\"2025-02-20\",\"End_Date\":\"2027-07-13\"}', '2026-01-19 15:42:35'),
(0x37663531613732652d663430612d3131, '6', 'DEACTIVATE', 'users', '7', '{\"user_status\":\"active\"}', '{\"user_status\":\"inactive\"}', '2026-01-18 01:10:37'),
(0x37663938353134612d663534352d3131, '6', 'CREATE', 'Project', '27', NULL, '{\"Contractor_ID\":14,\"Project_Status\":\"Completed\",\"Project_Category\":\"Environmental\",\"Project_Title\":\"Novaliches Underground Detention Basin\",\"Project_Description\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla placerat, egestas turpis id, rhoncus arcu. Aliquam maximus at nulla eu vehicula. Curabitur consequat volutpat pharetra. Pellentesque eget lorem in est facilisis egestas. Fusce posuere augue id diam elementum, quis laoreet augue faucibus.\\\\r\\\\n\\\\r\\\\nProin gravida, ipsum ac sollicitudin hendrerit, mauris mauris feugiat justo, et pulvinar nunc quam vitae eros. Aliquam condimentum velit non neque iaculis, eget interdum risus interdum. Donec laoreet id purus in suscipit. Etiam ullamcorper dolor non dui aliquam scelerisque. Pellentesque quis massa imperdiet, feugiat elit sed, finibus risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce eget lectus diam. Suspendisse varius sem arcu, eu sagittis mauris blandit vitae. Vestibulum et porttitor lorem. Etiam quis imperdiet libero. Suspendisse viverra ante ac vulputate ultricies.\\\\r\\\\n\\\\r\\\\nNunc vitae accumsan enim. Aliquam vehicula, ante id fringilla tempor, enim quam venenatis sem, non pretium neque elit vitae est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi hendrerit nisi nec aliquet convallis. Nulla at aliquam felis. Vivamus ante risus, dictum placerat mauris vitae, volutpat mattis quam. Integer iaculis tortor felis, vitae consequat diam convallis nec. Maecenas facilisis venenatis rutrum. Nam congue massa eget lacus luctus mattis. Duis ornare sem vel dapibus congue. In hac habitasse platea dictumst. Ut odio tellus, lobortis in elit quis, faucibus sollicitudin nunc. Phasellus vitae mi interdum, luctus ligula nec, efficitur turpis. Praesent porta tellus non dolor tempor tristique.\\\\r\\\\n\\\\r\\\\nInteger id lacinia ipsum, ac elementum turpis. Mauris magna lectus, accumsan non risus in, interdum consequat neque. Praesent gravida urna at nibh sodales, sed ornare urna vestibulum. Sed a urna nec mi volutpat lacinia non nec enim. Integer eu posuere ipsum, nec ornare lorem. Duis pulvinar vestibulum justo, sed faucibus libero. Nunc vitae tincidunt lorem, quis scelerisque tellus. In efficitur orci pellentesque lobortis imperdiet.\\\\r\\\\n\\\\r\\\\nVivamus fringilla, purus vitae rhoncus dictum, tellus augue dignissim eros, finibus gravida dolor dolor quis metus. Integer faucibus vitae nunc nec consequat. Nam venenatis orci convallis est tristique, non hendrerit libero aliquet. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam iaculis tortor non nibh pulvinar euismod. Integer elementum ex at hendrerit finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam a sapien turpis.\",\"Project_Budget\":40000000,\"Location\":\"General Luis Street, Novaliches Proper, 1125\",\"Started_Date\":\"2024-06-05\",\"End_Date\":\"2025-05-13\"}', '2026-01-19 14:45:28'),
(0x38353833643134382d663535322d3131, '9', 'CREATE', 'users', '14', NULL, '{\"name\":\"Prince Mendoza\",\"role\":\"citizen\",\"email\":\"p.mendoza@gmail.com\",\"qc_id\":\"86180871186\"}', '2026-01-19 16:18:42'),
(0x38383162636330372d663533662d3131, '9', 'CREATE', 'Project', '23', NULL, '{\"Contractor_ID\":15,\"Project_Status\":\"Completed\",\"Project_Category\":\"Environmental\",\"Project_Title\":\"NLEX-C5 Segment 8.2 Construction\",\"Project_Description\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla placerat, egestas turpis id, rhoncus arcu. Aliquam maximus at nulla eu vehicula. Curabitur consequat volutpat pharetra. Pellentesque eget lorem in est facilisis egestas. Fusce posuere augue id diam elementum, quis laoreet augue faucibus.\\\\r\\\\n\\\\r\\\\nProin gravida, ipsum ac sollicitudin hendrerit, mauris mauris feugiat justo, et pulvinar nunc quam vitae eros. Aliquam condimentum velit non neque iaculis, eget interdum risus interdum. Donec laoreet id purus in suscipit. Etiam ullamcorper dolor non dui aliquam scelerisque. Pellentesque quis massa imperdiet, feugiat elit sed, finibus risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce eget lectus diam. Suspendisse varius sem arcu, eu sagittis mauris blandit vitae. Vestibulum et porttitor lorem. Etiam quis imperdiet libero. Suspendisse viverra ante ac vulputate ultricies.\\\\r\\\\n\\\\r\\\\nNunc vitae accumsan enim. Aliquam vehicula, ante id fringilla tempor, enim quam venenatis sem, non pretium neque elit vitae est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi hendrerit nisi nec aliquet convallis. Nulla at aliquam felis. Vivamus ante risus, dictum placerat mauris vitae, volutpat mattis quam. Integer iaculis tortor felis, vitae consequat diam convallis nec. Maecenas facilisis venenatis rutrum. Nam congue massa eget lacus luctus mattis. Duis ornare sem vel dapibus congue. In hac habitasse platea dictumst. Ut odio tellus, lobortis in elit quis, faucibus sollicitudin nunc. Phasellus vitae mi interdum, luctus ligula nec, efficitur turpis. Praesent porta tellus non dolor tempor tristique.\\\\r\\\\n\\\\r\\\\nInteger id lacinia ipsum, ac elementum turpis. Mauris magna lectus, accumsan non risus in, interdum consequat neque. Praesent gravida urna at nibh sodales, sed ornare urna vestibulum. Sed a urna nec mi volutpat lacinia non nec enim. Integer eu posuere ipsum, nec ornare lorem. Duis pulvinar vestibulum justo, sed faucibus libero. Nunc vitae tincidunt lorem, quis scelerisque tellus. In efficitur orci pellentesque lobortis imperdiet.\\\\r\\\\n\\\\r\\\\nVivamus fringilla, purus vitae rhoncus dictum, tellus augue dignissim eros, finibus gravida dolor dolor quis metus. Integer faucibus vitae nunc nec consequat. Nam venenatis orci convallis est tristique, non hendrerit libero aliquet. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam iaculis tortor non nibh pulvinar euismod. Integer elementum ex at hendrerit finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam a sapien turpis.\",\"Project_Budget\":2002000000,\"Location\":\"North Luzon Expressway, Libis Baesa\\/Reparo, 1401\",\"Started_Date\":\"2024-06-20\",\"End_Date\":\"2025-11-20\"}', '2026-01-19 14:02:46'),
(0x38386662666636642d663534612d3131, '8', 'CREATE', 'Contractor', '24', NULL, '{\"Company_Name\":\"PrimeFlow Plumbing Solutions\",\"Owner_Name\":\"Engr. Ricardo M. Dalisay\",\"Company_Address\":\"88 Waterway Lane, Barangay San Antonio, Pasig City, 1605 Metro Manila\",\"Contact_Number\":\"39451234566\",\"Company_Email\":\"contact@primeflow.ph\",\"Years_Of_Experience\":15,\"Logo_Path\":\"\\/QTrace-Website\\/uploads\\/contractors\\/logos\\/PrimeFlow_Plumbing_Solutions_logo.jpg\",\"Additional_Notes\":\"Specialists in high-pressure water systems for commercial skyscrapers and hotels.\"}', '2026-01-19 15:21:32'),
(0x39353061363139302d663535332d3131, '9', 'CREATE', 'users', '21', NULL, '{\"name\":\"Sienna Rhodes\",\"role\":\"citizen\",\"email\":\"s.rhodes@gmail.com\",\"qc_id\":\"53249342920\"}', '2026-01-19 16:26:17'),
(0x61343134333363322d663535322d3131, '9', 'CREATE', 'users', '15', NULL, '{\"name\":\"Juan Lozada\",\"role\":\"citizen\",\"email\":\"j.lozada@gmail.com\",\"qc_id\":\"46688937833\"}', '2026-01-19 16:19:33'),
(0x61383963383438302d663535312d3131, '9', 'CREATE', 'Project', '32', NULL, '{\"Contractor_ID\":22,\"Project_Status\":\"Planning\",\"Project_Category\":\"Social Services\",\"Project_Title\":\"Harmony Hills Terraces (4PH Housing)\",\"Project_Description\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla placerat, egestas turpis id, rhoncus arcu. Aliquam maximus at nulla eu vehicula. Curabitur consequat volutpat pharetra. Pellentesque eget lorem in est facilisis egestas. Fusce posuere augue id diam elementum, quis laoreet augue faucibus.\\\\r\\\\n\\\\r\\\\nProin gravida, ipsum ac sollicitudin hendrerit, mauris mauris feugiat justo, et pulvinar nunc quam vitae eros. Aliquam condimentum velit non neque iaculis, eget interdum risus interdum. Donec laoreet id purus in suscipit. Etiam ullamcorper dolor non dui aliquam scelerisque. Pellentesque quis massa imperdiet, feugiat elit sed, finibus risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce eget lectus diam. Suspendisse varius sem arcu, eu sagittis mauris blandit vitae. Vestibulum et porttitor lorem. Etiam quis imperdiet libero. Suspendisse viverra ante ac vulputate ultricies.\\\\r\\\\n\\\\r\\\\nNunc vitae accumsan enim. Aliquam vehicula, ante id fringilla tempor, enim quam venenatis sem, non pretium neque elit vitae est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi hendrerit nisi nec aliquet convallis. Nulla at aliquam felis. Vivamus ante risus, dictum placerat mauris vitae, volutpat mattis quam. Integer iaculis tortor felis, vitae consequat diam convallis nec. Maecenas facilisis venenatis rutrum. Nam congue massa eget lacus luctus mattis. Duis ornare sem vel dapibus congue. In hac habitasse platea dictumst. Ut odio tellus, lobortis in elit quis, faucibus sollicitudin nunc. Phasellus vitae mi interdum, luctus ligula nec, efficitur turpis. Praesent porta tellus non dolor tempor tristique.\\\\r\\\\n\\\\r\\\\nInteger id lacinia ipsum, ac elementum turpis. Mauris magna lectus, accumsan non risus in, interdum consequat neque. Praesent gravida urna at nibh sodales, sed ornare urna vestibulum. Sed a urna nec mi volutpat lacinia non nec enim. Integer eu posuere ipsum, nec ornare lorem. Duis pulvinar vestibulum justo, sed faucibus libero. Nunc vitae tincidunt lorem, quis scelerisque tellus. In efficitur orci pellentesque lobortis imperdiet.\\\\r\\\\n\\\\r\\\\nVivamus fringilla, purus vitae rhoncus dictum, tellus augue dignissim eros, finibus gravida dolor dolor quis metus. Integer faucibus vitae nunc nec consequat. Nam venenatis orci convallis est tristique, non hendrerit libero aliquet. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam iaculis tortor non nibh pulvinar euismod. Integer elementum ex at hendrerit finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam a sapien turpis.\",\"Project_Budget\":250000000,\"Location\":\"Pangasinan Street, Batasan Hills, 1126\",\"Started_Date\":\"2026-03-12\",\"End_Date\":\"2026-07-10\"}', '2026-01-19 16:12:31'),
(0x61643135643733662d663431322d3131, '6', 'CREATE', 'users', '9', NULL, '{\"name\":\"Alexander Deguzman\",\"role\":\"admin\",\"email\":\"Alex@gmail.com\",\"qc_id\":\"97516143278\"}', '2026-01-18 02:09:09'),
(0x63333631386566662d663535322d3131, '9', 'CREATE', 'users', '16', NULL, '{\"name\":\"Alex Montifalco\",\"role\":\"citizen\",\"email\":\"a.montifalco@gmail.com\",\"qc_id\":\"21180117990\"}', '2026-01-19 16:20:26');
INSERT INTO `audit_logs` (`audit_log_id`, `user_id`, `action`, `resource_type`, `resource_id`, `old_values`, `new_values`, `created_at`) VALUES
(0x63336138373639372d663533642d3131, '8', 'CREATE', 'Project', '22', NULL, '{\"Contractor_ID\":12,\"Project_Status\":\"Delayed\",\"Project_Category\":\"Infrastructure\",\"Project_Title\":\"MRT Tandang Sora Station\",\"Project_Description\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla placerat, egestas turpis id, rhoncus arcu. Aliquam maximus at nulla eu vehicula. Curabitur consequat volutpat pharetra. Pellentesque eget lorem in est facilisis egestas. Fusce posuere augue id diam elementum, quis laoreet augue faucibus.\\\\r\\\\n\\\\r\\\\nProin gravida, ipsum ac sollicitudin hendrerit, mauris mauris feugiat justo, et pulvinar nunc quam vitae eros. Aliquam condimentum velit non neque iaculis, eget interdum risus interdum. Donec laoreet id purus in suscipit. Etiam ullamcorper dolor non dui aliquam scelerisque. Pellentesque quis massa imperdiet, feugiat elit sed, finibus risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce eget lectus diam. Suspendisse varius sem arcu, eu sagittis mauris blandit vitae. Vestibulum et porttitor lorem. Etiam quis imperdiet libero. Suspendisse viverra ante ac vulputate ultricies.\\\\r\\\\n\\\\r\\\\nNunc vitae accumsan enim. Aliquam vehicula, ante id fringilla tempor, enim quam venenatis sem, non pretium neque elit vitae est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi hendrerit nisi nec aliquet convallis. Nulla at aliquam felis. Vivamus ante risus, dictum placerat mauris vitae, volutpat mattis quam. Integer iaculis tortor felis, vitae consequat diam convallis nec. Maecenas facilisis venenatis rutrum. Nam congue massa eget lacus luctus mattis. Duis ornare sem vel dapibus congue. In hac habitasse platea dictumst. Ut odio tellus, lobortis in elit quis, faucibus sollicitudin nunc. Phasellus vitae mi interdum, luctus ligula nec, efficitur turpis. Praesent porta tellus non dolor tempor tristique.\\\\r\\\\n\\\\r\\\\nInteger id lacinia ipsum, ac elementum turpis. Mauris magna lectus, accumsan non risus in, interdum consequat neque. Praesent gravida urna at nibh sodales, sed ornare urna vestibulum. Sed a urna nec mi volutpat lacinia non nec enim. Integer eu posuere ipsum, nec ornare lorem. Duis pulvinar vestibulum justo, sed faucibus libero. Nunc vitae tincidunt lorem, quis scelerisque tellus. In efficitur orci pellentesque lobortis imperdiet.\\\\r\\\\n\\\\r\\\\nVivamus fringilla, purus vitae rhoncus dictum, tellus augue dignissim eros, finibus gravida dolor dolor quis metus. Integer faucibus vitae nunc nec consequat. Nam venenatis orci convallis est tristique, non hendrerit libero aliquet. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam iaculis tortor non nibh pulvinar euismod. Integer elementum ex at hendrerit finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam a sapien turpis.\",\"Project_Budget\":24000000,\"Location\":\"Commonwealth Avenue, Pook Palaris, 1101\",\"Started_Date\":\"2024-06-13\",\"End_Date\":\"2025-07-23\"}', '2026-01-19 13:50:07'),
(0x64393230373436352d663534382d3131, '6', 'CREATE', 'Contractor', '21', NULL, '{\"Company_Name\":\"BuildRight Solutions Philippines\",\"Owner_Name\":\"Roberto G. Santos\",\"Company_Address\":\"Unit 402, Highrise Tower, Ayala Avenue, Makati City, 1226 Metro Manila\",\"Contact_Number\":\"3917123456\",\"Company_Email\":\"r.santos@buildright.ph\",\"Years_Of_Experience\":12,\"Logo_Path\":\"\\/QTrace-Website\\/uploads\\/contractors\\/logos\\/BuildRight_Solutions_Philippines_logo.jpg\",\"Additional_Notes\":\"Specializes in mid-rise residential buildings and warehouse retrofitting.\"}', '2026-01-19 15:09:27'),
(0x64396564353562612d663533362d3131, '8', 'CREATE', 'Project', '18', NULL, '{\"Contractor_ID\":11,\"Project_Status\":\"Ongoing\",\"Project_Category\":\"Infrastructure\",\"Project_Title\":\"Metro Manila Subway\",\"Project_Description\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla placerat, egestas turpis id, rhoncus arcu. Aliquam maximus at nulla eu vehicula. Curabitur consequat volutpat pharetra. Pellentesque eget lorem in est facilisis egestas. Fusce posuere augue id diam elementum, quis laoreet augue faucibus.\\\\r\\\\n\\\\r\\\\nProin gravida, ipsum ac sollicitudin hendrerit, mauris mauris feugiat justo, et pulvinar nunc quam vitae eros. Aliquam condimentum velit non neque iaculis, eget interdum risus interdum. Donec laoreet id purus in suscipit. Etiam ullamcorper dolor non dui aliquam scelerisque. Pellentesque quis massa imperdiet, feugiat elit sed, finibus risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce eget lectus diam. Suspendisse varius sem arcu, eu sagittis mauris blandit vitae. Vestibulum et porttitor lorem. Etiam quis imperdiet libero. Suspendisse viverra ante ac vulputate ultricies.\\\\r\\\\n\\\\r\\\\nNunc vitae accumsan enim. Aliquam vehicula, ante id fringilla tempor, enim quam venenatis sem, non pretium neque elit vitae est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi hendrerit nisi nec aliquet convallis. Nulla at aliquam felis. Vivamus ante risus, dictum placerat mauris vitae, volutpat mattis quam. Integer iaculis tortor felis, vitae consequat diam convallis nec. Maecenas facilisis venenatis rutrum. Nam congue massa eget lacus luctus mattis. Duis ornare sem vel dapibus congue. In hac habitasse platea dictumst. Ut odio tellus, lobortis in elit quis, faucibus sollicitudin nunc. Phasellus vitae mi interdum, luctus ligula nec, efficitur turpis. Praesent porta tellus non dolor tempor tristique.\\\\r\\\\n\\\\r\\\\nInteger id lacinia ipsum, ac elementum turpis. Mauris magna lectus, accumsan non risus in, interdum consequat neque. Praesent gravida urna at nibh sodales, sed ornare urna vestibulum. Sed a urna nec mi volutpat lacinia non nec enim. Integer eu posuere ipsum, nec ornare lorem. Duis pulvinar vestibulum justo, sed faucibus libero. Nunc vitae tincidunt lorem, quis scelerisque tellus. In efficitur orci pellentesque lobortis imperdiet.\\\\r\\\\n\\\\r\\\\nVivamus fringilla, purus vitae rhoncus dictum, tellus augue dignissim eros, finibus gravida dolor dolor quis metus. Integer faucibus vitae nunc nec consequat. Nam venenatis orci convallis est tristique, non hendrerit libero aliquet. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam iaculis tortor non nibh pulvinar euismod. Integer elementum ex at hendrerit finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam a sapien turpis.\",\"Project_Budget\":355000000000,\"Location\":\"Mindanao Avenue, Villa Florencia Subdivision, 1116\",\"Started_Date\":\"2019-02-27\",\"End_Date\":\"2029-06-18\"}', '2026-01-19 13:00:38'),
(0x64616333376332622d663534612d3131, '8', 'CREATE', 'Contractor', '25', NULL, '{\"Company_Name\":\"\",\"Owner_Name\":\"\",\"Company_Address\":\"\",\"Contact_Number\":\"\",\"Company_Email\":\"\",\"Years_Of_Experience\":0,\"Logo_Path\":\"\",\"Additional_Notes\":\"\"}', '2026-01-19 15:23:49'),
(0x64643834313538382d663534342d3131, '6', 'CREATE', 'Project', '26', NULL, '{\"Contractor_ID\":13,\"Project_Status\":\"Delayed\",\"Project_Category\":\"Infrastructure\",\"Project_Title\":\"Aurora Blvd. Sidewalk & Lighting\",\"Project_Description\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla placerat, egestas turpis id, rhoncus arcu. Aliquam maximus at nulla eu vehicula. Curabitur consequat volutpat pharetra. Pellentesque eget lorem in est facilisis egestas. Fusce posuere augue id diam elementum, quis laoreet augue faucibus.\\\\r\\\\n\\\\r\\\\nProin gravida, ipsum ac sollicitudin hendrerit, mauris mauris feugiat justo, et pulvinar nunc quam vitae eros. Aliquam condimentum velit non neque iaculis, eget interdum risus interdum. Donec laoreet id purus in suscipit. Etiam ullamcorper dolor non dui aliquam scelerisque. Pellentesque quis massa imperdiet, feugiat elit sed, finibus risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce eget lectus diam. Suspendisse varius sem arcu, eu sagittis mauris blandit vitae. Vestibulum et porttitor lorem. Etiam quis imperdiet libero. Suspendisse viverra ante ac vulputate ultricies.\\\\r\\\\n\\\\r\\\\nNunc vitae accumsan enim. Aliquam vehicula, ante id fringilla tempor, enim quam venenatis sem, non pretium neque elit vitae est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi hendrerit nisi nec aliquet convallis. Nulla at aliquam felis. Vivamus ante risus, dictum placerat mauris vitae, volutpat mattis quam. Integer iaculis tortor felis, vitae consequat diam convallis nec. Maecenas facilisis venenatis rutrum. Nam congue massa eget lacus luctus mattis. Duis ornare sem vel dapibus congue. In hac habitasse platea dictumst. Ut odio tellus, lobortis in elit quis, faucibus sollicitudin nunc. Phasellus vitae mi interdum, luctus ligula nec, efficitur turpis. Praesent porta tellus non dolor tempor tristique.\\\\r\\\\n\\\\r\\\\nInteger id lacinia ipsum, ac elementum turpis. Mauris magna lectus, accumsan non risus in, interdum consequat neque. Praesent gravida urna at nibh sodales, sed ornare urna vestibulum. Sed a urna nec mi volutpat lacinia non nec enim. Integer eu posuere ipsum, nec ornare lorem. Duis pulvinar vestibulum justo, sed faucibus libero. Nunc vitae tincidunt lorem, quis scelerisque tellus. In efficitur orci pellentesque lobortis imperdiet.\\\\r\\\\n\\\\r\\\\nVivamus fringilla, purus vitae rhoncus dictum, tellus augue dignissim eros, finibus gravida dolor dolor quis metus. Integer faucibus vitae nunc nec consequat. Nam venenatis orci convallis est tristique, non hendrerit libero aliquet. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam iaculis tortor non nibh pulvinar euismod. Integer elementum ex at hendrerit finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam a sapien turpis.\",\"Project_Budget\":29900000,\"Location\":\"Aurora Boulevard, Cubao, 1111\",\"Started_Date\":\"2024-06-20\",\"End_Date\":\"2025-06-18\"}', '2026-01-19 14:40:57'),
(0x65393330643638622d663534392d3131, '9', 'CREATE', 'Contractor', '23', NULL, '{\"Company_Name\":\"Modern Vibe Interiors\",\"Owner_Name\":\"Antonio \\\\\\\"Tony\\\\\\\" Luna\",\"Company_Address\":\"G\\/F Creative Hub Bldg, Maginhawa St., Quezon City, 1101 Metro Manila\",\"Contact_Number\":\"3920334455\",\"Company_Email\":\"info@modernvibe.ph\",\"Years_Of_Experience\":5,\"Logo_Path\":\"\\/QTrace-Website\\/uploads\\/contractors\\/logos\\/Modern_Vibe_Interiors_logo.jpg\",\"Additional_Notes\":\"Strong focus on commercial office fit-outs and retail boutique renovations.\"}', '2026-01-19 15:17:04'),
(0x66386634333733622d663535312d3131, '9', 'CREATE', 'users', '11', NULL, '{\"name\":\"Joemari Berango\",\"role\":\"admin\",\"email\":\"j.berango@gmail.com\",\"qc_id\":\"61558680511\"}', '2026-01-19 16:14:46');

-- --------------------------------------------------------

--
-- Table structure for table `contractor_documents_table`
--

CREATE TABLE `contractor_documents_table` (
  `Contractor_Documents_Id` int(11) NOT NULL,
  `Contractor_Id` int(11) NOT NULL,
  `Document_Type` varchar(255) NOT NULL,
  `Document_Path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contractor_documents_table`
--

INSERT INTO `contractor_documents_table` (`Contractor_Documents_Id`, `Contractor_Id`, `Document_Type`, `Document_Path`) VALUES
(12, 10, 'Certificate', '/QTrace-Website/uploads/contractors/documents/BrightBuild_Construction_Co__Certificate.png'),
(13, 11, 'Certificate', '/QTrace-Website/uploads/contractors/documents/Apex_Infrastructure_Solutions_Certificate.png'),
(14, 12, 'License', '/QTrace-Website/uploads/contractors/documents/GreenLine_Engineering_Services_License.png'),
(15, 13, 'License', '/QTrace-Website/uploads/contractors/documents/SolidRock_Builders_License.png'),
(16, 14, 'License', '/QTrace-Website/uploads/contractors/documents/UrbanWorks_Development_Corp__License.png'),
(17, 15, 'License', '/QTrace-Website/uploads/contractors/documents/Horizon_Roadworks_Ltd__License.png'),
(18, 16, 'License', '/QTrace-Website/uploads/contractors/documents/Ironclad_Structures_Inc__License.png'),
(19, 17, 'License', '/QTrace-Website/uploads/contractors/documents/EcoCore_Civil_Engineering_License.png'),
(20, 18, 'License', '/QTrace-Website/uploads/contractors/documents/BlueHammer_Construction_License.png'),
(21, 19, 'License', '/QTrace-Website/uploads/contractors/documents/PrimeAxis_Contractors_License.png'),
(22, 20, 'SEC Registration, 2024 Mayor’s Permit, PCAB License', '/QTrace-Website/uploads/contractors/documents/BuildRight_Solutions_Philippines_SEC_Registration__2024_Mayor___s_Permit__PCAB_License.pdf'),
(24, 22, 'DTI Certification', '/QTrace-Website/uploads/contractors/documents/VoltArc_Electrical_Services_DTI_Certification.pdf'),
(25, 23, 'Business Permit', '/QTrace-Website/uploads/contractors/documents/Modern_Vibe_Interiors_Business_Permit.pdf'),
(26, 24, 'DTI Registration', '/QTrace-Website/uploads/contractors/documents/PrimeFlow_Plumbing_Solutions_DTI_Registration.pdf'),
(27, 26, 'VAT Registration', '/QTrace-Website/uploads/contractors/documents/CoolArctic_Air_Conditioning_Services_VAT_Registration.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `contractor_expertise_table`
--

CREATE TABLE `contractor_expertise_table` (
  `Contractor_Expertise_Id` int(11) NOT NULL,
  `Contractor_Id` int(11) NOT NULL,
  `Expertise` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contractor_expertise_table`
--

INSERT INTO `contractor_expertise_table` (`Contractor_Expertise_Id`, `Contractor_Id`, `Expertise`) VALUES
(18, 10, 'Roadworks'),
(19, 11, 'Roadworks'),
(20, 11, 'Asphalt paving'),
(21, 11, 'Procurement management'),
(22, 12, 'Environmental engineering'),
(23, 13, 'Concrete works'),
(24, 14, 'Site development'),
(25, 14, 'Urban planning'),
(26, 15, 'Highway construction'),
(27, 15, 'Traffic systems'),
(28, 16, 'Steel structures'),
(29, 16, 'Fabrication'),
(30, 16, 'Industrial construction'),
(31, 17, 'Waste systems'),
(32, 17, 'Green buildings'),
(33, 17, 'Water treatment'),
(34, 18, 'Steel structures'),
(35, 18, 'Concrete works'),
(36, 18, 'Foundation engineering'),
(37, 18, 'Heavy equipment operations'),
(38, 19, 'Sustainability planning'),
(39, 19, 'Urban planning'),
(40, 19, 'Cost estimation'),
(41, 19, 'Bidding documentation'),
(42, 20, 'Structural Engineering'),
(43, 20, 'Concrete Pouring'),
(44, 20, 'Project Management'),
(48, 22, 'Industrial Wiring'),
(49, 22, 'Solar Panel Installation'),
(50, 22, 'Smart Home Integration'),
(51, 23, 'Custom Cabinetry'),
(52, 23, 'Drywall Partitioning'),
(53, 23, 'Interior Design'),
(54, 24, 'Master Plumbing'),
(55, 24, 'Drainage System Design'),
(56, 24, 'Industrial Pump Installation'),
(57, 26, 'Centralized AC Installation'),
(58, 26, 'VRF Systems'),
(59, 26, 'Preventive Maintenance');

-- --------------------------------------------------------

--
-- Table structure for table `contractor_table`
--

CREATE TABLE `contractor_table` (
  `Contractor_Id` int(11) NOT NULL,
  `Contractor_Logo_Path` varchar(255) NOT NULL,
  `Contractor_Name` varchar(50) NOT NULL,
  `Owner_Name` varchar(50) NOT NULL,
  `Company_Address` varchar(100) NOT NULL,
  `Contact_Number` bigint(20) NOT NULL,
  `Company_Email_Address` varchar(50) NOT NULL,
  `Years_Of_Experience` int(11) NOT NULL,
  `Additional_Notes` varchar(250) NOT NULL,
  `Created_At` date NOT NULL DEFAULT current_timestamp(),
  `Contractor_Status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contractor_table`
--

INSERT INTO `contractor_table` (`Contractor_Id`, `Contractor_Logo_Path`, `Contractor_Name`, `Owner_Name`, `Company_Address`, `Contact_Number`, `Company_Email_Address`, `Years_Of_Experience`, `Additional_Notes`, `Created_At`, `Contractor_Status`) VALUES
(10, '/QTrace-Website/uploads/contractors/logos/BrightBuild_Construction_Co__logo.jpg', 'BrightBuild Construction Co.', 'Engr. Marco Dela Cruz', '1186 Quezon Avenue, Diliman, Quezon City 1101', 9172458831, 'marcodelacruz@brightbuild.ph', 12, '', '2026-01-15', ''),
(11, '/QTrace-Website/uploads/contractors/logos/Apex_Infrastructure_Solutions_logo.jpg', 'Apex Infrastructure Solutions', 'Liza R. Santos', '16 P. Tuazon Blvd, Barangay Kaunlaran, Quezon City 1111', 9281107742, 'liza.santos@apexinfra.ph', 12, '', '2026-01-15', ''),
(12, '/QTrace-Website/uploads/contractors/logos/GreenLine_Engineering_Services_logo.jpg', 'GreenLine Engineering Services', 'Engr. Paolo Ramirez', '224 Don C. Manuel Avenue, Quezon City 1115', 9954821160, 'pramirez@greenline.ph', 10, '', '2026-01-15', ''),
(13, '/QTrace-Website/uploads/contractors/logos/SolidRock_Builders_logo.jpg', 'SolidRock Builders', 'Victor M. Tan', '239 Kanlaon Avenue, Quezon City 1114', 9167742309, 'victortan@solidrock.ph', 3, '', '2026-01-15', ''),
(14, '/QTrace-Website/uploads/contractors/logos/UrbanWorks_Development_Corp__logo.jpg', 'UrbanWorks Development Corp.', 'Carla Joy Mendoza', '28 Kamuning Road, Quezon City 1103', 9305569912, 'carla.mendoza@urbanworks.ph', 20, '', '2026-01-15', ''),
(15, '/QTrace-Website/uploads/contractors/logos/Horizon_Roadworks_Ltd__logo.jpg', 'Horizon Roadworks Ltd.', 'Engr. Dennis Villanueva', '67 Timog Avenue, South Triangle, Quezon City 1103', 9472225084, 'dvillanueva@horizonworks.ph', 33, '', '2026-01-15', ''),
(16, '/QTrace-Website/uploads/contractors/logos/Ironclad_Structures_Inc__logo.jpg', 'Ironclad Structures Inc.', 'Engr. Jonathan Cruz', 'Del Monte Avenue, Quezon City 1105', 9926641188, 'jcruz@ironclad.ph', 56, '', '2026-01-15', ''),
(17, '/QTrace-Website/uploads/contractors/logos/EcoCore_Civil_Engineering_logo.jpg', 'EcoCore Civil Engineering', 'Melissa A. Navarro', 'Agham Road, Quezon City 1103', 9667754203, 'mnavarro@ecocore.ph', 67, '', '2026-01-15', ''),
(18, '/QTrace-Website/uploads/contractors/logos/BlueHammer_Construction_logo.jpg', 'BlueHammer Construction', 'Roberto Lim', 'Mayon Avenue corner Calamba Street, San Isidro Labrador, Quezon City 1125', 9213806675, 'rlim@bluehammer.ph', 73, '', '2026-01-15', ''),
(19, '/QTrace-Website/uploads/contractors/logos/PrimeAxis_Contractors_logo.jpg', 'PrimeAxis Contractors', 'Angela T. Flores', 'Banawe Avenue, Quezon City 1105', 9184497311, 'angela.flores@primeaxis.ph', 45, '', '2026-01-15', ''),
(20, '/QTrace-Website/uploads/contractors/logos/BuildRight_Solutions_Philippines_logo.jpg', 'BuildRight Solutions Philippines', 'Roberto G. Santos', 'Unit 402, Highrise Tower, Ayala Avenue, Makati City, 1226 Metro Manila', 3917123456, 'r.santos@buildright.ph', 12, 'Specializes in mid-rise residential buildings and warehouse retrofitting.', '2026-01-19', ''),
(22, '/QTrace-Website/uploads/contractors/logos/VoltArc_Electrical_Services_logo.jpg', 'VoltArc Electrical Services', 'Maria Clara Reyes', '15-B Industrial Way, Barangay Ugong, Pasig City, 1604 Metro Manila', 3318987654, 'm.reyes@voltarc.com', 8, 'Preferred vendor for eco-friendly housing projects. Known for high safety standards.', '2026-01-19', ''),
(23, '/QTrace-Website/uploads/contractors/logos/Modern_Vibe_Interiors_logo.jpg', 'Modern Vibe Interiors', 'Antonio \\\"Tony\\\" Luna', 'G/F Creative Hub Bldg, Maginhawa St., Quezon City, 1101 Metro Manila', 3920334455, 'info@modernvibe.ph', 5, 'Strong focus on commercial office fit-outs and retail boutique renovations.', '2026-01-19', ''),
(24, '/QTrace-Website/uploads/contractors/logos/PrimeFlow_Plumbing_Solutions_logo.jpg', 'PrimeFlow Plumbing Solutions', 'Engr. Ricardo M. Dalisay', '88 Waterway Lane, Barangay San Antonio, Pasig City, 1605 Metro Manila', 39451234566, 'contact@primeflow.ph', 15, 'Specialists in high-pressure water systems for commercial skyscrapers and hotels.', '2026-01-19', ''),
(26, '/QTrace-Website/uploads/contractors/logos/CoolArctic_Air_Conditioning_Services_logo.jpg', 'CoolArctic Air Conditioning Services', 'Elena V. Rodriguez', 'Suite 201, Frost Building, Commonwealth Ave, Quezon City, 1121 Metro Manila', 31667788998, 'service@coolarctic.com', 7, 'Offers 24/7 emergency repair services for data centers and cold storage facilities.', '2026-01-19', '');

-- --------------------------------------------------------

--
-- Table structure for table `projectdetails_table`
--

CREATE TABLE `projectdetails_table` (
  `ProjectDetails_ID` int(11) NOT NULL,
  `Project_ID` int(11) DEFAULT NULL,
  `ProjectDetails_Title` varchar(255) NOT NULL,
  `ProjectDetails_Description` varchar(255) NOT NULL,
  `ProjectDetails_Budget` double NOT NULL,
  `ProjectDetails_Street` varchar(255) NOT NULL,
  `ProjectDetails_Barangay` varchar(255) NOT NULL,
  `ProjectDetails_ZIP_Code` int(11) NOT NULL,
  `ProjectDetails_StartedDate` date DEFAULT NULL,
  `ProjectDetails_EndDate` date DEFAULT NULL,
  `ProjectDetails_CreatedAt` date NOT NULL DEFAULT current_timestamp(),
  `ProjectDetails_UpdatedAT` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projectdetails_table`
--

INSERT INTO `projectdetails_table` (`ProjectDetails_ID`, `Project_ID`, `ProjectDetails_Title`, `ProjectDetails_Description`, `ProjectDetails_Budget`, `ProjectDetails_Street`, `ProjectDetails_Barangay`, `ProjectDetails_ZIP_Code`, `ProjectDetails_StartedDate`, `ProjectDetails_EndDate`, `ProjectDetails_CreatedAt`, `ProjectDetails_UpdatedAT`) VALUES
(1, 18, 'Metro Manila Subway', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla p', 355000000000, 'Mindanao Avenue', 'Villa Florencia Subdivision', 1116, '2019-02-27', '2029-06-18', '2026-01-19', NULL),
(2, 19, 'MRT-7 (New Line)', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla p', 62007000000, 'Commonwealth Avenue', 'Holy Spirit', 1127, '2017-06-07', '2028-06-30', '2026-01-19', NULL),
(3, 20, 'MRT-7 North Avenue Common Station (Area Segment A)', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla p', 2008000000, 'North Avenue', 'Diliman', 1148, '2020-10-08', '2028-02-24', '2026-01-19', NULL),
(4, 21, 'Quezon City Elevated Promenade', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla p', 84004000, 'North Avenue', 'San Jose', 1100, '2026-01-19', '2027-06-17', '2026-01-19', NULL),
(5, 22, 'MRT Tandang Sora Station', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla p', 24000000, 'Commonwealth Avenue', 'Pook Palaris', 1101, '2024-06-13', '2025-07-23', '2026-01-19', NULL),
(6, 23, 'NLEX-C5 Segment 8.2 Construction', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla p', 2002000000, 'North Luzon Expressway', 'Libis Baesa/Reparo', 1401, '2024-06-20', '2025-11-20', '2026-01-19', NULL),
(7, 24, 'Ermitaño Creek Rehabilitation', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla p', 13500000, 'Commonwealth Avenue Cycleway', 'Diliman', 1128, '2025-11-20', '2026-02-05', '2026-01-19', NULL),
(8, 25, 'Commonwealth Detention Basin', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla p', 4000000000, 'Maliwanag Street', 'Diliman', 1101, '2024-02-19', '2025-06-17', '2026-01-19', NULL),
(9, 26, 'Aurora Blvd. Sidewalk & Lighting', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla p', 29900000, 'Aurora Boulevard', 'Cubao', 1111, '2024-06-20', '2025-06-18', '2026-01-19', NULL),
(10, 27, 'Novaliches Underground Detention Basin', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla p', 40000000, 'General Luis Street', 'Novaliches Proper', 1125, '2024-06-05', '2025-05-13', '2026-01-19', NULL),
(11, 28, 'La Mesa Water Treatment Plant 2 (Rehabilitation)', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla p', 56000000000, 'Mathew Street', 'Commonwealth', 1121, '2025-02-20', '2027-07-13', '2026-01-19', NULL),
(12, 29, 'QC E-Sports & Innovation Hub', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla p', 3000000, 'General Aguinaldo Avenue', 'Cubao', 1109, '2024-08-15', '2026-05-20', '2026-01-19', NULL),
(13, 30, 'PCMC New Building (Legacy Hospital Project)', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla p', 25600000000, 'Quezon Avenue', 'San Jose', 1100, '2024-06-17', '2025-11-20', '2026-01-20', NULL),
(14, 31, 'QC Biogas Plant (Waste-to-Energy)', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla p', 50000000, 'San Lucas Street', 'Payatas', 1119, '2026-01-20', '2026-02-05', '2026-01-20', NULL),
(15, 32, 'Harmony Hills Terraces (4PH Housing)', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet aliquam semper, mauris turpis luctus diam, et consectetur tortor diam in magna. Etiam sit amet nulla p', 250000000, 'Pangasinan Street', 'Batasan Hills', 1126, '2026-03-12', '2026-07-10', '2026-01-20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projectmilestone_table`
--

CREATE TABLE `projectmilestone_table` (
  `projectMilestone_PhotoID` int(11) NOT NULL,
  `Project_ID` int(11) NOT NULL,
  `projectMilestone_Image_Path` varchar(255) DEFAULT NULL,
  `projectMilestone_Phase` varchar(100) NOT NULL,
  `projectMilestone_CreatedAt` date NOT NULL DEFAULT current_timestamp(),
  `projectMilestone_UploadedAT` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projectmilestone_table`
--

INSERT INTO `projectmilestone_table` (`projectMilestone_PhotoID`, `Project_ID`, `projectMilestone_Image_Path`, `projectMilestone_Phase`, `projectMilestone_CreatedAt`, `projectMilestone_UploadedAT`) VALUES
(1, 18, '/QTrace-Website/uploads/projects/milestones/IMG_18_1768827638_0.jpg', 'site_progress', '2026-01-19', NULL),
(2, 19, '/QTrace-Website/uploads/projects/milestones/IMG_19_1768828273_0.jpg', 'site_progress', '2026-01-19', NULL),
(3, 20, '/QTrace-Website/uploads/projects/milestones/IMG_20_1768828738_0.jpg', 'site_progress', '2026-01-19', NULL),
(4, 21, '/QTrace-Website/uploads/projects/milestones/IMG_21_1768829549_0.jpg', 'after_photo', '2026-01-19', NULL),
(5, 22, '/QTrace-Website/uploads/projects/milestones/IMG_22_1768830607_0.jpg', 'site_progress', '2026-01-19', NULL),
(6, 23, '/QTrace-Website/uploads/projects/milestones/IMG_23_1768831366_0.png', 'site_progress', '2026-01-19', NULL),
(7, 24, '/QTrace-Website/uploads/projects/milestones/IMG_24_1768832481_0.jpg', 'inspection', '2026-01-19', NULL),
(8, 25, '/QTrace-Website/uploads/projects/milestones/IMG_25_1768832991_0.png', 'inspection', '2026-01-19', NULL),
(9, 26, '/QTrace-Website/uploads/projects/milestones/IMG_26_1768833657_0.png', 'after_photo', '2026-01-19', NULL),
(10, 27, '/QTrace-Website/uploads/projects/milestones/IMG_27_1768833928_0.jpg', 'inspection', '2026-01-19', NULL),
(11, 28, '/QTrace-Website/uploads/projects/milestones/IMG_28_1768837355_0.jpg', 'site_progress', '2026-01-19', NULL),
(12, 29, '/QTrace-Website/uploads/projects/milestones/IMG_29_1768838149_0.jpg', 'site_progress', '2026-01-19', NULL),
(13, 30, '/QTrace-Website/uploads/projects/milestones/IMG_30_1768838553_0.jpg', 'after_photo', '2026-01-20', NULL),
(14, 31, '/QTrace-Website/uploads/projects/milestones/IMG_31_1768838996_0.jpg', 'before_photo', '2026-01-20', NULL),
(15, 32, '/QTrace-Website/uploads/projects/milestones/IMG_32_1768839151_0.jpg', 'after_photo', '2026-01-20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projectsdocument_table`
--

CREATE TABLE `projectsdocument_table` (
  `ProjectDocument_ID` int(11) NOT NULL,
  `Project_ID` int(11) NOT NULL,
  `ProjectDocument_FileLocation` varchar(255) DEFAULT NULL,
  `ProjectDocument_Type` varchar(255) DEFAULT NULL,
  `ProjectDocument_UploadedAt` datetime DEFAULT current_timestamp(),
  `ProjectDocument_CreatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projectsdocument_table`
--

INSERT INTO `projectsdocument_table` (`ProjectDocument_ID`, `Project_ID`, `ProjectDocument_FileLocation`, `ProjectDocument_Type`, `ProjectDocument_UploadedAt`, `ProjectDocument_CreatedAt`) VALUES
(1, 18, '/QTrace-Website/uploads/projects/documents/DOC_18_1768827638_0.pdf', 'Building Permit', '2026-01-19 21:00:38', '2026-01-19 21:00:38'),
(2, 18, '/QTrace-Website/uploads/projects/documents/DOC_18_1768827638_1.pdf', 'Safety Permit', '2026-01-19 21:00:38', '2026-01-19 21:00:38'),
(3, 19, '/QTrace-Website/uploads/projects/documents/DOC_19_1768828273_0.pdf', 'Building Permit', '2026-01-19 21:11:13', '2026-01-19 21:11:13'),
(4, 19, '/QTrace-Website/uploads/projects/documents/DOC_19_1768828273_1.pdf', 'Project ', '2026-01-19 21:11:13', '2026-01-19 21:11:13'),
(5, 20, '/QTrace-Website/uploads/projects/documents/DOC_20_1768828738_0.pdf', 'Building Permit', '2026-01-19 21:18:58', '2026-01-19 21:18:58'),
(6, 20, '/QTrace-Website/uploads/projects/documents/DOC_20_1768828738_1.pdf', 'Project ', '2026-01-19 21:18:58', '2026-01-19 21:18:58'),
(7, 21, '/QTrace-Website/uploads/projects/documents/DOC_21_1768829549_0.pdf', 'Building Permit', '2026-01-19 21:32:29', '2026-01-19 21:32:29'),
(8, 21, '/QTrace-Website/uploads/projects/documents/DOC_21_1768829549_1.pdf', 'Project ', '2026-01-19 21:32:29', '2026-01-19 21:32:29'),
(9, 22, '/QTrace-Website/uploads/projects/documents/DOC_22_1768830607_0.pdf', 'Building Permit', '2026-01-19 21:50:07', '2026-01-19 21:50:07'),
(10, 22, '/QTrace-Website/uploads/projects/documents/DOC_22_1768830607_1.pdf', 'Project ', '2026-01-19 21:50:07', '2026-01-19 21:50:07'),
(11, 23, '/QTrace-Website/uploads/projects/documents/DOC_23_1768831366_0.pdf', 'Building Permit', '2026-01-19 22:02:46', '2026-01-19 22:02:46'),
(12, 23, '/QTrace-Website/uploads/projects/documents/DOC_23_1768831366_1.pdf', 'Project Description', '2026-01-19 22:02:46', '2026-01-19 22:02:46'),
(13, 23, '/QTrace-Website/uploads/projects/documents/DOC_23_1768831366_2.pdf', 'Safety Permit', '2026-01-19 22:02:46', '2026-01-19 22:02:46'),
(14, 24, '/QTrace-Website/uploads/projects/documents/DOC_24_1768832481_0.pdf', 'Building Permit', '2026-01-19 22:21:21', '2026-01-19 22:21:21'),
(15, 24, '/QTrace-Website/uploads/projects/documents/DOC_24_1768832481_1.pdf', 'Project Permit', '2026-01-19 22:21:21', '2026-01-19 22:21:21'),
(16, 25, '/QTrace-Website/uploads/projects/documents/DOC_25_1768832991_0.pdf', 'Detention Basin', '2026-01-19 22:29:51', '2026-01-19 22:29:51'),
(17, 25, '/QTrace-Website/uploads/projects/documents/DOC_25_1768832991_1.pdf', 'Project Permit', '2026-01-19 22:29:51', '2026-01-19 22:29:51'),
(18, 26, '/QTrace-Website/uploads/projects/documents/DOC_26_1768833657_0.pdf', 'Building Permit', '2026-01-19 22:40:57', '2026-01-19 22:40:57'),
(19, 26, '/QTrace-Website/uploads/projects/documents/DOC_26_1768833657_1.pdf', 'Contractors Contract', '2026-01-19 22:40:57', '2026-01-19 22:40:57'),
(20, 27, '/QTrace-Website/uploads/projects/documents/DOC_27_1768833928_0.pdf', 'Building Permit', '2026-01-19 22:45:28', '2026-01-19 22:45:28'),
(21, 27, '/QTrace-Website/uploads/projects/documents/DOC_27_1768833928_1.pdf', 'Flood Control Project', '2026-01-19 22:45:28', '2026-01-19 22:45:28'),
(22, 28, '/QTrace-Website/uploads/projects/documents/DOC_28_1768837355_0.pdf', 'Building Permit', '2026-01-19 23:42:35', '2026-01-19 23:42:35'),
(23, 28, '/QTrace-Website/uploads/projects/documents/DOC_28_1768837355_1.pdf', 'Contract', '2026-01-19 23:42:35', '2026-01-19 23:42:35'),
(24, 29, '/QTrace-Website/uploads/projects/documents/DOC_29_1768838149_0.pdf', 'Building Permit', '2026-01-19 23:55:49', '2026-01-19 23:55:49'),
(25, 29, '/QTrace-Website/uploads/projects/documents/DOC_29_1768838149_1.pdf', 'Project Permit', '2026-01-19 23:55:49', '2026-01-19 23:55:49'),
(26, 30, '/QTrace-Website/uploads/projects/documents/DOC_30_1768838553_0.pdf', 'Project Permit', '2026-01-20 00:02:33', '2026-01-20 00:02:33'),
(27, 30, '/QTrace-Website/uploads/projects/documents/DOC_30_1768838553_1.pdf', 'Building Permit', '2026-01-20 00:02:33', '2026-01-20 00:02:33'),
(28, 31, '/QTrace-Website/uploads/projects/documents/DOC_31_1768838996_0.pdf', 'Building Permit', '2026-01-20 00:09:56', '2026-01-20 00:09:56'),
(29, 31, '/QTrace-Website/uploads/projects/documents/DOC_31_1768838996_1.pdf', 'Project Permit', '2026-01-20 00:09:56', '2026-01-20 00:09:56'),
(30, 32, '/QTrace-Website/uploads/projects/documents/DOC_32_1768839151_0.pdf', 'Building Permit', '2026-01-20 00:12:31', '2026-01-20 00:12:31'),
(31, 32, '/QTrace-Website/uploads/projects/documents/DOC_32_1768839151_1.pdf', 'Project Permit', '2026-01-20 00:12:31', '2026-01-20 00:12:31');

-- --------------------------------------------------------

--
-- Table structure for table `projects_table`
--

CREATE TABLE `projects_table` (
  `Project_ID` int(11) NOT NULL,
  `Contractor_ID` int(11) NOT NULL,
  `Project_Status` varchar(50) NOT NULL,
  `Project_Category` varchar(50) NOT NULL,
  `Project_Lng` decimal(20,8) NOT NULL,
  `Project_Lat` decimal(20,8) NOT NULL,
  `Project_CreatedAt` date DEFAULT curdate(),
  `Project_UpdatedAT` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects_table`
--

INSERT INTO `projects_table` (`Project_ID`, `Contractor_ID`, `Project_Status`, `Project_Category`, `Project_Lng`, `Project_Lat`, `Project_CreatedAt`, `Project_UpdatedAT`) VALUES
(18, 11, 'Ongoing', 'Infrastructure', 121.02875900, 14.68942700, '2026-01-19', NULL),
(19, 18, 'Ongoing', 'Infrastructure', 121.08276800, 14.67720700, '2026-01-19', NULL),
(20, 10, 'Ongoing', 'Infrastructure', 121.03341600, 14.65490800, '2026-01-19', NULL),
(21, 17, 'Planning', 'Environmental', 121.04498100, 14.65223400, '2026-01-19', NULL),
(22, 12, 'Delayed', 'Infrastructure', 121.06719000, 14.66320300, '2026-01-19', NULL),
(23, 15, 'Completed', 'Environmental', 121.00118600, 14.67956100, '2026-01-19', NULL),
(24, 16, 'Ongoing', 'Environmental', 121.05255600, 14.65387400, '2026-01-19', NULL),
(25, 19, 'Completed', 'Environmental', 121.05556000, 14.65262900, '2026-01-19', NULL),
(26, 13, 'Delayed', 'Infrastructure', 121.04953100, 14.62130000, '2026-01-19', NULL),
(27, 14, 'Completed', 'Environmental', 121.03800800, 14.72168600, '2026-01-19', NULL),
(28, 24, 'Ongoing', 'Environmental', 121.08427000, 14.71551600, '2026-01-19', NULL),
(29, 26, 'Ongoing', 'Social Services', 121.05423000, 14.62074300, '2026-01-19', NULL),
(30, 20, 'Delayed', 'Infrastructure', 121.04160700, 14.64758300, '2026-01-20', NULL),
(31, 14, 'Planning', 'Safety', 121.09654400, 14.70585400, '2026-01-20', NULL),
(32, 22, 'Planning', 'Social Services', 121.09225300, 14.68628600, '2026-01-20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_categories`
--

CREATE TABLE `project_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL
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
  `QC_ID_Number` varchar(20) DEFAULT NULL,
  `user_lastName` varchar(50) NOT NULL,
  `user_firstName` varchar(50) NOT NULL,
  `user_middleName` varchar(20) DEFAULT NULL,
  `user_Email` varchar(20) NOT NULL,
  `user_Password` varchar(255) NOT NULL,
  `user_Role` enum('citizen','admin') NOT NULL,
  `user_birthDate` date NOT NULL,
  `user_sex` enum('female','male','other') NOT NULL,
  `user_contactInformation` bigint(20) NOT NULL,
  `user_address` varchar(100) NOT NULL,
  `user_status` varchar(50) NOT NULL,
  `created_At` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_ID`, `QC_ID_Number`, `user_lastName`, `user_firstName`, `user_middleName`, `user_Email`, `user_Password`, `user_Role`, `user_birthDate`, `user_sex`, `user_contactInformation`, `user_address`, `user_status`, `created_At`) VALUES
(6, '74373497704', 'Manongdo', 'Gerald', 'Pavillon', 'ipoglang@gmail.com', '$2y$10$ABJV3LTejJGIWKXjcUeS2eUr5/C6P0GzzkCkHWT15Vgyc7y7ThXJe', 'admin', '2005-09-12', 'other', 9562184010, 'blk 51 lt 49 noche buena st. ', 'active', '2026-01-11'),
(7, '97192855754', 'Tan', 'Kurt', 'Clet', 'KurtTan@gmail.com', '$2y$10$5x4VPncdSUs9Wg81LIVcbOlcXAsnik7C7ESH5OiSbyyr1UREM56EG', 'citizen', '2006-03-10', 'female', 43243432, '123', 'inactive', '2026-01-11'),
(8, '13285297641', 'Tarun', 'Dos', 'Hambala', 'unotarun@gmail.com', '$2y$10$EvF/NUVDM/.bTMFqifk7XOIKxLQgIsoTCXXu638sJianBQBIcy3hS', 'admin', '2006-08-31', 'male', 817398719824, '78c atherton st.', 'active', '2026-01-18'),
(9, '97516143278', 'Deguzman', 'Alexander', '', 'Alex@gmail.com', '$2y$10$ywLmsIXJnAuNf3JGK5FsFuZ0nKh352Ys9RG0x6trvnKgUDxOw4JCK', 'admin', '2005-11-04', 'male', 84579432, 'blk 51 lt 49 noche buena st. ', 'active', '2026-01-18'),
(11, '61558680511', 'Berango', 'Joemari', 'P.', 'j.berango@gmail.com', '$2y$10$pJcItWdROSFF4PlSrLqi/eu9BDtNU4m4M5KYn3kRHjkGXr.TYFiW6', 'admin', '2001-12-22', 'male', 5345375109, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravid', 'active', '2026-01-20'),
(12, '78195285403', 'Pua', 'Mikhale', 'C.', 'r.pua@gmail.com', '$2y$10$06lZi09W21ks53wbJ5coD.0muqkZGWtonbWbZ81LrAJELReUQaLSy', 'citizen', '2005-10-02', 'female', 9932341581, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravid', 'active', '2026-01-20'),
(13, '40881637885', 'Doe', 'John', 'L.', 'j.doe@gmail.com', '$2y$10$Nyt0x7UrImaDO17iBJ8VV.5fpegTvCCGr4D1iSl5kKQkc3aSwBvm2', 'citizen', '1995-02-14', 'male', 1237234761, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravid', 'active', '2026-01-20'),
(14, '86180871186', 'Mendoza', 'Prince', 'H.', 'p.mendoza@gmail.com', '$2y$10$LyDd2jZqz.9hCFl.D4Y0juWuK5LE8oOZBTQNZEOlYqdO8OT.2ncua', 'citizen', '2005-11-12', 'male', 1445611221, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravid', 'active', '2026-01-20'),
(15, '46688937833', 'Lozada', 'Juan', 'S.', 'j.lozada@gmail.com', '$2y$10$qxuHkIdqFQ/.3a7/Gs.Qi.gpU6ALoywqLPx/ccZdZ0t/31VRxOyEK', 'citizen', '1997-06-18', 'male', 2345121234, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ', 'active', '2026-01-20'),
(16, '21180117990', 'Montifalco', 'Alex', 'G.', 'a.montifalco@gmail.c', '$2y$10$tu5uIE/IIeeEx6oqB/pwgusmhtZeNSri.UzRkebU1O5oPKqW2hb4m', 'citizen', '2005-08-15', 'male', 3453612321, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante', 'active', '2026-01-20'),
(17, '33094395895', 'Vance', 'Julianne', 'F.', 'j.vance@gmail.com', '$2y$10$5ikescmTbPXa7yyk8zeeEe2LzBGd0FQzkT7voX4lnnBIrPVWbCwt2', 'citizen', '1999-01-05', 'female', 5028419376, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante', 'active', '2026-01-20'),
(18, '80100760397', 'Thorne', 'Dominic', 'G.', 'd.thorne@gmail.com', '$2y$10$2IMXI/WZDMgdpVYIMRrHheHv/gBmIMj4QFKMZ.u5hosD6ghqqQnFu', 'citizen', '1989-06-19', 'male', 1930527748, ' Pellentesque faucibus est ante, quis gravida ligula pharetra sed. Proin dapibus, massa sit amet ali', 'active', '2026-01-20'),
(19, '18342082231', 'Sterling', 'Elara', 'Q.', 'e.sterling@gmail.com', '$2y$10$HA.iayGl8A38qXGoJ17zAOE6DOy1eliC4uEQzaKk6tPpPLeP7YXeC', 'citizen', '1971-05-11', 'female', 8271640593, 'gravida, ipsum ac sollicitudin hendrerit, mauris mauris feugiat justo, et pulvinar nunc quam vitae e', 'active', '2026-01-20'),
(20, '51588060498', 'Montgomery', 'Kellan', 'B.', 'k.montgomery@gmail.c', '$2y$10$ugYmY7Ua4SWaB/iX.SqiMeA7Dp75N3U5g0pCLHJpEqkg41mbHa7Cq', 'citizen', '1994-10-13', 'male', 5028419376, 'Fusce eget lectus diam. Suspendisse varius sem arcu, eu sagittis mauris blandit vitae.', 'active', '2026-01-20'),
(21, '53249342920', 'Rhodes', 'Sienna', 'L.', 's.rhodes@gmail.com', '$2y$10$qVi.IJTqky/p/oJ1knfakuYkkDNpWU0h4VCDVXFZ75H5A5sldArMW', 'citizen', '1998-10-29', 'female', 4039174700, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus est ante, quis gravid', 'active', '2026-01-20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles_table`
--
ALTER TABLE `articles_table`
  ADD PRIMARY KEY (`article_ID`),
  ADD KEY `user_ID` (`user_ID`),
  ADD KEY `idx_project` (`Project_ID`),
  ADD KEY `idx_status` (`article_status`),
  ADD KEY `idx_created` (`article_created_at`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`audit_log_id`);

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
-- Indexes for table `projectdetails_table`
--
ALTER TABLE `projectdetails_table`
  ADD PRIMARY KEY (`ProjectDetails_ID`);

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
-- Indexes for table `project_categories`
--
ALTER TABLE `project_categories`
  ADD PRIMARY KEY (`category_id`);

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
-- AUTO_INCREMENT for table `articles_table`
--
ALTER TABLE `articles_table`
  MODIFY `article_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contractor_documents_table`
--
ALTER TABLE `contractor_documents_table`
  MODIFY `Contractor_Documents_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `contractor_expertise_table`
--
ALTER TABLE `contractor_expertise_table`
  MODIFY `Contractor_Expertise_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `contractor_table`
--
ALTER TABLE `contractor_table`
  MODIFY `Contractor_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `projectdetails_table`
--
ALTER TABLE `projectdetails_table`
  MODIFY `ProjectDetails_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `projectmilestone_table`
--
ALTER TABLE `projectmilestone_table`
  MODIFY `projectMilestone_PhotoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `projectsdocument_table`
--
ALTER TABLE `projectsdocument_table`
  MODIFY `ProjectDocument_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `projects_table`
--
ALTER TABLE `projects_table`
  MODIFY `Project_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `project_categories`
--
ALTER TABLE `project_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_table`
--
ALTER TABLE `report_table`
  MODIFY `report_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles_table`
--
ALTER TABLE `articles_table`
  ADD CONSTRAINT `articles_table_ibfk_1` FOREIGN KEY (`Project_ID`) REFERENCES `projects_table` (`Project_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `articles_table_ibfk_2` FOREIGN KEY (`user_ID`) REFERENCES `user_table` (`user_ID`) ON DELETE SET NULL;

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
