-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2024 at 04:22 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_question_generator`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admins`
--

CREATE TABLE `tbl_admins` (
  `ids` int(11) NOT NULL,
  `username` varchar(1000) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admins`
--

INSERT INTO `tbl_admins` (`ids`, `username`, `password`, `status`) VALUES
(1, 'ritto', '123', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exam_login`
--

CREATE TABLE `tbl_exam_login` (
  `ids` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `scored` decimal(18,2) NOT NULL,
  `total_score` decimal(18,2) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_exam_login`
--

INSERT INTO `tbl_exam_login` (`ids`, `name`, `email`, `scored`, `total_score`, `date_time`) VALUES
(1, 'ritto', 'ritto@gmail.com', '30.00', '40.00', '2024-04-04 14:10:33'),
(2, 'ritto', 'ritto@gmaail.com', '0.00', '40.00', '2024-04-04 14:21:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_questions`
--

CREATE TABLE `tbl_questions` (
  `ids` int(11) NOT NULL,
  `question` text NOT NULL,
  `options` text NOT NULL,
  `answer` text NOT NULL,
  `score` decimal(18,2) NOT NULL,
  `question_code` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_questions`
--

INSERT INTO `tbl_questions` (`ids`, `question`, `options`, `answer`, `score`, `question_code`, `status`) VALUES
(1, 'Full Form of PHP', '1) Personal Home Page 2) Preprocessed Hypertext Processor 3) Hypertext Preprocessor 4) Public Hosting Platform', 'Hypertext Preprocessor', '10.00', 'd8q2i', 'Active'),
(2, 'Which PHP framework is known for its simplicity and ease of use in building web applications?', '1) Laravel 2) Symfony 3) CodeIgniter 4) Django', 'Django', '10.00', 'r6qtJ', 'Active'),
(3, 'Which function in PHP is used to redirect the user to another webpage?', '1) location() 2) forward() 3) redirect() 4) header()', 'header()', '10.00', 'd1wtJ', 'Active'),
(4, 'Which of the following is NOT a data type supported by PHP?', '1) Integer 2) String 3) Float 4) Boolean Array', 'Boolean Array', '10.00', 'd8q5J', 'Active'),
(5, 'test', 'test', 'test', '10.00', 'd8qtJ', 'Deactive');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admins`
--
ALTER TABLE `tbl_admins`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_exam_login`
--
ALTER TABLE `tbl_exam_login`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_questions`
--
ALTER TABLE `tbl_questions`
  ADD PRIMARY KEY (`ids`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admins`
--
ALTER TABLE `tbl_admins`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_exam_login`
--
ALTER TABLE `tbl_exam_login`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_questions`
--
ALTER TABLE `tbl_questions`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
