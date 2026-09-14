-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2025 at 05:11 PM
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
-- Database: `supermarket-app1`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `CalculateTotalStock` ()   BEGIN
    SELECT 
        SUM(
            p.initial_stock
            + IFNULL(r.total_restock,0)
            + IFNULL(sa.total_adjustment,0)
        ) AS total_stock
    FROM products p
    LEFT JOIN (
        SELECT product_id, SUM(quantity) total_restock
        FROM restocks GROUP BY product_id
    ) r ON p.id = r.product_id
    LEFT JOIN (
        SELECT product_id, SUM(quantity) total_adjustment
        FROM stock_adjustments GROUP BY product_id
    ) sa ON p.id = sa.product_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ManageBrand` (IN `p_action` VARCHAR(10), IN `p_id` INT, IN `p_name` VARCHAR(100))   BEGIN
    IF p_action = 'CREATE' THEN
        INSERT INTO brands(name) VALUES (p_name);

    ELSEIF p_action = 'UPDATE' THEN
        UPDATE brands SET name = p_name WHERE id = p_id;

    ELSEIF p_action = 'DELETE' THEN
        DELETE FROM brands WHERE id = p_id;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ManageCategory` (IN `p_action` VARCHAR(10), IN `p_id` INT, IN `p_name` VARCHAR(100))   BEGIN
    IF p_action = 'CREATE' THEN
        INSERT INTO categories(name) VALUES (p_name);

    ELSEIF p_action = 'UPDATE' THEN
        UPDATE categories SET name = p_name WHERE id = p_id;

    ELSEIF p_action = 'DELETE' THEN
        DELETE FROM categories WHERE id = p_id;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ManageProduct` (IN `p_action` VARCHAR(10), IN `p_id` INT, IN `p_name` VARCHAR(100), IN `p_category_id` INT, IN `p_brand_id` INT, IN `p_price` DECIMAL(10,2), IN `p_initial_stock` INT)   BEGIN
    IF p_action = 'CREATE' THEN
        INSERT INTO products
        (name, category_id, brand_id, price, initial_stock)
        VALUES
        (p_name, p_category_id, p_brand_id, p_price, p_initial_stock);

    ELSEIF p_action = 'UPDATE' THEN
        UPDATE products
        SET
            name = p_name,
            category_id = p_category_id,
            brand_id = p_brand_id,
            price = p_price
        WHERE id = p_id;

    ELSEIF p_action = 'DELETE' THEN
        DELETE FROM products WHERE id = p_id;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ManageRestock` (IN `p_action` VARCHAR(10), IN `p_id` INT, IN `p_product_id` INT, IN `p_quantity` INT)   BEGIN
    IF p_action = 'CREATE' THEN
        INSERT INTO restocks(product_id, quantity)
        VALUES (p_product_id, p_quantity);

    ELSEIF p_action = 'DELETE' THEN
        DELETE FROM restocks WHERE id = p_id;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ManageRole` (IN `p_action` VARCHAR(10), IN `p_id` INT, IN `p_name` VARCHAR(50))   BEGIN
    IF p_action = 'CREATE' THEN
        INSERT INTO roles(name) VALUES (p_name);

    ELSEIF p_action = 'UPDATE' THEN
        UPDATE roles SET name = p_name WHERE id = p_id;

    ELSEIF p_action = 'DELETE' THEN
        DELETE FROM roles WHERE id = p_id;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ManageStockAdjustment` (IN `p_action` VARCHAR(10), IN `p_id` INT, IN `p_product_id` INT, IN `p_quantity` INT)   BEGIN
    IF p_action = 'CREATE' THEN
        INSERT INTO stock_adjustments(product_id, quantity)
        VALUES (p_product_id, p_quantity);

    ELSEIF p_action = 'DELETE' THEN
        DELETE FROM stock_adjustments WHERE id = p_id;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ManageSupplier` (IN `p_action` VARCHAR(10), IN `p_id` INT, IN `p_name` VARCHAR(100), IN `p_phone` VARCHAR(20))   BEGIN
    IF p_action = 'CREATE' THEN
        INSERT INTO suppliers(name, phone)
        VALUES (p_name, p_phone);

    ELSEIF p_action = 'UPDATE' THEN
        UPDATE suppliers
        SET name = p_name,
            phone = p_phone
        WHERE id = p_id;

    ELSEIF p_action = 'DELETE' THEN
        DELETE FROM suppliers WHERE id = p_id;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ManageUser` (IN `p_action` VARCHAR(10), IN `p_id` INT, IN `p_username` VARCHAR(50), IN `p_password` VARCHAR(255), IN `p_role_id` INT)   BEGIN
    IF p_action = 'CREATE' THEN
        INSERT INTO users(username, password, role_id)
        VALUES (p_username, p_password, p_role_id);

    ELSEIF p_action = 'UPDATE' THEN
        UPDATE users
        SET username = p_username,
            role_id = p_role_id
        WHERE id = p_id;

    ELSEIF p_action = 'DELETE' THEN
        DELETE FROM users WHERE id = p_id;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `brand_id` int(10) UNSIGNED NOT NULL,
  `brand_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brand_id`, `brand_name`) VALUES
