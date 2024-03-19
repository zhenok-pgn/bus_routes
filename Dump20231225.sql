-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: citybusroutes
-- ------------------------------------------------------
-- Server version	8.2.0

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
-- Table structure for table `bus_class`
--

DROP TABLE IF EXISTS `bus_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bus_class` (
  `bus_class_id` int NOT NULL AUTO_INCREMENT,
  `bus_class_name` varchar(20) NOT NULL,
  `bus_class_capacity` tinyint unsigned NOT NULL,
  PRIMARY KEY (`bus_class_id`),
  UNIQUE KEY `bus_class_name` (`bus_class_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bus_class`
--

LOCK TABLES `bus_class` WRITE;
/*!40000 ALTER TABLE `bus_class` DISABLE KEYS */;
INSERT INTO `bus_class` VALUES (1,'особо малый',10),(2,'малый',25),(3,'средний',50),(4,'большой',80),(5,'особо большой',120);
/*!40000 ALTER TABLE `bus_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bus_depot`
--

DROP TABLE IF EXISTS `bus_depot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bus_depot` (
  `bus_class_id` int NOT NULL,
  `route_id` int NOT NULL,
  PRIMARY KEY (`bus_class_id`,`route_id`),
  KEY `FK_Route` (`route_id`),
  CONSTRAINT `FK_BusClass` FOREIGN KEY (`bus_class_id`) REFERENCES `bus_class` (`bus_class_id`),
  CONSTRAINT `FK_Route` FOREIGN KEY (`route_id`) REFERENCES `route` (`route_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bus_depot`
--

LOCK TABLES `bus_depot` WRITE;
/*!40000 ALTER TABLE `bus_depot` DISABLE KEYS */;
INSERT INTO `bus_depot` VALUES (3,1),(4,1),(3,29),(4,29),(1,66),(3,66),(2,71),(1,82),(2,82),(3,85),(4,85);
/*!40000 ALTER TABLE `bus_depot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bus_direction`
--

DROP TABLE IF EXISTS `bus_direction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bus_direction` (
  `bus_direction_id` int NOT NULL AUTO_INCREMENT,
  `bus_direction_name` varchar(20) NOT NULL,
  PRIMARY KEY (`bus_direction_id`),
  UNIQUE KEY `bus_direction_name` (`bus_direction_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bus_direction`
--

LOCK TABLES `bus_direction` WRITE;
/*!40000 ALTER TABLE `bus_direction` DISABLE KEYS */;
INSERT INTO `bus_direction` VALUES (2,'Обратное'),(1,'Прямое');
/*!40000 ALTER TABLE `bus_direction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bus_stop`
--

DROP TABLE IF EXISTS `bus_stop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bus_stop` (
  `bus_stop_id` int NOT NULL AUTO_INCREMENT,
  `city_code` bigint unsigned NOT NULL,
  `bus_stop_name` varchar(40) NOT NULL,
  `bus_stop_address` varchar(255) NOT NULL,
  PRIMARY KEY (`bus_stop_id`),
  UNIQUE KEY `UC_BusStop` (`bus_stop_name`,`bus_stop_address`),
  KEY `FK_City_idx` (`city_code`),
  CONSTRAINT `FK_CityBusStop` FOREIGN KEY (`city_code`) REFERENCES `city` (`city_code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bus_stop`
--

LOCK TABLES `bus_stop` WRITE;
/*!40000 ALTER TABLE `bus_stop` DISABLE KEYS */;
INSERT INTO `bus_stop` VALUES (1,94701000001,'ул. Труда','г.Ижевск, ул.Труда'),(2,94701000001,'Проспект имени Калашникова','г.Ижевск, ул.Молодежная'),(3,94701000001,'Парк имени Кирова','г.Ижевск, ул.Кирова'),(4,94701000001,'Сельхозакадемия','г.Ижевск, ул.30 лет победы'),(5,94701000001,'4-я Подлесная улица','г.Ижевск, ул.30 лет победы'),(6,94701000001,'Спортивная','г. Ижевск, ул. Молодежная');
/*!40000 ALTER TABLE `bus_stop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bus_stop_schedule`
--

DROP TABLE IF EXISTS `bus_stop_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bus_stop_schedule` (
  `bus_stop_schedule_id` int NOT NULL AUTO_INCREMENT,
  `route_execution_id` int NOT NULL,
  `bus_stop_id` int NOT NULL,
  `arriving_time` datetime NOT NULL,
  PRIMARY KEY (`bus_stop_schedule_id`),
  UNIQUE KEY `UC_BusStopSchedule` (`route_execution_id`,`bus_stop_id`),
  KEY `FK_BusStop` (`bus_stop_id`),
  CONSTRAINT `FK_BusStop` FOREIGN KEY (`bus_stop_id`) REFERENCES `bus_stop` (`bus_stop_id`),
  CONSTRAINT `FK_RouteExecution` FOREIGN KEY (`route_execution_id`) REFERENCES `route_execution` (`route_execution_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bus_stop_schedule`
--

LOCK TABLES `bus_stop_schedule` WRITE;
/*!40000 ALTER TABLE `bus_stop_schedule` DISABLE KEYS */;
INSERT INTO `bus_stop_schedule` VALUES (10,6,2,'2023-12-12 19:46:00'),(12,15,3,'2023-12-16 06:40:00'),(13,15,4,'2023-12-16 06:45:00'),(14,15,5,'2023-12-16 06:50:00');
/*!40000 ALTER TABLE `bus_stop_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrier`
--

DROP TABLE IF EXISTS `carrier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrier` (
  `carrier_ogrn` bigint unsigned NOT NULL,
  `carrier_inn` bigint(10) unsigned zerofill NOT NULL,
  `carrier_name` varchar(255) NOT NULL,
  `carrier_address` varchar(255) NOT NULL,
  `carrier_phone` bigint unsigned DEFAULT NULL,
  `carrier_email` varchar(40) DEFAULT NULL,
  `carrier_website` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`carrier_ogrn`),
  UNIQUE KEY `carrier_inn` (`carrier_inn`),
  UNIQUE KEY `carrier_name` (`carrier_name`),
  CONSTRAINT `CHK_Inn` CHECK ((`carrier_inn` between 100000000 and 9999999999)),
  CONSTRAINT `CHK_Ogrn` CHECK (((`carrier_ogrn` between 1000000000000 and 1999999999999) or (`carrier_ogrn` between 5000000000000 and 5999999999999))),
  CONSTRAINT `CHK_Phone` CHECK ((`carrier_phone` between 80000000000 and 89999999999))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrier`
--

LOCK TABLES `carrier` WRITE;
/*!40000 ALTER TABLE `carrier` DISABLE KEYS */;
INSERT INTO `carrier` VALUES (1131841001665,1841032010,'ООО \"Автосила\"','Удмуртская Республика, город Ижевск, ул. Ключевой поселок, д.11-а ',NULL,NULL,NULL),(5111111111111,1833046700,'АКЦИОНЕРНОЕ ОБЩЕСТВО \"ИЖЕВСКОЕ ПРОИЗВОДСТВЕННОЕ ОБЪЕДИНЕНИЕ ПАССАЖИРСКОГО АВТОТРАНСПОРТА\"','Удмуртская респ., г. Ижевск, ул. Буммашевская, д. ЗД. 5',83412452125,'atp2@nivad.ru','http://www.ипопат.рф/');
/*!40000 ALTER TABLE `carrier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `city` (
  `city_code` bigint(11) unsigned zerofill NOT NULL,
  `city_name` varchar(40) NOT NULL,
  PRIMARY KEY (`city_code`),
  CONSTRAINT `CHK_CityCode` CHECK ((`city_code` between 1000000000 and 99999999999))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `city`
--

LOCK TABLES `city` WRITE;
/*!40000 ALTER TABLE `city` DISABLE KEYS */;
INSERT INTO `city` VALUES (18701000001,'Волгоград'),(22701000001,'Нижний Новгород'),(36701000001,'Самара'),(40000000000,'Санкт-Петербург'),(45000000000,'Москва'),(52701000001,'Омск'),(57701000001,'Пермь'),(88701000001,'Йошкар-Ола'),(92701000000,'Казань'),(92730000001,'Набережные Челны'),(94701000001,'Ижевск');
/*!40000 ALTER TABLE `city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_method`
--

DROP TABLE IF EXISTS `payment_method`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_method` (
  `payment_method_id` int NOT NULL AUTO_INCREMENT,
  `payment_method_name` varchar(20) NOT NULL,
  PRIMARY KEY (`payment_method_id`),
  UNIQUE KEY `payment_method_name` (`payment_method_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_method`
--

LOCK TABLES `payment_method` WRITE;
/*!40000 ALTER TABLE `payment_method` DISABLE KEYS */;
INSERT INTO `payment_method` VALUES (2,'Банковская карта'),(1,'Наличные');
/*!40000 ALTER TABLE `payment_method` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `route`
--

DROP TABLE IF EXISTS `route`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `route` (
  `route_id` int NOT NULL AUTO_INCREMENT,
  `carrier_ogrn` bigint unsigned NOT NULL,
  `city_code` bigint(11) unsigned zerofill NOT NULL,
  `route_number` varchar(20) NOT NULL,
  `route_name` varchar(255) NOT NULL,
  PRIMARY KEY (`route_id`),
  UNIQUE KEY `UC_Route` (`route_number`,`route_name`),
  UNIQUE KEY `UC_CityRouteNumber` (`route_number`,`city_code`),
  KEY `FK_City` (`city_code`),
  KEY `FK_Carrier` (`carrier_ogrn`),
  CONSTRAINT `FK_Carrier` FOREIGN KEY (`carrier_ogrn`) REFERENCES `carrier` (`carrier_ogrn`),
  CONSTRAINT `FK_City` FOREIGN KEY (`city_code`) REFERENCES `city` (`city_code`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `route`
--

LOCK TABLES `route` WRITE;
/*!40000 ALTER TABLE `route` DISABLE KEYS */;
INSERT INTO `route` VALUES (1,5111111111111,94701000001,'2','Собор Александра невского - Медведево'),(29,5111111111111,94701000001,'79','Улица Архитектора Берша  - Сельхозакадемия'),(66,5111111111111,94701000001,'6','Собор Александра Невского  - Микрорайон '),(71,1131841001665,94701000001,'49','Оранжерейный комплекс  - Ижевск, Транссельхозтехника'),(82,1131841001665,94701000001,'30','Центр - Край'),(85,5111111111111,94701000001,'29','Парк имени Кирова - Рембыттехника');
/*!40000 ALTER TABLE `route` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `route_execution`
--

DROP TABLE IF EXISTS `route_execution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `route_execution` (
  `route_execution_id` int NOT NULL AUTO_INCREMENT,
  `route_id` int NOT NULL,
  `bus_direction_id` int NOT NULL,
  `route_execution_time` datetime NOT NULL,
  PRIMARY KEY (`route_execution_id`),
  UNIQUE KEY `UC_RouteExecution` (`route_id`,`bus_direction_id`,`route_execution_time`),
  KEY `FK_BusDirection` (`bus_direction_id`),
  CONSTRAINT `FK_BusDirection` FOREIGN KEY (`bus_direction_id`) REFERENCES `bus_direction` (`bus_direction_id`),
  CONSTRAINT `FK_BusRoute` FOREIGN KEY (`route_id`) REFERENCES `route` (`route_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `route_execution`
--

LOCK TABLES `route_execution` WRITE;
/*!40000 ALTER TABLE `route_execution` DISABLE KEYS */;
INSERT INTO `route_execution` VALUES (2,1,1,'2023-12-10 15:10:00'),(3,1,1,'2023-12-10 15:35:00'),(4,1,1,'2023-12-11 14:00:00'),(6,1,1,'2023-12-12 14:36:00'),(7,1,1,'2023-12-12 15:36:00'),(8,1,1,'2023-12-12 17:36:00'),(15,85,1,'2023-12-16 06:40:00'),(16,85,1,'2023-12-16 06:50:00'),(17,85,1,'2023-12-16 07:00:00'),(18,85,1,'2023-12-16 07:20:00'),(19,85,1,'2023-12-16 07:40:00');
/*!40000 ALTER TABLE `route_execution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `route_price`
--

DROP TABLE IF EXISTS `route_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `route_price` (
  `route_id` int NOT NULL,
  `payment_method_id` int NOT NULL,
  `price` smallint unsigned NOT NULL,
  PRIMARY KEY (`route_id`,`payment_method_id`),
  KEY `FK_PaymentMethod` (`payment_method_id`),
  CONSTRAINT `FK_PaymentMethod` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_method` (`payment_method_id`),
  CONSTRAINT `FK_RoutePayment` FOREIGN KEY (`route_id`) REFERENCES `route` (`route_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `route_price`
--

LOCK TABLES `route_price` WRITE;
/*!40000 ALTER TABLE `route_price` DISABLE KEYS */;
INSERT INTO `route_price` VALUES (1,1,32),(1,2,32),(29,1,32),(29,2,30),(66,1,32),(66,2,30),(71,1,30),(82,1,30),(85,1,32),(85,2,30);
/*!40000 ALTER TABLE `route_price` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-25 19:35:54
