-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 12, 2018 at 11:24 AM
-- Server version: 5.6.38
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `kuesioner`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_new`
--

CREATE TABLE `admin_new` (
  `id_admin` char(5) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_new`
--

INSERT INTO `admin_new` (`id_admin`, `nama`, `email`, `password`) VALUES
('A0001', 'Agus Wahyu', 'aguswmika@gmail.com', '5350e4ecdf6983acfe8ae7ca197593e9');

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE `form` (
  `id_form` char(5) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `id_semester` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `status` enum('aktif','nonaktif') NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `form`
--
DELIMITER $$
CREATE TRIGGER `form_ondelete` BEFORE DELETE ON `form` FOR EACH ROW BEGIN
  DELETE FROM form_pertanyaan WHERE id_form = old.id_form;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `form_pertanyaan`
--

CREATE TABLE `form_pertanyaan` (
  `id_pertanyaan` int(11) NOT NULL,
  `id_form` char(5) CHARACTER SET utf8 NOT NULL,
  `pertanyaan` varchar(255) NOT NULL,
  `tipe` enum('opsional','esay') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `form_pertanyaan`
--
DELIMITER $$
CREATE TRIGGER `form_pertanyaan_ondelete` BEFORE DELETE ON `form_pertanyaan` FOR EACH ROW BEGIN
      DELETE FROM hasil_kuesioner WHERE id_pertanyaan = old.id_pertanyaan;
  DELETE FROM opsi WHERE id_pertanyaan = old.id_pertanyaan;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `hasil_kuesioner`
--

CREATE TABLE `hasil_kuesioner` (
  `id_hasil` int(11) NOT NULL,
  `id_pertanyaan` int(11) NOT NULL,
  `id_opsi` int(11) DEFAULT NULL,
  `hasil_esay` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `opsi`
--

CREATE TABLE `opsi` (
  `id_opsi` int(11) NOT NULL,
  `id_pertanyaan` int(11) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `id_semester` int(11) NOT NULL,
  `nama_semester` enum('ganjil','genap') NOT NULL,
  `tahun` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_new`
--
ALTER TABLE `admin_new`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`id_form`),
  ADD KEY `id_semester` (`id_semester`);

--
-- Indexes for table `form_pertanyaan`
--
ALTER TABLE `form_pertanyaan`
  ADD PRIMARY KEY (`id_pertanyaan`),
  ADD KEY `id_form` (`id_form`);

--
-- Indexes for table `hasil_kuesioner`
--
ALTER TABLE `hasil_kuesioner`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `id_pertanyaan` (`id_pertanyaan`),
  ADD KEY `id_opsi` (`id_opsi`);

--
-- Indexes for table `opsi`
--
ALTER TABLE `opsi`
  ADD PRIMARY KEY (`id_opsi`),
  ADD KEY `id_pertanyaan` (`id_pertanyaan`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`id_semester`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `form_pertanyaan`
--
ALTER TABLE `form_pertanyaan`
  MODIFY `id_pertanyaan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hasil_kuesioner`
--
ALTER TABLE `hasil_kuesioner`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opsi`
--
ALTER TABLE `opsi`
  MODIFY `id_opsi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `id_semester` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `form`
--
ALTER TABLE `form`
  ADD CONSTRAINT `form_ibfk_1` FOREIGN KEY (`id_semester`) REFERENCES `semester` (`id_semester`);

--
-- Constraints for table `form_pertanyaan`
--
ALTER TABLE `form_pertanyaan`
  ADD CONSTRAINT `form_pertanyaan_ibfk_1` FOREIGN KEY (`id_form`) REFERENCES `form` (`id_form`);

--
-- Constraints for table `hasil_kuesioner`
--
ALTER TABLE `hasil_kuesioner`
  ADD CONSTRAINT `hasil_kuesioner_ibfk_1` FOREIGN KEY (`id_pertanyaan`) REFERENCES `form_pertanyaan` (`id_pertanyaan`),
  ADD CONSTRAINT `hasil_kuesioner_ibfk_2` FOREIGN KEY (`id_opsi`) REFERENCES `opsi` (`id_opsi`);

--
-- Constraints for table `opsi`
--
ALTER TABLE `opsi`
  ADD CONSTRAINT `opsi_ibfk_1` FOREIGN KEY (`id_pertanyaan`) REFERENCES `form_pertanyaan` (`id_pertanyaan`);
