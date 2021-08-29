-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2021 at 02:41 PM
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

--
-- Dumping data for table `at_transactions`
--

INSERT INTO `at_transactions` (`ref_transaction_id`, `ref_product_id`, `qty`, `price`, `subtotal_price`, `sort`) VALUES
('7c7b3ceb-b199-4eb1-b9f9-d733dece2331', 'eeaf9ad6-e7bb-4481-a153-5b000e68fb98', 1, 9300000, 9300000, 1),
('7c7b3ceb-b199-4eb1-b9f9-d733dece2331', '09eba22e-2e3b-4c89-9756-700be9c8074e', 1, 10300000, 10300000, 2),
('caeac03a-8187-4602-bcf5-e7dda4d90c1b', '394a6a2b-055b-4dfe-92ce-1b839c56312a', 1, 9800000, 9800000, 1),
('d38b793d-1d61-45ab-a093-8ad093d73dbf', '394a6a2b-055b-4dfe-92ce-1b839c56312a', 1, 9800000, 9800000, 1),
('7208df50-b350-44d9-8546-d92969e97aa4', '394a6a2b-055b-4dfe-92ce-1b839c56312a', 3, 9800000, 29400000, 1),
('7208df50-b350-44d9-8546-d92969e97aa4', '6e2ad48a-5db9-4e29-895e-779d74f7266a', 2, 7300000, 14600000, 2),
('7208df50-b350-44d9-8546-d92969e97aa4', '09eba22e-2e3b-4c89-9756-700be9c8074e', 3, 10300000, 30900000, 3),
('1b3e504d-5a8c-4a75-a0f3-20a13b2bab3f', '09eba22e-2e3b-4c89-9756-700be9c8074e', 1, 10300000, 10300000, 1),
('1b3e504d-5a8c-4a75-a0f3-20a13b2bab3f', '6e2ad48a-5db9-4e29-895e-779d74f7266a', 1, 7300000, 7300000, 2),
('227a422f-d745-4d76-8735-2287fa802d54', 'eeaf9ad6-e7bb-4481-a153-5b000e68fb98', 2, 9300000, 18600000, 1),
('227a422f-d745-4d76-8735-2287fa802d54', '6e2ad48a-5db9-4e29-895e-779d74f7266a', 2, 7300000, 14600000, 2);

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2021_08_27_140654_create_master_product_table', 1),
(3, '2021_08_27_140824_create_carts_table', 1),
(4, '2021_08_27_140858_create_transactions_table', 1),
(5, '2021_08_27_142646_create_at_carts_table', 1),
(6, '2021_08_27_142728_create_at_transactions_table', 1);

--
-- Dumping data for table `t_product`
--

INSERT INTO `t_product` (`id`, `product_code`, `product_name`, `product_image`, `price`, `publish`, `created_at`, `updated_at`) VALUES
('09eba22e-2e3b-4c89-9756-700be9c8074e', 'IPX11-PR01128', 'iPhone 11 Purple - 128GB', 'cts3ea8bUldlngTDbqp5OpNTZtl0eml7bFt4yAuh.jpg', 10300000, 'Y', '2021-08-29 08:55:37', '2021-08-29 08:55:37'),
('394a6a2b-055b-4dfe-92ce-1b839c56312a', 'IPX11-PR0164', 'iPhone 11 64GB - Purple', '8O9OYfy1ZMvl0dcTfGINg9sZh8rPp4GYLqxk7tT6.jpg', 9800000, 'Y', '2021-08-29 08:52:59', '2021-08-29 08:55:06'),
('6e2ad48a-5db9-4e29-895e-779d74f7266a', 'IPXR001', 'iPhone XR Red - 64GB', 'XV86yDD5bCEA601eTEYKrVEwxlZPWTlWhXDon2Vx.webp', 7300000, 'N', '2021-08-29 08:46:45', '2021-08-29 12:25:21'),
('eeaf9ad6-e7bb-4481-a153-5b000e68fb98', 'IPXR002', 'iPhone XR Red - 128GB', 'r0MeEKSjTKLy5rcd6fj5IO0ZgsIzgBE6AD59KqBs.webp', 9300000, 'Y', '2021-08-29 08:47:17', '2021-08-29 08:47:17');

