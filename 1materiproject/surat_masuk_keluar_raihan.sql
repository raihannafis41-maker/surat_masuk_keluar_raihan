-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 01, 2025 at 02:40 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `surat_masuk_keluar_raihan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `username`, `password`, `email`, `no_telp`, `foto`) VALUES
(3, 'raihanlageee', 'raihann', '$2y$10$S8UcEWtEHnclx4LGb2KGZOv0yuAuHJ2BAt0t7Im1rEpcBMqBu8BL6', 'raihanlagee@gmail.com', '087895367788', '1761796046_1761786630_1761711344_1761555383_hancok.jpg'),
(73, 'handiks', 'hannnn', '122222', 'handiks@gmail.com', '089887878788787', '1761833704_hanjay.png'),
(74, 'rakan', 'rakanlagi', '121212121', 'rakan@gmail.com', '087896354323', '1761837004_hanjay.png');

-- --------------------------------------------------------

--
-- Table structure for table `disposisi`
--

CREATE TABLE `disposisi` (
  `id_disposisi` int NOT NULL,
  `id_surat_masuk` int NOT NULL,
  `id_pegawai` int NOT NULL,
  `tgl_disposisi` date NOT NULL,
  `isi_disposisi` text,
  `status_disposisi` enum('Belum Dibaca','Proses','Selesai') DEFAULT 'Belum Dibaca',
  `catatan` text,
  `file_disposisi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `disposisi`
--

INSERT INTO `disposisi` (`id_disposisi`, `id_surat_masuk`, `id_pegawai`, `tgl_disposisi`, `isi_disposisi`, `status_disposisi`, `catatan`, `file_disposisi`) VALUES
(9, 5, 21, '2025-11-01', NULL, 'Proses', 'yty', '1761875030_muhammad raihan nafis laporan analisis biaya.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `keterangan`) VALUES
(4, 'laporan data diri ', 'lowongan kerja'),
(5, 'laporan tamu wajib lapor 2x 24jam', 'menginap saja'),
(6, 'surat liburan', 'selama 3 minggu');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` int NOT NULL,
  `nip` varchar(30) DEFAULT NULL,
  `nama_pegawai` varchar(100) NOT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `golongan` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `nip`, `nama_pegawai`, `jabatan`, `email`, `no_telp`, `golongan`, `foto`) VALUES
(12, '989998988', 'raihan _lagi', 'siswa', 'raihanlagi@gmail.com', '0895767776552', 'X', 'pegawai_1761832748.jpg'),
(20, '099288772662', 'yakub', 'siswa', 'yakub@gmail.com', '087895367788', 'XX', '1761837261_hanjay.png'),
(21, '873727328283823', 'yudo', 'siswa', 'yudo@gmail.com', '0895767776552', 'XX', '1761837464_hanjay.png'),
(28, '099988878776', 'adit', 'siswa', 'adit@gmail.com', '07625255343553', 'XI', '1761837821_hanjay.png'),
(29, '100025636737738', 'rudi', 'siswa', 'rudi@gmail.com', '098886738389', 'XX', '1761875487_hanjay.png');

-- --------------------------------------------------------

--
-- Table structure for table `surat_keluar`
--

CREATE TABLE `surat_keluar` (
  `id_surat_keluar` int NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `tgl_surat` date NOT NULL,
  `tujuan` varchar(100) DEFAULT NULL,
  `alamat_tujuan` text,
  `perihal` varchar(255) DEFAULT NULL,
  `isi` text,
  `file_surat` varchar(255) DEFAULT NULL,
  `id_kategori` int DEFAULT NULL,
  `id_admin` int DEFAULT NULL,
  `id_pegawai` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `surat_keluar`
--

INSERT INTO `surat_keluar` (`id_surat_keluar`, `no_surat`, `tgl_surat`, `tujuan`, `alamat_tujuan`, `perihal`, `isi`, `file_surat`, `id_kategori`, `id_admin`, `id_pegawai`) VALUES
(2, '(003/SMK/X/2025', '2025-10-29', 'rapat osis', 'osis', 'rapat osis', 'berkumpul di halte', '1761643415_1761555383_hancok.jpg', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `surat_masuk`
--

CREATE TABLE `surat_masuk` (
  `id_surat_masuk` int NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `tgl_surat` date NOT NULL,
  `tgl_terima` date DEFAULT NULL,
  `pengirim` varchar(100) DEFAULT NULL,
  `alamat_pengirim` text,
  `perihal` varchar(255) DEFAULT NULL,
  `isi` text,
  `file_surat` varchar(255) DEFAULT NULL,
  `status` enum('baru','dibaca','arsip') DEFAULT 'baru',
  `id_kategori` int DEFAULT NULL,
  `id_admin` int DEFAULT NULL,
  `id_pegawai` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `surat_masuk`
--

INSERT INTO `surat_masuk` (`id_surat_masuk`, `no_surat`, `tgl_surat`, `tgl_terima`, `pengirim`, `alamat_pengirim`, `perihal`, `isi`, `file_surat`, `status`, `id_kategori`, `id_admin`, `id_pegawai`) VALUES
(1, '001', '2025-10-07', '2025-10-07', 'Dinas Pendidikan Dan Kebudayaan', 'Jl. Ahmad Yani', 'Undangan Rapat', '', '1761711344_1761555383_hancok.jpg', 'baru', NULL, NULL, NULL),
(5, '2', '2025-10-30', '2025-10-31', 'raihann', 'smk', 'ertttyty', 'wwertreewe', '1761728320_1761555383_hancok.jpg', 'baru', NULL, NULL, NULL),
(6, '0998989', '2025-10-29', '2025-10-31', 'raihannn', 'jl.vbvb', 'ywyywsbsh', 'weee', '1761877085_muhammad raihan nafis laporan analisis biaya.pdf', 'baru', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `disposisi`
--
ALTER TABLE `disposisi`
  ADD PRIMARY KEY (`id_disposisi`),
  ADD KEY `fk_disposisi_surat_masuk` (`id_surat_masuk`),
  ADD KEY `fk_disposisi_pegawai` (`id_pegawai`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indexes for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD PRIMARY KEY (`id_surat_keluar`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indexes for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD PRIMARY KEY (`id_surat_masuk`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `disposisi`
--
ALTER TABLE `disposisi`
  MODIFY `id_disposisi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_pegawai` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  MODIFY `id_surat_keluar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  MODIFY `id_surat_masuk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `disposisi`
--
ALTER TABLE `disposisi`
  ADD CONSTRAINT `fk_disposisi_pegawai` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_disposisi_surat_masuk` FOREIGN KEY (`id_surat_masuk`) REFERENCES `surat_masuk` (`id_surat_masuk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD CONSTRAINT `surat_keluar_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `surat_keluar_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `surat_keluar_ibfk_3` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD CONSTRAINT `surat_masuk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `surat_masuk_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `surat_masuk_ibfk_3` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
