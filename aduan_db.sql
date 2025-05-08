-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 07, 2025 at 10:45 AM
-- Server version: 8.0.42-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aduan_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `aduan_layanan`
--

CREATE TABLE `aduan_layanan` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_tiket` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instansi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isi_aduan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `aduan_layanan`
--

INSERT INTO `aduan_layanan` (`id`, `nomor_tiket`, `user_id`, `nama_lengkap`, `instansi`, `isi_aduan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'AD-20250327-4054', NULL, 'Tio', 'Diskominfo', 'Awon jaringannya pak', 0, NULL, NULL),
(2, 'AD-20250327-7867', NULL, 'kucing', 'ngunyah', 'jadi begini', 1, '2025-03-27 03:08:30', '2025-03-27 03:09:39'),
(3, 'AD-20250327-2354', NULL, 'cengsoy', 'pp', 'tidak terjadi hujan', 0, '2025-03-27 03:34:40', NULL),
(4, 'AD-20250327-3035', NULL, 'cengsoy', 'indo', 'insya', 0, '2025-03-27 05:35:16', NULL),
(5, 'AD-20250327-2574', NULL, 'cahya', 'dk', 'dk', 0, '2025-03-27 06:11:21', NULL),
(6, 'AD-20250327-5665', NULL, 'cahya', 'inda', 'hah', 0, '2025-03-27 06:16:05', NULL),
(7, 'AD-20250327-4796', NULL, 'd', 'd', 'd', 1, '2025-03-27 06:17:48', NULL),
(8, 'AD-20250409-2805', NULL, 'Tio hanapinandi', 'Diskominfo', 'Jaringannya jelek', 1, '2025-04-09 02:35:24', '2025-04-09 05:05:47'),
(9, 'AD-20250410-9024', NULL, 'Hafizh', 'Diskominfo', 'Testing', 1, '2025-04-10 02:11:08', '2025-04-10 02:11:25'),
(10, 'AD-20250410-6412', NULL, '21', 'e', 'dada', 0, '2025-04-10 03:09:34', NULL),
(11, 'AD-20250410-3554', NULL, '1', '1', '1', 0, '2025-04-10 03:38:23', NULL),
(12, 'AD-20250410-7927', NULL, '1', '1', '1', 0, '2025-04-10 04:02:21', NULL),
(13, 'AD-20250410-3970', NULL, '1', '1', '1', 0, '2025-04-10 06:03:24', NULL),
(14, 'AD-20250421-3085', NULL, 'tio', 'diskominfo', 'jaringan di ruang TIK kurang baik', 0, '2025-04-21 03:11:22', NULL),
(15, 'AD-20250421-4374', NULL, 'tio haha', 'diskominf', 'jaringanna goreng pak', 1, '2025-04-21 04:10:58', '2025-04-21 04:12:29'),
(16, 'AD-20250421-4598', NULL, 'legi', 'bcondj', 'si akbar aduhai', 1, '2025-04-21 06:39:52', '2025-04-21 07:24:27'),
(17, 'AD-20250422-7204', NULL, 'Ww', 'Dhdh', 'Hdhdhc', 0, '2025-04-22 07:51:54', NULL),
(18, 'AD-20250422-3594', NULL, 'Halo', 'Hehe', '\'', 0, '2025-04-22 07:57:27', NULL),
(19, 'AD-20250422-7936', NULL, 'Wleo wleo', 'Hehehhh', 'Ishdhxbx', 0, '2025-04-22 08:00:43', NULL),
(20, 'AD-20250422-5245', NULL, 'Valen', 'Jelek', 'Pisan', 0, '2025-04-22 08:17:45', NULL),
(21, 'AD-20250423-7602', NULL, 'tio hanapiandi', 'diskominfo padang', 'jaringan ruangan bidang x bermasalah', 0, '2025-04-23 01:51:44', NULL),
(22, 'AD-20250423-6932', NULL, 'fahri akbar', 'setda', 'jaringannya jelek pak', 1, '2025-04-23 01:54:56', '2025-04-23 01:57:56'),
(23, 'AD-20250423-8272', NULL, 'Hehe', 'Hjndhx', 'Hxhxhd', 0, '2025-04-23 02:26:54', NULL),
(24, 'AD-20250423-7362', NULL, 'Jam', 'Wib', 'Hh', 0, '2025-04-23 02:35:27', NULL),
(25, 'AD-20250423-4550', NULL, 'Helmi', 'Diskominfo', 'Jaringan mati', 1, '2025-04-23 02:44:36', '2025-04-23 02:46:05'),
(26, 'AD-20250428-2699', NULL, 'Yes i did, did tolong did', 'Wheh', 'Hags', 1, '2025-04-28 07:21:54', '2025-04-28 07:24:29');

