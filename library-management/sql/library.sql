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
  `price` int(11) NOT NULL COMMENT 'Giá sách',
  `fee` int(11) NOT NULL COMMENT 'Giá mượn',
  `amount` int(11) NOT NULL COMMENT 'Số lượng còn lại',
  `status` tinyint(4) NOT NULL COMMENT 'Trạng thái sách. 0 - đã xóa, 1 - đang hoạt động.',
  `insert_date` datetime NOT NULL,
  `insert_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='Lưu thông tin sách';

-- Dumping data for table library.book: ~12 rows (approximately)
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` (`book_id`, `title`, `category`, `author`, `language`, `publisher`, `price`, `fee`, `amount`, `status`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
	(1, 'book1', 'cut1', 'au1', 'lan2', 'pub1', 100000, 10000, 1000, 1, '2020-11-29 10:53:52', 1, '2020-12-06 21:03:13', 1),
	(2, 'book2', 'cat1', 'au2', 'lan1', 'pub1', 200000, 10000, 1000, 1, '2020-11-29 10:53:52', 1, '2020-12-03 16:35:14', 1),
	(3, 'book3', 'cat2', 'au3', 'lan1', 'pub3', 100000, 10000, 1000, 1, '2020-11-29 10:53:52', 1, '2020-12-03 16:35:16', 1),
	(4, 'book4', 'cat3', 'au1', 'lan2', 'pub3', 300000, 10000, 1000, 1, '2020-11-29 10:53:52', 1, '2020-11-29 10:53:55', 1),
	(5, 'book5', 'cat3', 'au4', 'lan1', 'pub2', 400000, 10000, 1000, 1, '2020-11-29 10:53:52', 1, '2020-11-29 10:53:55', 1),
	(6, 'book6', 'cat4', 'au1', 'lan3', 'pub4', 500000, 10000, 1000, 1, '2020-11-29 10:53:52', 1, '2020-11-29 10:53:55', 1),
	(7, 'book7', 'cat4', 'au1', 'lan1', 'pub1', 200000, 10000, 1000, 1, '2020-11-29 10:53:52', 1, '2020-12-02 11:14:13', 1),
	(8, 'blah2', 'blah', 'blah', 'en', 'nxb1', 69000, 10000, 20000, 1, '2020-12-02 12:21:04', 1, '2020-12-03 16:35:12', 1),
	(9, 'test', 'blah', 'blah', 'en', 'nxb1', 50000, 10000, 500, 1, '2020-12-02 12:26:52', 1, '2020-12-03 16:08:46', 1),
	(10, 'blah23', 'blah', 'blah', 'en', 'nxb1', 69000, 10000, 10, 0, '2020-12-06 20:43:38', 1, '2020-12-06 21:26:16', 1),
	(17, 'blah235', 'blah', 'blah', 'en', 'nxb1', 54000, 10000, 111, 1, '2020-12-07 11:22:17', 2, '2020-12-07 11:22:17', 2),
	(18, 'test3434', 'cut1', 'blah', 'vn', 'vn', 50000, 5000, 900, 0, '2020-12-07 11:38:37', 2, '2020-12-07 13:16:36', 1);
/*!40000 ALTER TABLE `book` ENABLE KEYS */;

-- Dumping structure for table library.borrow_book
CREATE TABLE IF NOT EXISTS `borrow_book` (
  `borrow_book_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time_request` datetime NOT NULL COMMENT 'Thời gian yêu cầu mượn',
  `time_borrow` datetime DEFAULT NULL COMMENT 'Thời gian mượn',
  `quantity` int(11) NOT NULL COMMENT 'Số sách mượn',
  `fee` int(11) NOT NULL COMMENT 'Tổng giá mượn',
  `status` tinyint(4) NOT NULL COMMENT 'Trạng thái giao dịch. 0 - đã hủy,  1 - chờ giao dịch, 2 - đã cho mượn, 3 - đã trả, 4 - đã mất/hỏng',
  `insert_date` datetime NOT NULL,
  `insert_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  PRIMARY KEY (`borrow_book_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Lưu giao dịch mượn sách';

-- Dumping data for table library.borrow_book: ~2 rows (approximately)
/*!40000 ALTER TABLE `borrow_book` DISABLE KEYS */;
INSERT INTO `borrow_book` (`borrow_book_id`, `book_id`, `user_id`, `time_request`, `time_borrow`, `quantity`, `fee`, `status`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
	(1, 1, 1, '2020-11-29 10:57:44', NULL, 5, 500000, 1, '2020-11-29 10:57:54', 1, '2020-11-29 10:57:55', 1),
	(2, 1, 1, '2020-10-29 10:57:44', NULL, 10, 1000000, 1, '2020-11-29 10:57:54', 1, '2020-11-29 10:57:55', 1),
	(3, 1, 2, '2020-12-06 23:42:26', '2020-12-06 23:44:03', 10, 690000, 2, '2020-12-06 23:42:26', 1, '2020-12-06 23:44:03', 1);
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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COMMENT='Lưu thông tin tài khoản';

-- Dumping data for table library.user: ~7 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`user_id`, `email`, `password`, `name`, `ic_number`, `phone`, `date_of_birth`, `address`, `type`, `status`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
	(1, 'admin@gmail.com', 'cb9a7f035d23c91b81d8f9981405d2e566267e4e10ef8ff0722d3d5a61611b52', 'admin', '123', '0333333333', '1990-11-29', 'HN', 0, 1, '2020-11-29 10:59:18', 1, '2020-11-29 10:59:20', 1),
	(2, 'employee@gmail.com', 'cb9a7f035d23c91b81d8f9981405d2e566267e4e10ef8ff0722d3d5a61611b52', 'employee', '124', '0333333331', '1990-11-29', 'HD', 1, 1, '2020-11-29 10:59:18', 1, '2020-11-29 10:59:20', 1),
	(3, 'member@gmail.com', 'cb9a7f035d23c91b81d8f9981405d2e566267e4e10ef8ff0722d3d5a61611b52', 'mem1', '125', '0333333332', '1990-11-29', 'HN', 2, 1, '2020-11-29 10:59:18', 1, '2020-12-07 10:59:23', 2),
	(4, 'cus2@gmail.com', 'cb9a7f035d23c91b81d8f9981405d2e566267e4e10ef8ff0722d3d5a61611b52', 'mem2', '126', '0333333334', '1990-11-29', 'HD', 2, 1, '2020-11-29 10:59:18', 1, '2020-11-29 10:59:20', 1),
	(5, 'cus3@gmail.com', 'cb9a7f035d23c91b81d8f9981405d2e566267e4e10ef8ff0722d3d5a61611b52', 'mem3', '127', '0333333335', '1990-11-29', 'HP', 2, 1, '2020-11-29 10:59:18', 1, '2020-11-29 10:59:20', 1),
	(6, 'c@a.b', 'cb9a7f035d23c91b81d8f9981405d2e566267e4e10ef8ff0722d3d5a61611b52', 'test', '1000234532', '0983425321', '1999-03-31', 'HD', 2, 1, '2020-12-07 11:59:08', 2, '2020-12-07 11:59:08', 2),
	(42, 'cd@a.b', 'cb9a7f035d23c91b81d8f9981405d2e566267e4e10ef8ff0722d3d5a61611b52', 'test', '1001234532', '0985425321', '1999-03-31', 'HD', 2, 1, '2020-12-07 12:38:42', 2, '2020-12-07 12:40:50', 2);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
