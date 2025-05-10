-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2025 at 07:49 AM
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
-- Database: `it9al_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Bilat', '2025-05-04 09:18:24', '2025-05-04 09:18:24');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `contact_number`, `department_id`, `created_at`, `updated_at`) VALUES
(1, 'Divine', '09123456789', 1, '2025-05-04 09:18:34', '2025-05-04 09:18:34'),
(2, 'Divine', '09123456789', 1, '2025-05-04 09:41:56', '2025-05-04 09:41:56');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_issues`
--

CREATE TABLE `inventory_issues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `quantity_issued` int(11) NOT NULL,
  `issue_date` date NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `issued_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_issues`
--

INSERT INTO `inventory_issues` (`id`, `product_id`, `employee_id`, `department_id`, `quantity_issued`, `issue_date`, `reason`, `notes`, `issued_by`, `created_at`, `updated_at`) VALUES
(1, 15, 1, 1, 12, '2025-05-10', 'asd', 'asd', NULL, '2025-05-09 20:55:07', '2025-05-09 20:55:07'),
(2, 15, 1, 1, 15, '2025-05-10', '123', '123', 2, '2025-05-09 21:07:13', '2025-05-09 21:07:13'),
(3, 15, 1, 1, 12, '2025-05-10', '123', '123', 2, '2025-05-09 21:08:10', '2025-05-09 21:08:10'),
(4, 15, 1, 1, 3, '2025-05-10', 'sda', 'asd', 2, '2025-05-09 21:09:03', '2025-05-09 21:09:03'),
(5, 15, 1, 1, 4, '2025-05-10', '123', '231', 2, '2025-05-09 21:20:15', '2025-05-09 21:20:15');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_11_095000_create_suppliers_table', 1),
(5, '2025_04_12_054449_create_products_table', 1),
(6, '2025_04_18_154624_create_departments_table', 1),
(7, '2025_04_18_154638_create_employees_table', 1),
(8, '2025_04_18_154701_create_purchase_orders_table', 1),
(9, '2025_04_18_154706_create_order_details_table', 1),
(10, '2025_04_18_154720_create_inventory_issues_table', 1),
(11, '2025_04_18_155615_create_reports_table', 1),
(12, '2025_04_18_160012_create_purchase_order_receivings_table', 1),
(13, '2025_04_28_121521_create_stocks_table', 2),
(14, '2025_05_01_100000_update_status_column_in_purchase_orders_table', 2),
(15, '2025_05_02_062319_add_price_per_item_to_products_table', 3),
(16, '2025_05_05_999999_update_order_details_foreign_key', 4),
(17, '2025_05_05_999998_remove_supplier_id_from_products', 5),
(18, '2025_05_06_051238_add_price_per_item_to_order_details_table', 6),
(19, '2025_05_06_054614_create_product_supplier_table', 7),
(20, '2025_05_10_040721_add_reason_and_notes_to_inventory_issues_table', 8),
(21, '2025_05_10_050552_add_issued_by_to_inventory_issues_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `part_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_id` bigint(20) UNSIGNED NOT NULL,
  `quantity_ordered` int(11) NOT NULL,
  `price_per_item` decimal(10,2) NOT NULL DEFAULT 0.00,
  `order_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `part_id`, `purchase_order_id`, `quantity_ordered`, `price_per_item`, `order_date`, `created_at`, `updated_at`) VALUES