(1, 'Indofood'),
(2, 'Nestle'),
(3, 'Unilever'),
(4, 'Coca-Colaa'),
(5, 'PepsiCo'),
(6, 'Danone'),
(7, 'Kraft Heinz'),
(8, 'Procter & Gamble'),
(9, 'Colgate-Palmolive'),
(10, 'Johnson & Johnson');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Makanan'),
(2, 'Minuman'),
(3, 'Peralatan Rumah Tangga'),
(4, 'Kebutuhan Harian'),
(6, 'Kecantikan Wanita'),
(7, 'Elektronik'),
(8, 'Pakaian'),
(9, 'Alat Tulis & Kantor'),
(10, 'Olahraga'),
(11, 'Mainan Anak'),
(12, 'Buku'),
(13, 'Perhiasan & Aksesoris'),
(14, 'Perawatan Pria'),
(15, 'Produk Kebersihan'),
(16, 'Bahan Dapur');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `brand_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `status_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `brand_id`, `category_id`, `supplier_id`, `status_id`) VALUES
(1, 'Indomie Goreng ', 1, 1, 1, 3),
(5, 'Indomie Rebus Kuah', 1, 2, 1, 3),
(6, 'Indomie Rendang', 1, 1, 1, 3),
(17, 'Nestle Milo', 2, 2, 2, 3),
(18, 'Nestle Dancow', 2, 7, 2, 3),
(19, 'Lifebuoy Sabun Mandi', 3, 6, 3, 3),
(20, 'Sunsilk Shampoo', 3, 6, 3, 3),
(21, 'Coca-Cola Original', 4, 2, 4, 3),
(22, 'Sprite', 4, 2, 4, 3),
(23, 'Samsung Kulkas 2 Pintu', 5, 3, 5, 3),
(24, 'LG Mesin Cuci', 6, 3, 6, 3),
(25, 'Multo Pewangi Pakaian', 10, 6, 10, 3);

-- --------------------------------------------------------

--
-- Table structure for table `qty_unit`
--

CREATE TABLE `qty_unit` (
  `unit_id` int(10) UNSIGNED NOT NULL,
  `unit_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `qty_unit`
--

INSERT INTO `qty_unit` (`unit_id`, `unit_name`) VALUES
(1, 'pcs'),
(2, 'pack'),
(3, 'botol'),
(4, 'liter'),
(5, 'kg'),
(6, 'dus'),
(7, 'gram'),
(8, 'sachet'),
(9, 'tablet'),
(10, 'kaleng');

-- --------------------------------------------------------

--
-- Table structure for table `restock_history`
--

CREATE TABLE `restock_history` (
  `restock_history_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `quantity_change` int(11) NOT NULL,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `log_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restock_history`
--

INSERT INTO `restock_history` (`restock_history_id`, `product_id`, `supplier_id`, `quantity_change`, `unit_id`, `log_date`) VALUES
(1, 1, 1, 8, 5, '2025-12-11 19:51:15'),
(2, 1, 1, 10, 5, '2025-12-11 19:51:47'),
(3, 1, 1, 12, 5, '2025-12-11 20:40:02'),
(4, 1, 1, 60, 5, '2025-12-11 20:53:11'),
(5, 1, 1, 70, 5, '2025-12-12 06:02:16'),
(6, 1, 1, 90, 1, '2025-12-12 06:18:51'),
(7, 5, 1, 80, 1, '2025-12-12 06:24:24'),
(8, 5, 1, 90, 1, '2025-12-12 06:36:59'),
(9, 1, 1, 50, 1, '2025-12-13 18:53:34'),
(10, 1, 1, 20, 1, '2025-12-13 18:53:41'),
(13, 1, 1, 200, 1, '2025-12-19 17:29:39'),
(14, 1, 1, 10, 1, '2025-12-19 17:29:45'),
(15, 1, 1, 200, 1, '2025-12-19 17:29:51'),
(16, 6, 1, 100, 1, '2025-12-19 17:30:10'),
(17, 6, 1, 10, 1, '2025-12-19 17:30:16');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `role_name` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `created_at`) VALUES
(1, 'Admin', '2025-12-10 19:44:58'),
(2, 'Staff', '2025-12-10 19:44:58');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_id` int(10) UNSIGNED NOT NULL,
  `status_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `status_name`) VALUES
(1, 'Available'),
(2, 'Need Restock'),
(3, 'Out of Stock'),
(4, 'OTW');

-- --------------------------------------------------------

