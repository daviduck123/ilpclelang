SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `ilpclelang` DEFAULT CHARACTER SET utf8 ;
USE `ilpclelang` ;

-- -----------------------------------------------------
-- Table `ilpclelang`.`barang`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ilpclelang`.`barang` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_barang` VARCHAR(255) NOT NULL,
  `harga_awal` INT(11) NOT NULL,
  `harga_sekarang` INT(11) NOT NULL,
  `nilai_turun` INT(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ilpclelang`.`panitia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ilpclelang`.`panitia` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `nama` VARCHAR(45) NULL DEFAULT NULL,
  `status` ENUM('0','1') NULL DEFAULT NULL COMMENT '0->biasa, 1->superAdmin',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username` (`username` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;

INSERT INTO `panitia` (`id`, `username`, `password`, `nama`, `status`) VALUES
(1, 'admin', '891c3df989c3adf653e09261a2c1a7fb', 'Super admin', '1');
-- -----------------------------------------------------
-- Table `ilpclelang`.`chat`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ilpclelang`.`chat` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `chat` TEXT NULL DEFAULT NULL,
  `time` DATETIME NULL DEFAULT NULL,
  `panitia_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_chat_panitia1_idx` (`panitia_id` ASC),
  CONSTRAINT `fk_chat_panitia1`
    FOREIGN KEY (`panitia_id`)
    REFERENCES `ilpclelang`.`panitia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ilpclelang`.`customer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ilpclelang`.`customer` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_customer` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ilpclelang`.`season`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ilpclelang`.`season` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `aktif` ENUM('0','1','2','3') NOT NULL COMMENT '0->belum,1->persiapan,2->mulai,3->selesai',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ilpclelang`.`lelang_jual_customer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ilpclelang`.`lelang_jual_customer` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `no_lelang` TEXT NOT NULL,
  `judul_lelang` VARCHAR(255) NOT NULL,
  `budget` INT(11) NOT NULL,
  `deskripsi` TEXT NOT NULL,
  `jumlah` INT(11) NOT NULL,
  `customer_id` INT(11) NOT NULL,
  `season_id` INT(11) NOT NULL,
  `status_lelang` ENUM('0','1','2') NULL DEFAULT NULL COMMENT '0->belum diikuti, 1->sudah diikuti, 2->sudah ditentukan pemenang',
  `nama_barang` VARCHAR(30) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_lelang_jual_customer_customer1_idx` (`customer_id` ASC),
  INDEX `fk_lelang_jual_customer_season1_idx` (`season_id` ASC),
  CONSTRAINT `fk_lelang_jual_customer_customer1`
    FOREIGN KEY (`customer_id`)
    REFERENCES `ilpclelang`.`customer` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lelang_jual_customer_season1`
    FOREIGN KEY (`season_id`)
    REFERENCES `ilpclelang`.`season` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ilpclelang`.`detail_lelang_jual`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ilpclelang`.`detail_lelang_jual` (
  `lelang_jual_id` INT(11) NOT NULL,
  `barang_id` INT(11) NOT NULL,
  PRIMARY KEY (`lelang_jual_id`, `barang_id`),
  INDEX `fk_lelang_jual_customer_has_barang_barang1_idx` (`barang_id` ASC),
  INDEX `fk_lelang_jual_customer_has_barang_lelang_jual_customer1_idx` (`lelang_jual_id` ASC),
  CONSTRAINT `fk_lelang_jual_customer_has_barang_barang1`
    FOREIGN KEY (`barang_id`)
    REFERENCES `ilpclelang`.`barang` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lelang_jual_customer_has_barang_lelang_jual_customer1`
    FOREIGN KEY (`lelang_jual_id`)
    REFERENCES `ilpclelang`.`lelang_jual_customer` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ilpclelang`.`history_activity_panitia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ilpclelang`.`history_activity_panitia` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `time` DATETIME NULL DEFAULT NULL,
  `activity` TEXT NULL DEFAULT NULL,
  `panitia_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_history_activity_panitia_panitia1_idx` (`panitia_id` ASC),
  CONSTRAINT `fk_history_activity_panitia_panitia1`
    FOREIGN KEY (`panitia_id`)
    REFERENCES `ilpclelang`.`panitia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ilpclelang`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ilpclelang`.`user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(100) NOT NULL,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `jumlahuang` INT(11) NOT NULL,
  `status` ENUM('0','1') NOT NULL COMMENT '0->tidak login, 1->login',
  `jumlahSertifikat` INT(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ilpclelang`.`history_activity_peserta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ilpclelang`.`history_activity_peserta` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `time` DATETIME NULL DEFAULT NULL,
  `activity` TEXT NULL DEFAULT NULL,
  `user_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_history_activity_peserta_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_history_activity_peserta_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `ilpclelang`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ilpclelang`.`history_beli`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ilpclelang`.`history_beli` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `jam` DATETIME NOT NULL,
  `jumlah` INT(11) NOT NULL,
  `barang_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `harga` INT(11) NULL DEFAULT NULL,
  `status_beli` ENUM('0','1','2') NULL DEFAULT NULL COMMENT '0->beli,1->jual,2->lelang',
  PRIMARY KEY (`id`),
  INDEX `fk_history_beli_barang1_idx` (`barang_id` ASC),
  INDEX `fk_history_beli_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_history_beli_barang1`
    FOREIGN KEY (`barang_id`)
    REFERENCES `ilpclelang`.`barang` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_history_beli_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `ilpclelang`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ilpclelang`.`history_fluktuasi`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ilpclelang`.`history_fluktuasi` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `harga_jual` INT(11) NOT NULL,
  `time` DATETIME NOT NULL,
  `barang_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_history_fluktuasi_barang1_idx` (`barang_id` ASC),
  CONSTRAINT `fk_history_fluktuasi_barang1`
    FOREIGN KEY (`barang_id`)
    REFERENCES `ilpclelang`.`barang` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ilpclelang`.`jenis_pos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ilpclelang`.`jenis_pos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis` VARCHAR(45) NULL DEFAULT NULL,
  `sertifikat_menang` INT(11) NULL DEFAULT NULL,
  `sertifikat_kalah` INT(11) NULL DEFAULT NULL,
  `uang_menang` INT(11) NULL DEFAULT NULL,
  `uang_kalah` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ilpclelang`.`pos_ilpc`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ilpclelang`.`pos_ilpc` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_pos` VARCHAR(255) NOT NULL,
  `jenis_pos_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_pos_ilpc_jenis_pos1_idx` (`jenis_pos_id` ASC),
  CONSTRAINT `fk_pos_ilpc_jenis_pos1`
    FOREIGN KEY (`jenis_pos_id`)
    REFERENCES `ilpclelang`.`jenis_pos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ilpclelang`.`history_modal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ilpclelang`.`history_modal` (
  `pos_ilpc_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `waktu` DATETIME NULL DEFAULT NULL,
  `status` ENUM('1','2','3') NULL DEFAULT NULL COMMENT '1->Menang, 2->Seri, 3->kalah',
  PRIMARY KEY (`pos_ilpc_id`, `user_id`),
  INDEX `fk_pos_ilpc_has_user_user1_idx` (`user_id` ASC),
  INDEX `fk_pos_ilpc_has_user_pos_ilpc1_idx` (`pos_ilpc_id` ASC),
  CONSTRAINT `fk_pos_ilpc_has_user_pos_ilpc1`
    FOREIGN KEY (`pos_ilpc_id`)
    REFERENCES `ilpclelang`.`pos_ilpc` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pos_ilpc_has_user_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `ilpclelang`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ilpclelang`.`news`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ilpclelang`.`news` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `berita` TEXT NOT NULL,
  `time` DATETIME NULL DEFAULT NULL,
  `panitia_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_news_panitia1_idx` (`panitia_id` ASC),
  CONSTRAINT `fk_news_panitia1`
    FOREIGN KEY (`panitia_id`)
    REFERENCES `ilpclelang`.`panitia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ilpclelang`.`panitia_pos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ilpclelang`.`panitia_pos` (
  `pos_ilpc_id` INT(11) NOT NULL,
  `panitia_id` INT(11) NOT NULL,
  PRIMARY KEY (`pos_ilpc_id`, `panitia_id`),
  INDEX `fk_pos_ilpc_has_panitia_panitia1_idx` (`panitia_id` ASC),
  INDEX `fk_pos_ilpc_has_panitia_pos_ilpc1_idx` (`pos_ilpc_id` ASC),
  CONSTRAINT `fk_pos_ilpc_has_panitia_panitia1`
    FOREIGN KEY (`panitia_id`)
    REFERENCES `ilpclelang`.`panitia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pos_ilpc_has_panitia_pos_ilpc1`
    FOREIGN KEY (`pos_ilpc_id`)
    REFERENCES `ilpclelang`.`pos_ilpc` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ilpclelang`.`user_barang`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ilpclelang`.`user_barang` (
  `barang_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `stok_user` INT(11) NULL DEFAULT NULL,
  `lock_user` INT(11) NULL DEFAULT NULL,
  `harga_sekarang` INT(30) NULL DEFAULT NULL,
  PRIMARY KEY (`barang_id`, `user_id`),
  INDEX `fk_barang_has_user_user1_idx` (`user_id` ASC),
  INDEX `fk_barang_has_user_barang_idx` (`barang_id` ASC),
  CONSTRAINT `fk_barang_has_user_barang`
    FOREIGN KEY (`barang_id`)
    REFERENCES `ilpclelang`.`barang` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_barang_has_user_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `ilpclelang`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ilpclelang`.`user_lelang_jual`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ilpclelang`.`user_lelang_jual` (
  `user_id` INT(11) NOT NULL,
  `lelang_jual_customer_id` INT(11) NOT NULL,
  `jumlah` INT(11) NULL DEFAULT NULL,
  `jumlah_terima` INT(11) NULL DEFAULT NULL,
  `harga` INT(11) NULL DEFAULT NULL,
  `status` ENUM('1','2','3') NULL DEFAULT NULL COMMENT '1->diterima, 2->ditolak, 3->dipending',
  `time` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`, `lelang_jual_customer_id`),
  INDEX `fk_user_has_lelang_jual_customer_lelang_jual_customer1_idx` (`lelang_jual_customer_id` ASC),
  INDEX `fk_user_has_lelang_jual_customer_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_user_has_lelang_jual_customer_lelang_jual_customer1`
    FOREIGN KEY (`lelang_jual_customer_id`)
    REFERENCES `ilpclelang`.`lelang_jual_customer` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_lelang_jual_customer_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `ilpclelang`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

USE `ilpclelang` ;

-- -----------------------------------------------------
-- procedure ambilSeluruhLogin
-- -----------------------------------------------------

DELIMITER $$
USE `ilpclelang`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ambilSeluruhLogin`()
    NO SQL
    SQL SECURITY INVOKER
SELECT * FROM user$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure fluktuasi
-- -----------------------------------------------------

DELIMITER $$
USE `ilpclelang`$$
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


END$$

DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
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