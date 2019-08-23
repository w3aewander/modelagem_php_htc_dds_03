-- MySQL dump 10.13  Distrib 5.7.27, for Linux (x86_64)
--
-- Host: localhost    Database: HTC_DDS_03
-- ------------------------------------------------------
-- Server version	5.7.27-0ubuntu0.18.04.1

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
-- Current Database: `HTC_DDS_03`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `HTC_DDS_03` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `HTC_DDS_03`;

--
-- Table structure for table `ALUNOS`
--

DROP TABLE IF EXISTS `ALUNOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ALUNOS` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `turma_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `turma_id` (`turma_id`),
  CONSTRAINT `ALUNOS_ibfk_1` FOREIGN KEY (`turma_id`) REFERENCES `TURMA` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ALUNOS`
--

LOCK TABLES `ALUNOS` WRITE;
/*!40000 ALTER TABLE `ALUNOS` DISABLE KEYS */;
INSERT INTO `ALUNOS` VALUES (2,'Wanderlei',1),(3,'Victor Henrique',1),(4,'Klayton',1),(5,'Igor Maurilio',1),(6,'Igor Pinheiro',1),(7,'Victor Corassa',1),(8,'Pablo',1);
/*!40000 ALTER TABLE `ALUNOS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `DISCIPLINA`
--

DROP TABLE IF EXISTS `DISCIPLINA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DISCIPLINA` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DISCIPLINA`
--

LOCK TABLES `DISCIPLINA` WRITE;
/*!40000 ALTER TABLE `DISCIPLINA` DISABLE KEYS */;
INSERT INTO `DISCIPLINA` VALUES (1,'BANCO DE DADOS','2019-08-20 00:28:35'),(2,'MODELAGEM DE SISTEMAS','2019-08-20 00:28:35'),(18,'DESENVOLVIMENTO WEB','2019-08-21 23:32:02'),(19,'SISTEMAS OPERACIONAIS','2019-08-21 23:32:02'),(20,'FUNDAMENTOS DE TI E COM.','2019-08-21 23:32:02'),(21,'ANALISE TEXTUAL','2019-08-21 23:32:02'),(22,'LÓGICA DE PROGRAMAÇÃO','2019-08-21 23:32:02');
/*!40000 ALTER TABLE `DISCIPLINA` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PROFESSOR`
--

DROP TABLE IF EXISTS `PROFESSOR`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PROFESSOR` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PROFESSOR`
--

LOCK TABLES `PROFESSOR` WRITE;
/*!40000 ALTER TABLE `PROFESSOR` DISABLE KEYS */;
INSERT INTO `PROFESSOR` VALUES (1,'MARLY'),(2,'WANDERLEI SILVA'),(3,'THALISON'),(4,'ROBSON'),(5,'RUBENS');
/*!40000 ALTER TABLE `PROFESSOR` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PROFESSOR_DISCIPLINA`
--

DROP TABLE IF EXISTS `PROFESSOR_DISCIPLINA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PROFESSOR_DISCIPLINA` (
  `professor_id` int(11) NOT NULL,
  `disciplina_id` int(11) NOT NULL,
  PRIMARY KEY (`professor_id`,`disciplina_id`),
  KEY `disciplina_id` (`disciplina_id`),
  CONSTRAINT `PROFESSOR_DISCIPLINA_ibfk_1` FOREIGN KEY (`professor_id`) REFERENCES `PROFESSOR` (`id`),
  CONSTRAINT `PROFESSOR_DISCIPLINA_ibfk_2` FOREIGN KEY (`disciplina_id`) REFERENCES `DISCIPLINA` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PROFESSOR_DISCIPLINA`
--

LOCK TABLES `PROFESSOR_DISCIPLINA` WRITE;
/*!40000 ALTER TABLE `PROFESSOR_DISCIPLINA` DISABLE KEYS */;
INSERT INTO `PROFESSOR_DISCIPLINA` VALUES (2,1),(2,2),(2,19),(2,20),(1,21);
/*!40000 ALTER TABLE `PROFESSOR_DISCIPLINA` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TURMA`
--

DROP TABLE IF EXISTS `TURMA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TURMA` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TURMA`
--

LOCK TABLES `TURMA` WRITE;
/*!40000 ALTER TABLE `TURMA` DISABLE KEYS */;
INSERT INTO `TURMA` VALUES (1,'HTC_DDS_03');
/*!40000 ALTER TABLE `TURMA` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TURMA_DISCIPLINA`
--

DROP TABLE IF EXISTS `TURMA_DISCIPLINA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TURMA_DISCIPLINA` (
  `turma_id` int(11) NOT NULL,
  `disciplina_id` int(11) NOT NULL,
  PRIMARY KEY (`turma_id`,`disciplina_id`),
  KEY `fk_disciplina_id` (`disciplina_id`),
  CONSTRAINT `fk_disciplina_id` FOREIGN KEY (`disciplina_id`) REFERENCES `DISCIPLINA` (`id`),
  CONSTRAINT `fk_turma_id` FOREIGN KEY (`turma_id`) REFERENCES `TURMA` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TURMA_DISCIPLINA`
--

LOCK TABLES `TURMA_DISCIPLINA` WRITE;
/*!40000 ALTER TABLE `TURMA_DISCIPLINA` DISABLE KEYS */;
/*!40000 ALTER TABLE `TURMA_DISCIPLINA` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `VIEW_PROFESSOR_DISCIPLINA`
--

DROP TABLE IF EXISTS `VIEW_PROFESSOR_DISCIPLINA`;
/*!50001 DROP VIEW IF EXISTS `VIEW_PROFESSOR_DISCIPLINA`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `VIEW_PROFESSOR_DISCIPLINA` AS SELECT 
 1 AS `ProfessorID`,
 1 AS `Professor`,
 1 AS `Disciplina`*/;
SET character_set_client = @saved_cs_client;

--
-- Current Database: `HTC_DDS_03`
--

USE `HTC_DDS_03`;

--
-- Final view structure for view `VIEW_PROFESSOR_DISCIPLINA`
--

/*!50001 DROP VIEW IF EXISTS `VIEW_PROFESSOR_DISCIPLINA`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `VIEW_PROFESSOR_DISCIPLINA` AS select `p`.`id` AS `ProfessorID`,`p`.`nome` AS `Professor`,`d`.`nome` AS `Disciplina` from ((`PROFESSOR` `p` join `PROFESSOR_DISCIPLINA` `pd` on((`p`.`id` = `pd`.`professor_id`))) join `DISCIPLINA` `d` on((`d`.`id` = `pd`.`disciplina_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-08-22 20:44:37
