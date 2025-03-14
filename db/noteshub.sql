-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2025 at 06:07 PM
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
-- Database: `noteshub`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`) VALUES
(3, 'admin@noteshub.com', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notes_title` varchar(255) NOT NULL,
  `notes_subject` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `pdf` varchar(255) DEFAULT NULL,
  `view_count` int(11) DEFAULT 0,
  `dwnld_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `download_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `user_id`, `notes_title`, `notes_subject`, `description`, `pdf`, `view_count`, `dwnld_count`, `created_at`, `download_count`) VALUES
(1, 1, 'Introduction to JavaScript', 'JavaScript', 'This beginner-friendly guide explores the core concepts of JavaScript, such as variables, operators, functions, loops, and event handling. It provides a solid foundation for building interactive web applications.', '1741885677_file-sample_150kB.pdf', 0, 0, '2025-03-13 17:07:57', 0),
(2, 1, 'Mastering React Components', 'React.js Development', 'A comprehensive guide to understanding and building React components, including functional and class components, props, state management, hooks, lifecycle methods, and best practices for creating scalable and maintainable applications.', '1741885746_file-sample_150kB.pdf', 0, 0, '2025-03-13 17:09:06', 0),
(3, 2, 'React Components Guide', 'React.js Development', 'This guide provides an in-depth overview of React components, covering functional and class components, props, state management, lifecycle methods, hooks, and best practices for building efficient and reusable UI components.', '1741885822_file-sample_150kB.pdf', 0, 1, '2025-03-13 17:10:22', 0),
(5, 2, 'JavaScript Basics', 'JavaScript', 'This guide covers the fundamental concepts of JavaScript, including variables, data types, functions, loops, conditionals, and basic DOM manipulation. It serves as a foundation for beginners to understand and start coding in JavaScript.', '1741961314_file-sample_150kB.pdf', 0, 2, '2025-03-13 17:53:52', 0),
(6, 1, 'JavaScript Fundamentals', 'JavaScript', 'Learn the essential building blocks of JavaScript, including syntax, data types, control structures, functions, and basic DOM interactions. This guide is perfect for beginners looking to start their JavaScript journey.', '1741967895_file-sample_150kB.pdf', 0, 0, '2025-03-14 15:58:15', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `profile_picture`) VALUES
(1, 'Antonyrahul', 'rah@gmail.com', '$2y$10$nQdorQdJ4V6l23kI.njka.2JvaHaQlCSUZi40cWNBZeYAJPj6GkVG', NULL),
(2, 'Johnson', 'john@gmail.com', '$2y$10$VwHGbDQM5qJrQAw0oWkUh.ZTvJtPr7GeMNuel8D44RuaxHYbtjeaS', 'uploads/5677.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
