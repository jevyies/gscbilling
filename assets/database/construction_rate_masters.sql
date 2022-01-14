-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2021 at 03:51 PM
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
-- Table structure for table `construction_rate_masters`
--

CREATE TABLE `construction_rate_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `activityID` bigint(20) UNSIGNED NOT NULL,
  `costCenterID` bigint(20) NOT NULL,
  `glID` bigint(20) NOT NULL,
  `locationID` bigint(20) NOT NULL,
  `activity_fr_mg` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_fr_mg` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gl_fr_mg` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `costcenter__` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rd_st` double(8,3) NOT NULL,
  `rd_ot` double(8,3) NOT NULL,
  `rd_nd` double(8,3) NOT NULL,
  `rd_ndot` double(8,3) NOT NULL,
  `shol_st` double(8,3) NOT NULL,
  `shol_ot` double(8,3) NOT NULL,
  `shol_nd` double(8,3) NOT NULL,
  `shol_ndot` double(8,3) NOT NULL,
  `shrd_st` double(8,3) NOT NULL,
  `shrd_ot` double(8,3) NOT NULL,
  `shrd_nd` double(8,3) NOT NULL,
  `shrd_ndot` double(8,3) NOT NULL,
  `rhol_st` double(8,3) NOT NULL,
  `rhol_ot` double(8,3) NOT NULL,
  `rhol_nd` double(8,3) NOT NULL,
  `rhol_ndot` double(8,3) NOT NULL,
  `rhrd_st` double(8,3) NOT NULL,
  `rhrd_ot` double(8,3) NOT NULL,
  `rhrd_nd` double(8,3) NOT NULL,
  `rhrd_ndot` double(8,3) NOT NULL,
  `rhol_st2x` double(8,3) NOT NULL,
  `rhol_ot2x` double(8,3) NOT NULL,
  `rhol_nd2x` double(8,3) NOT NULL,
  `rhol_ndot2x` double(8,3) NOT NULL,
  `rholrd_st2x` double(8,3) NOT NULL,
  `rholrd_ot2x` double(8,3) NOT NULL,
  `rholrd_nd2x` double(8,3) NOT NULL,
  `rholrd_ndot2x` double(8,3) NOT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `construction_rate_masters`
--
ALTER TABLE `construction_rate_masters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activityID` (`activityID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `construction_rate_masters`
--
ALTER TABLE `construction_rate_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