--
-- Dumping data for table `t_transactions`
--

INSERT INTO `t_transactions` (`id`, `transaction_id`, `ref_user_id`, `total_price`, `total_qty`, `created_at`, `updated_at`) VALUES
('1b3e504d-5a8c-4a75-a0f3-20a13b2bab3f', 'TR-20210829-NFYXO', '4092378d-f484-4dc3-aaf3-0ff96ec39d8e', 17600000, 2, '2021-08-29 12:19:17', '2021-08-29 12:19:17'),
('227a422f-d745-4d76-8735-2287fa802d54', 'TR-20210829-MF2N2', '4092378d-f484-4dc3-aaf3-0ff96ec39d8e', 33200000, 4, '2021-08-29 12:19:35', '2021-08-29 12:19:35'),
('7208df50-b350-44d9-8546-d92969e97aa4', 'TR-20210829-25BTJ', '19450f2a-ee8f-4339-bd5d-a86028f6727e', 74900000, 8, '2021-08-29 12:17:11', '2021-08-29 12:17:11'),
('7c7b3ceb-b199-4eb1-b9f9-d733dece2331', 'TR-20210829-JPLBA', '19450f2a-ee8f-4339-bd5d-a86028f6727e', 19600000, 2, '2021-08-29 09:30:09', '2021-08-29 09:30:09'),
('caeac03a-8187-4602-bcf5-e7dda4d90c1b', 'TR-20210829-IL4GD', '19450f2a-ee8f-4339-bd5d-a86028f6727e', 9800000, 1, '2021-08-29 09:30:26', '2021-08-29 09:30:26'),
('d38b793d-1d61-45ab-a093-8ad093d73dbf', 'TR-20210829-KVGRL', '4092378d-f484-4dc3-aaf3-0ff96ec39d8e', 9800000, 1, '2021-08-29 09:55:02', '2021-08-29 09:55:02');

--
-- Dumping data for table `t_users`
--

INSERT INTO `t_users` (`id`, `nama`, `email`, `password`, `publish`, `roles`, `created_at`, `updated_at`) VALUES
('19450f2a-ee8f-4339-bd5d-a86028f6727e', 'Sony Darmawan', 'sonypiay@mail.com', '$2y$10$vATIdp3SB5nZxtTLMVifSOAJCGICM2nz.G7mDK.1YgQ61TKwAdUUy', 'Y', 'user', '2021-08-29 08:47:59', '2021-08-29 12:26:58'),
('1a5373c5-aa58-46b8-817d-cab2477969c1', 'Sony Darmawan', 'sonypiay@mail.com', '$2y$10$ufM0tXiEv7CeBY7g7sQF6eKK8YFA8HIDQs/uHhyu7/Kjz7zZpNXUK', 'Y', 'admin', '2021-08-29 08:45:45', '2021-08-29 12:20:21'),
('3c203075-b84e-480b-9217-55c2786e7b6a', 'Jati Hidayat S.I.Kom', 'sadina83@example.net', '$2y$10$eZOhlVVw51u0ijfogll8XOEXd4ERXuMZAEs02Rv1E8ILeaHbcC7rC', 'Y', 'admin', '2021-08-29 08:45:45', '2021-08-29 08:45:45'),
('4092378d-f484-4dc3-aaf3-0ff96ec39d8e', 'John Doe', 'john.doe@gmail.com', '$2y$10$25aRRHd2XXD3OJyR6ZQV/eD4.MqNb/9IG90qo4pHbmnRnU65PZHt.', 'Y', 'user', '2021-08-29 09:50:34', '2021-08-29 09:50:34'),
('ce5eff95-10fe-4dd0-8128-5377fdba6dfb', 'Nrima Lurhur Prayoga S.H.', 'victoria.tamba@example.net', '$2y$10$PTOToYT7eNTCS0xHaAzXjujpTlUuyJ.8TS3xz6zSnOSHP0CrqBy46', 'Y', 'admin', '2021-08-29 08:45:45', '2021-08-29 08:45:45');
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
