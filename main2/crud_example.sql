-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 22 أكتوبر 2025 الساعة 00:46
-- إصدار الخادم: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crud_example`
--

-- --------------------------------------------------------

--
-- بنية الجدول `tbl_attendance`
--

DROP TABLE IF EXISTS `tbl_attendance`;
CREATE TABLE IF NOT EXISTS `tbl_attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `present` tinyint(4) NOT NULL,
  `absent` tinyint(4) NOT NULL,
  `attendance_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;

--
-- إرجاع أو استيراد بيانات الجدول `tbl_attendance`
--

INSERT INTO `tbl_attendance` (`id`, `student_id`, `present`, `absent`, `attendance_date`) VALUES
(73, 12, 1, 0, '2025-10-10'),
(74, 12, 1, 0, '2025-10-22'),
(75, 12, 0, 1, '0005-03-10');

-- --------------------------------------------------------

--
-- بنية الجدول `tbl_student`
--

DROP TABLE IF EXISTS `tbl_student`;
CREATE TABLE IF NOT EXISTS `tbl_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `roll_number` int(11) NOT NULL,
  `dob` date NOT NULL,
  `class` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- إرجاع أو استيراد بيانات الجدول `tbl_student`
--

INSERT INTO `tbl_student` (`id`, `name`, `roll_number`, `dob`, `class`) VALUES
(12, 'abdulaziz alotaibi', 443229303, '2025-10-22', 'ØªÙ‚Ù†ÙŠØ§Øª Ø§Ù„Ø§Ù†ØªØ±Ù†Øª Ø§Ù„Ù…ØªÙ‚Ø¯Ù…Ø© ');

-- --------------------------------------------------------

--
-- بنية الجدول `tbl_users`
--

DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- إرجاع أو استيراد بيانات الجدول `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `username`, `email`, `password`, `role`) VALUES
(3, 'aa', 'sda@gmail.com', 'aa1234', 'user'),
(4, 'ss', 'aa@gmail.com', 'aa1234', 'admin');

--
-- قيود الجداول المحفوظة
--

--
-- القيود للجدول `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD CONSTRAINT `tbl_attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `tbl_student` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
