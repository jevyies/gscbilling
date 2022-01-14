-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2021 at 11:20 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gscbilling`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbloc_constructionhdr`
--

CREATE TABLE `tbloc_constructionhdr` (
  `TOCSHDR` bigint(20) NOT NULL,
  `SOANo` varchar(100) NOT NULL,
  `period` varchar(15) NOT NULL,
  `Date` date NOT NULL,
  `SOAMonthSeries` varchar(2) NOT NULL,
  `Payment_for` varchar(500) NOT NULL,
  `body` varchar(5000) NOT NULL,
  `body2` varchar(5000) NOT NULL,
  `period_date` varchar(100) NOT NULL,
  `letter_to` varchar(5000) NOT NULL,
  `admin_percentage` double NOT NULL,
  `Status` varchar(50) NOT NULL,
  `Prepared_by` varchar(200) NOT NULL,
  `Prepared_by_desig` varchar(200) NOT NULL,
  `Noted_by` varchar(200) NOT NULL,
  `Noted_by_desig` varchar(200) NOT NULL,
  `Checked_by` varchar(200) NOT NULL,
  `Checked_by_desig` varchar(200) NOT NULL,
  `Approved_by` varchar(200) NOT NULL,
  `Approved_by_desig` varchar(200) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `PaidAmount` double NOT NULL,
  `PaymentHDRID` bigint(20) NOT NULL,
  `transmittal_no` varchar(100) NOT NULL,
  `Confirmed_by` varchar(255) NOT NULL,
  `Confirmed_by_desig` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbloc_constructionhdr`
--
ALTER TABLE `tbloc_constructionhdr`
  ADD PRIMARY KEY (`TOCSHDR`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbloc_constructionhdr`
--
ALTER TABLE `tbloc_constructionhdr`
  MODIFY `TOCSHDR` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
