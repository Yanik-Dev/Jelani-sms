-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2017 at 12:30 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


--
-- Database: `jelani_db`
--

use jelani_db;

-- --------------------------------------------------------

--
-- Table structure for table `academic_years`
--

CREATE TABLE `academic_years` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `is_default` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `available_forms`
--

CREATE TABLE `available_forms` (
  `id` int(11) NOT NULL,
  `name` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `available_forms`
--

INSERT INTO `available_forms` (`id`, `name`) VALUES
(1, 'Grade 1'),
(2, 'Grade 2'),
(3, 'Grade 3'),
(4, 'Grade 4'),
(5, 'Grade 5'),
(6, 'Grade 6');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `fk_form_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `fk_teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class_subjects`
--

CREATE TABLE `class_subjects` (
  `class_subject_id` int(11) NOT NULL,
  `fk_class_id` int(11) NOT NULL,
  `fk_subject_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` int(11) NOT NULL,
  `name` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `guardians`
--

CREATE TABLE `guardians` (
  `id` int(11) NOT NULL,
  `fk_student_id` int(11) NOT NULL,
  `type` enum('Parent','Sibling','Relative','Grand Parent','Family Friend') NOT NULL,
  `profession` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_no1` varchar(20) DEFAULT NULL,
  `contact_no2` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `photo` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `srn` varchar(40) DEFAULT NULL,
  `fk_academic_year_id` int(11) NOT NULL,
  `fk_class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_code` varchar(4) NOT NULL,
  `subject_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `date_of_employment` date NOT NULL,
  `marital_status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_classes`
--

CREATE TABLE `teacher_classes` (
  `teacher_class_id` int(11) NOT NULL,
  `fk_class_id` int(11) NOT NULL,
  `fk_teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_subjects`
--

CREATE TABLE `teacher_subjects` (
  `teacher_subject_id` int(11) NOT NULL,
  `fk_teacher_id` int(11) NOT NULL,
  `fk_subject_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` enum('Admin','Teacher','Guardian','Student') NOT NULL,
  `password` text NOT NULL,
  `salt` varchar(10) NOT NULL,
  `is_activated` enum('yes','no') NOT NULL DEFAULT 'yes',
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `photo` text,
  `contact_no1` varchar(20) DEFAULT NULL,
  `contact_no2` varchar(20) DEFAULT NULL,
  `trn` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Stand-in structure for view `v_classes`
--
CREATE TABLE `v_classes` (
`form_name` varchar(14)
,`id` int(11)
,`fk_form_id` int(11)
,`name` varchar(20)
,`fk_teacher_id` int(11)
,`first_name` varchar(45)
,`last_name` varchar(45)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_students`
--
CREATE TABLE `v_students` (
`id` int(11)
,`username` varchar(20)
,`email` varchar(255)
,`role` enum('Admin','Teacher','Guardian','Student')
,`password` text
,`salt` varchar(10)
,`is_activated` enum('yes','no')
,`first_name` varchar(45)
,`last_name` varchar(45)
,`middle_name` varchar(45)
,`gender` enum('Male','Female')
,`date_of_birth` date
,`address` varchar(255)
,`photo` text
,`contact_no1` varchar(20)
,`contact_no2` varchar(20)
,`srn` varchar(40)
,`fk_academic_year_id` int(11)
,`year` int(11)
,`fk_class_id` int(11)
,`fk_form_id` int(11)
,`class_name` varchar(20)
,`form_name` varchar(14)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_teachers`
--
CREATE TABLE `v_teachers` (
`id` int(11)
,`username` varchar(20)
,`email` varchar(255)
,`role` enum('Admin','Teacher','Guardian','Student')
,`password` text
,`salt` varchar(10)
,`is_activated` enum('yes','no')
,`first_name` varchar(45)
,`last_name` varchar(45)
,`middle_name` varchar(45)
,`gender` enum('Male','Female')
,`date_of_birth` date
,`address` varchar(255)
,`photo` text
,`contact_no1` varchar(20)
,`contact_no2` varchar(20)
,`trn` varchar(15)
,`teacher_id` int(11)
,`date_of_employment` date
,`marital_status` varchar(15)
);

-- --------------------------------------------------------

--
-- Structure for view `v_classes`
--
DROP TABLE IF EXISTS `v_classes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_classes`  AS  select `forms`.`name` AS `form_name`,`classes`.`id` AS `id`,`classes`.`fk_form_id` AS `fk_form_id`,`classes`.`name` AS `name`,`classes`.`fk_teacher_id` AS `fk_teacher_id`,`users`.`first_name` AS `first_name`,`users`.`last_name` AS `last_name` from ((`classes` left join `users` on((`users`.`id` = `classes`.`fk_teacher_id`))) left join `forms` on((`forms`.`id` = `classes`.`fk_form_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_students`
--
DROP TABLE IF EXISTS `v_students`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_students`  AS  select `users`.`id` AS `id`,`users`.`username` AS `username`,`users`.`email` AS `email`,`users`.`role` AS `role`,`users`.`password` AS `password`,`users`.`salt` AS `salt`,`users`.`is_activated` AS `is_activated`,`users`.`first_name` AS `first_name`,`users`.`last_name` AS `last_name`,`users`.`middle_name` AS `middle_name`,`users`.`gender` AS `gender`,`users`.`date_of_birth` AS `date_of_birth`,`users`.`address` AS `address`,`users`.`photo` AS `photo`,`users`.`contact_no1` AS `contact_no1`,`users`.`contact_no2` AS `contact_no2`,`students`.`srn` AS `srn`,`students`.`fk_academic_year_id` AS `fk_academic_year_id`,`academic_years`.`year` AS `year`,`students`.`fk_class_id` AS `fk_class_id`,`classes`.`fk_form_id` AS `fk_form_id`,`classes`.`name` AS `class_name`,`forms`.`name` AS `form_name` from ((((`students` join `users` on((`users`.`id` = `students`.`id`))) join `classes` on((`classes`.`id` = `students`.`fk_class_id`))) join `forms` on((`classes`.`fk_form_id` = `forms`.`id`))) join `academic_years`) ;

-- --------------------------------------------------------

--
-- Structure for view `v_teachers`
--
DROP TABLE IF EXISTS `v_teachers`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_teachers`  AS  select `users`.`id` AS `id`,`users`.`username` AS `username`,`users`.`email` AS `email`,`users`.`role` AS `role`,`users`.`password` AS `password`,`users`.`salt` AS `salt`,`users`.`is_activated` AS `is_activated`,`users`.`first_name` AS `first_name`,`users`.`last_name` AS `last_name`,`users`.`middle_name` AS `middle_name`,`users`.`gender` AS `gender`,`users`.`date_of_birth` AS `date_of_birth`,`users`.`address` AS `address`,`users`.`photo` AS `photo`,`users`.`contact_no1` AS `contact_no1`,`users`.`contact_no2` AS `contact_no2`,`users`.`trn` AS `trn`,`teachers`.`teacher_id` AS `teacher_id`,`teachers`.`date_of_employment` AS `date_of_employment`,`teachers`.`marital_status` AS `marital_status` from (`users` join `teachers` on((`teachers`.`teacher_id` = `users`.`id`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_years`
--
ALTER TABLE `academic_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `available_forms`
--
ALTER TABLE `available_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_form_id` (`fk_form_id`),
  ADD KEY `fk_teacher_id` (`fk_teacher_id`);

--
-- Indexes for table `class_subjects`
--
ALTER TABLE `class_subjects`
  ADD PRIMARY KEY (`class_subject_id`),
  ADD KEY `fk_subject_id` (`fk_subject_id`),
  ADD KEY `fk_class_id` (`fk_class_id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guardians`
--
ALTER TABLE `guardians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_student_id` (`fk_student_id`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_index` (`id`),
  ADD KEY `class_index` (`fk_class_id`),
  ADD KEY `academicyr_index` (`fk_academic_year_id`),
  ADD KEY `fk_academic_year_id` (`fk_academic_year_id`),
  ADD KEY `fk_class_id` (`fk_class_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`);

--
-- Indexes for table `teacher_classes`
--
ALTER TABLE `teacher_classes`
  ADD PRIMARY KEY (`teacher_class_id`),
  ADD KEY `fk_class_id` (`fk_class_id`),
  ADD KEY `fk_teacher_id` (`fk_teacher_id`);

--
-- Indexes for table `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  ADD PRIMARY KEY (`teacher_subject_id`),
  ADD KEY `fk_teacher_id` (`fk_teacher_id`),
  ADD KEY `fk_subject_id` (`fk_subject_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_years`
--
ALTER TABLE `academic_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `available_forms`
--
ALTER TABLE `available_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `class_subjects`
--
ALTER TABLE `class_subjects`
  MODIFY `class_subject_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `teacher_classes`
--
ALTER TABLE `teacher_classes`
  MODIFY `teacher_class_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  MODIFY `teacher_subject_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`fk_form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `class_subjects`
--
ALTER TABLE `class_subjects`
  ADD CONSTRAINT `class_subjects_ibfk_1` FOREIGN KEY (`fk_class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_subjects_ibfk_2` FOREIGN KEY (`fk_subject_id`) REFERENCES `subjects` (`subject_id`) ON DELETE SET NULL;

--
-- Constraints for table `guardians`
--
ALTER TABLE `guardians`
  ADD CONSTRAINT `guardians_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `guardians_ibfk_2` FOREIGN KEY (`fk_student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`fk_academic_year_id`) REFERENCES `academic_years` (`id`),
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`fk_class_id`) REFERENCES `classes` (`id`);

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_classes`
--
ALTER TABLE `teacher_classes`
  ADD CONSTRAINT `teacher_classes_ibfk_1` FOREIGN KEY (`fk_class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teacher_classes_ibfk_2` FOREIGN KEY (`fk_teacher_id`) REFERENCES `teachers` (`teacher_id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  ADD CONSTRAINT `teacher_subjects_ibfk_1` FOREIGN KEY (`fk_teacher_id`) REFERENCES `teachers` (`teacher_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_subjects_ibfk_2` FOREIGN KEY (`fk_subject_id`) REFERENCES `subjects` (`subject_id`) ON DELETE SET NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
