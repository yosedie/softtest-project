-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2020 at 09:38 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `update`
--

-- --------------------------------------------------------

--
-- Table structure for table `adsenses`
--

CREATE TABLE `adsenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `ishome` tinyint(1) NOT NULL DEFAULT '0',
  `iscart` tinyint(1) NOT NULL DEFAULT '0',
  `isdetail` tinyint(1) NOT NULL DEFAULT '0',
  `iswishlist` tinyint(1) NOT NULL DEFAULT '0',
  `isviewall` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bigbluemeetings`
--

CREATE TABLE `bigbluemeetings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `presen_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instructor_id` int(11) UNSIGNED NOT NULL,
  `meetingid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail` longtext COLLATE utf8mb4_unicode_ci,
  `start_time` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meetingname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modpw` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attendeepw` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `welcomemsg` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setMaxParticipants` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-1',
  `setMuteOnStart` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'false',
  `allow_record` tinyint(1) NOT NULL,
  `is_ended` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_progress`
--

CREATE TABLE `course_progress` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `mark_chapter_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `all_chapter_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adsenses`
--
ALTER TABLE `adsenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bigbluemeetings`
--
ALTER TABLE `bigbluemeetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_progress`
--
ALTER TABLE `course_progress`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adsenses`
--
ALTER TABLE `adsenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bigbluemeetings`
--
ALTER TABLE `bigbluemeetings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_progress`
--
ALTER TABLE `course_progress`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
