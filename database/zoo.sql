-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 04, 2024 at 01:33 PM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zoo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Ad_ID` varchar(60) NOT NULL,
  `Ad_name` varchar(60) NOT NULL,
  `Ad_Password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Ad_ID`, `Ad_name`, `Ad_Password`) VALUES
('Ad001', 'Admin', '$2y$10$iFkNI.f4NwE1yA0b9ey1AOksoZer5mPIWz5ar8pvLV.clEC1wBWFC');

-- --------------------------------------------------------

--
-- Table structure for table `animal`
--

CREATE TABLE `animal` (
  `A_ID` varchar(60) NOT NULL,
  `A_name` varchar(60) NOT NULL,
  `A_Sex` varchar(10) NOT NULL,
  `ADate_of_birth` date NOT NULL,
  `Species` varchar(30) NOT NULL,
  `ZK_ID` varchar(60) NOT NULL,
  `Zone_name` varchar(30) NOT NULL,
  `image_path` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `animal`
--

INSERT INTO `animal` (`A_ID`, `A_name`, `A_Sex`, `ADate_of_birth`, `Species`, `ZK_ID`, `Zone_name`, `image_path`) VALUES
('A001', 'Sun wukong', 'Male', '1879-08-16', 'monkey', 'Z003', 'Mount Liangshan', 'img/Sun wukong.jpg'),
('A002', 'Hippogriff', 'Male', '1994-09-03', 'Griffin-Equus', 'Z003', 'Mount Himalayan', 'img/Hippogriff.jpg'),
('A003', 'Hippocampi', 'Male', '2008-07-15', 'Equus-Kampos', 'Z002', 'Mount Olympus', 'img/Hippocampi.jpg'),
('A004', 'Minotaur', 'Male', '2008-05-15', 'Ox-Human', 'Z001', 'Mount Olympus', 'img/Minotaur.jpg'),
('A005', 'Waree Kunchorn', 'Male', '2022-04-06', 'Elephant-Fish', 'Z002', 'Mount Himalayan', 'img/Waree Kunchorn.jpg'),
('A006', 'Alicorn', 'Female', '2014-11-19', 'Unicorn-Pegasus', 'Z003', 'Mount Olympus', 'img/Alicorn.jpg'),
('A007', 'Nian', 'Male', '2000-04-17', 'Kampos-Lion', 'Z001', 'Mount Liangshan', 'img/Nian.jpg'),
('A008', 'Naga', 'Female', '2003-07-23', 'Serpent', 'Z002', 'Mount Himalayan', 'img/Naga.jpg'),
('A009', 'Niffler', 'Male', '2015-12-18', 'Rodent-Echidna', 'Z001', 'Mount Liangshan', 'img/Niffler.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ingredient`
--

