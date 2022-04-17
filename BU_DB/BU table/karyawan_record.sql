-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 17, 2022 at 05:29 AM
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
-- Table structure for table `karyawan_record`
--

CREATE TABLE `karyawan_record` (
  `id` int(5) NOT NULL,
  `kode_area` varchar(40) NOT NULL,
  `nama_area` varchar(50) NOT NULL,
  `part` varchar(10) NOT NULL,
  `jabatan` varchar(5) NOT NULL,
  `status` varchar(5) NOT NULL,
  `category` varchar(5) NOT NULL,
  `acc` int(10) NOT NULL,
  `updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `karyawan_record`
--

INSERT INTO `karyawan_record` (`id`, `kode_area`, `nama_area`, `part`, `jabatan`, `status`, `category`, `acc`, `updated`) VALUES
(1, '1-001-001-009-001', 'RM', 'group', 'TM', 'P', 'idl', 20, '2022-04-13'),
(2, '1-001-001-009-001', 'RM', 'group', 'TM', 'C1', 'dl', 30, '2022-04-13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `karyawan_record`
--
ALTER TABLE `karyawan_record`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
