-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2026 at 05:14 PM
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
-- Database: `rakan_akademik`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` varchar(20) NOT NULL COMMENT 'Admin identifier',
  `userID` varchar(20) NOT NULL COMMENT 'Reference to user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bookingID` varchar(20) NOT NULL COMMENT 'Booking identifier',
  `matricNoTutor` varchar(20) NOT NULL COMMENT 'Tutor assigned',
  `matricNoStudent` varchar(20) NOT NULL COMMENT 'Student making booking',
  `schedule` datetime NOT NULL COMMENT 'Booking schedule',
  `bookingStatus` varchar(20) NOT NULL COMMENT 'Booking status',
  `subject` varchar(100) NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  `recordID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` varchar(20) NOT NULL COMMENT 'Payment identifier',
  `bookingID` varchar(20) NOT NULL COMMENT 'Reference to booking',
  `amount` decimal(10,2) NOT NULL COMMENT 'Payment amount',
  `payment_date` date NOT NULL COMMENT 'Payment date',
  `paymentStatus` varchar(20) NOT NULL COMMENT 'Payment status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quizID` varchar(20) NOT NULL COMMENT 'Quiz identifier',
  `matricNoTutor` varchar(20) NOT NULL COMMENT 'Tutor who created quiz',
  `title` varchar(255) NOT NULL,
  `description` varchar(100) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `difficulty` varchar(50) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `time_limit` int(11) DEFAULT NULL,
  `attempts` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`quizID`, `matricNoTutor`, `title`, `description`, `category`, `difficulty`, `cover`, `time_limit`, `attempts`) VALUES
('Q1782223233', 'd0112', '1234567', '', 'Programming', 'Easy', '', 10, 3);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts`
--

CREATE TABLE `quiz_attempts` (
  `attemptID` int(11) NOT NULL,
  `quizID` varchar(20) NOT NULL,
  `userID` varchar(20) NOT NULL,
  `score` int(11) NOT NULL,
  `total_question` int(11) NOT NULL,
  `user_answer` text NOT NULL,
  `attempt_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_attempts`
--

INSERT INTO `quiz_attempts` (`attemptID`, `quizID`, `userID`, `score`, `total_question`, `user_answer`, `attempt_date`) VALUES
(6, 'Q1782223233', 'd0112', 1, 2, '{\"22\":\"A\",\"23\":\"A\"}', '2026-06-23 14:00:59');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_question`
--

