-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2014 at 05:42 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ilpc_alpha`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ambilSeluruhLogin`()
    NO SQL
    SQL SECURITY INVOKER
SELECT * FROM user$$

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `P_cari_pemenang`(sesi INT)
BEGIN
  DECLARE done, done2 BOOLEAN DEFAULT FALSE;
  
  DECLARE v_id_lelang INT;
  DECLARE v_sisa INT;
  DECLARE v_budget INT;
  
  DECLARE v_id_pemenang INT;
  DECLARE v_jumlah INT;
  DECLARE v_harga INT;
  
  DECLARE v_id_barang INT;
    
    DECLARE C_lelang CURSOR FOR 
    SELECT id,budget,jumlah FROM lelang_jual_customer
    WHERE season_id = sesi ORDER BY id ASC;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    OPEN C_lelang;
    cur_lelang_loop: LOOP
    	FETCH FROM C_lelang INTO v_id_lelang,v_budget,v_sisa;
        IF done THEN
        CLOSE C_lelang;
        LEAVE cur_lelang_loop;
        END IF;

        BLOCK2: BEGIN
        DECLARE C_pemenang CURSOR FOR 
        SELECT user_id,jumlah,harga FROM user_lelang_jual
        WHERE lelang_jual_customer_id = v_id_lelang AND status = 3 ORDER BY harga,time ASC;
        DECLARE CONTINUE HANDLER FOR NOT FOUND SET done2 = TRUE;
        OPEN C_pemenang; 
        cur_pemenang_loop: LOOP
        FETCH FROM C_pemenang INTO v_id_pemenang,v_jumlah,v_harga;   
            IF (done2) THEN
            	set done2 = FALSE;
            	CLOSE C_pemenang;
            	LEAVE cur_pemenang_loop;
            ELSE
            	IF(v_sisa>0)THEN
            		IF(v_harga <= v_budget) THEN
            			IF(v_jumlah <= v_sisa) THEN
                                	CALL P_kurang_stok_user(v_id_pemenang,v_id_lelang,v_jumlah,v_sisa,v_harga,1);
            				UPDATE user_lelang_jual SET jumlah_terima=v_jumlah,status=1
                        		WHERE user_id = v_id_pemenang AND lelang_jual_customer_id 
                                        = v_id_lelang;
					
                        		UPDATE user SET jumlahuang=(jumlahuang+(v_jumlah*v_harga)+((v_jumlah*v_harga)*30/100)) 
                                        WHERE id = v_id_pemenang;
            				SET v_sisa = v_sisa - v_jumlah;
                                	SET v_jumlah = 0;
            			ELSEIF (v_jumlah > v_sisa) THEN
                                	CALL P_kurang_stok_user(v_id_pemenang,v_id_lelang,v_jumlah,v_sisa,v_harga,2);
            				UPDATE user_lelang_jual SET jumlah_terima=v_sisa,status=1
                        		WHERE user_id = v_id_pemenang AND lelang_jual_customer_id 
                                        = v_id_lelang;
                        		UPDATE user SET jumlahuang=(jumlahuang+(v_sisa*v_harga)+((v_sisa*v_harga)*30/100))
                                        WHERE id = v_id_pemenang;
                                	SET v_jumlah = 0;
                                        SET v_sisa = 0;
            			ELSE
                                	CALL P_kurang_stok_user(v_id_pemenang,v_id_lelang,v_jumlah,v_sisa,v_harga,3);
                                        UPDATE user_lelang_jual SET jumlah_terima=0,status=2
                        		WHERE user_id = v_id_pemenang AND lelang_jual_customer_id = v_id_lelang;
                                END IF;
                	ELSE
                        	CALL P_kurang_stok_user(v_id_pemenang,v_id_lelang,v_jumlah,v_sisa,v_harga,3);
                		UPDATE user_lelang_jual SET jumlah_terima=0,status=2
                        	WHERE user_id = v_id_pemenang AND lelang_jual_customer_id = v_id_lelang;
                	END IF;
            	ELSE
                	CALL P_kurang_stok_user(v_id_pemenang,v_id_lelang,v_jumlah,v_sisa,v_harga,3);
                        UPDATE user_lelang_jual SET jumlah_terima=0,status=2
                        WHERE user_id = v_id_pemenang AND lelang_jual_customer_id = v_id_lelang;
                END IF;
            END IF; 
            
        END LOOP cur_pemenang_loop;
        END BLOCK2;
    END LOOP cur_lelang_loop;

    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `P_kurang_stok_user`(
v_id_pemenang INT,v_id_lelang INT,v_jumlah INT,v_harga INT,v_jenis INT
)
BEGIN
     DECLARE done3 BOOLEAN DEFAULT FALSE;
     DECLARE v_id_barang INT;
     DECLARE v_sisa_lelang INT DEFAULT 0;
     
     DECLARE C_barang CURSOR FOR 
     SELECT barang_id FROM detail_lelang_jual
     WHERE lelang_jual_id = v_id_lelang;
     DECLARE CONTINUE HANDLER FOR NOT FOUND SET done3 = TRUE;
     OPEN C_barang; 
     cur_stok_barang_loop: LOOP
     FETCH FROM C_barang INTO v_id_barang;   
     IF done3 THEN
          SET done3 = FALSE;
          CLOSE C_barang;
          LEAVE cur_stok_barang_loop;
     ELSE
           IF(v_jenis=1)THEN
          	SELECT lock_user INTO v_sisa_lelang FROM user_barang WHERE user_id =
          	v_id_pemenang AND barang_id = v_id_barang;
                SET v_sisa_lelang = v_sisa_lelang - v_jumlah;
          	IF(v_sisa_lelang >= 0)THEN
          		UPDATE user_barang SET stok_user=(stok_user - v_jumlah)
                        ,lock_user=(lock_user - v_jumlah) WHERE user_id =
          		v_id_pemenang AND barang_id = v_id_barang;
			INSERT INTO history_beli (jam,jumlah,barang_id,user_id,harga,status_beli)
                        VALUES (NOW(),v_jumlah,v_id_barang,v_id_pemenang,v_harga,2); 
          	END IF;
            ELSE
            	UPDATE user_barang SET lock_user=(lock_user - v_jumlah)
                WHERE user_id = v_id_pemenang AND barang_id = v_id_barang;
            END iF;
     END iF;
     END LOOP cur_stok_barang_loop;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE IF NOT EXISTS `barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(255) NOT NULL,
  `harga_awal` int(11) NOT NULL,
  `harga_sekarang` int(11) NOT NULL,
  `nilai_turun` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chat` text,
  `time` datetime DEFAULT NULL,
  `panitia_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_chat_panitia1_idx` (`panitia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_customer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `detail_lelang_jual`
--

CREATE TABLE IF NOT EXISTS `detail_lelang_jual` (
  `lelang_jual_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  PRIMARY KEY (`lelang_jual_id`,`barang_id`),
  KEY `fk_lelang_jual_customer_has_barang_barang1_idx` (`barang_id`),
  KEY `fk_lelang_jual_customer_has_barang_lelang_jual_customer1_idx` (`lelang_jual_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `history_activity_panitia`
--

CREATE TABLE IF NOT EXISTS `history_activity_panitia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` datetime DEFAULT NULL,
  `activity` text,
  `panitia_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_history_activity_panitia_panitia1_idx` (`panitia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `history_activity_peserta`
--

CREATE TABLE IF NOT EXISTS `history_activity_peserta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` datetime DEFAULT NULL,
  `activity` text,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_history_activity_peserta_user1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `history_beli`
--

CREATE TABLE IF NOT EXISTS `history_beli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jam` datetime NOT NULL,
  `jumlah` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `harga` int(11) DEFAULT NULL,
  `status_beli` enum('0','1','2') DEFAULT NULL COMMENT '0->beli,1->jual,2->lelang',
  PRIMARY KEY (`id`),
  KEY `fk_history_beli_barang1_idx` (`barang_id`),
  KEY `fk_history_beli_user1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `history_fluktuasi`
--

CREATE TABLE IF NOT EXISTS `history_fluktuasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `harga_jual` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `barang_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_history_fluktuasi_barang1_idx` (`barang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `history_modal`
--

CREATE TABLE IF NOT EXISTS `history_modal` (
  `pos_ilpc_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `waktu` datetime DEFAULT NULL,
  `status` enum('1','2','3') DEFAULT NULL COMMENT '1->Menang, 2->Seri, 3->kalah',
  PRIMARY KEY (`pos_ilpc_id`,`user_id`),
  KEY `fk_pos_ilpc_has_user_user1_idx` (`user_id`),
  KEY `fk_pos_ilpc_has_user_pos_ilpc1_idx` (`pos_ilpc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pos`
--

CREATE TABLE IF NOT EXISTS `jenis_pos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis` varchar(45) DEFAULT NULL,
  `sertifikat_menang` int(11) DEFAULT NULL,
  `sertifikat_kalah` int(11) DEFAULT NULL,
  `uang_menang` int(11) DEFAULT NULL,
  `uang_kalah` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lelang_jual_customer`
--

CREATE TABLE IF NOT EXISTS `lelang_jual_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_lelang` text NOT NULL,
  `judul_lelang` varchar(255) NOT NULL,
  `budget` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `jumlah` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `season_id` int(11) NOT NULL,
  `status_lelang` enum('0','1','2') DEFAULT NULL COMMENT '0->belum diikuti, 1->sudah diikuti, 2->sudah ditentukan pemenang',
  `nama_barang` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lelang_jual_customer_customer1_idx` (`customer_id`),
  KEY `fk_lelang_jual_customer_season1_idx` (`season_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `berita` text NOT NULL,
  `time` datetime DEFAULT NULL,
  `panitia_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_news_panitia1_idx` (`panitia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `panitia`
--

CREATE TABLE IF NOT EXISTS `panitia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(45) DEFAULT NULL,
  `status` enum('0','1') DEFAULT NULL COMMENT '0->biasa, 1->superAdmin',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `panitia`
--

INSERT INTO `panitia` (`id`, `username`, `password`, `nama`, `status`) VALUES
(1, 'admin', '891c3df989c3adf653e09261a2c1a7fb', 'Super admin', '1');

-- --------------------------------------------------------

--
-- Table structure for table `panitia_pos`
--

CREATE TABLE IF NOT EXISTS `panitia_pos` (
  `pos_ilpc_id` int(11) NOT NULL,
  `panitia_id` int(11) NOT NULL,
  PRIMARY KEY (`pos_ilpc_id`,`panitia_id`),
  KEY `fk_pos_ilpc_has_panitia_panitia1_idx` (`panitia_id`),
  KEY `fk_pos_ilpc_has_panitia_pos_ilpc1_idx` (`pos_ilpc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_ilpc`
--

CREATE TABLE IF NOT EXISTS `pos_ilpc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pos` varchar(255) NOT NULL,
  `jenis_pos_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pos_ilpc_jenis_pos1_idx` (`jenis_pos_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `season`
--

CREATE TABLE IF NOT EXISTS `season` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aktif` enum('0','1','2','3') NOT NULL COMMENT '0->belum,1->persiapan,2->mulai,3->selesai',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Triggers `season`
--
DROP TRIGGER IF EXISTS `T_set_budget`;
DELIMITER //
CREATE TRIGGER `T_set_budget` AFTER UPDATE ON `season`
 FOR EACH ROW BEGIN
    DECLARE done, done2 BOOLEAN DEFAULT FALSE;
    DECLARE v_id_lelang INT DEFAULT 0;
    DECLARE v_harga INT DEFAULT 0;
    DECLARE v_jumlah INT DEFAULT 0;
    
    IF NEW.aktif = 1 THEN
    BLOCK1: BEGIN
       DECLARE C_lelang CURSOR FOR 
       SELECT id FROM lelang_jual_customer
       WHERE season_id = NEW.id ORDER BY id ASC;
       DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
       OPEN C_lelang;
       
       cur_lelang_loop: LOOP
    		FETCH FROM C_lelang INTO v_id_lelang;
        	IF done THEN
        		CLOSE C_lelang;
        		LEAVE cur_lelang_loop;
        	END IF;
                BLOCK2: BEGIN
        		DECLARE C_harga_sekarang CURSOR FOR 
        		SELECT b.harga_sekarang FROM barang b INNER JOIN detail_lelang_jual d
			ON b.id = d.barang_id 
                        INNER JOIN lelang_jual_customer l ON
                        d.lelang_jual_id = l.id
                        WHERE d.lelang_jual_id = v_id_lelang AND l.season_id = NEW.id;
        		DECLARE CONTINUE HANDLER FOR NOT FOUND SET done2 = TRUE;
        		OPEN C_harga_sekarang; 
        		cur_ambil_harga_loop: LOOP
        		FETCH FROM C_harga_sekarang INTO v_harga;   
            		IF (done2) THEN
                        	UPDATE lelang_jual_customer SET budget = (v_jumlah*2) WHERE id =  v_id_lelang AND 
                                season_id = NEW.id;
                                SET v_jumlah = 0;
            			set done2 = FALSE;
            			CLOSE C_harga_sekarang;
            			LEAVE cur_ambil_harga_loop;
            		ELSE
            			SET v_jumlah = (v_jumlah + v_harga);
            		END IF; 
        		END LOOP cur_ambil_harga_loop;
        	END BLOCK2;
       END LOOP cur_lelang_loop;
       END BLOCK1;
       END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `jumlahuang` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL COMMENT '0->tidak login, 1->login',
  `jumlahSertifikat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Triggers `user`
--
DROP TRIGGER IF EXISTS `T_user_barang`;
DELIMITER //
CREATE TRIGGER `T_user_barang` AFTER INSERT ON `user`
 FOR EACH ROW BEGIN
       DECLARE id_exists INT DEFAULT 0; 
       
WHILE EXISTS(SELECT id FROM barang WHERE id > id_exists)
DO
SET id_exists = (SELECT id
       FROM barang
       WHERE id > id_exists
       ORDER BY id ASC
       LIMIT 1);
       
       IF id_exists IS NOT NULL
       THEN 
           INSERT INTO 
                  user_barang (user_id,barang_id,stok_user,lock_user,harga_sekarang)
                  VALUES(NEW.id,id_exists,0,0,0);
        END IF;
       
END WHILE;
              
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_barang`
--

CREATE TABLE IF NOT EXISTS `user_barang` (
  `barang_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `stok_user` int(11) DEFAULT NULL,
  `lock_user` int(11) DEFAULT NULL,
  `harga_sekarang` int(30) DEFAULT NULL,
  PRIMARY KEY (`barang_id`,`user_id`),
  KEY `fk_barang_has_user_user1_idx` (`user_id`),
  KEY `fk_barang_has_user_barang_idx` (`barang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_lelang_jual`
--

CREATE TABLE IF NOT EXISTS `user_lelang_jual` (
  `user_id` int(11) NOT NULL,
  `lelang_jual_customer_id` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `jumlah_terima` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `status` enum('1','2','3') DEFAULT NULL COMMENT '1->diterima, 2->ditolak, 3->dipending',
  `time` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`,`lelang_jual_customer_id`),
  KEY `fk_user_has_lelang_jual_customer_lelang_jual_customer1_idx` (`lelang_jual_customer_id`),
  KEY `fk_user_has_lelang_jual_customer_user1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `fk_chat_panitia1` FOREIGN KEY (`panitia_id`) REFERENCES `panitia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `detail_lelang_jual`
--
ALTER TABLE `detail_lelang_jual`
  ADD CONSTRAINT `fk_lelang_jual_customer_has_barang_barang1` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lelang_jual_customer_has_barang_lelang_jual_customer1` FOREIGN KEY (`lelang_jual_id`) REFERENCES `lelang_jual_customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `history_activity_panitia`
--
ALTER TABLE `history_activity_panitia`
  ADD CONSTRAINT `fk_history_activity_panitia_panitia1` FOREIGN KEY (`panitia_id`) REFERENCES `panitia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `history_activity_peserta`
--
ALTER TABLE `history_activity_peserta`
  ADD CONSTRAINT `fk_history_activity_peserta_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `history_beli`
--
ALTER TABLE `history_beli`
  ADD CONSTRAINT `fk_history_beli_barang1` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_history_beli_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `history_fluktuasi`
--
ALTER TABLE `history_fluktuasi`
  ADD CONSTRAINT `fk_history_fluktuasi_barang1` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `history_modal`
--
ALTER TABLE `history_modal`
  ADD CONSTRAINT `fk_pos_ilpc_has_user_pos_ilpc1` FOREIGN KEY (`pos_ilpc_id`) REFERENCES `pos_ilpc` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pos_ilpc_has_user_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `lelang_jual_customer`
--
ALTER TABLE `lelang_jual_customer`
  ADD CONSTRAINT `fk_lelang_jual_customer_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lelang_jual_customer_season1` FOREIGN KEY (`season_id`) REFERENCES `season` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `fk_news_panitia1` FOREIGN KEY (`panitia_id`) REFERENCES `panitia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `panitia_pos`
--
ALTER TABLE `panitia_pos`
  ADD CONSTRAINT `fk_pos_ilpc_has_panitia_panitia1` FOREIGN KEY (`panitia_id`) REFERENCES `panitia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pos_ilpc_has_panitia_pos_ilpc1` FOREIGN KEY (`pos_ilpc_id`) REFERENCES `pos_ilpc` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `pos_ilpc`
--
ALTER TABLE `pos_ilpc`
  ADD CONSTRAINT `fk_pos_ilpc_jenis_pos1` FOREIGN KEY (`jenis_pos_id`) REFERENCES `jenis_pos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_barang`
--
ALTER TABLE `user_barang`
  ADD CONSTRAINT `fk_barang_has_user_barang` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_barang_has_user_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_lelang_jual`
--
ALTER TABLE `user_lelang_jual`
  ADD CONSTRAINT `fk_user_has_lelang_jual_customer_lelang_jual_customer1` FOREIGN KEY (`lelang_jual_customer_id`) REFERENCES `lelang_jual_customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_has_lelang_jual_customer_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `fluk` ON SCHEDULE EVERY 1 MINUTE STARTS '2014-01-11 15:45:00' ON COMPLETION NOT PRESERVE ENABLE DO call fluktuasi(NOW())$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
