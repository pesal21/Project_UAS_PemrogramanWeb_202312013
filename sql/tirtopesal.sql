-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 25, 2025 at 01:13 AM
-- Server version: 8.0.40
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tirtopesal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'pesal', '$2y$10$KSB.95t/EhlpJVdXZ/eZGurvNskrKqMKk2UMOVx2sDL4W6.T8b75m', 'Admin TirtoPesal');

-- --------------------------------------------------------

--
-- Table structure for table `aktivitas_admin`
--

CREATE TABLE `aktivitas_admin` (
  `id_aktivitas` int NOT NULL,
  `id_admin` int DEFAULT NULL,
  `id_pelanggan` int DEFAULT NULL,
  `peran` enum('admin','pelanggan') NOT NULL,
  `aktivitas` text NOT NULL,
  `waktu` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aktivitas_admin`
--

INSERT INTO `aktivitas_admin` (`id_aktivitas`, `id_admin`, `id_pelanggan`, `peran`, `aktivitas`, `waktu`) VALUES
(1, NULL, NULL, 'pelanggan', 'Melakukan pemesanan travel', '2025-07-19 11:14:12'),
(2, NULL, NULL, 'pelanggan', 'Pelanggan baru mendaftar', '2025-07-19 03:43:32'),
(3, NULL, NULL, 'pelanggan', 'Pelanggan baru mendaftar', '2025-07-19 03:43:51'),
(4, NULL, NULL, 'pelanggan', 'Melakukan pemesanan', '2025-07-19 05:18:04'),
(5, NULL, NULL, 'pelanggan', 'Melakukan pemesanan', '2025-07-19 05:18:06'),
(6, NULL, NULL, 'pelanggan', 'Pelanggan baru mendaftar', '2025-07-19 05:42:23'),
(7, NULL, NULL, 'pelanggan', 'Melakukan pemesanan', '2025-07-19 05:50:34'),
(8, NULL, NULL, 'pelanggan', 'Melakukan pemesanan', '2025-07-19 05:51:11'),
(9, NULL, 2, 'pelanggan', 'Melakukan pemesanan', '2025-07-19 05:55:19'),
(10, NULL, 2, 'pelanggan', 'Melakukan pemesanan', '2025-07-19 05:55:26'),
(11, NULL, 2, 'pelanggan', 'Melakukan pemesanan', '2025-07-19 06:06:16'),
(12, NULL, 2, 'pelanggan', 'Melakukan pemesanan', '2025-07-19 06:17:52'),
(13, NULL, 2, 'pelanggan', 'Melakukan pemesanan', '2025-07-19 06:42:09'),
(14, NULL, 2, 'pelanggan', 'Melakukan pemesanan', '2025-07-19 06:43:20'),
(15, NULL, NULL, 'admin', 'Menambahkan data mobil baru', '2025-07-19 06:53:59'),
(16, NULL, NULL, 'admin', 'Menambahkan data mobil baru', '2025-07-19 06:55:19'),
(17, NULL, NULL, 'pelanggan', 'Pelanggan baru mendaftar', '2025-07-19 07:21:16'),
(18, NULL, NULL, 'pelanggan', 'Pelanggan baru mendaftar', '2025-07-19 07:21:20');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int NOT NULL,
  `id_pemesanan` int NOT NULL,
  `id_admin` int DEFAULT NULL,
  `tanggal_laporan` datetime DEFAULT CURRENT_TIMESTAMP,
  `total_pembayaran` int NOT NULL,
  `metode_pembayaran` varchar(100) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id_laporan`, `id_pemesanan`, `id_admin`, `tanggal_laporan`, `total_pembayaran`, `metode_pembayaran`, `keterangan`) VALUES
