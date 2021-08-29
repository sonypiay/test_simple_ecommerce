-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2021 at 02:39 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.27

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simple_ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `at_carts`
--

CREATE TABLE `at_carts` (
  `id` char(36) NOT NULL,
  `ref_cart_id` char(36) NOT NULL,
  `ref_product_id` char(36) NOT NULL,
  `qty` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `price` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `subtotal_price` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `at_transactions`
--

CREATE TABLE `at_transactions` (
  `ref_transaction_id` char(36) NOT NULL,
  `ref_product_id` char(36) NOT NULL,
  `qty` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `price` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `subtotal_price` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `sort` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t_carts`
--

CREATE TABLE `t_carts` (
  `id` char(36) NOT NULL,
  `ref_user_id` char(36) NOT NULL,
  `total_price` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `total_qty` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t_product`
--

CREATE TABLE `t_product` (
  `id` char(36) NOT NULL,
  `product_code` varchar(20) NOT NULL,
  `product_name` varchar(128) NOT NULL,
  `product_image` varchar(128) NOT NULL,
  `price` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `publish` enum('Y','N') NOT NULL DEFAULT 'Y',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t_transactions`
--

CREATE TABLE `t_transactions` (
  `id` char(36) NOT NULL,
  `transaction_id` varchar(20) NOT NULL,
  `ref_user_id` char(36) NOT NULL,
  `total_price` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `total_qty` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t_users`
--

CREATE TABLE `t_users` (
  `id` char(36) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `publish` enum('Y','N') NOT NULL DEFAULT 'Y',
  `roles` enum('admin','user') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `at_carts`
--
ALTER TABLE `at_carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `at_carts_ref_cart_id_foreign` (`ref_cart_id`);

--
-- Indexes for table `at_transactions`
--
ALTER TABLE `at_transactions`
  ADD KEY `at_transactions_ref_transaction_id_foreign` (`ref_transaction_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_carts`
--
ALTER TABLE `t_carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_carts_ref_user_id_foreign` (`ref_user_id`);

--
-- Indexes for table `t_product`
--
ALTER TABLE `t_product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `t_product_product_code_unique` (`product_code`);

--
-- Indexes for table `t_transactions`
--
ALTER TABLE `t_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `t_transactions_transaction_id_unique` (`transaction_id`),
  ADD KEY `t_transactions_ref_user_id_foreign` (`ref_user_id`);

--
-- Indexes for table `t_users`
--
ALTER TABLE `t_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `t_users_email_roles_unique` (`email`,`roles`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `at_carts`
--
ALTER TABLE `at_carts`
  ADD CONSTRAINT `at_carts_ref_cart_id_foreign` FOREIGN KEY (`ref_cart_id`) REFERENCES `t_carts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `at_transactions`
--
ALTER TABLE `at_transactions`
  ADD CONSTRAINT `at_transactions_ref_transaction_id_foreign` FOREIGN KEY (`ref_transaction_id`) REFERENCES `t_transactions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `t_carts`
--
ALTER TABLE `t_carts`
  ADD CONSTRAINT `t_carts_ref_user_id_foreign` FOREIGN KEY (`ref_user_id`) REFERENCES `t_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `t_transactions`
--
ALTER TABLE `t_transactions`
  ADD CONSTRAINT `t_transactions_ref_user_id_foreign` FOREIGN KEY (`ref_user_id`) REFERENCES `t_users` (`id`) ON DELETE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
