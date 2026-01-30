-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 30, 2026 at 03:07 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventaris-kelurahan`
--

-- --------------------------------------------------------

--
-- Table structure for table `asets`
--

CREATE TABLE `asets` (
  `id_aset` bigint UNSIGNED NOT NULL,
  `jenis_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identitas_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pengelola_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_perolehan` date DEFAULT NULL,
  `nilai_perolehan` decimal(15,2) DEFAULT NULL,
  `nilai_saat_ini` decimal(15,2) DEFAULT NULL,
  `jumlah` int NOT NULL DEFAULT '0',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `qr_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asets`
--

INSERT INTO `asets` (`id_aset`, `jenis_barang`, `kode_barang`, `identitas_barang`, `foto`, `pengelola_barang`, `tahun_perolehan`, `nilai_perolehan`, `nilai_saat_ini`, `jumlah`, `keterangan`, `qr_code`, `created_at`, `updated_at`) VALUES
(1, 'Mobils', '01.01.01.001.001', 'Toyota Avanza (AB 0989 YG)', 'aset/GnCj250I2eTOm1GXB8Z4e1LUSE2AYtE80lWV9t1H.jpg', 'Boby Pragiwacana Saputra Satyanodisa', '2026-01-29', '128000000.00', '128000000.00', 12, 'asd', NULL, '2026-01-28 17:23:13', '2026-01-28 21:28:22'),
(2, 'Kursi', '02.02.01.004.002', 'Kursi Plastik', 'aset/oekdrz2nlfWE82gOxgHODcqlPRkJch6GbtF0mgiN.jpg', 'Rudi', '2026-01-06', '30000.00', '30000.00', 78, 'lklk', NULL, '2026-01-28 21:27:25', '2026-01-28 21:27:25');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_28_090104_asets_table', 1),
(5, '2025_10_28_090159_peminjams_table', 1),
(6, '2025_10_28_120948_peminjamans_table', 1),
(7, '2025_12_09_150725_add_jumlah_to_asets_table', 1),
(8, '2026_01_28_144417_add_user_id_to_peminjams_table', 2),
(9, '2026_01_28_144451_add_role_to_users_table', 2),
(10, '2026_01_28_145006_add_created_by_role_to_peminjamans_table', 2),
(11, '2026_01_28_145407_update_status_enum_on_peminjamans_table', 2),
(12, '2026_01_28_232439_add_foto_to_asets_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjamans`
--

CREATE TABLE `peminjamans` (
  `id_peminjaman` bigint UNSIGNED NOT NULL,
  `id_peminjam` bigint UNSIGNED NOT NULL,
  `id_aset` bigint UNSIGNED NOT NULL,
  `tanggal_pinjam` datetime NOT NULL,
  `tanggal_kembali` datetime NOT NULL,
  `status` enum('pending','dipinjam','ditolak','dikembalikan') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `created_by_role` enum('admin','peminjam') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peminjamans`
--

INSERT INTO `peminjamans` (`id_peminjaman`, `id_peminjam`, `id_aset`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `created_by_role`, `jumlah`, `created_at`, `updated_at`) VALUES
(4, 1, 1, '2026-01-29 04:09:00', '2026-01-31 11:09:00', 'dipinjam', 'peminjam', 1, '2026-01-28 21:09:39', '2026-01-29 19:10:51'),
(5, 6, 1, '2026-01-29 04:23:00', '2026-01-31 11:23:00', 'pending', 'peminjam', 1, '2026-01-28 21:23:14', '2026-01-28 21:23:14'),
(6, 7, 1, '2026-01-30 02:09:00', '2026-01-30 09:09:00', 'pending', 'peminjam', 1, '2026-01-29 19:10:05', '2026-01-29 19:10:05');

-- --------------------------------------------------------

--
-- Table structure for table `peminjams`
--

CREATE TABLE `peminjams` (
  `id_peminjam` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_peminjam` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peminjams`
--

INSERT INTO `peminjams` (`id_peminjam`, `user_id`, `nik`, `nama_peminjam`, `no_telp`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 1, '1872042208050009', 'Bob', '087832761232', 'Solo', NULL, NULL),
(6, 7, '1872042208050008', 'Reza Azhari', '087863253521', 'Metro', '2026-01-28 21:20:05', '2026-01-28 21:20:28'),
(7, 8, NULL, 'Bob', '087863253212', 'Lampung', '2026-01-29 19:09:13', '2026-01-29 19:09:13');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('9F3iWhkaZsqbenHHX0wm8ESpsZLtCp8dByw7PFLX', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUTRxUDZiMTl4ZzU2RXRRRHcwcDJ5ME03VUZzbFdYZnhuMzdpWG9EOSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW1pbmphbWFuIjtzOjU6InJvdXRlIjtzOjE2OiJwZW1pbmphbWFuLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1769739076);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('isAdmin','isPeminjam') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'isPeminjam',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Bobs', 'azharireza370@gmail.com', NULL, '$2y$12$OVUULT8f0Po1apcySgbUqu3yFi1.itePu.dcnFljPVSy0F3bEH78u', 'isPeminjam', NULL, '2026-01-28 08:54:54', '2026-01-28 19:00:26'),
(2, 'Admins', 'rezaazhari867@gmail.com', '2026-01-28 11:02:54', '$2y$12$zOrzLG4HyhAbYQP7j18tfOvSnEdObZz6xYk3sEkC9PEIpcJoIJ.gi', 'isAdmin', 'NONG8ZRmW09e9BvKNihvmRJDJ69s5UtJDygZlWPmbM8yBqg55ch9cvWBxZ02', '2026-01-28 11:02:54', '2026-01-28 19:00:48'),
(7, 'Reza Azhari', 'azharireza090@gmail.com', NULL, '$2y$12$zZI57lKvbxIWJDO4haoISuj3e77zg6l4C9RZBgwBX4mtLfJufzfmq', 'isPeminjam', NULL, '2026-01-28 21:20:05', '2026-01-28 22:33:55'),
(8, 'Bob', 'bob@gmail.com', NULL, '$2y$12$jDpG5MwXvy3Dy1BpoKMSd.zFNn3Nb0BnLIbtsVeSvd0a4GFeuIzRC', 'isPeminjam', NULL, '2026-01-29 19:09:13', '2026-01-29 19:09:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asets`
--
ALTER TABLE `asets`
  ADD PRIMARY KEY (`id_aset`);

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `peminjamans_id_peminjam_foreign` (`id_peminjam`),
  ADD KEY `peminjamans_id_aset_foreign` (`id_aset`);

--
-- Indexes for table `peminjams`
--
ALTER TABLE `peminjams`
  ADD PRIMARY KEY (`id_peminjam`),
  ADD UNIQUE KEY `peminjams_nik_unique` (`nik`),
  ADD KEY `peminjams_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asets`
--
ALTER TABLE `asets`
  MODIFY `id_aset` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `peminjamans`
--
ALTER TABLE `peminjamans`
  MODIFY `id_peminjaman` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `peminjams`
--
ALTER TABLE `peminjams`
  MODIFY `id_peminjam` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD CONSTRAINT `peminjamans_id_aset_foreign` FOREIGN KEY (`id_aset`) REFERENCES `asets` (`id_aset`) ON DELETE CASCADE,
  ADD CONSTRAINT `peminjamans_id_peminjam_foreign` FOREIGN KEY (`id_peminjam`) REFERENCES `peminjams` (`id_peminjam`) ON DELETE CASCADE;

--
-- Constraints for table `peminjams`
--
ALTER TABLE `peminjams`
  ADD CONSTRAINT `peminjams_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
