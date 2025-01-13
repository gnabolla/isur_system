-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2025 at 01:48 PM
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
-- Database: `isur_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `curriculum`
--

CREATE TABLE `curriculum` (
  `id` int(11) NOT NULL,
  `program_id` int(11) DEFAULT NULL,
  `version_label` varchar(100) NOT NULL,
  `effectivity_sy` varchar(50) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `curriculum`
--

INSERT INTO `curriculum` (`id`, `program_id`, `version_label`, `effectivity_sy`, `notes`, `created_at`, `updated_at`) VALUES
(1, NULL, '2024 Revision', '2024-2025', 'Updated curriculum for CS', '2025-01-04 06:59:25', '2025-01-04 06:59:25'),
(2, NULL, '2024 Revision', '2024-2025', 'Updated curriculum for IT', '2025-01-04 06:59:25', '2025-01-04 06:59:25'),
(3, NULL, '2024 Revision', '2024-2025', 'Updated curriculum for SE', '2025-01-04 06:59:25', '2025-01-04 06:59:25');

-- --------------------------------------------------------

--
-- Table structure for table `curriculum_subjects`
--

CREATE TABLE `curriculum_subjects` (
  `id` int(11) NOT NULL,
  `curriculum_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `year_level` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `is_lab` tinyint(1) DEFAULT 0,
  `prerequisites` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'IICT', 'Institute of Information and Communication Technology', '2025-01-04 14:07:16', '2025-01-04 14:07:16'),
(2, 'SAA', 'School of Agriculture and Agribusiness', '2025-01-04 15:00:27', '2025-01-04 15:00:27');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `grade` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `department_id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `prefix` varchar(50) DEFAULT NULL,
  `suffix` varchar(50) DEFAULT NULL,
  `position_rank` varchar(100) DEFAULT NULL,
  `employment_status` varchar(50) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `id_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`id`, `user_id`, `department_id`, `firstname`, `middlename`, `lastname`, `created_at`, `updated_at`, `prefix`, `suffix`, `position_rank`, `employment_status`, `birthdate`, `email`, `id_number`) VALUES
