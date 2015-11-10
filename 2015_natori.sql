-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015 年 11 月 10 日 16:26
-- サーバのバージョン： 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `2015_natori`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `answer_person`
--

CREATE TABLE IF NOT EXISTS `answer_person` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `policy_field` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `attendance`
--

CREATE TABLE IF NOT EXISTS `attendance` (
  `giin_id` int(11) NOT NULL,
  `gikai_id` int(11) NOT NULL,
  `attendance` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `gian`
--

CREATE TABLE IF NOT EXISTS `gian` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `iinkai` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `giin`
--

CREATE TABLE IF NOT EXISTS `giin` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `detail` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `gikai`
--

CREATE TABLE IF NOT EXISTS `gikai` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `gikai_gian`
--

CREATE TABLE IF NOT EXISTS `gikai_gian` (
  `gikai_id` int(11) NOT NULL,
  `gian_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `hatugen`
--

CREATE TABLE IF NOT EXISTS `hatugen` (
  `id` int(11) NOT NULL,
  `detail` varchar(100) DEFAULT NULL,
  `giin_id` int(11) DEFAULT NULL,
  `answer_id` int(11) DEFAULT NULL,
  `gikai_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `hatugen_gian`
--

CREATE TABLE IF NOT EXISTS `hatugen_gian` (
  `hatugen_id` int(11) NOT NULL,
  `gikai_id` int(11) NOT NULL,
  `gian_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `sansei_or_hantai`
--

CREATE TABLE IF NOT EXISTS `sansei_or_hantai` (
  `giin_id` int(11) NOT NULL,
  `gian_id` int(11) NOT NULL,
  `detail` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer_person`
--
ALTER TABLE `answer_person`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
 ADD PRIMARY KEY (`giin_id`,`gikai_id`), ADD KEY `id_idx` (`gikai_id`);

--
-- Indexes for table `gian`
--
ALTER TABLE `gian`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `giin`
--
ALTER TABLE `giin`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `gikai`
--
ALTER TABLE `gikai`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `gikai_gian`
--
ALTER TABLE `gikai_gian`
 ADD PRIMARY KEY (`gikai_id`,`gian_id`), ADD KEY `gian_gikai_idx` (`gian_id`);

--
-- Indexes for table `hatugen`
--
ALTER TABLE `hatugen`
 ADD PRIMARY KEY (`id`,`gikai_id`), ADD KEY `giin_id_idx` (`giin_id`), ADD KEY `gikai_to_hatugen_idx` (`gikai_id`), ADD KEY `answer_to_hatugen_idx` (`answer_id`);

--
-- Indexes for table `hatugen_gian`
--
ALTER TABLE `hatugen_gian`
 ADD PRIMARY KEY (`hatugen_id`,`gikai_id`,`gian_id`), ADD KEY `gian_idx` (`gian_id`), ADD KEY `gikai_idx` (`gikai_id`);

--
-- Indexes for table `sansei_or_hantai`
--
ALTER TABLE `sansei_or_hantai`
 ADD PRIMARY KEY (`giin_id`,`gian_id`), ADD KEY `gian_to_sanpi_idx` (`gian_id`);

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `attendance`
--
ALTER TABLE `attendance`
ADD CONSTRAINT `giin_to_attendance` FOREIGN KEY (`giin_id`) REFERENCES `giin` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `gikai_to_attendance` FOREIGN KEY (`gikai_id`) REFERENCES `gikai` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- テーブルの制約 `gikai_gian`
--
ALTER TABLE `gikai_gian`
ADD CONSTRAINT `gian_gikai` FOREIGN KEY (`gian_id`) REFERENCES `gian` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `gikai_gian` FOREIGN KEY (`gikai_id`) REFERENCES `gikai` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- テーブルの制約 `hatugen`
--
ALTER TABLE `hatugen`
ADD CONSTRAINT `answer_to_hatugen` FOREIGN KEY (`answer_id`) REFERENCES `answer_person` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `giin_to_hatugen` FOREIGN KEY (`giin_id`) REFERENCES `giin` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `gikai_to_hatugen` FOREIGN KEY (`gikai_id`) REFERENCES `gikai` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- テーブルの制約 `hatugen_gian`
--
ALTER TABLE `hatugen_gian`
ADD CONSTRAINT `gian` FOREIGN KEY (`gian_id`) REFERENCES `gian` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `gikai` FOREIGN KEY (`gikai_id`) REFERENCES `gikai` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `hatugen` FOREIGN KEY (`hatugen_id`) REFERENCES `hatugen` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- テーブルの制約 `sansei_or_hantai`
--
ALTER TABLE `sansei_or_hantai`
ADD CONSTRAINT `gian_to_sanpi` FOREIGN KEY (`gian_id`) REFERENCES `gian` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `giin_to_sanpi` FOREIGN KEY (`giin_id`) REFERENCES `giin` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
