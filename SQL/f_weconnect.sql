-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2022 at 05:56 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `f_weconnect`
--

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `from_send_notification_user_id` int(11) DEFAULT NULL,
  `to_receive_notification_user_id` int(11) DEFAULT NULL,
  `notification_name` varchar(1000) DEFAULT NULL,
  `notification_read_status` int(11) NOT NULL DEFAULT 0,
  `notification_date_time` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `from_send_notification_user_id`, `to_receive_notification_user_id`, `notification_name`, `notification_read_status`, `notification_date_time`) VALUES
(199, 2, 1, '<b>Sayandeep Barai</b> Send a Friend Request To You.', 1, '1654523074'),
(200, 1, 2, '<b>Tathagata Bandyopadhyay</b> Accept Your Friend Request.', 1, '1654523076');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_si_no` int(11) NOT NULL,
  `post_id` varchar(500) NOT NULL,
  `post_message` longtext DEFAULT NULL,
  `post_img_name` longtext DEFAULT NULL,
  `post_privacy` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `post_timestamp` varchar(40) NOT NULL,
  `like_` int(11) NOT NULL DEFAULT 0,
  `love` int(11) NOT NULL DEFAULT 0,
  `care` int(11) NOT NULL DEFAULT 0,
  `haha` int(11) NOT NULL DEFAULT 0,
  `wow` int(11) NOT NULL DEFAULT 0,
  `sad` int(11) NOT NULL DEFAULT 0,
  `angry` int(11) NOT NULL DEFAULT 0,
  `total_rection_count` int(11) NOT NULL DEFAULT 0,
  `total_comment_in_post` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_si_no`, `post_id`, `post_message`, `post_img_name`, `post_privacy`, `user_id`, `post_timestamp`, `like_`, `love`, `care`, `haha`, `wow`, `sad`, `angry`, `total_rection_count`, `total_comment_in_post`) VALUES