(20, 10, 1, 'MA. VALEN', 'DAMMAY', 'ALZATE', '2025-01-05 18:47:44', '2025-01-05 18:55:12', 'DR.', 'PhD/DIT', 'ASSOCIATE PROFESSOR II', 'PERMANENT', '1973-02-14', 'mavalendammay613@gmail.com', 'MVD021473'),
(21, 11, 1, 'CARLO', 'VIDAL', 'BALTAZAR', '2025-01-05 18:47:44', '2025-01-05 18:55:12', 'MR.', 'MIT', 'INSTRUCTOR II', 'PERMANENT', '1992-09-29', 'carlo.v.baltazar@isu.edu.ph', 'CVB029292'),
(22, 12, 1, 'MARY JANE', 'CAGAYAN', 'BANIQUED', '2025-01-05 18:47:44', '2025-01-05 18:55:12', 'MS.', 'M\'Eng/MIT', 'ASSISTANT PROFESSOR IV', 'PERMANENT', '1979-06-21', 'maryjane.baniqued@gmail.com', 'MCB062179'),
(23, 13, 1, 'AUDELON', 'RAMISCAL', 'BENITO', '2025-01-05 18:47:44', '2025-01-05 18:55:12', 'MR.', 'DIT', 'ASSISTANT PROFESSOR IV', 'PERMANENT', '1988-10-04', 'audelon.r.benito@isu.edu.ph', 'ARB100488'),
(24, 14, 1, 'CERENO', 'CACAL', 'CERENO', '2025-01-05 18:47:44', '2025-01-05 18:55:12', 'MR.', 'MSIT', 'ASSISTANT PROFESSOR II', 'PERMANENT', '1982-09-05', 'joey.c.cereno@isu.edu.ph', 'JCC090582'),
(25, 15, 1, 'CUNANAN', 'PASCUA', 'CUNANAN', '2025-01-05 18:47:44', '2025-01-05 18:55:12', 'MRS.', 'PhD', 'ASSOCIATE PROFESSOR III', 'PERMANENT', '1978-06-22', 'janetcunanan242@gmail.com', 'JPC062278'),
(26, 16, 1, 'JAY', 'LAU REL', 'FLORENTIN', '2025-01-05 18:47:44', '2025-01-05 18:55:12', 'MR.', 'MIT', 'INSTRUCTOR III', 'PERMANENT', '1988-01-28', 'ghielaurel28@gmail.com', 'VBPD122992'),
(27, 17, 1, 'DOMINGO', 'MANUEL', 'RAMOS', '2025-01-05 18:47:44', '2025-01-05 18:55:12', 'MR.', 'DIT', 'ASSOCIATE PROFESSOR II', 'PERMANENT', '1975-01-13', 'domingo.m.ramos@isu.edu.ph', 'JTG090983'),
(28, 18, 1, 'VIC BERRY', 'PALOMAR', 'DUQUE', '2025-01-05 18:47:44', '2025-01-05 18:55:12', 'MR.', NULL, 'INSTRUCTOR I', 'COS', '1992-12-29', 'striffe0970@gmail.com', 'JEL012888'),
(29, 19, 1, 'JAYSON', 'TELAN', 'GUILLERMO', '2025-01-05 18:47:44', '2025-01-05 18:55:12', 'MR.', NULL, 'INSTRUCTOR I', 'COS', '1983-09-09', 'jayson.t.guillermo@isu.edu.ph', 'YRM041297'),
(30, 20, 1, 'YOSEV', 'RAMEL', 'MARTE', '2025-01-05 18:47:44', '2025-01-05 18:55:12', 'MR.', NULL, 'INSTRUCTOR I', 'COS', '1997-04-12', 'yumptisolle@gmail.com', 'JBN051881'),
(31, 21, 1, 'JUNESTHER', 'BULAN', 'NATIVIDAD', '2025-01-05 18:47:44', '2025-01-05 18:55:12', 'MR.', NULL, 'INSTRUCTOR I', 'COS', '1981-05-18', 'njunesther@gmail.com', 'MVQ071991'),
(32, 22, 1, 'MAC JOHN', 'IVERNS', 'QUIMING', '2025-01-05 18:47:44', '2025-01-05 18:55:12', 'MR.', NULL, 'INSTRUCTOR I', 'COS', '1991-07-19', 'macjohnq19@gmail.com', 'DMR013175'),
(33, 23, 1, 'JOEMAR', 'CASER', 'TISADO', '2025-01-05 18:47:44', '2025-01-05 18:55:12', 'MR.', NULL, 'INSTRUCTOR I', 'COS', '1990-03-30', 'joem033090@gmail.com', 'JCT033090');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_subjects`
--

CREATE TABLE `faculty_subjects` (
  `id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `school_year_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `department_id`, `name`, `code`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'BSIT', 'BSIT', 'Bachelor of Science in Information Technology', '2025-01-04 14:08:51', '2025-01-04 15:01:06'),
(2, 2, 'BSA', '', 'Bachelor of Science in Agriculture', '2025-01-04 15:00:43', '2025-01-04 15:00:43');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `room_type` enum('LAB','LECTURE') NOT NULL,
  `capacity` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `room_type`, `capacity`, `created_at`, `updated_at`) VALUES
(1, 'D2', 'LECTURE', 50, '2025-01-06 06:39:14', '2025-01-06 06:39:14'),
(2, 'D3', 'LECTURE', 50, '2025-01-06 06:39:14', '2025-01-06 06:39:14'),
(3, 'D4', 'LECTURE', 50, '2025-01-06 06:39:14', '2025-01-06 06:39:14'),
(4, 'D5', 'LECTURE', 50, '2025-01-06 06:39:14', '2025-01-06 06:39:14'),
(5, 'CLF', 'LECTURE', 50, '2025-01-06 06:39:14', '2025-01-06 06:39:14'),
(6, 'CLA', 'LAB', 50, '2025-01-06 06:39:14', '2025-01-06 06:39:14'),
(7, 'CLB', 'LAB', 50, '2025-01-06 06:39:14', '2025-01-06 06:39:14'),
(8, 'CLC', 'LAB', 50, '2025-01-06 06:39:14', '2025-01-06 06:39:14'),
(9, 'CLD', 'LAB', 50, '2025-01-06 06:39:14', '2025-01-06 06:39:14'),
(10, 'CLE', 'LAB', 50, '2025-01-06 06:39:14', '2025-01-06 06:39:14');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `school_year_id` int(11) NOT NULL,
  `day` enum('Mon','Tue','Wed','Thu','Fri') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `class_type` enum('lecture','lab') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `faculty_id`, `subject_id`, `section_id`, `room_id`, `semester_id`, `program_id`, `department_id`, `school_year_id`, `day`, `start_time`, `end_time`, `class_type`, `created_at`, `updated_at`) VALUES
(3, 21, 14, 1, 7, 2, 1, 2, 1, 'Mon', '07:30:00', '10:30:00', 'lecture', '2025-01-13 11:51:00', '2025-01-13 11:51:00');

-- --------------------------------------------------------

--
-- Table structure for table `school_years`
--

CREATE TABLE `school_years` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_years`
--

