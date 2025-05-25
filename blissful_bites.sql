-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 15, 2025 at 06:57 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blissful_bites`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `cart_data` text DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `cart_data`, `total`, `payment_method`, `created_at`, `status`) VALUES
(1, '[{\"name\":\"Strawberry Croissant\",\"price\":220,\"image\":\"croissant w: flavor.jpg\",\"quantity\":1},{\"name\":\"Croissant\",\"price\":180,\"image\":\"croissant.jpg\",\"quantity\":2}]', 655.00, 'Gcash', '2025-05-02 12:06:06', NULL),
(2, '[{\"name\":\"Iced Coffee\",\"price\":235,\"image\":\"coffee.jpg\",\"quantity\":1}]', 310.00, 'Gcash', '2025-05-02 12:06:46', NULL),
(3, '[{\"name\":\"Iced Coffee\",\"price\":235,\"image\":\"coffee.jpg\",\"quantity\":1},{\"name\":\"Croissant\",\"price\":180,\"image\":\"croissant.jpg\",\"quantity\":1},{\"name\":\"Strawberry Croissant\",\"price\":220,\"image\":\"croissant w: flavor.jpg\",\"quantity\":1}]', 710.00, 'Gcash', '2025-05-02 12:07:10', NULL),
(4, '[{\"name\":\"Iced Coffee\",\"price\":235,\"image\":\"coffee.jpg\",\"quantity\":1},{\"name\":\"Croissant\",\"price\":180,\"image\":\"croissant.jpg\",\"quantity\":1},{\"name\":\"Strawberry Croissant\",\"price\":220,\"image\":\"croissant w: flavor.jpg\",\"quantity\":1}]', 710.00, 'Gcash', '2025-05-02 12:31:13', NULL),
(5, '[{\"name\":\"Iced Coffee\",\"price\":235,\"image\":\"coffee.jpg\",\"quantity\":1},{\"name\":\"Croissant\",\"price\":180,\"image\":\"croissant.jpg\",\"quantity\":1},{\"name\":\"Strawberry Croissant\",\"price\":220,\"image\":\"croissant w: flavor.jpg\",\"quantity\":1}]', 710.00, 'Gcash', '2025-05-02 12:33:31', NULL),
(6, '[{\"name\":\"Iced Coffee\",\"price\":235,\"image\":\"coffee.jpg\",\"quantity\":1},{\"name\":\"Strawberry Croissant\",\"price\":220,\"image\":\"croissant w: flavor.jpg\",\"quantity\":1}]', 530.00, 'Gcash', '2025-05-02 12:33:55', NULL),
(7, '[{\"name\":\"Iced Coffee\",\"price\":235,\"image\":\"coffee.jpg\",\"quantity\":1},{\"name\":\"Strawberry Croissant\",\"price\":220,\"image\":\"croissant w: flavor.jpg\",\"quantity\":1}]', 530.00, 'COD', '2025-05-03 03:51:55', NULL),
(8, '[{\"name\":\"Croissant\",\"image\":\"180\",\"price\":\"croissant.jpg\",\"quantity\":1}]', 0.00, 'Gcash', '2025-05-10 05:45:01', NULL),
(9, '[{\"name\":\"Cream Puff\",\"image\":\"cream puff.jpg\",\"price\":\"150\",\"quantity\":1},{\"name\":\"Plain Cinnamon Roll\",\"image\":\"cinnamon roll.jpg\",\"price\":\"230\",\"quantity\":1}]', 455.00, 'Gcash', '2025-05-10 06:17:59', NULL),
(10, '[{\"name\":\"Cream Puff\",\"image\":\"cream puff.jpg\",\"price\":\"150\",\"quantity\":1},{\"name\":\"Plain Cinnamon Roll\",\"image\":\"cinnamon roll.jpg\",\"price\":\"230\",\"quantity\":1}]', 455.00, 'Gcash', '2025-05-10 06:23:13', NULL),
(11, '[{\"name\":\"Cream Puff\",\"image\":\"cream puff.jpg\",\"price\":\"150\",\"quantity\":1},{\"name\":\"Plain Cinnamon Roll\",\"image\":\"cinnamon roll.jpg\",\"price\":\"230\",\"quantity\":1},{\"name\":\"Croissant\",\"image\":\"croissant.jpg\",\"price\":\"180\",\"quantity\":1}]', 635.00, 'Gcash', '2025-05-10 06:32:38', NULL),
(12, '[{\"name\":\"Cream Puff\",\"image\":\"cream puff.jpg\",\"price\":\"150\",\"quantity\":1},{\"name\":\"Plain Cinnamon Roll\",\"image\":\"cinnamon roll.jpg\",\"price\":\"230\",\"quantity\":1},{\"name\":\"Croissant\",\"image\":\"croissant.jpg\",\"price\":\"180\",\"quantity\":1}]', 635.00, 'gcash', '2025-05-10 06:43:31', NULL),
(13, '[{\"name\":\"Cream Puff\",\"image\":\"cream puff.jpg\",\"price\":\"150\",\"quantity\":1},{\"name\":\"Plain Cinnamon Roll\",\"image\":\"cinnamon roll.jpg\",\"price\":\"230\",\"quantity\":1},{\"name\":\"Croissant\",\"image\":\"croissant.jpg\",\"price\":\"180\",\"quantity\":1}]', 635.00, 'COD', '2025-05-10 06:52:13', NULL),
(14, NULL, NULL, NULL, '2025-05-10 06:55:14', NULL),
(15, NULL, NULL, NULL, '2025-05-10 06:55:17', NULL),
(16, NULL, NULL, NULL, '2025-05-10 06:55:18', NULL),
(17, '[{\"name\":\"Cream Puff\",\"image\":\"cream puff.jpg\",\"price\":\"150\",\"quantity\":1},{\"name\":\"Plain Cinnamon Roll\",\"image\":\"cinnamon roll.jpg\",\"price\":\"230\",\"quantity\":1},{\"name\":\"Croissant\",\"image\":\"croissant.jpg\",\"price\":\"180\",\"quantity\":1},{\"name\":\"Strawberry Croissant\",\"image\":\"croissant w: flavor.jpg\",\"price\":\"220\",\"quantity\":1}]', 855.00, 'COD', '2025-05-10 06:55:38', NULL),
(18, NULL, NULL, NULL, '2025-05-10 06:55:40', NULL),
(19, '[{\"name\":\"Cream Puff\",\"image\":\"cream puff.jpg\",\"price\":\"150\",\"quantity\":1},{\"name\":\"Plain Cinnamon Roll\",\"image\":\"cinnamon roll.jpg\",\"price\":\"230\",\"quantity\":1},{\"name\":\"Croissant\",\"image\":\"croissant.jpg\",\"price\":\"180\",\"quantity\":1},{\"name\":\"Strawberry Croissant\",\"image\":\"croissant w: flavor.jpg\",\"price\":\"220\",\"quantity\":1}]', 855.00, 'COD', '2025-05-10 06:59:31', 'Confirmed'),
(20, '[{\"name\":\"Cream Puff\",\"image\":\"cream puff.jpg\",\"price\":\"150\",\"quantity\":1},{\"name\":\"Plain Cinnamon Roll\",\"image\":\"cinnamon roll.jpg\",\"price\":\"230\",\"quantity\":1},{\"name\":\"Croissant\",\"image\":\"croissant.jpg\",\"price\":\"180\",\"quantity\":1},{\"name\":\"Strawberry Croissant\",\"image\":\"croissant w: flavor.jpg\",\"price\":\"220\",\"quantity\":1}]', 855.00, 'COD', '2025-05-10 07:02:15', 'Confirmed'),
(21, '[{\"name\":\"Strawberry Croissant\",\"image\":\"croissant w: flavor.jpg\",\"price\":\"220\",\"quantity\":1}]', 295.00, 'Gcash', '2025-05-10 07:03:08', 'Confirmed'),
(22, '[{\"name\":\"Strawberry Croissant\",\"image\":\"croissant w: flavor.jpg\",\"price\":\"220\",\"quantity\":1}]', 295.00, 'Gcash', '2025-05-10 07:05:55', 'Confirmed'),
(23, '[{\"name\":\"Strawberry Croissant\",\"image\":\"croissant w: flavor.jpg\",\"price\":\"220\",\"quantity\":2}]', 515.00, 'Gcash', '2025-05-10 07:07:50', NULL),
(24, '[{\"name\":\"Strawberry Croissant\",\"image\":\"croissant w: flavor.jpg\",\"price\":\"220\",\"quantity\":2}]', 515.00, 'Gcash', '2025-05-10 07:09:25', NULL),
(25, '[{\"name\":\"Strawberry Croissant\",\"image\":\"croissant w: flavor.jpg\",\"price\":\"220\",\"quantity\":2},{\"name\":\"Croissant\",\"image\":\"croissant.jpg\",\"price\":\"180\",\"quantity\":1}]', 695.00, 'Gcash', '2025-05-10 07:09:57', NULL),
(26, '[{\"name\":\"Strawberry Croissant\",\"image\":\"croissant w: flavor.jpg\",\"price\":\"220\",\"quantity\":2},{\"name\":\"Croissant\",\"image\":\"croissant.jpg\",\"price\":\"180\",\"quantity\":1}]', 695.00, 'Gcash', '2025-05-10 07:14:44', NULL),
(27, '[{\"name\":\"Strawberry Croissant\",\"image\":\"croissant w: flavor.jpg\",\"price\":\"220\",\"quantity\":2},{\"name\":\"Croissant\",\"image\":\"croissant.jpg\",\"price\":\"180\",\"quantity\":1}]', 695.00, 'Gcash', '2025-05-10 07:23:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `street` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `province` varchar(50) DEFAULT 'Bulacan',
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verification_code` varchar(6) DEFAULT NULL,
  `email_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `company_name`, `street`, `city`, `province`, `phone`, `email`, `user_password`, `created_at`, `verification_code`, `email_verified`) VALUES
(1, 'test', 'test', '', 'test', 'test', 'Bulacan', 'test', 'test@gmail.com', '$2y$10$CdtJks5HvTumppNfl01yDOa7zkn04/NkO3iA8BYJ7cKynOXsDwVyi', '2025-04-14 06:23:05', NULL, 0),
(2, 'ana', 'ana', '', 'ana', 'ana', 'Bulacan', 'ana', 'ana@gmail.com', '$2y$10$k4nFD5I77ApgdLiMEkuiC.4Jr8U9Vqyo4HzU49hE0sjJXOXW6RF0q', '2025-04-14 06:24:45', NULL, 0),
(3, 'jm', 'jm', '', 'jm', 'jmjm', 'Bulacan', 'jm', 'jm@gmail.com', '$2y$10$6ZMGs11d3f6O.o3TVB3CherVlrjPYnZIjmIWolNv7lQco8juvIK8K', '2025-04-14 06:29:24', NULL, 0),
(4, 'testt', 'testt', '', 'testt', 'testt', 'Bulacan', 'testt', 'testt@gmail.com', '$2y$10$vwLDPJ91duA/.iwNBmCLZuLmQUYI2p8cXFoHRwGU3U8FBdNRjc5XG', '2025-04-14 12:16:50', NULL, 0),
(5, 'try', 'try', '', 'try', 'try', 'Bulacan', 'try', 'try@gmail.com', '$2y$10$04MqIOMGtQ0Pg7g6.MH1K.hI6.HtXGhH3Cw6ntvZppH8m8IDA2uD2', '2025-04-14 12:20:21', NULL, 0),
(6, 'anaa', 'anaa', '', 'anaaanaa', 'anaa', 'Bulacan', 'anaa', 'anaa@gmail.com', '$2y$10$XB3ewvfFnMcoTMapOc3KmOWHw1Wf5OyJAMueJc5wWUaZpknI9jTHu', '2025-04-14 12:45:04', NULL, 0),
(7, 'tryy', 'tryy', '', 'tryy', 'tryy', 'Bulacan', 'tryy', 'tryy@gmail.com', '$2y$10$oMj.lZhacCf6T3KNgoJr/uZcPn.ukz.K1d.MgcJdPl6t05ppLchFC', '2025-04-14 12:55:39', NULL, 0),
(8, 'lucas', 'lucas', '', 'lucas', 'lucas', 'Bulacan', 'lucas', 'lucas@gmail.com', '$2y$10$Dcnpg42ZzlpsWJDDjNBSUueMrJdSHWAe8bV8O9C2UrcwhL5RBsCcS', '2025-04-14 13:05:19', NULL, 0),
(9, 'mimoys', 'mimoys', '', 'mimoys', 'mimoys', 'Bulacan', 'mimoys', 'mimoys@gmail.com', '$2y$10$twFFV.SPN9UoQCo8RTh8recMs8elxPEo7o.p/MIMRuovzaVcyJkVi', '2025-04-15 11:53:05', NULL, 0),
(10, '1', '1', '', '1', '1', 'Bulacan', '1', '1@gmail.com', '$2y$10$nwNHPa/MoGpmL1tn20/IM.A8nyMHyz/5XI/rRHkf0gunuNB/zYFeO', '2025-04-20 12:17:05', NULL, 0),
(11, 'testttt', 'testttt', 'testttt', 'testttt', 'testttt', 'Bulacan', 'testttt', 'testttt@gmail.com', '$2y$10$Fmu6/eotZHsuUeAZr8bB9ezebMkY2BeXHAto.l9JyjJtL2Pf4R8K.', '2025-05-02 12:41:08', NULL, 0),
(12, 'try1', 'try1', 'try1', 'try1', 'try1', 'Bulacan', 'try1', 'try1@gmail.com', '$2y$10$VI1p8bX3IK0F7ZIwNHmtpuOkKhK4ooIjN38Mywh5zh.PyADu4A24q', '2025-05-02 12:43:12', NULL, 0),
(23, 'maria', 'marie', '', 'tiaong', 'baliwag', 'Bulacan', '09236898327', 'maria2001marie@gmail.com', '$2y$10$cvAIydN6gt605pJ8O8fbL.Er.xP4CBjXeODzjEN5R8k6D90Om1hTm', '2025-05-13 07:16:11', '228421', 1),
(25, 'ana', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com', '$2y$10$kzQyzPLsBcr1DGNXTg.nlOaGr2mgy7VHCyvsUwly5lzaA8bTDhf4m', '2025-05-13 07:21:03', '146876', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
