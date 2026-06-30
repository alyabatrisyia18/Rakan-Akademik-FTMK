-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 29, 2026 at 05:41 PM
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
  `matricNoStudent` varchar(20) NOT NULL COMMENT 'Reference to user'
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
-- Table structure for table `chapters`
--

CREATE TABLE `chapters` (
  `chapter_id` int(11) NOT NULL,
  `subject` varchar(20) NOT NULL,
  `chapter_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` varchar(20) NOT NULL COMMENT 'Payment identifier',
  `recordID` varchar(20) NOT NULL COMMENT 'Reference to booking',
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

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts`
--

CREATE TABLE `quiz_attempts` (
  `attemptID` int(11) NOT NULL,
  `quizID` varchar(20) NOT NULL,
  `matricNoStudent` varchar(20) NOT NULL,
  `score` int(11) NOT NULL,
  `total_question` int(11) NOT NULL,
  `user_answer` text NOT NULL,
  `attempt_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `resource_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `matricNoStudent` varchar(20) NOT NULL COMMENT 'Student matric number',
  `course` varchar(100) NOT NULL COMMENT 'Student course'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`matricNoStudent`, `course`) VALUES
('D000', 'Diploma In Science Computer'),
('D032410021', 'Diploma in Science Computer'),
('D111', 'Diploma In Science Computer'),
('D777', 'Diploma In Science Computer');

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
  `venue` varchar(255) NOT NULL,
  `proofFile` varchar(255) NOT NULL,
  `hours` int(11) NOT NULL,
  `estimatedEarning` decimal(10,2) NOT NULL,
  `approvalStatus` varchar(20) NOT NULL,
  `submitDate` datetime DEFAULT NULL,
  `approvalDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `topic_id` int(11) NOT NULL,
  `chapter_id` int(11) NOT NULL,
  `topic_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tutor`
--

CREATE TABLE `tutor` (
  `matricNoTutor` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `programme` varchar(100) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `currentStatus` varchar(100) NOT NULL,
  `academicBackground` text NOT NULL,
  `academicStrengths` text NOT NULL,
  `cgpa` decimal(3,2) NOT NULL,
  `availability` varchar(100) NOT NULL,
  `contactNumber` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `matricNoStudent` varchar(20) NOT NULL,
  `expertise` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor`
--

INSERT INTO `tutor` (`matricNoTutor`, `name`, `programme`, `institution`, `currentStatus`, `academicBackground`, `academicStrengths`, `cgpa`, `availability`, `contactNumber`, `email`, `matricNoStudent`, `expertise`) VALUES
('D000', 'carmen', 'Diploma In Science Computer', 'Utem', 'Active', 'ok', 'okje', 3.95, 'ok', '0100000000', 'carmen@gmail.com', 'D000', 'Programming, Database'),
('D777', 'abu bin osamn', 'Diploma in Science Computer', 'Utem', 'Diploma Student', 'takde', 'ade hidup', 4.00, 'Monday until kiamat', '0158663248', 'abu@gmail.com', 'D777', 'Programming');

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
  `contactNumber` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `reason` text NOT NULL,
  `transcript` varchar(255) NOT NULL,
  `applicationDate` datetime DEFAULT current_timestamp(),
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `popupStatus` tinyint(1) DEFAULT 0,
  `name` varchar(100) NOT NULL,
  `programme` varchar(100) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `currentStatus` varchar(100) NOT NULL,
  `academicBackground` text NOT NULL,
  `academicStrengths` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor_application`
--

INSERT INTO `tutor_application` (`applicationID`, `matricNoStudent`, `cgpa`, `expertise`, `availability`, `contactNumber`, `email`, `reason`, `transcript`, `applicationDate`, `status`, `popupStatus`, `name`, `programme`, `institution`, `currentStatus`, `academicBackground`, `academicStrengths`) VALUES
(1, 'D123', 3.50, 'Data Structure', '-', '', '', '-', '1782501502_ANALYSIS DOCUMENT.pdf', '2026-06-27 03:18:22', 'Approved', 0, '', '', '', '', '', ''),
(2, 'D777', 3.85, 'Programming, Data Structure', 'Monday until kiamat', '0158663248', 'abu@gmail.com', 'sbb nk ajak org ramai jadi bodoh', '1782679962_RESUME.pdf', '2026-06-29 04:52:42', 'Approved', 0, 'abu bin osamn', 'Diploma In Science Computer', 'Utem', 'Diploma Student', 'takde', 'takde hidup'),
(3, 'D000', 3.95, 'Programming, Data Structure', 'ok', '0100000000', 'carmen@gmail.com', 'ok', '1782718971_RESUME.pdf', '2026-06-29 15:42:51', 'Approved', 1, 'carmen', 'Diploma In Science Computer', 'Utem', 'Active', 'ok', 'ok');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `matricNoStudent` varchar(20) NOT NULL COMMENT 'Unique user identifier',
  `name` varchar(100) NOT NULL COMMENT 'User full name',
  `email` varchar(100) DEFAULT NULL COMMENT 'User email address',
  `mobile_phone` varchar(20) DEFAULT NULL COMMENT 'User phone number',
  `gender` varchar(10) NOT NULL COMMENT 'User gender',
  `password` varchar(255) NOT NULL COMMENT 'User password',
  `status` varchar(20) NOT NULL COMMENT 'User account status',
  `role` varchar(20) NOT NULL COMMENT 'User role'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`matricNoStudent`, `name`, `email`, `mobile_phone`, `gender`, `password`, `status`, `role`) VALUES
('D000', 'Carmen', 'carmen@gmail.com', '0100000000', 'Female', '$2y$10$1GmlRsiIi4JXOf9jUDvJGe5QrAEZtWoz/0rOTcHSoMdfDRmrr6K5e', 'Active', 'Student,Tutor'),
('D032410021', 'alya', 'batrisyiaalya13@gmail.com', '01153110996', 'Female', '$2y$10$G8lAx6nQNtQw44qzr4rXV.i2vdoKnHYf6rhuLNEMlsS7yS3aXxZZe', 'Approved', 'Tutor'),
('D032410154', 'elsa binti hamid', 'elsa@gmail.com', '0177558020', 'Female', '$2y$10$AxQKOk6uBC7Q3HFRbEOSxuUgEKp1MxhmRB.ltpAbqE/XUKTl57lde', 'Active', 'Student'),
('D111', 'kiki', 'kiki@gmail.com', '0111111111', 'Male', '$2y$10$Juw4QSjmQEI6zN4Tntf8G.hSkUYZBN42Npk/oyCMckAr7E41FoJUu', 'Active', 'Student'),
('D777', 'abu bin osamn', 'abu@gmail.com', '0158663248', 'Male', '$2y$10$BoNrNPWAy0ZJ5KgICKd9YuZRS5LqUhK9vclEsqe0XyaKME/nAA44a', 'Active', 'Tutor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`),
  ADD KEY `userID` (`matricNoStudent`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bookingID`),
  ADD KEY `matricNoTutor` (`matricNoTutor`,`matricNoStudent`),
  ADD KEY `matricNoStudent` (`matricNoStudent`),
  ADD KEY `recordID` (`recordID`);

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`chapter_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `bookingID` (`recordID`);

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
  ADD KEY `userID` (`matricNoStudent`);

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
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`resource_id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`matricNoStudent`);

--
-- Indexes for table `teaching record`
--
ALTER TABLE `teaching record`
  ADD PRIMARY KEY (`recordID`),
  ADD KEY `matricNoTutor` (`matricNoTutor`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `chapter_id` (`chapter_id`);

--
-- Indexes for table `tutor`
--
ALTER TABLE `tutor`
  ADD PRIMARY KEY (`matricNoTutor`),
  ADD KEY `matricNoStudent` (`matricNoStudent`);

--
-- Indexes for table `tutor_application`
--
ALTER TABLE `tutor_application`
  ADD PRIMARY KEY (`applicationID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`matricNoStudent`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `chapter_id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `resource_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tutor_application`
--
ALTER TABLE `tutor_application`
  MODIFY `applicationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`matricNoStudent`) REFERENCES `user` (`matricNoStudent`);

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
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`recordID`) REFERENCES `teaching record` (`recordID`);

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
  ADD CONSTRAINT `quiz_attempts_ibfk_2` FOREIGN KEY (`matricNoStudent`) REFERENCES `user` (`matricNoStudent`);

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
-- Constraints for table `resources`
--
ALTER TABLE `resources`
  ADD CONSTRAINT `resources_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`) ON DELETE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`matricNoStudent`) REFERENCES `user` (`matricNoStudent`);

--
-- Constraints for table `teaching record`
--
ALTER TABLE `teaching record`
  ADD CONSTRAINT `teaching record_ibfk_1` FOREIGN KEY (`matricNoTutor`) REFERENCES `tutor` (`matricNoTutor`);

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`chapter_id`) ON DELETE CASCADE;

--
-- Constraints for table `tutor`
--
ALTER TABLE `tutor`
  ADD CONSTRAINT `tutor_ibfk_1` FOREIGN KEY (`matricNoStudent`) REFERENCES `user` (`matricNoStudent`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
