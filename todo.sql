-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2023 at 03:04 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todo`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `ID` int(11) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  `Grade` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`ID`, `FirstName`, `LastName`, `Grade`) VALUES
(1, 'Ademir', 'Hebibovic', 4),
(2, 'Mirza', 'Novalic', 7),
(13, 'kenan', 'hasan', 0),
(14, 'Amina', 'Haskovic;', 0),
(16, 'Amina', 'Haskovic;', 0),
(17, 'Amina', 'Haskovic;', 0),
(18, 'promjenica', 'Haskovic;', 1),
(19, 'Amina', 'Haskovic;', 0),
(20, 'mehdi', 'imamovic', 0),
(21, 'mehdi', 'imamovic', 0),
(22, 'mehdi', 'imamovic', 0),
(24, 'mehdi', 'imamovic', 0),
(25, 'mehdi', 'imamovic', 0),
(29, 'FirstName', 'LastName', 0),
(30, 'FirstName', 'LastName', 0),
(31, 'merima', 'berimbolo', 0),
(32, 'merima', 'berimbolo', 0),
(34, '', '', 0),
(35, '', '', 0),
(36, '', '', 0),
(37, '', '', 0),
(38, '', '', 0),
(42, 'emir', 'mulic', 0),
(43, 'basil', 'bosnjak', 0),
(44, 'basil', 'bosnjak', 0),
(47, 'teča', 'gambino', 0),
(48, 'dino', 'brescic', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
