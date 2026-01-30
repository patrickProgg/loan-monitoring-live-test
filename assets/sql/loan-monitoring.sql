-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table loan-monitoring.tbl_client
CREATE TABLE IF NOT EXISTS `tbl_client` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(50) NOT NULL,
  `address` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `contact_no_1` varchar(50) DEFAULT NULL,
  `contact_no_2` varchar(50) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `status` enum('0','1') DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table loan-monitoring.tbl_client: ~5 rows (approximately)
INSERT INTO `tbl_client` (`id`, `full_name`, `address`, `contact_no_1`, `contact_no_2`, `date_added`, `status`, `created_at`) VALUES
	(1, 'Patrick Henry Bersaluna', 'Guinacot', '09703813485', '09555011676', '2026-01-26', '0', '2026-01-26 03:17:33'),
	(3, 'John Louie Bersaluna', 'Dao, Tagbilaran', '09979999999', '09488787888', '2026-01-27', '0', '2026-01-27 00:16:51'),
	(4, 'test testt', 'bohol ssss', '121', '22', '2026-01-29', '0', '2026-01-29 05:51:23'),
	(5, 'rowina galaura', 'masayag bohol', '09989999999', '09887878888', '2026-01-29', '0', '2026-01-29 06:01:00'),
	(6, 'emanuel', 'batuan', '09989999999', '09997422211', '2026-01-31', '0', '2026-01-29 06:02:10');

-- Dumping structure for table loan-monitoring.tbl_expenses
CREATE TABLE IF NOT EXISTS `tbl_expenses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL,
  `amt` decimal(20,2) NOT NULL,
  `date_added` date DEFAULT NULL,
  `status` enum('0','1') DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table loan-monitoring.tbl_expenses: ~14 rows (approximately)
INSERT INTO `tbl_expenses` (`id`, `type`, `amt`, `date_added`, `status`, `created_at`) VALUES
	(2, 'meals', 200.00, '2026-01-29', '0', '2026-01-29 01:18:03'),
	(3, 'slipper', 300.00, '2026-01-29', '0', '2026-01-29 01:42:11'),
	(4, 'shoes', 200.00, '2026-01-29', '0', '2026-01-29 01:43:26'),
	(5, 'water', 200.00, '2026-01-29', '1', '2026-01-29 01:43:48'),
	(6, 'test', 0.00, '2026-01-29', '1', '2026-01-29 01:45:21'),
	(7, 'test2', 0.00, '2026-01-29', '1', '2026-01-29 01:45:48'),
	(8, 'test3', 0.00, '2026-01-29', '1', '2026-01-29 01:46:06'),
	(9, 'test4', 0.00, '2026-01-29', '0', '2026-01-29 01:46:06'),
	(18, 'gas', 500.00, '2026-01-29', '0', '2026-01-29 05:50:20'),
	(19, 'test', 200.00, '2026-01-29', '0', '2026-01-29 09:57:53'),
	(20, 'resss', 1.00, '2026-01-29', '0', '2026-01-29 09:58:02'),
	(21, 'errw', 1212.00, '2026-01-29', '0', '2026-01-29 09:58:06'),
	(22, 'dfasda', 11.00, '2026-01-29', '0', '2026-01-29 09:58:12'),
	(23, 'sdfsds', 11.00, '2026-01-29', '0', '2026-01-29 09:58:15'),
	(24, 'test', 3000.00, '2026-03-18', '0', '2026-01-30 03:46:26'),
	(25, 'gas', 1000.00, '2027-03-30', '0', '2026-01-30 05:10:28'),
	(26, 'gloves', 1111.00, '2026-01-30', '0', '2026-01-30 05:29:20'),
	(27, 'sds', 40003.00, '2026-01-30', '0', '2026-01-30 05:30:31');

-- Dumping structure for table loan-monitoring.tbl_expenses_list
CREATE TABLE IF NOT EXISTS `tbl_expenses_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table loan-monitoring.tbl_expenses_list: ~0 rows (approximately)

-- Dumping structure for table loan-monitoring.tbl_loan
CREATE TABLE IF NOT EXISTS `tbl_loan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cl_id` int NOT NULL,
  `capital_amt` decimal(20,2) NOT NULL,
  `interest` int NOT NULL DEFAULT '0',
  `added_amt` decimal(20,2) NOT NULL,
  `total_amt` decimal(20,2) NOT NULL,
  `start_date` date NOT NULL,
  `due_date` date NOT NULL,
  `complete_date` date DEFAULT NULL,
  `status` enum('ongoing','completed','overdue') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'ongoing',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table loan-monitoring.tbl_loan: ~18 rows (approximately)
