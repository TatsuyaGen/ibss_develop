-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2020 年 12 月 25 日 15:32
-- サーバのバージョン： 10.4.17-MariaDB
-- PHP のバージョン: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `ibss`
--
CREATE DATABASE IF NOT EXISTS `ibss` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ibss`;

-- --------------------------------------------------------

--
-- テーブルの構造 `menutable`
--

CREATE TABLE `menutable` (
  `productname` varchar(200) NOT NULL,
  `category` varchar(200) NOT NULL,
  `value` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `ownerinfo`
--

CREATE TABLE `ownerinfo` (
  `id` int(250) NOT NULL,
  `password` varchar(200) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `ownerinfo`
--

INSERT INTO `ownerinfo` (`id`, `password`) VALUES
(0, 'pass');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `menutable`
--
ALTER TABLE `menutable`
  ADD PRIMARY KEY (`productname`);

--
-- テーブルのインデックス `ownerinfo`
--
ALTER TABLE `ownerinfo`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