INSERT INTO `school_years` (`id`, `name`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, '2024-2025', '2024-08-01', '2025-05-31', '2025-01-04 06:59:25', '2025-01-04 06:59:25'),
(2, '2025-2026', '2025-08-01', '2026-05-31', '2025-01-04 06:59:25', '2025-01-04 06:59:25'),
(3, '2026-2027', '2026-08-01', '2027-05-31', '2025-01-04 06:59:25', '2025-01-04 06:59:25');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `year_level` int(11) NOT NULL,
  `section` varchar(10) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `curriculum_id` int(11) NOT NULL,
  `archived` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `program_id`, `year_level`, `section`, `semester_id`, `curriculum_id`, `archived`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'BSIT 1A', 1, 2, 0, '2025-01-06 06:31:31', '2025-01-06 06:31:31'),
(2, 1, 1, 'BSIT 1B', 1, 2, 0, '2025-01-06 06:31:31', '2025-01-06 06:31:31'),
(3, 1, 1, 'BSIT 1C', 1, 2, 0, '2025-01-06 06:31:31', '2025-01-06 06:31:31'),
(4, 1, 1, 'BSIT 1D', 1, 2, 0, '2025-01-06 06:31:31', '2025-01-06 06:31:31'),
(5, 1, 1, 'BSIT 1E', 1, 2, 0, '2025-01-06 06:31:31', '2025-01-06 06:31:31'),
(6, 1, 2, 'BSIT 2AWM', 1, 2, 0, '2025-01-06 06:31:31', '2025-01-06 06:31:31'),
(7, 1, 2, 'BSIT 2BWM', 1, 2, 0, '2025-01-06 06:31:31', '2025-01-06 06:31:31'),
(8, 1, 2, 'BSIT 2ANS', 1, 2, 0, '2025-01-06 06:31:31', '2025-01-06 06:31:31'),
(9, 1, 3, 'BSIT 3AWM', 1, 2, 0, '2025-01-06 06:31:31', '2025-01-06 06:31:31'),
(10, 1, 3, 'BSIT 3BWM', 1, 2, 0, '2025-01-06 06:31:31', '2025-01-06 06:31:31'),
(11, 1, 3, 'BSIT 3CWM', 1, 2, 0, '2025-01-06 06:31:31', '2025-01-06 06:31:31'),
(12, 1, 3, 'BSIT 3ANS', 1, 2, 0, '2025-01-06 06:31:31', '2025-01-06 06:31:31'),
(13, 1, 4, 'BSIT 4AWM', 1, 2, 0, '2025-01-06 06:31:31', '2025-01-06 06:31:31'),
(14, 1, 4, 'BSIT 4BWM', 1, 2, 0, '2025-01-06 06:31:31', '2025-01-06 06:31:31'),
(15, 1, 4, 'BSIT 4ANS', 1, 2, 0, '2025-01-06 06:31:31', '2025-01-06 06:31:31'),
(16, 1, 4, 'BSIT 4BNS', 1, 2, 0, '2025-01-06 06:31:31', '2025-01-06 06:31:31');

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `id` int(11) NOT NULL,
  `sy_id` int(11) NOT NULL,
  `semester_no` int(11) NOT NULL,
  `label` varchar(50) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semesters`
--

INSERT INTO `semesters` (`id`, `sy_id`, `semester_no`, `label`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'First Semester', '2024-08-01', '2024-12-15', '2025-01-04 06:59:25', '2025-01-04 06:59:25'),
(2, 1, 2, 'Second Semester', '2025-01-10', '2025-05-31', '2025-01-04 06:59:25', '2025-01-04 06:59:25');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) NOT NULL,
  `program_id` int(11) NOT NULL,
  `year_level` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `curriculum_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `program_id` int(11) DEFAULT NULL,
  `units` decimal(4,1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `code`, `description`, `department_id`, `program_id`, `units`, `created_at`, `updated_at`) VALUES
