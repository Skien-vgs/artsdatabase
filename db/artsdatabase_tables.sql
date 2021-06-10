-- Adminer 4.8.0 MySQL 5.5.5-10.1.48-MariaDB-0+deb9u1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `ad_bilder`;
CREATE TABLE `ad_bilder` (
  `file_path` varchar(50) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  KEY `kategori_id` (`kategori_id`),
  CONSTRAINT `ad_bilder_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `ad_hierarki` (`kategori_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `ad_elever`;
CREATE TABLE `ad_elever` (
  `elev_id` int(11) NOT NULL AUTO_INCREMENT,
  `fornavn` varchar(45) NOT NULL,
  `etternavn` varchar(45) NOT NULL,
  `skoleklasse` varchar(20) NOT NULL,
  PRIMARY KEY (`elev_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `ad_hierarki`;
CREATE TABLE `ad_hierarki` (
  `kategori_id` int(11) NOT NULL AUTO_INCREMENT,
  `navn` varchar(45) NOT NULL,
  `navn_norsk` varchar(45) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`kategori_id`),
  KEY `parent` (`parent`),
  CONSTRAINT `ad_hierarki_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `ad_hierarki` (`kategori_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `ad_koordinater`;
CREATE TABLE `ad_koordinater` (
  `koordinater_id` int(11) NOT NULL AUTO_INCREMENT,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  PRIMARY KEY (`koordinater_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `ad_registreringer`;
CREATE TABLE `ad_registreringer` (
  `elev_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `koordinater_id` int(11) DEFAULT NULL,
  `tidspunkt` datetime NOT NULL,
  PRIMARY KEY (`elev_id`,`tidspunkt`),
  KEY `kategori_id` (`kategori_id`),
  KEY `koordinater_id` (`koordinater_id`),
  CONSTRAINT `ad_registreringer_ibfk_1` FOREIGN KEY (`elev_id`) REFERENCES `ad_elever` (`elev_id`),
  CONSTRAINT `ad_registreringer_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `ad_hierarki` (`kategori_id`),
  CONSTRAINT `ad_registreringer_ibfk_3` FOREIGN KEY (`koordinater_id`) REFERENCES `ad_koordinater` (`koordinater_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `ad_sider`;
CREATE TABLE `ad_sider` (
  `kategori_id` int(11) NOT NULL,
  `info` text NOT NULL,
  `info2` text NOT NULL,
  KEY `kategori_id` (`kategori_id`),
  CONSTRAINT `ad_sider_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `ad_hierarki` (`kategori_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- 2021-06-10 08:19:11
