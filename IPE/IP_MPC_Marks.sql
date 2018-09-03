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
-- Table structure for table `IP_MPC_Marks`
--

CREATE TABLE `IP_MPC_Marks` (
  `sl` int(11) NOT NULL,
  `CAMPUS_ID` bigint(20) DEFAULT NULL,
  `STUD_ID` varchar(25) DEFAULT NULL,
  `exam_id` int(20) DEFAULT NULL,
  `PHYSICS` decimal(5,2) DEFAULT NULL,
  `CHEMISTRY` decimal(5,2) DEFAULT NULL,
  `MATHEMATICS` decimal(5,2) DEFAULT NULL,
  `TOTAL` decimal(5,2) DEFAULT NULL,
  `SEC_RANK` int(3) DEFAULT NULL,
  `CAMP_RANK` int(3) DEFAULT NULL,
  `CITY_RANK` int(5) DEFAULT NULL,
  `DISTRICT_RANK` int(5) DEFAULT NULL,
  `STATE_RANK` int(8) DEFAULT NULL,
  `ALL_INDIA_RANK` int(8) DEFAULT NULL,
  `ENGLISH` int(3) DEFAULT NULL,
  `GK` int(3) DEFAULT NULL,
  `MATHEMATICS_RANK` int(3) DEFAULT NULL,
  `PHYSICS_RANK` int(3) DEFAULT NULL,
  `CHEMISTRY_RANK` int(3) DEFAULT NULL,
  `M_RANK` int(5) DEFAULT NULL,
  `P_RANK` int(5) DEFAULT NULL,
  `C_RANK` int(5) DEFAULT NULL,
  `MAT1` varchar(10) DEFAULT NULL,
  `MAT2` varchar(10) DEFAULT NULL,
  `MAT3` varchar(10) DEFAULT NULL,
  `PHY1` varchar(10) DEFAULT NULL,
  `PHY2` varchar(10) DEFAULT NULL,
  `CHE1` varchar(10) DEFAULT NULL,
  `CHE2` varchar(10) DEFAULT NULL,
  `REG_RANK` int(4) DEFAULT NULL,
  `CAMPUS` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `IP_MPC_Marks`
--

INSERT INTO `IP_MPC_Marks` (`sl`, `CAMPUS_ID`, `STUD_ID`, `exam_id`, `PHYSICS`, `CHEMISTRY`, `MATHEMATICS`, `TOTAL`, `SEC_RANK`, `CAMP_RANK`, `CITY_RANK`, `DISTRICT_RANK`, `STATE_RANK`, `ALL_INDIA_RANK`, `ENGLISH`, `GK`, `MATHEMATICS_RANK`, `PHYSICS_RANK`, `CHEMISTRY_RANK`, `M_RANK`, `P_RANK`, `C_RANK`, `MAT1`, `MAT2`, `MAT3`, `PHY1`, `PHY2`, `CHE1`, `CHE2`, `REG_RANK`, `CAMPUS`) VALUES
(1, 249, '178461028', 23, '11.00', '15.00', '10.00', '34.00', 3, 4, 5, 4, 3, 4, 23, 3, 4, 45, 3, 4, 34, 23, '78', '6', '56', '65', '5', '8', '9', 3, '12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `IP_MPC_Marks`
--
ALTER TABLE `IP_MPC_Marks`
  ADD PRIMARY KEY (`sl`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `IP_MPC_Marks`
--
ALTER TABLE `IP_MPC_Marks`
  MODIFY `sl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