(1, 'GEC 4', 'Purposive Communication', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(2, 'GEC 5', 'Art Appreciation', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(3, 'IT Inst 1', 'Climate Change and Disaster Risk Management', 1, 1, 2.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(4, 'IT GE Elect 1', 'Health and Wellness World', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(5, 'IT GE Elect 2', 'Foreign Language 1', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(6, 'IT 111', 'Introduction to Computing', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(7, 'IT 112', 'Computer Programming 1', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(8, 'PE 1', 'Physical Activity Towards Health Fitness I (Movement Patterns)', 1, 1, 2.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(9, 'NSTP 1', 'National Service Training Program 1', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(10, 'GEC 1', 'Understanding the Self', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(11, 'GEC 2', 'Reading in Philippine History', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(12, 'GEC 3', 'Mathematics in the Modern World', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(13, 'GEC 7', 'Ethics', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(14, 'IT 121', 'Computer Programming 2', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(15, 'IT 122', 'Human Computer Interaction 1', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(16, 'IT 123', 'Discrete Mathematics', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(17, 'PE 2', 'Physical Activity Towards Health Fitness II (Exercise Program)', 1, 1, 2.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(18, 'NSTP 2', 'National Service Training Program 2', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(19, 'GEC 6', 'Science, Technology & Society', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(20, 'GEC 8', 'The Contemporary World', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(21, 'IT Inst 2', 'Creative and Critical Thinking', 1, 1, 2.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(22, 'IT GE Elect 3', 'Foreign Language 2', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(23, 'IT 211', 'Data Structures and Algorithm', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(24, 'IT ELEC 1', 'Platform Technologies', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(25, 'IT ELEC 2', 'Object-Oriented Programming', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(26, 'IT BPO 1', 'Business Communication', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(27, 'PE 3', 'Physical Activity Towards Health Fitness 3 (Dance/Sports/etc.)', 1, 1, 2.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(28, 'IT GE ELEC 4', 'The Entrepreneurial Mind', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(29, 'GEC 9', 'The Life and Works of Rizal', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(30, 'IT 221', 'Information Management', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(31, 'IT 222', 'Networking 1', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(32, 'IT 223', 'Quantitative Methods (including Modeling & Simulation)', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(33, 'IT 224', 'Integrative Programming and Technologies', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(34, 'IT 225', 'Accounting for Information Technology', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(35, 'IT APPDEV 1', 'Fundamentals of Mobile Technology', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(36, 'PE 4', 'Physical Activity Towards Health Fitness 3 (Dance/Sports/etc.)', 1, 1, 2.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(37, 'IT 226', 'Applications Development & Emerging Technologies', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(38, 'IT ELEC 3', 'Web Systems and Technologies', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(39, 'IT Inst 3', 'Data Science and Analytics', 1, 1, 2.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(40, 'IT 311', 'Advanced Database Systems', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(41, 'IT 312', 'Networking 2', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(42, 'IT 313', 'System Integration and Architecture', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(43, 'IT 314', 'Information Assurance and Security 1', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(44, 'IT APPDEV 2', 'Web Applications', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(45, 'IT APPDEV 3', 'Mobile Applications', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(46, 'IT GE ELEC 5', 'Multicultural Education', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(47, 'IT 321', 'Information Assurance and Security 2', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(48, 'IT 322', 'Social and Professional Issues', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(49, 'IT 323', 'Capstone Project and Research 1', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(50, 'IT APPDEV 4', 'Game Development', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(51, 'IT APPDEV 5', 'Cloud Computing', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(52, 'IT GE ELEC 6', 'Leadership and Management in the Profession', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(53, 'IT 411', 'Systems Administration and Maintenance', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(54, 'IT ELEC 4', 'Human Computer Interaction 2', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(55, 'IT 412', 'Capstone Project and Research 2', 1, 1, 3.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39'),
(56, 'IT 421', 'Internship/ojt/ Practicum (486 hours)', 1, 1, 9.0, '2025-01-06 07:20:39', '2025-01-06 07:20:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` enum('faculty','student','admin','registrar') NOT NULL DEFAULT 'faculty',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('pending','active','rejected') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `created_at`, `updated_at`, `status`) VALUES
(1, 'admin', '$2y$10$mg0gQmt1uVYxdyJYEDV3xuIWaQMHA9yWXZmH/uR7vlcsKY3GT8fey', NULL, 'admin', '2025-01-04 01:34:27', '2025-01-04 01:34:27', 'active'),
(10, 'MVD021473', '$2y$10$aXtrtozRo1frIBD125xJsOdkPiuP7GXxYfWCCwXfhlAcGnMd2Znp.', 'mavalendammay613@gmail.com', 'faculty', '2025-01-05 18:55:12', '2025-01-05 18:55:12', 'active'),
(11, 'CVB029292', '$2y$10$yTh0ZzGwzgkrni2fHLG7IuqsDHb5CM3rV62CENcNn.915PGvbt01O', 'carlo.v.baltazar@isu.edu.ph', 'faculty', '2025-01-05 18:55:12', '2025-01-05 19:25:24', 'active'),
(12, 'MCB062179', '$2y$10$aXtrtozRo1frIBD125xJsOdkPiuP7GXxYfWCCwXfhlAcGnMd2Znp.', 'maryjane.baniqued@gmail.com', 'faculty', '2025-01-05 18:55:12', '2025-01-05 18:55:12', 'active'),
(13, 'ARB100488', '$2y$10$aXtrtozRo1frIBD125xJsOdkPiuP7GXxYfWCCwXfhlAcGnMd2Znp.', 'audelon.r.benito@isu.edu.ph', 'faculty', '2025-01-05 18:55:12', '2025-01-05 18:55:12', 'active'),
(14, 'JCC090582', '$2y$10$aXtrtozRo1frIBD125xJsOdkPiuP7GXxYfWCCwXfhlAcGnMd2Znp.', 'joey.c.cereno@isu.edu.ph', 'faculty', '2025-01-05 18:55:12', '2025-01-05 18:55:12', 'active'),
(15, 'JPC062278', '$2y$10$aXtrtozRo1frIBD125xJsOdkPiuP7GXxYfWCCwXfhlAcGnMd2Znp.', 'janetcunanan242@gmail.com', 'faculty', '2025-01-05 18:55:12', '2025-01-05 18:55:12', 'active'),
(16, 'VBPD122992', '$2y$10$aXtrtozRo1frIBD125xJsOdkPiuP7GXxYfWCCwXfhlAcGnMd2Znp.', 'ghielaurel28@gmail.com', 'faculty', '2025-01-05 18:55:12', '2025-01-05 18:55:12', 'active'),
(17, 'JTG090983', '$2y$10$aXtrtozRo1frIBD125xJsOdkPiuP7GXxYfWCCwXfhlAcGnMd2Znp.', 'domingo.m.ramos@isu.edu.ph', 'faculty', '2025-01-05 18:55:12', '2025-01-05 18:55:12', 'active'),
(18, 'JEL012888', '$2y$10$aXtrtozRo1frIBD125xJsOdkPiuP7GXxYfWCCwXfhlAcGnMd2Znp.', 'striffe0970@gmail.com', 'faculty', '2025-01-05 18:55:12', '2025-01-05 18:55:12', 'active'),
(19, 'YRM041297', '$2y$10$aXtrtozRo1frIBD125xJsOdkPiuP7GXxYfWCCwXfhlAcGnMd2Znp.', 'jayson.t.guillermo@isu.edu.ph', 'faculty', '2025-01-05 18:55:12', '2025-01-05 18:55:12', 'active'),
(20, 'JBN051881', '$2y$10$aXtrtozRo1frIBD125xJsOdkPiuP7GXxYfWCCwXfhlAcGnMd2Znp.', 'yumptisolle@gmail.com', 'faculty', '2025-01-05 18:55:12', '2025-01-05 18:55:12', 'active'),
(21, 'MVQ071991', '$2y$10$aXtrtozRo1frIBD125xJsOdkPiuP7GXxYfWCCwXfhlAcGnMd2Znp.', 'njunesther@gmail.com', 'faculty', '2025-01-05 18:55:12', '2025-01-05 18:55:12', 'active'),
(22, 'DMR013175', '$2y$10$aXtrtozRo1frIBD125xJsOdkPiuP7GXxYfWCCwXfhlAcGnMd2Znp.', 'macjohnq19@gmail.com', 'faculty', '2025-01-05 18:55:12', '2025-01-05 18:55:12', 'active'),
(23, 'JCT033090', '$2y$10$aXtrtozRo1frIBD125xJsOdkPiuP7GXxYfWCCwXfhlAcGnMd2Znp.', 'joem033090@gmail.com', 'faculty', '2025-01-05 18:55:12', '2025-01-05 18:55:12', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `curriculum`
--
ALTER TABLE `curriculum`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_curriculum_program` (`program_id`);

--
-- Indexes for table `curriculum_subjects`
--
ALTER TABLE `curriculum_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curriculum_id` (`curriculum_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `semester_id` (`semester_id`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculties_user_id_fk` (`user_id`),
  ADD KEY `fk_faculties_department` (`department_id`);

--
-- Indexes for table `faculty_subjects`
--
ALTER TABLE `faculty_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fs_faculty` (`faculty_id`),
  ADD KEY `fk_fs_subject` (`subject_id`),
  ADD KEY `idx_faculty_subjects_school_year_id` (`school_year_id`),
  ADD KEY `idx_faculty_subjects_semester_id` (`semester_id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_programs_department` (`department_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `semester_id` (`semester_id`),
  ADD KEY `program_id` (`program_id`);

--
-- Indexes for table `school_years`
--
ALTER TABLE `school_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `semester_id` (`semester_id`),
  ADD KEY `curriculum_id` (`curriculum_id`),
  ADD KEY `fk_sections_program` (`program_id`);

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sy_id` (`sy_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `curriculum_id` (`curriculum_id`),
  ADD KEY `students_user_id_fk` (`user_id`),
  ADD KEY `fk_students_program` (`program_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_subjects_department` (`department_id`),
  ADD KEY `fk_subjects_program` (`program_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `curriculum`
--
ALTER TABLE `curriculum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `curriculum_subjects`
--
ALTER TABLE `curriculum_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `faculty_subjects`
--
ALTER TABLE `faculty_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `school_years`
--
ALTER TABLE `school_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `curriculum`
--
ALTER TABLE `curriculum`
  ADD CONSTRAINT `fk_curriculum_program` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `curriculum_subjects`
--
ALTER TABLE `curriculum_subjects`
  ADD CONSTRAINT `curriculum_subjects_ibfk_1` FOREIGN KEY (`curriculum_id`) REFERENCES `curriculum` (`id`),
  ADD CONSTRAINT `curriculum_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `enrollments_ibfk_3` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`);

--
-- Constraints for table `faculties`
--
ALTER TABLE `faculties`
  ADD CONSTRAINT `faculties_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_faculties_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `faculty_subjects`
--
ALTER TABLE `faculty_subjects`
  ADD CONSTRAINT `fk_faculty_subjects_schoolyear` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_faculty_subjects_semester` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_fs_faculty` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_fs_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `fk_programs_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `fk_schedules_program_id` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`),
  ADD CONSTRAINT `schedules_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `schedules_ibfk_3` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `schedules_ibfk_4` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `schedules_ibfk_5` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`);

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `fk_sections_program` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sections_ibfk_1` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`),
  ADD CONSTRAINT `sections_ibfk_2` FOREIGN KEY (`curriculum_id`) REFERENCES `curriculum` (`id`);

--
-- Constraints for table `semesters`
--
ALTER TABLE `semesters`
  ADD CONSTRAINT `semesters_ibfk_1` FOREIGN KEY (`sy_id`) REFERENCES `school_years` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_students_program` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`curriculum_id`) REFERENCES `curriculum` (`id`),
  ADD CONSTRAINT `students_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `fk_subjects_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_subjects_program` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
