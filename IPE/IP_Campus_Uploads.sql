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
-- Table structure for table `IP_Campus_Uploads`
--

CREATE TABLE `IP_Campus_Uploads` (
  `sl` int(11) NOT NULL,
  `CAMPUS_ID` bigint(20) DEFAULT NULL,
  `exam_id` bigint(20) DEFAULT NULL,
  `section_id` bigint(20) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `IP_Campus_Uploads`
--

INSERT INTO `IP_Campus_Uploads` (`sl`, `CAMPUS_ID`, `exam_id`, `section_id`, `status`) VALUES
(2, 41, 23, NULL, 0),
(3, 54, 24, NULL, 0),
(4, 12, 25, NULL, 0),
(5, 10, 27, NULL, 0),
(8, 120, 6, 12, 0),
(9, 120, NULL, NULL, NULL),
(10, 120, 8, 12, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `IP_Campus_Uploads`
--
ALTER TABLE `IP_Campus_Uploads`
  ADD PRIMARY KEY (`sl`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `IP_Campus_Uploads`
--
ALTER TABLE `IP_Campus_Uploads`
  MODIFY `sl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