(2, 1, 2, 1, 0.00, '2025-05-05', '2025-05-04 19:02:08', '2025-05-04 19:02:08'),
(3, 1, 3, 10, 0.00, '2025-05-05', '2025-05-05 01:33:21', '2025-05-05 01:33:21'),
(4, 1, 4, 15, 0.00, '2025-05-05', '2025-05-05 05:06:05', '2025-05-05 05:06:05'),
(5, 8, 5, 10, 0.00, '2025-05-05', '2025-05-05 05:07:10', '2025-05-05 05:07:10'),
(6, 8, 6, 20, 0.00, '2025-05-05', '2025-05-05 05:07:48', '2025-05-05 05:07:48'),
(7, 1, 7, 10, 0.00, '2025-05-06', '2025-05-05 20:58:47', '2025-05-05 20:58:47'),
(8, 1, 8, 10, 0.00, '2025-05-06', '2025-05-05 21:09:36', '2025-05-05 21:09:36'),
(9, 1, 9, 10, 0.00, '2025-05-06', '2025-05-05 21:13:14', '2025-05-05 21:13:14'),
(10, 9, 10, 9, 150.00, '2025-05-06', '2025-05-05 21:13:34', '2025-05-05 21:13:34'),
(11, 10, 11, 10, 120.00, '2025-05-06', '2025-05-05 21:58:05', '2025-05-05 21:58:05'),
(12, 10, 12, 125, 120.00, '2025-05-06', '2025-05-05 21:58:23', '2025-05-05 21:58:23'),
(13, 14, 13, 10, 124122.00, '2025-05-06', '2025-05-05 23:03:17', '2025-05-05 23:03:17'),
(14, 14, 14, 10, 124122.00, '2025-05-08', '2025-05-08 07:08:37', '2025-05-08 07:08:37'),
(15, 15, 15, 50, 5.00, '2025-05-08', '2025-05-08 07:47:27', '2025-05-08 07:47:27'),
(16, 15, 16, 10, 5.00, '2025-05-08', '2025-05-08 09:38:51', '2025-05-08 09:38:51');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `price_per_item` decimal(10,2) NOT NULL,
  `min_stock_level` int(11) NOT NULL DEFAULT 5,
  `serial_number` varchar(255) DEFAULT NULL,
  `specifications` text NOT NULL,
  `status` enum('available','assigned','maintenance','retired') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `type`, `quantity`, `price_per_item`, `min_stock_level`, `serial_number`, `specifications`, `status`, `created_at`, `updated_at`) VALUES
(1, 'AMD', '', 'Motherboard', 116, 0.00, 5, NULL, '', 'available', '2025-05-04 19:01:48', '2025-05-05 20:59:47'),
(2, 'Ryzen', '', 'CPU', 15, 0.00, 5, NULL, '', 'available', '2025-05-05 02:15:45', '2025-05-05 02:15:45'),
(3, 'Bilat', '', 'Storage', 123, 0.00, 5, NULL, '', 'available', '2025-05-05 02:59:23', '2025-05-05 02:59:23'),
(4, 'bulbul', '', 'RAM', 10, 0.00, 5, NULL, '', 'available', '2025-05-05 03:15:55', '2025-05-05 03:15:55'),
(5, 'luisdanielpanal', '', 'CPU', 156, 0.00, 5, NULL, '', 'available', '2025-05-05 03:34:52', '2025-05-05 03:34:52'),
(6, '12312312', '', 'Storage', 123, 0.00, 5, NULL, '', 'available', '2025-05-05 03:43:57', '2025-05-05 03:43:57'),
(8, 'Intel', '23423', 'CPU', 13, 150.00, 5, 'SN-6818B7EBA64FC', 'xzcz', 'available', '2025-05-05 05:06:51', '2025-05-05 05:18:20'),
(9, 'GFORCE', 'BEST!', 'Power Supply', 150, 150.00, 5, 'SN-6819995FAADFF', 'skemberlu', 'available', '2025-05-05 21:08:47', '2025-05-05 21:08:47'),
(10, 'tralelelo tralala', 'skemter', 'Motherboard', 200, 120.00, 5, 'SN-6819A4DCAC369', 'kigwa', 'available', '2025-05-05 21:57:48', '2025-05-08 06:14:27'),
(11, 'zxcxxzcd', 'asdz', 'CPU', 1232, 123.00, 5, 'SN-6819A61D74912', 'zxczdc', 'available', '2025-05-05 22:03:09', '2025-05-05 22:03:09'),
(12, '12312312', '123213', 'Storage', 123, 123123.00, 5, 'SN-6819A8CC17C62', '1231231', 'available', '2025-05-05 22:14:36', '2025-05-05 22:14:36'),
(13, '23123', '123', 'CPU', 1232, 241.00, 5, 'SN-6819A8DA186CC', '123', 'available', '2025-05-05 22:14:50', '2025-05-05 22:14:50'),
(14, '12312312312', '141241', 'RAM', 12412422, 124122.00, 5, 'SN-6819ADC26C773', '12412412', 'available', '2025-05-05 22:35:46', '2025-05-08 07:36:17'),
(15, 'ROG', 'BEST!', 'CPU', 21, 5.00, 5, 'SN-681CD1FE2D787', 'kigwa', 'available', '2025-05-08 07:47:10', '2025-05-09 21:20:15');

