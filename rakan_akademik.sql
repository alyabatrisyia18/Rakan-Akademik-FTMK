-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 24, 2026 at 03:39 PM
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
  `question` varchar(255) NOT NULL COMMENT 'Quiz creation',
  `answer` varchar(255) NOT NULL COMMENT 'Correct answer'
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
('d011', 'd011', 'sc');

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
('T001', 'U002', 'Programming', 'Available');

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
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `name`, `email`, `mobile_phone`, `gender`, `password`, `status`, `role`) VALUES
('d011', 'sofea', 'aisya@gmail.com', '011', 'Female', '$2y$10$J02DKpbisCXpFJ4tdi8DrudUJmJBBz6O4ExpKuAfyOfhldoOAyeLu', 'Active', 'Student'),
('d0112', 'sofea', 'sofea@gmail.com', '011', 'Female', '$2y$10$88BQsIt8Q3ugxVe./il2..JBSD8MZme2A1/OHWG4J2ycfGJRifqGC', 'Active', 'Tutor'),
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
-- Indexes for table `quiz_result`
--
ALTER TABLE `quiz_result`
  ADD PRIMARY KEY (`resultID`),
  ADD KEY `matricNoStudent` (`matricNoStudent`,`quizID`),
  ADD KEY `quizID` (`quizID`);

--
-- Indexes for table `rakan_profile`
--
ALTER TABLE `rakan_profile`
  ADD PRIMARY KEY (`profileID`),
  ADD KEY `matricNoTutor` (`matricNoTutor`);

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
-- AUTO_INCREMENT for table `rakan_profile`
--
ALTER TABLE `rakan_profile`
  MODIFY `profileID` int(11) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `quiz_result`
--
ALTER TABLE `quiz_result`
  ADD CONSTRAINT `quiz_result_ibfk_2` FOREIGN KEY (`matricNoStudent`) REFERENCES `student` (`matricNoStudent`);

--
-- Constraints for table `rakan_profile`
--
ALTER TABLE `rakan_profile`
  ADD CONSTRAINT `rakan_profile_ibfk_1` FOREIGN KEY (`matricNoTutor`) REFERENCES `tutor` (`matricNoTutor`);

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
