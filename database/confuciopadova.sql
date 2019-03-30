-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2019 at 03:05 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `confuciopadova`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `Name` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `Credit` varchar(3) COLLATE utf32_unicode_ci NOT NULL,
  `Teacher` int(11) NOT NULL,
  `Duration` int(11) NOT NULL,
  `NumberOfLessons` int(11) NOT NULL,
  `Location` int(11) NOT NULL,
  `Semester` int(11) NOT NULL,
  `Year` int(11) NOT NULL,
  `Level` varchar(10) COLLATE utf32_unicode_ci NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`Name`, `Credit`, `Teacher`, `Duration`, `NumberOfLessons`, `Location`, `Semester`, `Year`, `Level`, `ID`) VALUES
('Lingua e cultura  cinese avanzata C1', 'Yes', 7, 60, 30, 0, 2, 2019, 'C1.1', 1),
('Principianti A1.1', 'Yes', 7, 5, 8, 0, 1, 2019, 'A1.1', 2),
('Principianti A2.1', 'No', 8, 50, 8, 0, 2, 2019, 'A2.1', 3),
('Corso esperti C2.2', 'Yes', 9, 900, 90, 6, 2, 2019, 'C2.2', 4);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `Name` varchar(100) COLLATE utf8_bin NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`Name`, `ID`) VALUES
('Sede di Pordenone', 0),
('Sede di Ferrara', 4),
('Sede di Roma', 5),
('Sede di Padova', 6),
('Rome', 7);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Surname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Occupation` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Gender` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `MobilePhone` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Telephone` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `BirthDate` date NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Name`, `Surname`, `Occupation`, `Gender`, `MobilePhone`, `Telephone`, `Email`, `BirthDate`, `ID`) VALUES
('Julien', 'Wanders', 'Other', 'Male', '3664783318', '0493059193', 'julian97ls@gmail.com', '1988-02-13', 1),
('Eliud', 'Kipchoge', 'Worker', 'Male', '39235019475', '3515853702', 'eliud97ls@gmail.com', '1960-02-13', 2),
('Yuliva', 'Levchenko', 'High School', 'Female', '3382947294', '', 'yuliva@gmail.com', '2003-02-13', 3),
('Marco', 'Polo', 'University', 'Male', '4957978689', '', 'marco@libero.it', '1970-01-01', 14),
('Marco', 'Rossi', 'Primary School', 'Male', '393515853702', '', 'davide97ls@gmail.com', '1919-01-01', 20),
('Lorenzo', 'Lazzaro', 'University', 'Male', '393515853702', '0498654103', 'lollo@gmail.com', '1997-08-27', 21);

-- --------------------------------------------------------

--
-- Table structure for table `student_course`
--

CREATE TABLE `student_course` (
  `Student` int(11) NOT NULL,
  `Course` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `student_course`
--

INSERT INTO `student_course` (`Student`, `Course`) VALUES
(1, 1),
(1, 3),
(1, 4),
(2, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `Name` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `Surname` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `Email` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `Password` varchar(256) COLLATE utf32_unicode_ci NOT NULL,
  `Position` varchar(30) COLLATE utf32_unicode_ci NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`Name`, `Surname`, `Email`, `Password`, `Position`, `ID`) VALUES
('Admin', '', 'istituto.confucio@unipd.it', '$2y$10$XocNeVGpSkoY7wVjtEw11.TCx6fUpF439lCt.EZyrMzU2U3p1RxyC', 'Headquarter', 0),
('Lionel', 'Messi', 'messigoal@gmail.com', '', 'Headquarter', 7),
('Critstiano', 'Ronaldo', 'cr7@libero.it', '', 'Local', 8),
('Usain', 'Bolt', 'usainbolt@gmail.com', '', 'Headquarter', 9),
('Xiaolong', 'Li', 'brucelee@gmail.com', '', 'Headquarter', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `student_course`
--
ALTER TABLE `student_course`
  ADD PRIMARY KEY (`Student`,`Course`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD UNIQUE KEY `ID` (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