-- --------------------------------------------------------

--
-- Table structure for table `product_supplier`
--

CREATE TABLE `product_supplier` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_supplier`
--

INSERT INTO `product_supplier` (`id`, `product_id`, `supplier_id`, `created_at`, `updated_at`) VALUES
(1, 10, 1, NULL, NULL),
(3, 12, 1, NULL, NULL),
(4, 12, 2, NULL, NULL),
(5, 13, 1, NULL, NULL),
(6, 14, 1, NULL, NULL),
(7, 15, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('partial','pending','approved','completed','received','cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `supplier_id`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 1.00, 'received', '2025-05-04 19:02:08', '2025-05-05 01:15:42'),
(3, 1, 10.00, 'approved', '2025-05-05 01:33:21', '2025-05-05 02:08:23'),
(4, 1, 15.00, 'pending', '2025-05-05 05:06:05', '2025-05-05 05:06:05'),
(5, 1, 10.00, 'approved', '2025-05-05 05:07:10', '2025-05-08 09:40:36'),
(6, 2, 20.00, 'approved', '2025-05-05 05:07:48', '2025-05-05 05:17:33'),
(7, 1, 10.00, 'received', '2025-05-05 20:58:47', '2025-05-05 20:59:47'),
(8, 2, 0.00, 'pending', '2025-05-05 21:09:36', '2025-05-05 21:09:36'),
(9, 1, 0.00, 'pending', '2025-05-05 21:13:14', '2025-05-05 21:13:14'),
(10, 2, 1350.00, 'approved', '2025-05-05 21:13:34', '2025-05-08 08:55:46'),
(11, 2, 1200.00, 'approved', '2025-05-05 21:58:05', '2025-05-08 08:55:37'),
(12, 1, 15000.00, 'partial', '2025-05-05 21:58:23', '2025-05-08 06:14:27'),
(13, 1, 1241220.00, 'received', '2025-05-05 23:03:17', '2025-05-08 07:36:17'),
(14, 1, 1241220.00, 'approved', '2025-05-08 07:08:37', '2025-05-08 08:00:59'),
(15, 2, 250.00, 'received', '2025-05-08 07:47:27', '2025-05-08 08:05:10'),
(16, 2, 50.00, 'received', '2025-05-08 09:38:51', '2025-05-08 09:52:43');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_receivings`
--

