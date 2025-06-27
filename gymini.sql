-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 27, 2025 at 09:06 AM
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
-- Database: `gymini`
--

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `members_id` int NOT NULL,
  `nama_members` varchar(60) NOT NULL,
  `notelp_members` varchar(15) NOT NULL,
  `jk_members` enum('L','P') NOT NULL,
  `tgl_lahir_members` date NOT NULL,
  `tgl_daftar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_members` char(1) DEFAULT '1',
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`members_id`, `nama_members`, `notelp_members`, `jk_members`, `tgl_lahir_members`, `tgl_daftar`, `status_members`, `user_id`) VALUES
(1, 'Raya Nirmala', '081234567912', 'P', '2000-07-07', '2025-06-26 02:20:58', '1', 1),
(2, 'atmaa', '081234567912', 'L', '2000-07-07', '2025-06-26 04:03:18', '1', 2),
(3, 'Iwaa Peyek', '123455678910', 'P', '2006-07-07', '2025-06-27 08:31:14', '0', 3);

-- --------------------------------------------------------

--
-- Table structure for table `membership_plan`
--

CREATE TABLE `membership_plan` (
  `plan_id` int NOT NULL,
  `nama_paket` varchar(20) NOT NULL,
  `harga_paket` int NOT NULL,
  `durasi_hari` int NOT NULL,
  `deskripsi` varchar(256) NOT NULL,
  `membership_status` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `membership_plan`
--

INSERT INTO `membership_plan` (`plan_id`, `nama_paket`, `harga_paket`, `durasi_hari`, `deskripsi`, `membership_status`) VALUES
(1, 'Paket Mingguan Gacor', 30000, 14, 'Linggaguliguliguliwachalinggagulinggagu', '0'),
(2, 'Tahunan brutal', 1500000, 365, 'Tahunan itu paling gacorr, karenda dapet langganan setahun', '1');

-- --------------------------------------------------------

--
-- Table structure for table `members_memberships`
--

CREATE TABLE `members_memberships` (
  `id_membership` int NOT NULL,
  `members_id` int NOT NULL,
  `plan_id` int NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_berakhir` date NOT NULL,
  `status_pembayaran` enum('Lunas','Belum lunas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `members_memberships`
--

INSERT INTO `members_memberships` (`id_membership`, `members_id`, `plan_id`, `tanggal_mulai`, `tanggal_berakhir`, `status_pembayaran`) VALUES
(1, 2, 1, '2025-06-27', '2025-07-11', 'Lunas'),
(2, 2, 1, '2025-07-11', '2025-07-25', 'Lunas'),
(3, 3, 2, '2025-06-27', '2026-06-27', 'Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id_transaction` int NOT NULL,
  `members_id` int NOT NULL,
  `plan_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('Transfer','Cash') NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id_transaction`, `members_id`, `plan_id`, `amount`, `payment_method`, `description`) VALUES
(1, 2, 1, '30000.00', 'Cash', ''),
(2, 2, 1, '30000.00', 'Cash', 'mantap'),
(3, 2, 1, '30000.00', 'Cash', 'gg'),
(4, 3, 2, '1500000.00', 'Transfer', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `email` varchar(60) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('member','kasir','admin') DEFAULT NULL,
  `users_status` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `username`, `password`, `role`, `users_status`) VALUES
(1, 'nirmalacantik@gmail.com', 'nirmala', '12345678', 'member', '1'),
(2, 'atmahuwe@gmail.com', 'Atmaa', '$2y$10$vf9e98hefjq.BxaxyO6mg.oy3YcCwBME2JYwLpdNcSaq7qkl//7Da', 'member', '1'),
(3, 'iwacosple@gmail.com', 'iwaaa', '$2y$10$pwNukTdboa6ps2Kyz9Qr8e7OrSqli5FYQCbPazY/aWbJPaEMXRpAy', 'member', '1'),
(4, 'juliasta702@gmail.com', 'juliasta', '12345678', 'member', '1'),
(24, 'wulansukma@gmail.com', 'wulan', '$2y$10$9ipxZX4Dr1m3yR8RotCq4OjLqfIu4Q8JL.MnKgx34suqhsx8FxkYS', 'admin', '1'),
(26, 'saityayess@example.com', 'saitya', '$2y$10$I1LGAVWpT.G1Zs9ZpBn2FejLCPJV6O9BbOTZ5E6UoWI6nAkN0Vq8e', 'admin', '1'),
(27, 'example@example.com', 'example', '12345678', 'kasir', '0'),
(28, 'yahahahahayuk@example.com', 'hayukk', '$2y$10$.uCbu3gGxXjwS3H.f4hLV..CY0f/ycuMk3NCHM8pIPKGKdulbY5/C', 'member', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`members_id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `membership_plan`
--
ALTER TABLE `membership_plan`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `members_memberships`
--
ALTER TABLE `members_memberships`
  ADD PRIMARY KEY (`id_membership`),
  ADD KEY `fk_member` (`members_id`),
  ADD KEY `fk_plan_for_membership` (`plan_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id_transaction`),
  ADD KEY `fk_member_for_payment` (`members_id`),
  ADD KEY `fk_plan_for_payment` (`plan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `members_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `membership_plan`
--
ALTER TABLE `membership_plan`
  MODIFY `plan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `members_memberships`
--
ALTER TABLE `members_memberships`
  MODIFY `id_membership` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id_transaction` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `members_memberships`
--
ALTER TABLE `members_memberships`
  ADD CONSTRAINT `fk_member` FOREIGN KEY (`members_id`) REFERENCES `members` (`members_id`),
  ADD CONSTRAINT `fk_plan_for_membership` FOREIGN KEY (`plan_id`) REFERENCES `membership_plan` (`plan_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_member_for_payment` FOREIGN KEY (`members_id`) REFERENCES `members` (`members_id`),
  ADD CONSTRAINT `fk_plan_for_payment` FOREIGN KEY (`plan_id`) REFERENCES `membership_plan` (`plan_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
