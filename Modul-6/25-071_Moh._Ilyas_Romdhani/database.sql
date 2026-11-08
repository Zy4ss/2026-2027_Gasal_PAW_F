-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 08, 2026 at 04:46 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_penjualan`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga` int NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `supplier_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `harga`, `stok`, `supplier_id`) VALUES
(1, 'BRG001', 'Buku Tulis', 5000, 100, 1),
(2, 'BRG002', 'Pulpen', 3000, 150, 2),
(3, 'BRG003', 'Pensil', 2500, 120, 3),
(4, 'BRG004', 'Penghapus', 2000, 80, 4),
(5, 'BRG005', 'Penggaris', 4000, 90, 5),
(6, 'BRG006', 'Spidol', 7000, 60, 1),
(7, 'BRG007', 'Map Plastik', 3500, 70, 2);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `jenis_kelamin`, `telp`, `alamat`) VALUES
('PLG001', 'Andi Saputra', 'L', '081300000001', 'Surabaya'),
('PLG002', 'Budi Santoso', 'L', '081300000002', 'Bangkalan'),
('PLG003', 'Citra Lestari', 'P', '081300000003', 'Sidoarjo'),
('PLG004', 'Dewi Anggraini', 'P', '081300000004', 'Gresik'),
('PLG005', 'Eko Prasetyo', 'L', '081300000005', 'Sumenep');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int NOT NULL,
  `waktu_bayar` datetime NOT NULL,
  `total` int NOT NULL,
  `metode` enum('TUNAI','TRANSFER','EDC') NOT NULL,
  `transaksi_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `waktu_bayar`, `total`, `metode`, `transaksi_id`) VALUES
(1, '2026-10-01 10:00:00', 19000, 'TUNAI', 1),
(2, '2026-10-02 10:00:00', 14000, 'TRANSFER', 2),
(3, '2026-10-03 10:00:00', 19000, 'EDC', 3),
(4, '2026-10-04 10:00:00', 12000, 'TRANSFER', 4),
(5, '2026-10-05 10:00:00', 20000, 'TUNAI', 5),
(6, '2026-10-06 10:00:00', 14000, 'EDC', 6),
(7, '2026-10-07 10:00:00', 17500, 'TUNAI', 7),
(8, '2026-10-08 10:00:00', 22500, 'TRANSFER', 8),
(9, '2026-10-09 10:00:00', 10000, 'EDC', 9),
(10, '2026-10-10 10:00:00', 15000, 'TRANSFER', 10);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `telp`, `alamat`) VALUES
(1, 'CV Sumber Makmur', '081234567801', 'Surabaya'),
(2, 'PT Maju Jaya', '081234567802', 'Sidoarjo'),
(3, 'Toko Berkah', '081234567803', 'Gresik'),
(4, 'UD Sentosa', '081234567804', 'Madura'),
(5, 'PT Niaga Utama', '081234567805', 'Malang');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `waktu_transaksi` date NOT NULL,
  `keterangan` text,
  `total` int NOT NULL DEFAULT '0',
  `pelanggan_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `waktu_transaksi`, `keterangan`, `total`, `pelanggan_id`) VALUES
(1, '2026-10-01', 'Pembelian alat tulis', 22500, 'PLG001'),
(2, '2026-10-02', 'Pembelian perlengkapan sekolah', 14000, 'PLG002'),
(3, '2026-10-03', 'Pembelian kantor', 19000, 'PLG003'),
(4, '2026-10-04', 'Pembelian alat tulis', 12000, 'PLG004'),
(5, '2026-10-05', 'Pembelian pelanggan', 20000, 'PLG005'),
(6, '2026-10-06', 'Pembelian perlengkapan', 14000, 'PLG001'),
(7, '2026-10-07', 'Pembelian alat tulis', 17500, 'PLG002'),
(8, '2026-10-08', 'Pembelian kantor', 22500, 'PLG003'),
(9, '2026-10-09', 'Pembelian perlengkapan sekolah', 10000, 'PLG004'),
(10, '2026-10-10', 'Pembelian alat tulis', 20000, 'PLG005');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `transaksi_id` int NOT NULL,
  `barang_id` int NOT NULL,
  `harga` int NOT NULL,
  `qty` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`transaksi_id`, `barang_id`, `harga`, `qty`) VALUES
(1, 1, 5000, 2),
(1, 2, 3000, 3),
(1, 7, 3500, 1),
(2, 3, 2500, 4),
(2, 4, 2000, 2),
(3, 5, 4000, 3),
(3, 6, 7000, 1),
(4, 1, 5000, 1),
(4, 7, 3500, 2),
(5, 2, 3000, 5),
(5, 3, 2500, 2),
(6, 4, 2000, 3),
(6, 5, 4000, 2),
(7, 6, 7000, 2),
(7, 7, 3500, 1),
(8, 1, 5000, 3),
(8, 3, 2500, 3),
(9, 2, 3000, 2),
(9, 5, 4000, 1),
(10, 1, 5000, 1),
(10, 4, 2000, 4),
(10, 6, 7000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` tinyint UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `hp` varchar(20) DEFAULT NULL,
  `level` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `alamat`, `hp`, `level`) VALUES
(1, 'admin', 'admin123', 'Administrator', 'Surabaya', '081200000001', 1),
(2, 'kasir1', 'kasir123', 'Kasir Satu', 'Bangkalan', '081200000002', 2),
(3, 'kasir2', 'kasir123', 'Kasir Dua', 'Sampang', '081200000003', 2),
(4, 'operator1', 'operator123', 'Operator Satu', 'Pamekasan', '081200000004', 2),
(5, 'operator2', 'operator123', 'Operator Dua', 'Sumenep', '081200000005', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`),
  ADD KEY `fk_barang_supplier` (`supplier_id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pembayaran_transaksi` (`transaksi_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_transaksi_pelanggan` (`pelanggan_id`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`transaksi_id`,`barang_id`),
  ADD UNIQUE KEY `uq_transaksi_barang` (`transaksi_id`,`barang_id`),
  ADD KEY `fk_detail_barang` (`barang_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `fk_barang_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_pembayaran_transaksi` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_transaksi_pelanggan` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `fk_detail_barang` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detail_transaksi` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