CREATE TABLE `purchase_order_receivings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_detail_id` bigint(20) UNSIGNED NOT NULL,
  `received_date` date NOT NULL,
  `quantity_received` int(11) NOT NULL,
  `received_by` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_order_receivings`
--

INSERT INTO `purchase_order_receivings` (`id`, `order_detail_id`, `received_date`, `quantity_received`, `received_by`, `notes`, `created_at`, `updated_at`) VALUES
(4, 2, '2025-05-05', 1, 'Luis', NULL, '2025-05-05 01:15:42', '2025-05-05 01:15:42'),
(5, 3, '2025-05-05', 5, 'Luis', NULL, '2025-05-05 02:08:48', '2025-05-05 02:08:48'),
(6, 6, '2025-05-05', 3, 'dfg', NULL, '2025-05-05 05:18:20', '2025-05-05 05:18:20'),
(7, 7, '2025-05-06', 10, 'Luis', NULL, '2025-05-05 20:59:47', '2025-05-05 20:59:47'),
(11, 12, '2025-05-08', 100, 'Luis', NULL, '2025-05-08 06:14:27', '2025-05-08 06:14:27'),
(12, 13, '2025-05-08', 10, 'Luis', NULL, '2025-05-08 07:36:17', '2025-05-08 07:36:17'),
(13, 15, '2025-05-08', 50, 'Divine', NULL, '2025-05-08 08:05:10', '2025-05-08 08:05:10'),
(14, 16, '2025-05-08', 10, 'Luis', NULL, '2025-05-08 09:52:43', '2025-05-08 09:52:43');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `report_type` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('tx8rdhplsKUYBDQxN1XSN4TSVvXJ5aB2QCTpeEuV', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWGJKckdmVlh2Tk5mN1FuSkVENHQ3azRHSGg3WFV4ck5hTm10VmhoUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2ludmVudG9yeS1pc3N1ZXMiO319', 1746856071);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `product_name`, `quantity`, `supplier`, `created_at`, `updated_at`) VALUES
(1, 'asd', 426, 'Justin', '2025-05-05 04:08:55', '2025-05-05 04:24:54');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `contact_number`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Justin', '09123456789', 'test@gmail.com', '2025-04-18 09:16:13', '2025-04-18 09:16:13'),
(2, 'Bieber', '12312312312', 'test@gmail.com', '2025-05-05 02:15:24', '2025-05-05 02:15:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Divine', 'divinelovemypookiebear@gmail.com', NULL, '$2y$12$Zvk7zt/sAFKGv70Exnmm4uHDY8l7OoEc.lsShsS/YlhE59miXok8a', NULL, '2025-04-18 08:44:21', '2025-04-18 08:44:21'),
(2, 'Justin', 'justin@gmail.com', NULL, '$2y$12$f1v8xFin4gkPXkqJwJAInuvf5cnSk9WxgZi9V4z2gWtH0spLa3AkW', NULL, '2025-05-03 20:48:15', '2025-05-03 20:48:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_department_id_foreign` (`department_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inventory_issues`
--
ALTER TABLE `inventory_issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_issues_employee_id_foreign` (`employee_id`),
  ADD KEY `inventory_issues_department_id_foreign` (`department_id`),
  ADD KEY `inventory_issues_part_id_foreign` (`product_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_part_id_foreign` (`part_id`),
  ADD KEY `order_details_purchase_order_id_foreign` (`purchase_order_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_serial_number_unique` (`serial_number`);

--
-- Indexes for table `product_supplier`
--
ALTER TABLE `product_supplier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_supplier_product_id_foreign` (`product_id`),
  ADD KEY `product_supplier_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_orders_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `purchase_order_receivings`
--
ALTER TABLE `purchase_order_receivings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_order_receivings_order_detail_id_foreign` (`order_detail_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_issues`
--
ALTER TABLE `inventory_issues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `product_supplier`
--
ALTER TABLE `product_supplier`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `purchase_order_receivings`
--
ALTER TABLE `purchase_order_receivings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `inventory_issues`
--
ALTER TABLE `inventory_issues`
  ADD CONSTRAINT `inventory_issues_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `inventory_issues_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `inventory_issues_part_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_part_id_foreign` FOREIGN KEY (`part_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `order_details_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_supplier`
--
ALTER TABLE `product_supplier`
  ADD CONSTRAINT `product_supplier_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_supplier_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchase_orders_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `purchase_order_receivings`
--
ALTER TABLE `purchase_order_receivings`
  ADD CONSTRAINT `purchase_order_receivings_order_detail_id_foreign` FOREIGN KEY (`order_detail_id`) REFERENCES `order_details` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
