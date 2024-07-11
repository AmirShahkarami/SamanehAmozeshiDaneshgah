-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2024 at 08:30 AM
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

--
-- Dumping data for table `dars`
--

INSERT INTO `dars` (`dars_code`, `dars_name`, `dars_vahed`, `dars_zarfeiat`, `tozihat`) VALUES
(1, 'تاریخ', 2, 30, ''),
(2, 'ریاضی', 3, 45, ''),
(3, 'دانش خانواده', 2, 45, ''),
(4, 'فارسی', 3, 45, ''),
(5, 'زبان عمومی', 3, 45, ''),
(6, 'طراحی سایت', 3, 25, ''),
(7, 'شبکه ', 3, 25, '');

-- --------------------------------------------------------

--
-- Table structure for table `entekhab_vahed`
--

CREATE TABLE `entekhab_vahed` (
  `id` int(11) NOT NULL,
  `term_ostad_dars_id` int(11) NOT NULL,
  `student_code` int(11) NOT NULL,
  `tozihat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `entekhab_vahed`
--

INSERT INTO `entekhab_vahed` (`id`, `term_ostad_dars_id`, `student_code`, `tozihat`) VALUES
(1, 1, 101, '');

-- --------------------------------------------------------

--
-- Table structure for table `hozor_gheyab`
--

CREATE TABLE `hozor_gheyab` (
  `hozor_gheyab_id` int(11) NOT NULL,
  `entekhab_vahed_code` int(11) NOT NULL,
  `jaleseh_id` int(11) NOT NULL,
  `vazeiat_hozor` varchar(50) NOT NULL,
  `movajah` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hozor_gheyab`
--

INSERT INTO `hozor_gheyab` (`hozor_gheyab_id`, `entekhab_vahed_code`, `jaleseh_id`, `vazeiat_hozor`, `movajah`) VALUES
(4, 1, 1, 'حاضر', ''),
(5, 1, 2, 'حاضر', ''),
(6, 1, 3, 'غایب', ''),
(7, 1, 4, 'حاضر', '');

-- --------------------------------------------------------

--
-- Table structure for table `jaleseh`
--

CREATE TABLE `jaleseh` (
  `jaleseh_code` int(11) NOT NULL,
  `term_ostad_dars_id` int(11) NOT NULL,
  `jaleseh_roze_hafteh` varchar(50) NOT NULL,
  `jaleseh_saat` varchar(50) NOT NULL,
  `jaleseh_tarikh` date NOT NULL,
  `jaleseh_shomareh` int(11) NOT NULL,
  `tozihat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jaleseh`
--

INSERT INTO `jaleseh` (`jaleseh_code`, `term_ostad_dars_id`, `jaleseh_roze_hafteh`, `jaleseh_saat`, `jaleseh_tarikh`, `jaleseh_shomareh`, `tozihat`) VALUES
(1, 1, 'شنبه', '8:00', '2024-01-06', 1, ''),
(2, 1, 'شنبه', '8:00', '2024-01-13', 2, ''),
(3, 1, 'شنبه', '8:00', '2024-01-20', 3, ''),
(4, 1, 'شنبه', '8:00', '2024-01-27', 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `maghtaa`
--

CREATE TABLE `maghtaa` (
  `maghtaa_code` int(11) NOT NULL,
  `maghtaa_onvan` varchar(50) NOT NULL,
  `tozihat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maghtaa`
--

INSERT INTO `maghtaa` (`maghtaa_code`, `maghtaa_onvan`, `tozihat`) VALUES
(1, 'فناوری اطلاعات ', 'یادگیری واموزش طراحی سایت '),
(2, 'حسابداری', 'اموزش ریاضی پیشرفته برای حساب و کتاب های دفتری'),
(3, 'مکانیک', 'اموزش تعمیر و یادگیری تمام ابزار های تعمیر خودرو و وسایل های کارخانه ای '),
(4, 'برق و قدرت ', 'اموزش های لازم برای برق کشی و جریانات برقی\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `nomarat`
--

CREATE TABLE `nomarat` (
  `nomarat_code` int(11) NOT NULL,
  `entekhab_vahed_code` int(11) NOT NULL,
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

--
-- Dumping data for table `ostad`
--

INSERT INTO `ostad` (`ostad_code`, `ostad_name`, `ostad_family`, `ostad_madrak`, `ostad_reshtah`, `user_code`, `tozihat`) VALUES
(1, 'علی', 'مهرنیا', 'فوق لیسانس', 'کامپیوتر طراحی سایت ', 4, ''),
(2, 'ناصر ', 'شیرازی', 'لیسانس', 'ریاضی', 11, ''),
(3, 'رضا ', 'علیزاده', 'فوق لیسانس', 'فارسی', 19, ''),
(4, 'مجتبی', 'ناصری', 'فوق لیسانس', 'ریاضی', 21, '');

-- --------------------------------------------------------

--
-- Table structure for table `ostad_dars`
--

CREATE TABLE `ostad_dars` (
  `id` int(11) NOT NULL,
  `ostad_code` int(11) NOT NULL,
  `dars_code` int(11) NOT NULL,
  `tozihat` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ostad_dars`
--

INSERT INTO `ostad_dars` (`id`, `ostad_code`, `dars_code`, `tozihat`) VALUES
(1, 3, 4, ''),
(2, 3, 5, ''),
(3, 1, 7, ''),
(4, 1, 6, ''),
(5, 4, 2, '');

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

--
-- Dumping data for table `reshte`
--

INSERT INTO `reshte` (`reshte_code`, `reshte_name`, `maghtaa_code`, `tozihat`) VALUES
(1, 'فناوری اطلاعات', 1, ''),
(2, 'حسابداری', 2, ''),
(3, 'مکانیک', 3, ''),
(4, 'برق و قدرت', 4, '');

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
  `student_tel_family` varchar(13) NOT NULL,
  `user_code` int(11) NOT NULL,
  `tozihat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_code`, `student_name`, `student_family`, `student_codemeli`, `student_father`, `student_tel`, `student_tel_family`, `user_code`, `tozihat`) VALUES
(101, 'رضا', 'شهبازی', 1810726298, 'امیر', '0916336103', '09166667777', 3, NULL),
(102, 'امیر', 'رضا حسینی', 1810722222, 'محمد', '0916330000', '0916666000', 16, NULL),
(103, 'حسن', 'میرزایی', 1810720103, 'امیررضا', '0916330103', '09166660103', 17, NULL),
(104, 'امید', 'رضایی', 1810720104, 'حسینی', '0916330104', '09166660104', 18, NULL),
(105, 'مهدی', 'مهدیان', 1810720105, 'امید', '0916330105', '09166660105', 19, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `term`
--

CREATE TABLE `term` (
  `term_code` int(11) NOT NULL,
  `term_sal_tahsili` varchar(9) NOT NULL,
  `term_shomareh` int(11) NOT NULL,
  `term_active` tinyint(1) NOT NULL,
  `tozihat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `term`
--

INSERT INTO `term` (`term_code`, `term_sal_tahsili`, `term_shomareh`, `term_active`, `tozihat`) VALUES
(1, '1400-1401', 1, 0, ''),
(2, '1400-1401', 2, 0, ''),
(3, '1400-1401', 3, 0, ''),
(4, '1401-1402', 1, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `term_ostad_dars`
--

CREATE TABLE `term_ostad_dars` (
  `term_ostad_dars_id` int(11) NOT NULL,
  `term_code` int(11) NOT NULL,
  `ostad_dars_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `term_ostad_dars`
--

INSERT INTO `term_ostad_dars` (`term_ostad_dars_id`, `term_code`, `ostad_dars_code`) VALUES
(1, 4, 3),
(2, 4, 4),
(3, 3, 1),
(4, 2, 3),
(5, 4, 5);

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
(11, 'naser', '2', 'teacher'),
(15, 's1', '1', 'student'),
(16, 's2', '2', 'student'),
(17, 's3', '3', 'student'),
(18, 's4', '4', 'student'),
(19, 't5', '555', 'teacher'),
(20, 'tch2', 't2', 'teacher'),
(21, 'tch2', 't2', 'teacher'),
(22, 'tch2', 't2', 'teacher');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dars`
--
ALTER TABLE `dars`
  ADD PRIMARY KEY (`dars_code`);

--
-- Indexes for table `entekhab_vahed`
--
ALTER TABLE `entekhab_vahed`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_code` (`student_code`),
  ADD KEY `term_ostad_dars_id` (`term_ostad_dars_id`);

--
-- Indexes for table `hozor_gheyab`
--
ALTER TABLE `hozor_gheyab`
  ADD PRIMARY KEY (`hozor_gheyab_id`),
  ADD KEY `entekhab_vahed_code` (`entekhab_vahed_code`),
  ADD KEY `jaleseh_id` (`jaleseh_id`);

--
-- Indexes for table `jaleseh`
--
ALTER TABLE `jaleseh`
  ADD PRIMARY KEY (`jaleseh_code`),
  ADD KEY `term_ostad_dars_id` (`term_ostad_dars_id`);

--
-- Indexes for table `maghtaa`
--
ALTER TABLE `maghtaa`
  ADD PRIMARY KEY (`maghtaa_code`);

--
-- Indexes for table `nomarat`
--
ALTER TABLE `nomarat`
  ADD PRIMARY KEY (`nomarat_code`),
  ADD KEY `entekhab_vahed_code` (`entekhab_vahed_code`);

--
-- Indexes for table `ostad`
--
ALTER TABLE `ostad`
  ADD PRIMARY KEY (`ostad_code`),
  ADD KEY `user_code` (`user_code`);

--
-- Indexes for table `ostad_dars`
--
ALTER TABLE `ostad_dars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dars_code` (`dars_code`),
  ADD KEY `ostad_code` (`ostad_code`);

--
-- Indexes for table `reshte`
--
ALTER TABLE `reshte`
  ADD PRIMARY KEY (`reshte_code`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_code`),
  ADD KEY `user_code` (`user_code`);

--
-- Indexes for table `term`
--
ALTER TABLE `term`
  ADD PRIMARY KEY (`term_code`);

--
-- Indexes for table `term_ostad_dars`
--
ALTER TABLE `term_ostad_dars`
  ADD PRIMARY KEY (`term_ostad_dars_id`),
  ADD KEY `term_code` (`term_code`),
  ADD KEY `ostad_dars_code` (`ostad_dars_code`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `entekhab_vahed`
--
ALTER TABLE `entekhab_vahed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hozor_gheyab`
--
ALTER TABLE `hozor_gheyab`
  MODIFY `hozor_gheyab_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jaleseh`
--
ALTER TABLE `jaleseh`
  MODIFY `jaleseh_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `nomarat`
--
ALTER TABLE `nomarat`
  MODIFY `nomarat_code` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ostad_dars`
--
ALTER TABLE `ostad_dars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `term_ostad_dars`
--
ALTER TABLE `term_ostad_dars`
  MODIFY `term_ostad_dars_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `entekhab_vahed`
--
ALTER TABLE `entekhab_vahed`
  ADD CONSTRAINT `entekhab_vahed_ibfk_1` FOREIGN KEY (`student_code`) REFERENCES `student` (`student_code`),
  ADD CONSTRAINT `entekhab_vahed_ibfk_2` FOREIGN KEY (`term_ostad_dars_id`) REFERENCES `term_ostad_dars` (`term_ostad_dars_id`);

--
-- Constraints for table `hozor_gheyab`
--
ALTER TABLE `hozor_gheyab`
  ADD CONSTRAINT `hozor_gheyab_ibfk_1` FOREIGN KEY (`entekhab_vahed_code`) REFERENCES `entekhab_vahed` (`id`),
  ADD CONSTRAINT `hozor_gheyab_ibfk_2` FOREIGN KEY (`jaleseh_id`) REFERENCES `jaleseh` (`jaleseh_code`);

--
-- Constraints for table `jaleseh`
--
ALTER TABLE `jaleseh`
  ADD CONSTRAINT `jaleseh_ibfk_1` FOREIGN KEY (`term_ostad_dars_id`) REFERENCES `term_ostad_dars` (`term_ostad_dars_id`);

--
-- Constraints for table `nomarat`
--
ALTER TABLE `nomarat`
  ADD CONSTRAINT `nomarat_ibfk_1` FOREIGN KEY (`entekhab_vahed_code`) REFERENCES `entekhab_vahed` (`id`);

--
-- Constraints for table `ostad`
--
ALTER TABLE `ostad`
  ADD CONSTRAINT `ostad_ibfk_1` FOREIGN KEY (`user_code`) REFERENCES `user` (`user_code`);

--
-- Constraints for table `ostad_dars`
--
ALTER TABLE `ostad_dars`
  ADD CONSTRAINT `ostad_dars_ibfk_1` FOREIGN KEY (`dars_code`) REFERENCES `dars` (`dars_code`),
  ADD CONSTRAINT `ostad_dars_ibfk_2` FOREIGN KEY (`ostad_code`) REFERENCES `ostad` (`ostad_code`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`user_code`) REFERENCES `user` (`user_code`);

--
-- Constraints for table `term_ostad_dars`
--
ALTER TABLE `term_ostad_dars`
  ADD CONSTRAINT `term_ostad_dars_ibfk_3` FOREIGN KEY (`term_code`) REFERENCES `term` (`term_code`),
  ADD CONSTRAINT `term_ostad_dars_ibfk_4` FOREIGN KEY (`ostad_dars_code`) REFERENCES `ostad_dars` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