(1, 29, NULL, '2025-07-19 00:00:00', 530000, 'Transfer', 'Pemesanan tujuan Tenggarong (Kukar) oleh Vidi Maulidiyah'),
(2, 30, NULL, '2025-07-19 00:00:00', 720000, 'Cash', 'Pemesanan tujuan Bontang oleh Vidi Maulidiyah'),
(3, 31, NULL, '2025-07-19 00:00:00', 620000, 'Cash', 'Pemesanan tujuan Bontang oleh Vidi Maulidiyah'),
(4, 32, NULL, '2025-07-19 00:00:00', 620000, 'Cash', 'Pemesanan tujuan Bontang oleh Vidi Maulidiyah');

-- --------------------------------------------------------

--
-- Table structure for table `mobil`
--

CREATE TABLE `mobil` (
  `id_mobil` int NOT NULL,
  `nama_mobil` varchar(50) DEFAULT NULL,
  `harga` int DEFAULT NULL,
  `plat_nomor` varchar(20) DEFAULT NULL,
  `nama_supir` varchar(100) NOT NULL,
  `kapasitas` int DEFAULT NULL,
  `status` varchar(20) DEFAULT 'aktif',
  `gambar` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`id_mobil`, `nama_mobil`, `harga`, `plat_nomor`, `nama_supir`, `kapasitas`, `status`, `gambar`) VALUES
