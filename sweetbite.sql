-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2025 at 04:29 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sweetbite`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `isi` text NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `isi`, `rating`, `created_at`) VALUES
(1, 2, 'prosesnya cepet, keren banget anjay', 5, '2025-04-13 03:40:39'),
(2, 2, 'Kuenya enak hehe', 4, '2025-04-13 03:46:36'),
(3, 2, 'wahh enakk', 5, '2025-04-16 02:36:39');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `alamat` text NOT NULL,
  `status` enum('Menunggu Konfirmasi','Dikirim','Diterima') DEFAULT 'Menunggu Konfirmasi',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `user_id`, `alamat`, `status`, `created_at`) VALUES
(1, 2, 'Jl. Mawar No. 123, Jakarta', 'Dikirim', '2025-04-12 17:23:34'),
(2, 2, 'Jl. Gelatik 1 Gg. Patriot', 'Dikirim', '2025-04-12 19:39:19'),
(3, 2, 'JL.Pramuka', 'Diterima', '2025-04-12 19:46:09'),
(4, 2, 'Jl. M.Yamin', 'Dikirim', '2025-04-12 20:01:41'),
(5, 2, 'luar jawa', 'Menunggu Konfirmasi', '2025-04-15 18:22:54'),
(6, 2, 'jalan jalan', 'Menunggu Konfirmasi', '2025-04-15 18:28:52'),
(7, 2, 'aa', 'Menunggu Konfirmasi', '2025-04-15 18:36:17');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_detail`
--

CREATE TABLE `pesanan_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `produk_id` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan_detail`
--

INSERT INTO `pesanan_detail` (`id`, `order_id`, `produk_id`, `jumlah`) VALUES
(1, 1, 1, 2),
(2, 1, 3, 1),
(3, 2, 4, 2),
(4, 2, 5, 1),
(5, 2, 15, 1),
(6, 3, 5, 2),
(7, 4, 3, 1),
(8, 4, 4, 1),
(9, 5, 3, 1),
(10, 6, 3, 1),
(11, 6, 4, 1),
(12, 6, 7, 1),
(13, 6, 8, 2),
(14, 7, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama`, `deskripsi`, `harga`, `gambar`, `created_at`) VALUES
(1, 'Kue Coklat', 'Kue coklat lezat', 50000, 'kue_coklat.jpg', '2025-04-12 17:16:08'),
(2, 'Kue Vanila', 'Kue dengan rasa vanila', 45000, 'kue_vanila.jpg', '2025-04-12 17:16:08'),
(3, 'Kue Red Velvet', 'Red velvet yang menggoda', 60000, 'kue_redvelvet.jpg', '2025-04-12 17:16:08'),
(4, 'Kue Keju', 'Kue dengan keju pilihan', 55000, 'kue_keju.jpg', '2025-04-12 17:16:08'),
(5, 'Kue Pisang', 'Kue pisang enak dan lembut', 40000, 'kue_pisang.jpg', '2025-04-12 17:16:08'),
(6, 'Kue Lapis', 'Lapis legit manis', 70000, 'kue_lapis.jpg', '2025-04-12 17:16:08'),
(7, 'Kue Black Forest', 'Kue dengan krim dan ceri', 75000, 'kue_blackforest.png', '2025-04-12 17:16:08'),
(8, 'Kue Pandan', 'Kue pandan lembut dan hijau segar', 50000, 'kue_pandan.jpg', '2025-04-12 17:16:08'),
(9, 'Kue Tiramisu', 'Tiramisu yang lezat', 80000, 'kue_tiramisu.jpg', '2025-04-12 17:16:08'),
(10, 'Kue Strawberry', 'Kue dengan topping strawberry segar', 65000, 'kue_strawberry.jpg', '2025-04-12 17:16:08'),
(11, 'Kue Moka', 'Kue moka dengan rasa kopi', 52000, 'kue_moka.jpg', '2025-04-12 17:16:08'),
(13, 'Kue Mocca', 'Kue mocca coklat lezat', 48000, 'kue_mocca.jpg', '2025-04-12 17:16:08'),
(14, 'Kue Kacang', 'Kue kacang manis gurih', 42000, 'kue_kacang.jpg', '2025-04-12 17:16:08'),
(15, 'Kue Durian 2', 'Kue durian yang kaya', 76000, 'kue_durian.jpg', '2025-04-12 17:16:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pelanggan','kurir') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'passwordadmin', 'admin', '2025-04-12 17:21:53'),
(2, 'pelanggan1', 'passwordpelanggan', 'pelanggan', '2025-04-12 17:21:53'),
(3, 'kurir1', 'passwordkurir', 'kurir', '2025-04-12 17:21:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD CONSTRAINT `pesanan_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `pesanan` (`id`),
  ADD CONSTRAINT `pesanan_detail_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
