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
-- Table structure for table `IP_Query_Response`
--

CREATE TABLE `IP_Query_Response` (
  `response_id` int(11) NOT NULL,
  `query_id` int(11) NOT NULL,
  `response_text` varchar(50) NOT NULL,
  `response_by` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `IP_Query_Response`
--

INSERT INTO `IP_Query_Response` (`response_id`, `query_id`, `response_text`, `response_by`, `created_at`, `updated_at`) VALUES
(10, 3, 'Hi Im', 'DEF123', '2018-08-28 06:16:53', '2018-08-28 06:16:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `IP_Query_Response`
--
ALTER TABLE `IP_Query_Response`
  ADD PRIMARY KEY (`response_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `IP_Query_Response`
--
ALTER TABLE `IP_Query_Response`
  MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
