-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2026 at 09:53 AM
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
-- Database: `rakan_akademik.sql`
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

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`quizID`, `matricNoTutor`, `title`, `description`, `category`, `difficulty`, `cover`, `time_limit`, `attempts`) VALUES
('Q1782805417', 'D032410688', 'Programming II', 'Test your knowledge about programming II', 'Programming', 'Medium', 'uploads/1782805417_download.jpg', 10, 2),
('Q1782805806', 'D041910322', 'DSA', 'Test your brain ', 'Data Structure & Algorithm', 'Hard', 'uploads/1782805806_Data Structures and Algorithm.jpg', 10, 2);

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

--
-- Dumping data for table `quiz_attempts`
--

INSERT INTO `quiz_attempts` (`attemptID`, `quizID`, `matricNoStudent`, `score`, `total_question`, `user_answer`, `attempt_date`) VALUES
(11, 'Q1782805417', 'D032410657', 1, 5, '{\"43\":\"A\",\"44\":\"C\",\"45\":\"A\",\"46\":\"A\",\"47\":\"B\"}', '2026-06-30 07:52:08'),
(12, 'Q1782805806', 'D032410657', 3, 4, '{\"48\":\"A\",\"49\":\"D\",\"50\":\"A\",\"51\":\"D\"}', '2026-06-30 07:52:22');

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
(43, 'Q1782805417', 'Which PHP function is used to connect to a MySQL database using MySQLi?', 'mysqli_open()', 'mysqli_connect()', 'mysql_connect()', 'db_connect()', 'B'),
(44, 'Q1782805417', 'Which symbol is used to concatenate two strings in PHP?', '+', '&', '.', '=', 'C'),
(45, 'Q1782805417', 'Which SQL statement is used to retrieve data from a table?', 'INSERT', 'UPDATE', 'SELECT', 'DELETE', 'C'),
(46, 'Q1782805417', 'Which function starts a session in PHP?', 'session_open()', 'start_session()', 'session_start()', 'session_begin()', 'C'),
(47, 'Q1782805417', 'Which statement is used to repeat a block of code when the number of iterations is known?', 'while', 'do...while', 'foreach', 'for', 'D'),
(48, 'Q1782805806', 'Which data structure is most suitable for implementing recursion?', 'Queue', 'Stack', 'Linked List', 'Heap', 'B'),
(49, 'Q1782805806', 'What is the worst-case time complexity of Quick Sort?', 'O(n)', 'O(log n)', 'O(n log n)', 'O(n²)', 'D'),
(50, 'Q1782805806', 'Which operation on a balanced Binary Search Tree has time complexity O(log n)?', 'All of the above', 'Search', 'Insert', 'Delete', 'A'),
(51, 'Q1782805806', 'Which tree guarantees minimum height after insertions and deletions? ', 'Binary Tree', 'Huffman Tree', 'Huffman Tree', 'AVL Tree', 'D');

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
('B041910321', 'Bachelor of Computer Science (Software Development)'),
('D032410657', 'Diploma in Science Computer'),
('D032410684', 'Diploma in Computer Science'),
('D032410688', 'Diploma in Science Computer'),
('D041910322', 'Diploma in Science Computer');

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
('B041910321', 'Ahmad Haziq Bin Azman', 'Bachelor of Computer Science (Software Development)', 'Universiti Teknikal Malaysia Melaka (UTeM)', 'Active Student', 'I am currently pursuing a Bachelor of Computer Science (Software Development) at UTeM. My academic focus is on programming, software development, data structures, algorithms, and web application development. I have completed several programming projects using Java, PHP, HTML, CSS, JavaScript, and MySQL.', '', 3.87, 'Monday – Friday (8:00 PM – 10:00 PM), Saturday (9:00 AM – 12:00 PM)', '01259641030', 'b041910321@student.utem.edu.my', 'B041910321', 'Programming'),
('D032410688', 'Nur Iman Sofea Binti Omar', 'Diploma in Science Computer', 'Universiti Teknikal Malaysia Melaka (UTeM)', 'Active Student', 'I am currently pursuing a Diploma in Computer Science at UTeM. Throughout my studies, I have consistently performed well in programming, database systems, web development, and data structures while actively participating in group projects and practical assignments', '', 3.82, 'Monday – Friday (8:00 PM – 10:00 PM), Saturday (10:00 AM – 1:00 PM)', '0176234510', 'd032410688@student.utem.edu.my', 'D032410688', 'Programming, Data Structure'),
('D041910322', 'Nur Aina Syazwani Binti Hassan', 'Diploma in Science Computer', 'Universiti Teknikal Malaysia Melaka (UTeM)', 'Active Student', 'I am currently pursuing a Diploma in Computer Science at UTeM. My academic focus is on database management, SQL, data modelling, and web application development. I have completed several projects involving MySQL, database design, and PHP-based systems.', '', 3.90, 'Monday – Friday (8:00 PM – 10:00 PM), Saturday (10:00 AM – 1:00 PM)', '01117849658', 'd041910322@student.utem.edu.my', 'D041910322', 'Data Structure');

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
(6, 'D032410688', 3.82, 'Programming, Data Structure', 'Monday – Friday (8:00 PM – 10:00 PM), Saturday (10:00 AM – 1:00 PM)', '0176234510', 'd032410688@student.utem.edu.my', 'I want to become a Rakan Akademik to help other students succeed in their studies while improving my communication and leadership skills.', '1782802941_Transcript_Nur_Iman_Sofea.pdf', '2026-06-30 15:02:21', 'Approved', 1, 'Nur Iman Sofea Binti Omar', 'Diploma in Science Computer', 'Universiti Teknikal Malaysia Melaka (UTeM)', 'Active Student', 'I am currently pursuing a Diploma in Computer Science at UTeM. Throughout my studies, I have consistently performed well in programming, database systems, web development, and data structures while actively participating in group projects and practical assignments', 'Strong problem-solving skills, programming fundamentals, object-oriented programming, database management, web development, teamwork, communication, and analytical thinking.'),
(7, 'B041910321', 3.87, 'Programming', 'Monday – Friday (8:00 PM – 10:00 PM), Saturday (9:00 AM – 12:00 PM)', '01259641030', 'b041910321@student.utem.edu.my', 'I want to become a Rakan Akademik to help fellow students improve their understanding of computer science subjects (programming) while enhancing my communication and leadership skills.', '1782803546_Transcript_Ahmad_Haziq.pdf', '2026-06-30 15:12:26', 'Approved', 1, 'Ahmad Haziq Bin Azman', 'Bachelor of Computer Science (Software Development)', 'Universiti Teknikal Malaysia Melaka (UTeM)', 'Active Student', 'I am currently pursuing a Bachelor of Computer Science (Software Development) at UTeM. My academic focus is on programming, software development, data structures, algorithms, and web application development. I have completed several programming projects using Java, PHP, HTML, CSS, JavaScript, and MySQL.', 'Strong programming skills, object-oriented programming (Java), PHP, web development, problem-solving, data structures and algorithms, database management (MySQL), and software development.'),
(8, 'D041910322', 3.90, 'Data Structure', 'Monday – Friday (8:00 PM – 10:00 PM), Saturday (10:00 AM – 1:00 PM)', '01117849658', 'd041910322@student.utem.edu.my', 'I want to become a Rakan Akademik to help fellow students understand database concepts and improve their practical skills while developing my communication and leadership abilities.', '1782804074_Transcript_Nur_Syazwani.pdf', '2026-06-30 15:21:14', 'Approved', 1, 'Nur Aina Syazwani Binti Hassan', 'Diploma in Science Computer', 'Universiti Teknikal Malaysia Melaka (UTeM)', 'Active Student', 'I am currently pursuing a Diploma in Computer Science at UTeM. My academic focus is on database management, SQL, data modelling, and web application development. I have completed several projects involving MySQL, database design, and PHP-based systems.', 'Strong database management skills, SQL, database design, ERD, normalization, MySQL, problem-solving, and web development.');

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
('B041910321', 'Ahmad Haziq Bin Azman', 'B041910321@student.utem.edu.my', '01259641030', 'Male', '$2y$10$68tokIQ5Ps2JDMDFlBlz.OJfVzL3tfcivIhHrtm8P2AeoIbRJuA6y', 'Active', 'Student,Tutor'),
('D032410657', 'Muhammad Kamal Bin Rahman', 'D032410657@student.utem.edu.my', '01123456789', 'Male', '$2y$10$zZfvQx6C4jKTNzVqRj/RMeMBYkoOsWruLzhfM8BBCE2egxHQuwGAG', 'Active', 'Student'),
('D032410684', 'Puteri Qistina Binti Osman', 'D032410684@student.utem.edu.my', '0138674521', 'Female', '$2y$10$FZXCNlpM/d7JEcHA0YycWeydLmfi3.dFocgUb5WwdgL6frFCGlCiS', 'Active', 'Student'),
('D032410688', 'Nur Iman Sofea Binti Omar', 'D032410688@student.utem.edu.my', '0176234510', 'Female', '$2y$10$spc.9OPzJiuRrqtal9waCuSTRpuDLmgr3/sWJGiufGWdp6TFSz6jq', 'Active', 'Student,Tutor'),
('D041910322', 'Nur Aina Syazwani Binti Hassan', 'D041910322@student.utem.edu.my', '01117849658', 'Female', '$2y$10$k0MBJLbdr8u9vPd/kWf9FOZFzI/MZn6mPDnuvYOmQ66rZQCTtysFW', 'Active', 'Student,Tutor');

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
  MODIFY `attemptID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `quiz_question`
--
ALTER TABLE `quiz_question`
  MODIFY `questionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

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
  MODIFY `applicationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
