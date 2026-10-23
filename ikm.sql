-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.11.6-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.21.0.7344
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for ikm
CREATE DATABASE IF NOT EXISTS `ikm` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `ikm`;

-- Dumping structure for table ikm.data
CREATE TABLE IF NOT EXISTS `data` (
  `id_data` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) NOT NULL,
  `counter` varchar(20) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `q1` varchar(20) NOT NULL,
  `q2` varchar(20) NOT NULL,
  `q3` varchar(20) NOT NULL,
  `q4` varchar(20) NOT NULL,
  `q5` varchar(20) NOT NULL,
  `q6` varchar(20) NOT NULL,
  `q7` varchar(20) NOT NULL,
  `q8` varchar(20) NOT NULL,
  `q9` varchar(20) NOT NULL,
  `suggestion` text NOT NULL,
  PRIMARY KEY (`id_data`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table ikm.data: ~0 rows (approximately)
DELETE FROM `data`;

-- Dumping structure for table ikm.question
CREATE TABLE IF NOT EXISTS `question` (
  `id_text` varchar(10) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id_text`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table ikm.question: ~9 rows (approximately)
DELETE FROM `question`;
INSERT INTO `question` (`id_text`, `text`) VALUES
	('1+a', 'Kesesuaian persyaratan pelayanan dengan jenis pelayananya ?'),
	('1+b', 'Kemudahan prosedur Pelayanan yang Diberikan penyelenggara pelayanan ?'),
	('1+c', 'Kecepatan Pelayanan yang Diberikan penyelenggara pelayanan ?'),
	('1+d', 'Kesesuaian antara biaya yang dibayarkan dengan biaya yang telah ditetapkan ?'),
	('1+e', 'Kesesuaian antara hasil pelayanan yang diberikan dengan ketentuan yang telah ditetapkan / permintaan awal pelanggan ?'),
	('1+f', 'Kemampuan petugas dalam memberikan pelayanan ?'),
	('1+g', 'Sikap (kesopanan dan keramahan) petugas dalam memberikan pelayanan ?'),
	('1+h', 'kesesuaian antara pelayanan yang didapatkan dengan malumat pelayanan (standart pelayanan) yang ditetapkan ?'),
	('1+i', 'Penanganan terhadap pengaduan, saran dan masukan ?');

-- Dumping structure for table ikm.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(30) NOT NULL,
  `mobile` varchar(30) NOT NULL,
  `role` enum('admin','operator') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table ikm.user: ~2 rows (approximately)
DELETE FROM `user`;
INSERT INTO `user` (`id`, `name`, `username`, `password`, `address`, `email`, `mobile`, `role`) VALUES
	(0, 'Administrators', 'admin', 'admin', 'Indonesia', 'administrator@mail.co.id', '085691996250', 'admin'),
	(1, 'operator', 'op', '123', '', '', '', 'operator');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
