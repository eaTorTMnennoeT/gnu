-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: gnu1
-- ------------------------------------------------------
-- Server version	8.4.3

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
-- Table structure for table `g5_auth`
--

DROP TABLE IF EXISTS `g5_auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_auth` (
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `au_menu` varchar(50) NOT NULL DEFAULT '',
  `au_auth` set('r','w','d') NOT NULL DEFAULT '',
  PRIMARY KEY (`mb_id`,`au_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_auth`
--

LOCK TABLES `g5_auth` WRITE;
/*!40000 ALTER TABLE `g5_auth` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_auth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_autosave`
--

DROP TABLE IF EXISTS `g5_autosave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_autosave` (
  `as_id` int NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL,
  `as_uid` bigint unsigned NOT NULL,
  `as_subject` varchar(255) NOT NULL,
  `as_content` text NOT NULL,
  `as_datetime` datetime NOT NULL,
  PRIMARY KEY (`as_id`),
  UNIQUE KEY `as_uid` (`as_uid`),
  KEY `mb_id` (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_autosave`
--

LOCK TABLES `g5_autosave` WRITE;
/*!40000 ALTER TABLE `g5_autosave` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_autosave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_board`
--

DROP TABLE IF EXISTS `g5_board`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_board` (
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `gr_id` varchar(255) NOT NULL DEFAULT '',
  `bo_subject` varchar(255) NOT NULL DEFAULT '',
  `bo_icon` text,
  `bo_mobile_subject` varchar(255) NOT NULL DEFAULT '',
  `bo_device` enum('both','pc','mobile') NOT NULL DEFAULT 'both',
  `bo_admin` varchar(255) NOT NULL DEFAULT '',
  `bo_list_level` tinyint NOT NULL DEFAULT '0',
  `bo_read_level` tinyint NOT NULL DEFAULT '0',
  `bo_write_level` tinyint NOT NULL DEFAULT '0',
  `bo_reply_level` tinyint NOT NULL DEFAULT '0',
  `bo_comment_level` tinyint NOT NULL DEFAULT '0',
  `bo_upload_level` tinyint NOT NULL DEFAULT '0',
  `bo_download_level` tinyint NOT NULL DEFAULT '0',
  `bo_html_level` tinyint NOT NULL DEFAULT '0',
  `bo_link_level` tinyint NOT NULL DEFAULT '0',
  `bo_count_delete` tinyint NOT NULL DEFAULT '0',
  `bo_count_modify` tinyint NOT NULL DEFAULT '0',
  `bo_read_point` int NOT NULL DEFAULT '0',
  `bo_write_point` int NOT NULL DEFAULT '0',
  `bo_comment_point` int NOT NULL DEFAULT '0',
  `bo_download_point` int NOT NULL DEFAULT '0',
  `bo_use_category` tinyint NOT NULL DEFAULT '0',
  `bo_category_list` text NOT NULL,
  `bo_use_sideview` tinyint NOT NULL DEFAULT '0',
  `bo_use_file_content` tinyint NOT NULL DEFAULT '0',
  `bo_use_secret` tinyint NOT NULL DEFAULT '0',
  `bo_use_dhtml_editor` tinyint NOT NULL DEFAULT '0',
  `bo_select_editor` varchar(50) NOT NULL DEFAULT '',
  `bo_use_rss_view` tinyint NOT NULL DEFAULT '0',
  `bo_use_good` tinyint NOT NULL DEFAULT '0',
  `bo_use_nogood` tinyint NOT NULL DEFAULT '0',
  `bo_use_name` tinyint NOT NULL DEFAULT '0',
  `bo_use_signature` tinyint NOT NULL DEFAULT '0',
  `bo_use_ip_view` tinyint NOT NULL DEFAULT '0',
  `bo_use_list_view` tinyint NOT NULL DEFAULT '0',
  `bo_use_list_file` tinyint NOT NULL DEFAULT '0',
  `bo_use_list_content` tinyint NOT NULL DEFAULT '0',
  `bo_table_width` int NOT NULL DEFAULT '0',
  `bo_subject_len` int NOT NULL DEFAULT '0',
  `bo_mobile_subject_len` int NOT NULL DEFAULT '0',
  `bo_page_rows` int NOT NULL DEFAULT '0',
  `bo_mobile_page_rows` int NOT NULL DEFAULT '0',
  `bo_new` int NOT NULL DEFAULT '0',
  `bo_hot` int NOT NULL DEFAULT '0',
  `bo_image_width` int NOT NULL DEFAULT '0',
  `bo_skin` varchar(255) NOT NULL DEFAULT '',
  `bo_mobile_skin` varchar(255) NOT NULL DEFAULT '',
  `bo_include_head` varchar(255) NOT NULL DEFAULT '',
  `bo_include_tail` varchar(255) NOT NULL DEFAULT '',
  `bo_content_head` text NOT NULL,
  `bo_mobile_content_head` text NOT NULL,
  `bo_content_tail` text NOT NULL,
  `bo_mobile_content_tail` text NOT NULL,
  `bo_insert_content` text NOT NULL,
  `bo_gallery_cols` int NOT NULL DEFAULT '0',
  `bo_gallery_width` int NOT NULL DEFAULT '0',
  `bo_gallery_height` int NOT NULL DEFAULT '0',
  `bo_mobile_gallery_width` int NOT NULL DEFAULT '0',
  `bo_mobile_gallery_height` int NOT NULL DEFAULT '0',
  `bo_upload_size` int NOT NULL DEFAULT '0',
  `bo_reply_order` tinyint NOT NULL DEFAULT '0',
  `bo_use_search` tinyint NOT NULL DEFAULT '0',
  `bo_order` int NOT NULL DEFAULT '0',
  `bo_count_write` int NOT NULL DEFAULT '0',
  `bo_count_comment` int NOT NULL DEFAULT '0',
  `bo_write_min` int NOT NULL DEFAULT '0',
  `bo_write_max` int NOT NULL DEFAULT '0',
  `bo_comment_min` int NOT NULL DEFAULT '0',
  `bo_comment_max` int NOT NULL DEFAULT '0',
  `bo_notice` text NOT NULL,
  `bo_upload_count` tinyint NOT NULL DEFAULT '0',
  `bo_use_email` tinyint NOT NULL DEFAULT '0',
  `bo_use_cert` enum('','cert','adult','hp-cert','hp-adult') NOT NULL DEFAULT '',
  `bo_use_sns` tinyint NOT NULL DEFAULT '0',
  `bo_use_captcha` tinyint NOT NULL DEFAULT '0',
  `bo_sort_field` varchar(255) NOT NULL DEFAULT '',
  `bo_1_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_2_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_3_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_4_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_5_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_6_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_7_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_8_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_9_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_10_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_1` varchar(255) NOT NULL DEFAULT '',
  `bo_2` varchar(255) NOT NULL DEFAULT '',
  `bo_3` varchar(255) NOT NULL DEFAULT '',
  `bo_4` varchar(255) NOT NULL DEFAULT '',
  `bo_5` varchar(255) NOT NULL DEFAULT '',
  `bo_6` varchar(255) NOT NULL DEFAULT '',
  `bo_7` varchar(255) NOT NULL DEFAULT '',
  `bo_8` varchar(255) NOT NULL DEFAULT '',
  `bo_9` varchar(255) NOT NULL DEFAULT '',
  `bo_10` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`bo_table`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_board`
--

LOCK TABLES `g5_board` WRITE;
/*!40000 ALTER TABLE `g5_board` DISABLE KEYS */;
INSERT INTO `g5_board` VALUES ('free','community','자유게시판','<svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"><path d=\"M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z\"/></svg>','','both','',1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,'',0,0,0,1,'',0,0,0,0,0,0,0,0,0,100,60,30,15,15,24,100,835,'premium','basic','_head.php','_tail.php','','','','','',4,202,150,125,100,1048576,1,1,0,107,5,0,0,0,0,'104',2,0,'',0,0,'','','','','','','','','','','','','','','','','','','','',''),('gallery','gallery','갤러리','<svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"><rect x=\"3\" y=\"3\" width=\"18\" height=\"18\" rx=\"2\" ry=\"2\"/><circle cx=\"8.5\" cy=\"8.5\" r=\"1.5\"/><polyline points=\"21,15 16,10 5,21\"/></svg>','','both','',1,1,1,1,1,1,1,1,1,1,1,-1,5,1,-20,0,'',0,0,0,1,'',0,0,0,0,0,0,0,0,0,100,60,30,15,15,24,100,835,'basic','basic','_head.php','_tail.php','','','','','',4,202,150,125,100,1048576,1,1,0,105,0,0,0,0,0,'',2,0,'',0,0,'','','','','','','','','','','','','','','','','','','','',''),('pds','pds','자료실','<svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"><path d=\"M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z\"/><polyline points=\"14,2 14,8 20,8\"/></svg>','','both','',1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,'',0,0,0,1,'',0,0,0,0,0,0,0,0,0,100,60,30,15,15,24,100,835,'premium_pds','basic','_head.php','_tail.php','','','','','',4,202,150,125,100,1048576,1,1,0,110,3,0,0,0,0,'96',127,0,'',0,0,'','','','','','','','','','','','','','','','','','','','',''),('test','community','test',NULL,'','both','',1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,'',0,0,0,0,'',0,0,0,0,0,0,0,0,0,100,60,30,15,15,24,100,600,'basic','basic','_head.php','_tail.php','','','','','',4,202,150,125,100,1048576,1,1,0,1,6,0,0,0,0,'',2,0,'',0,0,'','','','','','','','','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_board` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_board_file`
--

DROP TABLE IF EXISTS `g5_board_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_board_file` (
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `wr_id` int NOT NULL DEFAULT '0',
  `bf_no` int NOT NULL DEFAULT '0',
  `bf_source` varchar(255) NOT NULL DEFAULT '',
  `bf_file` varchar(255) NOT NULL DEFAULT '',
  `bf_download` int NOT NULL,
  `bf_content` text NOT NULL,
  `bf_fileurl` varchar(255) NOT NULL DEFAULT '',
  `bf_thumburl` varchar(255) NOT NULL DEFAULT '',
  `bf_storage` varchar(50) NOT NULL DEFAULT '',
  `bf_filesize` int NOT NULL DEFAULT '0',
  `bf_width` int NOT NULL DEFAULT '0',
  `bf_height` smallint NOT NULL DEFAULT '0',
  `bf_type` tinyint NOT NULL DEFAULT '0',
  `bf_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`bo_table`,`wr_id`,`bf_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_board_file`
--

LOCK TABLES `g5_board_file` WRITE;
/*!40000 ALTER TABLE `g5_board_file` DISABLE KEYS */;
INSERT INTO `g5_board_file` VALUES ('free',105,0,'88.png','be40cd0cd01209b4a21423f85fe24611_MoUjqrJd_1901960777a0ed17327b3c5a5722a1cafc4d9b68.png',0,'','','','',40450,331,492,3,'2026-01-10 01:54:36'),('free',105,1,'2434.png','be40cd0cd01209b4a21423f85fe24611_U2RZXoMB_0a96aa3b09ba21f31bbf45eac806097483bde855.png',1,'','','','',201296,317,729,3,'2026-01-10 01:53:55'),('pds',112,0,'photo_2025-04-23_20-27-59.jpg','be40cd0cd01209b4a21423f85fe24611_SwqMhrUH_0e5eab65ce2a0bfeb69f25ad16d06a88226dbddd.jpg',0,'','','','',96923,1080,1073,2,'2026-01-10 07:45:53'),('pds',113,0,'photo_2025-04-23_20-08-08.jpg','be40cd0cd01209b4a21423f85fe24611_O7KTkDsX_ac432e37d2f1e521064c40fa813f7f2507cf1489.jpg',1,'','','','',54827,590,1280,2,'2026-01-10 08:09:04'),('pds',113,1,'photo_2025-04-23_20-27-59.jpg','be40cd0cd01209b4a21423f85fe24611_B6oDePyt_a7b1d42776ff979cba33e5cee39c06b823c0925a.jpg',0,'','','','',96923,1080,1073,2,'2026-01-10 08:09:04'),('pds',113,2,'photo_2025-04-24_16-10-35.jpg','be40cd0cd01209b4a21423f85fe24611_YFBO9NAw_61d0e3583f3eecbb9c2e2c657dc53afea280f0ff.jpg',0,'','','','',71545,481,762,2,'2026-01-10 08:09:04');
/*!40000 ALTER TABLE `g5_board_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_board_good`
--

DROP TABLE IF EXISTS `g5_board_good`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_board_good` (
  `bg_id` int NOT NULL AUTO_INCREMENT,
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `wr_id` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `bg_flag` varchar(255) NOT NULL DEFAULT '',
  `bg_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`bg_id`),
  UNIQUE KEY `fkey1` (`bo_table`,`wr_id`,`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_board_good`
--

LOCK TABLES `g5_board_good` WRITE;
/*!40000 ALTER TABLE `g5_board_good` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_board_good` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_board_new`
--

DROP TABLE IF EXISTS `g5_board_new`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_board_new` (
  `bn_id` int NOT NULL AUTO_INCREMENT,
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `wr_id` int NOT NULL DEFAULT '0',
  `wr_parent` int NOT NULL DEFAULT '0',
  `bn_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`bn_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=InnoDB AUTO_INCREMENT=338 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_board_new`
--

LOCK TABLES `g5_board_new` WRITE;
/*!40000 ALTER TABLE `g5_board_new` DISABLE KEYS */;
INSERT INTO `g5_board_new` VALUES (1,'free',1,1,'2026-01-10 00:37:39','admin'),(2,'free',2,2,'2026-01-10 00:37:39','admin'),(3,'free',3,3,'2026-01-10 00:37:39','admin'),(4,'free',4,4,'2026-01-10 00:37:39','admin'),(5,'free',5,5,'2026-01-10 00:37:39','admin'),(6,'free',6,6,'2026-01-10 00:37:39','admin'),(7,'free',7,7,'2026-01-10 00:37:39','admin'),(8,'free',8,8,'2026-01-10 00:37:39','admin'),(9,'free',9,9,'2026-01-10 00:37:39','admin'),(10,'free',10,10,'2026-01-10 00:37:39','admin'),(11,'free',11,11,'2026-01-10 00:37:39','admin'),(12,'free',12,12,'2026-01-10 00:37:39','admin'),(13,'free',13,13,'2026-01-10 00:37:39','admin'),(14,'free',14,14,'2026-01-10 00:37:39','admin'),(15,'free',15,15,'2026-01-10 00:37:39','admin'),(16,'free',16,16,'2026-01-10 00:37:39','admin'),(17,'free',17,17,'2026-01-10 00:37:39','admin'),(18,'free',18,18,'2026-01-10 00:37:39','admin'),(19,'free',19,19,'2026-01-10 00:37:39','admin'),(20,'free',20,20,'2026-01-10 00:37:39','admin'),(21,'free',21,21,'2025-12-22 11:37:20','admin'),(22,'free',22,22,'2025-12-22 09:37:20','admin'),(23,'free',23,23,'2025-12-21 09:37:20','admin'),(24,'free',24,24,'2025-12-20 09:37:20','admin'),(25,'free',25,25,'2025-12-19 12:37:20','admin'),(26,'free',26,26,'2025-12-18 15:37:20','admin'),(27,'free',27,27,'2025-12-16 20:37:20','admin'),(28,'free',28,28,'2025-12-16 02:37:20','admin'),(29,'free',29,29,'2025-12-14 19:37:20','admin'),(30,'free',30,30,'2025-12-14 10:37:20','admin'),(31,'free',31,31,'2025-12-12 19:37:20','admin'),(32,'free',32,32,'2025-12-12 21:37:20','admin'),(33,'free',33,33,'2025-12-11 21:37:20','admin'),(34,'free',34,34,'2025-12-10 18:37:20','admin'),(35,'free',35,35,'2025-12-10 06:37:20','admin'),(36,'free',36,36,'2025-12-09 01:37:20','admin'),(37,'free',37,37,'2025-12-08 11:37:20','admin'),(38,'free',38,38,'2025-12-07 15:37:20','admin'),(39,'free',39,39,'2025-12-05 18:37:20','admin'),(40,'free',40,40,'2025-12-05 09:37:20','admin'),(41,'free',41,41,'2025-12-04 15:37:20','admin'),(42,'free',42,42,'2025-12-04 06:37:20','admin'),(43,'free',43,43,'2025-12-02 23:37:20','admin'),(44,'free',44,44,'2025-12-02 15:37:20','admin'),(45,'free',45,45,'2025-11-30 20:37:20','admin'),(46,'free',46,46,'2025-11-30 07:37:20','admin'),(47,'free',47,47,'2025-11-28 22:37:20','admin'),(48,'free',48,48,'2025-11-28 07:37:20','admin'),(49,'free',49,49,'2025-11-26 22:37:20','admin'),(50,'free',50,50,'2025-11-26 05:37:20','admin'),(51,'free',51,51,'2025-11-24 18:37:20','admin'),(52,'free',52,52,'2025-11-25 08:37:20','admin'),(53,'free',53,53,'2025-11-24 04:37:20','admin'),(54,'free',54,54,'2025-11-23 00:37:20','admin'),(55,'free',55,55,'2025-11-22 11:37:20','admin'),(56,'free',56,56,'2025-11-21 14:37:20','admin'),(57,'free',57,57,'2025-11-20 08:37:20','admin'),(58,'free',58,58,'2025-11-19 05:37:20','admin'),(59,'free',59,59,'2025-11-18 05:37:20','admin'),(60,'free',60,60,'2025-11-16 20:37:20','admin'),(61,'free',61,61,'2025-11-16 03:37:20','admin'),(62,'free',62,62,'2025-11-15 21:37:20','admin'),(63,'free',63,63,'2025-11-15 12:37:20','admin'),(64,'free',64,64,'2025-11-13 22:37:20','admin'),(65,'free',65,65,'2025-11-13 01:37:20','admin'),(66,'free',66,66,'2025-11-11 16:37:20','admin'),(67,'free',67,67,'2025-11-11 08:37:20','admin'),(68,'free',68,68,'2025-11-10 12:37:20','admin'),(69,'free',69,69,'2025-11-08 16:37:20','admin'),(70,'free',70,70,'2025-11-08 05:37:20','admin'),(71,'free',71,71,'2025-11-07 02:37:20','admin'),(72,'free',72,72,'2025-11-07 11:37:20','admin'),(73,'free',73,73,'2025-11-05 21:37:20','admin'),(74,'free',74,74,'2025-11-04 21:37:20','admin'),(75,'free',75,75,'2025-11-04 09:37:20','admin'),(76,'free',76,76,'2025-11-03 13:37:20','admin'),(77,'free',77,77,'2025-11-02 14:37:20','admin'),(78,'free',78,78,'2025-11-01 01:37:20','admin'),(79,'free',79,79,'2025-10-31 09:37:20','admin'),(80,'free',80,80,'2025-10-29 22:37:20','admin'),(81,'free',81,81,'2025-10-29 08:37:20','admin'),(82,'free',82,82,'2025-10-28 19:37:20','admin'),(83,'free',83,83,'2025-10-28 11:37:20','admin'),(84,'free',84,84,'2025-10-27 08:37:20','admin'),(85,'free',85,85,'2025-10-26 00:37:20','admin'),(86,'free',86,86,'2025-10-25 11:37:20','admin'),(87,'free',87,87,'2025-10-24 15:37:20','admin'),(88,'free',88,88,'2025-10-23 01:37:20','admin'),(89,'free',89,89,'2025-10-22 14:37:20','admin'),(90,'free',90,90,'2025-10-20 20:37:20','admin'),(91,'free',91,91,'2025-10-20 06:37:20','admin'),(92,'free',92,92,'2025-10-19 16:37:20','admin'),(93,'free',93,93,'2025-10-19 07:37:20','admin'),(94,'free',94,94,'2025-10-18 08:37:20','admin'),(95,'free',95,95,'2025-10-17 05:37:20','admin'),(96,'free',96,96,'2025-10-16 10:37:20','admin'),(97,'free',97,97,'2025-10-15 10:37:20','admin'),(98,'free',98,98,'2025-10-13 23:37:20','admin'),(99,'free',99,99,'2025-10-12 23:37:20','admin'),(100,'free',100,100,'2025-10-12 00:37:20','admin'),(101,'gallery',1,1,'2026-01-10 00:37:39','admin'),(102,'gallery',2,2,'2026-01-10 00:37:39','admin'),(103,'gallery',3,3,'2026-01-10 00:37:39','admin'),(104,'gallery',4,4,'2026-01-10 00:37:39','admin'),(105,'gallery',5,5,'2026-01-10 00:37:39','admin'),(106,'gallery',6,6,'2026-01-10 00:37:39','admin'),(107,'gallery',7,7,'2026-01-10 00:37:39','admin'),(108,'gallery',8,8,'2026-01-10 00:37:39','admin'),(109,'gallery',9,9,'2026-01-10 00:37:39','admin'),(110,'gallery',10,10,'2026-01-10 00:37:39','admin'),(111,'gallery',11,11,'2026-01-10 00:37:39','admin'),(112,'gallery',12,12,'2026-01-10 00:37:39','admin'),(113,'gallery',13,13,'2026-01-10 00:37:39','admin'),(114,'gallery',14,14,'2026-01-10 00:37:39','admin'),(115,'gallery',15,15,'2026-01-10 00:37:39','admin'),(116,'gallery',16,16,'2025-12-27 13:37:21','admin'),(117,'gallery',17,17,'2025-12-26 11:37:21','admin'),(118,'gallery',18,18,'2025-12-25 11:37:21','admin'),(119,'gallery',19,19,'2025-12-23 21:37:21','admin'),(120,'gallery',20,20,'2025-12-22 17:37:21','admin'),(121,'gallery',21,21,'2025-12-21 23:37:21','admin'),(122,'gallery',22,22,'2025-12-21 22:37:21','admin'),(123,'gallery',23,23,'2025-12-21 00:37:21','admin'),(124,'gallery',24,24,'2025-12-20 02:37:21','admin'),(125,'gallery',25,25,'2025-12-19 06:37:21','admin'),(126,'gallery',26,26,'2025-12-17 16:37:21','admin'),(127,'gallery',27,27,'2025-12-16 23:37:21','admin'),(128,'gallery',28,28,'2025-12-16 08:37:21','admin'),(129,'gallery',29,29,'2025-12-15 04:37:21','admin'),(130,'gallery',30,30,'2025-12-13 21:37:21','admin'),(131,'gallery',31,31,'2025-12-13 01:37:21','admin'),(132,'gallery',32,32,'2025-12-13 02:37:21','admin'),(133,'gallery',33,33,'2025-12-11 16:37:21','admin'),(134,'gallery',34,34,'2025-12-11 00:37:21','admin'),(135,'gallery',35,35,'2025-12-10 08:37:21','admin'),(136,'gallery',36,36,'2025-12-09 03:37:21','admin'),(137,'gallery',37,37,'2025-12-08 03:37:21','admin'),(138,'gallery',38,38,'2025-12-07 10:37:21','admin'),(139,'gallery',39,39,'2025-12-06 12:37:21','admin'),(140,'gallery',40,40,'2025-12-04 21:37:21','admin'),(141,'gallery',41,41,'2025-12-04 10:37:21','admin'),(142,'gallery',42,42,'2025-12-03 17:37:21','admin'),(143,'gallery',43,43,'2025-12-03 02:37:21','admin'),(144,'gallery',44,44,'2025-12-01 23:37:21','admin'),(145,'gallery',45,45,'2025-12-01 05:37:21','admin'),(146,'gallery',46,46,'2025-11-29 20:37:21','admin'),(147,'gallery',47,47,'2025-11-29 03:37:21','admin'),(148,'gallery',48,48,'2025-11-28 09:37:21','admin'),(149,'gallery',49,49,'2025-11-26 16:37:21','admin'),(150,'gallery',50,50,'2025-11-26 12:37:21','admin'),(151,'gallery',51,51,'2025-11-24 21:37:21','admin'),(152,'gallery',52,52,'2025-11-24 22:37:21','admin'),(153,'gallery',53,53,'2025-11-23 17:37:21','admin'),(154,'gallery',54,54,'2025-11-23 11:37:21','admin'),(155,'gallery',55,55,'2025-11-21 20:37:21','admin'),(156,'gallery',56,56,'2025-11-20 16:37:21','admin'),(157,'gallery',57,57,'2025-11-20 02:37:21','admin'),(158,'gallery',58,58,'2025-11-19 03:37:21','admin'),(159,'gallery',59,59,'2025-11-17 20:37:21','admin'),(160,'gallery',60,60,'2025-11-16 18:37:21','admin'),(161,'gallery',61,61,'2025-11-16 02:37:21','admin'),(162,'gallery',62,62,'2025-11-16 04:37:21','admin'),(163,'gallery',63,63,'2025-11-15 15:37:21','admin'),(164,'gallery',64,64,'2025-11-14 11:37:21','admin'),(165,'gallery',65,65,'2025-11-13 02:37:21','admin'),(166,'gallery',66,66,'2025-11-12 02:37:21','admin'),(167,'gallery',67,67,'2025-11-11 08:37:21','admin'),(168,'gallery',68,68,'2025-11-10 10:37:21','admin'),(169,'gallery',69,69,'2025-11-09 11:37:21','admin'),(170,'gallery',70,70,'2025-11-08 15:37:21','admin'),(171,'gallery',71,71,'2025-11-07 01:37:21','admin'),(172,'gallery',72,72,'2025-11-07 08:37:21','admin'),(173,'gallery',73,73,'2025-11-05 22:37:21','admin'),(174,'gallery',74,74,'2025-11-05 05:37:21','admin'),(175,'gallery',75,75,'2025-11-03 21:37:21','admin'),(176,'gallery',76,76,'2025-11-02 22:37:21','admin'),(177,'gallery',77,77,'2025-11-01 18:37:21','admin'),(178,'gallery',78,78,'2025-11-01 01:37:21','admin'),(179,'gallery',79,79,'2025-10-31 12:37:21','admin'),(180,'gallery',80,80,'2025-10-30 06:37:21','admin'),(181,'gallery',81,81,'2025-10-29 15:37:21','admin'),(182,'gallery',82,82,'2025-10-29 04:37:21','admin'),(183,'gallery',83,83,'2025-10-27 21:37:21','admin'),(184,'gallery',84,84,'2025-10-27 02:37:21','admin'),(185,'gallery',85,85,'2025-10-26 14:37:21','admin'),(186,'gallery',86,86,'2025-10-24 20:37:21','admin'),(187,'gallery',87,87,'2025-10-23 22:37:21','admin'),(188,'gallery',88,88,'2025-10-23 07:37:21','admin'),(189,'gallery',89,89,'2025-10-22 10:37:21','admin'),(190,'gallery',90,90,'2025-10-21 12:37:21','admin'),(191,'gallery',91,91,'2025-10-20 00:37:21','admin'),(192,'gallery',92,92,'2025-10-20 14:37:21','admin'),(193,'gallery',93,93,'2025-10-19 03:37:21','admin'),(194,'gallery',94,94,'2025-10-18 12:37:21','admin'),(195,'gallery',95,95,'2025-10-17 11:37:21','admin'),(196,'gallery',96,96,'2025-10-16 05:37:21','admin'),(197,'gallery',97,97,'2025-10-15 02:37:21','admin'),(198,'gallery',98,98,'2025-10-13 18:37:21','admin'),(199,'gallery',99,99,'2025-10-13 00:37:21','admin'),(200,'gallery',100,100,'2025-10-12 15:37:21','admin'),(201,'pds',1,1,'2026-01-10 00:37:39','admin'),(202,'pds',2,2,'2026-01-10 00:37:39','admin'),(203,'pds',3,3,'2026-01-10 00:37:39','admin'),(204,'pds',4,4,'2026-01-10 00:37:39','admin'),(205,'pds',5,5,'2026-01-10 00:37:39','admin'),(206,'pds',6,6,'2026-01-10 00:37:39','admin'),(207,'pds',7,7,'2026-01-10 00:37:39','admin'),(208,'pds',8,8,'2026-01-10 00:37:39','admin'),(209,'pds',9,9,'2026-01-10 00:37:39','admin'),(210,'pds',10,10,'2026-01-10 00:37:39','admin'),(211,'pds',11,11,'2025-12-31 07:37:21','admin'),(212,'pds',12,12,'2025-12-31 06:37:21','admin'),(213,'pds',13,13,'2025-12-30 08:37:21','admin'),(214,'pds',14,14,'2025-12-28 17:37:21','admin'),(215,'pds',15,15,'2025-12-28 05:37:21','admin'),(216,'pds',16,16,'2025-12-27 04:37:21','admin'),(217,'pds',17,17,'2025-12-26 07:37:21','admin'),(218,'pds',18,18,'2025-12-25 14:37:21','admin'),(219,'pds',19,19,'2025-12-24 12:37:21','admin'),(220,'pds',20,20,'2025-12-23 12:37:21','admin'),(221,'pds',21,21,'2025-12-22 00:37:21','admin'),(222,'pds',22,22,'2025-12-22 00:37:21','admin'),(223,'pds',23,23,'2025-12-20 20:37:21','admin'),(224,'pds',24,24,'2025-12-19 23:37:21','admin'),(225,'pds',25,25,'2025-12-19 02:37:21','admin'),(226,'pds',26,26,'2025-12-18 11:37:21','admin'),(227,'pds',27,27,'2025-12-16 16:37:21','admin'),(228,'pds',28,28,'2025-12-15 22:37:22','admin'),(229,'pds',29,29,'2025-12-14 23:37:22','admin'),(230,'pds',30,30,'2025-12-14 13:37:22','admin'),(231,'pds',31,31,'2025-12-13 09:37:22','admin'),(232,'pds',32,32,'2025-12-13 10:37:22','admin'),(233,'pds',33,33,'2025-12-11 23:37:22','admin'),(234,'pds',34,34,'2025-12-11 07:37:22','admin'),(235,'pds',35,35,'2025-12-09 22:37:22','admin'),(236,'pds',36,36,'2025-12-09 02:37:22','admin'),(237,'pds',37,37,'2025-12-08 06:37:22','admin'),(238,'pds',38,38,'2025-12-07 01:37:22','admin'),(239,'pds',39,39,'2025-12-06 00:37:22','admin'),(240,'pds',40,40,'2025-12-04 18:37:22','admin'),(241,'pds',41,41,'2025-12-04 05:37:22','admin'),(242,'pds',42,42,'2025-12-04 10:37:22','admin'),(243,'pds',43,43,'2025-12-03 08:37:22','admin'),(244,'pds',44,44,'2025-12-02 07:37:22','admin'),(245,'pds',45,45,'2025-12-01 08:37:22','admin'),(246,'pds',46,46,'2025-11-30 15:37:22','admin'),(247,'pds',47,47,'2025-11-29 10:37:22','admin'),(248,'pds',48,48,'2025-11-27 20:37:22','admin'),(249,'pds',49,49,'2025-11-26 19:37:22','admin'),(250,'pds',50,50,'2025-11-25 16:37:22','admin'),(251,'pds',51,51,'2025-11-25 09:37:22','admin'),(252,'pds',52,52,'2025-11-24 18:37:22','admin'),(253,'pds',53,53,'2025-11-24 01:37:22','admin'),(254,'pds',54,54,'2025-11-22 19:37:22','admin'),(255,'pds',55,55,'2025-11-21 20:37:22','admin'),(256,'pds',56,56,'2025-11-20 16:37:22','admin'),(257,'pds',57,57,'2025-11-20 08:37:22','admin'),(258,'pds',58,58,'2025-11-19 11:37:22','admin'),(259,'pds',59,59,'2025-11-18 01:37:22','admin'),(260,'pds',60,60,'2025-11-16 19:37:22','admin'),(261,'pds',61,61,'2025-11-16 03:37:22','admin'),(262,'pds',62,62,'2025-11-16 08:37:22','admin'),(263,'pds',63,63,'2025-11-15 08:37:22','admin'),(264,'pds',64,64,'2025-11-14 05:37:22','admin'),(265,'pds',65,65,'2025-11-13 02:37:22','admin'),(266,'pds',66,66,'2025-11-12 02:37:22','admin'),(267,'pds',67,67,'2025-11-11 03:37:22','admin'),(268,'pds',68,68,'2025-11-10 00:37:22','admin'),(269,'pds',69,69,'2025-11-08 21:37:22','admin'),(270,'pds',70,70,'2025-11-07 17:37:22','admin'),(271,'pds',71,71,'2025-11-06 19:37:22','admin'),(272,'pds',72,72,'2025-11-06 19:37:22','admin'),(273,'pds',73,73,'2025-11-05 20:37:22','admin'),(274,'pds',74,74,'2025-11-05 03:37:22','admin'),(275,'pds',75,75,'2025-11-04 07:37:22','admin'),(276,'pds',76,76,'2025-11-02 20:37:22','admin'),(277,'pds',77,77,'2025-11-02 09:37:22','admin'),(278,'pds',78,78,'2025-10-31 18:37:22','admin'),(279,'pds',79,79,'2025-10-31 14:37:22','admin'),(280,'pds',80,80,'2025-10-30 08:37:22','admin'),(281,'pds',81,81,'2025-10-29 00:37:22','admin'),(282,'pds',82,82,'2025-10-29 04:37:22','admin'),(283,'pds',83,83,'2025-10-28 00:37:22','admin'),(284,'pds',84,84,'2025-10-26 17:37:22','admin'),(285,'pds',85,85,'2025-10-26 09:37:22','admin'),(286,'pds',86,86,'2025-10-24 23:37:22','admin'),(287,'pds',87,87,'2025-10-23 21:37:22','admin'),(288,'pds',88,88,'2025-10-22 21:37:22','admin'),(289,'pds',89,89,'2025-10-22 08:37:22','admin'),(290,'pds',90,90,'2025-10-21 06:37:22','admin'),(291,'pds',91,91,'2025-10-20 00:37:22','admin'),(292,'pds',92,92,'2025-10-20 15:37:22','admin'),(293,'pds',93,93,'2025-10-19 11:37:22','admin'),(294,'pds',94,94,'2025-10-18 08:37:22','admin'),(295,'pds',95,95,'2025-10-16 19:37:22','admin'),(296,'pds',96,96,'2025-10-16 15:37:22','admin'),(297,'pds',97,97,'2025-10-15 02:37:22','admin'),(298,'pds',98,98,'2025-10-13 17:37:22','admin'),(299,'pds',99,99,'2025-10-12 19:37:22','admin'),(300,'pds',100,100,'2025-10-12 05:37:22','admin'),(301,'free',101,101,'2026-01-10 00:49:45','admin'),(302,'free',102,102,'2026-01-10 00:56:45','admin'),(303,'free',103,103,'2026-01-10 01:00:34','admin'),(304,'free',104,104,'2026-01-10 01:23:58','admin'),(305,'free',105,105,'2026-01-10 01:53:55','admin'),(306,'gallery',101,101,'2026-01-10 04:39:51','admin'),(307,'gallery',102,102,'2026-01-10 04:44:52','admin'),(308,'test',1,1,'2026-01-10 04:50:44','admin'),(309,'test',2,1,'2026-01-10 04:55:50','admin'),(310,'test',3,1,'2026-01-10 04:55:54','admin'),(311,'test',4,1,'2026-01-10 04:56:16','admin'),(312,'test',5,1,'2026-01-10 04:56:23','admin'),(313,'free',106,92,'2026-01-10 04:58:08','admin'),(314,'test',6,1,'2026-01-10 05:00:49','admin'),(315,'test',7,1,'2026-01-10 05:00:52','admin'),(316,'free',107,105,'2026-01-10 05:19:08','admin'),(317,'free',108,105,'2026-01-10 05:19:23','admin'),(318,'free',109,105,'2026-01-10 05:19:29','admin'),(319,'free',110,105,'2026-01-10 05:19:34','admin'),(320,'pds',101,100,'2026-01-10 05:20:08','admin'),(321,'pds',102,100,'2026-01-10 05:20:12','admin'),(322,'pds',103,100,'2026-01-10 05:21:04','admin'),(323,'pds',104,104,'2026-01-10 06:29:00','admin'),(324,'pds',105,105,'2026-01-10 06:37:17','admin'),(325,'gallery',103,103,'2026-01-10 06:37:51','admin'),(326,'pds',106,106,'2026-01-10 06:38:03','admin'),(327,'free',111,111,'2026-01-10 06:40:28','admin'),(328,'gallery',104,104,'2026-01-10 06:41:15','admin'),(329,'gallery',105,105,'2026-01-10 06:41:32','admin'),(330,'pds',107,107,'2026-01-10 07:05:51','admin'),(331,'pds',108,108,'2026-01-10 07:06:20','admin'),(332,'pds',109,109,'2026-01-10 07:16:07','admin'),(333,'pds',110,110,'2026-01-10 07:17:27','admin'),(334,'free',112,112,'2026-01-10 07:18:36','admin'),(335,'pds',111,111,'2026-01-10 07:43:54','admin'),(336,'pds',112,112,'2026-01-10 07:45:53','admin'),(337,'pds',113,113,'2026-01-10 08:09:04','admin');
/*!40000 ALTER TABLE `g5_board_new` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_cash`
--

DROP TABLE IF EXISTS `g5_cash`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_cash` (
  `ca_id` int NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `ca_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ca_content` varchar(255) NOT NULL DEFAULT '',
  `ca_cash` int NOT NULL DEFAULT '0',
  `ca_use_cash` int NOT NULL DEFAULT '0',
  `ca_expired` tinyint NOT NULL DEFAULT '0',
  `ca_expire_date` date NOT NULL DEFAULT '0000-00-00',
  `ca_mb_cash` int NOT NULL DEFAULT '0',
  `ca_rel_table` varchar(20) NOT NULL DEFAULT '',
  `ca_rel_id` varchar(20) NOT NULL DEFAULT '',
  `ca_rel_action` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`ca_id`),
  KEY `index1` (`mb_id`,`ca_rel_table`,`ca_rel_id`,`ca_rel_action`),
  KEY `index2` (`mb_id`,`ca_expired`,`ca_expire_date`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_cash`
--

LOCK TABLES `g5_cash` WRITE;
/*!40000 ALTER TABLE `g5_cash` DISABLE KEYS */;
INSERT INTO `g5_cash` VALUES (1,'admin','2026-01-09 23:45:53','테스트 캐시 지급',50000,0,0,'0000-00-00',50000,'@passive','admin','admin-696114a11445a');
/*!40000 ALTER TABLE `g5_cash` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_cert_history`
--

DROP TABLE IF EXISTS `g5_cert_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_cert_history` (
  `cr_id` int NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `cr_company` varchar(255) NOT NULL DEFAULT '',
  `cr_method` varchar(255) NOT NULL DEFAULT '',
  `cr_ip` varchar(255) NOT NULL DEFAULT '',
  `cr_date` date NOT NULL DEFAULT '0000-00-00',
  `cr_time` time NOT NULL DEFAULT '00:00:00',
  PRIMARY KEY (`cr_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_cert_history`
--

LOCK TABLES `g5_cert_history` WRITE;
/*!40000 ALTER TABLE `g5_cert_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_cert_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_config`
--

DROP TABLE IF EXISTS `g5_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_config` (
  `cf_id` int NOT NULL AUTO_INCREMENT,
  `cf_title` varchar(255) NOT NULL DEFAULT '',
  `cf_theme` varchar(100) NOT NULL DEFAULT '',
  `cf_admin` varchar(100) NOT NULL DEFAULT '',
  `cf_admin_email` varchar(100) NOT NULL DEFAULT '',
  `cf_admin_email_name` varchar(100) NOT NULL DEFAULT '',
  `cf_add_script` text NOT NULL,
  `cf_use_point` tinyint NOT NULL DEFAULT '0',
  `cf_point_term` int NOT NULL DEFAULT '0',
  `cf_use_copy_log` tinyint NOT NULL DEFAULT '0',
  `cf_use_email_certify` tinyint NOT NULL DEFAULT '0',
  `cf_login_point` int NOT NULL DEFAULT '0',
  `cf_cut_name` tinyint NOT NULL DEFAULT '0',
  `cf_nick_modify` int NOT NULL DEFAULT '0',
  `cf_new_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_new_rows` int NOT NULL DEFAULT '0',
  `cf_search_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_connect_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_faq_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_read_point` int NOT NULL DEFAULT '0',
  `cf_write_point` int NOT NULL DEFAULT '0',
  `cf_comment_point` int NOT NULL DEFAULT '0',
  `cf_download_point` int NOT NULL DEFAULT '0',
  `cf_write_pages` int NOT NULL DEFAULT '0',
  `cf_mobile_pages` int NOT NULL DEFAULT '0',
  `cf_link_target` varchar(50) NOT NULL DEFAULT '',
  `cf_bbs_rewrite` tinyint NOT NULL DEFAULT '0',
  `cf_delay_sec` int NOT NULL DEFAULT '0',
  `cf_filter` text NOT NULL,
  `cf_possible_ip` text NOT NULL,
  `cf_intercept_ip` text NOT NULL,
  `cf_analytics` text NOT NULL,
  `cf_add_meta` text NOT NULL,
  `cf_syndi_token` varchar(255) NOT NULL,
  `cf_syndi_except` text NOT NULL,
  `cf_member_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_use_homepage` tinyint NOT NULL DEFAULT '0',
  `cf_req_homepage` tinyint NOT NULL DEFAULT '0',
  `cf_use_tel` tinyint NOT NULL DEFAULT '0',
  `cf_req_tel` tinyint NOT NULL DEFAULT '0',
  `cf_use_hp` tinyint NOT NULL DEFAULT '0',
  `cf_req_hp` tinyint NOT NULL DEFAULT '0',
  `cf_use_addr` tinyint NOT NULL DEFAULT '0',
  `cf_req_addr` tinyint NOT NULL DEFAULT '0',
  `cf_use_signature` tinyint NOT NULL DEFAULT '0',
  `cf_req_signature` tinyint NOT NULL DEFAULT '0',
  `cf_use_profile` tinyint NOT NULL DEFAULT '0',
  `cf_req_profile` tinyint NOT NULL DEFAULT '0',
  `cf_register_level` tinyint NOT NULL DEFAULT '0',
  `cf_register_point` int NOT NULL DEFAULT '0',
  `cf_icon_level` tinyint NOT NULL DEFAULT '0',
  `cf_use_recommend` tinyint NOT NULL DEFAULT '0',
  `cf_recommend_point` int NOT NULL DEFAULT '0',
  `cf_leave_day` int NOT NULL DEFAULT '0',
  `cf_search_part` int NOT NULL DEFAULT '0',
  `cf_email_use` tinyint NOT NULL DEFAULT '0',
  `cf_email_wr_super_admin` tinyint NOT NULL DEFAULT '0',
  `cf_email_wr_group_admin` tinyint NOT NULL DEFAULT '0',
  `cf_email_wr_board_admin` tinyint NOT NULL DEFAULT '0',
  `cf_email_wr_write` tinyint NOT NULL DEFAULT '0',
  `cf_email_wr_comment_all` tinyint NOT NULL DEFAULT '0',
  `cf_email_mb_super_admin` tinyint NOT NULL DEFAULT '0',
  `cf_email_mb_member` tinyint NOT NULL DEFAULT '0',
  `cf_email_po_super_admin` tinyint NOT NULL DEFAULT '0',
  `cf_prohibit_id` text NOT NULL,
  `cf_prohibit_email` text NOT NULL,
  `cf_new_del` int NOT NULL DEFAULT '0',
  `cf_memo_del` int NOT NULL DEFAULT '0',
  `cf_visit_del` int NOT NULL DEFAULT '0',
  `cf_popular_del` int NOT NULL DEFAULT '0',
  `cf_optimize_date` date NOT NULL DEFAULT '0000-00-00',
  `cf_use_member_icon` tinyint NOT NULL DEFAULT '0',
  `cf_member_icon_size` int NOT NULL DEFAULT '0',
  `cf_member_icon_width` int NOT NULL DEFAULT '0',
  `cf_member_icon_height` int NOT NULL DEFAULT '0',
  `cf_member_img_size` int NOT NULL DEFAULT '0',
  `cf_member_img_width` int NOT NULL DEFAULT '0',
  `cf_member_img_height` int NOT NULL DEFAULT '0',
  `cf_login_minutes` int NOT NULL DEFAULT '0',
  `cf_image_extension` varchar(255) NOT NULL DEFAULT '',
  `cf_flash_extension` varchar(255) NOT NULL DEFAULT '',
  `cf_movie_extension` varchar(255) NOT NULL DEFAULT '',
  `cf_formmail_is_member` tinyint NOT NULL DEFAULT '0',
  `cf_page_rows` int NOT NULL DEFAULT '0',
  `cf_mobile_page_rows` int NOT NULL DEFAULT '0',
  `cf_visit` varchar(255) NOT NULL DEFAULT '',
  `cf_max_po_id` int NOT NULL DEFAULT '0',
  `cf_stipulation` text NOT NULL,
  `cf_privacy` text NOT NULL,
  `cf_use_promotion` tinyint(1) NOT NULL DEFAULT '0',
  `cf_open_modify` int NOT NULL DEFAULT '0',
  `cf_memo_send_point` int NOT NULL DEFAULT '0',
  `cf_mobile_new_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_mobile_search_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_mobile_connect_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_mobile_faq_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_mobile_member_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_captcha_mp3` varchar(255) NOT NULL DEFAULT '',
  `cf_editor` varchar(50) NOT NULL DEFAULT '',
  `cf_cert_use` tinyint NOT NULL DEFAULT '0',
  `cf_cert_find` tinyint NOT NULL DEFAULT '0',
  `cf_cert_ipin` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_hp` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_simple` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_kg_cd` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_kg_mid` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_use_seed` tinyint NOT NULL DEFAULT '1',
  `cf_cert_kcb_cd` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_kcp_cd` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_kcp_enckey` varchar(100) NOT NULL DEFAULT '',
  `cf_lg_mid` varchar(100) NOT NULL DEFAULT '',
  `cf_lg_mert_key` varchar(100) NOT NULL DEFAULT '',
  `cf_toss_client_key` varchar(100) NOT NULL DEFAULT '',
  `cf_toss_secret_key` varchar(100) NOT NULL DEFAULT '',
  `cf_cert_limit` int NOT NULL DEFAULT '0',
  `cf_cert_req` tinyint NOT NULL DEFAULT '0',
  `cf_sms_use` varchar(255) NOT NULL DEFAULT '',
  `cf_sms_type` varchar(10) NOT NULL DEFAULT '',
  `cf_icode_id` varchar(255) NOT NULL DEFAULT '',
  `cf_icode_pw` varchar(255) NOT NULL DEFAULT '',
  `cf_icode_server_ip` varchar(50) NOT NULL DEFAULT '',
  `cf_icode_server_port` varchar(50) NOT NULL DEFAULT '',
  `cf_icode_token_key` varchar(100) NOT NULL DEFAULT '',
  `cf_googl_shorturl_apikey` varchar(50) NOT NULL DEFAULT '',
  `cf_social_login_use` tinyint NOT NULL DEFAULT '0',
  `cf_social_servicelist` varchar(255) NOT NULL DEFAULT '',
  `cf_payco_clientid` varchar(100) NOT NULL DEFAULT '',
  `cf_payco_secret` varchar(100) NOT NULL DEFAULT '',
  `cf_facebook_appid` varchar(100) NOT NULL,
  `cf_facebook_secret` varchar(100) NOT NULL,
  `cf_twitter_key` varchar(100) NOT NULL,
  `cf_twitter_secret` varchar(100) NOT NULL,
  `cf_google_clientid` varchar(100) NOT NULL DEFAULT '',
  `cf_google_secret` varchar(100) NOT NULL DEFAULT '',
  `cf_naver_clientid` varchar(100) NOT NULL DEFAULT '',
  `cf_naver_secret` varchar(100) NOT NULL DEFAULT '',
  `cf_kakao_rest_key` varchar(100) NOT NULL DEFAULT '',
  `cf_kakao_client_secret` varchar(100) NOT NULL DEFAULT '',
  `cf_kakao_js_apikey` varchar(100) NOT NULL,
  `cf_captcha` varchar(100) NOT NULL DEFAULT '',
  `cf_recaptcha_site_key` varchar(100) NOT NULL DEFAULT '',
  `cf_recaptcha_secret_key` varchar(100) NOT NULL DEFAULT '',
  `cf_1_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_2_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_3_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_4_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_5_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_6_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_7_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_8_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_9_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_10_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_1` varchar(255) NOT NULL DEFAULT '',
  `cf_2` varchar(255) NOT NULL DEFAULT '',
  `cf_3` varchar(255) NOT NULL DEFAULT '',
  `cf_4` varchar(255) NOT NULL DEFAULT '',
  `cf_5` varchar(255) NOT NULL DEFAULT '',
  `cf_6` varchar(255) NOT NULL DEFAULT '',
  `cf_7` varchar(255) NOT NULL DEFAULT '',
  `cf_8` varchar(255) NOT NULL DEFAULT '',
  `cf_9` varchar(255) NOT NULL DEFAULT '',
  `cf_10` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`cf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_config`
--

LOCK TABLES `g5_config` WRITE;
/*!40000 ALTER TABLE `g5_config` DISABLE KEYS */;
INSERT INTO `g5_config` VALUES (1,'그누보드5','premium','admin','admin@domain.com','그누보드5','',1,0,1,0,100,15,60,'basic',15,'premium','basic','basic',0,0,0,0,10,5,'_blank',0,30,'18아,18놈,18새끼,18뇬,18노,18것,18넘,개년,개놈,개뇬,개새,개색끼,개세끼,개세이,개쉐이,개쉑,개쉽,개시키,개자식,개좆,게색기,게색끼,광뇬,뇬,눈깔,뉘미럴,니귀미,니기미,니미,도촬,되질래,뒈져라,뒈진다,디져라,디진다,디질래,병쉰,병신,뻐큐,뻑큐,뽁큐,삐리넷,새꺄,쉬발,쉬밸,쉬팔,쉽알,스패킹,스팽,시벌,시부랄,시부럴,시부리,시불,시브랄,시팍,시팔,시펄,실밸,십8,십쌔,십창,싶알,쌉년,썅놈,쌔끼,쌩쑈,썅,써벌,썩을년,쎄꺄,쎄엑,쓰바,쓰발,쓰벌,쓰팔,씨8,씨댕,씨바,씨발,씨뱅,씨봉알,씨부랄,씨부럴,씨부렁,씨부리,씨불,씨브랄,씨빠,씨빨,씨뽀랄,씨팍,씨팔,씨펄,씹,아가리,아갈이,엄창,접년,잡놈,재랄,저주글,조까,조빠,조쟁이,조지냐,조진다,조질래,존나,존니,좀물,좁년,좃,좆,좇,쥐랄,쥐롤,쥬디,지랄,지럴,지롤,지미랄,쫍빱,凸,퍽큐,뻑큐,빠큐,ㅅㅂㄹㅁ','','','','','','','basic',0,0,0,0,0,0,0,0,0,0,0,0,2,1000,2,0,0,30,10000,1,0,0,0,0,0,0,0,0,'admin,administrator,관리자,운영자,어드민,주인장,webmaster,웹마스터,sysop,시삽,시샵,manager,매니저,메니저,root,루트,su,guest,방문객','',30,180,180,180,'2026-01-10',2,5000,22,22,50000,60,60,10,'gif|jpg|jpeg|png|webp','swf','asx|asf|wmv|wma|mpg|mpeg|mov|avi|mp3',1,15,15,'오늘:2,어제:10,최대:10,전체:12',0,'해당 홈페이지에 맞는 회원가입약관을 입력합니다.','해당 홈페이지에 맞는 개인정보처리방침을 입력합니다.',0,0,500,'basic','basic','basic','basic','basic','basic','smarteditor2',0,0,'','','','','',1,'','','','','','','',2,0,'','','','','211.172.232.124','7295','','',0,'','','','','','','','','','','','','','','kcaptcha','','','','','','','','','','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_content`
--

DROP TABLE IF EXISTS `g5_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_content` (
  `co_id` varchar(20) NOT NULL DEFAULT '',
  `co_html` tinyint NOT NULL DEFAULT '0',
  `co_subject` varchar(255) NOT NULL DEFAULT '',
  `co_content` longtext NOT NULL,
  `co_seo_title` varchar(255) NOT NULL DEFAULT '',
  `co_mobile_content` longtext NOT NULL,
  `co_skin` varchar(255) NOT NULL DEFAULT '',
  `co_mobile_skin` varchar(255) NOT NULL DEFAULT '',
  `co_tag_filter_use` tinyint NOT NULL DEFAULT '0',
  `co_hit` int NOT NULL DEFAULT '0',
  `co_include_head` varchar(255) NOT NULL,
  `co_include_tail` varchar(255) NOT NULL,
  PRIMARY KEY (`co_id`),
  KEY `co_seo_title` (`co_seo_title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_content`
--

LOCK TABLES `g5_content` WRITE;
/*!40000 ALTER TABLE `g5_content` DISABLE KEYS */;
INSERT INTO `g5_content` VALUES ('company',1,'회사소개','<p align=center><b>회사소개에 대한 내용을 입력하십시오.</b></p>','','','basic','basic',0,0,'',''),('privacy',1,'개인정보 처리방침','<p align=center><b>개인정보 처리방침에 대한 내용을 입력하십시오.</b></p>','','','basic','basic',0,0,'',''),('provision',1,'서비스 이용약관','<p align=center><b>서비스 이용약관에 대한 내용을 입력하십시오.</b></p>','','','basic','basic',0,0,'','');
/*!40000 ALTER TABLE `g5_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_faq`
--

DROP TABLE IF EXISTS `g5_faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_faq` (
  `fa_id` int NOT NULL AUTO_INCREMENT,
  `fm_id` int NOT NULL DEFAULT '0',
  `fa_subject` text NOT NULL,
  `fa_content` text NOT NULL,
  `fa_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`fa_id`),
  KEY `fm_id` (`fm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_faq`
--

LOCK TABLES `g5_faq` WRITE;
/*!40000 ALTER TABLE `g5_faq` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_faq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_faq_master`
--

DROP TABLE IF EXISTS `g5_faq_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_faq_master` (
  `fm_id` int NOT NULL AUTO_INCREMENT,
  `fm_subject` varchar(255) NOT NULL DEFAULT '',
  `fm_head_html` text NOT NULL,
  `fm_tail_html` text NOT NULL,
  `fm_mobile_head_html` text NOT NULL,
  `fm_mobile_tail_html` text NOT NULL,
  `fm_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`fm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_faq_master`
--

LOCK TABLES `g5_faq_master` WRITE;
/*!40000 ALTER TABLE `g5_faq_master` DISABLE KEYS */;
INSERT INTO `g5_faq_master` VALUES (1,'자주하시는 질문','','','','',0);
/*!40000 ALTER TABLE `g5_faq_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_group`
--

DROP TABLE IF EXISTS `g5_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_group` (
  `gr_id` varchar(10) NOT NULL DEFAULT '',
  `gr_subject` varchar(255) NOT NULL DEFAULT '',
  `gr_icon` text,
  `gr_device` enum('both','pc','mobile') NOT NULL DEFAULT 'both',
  `gr_admin` varchar(255) NOT NULL DEFAULT '',
  `gr_use_access` tinyint NOT NULL DEFAULT '0',
  `gr_order` int NOT NULL DEFAULT '0',
  `gr_1_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_2_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_3_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_4_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_5_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_6_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_7_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_8_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_9_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_10_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_1` varchar(255) NOT NULL DEFAULT '',
  `gr_2` varchar(255) NOT NULL DEFAULT '',
  `gr_3` varchar(255) NOT NULL DEFAULT '',
  `gr_4` varchar(255) NOT NULL DEFAULT '',
  `gr_5` varchar(255) NOT NULL DEFAULT '',
  `gr_6` varchar(255) NOT NULL DEFAULT '',
  `gr_7` varchar(255) NOT NULL DEFAULT '',
  `gr_8` varchar(255) NOT NULL DEFAULT '',
  `gr_9` varchar(255) NOT NULL DEFAULT '',
  `gr_10` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`gr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_group`
--

LOCK TABLES `g5_group` WRITE;
/*!40000 ALTER TABLE `g5_group` DISABLE KEYS */;
INSERT INTO `g5_group` VALUES ('community','자유게시판','<svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"><path d=\"M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z\"/></svg>','both','',0,0,'','','','','','','','','','','','','','','','','','','',''),('gallery','갤러리','<svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"><rect x=\"3\" y=\"3\" width=\"18\" height=\"18\" rx=\"2\" ry=\"2\"/><circle cx=\"8.5\" cy=\"8.5\" r=\"1.5\"/><polyline points=\"21,15 16,10 5,21\"/></svg>','both','',0,2,'','','','','','','','','','','','','','','','','','','',''),('pds','자료실','<svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"><path d=\"M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z\"/><polyline points=\"14,2 14,8 20,8\"/></svg>','both','',0,3,'','','','','','','','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_group_member`
--

DROP TABLE IF EXISTS `g5_group_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_group_member` (
  `gm_id` int NOT NULL AUTO_INCREMENT,
  `gr_id` varchar(255) NOT NULL DEFAULT '',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `gm_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`gm_id`),
  KEY `gr_id` (`gr_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_group_member`
--

LOCK TABLES `g5_group_member` WRITE;
/*!40000 ALTER TABLE `g5_group_member` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_group_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_level`
--

DROP TABLE IF EXISTS `g5_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_level` (
  `lv_level` int NOT NULL,
  `lv_name` varchar(50) NOT NULL DEFAULT '',
  `lv_point` int NOT NULL DEFAULT '0',
  `lv_icon` varchar(255) NOT NULL DEFAULT '',
  `lv_color` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`lv_level`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_level`
--

LOCK TABLES `g5_level` WRITE;
/*!40000 ALTER TABLE `g5_level` DISABLE KEYS */;
INSERT INTO `g5_level` VALUES (1,'뉴비',0,'','#9ca3af'),(2,'초보',100,'','#9ca3af'),(3,'입문',300,'','#9ca3af'),(4,'초급',600,'','#6b7280'),(5,'하급',1000,'','#6b7280'),(6,'중하급',2000,'','#6b7280'),(7,'중급',4000,'','#3b82f6'),(8,'중상급',7000,'','#3b82f6'),(9,'상급',12000,'','#3b82f6'),(10,'고급',20000,'','#8b5cf6'),(11,'숙련',35000,'','#8b5cf6'),(12,'전문가',55000,'','#8b5cf6'),(13,'베테랑',80000,'','#f59e0b'),(14,'엘리트',120000,'','#f59e0b'),(15,'마스터',180000,'','#f59e0b'),(16,'그랜드마스터',260000,'','#ef4444'),(17,'챌린저',360000,'','#ef4444'),(18,'레전드',500000,'','#ef4444'),(19,'히어로',700000,'','#ec4899'),(20,'슈퍼히어로',1000000,'','#ec4899'),(21,'프리미엄',1500000,'','#d4af37'),(22,'VIP',2200000,'','#d4af37'),(23,'VVIP',3200000,'','#d4af37'),(24,'다이아몬드',4500000,'','#06b6d4'),(25,'로얄',6500000,'','#06b6d4'),(26,'임페리얼',9000000,'','#7c3aed'),(27,'갓',13000000,'','#7c3aed'),(28,'신화',18000000,'','#dc2626'),(29,'전설',25000000,'','#dc2626'),(30,'불멸',35000000,'','#fbbf24');
/*!40000 ALTER TABLE `g5_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_login`
--

DROP TABLE IF EXISTS `g5_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_login` (
  `lo_id` int NOT NULL AUTO_INCREMENT,
  `lo_ip` varchar(100) NOT NULL DEFAULT '',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `lo_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lo_location` text NOT NULL,
  `lo_url` text NOT NULL,
  PRIMARY KEY (`lo_id`),
  UNIQUE KEY `lo_ip_unique` (`lo_ip`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_login`
--

LOCK TABLES `g5_login` WRITE;
/*!40000 ALTER TABLE `g5_login` DISABLE KEYS */;
INSERT INTO `g5_login` VALUES (1,'::1','admin','2026-01-10 10:20:40','스피드 사다리',''),(11,'167.94.146.61','','2026-01-10 03:17:09','그누보드5','/gnu%20-%20%eb%b3%b5%ec%82%ac%eb%b3%b8/');
/*!40000 ALTER TABLE `g5_login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_mail`
--

DROP TABLE IF EXISTS `g5_mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_mail` (
  `ma_id` int NOT NULL AUTO_INCREMENT,
  `ma_subject` varchar(255) NOT NULL DEFAULT '',
  `ma_content` mediumtext NOT NULL,
  `ma_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ma_ip` varchar(255) NOT NULL DEFAULT '',
  `ma_last_option` text NOT NULL,
  PRIMARY KEY (`ma_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_mail`
--

LOCK TABLES `g5_mail` WRITE;
/*!40000 ALTER TABLE `g5_mail` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_mail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_member`
--

DROP TABLE IF EXISTS `g5_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_member` (
  `mb_no` int NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `mb_password` varchar(255) NOT NULL DEFAULT '',
  `mb_name` varchar(255) NOT NULL DEFAULT '',
  `mb_nick` varchar(255) NOT NULL DEFAULT '',
  `mb_nick_date` date NOT NULL DEFAULT '0000-00-00',
  `mb_email` varchar(255) NOT NULL DEFAULT '',
  `mb_homepage` varchar(255) NOT NULL DEFAULT '',
  `mb_level` tinyint NOT NULL DEFAULT '0',
  `mb_sex` char(1) NOT NULL DEFAULT '',
  `mb_birth` varchar(255) NOT NULL DEFAULT '',
  `mb_tel` varchar(255) NOT NULL DEFAULT '',
  `mb_hp` varchar(255) NOT NULL DEFAULT '',
  `mb_certify` varchar(20) NOT NULL DEFAULT '',
  `mb_adult` tinyint NOT NULL DEFAULT '0',
  `mb_dupinfo` varchar(255) NOT NULL DEFAULT '',
  `mb_zip1` char(3) NOT NULL DEFAULT '',
  `mb_zip2` char(3) NOT NULL DEFAULT '',
  `mb_addr1` varchar(255) NOT NULL DEFAULT '',
  `mb_addr2` varchar(255) NOT NULL DEFAULT '',
  `mb_addr3` varchar(255) NOT NULL DEFAULT '',
  `mb_addr_jibeon` varchar(255) NOT NULL DEFAULT '',
  `mb_signature` text NOT NULL,
  `mb_recommend` varchar(255) NOT NULL DEFAULT '',
  `mb_point` int NOT NULL DEFAULT '0',
  `mb_cash` int NOT NULL DEFAULT '0',
  `mb_today_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_login_ip` varchar(255) NOT NULL DEFAULT '',
  `mb_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_ip` varchar(255) NOT NULL DEFAULT '',
  `mb_leave_date` varchar(8) NOT NULL DEFAULT '',
  `mb_intercept_date` varchar(8) NOT NULL DEFAULT '',
  `mb_email_certify` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_email_certify2` varchar(255) NOT NULL DEFAULT '',
  `mb_memo` text NOT NULL,
  `mb_lost_certify` varchar(255) NOT NULL,
  `mb_mailling` tinyint NOT NULL DEFAULT '0',
  `mb_mailling_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_sms` tinyint NOT NULL DEFAULT '0',
  `mb_sms_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_open` tinyint NOT NULL DEFAULT '0',
  `mb_open_date` date NOT NULL DEFAULT '0000-00-00',
  `mb_profile` text NOT NULL,
  `mb_memo_call` varchar(255) NOT NULL DEFAULT '',
  `mb_memo_cnt` int NOT NULL DEFAULT '0',
  `mb_scrap_cnt` int NOT NULL DEFAULT '0',
  `mb_marketing_agree` tinyint(1) NOT NULL DEFAULT '0',
  `mb_marketing_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_thirdparty_agree` tinyint(1) NOT NULL DEFAULT '0',
  `mb_thirdparty_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_agree_log` text NOT NULL,
  `mb_1` varchar(255) NOT NULL DEFAULT '',
  `mb_2` varchar(255) NOT NULL DEFAULT '',
  `mb_3` varchar(255) NOT NULL DEFAULT '',
  `mb_4` varchar(255) NOT NULL DEFAULT '',
  `mb_5` varchar(255) NOT NULL DEFAULT '',
  `mb_6` varchar(255) NOT NULL DEFAULT '',
  `mb_7` varchar(255) NOT NULL DEFAULT '',
  `mb_8` varchar(255) NOT NULL DEFAULT '',
  `mb_9` varchar(255) NOT NULL DEFAULT '',
  `mb_10` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`mb_no`),
  UNIQUE KEY `mb_id` (`mb_id`),
  KEY `mb_today_login` (`mb_today_login`),
  KEY `mb_datetime` (`mb_datetime`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_member`
--

LOCK TABLES `g5_member` WRITE;
/*!40000 ALTER TABLE `g5_member` DISABLE KEYS */;
INSERT INTO `g5_member` VALUES (1,'admin','sha256:12000:dnx7r8e6LiFW3Fx1MZWAGAHsq+hsSScU:AoPv8Hk7q+tDqe0ryI9zQNX+6ctNciXh','최고관리자','최고관리자','2026-01-09','admin@domain.com','',10,'','','','','',0,'','','','','','','','','',20500,50000,'2026-01-10 00:00:02','::1','2026-01-09 21:36:40','::1','','','2026-01-09 21:36:40','','','',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',1,'0000-00-00','','',0,0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_member_cert_history`
--

DROP TABLE IF EXISTS `g5_member_cert_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_member_cert_history` (
  `ch_id` int NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `ch_name` varchar(255) NOT NULL DEFAULT '',
  `ch_hp` varchar(255) NOT NULL DEFAULT '',
  `ch_birth` varchar(255) NOT NULL DEFAULT '',
  `ch_type` varchar(20) NOT NULL DEFAULT '',
  `ch_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ch_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_member_cert_history`
--

LOCK TABLES `g5_member_cert_history` WRITE;
/*!40000 ALTER TABLE `g5_member_cert_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_member_cert_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_member_social_profiles`
--

DROP TABLE IF EXISTS `g5_member_social_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_member_social_profiles` (
  `mp_no` int NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(255) NOT NULL DEFAULT '',
  `provider` varchar(50) NOT NULL DEFAULT '',
  `object_sha` varchar(45) NOT NULL DEFAULT '',
  `identifier` varchar(255) NOT NULL DEFAULT '',
  `profileurl` varchar(255) NOT NULL DEFAULT '',
  `photourl` varchar(255) NOT NULL DEFAULT '',
  `displayname` varchar(150) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `mp_register_day` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mp_latest_day` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`mp_no`),
  KEY `mb_id` (`mb_id`),
  KEY `provider` (`provider`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_member_social_profiles`
--

LOCK TABLES `g5_member_social_profiles` WRITE;
/*!40000 ALTER TABLE `g5_member_social_profiles` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_member_social_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_memo`
--

DROP TABLE IF EXISTS `g5_memo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_memo` (
  `me_id` int NOT NULL AUTO_INCREMENT,
  `me_recv_mb_id` varchar(20) NOT NULL DEFAULT '',
  `me_send_mb_id` varchar(20) NOT NULL DEFAULT '',
  `me_send_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `me_read_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `me_memo` text NOT NULL,
  `me_send_id` int NOT NULL DEFAULT '0',
  `me_type` enum('send','recv') NOT NULL DEFAULT 'recv',
  `me_send_ip` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`me_id`),
  KEY `me_recv_mb_id` (`me_recv_mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_memo`
--

LOCK TABLES `g5_memo` WRITE;
/*!40000 ALTER TABLE `g5_memo` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_memo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_menu`
--

DROP TABLE IF EXISTS `g5_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_menu` (
  `me_id` int NOT NULL AUTO_INCREMENT,
  `me_code` varchar(255) NOT NULL DEFAULT '',
  `me_name` varchar(255) NOT NULL DEFAULT '',
  `me_link` varchar(255) NOT NULL DEFAULT '',
  `me_target` varchar(255) NOT NULL DEFAULT '',
  `me_order` int NOT NULL DEFAULT '0',
  `me_use` tinyint NOT NULL DEFAULT '0',
  `me_mobile_use` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`me_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_menu`
--

LOCK TABLES `g5_menu` WRITE;
/*!40000 ALTER TABLE `g5_menu` DISABLE KEYS */;
INSERT INTO `g5_menu` VALUES (1,'10','자료실','#','self',0,1,1);
/*!40000 ALTER TABLE `g5_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_new_win`
--

DROP TABLE IF EXISTS `g5_new_win`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_new_win` (
  `nw_id` int NOT NULL AUTO_INCREMENT,
  `nw_division` varchar(10) NOT NULL DEFAULT 'both',
  `nw_device` varchar(10) NOT NULL DEFAULT 'both',
  `nw_begin_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nw_end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nw_disable_hours` int NOT NULL DEFAULT '0',
  `nw_left` int NOT NULL DEFAULT '0',
  `nw_top` int NOT NULL DEFAULT '0',
  `nw_height` int NOT NULL DEFAULT '0',
  `nw_width` int NOT NULL DEFAULT '0',
  `nw_subject` text NOT NULL,
  `nw_content` text NOT NULL,
  `nw_content_html` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`nw_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_new_win`
--

LOCK TABLES `g5_new_win` WRITE;
/*!40000 ALTER TABLE `g5_new_win` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_new_win` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_point`
--

DROP TABLE IF EXISTS `g5_point`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_point` (
  `po_id` int NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `po_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `po_content` varchar(255) NOT NULL DEFAULT '',
  `po_point` int NOT NULL DEFAULT '0',
  `po_use_point` int NOT NULL DEFAULT '0',
  `po_expired` tinyint NOT NULL DEFAULT '0',
  `po_expire_date` date NOT NULL DEFAULT '0000-00-00',
  `po_mb_point` int NOT NULL DEFAULT '0',
  `po_rel_table` varchar(20) NOT NULL DEFAULT '',
  `po_rel_id` varchar(20) NOT NULL DEFAULT '',
  `po_rel_action` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`po_id`),
  KEY `index1` (`mb_id`,`po_rel_table`,`po_rel_id`,`po_rel_action`),
  KEY `index2` (`po_expire_date`)
) ENGINE=InnoDB AUTO_INCREMENT=206 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_point`
--

LOCK TABLES `g5_point` WRITE;
/*!40000 ALTER TABLE `g5_point` DISABLE KEYS */;
INSERT INTO `g5_point` VALUES (1,'admin','2026-01-09 21:36:56','2026-01-09 첫로그인',100,100,100,'9999-12-31',100,'@login','admin','2026-01-09'),(2,'admin','2026-01-10 00:00:02','2026-01-10 첫로그인',100,100,100,'9999-12-31',200,'@login','admin','2026-01-10'),(6,'admin','2026-01-10 03:16:23','50000',50000,50000,100,'9999-12-31',50000,'@passive','admin','admin-696145f74a11b'),(92,'admin','2026-01-10 04:39:51','갤러리 101 글쓰기',5,5,100,'9999-12-31',50025,'gallery','101','쓰기'),(94,'admin','2026-01-10 04:44:52','갤러리 102 글쓰기',5,5,100,'9999-12-31',49930,'gallery','102','쓰기'),(110,'admin','2026-01-10 05:31:55','Crash 게임 베팅',-1000,0,1,'2026-01-10',49210,'game','admin','crash_bet_1767990715'),(111,'admin','2026-01-10 05:32:02','Crash 게임 베팅',-1000,0,1,'2026-01-10',48210,'game','admin','crash_bet_1767990722'),(112,'admin','2026-01-10 05:32:07','Crash 캐시아웃 (x1.33)',1330,1330,100,'9999-12-31',49540,'game','admin','crash_win_1767990727'),(113,'admin','2026-01-10 05:33:31','Crash 게임 베팅',-1000,0,1,'2026-01-10',48540,'game','admin','crash_bet_1767990811'),(114,'admin','2026-01-10 05:33:35','Crash 캐시아웃 (x1.24)',1235,1235,100,'9999-12-31',49775,'game','admin','crash_win_1767990815'),(115,'admin','2026-01-10 05:48:54','주사위 당첨 (LOW, x2)',100,100,100,'9999-12-31',49875,'game','admin','dice_1767991734'),(116,'admin','2026-01-10 05:49:08','주사위 게임 (HIGH)',-100,0,1,'2026-01-10',49775,'game','admin','dice_1767991748'),(117,'admin','2026-01-10 05:49:14','주사위 당첨 (HIGH, x2)',100,100,100,'9999-12-31',49875,'game','admin','dice_1767991754'),(118,'admin','2026-01-10 05:51:58','룰렛 당첨 (x2, +200P)',100,100,100,'9999-12-31',49975,'game','admin','roulette_1767991918'),(119,'admin','2026-01-10 05:52:10','룰렛 당첨 (x2, +200P)',100,100,100,'9999-12-31',50075,'game','admin','roulette_1767991930'),(120,'admin','2026-01-10 05:52:17','룰렛 꽝',-100,0,1,'2026-01-10',49975,'game','admin','roulette_1767991938'),(121,'admin','2026-01-10 05:52:25','룰렛 당첨 (x2, +200P)',100,100,100,'9999-12-31',50075,'game','admin','roulette_1767991945'),(122,'admin','2026-01-10 05:52:37','슬롯머신 게임',-100,0,1,'2026-01-10',49975,'game','admin','slot_1767991957'),(123,'admin','2026-01-10 05:52:41','슬롯머신 당첨 (small)',50,50,100,'9999-12-31',50025,'game','admin','slot_1767991961'),(124,'admin','2026-01-10 05:52:45','슬롯머신 게임',-100,0,1,'2026-01-10',49925,'game','admin','slot_1767991965'),(125,'admin','2026-01-10 06:33:58','슬롯머신 당첨 (small)',50,50,100,'9999-12-31',49975,'game','admin','slot_1767994438'),(126,'admin','2026-01-10 06:34:13','슬롯머신 당첨 (small)',50,50,100,'9999-12-31',50025,'game','admin','slot_1767994453'),(127,'admin','2026-01-10 06:34:21','슬롯머신 게임',-100,0,1,'2026-01-10',49925,'game','admin','slot_1767994461'),(128,'admin','2026-01-10 06:37:51','갤러리 103 글쓰기',5,5,100,'9999-12-31',49930,'gallery','103','쓰기'),(129,'admin','2026-01-10 06:41:15','갤러리 104 글쓰기',5,5,100,'9999-12-31',49935,'gallery','104','쓰기'),(130,'admin','2026-01-10 06:41:32','갤러리 105 글쓰기',5,5,100,'9999-12-31',49940,'gallery','105','쓰기'),(131,'admin','2026-01-10 06:44:17','슬롯머신 당첨 (small)',50,50,100,'9999-12-31',49990,'game','admin','slot_1767995057'),(132,'admin','2026-01-10 06:44:36','룰렛 당첨 (x14, +1400P)',1300,1300,100,'9999-12-31',51290,'game','admin','roulette_1767995076'),(133,'admin','2026-01-10 06:44:47','룰렛 당첨 (x2, +200P)',100,100,100,'9999-12-31',51390,'game','admin','roulette_1767995088'),(134,'admin','2026-01-10 06:44:54','룰렛 당첨 (x2, +200P)',100,100,100,'9999-12-31',51490,'game','admin','roulette_1767995094'),(135,'admin','2026-01-10 06:45:22','주사위 게임 (LOW)',-100,0,1,'2026-01-10',51390,'game','admin','dice_1767995122'),(136,'admin','2026-01-10 06:45:40','바카라 게임 (뱅커)',-100,0,1,'2026-01-10',51290,'game','admin','baccarat_1767995140'),(137,'admin','2026-01-10 06:45:46','바카라 게임 (뱅커)',-100,0,1,'2026-01-10',51190,'game','admin','baccarat_1767995146'),(138,'admin','2026-01-10 06:45:50','바카라 게임 (뱅커)',-100,0,1,'2026-01-10',51090,'game','admin','baccarat_1767995150'),(139,'admin','2026-01-10 06:45:54','바카라 당첨 (뱅커, x1.95)',95,95,100,'9999-12-31',51185,'game','admin','baccarat_1767995154'),(140,'admin','2026-01-10 06:46:02','바카라 당첨 (뱅커, x1.95)',95,95,100,'9999-12-31',51280,'game','admin','baccarat_1767995162'),(141,'admin','2026-01-10 06:47:59','BTC 예측 베팅 (DOWN)',-1000,0,1,'2026-01-10',50280,'game','admin','btc_bet_1767995279'),(142,'admin','2026-01-10 06:50:47','바카라 당첨 (뱅커, x1.95)',950,950,100,'9999-12-31',51230,'game','admin','baccarat_1767995447'),(143,'admin','2026-01-10 06:51:45','바카라 당첨 (뱅커, x1.95)',4750,4750,100,'9999-12-31',55980,'game','admin','baccarat_1767995505'),(144,'admin','2026-01-10 06:51:57','바카라 게임 (타이)',-5000,0,1,'2026-01-10',50980,'game','admin','baccarat_1767995517'),(145,'admin','2026-01-10 06:55:05','바카라 게임 (타이)',-500,0,1,'2026-01-10',50480,'game','admin','baccarat_1767995705'),(146,'admin','2026-01-10 06:57:47','바카라 게임 (플레이어)',-500,0,1,'2026-01-10',49980,'game','admin','baccarat_1767995867'),(147,'admin','2026-01-10 07:02:35','바카라 게임 (플레이어)',-500,0,1,'2026-01-10',49480,'game','admin','baccarat_1767996155'),(148,'admin','2026-01-10 07:03:40','주사위 게임 (HIGH)',-100,0,1,'2026-01-10',49380,'game','admin','dice_1767996220'),(149,'admin','2026-01-10 07:07:16','주사위 게임 (HIGH)',-100,0,1,'2026-01-10',49280,'game','admin','dice_1767996436'),(150,'admin','2026-01-10 07:07:25','주사위 당첨 (SEVEN, x5)',400,400,100,'9999-12-31',49680,'game','admin','dice_1767996445'),(151,'admin','2026-01-10 07:07:37','주사위 게임 (LOW)',-100,0,1,'2026-01-10',49580,'game','admin','dice_1767996457'),(152,'admin','2026-01-10 07:07:42','주사위 게임 (HIGH)',-100,0,1,'2026-01-10',49480,'game','admin','dice_1767996462'),(153,'admin','2026-01-10 07:10:59','바카라 게임 (타이)',-100,0,1,'2026-01-10',49380,'game','admin','baccarat_1767996659'),(154,'admin','2026-01-10 07:11:26','바카라 당첨 (타이, x8)',700,700,100,'9999-12-31',50080,'game','admin','baccarat_1767996686'),(155,'admin','2026-01-10 07:11:37','바카라 게임 (뱅커)',-100,0,1,'2026-01-10',49980,'game','admin','baccarat_1767996697'),(156,'admin','2026-01-10 07:11:46','바카라 게임 (뱅커)',-10000,0,1,'2026-01-10',39980,'game','admin','baccarat_1767996706'),(157,'admin','2026-01-10 07:19:50','BTC 예측 베팅 (DOWN)',-1000,0,1,'2026-01-10',38980,'game','admin','btc_bet_1767997191'),(158,'admin','2026-01-10 07:20:04','BTC 예측 당첨 (DOWN, +1950P)',1950,1950,100,'9999-12-31',40930,'game','admin','btc_win_1767997204'),(159,'admin','2026-01-10 07:21:53','블랙잭 승리 (dealer_bust)',100,100,100,'9999-12-31',41030,'game','admin','blackjack_1767997313'),(160,'admin','2026-01-10 07:21:56','블랙잭 승리 (blackjack)',150,150,100,'9999-12-31',41180,'game','admin','blackjack_1767997316'),(161,'admin','2026-01-10 07:22:04','블랙잭 패배 (bust)',-200,0,1,'2026-01-10',40980,'game','admin','blackjack_1767997324'),(162,'admin','2026-01-10 07:22:10','블랙잭 패배 (lose)',-200,0,1,'2026-01-10',40780,'game','admin','blackjack_1767997330'),(163,'admin','2026-01-10 07:22:27','블랙잭 패배 (bust)',-100,0,1,'2026-01-10',40680,'game','admin','blackjack_1767997347'),(164,'admin','2026-01-10 07:22:37','블랙잭 패배 (lose)',-100,0,1,'2026-01-10',40580,'game','admin','blackjack_1767997357'),(165,'admin','2026-01-10 07:22:41','블랙잭 패배 (bust)',-100,0,1,'2026-01-10',40480,'game','admin','blackjack_1767997361'),(166,'admin','2026-01-10 07:33:52','룰렛 당첨 (x14, +1400P)',1300,1300,100,'9999-12-31',41780,'game','admin','roulette_1767998032'),(167,'admin','2026-01-10 07:33:59','룰렛 당첨 (x2, +200P)',100,100,100,'9999-12-31',41880,'game','admin','roulette_1767998039'),(168,'admin','2026-01-10 07:34:06','룰렛 당첨 (x2, +200P)',100,100,100,'9999-12-31',41980,'game','admin','roulette_1767998046'),(169,'admin','2026-01-10 07:47:42','블랙잭 승리 (win)',100,100,100,'9999-12-31',42080,'game','admin','blackjack_1767998862'),(170,'admin','2026-01-10 07:47:54','블랙잭 패배 (bust)',-200,0,1,'2026-01-10',41880,'game','admin','blackjack_1767998874'),(171,'admin','2026-01-10 07:47:57','블랙잭 패배 (lose)',-100,0,1,'2026-01-10',41780,'game','admin','blackjack_1767998877'),(172,'admin','2026-01-10 07:48:07','블랙잭 패배 (lose)',-100,0,1,'2026-01-10',41680,'game','admin','blackjack_1767998887'),(173,'admin','2026-01-10 07:50:25','BTC 예측 베팅 (DOWN)',-500,0,1,'2026-01-10',41180,'game','admin','btc_bet_1767999025'),(174,'admin','2026-01-10 07:50:46','BTC 예측 당첨 (DOWN, +975P)',975,975,100,'9999-12-31',42155,'game','admin','btc_win_1767999046'),(175,'admin','2026-01-10 07:51:57','블랙잭 승리 (blackjack)',150,150,100,'9999-12-31',42305,'game','admin','blackjack_1767999117'),(176,'admin','2026-01-10 07:52:06','블랙잭 패배 (lose)',-200,0,1,'2026-01-10',42105,'game','admin','blackjack_1767999126'),(177,'admin','2026-01-10 07:52:14','블랙잭 패배 (lose)',-100,0,1,'2026-01-10',42005,'game','admin','blackjack_1767999134'),(178,'admin','2026-01-10 07:52:20','블랙잭 패배 (bust)',-100,0,1,'2026-01-10',41905,'game','admin','blackjack_1767999140'),(179,'admin','2026-01-10 07:53:53','BTC 예측 베팅 (DOWN)',-1000,0,1,'2026-01-10',40905,'game','admin','btc_bet_1767999233'),(180,'admin','2026-01-10 07:54:21','BTC 예측 당첨 (DOWN, +1950P)',1950,1950,100,'9999-12-31',42855,'game','admin','btc_win_1767999261'),(181,'admin','2026-01-10 07:56:57','BTC 예측 베팅 (DOWN)',-100,0,1,'2026-01-10',42755,'game','admin','btc_bet_1767999417'),(182,'admin','2026-01-10 08:40:12','경마 29466700회차 베팅 (#4, x7)',-1000,0,1,'2026-01-10',41755,'game','admin','racing_bet_29466700_1768002012'),(183,'admin','2026-01-10 08:42:23','경마 29466702회차 베팅 (#1, x6.8)',-500,0,1,'2026-01-10',41255,'game','admin','racing_bet_29466702_1768002143'),(184,'admin','2026-01-10 08:45:37','경마 29466705회차 베팅 (황금마, x7.4)',-500,0,1,'2026-01-10',40755,'game','admin','racing_bet_29466705_1768002337'),(185,'admin','2026-01-10 08:49:09','경마 29466709회차 베팅 (블루윈드, x3.7)',-1000,0,1,'2026-01-10',39755,'game','admin','racing_bet_29466709_1768002549'),(186,'admin','2026-01-10 08:50:18','경마 29466709회차 당첨 (블루윈드, x3.70)',3700,3700,100,'9999-12-31',43455,'game','admin','racing_win_29466709_1'),(187,'admin','2026-01-10 08:50:33','경마 29466710회차 베팅 (번개, x6.5)',-1000,0,1,'2026-01-10',42455,'game','admin','racing_bet_29466710_1768002633'),(188,'admin','2026-01-10 08:52:20','경마 29466712회차 베팅 (그린라이트, x8.7)',-500,0,1,'2026-01-10',41955,'game','admin','racing_bet_29466712_1768002740'),(189,'admin','2026-01-10 08:54:45','경마 29466714회차 베팅 (퍼플스타, x9.3)',-5000,0,1,'2026-01-10',36955,'game','admin','racing_bet_29466714_1768002885'),(190,'admin','2026-01-10 09:00:29','경마 29466720회차 베팅 (퍼플스타, x6.9)',-500,0,1,'2026-01-10',36455,'game','admin','racing_bet_29466720_1768003229'),(191,'admin','2026-01-10 09:20:36','사다리 베팅 (짝)',-100,0,1,'2026-01-10',36355,'game','admin','ladder_bet_58933481_1768004436'),(192,'admin','2026-01-10 09:30:20','사다리 베팅 (우, 홀, 4줄)',-1500,0,1,'2026-01-10',34855,'game','admin','ladder_bet_58933500_1768005020'),(193,'admin','2026-01-10 09:30:45','사다리 베팅 (홀)',-100,0,1,'2026-01-10',34755,'game','admin','ladder_bet_58933501_1768005045'),(194,'admin','2026-01-10 09:31:12','사다리 베팅 (3줄)',-100,0,1,'2026-01-10',34655,'game','admin','ladder_bet_58933502_1768005072'),(195,'admin','2026-01-10 09:32:43','사다리 베팅 (우, 짝, 3줄)',-300,0,1,'2026-01-10',34355,'game','admin','ladder_bet_58933505_1768005163'),(196,'admin','2026-01-10 09:35:38','사다리 베팅 (4줄)',-1100,0,1,'2026-01-10',33255,'game','admin','ladder_bet_58933511_1768005338'),(197,'admin','2026-01-10 09:36:11','사다리 베팅 (짝)',-1100,0,1,'2026-01-10',32155,'game','admin','ladder_bet_58933512_1768005371'),(198,'admin','2026-01-10 09:36:15','사다리 베팅 (우)',-1600,0,1,'2026-01-10',30555,'game','admin','ladder_bet_58933512_1768005376'),(199,'admin','2026-01-10 09:37:05','사다리 베팅 (좌)',-100,0,1,'2026-01-10',30455,'game','admin','ladder_bet_58933514_1768005425'),(200,'admin','2026-01-10 10:02:45','사다리 베팅 (4줄)',-600,0,1,'2026-01-10',29855,'game','admin','ladder_bet_58933565_1768006965'),(201,'admin','2026-01-10 10:04:18','사다리 베팅 (3줄)',-100,0,1,'2026-01-10',29755,'game','admin','ladder_bet_58933568_1768007059'),(202,'admin','2026-01-10 10:04:50','사다리 베팅 (우, 홀)',-10000,0,1,'2026-01-10',19755,'game','admin','ladder_bet_58933569_1768007090'),(203,'admin','2026-01-10 10:09:42','사다리 베팅 (홀, 3줄)',-200,0,1,'2026-01-10',19555,'game','admin','ladder_bet_58933579_1768007382'),(204,'admin','2026-01-10 10:11:51','사다리 베팅 (홀)',-100,0,1,'2026-01-10',19455,'game','admin','ladder_bet_58933583_1768007511'),(205,'admin','2026-01-10 10:15:16','사다리 베팅 (홀)',-1100,0,1,'2026-01-10',18355,'game','admin','ladder_bet_58933590_1768007716');
/*!40000 ALTER TABLE `g5_point` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_poll`
--

DROP TABLE IF EXISTS `g5_poll`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_poll` (
  `po_id` int NOT NULL AUTO_INCREMENT,
  `po_subject` varchar(255) NOT NULL DEFAULT '',
  `po_poll1` varchar(255) NOT NULL DEFAULT '',
  `po_poll2` varchar(255) NOT NULL DEFAULT '',
  `po_poll3` varchar(255) NOT NULL DEFAULT '',
  `po_poll4` varchar(255) NOT NULL DEFAULT '',
  `po_poll5` varchar(255) NOT NULL DEFAULT '',
  `po_poll6` varchar(255) NOT NULL DEFAULT '',
  `po_poll7` varchar(255) NOT NULL DEFAULT '',
  `po_poll8` varchar(255) NOT NULL DEFAULT '',
  `po_poll9` varchar(255) NOT NULL DEFAULT '',
  `po_cnt1` int NOT NULL DEFAULT '0',
  `po_cnt2` int NOT NULL DEFAULT '0',
  `po_cnt3` int NOT NULL DEFAULT '0',
  `po_cnt4` int NOT NULL DEFAULT '0',
  `po_cnt5` int NOT NULL DEFAULT '0',
  `po_cnt6` int NOT NULL DEFAULT '0',
  `po_cnt7` int NOT NULL DEFAULT '0',
  `po_cnt8` int NOT NULL DEFAULT '0',
  `po_cnt9` int NOT NULL DEFAULT '0',
  `po_etc` varchar(255) NOT NULL DEFAULT '',
  `po_level` tinyint NOT NULL DEFAULT '0',
  `po_point` int NOT NULL DEFAULT '0',
  `po_date` date NOT NULL DEFAULT '0000-00-00',
  `po_ips` mediumtext NOT NULL,
  `mb_ids` text NOT NULL,
  `po_use` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`po_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_poll`
--

LOCK TABLES `g5_poll` WRITE;
/*!40000 ALTER TABLE `g5_poll` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_poll` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_poll_etc`
--

DROP TABLE IF EXISTS `g5_poll_etc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_poll_etc` (
  `pc_id` int NOT NULL DEFAULT '0',
  `po_id` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `pc_name` varchar(255) NOT NULL DEFAULT '',
  `pc_idea` varchar(255) NOT NULL DEFAULT '',
  `pc_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`pc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_poll_etc`
--

LOCK TABLES `g5_poll_etc` WRITE;
/*!40000 ALTER TABLE `g5_poll_etc` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_poll_etc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_popular`
--

DROP TABLE IF EXISTS `g5_popular`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_popular` (
  `pp_id` int NOT NULL AUTO_INCREMENT,
  `pp_word` varchar(50) NOT NULL DEFAULT '',
  `pp_date` date NOT NULL DEFAULT '0000-00-00',
  `pp_ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`pp_id`),
  UNIQUE KEY `index1` (`pp_date`,`pp_word`,`pp_ip`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_popular`
--

LOCK TABLES `g5_popular` WRITE;
/*!40000 ALTER TABLE `g5_popular` DISABLE KEYS */;
INSERT INTO `g5_popular` VALUES (2,'123','2026-01-10','::1'),(1,'1231233','2026-01-10','::1'),(3,'1233','2026-01-10','::1'),(20,'ㅋㅋ','2026-01-10','::1'),(71,'ㅋㅋㅋㅋ','2026-01-10','::1'),(60,'건강','2026-01-10','::1'),(17,'건강관리','2026-01-10','::1'),(59,'고민','2026-01-10','::1'),(6,'아침형','2026-01-10','::1'),(5,'출퇴근','2026-01-10','::1');
/*!40000 ALTER TABLE `g5_popular` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_qa_config`
--

DROP TABLE IF EXISTS `g5_qa_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_qa_config` (
  `qa_id` int NOT NULL AUTO_INCREMENT,
  `qa_title` varchar(255) NOT NULL DEFAULT '',
  `qa_category` varchar(255) NOT NULL DEFAULT '',
  `qa_skin` varchar(255) NOT NULL DEFAULT '',
  `qa_mobile_skin` varchar(255) NOT NULL DEFAULT '',
  `qa_use_email` tinyint NOT NULL DEFAULT '0',
  `qa_req_email` tinyint NOT NULL DEFAULT '0',
  `qa_use_hp` tinyint NOT NULL DEFAULT '0',
  `qa_req_hp` tinyint NOT NULL DEFAULT '0',
  `qa_use_sms` tinyint NOT NULL DEFAULT '0',
  `qa_send_number` varchar(255) NOT NULL DEFAULT '0',
  `qa_admin_hp` varchar(255) NOT NULL DEFAULT '',
  `qa_admin_email` varchar(255) NOT NULL DEFAULT '',
  `qa_use_editor` tinyint NOT NULL DEFAULT '0',
  `qa_subject_len` int NOT NULL DEFAULT '0',
  `qa_mobile_subject_len` int NOT NULL DEFAULT '0',
  `qa_page_rows` int NOT NULL DEFAULT '0',
  `qa_mobile_page_rows` int NOT NULL DEFAULT '0',
  `qa_image_width` int NOT NULL DEFAULT '0',
  `qa_upload_size` int NOT NULL DEFAULT '0',
  `qa_insert_content` text NOT NULL,
  `qa_include_head` varchar(255) NOT NULL DEFAULT '',
  `qa_include_tail` varchar(255) NOT NULL DEFAULT '',
  `qa_content_head` text NOT NULL,
  `qa_content_tail` text NOT NULL,
  `qa_mobile_content_head` text NOT NULL,
  `qa_mobile_content_tail` text NOT NULL,
  `qa_1_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_2_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_3_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_4_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_5_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_1` varchar(255) NOT NULL DEFAULT '',
  `qa_2` varchar(255) NOT NULL DEFAULT '',
  `qa_3` varchar(255) NOT NULL DEFAULT '',
  `qa_4` varchar(255) NOT NULL DEFAULT '',
  `qa_5` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`qa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_qa_config`
--

LOCK TABLES `g5_qa_config` WRITE;
/*!40000 ALTER TABLE `g5_qa_config` DISABLE KEYS */;
INSERT INTO `g5_qa_config` VALUES (1,'1:1문의','회원|포인트','basic','basic',1,0,1,0,0,'0','','',1,60,30,15,15,600,1048576,'','','','','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_qa_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_qa_content`
--

DROP TABLE IF EXISTS `g5_qa_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_qa_content` (
  `qa_id` int NOT NULL AUTO_INCREMENT,
  `qa_num` int NOT NULL DEFAULT '0',
  `qa_parent` int NOT NULL DEFAULT '0',
  `qa_related` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `qa_name` varchar(255) NOT NULL DEFAULT '',
  `qa_email` varchar(255) NOT NULL DEFAULT '',
  `qa_hp` varchar(255) NOT NULL DEFAULT '',
  `qa_type` tinyint NOT NULL DEFAULT '0',
  `qa_category` varchar(255) NOT NULL DEFAULT '',
  `qa_email_recv` tinyint NOT NULL DEFAULT '0',
  `qa_sms_recv` tinyint NOT NULL DEFAULT '0',
  `qa_html` tinyint NOT NULL DEFAULT '0',
  `qa_subject` varchar(255) NOT NULL DEFAULT '',
  `qa_content` text NOT NULL,
  `qa_status` tinyint NOT NULL DEFAULT '0',
  `qa_file1` varchar(255) NOT NULL DEFAULT '',
  `qa_source1` varchar(255) NOT NULL DEFAULT '',
  `qa_file2` varchar(255) NOT NULL DEFAULT '',
  `qa_source2` varchar(255) NOT NULL DEFAULT '',
  `qa_ip` varchar(255) NOT NULL DEFAULT '',
  `qa_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `qa_1` varchar(255) NOT NULL DEFAULT '',
  `qa_2` varchar(255) NOT NULL DEFAULT '',
  `qa_3` varchar(255) NOT NULL DEFAULT '',
  `qa_4` varchar(255) NOT NULL DEFAULT '',
  `qa_5` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`qa_id`),
  KEY `qa_num_parent` (`qa_num`,`qa_parent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_qa_content`
--

LOCK TABLES `g5_qa_content` WRITE;
/*!40000 ALTER TABLE `g5_qa_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_qa_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_scrap`
--

DROP TABLE IF EXISTS `g5_scrap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_scrap` (
  `ms_id` int NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `wr_id` varchar(15) NOT NULL DEFAULT '',
  `ms_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ms_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_scrap`
--

LOCK TABLES `g5_scrap` WRITE;
/*!40000 ALTER TABLE `g5_scrap` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_scrap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_uniqid`
--

DROP TABLE IF EXISTS `g5_uniqid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_uniqid` (
  `uq_id` bigint unsigned NOT NULL,
  `uq_ip` varchar(255) NOT NULL,
  PRIMARY KEY (`uq_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_uniqid`
--

LOCK TABLES `g5_uniqid` WRITE;
/*!40000 ALTER TABLE `g5_uniqid` DISABLE KEYS */;
INSERT INTO `g5_uniqid` VALUES (2026011004381485,'::1'),(2026011004381975,'::1'),(2026011004382739,'::1'),(2026011004383617,'::1'),(2026011004400710,'::1'),(2026011004401294,'::1'),(2026011004401732,'::1'),(2026011004402194,'::1'),(2026011004402587,'::1'),(2026011004442434,'::1'),(2026011004442891,'::1'),(2026011004443370,'::1'),(2026011004444988,'::1'),(2026011004504160,'::1'),(2026011006374821,'::1'),(2026011006410014,'::1'),(2026011006411278,'::1'),(2026011006412847,'::1'),(2026011007371459,'::1');
/*!40000 ALTER TABLE `g5_uniqid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_visit`
--

DROP TABLE IF EXISTS `g5_visit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_visit` (
  `vi_id` int NOT NULL AUTO_INCREMENT,
  `vi_ip` varchar(100) NOT NULL DEFAULT '',
  `vi_date` date NOT NULL DEFAULT '0000-00-00',
  `vi_time` time NOT NULL DEFAULT '00:00:00',
  `vi_referer` text NOT NULL,
  `vi_agent` varchar(200) NOT NULL DEFAULT '',
  `vi_browser` varchar(255) NOT NULL DEFAULT '',
  `vi_os` varchar(255) NOT NULL DEFAULT '',
  `vi_device` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`vi_id`),
  UNIQUE KEY `index1` (`vi_ip`,`vi_date`),
  KEY `index2` (`vi_date`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_visit`
--

LOCK TABLES `g5_visit` WRITE;
/*!40000 ALTER TABLE `g5_visit` DISABLE KEYS */;
INSERT INTO `g5_visit` VALUES (1,'::1','2026-01-09','21:36:43','http://localhost/install/install_db.php','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(2,'185.16.39.146','2026-01-09','21:37:42','','Mozilla/5.0','','',''),(4,'89.42.231.200','2026-01-09','21:46:32','','','','',''),(7,'149.50.103.48','2026-01-09','21:51:25','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','','',''),(8,'204.76.203.212','2026-01-09','21:54:30','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','','',''),(10,'91.224.92.14','2026-01-09','21:54:57','','','','',''),(22,'193.142.147.209','2026-01-09','22:30:44','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36','','',''),(25,'45.135.194.23','2026-01-09','22:38:30','','','','',''),(30,'95.214.55.71','2026-01-09','22:47:22','','python-requests/2.31.0','','',''),(40,'20.127.202.128','2026-01-09','23:15:08','','Mozilla/5.0 zgrab/0.x','','',''),(46,'::1','2026-01-10','00:33:26','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','','',''),(56,'167.94.146.61','2026-01-10','03:17:09','http://109.61.83.163:80/gnu%20-%20%eb%b3%b5%ec%82%ac%eb%b3%b8','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','','','');
/*!40000 ALTER TABLE `g5_visit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_visit_sum`
--

DROP TABLE IF EXISTS `g5_visit_sum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_visit_sum` (
  `vs_date` date NOT NULL DEFAULT '0000-00-00',
  `vs_count` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`vs_date`),
  KEY `index1` (`vs_count`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_visit_sum`
--

LOCK TABLES `g5_visit_sum` WRITE;
/*!40000 ALTER TABLE `g5_visit_sum` DISABLE KEYS */;
INSERT INTO `g5_visit_sum` VALUES ('2026-01-10',2),('2026-01-09',10);
/*!40000 ALTER TABLE `g5_visit_sum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_artwork`
--

DROP TABLE IF EXISTS `g5_write_artwork`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_artwork` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_artwork`
--

LOCK TABLES `g5_write_artwork` WRITE;
/*!40000 ALTER TABLE `g5_write_artwork` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_artwork` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_docs`
--

DROP TABLE IF EXISTS `g5_write_docs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_docs` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_docs`
--

LOCK TABLES `g5_write_docs` WRITE;
/*!40000 ALTER TABLE `g5_write_docs` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_docs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_free`
--

DROP TABLE IF EXISTS `g5_write_free`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_free` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_free`
--

LOCK TABLES `g5_write_free` WRITE;
/*!40000 ALTER TABLE `g5_write_free` DISABLE KEYS */;
INSERT INTO `g5_write_free` VALUES (1,-1,'',1,0,1,'','','','오늘 회사에서 있었던 황당한 일 공유합니다 (1)','안녕하세요, 오늘 회사에서 정말 황당한 일이 있었어요.\n\n아침에 출근해서 자리에 앉았는데, 제 컴퓨터가 없어진 거예요! 알고 보니 IT팀에서 업그레이드한다고 가져갔더라고요. 미리 말해주지... 그래서 오전 내내 다른 분 컴퓨터 빌려서 일했네요.\n\n점심시간에는 구내식당에서 또 웃긴 일이 있었어요. 줄 서서 기다리고 있는데 앞사람이 갑자기 뒤돌아보면서 \'혹시 김대리님 아니세요?\' 하는 거예요. 저는 김대리가 아닌데... 그래서 \'아닌데요\'라고 했더니 엄청 민망해하시더라고요.\n\n오후에는 회의가 있었는데, 화상회의 중에 누군가 마이크 안 끄고 라면 먹는 소리가 들려서 다들 빵 터졌어요. 재택근무하시는 분이셨는데 본인은 모르셨나봐요.\n\n이렇게 소소한 일상의 에피소드들이 직장생활을 버티게 해주는 것 같아요. 여러분의 회사 에피소드도 댓글로 공유해주세요!','오늘-회사에서-있었던-황당한-일-공유합니다-1','','',0,0,648,21,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(2,-2,'',2,0,11,'','','','주말에 뭐하시나요? 추천 좀 해주세요 (2)','이번 주말에 뭐 하실 계획이세요? 저는 요즘 집콕만 해서 이번에는 좀 나가볼까 합니다.\n\n근데 막상 나가려니까 뭘 해야 할지 모르겠더라고요. 혼자 카페 가기? 영화 보기? 아니면 근교 드라이브?\n\n제 취향은 이래요:\n- 등산은 좀 힘들어서 패스\n- 카페 투어는 좋아함\n- 사람 많은 곳은 별로\n- 자연 풍경 보는 거 좋아함\n\n서울 근교로 드라이브 가기 좋은 곳이나, 조용한 카페 아시는 분 추천 부탁드려요! 특히 요즘 단풍 예쁜 곳 있으면 알려주세요.\n\n그리고 주말에 혼자 다니시는 분들 계신가요? 처음에는 좀 어색했는데 이제는 혼밥, 혼카페, 혼영화 다 즐기게 됐어요. 혼자만의 시간도 소중하더라고요.','','','',0,0,499,14,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(3,-3,'',3,0,5,'','','','요즘 날씨가 너무 좋네요 산책 다녀왔어요 (3)','요즘 날씨가 정말 좋지 않나요? 아침저녁으로는 선선하고, 낮에는 따뜻하고... 딱 나들이 가기 좋은 날씨예요.\n\n저는 오늘 점심시간에 잠깐 회사 근처 공원 산책했는데, 단풍이 정말 예쁘더라고요. 빨강, 노랑, 주황색 나뭇잎들이 햇빛 받아서 반짝반짝...\n\n이런 날씨에 추천하는 활동:\n1. 공원 산책 - 가볍게 걷기만 해도 힐링\n2. 야외 카페 - 테라스 석에서 커피 한 잔\n3. 자전거 타기 - 한강 자전거 도로 추천\n4. 피크닉 - 돗자리 깔고 김밥 먹기\n\n여러분은 이 좋은 날씨에 뭐 하고 계세요? 날씨 좋을 때 즐겨야 해요. 금방 추워질 테니까요.','','','',0,0,670,14,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(4,-4,'',4,0,8,'','','','강남역 근처 맛집 추천 부탁드려요 (4)','맛집 추천 부탁드려요! 이번 주에 친구들이랑 모임이 있는데 어디로 가야 할지 모르겠어요.\n\n조건:\n- 위치: 강남역 근처\n- 인원: 4-5명\n- 예산: 1인당 3만원 정도\n- 분위기: 대화하기 좋은 곳\n- 음식: 한식이나 이탈리안\n\n혹시 이 조건에 맞는 곳 아시면 추천해주세요!\n\n참고로 제가 가본 곳 중에 괜찮았던 데는 있는데 다 가봤던 데라서 이번에는 새로운 데 가보고 싶거든요. 숨은 맛집 있으면 공유해주세요!\n\n특히 분위기 좋고 사진 찍기 좋은 곳이면 더 좋겠어요. 요즘 인스타 감성 카페 겸 레스토랑 많잖아요.','','','',0,0,284,17,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(5,-5,'',5,0,0,'','','','30대 중반 운동 시작하려는데 조언 부탁드려요 (5)','30대 중반인데 이제서야 운동을 시작하려고 합니다. 그동안 운동이라곤 거의 안 해서 체력이 바닥이에요...\n\n고민되는 게:\n1. 헬스장 vs 홈트 - 뭐가 더 효과적일까요?\n2. PT 받아야 할까요? - 비용이 부담되긴 한데...\n3. 어떤 운동부터 시작해야 할까요?\n\n목표는 일단 체력 기르기랑 뱃살 빼기입니다. 마른 비만이라서 근육은 없고 뱃살만 있어요 ㅠㅠ\n\n운동 잘 아시는 분들 조언 부탁드립니다! 특히 운동 초보가 주의해야 할 점이나 효과적인 루틴 있으면 알려주세요.\n\n그리고 운동하면서 식단 관리도 해야 할까요? 닭가슴살 생활 해야 하나... 막막하네요.','','','',0,0,778,3,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(6,-6,'',6,0,0,'','','','재택근무 꿀팁 공유합니다 참고하세요 (6)','재택근무 3년차입니다. 처음에는 집중이 안 돼서 힘들었는데, 이제는 나름의 노하우가 생겼어요.\n\n제 재택근무 꿀팁:\n\n1. 출퇴근 루틴 만들기\n- 출근 시간에 맞춰 샤워하고 옷 갈아입기\n- 퇴근 시간 되면 컴퓨터 끄기\n\n2. 업무 공간 분리\n- 가능하면 별도 방 사용\n- 안 되면 책상이라도 업무 전용으로\n\n3. 집중력 유지\n- 뽀모도로 기법 (25분 집중 + 5분 휴식)\n- 방해 요소 제거 (SNS 알림 끄기)\n\n4. 소통 강화\n- 업무 시작/종료 시 팀 채팅방에 알리기\n- 화상회의 적극 활용\n\n5. 건강 관리\n- 틈틈이 스트레칭\n- 점심시간에 산책\n\n재택근무하시는 분들 다른 팁 있으면 공유해주세요!','','','',0,0,612,2,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(7,-7,'',7,0,10,'','','','요즘 읽고 있는 책 추천합니다 (7)','요즘 읽고 있는 책이 너무 좋아서 추천드려요.\n\n제목: \'아주 작은 습관의 힘\' (제임스 클리어)\n\n이 책의 핵심 내용:\n- 1%씩 나아지면 1년 후 37배 성장\n- 습관은 정체성의 변화에서 시작\n- 환경 설계의 중요성\n- 습관 쌓기(habit stacking) 기법\n\n특히 인상 깊었던 구절:\n\"우리는 목표 수준으로 올라가는 것이 아니라 시스템 수준으로 떨어진다.\"\n\n저도 이 책 읽고 아침 루틴을 만들기 시작했어요. 아침에 일어나서 물 한 잔 마시기 → 5분 스트레칭 → 10분 독서 이런 식으로요.\n\n자기계발서 좋아하시는 분들께 강추합니다. 다른 책 추천도 받아요!','','','',0,0,100,19,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(8,-8,'',8,0,11,'','','','취미생활 뭐 하시나요? 새로운 취미 찾는 중 (8)','요즘 새로운 취미를 찾고 있어요. 퇴근 후랑 주말에 뭔가 하고 싶은데 뭘 해야 할지 모르겠더라고요.\n\n지금까지 해본 취미:\n- 넷플릭스 정주행 (이건 취미라기보다...)\n- 독서 (꾸준히 하고 있음)\n- 요리 (가끔)\n\n관심 있는 것들:\n- 악기 (기타? 피아노?)\n- 그림 그리기\n- 운동 (클라이밍, 수영 등)\n- 사진 촬영\n\n여러분은 어떤 취미 활동 하시나요? 특히 혼자 할 수 있고, 스트레스 해소에 좋은 취미 있으면 추천해주세요!\n\n비용이나 시간 투자 대비 만족도 높은 취미면 더 좋겠어요.','','','',0,0,770,48,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(9,-9,'',9,0,0,'','','','이직 고민 중입니다 조언 부탁드려요 (9)','현재 회사에서 3년째 근무 중인데, 이직을 고민하고 있습니다.\n\n현재 상황:\n- 연봉: 업계 평균 수준\n- 업무: 익숙하지만 성장이 멈춘 느낌\n- 분위기: 나쁘지 않음\n- 워라밸: 괜찮은 편\n\n이직을 고민하는 이유:\n1. 커리어 성장의 한계를 느낌\n2. 새로운 도전을 하고 싶음\n3. 연봉 상승 기대\n\n고민되는 점:\n- 지금 이직 시장이 안 좋다는데...\n- 새 회사가 더 안 좋으면 어쩌지?\n- 3년이면 이직하기 좋은 시기인가?\n\n이직 경험 있으신 분들 조언 부탁드립니다. 어떤 기준으로 결정하셨나요?','이직-고민-중입니다-조언-부탁드려요-9','','',0,0,202,34,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(10,-10,'',10,0,3,'','','','연말 계획 세우셨나요? 저는 이렇게 계획 중 (10)','벌써 연말이 다가오네요. 올해도 얼마 안 남았어요.\n\n제 연말 계획:\n\n1. 송년회\n- 회사 송년회 (12월 셋째 주)\n- 친구들 모임 (크리스마스 전 주말)\n- 가족 모임 (크리스마스 당일)\n\n2. 여행\n- 크리스마스 연휴에 1박 2일 여행 계획 중\n- 강원도 쪽으로 갈까 고민\n\n3. 정리\n- 집 대청소\n- 안 입는 옷 정리\n- 1년 회고 작성\n\n4. 새해 목표 설정\n- 운동 계획\n- 재테크 목표\n- 자기계발 계획\n\n여러분은 연말 계획 어떻게 세우셨나요? 특별한 계획 있으면 공유해주세요!','','','',0,0,253,36,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(11,-11,'',11,0,11,'','','','아침형 인간 되는 방법 공유합니다 (11)','저도 예전에는 저녁형 인간이었는데, 아침형으로 바꾸고 삶의 질이 확 좋아졌어요.\n\n제가 아침형 인간이 된 방법:\n\n1. 점진적으로 바꾸기\n- 한 번에 2시간 당기지 말고\n- 일주일에 15분씩 앞당기기\n\n2. 저녁 루틴 만들기\n- 밤 10시 이후 스마트폰 안 보기\n- 따뜻한 물로 샤워\n- 독서나 명상\n\n3. 아침에 기대되는 것 만들기\n- 맛있는 아침 메뉴\n- 좋아하는 음악\n- 여유로운 커피 타임\n\n4. 환경 설정\n- 커튼 살짝 열어두기 (자연광)\n- 알람 여러 개 (점점 크게)\n- 알람 멀리 두기\n\n처음 2주가 제일 힘들어요. 그 고비만 넘기면 몸이 적응합니다!','아침형-인간-되는-방법-공유합니다-11','','',0,0,325,27,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(12,-12,'',12,0,15,'','','','스트레스 해소법 공유해요 저는 이렇게 해요 (12)','직장인이라면 스트레스 안 받을 수가 없죠. 저만의 스트레스 해소법 공유합니다.\n\n1. 운동\n- 땀 흘리면 스트레스가 날아가요\n- 특히 복싱, 러닝 추천\n\n2. 맛있는 거 먹기\n- 스트레스 받으면 맛있는 거 먹어야죠\n- 단, 폭식은 노노\n\n3. 수다 떨기\n- 친구나 가족과 대화\n- 말하다 보면 정리가 돼요\n\n4. 취미 활동\n- 저는 게임이나 영화 보기\n- 몰입하면 잡생각 사라짐\n\n5. 충분한 수면\n- 잠이 보약\n- 스트레스 받을수록 잘 자야 해요\n\n6. 글쓰기\n- 일기나 감정 노트\n- 쓰다 보면 객관화가 돼요\n\n여러분만의 스트레스 해소법도 공유해주세요!','','','',0,0,338,36,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(13,-13,'',13,0,12,'','','','최근에 본 영화 추천합니다 꼭 보세요 (13)','주말에 본 영화가 너무 좋아서 추천드려요.\n\n제목: 오펜하이머\n감독: 크리스토퍼 놀란\n\n놀란 감독 특유의 연출력이 돋보이는 영화였어요. 3시간이 넘는 러닝타임인데 지루할 틈이 없었습니다.\n\n좋았던 점:\n- 킬리언 머피의 연기력\n- 긴장감 넘치는 전개\n- 아이맥스로 보면 더 좋음\n- OST가 압도적\n\n참고사항:\n- 역사적 배경 알고 보면 더 재밌어요\n- 자막 집중해서 봐야 함 (대사 많음)\n\n평점: 9/10\n\n요즘 극장에서 볼 만한 영화 추천받아요. 장르 불문!','','','',0,0,295,13,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(14,-14,'',14,0,6,'','','','집에서 할 수 있는 취미 추천해주세요 (14)','요즘 밖에 나가기가 귀찮아서 집에서 할 수 있는 취미를 찾고 있어요.\n\n지금 하고 있는 것:\n- 넷플릭스\n- 유튜브\n- 게임\n\n해보고 싶은 것:\n- 홈베이킹\n- 플랜테리어 (식물 키우기)\n- DIY 소품 만들기\n- 홈트레이닝\n\n집에서 할 수 있는 취미 중에 추천하실 만한 거 있나요?\n\n조건:\n- 초기 비용 너무 안 들었으면\n- 소음 적은 것 (아파트라서)\n- 혼자 할 수 있는 것\n\n특히 손으로 뭔가 만드는 취미에 관심이 있어요. 레고나 프라모델 어떤가요?','','','',0,0,558,42,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(15,-15,'',15,0,4,'','','','커피 vs 차 어떤 거 좋아하세요? (15)','저는 원래 커피파였는데 요즘 차에 빠졌어요.\n\n커피의 장점:\n- 확실한 각성 효과\n- 맛있음 (특히 라떼)\n- 카페 분위기\n\n차의 장점:\n- 카페인 적음\n- 다양한 종류\n- 건강에 좋음\n- 따뜻하게 마시면 힐링\n\n요즘 제가 즐겨 마시는 차:\n- 얼그레이\n- 캐모마일 (취침 전)\n- 페퍼민트 (식후)\n- 루이보스\n\n여러분은 커피파? 차파? 아니면 둘 다?\n\n추천하는 차 종류나 카페 있으면 공유해주세요!','','','',0,0,171,39,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(16,-16,'',16,0,10,'','','','반려동물 키우시는 분들 질문있어요 (16)','반려동물 입양을 고민 중인데, 현실적인 조언 부탁드려요.\n\n고민되는 점:\n1. 혼자 사는 1인 가구인데 가능할까?\n2. 출장이 가끔 있는데 맡길 곳은?\n3. 비용은 한 달에 얼마나 들까?\n4. 강아지 vs 고양이 뭐가 좋을까?\n\n저의 상황:\n- 원룸 거주\n- 평일 출근 (9시-6시)\n- 주말에는 거의 집에 있음\n- 여행은 1년에 2-3번\n\n키우시는 분들 현실적인 조언 부탁드려요. 예쁜 것만 보고 입양했다가 힘들어하시는 분들 많다고 해서 신중하게 결정하려고요.\n\n특히 처음 키우시는 분들 경험담 들려주세요!','','','',0,0,429,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(17,-17,'',17,0,4,'','','','요즘 핫한 드라마 뭐예요? 추천해주세요 (17)','넷플릭스에서 볼 드라마 찾고 있어요. 요즘 뭐가 재밌나요?\n\n제가 좋아하는 장르:\n- 스릴러\n- 미스터리\n- SF\n- 로맨스도 가끔\n\n최근에 본 것들:\n- 오징어 게임 (재밌었음)\n- 더 글로리 (몰입감 최고)\n- 무빙 (액션 굿)\n\n안 좋아하는 것:\n- 너무 무거운 거\n- 시즌 너무 긴 거\n- 결말 흐지부지\n\n추천해주실 드라마 있으면 알려주세요! 해외 드라마도 좋아요.\n\n넷플릭스 말고 디즈니+, 웨이브 등 다른 OTT 추천도 환영합니다.','','','',0,0,126,18,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(18,-18,'',18,0,1,'','','','자기계발 어떻게 하시나요? 루틴 공유 (18)','올해 자기계발 목표를 세웠는데, 꾸준히 하기가 어렵네요.\n\n제 목표:\n1. 영어 공부 - 토익 900점\n2. 자격증 - 정보처리기사\n3. 독서 - 월 2권\n4. 운동 - 주 3회\n\n현실:\n- 영어 앱 깔아놓고 안 함\n- 자격증 책 사놓고 안 봄\n- 독서 1월에 1권 읽고 끝\n- 운동 헬스장 등록만 함\n\n작심삼일을 벗어나는 방법 있을까요?\n\n꾸준히 자기계발 하시는 분들 루틴이나 팁 공유해주세요. 특히 퇴근 후 시간 활용법이 궁금해요.','','','',0,0,81,11,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(19,-19,'',19,0,10,'','','','출퇴근 시간 활용법 알려드려요 (19)','출퇴근 시간이 왕복 2시간인데, 이 시간을 알차게 보내는 방법 공유해요.\n\n제 출퇴근 루틴:\n\n아침 (1시간):\n- 오디오북 듣기 (30분)\n- 뉴스 기사 읽기 (20분)\n- 하루 계획 정리 (10분)\n\n저녁 (1시간):\n- 팟캐스트 듣기 (30분)\n- 영어 공부 (20분)\n- SNS, 유튜브 (10분)\n\n추천하는 콘텐츠:\n- 오디오북: 밀리의 서재\n- 팟캐스트: 과학기술 관련\n- 영어: 영어회화 앱\n\n이렇게 하니까 1년에 책 20권 정도 듣더라고요. 시간 낭비하는 것 같던 출퇴근이 생산적으로 바뀌었어요.\n\n다른 분들 출퇴근 시간 활용법도 공유해주세요!','','','',0,0,113,16,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(20,-20,'',20,0,14,'','','','건강관리 팁 공유합니다 30대 필독 (20)','30대 들어서 건강이 예전 같지 않더라고요. 그래서 관리 시작했어요.\n\n제 건강관리 루틴:\n\n1. 식단\n- 아침 꼭 먹기\n- 야채 많이\n- 야식 자제\n- 물 2L\n\n2. 운동\n- 주 3회 헬스\n- 매일 스트레칭\n- 주말 산책\n\n3. 수면\n- 11시 취침 목표\n- 6시간 이상\n- 주말에도 일정하게\n\n4. 정기검진\n- 연 1회 건강검진\n- 치과 6개월마다\n\n5. 멘탈 관리\n- 명상 앱 활용\n- 취미 생활\n- 친구 만나기\n\n30대 되니까 관리 안 하면 바로 티가 나요. 미리미리 관리합시다!','','','',0,0,647,23,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(21,-21,'',21,0,4,'','','','오늘 회사에서 있었던 황당한 일 공유합니다 (21)','안녕하세요, 오늘 회사에서 정말 황당한 일이 있었어요.\n\n아침에 출근해서 자리에 앉았는데, 제 컴퓨터가 없어진 거예요! 알고 보니 IT팀에서 업그레이드한다고 가져갔더라고요. 미리 말해주지... 그래서 오전 내내 다른 분 컴퓨터 빌려서 일했네요.\n\n점심시간에는 구내식당에서 또 웃긴 일이 있었어요. 줄 서서 기다리고 있는데 앞사람이 갑자기 뒤돌아보면서 \'혹시 김대리님 아니세요?\' 하는 거예요. 저는 김대리가 아닌데... 그래서 \'아닌데요\'라고 했더니 엄청 민망해하시더라고요.\n\n오후에는 회의가 있었는데, 화상회의 중에 누군가 마이크 안 끄고 라면 먹는 소리가 들려서 다들 빵 터졌어요. 재택근무하시는 분이셨는데 본인은 모르셨나봐요.\n\n이렇게 소소한 일상의 에피소드들이 직장생활을 버티게 해주는 것 같아요. 여러분의 회사 에피소드도 댓글로 공유해주세요!','','','',0,0,582,30,0,'admin','','최고관리자','admin@domain.com','','2025-12-22 11:37:20',0,'2025-12-22 11:37:20','127.0.0.1','','','','','','','','','','','',''),(22,-22,'',22,0,4,'','','','주말에 뭐하시나요? 추천 좀 해주세요 (22)','이번 주말에 뭐 하실 계획이세요? 저는 요즘 집콕만 해서 이번에는 좀 나가볼까 합니다.\n\n근데 막상 나가려니까 뭘 해야 할지 모르겠더라고요. 혼자 카페 가기? 영화 보기? 아니면 근교 드라이브?\n\n제 취향은 이래요:\n- 등산은 좀 힘들어서 패스\n- 카페 투어는 좋아함\n- 사람 많은 곳은 별로\n- 자연 풍경 보는 거 좋아함\n\n서울 근교로 드라이브 가기 좋은 곳이나, 조용한 카페 아시는 분 추천 부탁드려요! 특히 요즘 단풍 예쁜 곳 있으면 알려주세요.\n\n그리고 주말에 혼자 다니시는 분들 계신가요? 처음에는 좀 어색했는데 이제는 혼밥, 혼카페, 혼영화 다 즐기게 됐어요. 혼자만의 시간도 소중하더라고요.','','','',0,0,700,32,0,'admin','','최고관리자','admin@domain.com','','2025-12-22 09:37:20',0,'2025-12-22 09:37:20','127.0.0.1','','','','','','','','','','','',''),(23,-23,'',23,0,4,'','','','요즘 날씨가 너무 좋네요 산책 다녀왔어요 (23)','요즘 날씨가 정말 좋지 않나요? 아침저녁으로는 선선하고, 낮에는 따뜻하고... 딱 나들이 가기 좋은 날씨예요.\n\n저는 오늘 점심시간에 잠깐 회사 근처 공원 산책했는데, 단풍이 정말 예쁘더라고요. 빨강, 노랑, 주황색 나뭇잎들이 햇빛 받아서 반짝반짝...\n\n이런 날씨에 추천하는 활동:\n1. 공원 산책 - 가볍게 걷기만 해도 힐링\n2. 야외 카페 - 테라스 석에서 커피 한 잔\n3. 자전거 타기 - 한강 자전거 도로 추천\n4. 피크닉 - 돗자리 깔고 김밥 먹기\n\n여러분은 이 좋은 날씨에 뭐 하고 계세요? 날씨 좋을 때 즐겨야 해요. 금방 추워질 테니까요.','','','',0,0,229,35,0,'admin','','최고관리자','admin@domain.com','','2025-12-21 09:37:20',0,'2025-12-21 09:37:20','127.0.0.1','','','','','','','','','','','',''),(24,-24,'',24,0,6,'','','','강남역 근처 맛집 추천 부탁드려요 (24)','맛집 추천 부탁드려요! 이번 주에 친구들이랑 모임이 있는데 어디로 가야 할지 모르겠어요.\n\n조건:\n- 위치: 강남역 근처\n- 인원: 4-5명\n- 예산: 1인당 3만원 정도\n- 분위기: 대화하기 좋은 곳\n- 음식: 한식이나 이탈리안\n\n혹시 이 조건에 맞는 곳 아시면 추천해주세요!\n\n참고로 제가 가본 곳 중에 괜찮았던 데는 있는데 다 가봤던 데라서 이번에는 새로운 데 가보고 싶거든요. 숨은 맛집 있으면 공유해주세요!\n\n특히 분위기 좋고 사진 찍기 좋은 곳이면 더 좋겠어요. 요즘 인스타 감성 카페 겸 레스토랑 많잖아요.','','','',0,0,199,29,0,'admin','','최고관리자','admin@domain.com','','2025-12-20 09:37:20',0,'2025-12-20 09:37:20','127.0.0.1','','','','','','','','','','','',''),(25,-25,'',25,0,0,'','','','30대 중반 운동 시작하려는데 조언 부탁드려요 (25)','30대 중반인데 이제서야 운동을 시작하려고 합니다. 그동안 운동이라곤 거의 안 해서 체력이 바닥이에요...\n\n고민되는 게:\n1. 헬스장 vs 홈트 - 뭐가 더 효과적일까요?\n2. PT 받아야 할까요? - 비용이 부담되긴 한데...\n3. 어떤 운동부터 시작해야 할까요?\n\n목표는 일단 체력 기르기랑 뱃살 빼기입니다. 마른 비만이라서 근육은 없고 뱃살만 있어요 ㅠㅠ\n\n운동 잘 아시는 분들 조언 부탁드립니다! 특히 운동 초보가 주의해야 할 점이나 효과적인 루틴 있으면 알려주세요.\n\n그리고 운동하면서 식단 관리도 해야 할까요? 닭가슴살 생활 해야 하나... 막막하네요.','','','',0,0,79,20,0,'admin','','최고관리자','admin@domain.com','','2025-12-19 12:37:20',0,'2025-12-19 12:37:20','127.0.0.1','','','','','','','','','','','',''),(26,-26,'',26,0,1,'','','','재택근무 꿀팁 공유합니다 참고하세요 (26)','재택근무 3년차입니다. 처음에는 집중이 안 돼서 힘들었는데, 이제는 나름의 노하우가 생겼어요.\n\n제 재택근무 꿀팁:\n\n1. 출퇴근 루틴 만들기\n- 출근 시간에 맞춰 샤워하고 옷 갈아입기\n- 퇴근 시간 되면 컴퓨터 끄기\n\n2. 업무 공간 분리\n- 가능하면 별도 방 사용\n- 안 되면 책상이라도 업무 전용으로\n\n3. 집중력 유지\n- 뽀모도로 기법 (25분 집중 + 5분 휴식)\n- 방해 요소 제거 (SNS 알림 끄기)\n\n4. 소통 강화\n- 업무 시작/종료 시 팀 채팅방에 알리기\n- 화상회의 적극 활용\n\n5. 건강 관리\n- 틈틈이 스트레칭\n- 점심시간에 산책\n\n재택근무하시는 분들 다른 팁 있으면 공유해주세요!','','','',0,0,181,28,0,'admin','','최고관리자','admin@domain.com','','2025-12-18 15:37:20',0,'2025-12-18 15:37:20','127.0.0.1','','','','','','','','','','','',''),(27,-27,'',27,0,10,'','','','요즘 읽고 있는 책 추천합니다 (27)','요즘 읽고 있는 책이 너무 좋아서 추천드려요.\n\n제목: \'아주 작은 습관의 힘\' (제임스 클리어)\n\n이 책의 핵심 내용:\n- 1%씩 나아지면 1년 후 37배 성장\n- 습관은 정체성의 변화에서 시작\n- 환경 설계의 중요성\n- 습관 쌓기(habit stacking) 기법\n\n특히 인상 깊었던 구절:\n\"우리는 목표 수준으로 올라가는 것이 아니라 시스템 수준으로 떨어진다.\"\n\n저도 이 책 읽고 아침 루틴을 만들기 시작했어요. 아침에 일어나서 물 한 잔 마시기 → 5분 스트레칭 → 10분 독서 이런 식으로요.\n\n자기계발서 좋아하시는 분들께 강추합니다. 다른 책 추천도 받아요!','','','',0,0,536,50,0,'admin','','최고관리자','admin@domain.com','','2025-12-16 20:37:20',0,'2025-12-16 20:37:20','127.0.0.1','','','','','','','','','','','',''),(28,-28,'',28,0,11,'','','','취미생활 뭐 하시나요? 새로운 취미 찾는 중 (28)','요즘 새로운 취미를 찾고 있어요. 퇴근 후랑 주말에 뭔가 하고 싶은데 뭘 해야 할지 모르겠더라고요.\n\n지금까지 해본 취미:\n- 넷플릭스 정주행 (이건 취미라기보다...)\n- 독서 (꾸준히 하고 있음)\n- 요리 (가끔)\n\n관심 있는 것들:\n- 악기 (기타? 피아노?)\n- 그림 그리기\n- 운동 (클라이밍, 수영 등)\n- 사진 촬영\n\n여러분은 어떤 취미 활동 하시나요? 특히 혼자 할 수 있고, 스트레스 해소에 좋은 취미 있으면 추천해주세요!\n\n비용이나 시간 투자 대비 만족도 높은 취미면 더 좋겠어요.','','','',0,0,287,30,0,'admin','','최고관리자','admin@domain.com','','2025-12-16 02:37:20',0,'2025-12-16 02:37:20','127.0.0.1','','','','','','','','','','','',''),(29,-29,'',29,0,5,'','','','이직 고민 중입니다 조언 부탁드려요 (29)','현재 회사에서 3년째 근무 중인데, 이직을 고민하고 있습니다.\n\n현재 상황:\n- 연봉: 업계 평균 수준\n- 업무: 익숙하지만 성장이 멈춘 느낌\n- 분위기: 나쁘지 않음\n- 워라밸: 괜찮은 편\n\n이직을 고민하는 이유:\n1. 커리어 성장의 한계를 느낌\n2. 새로운 도전을 하고 싶음\n3. 연봉 상승 기대\n\n고민되는 점:\n- 지금 이직 시장이 안 좋다는데...\n- 새 회사가 더 안 좋으면 어쩌지?\n- 3년이면 이직하기 좋은 시기인가?\n\n이직 경험 있으신 분들 조언 부탁드립니다. 어떤 기준으로 결정하셨나요?','이직-고민-중입니다-조언-부탁드려요-29','','',0,0,608,26,0,'admin','','최고관리자','admin@domain.com','','2025-12-14 19:37:20',0,'2025-12-14 19:37:20','127.0.0.1','','','','','','','','','','','',''),(30,-30,'',30,0,0,'','','','연말 계획 세우셨나요? 저는 이렇게 계획 중 (30)','벌써 연말이 다가오네요. 올해도 얼마 안 남았어요.\n\n제 연말 계획:\n\n1. 송년회\n- 회사 송년회 (12월 셋째 주)\n- 친구들 모임 (크리스마스 전 주말)\n- 가족 모임 (크리스마스 당일)\n\n2. 여행\n- 크리스마스 연휴에 1박 2일 여행 계획 중\n- 강원도 쪽으로 갈까 고민\n\n3. 정리\n- 집 대청소\n- 안 입는 옷 정리\n- 1년 회고 작성\n\n4. 새해 목표 설정\n- 운동 계획\n- 재테크 목표\n- 자기계발 계획\n\n여러분은 연말 계획 어떻게 세우셨나요? 특별한 계획 있으면 공유해주세요!','','','',0,0,743,45,0,'admin','','최고관리자','admin@domain.com','','2025-12-14 10:37:20',0,'2025-12-14 10:37:20','127.0.0.1','','','','','','','','','','','',''),(31,-31,'',31,0,15,'','','','아침형 인간 되는 방법 공유합니다 (31)','저도 예전에는 저녁형 인간이었는데, 아침형으로 바꾸고 삶의 질이 확 좋아졌어요.\n\n제가 아침형 인간이 된 방법:\n\n1. 점진적으로 바꾸기\n- 한 번에 2시간 당기지 말고\n- 일주일에 15분씩 앞당기기\n\n2. 저녁 루틴 만들기\n- 밤 10시 이후 스마트폰 안 보기\n- 따뜻한 물로 샤워\n- 독서나 명상\n\n3. 아침에 기대되는 것 만들기\n- 맛있는 아침 메뉴\n- 좋아하는 음악\n- 여유로운 커피 타임\n\n4. 환경 설정\n- 커튼 살짝 열어두기 (자연광)\n- 알람 여러 개 (점점 크게)\n- 알람 멀리 두기\n\n처음 2주가 제일 힘들어요. 그 고비만 넘기면 몸이 적응합니다!','아침형-인간-되는-방법-공유합니다-31','','',0,0,556,29,0,'admin','','최고관리자','admin@domain.com','','2025-12-12 19:37:20',0,'2025-12-12 19:37:20','127.0.0.1','','','','','','','','','','','',''),(32,-32,'',32,0,2,'','','','스트레스 해소법 공유해요 저는 이렇게 해요 (32)','직장인이라면 스트레스 안 받을 수가 없죠. 저만의 스트레스 해소법 공유합니다.\n\n1. 운동\n- 땀 흘리면 스트레스가 날아가요\n- 특히 복싱, 러닝 추천\n\n2. 맛있는 거 먹기\n- 스트레스 받으면 맛있는 거 먹어야죠\n- 단, 폭식은 노노\n\n3. 수다 떨기\n- 친구나 가족과 대화\n- 말하다 보면 정리가 돼요\n\n4. 취미 활동\n- 저는 게임이나 영화 보기\n- 몰입하면 잡생각 사라짐\n\n5. 충분한 수면\n- 잠이 보약\n- 스트레스 받을수록 잘 자야 해요\n\n6. 글쓰기\n- 일기나 감정 노트\n- 쓰다 보면 객관화가 돼요\n\n여러분만의 스트레스 해소법도 공유해주세요!','','','',0,0,573,17,0,'admin','','최고관리자','admin@domain.com','','2025-12-12 21:37:20',0,'2025-12-12 21:37:20','127.0.0.1','','','','','','','','','','','',''),(33,-33,'',33,0,2,'','','','최근에 본 영화 추천합니다 꼭 보세요 (33)','주말에 본 영화가 너무 좋아서 추천드려요.\n\n제목: 오펜하이머\n감독: 크리스토퍼 놀란\n\n놀란 감독 특유의 연출력이 돋보이는 영화였어요. 3시간이 넘는 러닝타임인데 지루할 틈이 없었습니다.\n\n좋았던 점:\n- 킬리언 머피의 연기력\n- 긴장감 넘치는 전개\n- 아이맥스로 보면 더 좋음\n- OST가 압도적\n\n참고사항:\n- 역사적 배경 알고 보면 더 재밌어요\n- 자막 집중해서 봐야 함 (대사 많음)\n\n평점: 9/10\n\n요즘 극장에서 볼 만한 영화 추천받아요. 장르 불문!','','','',0,0,590,37,0,'admin','','최고관리자','admin@domain.com','','2025-12-11 21:37:20',0,'2025-12-11 21:37:20','127.0.0.1','','','','','','','','','','','',''),(34,-34,'',34,0,5,'','','','집에서 할 수 있는 취미 추천해주세요 (34)','요즘 밖에 나가기가 귀찮아서 집에서 할 수 있는 취미를 찾고 있어요.\n\n지금 하고 있는 것:\n- 넷플릭스\n- 유튜브\n- 게임\n\n해보고 싶은 것:\n- 홈베이킹\n- 플랜테리어 (식물 키우기)\n- DIY 소품 만들기\n- 홈트레이닝\n\n집에서 할 수 있는 취미 중에 추천하실 만한 거 있나요?\n\n조건:\n- 초기 비용 너무 안 들었으면\n- 소음 적은 것 (아파트라서)\n- 혼자 할 수 있는 것\n\n특히 손으로 뭔가 만드는 취미에 관심이 있어요. 레고나 프라모델 어떤가요?','','','',0,0,333,29,0,'admin','','최고관리자','admin@domain.com','','2025-12-10 18:37:20',0,'2025-12-10 18:37:20','127.0.0.1','','','','','','','','','','','',''),(35,-35,'',35,0,9,'','','','커피 vs 차 어떤 거 좋아하세요? (35)','저는 원래 커피파였는데 요즘 차에 빠졌어요.\n\n커피의 장점:\n- 확실한 각성 효과\n- 맛있음 (특히 라떼)\n- 카페 분위기\n\n차의 장점:\n- 카페인 적음\n- 다양한 종류\n- 건강에 좋음\n- 따뜻하게 마시면 힐링\n\n요즘 제가 즐겨 마시는 차:\n- 얼그레이\n- 캐모마일 (취침 전)\n- 페퍼민트 (식후)\n- 루이보스\n\n여러분은 커피파? 차파? 아니면 둘 다?\n\n추천하는 차 종류나 카페 있으면 공유해주세요!','','','',0,0,493,41,0,'admin','','최고관리자','admin@domain.com','','2025-12-10 06:37:20',0,'2025-12-10 06:37:20','127.0.0.1','','','','','','','','','','','',''),(36,-36,'',36,0,2,'','','','반려동물 키우시는 분들 질문있어요 (36)','반려동물 입양을 고민 중인데, 현실적인 조언 부탁드려요.\n\n고민되는 점:\n1. 혼자 사는 1인 가구인데 가능할까?\n2. 출장이 가끔 있는데 맡길 곳은?\n3. 비용은 한 달에 얼마나 들까?\n4. 강아지 vs 고양이 뭐가 좋을까?\n\n저의 상황:\n- 원룸 거주\n- 평일 출근 (9시-6시)\n- 주말에는 거의 집에 있음\n- 여행은 1년에 2-3번\n\n키우시는 분들 현실적인 조언 부탁드려요. 예쁜 것만 보고 입양했다가 힘들어하시는 분들 많다고 해서 신중하게 결정하려고요.\n\n특히 처음 키우시는 분들 경험담 들려주세요!','','','',0,0,420,5,0,'admin','','최고관리자','admin@domain.com','','2025-12-09 01:37:20',0,'2025-12-09 01:37:20','127.0.0.1','','','','','','','','','','','',''),(37,-37,'',37,0,13,'','','','요즘 핫한 드라마 뭐예요? 추천해주세요 (37)','넷플릭스에서 볼 드라마 찾고 있어요. 요즘 뭐가 재밌나요?\n\n제가 좋아하는 장르:\n- 스릴러\n- 미스터리\n- SF\n- 로맨스도 가끔\n\n최근에 본 것들:\n- 오징어 게임 (재밌었음)\n- 더 글로리 (몰입감 최고)\n- 무빙 (액션 굿)\n\n안 좋아하는 것:\n- 너무 무거운 거\n- 시즌 너무 긴 거\n- 결말 흐지부지\n\n추천해주실 드라마 있으면 알려주세요! 해외 드라마도 좋아요.\n\n넷플릭스 말고 디즈니+, 웨이브 등 다른 OTT 추천도 환영합니다.','','','',0,0,515,26,0,'admin','','최고관리자','admin@domain.com','','2025-12-08 11:37:20',0,'2025-12-08 11:37:20','127.0.0.1','','','','','','','','','','','',''),(38,-38,'',38,0,7,'','','','자기계발 어떻게 하시나요? 루틴 공유 (38)','올해 자기계발 목표를 세웠는데, 꾸준히 하기가 어렵네요.\n\n제 목표:\n1. 영어 공부 - 토익 900점\n2. 자격증 - 정보처리기사\n3. 독서 - 월 2권\n4. 운동 - 주 3회\n\n현실:\n- 영어 앱 깔아놓고 안 함\n- 자격증 책 사놓고 안 봄\n- 독서 1월에 1권 읽고 끝\n- 운동 헬스장 등록만 함\n\n작심삼일을 벗어나는 방법 있을까요?\n\n꾸준히 자기계발 하시는 분들 루틴이나 팁 공유해주세요. 특히 퇴근 후 시간 활용법이 궁금해요.','','','',0,0,643,19,0,'admin','','최고관리자','admin@domain.com','','2025-12-07 15:37:20',0,'2025-12-07 15:37:20','127.0.0.1','','','','','','','','','','','',''),(39,-39,'',39,0,0,'','','','출퇴근 시간 활용법 알려드려요 (39)','출퇴근 시간이 왕복 2시간인데, 이 시간을 알차게 보내는 방법 공유해요.\n\n제 출퇴근 루틴:\n\n아침 (1시간):\n- 오디오북 듣기 (30분)\n- 뉴스 기사 읽기 (20분)\n- 하루 계획 정리 (10분)\n\n저녁 (1시간):\n- 팟캐스트 듣기 (30분)\n- 영어 공부 (20분)\n- SNS, 유튜브 (10분)\n\n추천하는 콘텐츠:\n- 오디오북: 밀리의 서재\n- 팟캐스트: 과학기술 관련\n- 영어: 영어회화 앱\n\n이렇게 하니까 1년에 책 20권 정도 듣더라고요. 시간 낭비하는 것 같던 출퇴근이 생산적으로 바뀌었어요.\n\n다른 분들 출퇴근 시간 활용법도 공유해주세요!','','','',0,0,63,4,0,'admin','','최고관리자','admin@domain.com','','2025-12-05 18:37:20',0,'2025-12-05 18:37:20','127.0.0.1','','','','','','','','','','','',''),(40,-40,'',40,0,8,'','','','건강관리 팁 공유합니다 30대 필독 (40)','30대 들어서 건강이 예전 같지 않더라고요. 그래서 관리 시작했어요.\n\n제 건강관리 루틴:\n\n1. 식단\n- 아침 꼭 먹기\n- 야채 많이\n- 야식 자제\n- 물 2L\n\n2. 운동\n- 주 3회 헬스\n- 매일 스트레칭\n- 주말 산책\n\n3. 수면\n- 11시 취침 목표\n- 6시간 이상\n- 주말에도 일정하게\n\n4. 정기검진\n- 연 1회 건강검진\n- 치과 6개월마다\n\n5. 멘탈 관리\n- 명상 앱 활용\n- 취미 생활\n- 친구 만나기\n\n30대 되니까 관리 안 하면 바로 티가 나요. 미리미리 관리합시다!','','','',0,0,120,34,0,'admin','','최고관리자','admin@domain.com','','2025-12-05 09:37:20',0,'2025-12-05 09:37:20','127.0.0.1','','','','','','','','','','','',''),(41,-41,'',41,0,7,'','','','오늘 회사에서 있었던 황당한 일 공유합니다 (41)','안녕하세요, 오늘 회사에서 정말 황당한 일이 있었어요.\n\n아침에 출근해서 자리에 앉았는데, 제 컴퓨터가 없어진 거예요! 알고 보니 IT팀에서 업그레이드한다고 가져갔더라고요. 미리 말해주지... 그래서 오전 내내 다른 분 컴퓨터 빌려서 일했네요.\n\n점심시간에는 구내식당에서 또 웃긴 일이 있었어요. 줄 서서 기다리고 있는데 앞사람이 갑자기 뒤돌아보면서 \'혹시 김대리님 아니세요?\' 하는 거예요. 저는 김대리가 아닌데... 그래서 \'아닌데요\'라고 했더니 엄청 민망해하시더라고요.\n\n오후에는 회의가 있었는데, 화상회의 중에 누군가 마이크 안 끄고 라면 먹는 소리가 들려서 다들 빵 터졌어요. 재택근무하시는 분이셨는데 본인은 모르셨나봐요.\n\n이렇게 소소한 일상의 에피소드들이 직장생활을 버티게 해주는 것 같아요. 여러분의 회사 에피소드도 댓글로 공유해주세요!','','','',0,0,368,3,0,'admin','','최고관리자','admin@domain.com','','2025-12-04 15:37:20',0,'2025-12-04 15:37:20','127.0.0.1','','','','','','','','','','','',''),(42,-42,'',42,0,11,'','','','주말에 뭐하시나요? 추천 좀 해주세요 (42)','이번 주말에 뭐 하실 계획이세요? 저는 요즘 집콕만 해서 이번에는 좀 나가볼까 합니다.\n\n근데 막상 나가려니까 뭘 해야 할지 모르겠더라고요. 혼자 카페 가기? 영화 보기? 아니면 근교 드라이브?\n\n제 취향은 이래요:\n- 등산은 좀 힘들어서 패스\n- 카페 투어는 좋아함\n- 사람 많은 곳은 별로\n- 자연 풍경 보는 거 좋아함\n\n서울 근교로 드라이브 가기 좋은 곳이나, 조용한 카페 아시는 분 추천 부탁드려요! 특히 요즘 단풍 예쁜 곳 있으면 알려주세요.\n\n그리고 주말에 혼자 다니시는 분들 계신가요? 처음에는 좀 어색했는데 이제는 혼밥, 혼카페, 혼영화 다 즐기게 됐어요. 혼자만의 시간도 소중하더라고요.','','','',0,0,312,40,0,'admin','','최고관리자','admin@domain.com','','2025-12-04 06:37:20',0,'2025-12-04 06:37:20','127.0.0.1','','','','','','','','','','','',''),(43,-43,'',43,0,0,'','','','요즘 날씨가 너무 좋네요 산책 다녀왔어요 (43)','요즘 날씨가 정말 좋지 않나요? 아침저녁으로는 선선하고, 낮에는 따뜻하고... 딱 나들이 가기 좋은 날씨예요.\n\n저는 오늘 점심시간에 잠깐 회사 근처 공원 산책했는데, 단풍이 정말 예쁘더라고요. 빨강, 노랑, 주황색 나뭇잎들이 햇빛 받아서 반짝반짝...\n\n이런 날씨에 추천하는 활동:\n1. 공원 산책 - 가볍게 걷기만 해도 힐링\n2. 야외 카페 - 테라스 석에서 커피 한 잔\n3. 자전거 타기 - 한강 자전거 도로 추천\n4. 피크닉 - 돗자리 깔고 김밥 먹기\n\n여러분은 이 좋은 날씨에 뭐 하고 계세요? 날씨 좋을 때 즐겨야 해요. 금방 추워질 테니까요.','','','',0,0,434,17,0,'admin','','최고관리자','admin@domain.com','','2025-12-02 23:37:20',0,'2025-12-02 23:37:20','127.0.0.1','','','','','','','','','','','',''),(44,-44,'',44,0,10,'','','','강남역 근처 맛집 추천 부탁드려요 (44)','맛집 추천 부탁드려요! 이번 주에 친구들이랑 모임이 있는데 어디로 가야 할지 모르겠어요.\n\n조건:\n- 위치: 강남역 근처\n- 인원: 4-5명\n- 예산: 1인당 3만원 정도\n- 분위기: 대화하기 좋은 곳\n- 음식: 한식이나 이탈리안\n\n혹시 이 조건에 맞는 곳 아시면 추천해주세요!\n\n참고로 제가 가본 곳 중에 괜찮았던 데는 있는데 다 가봤던 데라서 이번에는 새로운 데 가보고 싶거든요. 숨은 맛집 있으면 공유해주세요!\n\n특히 분위기 좋고 사진 찍기 좋은 곳이면 더 좋겠어요. 요즘 인스타 감성 카페 겸 레스토랑 많잖아요.','','','',0,0,174,11,0,'admin','','최고관리자','admin@domain.com','','2025-12-02 15:37:20',0,'2025-12-02 15:37:20','127.0.0.1','','','','','','','','','','','',''),(45,-45,'',45,0,15,'','','','30대 중반 운동 시작하려는데 조언 부탁드려요 (45)','30대 중반인데 이제서야 운동을 시작하려고 합니다. 그동안 운동이라곤 거의 안 해서 체력이 바닥이에요...\n\n고민되는 게:\n1. 헬스장 vs 홈트 - 뭐가 더 효과적일까요?\n2. PT 받아야 할까요? - 비용이 부담되긴 한데...\n3. 어떤 운동부터 시작해야 할까요?\n\n목표는 일단 체력 기르기랑 뱃살 빼기입니다. 마른 비만이라서 근육은 없고 뱃살만 있어요 ㅠㅠ\n\n운동 잘 아시는 분들 조언 부탁드립니다! 특히 운동 초보가 주의해야 할 점이나 효과적인 루틴 있으면 알려주세요.\n\n그리고 운동하면서 식단 관리도 해야 할까요? 닭가슴살 생활 해야 하나... 막막하네요.','','','',0,0,498,49,0,'admin','','최고관리자','admin@domain.com','','2025-11-30 20:37:20',0,'2025-11-30 20:37:20','127.0.0.1','','','','','','','','','','','',''),(46,-46,'',46,0,14,'','','','재택근무 꿀팁 공유합니다 참고하세요 (46)','재택근무 3년차입니다. 처음에는 집중이 안 돼서 힘들었는데, 이제는 나름의 노하우가 생겼어요.\n\n제 재택근무 꿀팁:\n\n1. 출퇴근 루틴 만들기\n- 출근 시간에 맞춰 샤워하고 옷 갈아입기\n- 퇴근 시간 되면 컴퓨터 끄기\n\n2. 업무 공간 분리\n- 가능하면 별도 방 사용\n- 안 되면 책상이라도 업무 전용으로\n\n3. 집중력 유지\n- 뽀모도로 기법 (25분 집중 + 5분 휴식)\n- 방해 요소 제거 (SNS 알림 끄기)\n\n4. 소통 강화\n- 업무 시작/종료 시 팀 채팅방에 알리기\n- 화상회의 적극 활용\n\n5. 건강 관리\n- 틈틈이 스트레칭\n- 점심시간에 산책\n\n재택근무하시는 분들 다른 팁 있으면 공유해주세요!','','','',0,0,359,43,0,'admin','','최고관리자','admin@domain.com','','2025-11-30 07:37:20',0,'2025-11-30 07:37:20','127.0.0.1','','','','','','','','','','','',''),(47,-47,'',47,0,8,'','','','요즘 읽고 있는 책 추천합니다 (47)','요즘 읽고 있는 책이 너무 좋아서 추천드려요.\n\n제목: \'아주 작은 습관의 힘\' (제임스 클리어)\n\n이 책의 핵심 내용:\n- 1%씩 나아지면 1년 후 37배 성장\n- 습관은 정체성의 변화에서 시작\n- 환경 설계의 중요성\n- 습관 쌓기(habit stacking) 기법\n\n특히 인상 깊었던 구절:\n\"우리는 목표 수준으로 올라가는 것이 아니라 시스템 수준으로 떨어진다.\"\n\n저도 이 책 읽고 아침 루틴을 만들기 시작했어요. 아침에 일어나서 물 한 잔 마시기 → 5분 스트레칭 → 10분 독서 이런 식으로요.\n\n자기계발서 좋아하시는 분들께 강추합니다. 다른 책 추천도 받아요!','','','',0,0,170,47,0,'admin','','최고관리자','admin@domain.com','','2025-11-28 22:37:20',0,'2025-11-28 22:37:20','127.0.0.1','','','','','','','','','','','',''),(48,-48,'',48,0,10,'','','','취미생활 뭐 하시나요? 새로운 취미 찾는 중 (48)','요즘 새로운 취미를 찾고 있어요. 퇴근 후랑 주말에 뭔가 하고 싶은데 뭘 해야 할지 모르겠더라고요.\n\n지금까지 해본 취미:\n- 넷플릭스 정주행 (이건 취미라기보다...)\n- 독서 (꾸준히 하고 있음)\n- 요리 (가끔)\n\n관심 있는 것들:\n- 악기 (기타? 피아노?)\n- 그림 그리기\n- 운동 (클라이밍, 수영 등)\n- 사진 촬영\n\n여러분은 어떤 취미 활동 하시나요? 특히 혼자 할 수 있고, 스트레스 해소에 좋은 취미 있으면 추천해주세요!\n\n비용이나 시간 투자 대비 만족도 높은 취미면 더 좋겠어요.','','','',0,0,524,6,0,'admin','','최고관리자','admin@domain.com','','2025-11-28 07:37:20',0,'2025-11-28 07:37:20','127.0.0.1','','','','','','','','','','','',''),(49,-49,'',49,0,0,'','','','이직 고민 중입니다 조언 부탁드려요 (49)','현재 회사에서 3년째 근무 중인데, 이직을 고민하고 있습니다.\n\n현재 상황:\n- 연봉: 업계 평균 수준\n- 업무: 익숙하지만 성장이 멈춘 느낌\n- 분위기: 나쁘지 않음\n- 워라밸: 괜찮은 편\n\n이직을 고민하는 이유:\n1. 커리어 성장의 한계를 느낌\n2. 새로운 도전을 하고 싶음\n3. 연봉 상승 기대\n\n고민되는 점:\n- 지금 이직 시장이 안 좋다는데...\n- 새 회사가 더 안 좋으면 어쩌지?\n- 3년이면 이직하기 좋은 시기인가?\n\n이직 경험 있으신 분들 조언 부탁드립니다. 어떤 기준으로 결정하셨나요?','이직-고민-중입니다-조언-부탁드려요-49','','',0,0,499,19,0,'admin','','최고관리자','admin@domain.com','','2025-11-26 22:37:20',0,'2025-11-26 22:37:20','127.0.0.1','','','','','','','','','','','',''),(50,-50,'',50,0,13,'','','','연말 계획 세우셨나요? 저는 이렇게 계획 중 (50)','벌써 연말이 다가오네요. 올해도 얼마 안 남았어요.\n\n제 연말 계획:\n\n1. 송년회\n- 회사 송년회 (12월 셋째 주)\n- 친구들 모임 (크리스마스 전 주말)\n- 가족 모임 (크리스마스 당일)\n\n2. 여행\n- 크리스마스 연휴에 1박 2일 여행 계획 중\n- 강원도 쪽으로 갈까 고민\n\n3. 정리\n- 집 대청소\n- 안 입는 옷 정리\n- 1년 회고 작성\n\n4. 새해 목표 설정\n- 운동 계획\n- 재테크 목표\n- 자기계발 계획\n\n여러분은 연말 계획 어떻게 세우셨나요? 특별한 계획 있으면 공유해주세요!','','','',0,0,256,26,0,'admin','','최고관리자','admin@domain.com','','2025-11-26 05:37:20',0,'2025-11-26 05:37:20','127.0.0.1','','','','','','','','','','','',''),(51,-51,'',51,0,11,'','','','아침형 인간 되는 방법 공유합니다 (51)','저도 예전에는 저녁형 인간이었는데, 아침형으로 바꾸고 삶의 질이 확 좋아졌어요.\n\n제가 아침형 인간이 된 방법:\n\n1. 점진적으로 바꾸기\n- 한 번에 2시간 당기지 말고\n- 일주일에 15분씩 앞당기기\n\n2. 저녁 루틴 만들기\n- 밤 10시 이후 스마트폰 안 보기\n- 따뜻한 물로 샤워\n- 독서나 명상\n\n3. 아침에 기대되는 것 만들기\n- 맛있는 아침 메뉴\n- 좋아하는 음악\n- 여유로운 커피 타임\n\n4. 환경 설정\n- 커튼 살짝 열어두기 (자연광)\n- 알람 여러 개 (점점 크게)\n- 알람 멀리 두기\n\n처음 2주가 제일 힘들어요. 그 고비만 넘기면 몸이 적응합니다!','아침형-인간-되는-방법-공유합니다-51','','',0,0,632,2,0,'admin','','최고관리자','admin@domain.com','','2025-11-24 18:37:20',0,'2025-11-24 18:37:20','127.0.0.1','','','','','','','','','','','',''),(52,-52,'',52,0,0,'','','','스트레스 해소법 공유해요 저는 이렇게 해요 (52)','직장인이라면 스트레스 안 받을 수가 없죠. 저만의 스트레스 해소법 공유합니다.\n\n1. 운동\n- 땀 흘리면 스트레스가 날아가요\n- 특히 복싱, 러닝 추천\n\n2. 맛있는 거 먹기\n- 스트레스 받으면 맛있는 거 먹어야죠\n- 단, 폭식은 노노\n\n3. 수다 떨기\n- 친구나 가족과 대화\n- 말하다 보면 정리가 돼요\n\n4. 취미 활동\n- 저는 게임이나 영화 보기\n- 몰입하면 잡생각 사라짐\n\n5. 충분한 수면\n- 잠이 보약\n- 스트레스 받을수록 잘 자야 해요\n\n6. 글쓰기\n- 일기나 감정 노트\n- 쓰다 보면 객관화가 돼요\n\n여러분만의 스트레스 해소법도 공유해주세요!','','','',0,0,687,47,0,'admin','','최고관리자','admin@domain.com','','2025-11-25 08:37:20',0,'2025-11-25 08:37:20','127.0.0.1','','','','','','','','','','','',''),(53,-53,'',53,0,9,'','','','최근에 본 영화 추천합니다 꼭 보세요 (53)','주말에 본 영화가 너무 좋아서 추천드려요.\n\n제목: 오펜하이머\n감독: 크리스토퍼 놀란\n\n놀란 감독 특유의 연출력이 돋보이는 영화였어요. 3시간이 넘는 러닝타임인데 지루할 틈이 없었습니다.\n\n좋았던 점:\n- 킬리언 머피의 연기력\n- 긴장감 넘치는 전개\n- 아이맥스로 보면 더 좋음\n- OST가 압도적\n\n참고사항:\n- 역사적 배경 알고 보면 더 재밌어요\n- 자막 집중해서 봐야 함 (대사 많음)\n\n평점: 9/10\n\n요즘 극장에서 볼 만한 영화 추천받아요. 장르 불문!','','','',0,0,136,47,0,'admin','','최고관리자','admin@domain.com','','2025-11-24 04:37:20',0,'2025-11-24 04:37:20','127.0.0.1','','','','','','','','','','','',''),(54,-54,'',54,0,13,'','','','집에서 할 수 있는 취미 추천해주세요 (54)','요즘 밖에 나가기가 귀찮아서 집에서 할 수 있는 취미를 찾고 있어요.\n\n지금 하고 있는 것:\n- 넷플릭스\n- 유튜브\n- 게임\n\n해보고 싶은 것:\n- 홈베이킹\n- 플랜테리어 (식물 키우기)\n- DIY 소품 만들기\n- 홈트레이닝\n\n집에서 할 수 있는 취미 중에 추천하실 만한 거 있나요?\n\n조건:\n- 초기 비용 너무 안 들었으면\n- 소음 적은 것 (아파트라서)\n- 혼자 할 수 있는 것\n\n특히 손으로 뭔가 만드는 취미에 관심이 있어요. 레고나 프라모델 어떤가요?','','','',0,0,439,48,0,'admin','','최고관리자','admin@domain.com','','2025-11-23 00:37:20',0,'2025-11-23 00:37:20','127.0.0.1','','','','','','','','','','','',''),(55,-55,'',55,0,3,'','','','커피 vs 차 어떤 거 좋아하세요? (55)','저는 원래 커피파였는데 요즘 차에 빠졌어요.\n\n커피의 장점:\n- 확실한 각성 효과\n- 맛있음 (특히 라떼)\n- 카페 분위기\n\n차의 장점:\n- 카페인 적음\n- 다양한 종류\n- 건강에 좋음\n- 따뜻하게 마시면 힐링\n\n요즘 제가 즐겨 마시는 차:\n- 얼그레이\n- 캐모마일 (취침 전)\n- 페퍼민트 (식후)\n- 루이보스\n\n여러분은 커피파? 차파? 아니면 둘 다?\n\n추천하는 차 종류나 카페 있으면 공유해주세요!','커피-vs-차-어떤-거-좋아하세요-55','','',0,0,606,15,0,'admin','','최고관리자','admin@domain.com','','2025-11-22 11:37:20',0,'2025-11-22 11:37:20','127.0.0.1','','','','','','','','','','','',''),(56,-56,'',56,0,5,'','','','반려동물 키우시는 분들 질문있어요 (56)','반려동물 입양을 고민 중인데, 현실적인 조언 부탁드려요.\n\n고민되는 점:\n1. 혼자 사는 1인 가구인데 가능할까?\n2. 출장이 가끔 있는데 맡길 곳은?\n3. 비용은 한 달에 얼마나 들까?\n4. 강아지 vs 고양이 뭐가 좋을까?\n\n저의 상황:\n- 원룸 거주\n- 평일 출근 (9시-6시)\n- 주말에는 거의 집에 있음\n- 여행은 1년에 2-3번\n\n키우시는 분들 현실적인 조언 부탁드려요. 예쁜 것만 보고 입양했다가 힘들어하시는 분들 많다고 해서 신중하게 결정하려고요.\n\n특히 처음 키우시는 분들 경험담 들려주세요!','','','',0,0,523,0,0,'admin','','최고관리자','admin@domain.com','','2025-11-21 14:37:20',0,'2025-11-21 14:37:20','127.0.0.1','','','','','','','','','','','',''),(57,-57,'',57,0,2,'','','','요즘 핫한 드라마 뭐예요? 추천해주세요 (57)','넷플릭스에서 볼 드라마 찾고 있어요. 요즘 뭐가 재밌나요?\n\n제가 좋아하는 장르:\n- 스릴러\n- 미스터리\n- SF\n- 로맨스도 가끔\n\n최근에 본 것들:\n- 오징어 게임 (재밌었음)\n- 더 글로리 (몰입감 최고)\n- 무빙 (액션 굿)\n\n안 좋아하는 것:\n- 너무 무거운 거\n- 시즌 너무 긴 거\n- 결말 흐지부지\n\n추천해주실 드라마 있으면 알려주세요! 해외 드라마도 좋아요.\n\n넷플릭스 말고 디즈니+, 웨이브 등 다른 OTT 추천도 환영합니다.','','','',0,0,298,29,0,'admin','','최고관리자','admin@domain.com','','2025-11-20 08:37:20',0,'2025-11-20 08:37:20','127.0.0.1','','','','','','','','','','','',''),(58,-58,'',58,0,15,'','','','자기계발 어떻게 하시나요? 루틴 공유 (58)','올해 자기계발 목표를 세웠는데, 꾸준히 하기가 어렵네요.\n\n제 목표:\n1. 영어 공부 - 토익 900점\n2. 자격증 - 정보처리기사\n3. 독서 - 월 2권\n4. 운동 - 주 3회\n\n현실:\n- 영어 앱 깔아놓고 안 함\n- 자격증 책 사놓고 안 봄\n- 독서 1월에 1권 읽고 끝\n- 운동 헬스장 등록만 함\n\n작심삼일을 벗어나는 방법 있을까요?\n\n꾸준히 자기계발 하시는 분들 루틴이나 팁 공유해주세요. 특히 퇴근 후 시간 활용법이 궁금해요.','','','',0,0,793,20,0,'admin','','최고관리자','admin@domain.com','','2025-11-19 05:37:20',0,'2025-11-19 05:37:20','127.0.0.1','','','','','','','','','','','',''),(59,-59,'',59,0,10,'','','','출퇴근 시간 활용법 알려드려요 (59)','출퇴근 시간이 왕복 2시간인데, 이 시간을 알차게 보내는 방법 공유해요.\n\n제 출퇴근 루틴:\n\n아침 (1시간):\n- 오디오북 듣기 (30분)\n- 뉴스 기사 읽기 (20분)\n- 하루 계획 정리 (10분)\n\n저녁 (1시간):\n- 팟캐스트 듣기 (30분)\n- 영어 공부 (20분)\n- SNS, 유튜브 (10분)\n\n추천하는 콘텐츠:\n- 오디오북: 밀리의 서재\n- 팟캐스트: 과학기술 관련\n- 영어: 영어회화 앱\n\n이렇게 하니까 1년에 책 20권 정도 듣더라고요. 시간 낭비하는 것 같던 출퇴근이 생산적으로 바뀌었어요.\n\n다른 분들 출퇴근 시간 활용법도 공유해주세요!','','','',0,0,279,22,0,'admin','','최고관리자','admin@domain.com','','2025-11-18 05:37:20',0,'2025-11-18 05:37:20','127.0.0.1','','','','','','','','','','','',''),(60,-60,'',60,0,13,'','','','건강관리 팁 공유합니다 30대 필독 (60)','30대 들어서 건강이 예전 같지 않더라고요. 그래서 관리 시작했어요.\n\n제 건강관리 루틴:\n\n1. 식단\n- 아침 꼭 먹기\n- 야채 많이\n- 야식 자제\n- 물 2L\n\n2. 운동\n- 주 3회 헬스\n- 매일 스트레칭\n- 주말 산책\n\n3. 수면\n- 11시 취침 목표\n- 6시간 이상\n- 주말에도 일정하게\n\n4. 정기검진\n- 연 1회 건강검진\n- 치과 6개월마다\n\n5. 멘탈 관리\n- 명상 앱 활용\n- 취미 생활\n- 친구 만나기\n\n30대 되니까 관리 안 하면 바로 티가 나요. 미리미리 관리합시다!','','','',0,0,205,26,0,'admin','','최고관리자','admin@domain.com','','2025-11-16 20:37:20',0,'2025-11-16 20:37:20','127.0.0.1','','','','','','','','','','','',''),(61,-61,'',61,0,1,'','','','오늘 회사에서 있었던 황당한 일 공유합니다 (61)','안녕하세요, 오늘 회사에서 정말 황당한 일이 있었어요.\n\n아침에 출근해서 자리에 앉았는데, 제 컴퓨터가 없어진 거예요! 알고 보니 IT팀에서 업그레이드한다고 가져갔더라고요. 미리 말해주지... 그래서 오전 내내 다른 분 컴퓨터 빌려서 일했네요.\n\n점심시간에는 구내식당에서 또 웃긴 일이 있었어요. 줄 서서 기다리고 있는데 앞사람이 갑자기 뒤돌아보면서 \'혹시 김대리님 아니세요?\' 하는 거예요. 저는 김대리가 아닌데... 그래서 \'아닌데요\'라고 했더니 엄청 민망해하시더라고요.\n\n오후에는 회의가 있었는데, 화상회의 중에 누군가 마이크 안 끄고 라면 먹는 소리가 들려서 다들 빵 터졌어요. 재택근무하시는 분이셨는데 본인은 모르셨나봐요.\n\n이렇게 소소한 일상의 에피소드들이 직장생활을 버티게 해주는 것 같아요. 여러분의 회사 에피소드도 댓글로 공유해주세요!','','','',0,0,595,40,0,'admin','','최고관리자','admin@domain.com','','2025-11-16 03:37:20',0,'2025-11-16 03:37:20','127.0.0.1','','','','','','','','','','','',''),(62,-62,'',62,0,15,'','','','주말에 뭐하시나요? 추천 좀 해주세요 (62)','이번 주말에 뭐 하실 계획이세요? 저는 요즘 집콕만 해서 이번에는 좀 나가볼까 합니다.\n\n근데 막상 나가려니까 뭘 해야 할지 모르겠더라고요. 혼자 카페 가기? 영화 보기? 아니면 근교 드라이브?\n\n제 취향은 이래요:\n- 등산은 좀 힘들어서 패스\n- 카페 투어는 좋아함\n- 사람 많은 곳은 별로\n- 자연 풍경 보는 거 좋아함\n\n서울 근교로 드라이브 가기 좋은 곳이나, 조용한 카페 아시는 분 추천 부탁드려요! 특히 요즘 단풍 예쁜 곳 있으면 알려주세요.\n\n그리고 주말에 혼자 다니시는 분들 계신가요? 처음에는 좀 어색했는데 이제는 혼밥, 혼카페, 혼영화 다 즐기게 됐어요. 혼자만의 시간도 소중하더라고요.','','','',0,0,421,39,0,'admin','','최고관리자','admin@domain.com','','2025-11-15 21:37:20',0,'2025-11-15 21:37:20','127.0.0.1','','','','','','','','','','','',''),(63,-63,'',63,0,15,'','','','요즘 날씨가 너무 좋네요 산책 다녀왔어요 (63)','요즘 날씨가 정말 좋지 않나요? 아침저녁으로는 선선하고, 낮에는 따뜻하고... 딱 나들이 가기 좋은 날씨예요.\n\n저는 오늘 점심시간에 잠깐 회사 근처 공원 산책했는데, 단풍이 정말 예쁘더라고요. 빨강, 노랑, 주황색 나뭇잎들이 햇빛 받아서 반짝반짝...\n\n이런 날씨에 추천하는 활동:\n1. 공원 산책 - 가볍게 걷기만 해도 힐링\n2. 야외 카페 - 테라스 석에서 커피 한 잔\n3. 자전거 타기 - 한강 자전거 도로 추천\n4. 피크닉 - 돗자리 깔고 김밥 먹기\n\n여러분은 이 좋은 날씨에 뭐 하고 계세요? 날씨 좋을 때 즐겨야 해요. 금방 추워질 테니까요.','','','',0,0,538,12,0,'admin','','최고관리자','admin@domain.com','','2025-11-15 12:37:20',0,'2025-11-15 12:37:20','127.0.0.1','','','','','','','','','','','',''),(64,-64,'',64,0,5,'','','','강남역 근처 맛집 추천 부탁드려요 (64)','맛집 추천 부탁드려요! 이번 주에 친구들이랑 모임이 있는데 어디로 가야 할지 모르겠어요.\n\n조건:\n- 위치: 강남역 근처\n- 인원: 4-5명\n- 예산: 1인당 3만원 정도\n- 분위기: 대화하기 좋은 곳\n- 음식: 한식이나 이탈리안\n\n혹시 이 조건에 맞는 곳 아시면 추천해주세요!\n\n참고로 제가 가본 곳 중에 괜찮았던 데는 있는데 다 가봤던 데라서 이번에는 새로운 데 가보고 싶거든요. 숨은 맛집 있으면 공유해주세요!\n\n특히 분위기 좋고 사진 찍기 좋은 곳이면 더 좋겠어요. 요즘 인스타 감성 카페 겸 레스토랑 많잖아요.','','','',0,0,470,30,0,'admin','','최고관리자','admin@domain.com','','2025-11-13 22:37:20',0,'2025-11-13 22:37:20','127.0.0.1','','','','','','','','','','','',''),(65,-65,'',65,0,2,'','','','30대 중반 운동 시작하려는데 조언 부탁드려요 (65)','30대 중반인데 이제서야 운동을 시작하려고 합니다. 그동안 운동이라곤 거의 안 해서 체력이 바닥이에요...\n\n고민되는 게:\n1. 헬스장 vs 홈트 - 뭐가 더 효과적일까요?\n2. PT 받아야 할까요? - 비용이 부담되긴 한데...\n3. 어떤 운동부터 시작해야 할까요?\n\n목표는 일단 체력 기르기랑 뱃살 빼기입니다. 마른 비만이라서 근육은 없고 뱃살만 있어요 ㅠㅠ\n\n운동 잘 아시는 분들 조언 부탁드립니다! 특히 운동 초보가 주의해야 할 점이나 효과적인 루틴 있으면 알려주세요.\n\n그리고 운동하면서 식단 관리도 해야 할까요? 닭가슴살 생활 해야 하나... 막막하네요.','','','',0,0,559,50,0,'admin','','최고관리자','admin@domain.com','','2025-11-13 01:37:20',0,'2025-11-13 01:37:20','127.0.0.1','','','','','','','','','','','',''),(66,-66,'',66,0,10,'','','','재택근무 꿀팁 공유합니다 참고하세요 (66)','재택근무 3년차입니다. 처음에는 집중이 안 돼서 힘들었는데, 이제는 나름의 노하우가 생겼어요.\n\n제 재택근무 꿀팁:\n\n1. 출퇴근 루틴 만들기\n- 출근 시간에 맞춰 샤워하고 옷 갈아입기\n- 퇴근 시간 되면 컴퓨터 끄기\n\n2. 업무 공간 분리\n- 가능하면 별도 방 사용\n- 안 되면 책상이라도 업무 전용으로\n\n3. 집중력 유지\n- 뽀모도로 기법 (25분 집중 + 5분 휴식)\n- 방해 요소 제거 (SNS 알림 끄기)\n\n4. 소통 강화\n- 업무 시작/종료 시 팀 채팅방에 알리기\n- 화상회의 적극 활용\n\n5. 건강 관리\n- 틈틈이 스트레칭\n- 점심시간에 산책\n\n재택근무하시는 분들 다른 팁 있으면 공유해주세요!','','','',0,0,696,44,0,'admin','','최고관리자','admin@domain.com','','2025-11-11 16:37:20',0,'2025-11-11 16:37:20','127.0.0.1','','','','','','','','','','','',''),(67,-67,'',67,0,10,'','','','요즘 읽고 있는 책 추천합니다 (67)','요즘 읽고 있는 책이 너무 좋아서 추천드려요.\n\n제목: \'아주 작은 습관의 힘\' (제임스 클리어)\n\n이 책의 핵심 내용:\n- 1%씩 나아지면 1년 후 37배 성장\n- 습관은 정체성의 변화에서 시작\n- 환경 설계의 중요성\n- 습관 쌓기(habit stacking) 기법\n\n특히 인상 깊었던 구절:\n\"우리는 목표 수준으로 올라가는 것이 아니라 시스템 수준으로 떨어진다.\"\n\n저도 이 책 읽고 아침 루틴을 만들기 시작했어요. 아침에 일어나서 물 한 잔 마시기 → 5분 스트레칭 → 10분 독서 이런 식으로요.\n\n자기계발서 좋아하시는 분들께 강추합니다. 다른 책 추천도 받아요!','','','',0,0,103,32,0,'admin','','최고관리자','admin@domain.com','','2025-11-11 08:37:20',0,'2025-11-11 08:37:20','127.0.0.1','','','','','','','','','','','',''),(68,-68,'',68,0,4,'','','','취미생활 뭐 하시나요? 새로운 취미 찾는 중 (68)','요즘 새로운 취미를 찾고 있어요. 퇴근 후랑 주말에 뭔가 하고 싶은데 뭘 해야 할지 모르겠더라고요.\n\n지금까지 해본 취미:\n- 넷플릭스 정주행 (이건 취미라기보다...)\n- 독서 (꾸준히 하고 있음)\n- 요리 (가끔)\n\n관심 있는 것들:\n- 악기 (기타? 피아노?)\n- 그림 그리기\n- 운동 (클라이밍, 수영 등)\n- 사진 촬영\n\n여러분은 어떤 취미 활동 하시나요? 특히 혼자 할 수 있고, 스트레스 해소에 좋은 취미 있으면 추천해주세요!\n\n비용이나 시간 투자 대비 만족도 높은 취미면 더 좋겠어요.','','','',0,0,596,3,0,'admin','','최고관리자','admin@domain.com','','2025-11-10 12:37:20',0,'2025-11-10 12:37:20','127.0.0.1','','','','','','','','','','','',''),(69,-69,'',69,0,9,'','','','이직 고민 중입니다 조언 부탁드려요 (69)','현재 회사에서 3년째 근무 중인데, 이직을 고민하고 있습니다.\n\n현재 상황:\n- 연봉: 업계 평균 수준\n- 업무: 익숙하지만 성장이 멈춘 느낌\n- 분위기: 나쁘지 않음\n- 워라밸: 괜찮은 편\n\n이직을 고민하는 이유:\n1. 커리어 성장의 한계를 느낌\n2. 새로운 도전을 하고 싶음\n3. 연봉 상승 기대\n\n고민되는 점:\n- 지금 이직 시장이 안 좋다는데...\n- 새 회사가 더 안 좋으면 어쩌지?\n- 3년이면 이직하기 좋은 시기인가?\n\n이직 경험 있으신 분들 조언 부탁드립니다. 어떤 기준으로 결정하셨나요?','이직-고민-중입니다-조언-부탁드려요-69','','',0,0,205,41,0,'admin','','최고관리자','admin@domain.com','','2025-11-08 16:37:20',0,'2025-11-08 16:37:20','127.0.0.1','','','','','','','','','','','',''),(70,-70,'',70,0,5,'','','','연말 계획 세우셨나요? 저는 이렇게 계획 중 (70)','벌써 연말이 다가오네요. 올해도 얼마 안 남았어요.\n\n제 연말 계획:\n\n1. 송년회\n- 회사 송년회 (12월 셋째 주)\n- 친구들 모임 (크리스마스 전 주말)\n- 가족 모임 (크리스마스 당일)\n\n2. 여행\n- 크리스마스 연휴에 1박 2일 여행 계획 중\n- 강원도 쪽으로 갈까 고민\n\n3. 정리\n- 집 대청소\n- 안 입는 옷 정리\n- 1년 회고 작성\n\n4. 새해 목표 설정\n- 운동 계획\n- 재테크 목표\n- 자기계발 계획\n\n여러분은 연말 계획 어떻게 세우셨나요? 특별한 계획 있으면 공유해주세요!','','','',0,0,341,39,0,'admin','','최고관리자','admin@domain.com','','2025-11-08 05:37:20',0,'2025-11-08 05:37:20','127.0.0.1','','','','','','','','','','','',''),(71,-71,'',71,0,14,'','','','아침형 인간 되는 방법 공유합니다 (71)','저도 예전에는 저녁형 인간이었는데, 아침형으로 바꾸고 삶의 질이 확 좋아졌어요.\n\n제가 아침형 인간이 된 방법:\n\n1. 점진적으로 바꾸기\n- 한 번에 2시간 당기지 말고\n- 일주일에 15분씩 앞당기기\n\n2. 저녁 루틴 만들기\n- 밤 10시 이후 스마트폰 안 보기\n- 따뜻한 물로 샤워\n- 독서나 명상\n\n3. 아침에 기대되는 것 만들기\n- 맛있는 아침 메뉴\n- 좋아하는 음악\n- 여유로운 커피 타임\n\n4. 환경 설정\n- 커튼 살짝 열어두기 (자연광)\n- 알람 여러 개 (점점 크게)\n- 알람 멀리 두기\n\n처음 2주가 제일 힘들어요. 그 고비만 넘기면 몸이 적응합니다!','아침형-인간-되는-방법-공유합니다-71','','',0,0,189,29,0,'admin','','최고관리자','admin@domain.com','','2025-11-07 02:37:20',0,'2025-11-07 02:37:20','127.0.0.1','','','','','','','','','','','',''),(72,-72,'',72,0,6,'','','','스트레스 해소법 공유해요 저는 이렇게 해요 (72)','직장인이라면 스트레스 안 받을 수가 없죠. 저만의 스트레스 해소법 공유합니다.\n\n1. 운동\n- 땀 흘리면 스트레스가 날아가요\n- 특히 복싱, 러닝 추천\n\n2. 맛있는 거 먹기\n- 스트레스 받으면 맛있는 거 먹어야죠\n- 단, 폭식은 노노\n\n3. 수다 떨기\n- 친구나 가족과 대화\n- 말하다 보면 정리가 돼요\n\n4. 취미 활동\n- 저는 게임이나 영화 보기\n- 몰입하면 잡생각 사라짐\n\n5. 충분한 수면\n- 잠이 보약\n- 스트레스 받을수록 잘 자야 해요\n\n6. 글쓰기\n- 일기나 감정 노트\n- 쓰다 보면 객관화가 돼요\n\n여러분만의 스트레스 해소법도 공유해주세요!','','','',0,0,737,16,0,'admin','','최고관리자','admin@domain.com','','2025-11-07 11:37:20',0,'2025-11-07 11:37:20','127.0.0.1','','','','','','','','','','','',''),(73,-73,'',73,0,6,'','','','최근에 본 영화 추천합니다 꼭 보세요 (73)','주말에 본 영화가 너무 좋아서 추천드려요.\n\n제목: 오펜하이머\n감독: 크리스토퍼 놀란\n\n놀란 감독 특유의 연출력이 돋보이는 영화였어요. 3시간이 넘는 러닝타임인데 지루할 틈이 없었습니다.\n\n좋았던 점:\n- 킬리언 머피의 연기력\n- 긴장감 넘치는 전개\n- 아이맥스로 보면 더 좋음\n- OST가 압도적\n\n참고사항:\n- 역사적 배경 알고 보면 더 재밌어요\n- 자막 집중해서 봐야 함 (대사 많음)\n\n평점: 9/10\n\n요즘 극장에서 볼 만한 영화 추천받아요. 장르 불문!','','','',0,0,180,16,0,'admin','','최고관리자','admin@domain.com','','2025-11-05 21:37:20',0,'2025-11-05 21:37:20','127.0.0.1','','','','','','','','','','','',''),(74,-74,'',74,0,7,'','','','집에서 할 수 있는 취미 추천해주세요 (74)','요즘 밖에 나가기가 귀찮아서 집에서 할 수 있는 취미를 찾고 있어요.\n\n지금 하고 있는 것:\n- 넷플릭스\n- 유튜브\n- 게임\n\n해보고 싶은 것:\n- 홈베이킹\n- 플랜테리어 (식물 키우기)\n- DIY 소품 만들기\n- 홈트레이닝\n\n집에서 할 수 있는 취미 중에 추천하실 만한 거 있나요?\n\n조건:\n- 초기 비용 너무 안 들었으면\n- 소음 적은 것 (아파트라서)\n- 혼자 할 수 있는 것\n\n특히 손으로 뭔가 만드는 취미에 관심이 있어요. 레고나 프라모델 어떤가요?','','','',0,0,326,27,0,'admin','','최고관리자','admin@domain.com','','2025-11-04 21:37:20',0,'2025-11-04 21:37:20','127.0.0.1','','','','','','','','','','','',''),(75,-75,'',75,0,0,'','','','커피 vs 차 어떤 거 좋아하세요? (75)','저는 원래 커피파였는데 요즘 차에 빠졌어요.\n\n커피의 장점:\n- 확실한 각성 효과\n- 맛있음 (특히 라떼)\n- 카페 분위기\n\n차의 장점:\n- 카페인 적음\n- 다양한 종류\n- 건강에 좋음\n- 따뜻하게 마시면 힐링\n\n요즘 제가 즐겨 마시는 차:\n- 얼그레이\n- 캐모마일 (취침 전)\n- 페퍼민트 (식후)\n- 루이보스\n\n여러분은 커피파? 차파? 아니면 둘 다?\n\n추천하는 차 종류나 카페 있으면 공유해주세요!','커피-vs-차-어떤-거-좋아하세요-75','','',0,0,307,26,0,'admin','','최고관리자','admin@domain.com','','2025-11-04 09:37:20',0,'2025-11-04 09:37:20','127.0.0.1','','','','','','','','','','','',''),(76,-76,'',76,0,3,'','','','반려동물 키우시는 분들 질문있어요 (76)','반려동물 입양을 고민 중인데, 현실적인 조언 부탁드려요.\n\n고민되는 점:\n1. 혼자 사는 1인 가구인데 가능할까?\n2. 출장이 가끔 있는데 맡길 곳은?\n3. 비용은 한 달에 얼마나 들까?\n4. 강아지 vs 고양이 뭐가 좋을까?\n\n저의 상황:\n- 원룸 거주\n- 평일 출근 (9시-6시)\n- 주말에는 거의 집에 있음\n- 여행은 1년에 2-3번\n\n키우시는 분들 현실적인 조언 부탁드려요. 예쁜 것만 보고 입양했다가 힘들어하시는 분들 많다고 해서 신중하게 결정하려고요.\n\n특히 처음 키우시는 분들 경험담 들려주세요!','반려동물-키우시는-분들-질문있어요-76','','',0,0,787,38,0,'admin','','최고관리자','admin@domain.com','','2025-11-03 13:37:20',0,'2025-11-03 13:37:20','127.0.0.1','','','','','','','','','','','',''),(77,-77,'',77,0,2,'','','','요즘 핫한 드라마 뭐예요? 추천해주세요 (77)','넷플릭스에서 볼 드라마 찾고 있어요. 요즘 뭐가 재밌나요?\n\n제가 좋아하는 장르:\n- 스릴러\n- 미스터리\n- SF\n- 로맨스도 가끔\n\n최근에 본 것들:\n- 오징어 게임 (재밌었음)\n- 더 글로리 (몰입감 최고)\n- 무빙 (액션 굿)\n\n안 좋아하는 것:\n- 너무 무거운 거\n- 시즌 너무 긴 거\n- 결말 흐지부지\n\n추천해주실 드라마 있으면 알려주세요! 해외 드라마도 좋아요.\n\n넷플릭스 말고 디즈니+, 웨이브 등 다른 OTT 추천도 환영합니다.','요즘-핫한-드라마-뭐예요-추천해주세요-77','','',0,0,452,8,0,'admin','','최고관리자','admin@domain.com','','2025-11-02 14:37:20',0,'2025-11-02 14:37:20','127.0.0.1','','','','','','','','','','','',''),(78,-78,'',78,0,10,'','','','자기계발 어떻게 하시나요? 루틴 공유 (78)','올해 자기계발 목표를 세웠는데, 꾸준히 하기가 어렵네요.\n\n제 목표:\n1. 영어 공부 - 토익 900점\n2. 자격증 - 정보처리기사\n3. 독서 - 월 2권\n4. 운동 - 주 3회\n\n현실:\n- 영어 앱 깔아놓고 안 함\n- 자격증 책 사놓고 안 봄\n- 독서 1월에 1권 읽고 끝\n- 운동 헬스장 등록만 함\n\n작심삼일을 벗어나는 방법 있을까요?\n\n꾸준히 자기계발 하시는 분들 루틴이나 팁 공유해주세요. 특히 퇴근 후 시간 활용법이 궁금해요.','자기계발-어떻게-하시나요-루틴-공유-78','','',0,0,118,21,0,'admin','','최고관리자','admin@domain.com','','2025-11-01 01:37:20',0,'2025-11-01 01:37:20','127.0.0.1','','','','','','','','','','','',''),(79,-79,'',79,0,10,'','','','출퇴근 시간 활용법 알려드려요 (79)','출퇴근 시간이 왕복 2시간인데, 이 시간을 알차게 보내는 방법 공유해요.\n\n제 출퇴근 루틴:\n\n아침 (1시간):\n- 오디오북 듣기 (30분)\n- 뉴스 기사 읽기 (20분)\n- 하루 계획 정리 (10분)\n\n저녁 (1시간):\n- 팟캐스트 듣기 (30분)\n- 영어 공부 (20분)\n- SNS, 유튜브 (10분)\n\n추천하는 콘텐츠:\n- 오디오북: 밀리의 서재\n- 팟캐스트: 과학기술 관련\n- 영어: 영어회화 앱\n\n이렇게 하니까 1년에 책 20권 정도 듣더라고요. 시간 낭비하는 것 같던 출퇴근이 생산적으로 바뀌었어요.\n\n다른 분들 출퇴근 시간 활용법도 공유해주세요!','출퇴근-시간-활용법-알려드려요-79','','',0,0,51,38,0,'admin','','최고관리자','admin@domain.com','','2025-10-31 09:37:20',0,'2025-10-31 09:37:20','127.0.0.1','','','','','','','','','','','',''),(80,-80,'',80,0,1,'','','','건강관리 팁 공유합니다 30대 필독 (80)','30대 들어서 건강이 예전 같지 않더라고요. 그래서 관리 시작했어요.\n\n제 건강관리 루틴:\n\n1. 식단\n- 아침 꼭 먹기\n- 야채 많이\n- 야식 자제\n- 물 2L\n\n2. 운동\n- 주 3회 헬스\n- 매일 스트레칭\n- 주말 산책\n\n3. 수면\n- 11시 취침 목표\n- 6시간 이상\n- 주말에도 일정하게\n\n4. 정기검진\n- 연 1회 건강검진\n- 치과 6개월마다\n\n5. 멘탈 관리\n- 명상 앱 활용\n- 취미 생활\n- 친구 만나기\n\n30대 되니까 관리 안 하면 바로 티가 나요. 미리미리 관리합시다!','건강관리-팁-공유합니다-30대-필독-80','','',0,0,355,16,0,'admin','','최고관리자','admin@domain.com','','2025-10-29 22:37:20',0,'2025-10-29 22:37:20','127.0.0.1','','','','','','','','','','','',''),(81,-81,'',81,0,8,'','','','오늘 회사에서 있었던 황당한 일 공유합니다 (81)','안녕하세요, 오늘 회사에서 정말 황당한 일이 있었어요.\n\n아침에 출근해서 자리에 앉았는데, 제 컴퓨터가 없어진 거예요! 알고 보니 IT팀에서 업그레이드한다고 가져갔더라고요. 미리 말해주지... 그래서 오전 내내 다른 분 컴퓨터 빌려서 일했네요.\n\n점심시간에는 구내식당에서 또 웃긴 일이 있었어요. 줄 서서 기다리고 있는데 앞사람이 갑자기 뒤돌아보면서 \'혹시 김대리님 아니세요?\' 하는 거예요. 저는 김대리가 아닌데... 그래서 \'아닌데요\'라고 했더니 엄청 민망해하시더라고요.\n\n오후에는 회의가 있었는데, 화상회의 중에 누군가 마이크 안 끄고 라면 먹는 소리가 들려서 다들 빵 터졌어요. 재택근무하시는 분이셨는데 본인은 모르셨나봐요.\n\n이렇게 소소한 일상의 에피소드들이 직장생활을 버티게 해주는 것 같아요. 여러분의 회사 에피소드도 댓글로 공유해주세요!','오늘-회사에서-있었던-황당한-일-공유합니다-81','','',0,0,443,28,0,'admin','','최고관리자','admin@domain.com','','2025-10-29 08:37:20',0,'2025-10-29 08:37:20','127.0.0.1','','','','','','','','','','','',''),(82,-82,'',82,0,1,'','','','주말에 뭐하시나요? 추천 좀 해주세요 (82)','이번 주말에 뭐 하실 계획이세요? 저는 요즘 집콕만 해서 이번에는 좀 나가볼까 합니다.\n\n근데 막상 나가려니까 뭘 해야 할지 모르겠더라고요. 혼자 카페 가기? 영화 보기? 아니면 근교 드라이브?\n\n제 취향은 이래요:\n- 등산은 좀 힘들어서 패스\n- 카페 투어는 좋아함\n- 사람 많은 곳은 별로\n- 자연 풍경 보는 거 좋아함\n\n서울 근교로 드라이브 가기 좋은 곳이나, 조용한 카페 아시는 분 추천 부탁드려요! 특히 요즘 단풍 예쁜 곳 있으면 알려주세요.\n\n그리고 주말에 혼자 다니시는 분들 계신가요? 처음에는 좀 어색했는데 이제는 혼밥, 혼카페, 혼영화 다 즐기게 됐어요. 혼자만의 시간도 소중하더라고요.','주말에-뭐하시나요-추천-좀-해주세요-82','','',0,0,778,17,0,'admin','','최고관리자','admin@domain.com','','2025-10-28 19:37:20',0,'2025-10-28 19:37:20','127.0.0.1','','','','','','','','','','','',''),(83,-83,'',83,0,14,'','','','요즘 날씨가 너무 좋네요 산책 다녀왔어요 (83)','요즘 날씨가 정말 좋지 않나요? 아침저녁으로는 선선하고, 낮에는 따뜻하고... 딱 나들이 가기 좋은 날씨예요.\n\n저는 오늘 점심시간에 잠깐 회사 근처 공원 산책했는데, 단풍이 정말 예쁘더라고요. 빨강, 노랑, 주황색 나뭇잎들이 햇빛 받아서 반짝반짝...\n\n이런 날씨에 추천하는 활동:\n1. 공원 산책 - 가볍게 걷기만 해도 힐링\n2. 야외 카페 - 테라스 석에서 커피 한 잔\n3. 자전거 타기 - 한강 자전거 도로 추천\n4. 피크닉 - 돗자리 깔고 김밥 먹기\n\n여러분은 이 좋은 날씨에 뭐 하고 계세요? 날씨 좋을 때 즐겨야 해요. 금방 추워질 테니까요.','요즘-날씨가-너무-좋네요-산책-다녀왔어요-83','','',0,0,388,27,0,'admin','','최고관리자','admin@domain.com','','2025-10-28 11:37:20',0,'2025-10-28 11:37:20','127.0.0.1','','','','','','','','','','','',''),(84,-84,'',84,0,0,'','','','강남역 근처 맛집 추천 부탁드려요 (84)','맛집 추천 부탁드려요! 이번 주에 친구들이랑 모임이 있는데 어디로 가야 할지 모르겠어요.\n\n조건:\n- 위치: 강남역 근처\n- 인원: 4-5명\n- 예산: 1인당 3만원 정도\n- 분위기: 대화하기 좋은 곳\n- 음식: 한식이나 이탈리안\n\n혹시 이 조건에 맞는 곳 아시면 추천해주세요!\n\n참고로 제가 가본 곳 중에 괜찮았던 데는 있는데 다 가봤던 데라서 이번에는 새로운 데 가보고 싶거든요. 숨은 맛집 있으면 공유해주세요!\n\n특히 분위기 좋고 사진 찍기 좋은 곳이면 더 좋겠어요. 요즘 인스타 감성 카페 겸 레스토랑 많잖아요.','강남역-근처-맛집-추천-부탁드려요-84','','',0,0,180,9,0,'admin','','최고관리자','admin@domain.com','','2025-10-27 08:37:20',0,'2025-10-27 08:37:20','127.0.0.1','','','','','','','','','','','',''),(85,-85,'',85,0,14,'','','','30대 중반 운동 시작하려는데 조언 부탁드려요 (85)','30대 중반인데 이제서야 운동을 시작하려고 합니다. 그동안 운동이라곤 거의 안 해서 체력이 바닥이에요...\n\n고민되는 게:\n1. 헬스장 vs 홈트 - 뭐가 더 효과적일까요?\n2. PT 받아야 할까요? - 비용이 부담되긴 한데...\n3. 어떤 운동부터 시작해야 할까요?\n\n목표는 일단 체력 기르기랑 뱃살 빼기입니다. 마른 비만이라서 근육은 없고 뱃살만 있어요 ㅠㅠ\n\n운동 잘 아시는 분들 조언 부탁드립니다! 특히 운동 초보가 주의해야 할 점이나 효과적인 루틴 있으면 알려주세요.\n\n그리고 운동하면서 식단 관리도 해야 할까요? 닭가슴살 생활 해야 하나... 막막하네요.','30대-중반-운동-시작하려는데-조언-부탁드려요-85','','',0,0,444,41,0,'admin','','최고관리자','admin@domain.com','','2025-10-26 00:37:20',0,'2025-10-26 00:37:20','127.0.0.1','','','','','','','','','','','',''),(86,-86,'',86,0,11,'','','','재택근무 꿀팁 공유합니다 참고하세요 (86)','재택근무 3년차입니다. 처음에는 집중이 안 돼서 힘들었는데, 이제는 나름의 노하우가 생겼어요.\n\n제 재택근무 꿀팁:\n\n1. 출퇴근 루틴 만들기\n- 출근 시간에 맞춰 샤워하고 옷 갈아입기\n- 퇴근 시간 되면 컴퓨터 끄기\n\n2. 업무 공간 분리\n- 가능하면 별도 방 사용\n- 안 되면 책상이라도 업무 전용으로\n\n3. 집중력 유지\n- 뽀모도로 기법 (25분 집중 + 5분 휴식)\n- 방해 요소 제거 (SNS 알림 끄기)\n\n4. 소통 강화\n- 업무 시작/종료 시 팀 채팅방에 알리기\n- 화상회의 적극 활용\n\n5. 건강 관리\n- 틈틈이 스트레칭\n- 점심시간에 산책\n\n재택근무하시는 분들 다른 팁 있으면 공유해주세요!','재택근무-꿀팁-공유합니다-참고하세요-86','','',0,0,522,46,0,'admin','','최고관리자','admin@domain.com','','2025-10-25 11:37:20',0,'2025-10-25 11:37:20','127.0.0.1','','','','','','','','','','','',''),(87,-87,'',87,0,11,'','','','요즘 읽고 있는 책 추천합니다 (87)','요즘 읽고 있는 책이 너무 좋아서 추천드려요.\n\n제목: \'아주 작은 습관의 힘\' (제임스 클리어)\n\n이 책의 핵심 내용:\n- 1%씩 나아지면 1년 후 37배 성장\n- 습관은 정체성의 변화에서 시작\n- 환경 설계의 중요성\n- 습관 쌓기(habit stacking) 기법\n\n특히 인상 깊었던 구절:\n\"우리는 목표 수준으로 올라가는 것이 아니라 시스템 수준으로 떨어진다.\"\n\n저도 이 책 읽고 아침 루틴을 만들기 시작했어요. 아침에 일어나서 물 한 잔 마시기 → 5분 스트레칭 → 10분 독서 이런 식으로요.\n\n자기계발서 좋아하시는 분들께 강추합니다. 다른 책 추천도 받아요!','요즘-읽고-있는-책-추천합니다-87','','',0,0,570,23,0,'admin','','최고관리자','admin@domain.com','','2025-10-24 15:37:20',0,'2025-10-24 15:37:20','127.0.0.1','','','','','','','','','','','',''),(88,-88,'',88,0,15,'','','','취미생활 뭐 하시나요? 새로운 취미 찾는 중 (88)','요즘 새로운 취미를 찾고 있어요. 퇴근 후랑 주말에 뭔가 하고 싶은데 뭘 해야 할지 모르겠더라고요.\n\n지금까지 해본 취미:\n- 넷플릭스 정주행 (이건 취미라기보다...)\n- 독서 (꾸준히 하고 있음)\n- 요리 (가끔)\n\n관심 있는 것들:\n- 악기 (기타? 피아노?)\n- 그림 그리기\n- 운동 (클라이밍, 수영 등)\n- 사진 촬영\n\n여러분은 어떤 취미 활동 하시나요? 특히 혼자 할 수 있고, 스트레스 해소에 좋은 취미 있으면 추천해주세요!\n\n비용이나 시간 투자 대비 만족도 높은 취미면 더 좋겠어요.','취미생활-뭐-하시나요-새로운-취미-찾는-중-88','','',0,0,352,40,0,'admin','','최고관리자','admin@domain.com','','2025-10-23 01:37:20',0,'2025-10-23 01:37:20','127.0.0.1','','','','','','','','','','','',''),(89,-89,'',89,0,0,'','','','이직 고민 중입니다 조언 부탁드려요 (89)','현재 회사에서 3년째 근무 중인데, 이직을 고민하고 있습니다.\n\n현재 상황:\n- 연봉: 업계 평균 수준\n- 업무: 익숙하지만 성장이 멈춘 느낌\n- 분위기: 나쁘지 않음\n- 워라밸: 괜찮은 편\n\n이직을 고민하는 이유:\n1. 커리어 성장의 한계를 느낌\n2. 새로운 도전을 하고 싶음\n3. 연봉 상승 기대\n\n고민되는 점:\n- 지금 이직 시장이 안 좋다는데...\n- 새 회사가 더 안 좋으면 어쩌지?\n- 3년이면 이직하기 좋은 시기인가?\n\n이직 경험 있으신 분들 조언 부탁드립니다. 어떤 기준으로 결정하셨나요?','이직-고민-중입니다-조언-부탁드려요-89','','',0,0,585,27,0,'admin','','최고관리자','admin@domain.com','','2025-10-22 14:37:20',0,'2025-10-22 14:37:20','127.0.0.1','','','','','','','','','','','',''),(90,-90,'',90,0,2,'','','','연말 계획 세우셨나요? 저는 이렇게 계획 중 (90)','벌써 연말이 다가오네요. 올해도 얼마 안 남았어요.\n\n제 연말 계획:\n\n1. 송년회\n- 회사 송년회 (12월 셋째 주)\n- 친구들 모임 (크리스마스 전 주말)\n- 가족 모임 (크리스마스 당일)\n\n2. 여행\n- 크리스마스 연휴에 1박 2일 여행 계획 중\n- 강원도 쪽으로 갈까 고민\n\n3. 정리\n- 집 대청소\n- 안 입는 옷 정리\n- 1년 회고 작성\n\n4. 새해 목표 설정\n- 운동 계획\n- 재테크 목표\n- 자기계발 계획\n\n여러분은 연말 계획 어떻게 세우셨나요? 특별한 계획 있으면 공유해주세요!','연말-계획-세우셨나요-저는-이렇게-계획-중-90','','',0,0,158,6,0,'admin','','최고관리자','admin@domain.com','','2025-10-20 20:37:20',0,'2025-10-20 20:37:20','127.0.0.1','','','','','','','','','','','',''),(91,-91,'',91,0,5,'','','','아침형 인간 되는 방법 공유합니다 (91)','저도 예전에는 저녁형 인간이었는데, 아침형으로 바꾸고 삶의 질이 확 좋아졌어요.\n\n제가 아침형 인간이 된 방법:\n\n1. 점진적으로 바꾸기\n- 한 번에 2시간 당기지 말고\n- 일주일에 15분씩 앞당기기\n\n2. 저녁 루틴 만들기\n- 밤 10시 이후 스마트폰 안 보기\n- 따뜻한 물로 샤워\n- 독서나 명상\n\n3. 아침에 기대되는 것 만들기\n- 맛있는 아침 메뉴\n- 좋아하는 음악\n- 여유로운 커피 타임\n\n4. 환경 설정\n- 커튼 살짝 열어두기 (자연광)\n- 알람 여러 개 (점점 크게)\n- 알람 멀리 두기\n\n처음 2주가 제일 힘들어요. 그 고비만 넘기면 몸이 적응합니다!','아침형-인간-되는-방법-공유합니다-91','','',0,0,752,12,0,'admin','','최고관리자','admin@domain.com','','2025-10-20 06:37:20',0,'2025-10-20 06:37:20','127.0.0.1','','','','','','','','','','','',''),(92,-92,'',92,0,10,'','','','스트레스 해소법 공유해요 저는 이렇게 해요 (92)','직장인이라면 스트레스 안 받을 수가 없죠. 저만의 스트레스 해소법 공유합니다.\n\n1. 운동\n- 땀 흘리면 스트레스가 날아가요\n- 특히 복싱, 러닝 추천\n\n2. 맛있는 거 먹기\n- 스트레스 받으면 맛있는 거 먹어야죠\n- 단, 폭식은 노노\n\n3. 수다 떨기\n- 친구나 가족과 대화\n- 말하다 보면 정리가 돼요\n\n4. 취미 활동\n- 저는 게임이나 영화 보기\n- 몰입하면 잡생각 사라짐\n\n5. 충분한 수면\n- 잠이 보약\n- 스트레스 받을수록 잘 자야 해요\n\n6. 글쓰기\n- 일기나 감정 노트\n- 쓰다 보면 객관화가 돼요\n\n여러분만의 스트레스 해소법도 공유해주세요!','스트레스-해소법-공유해요-저는-이렇게-해요-92','','',0,0,767,8,0,'admin','','최고관리자','admin@domain.com','','2025-10-19 16:37:20',0,'2026-01-10 04:58:08','127.0.0.1','','','','','','','','','','','',''),(93,-93,'',93,0,3,'','','','최근에 본 영화 추천합니다 꼭 보세요 (93)','주말에 본 영화가 너무 좋아서 추천드려요.\n\n제목: 오펜하이머\n감독: 크리스토퍼 놀란\n\n놀란 감독 특유의 연출력이 돋보이는 영화였어요. 3시간이 넘는 러닝타임인데 지루할 틈이 없었습니다.\n\n좋았던 점:\n- 킬리언 머피의 연기력\n- 긴장감 넘치는 전개\n- 아이맥스로 보면 더 좋음\n- OST가 압도적\n\n참고사항:\n- 역사적 배경 알고 보면 더 재밌어요\n- 자막 집중해서 봐야 함 (대사 많음)\n\n평점: 9/10\n\n요즘 극장에서 볼 만한 영화 추천받아요. 장르 불문!','최근에-본-영화-추천합니다-꼭-보세요-93','','',0,0,482,19,0,'admin','','최고관리자','admin@domain.com','','2025-10-19 07:37:20',0,'2025-10-19 07:37:20','127.0.0.1','','','','','','','','','','','',''),(94,-94,'',94,0,0,'','','','집에서 할 수 있는 취미 추천해주세요 (94)','요즘 밖에 나가기가 귀찮아서 집에서 할 수 있는 취미를 찾고 있어요.\n\n지금 하고 있는 것:\n- 넷플릭스\n- 유튜브\n- 게임\n\n해보고 싶은 것:\n- 홈베이킹\n- 플랜테리어 (식물 키우기)\n- DIY 소품 만들기\n- 홈트레이닝\n\n집에서 할 수 있는 취미 중에 추천하실 만한 거 있나요?\n\n조건:\n- 초기 비용 너무 안 들었으면\n- 소음 적은 것 (아파트라서)\n- 혼자 할 수 있는 것\n\n특히 손으로 뭔가 만드는 취미에 관심이 있어요. 레고나 프라모델 어떤가요?','집에서-할-수-있는-취미-추천해주세요-94','','',0,0,269,8,0,'admin','','최고관리자','admin@domain.com','','2025-10-18 08:37:20',0,'2025-10-18 08:37:20','127.0.0.1','','','','','','','','','','','',''),(95,-95,'',95,0,4,'','','','커피 vs 차 어떤 거 좋아하세요? (95)','저는 원래 커피파였는데 요즘 차에 빠졌어요.\n\n커피의 장점:\n- 확실한 각성 효과\n- 맛있음 (특히 라떼)\n- 카페 분위기\n\n차의 장점:\n- 카페인 적음\n- 다양한 종류\n- 건강에 좋음\n- 따뜻하게 마시면 힐링\n\n요즘 제가 즐겨 마시는 차:\n- 얼그레이\n- 캐모마일 (취침 전)\n- 페퍼민트 (식후)\n- 루이보스\n\n여러분은 커피파? 차파? 아니면 둘 다?\n\n추천하는 차 종류나 카페 있으면 공유해주세요!','커피-vs-차-어떤-거-좋아하세요-95','','',0,0,307,12,0,'admin','','최고관리자','admin@domain.com','','2025-10-17 05:37:20',0,'2025-10-17 05:37:20','127.0.0.1','','','','','','','','','','','',''),(96,-96,'',96,0,15,'','','html1','반려동물 키우시는 분들 질문있어요 (96)','반려동물 키우시는 분들 질문있어요!\n\n<p><img src=\"https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=800\" alt=\"귀여운 강아지\" style=\"max-width:100%;\"></p>\n\n강아지 입양을 고민 중인데요...\n\n궁금한 점:\n1. 한 달 비용이 얼마나 드나요?\n2. 직장인인데 혼자 키울 수 있을까요?\n3. 처음 키우기 좋은 품종은?\n\n<p><img src=\"https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=800\" alt=\"고양이\" style=\"max-width:100%;\"></p>\n\n고양이도 고민 중이에요. 강아지 vs 고양이 어떤 게 더 키우기 편할까요?\n\n경험담 공유해주시면 감사하겠습니다!','반려동물-키우시는-분들-질문있어요-96','','',0,0,697,33,0,'admin','','최고관리자','admin@domain.com','','2025-10-16 10:37:20',0,'2025-10-16 10:37:20','127.0.0.1','','','','','','','','','','','',''),(97,-97,'',97,0,14,'','','html1','요즘 핫한 드라마 뭐예요? 추천해주세요 (97)','요즘 핫한 드라마 뭐예요? 추천 좀 해주세요!\n\n<p><img src=\"https://images.unsplash.com/photo-1522869635100-9f4c5e86aa37?w=800\" alt=\"TV 시청\" style=\"max-width:100%;\"></p>\n\n넷플릭스, 티빙, 웨이브 다 구독 중인데 뭘 봐야 할지 모르겠어요 ㅠㅠ\n\n최근에 본 거:\n- 더 글로리 (완결)\n- 무빙 (완결)\n- 스위트홈3 (완결)\n\n<p><img src=\"https://images.unsplash.com/photo-1585647347483-22b66260dfff?w=800\" alt=\"팝콘과 영화\" style=\"max-width:100%;\"></p>\n\n로맨스, 스릴러, SF 다 좋아해요!\n추천 부탁드립니다~','요즘-핫한-드라마-뭐예요-추천해주세요-97','','',0,0,503,2,0,'admin','','최고관리자','admin@domain.com','','2025-10-15 10:37:20',0,'2025-10-15 10:37:20','127.0.0.1','','','','','','','','','','','',''),(98,-98,'',98,0,6,'','','html1','자기계발 어떻게 하시나요? 루틴 공유 (98)','자기계발 어떻게 하시나요? 루틴 공유해요!\n\n<p><img src=\"https://images.unsplash.com/photo-1506784983877-45594efa4cbe?w=800\" alt=\"독서하는 모습\" style=\"max-width:100%;\"></p>\n\n직장 다니면서 자기계발 하기 쉽지 않죠? 저만의 루틴 공유합니다.\n\n<h3>? 아침 루틴 (6:00-7:30)</h3>\n- 기상 후 물 한 잔\n- 독서 30분\n- 영어 공부 30분\n\n<p><img src=\"https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800\" alt=\"공부하는 책상\" style=\"max-width:100%;\"></p>\n\n<h3>? 저녁 루틴 (22:00-23:00)</h3>\n- 오늘 배운 것 정리\n- 내일 할 일 계획\n- 명상 10분\n\n<p><img src=\"https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=800\" alt=\"노트북과 커피\" style=\"max-width:100%;\"></p>\n\n꾸준히 하는 게 제일 중요한 것 같아요!\n다들 자기계발 루틴 공유해주세요~','자기계발-어떻게-하시나요-루틴-공유-98','','',0,0,207,46,0,'admin','','최고관리자','admin@domain.com','','2025-10-13 23:37:20',0,'2025-10-13 23:37:20','127.0.0.1','','','','','','','','','','','',''),(99,-99,'',99,0,13,'','','','출퇴근 시간 활용법 알려드려요 (99)','출퇴근 시간이 왕복 2시간인데, 이 시간을 알차게 보내는 방법 공유해요.\n\n제 출퇴근 루틴:\n\n아침 (1시간):\n- 오디오북 듣기 (30분)\n- 뉴스 기사 읽기 (20분)\n- 하루 계획 정리 (10분)\n\n저녁 (1시간):\n- 팟캐스트 듣기 (30분)\n- 영어 공부 (20분)\n- SNS, 유튜브 (10분)\n\n추천하는 콘텐츠:\n- 오디오북: 밀리의 서재\n- 팟캐스트: 과학기술 관련\n- 영어: 영어회화 앱\n\n이렇게 하니까 1년에 책 20권 정도 듣더라고요. 시간 낭비하는 것 같던 출퇴근이 생산적으로 바뀌었어요.\n\n다른 분들 출퇴근 시간 활용법도 공유해주세요!','출퇴근-시간-활용법-알려드려요-99','','',0,0,90,3,0,'admin','','최고관리자','admin@domain.com','','2025-10-12 23:37:20',0,'2025-10-12 23:37:20','127.0.0.1','','','','','','','','','','','',''),(100,-100,'',100,0,8,'','','html1','건강관리 팁 공유합니다 30대 필독 (100)','30대 들어서 건강이 예전 같지 않더라고요. 그래서 관리 시작했어요.\n\n<p><img src=\"https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=800\" alt=\"운동하는 모습\" style=\"max-width:100%;\"></p>\n\n제 건강관리 루틴:\n\n<h3>1. 식단</h3>\n<ul>\n<li>아침 꼭 먹기</li>\n<li>야채 많이</li>\n<li>야식 자제</li>\n<li>물 2L</li>\n</ul>\n\n<p><img src=\"https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=800\" alt=\"건강한 식단\" style=\"max-width:100%;\"></p>\n\n<h3>2. 운동</h3>\n<ul>\n<li>주 3회 헬스</li>\n<li>매일 스트레칭</li>\n<li>주말 등산</li>\n</ul>\n\n꾸준히 하니까 확실히 달라지더라고요. 다들 건강 챙기세요!','건강관리-팁-공유합니다-30대-필독-100','','',0,0,259,18,0,'admin','','최고관리자','admin@domain.com','','2025-10-12 00:37:20',0,'2025-10-12 00:37:20','127.0.0.1','','','','','','','','','','','',''),(101,-101,'',101,0,0,'','','','123123','123123123','123123','','',0,0,1,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:49:45',0,'2026-01-10 00:49:45','::1','','','','','','','','','','','',''),(102,-102,'',102,0,0,'','','','12312312','3123','12312312','','',0,0,1,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:56:45',0,'2026-01-10 00:56:45','::1','','','','','','','','','','','',''),(103,-103,'',103,0,0,'','','','아침형 테스트','아침형 테스트아침형 테스트아침형 테스트아침형 테스트아침형 테스트아침형 테스트아침형 테스트아침형 테스트아침형 테스트아침형 테스트아침형 테스트아침형 테스트아침형 테스트아침형 테스트','아침형-테스트','','',0,0,1,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 01:00:34',0,'2026-01-10 01:00:34','::1','','','','','','','','','','','',''),(104,-104,'',104,0,0,'','','','ㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋ','안녕하세요, 그누보드 테마를 적용해봤습니다.\r\n\r\n디자인이 정말 깔끔하고 모바일에서도 잘 작동하네요!','ㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋ','','',0,0,2,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 01:23:58',0,'2026-01-10 01:23:58','::1','','','','','','','','','','','',''),(105,-105,'',105,0,4,'','','','ㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋ','ㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋ','ㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋ','','',0,0,2,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 01:53:55',2,'2026-01-10 05:19:34','::1','','','','','','','','','','','',''),(106,-92,'',92,1,1,'','','','','fsdfdfsfd','','','',0,0,0,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 04:58:08',0,'','::1','','','','','','','','','','','',''),(107,-105,'',105,1,1,'','','','','123213123','','','',0,0,0,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 05:19:08',0,'','::1','','','','','','','','','','','',''),(108,-105,'',105,1,2,'','','','','`3213123213','','','',0,0,0,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 05:19:23',0,'','::1','','','','','','','','','','','',''),(109,-105,'',105,1,1,'A','','','','ㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋ','','','',0,0,0,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 05:19:29',0,'','::1','','','','','','','','','','','',''),(110,-105,'',105,1,1,'B','','','','ㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋ','','','',0,0,0,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 05:19:34',0,'','::1','','','','','','','','','','','',''),(111,-106,'',111,0,0,'','','','few','ewwf','few','','',0,0,1,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 06:40:28',0,'2026-01-10 06:40:28','::1','','','','','','','','','','','',''),(112,-107,'',112,0,0,'','','html1','<script>alert(\'XSS\')</script>','<img src=x onerror=alert(\'XSS\')>','alertxss','','',0,0,1,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 07:18:36',0,'2026-01-10 07:18:36','::1','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_free` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_gallery`
--

DROP TABLE IF EXISTS `g5_write_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_gallery` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_gallery`
--

LOCK TABLES `g5_write_gallery` WRITE;
/*!40000 ALTER TABLE `g5_write_gallery` DISABLE KEYS */;
INSERT INTO `g5_write_gallery` VALUES (1,-1,'',1,0,12,'','','html1','오늘 퇴근길 하늘 사진입니다 (1)','<p><img src=\"https://picsum.photos/id/101/700/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n오늘 퇴근길에 하늘이 너무 예뻐서 사진 찍어봤어요.\n\n노을이 지면서 하늘이 분홍색, 주황색, 보라색으로 물들었는데... 사진으로는 이 아름다움을 다 담을 수가 없네요. 실제로 보면 정말 숨이 멎을 것 같은 풍경이었어요.\n\n카메라: 아이폰 15 프로\n보정: 라이트룸에서 약간의 색감 보정\n장소: 회사 옥상\n\n요즘 날씨가 좋아서 그런지 하늘이 유독 예쁜 것 같아요. 여러분도 오늘 하늘 보셨나요?','','','',0,0,1212,59,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(2,-2,'',2,0,19,'','','html1','성수동 카페 인테리어 예쁘네요 (2)','<p><img src=\"https://picsum.photos/id/102/600/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n오늘 새로 오픈한 카페 갔다가 인테리어가 너무 예뻐서 사진 엄청 찍어왔어요!\n\n이 카페 특징:\n- 빈티지한 느낌의 인테리어\n- 자연광이 잘 들어오는 큰 창문\n- 식물이 많아서 힐링됨\n- 조용한 음악\n\n커피도 맛있었어요. 아메리카노랑 크로플 시켰는데 둘 다 맛있었습니다.\n\n위치는 성수동이고, 주말에는 웨이팅이 있을 수 있어요. 인스타 감성 카페 찾으시는 분들께 강추!','','','',0,0,863,66,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(3,-3,'',3,0,20,'','','html1','제주도 여행 사진 공유합니다 (3)','<p><img src=\"https://picsum.photos/id/103/600/600\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n지난 주말에 다녀온 제주도 여행 사진입니다!\n\n2박 3일 일정으로 다녀왔는데, 날씨가 정말 좋았어요. 구름 한 점 없는 맑은 하늘에 바다는 에메랄드빛...\n\n이번 여행 코스:\n1일차 - 협재해수욕장, 애월카페거리\n2일차 - 성산일출봉, 우도\n3일차 - 중문관광단지, 천지연폭포\n\n가장 좋았던 곳은 우도예요. 자전거 타고 섬 한 바퀴 돌았는데 경치가 진짜 미쳤습니다.','','','',0,0,562,74,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(4,-4,'',4,0,7,'','','html1','우리 집 강아지 사진 자랑해요 (4)','<p><img src=\"https://picsum.photos/id/104/600/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n우리 집 강아지 사진 자랑할게요 ㅎㅎ\n\n이름은 \'몽이\'고, 포메라니안 3살입니다. 털이 복슬복슬해서 진짜 인형 같아요!\n\n오늘 산책 갔다 와서 지쳐서 자고 있는 사진인데, 자는 모습도 너무 귀엽지 않나요?\n\n몽이 특징:\n- 간식 앞에서는 뭐든 함\n- 산책 좋아함 (특히 공원)\n- 낯선 사람 경계함\n- 배 만져주면 좋아함\n\n반려동물 키우시는 분들 사진 공유해요!','','','',0,0,324,51,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(5,-5,'',5,0,4,'','','html1','일상 스냅 사진 모음입니다 (5)','<p><img src=\"https://picsum.photos/id/105/500/600\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n요즘 일상 사진 찍는 재미에 빠졌어요.\n\n특별한 거 없이 그냥 지나가다 예쁘면 찍고, 맛있는 거 먹으면 찍고... 이렇게 모으다 보니까 나름의 기록이 되더라고요.\n\n오늘 올리는 사진들:\n1. 아침에 마신 커피\n2. 점심에 먹은 파스타\n3. 퇴근길 골목 풍경\n4. 저녁에 본 고양이\n\n일상이 특별해지는 느낌이에요.','','','',0,0,1487,88,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(6,-6,'',6,0,17,'','','html1','한강 야경 사진 찍어왔어요 (6)','<p><img src=\"https://picsum.photos/id/106/500/500\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n어제 한강에서 야경 사진 찍어왔어요.\n\n날씨도 좋고 바람도 시원해서 산책하면서 사진 찍었는데 너무 잘 나왔어요!\n\n촬영 정보:\n- 장소: 반포한강공원\n- 시간: 저녁 8시경\n- 장비: 소니 A7C + 35mm f1.8\n- 삼각대 사용\n\n야경 사진 팁:\n- 삼각대 필수\n- ISO 낮게\n- 셔터스피드 길게\n- 조리개는 f8-11 정도\n\n야경 사진 찍으시는 분들 팁 공유해요!','','','',0,0,454,55,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(7,-7,'',7,0,9,'','','html1','벚꽃 사진 예쁘게 나왔어요 (7)','<p><img src=\"https://picsum.photos/id/107/500/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n지난 봄에 찍은 벚꽃 사진인데, 정리하다가 발견해서 올려요.\n\n여의도 윤중로에서 찍었는데, 벚꽃이 만개했을 때라 정말 예뻤어요. 분홍빛 꽃잎이 바람에 날리는 게 영화 같았습니다.\n\n내년 벚꽃 시즌에는 꼭 가보세요!\n\n추천 벚꽃 명소:\n- 여의도 윤중로\n- 석촌호수\n- 남산\n- 경주 보문단지','','','',0,0,469,54,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(8,-8,'',8,0,12,'','','html1','맛있는 브런치 사진입니다 (8)','<p><img src=\"https://picsum.photos/id/108/400/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말 브런치 사진이에요.\n\n오랜만에 여유롭게 브런치 먹으러 갔는데, 음식도 맛있고 플레이팅도 예뻐서 사진 찍어봤어요.\n\n주문한 메뉴:\n- 에그베네딕트\n- 팬케이크\n- 아메리카노\n\n가격은 2인 기준 5만원 정도였어요. 분위기 좋고 음식 맛있어서 만족!\n\n브런치 맛집 추천받아요!','','','',0,0,368,49,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(9,-9,'',9,0,4,'','','html1','출근길 지하철역 풍경이에요 (9)','<p><img src=\"https://picsum.photos/id/109/600/600\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n출근길 지하철역에서 찍은 사진이에요.\n\n매일 지나가는 곳인데, 오늘따라 빛이 예쁘게 들어와서 사진 찍어봤어요. 일상 속에서 발견하는 아름다움이랄까요.\n\n출퇴근하면서 스쳐 지나가는 풍경도 가끔은 멈춰서 바라보면 새롭게 보이더라고요.\n\n여러분의 출퇴근길 풍경은 어떤가요?','','','',0,0,538,12,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(10,-10,'',10,0,5,'','','html1','비 오는 날 감성 사진 (10)','<p><img src=\"https://picsum.photos/id/110/800/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n비 오는 날 찍은 사진이에요.\n\n빗방울이 창문에 맺혀있는 거 찍어봤는데, 나름 감성 있게 나왔네요. 비 오는 날 특유의 촉촉한 분위기가 좋아요.\n\n비 오는 날 사진 팁:\n- 창문의 빗방울 클로즈업\n- 우산 쓴 사람들\n- 물웅덩이 반영\n- 비에 젖은 거리\n\n다음에 비 오면 우산 들고 나가서 더 많이 찍어봐야겠어요.','','','',0,0,256,84,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(11,-11,'',11,0,11,'','','html1','노을 지는 바다 풍경입니다 (11)','<p><img src=\"https://picsum.photos/id/111/800/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말에 바다 보러 갔다가 찍은 노을 사진이에요.\n\n해가 지면서 하늘이 주황색, 빨간색으로 물들었는데... 진짜 장관이었어요. 이런 풍경 보면 힐링 되는 것 같아요.\n\n장소: 강릉 경포해변\n시간: 저녁 6시경\n\n바다 + 노을 조합은 진리입니다. 스트레스 받을 때 바다 보러 가세요!','','','',0,0,885,45,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(12,-12,'',12,0,1,'','','html1','가을 단풍 사진 공유해요 (12)','<p><img src=\"https://picsum.photos/id/112/500/600\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n단풍 구경 다녀왔어요!\n\n설악산 근처 드라이브하면서 찍은 사진인데, 온 산이 빨갛고 노랗고... 정말 예뻤어요.\n\n단풍 명소 추천:\n- 설악산\n- 내장산\n- 남이섬\n- 덕유산\n\n지금이 단풍 절정 시기니까 이번 주말에 꼭 가보세요! 다음 주면 다 질 수도 있어요.','','','',0,0,419,77,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(13,-13,'',13,0,19,'','','html1','귀여운 고양이 사진이에요 (13)','<p><img src=\"https://picsum.photos/id/113/500/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n동네에서 만난 고양이예요.\n\n매일 출근길에 보이는 고양이인데, 오늘은 가까이 와서 사진 찍었어요. 경계심이 없고 너무 귀여워요!\n\n이 동네 고양이 특징:\n- 사람 무서워 안 함\n- 쓰다듬으면 가만히 있음\n- 간식 주면 더 좋아함\n\n길고양이 사진 공유해요!','','','',0,0,760,27,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(14,-14,'',14,0,14,'','','html1','캠핑장에서 찍은 사진 (14)','<p><img src=\"https://picsum.photos/id/114/700/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말 캠핑 다녀왔어요!\n\n날씨도 좋고 공기도 맑고... 도심에서 벗어나니까 힐링 되더라고요.\n\n캠핑 장비:\n- 텐트: 코베아 3인용\n- 체어: 헬리녹스\n- 테이블: 접이식\n- 랜턴: 충전식 LED\n\n캠핑 초보인데, 다음에는 바베큐도 해보려고요. 캠핑 팁 있으면 알려주세요!','','','',0,0,1148,24,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(15,-15,'',15,0,19,'','','html1','눈 오는 날 풍경 사진 (15)','<p><img src=\"https://picsum.photos/id/115/500/500\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n첫눈 왔을 때 찍은 사진이에요.\n\n눈이 소복소복 쌓이는 거 보니까 기분이 좋더라고요. 겨울 감성 물씬!\n\n눈 사진 찍을 때 팁:\n- 노출 +0.5~1 정도 올리기 (눈이 회색으로 나올 수 있음)\n- 셔터스피드 빠르게 (눈송이 담기)\n- 역광으로 찍으면 반짝반짝\n\n눈 오면 또 사진 찍으러 나가야겠어요!','','','',0,0,1386,89,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:38',0,'2026-01-10 00:37:38','127.0.0.1','','','','','','','','','','','',''),(16,-16,'',16,0,1,'','','html1','도시 야경 사진 공유합니다 (16)','<p><img src=\"https://picsum.photos/id/116/500/600\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n서울 야경 사진이에요.\n\n남산타워에서 찍은 건데, 서울 전경이 한눈에 보여서 좋았어요. 야경 사진은 역시 높은 곳에서 찍어야 제맛!\n\n서울 야경 명소:\n- 남산타워\n- 북악스카이웨이\n- 인왕산\n- 응봉산\n\n다음에는 인왕산 가서 찍어볼 예정이에요.','','','',0,0,1253,20,0,'admin','','최고관리자','admin@domain.com','','2025-12-27 13:37:21',0,'2025-12-27 13:37:21','127.0.0.1','','','','','','','','','','','',''),(17,-17,'',17,0,6,'','','html1','숲길 산책하며 찍은 사진 (17)','<p><img src=\"https://picsum.photos/id/117/500/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말에 숲길 산책하면서 찍은 사진이에요.\n\n나무 사이로 햇빛이 들어오는 게 너무 예뻤어요. 피톤치드 마시면서 걸으니까 힐링 그 자체!\n\n서울 근교 숲길 추천:\n- 북한산 둘레길\n- 관악산 자락길\n- 서울숲\n- 올림픽공원\n\n등산은 힘들어도 숲길 산책은 누구나 할 수 있어요!','','','',0,0,175,24,0,'admin','','최고관리자','admin@domain.com','','2025-12-26 11:37:21',0,'2025-12-26 11:37:21','127.0.0.1','','','','','','','','','','','',''),(18,-18,'',18,0,7,'','','html1','일출 사진 새벽에 찍었어요 (18)','<p><img src=\"https://picsum.photos/id/118/500/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n새벽에 일어나서 일출 찍었어요.\n\n힘들었지만 이 풍경 보니까 다 보상받는 느낌! 태양이 수평선 위로 떠오르는 순간은 정말 감동적이었어요.\n\n일출 명소:\n- 정동진\n- 울산 간절곶\n- 부산 해운대\n- 강릉 경포대\n\n내년 1월 1일에는 해돋이 보러 가야겠어요!','','','',0,0,1268,21,0,'admin','','최고관리자','admin@domain.com','','2025-12-25 11:37:21',0,'2025-12-25 11:37:21','127.0.0.1','','','','','','','','','','','',''),(19,-19,'',19,0,10,'','','html1','하늘 구름 사진 예술이네요 (19)','<p><img src=\"https://picsum.photos/id/119/400/500\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n오늘 구름이 너무 예뻐서 사진 찍어봤어요.\n\n뭉게구름이 하늘에 동동 떠다니는데, 마치 그림 같았어요. 자연이 만든 예술 작품!\n\n구름 사진 팁:\n- 광각 렌즈 활용\n- 전경과 함께 찍기\n- 골든아워에 찍기\n- 편광필터 사용\n\n하늘 사진 좋아하시는 분들 공유해요!','','','',0,0,428,71,0,'admin','','최고관리자','admin@domain.com','','2025-12-23 21:37:21',0,'2025-12-23 21:37:21','127.0.0.1','','','','','','','','','','','',''),(20,-20,'',20,0,7,'','','html1','주말 피크닉 사진이에요 (20)','<p><img src=\"https://picsum.photos/id/120/600/500\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말에 한강에서 피크닉했어요.\n\n돗자리 깔고 김밥 먹으면서 여유롭게 시간 보냈는데, 너무 좋았어요. 이런 소소한 행복이 최고!\n\n피크닉 준비물:\n- 돗자리\n- 김밥, 샌드위치\n- 음료\n- 블루투스 스피커\n- 책\n\n날씨 좋을 때 피크닉 강추합니다!','','','',0,0,265,13,0,'admin','','최고관리자','admin@domain.com','','2025-12-22 17:37:21',0,'2025-12-22 17:37:21','127.0.0.1','','','','','','','','','','','',''),(21,-21,'',21,0,1,'','','html1','오늘 퇴근길 하늘 사진입니다 (21)','<p><img src=\"https://picsum.photos/id/121/800/500\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n오늘 퇴근길에 하늘이 너무 예뻐서 사진 찍어봤어요.\n\n노을이 지면서 하늘이 분홍색, 주황색, 보라색으로 물들었는데... 사진으로는 이 아름다움을 다 담을 수가 없네요. 실제로 보면 정말 숨이 멎을 것 같은 풍경이었어요.\n\n카메라: 아이폰 15 프로\n보정: 라이트룸에서 약간의 색감 보정\n장소: 회사 옥상\n\n요즘 날씨가 좋아서 그런지 하늘이 유독 예쁜 것 같아요. 여러분도 오늘 하늘 보셨나요?','','','',0,0,559,73,0,'admin','','최고관리자','admin@domain.com','','2025-12-21 23:37:21',0,'2025-12-21 23:37:21','127.0.0.1','','','','','','','','','','','',''),(22,-22,'',22,0,12,'','','html1','성수동 카페 인테리어 예쁘네요 (22)','<p><img src=\"https://picsum.photos/id/122/500/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n오늘 새로 오픈한 카페 갔다가 인테리어가 너무 예뻐서 사진 엄청 찍어왔어요!\n\n이 카페 특징:\n- 빈티지한 느낌의 인테리어\n- 자연광이 잘 들어오는 큰 창문\n- 식물이 많아서 힐링됨\n- 조용한 음악\n\n커피도 맛있었어요. 아메리카노랑 크로플 시켰는데 둘 다 맛있었습니다.\n\n위치는 성수동이고, 주말에는 웨이팅이 있을 수 있어요. 인스타 감성 카페 찾으시는 분들께 강추!','','','',0,0,892,86,0,'admin','','최고관리자','admin@domain.com','','2025-12-21 22:37:21',0,'2025-12-21 22:37:21','127.0.0.1','','','','','','','','','','','',''),(23,-23,'',23,0,14,'','','html1','제주도 여행 사진 공유합니다 (23)','<p><img src=\"https://picsum.photos/id/123/600/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n지난 주말에 다녀온 제주도 여행 사진입니다!\n\n2박 3일 일정으로 다녀왔는데, 날씨가 정말 좋았어요. 구름 한 점 없는 맑은 하늘에 바다는 에메랄드빛...\n\n이번 여행 코스:\n1일차 - 협재해수욕장, 애월카페거리\n2일차 - 성산일출봉, 우도\n3일차 - 중문관광단지, 천지연폭포\n\n가장 좋았던 곳은 우도예요. 자전거 타고 섬 한 바퀴 돌았는데 경치가 진짜 미쳤습니다.','','','',0,0,421,53,0,'admin','','최고관리자','admin@domain.com','','2025-12-21 00:37:21',0,'2025-12-21 00:37:21','127.0.0.1','','','','','','','','','','','',''),(24,-24,'',24,0,14,'','','html1','우리 집 강아지 사진 자랑해요 (24)','<p><img src=\"https://picsum.photos/id/124/800/500\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n우리 집 강아지 사진 자랑할게요 ㅎㅎ\n\n이름은 \'몽이\'고, 포메라니안 3살입니다. 털이 복슬복슬해서 진짜 인형 같아요!\n\n오늘 산책 갔다 와서 지쳐서 자고 있는 사진인데, 자는 모습도 너무 귀엽지 않나요?\n\n몽이 특징:\n- 간식 앞에서는 뭐든 함\n- 산책 좋아함 (특히 공원)\n- 낯선 사람 경계함\n- 배 만져주면 좋아함\n\n반려동물 키우시는 분들 사진 공유해요!','','','',0,0,136,76,0,'admin','','최고관리자','admin@domain.com','','2025-12-20 02:37:21',0,'2025-12-20 02:37:21','127.0.0.1','','','','','','','','','','','',''),(25,-25,'',25,0,14,'','','html1','일상 스냅 사진 모음입니다 (25)','<p><img src=\"https://picsum.photos/id/125/500/500\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n요즘 일상 사진 찍는 재미에 빠졌어요.\n\n특별한 거 없이 그냥 지나가다 예쁘면 찍고, 맛있는 거 먹으면 찍고... 이렇게 모으다 보니까 나름의 기록이 되더라고요.\n\n오늘 올리는 사진들:\n1. 아침에 마신 커피\n2. 점심에 먹은 파스타\n3. 퇴근길 골목 풍경\n4. 저녁에 본 고양이\n\n일상이 특별해지는 느낌이에요.','','','',0,0,339,79,0,'admin','','최고관리자','admin@domain.com','','2025-12-19 06:37:21',0,'2025-12-19 06:37:21','127.0.0.1','','','','','','','','','','','',''),(26,-26,'',26,0,1,'','','html1','한강 야경 사진 찍어왔어요 (26)','<p><img src=\"https://picsum.photos/id/126/800/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n어제 한강에서 야경 사진 찍어왔어요.\n\n날씨도 좋고 바람도 시원해서 산책하면서 사진 찍었는데 너무 잘 나왔어요!\n\n촬영 정보:\n- 장소: 반포한강공원\n- 시간: 저녁 8시경\n- 장비: 소니 A7C + 35mm f1.8\n- 삼각대 사용\n\n야경 사진 팁:\n- 삼각대 필수\n- ISO 낮게\n- 셔터스피드 길게\n- 조리개는 f8-11 정도\n\n야경 사진 찍으시는 분들 팁 공유해요!','','','',0,0,441,63,0,'admin','','최고관리자','admin@domain.com','','2025-12-17 16:37:21',0,'2025-12-17 16:37:21','127.0.0.1','','','','','','','','','','','',''),(27,-27,'',27,0,14,'','','html1','벚꽃 사진 예쁘게 나왔어요 (27)','<p><img src=\"https://picsum.photos/id/127/700/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n지난 봄에 찍은 벚꽃 사진인데, 정리하다가 발견해서 올려요.\n\n여의도 윤중로에서 찍었는데, 벚꽃이 만개했을 때라 정말 예뻤어요. 분홍빛 꽃잎이 바람에 날리는 게 영화 같았습니다.\n\n내년 벚꽃 시즌에는 꼭 가보세요!\n\n추천 벚꽃 명소:\n- 여의도 윤중로\n- 석촌호수\n- 남산\n- 경주 보문단지','','','',0,0,1059,72,0,'admin','','최고관리자','admin@domain.com','','2025-12-16 23:37:21',0,'2025-12-16 23:37:21','127.0.0.1','','','','','','','','','','','',''),(28,-28,'',28,0,4,'','','html1','맛있는 브런치 사진입니다 (28)','<p><img src=\"https://picsum.photos/id/128/700/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말 브런치 사진이에요.\n\n오랜만에 여유롭게 브런치 먹으러 갔는데, 음식도 맛있고 플레이팅도 예뻐서 사진 찍어봤어요.\n\n주문한 메뉴:\n- 에그베네딕트\n- 팬케이크\n- 아메리카노\n\n가격은 2인 기준 5만원 정도였어요. 분위기 좋고 음식 맛있어서 만족!\n\n브런치 맛집 추천받아요!','','','',0,0,1379,28,0,'admin','','최고관리자','admin@domain.com','','2025-12-16 08:37:21',0,'2025-12-16 08:37:21','127.0.0.1','','','','','','','','','','','',''),(29,-29,'',29,0,13,'','','html1','출근길 지하철역 풍경이에요 (29)','<p><img src=\"https://picsum.photos/id/129/800/500\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n출근길 지하철역에서 찍은 사진이에요.\n\n매일 지나가는 곳인데, 오늘따라 빛이 예쁘게 들어와서 사진 찍어봤어요. 일상 속에서 발견하는 아름다움이랄까요.\n\n출퇴근하면서 스쳐 지나가는 풍경도 가끔은 멈춰서 바라보면 새롭게 보이더라고요.\n\n여러분의 출퇴근길 풍경은 어떤가요?','','','',0,0,1466,37,0,'admin','','최고관리자','admin@domain.com','','2025-12-15 04:37:21',0,'2025-12-15 04:37:21','127.0.0.1','','','','','','','','','','','',''),(30,-30,'',30,0,20,'','','html1','비 오는 날 감성 사진 (30)','<p><img src=\"https://picsum.photos/id/130/400/500\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n비 오는 날 찍은 사진이에요.\n\n빗방울이 창문에 맺혀있는 거 찍어봤는데, 나름 감성 있게 나왔네요. 비 오는 날 특유의 촉촉한 분위기가 좋아요.\n\n비 오는 날 사진 팁:\n- 창문의 빗방울 클로즈업\n- 우산 쓴 사람들\n- 물웅덩이 반영\n- 비에 젖은 거리\n\n다음에 비 오면 우산 들고 나가서 더 많이 찍어봐야겠어요.','','','',0,0,1065,11,0,'admin','','최고관리자','admin@domain.com','','2025-12-13 21:37:21',0,'2025-12-13 21:37:21','127.0.0.1','','','','','','','','','','','',''),(31,-31,'',31,0,6,'','','html1','노을 지는 바다 풍경입니다 (31)','<p><img src=\"https://picsum.photos/id/131/500/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말에 바다 보러 갔다가 찍은 노을 사진이에요.\n\n해가 지면서 하늘이 주황색, 빨간색으로 물들었는데... 진짜 장관이었어요. 이런 풍경 보면 힐링 되는 것 같아요.\n\n장소: 강릉 경포해변\n시간: 저녁 6시경\n\n바다 + 노을 조합은 진리입니다. 스트레스 받을 때 바다 보러 가세요!','','','',0,0,676,68,0,'admin','','최고관리자','admin@domain.com','','2025-12-13 01:37:21',0,'2025-12-13 01:37:21','127.0.0.1','','','','','','','','','','','',''),(32,-32,'',32,0,4,'','','html1','가을 단풍 사진 공유해요 (32)','<p><img src=\"https://picsum.photos/id/132/800/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n단풍 구경 다녀왔어요!\n\n설악산 근처 드라이브하면서 찍은 사진인데, 온 산이 빨갛고 노랗고... 정말 예뻤어요.\n\n단풍 명소 추천:\n- 설악산\n- 내장산\n- 남이섬\n- 덕유산\n\n지금이 단풍 절정 시기니까 이번 주말에 꼭 가보세요! 다음 주면 다 질 수도 있어요.','','','',0,0,927,88,0,'admin','','최고관리자','admin@domain.com','','2025-12-13 02:37:21',0,'2025-12-13 02:37:21','127.0.0.1','','','','','','','','','','','',''),(33,-33,'',33,0,14,'','','html1','귀여운 고양이 사진이에요 (33)','<p><img src=\"https://picsum.photos/id/133/500/500\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n동네에서 만난 고양이예요.\n\n매일 출근길에 보이는 고양이인데, 오늘은 가까이 와서 사진 찍었어요. 경계심이 없고 너무 귀여워요!\n\n이 동네 고양이 특징:\n- 사람 무서워 안 함\n- 쓰다듬으면 가만히 있음\n- 간식 주면 더 좋아함\n\n길고양이 사진 공유해요!','','','',0,0,1380,6,0,'admin','','최고관리자','admin@domain.com','','2025-12-11 16:37:21',0,'2025-12-11 16:37:21','127.0.0.1','','','','','','','','','','','',''),(34,-34,'',34,0,15,'','','html1','캠핑장에서 찍은 사진 (34)','<p><img src=\"https://picsum.photos/id/134/700/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말 캠핑 다녀왔어요!\n\n날씨도 좋고 공기도 맑고... 도심에서 벗어나니까 힐링 되더라고요.\n\n캠핑 장비:\n- 텐트: 코베아 3인용\n- 체어: 헬리녹스\n- 테이블: 접이식\n- 랜턴: 충전식 LED\n\n캠핑 초보인데, 다음에는 바베큐도 해보려고요. 캠핑 팁 있으면 알려주세요!','','','',0,0,146,30,0,'admin','','최고관리자','admin@domain.com','','2025-12-11 00:37:21',0,'2025-12-11 00:37:21','127.0.0.1','','','','','','','','','','','',''),(35,-35,'',35,0,3,'','','html1','눈 오는 날 풍경 사진 (35)','<p><img src=\"https://picsum.photos/id/135/600/500\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n첫눈 왔을 때 찍은 사진이에요.\n\n눈이 소복소복 쌓이는 거 보니까 기분이 좋더라고요. 겨울 감성 물씬!\n\n눈 사진 찍을 때 팁:\n- 노출 +0.5~1 정도 올리기 (눈이 회색으로 나올 수 있음)\n- 셔터스피드 빠르게 (눈송이 담기)\n- 역광으로 찍으면 반짝반짝\n\n눈 오면 또 사진 찍으러 나가야겠어요!','','','',0,0,1101,78,0,'admin','','최고관리자','admin@domain.com','','2025-12-10 08:37:21',0,'2025-12-10 08:37:21','127.0.0.1','','','','','','','','','','','',''),(36,-36,'',36,0,2,'','','html1','도시 야경 사진 공유합니다 (36)','<p><img src=\"https://picsum.photos/id/136/800/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n서울 야경 사진이에요.\n\n남산타워에서 찍은 건데, 서울 전경이 한눈에 보여서 좋았어요. 야경 사진은 역시 높은 곳에서 찍어야 제맛!\n\n서울 야경 명소:\n- 남산타워\n- 북악스카이웨이\n- 인왕산\n- 응봉산\n\n다음에는 인왕산 가서 찍어볼 예정이에요.','','','',0,0,965,39,0,'admin','','최고관리자','admin@domain.com','','2025-12-09 03:37:21',0,'2025-12-09 03:37:21','127.0.0.1','','','','','','','','','','','',''),(37,-37,'',37,0,17,'','','html1','숲길 산책하며 찍은 사진 (37)','<p><img src=\"https://picsum.photos/id/137/500/600\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말에 숲길 산책하면서 찍은 사진이에요.\n\n나무 사이로 햇빛이 들어오는 게 너무 예뻤어요. 피톤치드 마시면서 걸으니까 힐링 그 자체!\n\n서울 근교 숲길 추천:\n- 북한산 둘레길\n- 관악산 자락길\n- 서울숲\n- 올림픽공원\n\n등산은 힘들어도 숲길 산책은 누구나 할 수 있어요!','','','',0,0,653,46,0,'admin','','최고관리자','admin@domain.com','','2025-12-08 03:37:21',0,'2025-12-08 03:37:21','127.0.0.1','','','','','','','','','','','',''),(38,-38,'',38,0,15,'','','html1','일출 사진 새벽에 찍었어요 (38)','<p><img src=\"https://picsum.photos/id/138/800/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n새벽에 일어나서 일출 찍었어요.\n\n힘들었지만 이 풍경 보니까 다 보상받는 느낌! 태양이 수평선 위로 떠오르는 순간은 정말 감동적이었어요.\n\n일출 명소:\n- 정동진\n- 울산 간절곶\n- 부산 해운대\n- 강릉 경포대\n\n내년 1월 1일에는 해돋이 보러 가야겠어요!','','','',0,0,1380,28,0,'admin','','최고관리자','admin@domain.com','','2025-12-07 10:37:21',0,'2025-12-07 10:37:21','127.0.0.1','','','','','','','','','','','',''),(39,-39,'',39,0,6,'','','html1','하늘 구름 사진 예술이네요 (39)','<p><img src=\"https://picsum.photos/id/139/400/500\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n오늘 구름이 너무 예뻐서 사진 찍어봤어요.\n\n뭉게구름이 하늘에 동동 떠다니는데, 마치 그림 같았어요. 자연이 만든 예술 작품!\n\n구름 사진 팁:\n- 광각 렌즈 활용\n- 전경과 함께 찍기\n- 골든아워에 찍기\n- 편광필터 사용\n\n하늘 사진 좋아하시는 분들 공유해요!','','','',0,0,1018,93,0,'admin','','최고관리자','admin@domain.com','','2025-12-06 12:37:21',0,'2025-12-06 12:37:21','127.0.0.1','','','','','','','','','','','',''),(40,-40,'',40,0,9,'','','html1','주말 피크닉 사진이에요 (40)','<p><img src=\"https://picsum.photos/id/140/600/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말에 한강에서 피크닉했어요.\n\n돗자리 깔고 김밥 먹으면서 여유롭게 시간 보냈는데, 너무 좋았어요. 이런 소소한 행복이 최고!\n\n피크닉 준비물:\n- 돗자리\n- 김밥, 샌드위치\n- 음료\n- 블루투스 스피커\n- 책\n\n날씨 좋을 때 피크닉 강추합니다!','','','',0,0,357,100,0,'admin','','최고관리자','admin@domain.com','','2025-12-04 21:37:21',0,'2025-12-04 21:37:21','127.0.0.1','','','','','','','','','','','',''),(41,-41,'',41,0,12,'','','html1','오늘 퇴근길 하늘 사진입니다 (41)','<p><img src=\"https://picsum.photos/id/141/600/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n오늘 퇴근길에 하늘이 너무 예뻐서 사진 찍어봤어요.\n\n노을이 지면서 하늘이 분홍색, 주황색, 보라색으로 물들었는데... 사진으로는 이 아름다움을 다 담을 수가 없네요. 실제로 보면 정말 숨이 멎을 것 같은 풍경이었어요.\n\n카메라: 아이폰 15 프로\n보정: 라이트룸에서 약간의 색감 보정\n장소: 회사 옥상\n\n요즘 날씨가 좋아서 그런지 하늘이 유독 예쁜 것 같아요. 여러분도 오늘 하늘 보셨나요?','','','',0,0,1030,22,0,'admin','','최고관리자','admin@domain.com','','2025-12-04 10:37:21',0,'2025-12-04 10:37:21','127.0.0.1','','','','','','','','','','','',''),(42,-42,'',42,0,14,'','','html1','성수동 카페 인테리어 예쁘네요 (42)','<p><img src=\"https://picsum.photos/id/142/600/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n오늘 새로 오픈한 카페 갔다가 인테리어가 너무 예뻐서 사진 엄청 찍어왔어요!\n\n이 카페 특징:\n- 빈티지한 느낌의 인테리어\n- 자연광이 잘 들어오는 큰 창문\n- 식물이 많아서 힐링됨\n- 조용한 음악\n\n커피도 맛있었어요. 아메리카노랑 크로플 시켰는데 둘 다 맛있었습니다.\n\n위치는 성수동이고, 주말에는 웨이팅이 있을 수 있어요. 인스타 감성 카페 찾으시는 분들께 강추!','','','',0,0,395,15,0,'admin','','최고관리자','admin@domain.com','','2025-12-03 17:37:21',0,'2025-12-03 17:37:21','127.0.0.1','','','','','','','','','','','',''),(43,-43,'',43,0,5,'','','html1','제주도 여행 사진 공유합니다 (43)','<p><img src=\"https://picsum.photos/id/143/500/600\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n지난 주말에 다녀온 제주도 여행 사진입니다!\n\n2박 3일 일정으로 다녀왔는데, 날씨가 정말 좋았어요. 구름 한 점 없는 맑은 하늘에 바다는 에메랄드빛...\n\n이번 여행 코스:\n1일차 - 협재해수욕장, 애월카페거리\n2일차 - 성산일출봉, 우도\n3일차 - 중문관광단지, 천지연폭포\n\n가장 좋았던 곳은 우도예요. 자전거 타고 섬 한 바퀴 돌았는데 경치가 진짜 미쳤습니다.','','','',0,0,646,60,0,'admin','','최고관리자','admin@domain.com','','2025-12-03 02:37:21',0,'2025-12-03 02:37:21','127.0.0.1','','','','','','','','','','','',''),(44,-44,'',44,0,9,'','','html1','우리 집 강아지 사진 자랑해요 (44)','<p><img src=\"https://picsum.photos/id/144/400/500\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n우리 집 강아지 사진 자랑할게요 ㅎㅎ\n\n이름은 \'몽이\'고, 포메라니안 3살입니다. 털이 복슬복슬해서 진짜 인형 같아요!\n\n오늘 산책 갔다 와서 지쳐서 자고 있는 사진인데, 자는 모습도 너무 귀엽지 않나요?\n\n몽이 특징:\n- 간식 앞에서는 뭐든 함\n- 산책 좋아함 (특히 공원)\n- 낯선 사람 경계함\n- 배 만져주면 좋아함\n\n반려동물 키우시는 분들 사진 공유해요!','','','',0,0,414,87,0,'admin','','최고관리자','admin@domain.com','','2025-12-01 23:37:21',0,'2025-12-01 23:37:21','127.0.0.1','','','','','','','','','','','',''),(45,-45,'',45,0,6,'','','html1','일상 스냅 사진 모음입니다 (45)','<p><img src=\"https://picsum.photos/id/145/800/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n요즘 일상 사진 찍는 재미에 빠졌어요.\n\n특별한 거 없이 그냥 지나가다 예쁘면 찍고, 맛있는 거 먹으면 찍고... 이렇게 모으다 보니까 나름의 기록이 되더라고요.\n\n오늘 올리는 사진들:\n1. 아침에 마신 커피\n2. 점심에 먹은 파스타\n3. 퇴근길 골목 풍경\n4. 저녁에 본 고양이\n\n일상이 특별해지는 느낌이에요.','','','',0,0,1165,42,0,'admin','','최고관리자','admin@domain.com','','2025-12-01 05:37:21',0,'2025-12-01 05:37:21','127.0.0.1','','','','','','','','','','','',''),(46,-46,'',46,0,8,'','','html1','한강 야경 사진 찍어왔어요 (46)','<p><img src=\"https://picsum.photos/id/146/700/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n어제 한강에서 야경 사진 찍어왔어요.\n\n날씨도 좋고 바람도 시원해서 산책하면서 사진 찍었는데 너무 잘 나왔어요!\n\n촬영 정보:\n- 장소: 반포한강공원\n- 시간: 저녁 8시경\n- 장비: 소니 A7C + 35mm f1.8\n- 삼각대 사용\n\n야경 사진 팁:\n- 삼각대 필수\n- ISO 낮게\n- 셔터스피드 길게\n- 조리개는 f8-11 정도\n\n야경 사진 찍으시는 분들 팁 공유해요!','','','',0,0,1327,90,0,'admin','','최고관리자','admin@domain.com','','2025-11-29 20:37:21',0,'2025-11-29 20:37:21','127.0.0.1','','','','','','','','','','','',''),(47,-47,'',47,0,16,'','','html1','벚꽃 사진 예쁘게 나왔어요 (47)','<p><img src=\"https://picsum.photos/id/147/800/600\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n지난 봄에 찍은 벚꽃 사진인데, 정리하다가 발견해서 올려요.\n\n여의도 윤중로에서 찍었는데, 벚꽃이 만개했을 때라 정말 예뻤어요. 분홍빛 꽃잎이 바람에 날리는 게 영화 같았습니다.\n\n내년 벚꽃 시즌에는 꼭 가보세요!\n\n추천 벚꽃 명소:\n- 여의도 윤중로\n- 석촌호수\n- 남산\n- 경주 보문단지','','','',0,0,1306,55,0,'admin','','최고관리자','admin@domain.com','','2025-11-29 03:37:21',0,'2025-11-29 03:37:21','127.0.0.1','','','','','','','','','','','',''),(48,-48,'',48,0,20,'','','html1','맛있는 브런치 사진입니다 (48)','<p><img src=\"https://picsum.photos/id/148/400/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말 브런치 사진이에요.\n\n오랜만에 여유롭게 브런치 먹으러 갔는데, 음식도 맛있고 플레이팅도 예뻐서 사진 찍어봤어요.\n\n주문한 메뉴:\n- 에그베네딕트\n- 팬케이크\n- 아메리카노\n\n가격은 2인 기준 5만원 정도였어요. 분위기 좋고 음식 맛있어서 만족!\n\n브런치 맛집 추천받아요!','','','',0,0,1420,40,0,'admin','','최고관리자','admin@domain.com','','2025-11-28 09:37:21',0,'2025-11-28 09:37:21','127.0.0.1','','','','','','','','','','','',''),(49,-49,'',49,0,19,'','','html1','출근길 지하철역 풍경이에요 (49)','<p><img src=\"https://picsum.photos/id/149/700/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n출근길 지하철역에서 찍은 사진이에요.\n\n매일 지나가는 곳인데, 오늘따라 빛이 예쁘게 들어와서 사진 찍어봤어요. 일상 속에서 발견하는 아름다움이랄까요.\n\n출퇴근하면서 스쳐 지나가는 풍경도 가끔은 멈춰서 바라보면 새롭게 보이더라고요.\n\n여러분의 출퇴근길 풍경은 어떤가요?','','','',0,0,987,68,0,'admin','','최고관리자','admin@domain.com','','2025-11-26 16:37:21',0,'2025-11-26 16:37:21','127.0.0.1','','','','','','','','','','','',''),(50,-50,'',50,0,5,'','','html1','비 오는 날 감성 사진 (50)','<p><img src=\"https://picsum.photos/id/150/800/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n비 오는 날 찍은 사진이에요.\n\n빗방울이 창문에 맺혀있는 거 찍어봤는데, 나름 감성 있게 나왔네요. 비 오는 날 특유의 촉촉한 분위기가 좋아요.\n\n비 오는 날 사진 팁:\n- 창문의 빗방울 클로즈업\n- 우산 쓴 사람들\n- 물웅덩이 반영\n- 비에 젖은 거리\n\n다음에 비 오면 우산 들고 나가서 더 많이 찍어봐야겠어요.','','','',0,0,1118,49,0,'admin','','최고관리자','admin@domain.com','','2025-11-26 12:37:21',0,'2025-11-26 12:37:21','127.0.0.1','','','','','','','','','','','',''),(51,-51,'',51,0,4,'','','html1','노을 지는 바다 풍경입니다 (51)','<p><img src=\"https://picsum.photos/id/151/700/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말에 바다 보러 갔다가 찍은 노을 사진이에요.\n\n해가 지면서 하늘이 주황색, 빨간색으로 물들었는데... 진짜 장관이었어요. 이런 풍경 보면 힐링 되는 것 같아요.\n\n장소: 강릉 경포해변\n시간: 저녁 6시경\n\n바다 + 노을 조합은 진리입니다. 스트레스 받을 때 바다 보러 가세요!','','','',0,0,240,6,0,'admin','','최고관리자','admin@domain.com','','2025-11-24 21:37:21',0,'2025-11-24 21:37:21','127.0.0.1','','','','','','','','','','','',''),(52,-52,'',52,0,12,'','','html1','가을 단풍 사진 공유해요 (52)','<p><img src=\"https://picsum.photos/id/152/600/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n단풍 구경 다녀왔어요!\n\n설악산 근처 드라이브하면서 찍은 사진인데, 온 산이 빨갛고 노랗고... 정말 예뻤어요.\n\n단풍 명소 추천:\n- 설악산\n- 내장산\n- 남이섬\n- 덕유산\n\n지금이 단풍 절정 시기니까 이번 주말에 꼭 가보세요! 다음 주면 다 질 수도 있어요.','','','',0,0,1354,30,0,'admin','','최고관리자','admin@domain.com','','2025-11-24 22:37:21',0,'2025-11-24 22:37:21','127.0.0.1','','','','','','','','','','','',''),(53,-53,'',53,0,5,'','','html1','귀여운 고양이 사진이에요 (53)','<p><img src=\"https://picsum.photos/id/153/700/600\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n동네에서 만난 고양이예요.\n\n매일 출근길에 보이는 고양이인데, 오늘은 가까이 와서 사진 찍었어요. 경계심이 없고 너무 귀여워요!\n\n이 동네 고양이 특징:\n- 사람 무서워 안 함\n- 쓰다듬으면 가만히 있음\n- 간식 주면 더 좋아함\n\n길고양이 사진 공유해요!','','','',0,0,1168,14,0,'admin','','최고관리자','admin@domain.com','','2025-11-23 17:37:21',0,'2025-11-23 17:37:21','127.0.0.1','','','','','','','','','','','',''),(54,-54,'',54,0,16,'','','html1','캠핑장에서 찍은 사진 (54)','<p><img src=\"https://picsum.photos/id/154/500/600\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말 캠핑 다녀왔어요!\n\n날씨도 좋고 공기도 맑고... 도심에서 벗어나니까 힐링 되더라고요.\n\n캠핑 장비:\n- 텐트: 코베아 3인용\n- 체어: 헬리녹스\n- 테이블: 접이식\n- 랜턴: 충전식 LED\n\n캠핑 초보인데, 다음에는 바베큐도 해보려고요. 캠핑 팁 있으면 알려주세요!','','','',0,0,765,51,0,'admin','','최고관리자','admin@domain.com','','2025-11-23 11:37:21',0,'2025-11-23 11:37:21','127.0.0.1','','','','','','','','','','','',''),(55,-55,'',55,0,5,'','','html1','눈 오는 날 풍경 사진 (55)','<p><img src=\"https://picsum.photos/id/155/700/600\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n첫눈 왔을 때 찍은 사진이에요.\n\n눈이 소복소복 쌓이는 거 보니까 기분이 좋더라고요. 겨울 감성 물씬!\n\n눈 사진 찍을 때 팁:\n- 노출 +0.5~1 정도 올리기 (눈이 회색으로 나올 수 있음)\n- 셔터스피드 빠르게 (눈송이 담기)\n- 역광으로 찍으면 반짝반짝\n\n눈 오면 또 사진 찍으러 나가야겠어요!','','','',0,0,224,68,0,'admin','','최고관리자','admin@domain.com','','2025-11-21 20:37:21',0,'2025-11-21 20:37:21','127.0.0.1','','','','','','','','','','','',''),(56,-56,'',56,0,8,'','','html1','도시 야경 사진 공유합니다 (56)','<p><img src=\"https://picsum.photos/id/156/600/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n서울 야경 사진이에요.\n\n남산타워에서 찍은 건데, 서울 전경이 한눈에 보여서 좋았어요. 야경 사진은 역시 높은 곳에서 찍어야 제맛!\n\n서울 야경 명소:\n- 남산타워\n- 북악스카이웨이\n- 인왕산\n- 응봉산\n\n다음에는 인왕산 가서 찍어볼 예정이에요.','','','',0,0,1493,8,0,'admin','','최고관리자','admin@domain.com','','2025-11-20 16:37:21',0,'2025-11-20 16:37:21','127.0.0.1','','','','','','','','','','','',''),(57,-57,'',57,0,11,'','','html1','숲길 산책하며 찍은 사진 (57)','<p><img src=\"https://picsum.photos/id/157/700/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말에 숲길 산책하면서 찍은 사진이에요.\n\n나무 사이로 햇빛이 들어오는 게 너무 예뻤어요. 피톤치드 마시면서 걸으니까 힐링 그 자체!\n\n서울 근교 숲길 추천:\n- 북한산 둘레길\n- 관악산 자락길\n- 서울숲\n- 올림픽공원\n\n등산은 힘들어도 숲길 산책은 누구나 할 수 있어요!','','','',0,0,1019,33,0,'admin','','최고관리자','admin@domain.com','','2025-11-20 02:37:21',0,'2025-11-20 02:37:21','127.0.0.1','','','','','','','','','','','',''),(58,-58,'',58,0,4,'','','html1','일출 사진 새벽에 찍었어요 (58)','<p><img src=\"https://picsum.photos/id/158/600/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n새벽에 일어나서 일출 찍었어요.\n\n힘들었지만 이 풍경 보니까 다 보상받는 느낌! 태양이 수평선 위로 떠오르는 순간은 정말 감동적이었어요.\n\n일출 명소:\n- 정동진\n- 울산 간절곶\n- 부산 해운대\n- 강릉 경포대\n\n내년 1월 1일에는 해돋이 보러 가야겠어요!','','','',0,0,110,70,0,'admin','','최고관리자','admin@domain.com','','2025-11-19 03:37:21',0,'2025-11-19 03:37:21','127.0.0.1','','','','','','','','','','','',''),(59,-59,'',59,0,17,'','','html1','하늘 구름 사진 예술이네요 (59)','<p><img src=\"https://picsum.photos/id/159/400/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n오늘 구름이 너무 예뻐서 사진 찍어봤어요.\n\n뭉게구름이 하늘에 동동 떠다니는데, 마치 그림 같았어요. 자연이 만든 예술 작품!\n\n구름 사진 팁:\n- 광각 렌즈 활용\n- 전경과 함께 찍기\n- 골든아워에 찍기\n- 편광필터 사용\n\n하늘 사진 좋아하시는 분들 공유해요!','','','',0,0,1483,53,0,'admin','','최고관리자','admin@domain.com','','2025-11-17 20:37:21',0,'2025-11-17 20:37:21','127.0.0.1','','','','','','','','','','','',''),(60,-60,'',60,0,15,'','','html1','주말 피크닉 사진이에요 (60)','<p><img src=\"https://picsum.photos/id/160/600/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말에 한강에서 피크닉했어요.\n\n돗자리 깔고 김밥 먹으면서 여유롭게 시간 보냈는데, 너무 좋았어요. 이런 소소한 행복이 최고!\n\n피크닉 준비물:\n- 돗자리\n- 김밥, 샌드위치\n- 음료\n- 블루투스 스피커\n- 책\n\n날씨 좋을 때 피크닉 강추합니다!','','','',0,0,223,90,0,'admin','','최고관리자','admin@domain.com','','2025-11-16 18:37:21',0,'2025-11-16 18:37:21','127.0.0.1','','','','','','','','','','','',''),(61,-61,'',61,0,10,'','','html1','오늘 퇴근길 하늘 사진입니다 (61)','<p><img src=\"https://picsum.photos/id/161/500/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n오늘 퇴근길에 하늘이 너무 예뻐서 사진 찍어봤어요.\n\n노을이 지면서 하늘이 분홍색, 주황색, 보라색으로 물들었는데... 사진으로는 이 아름다움을 다 담을 수가 없네요. 실제로 보면 정말 숨이 멎을 것 같은 풍경이었어요.\n\n카메라: 아이폰 15 프로\n보정: 라이트룸에서 약간의 색감 보정\n장소: 회사 옥상\n\n요즘 날씨가 좋아서 그런지 하늘이 유독 예쁜 것 같아요. 여러분도 오늘 하늘 보셨나요?','','','',0,0,1276,36,0,'admin','','최고관리자','admin@domain.com','','2025-11-16 02:37:21',0,'2025-11-16 02:37:21','127.0.0.1','','','','','','','','','','','',''),(62,-62,'',62,0,16,'','','html1','성수동 카페 인테리어 예쁘네요 (62)','<p><img src=\"https://picsum.photos/id/162/400/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n오늘 새로 오픈한 카페 갔다가 인테리어가 너무 예뻐서 사진 엄청 찍어왔어요!\n\n이 카페 특징:\n- 빈티지한 느낌의 인테리어\n- 자연광이 잘 들어오는 큰 창문\n- 식물이 많아서 힐링됨\n- 조용한 음악\n\n커피도 맛있었어요. 아메리카노랑 크로플 시켰는데 둘 다 맛있었습니다.\n\n위치는 성수동이고, 주말에는 웨이팅이 있을 수 있어요. 인스타 감성 카페 찾으시는 분들께 강추!','','','',0,0,377,37,0,'admin','','최고관리자','admin@domain.com','','2025-11-16 04:37:21',0,'2025-11-16 04:37:21','127.0.0.1','','','','','','','','','','','',''),(63,-63,'',63,0,12,'','','html1','제주도 여행 사진 공유합니다 (63)','<p><img src=\"https://picsum.photos/id/163/400/500\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n지난 주말에 다녀온 제주도 여행 사진입니다!\n\n2박 3일 일정으로 다녀왔는데, 날씨가 정말 좋았어요. 구름 한 점 없는 맑은 하늘에 바다는 에메랄드빛...\n\n이번 여행 코스:\n1일차 - 협재해수욕장, 애월카페거리\n2일차 - 성산일출봉, 우도\n3일차 - 중문관광단지, 천지연폭포\n\n가장 좋았던 곳은 우도예요. 자전거 타고 섬 한 바퀴 돌았는데 경치가 진짜 미쳤습니다.','','','',0,0,650,76,0,'admin','','최고관리자','admin@domain.com','','2025-11-15 15:37:21',0,'2025-11-15 15:37:21','127.0.0.1','','','','','','','','','','','',''),(64,-64,'',64,0,0,'','','html1','우리 집 강아지 사진 자랑해요 (64)','<p><img src=\"https://picsum.photos/id/164/600/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n우리 집 강아지 사진 자랑할게요 ㅎㅎ\n\n이름은 \'몽이\'고, 포메라니안 3살입니다. 털이 복슬복슬해서 진짜 인형 같아요!\n\n오늘 산책 갔다 와서 지쳐서 자고 있는 사진인데, 자는 모습도 너무 귀엽지 않나요?\n\n몽이 특징:\n- 간식 앞에서는 뭐든 함\n- 산책 좋아함 (특히 공원)\n- 낯선 사람 경계함\n- 배 만져주면 좋아함\n\n반려동물 키우시는 분들 사진 공유해요!','','','',0,0,1285,67,0,'admin','','최고관리자','admin@domain.com','','2025-11-14 11:37:21',0,'2025-11-14 11:37:21','127.0.0.1','','','','','','','','','','','',''),(65,-65,'',65,0,10,'','','html1','일상 스냅 사진 모음입니다 (65)','<p><img src=\"https://picsum.photos/id/165/400/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n요즘 일상 사진 찍는 재미에 빠졌어요.\n\n특별한 거 없이 그냥 지나가다 예쁘면 찍고, 맛있는 거 먹으면 찍고... 이렇게 모으다 보니까 나름의 기록이 되더라고요.\n\n오늘 올리는 사진들:\n1. 아침에 마신 커피\n2. 점심에 먹은 파스타\n3. 퇴근길 골목 풍경\n4. 저녁에 본 고양이\n\n일상이 특별해지는 느낌이에요.','','','',0,0,809,12,0,'admin','','최고관리자','admin@domain.com','','2025-11-13 02:37:21',0,'2025-11-13 02:37:21','127.0.0.1','','','','','','','','','','','',''),(66,-66,'',66,0,1,'','','html1','한강 야경 사진 찍어왔어요 (66)','<p><img src=\"https://picsum.photos/id/166/800/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n어제 한강에서 야경 사진 찍어왔어요.\n\n날씨도 좋고 바람도 시원해서 산책하면서 사진 찍었는데 너무 잘 나왔어요!\n\n촬영 정보:\n- 장소: 반포한강공원\n- 시간: 저녁 8시경\n- 장비: 소니 A7C + 35mm f1.8\n- 삼각대 사용\n\n야경 사진 팁:\n- 삼각대 필수\n- ISO 낮게\n- 셔터스피드 길게\n- 조리개는 f8-11 정도\n\n야경 사진 찍으시는 분들 팁 공유해요!','','','',0,0,1213,42,0,'admin','','최고관리자','admin@domain.com','','2025-11-12 02:37:21',0,'2025-11-12 02:37:21','127.0.0.1','','','','','','','','','','','',''),(67,-67,'',67,0,19,'','','html1','벚꽃 사진 예쁘게 나왔어요 (67)','<p><img src=\"https://picsum.photos/id/167/700/500\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n지난 봄에 찍은 벚꽃 사진인데, 정리하다가 발견해서 올려요.\n\n여의도 윤중로에서 찍었는데, 벚꽃이 만개했을 때라 정말 예뻤어요. 분홍빛 꽃잎이 바람에 날리는 게 영화 같았습니다.\n\n내년 벚꽃 시즌에는 꼭 가보세요!\n\n추천 벚꽃 명소:\n- 여의도 윤중로\n- 석촌호수\n- 남산\n- 경주 보문단지','','','',0,0,528,54,0,'admin','','최고관리자','admin@domain.com','','2025-11-11 08:37:21',0,'2025-11-11 08:37:21','127.0.0.1','','','','','','','','','','','',''),(68,-68,'',68,0,14,'','','html1','맛있는 브런치 사진입니다 (68)','<p><img src=\"https://picsum.photos/id/168/800/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말 브런치 사진이에요.\n\n오랜만에 여유롭게 브런치 먹으러 갔는데, 음식도 맛있고 플레이팅도 예뻐서 사진 찍어봤어요.\n\n주문한 메뉴:\n- 에그베네딕트\n- 팬케이크\n- 아메리카노\n\n가격은 2인 기준 5만원 정도였어요. 분위기 좋고 음식 맛있어서 만족!\n\n브런치 맛집 추천받아요!','','','',0,0,655,67,0,'admin','','최고관리자','admin@domain.com','','2025-11-10 10:37:21',0,'2025-11-10 10:37:21','127.0.0.1','','','','','','','','','','','',''),(69,-69,'',69,0,11,'','','html1','출근길 지하철역 풍경이에요 (69)','<p><img src=\"https://picsum.photos/id/169/500/600\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n출근길 지하철역에서 찍은 사진이에요.\n\n매일 지나가는 곳인데, 오늘따라 빛이 예쁘게 들어와서 사진 찍어봤어요. 일상 속에서 발견하는 아름다움이랄까요.\n\n출퇴근하면서 스쳐 지나가는 풍경도 가끔은 멈춰서 바라보면 새롭게 보이더라고요.\n\n여러분의 출퇴근길 풍경은 어떤가요?','','','',0,0,842,36,0,'admin','','최고관리자','admin@domain.com','','2025-11-09 11:37:21',0,'2025-11-09 11:37:21','127.0.0.1','','','','','','','','','','','',''),(70,-70,'',70,0,10,'','','html1','비 오는 날 감성 사진 (70)','<p><img src=\"https://picsum.photos/id/170/700/600\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n비 오는 날 찍은 사진이에요.\n\n빗방울이 창문에 맺혀있는 거 찍어봤는데, 나름 감성 있게 나왔네요. 비 오는 날 특유의 촉촉한 분위기가 좋아요.\n\n비 오는 날 사진 팁:\n- 창문의 빗방울 클로즈업\n- 우산 쓴 사람들\n- 물웅덩이 반영\n- 비에 젖은 거리\n\n다음에 비 오면 우산 들고 나가서 더 많이 찍어봐야겠어요.','','','',0,0,875,27,0,'admin','','최고관리자','admin@domain.com','','2025-11-08 15:37:21',0,'2025-11-08 15:37:21','127.0.0.1','','','','','','','','','','','',''),(71,-71,'',71,0,14,'','','html1','노을 지는 바다 풍경입니다 (71)','<p><img src=\"https://picsum.photos/id/171/800/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말에 바다 보러 갔다가 찍은 노을 사진이에요.\n\n해가 지면서 하늘이 주황색, 빨간색으로 물들었는데... 진짜 장관이었어요. 이런 풍경 보면 힐링 되는 것 같아요.\n\n장소: 강릉 경포해변\n시간: 저녁 6시경\n\n바다 + 노을 조합은 진리입니다. 스트레스 받을 때 바다 보러 가세요!','','','',0,0,424,11,0,'admin','','최고관리자','admin@domain.com','','2025-11-07 01:37:21',0,'2025-11-07 01:37:21','127.0.0.1','','','','','','','','','','','',''),(72,-72,'',72,0,2,'','','html1','가을 단풍 사진 공유해요 (72)','<p><img src=\"https://picsum.photos/id/172/500/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n단풍 구경 다녀왔어요!\n\n설악산 근처 드라이브하면서 찍은 사진인데, 온 산이 빨갛고 노랗고... 정말 예뻤어요.\n\n단풍 명소 추천:\n- 설악산\n- 내장산\n- 남이섬\n- 덕유산\n\n지금이 단풍 절정 시기니까 이번 주말에 꼭 가보세요! 다음 주면 다 질 수도 있어요.','','','',0,0,516,48,0,'admin','','최고관리자','admin@domain.com','','2025-11-07 08:37:21',0,'2025-11-07 08:37:21','127.0.0.1','','','','','','','','','','','',''),(73,-73,'',73,0,19,'','','html1','귀여운 고양이 사진이에요 (73)','<p><img src=\"https://picsum.photos/id/173/400/500\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n동네에서 만난 고양이예요.\n\n매일 출근길에 보이는 고양이인데, 오늘은 가까이 와서 사진 찍었어요. 경계심이 없고 너무 귀여워요!\n\n이 동네 고양이 특징:\n- 사람 무서워 안 함\n- 쓰다듬으면 가만히 있음\n- 간식 주면 더 좋아함\n\n길고양이 사진 공유해요!','','','',0,0,241,45,0,'admin','','최고관리자','admin@domain.com','','2025-11-05 22:37:21',0,'2025-11-05 22:37:21','127.0.0.1','','','','','','','','','','','',''),(74,-74,'',74,0,15,'','','html1','캠핑장에서 찍은 사진 (74)','<p><img src=\"https://picsum.photos/id/174/600/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말 캠핑 다녀왔어요!\n\n날씨도 좋고 공기도 맑고... 도심에서 벗어나니까 힐링 되더라고요.\n\n캠핑 장비:\n- 텐트: 코베아 3인용\n- 체어: 헬리녹스\n- 테이블: 접이식\n- 랜턴: 충전식 LED\n\n캠핑 초보인데, 다음에는 바베큐도 해보려고요. 캠핑 팁 있으면 알려주세요!','','','',0,0,1397,99,0,'admin','','최고관리자','admin@domain.com','','2025-11-05 05:37:21',0,'2025-11-05 05:37:21','127.0.0.1','','','','','','','','','','','',''),(75,-75,'',75,0,8,'','','html1','눈 오는 날 풍경 사진 (75)','<p><img src=\"https://picsum.photos/id/175/500/500\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n첫눈 왔을 때 찍은 사진이에요.\n\n눈이 소복소복 쌓이는 거 보니까 기분이 좋더라고요. 겨울 감성 물씬!\n\n눈 사진 찍을 때 팁:\n- 노출 +0.5~1 정도 올리기 (눈이 회색으로 나올 수 있음)\n- 셔터스피드 빠르게 (눈송이 담기)\n- 역광으로 찍으면 반짝반짝\n\n눈 오면 또 사진 찍으러 나가야겠어요!','','','',0,0,730,54,0,'admin','','최고관리자','admin@domain.com','','2025-11-03 21:37:21',0,'2025-11-03 21:37:21','127.0.0.1','','','','','','','','','','','',''),(76,-76,'',76,0,0,'','','html1','도시 야경 사진 공유합니다 (76)','<p><img src=\"https://picsum.photos/id/176/400/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n서울 야경 사진이에요.\n\n남산타워에서 찍은 건데, 서울 전경이 한눈에 보여서 좋았어요. 야경 사진은 역시 높은 곳에서 찍어야 제맛!\n\n서울 야경 명소:\n- 남산타워\n- 북악스카이웨이\n- 인왕산\n- 응봉산\n\n다음에는 인왕산 가서 찍어볼 예정이에요.','','','',0,0,653,13,0,'admin','','최고관리자','admin@domain.com','','2025-11-02 22:37:21',0,'2025-11-02 22:37:21','127.0.0.1','','','','','','','','','','','',''),(77,-77,'',77,0,3,'','','html1','숲길 산책하며 찍은 사진 (77)','<p><img src=\"https://picsum.photos/id/177/600/600\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말에 숲길 산책하면서 찍은 사진이에요.\n\n나무 사이로 햇빛이 들어오는 게 너무 예뻤어요. 피톤치드 마시면서 걸으니까 힐링 그 자체!\n\n서울 근교 숲길 추천:\n- 북한산 둘레길\n- 관악산 자락길\n- 서울숲\n- 올림픽공원\n\n등산은 힘들어도 숲길 산책은 누구나 할 수 있어요!','','','',0,0,432,25,0,'admin','','최고관리자','admin@domain.com','','2025-11-01 18:37:21',0,'2025-11-01 18:37:21','127.0.0.1','','','','','','','','','','','',''),(78,-78,'',78,0,11,'','','html1','일출 사진 새벽에 찍었어요 (78)','<p><img src=\"https://picsum.photos/id/178/400/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n새벽에 일어나서 일출 찍었어요.\n\n힘들었지만 이 풍경 보니까 다 보상받는 느낌! 태양이 수평선 위로 떠오르는 순간은 정말 감동적이었어요.\n\n일출 명소:\n- 정동진\n- 울산 간절곶\n- 부산 해운대\n- 강릉 경포대\n\n내년 1월 1일에는 해돋이 보러 가야겠어요!','','','',0,0,267,55,0,'admin','','최고관리자','admin@domain.com','','2025-11-01 01:37:21',0,'2025-11-01 01:37:21','127.0.0.1','','','','','','','','','','','',''),(79,-79,'',79,0,9,'','','html1','하늘 구름 사진 예술이네요 (79)','<p><img src=\"https://picsum.photos/id/179/700/500\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n오늘 구름이 너무 예뻐서 사진 찍어봤어요.\n\n뭉게구름이 하늘에 동동 떠다니는데, 마치 그림 같았어요. 자연이 만든 예술 작품!\n\n구름 사진 팁:\n- 광각 렌즈 활용\n- 전경과 함께 찍기\n- 골든아워에 찍기\n- 편광필터 사용\n\n하늘 사진 좋아하시는 분들 공유해요!','','','',0,0,198,9,0,'admin','','최고관리자','admin@domain.com','','2025-10-31 12:37:21',0,'2025-10-31 12:37:21','127.0.0.1','','','','','','','','','','','',''),(80,-80,'',80,0,7,'','','html1','주말 피크닉 사진이에요 (80)','<p><img src=\"https://picsum.photos/id/180/800/500\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말에 한강에서 피크닉했어요.\n\n돗자리 깔고 김밥 먹으면서 여유롭게 시간 보냈는데, 너무 좋았어요. 이런 소소한 행복이 최고!\n\n피크닉 준비물:\n- 돗자리\n- 김밥, 샌드위치\n- 음료\n- 블루투스 스피커\n- 책\n\n날씨 좋을 때 피크닉 강추합니다!','','','',0,0,916,83,0,'admin','','최고관리자','admin@domain.com','','2025-10-30 06:37:21',0,'2025-10-30 06:37:21','127.0.0.1','','','','','','','','','','','',''),(81,-81,'',81,0,5,'','','html1','오늘 퇴근길 하늘 사진입니다 (81)','<p><img src=\"https://picsum.photos/id/181/400/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n오늘 퇴근길에 하늘이 너무 예뻐서 사진 찍어봤어요.\n\n노을이 지면서 하늘이 분홍색, 주황색, 보라색으로 물들었는데... 사진으로는 이 아름다움을 다 담을 수가 없네요. 실제로 보면 정말 숨이 멎을 것 같은 풍경이었어요.\n\n카메라: 아이폰 15 프로\n보정: 라이트룸에서 약간의 색감 보정\n장소: 회사 옥상\n\n요즘 날씨가 좋아서 그런지 하늘이 유독 예쁜 것 같아요. 여러분도 오늘 하늘 보셨나요?','','','',0,0,553,87,0,'admin','','최고관리자','admin@domain.com','','2025-10-29 15:37:21',0,'2025-10-29 15:37:21','127.0.0.1','','','','','','','','','','','',''),(82,-82,'',82,0,0,'','','html1','성수동 카페 인테리어 예쁘네요 (82)','<p><img src=\"https://picsum.photos/id/182/600/600\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n오늘 새로 오픈한 카페 갔다가 인테리어가 너무 예뻐서 사진 엄청 찍어왔어요!\n\n이 카페 특징:\n- 빈티지한 느낌의 인테리어\n- 자연광이 잘 들어오는 큰 창문\n- 식물이 많아서 힐링됨\n- 조용한 음악\n\n커피도 맛있었어요. 아메리카노랑 크로플 시켰는데 둘 다 맛있었습니다.\n\n위치는 성수동이고, 주말에는 웨이팅이 있을 수 있어요. 인스타 감성 카페 찾으시는 분들께 강추!','','','',0,0,942,17,0,'admin','','최고관리자','admin@domain.com','','2025-10-29 04:37:21',0,'2025-10-29 04:37:21','127.0.0.1','','','','','','','','','','','',''),(83,-83,'',83,0,2,'','','html1','제주도 여행 사진 공유합니다 (83)','<p><img src=\"https://picsum.photos/id/183/500/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n지난 주말에 다녀온 제주도 여행 사진입니다!\n\n2박 3일 일정으로 다녀왔는데, 날씨가 정말 좋았어요. 구름 한 점 없는 맑은 하늘에 바다는 에메랄드빛...\n\n이번 여행 코스:\n1일차 - 협재해수욕장, 애월카페거리\n2일차 - 성산일출봉, 우도\n3일차 - 중문관광단지, 천지연폭포\n\n가장 좋았던 곳은 우도예요. 자전거 타고 섬 한 바퀴 돌았는데 경치가 진짜 미쳤습니다.','','','',0,0,581,90,0,'admin','','최고관리자','admin@domain.com','','2025-10-27 21:37:21',0,'2025-10-27 21:37:21','127.0.0.1','','','','','','','','','','','',''),(84,-84,'',84,0,3,'','','html1','우리 집 강아지 사진 자랑해요 (84)','<p><img src=\"https://picsum.photos/id/184/700/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n우리 집 강아지 사진 자랑할게요 ㅎㅎ\n\n이름은 \'몽이\'고, 포메라니안 3살입니다. 털이 복슬복슬해서 진짜 인형 같아요!\n\n오늘 산책 갔다 와서 지쳐서 자고 있는 사진인데, 자는 모습도 너무 귀엽지 않나요?\n\n몽이 특징:\n- 간식 앞에서는 뭐든 함\n- 산책 좋아함 (특히 공원)\n- 낯선 사람 경계함\n- 배 만져주면 좋아함\n\n반려동물 키우시는 분들 사진 공유해요!','','','',0,0,425,37,0,'admin','','최고관리자','admin@domain.com','','2025-10-27 02:37:21',0,'2025-10-27 02:37:21','127.0.0.1','','','','','','','','','','','',''),(85,-85,'',85,0,3,'','','html1','일상 스냅 사진 모음입니다 (85)','<p><img src=\"https://picsum.photos/id/185/500/600\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n요즘 일상 사진 찍는 재미에 빠졌어요.\n\n특별한 거 없이 그냥 지나가다 예쁘면 찍고, 맛있는 거 먹으면 찍고... 이렇게 모으다 보니까 나름의 기록이 되더라고요.\n\n오늘 올리는 사진들:\n1. 아침에 마신 커피\n2. 점심에 먹은 파스타\n3. 퇴근길 골목 풍경\n4. 저녁에 본 고양이\n\n일상이 특별해지는 느낌이에요.','','','',0,0,770,6,0,'admin','','최고관리자','admin@domain.com','','2025-10-26 14:37:21',0,'2025-10-26 14:37:21','127.0.0.1','','','','','','','','','','','',''),(86,-86,'',86,0,17,'','','html1','한강 야경 사진 찍어왔어요 (86)','<p><img src=\"https://picsum.photos/id/186/600/600\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n어제 한강에서 야경 사진 찍어왔어요.\n\n날씨도 좋고 바람도 시원해서 산책하면서 사진 찍었는데 너무 잘 나왔어요!\n\n촬영 정보:\n- 장소: 반포한강공원\n- 시간: 저녁 8시경\n- 장비: 소니 A7C + 35mm f1.8\n- 삼각대 사용\n\n야경 사진 팁:\n- 삼각대 필수\n- ISO 낮게\n- 셔터스피드 길게\n- 조리개는 f8-11 정도\n\n야경 사진 찍으시는 분들 팁 공유해요!','한강-야경-사진-찍어왔어요-86','','',0,0,618,100,0,'admin','','최고관리자','admin@domain.com','','2025-10-24 20:37:21',0,'2025-10-24 20:37:21','127.0.0.1','','','','','','','','','','','',''),(87,-87,'',87,0,6,'','','html1','벚꽃 사진 예쁘게 나왔어요 (87)','<p><img src=\"https://picsum.photos/id/187/400/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n지난 봄에 찍은 벚꽃 사진인데, 정리하다가 발견해서 올려요.\n\n여의도 윤중로에서 찍었는데, 벚꽃이 만개했을 때라 정말 예뻤어요. 분홍빛 꽃잎이 바람에 날리는 게 영화 같았습니다.\n\n내년 벚꽃 시즌에는 꼭 가보세요!\n\n추천 벚꽃 명소:\n- 여의도 윤중로\n- 석촌호수\n- 남산\n- 경주 보문단지','벚꽃-사진-예쁘게-나왔어요-87','','',0,0,203,60,0,'admin','','최고관리자','admin@domain.com','','2025-10-23 22:37:21',0,'2025-10-23 22:37:21','127.0.0.1','','','','','','','','','','','',''),(88,-88,'',88,0,0,'','','html1','맛있는 브런치 사진입니다 (88)','<p><img src=\"https://picsum.photos/id/188/800/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말 브런치 사진이에요.\n\n오랜만에 여유롭게 브런치 먹으러 갔는데, 음식도 맛있고 플레이팅도 예뻐서 사진 찍어봤어요.\n\n주문한 메뉴:\n- 에그베네딕트\n- 팬케이크\n- 아메리카노\n\n가격은 2인 기준 5만원 정도였어요. 분위기 좋고 음식 맛있어서 만족!\n\n브런치 맛집 추천받아요!','맛있는-브런치-사진입니다-88','','',0,0,1082,22,0,'admin','','최고관리자','admin@domain.com','','2025-10-23 07:37:21',0,'2025-10-23 07:37:21','127.0.0.1','','','','','','','','','','','',''),(89,-89,'',89,0,18,'','','html1','출근길 지하철역 풍경이에요 (89)','<p><img src=\"https://picsum.photos/id/189/800/500\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n출근길 지하철역에서 찍은 사진이에요.\n\n매일 지나가는 곳인데, 오늘따라 빛이 예쁘게 들어와서 사진 찍어봤어요. 일상 속에서 발견하는 아름다움이랄까요.\n\n출퇴근하면서 스쳐 지나가는 풍경도 가끔은 멈춰서 바라보면 새롭게 보이더라고요.\n\n여러분의 출퇴근길 풍경은 어떤가요?','출근길-지하철역-풍경이에요-89','','',0,0,292,21,0,'admin','','최고관리자','admin@domain.com','','2025-10-22 10:37:21',0,'2025-10-22 10:37:21','127.0.0.1','','','','','','','','','','','',''),(90,-90,'',90,0,19,'','','html1','비 오는 날 감성 사진 (90)','<p><img src=\"https://picsum.photos/id/190/800/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n비 오는 날 찍은 사진이에요.\n\n빗방울이 창문에 맺혀있는 거 찍어봤는데, 나름 감성 있게 나왔네요. 비 오는 날 특유의 촉촉한 분위기가 좋아요.\n\n비 오는 날 사진 팁:\n- 창문의 빗방울 클로즈업\n- 우산 쓴 사람들\n- 물웅덩이 반영\n- 비에 젖은 거리\n\n다음에 비 오면 우산 들고 나가서 더 많이 찍어봐야겠어요.','비-오는-날-감성-사진-90','','',0,0,458,23,0,'admin','','최고관리자','admin@domain.com','','2025-10-21 12:37:21',0,'2025-10-21 12:37:21','127.0.0.1','','','','','','','','','','','',''),(91,-91,'',91,0,12,'','','html1','노을 지는 바다 풍경입니다 (91)','<p><img src=\"https://picsum.photos/id/191/500/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말에 바다 보러 갔다가 찍은 노을 사진이에요.\n\n해가 지면서 하늘이 주황색, 빨간색으로 물들었는데... 진짜 장관이었어요. 이런 풍경 보면 힐링 되는 것 같아요.\n\n장소: 강릉 경포해변\n시간: 저녁 6시경\n\n바다 + 노을 조합은 진리입니다. 스트레스 받을 때 바다 보러 가세요!','노을-지는-바다-풍경입니다-91','','',0,0,921,83,0,'admin','','최고관리자','admin@domain.com','','2025-10-20 00:37:21',0,'2025-10-20 00:37:21','127.0.0.1','','','','','','','','','','','',''),(92,-92,'',92,0,16,'','','html1','가을 단풍 사진 공유해요 (92)','<p><img src=\"https://picsum.photos/id/192/400/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n단풍 구경 다녀왔어요!\n\n설악산 근처 드라이브하면서 찍은 사진인데, 온 산이 빨갛고 노랗고... 정말 예뻤어요.\n\n단풍 명소 추천:\n- 설악산\n- 내장산\n- 남이섬\n- 덕유산\n\n지금이 단풍 절정 시기니까 이번 주말에 꼭 가보세요! 다음 주면 다 질 수도 있어요.','가을-단풍-사진-공유해요-92','','',0,0,1006,67,0,'admin','','최고관리자','admin@domain.com','','2025-10-20 14:37:21',0,'2025-10-20 14:37:21','127.0.0.1','','','','','','','','','','','',''),(93,-93,'',93,0,6,'','','html1','귀여운 고양이 사진이에요 (93)','<p><img src=\"https://picsum.photos/id/193/500/400\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n동네에서 만난 고양이예요.\n\n매일 출근길에 보이는 고양이인데, 오늘은 가까이 와서 사진 찍었어요. 경계심이 없고 너무 귀여워요!\n\n이 동네 고양이 특징:\n- 사람 무서워 안 함\n- 쓰다듬으면 가만히 있음\n- 간식 주면 더 좋아함\n\n길고양이 사진 공유해요!','귀여운-고양이-사진이에요-93','','',0,0,940,18,0,'admin','','최고관리자','admin@domain.com','','2025-10-19 03:37:21',0,'2025-10-19 03:37:21','127.0.0.1','','','','','','','','','','','',''),(94,-94,'',94,0,13,'','','html1','캠핑장에서 찍은 사진 (94)','<p><img src=\"https://picsum.photos/id/194/500/500\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말 캠핑 다녀왔어요!\n\n날씨도 좋고 공기도 맑고... 도심에서 벗어나니까 힐링 되더라고요.\n\n캠핑 장비:\n- 텐트: 코베아 3인용\n- 체어: 헬리녹스\n- 테이블: 접이식\n- 랜턴: 충전식 LED\n\n캠핑 초보인데, 다음에는 바베큐도 해보려고요. 캠핑 팁 있으면 알려주세요!','캠핑장에서-찍은-사진-94','','',0,0,1279,70,0,'admin','','최고관리자','admin@domain.com','','2025-10-18 12:37:21',0,'2025-10-18 12:37:21','127.0.0.1','','','','','','','','','','','',''),(95,-95,'',95,0,0,'','','html1','눈 오는 날 풍경 사진 (95)','<p><img src=\"https://picsum.photos/id/195/400/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n첫눈 왔을 때 찍은 사진이에요.\n\n눈이 소복소복 쌓이는 거 보니까 기분이 좋더라고요. 겨울 감성 물씬!\n\n눈 사진 찍을 때 팁:\n- 노출 +0.5~1 정도 올리기 (눈이 회색으로 나올 수 있음)\n- 셔터스피드 빠르게 (눈송이 담기)\n- 역광으로 찍으면 반짝반짝\n\n눈 오면 또 사진 찍으러 나가야겠어요!','눈-오는-날-풍경-사진-95','','',0,0,821,55,0,'admin','','최고관리자','admin@domain.com','','2025-10-17 11:37:21',0,'2025-10-17 11:37:21','127.0.0.1','','','','','','','','','','','',''),(96,-96,'',96,0,20,'','','html1','도시 야경 사진 공유합니다 (96)','<p><img src=\"https://picsum.photos/id/196/600/600\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n서울 야경 사진이에요.\n\n남산타워에서 찍은 건데, 서울 전경이 한눈에 보여서 좋았어요. 야경 사진은 역시 높은 곳에서 찍어야 제맛!\n\n서울 야경 명소:\n- 남산타워\n- 북악스카이웨이\n- 인왕산\n- 응봉산\n\n다음에는 인왕산 가서 찍어볼 예정이에요.','도시-야경-사진-공유합니다-96','','',0,0,655,61,0,'admin','','최고관리자','admin@domain.com','','2025-10-16 05:37:21',0,'2025-10-16 05:37:21','127.0.0.1','','','','','','','','','','','',''),(97,-97,'',97,0,10,'','','html1','숲길 산책하며 찍은 사진 (97)','<p><img src=\"https://picsum.photos/id/197/600/300\" alt=\"이미지\" style=\"max-width:100%;\"></p>\n\n주말에 숲길 산책하면서 찍은 사진이에요.\n\n나무 사이로 햇빛이 들어오는 게 너무 예뻤어요. 피톤치드 마시면서 걸으니까 힐링 그 자체!\n\n서울 근교 숲길 추천:\n- 북한산 둘레길\n- 관악산 자락길\n- 서울숲\n- 올림픽공원\n\n등산은 힘들어도 숲길 산책은 누구나 할 수 있어요!','숲길-산책하며-찍은-사진-97','','',0,0,1130,5,0,'admin','','최고관리자','admin@domain.com','','2025-10-15 02:37:21',0,'2025-10-15 02:37:21','127.0.0.1','','','','','','','','','','','',''),(98,-98,'',98,0,11,'','','html1','일출 사진 새벽에 찍었어요 (98)','맛있는 음식 사진들 ?️\n\n<p><img src=\"https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=800\" alt=\"팬케이크\" style=\"max-width:100%;\"></p>\n\n브런치 카페에서 먹은 팬케이크!\n\n<p><img src=\"https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=800\" alt=\"샐러드\" style=\"max-width:100%;\"></p>\n\n건강한 샐러드도 먹었어요 ?\n\n<p><img src=\"https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=800\" alt=\"피자\" style=\"max-width:100%;\"></p>\n\n그리고 치팅데이 피자 ?\n\n맛집 투어 최고!','일출-사진-새벽에-찍었어요-98','','',0,0,359,46,0,'admin','','최고관리자','admin@domain.com','','2025-10-13 18:37:21',0,'2025-10-13 18:37:21','127.0.0.1','','','','','','','','','','','',''),(99,-99,'',99,0,6,'','','html1','하늘 구름 사진 예술이네요 (99)','서울 야경 사진 모음 ?\n\n<p><img src=\"https://images.unsplash.com/photo-1617469767053-d3b523a0b982?w=800\" alt=\"서울 야경\" style=\"max-width:100%;\"></p>\n\n한강에서 찍은 야경입니다!\n\n<p><img src=\"https://images.unsplash.com/photo-1546874177-9e664107314e?w=800\" alt=\"도시 야경\" style=\"max-width:100%;\"></p>\n\n밤에 보는 서울이 정말 예뻐요 ✨\n\n<p><img src=\"https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=800\" alt=\"빌딩 야경\" style=\"max-width:100%;\"></p>\n\n카메라: Sony A7IV\n렌즈: 24-70mm f/2.8','하늘-구름-사진-예술이네요-99','','',0,0,1163,20,0,'admin','','최고관리자','admin@domain.com','','2025-10-13 00:37:21',0,'2025-10-13 00:37:21','127.0.0.1','','','','','','','','','','','',''),(100,-100,'',100,0,9,'','','html1','주말 피크닉 사진이에요 (100)','오늘 찍은 풍경 사진입니다 ?\n\n<p><img src=\"https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800\" alt=\"산 풍경\" style=\"max-width:100%;\"></p>\n\n날씨가 너무 좋아서 등산 다녀왔어요!\n\n<p><img src=\"https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800\" alt=\"산맥\" style=\"max-width:100%;\"></p>\n\n정상에서 본 풍경이 정말 장관이었습니다.\n\n<p><img src=\"https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=800\" alt=\"안개 낀 산\" style=\"max-width:100%;\"></p>\n\n힐링되는 하루였어요~ ?️','주말-피크닉-사진이에요-100','','',0,0,242,13,0,'admin','','최고관리자','admin@domain.com','','2025-10-12 15:37:21',0,'2025-10-12 15:37:21','127.0.0.1','','','','','','','','','','','',''),(101,-101,'',101,0,0,'','','html1','11111111111','<p><br></p>','11111111111','','',0,0,1,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 04:39:51',0,'2026-01-10 04:39:51','::1','','','','','','','','','','','',''),(102,-102,'',102,0,0,'','','','fwewfw','wefwe','fwewfw','','',0,0,1,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 04:44:52',0,'2026-01-10 04:44:52','::1','','','','','','','','','','','',''),(103,-103,'',103,0,0,'','','','WFEWE','WFEWWE','wfewe','','',0,0,1,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 06:37:51',0,'2026-01-10 06:37:51','::1','','','','','','','','','','','',''),(104,-104,'',104,0,0,'','','html1','wfewf','<p>wfwefwe</p>','wfewf','','',0,0,1,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 06:41:15',0,'2026-01-10 06:41:15','::1','','','','','','','','','','','',''),(105,-105,'',105,0,0,'','','html1','fsdfdfsf','<p>sdfdsfsd</p>','fsdfdfsf','','',0,0,1,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 06:41:32',0,'2026-01-10 06:41:32','::1','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_game_ladder_bet`
--

DROP TABLE IF EXISTS `g5_write_game_ladder_bet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_game_ladder_bet` (
  `lb_id` int NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `mb_nick` varchar(40) NOT NULL DEFAULT '',
  `lb_round` int NOT NULL DEFAULT '0',
  `lb_bet_type` varchar(20) NOT NULL DEFAULT '',
  `lb_bet_value` varchar(20) NOT NULL DEFAULT '',
  `lb_amount` int NOT NULL DEFAULT '0',
  `lb_odds` decimal(5,2) NOT NULL DEFAULT '0.00',
  `lb_status` enum('pending','win','lose') NOT NULL DEFAULT 'pending',
  `lb_win_amount` int NOT NULL DEFAULT '0',
  `lb_datetime` datetime NOT NULL,
  PRIMARY KEY (`lb_id`),
  KEY `idx_mb_id` (`mb_id`),
  KEY `idx_lb_round` (`lb_round`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_game_ladder_bet`
--

LOCK TABLES `g5_write_game_ladder_bet` WRITE;
/*!40000 ALTER TABLE `g5_write_game_ladder_bet` DISABLE KEYS */;
INSERT INTO `g5_write_game_ladder_bet` VALUES (1,'admin','최고관리자',58933500,'start','1',500,1.95,'lose',0,'2026-01-10 09:30:20'),(2,'admin','최고관리자',58933500,'oe','1',500,1.95,'win',975,'2026-01-10 09:30:20'),(3,'admin','최고관리자',58933500,'line','4',500,1.95,'win',975,'2026-01-10 09:30:20'),(4,'admin','최고관리자',58933501,'oe','1',100,1.95,'lose',0,'2026-01-10 09:30:45'),(5,'admin','최고관리자',58933502,'line','3',100,1.95,'win',195,'2026-01-10 09:31:12'),(6,'admin','최고관리자',58933505,'start','1',100,1.95,'win',195,'2026-01-10 09:32:43'),(7,'admin','최고관리자',58933505,'oe','0',100,1.95,'win',195,'2026-01-10 09:32:43'),(8,'admin','최고관리자',58933505,'line','3',100,1.95,'lose',0,'2026-01-10 09:32:43'),(9,'admin','최고관리자',58933511,'line','4',1100,1.95,'win',2145,'2026-01-10 09:35:38'),(10,'admin','최고관리자',58933512,'oe','0',1100,1.95,'win',2145,'2026-01-10 09:36:11'),(11,'admin','최고관리자',58933512,'start','1',1600,1.95,'win',3120,'2026-01-10 09:36:16'),(12,'admin','최고관리자',58933514,'start','0',100,1.95,'win',195,'2026-01-10 09:37:05'),(13,'admin','최고관리자',58933565,'line','4',600,1.95,'lose',0,'2026-01-10 10:02:45'),(14,'admin','최고관리자',58933568,'line','3',100,1.95,'win',195,'2026-01-10 10:04:19'),(15,'admin','최고관리자',58933569,'start','1',5000,1.95,'lose',0,'2026-01-10 10:04:50'),(16,'admin','최고관리자',58933569,'oe','1',5000,1.95,'lose',0,'2026-01-10 10:04:50'),(17,'admin','최고관리자',58933579,'oe','1',100,1.95,'lose',0,'2026-01-10 10:09:42'),(18,'admin','최고관리자',58933579,'line','3',100,1.95,'win',195,'2026-01-10 10:09:42'),(19,'admin','최고관리자',58933583,'oe','1',100,1.95,'win',195,'2026-01-10 10:11:51'),(20,'admin','최고관리자',58933590,'oe','1',1100,1.95,'win',2145,'2026-01-10 10:15:16');
/*!40000 ALTER TABLE `g5_write_game_ladder_bet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_game_log`
--

DROP TABLE IF EXISTS `g5_write_game_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_game_log` (
  `gl_id` int NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `mb_nick` varchar(40) NOT NULL DEFAULT '',
  `gl_game` varchar(20) NOT NULL DEFAULT '',
  `gl_bet_type` varchar(20) NOT NULL DEFAULT '',
  `gl_bet_amount` int NOT NULL DEFAULT '0',
  `gl_result` varchar(20) NOT NULL DEFAULT '',
  `gl_win_amount` int NOT NULL DEFAULT '0',
  `gl_profit` int NOT NULL DEFAULT '0',
  `gl_detail` text,
  `gl_datetime` datetime NOT NULL,
  PRIMARY KEY (`gl_id`),
  KEY `idx_mb_id` (`mb_id`),
  KEY `idx_gl_game` (`gl_game`),
  KEY `idx_gl_datetime` (`gl_datetime`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_game_log`
--

LOCK TABLES `g5_write_game_log` WRITE;
/*!40000 ALTER TABLE `g5_write_game_log` DISABLE KEYS */;
INSERT INTO `g5_write_game_log` VALUES (1,'admin','최고관리자','slot','small',100,'win',150,50,'????,????,????','2026-01-10 06:33:58'),(2,'admin','최고관리자','slot','small',100,'win',150,50,'????,????,????','2026-01-10 06:34:13'),(3,'admin','최고관리자','slot','lose',100,'lose',0,-100,'????,????,????','2026-01-10 06:34:21'),(4,'admin','최고관리자','slot','small',100,'win',150,50,'7 | 레몬 | 레몬','2026-01-10 06:44:17'),(5,'admin','최고관리자','roulette','green',100,'win',1400,1300,'x14','2026-01-10 06:44:36'),(6,'admin','최고관리자','roulette','red',100,'win',200,100,'x2','2026-01-10 06:44:47'),(7,'admin','최고관리자','roulette','black',100,'win',200,100,'x2','2026-01-10 06:44:54'),(8,'admin','최고관리자','dice','low',100,'lose',0,-100,'주사위: 6+5=11','2026-01-10 06:45:22'),(9,'admin','최고관리자','baccarat','banker',100,'lose',0,-100,'Player:8 vs Banker:4, Winner:player','2026-01-10 06:45:40'),(10,'admin','최고관리자','baccarat','banker',100,'lose',0,-100,'Player:8 vs Banker:8, Winner:tie','2026-01-10 06:45:46'),(11,'admin','최고관리자','baccarat','banker',100,'lose',0,-100,'Player:7 vs Banker:5, Winner:player','2026-01-10 06:45:50'),(12,'admin','최고관리자','baccarat','banker',100,'win',195,95,'Player:7 vs Banker:9, Winner:banker','2026-01-10 06:45:54'),(13,'admin','최고관리자','baccarat','banker',100,'win',195,95,'Player:2 vs Banker:6, Winner:banker','2026-01-10 06:46:02'),(14,'admin','최고관리자','btc','unknown',1000,'lose',0,-1000,'BTC 예측 실패','2026-01-10 06:48:21'),(15,'admin','최고관리자','baccarat','banker',1000,'win',1950,950,'Player:4 vs Banker:7, Winner:banker','2026-01-10 06:50:47'),(16,'admin','최고관리자','baccarat','banker',5000,'win',9750,4750,'Player:5 vs Banker:9, Winner:banker','2026-01-10 06:51:45'),(17,'admin','최고관리자','baccarat','tie',5000,'lose',0,-5000,'Player:6 vs Banker:5, Winner:player','2026-01-10 06:51:57'),(18,'admin','최고관리자','baccarat','tie',500,'lose',0,-500,'Player:6 vs Banker:4, Winner:player','2026-01-10 06:55:05'),(19,'admin','최고관리자','baccarat','player',500,'lose',0,-500,'Player:4 vs Banker:4, Winner:tie','2026-01-10 06:57:47'),(20,'admin','최고관리자','baccarat','player',500,'lose',0,-500,'Player:0 vs Banker:0, Winner:tie','2026-01-10 07:02:35'),(21,'admin','최고관리자','dice','high',100,'lose',0,-100,'주사위: 2+5=7','2026-01-10 07:03:40'),(22,'admin','최고관리자','dice','high',100,'lose',0,-100,'주사위: 3+3=6','2026-01-10 07:07:16'),(23,'admin','최고관리자','dice','seven',100,'win',500,400,'주사위: 4+3=7','2026-01-10 07:07:25'),(24,'admin','최고관리자','dice','low',100,'lose',0,-100,'주사위: 5+5=10','2026-01-10 07:07:37'),(25,'admin','최고관리자','dice','high',100,'lose',0,-100,'주사위: 1+5=6','2026-01-10 07:07:42'),(26,'admin','최고관리자','baccarat','tie',100,'lose',0,-100,'Player:5 vs Banker:9, Winner:banker','2026-01-10 07:10:59'),(27,'admin','최고관리자','baccarat','tie',100,'win',800,700,'Player:5 vs Banker:5, Winner:tie','2026-01-10 07:11:26'),(28,'admin','최고관리자','baccarat','banker',100,'lose',0,-100,'Player:7 vs Banker:3, Winner:player','2026-01-10 07:11:37'),(29,'admin','최고관리자','baccarat','banker',10000,'lose',0,-10000,'Player:8 vs Banker:8, Winner:tie','2026-01-10 07:11:46'),(30,'admin','최고관리자','btc','DOWN',1000,'win',1950,950,'베팅:DOWN, 잠금:$90431.3, 마감:$90420.87, 결과:DOWN','2026-01-10 07:20:04'),(31,'admin','최고관리자','blackjack','dealer_bust',100,'win',200,100,'Player:16 vs Dealer:25','2026-01-10 07:21:53'),(32,'admin','최고관리자','blackjack','blackjack',100,'win',250,150,'Player:21 vs Dealer:9','2026-01-10 07:21:56'),(33,'admin','최고관리자','blackjack','bust',200,'lose',0,-200,'Player:23 vs Dealer:9','2026-01-10 07:22:04'),(34,'admin','최고관리자','blackjack','lose',200,'lose',0,-200,'Player:13 vs Dealer:20','2026-01-10 07:22:10'),(35,'admin','최고관리자','blackjack','bust',100,'lose',0,-100,'Player:27 vs Dealer:5','2026-01-10 07:22:27'),(36,'admin','최고관리자','blackjack','lose',100,'lose',0,-100,'Player:9 vs Dealer:18','2026-01-10 07:22:37'),(37,'admin','최고관리자','blackjack','bust',100,'lose',0,-100,'Player:23 vs Dealer:11','2026-01-10 07:22:41'),(38,'admin','최고관리자','roulette','green',100,'win',1400,1300,'x14','2026-01-10 07:33:52'),(39,'admin','최고관리자','roulette','black',100,'win',200,100,'x2','2026-01-10 07:33:59'),(40,'admin','최고관리자','roulette','black',100,'win',200,100,'x2','2026-01-10 07:34:06'),(41,'admin','최고관리자','blackjack','win',100,'win',200,100,'Player:20 vs Dealer:18','2026-01-10 07:47:42'),(42,'admin','최고관리자','blackjack','bust',200,'lose',0,-200,'Player:24 vs Dealer:13','2026-01-10 07:47:54'),(43,'admin','최고관리자','blackjack','lose',100,'lose',0,-100,'Player:13 vs Dealer:18','2026-01-10 07:47:57'),(44,'admin','최고관리자','blackjack','push',200,'win',0,0,'Player:18 vs Dealer:18','2026-01-10 07:48:00'),(45,'admin','최고관리자','blackjack','lose',100,'lose',0,-100,'Player:7 vs Dealer:18','2026-01-10 07:48:07'),(46,'admin','최고관리자','btc','DOWN',500,'win',975,475,'베팅:DOWN, 잠금:$90640.79, 마감:$90640.79, 결과:DOWN','2026-01-10 07:50:46'),(47,'admin','최고관리자','blackjack','blackjack',100,'win',250,150,'Player:21 vs Dealer:13','2026-01-10 07:51:57'),(48,'admin','최고관리자','blackjack','lose',200,'lose',0,-200,'Player:12 vs Dealer:19','2026-01-10 07:52:06'),(49,'admin','최고관리자','blackjack','lose',100,'lose',0,-100,'Player:7 vs Dealer:17','2026-01-10 07:52:14'),(50,'admin','최고관리자','blackjack','bust',100,'lose',0,-100,'Player:25 vs Dealer:17','2026-01-10 07:52:20'),(51,'admin','최고관리자','btc','DOWN',1000,'win',1950,950,'베팅:DOWN, 잠금:$90679.81, 마감:$90619.96, 결과:DOWN','2026-01-10 07:54:21'),(52,'admin','최고관리자','btc','DOWN',100,'lose',0,-100,'베팅:DOWN, 잠금:$90622.17, 마감:$90624.77, 결과:UP','2026-01-10 07:57:20'),(53,'admin','최고관리자','racing','horse_4',1000,'pending',0,0,'회차:29466700, 선택:#4, 배당:x7','2026-01-10 08:40:12'),(54,'admin','최고관리자','racing','horse_1',500,'pending',0,0,'회차:29466702, 선택:#1, 배당:x6.8','2026-01-10 08:42:23'),(55,'admin','최고관리자','racing','horse_2',500,'pending',0,0,'회차:29466705, 선택:황금마, 배당:x7.4','2026-01-10 08:45:37'),(56,'admin','최고관리자','racing','horse_3',1000,'pending',0,0,'회차:29466709, 선택:블루윈드, 배당:x3.7','2026-01-10 08:49:09'),(57,'admin','최고관리자','racing','horse_3',1000,'win',3700,2700,'회차:29466709, 선택:블루윈드, 배당:x3.70, 당첨:3700P','2026-01-10 08:50:18'),(58,'admin','최고관리자','racing','horse_1',1000,'pending',0,0,'회차:29466710, 선택:번개, 배당:x6.5','2026-01-10 08:50:33'),(59,'admin','최고관리자','racing','horse_1',1000,'lose',0,-1000,'회차:29466710, 선택:번개, 배당:x6.50, 낙첨','2026-01-10 08:51:41'),(60,'admin','최고관리자','racing','horse_4',500,'lose',0,-500,'회차:29466712, 선택:그린라이트, 배당:x8.7','2026-01-10 08:52:20'),(61,'admin','최고관리자','racing','horse_5',5000,'pending',0,0,'회차:29466714, 선택:퍼플스타, 배당:x9.3','2026-01-10 08:54:45'),(62,'admin','최고관리자','racing','horse_5',5000,'lose',0,-5000,'회차:29466714, 선택:퍼플스타, 배당:x9.30, 낙첨','2026-01-10 08:55:18'),(63,'admin','최고관리자','racing','horse_5',500,'pending',0,0,'회차:29466720, 선택:퍼플스타, 배당:x6.9','2026-01-10 09:00:29'),(64,'admin','최고관리자','racing','horse_5',500,'lose',0,-500,'회차:29466720, 선택:퍼플스타, 배당:x6.90, 낙첨','2026-01-10 09:01:34'),(65,'admin','최고관리자','ladder','start:1',500,'lose',0,-500,NULL,'2026-01-10 09:30:20'),(66,'admin','최고관리자','ladder','oe:1',500,'win',975,475,NULL,'2026-01-10 09:30:20'),(67,'admin','최고관리자','ladder','line:4',500,'win',975,475,NULL,'2026-01-10 09:30:20'),(68,'admin','최고관리자','ladder','oe:1',100,'lose',0,-100,NULL,'2026-01-10 09:30:45'),(69,'admin','최고관리자','ladder','line:3',100,'win',195,95,NULL,'2026-01-10 09:31:12'),(70,'admin','최고관리자','ladder','start:1',100,'win',195,95,NULL,'2026-01-10 09:32:43'),(71,'admin','최고관리자','ladder','oe:0',100,'win',195,95,NULL,'2026-01-10 09:32:43'),(72,'admin','최고관리자','ladder','line:3',100,'lose',0,-100,NULL,'2026-01-10 09:32:43'),(73,'admin','최고관리자','ladder','line:4',1100,'win',2145,1045,NULL,'2026-01-10 09:35:38'),(74,'admin','최고관리자','ladder','oe:0',1100,'win',2145,1045,NULL,'2026-01-10 09:36:11'),(75,'admin','최고관리자','ladder','start:1',1600,'win',3120,1520,NULL,'2026-01-10 09:36:16'),(76,'admin','최고관리자','ladder','start:0',100,'win',195,95,NULL,'2026-01-10 09:37:05'),(77,'admin','최고관리자','ladder','line:4',600,'lose',0,-600,NULL,'2026-01-10 10:02:45'),(78,'admin','최고관리자','ladder','line:3',100,'win',195,95,NULL,'2026-01-10 10:04:19'),(79,'admin','최고관리자','ladder','start:1',5000,'lose',0,-5000,NULL,'2026-01-10 10:04:50'),(80,'admin','최고관리자','ladder','oe:1',5000,'lose',0,-5000,NULL,'2026-01-10 10:04:50'),(81,'admin','최고관리자','ladder','oe:1',100,'lose',0,-100,NULL,'2026-01-10 10:09:42'),(82,'admin','최고관리자','ladder','line:3',100,'win',195,95,NULL,'2026-01-10 10:09:42'),(83,'admin','최고관리자','ladder','oe:1',100,'win',195,95,NULL,'2026-01-10 10:11:51'),(84,'admin','최고관리자','ladder','oe:1',1100,'win',2145,1045,NULL,'2026-01-10 10:15:16');
/*!40000 ALTER TABLE `g5_write_game_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_game_racing_bet`
--

DROP TABLE IF EXISTS `g5_write_game_racing_bet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_game_racing_bet` (
  `rb_id` int NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `mb_nick` varchar(40) NOT NULL DEFAULT '',
  `rb_round` int NOT NULL DEFAULT '0',
  `rb_horse_id` int NOT NULL DEFAULT '0',
  `rb_horse_name` varchar(50) NOT NULL DEFAULT '',
  `rb_amount` int NOT NULL DEFAULT '0',
  `rb_odds` decimal(5,2) NOT NULL DEFAULT '0.00',
  `rb_status` enum('pending','win','lose') NOT NULL DEFAULT 'pending',
  `rb_win_amount` int NOT NULL DEFAULT '0',
  `rb_datetime` datetime NOT NULL,
  PRIMARY KEY (`rb_id`),
  KEY `idx_mb_id` (`mb_id`),
  KEY `idx_rb_round` (`rb_round`),
  KEY `idx_rb_status` (`rb_status`),
  KEY `idx_rb_datetime` (`rb_datetime`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_game_racing_bet`
--

LOCK TABLES `g5_write_game_racing_bet` WRITE;
/*!40000 ALTER TABLE `g5_write_game_racing_bet` DISABLE KEYS */;
INSERT INTO `g5_write_game_racing_bet` VALUES (1,'admin','최고관리자',29466709,3,'블루윈드',1000,3.70,'win',3700,'2026-01-10 08:49:09'),(2,'admin','최고관리자',29466710,1,'번개',1000,6.50,'lose',0,'2026-01-10 08:50:33'),(3,'admin','최고관리자',29466712,4,'그린라이트',500,8.70,'lose',0,'2026-01-10 08:52:20'),(4,'admin','최고관리자',29466714,5,'퍼플스타',5000,9.30,'lose',0,'2026-01-10 08:54:45'),(5,'admin','최고관리자',29466720,5,'퍼플스타',500,6.90,'lose',0,'2026-01-10 09:00:29');
/*!40000 ALTER TABLE `g5_write_game_racing_bet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_humor`
--

DROP TABLE IF EXISTS `g5_write_humor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_humor` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_humor`
--

LOCK TABLES `g5_write_humor` WRITE;
/*!40000 ALTER TABLE `g5_write_humor` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_humor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_info`
--

DROP TABLE IF EXISTS `g5_write_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_info` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_info`
--

LOCK TABLES `g5_write_info` WRITE;
/*!40000 ALTER TABLE `g5_write_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_meme`
--

DROP TABLE IF EXISTS `g5_write_meme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_meme` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_meme`
--

LOCK TABLES `g5_write_meme` WRITE;
/*!40000 ALTER TABLE `g5_write_meme` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_meme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_notice`
--

DROP TABLE IF EXISTS `g5_write_notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_notice` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_notice`
--

LOCK TABLES `g5_write_notice` WRITE;
/*!40000 ALTER TABLE `g5_write_notice` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_notice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_pds`
--

DROP TABLE IF EXISTS `g5_write_pds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_pds` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_pds`
--

LOCK TABLES `g5_write_pds` WRITE;
/*!40000 ALTER TABLE `g5_write_pds` DISABLE KEYS */;
INSERT INTO `g5_write_pds` VALUES (1,-1,'',1,0,7,'','','','[무료] 프리미엄 웹사이트 템플릿 10종 (1)','프리미엄 웹사이트 템플릿을 무료로 공유합니다!\n\n이번에 공유하는 템플릿은 총 10종으로, 다양한 업종에 맞게 제작되었습니다.\n\n포함된 템플릿:\n1. 기업 홈페이지 - 깔끔하고 전문적인 느낌\n2. 포트폴리오 - 크리에이티브한 디자인\n3. 쇼핑몰 - 상품 진열에 최적화\n4. 블로그 - 가독성 좋은 레이아웃\n5. 랜딩페이지 - 전환율 높은 구조\n\n특징:\n- 100% 반응형\n- SEO 최적화\n- 빠른 로딩 속도\n\n사용 기술: HTML5, CSS3, JavaScript, Bootstrap 5','','','',0,0,301,107,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:39',0,'2026-01-10 00:37:39','127.0.0.1','','','','','','','','','','','',''),(2,-2,'',2,0,3,'','','','[공유] 포토샵 액션 모음 30종 (2)','포토샵 액션 모음 공유합니다!\n\n작업 시간을 단축시켜주는 유용한 액션들을 모아봤어요.\n\n포함된 액션 (총 30종):\n- 빈티지 효과 5종\n- 필름 느낌 5종\n- HDR 효과 3종\n- 피부 보정 3종\n- 색상 보정 5종\n- 흑백 변환 3종\n- 글리치 효과 3종\n- 더블 노출 3종\n\n포토샵 CS6 이상에서 사용 가능합니다.','','','',0,0,1393,63,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:39',0,'2026-01-10 00:37:39','127.0.0.1','','','','','','','','','','','',''),(3,-3,'',3,0,3,'','','','[배포] 무료 아이콘 세트 500종 (3)','무료 아이콘 세트 500종 배포합니다!\n\n웹/앱 개발에 유용한 아이콘들을 정리해서 공유해요.\n\n카테고리별 구성:\n- UI 기본 아이콘 (100종)\n- 소셜 미디어 (50종)\n- 전자상거래 (80종)\n- 파일/문서 (40종)\n- 커뮤니케이션 (50종)\n\n제공 포맷:\n- SVG\n- PNG (24px, 48px, 96px)\n- AI\n- Figma 파일','','','',0,0,1316,134,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:39',0,'2026-01-10 00:37:39','127.0.0.1','','','','','','','','','','','',''),(4,-4,'',4,0,7,'','','','반응형 CSS 프레임워크 공유 (4)','반응형 CSS 프레임워크 공유합니다.\n\nBootstrap이나 Tailwind 대신 사용할 수 있는 가벼운 CSS 프레임워크예요.\n\n특징:\n- 용량이 작음 (minified 15KB)\n- 클래스명이 직관적\n- 커스터마이징 쉬움\n- 다크모드 지원\n\n포함된 기능:\n1. 그리드 시스템 (12컬럼)\n2. 타이포그래피\n3. 버튼 스타일\n4. 폼 요소\n5. 카드 컴포넌트','','','',0,0,378,61,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:39',0,'2026-01-10 00:37:39','127.0.0.1','','','','','','','','','','','',''),(5,-5,'',5,0,4,'','','','[무료폰트] 한글 손글씨체 5종 (5)','한글 손글씨체 5종 무료 배포합니다!\n\n직접 제작한 손글씨 폰트예요. 개인/상업적 사용 모두 무료입니다.\n\n폰트 목록:\n1. 따뜻한손글씨 - 부드럽고 따뜻한 느낌\n2. 귀여운손글씨 - 동글동글 귀여운 스타일\n3. 깔끔한손글씨 - 정돈된 느낌\n4. 빠른손글씨 - 역동적인 느낌\n5. 어른손글씨 - 성숙하고 차분한 느낌\n\n파일 포맷: TTF, OTF, WOFF, WOFF2','','','',0,0,242,64,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:39',0,'2026-01-10 00:37:39','127.0.0.1','','','','','','','','','','','',''),(6,-6,'',6,0,8,'','','','JavaScript 유틸리티 라이브러리 (6)','JavaScript 유틸리티 라이브러리 공유합니다.\n\n자주 사용하는 기능들을 모아서 라이브러리로 만들었어요.\n\n포함된 기능:\n- 날짜/시간 처리\n- 문자열 처리\n- 배열 유틸리티\n- DOM 조작\n- Ajax 래퍼\n- 로컬스토리지 헬퍼\n- 유효성 검사\n- 숫자 포맷\n\n용량: 10KB (minified)\n호환성: ES6+, IE11 폴리필 포함','','','',0,0,746,90,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:39',0,'2026-01-10 00:37:39','127.0.0.1','','','','','','','','','','','',''),(7,-7,'',7,0,0,'','','','[템플릿] 이력서 양식 모음 20종 (7)','이력서 양식 모음 20종 공유합니다!\n\n취업 준비하시는 분들께 도움이 되었으면 해요.\n\n포함된 양식:\n- 신입용 이력서 5종\n- 경력직 이력서 5종\n- 포트폴리오형 이력서 5종\n- 영문 이력서 5종\n\n파일 형식:\n- Word (.docx)\n- PDF\n- Figma\n\n업종별로 커스터마이징 가능합니다.','','','',0,0,373,58,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:39',0,'2026-01-10 00:37:39','127.0.0.1','','','','','','','','','','','',''),(8,-8,'',8,0,6,'','','','무료 스톡 이미지 사이트 정리 (8)','무료로 사용할 수 있는 스톡 이미지 사이트 정리했습니다.\n\n상업적 사용 가능한 사이트만 모았어요!\n\n추천 사이트:\n1. Unsplash - 고퀄리티 사진\n2. Pexels - 다양한 카테고리\n3. Pixabay - 일러스트도 있음\n4. Freepik - 벡터 이미지\n5. Flaticon - 아이콘 전문\n\n각 사이트별 라이선스 주의사항도 정리했어요.','','','',0,0,1907,122,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:39',0,'2026-01-10 00:37:39','127.0.0.1','','','','','','','','','','','',''),(9,-9,'',9,0,5,'','','','[공유] PPT 템플릿 50종 (9)','PPT 템플릿 50종 공유합니다!\n\n발표 준비하시는 분들 참고하세요.\n\n카테고리:\n- 비즈니스 (15종)\n- 교육 (10종)\n- 마케팅 (10종)\n- 포트폴리오 (10종)\n- 미니멀 (5종)\n\n특징:\n- 16:9 와이드 비율\n- 마스터 슬라이드 포함\n- 색상 변경 쉬움\n- 차트, 그래프 포함','','','',0,0,1976,101,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:39',0,'2026-01-10 00:37:39','127.0.0.1','','','','','','','','','','','',''),(10,-10,'',10,0,9,'','','','개발자를 위한 치트시트 모음 (10)','개발자를 위한 치트시트 모음입니다.\n\n자주 찾아보는 문법이나 명령어를 한눈에!\n\n포함된 치트시트:\n- HTML/CSS\n- JavaScript\n- Python\n- Git\n- Linux 명령어\n- SQL\n- React\n- Docker\n\nPDF와 이미지 파일로 제공됩니다.\n프린트해서 책상에 붙여두기 좋아요!','','','',0,0,1706,19,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 00:37:39',0,'2026-01-10 00:37:39','127.0.0.1','','','','','','','','','','','',''),(11,-11,'',11,0,9,'','','','[배포] 로고 디자인 템플릿 30종 (11)','로고 디자인 템플릿 30종 배포합니다!\n\n스타트업이나 개인 프로젝트에 활용하세요.\n\n스타일별 구성:\n- 미니멀 (10종)\n- 모던 (10종)\n- 빈티지 (5종)\n- 캐릭터 (5종)\n\n제공 파일:\n- AI (원본)\n- EPS\n- SVG\n- PNG (투명배경)\n\n색상, 텍스트 수정 자유롭게 가능합니다.','','','',0,0,524,126,0,'admin','','최고관리자','admin@domain.com','','2025-12-31 07:37:21',0,'2025-12-31 07:37:21','127.0.0.1','','','','','','','','','','','',''),(12,-12,'',12,0,3,'','','','무료 영상 소스 모음 100종 (12)','무료 영상 소스 100종 모음입니다.\n\n영상 편집할 때 유용하게 쓰세요!\n\n포함된 소스:\n- 배경 영상 (30종)\n- 트랜지션 효과 (20종)\n- 오버레이 (20종)\n- 타이틀 애니메이션 (15종)\n- 로어써드 (15종)\n\n해상도: Full HD (1920x1080)\n포맷: MP4, MOV','','','',0,0,622,27,0,'admin','','최고관리자','admin@domain.com','','2025-12-31 06:37:21',0,'2025-12-31 06:37:21','127.0.0.1','','','','','','','','','','','',''),(13,-13,'',13,0,6,'','','','[공유] 일러스트 브러쉬 세트 (13)','일러스트레이터/포토샵용 브러쉬 세트 공유합니다.\n\n다양한 스타일의 브러쉬 200개!\n\n브러쉬 종류:\n- 수채화 효과\n- 연필/펜 느낌\n- 텍스처 브러쉬\n- 패턴 브러쉬\n- 자연물 (나뭇잎, 구름 등)\n\n설치 방법과 사용 예제도 포함되어 있어요.','','','',0,0,602,139,0,'admin','','최고관리자','admin@domain.com','','2025-12-30 08:37:21',0,'2025-12-30 08:37:21','127.0.0.1','','','','','','','','','','','',''),(14,-14,'',14,0,1,'','','','HTML 이메일 템플릿 모음 (14)','HTML 이메일 템플릿 25종 공유합니다.\n\n뉴스레터나 마케팅 이메일에 활용하세요.\n\n템플릿 종류:\n- 뉴스레터 (10종)\n- 프로모션 (5종)\n- 환영 이메일 (3종)\n- 알림 이메일 (4종)\n- 트랜잭션 이메일 (3종)\n\n특징:\n- 반응형\n- 주요 이메일 클라이언트 호환\n- Litmus 테스트 완료','','','',0,0,431,33,0,'admin','','최고관리자','admin@domain.com','','2025-12-28 17:37:21',0,'2025-12-28 17:37:21','127.0.0.1','','','','','','','','','','','',''),(15,-15,'',15,0,7,'','','','[무료] 모바일 UI 키트 (15)','모바일 UI 키트 무료 배포합니다!\n\n앱 디자인할 때 참고하세요.\n\n포함된 화면:\n- 로그인/회원가입\n- 홈 화면\n- 프로필\n- 설정\n- 리스트/그리드\n- 상세 페이지\n- 채팅\n- 결제\n\n파일 형식: Figma, Sketch, XD\n총 100개 이상의 컴포넌트 포함','','','',0,0,549,35,0,'admin','','최고관리자','admin@domain.com','','2025-12-28 05:37:21',0,'2025-12-28 05:37:21','127.0.0.1','','','','','','','','','','','',''),(16,-16,'',16,0,6,'','','','CSS 애니메이션 코드 모음 (16)','CSS 애니메이션 코드 모음입니다.\n\n복사해서 바로 사용할 수 있어요!\n\n포함된 애니메이션:\n- 페이드 인/아웃\n- 슬라이드\n- 바운스\n- 회전\n- 스케일\n- 물결 효과\n- 타이핑 효과\n- 로딩 스피너\n\n총 50개 이상의 애니메이션\n순수 CSS만 사용 (JS 없음)','','','',0,0,1642,58,0,'admin','','최고관리자','admin@domain.com','','2025-12-27 04:37:21',0,'2025-12-27 04:37:21','127.0.0.1','','','','','','','','','','','',''),(17,-17,'',17,0,7,'','','','[공유] 무료 음악/효과음 모음 (17)','무료로 사용 가능한 음악과 효과음 모음입니다.\n\n영상 편집이나 게임 개발에 활용하세요.\n\n포함된 소스:\n- BGM (50곡)\n  - 신나는 분위기\n  - 잔잔한 분위기\n  - 긴장감 있는\n  - 귀여운 느낌\n- 효과음 (200종)\n  - UI 효과음\n  - 자연 소리\n  - 생활 소음\n\n포맷: MP3, WAV','','','',0,0,1041,147,0,'admin','','최고관리자','admin@domain.com','','2025-12-26 07:37:21',0,'2025-12-26 07:37:21','127.0.0.1','','','','','','','','','','','',''),(18,-18,'',18,0,2,'','','','워드프레스 테마 추천 및 리뷰 (18)','워드프레스 테마 추천합니다.\n\n직접 사용해보고 좋았던 테마들이에요.\n\n추천 테마:\n1. Flavflavor - 다목적 테마, 속도 빠름\n2. flavor flavor - 깔끔한 블로그용\n3. flavor flavor - 쇼핑몰 특화\n4. flavor flavor - 포트폴리오용\n\n각 테마별 장단점과 설치 가이드도 포함했습니다.','','','',0,0,1736,23,0,'admin','','최고관리자','admin@domain.com','','2025-12-25 14:37:21',0,'2025-12-25 14:37:21','127.0.0.1','','','','','','','','','','','',''),(19,-19,'',19,0,1,'','','','[배포] 명함 디자인 템플릿 40종 (19)','명함 디자인 템플릿 40종 배포합니다!\n\n업종별로 다양하게 준비했어요.\n\n카테고리:\n- 일반 비즈니스 (15종)\n- 크리에이티브 (10종)\n- 미니멀 (10종)\n- 세로형 (5종)\n\n파일 형식:\n- AI\n- PSD\n- PDF (인쇄용)\n\n실제 인쇄 사이즈 (90x50mm) 기준입니다.','','','',0,0,394,124,0,'admin','','최고관리자','admin@domain.com','','2025-12-24 12:37:21',0,'2025-12-24 12:37:21','127.0.0.1','','','','','','','','','','','',''),(20,-20,'',20,0,0,'','','','개발 관련 전자책 모음 (합법) (20)','개발 관련 무료 전자책 모음입니다.\n\n모두 합법적으로 무료 배포되는 책들이에요!\n\n포함된 책:\n- 프로 Git (한글판)\n- 클린 코드 요약본\n- 자바스크립트 완벽 가이드\n- 파이썬 공식 튜토리얼\n- 리눅스 커맨드라인\n\n각 책의 원본 링크와 라이선스 정보도 포함했습니다.','','','',0,0,1109,26,0,'admin','','최고관리자','admin@domain.com','','2025-12-23 12:37:21',0,'2025-12-23 12:37:21','127.0.0.1','','','','','','','','','','','',''),(21,-21,'',21,0,7,'','','','[무료] 프리미엄 웹사이트 템플릿 10종 (21)','프리미엄 웹사이트 템플릿을 무료로 공유합니다!\n\n이번에 공유하는 템플릿은 총 10종으로, 다양한 업종에 맞게 제작되었습니다.\n\n포함된 템플릿:\n1. 기업 홈페이지 - 깔끔하고 전문적인 느낌\n2. 포트폴리오 - 크리에이티브한 디자인\n3. 쇼핑몰 - 상품 진열에 최적화\n4. 블로그 - 가독성 좋은 레이아웃\n5. 랜딩페이지 - 전환율 높은 구조\n\n특징:\n- 100% 반응형\n- SEO 최적화\n- 빠른 로딩 속도\n\n사용 기술: HTML5, CSS3, JavaScript, Bootstrap 5','','','',0,0,1670,31,0,'admin','','최고관리자','admin@domain.com','','2025-12-22 00:37:21',0,'2025-12-22 00:37:21','127.0.0.1','','','','','','','','','','','',''),(22,-22,'',22,0,8,'','','','[공유] 포토샵 액션 모음 30종 (22)','포토샵 액션 모음 공유합니다!\n\n작업 시간을 단축시켜주는 유용한 액션들을 모아봤어요.\n\n포함된 액션 (총 30종):\n- 빈티지 효과 5종\n- 필름 느낌 5종\n- HDR 효과 3종\n- 피부 보정 3종\n- 색상 보정 5종\n- 흑백 변환 3종\n- 글리치 효과 3종\n- 더블 노출 3종\n\n포토샵 CS6 이상에서 사용 가능합니다.','','','',0,0,1837,137,0,'admin','','최고관리자','admin@domain.com','','2025-12-22 00:37:21',0,'2025-12-22 00:37:21','127.0.0.1','','','','','','','','','','','',''),(23,-23,'',23,0,8,'','','','[배포] 무료 아이콘 세트 500종 (23)','무료 아이콘 세트 500종 배포합니다!\n\n웹/앱 개발에 유용한 아이콘들을 정리해서 공유해요.\n\n카테고리별 구성:\n- UI 기본 아이콘 (100종)\n- 소셜 미디어 (50종)\n- 전자상거래 (80종)\n- 파일/문서 (40종)\n- 커뮤니케이션 (50종)\n\n제공 포맷:\n- SVG\n- PNG (24px, 48px, 96px)\n- AI\n- Figma 파일','','','',0,0,1619,23,0,'admin','','최고관리자','admin@domain.com','','2025-12-20 20:37:21',0,'2025-12-20 20:37:21','127.0.0.1','','','','','','','','','','','',''),(24,-24,'',24,0,8,'','','','반응형 CSS 프레임워크 공유 (24)','반응형 CSS 프레임워크 공유합니다.\n\nBootstrap이나 Tailwind 대신 사용할 수 있는 가벼운 CSS 프레임워크예요.\n\n특징:\n- 용량이 작음 (minified 15KB)\n- 클래스명이 직관적\n- 커스터마이징 쉬움\n- 다크모드 지원\n\n포함된 기능:\n1. 그리드 시스템 (12컬럼)\n2. 타이포그래피\n3. 버튼 스타일\n4. 폼 요소\n5. 카드 컴포넌트','','','',0,0,650,101,0,'admin','','최고관리자','admin@domain.com','','2025-12-19 23:37:21',0,'2025-12-19 23:37:21','127.0.0.1','','','','','','','','','','','',''),(25,-25,'',25,0,7,'','','','[무료폰트] 한글 손글씨체 5종 (25)','한글 손글씨체 5종 무료 배포합니다!\n\n직접 제작한 손글씨 폰트예요. 개인/상업적 사용 모두 무료입니다.\n\n폰트 목록:\n1. 따뜻한손글씨 - 부드럽고 따뜻한 느낌\n2. 귀여운손글씨 - 동글동글 귀여운 스타일\n3. 깔끔한손글씨 - 정돈된 느낌\n4. 빠른손글씨 - 역동적인 느낌\n5. 어른손글씨 - 성숙하고 차분한 느낌\n\n파일 포맷: TTF, OTF, WOFF, WOFF2','','','',0,0,567,133,0,'admin','','최고관리자','admin@domain.com','','2025-12-19 02:37:21',0,'2025-12-19 02:37:21','127.0.0.1','','','','','','','','','','','',''),(26,-26,'',26,0,1,'','','','JavaScript 유틸리티 라이브러리 (26)','JavaScript 유틸리티 라이브러리 공유합니다.\n\n자주 사용하는 기능들을 모아서 라이브러리로 만들었어요.\n\n포함된 기능:\n- 날짜/시간 처리\n- 문자열 처리\n- 배열 유틸리티\n- DOM 조작\n- Ajax 래퍼\n- 로컬스토리지 헬퍼\n- 유효성 검사\n- 숫자 포맷\n\n용량: 10KB (minified)\n호환성: ES6+, IE11 폴리필 포함','','','',0,0,1985,50,0,'admin','','최고관리자','admin@domain.com','','2025-12-18 11:37:21',0,'2025-12-18 11:37:21','127.0.0.1','','','','','','','','','','','',''),(27,-27,'',27,0,1,'','','','[템플릿] 이력서 양식 모음 20종 (27)','이력서 양식 모음 20종 공유합니다!\n\n취업 준비하시는 분들께 도움이 되었으면 해요.\n\n포함된 양식:\n- 신입용 이력서 5종\n- 경력직 이력서 5종\n- 포트폴리오형 이력서 5종\n- 영문 이력서 5종\n\n파일 형식:\n- Word (.docx)\n- PDF\n- Figma\n\n업종별로 커스터마이징 가능합니다.','','','',0,0,1501,102,0,'admin','','최고관리자','admin@domain.com','','2025-12-16 16:37:21',0,'2025-12-16 16:37:21','127.0.0.1','','','','','','','','','','','',''),(28,-28,'',28,0,6,'','','','무료 스톡 이미지 사이트 정리 (28)','무료로 사용할 수 있는 스톡 이미지 사이트 정리했습니다.\n\n상업적 사용 가능한 사이트만 모았어요!\n\n추천 사이트:\n1. Unsplash - 고퀄리티 사진\n2. Pexels - 다양한 카테고리\n3. Pixabay - 일러스트도 있음\n4. Freepik - 벡터 이미지\n5. Flaticon - 아이콘 전문\n\n각 사이트별 라이선스 주의사항도 정리했어요.','','','',0,0,1072,106,0,'admin','','최고관리자','admin@domain.com','','2025-12-15 22:37:22',0,'2025-12-15 22:37:22','127.0.0.1','','','','','','','','','','','',''),(29,-29,'',29,0,1,'','','','[공유] PPT 템플릿 50종 (29)','PPT 템플릿 50종 공유합니다!\n\n발표 준비하시는 분들 참고하세요.\n\n카테고리:\n- 비즈니스 (15종)\n- 교육 (10종)\n- 마케팅 (10종)\n- 포트폴리오 (10종)\n- 미니멀 (5종)\n\n특징:\n- 16:9 와이드 비율\n- 마스터 슬라이드 포함\n- 색상 변경 쉬움\n- 차트, 그래프 포함','','','',0,0,1266,74,0,'admin','','최고관리자','admin@domain.com','','2025-12-14 23:37:22',0,'2025-12-14 23:37:22','127.0.0.1','','','','','','','','','','','',''),(30,-30,'',30,0,3,'','','','개발자를 위한 치트시트 모음 (30)','개발자를 위한 치트시트 모음입니다.\n\n자주 찾아보는 문법이나 명령어를 한눈에!\n\n포함된 치트시트:\n- HTML/CSS\n- JavaScript\n- Python\n- Git\n- Linux 명령어\n- SQL\n- React\n- Docker\n\nPDF와 이미지 파일로 제공됩니다.\n프린트해서 책상에 붙여두기 좋아요!','','','',0,0,828,78,0,'admin','','최고관리자','admin@domain.com','','2025-12-14 13:37:22',0,'2025-12-14 13:37:22','127.0.0.1','','','','','','','','','','','',''),(31,-31,'',31,0,9,'','','','[배포] 로고 디자인 템플릿 30종 (31)','로고 디자인 템플릿 30종 배포합니다!\n\n스타트업이나 개인 프로젝트에 활용하세요.\n\n스타일별 구성:\n- 미니멀 (10종)\n- 모던 (10종)\n- 빈티지 (5종)\n- 캐릭터 (5종)\n\n제공 파일:\n- AI (원본)\n- EPS\n- SVG\n- PNG (투명배경)\n\n색상, 텍스트 수정 자유롭게 가능합니다.','','','',0,0,1004,31,0,'admin','','최고관리자','admin@domain.com','','2025-12-13 09:37:22',0,'2025-12-13 09:37:22','127.0.0.1','','','','','','','','','','','',''),(32,-32,'',32,0,3,'','','','무료 영상 소스 모음 100종 (32)','무료 영상 소스 100종 모음입니다.\n\n영상 편집할 때 유용하게 쓰세요!\n\n포함된 소스:\n- 배경 영상 (30종)\n- 트랜지션 효과 (20종)\n- 오버레이 (20종)\n- 타이틀 애니메이션 (15종)\n- 로어써드 (15종)\n\n해상도: Full HD (1920x1080)\n포맷: MP4, MOV','','','',0,0,1431,81,0,'admin','','최고관리자','admin@domain.com','','2025-12-13 10:37:22',0,'2025-12-13 10:37:22','127.0.0.1','','','','','','','','','','','',''),(33,-33,'',33,0,7,'','','','[공유] 일러스트 브러쉬 세트 (33)','일러스트레이터/포토샵용 브러쉬 세트 공유합니다.\n\n다양한 스타일의 브러쉬 200개!\n\n브러쉬 종류:\n- 수채화 효과\n- 연필/펜 느낌\n- 텍스처 브러쉬\n- 패턴 브러쉬\n- 자연물 (나뭇잎, 구름 등)\n\n설치 방법과 사용 예제도 포함되어 있어요.','','','',0,0,1041,50,0,'admin','','최고관리자','admin@domain.com','','2025-12-11 23:37:22',0,'2025-12-11 23:37:22','127.0.0.1','','','','','','','','','','','',''),(34,-34,'',34,0,5,'','','','HTML 이메일 템플릿 모음 (34)','HTML 이메일 템플릿 25종 공유합니다.\n\n뉴스레터나 마케팅 이메일에 활용하세요.\n\n템플릿 종류:\n- 뉴스레터 (10종)\n- 프로모션 (5종)\n- 환영 이메일 (3종)\n- 알림 이메일 (4종)\n- 트랜잭션 이메일 (3종)\n\n특징:\n- 반응형\n- 주요 이메일 클라이언트 호환\n- Litmus 테스트 완료','','','',0,0,375,71,0,'admin','','최고관리자','admin@domain.com','','2025-12-11 07:37:22',0,'2025-12-11 07:37:22','127.0.0.1','','','','','','','','','','','',''),(35,-35,'',35,0,5,'','','','[무료] 모바일 UI 키트 (35)','모바일 UI 키트 무료 배포합니다!\n\n앱 디자인할 때 참고하세요.\n\n포함된 화면:\n- 로그인/회원가입\n- 홈 화면\n- 프로필\n- 설정\n- 리스트/그리드\n- 상세 페이지\n- 채팅\n- 결제\n\n파일 형식: Figma, Sketch, XD\n총 100개 이상의 컴포넌트 포함','','','',0,0,1888,37,0,'admin','','최고관리자','admin@domain.com','','2025-12-09 22:37:22',0,'2025-12-09 22:37:22','127.0.0.1','','','','','','','','','','','',''),(36,-36,'',36,0,1,'','','','CSS 애니메이션 코드 모음 (36)','CSS 애니메이션 코드 모음입니다.\n\n복사해서 바로 사용할 수 있어요!\n\n포함된 애니메이션:\n- 페이드 인/아웃\n- 슬라이드\n- 바운스\n- 회전\n- 스케일\n- 물결 효과\n- 타이핑 효과\n- 로딩 스피너\n\n총 50개 이상의 애니메이션\n순수 CSS만 사용 (JS 없음)','','','',0,0,587,83,0,'admin','','최고관리자','admin@domain.com','','2025-12-09 02:37:22',0,'2025-12-09 02:37:22','127.0.0.1','','','','','','','','','','','',''),(37,-37,'',37,0,8,'','','','[공유] 무료 음악/효과음 모음 (37)','무료로 사용 가능한 음악과 효과음 모음입니다.\n\n영상 편집이나 게임 개발에 활용하세요.\n\n포함된 소스:\n- BGM (50곡)\n  - 신나는 분위기\n  - 잔잔한 분위기\n  - 긴장감 있는\n  - 귀여운 느낌\n- 효과음 (200종)\n  - UI 효과음\n  - 자연 소리\n  - 생활 소음\n\n포맷: MP3, WAV','','','',0,0,884,136,0,'admin','','최고관리자','admin@domain.com','','2025-12-08 06:37:22',0,'2025-12-08 06:37:22','127.0.0.1','','','','','','','','','','','',''),(38,-38,'',38,0,0,'','','','워드프레스 테마 추천 및 리뷰 (38)','워드프레스 테마 추천합니다.\n\n직접 사용해보고 좋았던 테마들이에요.\n\n추천 테마:\n1. Flavflavor - 다목적 테마, 속도 빠름\n2. flavor flavor - 깔끔한 블로그용\n3. flavor flavor - 쇼핑몰 특화\n4. flavor flavor - 포트폴리오용\n\n각 테마별 장단점과 설치 가이드도 포함했습니다.','','','',0,0,1912,42,0,'admin','','최고관리자','admin@domain.com','','2025-12-07 01:37:22',0,'2025-12-07 01:37:22','127.0.0.1','','','','','','','','','','','',''),(39,-39,'',39,0,6,'','','','[배포] 명함 디자인 템플릿 40종 (39)','명함 디자인 템플릿 40종 배포합니다!\n\n업종별로 다양하게 준비했어요.\n\n카테고리:\n- 일반 비즈니스 (15종)\n- 크리에이티브 (10종)\n- 미니멀 (10종)\n- 세로형 (5종)\n\n파일 형식:\n- AI\n- PSD\n- PDF (인쇄용)\n\n실제 인쇄 사이즈 (90x50mm) 기준입니다.','','','',0,0,543,42,0,'admin','','최고관리자','admin@domain.com','','2025-12-06 00:37:22',0,'2025-12-06 00:37:22','127.0.0.1','','','','','','','','','','','',''),(40,-40,'',40,0,6,'','','','개발 관련 전자책 모음 (합법) (40)','개발 관련 무료 전자책 모음입니다.\n\n모두 합법적으로 무료 배포되는 책들이에요!\n\n포함된 책:\n- 프로 Git (한글판)\n- 클린 코드 요약본\n- 자바스크립트 완벽 가이드\n- 파이썬 공식 튜토리얼\n- 리눅스 커맨드라인\n\n각 책의 원본 링크와 라이선스 정보도 포함했습니다.','','','',0,0,1156,112,0,'admin','','최고관리자','admin@domain.com','','2025-12-04 18:37:22',0,'2025-12-04 18:37:22','127.0.0.1','','','','','','','','','','','',''),(41,-41,'',41,0,3,'','','','[무료] 프리미엄 웹사이트 템플릿 10종 (41)','프리미엄 웹사이트 템플릿을 무료로 공유합니다!\n\n이번에 공유하는 템플릿은 총 10종으로, 다양한 업종에 맞게 제작되었습니다.\n\n포함된 템플릿:\n1. 기업 홈페이지 - 깔끔하고 전문적인 느낌\n2. 포트폴리오 - 크리에이티브한 디자인\n3. 쇼핑몰 - 상품 진열에 최적화\n4. 블로그 - 가독성 좋은 레이아웃\n5. 랜딩페이지 - 전환율 높은 구조\n\n특징:\n- 100% 반응형\n- SEO 최적화\n- 빠른 로딩 속도\n\n사용 기술: HTML5, CSS3, JavaScript, Bootstrap 5','','','',0,0,1021,127,0,'admin','','최고관리자','admin@domain.com','','2025-12-04 05:37:22',0,'2025-12-04 05:37:22','127.0.0.1','','','','','','','','','','','',''),(42,-42,'',42,0,4,'','','','[공유] 포토샵 액션 모음 30종 (42)','포토샵 액션 모음 공유합니다!\n\n작업 시간을 단축시켜주는 유용한 액션들을 모아봤어요.\n\n포함된 액션 (총 30종):\n- 빈티지 효과 5종\n- 필름 느낌 5종\n- HDR 효과 3종\n- 피부 보정 3종\n- 색상 보정 5종\n- 흑백 변환 3종\n- 글리치 효과 3종\n- 더블 노출 3종\n\n포토샵 CS6 이상에서 사용 가능합니다.','','','',0,0,390,103,0,'admin','','최고관리자','admin@domain.com','','2025-12-04 10:37:22',0,'2025-12-04 10:37:22','127.0.0.1','','','','','','','','','','','',''),(43,-43,'',43,0,8,'','','','[배포] 무료 아이콘 세트 500종 (43)','무료 아이콘 세트 500종 배포합니다!\n\n웹/앱 개발에 유용한 아이콘들을 정리해서 공유해요.\n\n카테고리별 구성:\n- UI 기본 아이콘 (100종)\n- 소셜 미디어 (50종)\n- 전자상거래 (80종)\n- 파일/문서 (40종)\n- 커뮤니케이션 (50종)\n\n제공 포맷:\n- SVG\n- PNG (24px, 48px, 96px)\n- AI\n- Figma 파일','','','',0,0,1609,146,0,'admin','','최고관리자','admin@domain.com','','2025-12-03 08:37:22',0,'2025-12-03 08:37:22','127.0.0.1','','','','','','','','','','','',''),(44,-44,'',44,0,8,'','','','반응형 CSS 프레임워크 공유 (44)','반응형 CSS 프레임워크 공유합니다.\n\nBootstrap이나 Tailwind 대신 사용할 수 있는 가벼운 CSS 프레임워크예요.\n\n특징:\n- 용량이 작음 (minified 15KB)\n- 클래스명이 직관적\n- 커스터마이징 쉬움\n- 다크모드 지원\n\n포함된 기능:\n1. 그리드 시스템 (12컬럼)\n2. 타이포그래피\n3. 버튼 스타일\n4. 폼 요소\n5. 카드 컴포넌트','','','',0,0,267,66,0,'admin','','최고관리자','admin@domain.com','','2025-12-02 07:37:22',0,'2025-12-02 07:37:22','127.0.0.1','','','','','','','','','','','',''),(45,-45,'',45,0,6,'','','','[무료폰트] 한글 손글씨체 5종 (45)','한글 손글씨체 5종 무료 배포합니다!\n\n직접 제작한 손글씨 폰트예요. 개인/상업적 사용 모두 무료입니다.\n\n폰트 목록:\n1. 따뜻한손글씨 - 부드럽고 따뜻한 느낌\n2. 귀여운손글씨 - 동글동글 귀여운 스타일\n3. 깔끔한손글씨 - 정돈된 느낌\n4. 빠른손글씨 - 역동적인 느낌\n5. 어른손글씨 - 성숙하고 차분한 느낌\n\n파일 포맷: TTF, OTF, WOFF, WOFF2','','','',0,0,1815,113,0,'admin','','최고관리자','admin@domain.com','','2025-12-01 08:37:22',0,'2025-12-01 08:37:22','127.0.0.1','','','','','','','','','','','',''),(46,-46,'',46,0,0,'','','','JavaScript 유틸리티 라이브러리 (46)','JavaScript 유틸리티 라이브러리 공유합니다.\n\n자주 사용하는 기능들을 모아서 라이브러리로 만들었어요.\n\n포함된 기능:\n- 날짜/시간 처리\n- 문자열 처리\n- 배열 유틸리티\n- DOM 조작\n- Ajax 래퍼\n- 로컬스토리지 헬퍼\n- 유효성 검사\n- 숫자 포맷\n\n용량: 10KB (minified)\n호환성: ES6+, IE11 폴리필 포함','','','',0,0,649,128,0,'admin','','최고관리자','admin@domain.com','','2025-11-30 15:37:22',0,'2025-11-30 15:37:22','127.0.0.1','','','','','','','','','','','',''),(47,-47,'',47,0,7,'','','','[템플릿] 이력서 양식 모음 20종 (47)','이력서 양식 모음 20종 공유합니다!\n\n취업 준비하시는 분들께 도움이 되었으면 해요.\n\n포함된 양식:\n- 신입용 이력서 5종\n- 경력직 이력서 5종\n- 포트폴리오형 이력서 5종\n- 영문 이력서 5종\n\n파일 형식:\n- Word (.docx)\n- PDF\n- Figma\n\n업종별로 커스터마이징 가능합니다.','','','',0,0,441,119,0,'admin','','최고관리자','admin@domain.com','','2025-11-29 10:37:22',0,'2025-11-29 10:37:22','127.0.0.1','','','','','','','','','','','',''),(48,-48,'',48,0,10,'','','','무료 스톡 이미지 사이트 정리 (48)','무료로 사용할 수 있는 스톡 이미지 사이트 정리했습니다.\n\n상업적 사용 가능한 사이트만 모았어요!\n\n추천 사이트:\n1. Unsplash - 고퀄리티 사진\n2. Pexels - 다양한 카테고리\n3. Pixabay - 일러스트도 있음\n4. Freepik - 벡터 이미지\n5. Flaticon - 아이콘 전문\n\n각 사이트별 라이선스 주의사항도 정리했어요.','','','',0,0,1735,46,0,'admin','','최고관리자','admin@domain.com','','2025-11-27 20:37:22',0,'2025-11-27 20:37:22','127.0.0.1','','','','','','','','','','','',''),(49,-49,'',49,0,7,'','','','[공유] PPT 템플릿 50종 (49)','PPT 템플릿 50종 공유합니다!\n\n발표 준비하시는 분들 참고하세요.\n\n카테고리:\n- 비즈니스 (15종)\n- 교육 (10종)\n- 마케팅 (10종)\n- 포트폴리오 (10종)\n- 미니멀 (5종)\n\n특징:\n- 16:9 와이드 비율\n- 마스터 슬라이드 포함\n- 색상 변경 쉬움\n- 차트, 그래프 포함','','','',0,0,217,24,0,'admin','','최고관리자','admin@domain.com','','2025-11-26 19:37:22',0,'2025-11-26 19:37:22','127.0.0.1','','','','','','','','','','','',''),(50,-50,'',50,0,9,'','','','개발자를 위한 치트시트 모음 (50)','개발자를 위한 치트시트 모음입니다.\n\n자주 찾아보는 문법이나 명령어를 한눈에!\n\n포함된 치트시트:\n- HTML/CSS\n- JavaScript\n- Python\n- Git\n- Linux 명령어\n- SQL\n- React\n- Docker\n\nPDF와 이미지 파일로 제공됩니다.\n프린트해서 책상에 붙여두기 좋아요!','','','',0,0,1330,40,0,'admin','','최고관리자','admin@domain.com','','2025-11-25 16:37:22',0,'2025-11-25 16:37:22','127.0.0.1','','','','','','','','','','','',''),(51,-51,'',51,0,9,'','','','[배포] 로고 디자인 템플릿 30종 (51)','로고 디자인 템플릿 30종 배포합니다!\n\n스타트업이나 개인 프로젝트에 활용하세요.\n\n스타일별 구성:\n- 미니멀 (10종)\n- 모던 (10종)\n- 빈티지 (5종)\n- 캐릭터 (5종)\n\n제공 파일:\n- AI (원본)\n- EPS\n- SVG\n- PNG (투명배경)\n\n색상, 텍스트 수정 자유롭게 가능합니다.','','','',0,0,327,12,0,'admin','','최고관리자','admin@domain.com','','2025-11-25 09:37:22',0,'2025-11-25 09:37:22','127.0.0.1','','','','','','','','','','','',''),(52,-52,'',52,0,3,'','','','무료 영상 소스 모음 100종 (52)','무료 영상 소스 100종 모음입니다.\n\n영상 편집할 때 유용하게 쓰세요!\n\n포함된 소스:\n- 배경 영상 (30종)\n- 트랜지션 효과 (20종)\n- 오버레이 (20종)\n- 타이틀 애니메이션 (15종)\n- 로어써드 (15종)\n\n해상도: Full HD (1920x1080)\n포맷: MP4, MOV','','','',0,0,1861,136,0,'admin','','최고관리자','admin@domain.com','','2025-11-24 18:37:22',0,'2025-11-24 18:37:22','127.0.0.1','','','','','','','','','','','',''),(53,-53,'',53,0,0,'','','','[공유] 일러스트 브러쉬 세트 (53)','일러스트레이터/포토샵용 브러쉬 세트 공유합니다.\n\n다양한 스타일의 브러쉬 200개!\n\n브러쉬 종류:\n- 수채화 효과\n- 연필/펜 느낌\n- 텍스처 브러쉬\n- 패턴 브러쉬\n- 자연물 (나뭇잎, 구름 등)\n\n설치 방법과 사용 예제도 포함되어 있어요.','','','',0,0,244,119,0,'admin','','최고관리자','admin@domain.com','','2025-11-24 01:37:22',0,'2025-11-24 01:37:22','127.0.0.1','','','','','','','','','','','',''),(54,-54,'',54,0,6,'','','','HTML 이메일 템플릿 모음 (54)','HTML 이메일 템플릿 25종 공유합니다.\n\n뉴스레터나 마케팅 이메일에 활용하세요.\n\n템플릿 종류:\n- 뉴스레터 (10종)\n- 프로모션 (5종)\n- 환영 이메일 (3종)\n- 알림 이메일 (4종)\n- 트랜잭션 이메일 (3종)\n\n특징:\n- 반응형\n- 주요 이메일 클라이언트 호환\n- Litmus 테스트 완료','','','',0,0,1460,94,0,'admin','','최고관리자','admin@domain.com','','2025-11-22 19:37:22',0,'2025-11-22 19:37:22','127.0.0.1','','','','','','','','','','','',''),(55,-55,'',55,0,1,'','','','[무료] 모바일 UI 키트 (55)','모바일 UI 키트 무료 배포합니다!\n\n앱 디자인할 때 참고하세요.\n\n포함된 화면:\n- 로그인/회원가입\n- 홈 화면\n- 프로필\n- 설정\n- 리스트/그리드\n- 상세 페이지\n- 채팅\n- 결제\n\n파일 형식: Figma, Sketch, XD\n총 100개 이상의 컴포넌트 포함','','','',0,0,556,90,0,'admin','','최고관리자','admin@domain.com','','2025-11-21 20:37:22',0,'2025-11-21 20:37:22','127.0.0.1','','','','','','','','','','','',''),(56,-56,'',56,0,4,'','','','CSS 애니메이션 코드 모음 (56)','CSS 애니메이션 코드 모음입니다.\n\n복사해서 바로 사용할 수 있어요!\n\n포함된 애니메이션:\n- 페이드 인/아웃\n- 슬라이드\n- 바운스\n- 회전\n- 스케일\n- 물결 효과\n- 타이핑 효과\n- 로딩 스피너\n\n총 50개 이상의 애니메이션\n순수 CSS만 사용 (JS 없음)','반려동물-키우시는-분들-질문있어요-56','','',0,0,1602,21,0,'admin','','최고관리자','admin@domain.com','','2025-11-20 16:37:22',0,'2025-11-20 16:37:22','127.0.0.1','','','','','','','','','','','',''),(57,-57,'',57,0,5,'','','','[공유] 무료 음악/효과음 모음 (57)','무료로 사용 가능한 음악과 효과음 모음입니다.\n\n영상 편집이나 게임 개발에 활용하세요.\n\n포함된 소스:\n- BGM (50곡)\n  - 신나는 분위기\n  - 잔잔한 분위기\n  - 긴장감 있는\n  - 귀여운 느낌\n- 효과음 (200종)\n  - UI 효과음\n  - 자연 소리\n  - 생활 소음\n\n포맷: MP3, WAV','요즘-핫한-드라마-뭐예요-추천해주세요-57','','',0,0,1264,89,0,'admin','','최고관리자','admin@domain.com','','2025-11-20 08:37:22',0,'2025-11-20 08:37:22','127.0.0.1','','','','','','','','','','','',''),(58,-58,'',58,0,4,'','','','워드프레스 테마 추천 및 리뷰 (58)','워드프레스 테마 추천합니다.\n\n직접 사용해보고 좋았던 테마들이에요.\n\n추천 테마:\n1. Flavflavor - 다목적 테마, 속도 빠름\n2. flavor flavor - 깔끔한 블로그용\n3. flavor flavor - 쇼핑몰 특화\n4. flavor flavor - 포트폴리오용\n\n각 테마별 장단점과 설치 가이드도 포함했습니다.','자기계발-어떻게-하시나요-루틴-공유-58','','',0,0,1727,23,0,'admin','','최고관리자','admin@domain.com','','2025-11-19 11:37:22',0,'2025-11-19 11:37:22','127.0.0.1','','','','','','','','','','','',''),(59,-59,'',59,0,5,'','','','[배포] 명함 디자인 템플릿 40종 (59)','명함 디자인 템플릿 40종 배포합니다!\n\n업종별로 다양하게 준비했어요.\n\n카테고리:\n- 일반 비즈니스 (15종)\n- 크리에이티브 (10종)\n- 미니멀 (10종)\n- 세로형 (5종)\n\n파일 형식:\n- AI\n- PSD\n- PDF (인쇄용)\n\n실제 인쇄 사이즈 (90x50mm) 기준입니다.','출퇴근-시간-활용법-알려드려요-59','','',0,0,1720,20,0,'admin','','최고관리자','admin@domain.com','','2025-11-18 01:37:22',0,'2025-11-18 01:37:22','127.0.0.1','','','','','','','','','','','',''),(60,-60,'',60,0,4,'','','','개발 관련 전자책 모음 (합법) (60)','개발 관련 무료 전자책 모음입니다.\n\n모두 합법적으로 무료 배포되는 책들이에요!\n\n포함된 책:\n- 프로 Git (한글판)\n- 클린 코드 요약본\n- 자바스크립트 완벽 가이드\n- 파이썬 공식 튜토리얼\n- 리눅스 커맨드라인\n\n각 책의 원본 링크와 라이선스 정보도 포함했습니다.','건강관리-팁-공유합니다-30대-필독-60','','',0,0,1604,121,0,'admin','','최고관리자','admin@domain.com','','2025-11-16 19:37:22',0,'2025-11-16 19:37:22','127.0.0.1','','','','','','','','','','','',''),(61,-61,'',61,0,0,'','','','[무료] 프리미엄 웹사이트 템플릿 10종 (61)','프리미엄 웹사이트 템플릿을 무료로 공유합니다!\n\n이번에 공유하는 템플릿은 총 10종으로, 다양한 업종에 맞게 제작되었습니다.\n\n포함된 템플릿:\n1. 기업 홈페이지 - 깔끔하고 전문적인 느낌\n2. 포트폴리오 - 크리에이티브한 디자인\n3. 쇼핑몰 - 상품 진열에 최적화\n4. 블로그 - 가독성 좋은 레이아웃\n5. 랜딩페이지 - 전환율 높은 구조\n\n특징:\n- 100% 반응형\n- SEO 최적화\n- 빠른 로딩 속도\n\n사용 기술: HTML5, CSS3, JavaScript, Bootstrap 5','오늘-회사에서-있었던-황당한-일-공유합니다-61','','',0,0,249,117,0,'admin','','최고관리자','admin@domain.com','','2025-11-16 03:37:22',0,'2025-11-16 03:37:22','127.0.0.1','','','','','','','','','','','',''),(62,-62,'',62,0,7,'','','','[공유] 포토샵 액션 모음 30종 (62)','포토샵 액션 모음 공유합니다!\n\n작업 시간을 단축시켜주는 유용한 액션들을 모아봤어요.\n\n포함된 액션 (총 30종):\n- 빈티지 효과 5종\n- 필름 느낌 5종\n- HDR 효과 3종\n- 피부 보정 3종\n- 색상 보정 5종\n- 흑백 변환 3종\n- 글리치 효과 3종\n- 더블 노출 3종\n\n포토샵 CS6 이상에서 사용 가능합니다.','주말에-뭐하시나요-추천-좀-해주세요-62','','',0,0,1966,57,0,'admin','','최고관리자','admin@domain.com','','2025-11-16 08:37:22',0,'2025-11-16 08:37:22','127.0.0.1','','','','','','','','','','','',''),(63,-63,'',63,0,6,'','','','[배포] 무료 아이콘 세트 500종 (63)','무료 아이콘 세트 500종 배포합니다!\n\n웹/앱 개발에 유용한 아이콘들을 정리해서 공유해요.\n\n카테고리별 구성:\n- UI 기본 아이콘 (100종)\n- 소셜 미디어 (50종)\n- 전자상거래 (80종)\n- 파일/문서 (40종)\n- 커뮤니케이션 (50종)\n\n제공 포맷:\n- SVG\n- PNG (24px, 48px, 96px)\n- AI\n- Figma 파일','요즘-날씨가-너무-좋네요-산책-다녀왔어요-63','','',0,0,1227,27,0,'admin','','최고관리자','admin@domain.com','','2025-11-15 08:37:22',0,'2025-11-15 08:37:22','127.0.0.1','','','','','','','','','','','',''),(64,-64,'',64,0,9,'','','','반응형 CSS 프레임워크 공유 (64)','반응형 CSS 프레임워크 공유합니다.\n\nBootstrap이나 Tailwind 대신 사용할 수 있는 가벼운 CSS 프레임워크예요.\n\n특징:\n- 용량이 작음 (minified 15KB)\n- 클래스명이 직관적\n- 커스터마이징 쉬움\n- 다크모드 지원\n\n포함된 기능:\n1. 그리드 시스템 (12컬럼)\n2. 타이포그래피\n3. 버튼 스타일\n4. 폼 요소\n5. 카드 컴포넌트','강남역-근처-맛집-추천-부탁드려요-64','','',0,0,468,10,0,'admin','','최고관리자','admin@domain.com','','2025-11-14 05:37:22',0,'2025-11-14 05:37:22','127.0.0.1','','','','','','','','','','','',''),(65,-65,'',65,0,1,'','','','[무료폰트] 한글 손글씨체 5종 (65)','한글 손글씨체 5종 무료 배포합니다!\n\n직접 제작한 손글씨 폰트예요. 개인/상업적 사용 모두 무료입니다.\n\n폰트 목록:\n1. 따뜻한손글씨 - 부드럽고 따뜻한 느낌\n2. 귀여운손글씨 - 동글동글 귀여운 스타일\n3. 깔끔한손글씨 - 정돈된 느낌\n4. 빠른손글씨 - 역동적인 느낌\n5. 어른손글씨 - 성숙하고 차분한 느낌\n\n파일 포맷: TTF, OTF, WOFF, WOFF2','30대-중반-운동-시작하려는데-조언-부탁드려요-65','','',0,0,862,83,0,'admin','','최고관리자','admin@domain.com','','2025-11-13 02:37:22',0,'2025-11-13 02:37:22','127.0.0.1','','','','','','','','','','','',''),(66,-66,'',66,0,5,'','','','JavaScript 유틸리티 라이브러리 (66)','JavaScript 유틸리티 라이브러리 공유합니다.\n\n자주 사용하는 기능들을 모아서 라이브러리로 만들었어요.\n\n포함된 기능:\n- 날짜/시간 처리\n- 문자열 처리\n- 배열 유틸리티\n- DOM 조작\n- Ajax 래퍼\n- 로컬스토리지 헬퍼\n- 유효성 검사\n- 숫자 포맷\n\n용량: 10KB (minified)\n호환성: ES6+, IE11 폴리필 포함','재택근무-꿀팁-공유합니다-참고하세요-66','','',0,0,717,66,0,'admin','','최고관리자','admin@domain.com','','2025-11-12 02:37:22',0,'2025-11-12 02:37:22','127.0.0.1','','','','','','','','','','','',''),(67,-67,'',67,0,6,'','','','[템플릿] 이력서 양식 모음 20종 (67)','이력서 양식 모음 20종 공유합니다!\n\n취업 준비하시는 분들께 도움이 되었으면 해요.\n\n포함된 양식:\n- 신입용 이력서 5종\n- 경력직 이력서 5종\n- 포트폴리오형 이력서 5종\n- 영문 이력서 5종\n\n파일 형식:\n- Word (.docx)\n- PDF\n- Figma\n\n업종별로 커스터마이징 가능합니다.','요즘-읽고-있는-책-추천합니다-67','','',0,0,1428,75,0,'admin','','최고관리자','admin@domain.com','','2025-11-11 03:37:22',0,'2025-11-11 03:37:22','127.0.0.1','','','','','','','','','','','',''),(68,-68,'',68,0,9,'','','','무료 스톡 이미지 사이트 정리 (68)','무료로 사용할 수 있는 스톡 이미지 사이트 정리했습니다.\n\n상업적 사용 가능한 사이트만 모았어요!\n\n추천 사이트:\n1. Unsplash - 고퀄리티 사진\n2. Pexels - 다양한 카테고리\n3. Pixabay - 일러스트도 있음\n4. Freepik - 벡터 이미지\n5. Flaticon - 아이콘 전문\n\n각 사이트별 라이선스 주의사항도 정리했어요.','취미생활-뭐-하시나요-새로운-취미-찾는-중-68','','',0,0,1288,41,0,'admin','','최고관리자','admin@domain.com','','2025-11-10 00:37:22',0,'2025-11-10 00:37:22','127.0.0.1','','','','','','','','','','','',''),(69,-69,'',69,0,10,'','','','[공유] PPT 템플릿 50종 (69)','PPT 템플릿 50종 공유합니다!\n\n발표 준비하시는 분들 참고하세요.\n\n카테고리:\n- 비즈니스 (15종)\n- 교육 (10종)\n- 마케팅 (10종)\n- 포트폴리오 (10종)\n- 미니멀 (5종)\n\n특징:\n- 16:9 와이드 비율\n- 마스터 슬라이드 포함\n- 색상 변경 쉬움\n- 차트, 그래프 포함','이직-고민-중입니다-조언-부탁드려요-69','','',0,0,700,84,0,'admin','','최고관리자','admin@domain.com','','2025-11-08 21:37:22',0,'2025-11-08 21:37:22','127.0.0.1','','','','','','','','','','','',''),(70,-70,'',70,0,8,'','','','개발자를 위한 치트시트 모음 (70)','개발자를 위한 치트시트 모음입니다.\n\n자주 찾아보는 문법이나 명령어를 한눈에!\n\n포함된 치트시트:\n- HTML/CSS\n- JavaScript\n- Python\n- Git\n- Linux 명령어\n- SQL\n- React\n- Docker\n\nPDF와 이미지 파일로 제공됩니다.\n프린트해서 책상에 붙여두기 좋아요!','연말-계획-세우셨나요-저는-이렇게-계획-중-70','','',0,0,1606,98,0,'admin','','최고관리자','admin@domain.com','','2025-11-07 17:37:22',0,'2025-11-07 17:37:22','127.0.0.1','','','','','','','','','','','',''),(71,-71,'',71,0,4,'','','','[배포] 로고 디자인 템플릿 30종 (71)','로고 디자인 템플릿 30종 배포합니다!\n\n스타트업이나 개인 프로젝트에 활용하세요.\n\n스타일별 구성:\n- 미니멀 (10종)\n- 모던 (10종)\n- 빈티지 (5종)\n- 캐릭터 (5종)\n\n제공 파일:\n- AI (원본)\n- EPS\n- SVG\n- PNG (투명배경)\n\n색상, 텍스트 수정 자유롭게 가능합니다.','아침형-인간-되는-방법-공유합니다-71','','',0,0,596,85,0,'admin','','최고관리자','admin@domain.com','','2025-11-06 19:37:22',0,'2025-11-06 19:37:22','127.0.0.1','','','','','','','','','','','',''),(72,-72,'',72,0,6,'','','','무료 영상 소스 모음 100종 (72)','무료 영상 소스 100종 모음입니다.\n\n영상 편집할 때 유용하게 쓰세요!\n\n포함된 소스:\n- 배경 영상 (30종)\n- 트랜지션 효과 (20종)\n- 오버레이 (20종)\n- 타이틀 애니메이션 (15종)\n- 로어써드 (15종)\n\n해상도: Full HD (1920x1080)\n포맷: MP4, MOV','스트레스-해소법-공유해요-저는-이렇게-해요-72','','',0,0,841,19,0,'admin','','최고관리자','admin@domain.com','','2025-11-06 19:37:22',0,'2025-11-06 19:37:22','127.0.0.1','','','','','','','','','','','',''),(73,-73,'',73,0,9,'','','','[공유] 일러스트 브러쉬 세트 (73)','일러스트레이터/포토샵용 브러쉬 세트 공유합니다.\n\n다양한 스타일의 브러쉬 200개!\n\n브러쉬 종류:\n- 수채화 효과\n- 연필/펜 느낌\n- 텍스처 브러쉬\n- 패턴 브러쉬\n- 자연물 (나뭇잎, 구름 등)\n\n설치 방법과 사용 예제도 포함되어 있어요.','최근에-본-영화-추천합니다-꼭-보세요-73','','',0,0,1422,144,0,'admin','','최고관리자','admin@domain.com','','2025-11-05 20:37:22',0,'2025-11-05 20:37:22','127.0.0.1','','','','','','','','','','','',''),(74,-74,'',74,0,9,'','','','HTML 이메일 템플릿 모음 (74)','HTML 이메일 템플릿 25종 공유합니다.\n\n뉴스레터나 마케팅 이메일에 활용하세요.\n\n템플릿 종류:\n- 뉴스레터 (10종)\n- 프로모션 (5종)\n- 환영 이메일 (3종)\n- 알림 이메일 (4종)\n- 트랜잭션 이메일 (3종)\n\n특징:\n- 반응형\n- 주요 이메일 클라이언트 호환\n- Litmus 테스트 완료','집에서-할-수-있는-취미-추천해주세요-74','','',0,0,1748,30,0,'admin','','최고관리자','admin@domain.com','','2025-11-05 03:37:22',0,'2025-11-05 03:37:22','127.0.0.1','','','','','','','','','','','',''),(75,-75,'',75,0,10,'','','','[무료] 모바일 UI 키트 (75)','모바일 UI 키트 무료 배포합니다!\n\n앱 디자인할 때 참고하세요.\n\n포함된 화면:\n- 로그인/회원가입\n- 홈 화면\n- 프로필\n- 설정\n- 리스트/그리드\n- 상세 페이지\n- 채팅\n- 결제\n\n파일 형식: Figma, Sketch, XD\n총 100개 이상의 컴포넌트 포함','커피-vs-차-어떤-거-좋아하세요-75','','',0,0,1939,42,0,'admin','','최고관리자','admin@domain.com','','2025-11-04 07:37:22',0,'2025-11-04 07:37:22','127.0.0.1','','','','','','','','','','','',''),(76,-76,'',76,0,5,'','','','CSS 애니메이션 코드 모음 (76)','CSS 애니메이션 코드 모음입니다.\n\n복사해서 바로 사용할 수 있어요!\n\n포함된 애니메이션:\n- 페이드 인/아웃\n- 슬라이드\n- 바운스\n- 회전\n- 스케일\n- 물결 효과\n- 타이핑 효과\n- 로딩 스피너\n\n총 50개 이상의 애니메이션\n순수 CSS만 사용 (JS 없음)','반려동물-키우시는-분들-질문있어요-76','','',0,0,632,118,0,'admin','','최고관리자','admin@domain.com','','2025-11-02 20:37:22',0,'2025-11-02 20:37:22','127.0.0.1','','','','','','','','','','','',''),(77,-77,'',77,0,10,'','','','[공유] 무료 음악/효과음 모음 (77)','무료로 사용 가능한 음악과 효과음 모음입니다.\n\n영상 편집이나 게임 개발에 활용하세요.\n\n포함된 소스:\n- BGM (50곡)\n  - 신나는 분위기\n  - 잔잔한 분위기\n  - 긴장감 있는\n  - 귀여운 느낌\n- 효과음 (200종)\n  - UI 효과음\n  - 자연 소리\n  - 생활 소음\n\n포맷: MP3, WAV','요즘-핫한-드라마-뭐예요-추천해주세요-77','','',0,0,357,33,0,'admin','','최고관리자','admin@domain.com','','2025-11-02 09:37:22',0,'2025-11-02 09:37:22','127.0.0.1','','','','','','','','','','','',''),(78,-78,'',78,0,2,'','','','워드프레스 테마 추천 및 리뷰 (78)','워드프레스 테마 추천합니다.\n\n직접 사용해보고 좋았던 테마들이에요.\n\n추천 테마:\n1. Flavflavor - 다목적 테마, 속도 빠름\n2. flavor flavor - 깔끔한 블로그용\n3. flavor flavor - 쇼핑몰 특화\n4. flavor flavor - 포트폴리오용\n\n각 테마별 장단점과 설치 가이드도 포함했습니다.','자기계발-어떻게-하시나요-루틴-공유-78','','',0,0,1941,32,0,'admin','','최고관리자','admin@domain.com','','2025-10-31 18:37:22',0,'2025-10-31 18:37:22','127.0.0.1','','','','','','','','','','','',''),(79,-79,'',79,0,5,'','','','[배포] 명함 디자인 템플릿 40종 (79)','명함 디자인 템플릿 40종 배포합니다!\n\n업종별로 다양하게 준비했어요.\n\n카테고리:\n- 일반 비즈니스 (15종)\n- 크리에이티브 (10종)\n- 미니멀 (10종)\n- 세로형 (5종)\n\n파일 형식:\n- AI\n- PSD\n- PDF (인쇄용)\n\n실제 인쇄 사이즈 (90x50mm) 기준입니다.','출퇴근-시간-활용법-알려드려요-79','','',0,0,1962,104,0,'admin','','최고관리자','admin@domain.com','','2025-10-31 14:37:22',0,'2025-10-31 14:37:22','127.0.0.1','','','','','','','','','','','',''),(80,-80,'',80,0,1,'','','','개발 관련 전자책 모음 (합법) (80)','개발 관련 무료 전자책 모음입니다.\n\n모두 합법적으로 무료 배포되는 책들이에요!\n\n포함된 책:\n- 프로 Git (한글판)\n- 클린 코드 요약본\n- 자바스크립트 완벽 가이드\n- 파이썬 공식 튜토리얼\n- 리눅스 커맨드라인\n\n각 책의 원본 링크와 라이선스 정보도 포함했습니다.','건강관리-팁-공유합니다-30대-필독-80','','',0,0,610,21,0,'admin','','최고관리자','admin@domain.com','','2025-10-30 08:37:22',0,'2025-10-30 08:37:22','127.0.0.1','','','','','','','','','','','',''),(81,-81,'',81,0,9,'','','','[무료] 프리미엄 웹사이트 템플릿 10종 (81)','프리미엄 웹사이트 템플릿을 무료로 공유합니다!\n\n이번에 공유하는 템플릿은 총 10종으로, 다양한 업종에 맞게 제작되었습니다.\n\n포함된 템플릿:\n1. 기업 홈페이지 - 깔끔하고 전문적인 느낌\n2. 포트폴리오 - 크리에이티브한 디자인\n3. 쇼핑몰 - 상품 진열에 최적화\n4. 블로그 - 가독성 좋은 레이아웃\n5. 랜딩페이지 - 전환율 높은 구조\n\n특징:\n- 100% 반응형\n- SEO 최적화\n- 빠른 로딩 속도\n\n사용 기술: HTML5, CSS3, JavaScript, Bootstrap 5','오늘-회사에서-있었던-황당한-일-공유합니다-81','','',0,0,1486,114,0,'admin','','최고관리자','admin@domain.com','','2025-10-29 00:37:22',0,'2025-10-29 00:37:22','127.0.0.1','','','','','','','','','','','',''),(82,-82,'',82,0,1,'','','','[공유] 포토샵 액션 모음 30종 (82)','포토샵 액션 모음 공유합니다!\n\n작업 시간을 단축시켜주는 유용한 액션들을 모아봤어요.\n\n포함된 액션 (총 30종):\n- 빈티지 효과 5종\n- 필름 느낌 5종\n- HDR 효과 3종\n- 피부 보정 3종\n- 색상 보정 5종\n- 흑백 변환 3종\n- 글리치 효과 3종\n- 더블 노출 3종\n\n포토샵 CS6 이상에서 사용 가능합니다.','주말에-뭐하시나요-추천-좀-해주세요-82','','',0,0,701,94,0,'admin','','최고관리자','admin@domain.com','','2025-10-29 04:37:22',0,'2025-10-29 04:37:22','127.0.0.1','','','','','','','','','','','',''),(83,-83,'',83,0,5,'','','','[배포] 무료 아이콘 세트 500종 (83)','무료 아이콘 세트 500종 배포합니다!\n\n웹/앱 개발에 유용한 아이콘들을 정리해서 공유해요.\n\n카테고리별 구성:\n- UI 기본 아이콘 (100종)\n- 소셜 미디어 (50종)\n- 전자상거래 (80종)\n- 파일/문서 (40종)\n- 커뮤니케이션 (50종)\n\n제공 포맷:\n- SVG\n- PNG (24px, 48px, 96px)\n- AI\n- Figma 파일','요즘-날씨가-너무-좋네요-산책-다녀왔어요-83','','',0,0,1362,107,0,'admin','','최고관리자','admin@domain.com','','2025-10-28 00:37:22',0,'2025-10-28 00:37:22','127.0.0.1','','','','','','','','','','','',''),(84,-84,'',84,0,3,'','','','반응형 CSS 프레임워크 공유 (84)','반응형 CSS 프레임워크 공유합니다.\n\nBootstrap이나 Tailwind 대신 사용할 수 있는 가벼운 CSS 프레임워크예요.\n\n특징:\n- 용량이 작음 (minified 15KB)\n- 클래스명이 직관적\n- 커스터마이징 쉬움\n- 다크모드 지원\n\n포함된 기능:\n1. 그리드 시스템 (12컬럼)\n2. 타이포그래피\n3. 버튼 스타일\n4. 폼 요소\n5. 카드 컴포넌트','강남역-근처-맛집-추천-부탁드려요-84','','',0,0,1772,54,0,'admin','','최고관리자','admin@domain.com','','2025-10-26 17:37:22',0,'2025-10-26 17:37:22','127.0.0.1','','','','','','','','','','','',''),(85,-85,'',85,0,0,'','','','[무료폰트] 한글 손글씨체 5종 (85)','한글 손글씨체 5종 무료 배포합니다!\n\n직접 제작한 손글씨 폰트예요. 개인/상업적 사용 모두 무료입니다.\n\n폰트 목록:\n1. 따뜻한손글씨 - 부드럽고 따뜻한 느낌\n2. 귀여운손글씨 - 동글동글 귀여운 스타일\n3. 깔끔한손글씨 - 정돈된 느낌\n4. 빠른손글씨 - 역동적인 느낌\n5. 어른손글씨 - 성숙하고 차분한 느낌\n\n파일 포맷: TTF, OTF, WOFF, WOFF2','30대-중반-운동-시작하려는데-조언-부탁드려요-85','','',0,0,1858,85,0,'admin','','최고관리자','admin@domain.com','','2025-10-26 09:37:22',0,'2025-10-26 09:37:22','127.0.0.1','','','','','','','','','','','',''),(86,-86,'',86,0,6,'','','','JavaScript 유틸리티 라이브러리 (86)','JavaScript 유틸리티 라이브러리 공유합니다.\n\n자주 사용하는 기능들을 모아서 라이브러리로 만들었어요.\n\n포함된 기능:\n- 날짜/시간 처리\n- 문자열 처리\n- 배열 유틸리티\n- DOM 조작\n- Ajax 래퍼\n- 로컬스토리지 헬퍼\n- 유효성 검사\n- 숫자 포맷\n\n용량: 10KB (minified)\n호환성: ES6+, IE11 폴리필 포함','재택근무-꿀팁-공유합니다-참고하세요-86','','',0,0,1776,123,0,'admin','','최고관리자','admin@domain.com','','2025-10-24 23:37:22',0,'2025-10-24 23:37:22','127.0.0.1','','','','','','','','','','','',''),(87,-87,'',87,0,3,'','','','[템플릿] 이력서 양식 모음 20종 (87)','이력서 양식 모음 20종 공유합니다!\n\n취업 준비하시는 분들께 도움이 되었으면 해요.\n\n포함된 양식:\n- 신입용 이력서 5종\n- 경력직 이력서 5종\n- 포트폴리오형 이력서 5종\n- 영문 이력서 5종\n\n파일 형식:\n- Word (.docx)\n- PDF\n- Figma\n\n업종별로 커스터마이징 가능합니다.','요즘-읽고-있는-책-추천합니다-87','','',0,0,1530,45,0,'admin','','최고관리자','admin@domain.com','','2025-10-23 21:37:22',0,'2025-10-23 21:37:22','127.0.0.1','','','','','','','','','','','',''),(88,-88,'',88,0,1,'','','','무료 스톡 이미지 사이트 정리 (88)','무료로 사용할 수 있는 스톡 이미지 사이트 정리했습니다.\n\n상업적 사용 가능한 사이트만 모았어요!\n\n추천 사이트:\n1. Unsplash - 고퀄리티 사진\n2. Pexels - 다양한 카테고리\n3. Pixabay - 일러스트도 있음\n4. Freepik - 벡터 이미지\n5. Flaticon - 아이콘 전문\n\n각 사이트별 라이선스 주의사항도 정리했어요.','취미생활-뭐-하시나요-새로운-취미-찾는-중-88','','',0,0,867,58,0,'admin','','최고관리자','admin@domain.com','','2025-10-22 21:37:22',0,'2025-10-22 21:37:22','127.0.0.1','','','','','','','','','','','',''),(89,-89,'',89,0,5,'','','','[공유] PPT 템플릿 50종 (89)','PPT 템플릿 50종 공유합니다!\n\n발표 준비하시는 분들 참고하세요.\n\n카테고리:\n- 비즈니스 (15종)\n- 교육 (10종)\n- 마케팅 (10종)\n- 포트폴리오 (10종)\n- 미니멀 (5종)\n\n특징:\n- 16:9 와이드 비율\n- 마스터 슬라이드 포함\n- 색상 변경 쉬움\n- 차트, 그래프 포함','이직-고민-중입니다-조언-부탁드려요-89','','',0,0,1626,48,0,'admin','','최고관리자','admin@domain.com','','2025-10-22 08:37:22',0,'2025-10-22 08:37:22','127.0.0.1','','','','','','','','','','','',''),(90,-90,'',90,0,6,'','','','개발자를 위한 치트시트 모음 (90)','개발자를 위한 치트시트 모음입니다.\n\n자주 찾아보는 문법이나 명령어를 한눈에!\n\n포함된 치트시트:\n- HTML/CSS\n- JavaScript\n- Python\n- Git\n- Linux 명령어\n- SQL\n- React\n- Docker\n\nPDF와 이미지 파일로 제공됩니다.\n프린트해서 책상에 붙여두기 좋아요!','연말-계획-세우셨나요-저는-이렇게-계획-중-90','','',0,0,1361,11,0,'admin','','최고관리자','admin@domain.com','','2025-10-21 06:37:22',0,'2025-10-21 06:37:22','127.0.0.1','','','','','','','','','','','',''),(91,-91,'',91,0,4,'','','','[배포] 로고 디자인 템플릿 30종 (91)','로고 디자인 템플릿 30종 배포합니다!\n\n스타트업이나 개인 프로젝트에 활용하세요.\n\n스타일별 구성:\n- 미니멀 (10종)\n- 모던 (10종)\n- 빈티지 (5종)\n- 캐릭터 (5종)\n\n제공 파일:\n- AI (원본)\n- EPS\n- SVG\n- PNG (투명배경)\n\n색상, 텍스트 수정 자유롭게 가능합니다.','아침형-인간-되는-방법-공유합니다-91','','',0,0,1855,122,0,'admin','','최고관리자','admin@domain.com','','2025-10-20 00:37:22',0,'2025-10-20 00:37:22','127.0.0.1','','','','','','','','','','','',''),(92,-92,'',92,0,9,'','','','무료 영상 소스 모음 100종 (92)','무료 영상 소스 100종 모음입니다.\n\n영상 편집할 때 유용하게 쓰세요!\n\n포함된 소스:\n- 배경 영상 (30종)\n- 트랜지션 효과 (20종)\n- 오버레이 (20종)\n- 타이틀 애니메이션 (15종)\n- 로어써드 (15종)\n\n해상도: Full HD (1920x1080)\n포맷: MP4, MOV','스트레스-해소법-공유해요-저는-이렇게-해요-92','','',0,0,613,144,0,'admin','','최고관리자','admin@domain.com','','2025-10-20 15:37:22',0,'2025-10-20 15:37:22','127.0.0.1','','','','','','','','','','','',''),(93,-93,'',93,0,10,'','','','[공유] 일러스트 브러쉬 세트 (93)','일러스트레이터/포토샵용 브러쉬 세트 공유합니다.\n\n다양한 스타일의 브러쉬 200개!\n\n브러쉬 종류:\n- 수채화 효과\n- 연필/펜 느낌\n- 텍스처 브러쉬\n- 패턴 브러쉬\n- 자연물 (나뭇잎, 구름 등)\n\n설치 방법과 사용 예제도 포함되어 있어요.','최근에-본-영화-추천합니다-꼭-보세요-93','','',0,0,798,68,0,'admin','','최고관리자','admin@domain.com','','2025-10-19 11:37:22',0,'2025-10-19 11:37:22','127.0.0.1','','','','','','','','','','','',''),(94,-94,'',94,0,8,'','','','HTML 이메일 템플릿 모음 (94)','HTML 이메일 템플릿 25종 공유합니다.\n\n뉴스레터나 마케팅 이메일에 활용하세요.\n\n템플릿 종류:\n- 뉴스레터 (10종)\n- 프로모션 (5종)\n- 환영 이메일 (3종)\n- 알림 이메일 (4종)\n- 트랜잭션 이메일 (3종)\n\n특징:\n- 반응형\n- 주요 이메일 클라이언트 호환\n- Litmus 테스트 완료','집에서-할-수-있는-취미-추천해주세요-94','','',0,0,1282,51,0,'admin','','최고관리자','admin@domain.com','','2025-10-18 08:37:22',0,'2025-10-18 08:37:22','127.0.0.1','','','','','','','','','','','',''),(95,-95,'',95,0,4,'','','','[무료] 모바일 UI 키트 (95)','모바일 UI 키트 무료 배포합니다!\n\n앱 디자인할 때 참고하세요.\n\n포함된 화면:\n- 로그인/회원가입\n- 홈 화면\n- 프로필\n- 설정\n- 리스트/그리드\n- 상세 페이지\n- 채팅\n- 결제\n\n파일 형식: Figma, Sketch, XD\n총 100개 이상의 컴포넌트 포함','커피-vs-차-어떤-거-좋아하세요-95','','',0,0,1556,16,0,'admin','','최고관리자','admin@domain.com','','2025-10-16 19:37:22',0,'2025-10-16 19:37:22','127.0.0.1','','','','','','','','','','','',''),(96,-96,'',96,0,4,'','','html1','CSS 애니메이션 코드 모음 (96)','CSS 애니메이션 코드 모음입니다.<br /><br />\r\n<br /><br />\r\n복사해서 바로 사용할 수 있어요!<br /><br />\r\n<br /><br />\r\n포함된 애니메이션:<br /><br />\r\n- 페이드 인/아웃<br /><br />\r\n- 슬라이드<br /><br />\r\n- 바운스<br /><br />\r\n- 회전<br /><br />\r\n- 스케일<br /><br />\r\n- 물결 효과<br /><br />\r\n- 타이핑 효과<br /><br />\r\n- 로딩 스피너<br /><br />\r\n<br /><br />\r\n총 50개 이상의 애니메이션<br /><br />\r\n순수 CSS만 사용 (JS 없음)','css-애니메이션-코드-모음-96','','',0,0,700,65,0,'admin','','최고관리자','admin@domain.com','','2025-10-16 15:37:22',0,'2025-10-16 15:37:22','127.0.0.1','','','','','','','','','','','',''),(97,-97,'',97,0,2,'','','','[공유] 무료 음악/효과음 모음 (97)','무료로 사용 가능한 음악과 효과음 모음입니다.\n\n영상 편집이나 게임 개발에 활용하세요.\n\n포함된 소스:\n- BGM (50곡)\n  - 신나는 분위기\n  - 잔잔한 분위기\n  - 긴장감 있는\n  - 귀여운 느낌\n- 효과음 (200종)\n  - UI 효과음\n  - 자연 소리\n  - 생활 소음\n\n포맷: MP3, WAV','요즘-핫한-드라마-뭐예요-추천해주세요-97','','',0,0,1231,139,0,'admin','','최고관리자','admin@domain.com','','2025-10-15 02:37:22',0,'2025-10-15 02:37:22','127.0.0.1','','','','','','','','','','','',''),(98,-98,'',98,0,7,'','','','워드프레스 테마 추천 및 리뷰 (98)','워드프레스 테마 추천합니다.\n\n직접 사용해보고 좋았던 테마들이에요.\n\n추천 테마:\n1. Flavflavor - 다목적 테마, 속도 빠름\n2. flavor flavor - 깔끔한 블로그용\n3. flavor flavor - 쇼핑몰 특화\n4. flavor flavor - 포트폴리오용\n\n각 테마별 장단점과 설치 가이드도 포함했습니다.','자기계발-어떻게-하시나요-루틴-공유-98','','',0,0,715,31,0,'admin','','최고관리자','admin@domain.com','','2025-10-13 17:37:22',0,'2025-10-13 17:37:22','127.0.0.1','','','','','','','','','','','',''),(99,-99,'',99,0,5,'','','','[배포] 명함 디자인 템플릿 40종 (99)','명함 디자인 템플릿 40종 배포합니다!\n\n업종별로 다양하게 준비했어요.\n\n카테고리:\n- 일반 비즈니스 (15종)\n- 크리에이티브 (10종)\n- 미니멀 (10종)\n- 세로형 (5종)\n\n파일 형식:\n- AI\n- PSD\n- PDF (인쇄용)\n\n실제 인쇄 사이즈 (90x50mm) 기준입니다.','출퇴근-시간-활용법-알려드려요-99','','',0,0,1801,141,0,'admin','','최고관리자','admin@domain.com','','2025-10-12 19:37:22',0,'2025-10-12 19:37:22','127.0.0.1','','','','','','','','','','','',''),(100,-100,'',100,0,3,'','','','개발 관련 전자책 모음 (합법) (100)','개발 관련 무료 전자책 모음입니다.\n\n모두 합법적으로 무료 배포되는 책들이에요!\n\n포함된 책:\n- 프로 Git (한글판)\n- 클린 코드 요약본\n- 자바스크립트 완벽 가이드\n- 파이썬 공식 튜토리얼\n- 리눅스 커맨드라인\n\n각 책의 원본 링크와 라이선스 정보도 포함했습니다.','건강관리-팁-공유합니다-30대-필독-100','','',0,0,1606,146,0,'admin','','최고관리자','admin@domain.com','','2025-10-12 05:37:22',0,'2026-01-10 05:21:04','127.0.0.1','','','','','','','','','','','',''),(101,-100,'',100,1,1,'','','','','12321312321','','','',0,0,0,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 05:20:08',0,'','::1','','','','','','','','','','','',''),(102,-100,'',100,1,2,'','','','','122232123','','','',0,0,0,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 05:20:12',0,'','::1','','','','','','','','','','','',''),(103,-100,'',100,1,1,'A','','','','ㅇㅇ','','','',0,0,0,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 05:21:04',0,'','::1','','','','','','','','','','','',''),(104,-101,'',104,0,0,'','','','1211','1212','1211','','',0,0,1,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 06:29:00',0,'2026-01-10 06:29:00','::1','','','free','','1','','','N','','','','zip'),(105,-102,'',105,0,0,'','','','테스트 자료입니다','<p>테스트 내용입니다. 이것은 테스트 자료입니다.</p>','테스트-자료입니다','','',0,0,1,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 06:37:17',0,'2026-01-10 06:37:17','::1','','','free','','1','','','N','','','','zip'),(106,-103,'',106,0,0,'','','','EWFEWFWEF','<p>WEFWFF</p>','ewfewfwef','','',0,0,1,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 06:38:03',0,'2026-01-10 06:38:03','::1','','','free','','1','','','N','','','','zip'),(107,-104,'',107,0,0,'','','','wfwef','<p>wefwefwefwe</p>','wfwef','','',0,0,1,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 07:05:51',0,'2026-01-10 07:05:51','::1','','','free','','1','','','N','','','','zip'),(108,-105,'',108,0,0,'','','','skfjkdsjkfsdjkf','<p>skfjkdsjkfsdjkf</p><p>skfjkdsjkfsdjkfskfjkdsjkfsdjkfskfjkdsjkfsdjkf</p><p>skfjkdsjkfsdjkfskfjkdsjkfsdjkf</p><p>skfjkdsjkfsdjkf</p><p>skfjkdsjkfsdjkf</p><p>skfjkdsjkfsdjkf</p><p>skfjkdsjkfsdjkf</p><p>skfjkdsjkfsdjkf</p><p>skfjkdsjkfsdjkf</p><p>skfjkdsjkfsdjkfskfjkdsjkfsdjkf</p>','skfjkdsjkfsdjkf','','',0,0,1,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 07:06:20',0,'2026-01-10 07:06:20','::1','','','free','','1','','','N','','','','zip'),(109,-106,'',109,0,0,'','','html1','wfwef','<p>wfwef</p>','wfwef-1','','',0,0,1,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 07:16:07',0,'2026-01-10 07:16:07','::1','','','free','','1','','','N','','','','zip'),(110,-107,'',110,0,0,'','','html1','<script>alert(\'XSS\')</script>','<img src=\"x\" onerror=\"alert(\'XSS\')\">\r\n<script>eval(atob(\'YWxlcnQoJ1hTUycp\'))</script>','alertxss','','',0,0,1,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 07:17:27',0,'2026-01-10 07:17:27','::1','','','free','','1','','','N','','','','zip'),(111,-108,'',111,0,0,'','','html1','sdfdsf','<p>dsfdsf</p>','sdfdsf','','',0,0,0,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 07:43:54',0,'2026-01-10 07:43:54','::1','','','free','','1','','','N','','','','zip'),(112,-109,'',112,0,0,'','','html1','pds','<p>pdspds</p>','pds','','',0,0,1,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 07:45:53',1,'2026-01-10 07:45:53','::1','','','free','','1','','','N','','','','zip'),(113,-110,'',113,0,0,'','','html1','sdfdsfdsf','<p>wefwefwwef</p>','sdfdsfdsf','','',0,0,1,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 08:09:04',3,'2026-01-10 08:09:04','::1','','','free','','1','','','N','','','','zip');
/*!40000 ALTER TABLE `g5_write_pds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_photo`
--

DROP TABLE IF EXISTS `g5_write_photo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_photo` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_photo`
--

LOCK TABLES `g5_write_photo` WRITE;
/*!40000 ALTER TABLE `g5_write_photo` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_photo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_plugin`
--

DROP TABLE IF EXISTS `g5_write_plugin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_plugin` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_plugin`
--

LOCK TABLES `g5_write_plugin` WRITE;
/*!40000 ALTER TABLE `g5_write_plugin` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_plugin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_promo`
--

DROP TABLE IF EXISTS `g5_write_promo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_promo` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_promo`
--

LOCK TABLES `g5_write_promo` WRITE;
/*!40000 ALTER TABLE `g5_write_promo` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_promo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_qa`
--

DROP TABLE IF EXISTS `g5_write_qa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_qa` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_qa`
--

LOCK TABLES `g5_write_qa` WRITE;
/*!40000 ALTER TABLE `g5_write_qa` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_qa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_qna_css`
--

DROP TABLE IF EXISTS `g5_write_qna_css`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_qna_css` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_qna_css`
--

LOCK TABLES `g5_write_qna_css` WRITE;
/*!40000 ALTER TABLE `g5_write_qna_css` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_qna_css` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_qna_js`
--

DROP TABLE IF EXISTS `g5_write_qna_js`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_qna_js` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_qna_js`
--

LOCK TABLES `g5_write_qna_js` WRITE;
/*!40000 ALTER TABLE `g5_write_qna_js` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_qna_js` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_qna_php`
--

DROP TABLE IF EXISTS `g5_write_qna_php`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_qna_php` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_qna_php`
--

LOCK TABLES `g5_write_qna_php` WRITE;
/*!40000 ALTER TABLE `g5_write_qna_php` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_qna_php` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_qna_server`
--

DROP TABLE IF EXISTS `g5_write_qna_server`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_qna_server` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_qna_server`
--

LOCK TABLES `g5_write_qna_server` WRITE;
/*!40000 ALTER TABLE `g5_write_qna_server` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_qna_server` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_skin`
--

DROP TABLE IF EXISTS `g5_write_skin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_skin` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_skin`
--

LOCK TABLES `g5_write_skin` WRITE;
/*!40000 ALTER TABLE `g5_write_skin` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_skin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_source`
--

DROP TABLE IF EXISTS `g5_write_source`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_source` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_source`
--

LOCK TABLES `g5_write_source` WRITE;
/*!40000 ALTER TABLE `g5_write_source` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_source` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_test`
--

DROP TABLE IF EXISTS `g5_write_test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `g5_write_test` (
  `wr_id` int NOT NULL AUTO_INCREMENT,
  `wr_num` int NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint NOT NULL DEFAULT '0',
  `wr_comment` int NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int NOT NULL DEFAULT '0',
  `wr_link2_hit` int NOT NULL DEFAULT '0',
  `wr_hit` int NOT NULL DEFAULT '0',
  `wr_good` int NOT NULL DEFAULT '0',
  `wr_nogood` int NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_test`
--

LOCK TABLES `g5_write_test` WRITE;
/*!40000 ALTER TABLE `g5_write_test` DISABLE KEYS */;
INSERT INTO `g5_write_test` VALUES (1,-1,'',1,0,6,'','','','sdfsdf','sdfsdfds','sdfsdf','','',0,0,4,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 04:50:44',0,'2026-01-10 05:00:52','::1','','','','','','','','','','','',''),(2,-1,'',1,1,1,'','','','','sfdsfdsf','','','',0,0,0,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 04:55:50',0,'','::1','','','','','','','','','','','',''),(3,-1,'',1,1,2,'','','','','werewrewweerwer','','','',0,0,0,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 04:55:54',0,'','::1','','','','','','','','','','','',''),(4,-1,'',1,1,3,'','','','','werwerweewr','','','',0,0,0,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 04:56:16',0,'','::1','','','','','','','','','','','',''),(5,-1,'',1,1,4,'','','','','123123123221','','','',0,0,0,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 04:56:23',0,'','::1','','','','','','','','','','','',''),(6,-1,'',1,1,5,'','','','','dff','','','',0,0,0,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 05:00:49',0,'','::1','','','','','','','','','','','',''),(7,-1,'',1,1,6,'','','','','zzzzzzzzzzzzzzzzzzzzzzz','','','',0,0,0,0,0,'admin','','최고관리자','admin@domain.com','','2026-01-10 05:00:52',0,'','::1','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_test` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-10 10:21:35
