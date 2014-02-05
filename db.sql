CREATE DATABASE  IF NOT EXISTS `ilpclelang` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `ilpclelang`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: localhost    Database: ilpclelang
-- ------------------------------------------------------
-- Server version	5.6.14

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
-- Table structure for table `barang`
--

DROP TABLE IF EXISTS `barang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(255) NOT NULL,
  `harga_awal` int(11) NOT NULL,
  `harga_sekarang` int(11) NOT NULL,
  `nilai_turun` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang`
--

LOCK TABLES `barang` WRITE;
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coba`
--

DROP TABLE IF EXISTS `coba`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coba` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl1` datetime NOT NULL,
  `tgl2` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coba`
--

LOCK TABLES `coba` WRITE;
/*!40000 ALTER TABLE `coba` DISABLE KEYS */;
/*!40000 ALTER TABLE `coba` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_customer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_lelang_jual`
--

DROP TABLE IF EXISTS `detail_lelang_jual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_lelang_jual` (
  `lelang_jual_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  PRIMARY KEY (`lelang_jual_id`,`barang_id`),
  KEY `fk_lelang_jual_customer_has_barang_barang1_idx` (`barang_id`),
  KEY `fk_lelang_jual_customer_has_barang_lelang_jual_customer1_idx` (`lelang_jual_id`),
  CONSTRAINT `fk_lelang_jual_customer_has_barang_lelang_jual_customer1` FOREIGN KEY (`lelang_jual_id`) REFERENCES `lelang_jual_customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_lelang_jual_customer_has_barang_barang1` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_lelang_jual`
--

LOCK TABLES `detail_lelang_jual` WRITE;
/*!40000 ALTER TABLE `detail_lelang_jual` DISABLE KEYS */;
/*!40000 ALTER TABLE `detail_lelang_jual` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history_beli`
--

DROP TABLE IF EXISTS `history_beli`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history_beli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jam` datetime NOT NULL,
  `jumlah` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_history_beli_barang1_idx` (`barang_id`),
  KEY `fk_history_beli_user1_idx` (`user_id`),
  CONSTRAINT `fk_history_beli_barang1` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_history_beli_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=459 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history_beli`
--

LOCK TABLES `history_beli` WRITE;
/*!40000 ALTER TABLE `history_beli` DISABLE KEYS */;
/*!40000 ALTER TABLE `history_beli` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history_fluktuasi`
--

DROP TABLE IF EXISTS `history_fluktuasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history_fluktuasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `harga_jual` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `barang_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_history_fluktuasi_barang1_idx` (`barang_id`),
  CONSTRAINT `fk_history_fluktuasi_barang1` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1657 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history_fluktuasi`
--

LOCK TABLES `history_fluktuasi` WRITE;
/*!40000 ALTER TABLE `history_fluktuasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `history_fluktuasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history_modal`
--

DROP TABLE IF EXISTS `history_modal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history_modal` (
  `pos_ilpc_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `waktu` datetime DEFAULT NULL,
  `status` enum('1','2','3') DEFAULT NULL,
  PRIMARY KEY (`pos_ilpc_id`,`user_id`),
  KEY `fk_pos_ilpc_has_user_user1_idx` (`user_id`),
  KEY `fk_pos_ilpc_has_user_pos_ilpc1_idx` (`pos_ilpc_id`),
  CONSTRAINT `fk_pos_ilpc_has_user_pos_ilpc1` FOREIGN KEY (`pos_ilpc_id`) REFERENCES `pos_ilpc` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pos_ilpc_has_user_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history_modal`
--

LOCK TABLES `history_modal` WRITE;
/*!40000 ALTER TABLE `history_modal` DISABLE KEYS */;
/*!40000 ALTER TABLE `history_modal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lelang_jual_customer`
--

DROP TABLE IF EXISTS `lelang_jual_customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lelang_jual_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_lelang` text NOT NULL,
  `judul_lelang` varchar(255) NOT NULL,
  `budget` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `jumlah` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `season_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lelang_jual_customer_customer1_idx` (`customer_id`),
  KEY `fk_lelang_jual_customer_season1_idx` (`season_id`),
  CONSTRAINT `fk_lelang_jual_customer_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_lelang_jual_customer_season1` FOREIGN KEY (`season_id`) REFERENCES `season` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lelang_jual_customer`
--

LOCK TABLES `lelang_jual_customer` WRITE;
/*!40000 ALTER TABLE `lelang_jual_customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `lelang_jual_customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `berita` text NOT NULL,
  `time` datetime DEFAULT NULL,
  `panitia_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_news_panitia1_idx` (`panitia_id`),
  CONSTRAINT `fk_news_panitia1` FOREIGN KEY (`panitia_id`) REFERENCES `panitia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `panitia`
--

DROP TABLE IF EXISTS `panitia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `panitia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `panitia`
--

LOCK TABLES `panitia` WRITE;
/*!40000 ALTER TABLE `panitia` DISABLE KEYS */;
/*!40000 ALTER TABLE `panitia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pos_ilpc`
--

DROP TABLE IF EXISTS `pos_ilpc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pos_ilpc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pos` varchar(255) NOT NULL,
  `jenis_pos` enum('programming','logika','games') NOT NULL,
  `sertifikat_menang` int(11) NOT NULL,
  `sertifikat_kalah` int(11) NOT NULL,
  `uang_menang` int(11) NOT NULL,
  `uang_kalah` int(11) NOT NULL,
  `panitia_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pos_ilpc_panitia1_idx` (`panitia_id`),
  CONSTRAINT `fk_pos_ilpc_panitia1` FOREIGN KEY (`panitia_id`) REFERENCES `panitia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pos_ilpc`
--

LOCK TABLES `pos_ilpc` WRITE;
/*!40000 ALTER TABLE `pos_ilpc` DISABLE KEYS */;
/*!40000 ALTER TABLE `pos_ilpc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `season`
--

DROP TABLE IF EXISTS `season`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `season` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aktif` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `season`
--

LOCK TABLES `season` WRITE;
/*!40000 ALTER TABLE `season` DISABLE KEYS */;
/*!40000 ALTER TABLE `season` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `jumlahuang` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL COMMENT '0->tidak login, 1->login',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_barang`
--

DROP TABLE IF EXISTS `user_barang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_barang` (
  `barang_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `stok_user` int(11) DEFAULT NULL,
  `lock_user` int(11) DEFAULT NULL,
  `harga_sekarang` int(30) DEFAULT NULL,
  PRIMARY KEY (`barang_id`,`user_id`),
  KEY `fk_barang_has_user_user1_idx` (`user_id`),
  KEY `fk_barang_has_user_barang_idx` (`barang_id`),
  CONSTRAINT `fk_barang_has_user_barang` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_barang_has_user_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_barang`
--

LOCK TABLES `user_barang` WRITE;
/*!40000 ALTER TABLE `user_barang` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_barang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_lelang_jual`
--

DROP TABLE IF EXISTS `user_lelang_jual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_lelang_jual` (
  `user_id` int(11) NOT NULL,
  `lelang_jual_customer_id` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `jumlah_terima` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `status` enum('1','2','3') DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`,`lelang_jual_customer_id`),
  KEY `fk_user_has_lelang_jual_customer_lelang_jual_customer1_idx` (`lelang_jual_customer_id`),
  KEY `fk_user_has_lelang_jual_customer_user1_idx` (`user_id`),
  CONSTRAINT `fk_user_has_lelang_jual_customer_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_lelang_jual_customer_lelang_jual_customer1` FOREIGN KEY (`lelang_jual_customer_id`) REFERENCES `lelang_jual_customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_lelang_jual`
--

LOCK TABLES `user_lelang_jual` WRITE;
/*!40000 ALTER TABLE `user_lelang_jual` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_lelang_jual` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'ilpclelang'
--
/*!50106 SET @save_time_zone= @@TIME_ZONE */ ;
/*!50106 DROP EVENT IF EXISTS `fluk` */;
DELIMITER ;;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;;
/*!50003 SET character_set_client  = utf8 */ ;;
/*!50003 SET character_set_results = utf8 */ ;;
/*!50003 SET collation_connection  = utf8_general_ci */ ;;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;;
/*!50003 SET @saved_time_zone      = @@time_zone */ ;;
/*!50003 SET time_zone             = 'SYSTEM' */ ;;
/*!50106 CREATE*/ /*!50117 DEFINER=`root`@`localhost`*/ /*!50106 EVENT `fluk` ON SCHEDULE EVERY 1 MINUTE STARTS '2014-01-11 15:45:00' ON COMPLETION NOT PRESERVE ENABLE DO call fluktuasi(NOW()) */ ;;
/*!50003 SET time_zone             = @saved_time_zone */ ;;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;;
/*!50003 SET character_set_client  = @saved_cs_client */ ;;
/*!50003 SET character_set_results = @saved_cs_results */ ;;
/*!50003 SET collation_connection  = @saved_col_connection */ ;;
DELIMITER ;
/*!50106 SET TIME_ZONE= @save_time_zone */ ;

