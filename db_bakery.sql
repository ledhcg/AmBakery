-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2020 at 07:37 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bakery`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2020_10_22_160410_create_tbl_admin_table', 1),
(2, '2020_10_22_194836_create_tbl_product_category', 1),
(3, '2020_10_23_113045_create_tbl_product', 1),
(4, '2020_10_24_084829_create_tbl_brand', 1),
(5, '2020_12_11_111202_create_tbl_customer', 1),
(6, '2020_12_14_010741_create_tbl_dealer', 1),
(7, '2020_12_14_022532_create_tbl_order', 1),
(8, '2020_12_14_040320_create_tbl_order_detail', 1),
(12, '2020_12_17_203059_create_tbl_inventory_production', 2),
(13, '2020_12_17_203909_create_tbl_inventory_production_detail', 2),
(14, '2020_12_18_075133_create_tbl_material', 3),
(15, '2020_12_18_081056_create_tbl_partner', 3),
(16, '2020_12_18_100143_create_tbl_inventory_material_detail', 4),
(17, '2020_12_18_100218_create_tbl_inventory_material', 4),
(18, '2020_12_18_122341_create_tbl_used_material_detail', 5),
(19, '2020_12_18_122630_create_tbl_used_material', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `admin_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `admin_email`, `admin_password`, `admin_name`, `admin_image`, `admin_phone`, `created_at`, `updated_at`) VALUES
(1, 'dinhcuong.firewin99@gmail.com', '123456789', 'DINHCUONG', 'dinhcuong.png', '89857336161', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brand`
--

CREATE TABLE `tbl_brand` (
  `id` int(10) UNSIGNED NOT NULL,
  `brand_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_brand`
--

INSERT INTO `tbl_brand` (`id`, `brand_name`, `brand_description`, `brand_image`, `brand_status`, `created_at`, `updated_at`) VALUES
(1, 'Miratorg', 'Miratorg', 'unnamed.jpg', 1, '2020-12-12 12:24:28', NULL),
(2, 'AmBakery', 'AmBakery', '12791038_864984360278727_3202199694740381364_n.png', 1, '2020-12-16 15:57:59', '2020-12-19 11:35:40');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_dob` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`id`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `customer_dob`, `customer_gender`, `created_at`, `updated_at`) VALUES
(1, 'LE DINH CUONG', 'admin@dinhcuong.me', '89857336161', '11-Ya Parkovaya Street, 36', '16/04/1999', 'Male', '2020-12-14 23:58:19', NULL),
(2, 'CAO DUC MANH', 'manh@dinhcuong.me', '123456789', '11-Ya Parkovaya Street, 36', '31/12/2020', 'Male', '2020-12-14 23:59:32', NULL),
(3, 'NGUYEN XUAN BACH', 'bach@dinhcuong.me', '123456789', '11-Ya Parkovaya Street, 36', '31/12/2020', 'Male', '2020-12-15 00:00:13', NULL),
(4, 'VU XUAN CANH', 'canh@dinhcuong.me', '123456789', '11-Ya Parkovaya Street, 36', '31/12/2020 ', 'Male', '2020-12-15 00:00:47', '2020-12-16 17:33:36');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dealer`
--

CREATE TABLE `tbl_dealer` (
  `id` int(10) UNSIGNED NOT NULL,
  `dealer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dealer_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dealer_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dealer_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dealer_dob` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dealer_gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_dealer`
--

