-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2019 at 12:46 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_albet`
--

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE IF NOT EXISTS `jenis` (
  `kd_jenis` varchar(10) NOT NULL,
  `nmjenis` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`kd_jenis`, `nmjenis`) VALUES
('ff', 'ff'),
('j01', 'j01'),
('j023', 'j023'),
('jjj', 'jjj'),
('jjjjj', 'jjjjj');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`) VALUES
('1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `pekerja`
--

CREATE TABLE IF NOT EXISTS `pekerja` (
  `id_pekerja` varchar(10) NOT NULL,
  `nmpekerja` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `jk` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pekerja`
--

INSERT INTO `pekerja` (`id_pekerja`, `nmpekerja`, `jabatan`, `jk`) VALUES
('gyugu', 'uygh', 'assshhhh', 'Pria'),
('h', 'jghfdjjfkgfjdklglfjglfd', 'j', 'Wanita'),
('jgjgjhkj', 'hkjhkjh', 'kj', 'Wanita');

-- --------------------------------------------------------

--
-- Table structure for table `permohonan`
--

CREATE TABLE IF NOT EXISTS `permohonan` (
  `kd_permohonan` varchar(100) NOT NULL,
  `id_pekerja` varchar(100) NOT NULL,
  `id_proyek` varchar(100) NOT NULL,
  `kd_jenis` varchar(100) NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `harga` varchar(100) NOT NULL,
  `total` varchar(100) NOT NULL,
  `jangkawaktu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permohonan`
--

INSERT INTO `permohonan` (`kd_permohonan`, `id_pekerja`, `id_proyek`, `kd_jenis`, `jumlah`, `harga`, `total`, `jangkawaktu`) VALUES
('j01', 'h', 'jjiio', 'j01', '6', '600', 'dd', 'h'),
('P01', 'gyugu', 'g', 'j01', '8', '7000', '5600000', '8');

-- --------------------------------------------------------

--
-- Table structure for table `proyek`
--

CREATE TABLE IF NOT EXISTS `proyek` (
  `id_proyek` varchar(100) NOT NULL,
  `nmproyek` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proyek`
--

INSERT INTO `proyek` (`id_proyek`, `nmproyek`, `alamat`) VALUES
('g', 'kk', 'gggggg'),
('jjiio', 'mmmm', 'mmmm'),
('nnnnn', 'nnnnnn', 'nnnnbnnnnnnnnnnn');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jenis`
--
ALTER TABLE `jenis`
 ADD PRIMARY KEY (`kd_jenis`);

--
-- Indexes for table `pekerja`
--
ALTER TABLE `pekerja`
 ADD PRIMARY KEY (`id_pekerja`);

--
-- Indexes for table `permohonan`
--
ALTER TABLE `permohonan`
 ADD PRIMARY KEY (`kd_permohonan`);

--
-- Indexes for table `proyek`
--
ALTER TABLE `proyek`
 ADD PRIMARY KEY (`id_proyek`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
