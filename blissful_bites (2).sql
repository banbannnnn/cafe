-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 24, 2025 at 03:55 PM
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
  `status` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `cart_data`, `total`, `payment_method`, `created_at`, `status`, `user_id`, `first_name`, `last_name`, `company_name`, `street`, `city`, `province`, `phone`, `email`) VALUES
(5, '[{\"name\":\"Croissant\",\"image\":\"croissant.jpg\",\"price\":\"180\",\"quantity\":1}]', 180.00, 'GCash', '2025-05-16 11:21:37', 'Pending', 26, 'ana', 'ferrer', '', 'tiaong', 'baliuag', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(10, '[{\"name\":\"Croissant\",\"image\":\"croissant.jpg\",\"price\":\"180\",\"quantity\":1}]', 255.00, 'Cash on Delivery', '2025-05-16 11:34:38', NULL, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, '[{\"name\":\"Croissant\",\"image\":\"croissant.jpg\",\"price\":\"180\",\"quantity\":1},{\"name\":\"Strawberry Croissant\",\"image\":\"croissantwithflavor.jpg\",\"price\":\"220\",\"quantity\":1},{\"name\":\"Cream Puff\",\"image\":\"creampuff.jpg\",\"price\":\"150\",\"quantity\":1},{\"name\":\"Plain Cinnamon Roll\",\"image\":\"cinnamonroll.jpg\",\"price\":\"230\",\"quantity\":1},{\"name\":\" White Cinnamon\",\"image\":\"cinnamonwhite.jpg\",\"price\":\"270\",\"quantity\":1}]', 1125.00, 'Cash on Delivery', '2025-05-16 11:36:11', NULL, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, '[{\"name\":\"Iced Coffee\",\"image\":\"coffee.jpg\",\"price\":\"235\",\"quantity\":1}]', 310.00, 'Cash on Delivery', '2025-05-16 11:37:10', NULL, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, '[{\"name\":\"Beef Steak\",\"image\":\"beef.jpg\",\"price\":\"435\",\"quantity\":1}]', 510.00, 'GCash', '2025-05-16 11:38:05', NULL, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, '[{\"name\":\"Iced Coffee\",\"image\":\"coffee.jpg\",\"price\":\"235\",\"quantity\":1},{\"name\":\"Iced Matcha\",\"image\":\"matcha.jpg\",\"price\":\"245\",\"quantity\":1},{\"name\":\"Lemon Juice\",\"image\":\"lemonjuice.jpg\",\"price\":\"200\",\"quantity\":1},{\"name\":\"Watermelon Juice\",\"image\":\"watermelonjuice.jpg\",\"price\":\"210\",\"quantity\":1},{\"name\":\"Iced Latte\",\"image\":\"latte.jpg\",\"price\":\"220\",\"quantity\":1}]', 1110.00, 'GCash', '2025-05-16 11:39:57', 'Pending', 26, 'ana', 'ferrer', '', 'tiaong', 'baliuag', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(15, '[{\"name\":\"Strawberry Croissant\",\"image\":\"croissantwithflavor.jpg\",\"price\":\"220\",\"quantity\":1}]', 220.00, 'Cash on Delivery', '2025-05-16 11:40:21', 'Pending', 26, 'ana', 'ferrer', '', 'tiaong', 'baliuag', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(16, '[{\"name\":\"Chocolate Chip Cookies\",\"image\":\"Chocolatechipcookies.jpg\",\"price\":\"80\",\"quantity\":1}]', 155.00, 'GCash', '2025-05-16 11:47:06', NULL, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '[{\"name\":\"Carbonara\",\"image\":\"carbo.jpg\",\"price\":\"420\",\"quantity\":1}]', 495.00, 'Cash on Delivery', '2025-05-16 11:48:49', NULL, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, '', 495.00, 'Cash on Delivery', '2025-05-16 11:49:07', 'Pending', 26, 'ana', 'ferrer', '', 'tiaong', 'baliuag', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(19, '[{\"name\":\"Carbonara\",\"image\":\"carbo.jpg\",\"price\":\"420\",\"quantity\":1},{\"name\":\"Strawberry Croissant\",\"image\":\"croissantwithflavor.jpg\",\"price\":\"220\",\"quantity\":2}]', 935.00, 'Cash on Delivery', '2025-05-16 11:54:56', NULL, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, '', 285.00, 'GCash', '2025-05-16 11:57:11', 'Delivered', 26, 'ana', 'ferrer', '', 'tiaong', 'baliuag', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(21, '', 295.00, 'GCash', '2025-05-16 12:42:58', 'Pending', 26, 'ana', 'ferrer', '', 'tiaong', 'baliuag', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(22, '', 305.00, 'Cash on Delivery', '2025-05-16 12:45:34', 'Pending', 26, 'ana', 'ferrer', '', 'tiaong', 'baliuag', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(23, '', 2575.00, 'GCash', '2025-05-16 12:47:39', 'Pending', 26, 'ana', 'ferrer', '', 'tiaong', 'baliuag', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(24, '[{\"name\":\"Croissant\",\"image\":\"croissant.jpg\",\"price\":\"180\",\"quantity\":1}]', 255.00, 'GCash', '2025-05-16 12:48:34', NULL, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, '[{\"name\":\"Strawberry Croissant\",\"image\":\"croissantwithflavor.jpg\",\"price\":\"220\",\"quantity\":1}]', 295.00, 'GCash', '2025-05-16 12:49:39', NULL, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, '[{\"name\":\"Iced Coffee\",\"image\":\"coffee.jpg\",\"price\":\"235\",\"quantity\":1}]', 310.00, 'Cash on Delivery', '2025-05-16 12:51:33', NULL, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, '[{\"name\":\"Watermelon Juice\",\"image\":\"watermelonjuice.jpg\",\"price\":\"210\",\"quantity\":2}]', 495.00, 'GCash', '2025-05-16 13:02:07', 'Processing', 26, 'ana', 'ferrer', '', '', '', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(31, '[{\"name\":\"Brownies\",\"image\":\"Brownies.jpg\",\"price\":\"80\",\"quantity\":1}]', 155.00, 'GCash', '2025-05-16 13:08:11', 'On the way', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(32, '[{\"name\":\"Croissant\",\"image\":\"croissant.jpg\",\"price\":\"180\",\"quantity\":1}]', 255.00, 'GCash', '2025-05-16 15:38:39', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(34, '[{\"name\":\"Basque Burnt Cheesecake (WHOLE)\",\"image\":\"burntcheesecake.jpg\",\"price\":\"2500\",\"quantity\":1}]', 2575.00, 'GCash', '2025-05-17 10:02:01', 'Pending', 23, 'maria', 'marie', '', 'tiaong', 'baliuag', 'Bulacan', '09236898327', 'maria2001marie@gmail.com'),
(35, '[{\"name\":\"Cream Puff\",\"image\":\"creampuff.jpg\",\"price\":\"150\",\"quantity\":1}]', 225.00, 'GCash', '2025-05-18 06:17:32', 'On the way', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(36, '[{\"name\":\"Lemon Juice\",\"image\":\"lemonjuice.jpg\",\"price\":\"200\",\"quantity\":1}]', 275.00, 'Cash on Delivery', '2025-05-18 06:18:43', 'Delivered', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(37, '[{\"name\":\"Iced Coffee\",\"quantity\":1},{\"name\":\"Croissant\",\"quantity\":1}]', 0.00, 'GCash', '2025-05-22 03:48:39', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(38, '[{\"name\":\"Croissant\",\"quantity\":1}]', 0.00, 'GCash', '2025-05-22 04:04:09', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(39, '[{\"name\":\"Croissant\",\"quantity\":1},{\"name\":\"Cream Puff\",\"quantity\":1}]', 0.00, 'Cash on Delivery', '2025-05-22 05:37:18', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(40, '', 0.00, '', '2025-05-22 12:54:20', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(41, '', 0.00, '', '2025-05-22 12:57:05', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(42, '', 0.00, '', '2025-05-22 12:57:15', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(43, '[{\"name\":\"Croissant\",\"quantity\":1}]', 0.00, 'Cash on Delivery', '2025-05-22 12:57:38', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(44, '[{\"name\":\"Croissant\",\"quantity\":1},{\"name\":\"Strawberry Croissant\",\"quantity\":1}]', 0.00, 'GCash', '2025-05-22 12:58:17', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(45, '', 0.00, '', '2025-05-22 14:29:27', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(46, '', 0.00, '', '2025-05-22 14:29:31', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(47, '', 0.00, '', '2025-05-22 14:30:06', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(48, '', 0.00, '', '2025-05-22 14:30:12', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(49, '', 0.00, '', '2025-05-22 14:30:14', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(50, '', 0.00, '', '2025-05-22 14:30:19', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(51, '[{\"name\":\"Basque Burnt Cheesecake (WHOLE)\",\"quantity\":1},{\"name\":\" White Cinnamon\",\"quantity\":1}]', 2075.00, 'Cash on Delivery', '2025-05-22 14:49:31', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(52, '[{\"name\":\"Basque Burnt Cheesecake (SLICED)\",\"quantity\":1},{\"name\":\"Croissant\",\"quantity\":1}]', 75.00, 'Cash on Delivery', '2025-05-22 15:03:23', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(53, '[{\"name\":\"Croissant\",\"quantity\":1}]', 75.00, 'GCash', '2025-05-22 15:14:53', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(54, '[{\"name\":\"Croissant\",\"quantity\":2}]', 0.00, 'Cash on Delivery', '2025-05-23 12:12:26', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(55, '[{\"name\":\"Cream Puff\",\"quantity\":1}]', 0.00, 'GCash', '2025-05-23 12:17:38', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(56, '[{\"name\":\"Croissant\",\"quantity\":1}]', 255.00, 'GCash', '2025-05-23 13:21:07', 'Pending', 30, '0', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(57, '[{\"name\":\"Croissant\",\"quantity\":2}]', 435.00, 'GCash', '2025-05-23 13:44:25', 'Pending', 27, 'hannah', 'piamonte', '', 'sabang', 'baliuag', 'Bulacan', '09236898327', 'carizzehannah@gmail.com'),
(58, '[{\"name\":\"Croissant\",\"quantity\":2}]', 435.00, 'GCash', '2025-05-23 13:44:42', 'Pending', 27, 'hannah', 'piamonte', '', 'sabang', 'baliuag', 'Bulacan', '09236898327', 'carizzehannah@gmail.com'),
(59, '[{\"name\":\"Cream Puff\",\"quantity\":1}]', 225.00, 'GCash', '2025-05-23 13:55:22', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(60, '[{\"name\":\"Croissant\",\"price\":\"180\",\"image\":\"croissant.jpg\",\"quantity\":1}]', 255.00, 'COD', '2025-05-23 14:07:34', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(61, '[{\"name\":\"Croissant\",\"price\":\"180\",\"image\":\"croissant.jpg\",\"quantity\":2}]', 435.00, 'GCash', '2025-05-23 14:08:05', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(62, '[{\"name\":\"Croissant\",\"price\":\"180\",\"image\":\"croissant.jpg\",\"quantity\":1}]', 255.00, 'GCash', '2025-05-23 14:11:12', 'Delivered', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(63, '[{\"name\":\"Croissant\",\"quantity\":1}]', 255.00, 'COD', '2025-05-24 02:11:27', 'Pending', 30, 'ana teresita', 'ferrer', '', 'cambaog', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(64, '[{\"name\":\"Croissant\",\"quantity\":2}]', 435.00, 'GCash', '2025-05-24 02:12:27', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(65, '[{\"name\":\"Croissant\",\"quantity\":2}]', 435.00, 'GCash', '2025-05-24 02:20:29', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(66, '[{\"name\":\"Cream Puff\",\"quantity\":1}]', 225.00, 'GCash', '2025-05-24 02:21:21', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(67, '[{\"name\":\"Cream Puff\",\"quantity\":1},{\"name\":\"Croissant\",\"quantity\":1},{\"name\":\"Plain Cinnamon Roll\",\"quantity\":1},{\"name\":\" White Cinnamon\",\"quantity\":1}]', 905.00, 'COD', '2025-05-24 02:21:51', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(68, '[{\"name\":\"Cream Puff\",\"quantity\":1},{\"name\":\"Plain Cinnamon Roll\",\"quantity\":1}]', 455.00, 'COD', '2025-05-24 02:59:12', 'On the way', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(69, '[{\"name\":\"Iced Coffee\",\"quantity\":1},{\"name\":\"Iced Matcha\",\"quantity\":1}]', 555.00, 'GCash', '2025-05-24 03:01:24', 'Processing', 30, 'ana teresita', 'ferrer', '', 'cambaog', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(70, '[{\"name\":\"Croissant\",\"quantity\":3},{\"name\":\"Cream Puff\",\"quantity\":1}]', 765.00, 'COD', '2025-05-24 03:07:54', 'Pending', 30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com'),
(71, '[{\"name\":\"Plain Cinnamon Roll\",\"quantity\":1}]', 305.00, 'COD', '2025-05-24 03:18:00', 'Pending', 27, 'hannah', 'piamonte', '', 'sabang', 'baliuag', 'Bulacan', '09236898327', 'carizzehannah@gmail.com'),
(72, '[{\"name\":\"Strawberry Cheesecake (WHOLE)\",\"quantity\":1}]', 2475.00, 'COD', '2025-05-24 04:50:58', 'Pending', 27, 'hannah', 'piamonte', '', 'sabang', 'baliuag', 'Bulacan', '09236898327', 'carizzehannah@gmail.com'),
(73, '[{\"name\":\" White Cinnamon\",\"quantity\":1},{\"name\":\"Iced Matcha\",\"quantity\":1}]', 590.00, 'GCash', '2025-05-24 05:00:37', 'Pending', 31, 'lucas gabriel', 'ferrer', '', 'tangos', 'baliuag', 'Bulacan', '09236898327', 'ferrerlucasgabriel@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(23, 'maria', 'marie', '', 'tiaong', 'baliuag', 'Bulacan', '09236898327', 'maria2001marie@gmail.com', '$2y$10$cvAIydN6gt605pJ8O8fbL.Er.xP4CBjXeODzjEN5R8k6D90Om1hTm', '2025-05-13 07:16:11', '228421', 1),
(27, 'hannah', 'piamonte', '', 'sabang', 'baliuag', 'Bulacan', '09236898327', 'carizzehannah@gmail.com', '$2y$10$I9T.QQ8Tl2yFHfY1F3WIoes/VpdBmLM/dh2d7yguYOYnJeJlmRAJC', '2025-05-15 07:06:22', '424629', 1),
(28, 'jm', 'figueroa', '', 'talampas', 'bustos', 'Bulacan', '09236898327', 'jhonmichaelfigueroa0714@gmail.com', '$2y$10$8vmDG0ob1ihKra5pUX4VF.0JPLo28NuKw1VpMtqlUem7lSiMU/RMy', '2025-05-16 00:22:58', '618549', 1),
(30, 'ana teresita', 'ferrer', '', 'san pedro', 'bustos', 'Bulacan', '09236898327', 'anateresitaferrer@gmail.com', '$2y$10$gUfsHMsWCKGH/eeNgvMI2ugYmqHK.T5Te/lOJ5XGQNZaQoO1UhNGK', '2025-05-16 13:06:13', NULL, 1),
(31, 'lucas gabriel', 'ferrer', '', 'tangos', 'baliuag', 'Bulacan', '09236898327', 'ferrerlucasgabriel@gmail.com', '$2y$10$6Ux6BNpUBJeJoYKfoN53Le88NqKz3eMLvhd4vNyGzzezc1/fGWWFC', '2025-05-24 04:59:26', '227453', 1);

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
-- Indexes for table `products`
--
ALTER TABLE `products`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
