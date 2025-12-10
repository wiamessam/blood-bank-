-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Des 2025 pada 15.31
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_upgrade`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','superadmin') DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'superadmin', '2025-12-04 17:00:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `blood_type` varchar(5) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `queue_no` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `appointments`
--

INSERT INTO `appointments` (`id`, `schedule_id`, `name`, `phone`, `blood_type`, `birthdate`, `queue_no`, `created_at`) VALUES
(1, 3, 'LUGAS', '089670990753`', 'O+', NULL, 1, '2025-12-04 17:01:59'),
(2, 3, 'WISNU', '089670123998', 'A+', NULL, 2, '2025-12-04 17:02:14'),
(3, 3, 'WISNU', '089670123998', 'A+', NULL, 3, '2025-12-04 17:02:18'),
(4, 3, 'WISNU ADJI', '089670990876221', 'O', '0000-00-00', 4, '2025-12-05 11:23:19'),
(5, 3, 'WISNU ADJI', '089670990876221', 'O', '0000-00-00', 5, '2025-12-05 11:26:41'),
(6, 1, 'WISNU ADJI', '089670990876221', 'A', '2002-02-22', 1, '2025-12-05 11:31:49'),
(7, 1, 'WISNU ADJI', '089670990876221', 'A', '2002-02-22', 2, '2025-12-05 11:34:01'),
(8, 1, 'WISNU ADJI', '089670990876221', 'A', '2002-02-22', 3, '2025-12-05 11:34:06'),
(9, 1, 'REVA', '089670990753', 'A', '1990-11-11', 4, '2025-12-05 11:34:29'),
(10, 1, 'REVA', '089670990753', 'A', '1990-11-11', 5, '2025-12-05 11:37:37'),
(11, 1, 'awi', '0812178218192', 'A', '2000-12-05', 6, '2025-12-05 11:38:00'),
(12, 1, 'awi', '0812178218192', 'A', '2000-12-05', 7, '2025-12-05 11:38:19'),
(13, 1, 'awi', '0812178218192', 'A', '2000-12-05', 8, '2025-12-05 11:39:19'),
(14, 1, 'awi', '0812178218192', 'A', '2000-12-05', 9, '2025-12-05 11:43:09'),
(15, 1, 'awi', '0812178218192', 'A', '2000-12-05', 10, '2025-12-05 11:44:01'),
(16, 1, 'awi', '0812178218192', 'A', '2000-12-05', 11, '2025-12-05 11:45:51'),
(17, 1, 'awi', '0812178218192', 'A', '2000-12-05', 12, '2025-12-05 11:46:34'),
(18, 1, 'Muhammad Wisnu Adji', '089670990753', 'O', '2002-02-22', 13, '2025-12-05 11:51:06'),
(19, 1, 'WISNU ADJI', '089670990876221', 'B', '1990-11-21', 14, '2025-12-05 11:52:58'),
(20, 5, 'Muhammad Wisnu Adji', '0891209199', 'O', '2002-02-22', 1, '2025-12-05 12:07:31'),
(21, 1, 'WISNU ADJI', '089609092189289', 'O', '2002-02-22', 15, '2025-12-05 12:10:09'),
(22, 1, 'WISNU ADJI', '089609092189289', 'O', '2002-02-22', 16, '2025-12-05 12:12:26'),
(23, 1, 'WISNU ADJI', '089670990876221', 'O', '2002-02-22', 17, '2025-12-05 12:17:54'),
(24, 5, 'Muhammad Wisnu Adji', '0891209199', 'O', '2002-02-22', 2, '2025-12-05 12:19:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hospitals`
--

CREATE TABLE `hospitals` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `hospitals`
--

INSERT INTO `hospitals` (`id`, `name`, `address`, `phone`, `created_at`) VALUES
(1, 'RSU Ananda', 'Jl. Contoh No.1', '081234567890', '2025-12-04 17:00:48'),
(2, 'Puskesmas Barat', 'Jl. Barat No.5', '081298765432', '2025-12-04 17:00:48'),
(3, 'Rumah Sakit Margono Soekarjo Purwokerto', 'Jl. Pwt Barat', '0891209199', '2025-12-04 17:07:12'),
(4, 'Puskesmas Cilongok', 'Jl Cikidang', '1029108', '2025-12-04 17:44:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `slot_total` int(11) DEFAULT NULL,
  `slot_available` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `schedules`
--

INSERT INTO `schedules` (`id`, `hospital_id`, `tanggal`, `slot_total`, `slot_available`, `created_at`) VALUES
(1, 3, '2025-12-08', 20, 3, '2025-12-04 17:00:48'),
(3, 2, '2025-12-07', 10, 5, '2025-12-04 17:00:48'),
(4, 2, '2025-12-10', 11, 11, '2025-12-04 17:42:17'),
(5, 1, '2025-12-11', 10, 8, '2025-12-04 17:42:35');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indeks untuk tabel `hospitals`
--
ALTER TABLE `hospitals`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hospital_id` (`hospital_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `hospitals`
--
ALTER TABLE `hospitals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
