-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: attendancemsystem
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.27-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbladmin`
--

DROP TABLE IF EXISTS `tbladmin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbladmin` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbladmin`
--

LOCK TABLES `tbladmin` WRITE;
/*!40000 ALTER TABLE `tbladmin` DISABLE KEYS */;
INSERT INTO `tbladmin` VALUES (1,'Admin','','m.adel','e6e061838856bf47e1de730719fb2609');
/*!40000 ALTER TABLE `tbladmin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblattendance`
--

DROP TABLE IF EXISTS `tblattendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblattendance` (
  `attendanceID` int(50) NOT NULL AUTO_INCREMENT,
  `employeeRegistrationNumber` varchar(100) NOT NULL,
  `tmonth` varchar(100) NOT NULL,
  `attendanceStatus` varchar(100) NOT NULL,
  `dateMarked` date NOT NULL,
  `week` varchar(100) NOT NULL,
  PRIMARY KEY (`attendanceID`)
) ENGINE=InnoDB AUTO_INCREMENT=510 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblattendance`
--

LOCK TABLES `tblattendance` WRITE;
/*!40000 ALTER TABLE `tblattendance` DISABLE KEYS */;
INSERT INTO `tblattendance` VALUES (489,'1511','11-2024','present','2024-10-29','W1'),(490,'6623','11-2024','present','2024-10-29','W1'),(491,'13649','11-2024','present','2024-10-29','W1'),(492,'1648','11-2024','present','2024-10-29','W1'),(493,'1245','11-2024','present','2024-10-29','W1'),(494,'189','11-2024','present','2024-10-29','W1'),(495,'123','11-2024','present','2024-10-29','W1'),(496,'1511','11-2024','غائب','2024-10-29','W1'),(497,'6623','11-2024','غائب','2024-10-29','W1'),(498,'13649','11-2024','present','2024-10-29','W1'),(499,'1648','11-2024','present','2024-10-29','W1'),(500,'1245','11-2024','present','2024-10-29','W1'),(501,'189','11-2024','present','2024-10-29','W1'),(502,'123','11-2024','غائب','2024-10-29','W1'),(503,'1511','11-2024','غائب','2024-10-29','W1'),(504,'6623','11-2024','غائب','2024-10-29','W1'),(505,'13649','11-2024','غائب','2024-10-29','W1'),(506,'1648','11-2024','present','2024-10-29','W1'),(507,'1245','11-2024','غائب','2024-10-29','W1'),(508,'189','11-2024','present','2024-10-29','W1'),(509,'123','11-2024','غائب','2024-10-29','W1');
/*!40000 ALTER TABLE `tblattendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbltmonth`
--

DROP TABLE IF EXISTS `tbltmonth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbltmonth` (
  `ID` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `facultyID` int(50) NOT NULL,
  `dateCreated` date NOT NULL,
  `tmonthCode` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbltmonth`
--

LOCK TABLES `tbltmonth` WRITE;
/*!40000 ALTER TABLE `tbltmonth` DISABLE KEYS */;
INSERT INTO `tbltmonth` VALUES (21,'Nov2024',1,'2024-10-29','11-2024');
/*!40000 ALTER TABLE `tbltmonth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblbranch`
--

DROP TABLE IF EXISTS `tblbranch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblbranch` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `facultyName` varchar(255) NOT NULL,
  `facultyCode` varchar(50) NOT NULL,
  `dateRegistered` date NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblbranch`
--

LOCK TABLES `tblbranch` WRITE;
/*!40000 ALTER TABLE `tblbranch` DISABLE KEYS */;
INSERT INTO `tblbranch` VALUES (1,'El-Batal','pj_br','2024-04-07');
/*!40000 ALTER TABLE `tblbranch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblmanager`
--

DROP TABLE IF EXISTS `tblmanager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblmanager` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phoneNo` varchar(50) NOT NULL,
  `facultyCode` varchar(50) NOT NULL,
  `dateCreated` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblmanager`
--

LOCK TABLES `tblmanager` WRITE;
/*!40000 ALTER TABLE `tblmanager` DISABLE KEYS */;
INSERT INTO `tblmanager` VALUES (1,'Papajohns','Manager','pj.manager','b9aaa755c379bdfcde7e8755b45f0a20','0000000','CIT','2024-05-02'),(2,'Stacked','Manager','st.manager','b9aaa755c379bdfcde7e8755b45f0a20','00000000','FoSST','2024-04-07');
/*!40000 ALTER TABLE `tblmanager` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblemployees`
--

DROP TABLE IF EXISTS `tblemployees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblemployees` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `registrationNumber` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `faculty` varchar(10) NOT NULL,
  `tmonthCode` varchar(20) NOT NULL,
  `employeeImage1` varchar(300) NOT NULL,
  `employeeImage2` varchar(300) NOT NULL,
  `dateRegistered` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=139 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblemployees`
--

LOCK TABLES `tblemployees` WRITE;
/*!40000 ALTER TABLE `tblemployees` DISABLE KEYS */;
INSERT INTO `tblemployees` VALUES (138,'abdullah','mahmoud','1511','a.mahmoud@test.com','pj_br','11-2024','1511_image1.png','1511_image2.png','2024-10-29'),(137,'kjdhjkd','kshohoi','6623','hjkd@test.com','pj_br','11-2024','6623_image1.png','6623_image2.png','2024-10-29'),(136,'emp2','emp145','13649','ghj@test.com','pj_br','11-2024','13649_image1.png','13649_image2.png','2024-10-29'),(135,'emp1','emp1','1648','emp12@test.com','pj_br','11-2024','1648_image1.png','1648_image2.png','2024-10-29'),(133,'werwer','werwerwe','1245','cxvzcvz@sfgfdgdf','pj_br','11-2024','1245_image1.png','1245_image2.png','2024-10-29'),(134,'erwqwtr','cbcv c','189','sdfsdfs@sgfdsg','pj_br','11-2024','189_image1.png','189_image2.png','2024-10-29'),(132,'Mohamed','Adel','123','eng.mohamed9988@gmail.com','pj_br','11-2024','123_image1.png','123_image2.png','2024-10-29');
/*!40000 ALTER TABLE `tblemployees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblweek`
--

DROP TABLE IF EXISTS `tblweek`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblweek` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `weekCode` varchar(50) NOT NULL,
  `tmonthID` varchar(50) NOT NULL,
  `dateCreated` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblweek`
--

LOCK TABLES `tblweek` WRITE;
/*!40000 ALTER TABLE `tblweek` DISABLE KEYS */;
INSERT INTO `tblweek` VALUES (10,'Firstweek','W1','21','2024-10-29');
/*!40000 ALTER TABLE `tblweek` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblshift`
--

DROP TABLE IF EXISTS `tblshift`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblshift` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `className` varchar(50) NOT NULL,
  `facultyCode` varchar(50) NOT NULL,
  `currentStatus` varchar(50) NOT NULL,
  `capacity` int(10) NOT NULL,
  `classification` varchar(50) NOT NULL,
  `dateCreated` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblshift`
--

LOCK TABLES `tblshift` WRITE;
/*!40000 ALTER TABLE `tblshift` DISABLE KEYS */;
INSERT INTO `tblshift` VALUES (14,'TSNight','pj_br','Night',12,'','2024-10-29');
/*!40000 ALTER TABLE `tblshift` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'attendancemsystem'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-29 14:00:05
