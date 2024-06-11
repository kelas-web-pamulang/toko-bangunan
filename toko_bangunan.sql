-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 11 Jun 2024 pada 16.57
-- Versi Server: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_bangunan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id_category` int(25) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id_category`, `nama`) VALUES
(1, 'Bata'),
(2, 'Semen');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembeli`
--

CREATE TABLE `pembeli` (
  `id_pembeli` int(11) NOT NULL,
  `nama_pembeli` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pembeli`
--

INSERT INTO `pembeli` (`id_pembeli`, `nama_pembeli`) VALUES
(1, 'Joko'),
(2, 'Anies'),
(3, 'Akbar'),
(4, 'Ganjar'),
(5, 'Prabowo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `id_category` int(100) NOT NULL,
  `id_pembeli` int(25) NOT NULL,
  `stock` varchar(10) CHARACTER SET utf8mb4 DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `id_category`, `id_pembeli`, `stock`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 'Batu bata', '43000', 1, 2, '30', '2024-06-04 13:10:36', '2024-06-11 20:58:35', NULL),
(7, 'Semen 10 Roda', '14000', 2, 1, '26', '2024-06-04 13:14:44', '2024-06-04 18:43:15', NULL),
(8, 'bata merah', '10000', 1, 2, '28', '2024-06-04 13:15:32', '2024-06-11 16:30:27', NULL),
(9, 'bata hebel', '25000', 1, 5, '23', '2024-06-04 16:34:09', '2024-06-11 20:52:32', NULL),
(10, 'bata putih (hebel)', '30000', 1, 1, '5', '2024-06-11 11:23:39', NULL, '2024-06-11 20:58:52'),
(11, 'semen empat roda', '70000', 2, 3, '2', '2024-06-11 11:24:10', '2024-06-11 20:52:50', NULL),
(12, 'semen padang', '45000', 2, 2, '6', '2024-06-11 11:26:08', NULL, NULL),
(13, 'semen bandung', '56000', 2, 4, '40', '2024-06-11 15:52:13', NULL, NULL),
(14, 'semen papua', '27000', 2, 1, '22', '2024-06-11 16:02:19', NULL, '2024-06-11 21:02:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(15) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `email`, `full_name`, `password`, `role`, `created_at`) VALUES
(4, 'afif@gmail.com', 'afif', '$2y$10$Zr0FhXQ2i4S4J6x38sA3H.DiV/GJau40ikD.jl.QShgLBE5DVPWCK', 'admin', '2024-06-11 15:10:31'),
(5, 'rafi@gmail.com', 'rafi', '$2y$10$qHQzqzFk2sYbxN8T9egtleK6/sYFeQpnhpxtkw7NLWZoHG9wzckHS', 'admin', '2024-06-11 15:11:12'),
(6, 'sultan@gmail.com', 'sultan', '$2y$10$5t4PG1LZttHFcQmzrXSJWefLF4UjlGgwK/xt5vjKI6Gu/bvuxx.c6', 'admin', '2024-06-11 16:25:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `pembeli`
--
ALTER TABLE `pembeli`
  ADD PRIMARY KEY (`id_pembeli`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`id_category`),
  ADD KEY `fk_pembeli` (`id_pembeli`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_pembeli` FOREIGN KEY (`id_pembeli`) REFERENCES `pembeli` (`id_pembeli`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
