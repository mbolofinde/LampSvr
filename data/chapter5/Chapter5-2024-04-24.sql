-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3309
-- Generation Time: Apr 24, 2024 at 12:30 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Chapter5`
--
CREATE DATABASE IF NOT EXISTS `Chapter5` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `Chapter5`;

-- --------------------------------------------------------

--
-- Table structure for table `Exam`
--
-- Creation: Apr 11, 2024 at 10:21 PM
--

DROP TABLE IF EXISTS `Exam`;
CREATE TABLE IF NOT EXISTS `Exam` (
  `ID` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `grade` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `Exam`:
--

--
-- Dumping data for table `Exam`
--

INSERT INTO `Exam` (`ID`, `score`, `grade`) VALUES
(1, 79, 'C'),
(2, 92, 'A'),
(3, 85, 'B');

--
-- Triggers `Exam`
--
DROP TRIGGER IF EXISTS `examGrade`;
DELIMITER $$
CREATE TRIGGER `examGrade` BEFORE INSERT ON `Exam` FOR EACH ROW BEGIN
IF NEW.Score >= 90 THEN
	SET NEW.GRADE = 'A';
ELSEIF NEW.Score >= 80 THEN
	SET NEW.GRADE = 'B';
ELSEIF NEW.Score >= 70 THEN
	SET NEW.GRADE = 'C';
ELSE
	SET NEW.GRADE = 'F'; 
END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--
-- Creation: Apr 04, 2024 at 11:03 PM
--

DROP TABLE IF EXISTS `flight`;
CREATE TABLE IF NOT EXISTS `flight` (
  `flightNumber` int(4) NOT NULL,
  `flightName` varchar(30) NOT NULL,
  `departureTime` time NOT NULL,
  `airPortCode` char(3) NOT NULL,
  PRIMARY KEY (`flightNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `flight`:
--

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`flightNumber`, `flightName`, `departureTime`, `airPortCode`) VALUES
(110, 'KoreanAir', '13:40:00', 'INC'),
(120, 'KoreanAir', '04:40:00', 'IAH'),
(444, 'American Airline', '12:12:30', 'IAH'),
(530, 'SouthWest', '07:40:00', 'FRA'),
(555, 'American Airline', '00:12:30', 'IAH'),
(888, 'KoreanAir', '05:00:00', 'INC'),
(999, 'Canada Airlines', '22:00:00', 'INC'),
(1300, 'KoreanAir', '19:30:00', 'INC'),
(1400, 'Canada Airlines', '19:30:00', 'IAH'),
(1500, 'KoreanAir', '09:30:00', 'IAH'),
(45687, 'Air Freedom', '08:45:00', 'ABV'),
(45688, 'Abuja SkyLine', '10:30:50', 'FCT');

--
-- Triggers `flight`
--
DROP TRIGGER IF EXISTS `delete_log`;
DELIMITER $$
CREATE TRIGGER `delete_log` AFTER DELETE ON `flight` FOR EACH ROW insert into logtbl VALUES
(old.flightnumber, old.flightName, old.departureTime)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `logtbl`
--
-- Creation: Apr 11, 2024 at 10:46 PM
--

DROP TABLE IF EXISTS `logtbl`;
CREATE TABLE IF NOT EXISTS `logtbl` (
  `flightNumber` int(11) NOT NULL,
  `flightName` varchar(20) NOT NULL,
  `departureTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `logtbl`:
--
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
