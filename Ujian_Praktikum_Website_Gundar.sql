-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2024 at 04:28 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_website_donation_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Air Bersih', 'Program Air Bersih'),
(2, 'Bantuan Tempat Tinggal', 'Program Bantuan Tempat Tinggal'),
(3, 'Biaya Pendidikan', 'Program Biaya Pendidikan'),
(4, 'Kebutuhan Pokok', 'Program Kebutuhan Pokok');

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `donor_name` varchar(100) NOT NULL,
  `donor_email` varchar(150) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `donation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `product_id`, `donor_name`, `donor_email`, `amount`, `donation_date`) VALUES
(1, 1, 'Samuel Hamonangan Silitonga', 'samuel@gmail.com', '100000.00', '2024-12-31 10:01:20'),
(2, 3, 'Samuel Hamonangan Silitonga', 'samuel@gmail.com', '1000000.00', '2024-12-31 10:02:37'),
(3, 1, 'Samuel Hamonangan Silitonga', 'samuel@gmail.com', '2500000.00', '2024-12-31 10:03:56'),
(4, 1, 'Ananda Putri Chayani', 'nanda@gmail.com', '100000.00', '2024-12-31 10:04:53'),
(5, 2, 'Ananda Putri Chayani', 'nanda@gmail.com', '5000000.00', '2024-12-31 10:06:01'),
(6, 3, 'Ananda Putri Chayani', 'nanda@gmail.com', '100000.00', '2024-12-31 10:06:49'),
(7, 3, 'Samuel Hamonangan Silitonga', 'samuel@gmail.com', '3500000.00', '2024-12-31 10:07:52'),
(8, 4, 'Samuel Hamonangan Silitonga', 'samuel@gmail.com', '1000000.00', '2024-12-31 10:08:29'),
(9, 1, 'Muhamad Ikhwan Fadilah', 'iwan@gmail.com', '100000.00', '2024-12-31 10:09:18'),
(10, 2, 'Muhamad Ikhwan Fadilah', 'iwan@gmail.com', '1000000.00', '2024-12-31 10:09:56'),
(11, 3, 'Muhamad Ikhwan Fadilah', 'iwan@gmail.com', '2000000.00', '2024-12-31 10:10:33'),
(12, 4, 'Muhamad Ikhwan Fadilah', 'iwan@gmail.com', '100000.00', '2024-12-31 10:11:01'),
(13, 1, 'Ananda Putri Chayani', 'nanda@gmail.com', '1000000.00', '2024-12-31 10:12:11');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `goal_price` decimal(15,2) NOT NULL,
  `current_price` decimal(15,2) DEFAULT 0.00,
  `thumbnail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `goal_price`, `current_price`, `thumbnail`) VALUES
(1, 1, 'Air Bersih Papua', 'Bantu Warga Papua Untuk Mendapatkan Air Bersih', '5000000.00', '3800000.00', 'download.jpeg'),
(2, 2, 'Rumah Susun Aceh', 'Bantu Warga Untuk Mendapatkan Tempat Tinggal Yang Layak', '10000000.00', '6000000.00', 'aceh.jpeg'),
(3, 3, 'Beasiswa Berprestasi Indonesia', 'Bantu Siswa Dan Mahasiswa Indonesia Agar Menuju Indonesia Emas 2045', '50000000.00', '38100000.00', '64a7d4c1b935c.png'),
(4, 4, 'Kebutuhan Pokok Jogja', 'Bantu Warga Jogja Untuk Kebutuhan Pokok Akibat Tsunami', '5000000.00', '1100000.00', 'Screenshot 2024-12-09 105052.png');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `product` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