(273, '1654540167_35777_82357_27', 'Hi everyone,<div></div>WeConnect is The Social Network Sites.<img alt=\"👍🏼\" class=\"emojioneemoji\" src=\"https://cdn.jsdelivr.net/emojione/assets/3.1/png/32/1f44d-1f3fc.png\"><img alt=\"👍🏼\" class=\"emojioneemoji\" src=\"https://cdn.jsdelivr.net/emojione/assets/3.1/png/32/1f44d-1f3fc.png\">', '1654540167_8853_login.png,1654540167_1226_post_home.png,1654540167_1809_post_set.png,1654540167_6768_signup.png,1654540167_4895_view Profile.png,1654540167_4000_watch.png', 'public', 1, '1654540167', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(274, '1654540199_79736_64996_59', 'Chants for Radiant Living Video <img alt=\"☺️\" class=\"emojioneemoji\" src=\"https://cdn.jsdelivr.net/emojione/assets/3.1/png/32/263a.png\"><img alt=\"☺️\" class=\"emojioneemoji\" src=\"https://cdn.jsdelivr.net/emojione/assets/3.1/png/32/263a.png\">', '1654540199_2474_Chants for Radiant Living.mp4', 'public', 1, '1654540199', 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `post_comment`
--

CREATE TABLE `post_comment` (
  `comment_si_no` int(11) NOT NULL,
  `comment_id` varchar(500) NOT NULL,
  `comment_description` longtext DEFAULT NULL,
  `post_id` varchar(500) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_time` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `request_friend`
--

CREATE TABLE `request_friend` (
  `request_friend_id` int(11) NOT NULL,
  `from_user_id` int(11) DEFAULT NULL,
  `to_user_id` int(11) DEFAULT NULL,
  `action_name` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request_friend`
--

INSERT INTO `request_friend` (`request_friend_id`, `from_user_id`, `to_user_id`, `action_name`) VALUES
(241, 2, 1, 'friends'),
(242, 1, 2, 'friends');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `last_login` bigint(20) NOT NULL DEFAULT 0,
  `user_email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `dob` varchar(20) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `image_type` varchar(10) DEFAULT 'text',
  `profile_image` varchar(500) DEFAULT NULL,
  `cover_photo` varchar(5000) NOT NULL DEFAULT 'default.jpg',
  `total_friends` bigint(14) NOT NULL DEFAULT 0,
  `use_message_send_status` varchar(100) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `last_login`, `user_email`, `password`, `dob`, `gender`, `image_type`, `profile_image`, `cover_photo`, `total_friends`, `use_message_send_status`) VALUES
(1, 'Tathagata Bandyopadhyay', 1654540333, 'tathagata.bandyo@gmail.com', '19f6ad0cdcffee21cb5f9114c85803ba', '2000-04-14', 'Male', 'image', '9388_1654513856_3551_1654316429_tathagata.jpg', '1797_1654316150_Enrique_Simonet_-_Marina_veneciana_6MB.jpg', 1, '0'),
(2, 'Sayandeep Barai', 1654530688, 'sayandeepbarai2587@gmail.com', '19f6ad0cdcffee21cb5f9114c85803ba', '2000-09-03', 'Male', 'text', NULL, 'default.jpg', 1, '0'),
(3, 'Demo Testing', 0, 'jontyba2000@gmail.com', '828fd9255753432d51df95eb62d61722', '1998-05-26', 'Male', 'image', '438_1652458162_Screenshot (18).png', 'default.jpg', 0, '0'),
(4, 'Pranab Pal', 1654527956, 'pranabpal349@gmail.com', '19f6ad0cdcffee21cb5f9114c85803ba', '1999-01-01', 'Male', 'text', NULL, 'default.jpg', 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `user_message`
--

CREATE TABLE `user_message` (
  `message_si_no` int(11) NOT NULL,
  `message_id` varchar(500) NOT NULL,
  `message` longtext DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `img_video_or_doc_name_s` longtext DEFAULT NULL,
  `document_name` longtext DEFAULT NULL,
  `message_time` varchar(100) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_message`
--

INSERT INTO `user_message` (`message_si_no`, `message_id`, `message`, `type`, `img_video_or_doc_name_s`, `document_name`, `message_time`, `sender_id`, `receiver_id`) VALUES
(87, '1654526300_50390_46682_20', 'hi', 'message', NULL, NULL, '1654526300', 2, 4),
(88, '1654526303_57405_72088_23', 'hello', 'message', NULL, NULL, '1654526303', 2, 4),
(89, '1654526310_43166_21809_30', NULL, 'documents', '1654526310_1547_1653305267_3130_DFD1.jpg,1654526310_9723_1653305267_5984_5.pptx', '1653305267_3130_DFD1.jpg,1653305267_5984_5.pptx', '1654526310', 2, 4),
(90, '1654526319_111161_5857_39', NULL, 'images_videos', '1654526319_6166_1653305267_3130_DFD1.jpg,1654526319_6347_1653305267_8240_DFD0.jpg,1654526319_9763_1653307203_7728_1652702164_6329_video2.mp4,1654526319_4406_1653307785_3843_1651770510_9949_Screenshot_20220415-202246_Chrome.jpg', NULL, '1654526319', 4, 2),
(91, '1654540210_100802_27941_10', 'Hi', 'message', NULL, NULL, '1654540210', 1, 2),
(92, '1654540218_131350_64329_18', NULL, 'documents', '1654540218_5484_5.pptx', '5.pptx', '1654540218', 1, 2),
(93, '1654540227_51402_41991_27', NULL, 'images_videos', '1654540227_5148_First Computer Game.mp4,1654540227_1689_login.png', NULL, '1654540227', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_rection_in_post`
--

CREATE TABLE `user_rection_in_post` (
  `user_rection_in_post_id` int(11) NOT NULL,
  `post_id` varchar(500) DEFAULT NULL,
  `rection_type` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `from_send_notification_user_id` (`from_send_notification_user_id`),
  ADD KEY `to_receive_notification_user_id` (`to_receive_notification_user_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD UNIQUE KEY `post_si_no` (`post_si_no`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `post_comment`
--
ALTER TABLE `post_comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD UNIQUE KEY `comment_si_no` (`comment_si_no`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `request_friend`
--
ALTER TABLE `request_friend`
  ADD PRIMARY KEY (`request_friend_id`),
  ADD KEY `from_user_id` (`from_user_id`),
  ADD KEY `to_user_id` (`to_user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_message`
--
ALTER TABLE `user_message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `message_si_no` (`message_si_no`);

--
-- Indexes for table `user_rection_in_post`
--
ALTER TABLE `user_rection_in_post`
  ADD PRIMARY KEY (`user_rection_in_post_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_si_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=275;

--
-- AUTO_INCREMENT for table `post_comment`
--
ALTER TABLE `post_comment`
  MODIFY `comment_si_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `request_friend`
--
ALTER TABLE `request_friend`
  MODIFY `request_friend_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_message`
--
ALTER TABLE `user_message`
  MODIFY `message_si_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `user_rection_in_post`
--
ALTER TABLE `user_rection_in_post`
  MODIFY `user_rection_in_post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`from_send_notification_user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`to_receive_notification_user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `post_comment`
--
ALTER TABLE `post_comment`
  ADD CONSTRAINT `post_comment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`),
  ADD CONSTRAINT `post_comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `request_friend`
--
ALTER TABLE `request_friend`
  ADD CONSTRAINT `request_friend_ibfk_1` FOREIGN KEY (`from_user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `request_friend_ibfk_2` FOREIGN KEY (`to_user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `user_message`
--
ALTER TABLE `user_message`
  ADD CONSTRAINT `user_message_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `user_message_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `user_rection_in_post`
--
ALTER TABLE `user_rection_in_post`
  ADD CONSTRAINT `user_rection_in_post_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`),
  ADD CONSTRAINT `user_rection_in_post_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