INSERT INTO `tbl_dealer` (`id`, `dealer_name`, `dealer_email`, `dealer_phone`, `dealer_address`, `dealer_dob`, `dealer_gender`, `created_at`, `updated_at`) VALUES
(1, 'DEALER A', 'a@dinhcuong.me', '123456789', '11-Ya Parkovaya Street, 36', '31/12/2020', 'Male', '2020-12-15 00:01:54', NULL),
(2, 'DEALER B', 'b@dinhcuong.me', '123456789', '11-Ya Parkovaya Street, 36', '31/12/2020', 'Male', '2020-12-15 00:02:20', NULL),
(3, 'DEALER C', 'c@dinhcuong.me', '123456789', '11-Ya Parkovaya Street, 36', '31/12/2020', 'Male', '2020-12-15 00:02:54', '2020-12-16 23:39:01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inventory_material`
--

CREATE TABLE `tbl_inventory_material` (
  `id` int(10) UNSIGNED NOT NULL,
  `inventory_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dealer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inventory_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inventory_note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `materials_updated` int(11) NOT NULL,
  `quantity_updated` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_inventory_material`
--

INSERT INTO `tbl_inventory_material` (`id`, `inventory_id`, `dealer_id`, `inventory_time`, `inventory_note`, `materials_updated`, `quantity_updated`, `created_at`, `updated_at`) VALUES
(2, '8287821343', '2', '18/12/2020 13:32', '4', 1, 1, '2020-12-18 10:37:15', NULL),
(3, '8292250177', '2', '18/12/2020 14:50', 'Nothing', 1, 1, '2020-12-18 11:50:57', NULL),
(4, '8292315980', '2', '18/12/2020 14:51', 'Nothing', 1, 1, '2020-12-18 11:52:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inventory_material_detail`
--

CREATE TABLE `tbl_inventory_material_detail` (
  `id` int(10) UNSIGNED NOT NULL,
  `inventory_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `material_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `material_stock` int(11) NOT NULL,
  `additional_quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_inventory_material_detail`
--

INSERT INTO `tbl_inventory_material_detail` (`id`, `inventory_id`, `material_id`, `material_stock`, `additional_quantity`, `created_at`, `updated_at`) VALUES
(2, '8287821343', '6', 1, 1, '2020-12-18 10:37:15', NULL),
(3, '8292250177', '6', 2, 1, '2020-12-18 11:50:57', NULL),
(4, '8292315980', '6', 3, 1, '2020-12-18 11:52:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inventory_production`
--

CREATE TABLE `tbl_inventory_production` (
  `id` int(10) UNSIGNED NOT NULL,
  `inventory_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dealer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inventory_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inventory_note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `products_updated` int(11) NOT NULL,
  `quantity_updated` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_inventory_production`
--

INSERT INTO `tbl_inventory_production` (`id`, `inventory_id`, `dealer_id`, `inventory_time`, `inventory_note`, `products_updated`, `quantity_updated`, `created_at`, `updated_at`) VALUES
(11, '8246231615', '1', '18/12/2020 02:03', 'Nothing', 1, 1, '2020-12-17 23:04:00', NULL),
(13, '8246278689', '3', '18/12/2020 02:03', 'Nothing', 3, 3, '2020-12-17 23:04:48', NULL),
(17, '8288730804', '1', '18/12/2020 13:52', 'Nothing', 1, 1, '2020-12-18 10:52:18', NULL),
(18, '8288754538', '2', '18/12/2020 13:52', 'Nothing', 1, 1, '2020-12-18 10:52:43', NULL),
(20, '8289243818', '1', '18/12/2020 14:00', 'Nothing', 1, 1, '2020-12-18 11:00:50', NULL),
(21, '8289661116', '2', '18/12/2020 14:07', 'Nothing', 1, 1, '2020-12-18 11:07:48', NULL),
(22, '8289697453', '2', '18/12/2020 14:08', 'Nothing', 1, 1, '2020-12-18 11:08:24', NULL),
(23, '8291753060', '2', '18/12/2020 14:42', 'Nothing', 1, 1, '2020-12-18 11:42:45', NULL),
(24, '8291848529', '3', '18/12/2020 14:44', 'Nothing', 1, 1, '2020-12-18 11:44:17', NULL),
(25, '8292009230', '2', '18/12/2020 14:46', 'Nothing', 1, 1, '2020-12-18 11:47:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inventory_production_detail`
--

CREATE TABLE `tbl_inventory_production_detail` (
  `id` int(10) UNSIGNED NOT NULL,
  `inventory_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_stock` int(11) NOT NULL,
  `additional_quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_inventory_production_detail`
--

INSERT INTO `tbl_inventory_production_detail` (`id`, `inventory_id`, `product_id`, `product_stock`, `additional_quantity`, `created_at`, `updated_at`) VALUES
(14, '8246231615', '3', 10, 1, '2020-12-17 23:04:00', NULL),
(18, '8246278689', '4', 10, 1, '2020-12-17 23:04:48', NULL),
(19, '8246278689', '3', 10, 1, '2020-12-17 23:04:48', NULL),
(20, '8246278689', '6', 10, 1, '2020-12-17 23:04:48', NULL),
(24, '8288730804', '3', 10, 1, '2020-12-18 10:52:18', NULL),
(25, '8288754538', '2', 10, 1, '2020-12-18 10:52:43', NULL),
(27, '8289243818', '1', 10, 1, '2020-12-18 11:00:50', NULL),
(28, '8289661116', '3', 11, 1, '2020-12-18 11:07:48', NULL),
(29, '8289697453', '2', 12, 1, '2020-12-18 11:08:24', NULL),
(30, '8291753060', '2', 13, 1, '2020-12-18 11:42:45', NULL),
(31, '8291848529', '3', 12, 1, '2020-12-18 11:44:17', NULL),
(32, '8292009230', '5', 10, 1, '2020-12-18 11:47:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_material`
--

CREATE TABLE `tbl_material` (
  `id` int(10) UNSIGNED NOT NULL,
  `material_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partner_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `material_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `material_import_price` double(8,2) NOT NULL,
  `material_unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `material_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `material_status` int(11) NOT NULL,
  `material_stock` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_material`
--

INSERT INTO `tbl_material` (`id`, `material_name`, `partner_id`, `material_description`, `material_import_price`, `material_unit`, `material_image`, `material_status`, `material_stock`, `created_at`, `updated_at`) VALUES
(3, 'Cooking Oil', '1', 'Cooking Oil', 3.00, '5', 'AN220-Olive-Oil-732x549-Thumb.jpg', 1, 3, '2020-12-18 08:53:08', '2020-12-19 11:48:37'),
(5, 'Flour', '1', 'Flour', 5.00, '1 KG', 'WholeWheatFlour_Lead.jpg', 1, 0, '2020-12-18 09:03:32', '2020-12-19 11:47:42'),
(6, 'Sugar', '1', 'Sugar', 2.50, '1 KG', 'SUGER.jpg', 1, 3, '2020-12-18 09:29:26', '2020-12-19 11:45:22'),
(7, 'Salt', '1', 'Salt', 2.00, '1 KG', 'cooking-salts.jpg', 1, 0, '2020-12-18 11:52:22', '2020-12-19 11:43:27'),
(9, 'Egg', '1', 'Egg', 3.00, '20', 'a-basket-of-eggs.jpg', 1, 0, '2020-12-19 11:49:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dealer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_payment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_total` double(8,2) NOT NULL,
  `order_discount` double(8,2) NOT NULL,
  `order_received` double(8,2) NOT NULL,
  `order_debit` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`id`, `order_id`, `customer_id`, `dealer_id`, `order_time`, `order_message`, `order_payment`, `order_total`, `order_discount`, `order_received`, `order_debit`, `created_at`, `updated_at`) VALUES
(20, '8297946019', '1', '2', '18/12/2020 16:25', 'Nothing', 'CREDIT', 7.95, 0.00, 3.00, 4.95, '2020-12-18 13:26:08', '2020-12-18 23:54:19'),
(21, '8335676483', '3', '2', '19/12/2020 02:54', 'Nothing', 'CASH', 2.00, 0.00, 2.00, 0.00, '2020-12-18 23:54:50', NULL),
(22, '8366304147', '1', '2', '19/12/2020 11:24', 'Nothing', 'CREDIT', 4.50, 0.00, 0.00, 4.50, '2020-12-19 08:25:20', NULL),
(23, '8366722071', '2', '1', '19/12/2020 11:32', 'Nothing', 'CREDIT', 10.70, 8.00, 2.00, 0.70, '2020-11-19 08:32:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_detail`
--

CREATE TABLE `tbl_order_detail` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_price` double(8,2) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_order_detail`
--

INSERT INTO `tbl_order_detail` (`id`, `order_id`, `product_id`, `product_price`, `product_quantity`, `created_at`, `updated_at`) VALUES
(25, '8297946019', '1', 1.95, 1, '2020-12-18 13:26:08', NULL),
(26, '8297946019', '3', 2.00, 1, '2020-12-18 13:26:08', NULL),
(27, '8297946019', '7', 1.75, 1, '2020-12-18 13:26:08', NULL),
(28, '8297946019', '6', 2.25, 1, '2020-12-18 13:26:08', NULL),
(29, '8335676483', '2', 2.00, 1, '2020-12-18 23:54:50', NULL),
(30, '8366304147', '5', 2.50, 1, '2020-12-19 08:25:20', NULL),
(31, '8366304147', '2', 2.00, 1, '2020-12-19 08:25:20', NULL),
(32, '8366722071', '3', 2.00, 1, '2020-12-19 08:32:34', NULL),
(33, '8366722071', '9', 1.00, 1, '2020-12-19 08:32:34', NULL),
(34, '8366722071', '1', 1.95, 1, '2020-12-19 08:32:34', NULL),
(35, '8366722071', '7', 1.75, 1, '2020-12-19 08:32:34', NULL),
(36, '8366722071', '2', 2.00, 1, '2020-12-19 08:32:34', NULL),
(37, '8366722071', '4', 2.00, 1, '2020-12-19 08:32:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_partner`
--

CREATE TABLE `tbl_partner` (
  `id` int(10) UNSIGNED NOT NULL,
  `partner_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partner_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `partner_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partner_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_partner`
--

INSERT INTO `tbl_partner` (`id`, `partner_name`, `partner_description`, `partner_image`, `partner_status`, `created_at`, `updated_at`) VALUES
(1, '54 Store', '54 Store', 'Homemade_Pita_Bread_Sweet_Simple_Vegan-copy.jpg', 1, '2020-12-18 08:13:55', '2020-12-19 11:29:43');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_unit_price` double(8,2) NOT NULL,
  `product_sale_price` double(8,2) NOT NULL,
  `product_size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_status` int(11) NOT NULL,
  `product_stock` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`id`, `product_name`, `brand_id`, `category_id`, `product_description`, `product_unit_price`, `product_sale_price`, `product_size`, `product_image`, `product_status`, `product_stock`, `created_at`, `updated_at`) VALUES
(1, 'Al Shams Pita Bread', '2', '1', 'Pita or pitta, is a family of yeast-leavened round flatbreads baked from wheat flour, common in the Mediterranean, Middle East, and neighboring areas\n', 1.95, 0.00, '10 pcs', 'Pita_Bread-8_asbled.jpg', 1, 9, '2020-12-12 12:27:54', '2020-12-19 08:32:34'),
(2, 'Garlic Filled Pita Bread', '2', '1', 'Pita or pitta, is a family of yeast-leavened round flatbreads baked from wheat flour, common in the Mediterranean, Middle East, and neighboring areas', 2.00, 1.80, 'XL', 'Pita_Bread-6_whabjs.jpg', 1, 10, '2020-12-12 12:29:27', '2020-12-19 11:49:37'),
(3, 'Giannis Big Pita Bread', '2', '1', 'Pita or pitta, is a family of yeast-leavened round flatbreads baked from wheat flour, common in the Mediterranean, Middle East, and neighboring areas', 2.00, 1.60, 'XL', 'Pita_Bread-2_daz412.jpg', 1, 11, '2020-12-12 12:30:24', '2020-12-19 08:32:34'),
(4, 'Alamir Bakery Pita Bread', '2', '1', 'Pita or pitta, is a family of yeast-leavened round flatbreads baked from wheat flour, common in the Mediterranean, Middle East, and neighboring areas', 2.00, 0.00, 'XL', 'Pita_Bread_ovbpdz.jpg', 1, 9, '2020-12-12 12:31:26', '2020-12-19 08:32:34'),
(5, 'Global Mediterranean Pita Bread', '2', '1', 'Pita or pitta, is a family of yeast-leavened round flatbreads baked from wheat flour, common in the Mediterranean, Middle East, and neighboring areas', 2.50, 0.00, 'L', 'Pita_Bread-4_csc7se.jpg', 1, 10, '2020-12-12 12:32:20', '2020-12-19 08:25:20'),
(6, 'JFW Wheat Pita Bread', '2', '1', 'Pita or pitta, is a family of yeast-leavened round flatbreads baked from wheat flour, common in the Mediterranean, Middle East, and neighboring areas', 2.25, 0.00, 'XL', 'Pita_Bread-3_uzisgc.jpg', 1, 9, '2020-12-12 12:35:38', '2020-12-18 13:26:08'),
(7, 'PPW Wheat Greek Flat Bread', '2', '1', 'Pita or pitta, is a family of yeast-leavened round flatbreads baked from wheat flour, common in the Mediterranean, Middle East, and neighboring areas', 1.75, 0.00, 'L', 'Pita_Bread-5_g37f7t.jpg', 1, 8, '2020-12-12 12:41:24', '2020-12-19 08:32:34'),
(9, 'Thomas Cinnamon Raisin English Muffins', '2', '2', 'Griddle and a cupcake-like quickbread that is chemically leavened and then baked in a mold.', 1.00, 0.75, '6 ct', 'Muffin-5_jbx3ok.jpg', 1, 9, '2020-12-12 12:48:08', '2020-12-19 08:32:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_category`
--

CREATE TABLE `tbl_product_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_status` int(11) NOT NULL,
  `category_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_product_category`
--

INSERT INTO `tbl_product_category` (`id`, `category_name`, `category_description`, `category_status`, `category_image`, `created_at`, `updated_at`) VALUES
(1, 'Pita Bread', 'Pita Bread', 1, 'Homemade_Pita_Bread_Sweet_Simple_Vegan-copy.jpg', '2020-12-12 12:22:04', '2020-12-12 20:42:13'),
(2, 'Muffin', 'Muffin', 1, 'chocolate-chip-muffins-featured.jpg', '2020-12-12 12:47:01', '2020-12-16 18:38:33');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_used_material`
--

CREATE TABLE `tbl_used_material` (
  `id` int(10) UNSIGNED NOT NULL,
  `inv_used_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dealer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inv_used_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inv_used_note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `materials_updated` int(11) NOT NULL,
  `quantity_updated` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_used_material`
--

INSERT INTO `tbl_used_material` (`id`, `inv_used_id`, `dealer_id`, `inv_used_time`, `inv_used_note`, `materials_updated`, `quantity_updated`, `created_at`, `updated_at`) VALUES
(4, '8336873771', '2', '18/12/2020 03:14', 'Nothing', 1, 1, '2020-12-19 00:14:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_used_material_detail`
--

CREATE TABLE `tbl_used_material_detail` (
  `id` int(10) UNSIGNED NOT NULL,
  `inv_used_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `material_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `material_stock` int(11) NOT NULL,
  `used_quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_used_material_detail`
--

INSERT INTO `tbl_used_material_detail` (`id`, `inv_used_id`, `material_id`, `material_stock`, `used_quantity`, `created_at`, `updated_at`) VALUES
(2, '8336873771', '6', 4, 1, '2020-12-19 00:14:40', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_brand`
--
ALTER TABLE `tbl_brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_dealer`
--
ALTER TABLE `tbl_dealer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_inventory_material`
--
ALTER TABLE `tbl_inventory_material`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_inventory_material_detail`
--
ALTER TABLE `tbl_inventory_material_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_inventory_production`
--
ALTER TABLE `tbl_inventory_production`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_inventory_production_detail`
--
ALTER TABLE `tbl_inventory_production_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_material`
--
ALTER TABLE `tbl_material`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order_detail`
--
ALTER TABLE `tbl_order_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_partner`
--
ALTER TABLE `tbl_partner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_product_category`
--
ALTER TABLE `tbl_product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_used_material`
--
ALTER TABLE `tbl_used_material`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_used_material_detail`
--
ALTER TABLE `tbl_used_material_detail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_brand`
--
ALTER TABLE `tbl_brand`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_dealer`
--
ALTER TABLE `tbl_dealer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_inventory_material`
--
ALTER TABLE `tbl_inventory_material`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_inventory_material_detail`
--
ALTER TABLE `tbl_inventory_material_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_inventory_production`
--
ALTER TABLE `tbl_inventory_production`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_inventory_production_detail`
--
ALTER TABLE `tbl_inventory_production_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tbl_material`
--
ALTER TABLE `tbl_material`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_order_detail`
--
ALTER TABLE `tbl_order_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_partner`
--
ALTER TABLE `tbl_partner`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tbl_product_category`
--
ALTER TABLE `tbl_product_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_used_material`
--
ALTER TABLE `tbl_used_material`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_used_material_detail`
--
ALTER TABLE `tbl_used_material_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
