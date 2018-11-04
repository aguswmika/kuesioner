-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 02, 2018 at 11:53 AM
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
-- Dumping data for table `form`
--

INSERT INTO `form` (`id_form`, `nama`, `id_semester`, `tanggal`, `status`, `slug`) VALUES
('F0001', 'Mahasiswa Aktif', 15, '2018-10-31 22:01:23', 'aktif', 'mahasiswa-aktif');

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
-- Dumping data for table `form_pertanyaan`
--

INSERT INTO `form_pertanyaan` (`id_pertanyaan`, `id_form`, `pertanyaan`, `tipe`) VALUES
(1, 'F0001', 'Siapa saya?', 'opsional'),
(2, 'F0001', 'Bahasa inggrisnya brute force?', 'esay'),
(3, 'F0001', '1+1 = ?', 'opsional');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_kuesioner`
--

CREATE TABLE `hasil_kuesioner` (
  `id_hasil` int(11) NOT NULL,
  `id_pertanyaan` int(11) NOT NULL,
  `id_opsi` int(11) NOT NULL,
  `hasil_esay` varchar(255) NOT NULL
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

--
-- Dumping data for table `opsi`
--

INSERT INTO `opsi` (`id_opsi`, `id_pertanyaan`, `value`) VALUES
(1, 1, 'Agus'),
(2, 1, 'Wahyu'),
(3, 1, 'Widiatmika'),
(4, 1, 'I'),
(5, 1, 'Putu'),
(6, 3, '1'),
(7, 3, '3');

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
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`id_semester`, `nama_semester`, `tahun`) VALUES
(15, 'ganjil', 2018),
(16, 'genap', 2018);

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
  MODIFY `id_pertanyaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hasil_kuesioner`
--
ALTER TABLE `hasil_kuesioner`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opsi`
--
ALTER TABLE `opsi`
  MODIFY `id_opsi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `id_semester` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
