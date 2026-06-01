-- MySQL dump 10.13  Distrib 8.0.45, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: pop_stat_analytics
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `adolescent_mother_records`
--

DROP TABLE IF EXISTS `adolescent_mother_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adolescent_mother_records` (
  `adolescent_mother_id` int(11) NOT NULL AUTO_INCREMENT,
  `dedaID` int(11) NOT NULL,
  `age` tinyint(4) NOT NULL,
  `total_count` int(11) DEFAULT 0,
  PRIMARY KEY (`adolescent_mother_id`),
  KEY `dedaID` (`dedaID`),
  CONSTRAINT `adolescent_mother_records_ibfk_1` FOREIGN KEY (`dedaID`) REFERENCES `demographic_datas` (`dedaID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adolescent_mother_records`
--

LOCK TABLES `adolescent_mother_records` WRITE;
/*!40000 ALTER TABLE `adolescent_mother_records` DISABLE KEYS */;
INSERT INTO `adolescent_mother_records` VALUES (4,4,17,1),(5,6,17,1),(6,6,18,2),(7,6,19,1),(14,7,18,1),(15,8,18,1),(17,11,16,1),(18,9,15,1),(19,9,18,1),(20,9,19,1),(25,3,17,1),(26,3,18,4),(27,3,19,1);
/*!40000 ALTER TABLE `adolescent_mother_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `demographic_datas`
--

DROP TABLE IF EXISTS `demographic_datas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `demographic_datas` (
  `dedaID` int(11) NOT NULL AUTO_INCREMENT,
  `municipality_id` int(11) NOT NULL,
  `record_month` tinyint(4) DEFAULT 0,
  `record_year` int(11) DEFAULT 0,
  `male_death` int(11) DEFAULT 0,
  `female_death` int(11) DEFAULT 0,
  `birth_on_date_male` int(11) DEFAULT 0,
  `birth_on_date_female` int(11) DEFAULT 0,
  `birth_late_male` int(11) DEFAULT 0,
  `birth_late_female` int(11) DEFAULT 0,
  `birth_married_parents` int(11) DEFAULT 0,
  `birth_not_married_parents` int(11) DEFAULT 0,
  `marriages` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`dedaID`),
  UNIQUE KEY `municipality_id` (`municipality_id`,`record_month`,`record_year`),
  CONSTRAINT `demographic_datas_ibfk_1` FOREIGN KEY (`municipality_id`) REFERENCES `municipalities` (`municipality_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demographic_datas`
--

LOCK TABLES `demographic_datas` WRITE;
/*!40000 ALTER TABLE `demographic_datas` DISABLE KEYS */;
INSERT INTO `demographic_datas` VALUES (1,1,1,2026,2,1,2,0,0,0,0,3,7,'2026-05-21 09:02:59'),(2,3,1,2026,5,2,7,4,0,0,2,9,8,'2026-05-21 09:04:04'),(3,2,1,2026,5,3,15,10,0,0,8,17,9,'2026-05-21 09:04:53'),(4,1,2,2026,9,3,4,3,0,0,1,6,16,'2026-05-21 09:05:42'),(5,3,2,2026,1,1,0,0,0,0,0,0,4,'2026-05-21 09:06:43'),(6,2,2,2026,6,5,8,8,0,0,5,11,2,'2026-05-21 09:08:59'),(7,1,3,2026,3,4,0,2,0,0,1,1,2,'2026-06-01 01:30:43'),(8,3,3,2026,5,3,3,0,0,0,3,0,39,'2026-06-01 01:44:37'),(9,2,3,2026,4,5,6,9,0,0,7,8,2,'2026-06-01 01:45:55'),(10,1,4,2026,12,5,0,0,1,5,1,5,3,'2026-06-01 03:40:08'),(11,2,4,2026,5,3,11,5,5,3,7,17,8,'2026-06-01 03:55:29'),(12,3,4,2026,5,9,5,8,5,4,4,17,9,'2026-06-01 03:57:59');
/*!40000 ALTER TABLE `demographic_datas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `municipalities`
--

DROP TABLE IF EXISTS `municipalities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `municipalities` (
  `municipality_id` int(11) NOT NULL AUTO_INCREMENT,
  `mun_name` varchar(50) NOT NULL,
  PRIMARY KEY (`municipality_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `municipalities`
--

LOCK TABLES `municipalities` WRITE;
/*!40000 ALTER TABLE `municipalities` DISABLE KEYS */;
INSERT INTO `municipalities` VALUES (1,'Ramon Magsaysay'),(2,'Midsalip'),(3,'Tambulig');
/*!40000 ALTER TABLE `municipalities` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-01 16:33:36
