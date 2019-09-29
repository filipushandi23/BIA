-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2019 at 02:45 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bia-gcw`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_data_nasabah`
--

CREATE TABLE `tbl_data_nasabah` (
  `cif` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `no_hp` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_data_nasabah`
--

INSERT INTO `tbl_data_nasabah` (`cif`, `user_id`, `nik`, `nama`, `alamat`, `no_hp`) VALUES
('c3CIqlUr', 2, '1111444411112222', 'Jason Budi', 'Jakarta Utara', '28452154'),
('mwZDYhJ2', 1, '123412341234', 'Filipus Handi', 'Jakbar', '1354054');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_data_rekening`
--

CREATE TABLE `tbl_data_rekening` (
  `no_rek` varchar(20) NOT NULL,
  `cif` varchar(20) NOT NULL,
  `jenis_rekening` varchar(20) DEFAULT NULL,
  `cabang` varchar(50) DEFAULT NULL,
  `saldo` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_data_rekening`
--

INSERT INTO `tbl_data_rekening` (`no_rek`, `cif`, `jenis_rekening`, `cabang`, `saldo`) VALUES
('085510001234', 'mwZDYhJ2', 'Giro', 'BSD Tangerang', 550000000),
('085579891642', 'c3CIqlUr', 'Tahapan', 'Sudirman Jakarta', 350000000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaksi_warkat`
--

CREATE TABLE `tbl_transaksi_warkat` (
  `security_code` varchar(32) NOT NULL,
  `no_rek_pengirim` varchar(20) NOT NULL,
  `no_rek_penerima` varchar(20) NOT NULL,
  `tipe_warkat` varchar(30) DEFAULT NULL,
  `nik` varchar(16) DEFAULT NULL,
  `jumlah_transfer` bigint(20) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `tgl_efektif` datetime NOT NULL,
  `tgl_issue` datetime DEFAULT NULL,
  `pindah_tangan` tinyint(4) DEFAULT NULL,
  `berita` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_transaksi_warkat`
--

INSERT INTO `tbl_transaksi_warkat` (`security_code`, `no_rek_pengirim`, `no_rek_penerima`, `tipe_warkat`, `nik`, `jumlah_transfer`, `status`, `tgl_efektif`, `tgl_issue`, `pindah_tangan`, `berita`) VALUES
('6jFmhRNpbZW7BEa0VsyS5PdXg1KUQHLc', '085510001234', '085579891642', 'Cek', NULL, 350000000, 'Selesai', '2019-09-28 05:57:00', '2019-09-28 05:57:00', NULL, NULL),
('7JASOTkBRcLstxPv1VG4rbgpljyhU5Kz', '085579891642', '085510001234', 'Cek', NULL, 200000000, 'Selesai', '2019-09-28 05:19:42', '2019-09-28 05:19:42', NULL, NULL),
('cAwidbMWLeUOh5H8oEK3tBVnlXqGQPJu', '085510001234', '085579891642', 'Cek', NULL, 400000000, 'Selesai', '2019-09-28 05:21:46', '2019-09-28 05:21:46', NULL, NULL),
('i1vKD5sCI3oRhL26PZWUm7JxrzeG9lkO', '085510001234', '085579891642', 'Cek', NULL, 200000000, 'Selesai', '2019-09-28 09:19:57', '2019-09-28 09:19:57', NULL, NULL),
('L1n2Vyq6rg8iCNDSdER5HGZBQKp93uOb', '085579891642', '085510001234', 'Cek', NULL, 600000000, 'Selesai', '2019-09-28 05:55:20', '2019-09-28 05:55:20', NULL, NULL),
('oDhdsJyc8HuWUrezfEqnxtgCBXIjNZ0R', '085579891642', '085510001234', 'Bilyet Giro', NULL, 300000001, 'Saldo tidak cukup', '2019-09-28 05:20:59', '2019-09-28 05:20:59', NULL, NULL),
('WuZ32bBKo58D1nXNp6Uixkz7edPmGLqH', '085579891642', '085510001234', 'Cek', NULL, 300000000, 'Selesai', '2019-09-28 05:59:44', '2019-09-28 05:59:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `username`, `password`, `role`) VALUES
(1, 'filipushandi', '123123', 'Nasabah'),
(2, 'jasonbudi', '123123', 'Nasabah'),
(3, 'raditya', '123123', 'Cabang'),
(4, 'teller', '123123', 'Cabang');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_data_nasabah`
--
ALTER TABLE `tbl_data_nasabah`
  ADD PRIMARY KEY (`cif`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_data_rekening`
--
ALTER TABLE `tbl_data_rekening`
  ADD PRIMARY KEY (`no_rek`),
  ADD KEY `cif` (`cif`);

--
-- Indexes for table `tbl_transaksi_warkat`
--
ALTER TABLE `tbl_transaksi_warkat`
  ADD PRIMARY KEY (`security_code`,`no_rek_penerima`,`no_rek_pengirim`,`tgl_efektif`),
  ADD KEY `no_rek_pengirim` (`no_rek_pengirim`),
  ADD KEY `no_rek_penerima` (`no_rek_penerima`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_data_nasabah`
--
ALTER TABLE `tbl_data_nasabah`
  ADD CONSTRAINT `tbl_data_nasabah_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`);

--
-- Constraints for table `tbl_data_rekening`
--
ALTER TABLE `tbl_data_rekening`
  ADD CONSTRAINT `tbl_data_rekening_ibfk_1` FOREIGN KEY (`cif`) REFERENCES `tbl_data_nasabah` (`cif`);

--
-- Constraints for table `tbl_transaksi_warkat`
--
ALTER TABLE `tbl_transaksi_warkat`
  ADD CONSTRAINT `tbl_transaksi_warkat_ibfk_1` FOREIGN KEY (`no_rek_pengirim`) REFERENCES `tbl_data_rekening` (`no_rek`),
  ADD CONSTRAINT `tbl_transaksi_warkat_ibfk_2` FOREIGN KEY (`no_rek_penerima`) REFERENCES `tbl_data_rekening` (`no_rek`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
