-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2023 at 06:25 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brbd`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(200) NOT NULL,
  `category_status` enum('Enable','Disable') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_status`) VALUES
(2, 'Programming', 'Enable'),
(3, 'Research', 'Enable'),
(10, 'Deep Learning', 'Enable'),
(12, 'Formatting', 'Enable'),
(14, 'Engineering', 'Enable');

-- --------------------------------------------------------

--
-- Table structure for table `category_to_courses`
--

CREATE TABLE `category_to_courses` (
  `course_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `category_to_courses`
--

INSERT INTO `category_to_courses` (`course_id`, `category_id`) VALUES
(1, 2),
(1, 3),
(2, 3),
(79, 2);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_title` varchar(500) NOT NULL,
  `course_author` int(10) NOT NULL,
  `course_status` enum('Publish','Pending','Draft') NOT NULL,
  `course_created` date NOT NULL DEFAULT current_timestamp(),
  `course_photo` varchar(100) NOT NULL,
  `course_info` longtext NOT NULL,
  `course_level` enum('Beginner','Intermadiate','Expert') DEFAULT NULL,
  `course_duration` varchar(10) NOT NULL,
  `course_materials` text NOT NULL,
  `course_requirements` text NOT NULL,
  `course_learning` text NOT NULL,
  `featured_video` text NOT NULL,
  `course_certificate` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_title`, `course_author`, `course_status`, `course_created`, `course_photo`, `course_info`, `course_level`, `course_duration`, `course_materials`, `course_requirements`, `course_learning`, `featured_video`, `course_certificate`) VALUES
(1, 'LATEX', 1, 'Publish', '2023-07-01', 'img/Learn-LateX.jpg', '<p><strong>LaTeX</strong> is a software system for document preparation. When writing, the writer uses plain text as opposed to the formatted text found in WYSIWYG word processors like <em>Microsoft Word, LibreOffice Writer </em>and<em> Apple Pages</em>.</p>\r\n', 'Beginner', '80', '4 Topics\r\n12 Videos\r\n5 PDF\r\n4 Quiz', 'Passion to research\r\nPatience', 'What is Research & Why\r\nType of Research', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/Ra6vA6-GbiI\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', 'img/certificate4.png'),
(2, 'Studying Research Paper', 4, 'Publish', '2023-07-01', 'img/4.jpg', '', 'Beginner', '130', '', '', '', '', ''),
(79, 'Python Programming', 1, 'Draft', '2023-07-05', 'img/d1326ca6cca8038cd115a061b4e2b3bc-840x430.png', '', 'Beginner', '60', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `course_enrolled`
--

CREATE TABLE `course_enrolled` (
  `enrolled_id` int(11) NOT NULL,
  `student_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `enrolled_status` enum('Enrolled','Running','Completed') NOT NULL,
  `enrolled_date` date NOT NULL DEFAULT current_timestamp(),
  `certificate_id` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `course_enrolled`
--

INSERT INTO `course_enrolled` (`enrolled_id`, `student_id`, `course_id`, `enrolled_status`, `enrolled_date`, `certificate_id`) VALUES
(21, 4, 1, 'Enrolled', '2023-07-20', '');

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `instructor_id` int(11) NOT NULL,
  `instructor_name` varchar(100) NOT NULL,
  `instructor_email` varchar(100) NOT NULL,
  `commission_rate` int(5) NOT NULL,
  `instructor_status` enum('Approved','Pending','Draft') NOT NULL,
  `instructor_photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`instructor_id`, `instructor_name`, `instructor_email`, `commission_rate`, `instructor_status`, `instructor_photo`) VALUES
(1, 'Himel Chakma', 'himelchakma55@gmail.com', 80, 'Approved', 'img/101.jpg'),
(4, 'Bishal Chakma', 'bishalchakma@gmail.com', 70, 'Pending', 'img/615994282.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `material_id` int(11) NOT NULL,
  `material_name` varchar(100) NOT NULL,
  `material_type` enum('Video Lesson','Power Point Slide','YouTube Video') NOT NULL,
  `material_link` varchar(500) NOT NULL,
  `topic_id` int(10) NOT NULL,
  `material_info` text NOT NULL,
  `video_duration` double(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`material_id`, `material_name`, `material_type`, `material_link`, `topic_id`, `material_info`, `video_duration`) VALUES
(32, 'What is Research & Why', 'YouTube Video', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/J9j7tGNzA3o\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', 70, 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Accusantium aperiam quasi possimus beatae, tempore corporis sed, dolores adipisci a nemo saepe reprehenderit eum aliquid maxime corrupti dolorem dolor nobis porro.', 2554.000),
(33, 'Type of Research', 'YouTube Video', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/nDSTyWhe2Aw\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', 71, 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Accusantium aperiam quasi possimus beatae, tempore corporis sed, dolores adipisci a nemo saepe reprehenderit eum aliquid maxime corrupti dolorem dolor nobis porro.', 1652.000),
(34, 'How to read Research Paper', 'YouTube Video', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/3FJ0RTBw4tM\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', 73, '', 881.000),
(35, 'Way to find good Research Paper', 'YouTube Video', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/QAUfuu_1Hhs\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', 73, '', 2828.000),
(36, 'How to detect fake journal', 'YouTube Video', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/XRgpEPnZwPM\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', 74, '', 656.000),
(37, 'Rules of Writing Literature Review', 'YouTube Video', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/KL8AghDVA_Y\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', 70, '', 2413.000),
(38, 'Lesson 1', 'YouTube Video', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/Ra6vA6-GbiI\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', 72, '', 782.000);

-- --------------------------------------------------------

--
-- Table structure for table `material_status_table`
--

CREATE TABLE `material_status_table` (
  `material_status` enum('incomplete','complete') NOT NULL,
  `material_status_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `enrolled_id` int(11) NOT NULL,
  `material_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `material_status_table`
--

INSERT INTO `material_status_table` (`material_status`, `material_status_id`, `material_id`, `enrolled_id`, `material_type`) VALUES
('complete', 33, 32, 21, 'YouTube Video'),
('complete', 34, 33, 21, 'YouTube Video'),
('complete', 35, 37, 21, 'YouTube Video'),
('complete', 36, 38, 21, 'YouTube Video'),
('complete', 37, 49, 21, 'quiz'),
('complete', 38, 51, 21, 'quiz'),
('complete', 39, 52, 21, 'quiz');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `option_id` int(11) NOT NULL,
  `option_title` varchar(100) NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`option_id`, `option_title`, `question_id`) VALUES
(88, 'C', 25),
(89, 'C++', 25),
(90, 'HTML', 25),
(91, 'Javascript', 25),
(92, '1990', 26),
(93, '1991', 26),
(94, '1992', 26),
(95, '1993', 26),
(96, 'Denis Richi', 27),
(97, 'De Morgan', 27),
(98, 'Tim Barnars Lee', 27),
(99, 'Alan Turing', 27),
(100, 'Complier', 28),
(101, 'Assembler', 28),
(102, 'Interpreter', 28),
(103, 'None of the above', 28),
(104, 'Hyper Text Marking Language', 29),
(105, 'Hyper Text Markup Language', 29),
(106, 'Hyper Text Marking Link', 29),
(107, 'Hyper Text Markup Link', 29),
(108, 'Compiler', 30),
(109, 'Assembler', 30),
(110, 'Interpreter', 30),
(111, 'None of the above', 30),
(112, 'Programming Language', 31),
(113, 'Markup Language', 31),
(114, 'Style sheet', 31),
(115, 'An Animal', 31),
(116, 'Operating System', 32),
(117, 'Oracle System', 32),
(118, 'Optimum Solution', 32),
(119, 'Optimized Solution', 32),
(120, 'Dijkstra Algorithm', 33),
(121, 'Belmand Ford', 33),
(122, 'Shanon Algorithm', 33),
(123, 'Bankers Algorithm', 33);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `question` varchar(100) NOT NULL,
  `correct_option` varchar(100) NOT NULL,
  `quiz_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question`, `correct_option`, `quiz_id`) VALUES
(25, 'Which is not a programming language?', 'HTML', 49),
(26, 'When was Python first arrived?', '1991', 49),
(27, 'Who invented HTML?', 'Tim Barnars Lee', 49),
(28, 'Which translates the Python Code?', 'Interpreter', 50),
(29, 'What is the full meaning of HTML?', 'Hyper Text Markup Language', 51),
(30, 'Which translates the Python Code?', 'Interpreter', 51),
(31, 'Python is a -', 'Programming Language', 51),
(32, 'What does OS stand for?', 'Operating System', 52),
(33, 'Which algorithm is used to find deadlock?', 'Bankers Algorithm', 52);

-- --------------------------------------------------------

--
-- Table structure for table `quizes`
--

CREATE TABLE `quizes` (
  `quiz_id` int(11) NOT NULL,
  `quiz_title` varchar(100) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `quiz_duration` int(10) NOT NULL,
  `passing_percentage` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `quizes`
--

INSERT INTO `quizes` (`quiz_id`, `quiz_title`, `topic_id`, `quiz_duration`, `passing_percentage`) VALUES
(49, 'Quiz 1', 70, 2, 80),
(50, 'Quiz 1', 73, 0, 0),
(51, 'Quiz 1', 71, 10, 80),
(52, 'Quiz 1', 72, 5, 80);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_participation`
--

CREATE TABLE `quiz_participation` (
  `participation_id` int(11) NOT NULL,
  `student_id` int(10) NOT NULL,
  `question_id` int(10) DEFAULT NULL,
  `answered_option` varchar(100) DEFAULT NULL,
  `quiz_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `quiz_participation`
--

INSERT INTO `quiz_participation` (`participation_id`, `student_id`, `question_id`, `answered_option`, `quiz_id`) VALUES
(119, 4, 29, 'Hyper Text Markup Language', 51),
(120, 4, 30, 'Interpreter', 51),
(121, 4, 31, 'Programming Language', 51),
(122, 4, 32, 'Operating System', 52),
(123, 4, 33, 'Bankers Algorithm', 52);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `student_user_name` varchar(100) NOT NULL,
  `student_email` varchar(100) NOT NULL,
  `student_password` varchar(100) NOT NULL,
  `student_first_name` varchar(100) NOT NULL,
  `student_last_name` varchar(100) NOT NULL,
  `registered_on` date NOT NULL DEFAULT current_timestamp(),
  `student_skill` text NOT NULL DEFAULT '-',
  `student_interests` text NOT NULL DEFAULT '-',
  `student_photo` varchar(100) NOT NULL,
  `student_mobile` varchar(15) NOT NULL DEFAULT '-',
  `student_biography` text NOT NULL DEFAULT '\'-\'',
  `facebook_id` varchar(100) NOT NULL DEFAULT '-',
  `linkedin_id` varchar(100) NOT NULL DEFAULT '-',
  `website` varchar(100) NOT NULL DEFAULT '-',
  `github_id` varchar(100) NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_user_name`, `student_email`, `student_password`, `student_first_name`, `student_last_name`, `registered_on`, `student_skill`, `student_interests`, `student_photo`, `student_mobile`, `student_biography`, `facebook_id`, `linkedin_id`, `website`, `github_id`) VALUES
(4, 'Himel ', 'himelchakma55@gmail.com', 'himelhimu98', 'Himel', 'Chakma', '2023-07-11', 'Programming Languages: C, C++, Java, PHP', '-', 'img/User-Avatar-in-Suit-PNG.png', '01704459694', 'I am an undergraduate student of Chittagong University of Engineering Technology', '-', '-', '-', '-'),
(5, 'Alam', 'abc@gmail.com', 'alam', 'Md Alam', 'Miah', '2023-07-11', '', '', '', '', '', '-', '-', '-', '-');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `topic_id` int(11) NOT NULL,
  `topic_name` varchar(100) NOT NULL,
  `course_id` int(11) NOT NULL,
  `topic_serial` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `topic_name`, `course_id`, `topic_serial`) VALUES
