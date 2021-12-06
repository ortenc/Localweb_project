-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2021 at 02:52 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testing`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_message`
--

CREATE TABLE `chat_message` (
  `chat_message_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `chat_message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login_details`
--

CREATE TABLE `login_details` (
  `login_details_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_type` enum('no','yes') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_details`
--

INSERT INTO `login_details` (`login_details_id`, `user_id`, `last_activity`, `is_type`) VALUES
(1, 517, '2021-12-06 13:26:52', 'no'),
(2, 517, '2021-12-06 13:27:09', 'no'),
(3, 517, '2021-12-06 13:32:17', 'no'),
(4, 517, '2021-12-06 13:32:31', 'no'),
(5, 517, '2021-12-06 13:33:58', 'no'),
(6, 517, '2021-12-06 13:34:25', 'no'),
(7, 517, '2021-12-06 13:34:47', 'no'),
(8, 517, '2021-12-06 13:35:31', 'no'),
(9, 517, '2021-12-06 13:35:40', 'no'),
(10, 516, '2021-12-06 13:38:04', 'no'),
(11, 510, '2021-12-06 13:41:12', 'no'),
(12, 516, '2021-12-06 13:41:32', 'no'),
(13, 516, '2021-12-06 13:43:07', 'no'),
(14, 510, '2021-12-06 13:43:32', 'no'),
(15, 518, '2021-12-06 13:44:34', 'no'),
(16, 516, '2021-12-06 13:44:49', 'no'),
(17, 516, '2021-12-06 13:45:06', 'no'),
(18, 510, '2021-12-06 13:45:12', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` enum('Admin','User') NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `photo` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `surname`, `email`, `password`, `gender`, `photo`) VALUES
(510, 'Admin', 'asds', 'asdsd', 'asd31@3.com', '$2y$10$NyxLIClfmUTMBHS4U6E9QO9QtVnu0AFdml2TpOHBKcDKtyENRxT6i', 'male', ''),
(516, 'User', '1', '1', '1@1.com', '$2y$10$Y4YwcKud/Q.Z67jF/F1PT.KfSZpqLi4L3VUiQg93JN.7X85A3JJhC', 'male', 'photos/asdad.jpg'),
(518, 'User', '2', '2', '2@2.com', '$2y$10$zc5leJt/GQds5dW0ApvtD.APJwBhPDD3/MsGMeLrRb5s9NKbf2/b2', 'male', 'photos/download.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`chat_message_id`);

--
-- Indexes for table `login_details`
--
ALTER TABLE `login_details`
  ADD PRIMARY KEY (`login_details_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_details`
--
ALTER TABLE `login_details`
  MODIFY `login_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=519;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
