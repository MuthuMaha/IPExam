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
-- Table structure for table `IP_Exam_Conducted_For`
--

DROP TABLE IF EXISTS `IP_Exam_Conducted_For`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `IP_Exam_Conducted_For` (
  `sl` int(11) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) NOT NULL,
  `group_id` bigint(20) NOT NULL,
  `classyear_id` bigint(20) NOT NULL,
  `stream_id` bigint(20) NOT NULL,
  `program_id` bigint(20) NOT NULL,
  PRIMARY KEY (`sl`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `IP_Exam_Conducted_For`
--

LOCK TABLES `IP_Exam_Conducted_For` WRITE;
/*!40000 ALTER TABLE `IP_Exam_Conducted_For` DISABLE KEYS */;
INSERT INTO `IP_Exam_Conducted_For` VALUES (1,22,4,1,1,1),(2,22,4,1,1,1),(3,22,4,1,1,1),(4,22,4,1,1,1),(5,23,4,1,1,1),(6,23,4,1,1,1),(7,23,4,1,1,1),(8,23,4,1,1,1),(9,24,4,1,1,1),(10,24,4,1,1,1),(11,24,4,1,1,1),(12,24,4,1,1,1),(13,7,5,2,2,13),(14,7,4,2,2,13),(15,8,4,2,2,13),(16,20,4,2,2,13);
/*!40000 ALTER TABLE `IP_Exam_Conducted_For` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-08-21 12:28:34