--
-- Triggers `aduan_layanan`
--
DELIMITER $$
CREATE TRIGGER `tr_aduan_layanan_created_at` BEFORE INSERT ON `aduan_layanan` FOR EACH ROW BEGIN
  SET NEW.created_at = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '2025_03_25_044829_create_aduan_layanan_table', 1),
(4, '2025_03_26_005648_create_sessions_table', 1),
(5, '2025_03_26_042200_create_permohonan_virtual_meeting_table', 1),
(6, '2025_03_26_044815_create_permohonan_vps_table', 1),
(7, '2025_03_26_062707_create_permohonan_bod_table', 1),
(8, '2025_03_27_010231_create_penerbitan_tte_table', 1),
(9, '2025_03_27_011613_create_permohonan_infrastruktur_table', 1),
(10, '2025_03_27_012638_create_permohonan_reset_email_table', 1),
(11, '2025_03_27_013441_create_permohonan_pentest_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `penerbitan_tte`
--

CREATE TABLE `penerbitan_tte` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_tiket` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instansi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_dinas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surat_permohonan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penerbitan_tte`
--

INSERT INTO `penerbitan_tte` (`id`, `nomor_tiket`, `user_id`, `nama_lengkap`, `instansi`, `email_dinas`, `surat_permohonan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'TTE-20250327-5428', '6285974363719@c.us', 'bata', 'inst', 'email@bebas.com', NULL, '1', NULL, '2025-03-27 02:52:44'),
(2, 'TTE-20250327-3773', '6282321305846@c.us', 'Tio', 'Diskominfo', 'Tiogtx@subang.go.id', NULL, '0', NULL, NULL),
(3, 'TTE-20250327-1458', '6285974363719@c.us', 'cingku', 'ngunya', 'gma@subang.xyz', NULL, '1', '2025-03-27 03:03:25', '2025-03-27 03:03:48'),
(4, 'TTE-20250327-5171', '6282129492134@c.us', 'cahya', 'pp', 'd', NULL, '1', '2025-03-27 06:34:09', '2025-03-27 06:35:23'),
(5, 'TTE-20250410-6974', '6282129492134@c.us', '8', '8', '8', NULL, '0', '2025-04-10 03:33:34', NULL),
(6, 'TTE-20250421-6847', '6282321305846@c.us', 'tio hanaf', 'diskom', 'tioaja@subang.go.id', NULL, '0', '2025-04-21 03:47:24', NULL),
(7, 'TTE-20250421-8500', '6281299210369@c.us', 'nshs', 'jsusn', 'izuve', NULL, '0', '2025-04-21 06:46:53', NULL);

--
-- Triggers `penerbitan_tte`
--
DELIMITER $$
CREATE TRIGGER `tr_penerbitan_tte_created_at` BEFORE INSERT ON `penerbitan_tte` FOR EACH ROW BEGIN
  SET NEW.created_at = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `permohonan_bod`
--

CREATE TABLE `permohonan_bod` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_tiket` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instansi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_koneksi_peruntukan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surat_permohonan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permohonan_bod`
--

INSERT INTO `permohonan_bod` (`id`, `nomor_tiket`, `user_id`, `nama_lengkap`, `instansi`, `jenis_koneksi_peruntukan`, `lokasi`, `surat_permohonan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'BOD-20250327-8176', '6285974363719@c.us', 'nama', 'instansi', 'kabel acara', 'alun alun', '/root/venom-bot-aduan/uploads/1743045154706-6285974363719@c.us.pdf', 1, '2025-03-27 03:12:34', '2025-03-27 03:21:31'),
(2, 'BOD-20250410-9151', '6282129492134@c.us', '4', '4', '4', '4', '/root/venom-bot-aduan/uploads/1744256168150-6282129492134@c.us.png', 0, '2025-04-10 03:36:08', NULL),
(3, 'BOD-20250421-2950', '6282321305846@c.us', 'tio', 'diskominfoo', 'Fiber optik untuk kegiatan konser di alun-alun', 'Alun-Alun Sabtu, 28 April 2025', '/root/venom-bot-aduan/uploads/1745205180212-6282321305846@c.us.pdf', 0, '2025-04-21 03:13:00', NULL),
(4, 'BOD-20250421-1094', '6281299210369@c.us', 'neihd', 'jsind', 'xiend', 'kdjd', '/root/venom-bot-aduan/uploads/1745217844444-6281299210369@c.us.pdf', 1, '2025-04-21 06:44:04', '2025-04-21 07:28:18');

--
-- Triggers `permohonan_bod`
--
DELIMITER $$
CREATE TRIGGER `tr_permohonan_bod_created_at` BEFORE INSERT ON `permohonan_bod` FOR EACH ROW BEGIN
  SET NEW.created_at = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `permohonan_infrastruktur`
--

CREATE TABLE `permohonan_infrastruktur` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_tiket` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instansi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_koneksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surat_permohonan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permohonan_infrastruktur`
--

INSERT INTO `permohonan_infrastruktur` (`id`, `nomor_tiket`, `user_id`, `nama_lengkap`, `instansi`, `jenis_koneksi`, `lokasi`, `surat_permohonan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'INFRA-20250327-5233', '6282321305846@c.us', 'P', 'Diskominfo', 'Vlan', 'Cicaheum', '/root/venom-bot-aduan/uploads/1743044438766-6282321305846@c.us.pdf', 0, NULL, NULL),
(2, 'INFRA-20250410-7896', '6282129492134@c.us', '5', '5', '5', '5', '/root/venom-bot-aduan/uploads/1744256121134-6282129492134@c.us.png', 0, '2025-04-10 03:35:21', NULL),
(3, 'INFRA-20250421-9472', '6282321305846@c.us', 'tio hana', 'diskominfooo', 'Fiber Optik', 'Ruang statistik Gedung Baru', '/root/venom-bot-aduan/uploads/1745205371263-6282321305846@c.us.pdf', 0, '2025-04-21 03:16:11', NULL),
(4, 'INFRA-20250421-4070', '6281299210369@c.us', 'ndid', 'beid', 'nsis', 'nzish', '/root/venom-bot-aduan/uploads/1745217900472-6281299210369@c.us.pdf', 0, '2025-04-21 06:45:00', NULL),
(5, 'INFRA-20250423-9110', '6282118215199@c.us', 'Helmi', 'Diskominfo', 'LAN', 'Bidang tik', '/root/venom-bot-aduan/uploads/1745376855262-6282118215199@c.us.pdf', 0, '2025-04-23 02:54:15', NULL);

--
-- Triggers `permohonan_infrastruktur`
--
DELIMITER $$
CREATE TRIGGER `tr_permohonan_infrastruktur_created_at` BEFORE INSERT ON `permohonan_infrastruktur` FOR EACH ROW BEGIN
  SET NEW.created_at = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `permohonan_pentest`
--

CREATE TABLE `permohonan_pentest` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_tiket` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instansi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_aplikasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surat_permohonan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permohonan_pentest`
--

INSERT INTO `permohonan_pentest` (`id`, `nomor_tiket`, `user_id`, `nama_lengkap`, `instansi`, `nama_aplikasi`, `surat_permohonan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'PENTEST-20250410-5463', '6282129492134@c.us', '7', '7', '7', '/root/venom-bot-aduan/uploads/1744256050798-6282129492134@c.us.png', 0, '2025-04-10 03:34:10', NULL),
(2, 'PENTEST-20250421-5202', '6282321305846@c.us', 'tio hana', 'diskominf', 'sianj', '/root/venom-bot-aduan/uploads/1745207015594-6282321305846@c.us.pdf', 0, '2025-04-21 03:43:35', NULL),
(3, 'PENTEST-20250421-8248', '6281299210369@c.us', 'kahgs', 'jaus', 'nsugs', '/root/venom-bot-aduan/uploads/1745217984809-6281299210369@c.us.pdf', 0, '2025-04-21 06:46:24', NULL);

--
-- Triggers `permohonan_pentest`
--
DELIMITER $$
CREATE TRIGGER `tr_permohonan_pentest_created_at` BEFORE INSERT ON `permohonan_pentest` FOR EACH ROW BEGIN
  SET NEW.created_at = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `permohonan_reset_email`
--

CREATE TABLE `permohonan_reset_email` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_tiket` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instansi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_dinas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surat_permohonan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permohonan_reset_email`
--

INSERT INTO `permohonan_reset_email` (`id`, `nomor_tiket`, `user_id`, `nama_lengkap`, `instansi`, `email_dinas`, `surat_permohonan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'RESET-20250410-9188', '6282129492134@c.us', '6', '6', '6', '/root/venom-bot-aduan/uploads/1744256086888-6282129492134@c.us.png', 0, '2025-04-10 03:34:46', NULL),
(2, 'RESET-20250421-4829', '6282321305846@c.us', 'tio hana', 'diskominfoooo', 'tiohana@subang.go.id', '/root/venom-bot-aduan/uploads/1745206692380-6282321305846@c.us.pdf', 0, '2025-04-21 03:38:12', NULL),
(3, 'RESET-20250421-9970', '6281299210369@c.us', 'ushs', 'ishs', 'nsis', '/root/venom-bot-aduan/uploads/1745217939147-6281299210369@c.us.pdf', 0, '2025-04-21 06:45:39', NULL);

--
-- Triggers `permohonan_reset_email`
--
DELIMITER $$
CREATE TRIGGER `tr_permohonan_reset_email_created_at` BEFORE INSERT ON `permohonan_reset_email` FOR EACH ROW BEGIN
  SET NEW.created_at = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `permohonan_virtual_meeting`
--

CREATE TABLE `permohonan_virtual_meeting` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_tiket` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instansi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `topik_meeting` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu_pelaksanaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_partisipan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `durasi_meeting` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi_meeting` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_operator` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surat_permohonan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permohonan_virtual_meeting`
--

INSERT INTO `permohonan_virtual_meeting` (`id`, `nomor_tiket`, `user_id`, `nama_lengkap`, `instansi`, `topik_meeting`, `waktu_pelaksanaan`, `jumlah_partisipan`, `durasi_meeting`, `lokasi_meeting`, `link_operator`, `surat_permohonan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'VM-20250327-1760', '6285974363719@c.us', '9', '9', '9', '9', '90', '180', '900', '9', '/root/venom-bot-aduan/uploads/1743045058481-6285974363719@c.us.pdf', 0, '2025-03-27 03:10:58', NULL),
(2, 'VM-20250410-3238', '6282129492134@c.us', 'w', 'w', 'e', '33333', '44', '90', 't', 'tt', '/root/venom-bot-aduan/uploads/1744255955472-6282129492134@c.us.png', 0, '2025-04-10 03:32:35', NULL),
(3, 'VM-20250410-3361', '6282129492134@c.us', '2', '2', '2``', '2', '2', '22', '2w', 'wwwwwwwwwwwww', '/root/venom-bot-aduan/uploads/1744256270119-6282129492134@c.us.png', 0, '2025-04-10 03:37:50', NULL),
(4, 'VM-20250421-2476', '6282321305846@c.us', 'tio', 'Diskominfo', 'inflasi', '2025-04-21 10:00', '100', '120 Menit', 'online', 'link only', '/root/venom-bot-aduan/uploads/1745204288112-6282321305846@c.us.pdf', 0, '2025-04-21 02:58:08', NULL),
(5, 'VM-20250421-2726', '6281299210369@c.us', 'ndibd', 'neind', 'jengd', '2025-04-21 13:41', '34', '40', 'tanjungsiang', 'Tidak Ada', '/root/venom-bot-aduan/uploads/1745217745326-6281299210369@c.us.pdf', 1, '2025-04-21 06:42:25', '2025-04-21 07:26:32'),
(6, 'VM-20250422-2143', '6281915158041@c.us', 'Wjwiwi', 'Jxjc', 'Jfjdj', '2025-10-21', '100', '120', 'J', 'Jd', '/root/venom-bot-aduan/uploads/1745309019002-6281915158041@c.us.pdf', 0, '2025-04-22 08:03:39', NULL);

--
-- Triggers `permohonan_virtual_meeting`
--
DELIMITER $$
CREATE TRIGGER `tr_permohonan_virtual_meeting_created_at` BEFORE INSERT ON `permohonan_virtual_meeting` FOR EACH ROW BEGIN
  SET NEW.created_at = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `permohonan_vps`
--

CREATE TABLE `permohonan_vps` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_tiket` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instansi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spesifikasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surat_permohonan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permohonan_vps`
--

INSERT INTO `permohonan_vps` (`id`, `nomor_tiket`, `user_id`, `nama_lengkap`, `instansi`, `spesifikasi`, `surat_permohonan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'VPS-20250327-4928', '6282129492134@c.us', 'ce ngaku', 'ha', 'sy', '/root/venom-bot-aduan/uploads/1743053493687-6282129492134@c.us.pdf', 0, '2025-03-27 05:31:33', NULL),
(2, 'VPS-20250410-6070', '6282129492134@c.us', '3', 'asu', 'd', '/root/venom-bot-aduan/uploads/1744256212032-6282129492134@c.us.png', 0, '2025-04-10 03:36:52', NULL),
(3, 'VPS-20250421-7121', '6282321305846@c.us', 'tio', 'diskominfo', '4cpu core\n8GB Ram\n128 GB Storage', '/root/venom-bot-aduan/uploads/1745205045588-6282321305846@c.us.pdf', 0, '2025-04-21 03:10:45', NULL),
(4, 'VPS-20250421-8078', '6281299210369@c.us', 'kevd', 'osbhd', 'ndidbd', '/root/venom-bot-aduan/uploads/1745217797923-6281299210369@c.us.octet-stream', 1, '2025-04-21 06:43:17', '2025-04-21 07:27:54');

--
-- Triggers `permohonan_vps`
--
DELIMITER $$
CREATE TRIGGER `tr_permohonan_vps_created_at` BEFORE INSERT ON `permohonan_vps` FOR EACH ROW BEGIN
  SET NEW.created_at = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1kfONRrcoznbjMd4GtaBQcY485pqlX1uZ7HCBQy4', 1, '10.200.66.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNXFUNGpMT1BGeVBhdVJwS0JiRXZtbzF2TGVvaHJFWmxNNzJERGZnaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xNzIuMTYuMzMuMTI6ODAwMC9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo1OiJhbGVydCI7YTowOnt9fQ==', 1745220584),
('EazpNv1IcZZJdF0DM1CS7C1Ttzk0nk4xsAKfKLys', 1, '10.200.66.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiV3ZmcEVJaFBNT3RYRDJSeXB2bGs3b054T0ZJaGFUV0RpMHFLTm1CWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozODoiaHR0cDovLzE3Mi4xNi4zMy4xMjo4MDAwL2FkdWFuLWxheWFuYW4iO31zOjU6ImFsZXJ0IjthOjA6e319', 1745825069),
('jP2DsVbklpIpFInxSQlusQVUptnqFu1sGDn8tnee', 1, '10.200.66.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSzJXWFk5RnJvQnVGSXB5SkZPZkNsMngyM0tOaTBzYnRIWmh0dzZhdCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozODoiaHR0cDovLzE3Mi4xNi4zMy4xMjo4MDAwL2FkdWFuLWxheWFuYW4iO31zOjU6ImFsZXJ0IjthOjA6e319', 1745209270),
('O8vU7EqBShbFESlkeCxDmbKZO6esWdHmvGBkEC8i', 1, '10.200.66.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaDJiNmJQUjkyTmhsYXRubjZ5VHFYTGpadzhKZGttVWJTZ1hSSzZRcSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozODoiaHR0cDovLzE3Mi4xNi4zMy4xMjo4MDAwL2FkdWFuLWxheWFuYW4iO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMDoiaHR0cDovLzE3Mi4xNi4zMy4xMjo4MDAwL2FkbWluIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1745913155),
('x3Uh78eMWwbJVpf3p6ZEHAAFbyR12fTnH1nnyRDz', 1, '10.200.66.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRUlCTGpMd0Y5U1A2SzRQclpQc0RCemNwTm9xdVp5bU51R3N5b2RFMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly8xNzIuMTYuMzMuMTI6ODAwMC9iYW5kd2lkdGgtb24tZGVtYW5kIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjU6ImFsZXJ0IjthOjA6e319', 1744256423),
('ZpAhulxOZRqOmyHPYnqAERaLMLQ7qcmUEIYHTkNf', 1, '10.200.66.3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSHVwdGM1TEtGTWF1V0IydmtuVmlOMFRqamFuQjJqcHdsVGNmNnJIOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xNzIuMTYuMzMuMTI6ODAwMC9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1745377840),
('zWFWJLuveBTv8Bz22XIdt1w1DvRWlsKZ4BkR4mA7', 1, '10.200.66.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRzNGYWc4dWppY2lBU2ZaOEhBaUs2ZXNETWJtRmNNSWFtV0xkSE02QSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MDoiaHR0cDovLzE3Mi4xNi4zMy4xMjo4MDAwL3ZpcnR1YWwtbWVldGluZyI7fXM6NToiYWxlcnQiO2E6MDp7fX0=', 1745382126);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','ketua_tim','kepala_bidang') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ketua_tim',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin@mail.id', '$2y$12$MlYJ9g.p1dOHby92YbrdK.aK9TwdD2FsILSQA9ESrxKh606u55TDy', 'admin', NULL, '2025-03-26 18:59:44', '2025-03-26 18:59:44'),
(2, 'ketua@mail.id', '$2y$12$fGokBoYC5FFSj0UcAJNAFeva/4W4O2vKTUwzlEau6qtnedD//u.Au', 'ketua_tim', NULL, '2025-03-26 18:59:44', '2025-03-26 18:59:44'),
(3, 'kabid@mail.id', '$2y$12$jvIX9jSvBGjGA358yubs6OTS5E.UdrLYMfHzUVDLDdD9Vf/Fg2aES', 'kepala_bidang', NULL, '2025-03-26 18:59:44', '2025-03-26 18:59:44');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_semua_nomor_tiket`
-- (See below for the actual view)
--
CREATE TABLE `view_semua_nomor_tiket` (
`created_at` timestamp
,`jenis_layanan` varchar(26)
,`nomor_tiket` varchar(255)
,`status` varchar(4)
);

-- --------------------------------------------------------

--
-- Structure for view `view_semua_nomor_tiket`
--
DROP TABLE IF EXISTS `view_semua_nomor_tiket`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_semua_nomor_tiket`  AS SELECT 'aduan_layanan' AS `jenis_layanan`, `aduan_layanan`.`nomor_tiket` AS `nomor_tiket`, `aduan_layanan`.`created_at` AS `created_at`, `aduan_layanan`.`status` AS `status` FROM `aduan_layanan` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aduan_layanan`
--
ALTER TABLE `aduan_layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penerbitan_tte`
--
ALTER TABLE `penerbitan_tte`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permohonan_bod`
--
ALTER TABLE `permohonan_bod`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permohonan_infrastruktur`
--
ALTER TABLE `permohonan_infrastruktur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permohonan_pentest`
--
ALTER TABLE `permohonan_pentest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permohonan_reset_email`
--
ALTER TABLE `permohonan_reset_email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permohonan_virtual_meeting`
--
ALTER TABLE `permohonan_virtual_meeting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permohonan_vps`
--
ALTER TABLE `permohonan_vps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_foreign` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aduan_layanan`
--
ALTER TABLE `aduan_layanan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `penerbitan_tte`
--
ALTER TABLE `penerbitan_tte`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `permohonan_bod`
--
ALTER TABLE `permohonan_bod`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permohonan_infrastruktur`
--
ALTER TABLE `permohonan_infrastruktur`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permohonan_pentest`
--
ALTER TABLE `permohonan_pentest`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permohonan_reset_email`
--
ALTER TABLE `permohonan_reset_email`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permohonan_virtual_meeting`
--
ALTER TABLE `permohonan_virtual_meeting`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `permohonan_vps`
--
ALTER TABLE `permohonan_vps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
