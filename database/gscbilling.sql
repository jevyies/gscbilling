-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2021 at 07:20 AM
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
-- Table structure for table `rate_masters_2`
--

CREATE TABLE `rate_masters_2` (
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
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rate_masters_3`
--

CREATE TABLE `rate_masters_3` (
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
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rate_masters_4`
--

CREATE TABLE `rate_masters_4` (
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
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `retro_bcc_rate`
--

CREATE TABLE `retro_bcc_rate` (
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
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UploadID` int(11) NOT NULL,
  `UploadedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `retro_bcc_upload_rate_history`
--

CREATE TABLE `retro_bcc_upload_rate_history` (
  `id` int(11) NOT NULL,
  `UploadedBy` bigint(20) NOT NULL,
  `status` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `retro_clubhouse_rate`
--

CREATE TABLE `retro_clubhouse_rate` (
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
  `updated_at` timestamp NULL DEFAULT NULL,
  `UploadID` int(11) NOT NULL,
  `UploadedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `retro_clubhouse_upload_rate_history`
--

CREATE TABLE `retro_clubhouse_upload_rate_history` (
  `id` int(11) NOT NULL,
  `UploadedBy` bigint(20) NOT NULL,
  `status` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `retro_slers_rate`
--

CREATE TABLE `retro_slers_rate` (
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
  `updated_at` timestamp NULL DEFAULT NULL,
  `UploadID` int(11) NOT NULL,
  `UploadedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `retro_slers_upload_rate_history`
--

CREATE TABLE `retro_slers_upload_rate_history` (
  `id` int(11) NOT NULL,
  `UploadedBy` bigint(20) NOT NULL,
  `status` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rate_masters_2`
--
ALTER TABLE `rate_masters_2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rate_masters_3`
--
ALTER TABLE `rate_masters_3`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rate_masters_4`
--
ALTER TABLE `rate_masters_4`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `retro_bcc_rate`
--
ALTER TABLE `retro_bcc_rate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activityID` (`activityID`);

--
-- Indexes for table `retro_bcc_upload_rate_history`
--
ALTER TABLE `retro_bcc_upload_rate_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `retro_clubhouse_rate`
--
ALTER TABLE `retro_clubhouse_rate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activityID` (`activityID`);

--
-- Indexes for table `retro_clubhouse_upload_rate_history`
--
ALTER TABLE `retro_clubhouse_upload_rate_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `retro_slers_rate`
--
ALTER TABLE `retro_slers_rate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activityID` (`activityID`);

--
-- Indexes for table `retro_slers_upload_rate_history`
--
ALTER TABLE `retro_slers_upload_rate_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rate_masters_2`
--
ALTER TABLE `rate_masters_2`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rate_masters_3`
--
ALTER TABLE `rate_masters_3`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rate_masters_4`
--
ALTER TABLE `rate_masters_4`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `retro_bcc_rate`
--
ALTER TABLE `retro_bcc_rate`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `retro_bcc_upload_rate_history`
--
ALTER TABLE `retro_bcc_upload_rate_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `retro_clubhouse_rate`
--
ALTER TABLE `retro_clubhouse_rate`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `retro_clubhouse_upload_rate_history`
--
ALTER TABLE `retro_clubhouse_upload_rate_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `retro_slers_rate`
--
ALTER TABLE `retro_slers_rate`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `retro_slers_upload_rate_history`
--
ALTER TABLE `retro_slers_upload_rate_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