CREATE TABLE `ingredient` (
  `In_ID` varchar(60) NOT NULL,
  `In_type` varchar(60) NOT NULL,
  `In_amount` int(11) NOT NULL,
  `Expiration_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ingredient`
--

INSERT INTO `ingredient` (`In_ID`, `In_type`, `In_amount`, `Expiration_date`) VALUES
('H001', 'Flesh', 72, '2024-12-07'),
('M001', 'Beef', 5, '2024-11-21'),
('V001', 'Carrot', 5, '2024-11-23');

-- --------------------------------------------------------

--
-- Table structure for table `meal`
--

CREATE TABLE `meal` (
  `Meal_code` varchar(60) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `A_ID` varchar(60) NOT NULL,
  `In_ID` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `meal`
--

INSERT INTO `meal` (`Meal_code`, `Date`, `Time`, `A_ID`, `In_ID`) VALUES
('B_Nian_20241130', '2024-11-30', '23:35:00', 'A007', 'H001');

-- --------------------------------------------------------

--
-- Table structure for table `zone`
--

CREATE TABLE `zone` (
  `Zone_name` varchar(30) NOT NULL,
  `Avg_temp` varchar(25) NOT NULL,
  `Habitat` varchar(100) NOT NULL,
  `Environment` varchar(100) NOT NULL,
  `Relative_humidity` int(11) NOT NULL,
  `image_path` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `zone`
--

INSERT INTO `zone` (`Zone_name`, `Avg_temp`, `Habitat`, `Environment`, `Relative_humidity`, `image_path`) VALUES
('Mount Himalayan', '25-30°C', 'Challenging yet peaceful magical creature', 'Dense and lush forest', 85, 'img/Himalayan.jpg'),
('Mount Liangshan', '10-20°C', 'gigantic and powerful yaoguai', 'subtropical mountain forests and rugged terrain', 70, 'img/Liangshan.jpg'),
('Mount Olympus', '0-20°C', 'Dangerous and iconic creature', 'Mediterranean, lush forests, alpine meadows, and rocky terrain', 60, 'img/Olympus.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `zookeeper`
--

CREATE TABLE `zookeeper` (
  `ZK_ID` varchar(60) NOT NULL,
  `ZKFName` varchar(60) NOT NULL,
  `ZKLName` varchar(60) NOT NULL,
  `ZDate_of_birth` date NOT NULL,
  `ZSex` varchar(10) NOT NULL,
  `Salary` int(11) NOT NULL,
  `image_path` varchar(100) NOT NULL,
  `ZK_Password` varchar(300) NOT NULL,
  `zk_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `zookeeper`
--

INSERT INTO `zookeeper` (`ZK_ID`, `ZKFName`, `ZKLName`, `ZDate_of_birth`, `ZSex`, `Salary`, `image_path`, `ZK_Password`, `zk_email`) VALUES
('Z001', 'Newt', 'Scamander', '1990-02-24', 'Male', 50000, 'img/Newt.jpg', '$2y$10$4.GmS4H2zJZuWfYK7Ia7/eD.xz2lS2ohhEs.6cs2Igje03efeKJny', 'Newt.S@zoo.com'),
('Z002', 'Percy', 'Jackson', '2002-08-18', 'Male', 35000, 'img/percy.jpg', '$2y$10$S7ET/iMNy7Vke/j5Puc6/uL64o5yrZfHv0dRYicWmAk1GPsDFI6vS', 'Percy.J@zoo.com'),
('Z003', 'Rubeus', 'Hagrid', '1968-12-06', 'Male', 60000, 'img/Rubeus.jpg', '$2y$10$XBMWrngg7N0QXZRVSs2cw.nh0mzIRJhKmTdNHLDoys6xY0rACH2uu', 'Rebeus.H@zoo.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Ad_ID`);

--
-- Indexes for table `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`A_ID`),
  ADD KEY `ZK_ID` (`ZK_ID`),
  ADD KEY `Zone_name` (`Zone_name`);

--
-- Indexes for table `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`In_ID`);

--
-- Indexes for table `meal`
--
ALTER TABLE `meal`
  ADD PRIMARY KEY (`Meal_code`),
  ADD KEY `A_ID` (`A_ID`),
  ADD KEY `In_ID` (`In_ID`);

--
-- Indexes for table `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`Zone_name`);

--
-- Indexes for table `zookeeper`
--
ALTER TABLE `zookeeper`
  ADD PRIMARY KEY (`ZK_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `animal`
--
ALTER TABLE `animal`
  ADD CONSTRAINT `animal_ibfk_1` FOREIGN KEY (`ZK_ID`) REFERENCES `zookeeper` (`ZK_ID`),
  ADD CONSTRAINT `animal_ibfk_2` FOREIGN KEY (`Zone_name`) REFERENCES `zone` (`Zone_name`);

--
-- Constraints for table `meal`
--
ALTER TABLE `meal`
  ADD CONSTRAINT `meal_ibfk_1` FOREIGN KEY (`In_ID`) REFERENCES `ingredient` (`In_ID`),
  ADD CONSTRAINT `meal_ibfk_2` FOREIGN KEY (`A_ID`) REFERENCES `animal` (`A_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
