CREATE USER slave_read_user@'%' IDENTIFIED WITH mysql_native_password BY 'xSc1jnBR6r8GW9gQgNvdKsVqGDqm5l';
GRANT REPLICATION SLAVE ON *.* TO slave_read_user@'%';
FLUSH PRIVILEGES;


--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `types` (
                         `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                         `title` varchar(255) NOT NULL,
                         `mask` varchar(255) DEFAULT NULL,
                         PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Заказы';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types`
--

LOCK TABLES `types` WRITE;
/*!40000 ALTER TABLE `types` DISABLE KEYS */;
INSERT INTO `types` VALUES (1,'TP-Link TL-WR74','XXAAAAAXAA'),(2,'D-Link DIR-300','NXXAAXZXaa'), (3,'D-Link DIR-300 S','NXXAAXZXXX');
/*!40000 ALTER TABLE `types` ENABLE KEYS */;
UNLOCK TABLES;
--
-- Table structure for table `equipment`
--

DROP TABLE IF EXISTS `equipment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipment` (
                             `id` int unsigned NOT NULL AUTO_INCREMENT,
                             `type_id` bigint unsigned NOT NULL,
                             `serial` varchar(255) NOT NULL UNIQUE,
                             PRIMARY KEY (`id`),
                             KEY `type_id` (`type_id`),
                             CONSTRAINT `equipment_type_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment`
--
#
# LOCK TABLES `equipment` WRITE;
# /*!40000 ALTER TABLE `equipment` DISABLE KEYS */;
# INSERT INTO `equipment` VALUES (1,1,'Pjotr','hren','2021-10-18 17:32:11',NULL,'41kbm6as401pi09tlcg12kn2oa',100009),;
# /*!40000 ALTER TABLE `equipment` ENABLE KEYS */;
# UNLOCK TABLES;
