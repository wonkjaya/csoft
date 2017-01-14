-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 09, 2017 at 02:21 
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `p_labmedis`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `no` int(10) NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`no`, `username`, `password`) VALUES
(0, 'abi', 'abi');

-- --------------------------------------------------------

--
-- Table structure for table `tabelpemeriksaan`
--

CREATE TABLE `tabelpemeriksaan` (
  `no` int(10) NOT NULL,
  `no_rm` varchar(6) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `umur` int(3) NOT NULL,
  `alamat` text NOT NULL,
  `jenis_kelamin` varchar(2) NOT NULL,
  `jenis_pasien` varchar(5) NOT NULL,
  `dokter` varchar(100) NOT NULL,
  `kategori` varchar(20) NOT NULL,
  `sub_kategori` varchar(20) NOT NULL,
  `pemeriksaan` varchar(20) NOT NULL,
  `pembayaran` int(15) NOT NULL,
  `tanggal` text NOT NULL,
  `nilai_tes` int(11) NOT NULL,
  `hasil` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabelpemeriksaan`
--

INSERT INTO `tabelpemeriksaan` (`no`, `no_rm`, `nama`, `umur`, `alamat`, `jenis_kelamin`, `jenis_pasien`, `dokter`, `kategori`, `sub_kategori`, `pemeriksaan`, `pembayaran`, `tanggal`, `nilai_tes`, `hasil`) VALUES
(1, '002', 'rohman', 21, 'Puri Mojobaru Blok AV-14', 'L', 'BPJS', 'Dr. Dewi Rhayu 				', 'HEMATOLOGI', 'NONE', 'LED', 3000, '2016-12-01', 40, 'Negatif bro'),
(5, '003', 'maretha', 21, 'jalan simpang sulfat', 'P', 'UMUM', 'sukirman', 'NONE', 'NONE', 'NONE', 32000, 'Friday, 23/12/2016 14:33:13', 0, 'oke'),
(6, '004', 'yuanita', 33, 'jalan babakan', 'P', 'BPJS', 'dukion', 'HEMATOLOGI', 'DARAH LENGKAP', 'LEUKOSIT', 540000, 'Friday, 23/12/2016 14:33:55', 0, 'sip');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `tabelpemeriksaan`
--
ALTER TABLE `tabelpemeriksaan`
  ADD PRIMARY KEY (`no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabelpemeriksaan`
--
ALTER TABLE `tabelpemeriksaan`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
