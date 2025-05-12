-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2025 at 06:01 PM
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
(1, 'IT Department', NULL, NULL),
(2, 'Finance Department', NULL, NULL),
(3, 'HR Department', NULL, NULL),
(4, 'Procurement', NULL, NULL),
(5, 'Technical Support', NULL, NULL);

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
(1, 'Alice Ramos', '09171234567', 1, NULL, NULL),
(2, 'Mark De Guzman', '09181234567', 2, NULL, NULL),
(3, 'Jenny Cruz', '09192234567', 3, NULL, NULL),
(4, 'Leo Fernandez', '09173456789', 4, NULL, NULL),
(5, 'Carla Santos', '09184567890', 5, NULL, NULL);

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
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity_issued` int(11) NOT NULL,
  `stock_out_type` varchar(255) DEFAULT NULL,
  `issue_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `issued_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_issues`
--

INSERT INTO `inventory_issues` (`id`, `product_id`, `employee_id`, `department_id`, `quantity_issued`, `stock_out_type`, `issue_date`, `notes`, `issued_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 'Assigned', '2025-05-12', '2', 2, '2025-05-12 06:42:39', '2025-05-12 06:42:39'),
(2, 1, 2, 1, 2, 'Assigned', '2025-05-12', '3', 2, '2025-05-12 06:43:10', '2025-05-12 06:43:10'),
(6, 1, 1, 1, 1, 'Assigned', '2025-05-12', '123', 2, '2025-05-12 07:22:44', '2025-05-12 07:22:44'),
(7, 1, 1, 1, 1, 'Assigned', '2025-05-12', '1213', 2, '2025-05-12 07:22:58', '2025-05-12 07:22:58'),
(8, 1, 1, 1, 1, 'Assigned', '2025-05-12', '213', 2, '2025-05-12 07:24:01', '2025-05-12 07:24:01'),
(9, 1, 2, 2, 1, 'Assigned', '2025-05-12', '12521', 2, '2025-05-12 07:27:09', '2025-05-12 07:27:09');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_logs`
--

CREATE TABLE `inventory_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('stock_in','stock_out') NOT NULL,
  `quantity` int(11) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_logs`
--

INSERT INTO `inventory_logs` (`id`, `product_id`, `type`, `quantity`, `reference`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 'stock_in', 6, '1', 'Stock received from purchase order', '2025-05-12 05:29:01', '2025-05-12 05:29:01'),
(2, 1, 'stock_out', 1, NULL, '2', '2025-05-12 06:42:39', '2025-05-12 06:42:39'),
(3, 1, 'stock_out', 2, NULL, '3', '2025-05-12 06:43:10', '2025-05-12 06:43:10'),
(4, 4, 'stock_in', 5, '3', 'Stock received from purchase order', '2025-05-12 07:02:42', '2025-05-12 07:02:42'),
(5, 5, 'stock_in', 5, '3', 'Stock received from purchase order', '2025-05-12 07:02:42', '2025-05-12 07:02:42'),
(6, 6, 'stock_in', 5, '3', 'Stock received from purchase order', '2025-05-12 07:02:42', '2025-05-12 07:02:42'),
(7, 7, 'stock_in', 5, '3', 'Stock received from purchase order', '2025-05-12 07:02:42', '2025-05-12 07:02:42'),
(8, 8, 'stock_in', 5, '3', 'Stock received from purchase order', '2025-05-12 07:02:42', '2025-05-12 07:02:42'),
(9, 9, 'stock_in', 5, '3', 'Stock received from purchase order', '2025-05-12 07:02:42', '2025-05-12 07:02:42'),
(10, 10, 'stock_in', 5, '3', 'Stock received from purchase order', '2025-05-12 07:02:42', '2025-05-12 07:02:42'),
(11, 4, 'stock_in', 2, '3', 'Stock received from purchase order', '2025-05-12 07:10:13', '2025-05-12 07:10:13'),
(12, 5, 'stock_in', 2, '3', 'Stock received from purchase order', '2025-05-12 07:10:13', '2025-05-12 07:10:13'),
(13, 6, 'stock_in', 2, '3', 'Stock received from purchase order', '2025-05-12 07:10:13', '2025-05-12 07:10:13'),
(14, 7, 'stock_in', 3, '3', 'Stock received from purchase order', '2025-05-12 07:10:13', '2025-05-12 07:10:13'),
(15, 8, 'stock_in', 1, '3', 'Stock received from purchase order', '2025-05-12 07:10:13', '2025-05-12 07:10:13'),
(16, 9, 'stock_in', 2, '3', 'Stock received from purchase order', '2025-05-12 07:10:13', '2025-05-12 07:10:13'),
(17, 10, 'stock_in', 2, '3', 'Stock received from purchase order', '2025-05-12 07:10:13', '2025-05-12 07:10:13'),
(18, 1, 'stock_out', 1, NULL, '123', '2025-05-12 07:22:44', '2025-05-12 07:22:44'),
(19, 1, 'stock_out', 1, NULL, '1213', '2025-05-12 07:22:58', '2025-05-12 07:22:58'),
(20, 1, 'stock_out', 1, NULL, '213', '2025-05-12 07:24:01', '2025-05-12 07:24:01'),
(21, 1, 'stock_out', 1, '9', '12521', '2025-05-12 07:27:09', '2025-05-12 07:27:09');

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
(21, '2025_05_10_050552_add_issued_by_to_inventory_issues_table', 9),
(24, '2025_05_11_000000_create_inventory_logs_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
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

INSERT INTO `order_details` (`id`, `product_id`, `purchase_order_id`, `quantity_ordered`, `price_per_item`, `order_date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 6, 5.00, '2025-05-12', '2025-05-12 04:14:05', '2025-05-12 04:14:05'),
(2, 1, 2, 6, 5.00, '2025-05-12', '2025-05-12 04:52:51', '2025-05-12 04:52:51'),
(3, 2, 2, 7, 25.00, '2025-05-12', '2025-05-12 04:52:51', '2025-05-12 04:52:51'),
(4, 3, 2, 8, 3.00, '2025-05-12', '2025-05-12 04:52:51', '2025-05-12 04:52:51'),
(5, 11, 2, 8, 5.00, '2025-05-12', '2025-05-12 04:52:51', '2025-05-12 04:52:51'),
(6, 4, 3, 7, 5.00, '2025-05-12', '2025-05-12 04:52:51', '2025-05-12 04:52:51'),
(7, 5, 3, 8, 5.00, '2025-05-12', '2025-05-12 04:52:51', '2025-05-12 04:52:51'),
(8, 6, 3, 7, 5.00, '2025-05-12', '2025-05-12 04:52:51', '2025-05-12 04:52:51'),
(9, 7, 3, 9, 5.00, '2025-05-12', '2025-05-12 04:52:51', '2025-05-12 04:52:51'),
(10, 8, 3, 6, 5.00, '2025-05-12', '2025-05-12 04:52:51', '2025-05-12 04:52:51'),
(11, 9, 3, 7, 5.00, '2025-05-12', '2025-05-12 04:52:51', '2025-05-12 04:52:51'),
(12, 10, 3, 7, 5.00, '2025-05-12', '2025-05-12 04:52:51', '2025-05-12 04:52:51');

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
  `status` enum('available','low stock','out of stock') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `type`, `quantity`, `price_per_item`, `min_stock_level`, `serial_number`, `specifications`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Ryzen', 'Skamb', 'CPU', 3, 5.00, 5, 'SN-6821E5E3F3874', 'xasd', 'low stock', '2025-05-12 04:13:23', '2025-05-12 07:27:09'),
(2, 'kigwa', '123', 'RAM', 3, 25.00, 5, 'SN-6821E64448356', '2313', 'low stock', '2025-05-12 04:15:00', '2025-05-12 04:15:00'),
(3, 'sadasd', 'asdasdas', 'Storage', 2, 3.00, 5, 'SN-6821E74AB6C61', 'adsdasdas', 'low stock', '2025-05-12 04:19:22', '2025-05-12 04:19:22'),
(4, '1212512', '1251251', 'RAM', 10, 5.00, 5, 'SN-6821E823ECC2B', '12515215', 'low stock', '2025-05-12 04:22:59', '2025-05-12 07:10:13'),
(5, 'erewwewwe', '123213', 'Motherboard', 9, 5.00, 5, 'SN-6821E84A3B14C', '12412421', 'low stock', '2025-05-12 04:23:38', '2025-05-12 07:10:13'),
(6, 'skigwa12', '12', 'Storage', 10, 5.00, 5, 'SN-6821E88D5F763', '1241', 'low stock', '2025-05-12 04:24:45', '2025-05-12 07:10:13'),
(7, '12312312', '12412', 'Storage', 9, 5.00, 5, 'SN-6821E96A93F96', '4214214', 'low stock', '2025-05-12 04:28:26', '2025-05-12 07:10:13'),
(8, 'Ryzen', '123123', 'Motherboard', 10, 5.00, 5, 'SN-6821E9D350AC3', '12312321', 'low stock', '2025-05-12 04:30:11', '2025-05-12 07:10:13'),
(9, 'ohohohw', '12312', 'CPU', 10, 5.00, 5, 'SN-6821EA5B997D5', '12312', 'low stock', '2025-05-12 04:32:27', '2025-05-12 07:10:13'),
(10, 'dssdsd', '12321', 'Graphics Card', 10, 5.00, 5, 'SN-6821EBB0A410F', '12312', 'low stock', '2025-05-12 04:38:08', '2025-05-12 07:10:13'),
(11, 'qew', '1321', 'Graphics Card', 2, 5.00, 5, 'SN-6821EBC7D89EE', '123', 'low stock', '2025-05-12 04:38:31', '2025-05-12 04:52:51');

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
(1, 1, 1, NULL, NULL),
(2, 2, 1, NULL, NULL),
(3, 3, 1, NULL, NULL),
(4, 4, 2, NULL, NULL),
(5, 5, 2, NULL, NULL),
(6, 6, 2, NULL, NULL),
(7, 7, 2, NULL, NULL),
(8, 8, 2, NULL, NULL),
(9, 9, 2, NULL, NULL),
(10, 10, 2, NULL, NULL),
(11, 11, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('draft','partial','pending','approved','completed','received','cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `supplier_id`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 30.00, 'received', '2025-05-12 04:14:05', '2025-05-12 05:29:01'),
(2, 1, 269.00, 'draft', '2025-05-12 04:52:51', '2025-05-12 04:52:51'),
(3, 2, 255.00, 'partial', '2025-05-12 04:52:51', '2025-05-12 07:02:42');

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
(1, 1, '2025-05-12', 6, 'Luis', '12312', '2025-05-12 05:29:01', '2025-05-12 05:29:01'),
(2, 6, '2025-05-12', 5, 'Justin', NULL, '2025-05-12 07:02:42', '2025-05-12 07:02:42'),
(3, 7, '2025-05-12', 5, 'Justin', NULL, '2025-05-12 07:02:42', '2025-05-12 07:02:42'),
(4, 8, '2025-05-12', 5, 'Justin', NULL, '2025-05-12 07:02:42', '2025-05-12 07:02:42'),
(5, 9, '2025-05-12', 5, 'Justin', NULL, '2025-05-12 07:02:42', '2025-05-12 07:02:42'),
(6, 10, '2025-05-12', 5, 'Justin', NULL, '2025-05-12 07:02:42', '2025-05-12 07:02:42'),
(7, 11, '2025-05-12', 5, 'Justin', NULL, '2025-05-12 07:02:42', '2025-05-12 07:02:42'),
(8, 12, '2025-05-12', 5, 'Justin', '123', '2025-05-12 07:02:42', '2025-05-12 07:02:42'),
(9, 6, '2025-05-12', 2, 'Justin', NULL, '2025-05-12 07:10:13', '2025-05-12 07:10:13'),
(10, 7, '2025-05-12', 2, 'Justin', NULL, '2025-05-12 07:10:13', '2025-05-12 07:10:13'),
(11, 8, '2025-05-12', 2, 'Justin', NULL, '2025-05-12 07:10:13', '2025-05-12 07:10:13'),
(12, 9, '2025-05-12', 3, 'Justin', NULL, '2025-05-12 07:10:13', '2025-05-12 07:10:13'),
(13, 10, '2025-05-12', 1, 'Justin', NULL, '2025-05-12 07:10:13', '2025-05-12 07:10:13'),
(14, 11, '2025-05-12', 2, 'Justin', NULL, '2025-05-12 07:10:13', '2025-05-12 07:10:13'),
(15, 12, '2025-05-12', 2, 'Justin', NULL, '2025-05-12 07:10:13', '2025-05-12 07:10:13');

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
('RTroSzo7NG3sFYOHG55Wuenn7m4sVh7Ah1IntTPZ', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYnZFSFMxeG0yNUdHMDlFdWw1Y0VMRDVtWmhVWk1xVDY5c29wN3pXZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2ludmVudG9yeS1sb2dzIjt9fQ==', 1747065177);

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
(1, 'Justin', '12312312312', 'baker@gmail.com', '2025-05-12 04:13:36', '2025-05-12 04:13:36'),
(2, 'Bilat', '125125', 'divinelovemypookiebear@gmail.com', '2025-05-12 04:22:42', '2025-05-12 04:22:42');

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
-- Indexes for table `inventory_logs`
--
ALTER TABLE `inventory_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_logs_product_id_foreign` (`product_id`);

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
  ADD KEY `order_details_part_id_foreign` (`product_id`),
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_issues`
--
ALTER TABLE `inventory_issues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `inventory_logs`
--
ALTER TABLE `inventory_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_supplier`
--
ALTER TABLE `product_supplier`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchase_order_receivings`
--
ALTER TABLE `purchase_order_receivings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- Constraints for table `inventory_logs`
--
ALTER TABLE `inventory_logs`
  ADD CONSTRAINT `inventory_logs_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_part_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
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
