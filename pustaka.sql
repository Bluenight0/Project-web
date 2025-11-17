-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 17 Nov 2025 pada 06.18
-- Versi server: 8.0.43
-- Versi PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `pustaka`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin_perpus`
--

CREATE TABLE `admin_perpus` (
  `id_admin` int NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT 'Admin',
  `tanggal_dibuat` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `admin_perpus`
--

INSERT INTO `admin_perpus` (`id_admin`, `nama_admin`, `password`, `email`, `jabatan`, `tanggal_dibuat`) VALUES
(1, 'Adit', '123456', 'adit123@gmail.com', 'Admin', '2025-11-16 12:24:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota_perpus`
--

CREATE TABLE `anggota_perpus` (
  `id_anggota` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text,
  `tanggal_daftar` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `foto` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `anggota_perpus`
--

INSERT INTO `anggota_perpus` (`id_anggota`, `nama`, `email`, `password`, `no_hp`, `alamat`, `tanggal_daftar`, `status`, `foto`) VALUES
('PA0001', 'Reza Firmansyah', 'reza@gmail.com', '123456', '08123456789', 'jln kutilang sakti', '2025-11-11 17:00:00', 'aktif', 'default.png'),
('PA0002', 'syarhan', 'kroy32697@gmail.com', '123456', '08123456789', 'jln kutilang sakti', '2025-11-12 17:00:00', 'aktif', 'PA0002.png'),
('PA0003', 'rudi', 'kro97@gmail.com', '123456', '08123456789', 'jln kutilang sakti', '2025-11-12 17:00:00', 'aktif', 'PA0003.png'),
('PA0004', 'poy', 'k97@gmail.com', '123456', '08123456789', 'jln kutilang sakti', '2025-11-12 17:00:00', 'aktif', 'PA0004.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id` int NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `jenis` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` date NOT NULL,
  `gambar` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'Tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id`, `nama`, `jenis`, `tanggal`, `gambar`, `status`) VALUES
(5, 'NARUTO 59', 'Comics & Graphic Novels', '2025-11-12', 'http://books.google.com/books/content?id=lzTMDwAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api', 'Tersedia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `event_perpus`
--

CREATE TABLE `event_perpus` (
  `id_event` int NOT NULL,
  `id_admin` int NOT NULL,
  `judul` varchar(150) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `lokasi` varchar(150) NOT NULL,
  `link_event` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `admin_perpus`
--
ALTER TABLE `admin_perpus`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `anggota_perpus`
--
ALTER TABLE `anggota_perpus`
  ADD PRIMARY KEY (`id_anggota`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `event_perpus`
--
ALTER TABLE `event_perpus`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `id_admin` (`id_admin`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin_perpus`
--
ALTER TABLE `admin_perpus`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `event_perpus`
--
ALTER TABLE `event_perpus`
  MODIFY `id_event` int NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `event_perpus`
--
ALTER TABLE `event_perpus`
  ADD CONSTRAINT `event_perpus_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin_perpus` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
