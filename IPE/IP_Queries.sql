-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 31, 2018 at 12:20 PM
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
-- Table structure for table `IP_Queries`
--

CREATE TABLE `IP_Queries` (
  `query_id` int(11) NOT NULL,
  `query_text` varchar(50) NOT NULL,
  `pointed_by` varchar(30) NOT NULL,
  `stud_id` varchar(30) NOT NULL,
  `exam_id` bigint(20) NOT NULL,
  `subject_id` bigint(20) NOT NULL,
  `pointed_to` varchar(30) NOT NULL,
  `created_at` varchar(30) NOT NULL,
  `updated_at` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `IP_Queries`
--

INSERT INTO `IP_Queries` (`query_id`, `query_text`, `pointed_by`, `stud_id`, `exam_id`, `subject_id`, `pointed_to`, `created_at`, `updated_at`) VALUES
(4, 'Hi Im fine what about you', 'MANIKUMAR', '167016667', 23, 3, 'DEF123', '2018-08-28 11:18:50', '2018-08-28 11:18:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `IP_Queries`
--
ALTER TABLE `IP_Queries`
  ADD PRIMARY KEY (`query_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `IP_Queries`
--
ALTER TABLE `IP_Queries`
  MODIFY `query_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
