-- MySQL dump 10.13  Distrib 8.0.11, for macos10.13 (x86_64)
--
-- Host: localhost    Database: esaplive
-- ------------------------------------------------------
-- Server version	8.0.11

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8mb4 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `IP_Exam_Details`
--

DROP TABLE IF EXISTS `IP_Exam_Details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `IP_Exam_Details` (
  `exam_id` int(20) NOT NULL AUTO_INCREMENT,
  `Exam_name` varchar(30) NOT NULL,
  `Date_exam` char(20) NOT NULL,
  `Test_type_id` int(10) NOT NULL,
  `Board` varchar(20) NOT NULL,
  `created_by` varchar(20) NOT NULL,
  `updated_by` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`exam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `IP_Exam_Details`
--

LOCK TABLES `IP_Exam_Details` WRITE;
/*!40000 ALTER TABLE `IP_Exam_Details` DISABLE KEYS */;
INSERT INTO `IP_Exam_Details` VALUES (5,'J-MPC-IIT-P1-WE-T1','12-11-2011',12,'J4','','SRINIVAS','2018-08-13 04:01:34','2018-08-13 04:18:03'),(7,'J-MPC-IIT-P1-WE-T1','12-11-2011',12,'J4','SRINIVAS','','2018-08-13 04:06:24','2018-08-13 04:06:24'),(8,'J-MPC-IIT-P1-WE-T1','12-11-2011',12,'J4','SRINIVAS','','2018-08-13 04:37:50','2018-08-13 04:37:50'),(10,'J-MPC-IIT-P1-WE-T1','12-11-2011',12,'J4','','SRINIVAS','2018-08-13 06:27:49','2018-08-13 06:40:33'),(11,'J-MPC-IIT-P1-WE-T1','12-11-2011',12,'J4','SRINIVAS','','2018-08-13 07:32:40','2018-08-13 07:32:40'),(12,'J-MPC-IIT-P1-WE-T1','12-11-2011',12,'J4','SRINIVAS','','2018-08-13 23:40:55','2018-08-13 23:40:55'),(13,'J-MPC-IIT-P1-WE-T1','12-11-2011',12,'J4','SRINIVAS','','2018-08-14 04:54:45','2018-08-14 04:54:45'),(14,'J-MPC-IIT-P1-WE-T1','12-11-2011',12,'J4','SRINIVAS','','2018-08-14 04:55:30','2018-08-14 04:55:30'),(15,'J-MPC-IIT-P1-WE-T1','12-11-2011',12,'J4','SRINIVAS','','2018-08-14 04:58:11','2018-08-14 04:58:11'),(16,'J-MPC-IIT-P1-WE-T1','12-11-2011',12,'J4','SRINIVAS','','2018-08-14 05:00:22','2018-08-14 05:00:22'),(17,'J-MPC-IIT-P1-WE-T1','12-11-2011',12,'J4','SRINIVAS','','2018-08-14 05:01:28','2018-08-14 05:01:28'),(18,'J-MPC-IIT-P1-WE-T1','12-11-2011',12,'J4','SRINIVAS','','2018-08-14 05:02:08','2018-08-14 05:02:08'),(19,'J-MPC-IIT-P1-WE-T1','12-11-2011',12,'J4','SRINIVAS','','2018-08-14 05:10:15','2018-08-14 05:10:15'),(20,'J-MPC-IIT-P1-WE-T1','12-11-2011',12,'J4','SRINIVAS','','2018-08-14 05:13:36','2018-08-14 05:13:36'),(21,'J-MPC-IIT-P1-WE-T1','12-11-2011',12,'J4','SRINIVAS','','2018-08-14 05:13:56','2018-08-14 05:13:56'),(22,'J-MPC-IIT-P1-WE-T1','12-11-2011',12,'J4','SRINIVAS','','2018-08-14 05:41:19','2018-08-14 05:41:19'),(23,'J-MPC-IIT-P1-WE-T1','12-11-2011',12,'J4','SRINIVAS','','2018-08-14 05:43:38','2018-08-14 05:43:38'),(24,'J-MPC-IIT-P1-WE-T1','12-11-2011',12,'J4','SRINIVAS','','2018-08-15 23:34:20','2018-08-15 23:34:20');
/*!40000 ALTER TABLE `IP_Exam_Details` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-08-21 12:31:18