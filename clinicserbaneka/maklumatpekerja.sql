-- --------------------------------------------------------
-- Cipta pangkalan data: maklumatpekerja
-- --------------------------------------------------------
CREATE DATABASE IF NOT EXISTS `maklumatpekerja`
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `maklumatpekerja`;

-- --------------------------------------------------------
-- Jadual: users (untuk login admin)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `userid` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tambah pengguna admin default
INSERT INTO `users` (`userid`, `password`)
VALUES ('admin', SHA2('admin123', 256));


-- --------------------------------------------------------
-- Jadual: pekerja (senarai maklumat pekerja)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `pekerja` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(255) NOT NULL,
  `nokp` VARCHAR(20) NOT NULL,
  `nohp` VARCHAR(20) NOT NULL,
  `jantina` ENUM('Lelaki', 'Perempuan') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tiada data dimasukkan (kosong)
