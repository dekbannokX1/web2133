-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2025 at 04:05 PM
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
-- Database: `preorder`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `color` varchar(20) NOT NULL,
  `size` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `order_id` int(11) NOT NULL,
  `order_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`full_name`, `phone`, `address`, `color`, `size`, `quantity`, `total_price`, `user_id`, `payment_status`, `order_id`, `order_time`) VALUES
('ฟหกฟหก', 'หฟกฟหก', 'กฟหกฟห', 'black', 'S', 1, 550.00, 2, 'pending', 1, '2025-01-31 13:06:33'),
('ฟหกฟหก', 'หฟกฟหก', 'กฟหกฟห', 'black', 'S', 1, 550.00, 2, 'pending', 2, '2025-01-31 13:06:33'),
('sadasdsad', 'sadsad', 'sadsad', 'black', 'S', 1, 550.00, 1, 'pending', 3, '2025-01-31 13:19:35'),
('sadasdsad', 'sadsad', 'sadsad', 'black', 'S', 1, 550.00, 1, 'pending', 4, '2025-01-31 13:24:42'),
('sixninerealstar@hotmail.com', 'ryzen746233XX', 'sixninerealstar@hotmail.com', 'black', 'S', 1, 550.00, 1, 'pending', 5, '2025-01-31 13:24:58'),
('sixninerealstar@hotmail.com', 'ryzen746233XX', 'sixninerealstar@hotmail.com', 'black', 'S', 1, 550.00, 1, 'pending', 6, '2025-01-31 13:26:23'),
('sixninerealstar@hotmail.com', 'ryzen746233XX', 'sixninerealstar@hotmail.com', 'black', 'S', 1, 550.00, 1, 'pending', 7, '2025-01-31 13:26:26'),
('หฟกฟหก', 'หฟกหฟก', 'ฟหกฟหก', 'black', 'S', 1, 550.00, 1, 'pending', 8, '2025-01-31 13:26:40'),
('sixninerealstar@hotmail.com', 'ryzen746233XX', 'sixninerealstar@hotmail.com', 'black', 'S', 1, 550.00, 1, 'pending', 9, '2025-01-31 13:27:02'),
('sixninerealstar@hotmail.com', 'ryzen746233XX', 'sixninerealstar@hotmail.com', 'black', 'S', 1, 550.00, 1, 'pending', 10, '2025-01-31 13:29:14'),
('sixninerealstar@hotmail.com', 'ryzen746233XX', 'sixninerealstar@hotmail.com', 'black', 'S', 1, 550.00, 1, 'pending', 11, '2025-01-31 13:29:24'),
('sixninerealstar@hotmail.com', 'ryzen746233XX', 'sixninerealstar@hotmail.com', 'black', 'S', 1, 550.00, 1, 'pending', 12, '2025-01-31 13:31:54'),
('sixninerealstar@hotmail.com', 'ryzen746233XX', 'sixninerealstar@hotmail.com', 'black', 'S', 1, 550.00, 1, 'pending', 13, '2025-01-31 13:31:59'),
('tasdadasd', '01234567890', '999/99999', 'black', 'M', 1, 550.00, 1, 'pending', 14, '2025-01-31 13:54:40'),
('tasdadasd', '01234567890', '999/99999', 'black', 'M', 1, 550.00, 1, 'pending', 15, '2025-01-31 14:36:38'),
('sixninerealstar@hotmail.com', 'ryzen746233XX', 'sixninerealstar@hotmail.com', 'black', 'S', 1, 550.00, 1, 'pending', 16, '2025-01-31 14:39:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(50) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `created_at`, `role`) VALUES
(1, 'ryzen746233XX', '$2y$10$vVrtbmkVjoyuuhuGNTyaKus8G5cdUncTbUbw.cUHrsuMYUxEO7pKS', 'sixninerealstar@hotmail.com', '2025-01-31 13:13:22', 'admin'),
(2, 'admin', '$2y$10$s21ug9Rq6lvQ9pt.ZANiLO6n7.h8h3gC4ACspnCt6uV.W7SIJCdpG', 'sixninerealstar@gmail.com', '2025-01-31 14:58:43', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