(1, 'Hiace', 500000, 'KT 1234 AB', 'Kevin', 12, 'aktif', 'hiace.jpeg'),
(2, 'Calya', 350000, 'KT 5678 CD', 'Udin', 5, 'aktif', 'calya.jpeg'),
(3, 'Sigra', 350000, 'KT 1111 EF', 'Agus', 5, 'aktif', 'sigra.jpeg'),
(4, 'Xenia', 450000, 'KT 2222 GH', 'Handoko', 7, 'aktif', 'xenia.jpeg'),
(5, 'Innova Reborn', 600000, 'KT 321 PSL', 'Mr.Eskicing', 6, 'aktif', 'innova.jpeg'),
(6, 'Avanza', 500000, 'KT 123 B', 'Guntur', 6, 'aktif', 'avanza.jpeg'),
(7, 'L300', 200000, 'KT 1234 AB', 'Akbar', 3, 'aktif', 'l300.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_pelanggan` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `username`, `password`, `nama_pelanggan`, `no_hp`, `email`, `alamat`) VALUES
(1, 'wenka', '$2y$10$MHv.9FU71t94bbcblafLS.fFMEGey6z0IAjCJC0wPmJVW6Cw6Ke2i', 'Wenka Salinding', '08089', 'wenka@gmail.com', 'btg'),
(2, 'vidi', '$2y$10$1BofrCDokI1qMaUHNGbLTudXf0AjvuCBam48r7nlqE5m51KbuLxoS', 'Vidi Maulidiyah', '12345', 'vidi@gmail.com', 'bontang'),
(3, 'cahaya', '$2y$10$GLwQsjY0/LILcxMxoRPi5eMF18MzIxR5t99esR6/1jwB.pz45ggk6', 'cahaya nur', '34', 'cahay@gmail.com', 'btg');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int NOT NULL,
  `id_pemesanan` int DEFAULT NULL,
  `metode_pembayaran` enum('cash','qris','transfer') DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `status` enum('pending','terverifikasi') DEFAULT 'pending',
  `tanggal_pembayaran` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pemesanan` int NOT NULL,
  `id_pelanggan` int DEFAULT NULL,
  `id_jadwal` int DEFAULT NULL,
  `id_mobil` int DEFAULT NULL,
  `tarif_mobil` int DEFAULT NULL,
  `jumlah_penumpang` int DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `total_bayar` int DEFAULT NULL,
  `tanggal_pesan` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_tujuan` int DEFAULT NULL,
  `tarif_tujuan` int DEFAULT NULL,
  `tanggal_berangkat` date DEFAULT NULL,
  `total_harga` int DEFAULT NULL,
  `metode_pembayaran` enum('Cash','Transfer','QRIS') NOT NULL DEFAULT 'Cash',
  `status_pembayaran` enum('Belum Dibayar','Menunggu Konfirmasi','Sudah Dibayar') NOT NULL DEFAULT 'Belum Dibayar',
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `tanggal_pembayaran` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id_pemesanan`, `id_pelanggan`, `id_jadwal`, `id_mobil`, `tarif_mobil`, `jumlah_penumpang`, `status`, `total_bayar`, `tanggal_pesan`, `id_tujuan`, `tarif_tujuan`, `tanggal_berangkat`, `total_harga`, `metode_pembayaran`, `status_pembayaran`, `bukti_pembayaran`, `tanggal_pembayaran`) VALUES
(1, 1, NULL, 1, NULL, 3, 'pending', NULL, '2025-07-17 05:27:35', 2, NULL, '2025-07-17', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(2, 1, NULL, 4, NULL, 1, 'pending', NULL, '2025-07-17 05:37:53', 4, NULL, '2025-07-18', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(3, 1, NULL, 2, NULL, 3, 'pending', NULL, '2025-07-17 09:50:23', 8, NULL, '2025-07-31', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(4, 1, NULL, 6, NULL, 3, 'pending', NULL, '2025-07-17 09:59:29', 4, NULL, '2025-08-01', 500000, 'Cash', 'Belum Dibayar', NULL, NULL),
(5, 1, NULL, 5, NULL, 1, 'pending', NULL, '2025-07-17 11:43:38', 6, NULL, '2025-07-24', 600000, 'Cash', 'Belum Dibayar', NULL, NULL),
(6, 1, NULL, 5, NULL, 1, 'pending', 600000, '2025-07-17 12:46:07', 6, NULL, '2025-07-24', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(7, 1, NULL, 5, NULL, 1, 'pending', 600000, '2025-07-17 12:49:45', 6, NULL, '2025-07-24', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(8, 1, NULL, 3, NULL, 3, 'pending', 350000, '2025-07-17 12:50:10', 2, NULL, '2025-07-18', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(9, 1, NULL, 3, NULL, 3, 'pending', 350000, '2025-07-17 12:53:53', 2, NULL, '2025-07-18', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(10, 1, NULL, 5, 600000, 1, 'pending', 750000, '2025-07-17 14:21:24', 6, 150000, '2025-07-24', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(11, 1, NULL, 6, NULL, 2, 'pending', 560000, '2025-07-17 14:33:53', 1, NULL, '2025-07-16', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(12, 1, NULL, 5, NULL, 3, 'pending', 660000, '2025-07-18 06:52:26', 1, NULL, '2025-08-19', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(13, 1, NULL, 5, NULL, 3, 'pending', 660000, '2025-07-18 06:53:00', 1, NULL, '2025-08-19', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(14, 1, NULL, 7, NULL, 2, 'pending', 250000, '2025-07-18 07:21:08', 8, NULL, '2025-07-19', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(15, 1, NULL, 5, NULL, 2, 'pending', 660000, '2025-07-19 00:29:29', 1, NULL, '2025-07-31', NULL, 'Cash', 'Belum Dibayar', '', NULL),
(16, 1, NULL, 5, NULL, 2, 'cash', 660000, '2025-07-19 00:38:34', 1, NULL, '2025-07-31', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(17, 1, NULL, 5, NULL, 2, 'cash', 660000, '2025-07-19 00:39:29', 1, NULL, '2025-07-31', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(18, 1, NULL, 5, NULL, 2, 'cash', 650000, '2025-07-19 00:40:11', 8, NULL, '2025-07-31', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(19, 1, NULL, 5, NULL, 2, 'cash', 650000, '2025-07-19 00:44:37', 8, NULL, '2025-07-31', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(20, 1, NULL, 5, NULL, 2, 'cash', 650000, '2025-07-19 01:17:03', 8, NULL, '2025-07-31', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(21, 1, NULL, 5, NULL, 2, 'cash', 650000, '2025-07-19 01:17:08', 8, NULL, '2025-07-31', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(22, 1, NULL, 5, NULL, 2, 'cash', 650000, '2025-07-19 01:20:21', 8, NULL, '2025-07-31', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(23, 2, NULL, 6, NULL, 2, 'cash', 620000, '2025-07-19 01:54:20', 3, NULL, '2025-07-30', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(24, 2, NULL, 6, NULL, 2, 'cash', 620000, '2025-07-19 01:57:17', 3, NULL, '2025-07-30', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(25, 2, NULL, 6, NULL, 2, 'cash', 620000, '2025-07-19 02:03:35', 3, NULL, '2025-07-30', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(26, 2, NULL, 6, NULL, 9, 'cash', 530000, '2025-07-19 02:29:35', 11, NULL, '2025-07-30', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(27, 2, NULL, 6, NULL, 1, 'menunggu verifikasi', 530000, '2025-07-19 02:30:09', 11, NULL, '2025-07-30', NULL, 'Transfer', 'Belum Dibayar', '1752892209_avanza.jpeg', NULL),
(28, 2, NULL, 7, NULL, 2, 'cash', 320000, '2025-07-19 03:21:49', 3, NULL, '2025-07-24', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(29, 2, NULL, 6, NULL, 1, 'menunggu verifikasi', 530000, '2025-07-19 05:18:07', 11, NULL, '2025-07-30', NULL, 'Transfer', 'Belum Dibayar', '1752902287_avanza.jpeg', NULL),
(30, 2, NULL, 5, NULL, 2, 'cash', 720000, '2025-07-19 06:17:52', 4, NULL, '2025-07-31', NULL, 'Cash', 'Belum Dibayar', '', NULL),
(31, 2, NULL, 6, NULL, 3, 'cash', 620000, '2025-07-19 06:42:09', 4, NULL, '2025-07-19', NULL, 'Cash', 'Belum Dibayar', '', NULL),
(32, 2, NULL, 6, NULL, 3, 'cash', 620000, '2025-07-19 06:43:20', 4, NULL, '2025-07-19', NULL, 'Cash', 'Belum Dibayar', '', NULL),
(33, NULL, NULL, 6, NULL, 3, 'diproses', NULL, '2025-07-22 17:34:00', 3, NULL, '2025-07-30', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(34, NULL, NULL, 6, NULL, 3, 'diproses', NULL, '2025-07-22 17:34:57', 3, NULL, '2025-08-07', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(35, NULL, NULL, 6, NULL, 3, 'diproses', NULL, '2025-07-22 17:35:19', 3, NULL, '2025-08-07', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(36, NULL, NULL, 7, NULL, 2, 'diproses', NULL, '2025-07-22 17:53:58', 3, NULL, '2025-07-25', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(37, NULL, NULL, 7, NULL, 2, 'diproses', NULL, '2025-07-22 17:54:36', 3, NULL, '2025-07-25', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(38, NULL, NULL, 7, NULL, 2, 'diproses', NULL, '2025-07-22 17:55:43', 3, NULL, '2025-07-25', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(39, NULL, NULL, 7, NULL, 2, 'diproses', NULL, '2025-07-22 17:56:16', 3, NULL, '2025-07-25', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(40, NULL, NULL, 6, NULL, 2, 'diproses', NULL, '2025-07-22 17:56:47', 13, NULL, '2025-08-06', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(41, NULL, NULL, 6, NULL, 2, 'diproses', NULL, '2025-07-22 17:57:12', 13, NULL, '2025-08-06', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(42, NULL, NULL, 6, NULL, 1, 'diproses', NULL, '2025-07-22 18:06:46', 3, NULL, '2025-07-31', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(43, NULL, NULL, 6, NULL, 1, 'diproses', NULL, '2025-07-22 18:07:20', 1, NULL, '2025-07-09', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(44, NULL, NULL, 6, NULL, 4, 'diproses', NULL, '2025-07-22 18:16:17', 17, NULL, '2025-08-02', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(45, NULL, NULL, 6, NULL, 2, 'diproses', NULL, '2025-07-22 18:18:35', 4, NULL, '2025-08-06', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(46, NULL, NULL, 6, NULL, 2, 'diproses', NULL, '2025-07-22 18:18:52', 4, NULL, '2025-08-06', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(47, NULL, NULL, 6, NULL, 2, 'diproses', NULL, '2025-07-22 18:18:57', 4, NULL, '2025-08-06', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(48, NULL, NULL, 6, NULL, 2, 'diproses', NULL, '2025-07-22 18:19:33', 4, NULL, '2025-08-06', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(49, NULL, NULL, 6, NULL, 2, 'diproses', NULL, '2025-07-22 18:29:39', 4, NULL, '2025-08-06', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(50, NULL, NULL, 6, NULL, 1, 'diproses', NULL, '2025-07-22 18:30:26', 4, NULL, '2025-07-31', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(51, NULL, NULL, 6, NULL, 1, 'diproses', NULL, '2025-07-22 18:41:58', 4, NULL, '2025-07-30', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(52, NULL, NULL, 5, NULL, 2, 'diproses', NULL, '2025-07-22 23:43:18', 8, NULL, '2025-07-24', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(53, NULL, NULL, 5, NULL, 2, 'diproses', NULL, '2025-07-22 23:52:57', 13, NULL, '2025-07-30', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(54, NULL, NULL, 4, NULL, 2, 'diproses', NULL, '2025-07-23 01:40:13', 3, NULL, '2025-07-26', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(55, NULL, NULL, 6, NULL, 2, 'diproses', NULL, '2025-07-23 15:08:38', 9, NULL, '2025-07-26', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(56, NULL, NULL, 6, NULL, 2, 'diproses', NULL, '2025-07-23 15:26:45', 9, NULL, '2025-07-26', NULL, 'Cash', 'Belum Dibayar', NULL, NULL),
(57, NULL, NULL, 5, NULL, 2, 'diproses', NULL, '2025-07-23 16:07:52', 1, NULL, '2025-07-31', NULL, 'QRIS', 'Belum Dibayar', NULL, NULL),
(58, NULL, NULL, 6, NULL, 2, 'diproses', NULL, '2025-07-24 17:22:21', 15, NULL, '2025-08-01', NULL, 'Transfer', 'Belum Dibayar', '../uploads/68826bcd64f07_faisal.png', NULL),
(59, NULL, NULL, 2, NULL, 2, 'diproses', NULL, '2025-07-24 17:39:07', 16, NULL, '2025-07-26', NULL, 'Transfer', 'Belum Dibayar', '../uploads/68826fbbd9dac_IMG_0691.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id_setting` int NOT NULL,
  `nama_aplikasi` varchar(100) DEFAULT NULL,
  `nomor_wa` varchar(20) DEFAULT NULL,
  `alamat` text,
  `deskripsi` text,
  `instagram` varchar(100) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `last_update` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id_setting`, `nama_aplikasi`, `nomor_wa`, `alamat`, `deskripsi`, `instagram`, `facebook`, `last_update`) VALUES
(1, 'TirtoPesal Travel', '082112345678', 'Jalan Ahmad Yani No. 123, Samarinda', 'mantap', '@tirto', 'oke', '2025-07-24 19:26:50');

-- --------------------------------------------------------

--
-- Table structure for table `tujuan`
--

CREATE TABLE `tujuan` (
  `id_tujuan` int NOT NULL,
  `kota_asal` varchar(100) NOT NULL,
  `kota_tujuan` varchar(100) NOT NULL,
  `tarif` int NOT NULL,
  `estimasi` int NOT NULL,
  `id_mobil` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tujuan`
--

INSERT INTO `tujuan` (`id_tujuan`, `kota_asal`, `kota_tujuan`, `tarif`, `estimasi`, `id_mobil`) VALUES
(1, 'Bontang', 'Samarinda', 60000, 0, NULL),
(2, 'Samarinda', 'Bontang', 60000, 0, NULL),
(3, 'Bontang', 'Balikpapan', 120000, 0, NULL),
(4, 'Balikpapan', 'Bontang', 120000, 0, NULL),
(5, 'Bontang', 'Berau', 150000, 0, NULL),
(6, 'Berau', 'Bontang', 150000, 0, NULL),
(7, 'Samarinda', 'Balikpapan', 50000, 0, NULL),
(8, 'Balikpapan', 'Samarinda', 50000, 0, NULL),
(9, 'Samarinda', 'Sangatta', 90000, 0, NULL),
(10, 'Sangatta', 'Samarinda', 90000, 0, NULL),
(11, 'Samarinda', 'Tenggarong (Kukar)', 30000, 0, NULL),
(12, 'Tenggarong (Kukar)', 'Samarinda', 30000, 0, NULL),
(13, 'Samarinda', 'Berau', 180000, 0, NULL),
(14, 'Berau', 'Samarinda', 180000, 0, NULL),
(15, 'Samarinda', 'Penajam', 50000, 0, NULL),
(16, 'Penajam', 'Samarinda', 50000, 0, NULL),
(17, 'Balikpapan', 'Penajam', 50000, 0, NULL),
(18, 'Penajam', 'Balikpapan', 50000, 0, NULL),
(19, 'Samarinda', 'Muara Badak', 50000, 0, NULL),
(20, 'Muara Badak', 'Samarinda', 50000, 0, NULL),
(21, 'Balikpapan', 'Sangatta', 130000, 0, NULL),
(22, 'Sangatta', 'Balikpapan', 130000, 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

CREATE TABLE `ulasan` (
  `id_ulasan` int NOT NULL,
  `id_pelanggan` int DEFAULT NULL,
  `id_mobil` int DEFAULT NULL,
  `id_pemesanan` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `isi_ulasan` text,
  `tanggal_ulasan` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ulasan`
--

INSERT INTO `ulasan` (`id_ulasan`, `id_pelanggan`, `id_mobil`, `id_pemesanan`, `rating`, `isi_ulasan`, `tanggal_ulasan`) VALUES
(1, 1, 1, NULL, 5, 'mantap ini jozz', '2025-07-17 09:19:20'),
(2, 1, 2, NULL, 3, 'kurang nyaman', '2025-07-17 09:51:21'),
(3, 1, 5, NULL, 4, 'mantap', '2025-07-17 11:42:34'),
(4, 1, 4, NULL, 4, 'jozzz', '2025-07-17 15:13:32'),
(5, 1, 7, NULL, 2, 'Minimal pajero', '2025-07-18 06:51:46'),
(6, 1, 2, NULL, 3, 'sqsa', '2025-07-18 09:26:31'),
(7, 2, 5, NULL, 4, 'oke', '2025-07-18 18:36:40'),
(8, 2, 6, NULL, 5, 'keren', '2025-07-18 18:38:20'),
(9, 3, 4, NULL, 5, 'mantapasssss\r\n', '2025-07-19 07:26:26'),
(10, 1, 4, NULL, 4, 'halo', '2025-07-22 13:20:24'),
(11, 2, 6, NULL, 5, 'bau stella jeruknya enak', '2025-07-23 16:06:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `aktivitas_admin`
--
ALTER TABLE `aktivitas_admin`
  ADD PRIMARY KEY (`id_aktivitas`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id_mobil`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_pemesanan` (`id_pemesanan`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_jadwal` (`id_jadwal`),
  ADD KEY `id_mobil` (`id_mobil`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indexes for table `tujuan`
--
ALTER TABLE `tujuan`
  ADD PRIMARY KEY (`id_tujuan`),
  ADD KEY `fk_tujuan_mobil` (`id_mobil`);

--
-- Indexes for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id_ulasan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `aktivitas_admin`
--
ALTER TABLE `aktivitas_admin`
  MODIFY `id_aktivitas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id_mobil` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pemesanan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id_setting` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tujuan`
--
ALTER TABLE `tujuan`
  MODIFY `id_tujuan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id_ulasan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id_pemesanan`);

--
-- Constraints for table `tujuan`
--
ALTER TABLE `tujuan`
  ADD CONSTRAINT `fk_tujuan_mobil` FOREIGN KEY (`id_mobil`) REFERENCES `mobil` (`id_mobil`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
