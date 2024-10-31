-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_demo`
--
CREATE DATABASE IF NOT EXISTS `student_demo` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `student_demo`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `admin_phone`
--

CREATE TABLE `admin_phone` (
  `admin_id` int(11) NOT NULL,
  `phone_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assessment`
--

CREATE TABLE `assessment` (
  `assess_id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `semester_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `max_score` int(11) DEFAULT NULL,
  `format` varchar(10) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_file`
--

CREATE TABLE `assessment_file` (
  `assessment_id` int(11) NOT NULL,
  `professor_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `upload_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_link`
--

CREATE TABLE `assessment_link` (
  `assessment_id` int(11) NOT NULL,
  `professor_id` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_online_schedule`
--

CREATE TABLE `assessment_online_schedule` (
  `assessment_id` int(11) NOT NULL,
  `due_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_onsite_schedule`
--

CREATE TABLE `assessment_onsite_schedule` (
  `assessment_id` int(11) NOT NULL,
  `hall_no` int(11) NOT NULL DEFAULT '0',
  `due_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_score`
--

CREATE TABLE `assessment_score` (
  `assessment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `credit` int(11) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `course_pre_requisit`
--

CREATE TABLE `course_pre_requisit` (
  `course_id` int(11) NOT NULL,
  `pre_requisit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `hall`
--

CREATE TABLE `hall` (
  `id` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `building` varchar(255) DEFAULT NULL,
  `floor` int(2) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lecture_schedule`
--

CREATE TABLE `lecture_schedule` (
  `hall_no` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `week_day` varchar(255) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `professor`
--

CREATE TABLE `professor` (
  `id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `professor_phone`
--

CREATE TABLE `professor_phone` (
  `professor_id` int(11) NOT NULL,
  `phone_number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `id` int(11) NOT NULL,
  `semester` varchar(255) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_phone`
--

CREATE TABLE `student_phone` (
  `student_id` int(11) NOT NULL,
  `phone_number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `teaching`
--

CREATE TABLE `teaching` (
  `professor_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `admin_phone`
--
ALTER TABLE `admin_phone`
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `assessment`
--
ALTER TABLE `assessment`
  ADD PRIMARY KEY (`assess_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `semester_id` (`semester_id`);

--
-- Indexes for table `assessment_file`
--
ALTER TABLE `assessment_file`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `professor_id` (`professor_id`);

--
-- Indexes for table `assessment_link`
--
ALTER TABLE `assessment_link`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `professor_id` (`professor_id`);

--
-- Indexes for table `assessment_online_schedule`
--
ALTER TABLE `assessment_online_schedule`
  ADD PRIMARY KEY (`assessment_id`);

--
-- Indexes for table `assessment_onsite_schedule`
--
ALTER TABLE `assessment_onsite_schedule`
  ADD PRIMARY KEY (`assessment_id`,`hall_no`),
  ADD KEY `hall_no` (`hall_no`);

--
-- Indexes for table `assessment_score`
--
ALTER TABLE `assessment_score`
  ADD PRIMARY KEY (`assessment_id`,`student_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `assessment_id` (`assessment_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_pre_requisit`
--
ALTER TABLE `course_pre_requisit`
  ADD PRIMARY KEY (`course_id`,`pre_requisit_id`),
  ADD KEY `course_id` (`course_id`) USING BTREE;

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`semester_id`,`course_id`,`student_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `semester_id` (`semester_id`);

--
-- Indexes for table `hall`
--
ALTER TABLE `hall`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecture_schedule`
--
ALTER TABLE `lecture_schedule`
  ADD PRIMARY KEY (`hall_no`,`course_id`,`professor_id`,`semester_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `professor_id` (`professor_id`),
  ADD KEY `semester_id` (`semester_id`);

--
-- Indexes for table `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `professor_phone`
--
ALTER TABLE `professor_phone`
  ADD PRIMARY KEY (`professor_id`,`phone_number`),
  ADD UNIQUE KEY `phone_number` (`phone_number`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `student_phone`
--
ALTER TABLE `student_phone`
  ADD PRIMARY KEY (`student_id`,`phone_number`);

--
-- Indexes for table `teaching`
--
ALTER TABLE `teaching`
  ADD PRIMARY KEY (`course_id`,`professor_id`,`semester_id`),
  ADD KEY `professor_id` (`professor_id`),
  ADD KEY `semester_id` (`semester_id`),
  ADD KEY `course_id` (`course_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessment`
--
ALTER TABLE `assessment`
  MODIFY `assess_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `professor`
--
ALTER TABLE `professor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`);

--
-- Constraints for table `assessment`
--
ALTER TABLE `assessment`
  ADD CONSTRAINT `assessment_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `semester_id` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`id`);

--
-- Constraints for table `assessment_file`
--
ALTER TABLE `assessment_file`
  ADD CONSTRAINT `assessment_file_ibfk_1` FOREIGN KEY (`assessment_id`) REFERENCES `assessment` (`assess_id`),
  ADD CONSTRAINT `assessment_file_ibfk_2` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`id`);

--
-- Constraints for table `assessment_link`
--
ALTER TABLE `assessment_link`
  ADD CONSTRAINT `assessment_link_ibfk_1` FOREIGN KEY (`assessment_id`) REFERENCES `assessment` (`assess_id`),
  ADD CONSTRAINT `assessment_link_ibfk_2` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`id`);

--
-- Constraints for table `assessment_online_schedule`
--
ALTER TABLE `assessment_online_schedule`
  ADD CONSTRAINT `assessment_online_schedule_ibfk_1` FOREIGN KEY (`assessment_id`) REFERENCES `assessment` (`assess_id`);

--
-- Constraints for table `assessment_onsite_schedule`
--
ALTER TABLE `assessment_onsite_schedule`
  ADD CONSTRAINT `assessment_onsite_schedule_ibfk_1` FOREIGN KEY (`assessment_id`) REFERENCES `assessment` (`assess_id`),
  ADD CONSTRAINT `assessment_onsite_schedule_ibfk_2` FOREIGN KEY (`hall_no`) REFERENCES `hall` (`id`);

--
-- Constraints for table `assessment_score`
--
ALTER TABLE `assessment_score`
  ADD CONSTRAINT `assessment_score_ibfk_1` FOREIGN KEY (`assessment_id`) REFERENCES `assessment` (`assess_id`),
  ADD CONSTRAINT `assessment_score_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);

--
-- Constraints for table `course_pre_requisit`
--
ALTER TABLE `course_pre_requisit`
  ADD CONSTRAINT `course_pre_requisit_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`);

--
-- Constraints for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD CONSTRAINT `enrollment_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `enrollment_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `enrollment_ibfk_3` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`id`);

--
-- Constraints for table `lecture_schedule`
--
ALTER TABLE `lecture_schedule`
  ADD CONSTRAINT `lecture_schedule_ibfk_1` FOREIGN KEY (`hall_no`) REFERENCES `hall` (`id`),
  ADD CONSTRAINT `lecture_schedule_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `lecture_schedule_ibfk_3` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`id`),
  ADD CONSTRAINT `lecture_schedule_ibfk_4` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`id`);

--
-- Constraints for table `professor`
--
ALTER TABLE `professor`
  ADD CONSTRAINT `professor_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`);

--
-- Constraints for table `professor_phone`
--
ALTER TABLE `professor_phone`
  ADD CONSTRAINT `professor_phone_ibfk_1` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`);

--
-- Constraints for table `student_phone`
--
ALTER TABLE `student_phone`
  ADD CONSTRAINT `student_phone_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);

--
-- Constraints for table `teaching`
--
ALTER TABLE `teaching`
  ADD CONSTRAINT `teaching_ibfk_1` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`id`),
  ADD CONSTRAINT `teaching_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `teaching_ibfk_3` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
