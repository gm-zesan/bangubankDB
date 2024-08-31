-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2024 at 08:56 PM
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
-- Database: `bangubank`
--

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `recipient` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `email`, `type`, `amount`, `date`, `recipient`) VALUES
(1, 'zesan@gmail.com', 'withdraw', '100', '0000-00-00 00:00:00', NULL),
(2, 'zesan@gmail.com', 'deposit', '500', '0000-00-00 00:00:00', NULL),
(3, 'zesan@gmail.com', 'withdraw', '1000', '0000-00-00 00:00:00', NULL),
(4, 'hasan@gmail.com', 'deposit', '1000', '0000-00-00 00:00:00', NULL),
(5, 'hasan@gmail.com', 'transfer', '500', '0000-00-00 00:00:00', 'zesan@gmail.com'),
(6, 'zesan@gmail.com', 'received', '500', '0000-00-00 00:00:00', 'hasan@gmail.com'),
(7, 'hasan@gmail.com', 'deposit', '1000', '0000-00-00 00:00:00', NULL),
(8, 'hasan@gmail.com', 'withdraw', '200', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `balance` varchar(255) DEFAULT NULL,
  `isAdmin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `balance`, `isAdmin`) VALUES
(1, 'zesan', 'zesan@gmail.com', '$2y$10$2vned.CeFAIB/4DfkKzAMeIyNpi8DOxgp/3M/5M04tWGtOS2yKVli', '7500', 0),
(2, 'hasan', 'hasan@gmail.com', '$2y$10$wNU6u4nrmsa7.SN7vFG6UuwZxu.oaVohwjFn.9gmS.YdtgqdjBI7G', '1300', 0),
(3, 'jafor iqbal', 'iqbal@gmail.com', '$2y$10$JK82o3A2wmM6t.7hCUizWexINzlgyNJ5/cnaJB0b4e9k0zj1KI2Lu', '0', 0),
(4, 'admin', 'admin@gmail.com', '$2y$10$5XU7cZnWEYS58wpZBxbuJukwxkGnerEzHeXRqyiItRJbkjczXKMu6', '0', 1),
(5, 'admin2', 'admin2@gmail.com', '$2y$10$x5kx2DC5nyFjrmDA2.PpIudzSLFzZxVKqhtHLJSAvlEuIYg8Z64eG', '0', 1),
(6, 'www', 'www@gmail.com', '$2y$10$fIHInDG9Key8YBvQAgDgmO4AJm20XAYrivlgGseVKi7rgrhrtrZ12', '0', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
