-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2025 at 05:19 PM
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
-- Database: `sortiran`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kategori` enum('makanan','minuman') NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `supplier_id` int(11) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama`, `kategori`, `stok`, `supplier_id`, `harga`, `create_at`) VALUES
(1, 'Roti', 'makanan', 40, 1, 10000.00, '2025-04-10 10:03:22'),
(2, 'Susu', 'minuman', 100, 2, NULL, '2025-04-10 10:03:22'),
(3, 'Biskuit', 'makanan', 150, 3, NULL, '2025-04-10 10:03:22'),
(4, 'Teh Botol', 'minuman', 170, 1, NULL, '2025-04-10 10:03:22'),
(5, 'Kopi', 'minuman', 180, 2, NULL, '2025-04-10 10:03:22');

-- --------------------------------------------------------

--
-- Table structure for table `detail_distribusi`
--

CREATE TABLE `detail_distribusi` (
  `id_detail_distribusi` int(11) NOT NULL,
  `distribusi_id` int(11) DEFAULT NULL,
  `barang_id` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` decimal(12,2) DEFAULT NULL,
  `tujuan` varchar(50) DEFAULT NULL,
  `tanggal_distribusi` date DEFAULT NULL,
  `keterangan` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_distribusi`
--

INSERT INTO `detail_distribusi` (`id_detail_distribusi`, `distribusi_id`, `barang_id`, `jumlah`, `harga`, `tujuan`, `tanggal_distribusi`, `keterangan`) VALUES
(10, NULL, 1, 20, 10000.00, NULL, NULL, 'Berhasil Terkirim'),
(11, NULL, 1, 10, 10000.00, NULL, NULL, 'Berhasil Terkirim'),
(12, NULL, 1, 30, 10000.00, 'RUmah', '2025-04-10', NULL),
(13, NULL, 2, 100, NULL, 'Patak', '2025-04-10', 'Berhasil Terkirim');

-- --------------------------------------------------------

--
-- Table structure for table `distribusi`
--

CREATE TABLE `distribusi` (
  `id_distribusi` int(11) NOT NULL,
  `barang_id` int(11) DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `tujuan` varchar(50) NOT NULL,
  `tanggal_distribusi` date NOT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `distribusi`
--

INSERT INTO `distribusi` (`id_distribusi`, `barang_id`, `jumlah`, `tujuan`, `tanggal_distribusi`, `harga`, `created_at`) VALUES
(11, 4, 10, 'Restoran C', '2025-04-10', NULL, '2025-04-10 14:46:16');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kontak` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama`, `kontak`, `alamat`, `created_at`) VALUES
(1, 'Supplier A', '081234567890', 'Jl. Raya No.1', '2025-04-02 03:00:51'),
(2, 'Supplier B', '082345678901', 'Jl. Merdeka No.2', '2025-04-02 03:00:51'),
(3, 'Supplier C', '083456789012', 'Jl. Sudirman No.3', '2025-04-02 03:00:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `detail_distribusi`
--
ALTER TABLE `detail_distribusi`
  ADD PRIMARY KEY (`id_detail_distribusi`),
  ADD KEY `distribusi_id` (`distribusi_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `distribusi`
--
ALTER TABLE `distribusi`
  ADD PRIMARY KEY (`id_distribusi`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `detail_distribusi`
--
ALTER TABLE `detail_distribusi`
  MODIFY `id_detail_distribusi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `distribusi`
--
ALTER TABLE `distribusi`
  MODIFY `id_distribusi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id_supplier`) ON DELETE SET NULL;

--
-- Constraints for table `detail_distribusi`
--
ALTER TABLE `detail_distribusi`
  ADD CONSTRAINT `detail_distribusi_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`),
  ADD CONSTRAINT `fk_distribusi` FOREIGN KEY (`distribusi_id`) REFERENCES `distribusi` (`id_distribusi`) ON DELETE SET NULL;

--
-- Constraints for table `distribusi`
--
ALTER TABLE `distribusi`
  ADD CONSTRAINT `distribusi_ibfk_1` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
