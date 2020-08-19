-- MySQL dump 10.13  Distrib 5.7.31, for Linux (x86_64)
--
-- Host: localhost    Database: magazynit
-- ------------------------------------------------------
-- Server version	5.7.31

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
-- Current Database: `magazynit`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `magazynit` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `magazynit`;

--
-- Table structure for table `hist`
--

DROP TABLE IF EXISTS `hist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `urz_id` int(11) NOT NULL,
  `typ_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `lok_id` int(11) NOT NULL,
  `sn` varchar(20) NOT NULL,
  `sn2` varchar(30) DEFAULT NULL,
  `stan` enum('S','N') NOT NULL,
  `serwis` tinyint(1) NOT NULL,
  `opis` varchar(255) NOT NULL,
  `rez` tinyint(1) NOT NULL,
  `fv` tinyint(1) NOT NULL,
  `utyl` tinyint(1) DEFAULT '0',
  `czas_op` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lokalizacja`
--

DROP TABLE IF EXISTS `lokalizacja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lokalizacja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(40) NOT NULL,
  `skrot` varchar(10) NOT NULL,
  `widoczna` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `skrot` (`skrot`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `model`
--

DROP TABLE IF EXISTS `model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nazwa` (`nazwa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `typ`
--

DROP TABLE IF EXISTS `typ`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `typ` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nazwa` (`nazwa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `uzytkownik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uzytkownik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `haslo` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prot_urz`
--

DROP TABLE IF EXISTS `prot_urz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prot_urz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `protokol_id` int(11) NOT NULL,
  `urzadzenie_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `urzadzenie_id` (`urzadzenie_id`),
  KEY `protokol_id` (`protokol_id`),
  CONSTRAINT `prot_urz_ibfk_1` FOREIGN KEY (`urzadzenie_id`) REFERENCES `urzadzenie` (`id`),
  CONSTRAINT `prot_urz_ibfk_2` FOREIGN KEY (`protokol_id`) REFERENCES `protokol` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `protokol`
--

DROP TABLE IF EXISTS `protokol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `protokol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lok_id` int(11) NOT NULL,
  `uzytkownik_id` int(11) NOT NULL,
  `osoba` varchar(100) DEFAULT NULL,
  `poz_urz` varchar(255) DEFAULT NULL,
  `data` date NOT NULL,
  `wro` tinyint(1) NOT NULL,
  `zlecajacy` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lok_id` (`lok_id`),
  KEY `uzytkownik_id` (`uzytkownik_id`),
  CONSTRAINT `protokol_ibfk_1` FOREIGN KEY (`lok_id`) REFERENCES `lokalizacja` (`id`),
  CONSTRAINT `protokol_ibfk_2` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownik` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `urzadzenie`
--

DROP TABLE IF EXISTS `urzadzenie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `urzadzenie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typ_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `lok_id` int(11) NOT NULL,
  `sn` varchar(30) NOT NULL,
  `sn2` varchar(30) DEFAULT NULL,
  `stan` enum('S','N') NOT NULL,
  `serwis` tinyint(1) NOT NULL,
  `opis` varchar(255) NOT NULL,
  `rez` tinyint(1) NOT NULL DEFAULT '0',
  `fv` tinyint(1) NOT NULL,
  `utyl` tinyint(1) DEFAULT '0',
  `czas_op` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sn` (`sn`),
  KEY `typ_id` (`typ_id`),
  KEY `model_id` (`model_id`),
  KEY `lok_id` (`lok_id`),
  CONSTRAINT `urzadzenie_ibfk_1` FOREIGN KEY (`typ_id`) REFERENCES `typ` (`id`),
  CONSTRAINT `urzadzenie_ibfk_2` FOREIGN KEY (`model_id`) REFERENCES `model` (`id`),
  CONSTRAINT `urzadzenie_ibfk_3` FOREIGN KEY (`lok_id`) REFERENCES `lokalizacja` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'magazynit'
--
/*!50003 DROP PROCEDURE IF EXISTS `changeProtLoc` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `changeProtLoc`(in lok_s varchar(10), in prot_id int)
begin
declare id_lok int;
declare id_urz int;
declare finished int default 0;
declare curUrz cursor for select urzadzenie_id from prot_urz where protokol_id=prot_id;
declare continue handler for not found set finished=1;
select id into id_lok from lokalizacja where skrot=lok_s;
select * from protokol where id=prot_id for update;
update protokol set lok_id=id_lok where id=prot_id;
open curUrz;
updateUrz: loop
	fetch curUrz into id_urz;
    if finished = 1 then
		leave updateUrz;
	end if;
    select * from urzadzenie where id=id_urz for update;
    update urzadzenie set lok_id=id_lok where id=id_urz;
end loop;
close curUrz;
commit;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `changeStan` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `changeStan`(
	IN `urz_id` int,
	IN `nowy_opis` VARCHAR(255)
)
BEGIN
	DECLARE s CHAR(1);
		SELECT stan INTO s FROM urzadzenie WHERE urzadzenie.id = urz_id for update;
		IF s = 'S' THEN
			UPDATE urzadzenie SET stan='N', opis=nowy_opis WHERE urzadzenie.id=urz_id;
			COMMIT;
		ELSEIF s = 'N' THEN
			UPDATE urzadzenie SET stan='S', opis=nowy_opis WHERE id=urz_id;
			COMMIT;
		ELSE ROLLBACK;
		END IF;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `change_prot_dev` */;
ALTER DATABASE `magazynit` CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `change_prot_dev`(in sn_er varchar(30), in skrot_lok varchar(10), in sn_ok varchar(30), in prot_id int)
begin
declare id_urz_er int;
declare id_lok int;
declare id_urz_ok int;
select id into id_urz_er from urzadzenie where sn like sn_er;
select id into id_lok from lokalizacja where skrot like skrot_lok;
select id into id_urz_ok from urzadzenie where sn like sn_ok;
update urzadzenie set lok_id=1 where id=id_urz_er;
update urzadzenie set lok_id=id_lok where id=id_urz_ok;
update prot_urz set urzadzenie_id=id_urz_ok where protokol_id=prot_id and urzadzenie_id=id_urz_er;
commit;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `magazynit` CHARACTER SET utf8 COLLATE utf8_general_ci ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-19  3:00:01
