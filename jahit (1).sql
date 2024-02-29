-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Feb 2024 pada 04.57
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
-- Database: `jahit`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_users` varchar(50) NOT NULL,
  `nohp` varchar(20) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`admin_id`, `email`, `username`, `password`, `nama_users`, `nohp`, `alamat`, `id_role`) VALUES
(1, 'inmaulana09@gmail.com', 'dewi09', '$2y$12$INpZHlWQ7aMw3XsqUh5ui.XUMljWYZ2EYx.ijQgXndo1B/FGEBaGS', 'Dewi Septiani', '089663366710', 'Banjar', 2),
(2, 'dewi09@gmail.com', 'Dewi09', '$2y$10$tYDNKxvfRj9UbyZv1MNf2e5lKJXU51Dc8z8hqPJGTxUduIciP1T06', 'Dewi Septiani', '089663366710', 'Banjar', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_bahan`
--

CREATE TABLE `tb_bahan` (
  `bahan_id` int(11) NOT NULL,
  `bahan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_bahan`
--

INSERT INTO `tb_bahan` (`bahan_id`, `bahan`) VALUES
(1, 'Katun'),
(2, 'Katun');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_desain`
--

CREATE TABLE `tb_desain` (
  `desain_id` int(11) NOT NULL,
  `pesanan_id` int(11) NOT NULL,
  `file_desain` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_desain`
--

INSERT INTO `tb_desain` (`desain_id`, `pesanan_id`, `file_desain`) VALUES
(1, 7, '7.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jenis`
--

CREATE TABLE `tb_jenis` (
  `jenis_id` int(11) NOT NULL,
  `jenis_jahitan` varchar(40) NOT NULL,
  `harga` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_jenis`
--

INSERT INTO `tb_jenis` (`jenis_id`, `jenis_jahitan`, `harga`) VALUES
(2, 'Kemeja', '27000'),
(3, 'Kaos', '15000'),
(6, 'Gamis', '27000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pelanggan`
--

CREATE TABLE `tb_pelanggan` (
  `pelanggan_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `foto_pelanggan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_pelanggan`
--

INSERT INTO `tb_pelanggan` (`pelanggan_id`, `username`, `password`, `nama_pelanggan`, `alamat`, `email`, `no_hp`, `foto_pelanggan`) VALUES
(3, 'inmaula09', '$2y$12$7jVZK2FG/f0l1r87MQzoBOqSHAA18bIHM5n882NIUK./cOtxp7SLC', 'Indra maulana', 'Banjar', 'inmaulana09@gmail.com', '089663366710', NULL),
(4, 'dewi09', '$2y$12$wMKBbxmXSELj52FalCqy1.2cZegKq1zk8HTvkz3UtLL4BMBpTY6Km', 'Dewi Septiani', 'Banjar', 'dewi@gmail.com', '09887787', '4.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pembayaran`
--

CREATE TABLE `tb_pembayaran` (
  `pembayaran_id` int(11) NOT NULL,
  `pesanan_id` varchar(20) NOT NULL,
  `metode_bayar` varchar(20) NOT NULL,
  `total_bayar` int(15) NOT NULL,
  `bukti_bayar` varchar(20) DEFAULT NULL,
  `status_bayar` int(2) NOT NULL,
  `pelanggan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_pembayaran`
--

INSERT INTO `tb_pembayaran` (`pembayaran_id`, `pesanan_id`, `metode_bayar`, `total_bayar`, `bukti_bayar`, `status_bayar`, `pelanggan_id`) VALUES
(13, '0602241034574', 'Cash Di Tempat', 54000, NULL, 0, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pesanan`
--

CREATE TABLE `tb_pesanan` (
  `pesanan_id` varchar(20) NOT NULL,
  `pelanggan_id` int(11) NOT NULL,
  `jenis_id` int(11) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `bahan` varchar(100) NOT NULL,
  `ukuran` varchar(10) NOT NULL,
  `status_pesanan` int(1) NOT NULL,
  `no_antrian` int(30) NOT NULL,
  `tgl_pemesanan` varchar(20) NOT NULL,
  `tgl_kirim` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_pesanan`
--

INSERT INTO `tb_pesanan` (`pesanan_id`, `pelanggan_id`, `jenis_id`, `jumlah`, `bahan`, `ukuran`, `status_pesanan`, `no_antrian`, `tgl_pemesanan`, `tgl_kirim`) VALUES
('0602241034574', 4, 2, 2, 'Katun', 'S', 0, 2, '2024-02-06', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rating`
--

CREATE TABLE `tb_rating` (
  `rating_id` int(11) NOT NULL,
  `pesanan_id` varchar(20) NOT NULL,
  `penilaian` int(5) NOT NULL,
  `komentar` varchar(100) NOT NULL,
  `status` int(1) NOT NULL,
  `pelanggan_id` int(11) NOT NULL,
  `pesan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_rating`
--

INSERT INTO `tb_rating` (`rating_id`, `pesanan_id`, `penilaian`, `komentar`, `status`, `pelanggan_id`, `pesan`) VALUES
(5, '0602241034574', 4, 'Eumm mantaff', 1, 4, 'Thanks');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_req`
--

CREATE TABLE `tb_req` (
  `req_id` int(11) NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `bahan` varchar(50) NOT NULL,
  `status` int(1) NOT NULL,
  `pelanggan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_req`
--

INSERT INTO `tb_req` (`req_id`, `jenis`, `bahan`, `status`, `pelanggan_id`) VALUES
(2, 'Gamis', 'Katun', 1, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_role`
--

CREATE TABLE `tb_role` (
  `id_role` int(11) NOT NULL,
  `nama_role` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_role`
--

INSERT INTO `tb_role` (`id_role`, `nama_role`) VALUES
(1, 'Penjahit'),
(2, 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indeks untuk tabel `tb_bahan`
--
ALTER TABLE `tb_bahan`
  ADD PRIMARY KEY (`bahan_id`);

--
-- Indeks untuk tabel `tb_desain`
--
ALTER TABLE `tb_desain`
  ADD PRIMARY KEY (`desain_id`);

--
-- Indeks untuk tabel `tb_jenis`
--
ALTER TABLE `tb_jenis`
  ADD PRIMARY KEY (`jenis_id`);

--
-- Indeks untuk tabel `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  ADD PRIMARY KEY (`pelanggan_id`);

--
-- Indeks untuk tabel `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD PRIMARY KEY (`pembayaran_id`);

--
-- Indeks untuk tabel `tb_pesanan`
--
ALTER TABLE `tb_pesanan`
  ADD PRIMARY KEY (`pesanan_id`),
  ADD UNIQUE KEY `no_antrian` (`no_antrian`);

--
-- Indeks untuk tabel `tb_rating`
--
ALTER TABLE `tb_rating`
  ADD PRIMARY KEY (`rating_id`);

--
-- Indeks untuk tabel `tb_req`
--
ALTER TABLE `tb_req`
  ADD PRIMARY KEY (`req_id`);

--
-- Indeks untuk tabel `tb_role`
--
ALTER TABLE `tb_role`
  ADD PRIMARY KEY (`id_role`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_bahan`
--
ALTER TABLE `tb_bahan`
  MODIFY `bahan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_desain`
--
ALTER TABLE `tb_desain`
  MODIFY `desain_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_jenis`
--
ALTER TABLE `tb_jenis`
  MODIFY `jenis_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  MODIFY `pelanggan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  MODIFY `pembayaran_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tb_pesanan`
--
ALTER TABLE `tb_pesanan`
  MODIFY `no_antrian` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_rating`
--
ALTER TABLE `tb_rating`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_req`
--
ALTER TABLE `tb_req`
  MODIFY `req_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_role`
--
ALTER TABLE `tb_role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