--
-- Table structure for table `stock_adjustment`
--

CREATE TABLE `stock_adjustment` (
  `adjustment_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `quantity_removed` int(11) NOT NULL,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `log_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_adjustment`
--

INSERT INTO `stock_adjustment` (`adjustment_id`, `product_id`, `supplier_id`, `quantity_removed`, `unit_id`, `log_date`) VALUES
(1, 1, 1, 10, 1, '2025-12-11 20:38:14'),
(2, 1, 1, 48, 1, '2025-12-11 20:38:26'),
(3, 1, 1, 5, 1, '2025-12-11 20:38:31'),
(4, 1, 1, 7, 1, '2025-12-11 20:40:49'),
(5, 1, 1, 60, 1, '2025-12-12 05:43:24'),
(6, 1, 1, 160, 1, '2025-12-12 06:18:57'),
(7, 1, 1, 70, 1, '2025-12-13 18:53:50'),
(8, 5, 1, 20, 1, '2025-12-19 17:29:25');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `supplier_name` varchar(50) NOT NULL,
  `supplier_address` varchar(100) NOT NULL,
  `supplier_phoneNum` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `supplier_name`, `supplier_address`, `supplier_phoneNum`) VALUES
(1, 'PT Indofood Sukses Makmur', 'Jakarta, Indonesia', '081234567890'),
(2, 'Nestle Indonesia', 'Bandung, Indonesia', '082345678901'),
(3, 'Unilever Indonesia', 'Surabaya, Indonesia', '083456789012'),
(4, 'Coca-Cola Indonesia', 'Bekasi, Indonesia', '084567890123'),
(5, 'Samsung Electronics Indonesia', 'Jakarta, Indonesia', '085678901234'),
(6, 'LG Electronics Indonesia', 'Kalimantan, Indonesia', '086789012345'),
(7, 'Kraft Heinz Indonesia', 'Jakarta, Indonesia', '087123456789'),
(8, 'Procter & Gamble Indonesia', 'Bandung, Indonesia', '088234567890'),
(9, 'Colgate Palmolive Indonesia', 'Surabaya, Indonesia', '089345678901'),
(10, 'PT Multo Indonesia', 'Jawa Barat, Indonesia', '08112602436');

-- --------------------------------------------------------

--
-- Table structure for table `total_stock`
--

CREATE TABLE `total_stock` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `total_stock` int(11) NOT NULL,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `last_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `total_stock`
--

INSERT INTO `total_stock` (`product_id`, `total_stock`, `unit_id`, `last_updated_at`) VALUES
(1, 410, 1, '2025-12-19 10:29:51'),
(5, 150, 1, '2025-12-19 10:29:25'),
(6, 110, 1, '2025-12-19 10:30:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role_id`, `created_at`) VALUES
(1, 'admin', 'admin456', 1, '2025-12-10 02:13:37'),
(5, 'staff', 'staff123', 2, '2025-12-10 13:43:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `fk_product_status` (`status_id`);

--
-- Indexes for table `qty_unit`
--
ALTER TABLE `qty_unit`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `restock_history`
--
ALTER TABLE `restock_history`
  ADD PRIMARY KEY (`restock_history_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `stock_adjustment`
--
ALTER TABLE `stock_adjustment`
  ADD PRIMARY KEY (`adjustment_id`),
  ADD KEY `fk_adjustment_product` (`product_id`),
  ADD KEY `fk_adjustment_supplier` (`supplier_id`),
  ADD KEY `fk_adjustment_unit` (`unit_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `total_stock`
--
ALTER TABLE `total_stock`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `brand_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `qty_unit`
--
ALTER TABLE `qty_unit`
  MODIFY `unit_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `restock_history`
--
ALTER TABLE `restock_history`
  MODIFY `restock_history_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stock_adjustment`
--
ALTER TABLE `stock_adjustment`
  MODIFY `adjustment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`brand_id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`),
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`);

--
-- Constraints for table `restock_history`
--
ALTER TABLE `restock_history`
  ADD CONSTRAINT `restock_history_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `restock_history_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`),
  ADD CONSTRAINT `restock_history_ibfk_3` FOREIGN KEY (`unit_id`) REFERENCES `qty_unit` (`unit_id`);

--
-- Constraints for table `stock_adjustment`
--
ALTER TABLE `stock_adjustment`
  ADD CONSTRAINT `fk_adjustment_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `fk_adjustment_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`),
  ADD CONSTRAINT `fk_adjustment_unit` FOREIGN KEY (`unit_id`) REFERENCES `qty_unit` (`unit_id`);

--
-- Constraints for table `total_stock`
--
ALTER TABLE `total_stock`
  ADD CONSTRAINT `total_stock_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `total_stock_ibfk_2` FOREIGN KEY (`unit_id`) REFERENCES `qty_unit` (`unit_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
