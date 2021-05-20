-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2020 at 11:30 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tdt_classroom`
--
CREATE DATABASE IF NOT EXISTS `tdt_classroom` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tdt_classroom`;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `FullName` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `Birthday` date NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `activated` bit(1) NOT NULL,
  `activate_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(1) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`username`, `password`, `FullName`, `Birthday`, `email`, `phone`, `activated`, `activate_token`, `role`) VALUES
('admin', '$2y$10$T.D5YzDn8LxpifnAIWUxTO9kSBOd/XycbIHrUbRMJvmdDVLsMsUY2', 'Admin ', '2020-01-11', 'phamvulongkhai2000@gmail.com', '0773637917', b'1', '', '1'),
('Lecturer0', '$2y$10$EvnDveVAk4Vv0elZ5ffyD.V/DkMk0N4NSGoc6Nzv6nftv23FZlKhW', 'Nguyen Van Tung', '2020-11-01', 'Lecturer0@gmail.com', '0123456789', b'1', '', '2'),
('Lecturer1', '$2y$10$t34HFKAEr3oZra9kx3DF9u1iWsH.M0kaBgfc0VFwXApj4pGcHxHBy', 'Le Thi Bich Ngoc', '2020-01-11', 'Lecturer1@gmail.com', '0123456789', b'1', '', '2'),
('Student0', '$2y$10$gCQLouYuZ42aFr3kImrJAevn4tkbDhu/7CydxG2ODLPFm/2dmH5gu', 'Student0', '2020-11-01', 'Student10@gmail.com', '0123456789', b'1', '', '3'),
('Student1', '$2y$10$hSwrK41qvLTztdt0.r6KBuS70pB51saxrAsmcvhjSwtN9hyIsEt4q', 'Student1', '2020-01-11', 'student1@gmail.com', '0123456789', b'1', '', '3'),
('Student2', '$2y$10$EmhWLWiSfOss20BJo3fXyOqeGeTEnzgBZZqNLt1BQHz1ZD3dF6.P.', 'Student2', '2020-11-01', 'Student2@gmail.com', '0123456789', b'1', '', '3'),
('Student3', '$2y$10$oYAS1jO9Rxi.4c2IfWs/UeZxG/Pj11TB4s16n8CcDwKDPM5DV9V86', 'Student3', '2020-11-01', 'Student3@gmail.com', '0123456789', b'1', '', '3'),
('Student4', '$2y$10$eMrZE..kMavSjK6rPuY2uOx9YUhQXZe3PcY1nozq.dX8jfbDKws2C', 'Student4', '2020-11-01', 'Student4@gmail.com', '0123456789', b'1', '', '3'),
('Student5', '$2y$10$FgoVA4leI9G/0MGDxuMNRu7YwboCX6fS8Fhbg5aOx5VllZgoerwIK', 'Student5', '2020-11-01', 'Student5@gmail.com', '0123456789', b'1', '', '3'),
('Student6', '$2y$10$AENVarBGdtcJAh4EhW1WrO3Wn6KSm5bJmwMAluOahx5PuhJPg9CyG', 'Student6', '2020-11-01', 'Student6@gmail.com', '0123456789', b'1', '', '3'),
('Student7', '$2y$10$bx.J7Aag4Vi6L1Z96DlJMel5TZZQxS7mu4.39vbud/fU5znCDfRaS', 'Student7', '2020-11-01', 'Student7@gmai.com', '0123456789', b'1', '', '3'),
('Student8', '$2y$10$BU8CUIHYCNoFUhcK5ured.uEiW7O6mZHR08is6lHvVLq1ocC6HJgq', 'Student8', '2020-11-01', 'Student8@gmail.com', '0123456789', b'1', '', '3'),
('Student9', '$2y$10$TvyvT/D.9oEfs0CRvxFwk.GCrwlUk5r1zPt.qf4BB0kAf/BmhDs.i', 'Student9', '2020-11-01', 'Student9@gmai.com', '0123456789', b'1', '', '3');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `classid` int(5) NOT NULL,
  `classname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `room` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `subjects` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `add_by_lecturers` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`classid`, `classname`, `room`, `subjects`, `image`, `add_by_lecturers`) VALUES
(18963, '18050304', 'C507', 'History', '4.png', 'Lecturer0'),
(25941, '18050303', 'C609', 'English', '3.jpg', 'Lecturer0'),
(37297, '18050301', 'B203', 'Math', '1.jpg', 'Lecturer0'),
(55595, '18050305', 'D707', 'Fine Art', '5.jpg', 'Lecturer1'),
(56896, '18050307', 'F502', 'Physical Education', '7.jpg', 'Lecturer1'),
(69465, '18050306', 'E111', 'Biology', '6.jpg', 'Lecturer1'),
(83965, '18050302', 'A405', 'Literature', '2.jpg', ''),
(95412, '18050308', 'C401', 'Music', '8.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `reset_token`
--

CREATE TABLE `reset_token` (
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expire_on` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reset_token`
--

INSERT INTO `reset_token` (`email`, `token`, `expire_on`) VALUES
('bestmid2000@gmail.com', 'e21df6e27f97dfda06ee5b8bc5b1a639', 1606760146),
('phamvulongkhai2000@gmail.com', '0e247015bbcbdc7847edf4bc04c80f5c', 1606930271);

-- --------------------------------------------------------

--
-- Table structure for table `student_class`
--

CREATE TABLE `student_class` (
  `ID` int(7) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `classid` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_class`
--

INSERT INTO `student_class` (`ID`, `username`, `classid`) VALUES
(2265006, 'Student0', 25941),
(2627376, 'Student1', 69465),
(2758496, 'Student0', 55595),
(4935835, 'Student0', 56896),
(6448700, 'Student0', 18963),
(7404450, 'Student1', 95412);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`classid`);

--
-- Indexes for table `reset_token`
--
ALTER TABLE `reset_token`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `student_class`
--
ALTER TABLE `student_class`
  ADD PRIMARY KEY (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
