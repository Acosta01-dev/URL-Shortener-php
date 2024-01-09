-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2024 at 01:04 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shortener`
--

-- --------------------------------------------------------

--
-- Table structure for table `url_shortener`
--

CREATE TABLE `url_shortener` (
  `id` int(11) NOT NULL,
  `short_code` varchar(10) NOT NULL,
  `long_url` varchar(255) NOT NULL,
  `used` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `url_shortener`
--

INSERT INTO `url_shortener` (`id`, `short_code`, `long_url`, `used`) VALUES
(1, '46421', 'www.google.com', 10),
(3, 'de1d4', 'www.yahoo.com', 1),
(4, '2c24b', 'www.youtube.com', 1),
(5, 'eca93', 'https://www.youtube.com/watch?v=BiStxSaLs7U', 0),
(7, 'adeb2', 'https://meteum.ai/weather/en-US?utm_source=yandex&utm_medium=com&utm_campaign=morda&lat=-34.615689&lon=-58.435104', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `url_shortener`
--
ALTER TABLE `url_shortener`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `url_shortener`
--
ALTER TABLE `url_shortener`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
