-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016 年 1 朁E09 日 17:26
-- サーバのバージョン： 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sotu`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `出席者`
--

CREATE TABLE IF NOT EXISTS `出席者` (
  `議員id` varchar(15) NOT NULL,
  `議会id` varchar(20) NOT NULL,
  `出欠` varchar(1) NOT NULL,
  PRIMARY KEY (`議員id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `発言`
--

CREATE TABLE IF NOT EXISTS `発言` (
  `発言id` varchar(20) NOT NULL,
  `議員id` varchar(15) NOT NULL,
  `答弁者id` varchar(15) NOT NULL,
  `発言者名` varchar(50) NOT NULL,
  `発言内容` text NOT NULL,
  `議会id` varchar(20) NOT NULL,
  PRIMARY KEY (`発言id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `発言内議案`
--

CREATE TABLE IF NOT EXISTS `発言内議案` (
  `発言id` varchar(20) NOT NULL,
  `議会id` varchar(20) NOT NULL,
  `議案id` varchar(20) NOT NULL,
  PRIMARY KEY (`発言id`,`議会id`,`議案id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `答弁者`
--

CREATE TABLE IF NOT EXISTS `答弁者` (
  `答弁者id` varchar(15) NOT NULL,
  `答弁者名` varchar(50) NOT NULL,
  `役職` varchar(100) NOT NULL,
  `分野名` varchar(100) NOT NULL,
  PRIMARY KEY (`答弁者id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `議会`
--

CREATE TABLE IF NOT EXISTS `議会` (
  `議会id` varchar(20) NOT NULL,
  `議会テーブル内id` varchar(3) DEFAULT NULL,
  `議会名` varchar(50) DEFAULT NULL,
  `開会時間` datetime NOT NULL,
  `閉会時間` datetime NOT NULL,
  `休憩開始` datetime DEFAULT NULL,
  `休憩終了` datetime DEFAULT NULL,
  PRIMARY KEY (`議会id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `議会内議案`
--

CREATE TABLE IF NOT EXISTS `議会内議案` (
  `議会id` varchar(20) NOT NULL,
  `議会内議案テーブル内id` varchar(3) NOT NULL,
  `議案id` varchar(20) NOT NULL,
  PRIMARY KEY (`議会id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `議員`
--

CREATE TABLE IF NOT EXISTS `議員` (
  `議員id` varchar(15) NOT NULL,
  `議員名` varchar(20) NOT NULL,
  `フリガナ` varchar(20) NOT NULL,
  `性別` varchar(1) NOT NULL,
  `年齢` varchar(3) NOT NULL,
  `党派` varchar(30) NOT NULL,
  PRIMARY KEY (`議員id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `議案`
--

CREATE TABLE IF NOT EXISTS `議案` (
  `議案id` varchar(20) NOT NULL,
  `議案名` varchar(150) NOT NULL,
  `委員会付託` varchar(1) NOT NULL,
  `提出議案種類` varchar(20) NOT NULL,
  PRIMARY KEY (`議案id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `賛否`
--

CREATE TABLE IF NOT EXISTS `賛否` (
  `議員id` varchar(15) NOT NULL,
  `議会id` varchar(20) NOT NULL,
  `賛否` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`議員id`,`議会id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
