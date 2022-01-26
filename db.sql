-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 26, 2022 at 11:27 PM
-- Server version: 5.7.32
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment` varchar(256) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `post_id`, `comment`, `created_at`) VALUES
(204, 6, 56, 'good', '2021-11-30 14:00:02'),
(205, 6, 63, 'good', '2021-11-30 14:15:58'),
(206, 6, 64, 'good', '2021-11-30 14:35:59'),
(207, 6, 64, 'good', '2021-12-01 12:36:49'),
(208, 6, 60, 'good', '2021-12-12 02:04:54'),
(209, 6, 57, 'good', '2022-01-12 09:35:50'),
(210, 6, 66, 'good', '2022-01-17 07:06:48');

-- --------------------------------------------------------

--
-- Table structure for table `like`
--

CREATE TABLE `like` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `like`
--

INSERT INTO `like` (`id`, `user_id`, `post_id`) VALUES
(300, 6, 48),
(306, 6, 56),
(308, 6, 63),
(320, 6, 60),
(322, 6, 64),
(323, 6, 58),
(326, 6, 66);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `producer_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `item` varchar(250) NOT NULL,
  `comment` varchar(250) NOT NULL,
  `cooking` varchar(250) NOT NULL,
  `main_item` varchar(50) NOT NULL,
  `main_image` varchar(255) NOT NULL,
  `check1` int(11) DEFAULT NULL,
  `check2` int(11) DEFAULT NULL,
  `check3` int(11) DEFAULT NULL,
  `check4` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `like_count` int(11) DEFAULT '0',
  `del_flg` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `producer_id`, `title`, `image`, `item`, `comment`, `cooking`, `main_item`, `main_image`, `check1`, `check2`, `check3`, `check4`, `created_at`, `like_count`, `del_flg`) VALUES
(57, 9, 'カレー（１人前）', '20211130230920post1.jpeg', 'カレールー・・・１個\r\nにんじん・・・1/2個\r\n玉ねぎ・・・1/2個\r\nじゃがいも・・・１個\r\n豚肉・・・１００g', '基本的なカレーです。じゃがいもは我々が生産している甘味がしっかりとしたじゃがいもを使用しています。', '１　肉と野菜を一口大に切ります。\r\n２　中火で肉を炒めます。\r\n３　野菜を加えます。\r\n４　火が通ったら水を加えて２０分煮込みます。\r\n５　ルーを加えて溶かしながら１０分煮込んで完成です。', 'じゃがいも', '20211130230920i1.jpeg', NULL, NULL, 1, NULL, '2021-11-30 23:09:20', 0, 0),
(58, 9, 'ポテトチップス', '20211130231021post2.jpeg', 'テスト', 'テスト', 'テスト', 'じゃがいも', '20211130231021i1.jpeg', NULL, NULL, 1, NULL, '2021-11-30 23:10:21', 1, 0),
(59, 10, 'ステーキ', '20211130231139post5.jpeg', 'テスト', 'テスト', 'テスト', '牛肉', '20211130231139i2.jpeg', NULL, NULL, 1, NULL, '2021-11-30 23:11:39', 0, 0),
(60, 10, 'ハンバーグ', '20211130231222post7.jpeg', 'テスト', 'テスト', 'テスト', '牛肉', '20211130231222i2.jpeg', NULL, NULL, 1, NULL, '2021-11-30 23:12:22', 1, 0),
(61, 11, 'オムライス', '20211130231310post9.jpeg', 'テスト', 'テスト', 'テスト', '米', '20211130231310i3.jpeg', 1, NULL, NULL, NULL, '2021-11-30 23:13:10', 0, 0),
(62, 11, '焼飯', '20211130231354post10.jpeg', 'テスト', 'テスト', 'テスト', '米', '20211130231354i3.jpeg', 1, NULL, NULL, NULL, '2021-11-30 23:13:54', 0, 0),
(63, 9, 'ポテトサラダ', '20211130231515test.jpeg', 'テスト', 'テスト', 'テスト\r\nテスト', 'じゃがいも', '20211130231515i1.jpeg', NULL, NULL, 1, NULL, '2021-11-30 23:15:15', 1, 1),
(64, 9, 'ポテトサラダ', '20211130233521test.jpeg', 'テスト', 'テスト', 'テスト\r\nテスト', 'じゃがいも', '20211130233521i1.jpeg', NULL, NULL, 1, NULL, '2021-11-30 23:35:21', 1, 1),
(65, 9, 'ポテトサラダ', '20220112183709test.jpeg', 'あああ', 'あああ', 'あああ', 'じゃがいも', '20220112183709i1.jpeg', NULL, NULL, 1, NULL, '2022-01-12 18:37:09', 0, 1),
(66, 9, 'ポテトサラダ', '20220117160547test.jpeg', 'あ', 'あ', 'あ', 'じゃがいも', '20220117160547i1.jpeg', NULL, NULL, 1, NULL, '2022-01-17 16:05:47', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `producer`
--

CREATE TABLE `producer` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `pr` varchar(250) NOT NULL,
  `image` varchar(255) NOT NULL,
  `url` varchar(2000) DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `producer`
--

INSERT INTO `producer` (`id`, `name`, `email`, `password`, `pr`, `image`, `url`, `role`) VALUES
(9, '生産者A', 'p1@gmail.com', '$2y$10$KXj6.t5wDM6V9v5RoKCA7uX9GHTComb8GQsBRvb0.3BQ82XVEXV66', 'Aです', '20211128192057p1.jpeg', 'https://www.tabechoku.com/', 1),
(10, '生産者B', 'p2@gmail.com', '$2y$10$lqstGGbPezJLO1nkxIDlUejAIHPVIJg9Inrx4gkOe1JL0Q6ot6jcS', '。。。。', '20211128195340p2.jpeg', '', 1),
(11, '生産者C', 'p3@gmail.com', '$2y$10$GLcDSRzK1yaNzMwS7WNUAORi.MaqahGvN8DGX8l0Nv/HyagTZjtQO', '...', '20211128201154p3.jpeg', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `role`) VALUES
(6, 'ユーザーA', 'u1@gmail.com', '$2y$10$8H9QpEMoB5RQAaIYiVhrTOIt/5ozZXpZDws8Ny5uc.3uUKuAEih2y', 0),
(7, 'ユーザーB', 'u2@gmail.com', '$2y$10$9Yrm3D/iFKZtnL9rADSI2uchgZMpxninrDIAQgiSq1o1Xsph6tKUW', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `like`
--
ALTER TABLE `like`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `file_name` (`image`),
  ADD UNIQUE KEY `image` (`image`),
  ADD UNIQUE KEY `main_image` (`main_image`);

--
-- Indexes for table `producer`
--
ALTER TABLE `producer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `image` (`image`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- AUTO_INCREMENT for table `like`
--
ALTER TABLE `like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=327;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `producer`
--
ALTER TABLE `producer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
