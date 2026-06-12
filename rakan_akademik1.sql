-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2026 at 03:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
  `bookingStatus` varchar(20) NOT NULL COMMENT 'Booking status'
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
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `matricNoStudent` varchar(20) NOT NULL COMMENT 'Student matric number',
  `userID` varchar(20) NOT NULL COMMENT 'Reference student',
  `course` varchar(100) NOT NULL COMMENT 'Student course'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teaching record`
--

CREATE TABLE `teaching record` (
  `recordID` varchar(20) NOT NULL COMMENT 'Teaching record identifier',
  `matricNoTutor` varchar(20) NOT NULL COMMENT 'Reference to tutor',
  `subject` varchar(100) NOT NULL COMMENT 'Subject taught',
  `date_time` datetime NOT NULL COMMENT 'Session date and time',
  `teachingStatus` varchar(20) NOT NULL COMMENT 'Teaching session status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD KEY `matricNoStudent` (`matricNoStudent`);

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
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`matricNoStudent`) REFERENCES `user` (`userId`);

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
