-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 12, 2022 at 12:12 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bais_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `external_directory`
--

CREATE TABLE `external_directory` (
  `id` int(11) NOT NULL,
  `root` varchar(100) NOT NULL,
  `keterangan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `external_directory`
--

INSERT INTO `external_directory` (`id`, `root`, `keterangan`) VALUES
(1, 'doc-upload/', 'SPL'),
(2, 'doc-upload/', 'ATT'),
(3, '//adm-fs/BODY/BODY02/Body Plant/BAIS/INFO-SUPPORT/', 'INFO'),
(4, '//adm-fs/BODY/BODY02/Body Plant/BAIS/employee-photo/', 'FOTO'),
(5, '//adm-fs/BODY/BODY02/Body Plant/BAIS/BAIS-FORM/2022/', 'FORM'),
(6, '//adm-fs/BODY/BODY02/Body Plant/BAIS/DOCUMENT/MANUALS/Welcome/', 'GUIDE'),
(7, '//adm-fs/BODY/BODY02/Body Plant/BAIS/', 'CICO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `external_directory`
--
ALTER TABLE `external_directory`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `external_directory`
--
ALTER TABLE `external_directory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
