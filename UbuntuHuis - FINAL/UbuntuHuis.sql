-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2025 at 11:04 AM
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
-- Database: `users_uh`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sellerEmail` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productId`, `name`, `description`, `price`, `image`, `sellerEmail`, `category`, `province`, `city`) VALUES
(4, 'Pictaa', 'hjhbgjg', 400.00, 'uploads/image3.jpeg', 'seller@gmail.com', 'Artisan and Handmade', 'Limpopo', 'Polokwane'),
(5, 'skippa', 'byhubhb', 500.00, 'uploads/image3.jpeg', 'seller@gmail.com', 'Thrift and Secondhand', 'Free State', 'Bloemfontein'),
(6, 'vgv', 'byuhh', 50.00, 'uploads/PhotoCapture_2024_1120_084452_554.jpeg', 'seller@gmail.com', 'Services', 'Gauteng', 'Johannesburg'),
(7, 'car wash', 'we wash all types of cars', 100.00, 'uploads/image3.jpeg', 'seller@gmail.com', 'Services', 'Gauteng', 'Johannesburg'),
(8, 'wdheb', 'ncjknclkinjc', 120.00, 'uploads/PhotoCapture_2024_1120_084452_554.jpeg', 'seller@gmail.com', 'Services', 'Gauteng', 'Johannesburg'),
(9, 'cjhnckidncw', 'hcfjurhdncjucvw', 180.00, 'uploads/ScreenshotSIP.png', 'seller@gmail.com', 'Services', 'Gauteng', 'Johannesburg'),
(10, 'gbvyuhbv', 'hbhrbvu', 50.00, 'uploads/GanttChart.png', 'seller@gmail.com', 'Food and Produce', 'Western Cape', 'Cape Town');

-- --------------------------------------------------------

--
-- Table structure for table `sellersprofile`
--
-- Error reading structure for table users_uh.sellersprofile: #1932 - Table &#039;users_uh.sellersprofile&#039; doesn&#039;t exist in engine
-- Error reading data for table users_uh.sellersprofile: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `users_uh`.`sellersprofile`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('buyer','seller') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `name`, `email`, `password`, `role`) VALUES
(1, 'seddi', 'chuenelesedi8@gmail.com', '$2y$10$MyzOxdeUxdwDyeWmw8JrjeGewZvCoqmHjcR8xiNwqGgyUFZHeJ276', 'buyer'),
(2, 'Gurla', 'eduv4828876@vossie.net', '$2y$10$bpKdlrPe9wNtGKlZkvY2yO/Ov9ltMeZ6K9wNJ.n1LZfuD89B8zow6', 'seller'),
(3, 'seller', 'seller@gmail.com', '$2y$10$tw31qaS4JLqaw9oTYceQye1hWCAleN7jhySdWbRhSqwbWrbFw5kca', 'seller'),
(4, 'buyer', 'buyer@gmail.com', '$2y$10$k3ZMHOJykLkrNPmavzhskuj6ZT9aygVkzf2QvWkwnUQsf6wtAL90S', 'buyer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`productId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
