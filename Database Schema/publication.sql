-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2015 at 08:29 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `publication`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
`id` int(11) NOT NULL,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `pub_books`
--

CREATE TABLE IF NOT EXISTS `pub_books` (
`book_ID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `total_quantity` int(11) NOT NULL,
  `catagory` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pub_books`
--

INSERT INTO `pub_books` (`book_ID`, `name`, `price`, `total_quantity`, `catagory`) VALUES
(5, 'Bangla First Paper', 120, 70, 'Bangla'),
(6, 'English 1st Paper', 130, 50, 'English'),
(7, 'ICT 1st paper', 140, 23, 'ICT');

-- --------------------------------------------------------

--
-- Table structure for table `pub_contacts`
--

CREATE TABLE IF NOT EXISTS `pub_contacts` (
`contact_ID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `district` varchar(20) NOT NULL,
  `contact_type` varchar(20) NOT NULL COMMENT '1 = Printing Press , 2 = Binding Store , 3 = Sales Store',
  `address` text NOT NULL,
  `phone` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pub_contacts`
--

INSERT INTO `pub_contacts` (`contact_ID`, `name`, `district`, `contact_type`, `address`, `phone`) VALUES
(1, 'TNT Books', 'Borishal', 'Binding Store', '', '01523232343'),
(2, 'Friends IT', 'Dhaka', 'Buyer', '', '01712121243'),
(3, 'AB Printers', 'Dhaka', 'Printing Press', '', '01212121212'),
(4, 'AB Binders', 'Dhaka', 'Binding Store', '', '01313131313'),
(5, 'AB Book Store', 'Dhaka', 'Sales Store', '', '014141414');

-- --------------------------------------------------------

--
-- Table structure for table `pub_memos`
--

CREATE TABLE IF NOT EXISTS `pub_memos` (
`memo_ID` int(11) NOT NULL COMMENT 'Memo ID',
  `memo_serial` varchar(50) NOT NULL COMMENT 'unique id auto genetated',
  `contact_ID` int(11) NOT NULL COMMENT 'Memo Issued to',
  `issue_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Memo auto generated timestamp',
  `sub_total` int(11) NOT NULL COMMENT 'Total book Price',
  `discount` int(11) NOT NULL COMMENT 'Discount made',
  `previous_due` int(11) NOT NULL COMMENT 'Prevous Due',
  `cash` int(11) NOT NULL COMMENT 'Paid by cash',
  `bank_due` int(11) NOT NULL COMMENT 'Paid by band check',
  `due` int(11) NOT NULL COMMENT 'Due'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pub_memos`
--

INSERT INTO `pub_memos` (`memo_ID`, `memo_serial`, `contact_ID`, `issue_date`, `sub_total`, `discount`, `previous_due`, `cash`, `bank_due`, `due`) VALUES
(1, '55e0465aebb13', 5, '2015-02-09 08:00:00', 930, 1, 2, 3, 4, 5),
(2, '55e0517776b69', 2, '2015-09-09 07:00:00', 920, 7, 13, 13, 14, 17),
(4, '55e05fdfb1543', 2, '2015-04-09 07:00:00', 920, 1, 2, 2, 2, 2),
(5, '55e50b3bc7cd0', 5, '2015-01-09 08:00:00', 640, 18, 14, 16, 13, 20),
(6, '55e9c7e602c7c', 3, '2015-04-09 07:00:00', 800, 10, 15, 12, 14, 13);

-- --------------------------------------------------------

--
-- Table structure for table `pub_memos_selected_books`
--

CREATE TABLE IF NOT EXISTS `pub_memos_selected_books` (
`selection_ID` int(11) NOT NULL,
  `memo_ID` int(11) NOT NULL,
  `book_ID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_per_book` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pub_memos_selected_books`
--

INSERT INTO `pub_memos_selected_books` (`selection_ID`, `memo_ID`, `book_ID`, `quantity`, `price_per_book`, `total`) VALUES
(1, 1, 5, 1, 120, 120),
(2, 1, 6, 2, 130, 260),
(3, 1, 7, 3, 140, 420),
(4, 2, 5, 2, 120, 240),
(5, 2, 6, 2, 130, 260),
(6, 2, 7, 2, 140, 280),
(7, 3, 5, 2, 120, 240),
(8, 3, 6, 2, 130, 260),
(9, 3, 7, 2, 140, 280),
(10, 4, 5, 2, 120, 240),
(11, 4, 6, 2, 130, 260),
(12, 4, 7, 2, 140, 280),
(13, 5, 5, 2, 120, 240),
(14, 5, 6, 2, 130, 260),
(15, 5, 7, 0, 140, 0),
(16, 6, 5, 1, 120, 120),
(17, 6, 6, 2, 130, 260),
(18, 6, 7, 3, 140, 420);

-- --------------------------------------------------------

--
-- Table structure for table `pub_stock`
--

CREATE TABLE IF NOT EXISTS `pub_stock` (
`stock_id` int(10) NOT NULL,
  `book_ID` varchar(100) NOT NULL,
  `printing_press_ID` int(11) NOT NULL,
  `printing_press_Quantity` int(11) NOT NULL,
  `binding_store_ID` int(11) NOT NULL,
  `binding_store_Quantity` int(11) NOT NULL,
  `sales_store_ID` int(11) NOT NULL,
  `sales_store_Quantity` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pub_stock`
--

INSERT INTO `pub_stock` (`stock_id`, `book_ID`, `printing_press_ID`, `printing_press_Quantity`, `binding_store_ID`, `binding_store_Quantity`, `sales_store_ID`, `sales_store_Quantity`) VALUES
(2, '5', 3, 56, 4, 4, 5, 130);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `activated`, `banned`, `ban_reason`, `new_password_key`, `new_password_requested`, `new_email`, `new_email_key`, `last_ip`, `last_login`, `created`, `modified`) VALUES
(1, 'admin', '$2a$08$NmXFqDOBe/c2E.xj8gMnvOwj8TRvUswb0NZUDdan1alvYsTlgGUHa', 'mashfiqnahid@gmail.com', 1, 0, NULL, NULL, NULL, NULL, 'ee715b40d32a11e440be813a06f4be13', '::1', '2015-09-04 18:22:51', '2015-08-14 17:35:42', '2015-09-04 16:22:51');

-- --------------------------------------------------------

--
-- Table structure for table `user_autologin`
--

CREATE TABLE IF NOT EXISTS `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user_autologin`
--

INSERT INTO `user_autologin` (`key_id`, `user_id`, `user_agent`, `last_ip`, `last_login`) VALUES
('34c6d5a1beb4003137abe89d23605324', 1, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36', '::1', '2015-09-04 16:22:51'),
('960618e390b6200d11f095c8e829ebc5', 1, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0', '::1', '2015-08-26 23:38:19');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE IF NOT EXISTS `user_profiles` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
 ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pub_books`
--
ALTER TABLE `pub_books`
 ADD PRIMARY KEY (`book_ID`);

--
-- Indexes for table `pub_contacts`
--
ALTER TABLE `pub_contacts`
 ADD PRIMARY KEY (`contact_ID`);

--
-- Indexes for table `pub_memos`
--
ALTER TABLE `pub_memos`
 ADD PRIMARY KEY (`memo_ID`);

--
-- Indexes for table `pub_memos_selected_books`
--
ALTER TABLE `pub_memos_selected_books`
 ADD PRIMARY KEY (`selection_ID`);

--
-- Indexes for table `pub_stock`
--
ALTER TABLE `pub_stock`
 ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_autologin`
--
ALTER TABLE `user_autologin`
 ADD PRIMARY KEY (`key_id`,`user_id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pub_books`
--
ALTER TABLE `pub_books`
MODIFY `book_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `pub_contacts`
--
ALTER TABLE `pub_contacts`
MODIFY `contact_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `pub_memos`
--
ALTER TABLE `pub_memos`
MODIFY `memo_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Memo ID',AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pub_memos_selected_books`
--
ALTER TABLE `pub_memos_selected_books`
MODIFY `selection_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `pub_stock`
--
ALTER TABLE `pub_stock`
MODIFY `stock_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
