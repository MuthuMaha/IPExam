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
-- Table structure for table `IP_Test_Max_Marks`
--

CREATE TABLE `IP_Test_Max_Marks` (
  `sl` int(11) NOT NULL,
  `test_type_id` bigint(20) DEFAULT NULL,
  `subject_id` bigint(20) DEFAULT NULL,
  `max_marks` varchar(50) DEFAULT NULL,
  `pass_marks` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `IP_Test_Max_Marks`
--

INSERT INTO `IP_Test_Max_Marks` (`sl`, `test_type_id`, `subject_id`, `max_marks`, `pass_marks`) VALUES
(1, 1, 7, '25', '12'),
(2, 2, 7, '50', '25'),
(3, 11, 7, '100', '50'),
(4, 12, 7, '100', '50'),
(5, 13, 7, '100', '50'),
(8, 1, 10, '25', '12'),
(9, 2, 10, '50', '25'),
(10, 11, 10, '100', '50'),
(11, 12, 10, '100', '50'),
(12, 13, 10, '100', '50'),
(15, 1, 3, '50', '25'),
(16, 2, 3, '50', '25'),
(17, 11, 3, '75', '37'),
(18, 12, 3, '75', '37'),
(19, 13, 3, '75', '37'),
(22, 1, 9, '0', '0'),
(23, 2, 9, '50', '25'),
(24, 11, 9, '75', '37'),
(25, 12, 9, '75', '37'),
(26, 13, 9, '75', '37'),
(29, 1, 1, '20', '10'),
(30, 2, 1, '30', '15'),
(31, 11, 1, '60', '30'),
(32, 12, 1, '60', '30'),
(33, 13, 1, '60', '30'),
(36, 1, 2, '20', '10'),
(37, 2, 2, '30', '15'),
(38, 11, 2, '60', '30'),
(39, 12, 2, '60', '30'),
(40, 13, 2, '60', '30'),
(43, 1, 5, '20', '10'),
(44, 2, 5, '30', '15'),
(45, 11, 5, '60', '30'),
(46, 12, 5, '60', '30'),
(47, 13, 5, '60', '30'),
(50, 1, 6, '20', '10'),
(51, 2, 6, '30', '15'),
(52, 11, 6, '60', '30'),
(53, 12, 6, '60', '30'),
(54, 13, 6, '60', '30'),
(57, 1, 11, '25', '12'),
(58, 2, 11, '50', '25'),
(59, 11, 11, '100', '50'),
(60, 12, 11, '100', '50'),
(61, 13, 11, '100', '50'),
(64, 1, 12, '25', '12'),
(65, 2, 12, '50', '25'),
(66, 11, 12, '100', '50'),
(67, 12, 12, '100', '50'),
(68, 13, 12, '100', '50'),
(71, 1, 13, '25', '12'),
(72, 2, 13, '50', '25'),
(73, 11, 13, '100', '50'),
(74, 12, 13, '100', '50'),
(75, 13, 13, '100', '50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `IP_Test_Max_Marks`
--
ALTER TABLE `IP_Test_Max_Marks`
  ADD PRIMARY KEY (`sl`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `IP_Test_Max_Marks`
--
ALTER TABLE `IP_Test_Max_Marks`
  MODIFY `sl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
