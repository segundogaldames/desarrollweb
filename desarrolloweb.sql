-- MySQL dump 10.13  Distrib 5.7.26, for osx10.9 (x86_64)
--
-- Host: localhost    Database: desarrolloweb
-- ------------------------------------------------------
-- Server version	5.7.26

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
-- Table structure for table `atributos`
--

DROP TABLE IF EXISTS `atributos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atributos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atributos`
--

LOCK TABLES `atributos` WRITE;
/*!40000 ALTER TABLE `atributos` DISABLE KEYS */;
/*!40000 ALTER TABLE `atributos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comunas`
--

DROP TABLE IF EXISTS `comunas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comunas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `region_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `region` (`region_id`),
  CONSTRAINT `comunas_ibfk_1` FOREIGN KEY (`region_id`) REFERENCES `regiones` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comunas`
--

LOCK TABLES `comunas` WRITE;
/*!40000 ALTER TABLE `comunas` DISABLE KEYS */;
INSERT INTO `comunas` VALUES (1,'Santiago',1,'2021-05-14 11:30:48','2021-05-14 11:30:48'),(2,'Padre Las Casas',3,'2021-05-14 11:46:33','2021-05-14 11:46:33'),(3,'Puente Alto',1,'2021-05-14 11:46:59','2021-05-14 11:46:59'),(4,'Las Condes',1,'2021-05-14 11:47:11','2021-05-14 11:47:11'),(5,'Curico',5,'2021-05-28 11:20:52','2021-05-28 11:28:53');
/*!40000 ALTER TABLE `comunas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marcas`
--

DROP TABLE IF EXISTS `marcas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marcas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marcas`
--

LOCK TABLES `marcas` WRITE;
/*!40000 ALTER TABLE `marcas` DISABLE KEYS */;
/*!40000 ALTER TABLE `marcas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_tipos`
--

DROP TABLE IF EXISTS `producto_tipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto_tipos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_tipos`
--

LOCK TABLES `producto_tipos` WRITE;
/*!40000 ALTER TABLE `producto_tipos` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto_tipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regiones`
--

DROP TABLE IF EXISTS `regiones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regiones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regiones`
--

LOCK TABLES `regiones` WRITE;
/*!40000 ALTER TABLE `regiones` DISABLE KEYS */;
INSERT INTO `regiones` VALUES (1,'Metropolitana de Santiago','2021-05-07 11:09:16','2021-05-07 11:09:16'),(2,'De Los Rios','2021-05-07 11:22:48','2021-05-07 11:38:55'),(3,'De la Araucanía','2021-05-14 10:53:52','2021-05-14 10:53:52'),(4,'De Valparaiso','2021-05-28 10:18:04','2021-05-28 10:27:26'),(5,'Del Maule','2021-05-28 11:21:23','2021-05-28 11:28:33');
/*!40000 ALTER TABLE `regiones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Cliente','2021-04-16 11:50:46','2021-04-23 21:40:55'),(2,'Administrador','2021-04-16 11:51:56','2021-04-30 11:36:23'),(3,'Supervisor','2021-04-16 11:57:12','2021-04-16 11:57:12'),(4,'Vendedor','2021-04-16 12:01:45','2021-04-16 12:01:45');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-06-04  8:16:11