(70, 'Introduction', 1, 1),
(71, 'Topic 2', 1, 2),
(72, 'Topic 3', 1, 3),
(73, 'Topic 1', 2, 1),
(74, 'Topic 2', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `topic_unlock`
--

CREATE TABLE `topic_unlock` (
  `topic_serial` int(11) NOT NULL,
  `enrolled_id` int(11) NOT NULL,
  `unlock_status` enum('Locked','Unlocked') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `topic_unlock`
--

INSERT INTO `topic_unlock` (`topic_serial`, `enrolled_id`, `unlock_status`) VALUES
(1, 21, 'Unlocked'),
(2, 21, 'Unlocked'),
(3, 21, 'Unlocked');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_type`) VALUES
(1, 'Himel Chakma', 'himelchakma55@gmail.com', 'himelhimu98', 'Master');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `category_to_courses`
--
ALTER TABLE `category_to_courses`
  ADD PRIMARY KEY (`course_id`,`category_id`),
  ADD KEY `category_to_courses_ibfk_1` (`category_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `course_author` (`course_author`);

--
-- Indexes for table `course_enrolled`
--
ALTER TABLE `course_enrolled`
  ADD PRIMARY KEY (`enrolled_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`instructor_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`material_id`),
  ADD KEY `materials_ibfk_1` (`topic_id`);

--
-- Indexes for table `material_status_table`
--
ALTER TABLE `material_status_table`
  ADD PRIMARY KEY (`material_status_id`),
  ADD KEY `material_status_table_ibfk_1` (`enrolled_id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`option_id`),
  ADD KEY `options_ibfk_1` (`question_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quizes`
--
ALTER TABLE `quizes`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `quizes_ibfk_1` (`topic_id`);

--
-- Indexes for table `quiz_participation`
--
ALTER TABLE `quiz_participation`
  ADD PRIMARY KEY (`participation_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `topics_ibfk_1` (`course_id`);

--
-- Indexes for table `topic_unlock`
--
ALTER TABLE `topic_unlock`
  ADD PRIMARY KEY (`topic_serial`,`enrolled_id`),
  ADD KEY `enrolled_id` (`enrolled_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `course_enrolled`
--
ALTER TABLE `course_enrolled`
  MODIFY `enrolled_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `instructor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `material_status_table`
--
ALTER TABLE `material_status_table`
  MODIFY `material_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `quizes`
--
ALTER TABLE `quizes`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `quiz_participation`
--
ALTER TABLE `quiz_participation`
  MODIFY `participation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category_to_courses`
--
ALTER TABLE `category_to_courses`
  ADD CONSTRAINT `category_to_courses_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_to_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`course_author`) REFERENCES `instructors` (`instructor_id`);

--
-- Constraints for table `course_enrolled`
--
ALTER TABLE `course_enrolled`
  ADD CONSTRAINT `course_enrolled_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_enrolled_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`) ON DELETE CASCADE;

--
-- Constraints for table `material_status_table`
--
ALTER TABLE `material_status_table`
  ADD CONSTRAINT `material_status_table_ibfk_1` FOREIGN KEY (`enrolled_id`) REFERENCES `course_enrolled` (`enrolled_id`) ON DELETE CASCADE;

--
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizes` (`quiz_id`) ON DELETE CASCADE;

--
-- Constraints for table `quizes`
--
ALTER TABLE `quizes`
  ADD CONSTRAINT `quizes_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`) ON DELETE CASCADE;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `topic_unlock`
--
ALTER TABLE `topic_unlock`
  ADD CONSTRAINT `topic_unlock_ibfk_1` FOREIGN KEY (`enrolled_id`) REFERENCES `course_enrolled` (`enrolled_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
