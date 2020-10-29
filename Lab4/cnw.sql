-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 28, 2020 lúc 05:47 PM
-- Phiên bản máy phục vụ: 10.4.11-MariaDB
-- Phiên bản PHP: 7.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `cnw`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bsn_cat`
--

CREATE TABLE `bsn_cat` (
  `bsnID` varchar(100) NOT NULL,
  `catID` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `bsn_cat`
--

INSERT INTO `bsn_cat` (`bsnID`, `catID`) VALUES
('CT TNHH Hoang Phat', 'FISH'),
('Cong ty Dai Hoc HUST', 'HEALTH'),
('Cong ty Dai Hoc HUST', 'SCHOOL'),
('Cong ty Dai Hoc HUST', 'SPORT');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `business`
--

CREATE TABLE `business` (
  `bsn_name` varchar(100) NOT NULL,
  `bsn_address` varchar(100) DEFAULT NULL,
  `bsn_city` varchar(100) DEFAULT NULL,
  `bsn_phone` varchar(20) DEFAULT NULL,
  `bsn_url` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `business`
--

INSERT INTO `business` (`bsn_name`, `bsn_address`, `bsn_city`, `bsn_phone`, `bsn_url`) VALUES
('Cong ty Dai Hoc HUST', 'Tran Dai Nghia Street, Hai ba trung district', 'Ha Noi', '0546456', 'sis.hust.edu.vn'),
('CT TNHH Hoang Phat', 'Xuân an - Nghi Xuân - Hà Tĩnh', 'Hà Tĩnh', '0982537337', 'https://www.facebook.com/sken.orilee.2319');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `catID` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`catID`, `title`, `description`) VALUES
('AUTO', 'Automotive Parts And Supplies', 'accessories for you car'),
('FISH', 'Seefood Stores and Restaurant', 'place to get your fish'),
('HEALTH', 'Health And Beauty', 'Everything for the body'),
('SCHOOL', 'Schools and colleges', 'Public and private learning'),
('SPORT', 'Community Sports And Recreation', 'Guide to park and leagues');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bsn_cat`
--
ALTER TABLE `bsn_cat`
  ADD KEY `bsnID_fk` (`bsnID`),
  ADD KEY `catID_fk` (`catID`);

--
-- Chỉ mục cho bảng `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`bsn_name`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`catID`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bsn_cat`
--
ALTER TABLE `bsn_cat`
  ADD CONSTRAINT `bsnID_fk` FOREIGN KEY (`bsnID`) REFERENCES `business` (`bsn_name`),
  ADD CONSTRAINT `catID_fk` FOREIGN KEY (`catID`) REFERENCES `category` (`catID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
