-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: localhost    Database: coperacha
-- ------------------------------------------------------
-- Server version	5.5.46-0ubuntu0.14.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Cumpleaños','/images/category/birthday.png','2016-08-07 04:14:29','2016-08-07 04:14:29'),(2,'Festejos','/images/category/celebrations.png','2016-08-07 04:14:30','2016-08-07 04:14:30'),(3,'Viajes','/images/category/travels.png','2016-08-07 04:14:30','2016-08-07 04:14:30'),(4,'Bodas','/images/category/wedding.png','2016-08-07 04:14:30','2016-08-07 04:14:30'),(5,'Baby Shower','/images/category/baby-shawer.png','2016-08-07 04:14:30','2016-08-07 04:14:30'),(6,'Emergencias','/images/category/emergencies.png','2016-08-07 04:14:30','2016-08-07 04:14:30'),(7,'Otro','/images/category/others.png','2016-08-07 04:14:30','2016-08-07 04:14:30');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fbusers`
--

DROP TABLE IF EXISTS `fbusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fbusers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `fb_uid` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fbusers_fb_uid_unique` (`fb_uid`),
  KEY `fbusers_user_id_foreign` (`user_id`),
  CONSTRAINT `fbusers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fbusers`
--

LOCK TABLES `fbusers` WRITE;
/*!40000 ALTER TABLE `fbusers` DISABLE KEYS */;
INSERT INTO `fbusers` VALUES (1,1,'1148966948479400','2016-09-08 02:30:39','2016-09-08 02:30:39'),(2,2,'530266100517243','2016-09-08 11:31:15','2016-09-08 11:31:15'),(3,5,'10154213079572599','2016-09-09 01:12:20','2016-09-09 01:12:20');
/*!40000 ALTER TABLE `fbusers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extension` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) NOT NULL,
  `metadata` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `storable_type` varchar(255) CHARACTER SET utf8 NOT NULL,
  `storable_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (1,'1','57d14b6f72433_63398420.jpg','uploads','66487','jpg',0,'image/jpeg','App\\Entities\\Moneybox',1,'2016-09-08 10:28:47','2016-09-08 10:28:47'),(2,'4','57d2184686879_imp-pant.jpg','uploads','78402','jpg',0,'image/jpeg','App\\Entities\\Moneybox',3,'2016-09-09 01:02:46','2016-09-09 01:02:46'),(3,'1','57d2494a94602_cover-money.png','uploads','15409','png',0,'image/png','App\\Entities\\Moneybox',1,'2016-09-09 04:31:54','2016-09-09 04:31:54'),(4,'1','57d24dc5143be_american-express-logo.png','uploads','15483','png',0,'image/png','App\\Entities\\Moneybox',1,'2016-09-09 04:51:01','2016-09-09 04:51:01'),(5,'1','57d24e21614b1_advantage-3.png','uploads','2869','png',0,'image/png','App\\Entities\\Moneybox',1,'2016-09-09 04:52:33','2016-09-09 04:52:33'),(6,'1','57d24e2cb72f7_cover-money.png','uploads','15409','png',0,'image/png','App\\Entities\\Moneybox',1,'2016-09-09 04:52:44','2016-09-09 04:52:44'),(7,'1','57d5ab831a64b_invoice-01-09-2015.pdf','public','321328','pdf',0,'application/pdf','App\\Entities\\Order',1,'2016-09-11 18:07:47','2016-09-11 18:07:47'),(8,'1','57d5add22cd38_invoice-01-09-2015.pdf','public','321328','pdf',0,'application/pdf','App\\Entities\\Order',2,'2016-09-11 18:17:38','2016-09-11 18:17:38'),(9,'1','57d6366bec89c_Screenshot_2016-09-11-23-59-22.png','uploads','95779','png',0,'image/png','App\\Entities\\Moneybox',4,'2016-09-12 04:00:27','2016-09-12 04:00:27');
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friendships`
--

DROP TABLE IF EXISTS `friendships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friendships` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(10) unsigned NOT NULL,
  `friend_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `friendships_person_id_foreign` (`person_id`),
  CONSTRAINT `friendships_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friendships`
--

LOCK TABLES `friendships` WRITE;
/*!40000 ALTER TABLE `friendships` DISABLE KEYS */;
/*!40000 ALTER TABLE `friendships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invitations`
--

DROP TABLE IF EXISTS `invitations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invitations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `moneybox_id` int(11) NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invitations`
--

LOCK TABLES `invitations` WRITE;
/*!40000 ALTER TABLE `invitations` DISABLE KEYS */;
INSERT INTO `invitations` VALUES (1,2,'jorgeramon_@hotmail.com',0,8,'2016-09-08 12:12:46','2016-09-16 10:00:02'),(2,2,'jorgeramon_@hotmail.com',0,0,'2016-09-08 12:38:43','2016-09-08 12:38:43'),(3,2,'efrain.lazzerim@gmail.com',1,0,'2016-09-08 12:43:48','2016-09-08 12:48:36'),(4,2,'corbin.yoann@gmail.com',0,8,'2016-09-08 12:47:12','2016-09-16 10:00:08'),(5,3,'cesarmejiaguzman@gmail.com',0,8,'2016-09-09 00:55:51','2016-09-16 10:00:10'),(6,1,'',0,5,'2016-09-11 21:35:55','2016-09-16 10:00:10');
/*!40000 ALTER TABLE `invitations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_settings`
--

DROP TABLE IF EXISTS `member_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `setting_id` int(10) unsigned NOT NULL,
  `option_id` int(10) unsigned NOT NULL,
  `owner_id` int(10) unsigned NOT NULL,
  `owner` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_settings_option_id_foreign` (`option_id`),
  KEY `member_settings_setting_id_foreign` (`setting_id`),
  CONSTRAINT `member_settings_setting_id_foreign` FOREIGN KEY (`setting_id`) REFERENCES `settings` (`id`),
  CONSTRAINT `member_settings_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `setting_options` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_settings`
--

LOCK TABLES `member_settings` WRITE;
/*!40000 ALTER TABLE `member_settings` DISABLE KEYS */;
INSERT INTO `member_settings` VALUES (1,1,1,1,'moneybox','1','2016-09-08 02:32:50','2016-09-08 02:32:50'),(2,2,4,1,'moneybox','1','2016-09-08 02:32:50','2016-09-08 02:32:50'),(3,3,7,1,'participant','1','2016-09-08 02:33:16','2016-09-08 02:33:16'),(4,1,1,2,'moneybox','1','2016-09-08 12:10:40','2016-09-08 12:38:34'),(5,2,4,2,'moneybox','1','2016-09-08 12:10:40','2016-09-08 12:10:40'),(6,3,7,2,'participant','1','2016-09-08 12:48:36','2016-09-08 12:48:36'),(7,1,2,3,'moneybox','20','2016-09-09 00:55:29','2016-09-09 01:07:17'),(8,2,4,3,'moneybox','1','2016-09-09 00:55:29','2016-09-09 00:55:29'),(9,3,7,3,'participant','1','2016-09-09 00:57:21','2016-09-09 00:57:21'),(10,1,2,4,'moneybox','50','2016-09-12 03:58:16','2016-09-12 03:58:16'),(11,2,4,4,'moneybox','1','2016-09-12 03:58:16','2016-09-12 03:58:16'),(12,3,7,4,'participant','1','2016-09-12 03:58:54','2016-09-12 03:58:54');
/*!40000 ALTER TABLE `member_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_100000_create_password_resets_table',1),('2016_06_12_015044_create_persons_table',1),('2016_06_12_016045_create_categories_table',1),('2016_06_12_022004_create_moneyboxes_table',1),('2016_06_12_022934_create_participants_table',1),('2016_06_12_023407_create_settings_table',1),('2016_06_12_023408_create_setting_options_table',1),('2016_06_12_023820_create_member_settings_table',1),('2016_06_12_024607_create_payments_table',1),('2016_06_12_025152_create_friendships_table',1),('2016_06_12_025153_create_users_table',1),('2016_06_13_025154_create_fbusers_table',1),('2016_08_30_231322_create_invitations_table',1),('2016_09_03_123604_create_orders_table',1),('2016_09_03_164614_create_files_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `moneyboxes`
--

DROP TABLE IF EXISTS `moneyboxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moneyboxes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `goal_amount` decimal(10,2) NOT NULL,
  `collected_amount` decimal(10,2) NOT NULL,
  `commission_amount` decimal(10,2) NOT NULL,
  `end_date` date NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL,
  `url` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `moneyboxes_category_id_foreign` (`category_id`),
  CONSTRAINT `moneyboxes_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moneyboxes`
--

LOCK TABLES `moneyboxes` WRITE;
/*!40000 ALTER TABLE `moneyboxes` DISABLE KEYS */;
INSERT INTO `moneyboxes` VALUES (1,7,1,'Alcancia de prueba no. 234567',1000.00,200.00,10.00,'2016-09-30','Alcancia para probar OXXO y SPEI',1,'f9a8826d8a336abd80a97a2e95321942','','2016-09-08 02:32:50','2016-09-08 02:40:15'),(2,7,2,'Marca de Ropa',10000.00,50.00,2.50,'2016-10-31','Este dinero va a ser un pequeño fondo para empezar un negocio nuevo.',1,'5fe6cfd9cfe1b6116bdd4c059ae50c87','','2016-09-08 12:10:40','2016-09-08 12:52:54'),(3,7,4,'Fiesta de despedida',5000.00,100.00,5.00,'2016-09-30','Fiesta de despedida para Pancho López',1,'40a2da2804856da6434640a4f2f98e60','','2016-09-09 00:55:29','2016-09-09 01:07:17'),(4,1,1,'Prueba movil',1000.00,50.00,2.50,'2016-09-30','Alcancía para ver las vistas en la versión movil',1,'22d90db7e00223a868b2f40b26b9ddc0','','2016-09-12 03:58:16','2016-09-12 03:59:27');
/*!40000 ALTER TABLE `moneyboxes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `clabe` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `account` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `bank_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `bank_address` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `comments` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `moneybox_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_moneybox_id_foreign` (`moneybox_id`),
  CONSTRAINT `orders_moneybox_id_foreign` FOREIGN KEY (`moneybox_id`) REFERENCES `moneyboxes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'Emmanuel Sanchez','','900009388-2388328','900009388','bancomer','Reforma Sur 129','Prueba de archivo adjunto.','',1,'2016-09-11 18:07:47','2016-09-11 18:07:47'),(2,'Daniel','','900009388-2388328','900009388','banorte','And. Santa Isabel Ed. E12 Depto2 Santa Lucia 4','Test 3','',1,'2016-09-11 18:17:38','2016-09-11 18:17:38');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participants`
--

DROP TABLE IF EXISTS `participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `participants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(10) unsigned NOT NULL,
  `moneybox_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `participants_person_id_foreign` (`person_id`),
  KEY `participants_moneybox_id_foreign` (`moneybox_id`),
  CONSTRAINT `participants_moneybox_id_foreign` FOREIGN KEY (`moneybox_id`) REFERENCES `moneyboxes` (`id`),
  CONSTRAINT `participants_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participants`
--

LOCK TABLES `participants` WRITE;
/*!40000 ALTER TABLE `participants` DISABLE KEYS */;
INSERT INTO `participants` VALUES (1,1,1,'2016-09-08 02:33:16','2016-09-08 02:33:16'),(2,2,2,'2016-09-08 12:48:36','2016-09-08 12:48:36'),(3,4,3,'2016-09-09 00:57:21','2016-09-09 00:57:21'),(4,1,4,'2016-09-12 03:58:54','2016-09-12 03:58:54');
/*!40000 ALTER TABLE `participants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(10) unsigned NOT NULL,
  `moneybox_id` int(10) unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `commission` decimal(10,2) NOT NULL,
  `uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `method` enum('P','O','S') COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('PENDING','CANCELED','PAYED') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_uid_unique` (`uid`),
  KEY `payments_person_id_foreign` (`person_id`),
  KEY `payments_moneybox_id_foreign` (`moneybox_id`),
  CONSTRAINT `payments_moneybox_id_foreign` FOREIGN KEY (`moneybox_id`) REFERENCES `moneyboxes` (`id`),
  CONSTRAINT `payments_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,1,100.00,5.00,'v6yrwHJ2Sl','O','PAYED','2016-09-08 02:35:44','2016-09-08 02:35:46'),(2,1,1,100.00,5.00,'bwPOpx26ma','S','PAYED','2016-09-08 02:40:12','2016-09-08 02:40:15'),(3,2,2,50.00,2.50,'EC-0L077388CM259811B','P','PAYED','2016-09-08 12:48:52','2016-09-08 12:52:54'),(4,4,3,50.00,2.50,'EC-7WA48540U1938610B','P','PENDING','2016-09-09 00:59:26','2016-09-09 00:59:26'),(5,4,3,50.00,2.50,'zp1lim5tB5','O','PAYED','2016-09-09 00:59:53','2016-09-09 00:59:53'),(6,4,3,50.00,2.50,'S2zh1cE8fo','S','PAYED','2016-09-09 01:00:08','2016-09-09 01:00:14'),(7,1,4,50.00,2.50,'8LFcqfw ry','O','PAYED','2016-09-12 03:59:19','2016-09-12 03:59:27');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persons`
--

DROP TABLE IF EXISTS `persons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `persons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `gender` enum('H','M') COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persons`
--

LOCK TABLES `persons` WRITE;
/*!40000 ALTER TABLE `persons` DISABLE KEYS */;
INSERT INTO `persons` VALUES (1,'Emmanuel','Sanchezz ','0000-00-00','H','2224819693','','','','2016-09-08 02:30:39','2016-09-08 02:33:16'),(2,'Efrain','Lazzeri','1988-07-23','H','2717070241','Puebla','MExico','','2016-09-08 11:31:15','2016-09-09 11:14:16'),(3,'Emmanuel','Sánchez Luna','0000-00-00','H','','','','','2016-09-08 17:17:56','2016-09-08 17:17:56'),(4,'César','Mejía','1986-01-31','H','2221564067','Puebla','México','','2016-09-09 00:49:09','2016-09-09 00:51:25'),(5,'Cesar','Mejia Guzman ','0000-00-00','H','','','','','2016-09-09 01:12:20','2016-09-09 01:12:20');
/*!40000 ALTER TABLE `persons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting_options`
--

DROP TABLE IF EXISTS `setting_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `setting_id` int(10) unsigned NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `subtype` enum('','text','radio','checkbox') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `setting_options_setting_id_foreign` (`setting_id`),
  CONSTRAINT `setting_options_setting_id_foreign` FOREIGN KEY (`setting_id`) REFERENCES `settings` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting_options`
--

LOCK TABLES `setting_options` WRITE;
/*!40000 ALTER TABLE `setting_options` DISABLE KEYS */;
INSERT INTO `setting_options` VALUES (1,1,'Libre','','2016-08-21 07:07:58','2016-08-21 07:07:58'),(2,1,'Sugerido','text','2016-08-21 07:08:20','2016-08-21 07:08:20'),(3,1,'Fijo','text','2016-08-21 07:08:30','2016-08-21 07:08:30'),(4,2,'Ocultar la identidad de los participantes','','2016-08-21 07:09:36','2016-08-21 07:09:36'),(5,2,'Ocultar el importe con el que colaboran los participantes','','2016-08-21 07:10:00','2016-08-21 07:10:00'),(6,2,'Ocultar el importe del bote','','2016-08-21 07:10:11','2016-08-21 07:10:11'),(7,3,'Visible: enseÃ±ar mi nombre y el monto con el que participo','','2016-08-27 20:59:25','2016-08-27 20:59:25'),(8,3,'Mostrar mi nombre y esconder el monto con el que participo','','2016-08-27 20:59:37','2016-08-27 20:59:37'),(9,3,'AnÃ³nimamente','','2016-08-27 20:59:53','2016-08-27 20:59:53');
/*!40000 ALTER TABLE `setting_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('text','radio','checkbox') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'Â¿CÃ³mo quiÃ©res que sea el monto de participaciÃ³n?','/moneybox','radio','2016-08-21 07:04:50','2016-08-21 07:04:50'),(2,'Opciones de privacidad','/moneybox','radio','2016-08-21 07:06:29','2016-08-21 07:06:29'),(3,' Hacer mi participaciÃ³n:','/participant','radio','2016-08-27 20:56:00','2016-08-27 20:56:00');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(10) unsigned NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `tracking` int(11) NOT NULL,
  `roles` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`),
  KEY `users_person_id_foreign` (`person_id`),
  CONSTRAINT `users_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'super_puma_05@hotmail.com','$2y$10$ktUG5hoFcm3OQ86nvkZbKOLpdEL6u1iSx8.cYd9W/BfIjNs.28iDW','super_puma_05@hotmail.com',1,'','zmlEJI2pnPFIYATlwBdqFKux12V8cNPliuH6P4BK77iSmSgS9OhG0Wrs4E1w','2016-09-08 02:30:39','2016-09-13 01:26:55'),(2,2,'efrain.lazzerim@gmail.com','$2y$10$keycuWPHmFLIBZBEulM3w.kXo2IPrM.FacaooRBXDkQ0.4oGuSzHq','efrain.lazzerim@gmail.com',1,'','JhtT9lTWBWvqnjQ9T8IcDbdGqB4h6rAAvyZzkWDDrHnoiE7a03WhJ2YD2wwH','2016-09-08 11:31:15','2016-09-09 16:29:05'),(3,3,'sanchezz985@gmail.com','$2y$10$EnZE2BeH5hex8cURKRY3TuCZPMxq3.INRajrnw.7EcmzfJzYtuOGe','sanchezz985@gmail.com',1,'','94k5UjYedsJvyNNNjLGOqU66qR6lnPgGhxUrtA4cQLs7KUBe2gAaxacFnGPe','2016-09-08 17:17:56','2016-09-09 16:15:30'),(4,4,'iconfidence@gmail.com','$2y$10$0g/Ex8IayO/gMyum7PxDjOnE50QPkfe1oRuh7WetzO1y5v6e8NBh6','cesarmejia',1,'','dKtdGYrePXRGMp485b5XTKKC5iHjAqNMgxHSmSyQPZK10ih45WcrWmNKk9Ci','2016-09-09 00:49:09','2016-09-09 01:17:15'),(5,5,'liquid_zk@hotmail.com','','liquid_zk@hotmail.com',0,'','iPmLzUiYPtBvshilzdXrkScNP5Y3Z7o8oGogfytQjgaZHjQeDXKdY7G15Bdd','2016-09-09 01:12:20','2016-09-09 01:13:15');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'coperacha'
--

--
-- Dumping routines for database 'coperacha'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-09-16  7:12:02
