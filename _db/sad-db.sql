-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2024 at 08:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sad-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `dars`
--

CREATE TABLE `dars` (
  `dars_code` int(11) NOT NULL,
  `dars_name` varchar(50) NOT NULL,
  `dars_vahed` int(11) NOT NULL,
  `dars_zarfeiat` int(11) NOT NULL,
  `tozihat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hozor_gheyab`
--

CREATE TABLE `hozor_gheyab` (
  `hozor_gheyab_id` int(11) NOT NULL,
  `term_ostad_dars_id` int(11) NOT NULL,
  `student_code` int(11) NOT NULL,
  `jaleseh_id` int(11) NOT NULL,
  `vazeiat_hozor` varchar(50) NOT NULL,
  `movajah` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jaleseh`
--

CREATE TABLE `jaleseh` (
  `jaleseh_code` int(11) NOT NULL,
  `term_ostad_dars_id` int(11) NOT NULL,
  `jaleseh_roze_hafteh` varchar(50) NOT NULL,
  `jaleseh_saat` varchar(50) NOT NULL,
  `jaleseh_tarikh` int(11) NOT NULL,
  `jaleseh_shomareh` int(11) NOT NULL,
  `tozihat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maghtaa`
--

CREATE TABLE `maghtaa` (
  `maghtaa_code` int(11) NOT NULL,
  `maghtaa_onvan` varchar(50) NOT NULL,
  `tozihat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nomarat`
--

CREATE TABLE `nomarat` (
  `nomarat_code` int(11) NOT NULL,
  `term_ostad_dars_id` int(11) NOT NULL,
  `student_code` int(11) NOT NULL,
  `nomreh` double NOT NULL,
  `vazeiat_eeteraz` varchar(50) NOT NULL,
  `tozihat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ostad`
--

CREATE TABLE `ostad` (
  `ostad_code` int(11) NOT NULL,
  `ostad_name` varchar(50) NOT NULL,
  `ostad_family` varchar(50) NOT NULL,
  `ostad_madrak` varchar(50) NOT NULL,
  `ostad_reshtah` varchar(50) NOT NULL,
  `user_code` int(11) NOT NULL,
  `tozihat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reshte`
--

CREATE TABLE `reshte` (
  `reshte_code` int(11) NOT NULL,
  `reshte_name` varchar(50) NOT NULL,
  `maghtaa_code` int(11) NOT NULL,
  `tozihat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_code` int(11) NOT NULL,
  `student_name` varchar(50) NOT NULL,
  `student_family` varchar(50) NOT NULL,
  `student_codemeli` int(11) NOT NULL,
  `student_father` varchar(50) NOT NULL,
  `student_tel` varchar(13) NOT NULL,
  `student_tel_amily` varchar(13) NOT NULL,
  `user_code` int(11) NOT NULL,
  `tozihat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `term`
--

CREATE TABLE `term` (
  `term_code` int(11) NOT NULL,
  `term_sal_tahsili` varchar(9) NOT NULL,
  `term_shoareh` int(11) NOT NULL,
  `tozihat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `term_ostad_dars`
--

CREATE TABLE `term_ostad_dars` (
  `term_ostad_dars_id` int(11) NOT NULL,
  `term_code` int(11) NOT NULL,
  `ostad_code` int(11) NOT NULL,
  `dars_code` int(11) NOT NULL,
  `tozihat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_code` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_code`, `username`, `password`, `role`) VALUES
(1, 'admin', '123', 'admin'),
(3, 'reza', '2', 'student'),
(4, 'ali', '123', 'teacher'),
(8, 'ففففف', 't2', 'teacher'),
(11, 'u2', '2', 'teacher'),
(15, 'u47', '44', 'teacher');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dars`
--
ALTER TABLE `dars`
  ADD PRIMARY KEY (`dars_code`);

--
-- Indexes for table `hozor_gheyab`
--
ALTER TABLE `hozor_gheyab`
  ADD PRIMARY KEY (`hozor_gheyab_id`);

--
-- Indexes for table `jaleseh`
--
ALTER TABLE `jaleseh`
  ADD PRIMARY KEY (`jaleseh_code`);

--
-- Indexes for table `maghtaa`
--
ALTER TABLE `maghtaa`
  ADD PRIMARY KEY (`maghtaa_code`);

--
-- Indexes for table `nomarat`
--
ALTER TABLE `nomarat`
  ADD PRIMARY KEY (`nomarat_code`);

--
-- Indexes for table `ostad`
--
ALTER TABLE `ostad`
  ADD PRIMARY KEY (`ostad_code`);

--
-- Indexes for table `reshte`
--
ALTER TABLE `reshte`
  ADD PRIMARY KEY (`reshte_code`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_code`);

--
-- Indexes for table `term`
--
ALTER TABLE `term`
  ADD PRIMARY KEY (`term_code`);

--
-- Indexes for table `term_ostad_dars`
--
ALTER TABLE `term_ostad_dars`
  ADD PRIMARY KEY (`term_ostad_dars_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hozor_gheyab`
--
ALTER TABLE `hozor_gheyab`
  MODIFY `hozor_gheyab_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jaleseh`
--
ALTER TABLE `jaleseh`
  MODIFY `jaleseh_code` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nomarat`
--
ALTER TABLE `nomarat`
  MODIFY `nomarat_code` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `term_ostad_dars`
--
ALTER TABLE `term_ostad_dars`
  MODIFY `term_ostad_dars_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
