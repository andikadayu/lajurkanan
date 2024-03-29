-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2021 at 03:07 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lajurkanan`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_commerce`
--

CREATE TABLE `tb_commerce` (
  `id_commerce` int(4) NOT NULL,
  `name_commerce` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_commerce`
--

INSERT INTO `tb_commerce` (`id_commerce`, `name_commerce`) VALUES
(1, 'Shopee'),
(2, 'Lazada');

-- --------------------------------------------------------

--
-- Table structure for table `tb_lazada`
--

CREATE TABLE `tb_lazada` (
  `id_lazada` int(225) NOT NULL,
  `id_scrape` int(225) DEFAULT NULL,
  `url_scrape` text DEFAULT NULL,
  `nama_produk` text DEFAULT NULL,
  `deskripsi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cat1` int(225) DEFAULT NULL,
  `berat` int(225) DEFAULT NULL,
  `minimum_pemesanan` int(225) DEFAULT NULL,
  `nomor_etalase` int(225) DEFAULT NULL,
  `waktu_preorder` int(225) DEFAULT NULL,
  `kondisi` text DEFAULT NULL,
  `gambar1` text DEFAULT NULL,
  `video1` text DEFAULT NULL,
  `sku_name` text DEFAULT NULL,
  `status` text DEFAULT NULL,
  `jumlah_stok` int(225) DEFAULT NULL,
  `harga` int(255) DEFAULT NULL,
  `asuransi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_manage`
--

CREATE TABLE `tb_manage` (
  `id_subscribe` int(225) NOT NULL,
  `id_user` int(11) NOT NULL,
  `request_from` date NOT NULL,
  `request_until` date NOT NULL,
  `status` int(2) NOT NULL,
  `harga_subscribe` int(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_scrap`
--

CREATE TABLE `tb_scrap` (
  `id_scrap` int(225) NOT NULL,
  `tgl_scrap` datetime NOT NULL,
  `id_commerce` int(4) NOT NULL,
  `id_user` int(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_shopee`
--

CREATE TABLE `tb_shopee` (
  `id_shopee` int(225) NOT NULL,
  `id_scrape` int(225) DEFAULT NULL,
  `url_scrape` text DEFAULT NULL,
  `nama_produk` text DEFAULT NULL,
  `deskripsi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cat1` int(225) DEFAULT NULL,
  `berat` int(225) DEFAULT NULL,
  `minimum_pemesanan` int(225) DEFAULT NULL,
  `nomor_etalase` int(225) DEFAULT NULL,
  `waktu_preorder` int(225) DEFAULT NULL,
  `kondisi` text DEFAULT NULL,
  `gambar1` text DEFAULT NULL,
  `video1` text DEFAULT NULL,
  `sku_name` text DEFAULT NULL,
  `status` text DEFAULT NULL,
  `jumlah_stok` int(225) DEFAULT NULL,
  `harga` int(225) DEFAULT NULL,
  `asuransi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(225) NOT NULL,
  `name` varchar(225) NOT NULL,
  `no_telp` varchar(25) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(25) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `code` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `name`, `no_telp`, `alamat`, `email`, `password`, `role`, `is_active`, `code`) VALUES
(1, 'Lajur Kanan Admin', '081111111', 'Alamat', 'admin@lajurkanan.com', 'f05041e14758d67e868604b522e2ef20', 'superadmin', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_old`
--

CREATE TABLE `tb_user_old` (
  `id_user` int(225) NOT NULL,
  `name` varchar(225) NOT NULL,
  `no_telp` varchar(25) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(25) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `code` int(6) DEFAULT NULL,
  `accesskey` text DEFAULT NULL,
  `active_from` date DEFAULT NULL,
  `active_until` date DEFAULT NULL,
  `harga_regis` int(225) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_commerce`
--
ALTER TABLE `tb_commerce`
  ADD PRIMARY KEY (`id_commerce`);

--
-- Indexes for table `tb_lazada`
--
ALTER TABLE `tb_lazada`
  ADD PRIMARY KEY (`id_lazada`);

--
-- Indexes for table `tb_manage`
--
ALTER TABLE `tb_manage`
  ADD PRIMARY KEY (`id_subscribe`);

--
-- Indexes for table `tb_scrap`
--
ALTER TABLE `tb_scrap`
  ADD PRIMARY KEY (`id_scrap`);

--
-- Indexes for table `tb_shopee`
--
ALTER TABLE `tb_shopee`
  ADD PRIMARY KEY (`id_shopee`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tb_user_old`
--
ALTER TABLE `tb_user_old`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_commerce`
--
ALTER TABLE `tb_commerce`
  MODIFY `id_commerce` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_lazada`
--
ALTER TABLE `tb_lazada`
  MODIFY `id_lazada` int(225) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_manage`
--
ALTER TABLE `tb_manage`
  MODIFY `id_subscribe` int(225) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_scrap`
--
ALTER TABLE `tb_scrap`
  MODIFY `id_scrap` int(225) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_shopee`
--
ALTER TABLE `tb_shopee`
  MODIFY `id_shopee` int(225) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_user_old`
--
ALTER TABLE `tb_user_old`
  MODIFY `id_user` int(225) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
