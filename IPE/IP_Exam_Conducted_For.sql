-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 31, 2018 at 12:19 PM
-- Server version: 5.7.23-0ubuntu0.18.04.1
-- PHP Version: 7.2.7-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `task3`
--

-- --------------------------------------------------------

--
-- Table structure for table `IP_Exam_Conducted_For`
--

CREATE TABLE `IP_Exam_Conducted_For` (
  `sl` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `group_id` bigint(20) NOT NULL,
  `classyear_id` bigint(20) NOT NULL,
  `stream_id` bigint(20) NOT NULL,
  `program_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `IP_Exam_Conducted_For`
--

INSERT INTO `IP_Exam_Conducted_For` (`sl`, `exam_id`, `group_id`, `classyear_id`, `stream_id`, `program_id`) VALUES
(5, 23, 5, 3, 10, 81),
(6, 24, 4, 3, 10, 81),
(7, 23, 4, 3, 10, 81),
(8, 23, 4, 1, 1, 1),
(9, 24, 4, 1, 1, 1),
(10, 24, 4, 1, 1, 1),
(11, 24, 4, 1, 1, 1),
(12, 24, 4, 1, 1, 1),
(13, 7, 5, 2, 2, 13),
(14, 7, 4, 2, 2, 13),
(15, 8, 4, 2, 2, 13),
(16, 20, 4, 2, 2, 13),
(17, 27, 12, 11, 56, 12),
(18, 27, 4, 2, 23, 12),
(19, 27, 23, 23, 34, 32),
(20, 27, 4, 12, 4, 10),
(21, 28, 12, 11, 56, 12),
(22, 28, 4, 2, 23, 12),
(23, 28, 23, 23, 34, 32),
(24, 28, 4, 12, 4, 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `IP_Exam_Conducted_For`
--
ALTER TABLE `IP_Exam_Conducted_For`
  ADD PRIMARY KEY (`sl`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `IP_Exam_Conducted_For`
--
ALTER TABLE `IP_Exam_Conducted_For`
  MODIFY `sl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
