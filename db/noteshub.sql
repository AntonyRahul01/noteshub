-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2025 at 04:09 PM
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

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(6, 'AntonyRahul', 'antonyrahul2001@gmail.com', 'Good', '2025-03-14 17:11:19');

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
(5, 2, 'JavaScript Basics', 'JavaScript', 'This guide covers the fundamental concepts of JavaScript, including variables, data types, functions, loops, conditionals, and basic DOM manipulation. It serves as a foundation for beginners to understand and start coding in JavaScript.', '1741961314_file-sample_150kB.pdf', 2, 3, '2025-03-13 17:53:52', 0),
(6, 1, 'JavaScript Fundamentals', 'JavaScript', 'Learn the essential building blocks of JavaScript, including syntax, data types, control structures, functions, and basic DOM interactions. This guide is perfect for beginners looking to start their JavaScript journey.', '1741967895_file-sample_150kB.pdf', 1, 1, '2025-03-14 15:58:15', 0),
(10, 2, 'Database Management with MySQL', 'Database Management', 'Learn how to create, manage, and optimize databases using MySQL. This guide covers SQL queries, data relationships, indexing, and best practices for efficient data handling.', '1742045311_file-sample_150kB.pdf', 0, 0, '2025-03-15 13:28:31', 0),
(11, 2, 'Cloud Computing with AWS', 'Cloud Computing', 'Get an introduction to cloud computing with AWS, covering core services like EC2, S3, Lambda, and DynamoDB, along with practical use cases for scalable applications.', '1742045341_file-sample_150kB.pdf', 0, 0, '2025-03-15 13:29:01', 0),
(12, 2, 'Introduction to React.js', 'Frontend Development', 'Explore the basics of React.js, a popular JavaScript library for building dynamic user interfaces. Learn about components, state management, hooks, and API integration.', '1742045366_file-sample_150kB.pdf', 0, 0, '2025-03-15 13:29:26', 0),
(13, 2, 'Introduction to Cybersecurity', 'Cybersecurity', 'Explore key cybersecurity concepts, including encryption, authentication, network security, and best practices to protect applications from cyber threats.', '1742045437_file-sample_150kB.pdf', 0, 0, '2025-03-15 13:30:37', 0),
(14, 1, 'Getting Started with PHP and MySQL', 'Web Development', 'Learn the fundamentals of PHP and MySQL, including syntax, database connections, and basic CRUD operations for building dynamic websites.', '1742045566_file-sample_150kB.pdf', 0, 0, '2025-03-15 13:32:46', 0),
(15, 1, 'File Upload and Management System in PHP and MySQL', 'Web Applications', 'Develop a file upload system with PHP and MySQL, implementing security measures, validation, and file management techniques.', '1742045622_file-sample_150kB.pdf', 0, 0, '2025-03-15 13:33:42', 0),
(16, 1, 'Java Programming for Beginners', 'Java Development', 'Learn the fundamentals of Java programming, including object-oriented concepts, data structures, exception handling, and file management to build robust applications.', '1742045718_file-sample_150kB.pdf', 0, 0, '2025-03-15 13:35:18', 0),
(17, 1, 'Operational Research: An Introduction', 'Operational Research', 'Explore the basics of operational research, including linear programming, decision analysis, and optimization techniques for better decision-making in business and industries.', '1742045753_file-sample_150kB.pdf', 0, 0, '2025-03-15 13:35:53', 0);

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
(1, 'Antonyrahul', 'rah@gmail.com', '$2y$10$nQdorQdJ4V6l23kI.njka.2JvaHaQlCSUZi40cWNBZeYAJPj6GkVG', 'uploads/5677.jpg'),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
