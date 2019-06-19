-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2019 at 06:29 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_paymentsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `ps_employee`
--

CREATE TABLE `ps_employee` (
  `id` int(11) NOT NULL,
  `name` varchar(126) NOT NULL,
  `email` varchar(256) NOT NULL,
  `salary` bigint(126) NOT NULL,
  `account_number` varchar(152) NOT NULL,
  `bank` varchar(126) NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ps_employee`
--

INSERT INTO `ps_employee` (`id`, `name`, `email`, `salary`, `account_number`, `bank`, `date`) VALUES
(10, 'kene', 'Kenenna@csr-in-action.org', 10000, '6170636996', 'Fidelity Bank', '2019-06-04 09:40:24'),
(11, 'kene', 'kenenna@gmail.com', 1210, '0759940406', 'Access Bank', '2019-06-04 10:10:11'),
(12, 'Musa', 'musa@zenera.mx', 2110000, '2074500903', 'UBA Bank', '2019-06-04 04:41:46');

-- --------------------------------------------------------

--
-- Table structure for table `ps_user`
--

CREATE TABLE `ps_user` (
  `Id` int(30) NOT NULL,
  `Username` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ps_user`
--

INSERT INTO `ps_user` (`Id`, `Username`, `Password`) VALUES
(1, 'ps_admin', '$2y$12$TYeGqpziVTfCKNV1/4.2i.IXZ5EZ6L/YloVTwtByWosv.HsFYgpZy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ps_employee`
--
ALTER TABLE `ps_employee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account number` (`account_number`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `ps_user`
--
ALTER TABLE `ps_user`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ps_employee`
--
ALTER TABLE `ps_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `ps_user`
--
ALTER TABLE `ps_user`
  MODIFY `Id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
