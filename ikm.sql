-- ========================================================
-- Migration & Seed Database: ikm (Slim Framework v4)
-- Otomatis di-import saat database belum ada atau saat Reset Database
-- ========================================================

CREATE DATABASE IF NOT EXISTS `ikm` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ikm`;

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text NOT NULL,
  PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES
('company_logo', 'images/logo.png'),
('marquee_text', 'Terima kasih atas partisipasi, penilaian, dan masukan Anda bagi peningkatan pelayanan kami.'),
('footer_text', 'Portal Survei IKM & Suara Rakyat');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `address` text NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `mobile` varchar(30) NOT NULL DEFAULT '',
  `photo` varchar(255) NOT NULL DEFAULT '',
  `role` enum('admin','operator') NOT NULL DEFAULT 'operator',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `user` (`id`, `name`, `username`, `password`, `address`, `email`, `mobile`, `photo`, `role`) VALUES
(0, 'Administrator Utama', 'admin', 'admin', 'Kantor Pusat Layanan Publik', 'admin@instansi.go.id', '085691996250', '', 'admin'),
(1, 'Budi Santoso, S.AP', '', '', 'Loket Pelayanan Administrasi Terpadu 1', 'budi.loket1@instansi.go.id', '081234567801', '', 'operator'),
(2, 'Siti Rahmawati, A.Md', '', '', 'Loket Informasi & Pengaduan Masyarakat 2', 'siti.loket2@instansi.go.id', '081234567802', '', 'operator');

DROP TABLE IF EXISTS `question`;
CREATE TABLE `question` (
  `id_question` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) NOT NULL,
  `q_order` tinyint(3) unsigned NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id_question`),
  UNIQUE KEY `user_q_order` (`id_user`, `q_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `question` (`id_user`, `q_order`, `text`) VALUES
(1, 1, 'Bagaimana kesesuaian persyaratan pelayanan dengan jenis pelayanannya?'),
(1, 2, 'Bagaimana kemudahan prosedur pelayanan yang diberikan petugas?'),
(1, 3, 'Bagaimana kecepatan waktu petugas dalam memberikan pelayanan?'),
(1, 4, 'Bagaimana sikap (kesopanan dan keramahan) petugas saat melayani Anda?'),
(2, 1, 'Bagaimana kejelasan informasi dan solusi yang disampaikan petugas?'),
(2, 2, 'Bagaimana kecepatan dan ketanggapan petugas dalam menangani pengaduan/masukan?');

DROP TABLE IF EXISTS `data`;
CREATE TABLE `data` (
  `id_data` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) NOT NULL,
  `counter` varchar(20) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `q1` varchar(20) NOT NULL DEFAULT '',
  `q2` varchar(20) NOT NULL DEFAULT '',
  `q3` varchar(20) NOT NULL DEFAULT '',
  `q4` varchar(20) NOT NULL DEFAULT '',
  `q5` varchar(20) NOT NULL DEFAULT '',
  `q6` varchar(20) NOT NULL DEFAULT '',
  `q7` varchar(20) NOT NULL DEFAULT '',
  `q8` varchar(20) NOT NULL DEFAULT '',
  `q9` varchar(20) NOT NULL DEFAULT '',
  `q10` varchar(20) NOT NULL DEFAULT '',
  `suggestion` text NOT NULL DEFAULT '',
  PRIMARY KEY (`id_data`),
  KEY `idx_counter_time` (`counter`, `time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
