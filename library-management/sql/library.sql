-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.5.4-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for library
CREATE DATABASE IF NOT EXISTS `library` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `library`;

-- Dumping structure for table library.book
CREATE TABLE IF NOT EXISTS `book` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `language` varchar(50) NOT NULL,
  `publisher` varchar(50) DEFAULT NULL,
  `price` int(11) NOT NULL COMMENT 'Giá mượn',
  `amount` int(11) NOT NULL COMMENT 'Số lượng còn lại',
  `status` tinyint(4) NOT NULL COMMENT 'Trạng thái sách. 0 - đã xóa, 1 - đang hoạt động.',
  `insert_date` datetime NOT NULL,
  `insert_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='Lưu thông tin sách';

-- Dumping data for table library.book: ~7 rows (approximately)
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` (`book_id`, `title`, `category`, `author`, `language`, `publisher`, `price`, `amount`, `status`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
	(1, 'book1', 'cat1', 'au1', 'lan2', 'pub1', 100000, 1000, 1, '2020-11-29 10:53:52', 1, '2020-11-29 10:53:55', 1),
	(2, 'book2', 'cat1', 'au2', 'lan1', 'pub1', 200000, 1000, 1, '2020-11-29 10:53:52', 1, '2020-11-29 10:53:55', 1),
	(3, 'book3', 'cat2', 'au3', 'lan1', 'pub3', 100000, 1000, 1, '2020-11-29 10:53:52', 1, '2020-11-29 10:53:55', 1),
	(4, 'book4', 'cat3', 'au1', 'lan2', 'pub3', 300000, 1000, 1, '2020-11-29 10:53:52', 1, '2020-11-29 10:53:55', 1),
	(5, 'book5', 'cat3', 'au4', 'lan1', 'pub2', 400000, 1000, 1, '2020-11-29 10:53:52', 1, '2020-11-29 10:53:55', 1),
	(6, 'book6', 'cat4', 'au1', 'lan3', 'pub4', 500000, 1000, 1, '2020-11-29 10:53:52', 1, '2020-11-29 10:53:55', 1),
	(7, 'book7', 'cat4', 'au1', 'lan1', 'pub1', 200000, 1000, 1, '2020-11-29 10:53:52', 1, '2020-11-29 10:53:55', 1);
/*!40000 ALTER TABLE `book` ENABLE KEYS */;

-- Dumping structure for table library.borrow_book
CREATE TABLE IF NOT EXISTS `borrow_book` (
  `borrow_book_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `quantity` int(11) NOT NULL COMMENT 'Số sách mượn',
  `price` int(11) NOT NULL COMMENT 'Tổng giá mượn',
  `status` tinyint(4) NOT NULL COMMENT 'Trạng thái giao dịch. 0 - đã hủy,  1 - chờ giao dịch, 2 - đã cho mượn, 3 - đã trả, 4 - đã mất/hỏng',
  `insert_date` datetime NOT NULL,
  `insert_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  PRIMARY KEY (`borrow_book_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Lưu giao dịch mượn sách';

-- Dumping data for table library.borrow_book: ~2 rows (approximately)
/*!40000 ALTER TABLE `borrow_book` DISABLE KEYS */;
INSERT INTO `borrow_book` (`borrow_book_id`, `book_id`, `user_id`, `time`, `quantity`, `price`, `status`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
	(1, 1, 1, '2020-11-29 10:57:44', 5, 500000, 1, '2020-11-29 10:57:54', 1, '2020-11-29 10:57:55', 1),
	(2, 1, 1, '2020-10-29 10:57:44', 10, 1000000, 1, '2020-11-29 10:57:54', 1, '2020-11-29 10:57:55', 1);
/*!40000 ALTER TABLE `borrow_book` ENABLE KEYS */;

-- Dumping structure for table library.user
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` char(64) NOT NULL,
  `name` varchar(50) NOT NULL,
  `ic_number` varchar(12) NOT NULL COMMENT 'Số CMND/căn cước',
  `phone` varchar(12) NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` varchar(100) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT 'Loại tài khoản. 0 - admin, 1 - nhân viên, 2 - thành viên',
  `status` tinyint(4) NOT NULL COMMENT 'Trạng thái tài khoản. 0 - đã xóa, 1 - đang hoạt động',
  `insert_date` datetime NOT NULL,
  `insert_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `ic_number` (`ic_number`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='Lưu thông tin tài khoản';

-- Dumping data for table library.user: ~5 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`user_id`, `email`, `password`, `name`, `ic_number`, `phone`, `date_of_birth`, `address`, `type`, `status`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
	(1, 'admin@gmail.com', 'test', 'admin', '123', '0333333333', '1990-11-29', 'HN', 1, 1, '2020-11-29 10:59:18', 1, '2020-11-29 10:59:20', 1),
	(2, 'employee@gmail.com', 'test', 'employee', '124', '0333333331', '1990-11-29', 'HD', 2, 1, '2020-11-29 10:59:18', 1, '2020-11-29 10:59:20', 1),
	(3, 'cus1@gmail.com', 'test', 'admin', '125', '0333333332', '1990-11-29', 'HN', 3, 1, '2020-11-29 10:59:18', 1, '2020-11-29 10:59:20', 1),
	(4, 'cus2@gmail.com', 'test', 'admin', '126', '0333333334', '1990-11-29', 'HD', 3, 1, '2020-11-29 10:59:18', 1, '2020-11-29 10:59:20', 1),
	(5, 'cus3@gmail.com', 'test', 'admin', '127', '0333333335', '1990-11-29', 'HP', 3, 1, '2020-11-29 10:59:18', 1, '2020-11-29 10:59:20', 1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