CREATE TABLE `quiz_question` (
  `questionID` int(11) NOT NULL,
  `quizID` varchar(20) NOT NULL,
  `question` text NOT NULL,
  `optionA` varchar(255) NOT NULL,
  `optionB` varchar(255) NOT NULL,
  `optionC` varchar(255) NOT NULL,
  `optionD` varchar(255) NOT NULL,
  `correct_answer` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_question`
--

INSERT INTO `quiz_question` (`questionID`, `quizID`, `question`, `optionA`, `optionB`, `optionC`, `optionD`, `correct_answer`) VALUES
(22, 'Q1782223233', '1', 'where', 'set', 'Child Node', '8', 'A'),
(23, 'Q1782223233', '345tyu', 'where', 'Root Node', 'insert', '8', 'D');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_result`
--

CREATE TABLE `quiz_result` (
  `resultID` varchar(20) NOT NULL COMMENT 'Quiz result identifier',
  `matricNoStudent` varchar(20) NOT NULL COMMENT 'Student taking quiz',
  `quizID` varchar(20) NOT NULL COMMENT 'Reference to quiz',
  `score` int(3) NOT NULL COMMENT 'Quiz score'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rakan_profile`
--

CREATE TABLE `rakan_profile` (
  `profileID` int(11) NOT NULL,
  `matricNoTutor` varchar(20) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `programme` varchar(100) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `currentStatus` varchar(100) NOT NULL,
  `academicBackground` text NOT NULL,
  `academicStrengths` text NOT NULL,
  `cgpa` decimal(3,2) NOT NULL,
  `availability` varchar(100) NOT NULL,
  `contactNumber` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `matricNoStudent` varchar(20) NOT NULL COMMENT 'Student matric number',
  `userID` varchar(20) NOT NULL COMMENT 'Reference student',
  `course` varchar(100) NOT NULL COMMENT 'Student course'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`matricNoStudent`, `userID`, `course`) VALUES
('B032410001', 'U001', 'BITP'),
('d011', 'd011', 'sc'),
('D032410021', 'D032410021', 'Diploma in Science Computer'),
('D123', 'D123', 'Diploma in Science Computer');

-- --------------------------------------------------------

--
-- Table structure for table `teaching record`
--

CREATE TABLE `teaching record` (
  `recordID` varchar(20) NOT NULL COMMENT 'Teaching record identifier',
  `matricNoTutor` varchar(20) NOT NULL COMMENT 'Reference to tutor',
  `subject` varchar(100) NOT NULL COMMENT 'Subject taught',
  `sessionDate` date NOT NULL COMMENT 'Session date and time',
  `teachingStatus` varchar(20) NOT NULL COMMENT 'Teaching session status',
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  `sessionType` varchar(20) NOT NULL,
  `meetingLink` varchar(20) NOT NULL,
  `venue` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teaching record`
--

INSERT INTO `teaching record` (`recordID`, `matricNoTutor`, `subject`, `sessionDate`, `teachingStatus`, `startTime`, `endTime`, `sessionType`, `meetingLink`, `venue`) VALUES
('R526', 'd0112', 'Programming', '2026-03-12', 'Available', '17:22:00', '18:22:00', 'Online', 'https://teams.live.c', '');

-- --------------------------------------------------------

--
-- Table structure for table `tutor`
--

CREATE TABLE `tutor` (
  `matricNoTutor` varchar(20) NOT NULL COMMENT 'Tutor matric number',
  `userID` varchar(20) NOT NULL COMMENT 'Reference to user',
  `expertise` varchar(100) NOT NULL COMMENT 'Tutor expertise',
  `availability` varchar(100) NOT NULL COMMENT 'Tutor availability'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor`
--

INSERT INTO `tutor` (`matricNoTutor`, `userID`, `expertise`, `availability`) VALUES
('d0112', 'd0112', 'Programming, Data Structure & Algorithm', 'Available'),
('D032410021', 'D032410021', 'Data Structure & Algorithm', 'Available'),
('T001', 'U002', 'Programming', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `tutor_application`
--

CREATE TABLE `tutor_application` (
  `applicationID` int(11) NOT NULL,
  `matricNoStudent` varchar(20) NOT NULL,
  `cgpa` decimal(3,2) NOT NULL,
  `expertise` varchar(255) NOT NULL,
  `availability` varchar(100) NOT NULL,
  `reason` text NOT NULL,
  `transcript` varchar(255) NOT NULL,
  `applicationDate` datetime DEFAULT current_timestamp(),
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `adminRemark` text DEFAULT NULL,
  `popupStatus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor_application`
--

INSERT INTO `tutor_application` (`applicationID`, `matricNoStudent`, `cgpa`, `expertise`, `availability`, `reason`, `transcript`, `applicationDate`, `status`, `adminRemark`, `popupStatus`) VALUES
(0, 'D123', 3.50, 'Data Structure', '-', '-', '1782501502_ANALYSIS DOCUMENT.pdf', '2026-06-27 03:18:22', 'Approved', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userId` varchar(20) NOT NULL COMMENT 'Unique user identifier',
  `name` varchar(100) NOT NULL COMMENT 'User full name',
  `email` varchar(100) DEFAULT NULL COMMENT 'User email address',
  `mobile_phone` varchar(20) DEFAULT NULL COMMENT 'User phone number',
  `gender` varchar(10) NOT NULL COMMENT 'User gender',
  `password` varchar(255) NOT NULL COMMENT 'User password',
  `status` varchar(20) NOT NULL COMMENT 'User account status',
  `role` varchar(20) NOT NULL COMMENT 'User role'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
--
--Table chapters, topics, resources for learning module
--

CREATE TABLE `chapters` (
  `chapter_id` INT NOT NULL AUTO_INCREMENT,
  `subject` VARCHAR(20) NOT NULL,
  `chapter_name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`chapter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `topics` (
  `topic_id` INT NOT NULL AUTO_INCREMENT,
  `chapter_id` INT NOT NULL,
  `topic_name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`topic_id`),
  FOREIGN KEY (`chapter_id`) REFERENCES `chapters`(`chapter_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `resources` (
  `resource_id` INT NOT NULL AUTO_INCREMENT,
  `topic_id` INT NOT NULL,
  `type` VARCHAR(20) NOT NULL,
  `title` VARCHAR(50) NOT NULL,
  `link` TEXT NOT NULL,
  PRIMARY KEY (`resource_id`),
  FOREIGN KEY (`topic_id`) REFERENCES `topics`(`topic_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `name`, `email`, `mobile_phone`, `gender`, `password`, `status`, `role`) VALUES
('d011', 'sofea', 'aisya@gmail.com', '011', 'Female', '111', 'Active', 'Student'),
('d0112', 'sofea', 'sofea@gmail.com', '011', 'Female', '$2y$10$88BQsIt8Q3ugxVe./il2..JBSD8MZme2A1/OHWG4J2ycfGJRifqGC', 'Active', 'Tutor'),
('D032410021', 'alya', 'batrisyiaalya13@gmail.com', '01153110996', 'Female', '$2y$10$G8lAx6nQNtQw44qzr4rXV.i2vdoKnHYf6rhuLNEMlsS7yS3aXxZZe', 'Approved', 'Tutor'),
('D123', 'bat', 'batrisyia@gmail.com', '0123456789', 'Female', '$2y$10$/NivSmmQYPiNIDgCW50BeeHnMxdsOjRfQDLjVq815hyc8vtIzzM6C', 'Active', 'Student'),
('U001', 'Aisya', 'aisya@gmail.com', '0123456789', 'Female', '123456', 'Active', 'Student'),
('U002', 'Ahmad ', 'ahmad@gmail.com', '01111111111', 'Male', '123456', 'Active', 'Tutor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bookingID`),
  ADD KEY `matricNoTutor` (`matricNoTutor`,`matricNoStudent`),
  ADD KEY `matricNoStudent` (`matricNoStudent`),
  ADD KEY `recordID` (`recordID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `bookingID` (`bookingID`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quizID`),
  ADD KEY `matricNoTutor` (`matricNoTutor`);

--
-- Indexes for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD PRIMARY KEY (`attemptID`),
  ADD KEY `quizID` (`quizID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `quiz_question`
--
ALTER TABLE `quiz_question`
  ADD PRIMARY KEY (`questionID`),
  ADD KEY `quizID` (`quizID`);

--
-- Indexes for table `quiz_result`
--
ALTER TABLE `quiz_result`
  ADD PRIMARY KEY (`resultID`),
  ADD KEY `matricNoStudent` (`matricNoStudent`,`quizID`),
  ADD KEY `quizID` (`quizID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`matricNoStudent`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `teaching record`
--
ALTER TABLE `teaching record`
  ADD PRIMARY KEY (`recordID`),
  ADD KEY `matricNoTutor` (`matricNoTutor`);

--
-- Indexes for table `tutor`
--
ALTER TABLE `tutor`
  ADD PRIMARY KEY (`matricNoTutor`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `attemptID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `quiz_question`
--
ALTER TABLE `quiz_question`
  MODIFY `questionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userId`);

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`matricNoStudent`) REFERENCES `student` (`matricNoStudent`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`matricNoTutor`) REFERENCES `tutor` (`matricNoTutor`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`bookingID`) REFERENCES `booking` (`bookingID`);

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`matricNoTutor`) REFERENCES `tutor` (`matricNoTutor`);

--
-- Constraints for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD CONSTRAINT `quiz_attempts_ibfk_1` FOREIGN KEY (`quizID`) REFERENCES `quiz` (`quizID`),
  ADD CONSTRAINT `quiz_attempts_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `user` (`userId`);

--
-- Constraints for table `quiz_question`
--
ALTER TABLE `quiz_question`
  ADD CONSTRAINT `quiz_question_ibfk_1` FOREIGN KEY (`quizID`) REFERENCES `quiz` (`quizID`);

--
-- Constraints for table `quiz_result`
--
ALTER TABLE `quiz_result`
  ADD CONSTRAINT `quiz_result_ibfk_2` FOREIGN KEY (`matricNoStudent`) REFERENCES `student` (`matricNoStudent`);

--
-- Constraints for table `teaching record`
--
ALTER TABLE `teaching record`
  ADD CONSTRAINT `teaching record_ibfk_1` FOREIGN KEY (`matricNoTutor`) REFERENCES `tutor` (`matricNoTutor`);

--
-- Constraints for table `tutor`
--
ALTER TABLE `tutor`
  ADD CONSTRAINT `tutor_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
