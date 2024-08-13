-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2024 at 10:06 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mmt`
--

-- --------------------------------------------------------

--
-- Table structure for table `cabbooking`
--

CREATE TABLE `cabbooking` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobileno` varchar(100) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `pickplace` varchar(100) NOT NULL,
  `dropplace` varchar(100) NOT NULL,
  `ptype` varchar(100) NOT NULL,
  `lpack` varchar(100) NOT NULL,
  `ctype` varchar(100) NOT NULL,
  `dat` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cabbooking`
--

INSERT INTO `cabbooking` (`id`, `name`, `mobileno`, `mail`, `pickplace`, `dropplace`, `ptype`, `lpack`, `ctype`, `dat`) VALUES
(1, 'Ashok Kumar', '9965109712', 'ashokpravick90@gmail.com', 'Madurai', 'Trichy', 'Sedan', 'Nil', 'Oneway', '2023-11-30 00:00:00'),
(2, 'Bharth Mobiles', '9965109712', 'ashokpravick90@gmail.com', 'Mdaurai', 'Trichy', 'Round Trip', 'state', 'Sedan', '2024-02-29 10:04:00'),
(3, 'Bharth Mobiles', '9965109712', 'ashokpravick90@gmail.com', 'Mdaurai', 'Trichy', 'Round Trip', 'state', 'Sedan', '2024-02-29 10:04:00'),
(4, 'Bharth Mobiles', '9965109712', 'ashokpravick90@gmail.com', 'Mdaurai', 'Trichy', 'Round Trip', 'state', 'Sedan', '2024-02-29 10:04:00');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `c_id` int(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `serviceimg` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`c_id`, `type`, `serviceimg`) VALUES
(7, 'Ooty', 'p3.jpg'),
(8, 'Rameshwaram', 'p1.jpg'),
(9, 'Ooty', 'p4.png'),
(10, 'Rameshwaram', 'p5.jpg'),
(11, 'Kodaikanal', 'p6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(100) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `Username`, `Password`) VALUES
(1, 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cabbooking`
--
ALTER TABLE `cabbooking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cabbooking`
--
ALTER TABLE `cabbooking`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `c_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
