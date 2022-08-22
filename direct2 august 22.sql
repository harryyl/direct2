-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Aug 22, 2022 at 10:34 AM
-- Server version: 5.7.34
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `direct2`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemname` varchar(600) DEFAULT NULL,
  `itemprice` float NOT NULL DEFAULT '50',
  `itemid` int(11) UNSIGNED NOT NULL,
  `itemsize` int(11) NOT NULL,
  `itemshade` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemname`, `itemprice`, `itemid`, `itemsize`, `itemshade`) VALUES
('dramatically different moisturizing gel', 33, 1, 125, NULL),
('dramatically different moisturizing lotion+', 33, 2, 125, NULL),
('smart clinical repair wrinkle correct serum', 57, 3, 30, NULL),
('smart clinical repair wrinkle correct serum', 75, 4, 50, NULL),
('smart clinical repair wrinkle correct serum', 120, 5, 100, NULL),
('even better makeup spf 15', 31, 6, 30, 'cn 20 fair'),
('even better makeup spf 15', 31, 7, 30, 'cn 08 linen'),
('even better makeup spf 15', 31, 8, 30, 'wn 04 bone'),
('even better makeup spf 15', 31, 9, 30, 'cn 40 cream chamois'),
('superdefense city block spf 50', 23, 10, 30, NULL),
('clarifying lotion 2', 21, 11, 200, NULL),
('clarifying lotion 2', 33, 12, 400, NULL),
('clarifying lotion 3', 21, 13, 200, NULL),
('clarifying lotion 3', 33, 14, 400, NULL),
('clarifying lotion 1', 21, 15, 200, NULL),
('clarifying lotion 1', 33, 16, 400, NULL),
('clarifying lotion 1.0', 21, 17, 200, NULL),
('clarifying lotion 1.0', 33, 18, 400, NULL),
('clarifying lotion 4', 21, 19, 200, NULL),
('clarifying lotion 4', 33, 20, 400, NULL),
('dramatically different moisturizing gel', 20, 21, 50, NULL),
('dramatically different moisturizing lotion+', 20, 22, 50, NULL),
('superprimer', 29, 23, 30, NULL),
('even better clinical dark spot serum interrupter', 49, 24, 30, NULL),
('even better clinical dark spot serum interrupter', 65, 25, 50, NULL),
('even better clinical dark spot serum interrupter', 106, 26, 100, NULL),
('liquid facial soap - extra mild ', 19.5, 27, 200, NULL),
('liquid facial soap - dry combination', 19.5, 28, 200, NULL),
('liquid facial soap - oily ', 19.5, 29, 200, NULL),
('take the day off cleansing balm', 29, 30, 125, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `useritems`
--

CREATE TABLE `useritems` (
  `uiId` int(60) UNSIGNED NOT NULL,
  `uiUser` int(11) UNSIGNED NOT NULL,
  `uiItem` int(11) UNSIGNED NOT NULL,
  `uiCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `useritems`
--

INSERT INTO `useritems` (`uiId`, `uiUser`, `uiItem`, `uiCreated`) VALUES
(2, 34, 16, '2022-08-15 11:39:38'),
(3, 34, 11, '2022-08-15 11:39:38'),
(4, 33, 2, '2022-08-15 11:39:38'),
(5, 34, 16, '2022-08-15 12:09:23'),
(6, 33, 1, '2022-08-15 14:25:04'),
(7, 33, 9, '2022-08-15 14:27:26'),
(8, 34, 1, '2022-08-15 14:27:29'),
(9, 34, 16, '2022-08-15 14:27:33'),
(10, 33, 4, '2022-08-15 14:51:04'),
(11, 33, 4, '2022-08-15 14:51:33'),
(12, 34, 10, '2022-08-15 14:52:08'),
(13, 33, 1, '2022-08-15 15:06:43'),
(14, 34, 1, '2022-08-15 15:06:45'),
(15, 34, 1, '2022-08-15 15:06:47'),
(16, 33, 1, '2022-08-15 15:08:31'),
(17, 33, 1, '2022-08-15 15:08:31'),
(18, 33, 1, '2022-08-15 15:08:33'),
(19, 33, 1, '2022-08-15 15:08:33'),
(20, 33, 1, '2022-08-15 15:08:40'),
(21, 37, 11, '2022-08-15 15:16:42'),
(22, 37, 1, '2022-08-15 15:49:56'),
(23, 33, 8, '2022-08-15 15:50:34'),
(24, 37, 10, '2022-08-17 09:28:00'),
(25, 37, 8, '2022-08-17 09:28:13'),
(26, 34, 1, '2022-08-17 11:06:31'),
(27, 34, 6, '2022-08-17 11:08:58'),
(28, 34, 6, '2022-08-17 11:09:05'),
(29, 37, 23, '2022-08-17 11:11:33'),
(30, 37, 26, '2022-08-17 11:15:42'),
(31, 37, 26, '2022-08-17 11:16:40'),
(32, 33, 27, '2022-08-17 11:19:10'),
(33, 38, 30, '2022-08-17 11:25:34'),
(34, 38, 3, '2022-08-17 13:31:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `name` text,
  `gender` varchar(6) DEFAULT NULL,
  `itemspurchased` int(11) DEFAULT '0',
  `userID` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`name`, `gender`, `itemspurchased`, `userID`) VALUES
('jacob', 'male', 13, 33),
('becca', 'female', 11, 34),
('kylie', 'female', 7, 37),
('miley', 'female', 2, 38);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemid`);

--
-- Indexes for table `useritems`
--
ALTER TABLE `useritems`
  ADD PRIMARY KEY (`uiId`),
  ADD KEY `uiUser` (`uiUser`),
  ADD KEY `useritems_ibfk_2` (`uiItem`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `useritems`
--
ALTER TABLE `useritems`
  MODIFY `uiId` int(60) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `useritems`
--
ALTER TABLE `useritems`
  ADD CONSTRAINT `useritems_ibfk_1` FOREIGN KEY (`uiUser`) REFERENCES `users` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `useritems_ibfk_2` FOREIGN KEY (`uiItem`) REFERENCES `items` (`itemid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