INSERT INTO `tbl_loan` (`id`, `cl_id`, `capital_amt`, `interest`, `added_amt`, `total_amt`, `start_date`, `due_date`, `complete_date`, `status`) VALUES
	(1, 1, 10000.00, 15, 100.00, 11600.00, '2025-12-30', '2026-02-25', '2025-12-31', 'completed'),
	(2, 1, 4000.00, 15, 100.00, 4700.00, '2026-02-04', '2026-04-03', '2026-04-03', 'overdue'),
	(6, 1, 1150.00, 15, 100.00, 1422.50, '2026-04-03', '2026-05-31', '2026-04-04', 'completed'),
	(7, 1, 2000.00, 15, 0.00, 2300.00, '2026-04-07', '2026-06-04', '2026-04-08', 'completed'),
	(8, 1, 1000.00, 15, 0.00, 1150.00, '2026-04-10', '2026-06-07', '2026-04-14', 'completed'),
	(9, 1, 100.00, 15, 10.00, 125.00, '2026-01-01', '2026-02-28', '2026-02-28', 'overdue'),
	(17, 1, 25.00, 15, 200.00, 228.75, '2026-02-28', '2026-04-27', '2026-04-27', 'overdue'),
	(18, 1, 228.75, 15, 2000.00, 2263.06, '2026-09-15', '2026-11-12', '2026-09-16', 'completed'),
	(19, 1, 20000.00, 15, 100.00, 23100.00, '2026-10-01', '2026-11-28', '2026-10-02', 'completed'),
	(20, 1, 10000.00, 15, 100.00, 11600.00, '2026-09-20', '2026-11-17', '2026-09-23', 'completed'),
	(21, 1, 5000.00, 15, 100.00, 5850.00, '2026-09-30', '2026-11-27', '2026-10-08', 'completed'),
	(22, 3, 10000.00, 15, 100.00, 11600.00, '2026-01-28', '2026-03-27', '2026-03-27', 'overdue'),
	(23, 3, 10600.00, 15, 100.00, 12290.00, '2026-03-27', '2026-05-24', NULL, 'ongoing'),
	(24, 4, 5000.00, 15, 0.00, 5750.00, '2026-01-29', '2026-03-28', NULL, 'ongoing'),
	(25, 5, 5000.00, 15, 200.00, 5950.00, '2026-01-29', '2026-03-28', NULL, 'ongoing'),
	(26, 6, 111.00, 15, 0.00, 127.65, '2026-01-30', '2026-03-29', '2026-03-29', 'overdue'),
	(27, 6, 127.65, 15, 200.00, 346.80, '2026-03-29', '2026-05-26', NULL, 'ongoing'),
	(28, 1, 20000.00, 15, 100.00, 23100.00, '2026-10-09', '2026-12-06', '2026-10-11', 'completed'),
	(29, 1, 20000.00, 15, 100.00, 23100.00, '2027-01-30', '2027-03-29', NULL, 'ongoing');