--
-- Dumping routines for database 'ilpclelang'
--
/*!50003 DROP PROCEDURE IF EXISTS `ambilSeluruhLogin` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ambilSeluruhLogin`()
    NO SQL
    SQL SECURITY INVOKER
SELECT * FROM user ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `fluktuasi` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `fluktuasi`(IN `param` DATETIME)
    NO SQL
    SQL SECURITY INVOKER
BEGIN


 DECLARE done INT DEFAULT FALSE;


  DECLARE id_barang, hargaAwal, hargaSekarang, nilaiTurun INT;


  DECLARE total_jual, perkalian INT;


  DECLARE cur1 CURSOR FOR SELECT id,harga_awal, harga_sekarang, nilai_turun FROM barang;


  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE; 


   OPEN cur1;


  read_loop: LOOP


FETCH cur1 INTO id_barang, hargaAwal, hargaSekarang, nilaiTurun;


    IF done THEN


      LEAVE read_loop;


    END IF;


    


    SET total_jual = (select sum(jumlah) from history_beli where barang_id=id_barang and (jam >= DATE_ADD(param, INTERVAL -1 MINUTE) and jam <= param));


    


    IF total_jual > 0 THEN


    	SET perkalian = FLOOR((total_jual/10));


        SET hargaSekarang = hargaSekarang + (perkalian * (hargaAwal/100));


        set nilaiTurun = 0;


    ELSE


        IF nilaiTurun = 0 THEN


        	SET nilaiTurun=(hargaSekarang - hargaAwal) / 20;


    	END IF;


    	SET hargaSekarang = hargaSekarang - nilaiTurun;


        


        IF hargaSekarang < hargaAwal THEN


        	SET hargaSekarang = hargaAwal;


        END IF;


    END IF;


      


    Update barang SET harga_sekarang = hargaSekarang, nilai_turun = nilaiTurun where id = id_barang;


    INSERT INTO `history_fluktuasi`(`barang_id`, `harga_jual`, `time`) VALUES (id_barang, hargaSekarang, param);


  END LOOP;


  CLOSE cur1;


END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-01-25 11:17:28
