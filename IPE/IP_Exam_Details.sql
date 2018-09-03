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
-- Table structure for table `IP_Exam_Details`
--

CREATE TABLE `IP_Exam_Details` (
  `exam_id` int(20) NOT NULL,
  `Exam_name` varchar(30) NOT NULL,
  `Date_exam` char(20) NOT NULL,
  `Test_type_id` int(10) NOT NULL,
  `Board` varchar(20) NOT NULL,
  `created_by` varchar(20) NOT NULL,
  `updated_by` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `IP_Exam_Details`
--

INSERT INTO `IP_Exam_Details` (`exam_id`, `Exam_name`, `Date_exam`, `Test_type_id`, `Board`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(5, 'J-MPC-IIT-P1-WE-T1', '12-11-2011', 12, 'J4', '', 'SRINIVAS', '2018-08-13 04:01:34', '2018-08-13 04:18:03'),
(7, 'J-MPC-IIT-P1-WE-T1', '12-11-2011', 2, 'J4', 'SRINIVAS', '', '2018-08-13 04:06:24', '2018-08-13 04:06:24'),
(8, 'J-MPC-IIT-P1-WE-T1', '12-11-2011', 1, 'J4', 'SRINIVAS', '', '2018-08-13 04:37:50', '2018-08-13 04:37:50'),
(10, 'J-MPC-IIT-P1-WE-T1', '12-11-2011', 12, 'J4', '', 'SRINIVAS', '2018-08-13 06:27:49', '2018-08-13 06:40:33'),
(11, 'J-MPC-IIT-P1-WE-T1', '12-11-2011', 12, 'J4', 'SRINIVAS', '', '2018-08-13 07:32:40', '2018-08-13 07:32:40'),
(12, 'J-MPC-IIT-P1-WE-T1', '12-11-2011', 12, 'J4', 'SRINIVAS', '', '2018-08-13 23:40:55', '2018-08-13 23:40:55'),
(13, 'J-MPC-IIT-P1-WE-T1', '12-11-2011', 12, 'J4', 'SRINIVAS', '', '2018-08-14 04:54:45', '2018-08-14 04:54:45'),
(14, 'J-MPC-IIT-P1-WE-T1', '12-11-2011', 12, 'J4', 'SRINIVAS', '', '2018-08-14 04:55:30', '2018-08-14 04:55:30'),
(15, 'J-MPC-IIT-P1-WE-T1', '12-11-2011', 12, 'J4', 'SRINIVAS', '', '2018-08-14 04:58:11', '2018-08-14 04:58:11'),
(16, 'J-MPC-IIT-P1-WE-T1', '12-11-2011', 12, 'J4', 'SRINIVAS', '', '2018-08-14 05:00:22', '2018-08-14 05:00:22'),
(17, 'J-MPC-IIT-P1-WE-T1', '12-11-2011', 12, 'J4', 'SRINIVAS', '', '2018-08-14 05:01:28', '2018-08-14 05:01:28'),
(18, 'J-MPC-IIT-P1-WE-T1', '12-11-2011', 12, 'J4', 'SRINIVAS', '', '2018-08-14 05:02:08', '2018-08-14 05:02:08'),
(19, 'J-MPC-IIT-P1-WE-T1', '12-11-2011', 12, 'J4', 'SRINIVAS', '', '2018-08-14 05:10:15', '2018-08-14 05:10:15'),
(20, 'J-MPC-IIT-P1-WE-T1', '12-11-2011', 3, 'J4', 'SRINIVAS', '', '2018-08-14 05:13:36', '2018-08-14 05:13:36'),
(21, 'J-MPC-IIT-P1-WE-T1', '12-11-2011', 12, 'J4', 'SRINIVAS', '', '2018-08-14 05:13:56', '2018-08-14 05:13:56'),
(23, 'J-MPC-IIT-P1-WE-T1', '12-11-2011', 12, '1', 'SRINIVAS', '167016667', '2018-08-14 05:43:38', '2018-08-27 01:17:15'),
(24, 'J-MPC-IIT-P1-WE-T1', '12-11-2011', 12, 'J4', 'SRINIVAS', '', '2018-08-15 23:34:20', '2018-08-15 23:34:20'),
(25, 'J-MPC-IIT-P1-WE-T1', '12-11-2011', 12, 'J4', 'SRINIVAS', '', '2018-08-16 04:03:09', '2018-08-16 04:03:09'),
(26, 'J-MPC-IIT-P1-WE-T1', '12-11-2011', 1, '23', 'TALAGADADEEVI', '', '2018-08-21 01:51:53', '2018-08-21 01:51:53'),
(27, 'J-MPC-IIT-P1-WE-T1', '12-11-2011', 12, '23', '167016667', '', '2018-08-27 00:52:58', '2018-08-27 00:52:58'),
(28, 'J-MPC-IIT-P1-WE-T1', '12-11-2011', 12, '23', '3', '3', '2018-08-31 00:24:19', '2018-08-31 00:49:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `IP_Exam_Details`
--
ALTER TABLE `IP_Exam_Details`
  ADD PRIMARY KEY (`exam_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `IP_Exam_Details`
--
ALTER TABLE `IP_Exam_Details`
  MODIFY `exam_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
