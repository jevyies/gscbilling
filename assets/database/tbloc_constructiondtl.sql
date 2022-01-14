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
-- Table structure for table `tbloc_constructiondtl`
--

CREATE TABLE `tbloc_constructiondtl` (
  `TOSDTL` bigint(20) NOT NULL,
  `hdr_id` bigint(20) NOT NULL,
  `activity_id` bigint(20) NOT NULL,
  `Activity` varchar(200) NOT NULL,
  `Location` varchar(500) NOT NULL,
  `MHRS` double NOT NULL,
  `HC` int(11) NOT NULL,
  `GL` varchar(50) NOT NULL,
  `CC` varchar(50) NOT NULL,
  `Chapa` varchar(50) NOT NULL,
  `Name` varchar(500) NOT NULL,
  `rd_st` double NOT NULL,
  `rd_ot` double NOT NULL,
  `rd_nd` double NOT NULL,
  `rd_ndot` double NOT NULL,
  `shol_st` double NOT NULL,
  `shol_ot` double NOT NULL,
  `shol_nd` double NOT NULL,
  `shol_ndot` double NOT NULL,
  `rhol_st` double NOT NULL,
  `rhol_ot` double NOT NULL,
  `rhol_nd` double NOT NULL,
  `rhol_ndot` double NOT NULL,
  `shrd_st` double NOT NULL,
  `shrd_ot` double NOT NULL,
  `shrd_nd` double NOT NULL,
  `shrd_ndot` double NOT NULL,
  `rhrd_st` double NOT NULL,
  `rhrd_ot` double NOT NULL,
  `rhrd_nd` double NOT NULL,
  `rhrd_ndot` double NOT NULL,
  `rhol_st2x` double NOT NULL,
  `rhol_ot2x` double NOT NULL,
  `rhol_nd2x` double NOT NULL,
  `rhol_ndot2x` double NOT NULL,
  `rholrd_st2x` double NOT NULL,
  `rholrd_ot2x` double NOT NULL,
  `rholrd_nd2x` double NOT NULL,
  `rholrd_ndot2x` double NOT NULL,
  `total_st` double NOT NULL,
  `total_ot` double NOT NULL,
  `total_nd` double NOT NULL,
  `total_ndot` double NOT NULL,
  `extra` double NOT NULL,
  `silpat` double NOT NULL,
  `adjustment` double NOT NULL,
  `incentive` double NOT NULL,
  `addpay` double NOT NULL,
  `volumepay` double NOT NULL,
  `allowance` double NOT NULL,
  `cola` double NOT NULL,
  `grosspay` double NOT NULL,
  `sss_ec` double NOT NULL,
  `sss_er` double NOT NULL,
  `phic_er` double NOT NULL,
  `hdmf_er` double NOT NULL,
  `total` double NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbloc_constructiondtl`
--
ALTER TABLE `tbloc_constructiondtl`
  ADD PRIMARY KEY (`TOSDTL`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbloc_constructiondtl`
--
ALTER TABLE `tbloc_constructiondtl`
  MODIFY `TOSDTL` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