-- Dumping structure for table loan-monitoring.tbl_payment
CREATE TABLE IF NOT EXISTS `tbl_payment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `loan_id` int NOT NULL,
  `payment_for` date NOT NULL,
  `amt` decimal(20,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table loan-monitoring.tbl_payment: ~47 rows (approximately)
INSERT INTO `tbl_payment` (`id`, `loan_id`, `payment_for`, `amt`, `created_at`) VALUES
	(1, 1, '2025-12-31', 11600.00, '2026-01-27 10:15:36'),
	(2, 2, '2026-02-07', 200.00, '2026-01-27 10:20:38'),
	(3, 2, '2026-02-08', 20.00, '2026-01-27 10:21:00'),
	(4, 2, '2026-02-09', 100.00, '2026-01-27 10:22:34'),
	(5, 2, '2026-02-10', 20.00, '2026-01-27 10:23:36'),
	(6, 2, '2026-02-11', 50.00, '2026-01-28 00:44:21'),
	(7, 2, '2026-02-12', 10.00, '2026-01-28 00:53:35'),
	(8, 2, '2026-02-13', 20.00, '2026-01-28 00:56:25'),
	(9, 2, '2026-02-14', 50.00, '2026-01-28 01:09:54'),
	(10, 2, '2026-02-15', 250.00, '2026-01-28 01:10:27'),
	(11, 2, '2026-02-16', 600.00, '2026-01-28 01:12:59'),
	(12, 2, '2026-02-17', 1.00, '2026-01-28 01:14:46'),
	(13, 2, '2026-02-18', 1.00, '2026-01-28 01:17:30'),
	(14, 2, '2026-02-19', 1.00, '2026-01-28 01:19:42'),
	(15, 2, '2026-02-20', 1.00, '2026-01-28 01:26:02'),
	(16, 2, '2026-02-21', 2.00, '2026-01-28 01:26:54'),
	(17, 2, '2026-02-22', 73.00, '2026-01-28 01:27:20'),
	(18, 2, '2026-02-23', 1.00, '2026-01-28 01:29:04'),
	(20, 2, '2026-02-24', 500.00, '2026-01-28 01:46:52'),
	(21, 2, '2026-02-06', 200.00, '2026-01-28 01:47:14'),
	(22, 2, '2026-02-05', 300.00, '2026-01-28 01:49:45'),
	(23, 2, '2026-02-03', 100.00, '2026-01-28 02:27:10'),
	(24, 2, '2026-02-25', 1150.00, '2026-01-28 02:37:29'),
	(25, 6, '2026-04-04', 1422.50, '2026-01-28 03:03:00'),
	(26, 7, '2026-04-08', 2300.00, '2026-01-28 03:04:52'),
	(27, 8, '2026-04-11', 10.00, '2026-01-28 03:08:35'),
	(28, 8, '2026-04-12', 10.00, '2026-01-28 03:08:52'),
	(29, 8, '2026-04-13', 30.00, '2026-01-28 03:09:23'),
	(30, 8, '2026-04-14', 1100.00, '2026-01-28 03:10:18'),
	(32, 9, '2026-01-02', 100.00, '2026-01-28 03:39:00'),
	(33, 18, '2026-09-16', 2263.06, '2026-01-28 03:59:43'),
	(34, 19, '2026-10-02', 23100.00, '2026-01-28 05:20:42'),
	(35, 20, '2026-09-21', 333.00, '2026-01-28 08:37:06'),
	(36, 20, '2026-09-22', 500.00, '2026-01-28 09:42:14'),
	(37, 20, '2026-09-23', 10767.00, '2026-01-28 09:43:03'),
	(38, 21, '2026-10-01', 100.00, '2026-01-28 09:45:51'),
	(39, 21, '2026-10-02', 1000.00, '2026-01-28 09:45:56'),
	(40, 22, '2026-01-29', 1000.00, '2026-01-28 09:46:51'),
	(41, 21, '2026-10-03', 50.00, '2026-01-29 05:14:28'),
	(42, 21, '2026-10-04', 4550.00, '2026-01-29 05:14:41'),
	(43, 21, '2026-10-05', 10.00, '2026-01-29 05:55:30'),
	(44, 21, '2026-10-06', 20.00, '2026-01-29 05:55:32'),
	(45, 21, '2026-10-07', 70.00, '2026-01-29 05:55:35'),
	(46, 25, '2026-01-30', 100.00, '2026-01-29 06:06:33'),
	(47, 21, '2026-10-08', 50.00, '2026-01-29 07:48:47'),
	(48, 28, '2026-10-10', 100.00, '2026-01-30 01:50:31'),
	(49, 23, '2026-03-28', 1500.00, '2026-01-30 03:16:47'),
	(50, 28, '2026-10-11', 23000.00, '2026-01-30 05:11:18'),
	(51, 29, '2027-01-31', 200.00, '2026-01-30 05:11:42');

-- Dumping structure for table loan-monitoring.tbl_pull_out
CREATE TABLE IF NOT EXISTS `tbl_pull_out` (
  `id` int NOT NULL AUTO_INCREMENT,
  `process_fee` decimal(20,2) DEFAULT '0.00',
  `ticket` decimal(20,2) DEFAULT '0.00',
  `profit_share` decimal(20,2) DEFAULT '0.00',
  `pull_out` decimal(20,2) DEFAULT '0.00',
  `total_pull_out` decimal(20,2) DEFAULT '0.00',
  `date_added` date DEFAULT NULL,
  `status` enum('0','1') DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table loan-monitoring.tbl_pull_out: ~11 rows (approximately)
INSERT INTO `tbl_pull_out` (`id`, `process_fee`, `ticket`, `profit_share`, `pull_out`, `total_pull_out`, `date_added`, `status`, `created_at`) VALUES
	(4, 1000.00, 1000.00, 3500.00, 1500.00, 7000.00, '2026-01-28', '0', '2026-01-27 05:27:30'),
	(14, 1.00, 0.00, 0.00, 0.00, 1.00, '2026-01-29', '0', '2026-01-29 04:04:31'),
	(15, 500.00, 600.00, 4000.00, 2000.00, 7100.00, '2026-01-29', '0', '2026-01-29 05:11:15'),
	(16, 1212.00, 0.00, 0.00, 0.00, 1212.00, '2026-01-29', '0', '2026-01-29 05:12:21'),
	(17, 1.00, 0.00, 0.00, 0.00, 1.00, '2026-01-29', '0', '2026-01-29 09:58:33'),
	(18, 100.00, 0.00, 0.00, 0.00, 100.00, '2026-01-29', '0', '2026-01-29 09:58:39'),
	(19, 200.00, 0.00, 0.00, 0.00, 200.00, '2026-01-29', '0', '2026-01-29 09:58:47'),
	(20, 333.00, 0.00, 0.00, 0.00, 333.00, '2026-01-29', '0', '2026-01-29 09:58:52'),
	(21, 332.00, 0.00, 0.00, 0.00, 332.00, '2026-01-29', '0', '2026-01-29 09:58:57'),
	(22, 3321.00, 0.00, 0.00, 0.00, 3321.00, '2026-01-29', '0', '2026-01-29 09:59:01'),
	(23, 1500.00, 666.00, 0.00, 0.00, 2166.00, '2026-01-29', '0', '2026-01-29 10:01:26'),
	(24, 1111111.00, 500.00, 0.00, 0.00, 1111611.00, '2026-01-30', '0', '2026-01-30 05:25:40');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
