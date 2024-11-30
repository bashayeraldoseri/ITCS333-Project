-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 02:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
CREATE DATABASE booking_system;
USE booking_system;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booking_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `Booking_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `Room_ID` int(11) NOT NULL,
  `Start_Time` date NOT NULL,
  `End_Time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`Booking_ID`, `user_ID`, `Room_ID`, `Start_Time`, `End_Time`) VALUES
(1, 2, 28, '2023-11-10', '2023-11-12'),
(2, 2, 30, '2024-12-01', '2024-12-05');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `Equipment_ID` int(11) NOT NULL,
  `Equipment_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`Equipment_ID`, `Equipment_name`) VALUES
(1, 'Projector'),
(2, 'Laptop'),
(3, 'Whiteboard'),
(4, 'Desktop Computer'),
(5, 'Smartboard'),
(6, 'Microphone'),
(7, 'Camera'),
(8, 'Printer'),
(9, 'Scanner'),
(10, 'Air Conditioner'),
(11, 'Digital Microscope'),
(12, '3D Printer'),
(13, 'Laboratory Glassware'),
(14, 'Beaker'),
(15, 'Bunsen Burner'),
(16, 'Centrifuge'),
(17, 'Balance Scale'),
(18, 'Multimeter'),
(19, 'Oscilloscope'),
(20, 'Soldering Iron'),
(21, 'Projector Screen'),
(22, 'Document Camera'),
(23, 'Laser Pointer'),
(24, 'Virtual Reality Headset'),
(25, 'Whiteboard Markers'),
(26, 'Flip Chart'),
(27, 'Smartphone'),
(28, 'Headphones'),
(29, 'Tablet'),
(30, 'Classroom Speaker'),
(31, 'Library Book Scanner'),
(32, 'Library Barcode Scanner'),
(33, 'Raspberry Pi Kit'),
(34, 'Arduino Kit'),
(35, 'Bookshelf'),
(36, 'Reading Lamp'),
(37, 'Desk Chair'),
(38, 'Ergonomic Chair'),
(39, 'Filing Cabinet'),
(40, 'Laptop Charger'),
(41, 'Desk Lamp'),
(42, 'Microwave'),
(43, 'Refrigerator'),
(44, 'Coffee Maker'),
(45, 'Water Cooler'),
(46, 'Air Purifier'),
(47, 'Security Camera'),
(48, 'Fire Extinguisher'),
(49, 'First Aid Kit'),
(50, 'Electric Kettle');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `number` text NOT NULL,
  `Capacity` int(11) NOT NULL,
  `Room_ID` int(11) NOT NULL,
  `Type` text NOT NULL,
  `Availability` tinyint(1) NOT NULL,
  `Description` text NOT NULL,
  `floor` int(11) NOT NULL,
  `department` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`number`, `Capacity`, `Room_ID`, `Type`, `Availability`, `Description`, `floor`, `department`) VALUES
('028', 43, 1, 'room', 1, 'Room for IS department', 0, 'IS'),
('029', 38, 2, 'room', 1, 'Room for IS department', 0, 'IS'),
('023', 33, 3, 'room', 1, 'Room for IS department', 0, 'IS'),
('030', 47, 4, 'room', 1, 'Room for IS department', 0, 'IS'),
('021', 41, 5, 'room', 1, 'Room for IS department', 0, 'IS'),
('032', 45, 6, 'room', 1, 'Room for IS department', 0, 'IS'),
('039', 95, 7, 'lab', 1, 'Lab for IS department', 0, 'IS'),
('040', 110, 8, 'lab', 1, 'Lab for IS department', 0, 'IS'),
('056', 44, 9, 'room', 1, 'Room for CS department', 0, 'CS'),
('057', 48, 10, 'room', 1, 'Room for CS department', 0, 'CS'),
('051', 50, 11, 'room', 1, 'Room for CS department', 0, 'CS'),
('058', 35, 12, 'room', 1, 'Room for CS department', 0, 'CS'),
('049', 39, 13, 'room', 1, 'Room for CS department', 0, 'CS'),
('060', 43, 14, 'room', 1, 'Room for CS department', 0, 'CS'),
('067', 100, 15, 'lab', 1, 'Lab for CS department', 0, 'CS'),
('068', 115, 16, 'lab', 1, 'Lab for CS department', 0, 'CS'),
('084', 46, 17, 'room', 1, 'Room for CE department', 0, 'CE'),
('085', 42, 18, 'room', 1, 'Room for CE department', 0, 'CE'),
('079', 37, 19, 'room', 1, 'Room for CE department', 0, 'CE'),
('086', 34, 20, 'room', 1, 'Room for CE department', 0, 'CE'),
('077', 40, 21, 'room', 1, 'Room for CE department', 0, 'CE'),
('088', 45, 22, 'room', 1, 'Room for CE department', 0, 'CE'),
('095', 95, 23, 'lab', 1, 'Lab for CE department', 0, 'CE'),
('096', 110, 24, 'lab', 1, 'Lab for CE department', 0, 'CE'),
('1010', 45, 25, 'room', 1, 'Room for IS department', 1, 'IS'),
('1011', 50, 26, 'room', 1, 'Room for IS department', 1, 'IS'),
('1008', 41, 27, 'room', 1, 'Room for IS department', 1, 'IS'),
('1012', 44, 28, 'room', 1, 'Room for IS department', 1, 'IS'),
('1006', 42, 29, 'room', 1, 'Room for IS department', 1, 'IS'),
('1014', 49, 30, 'room', 1, 'Room for IS department', 1, 'IS'),
('1016', 85, 31, 'lab', 1, 'Lab for IS department', 1, 'IS'),
('1017', 95, 32, 'lab', 1, 'Lab for IS department', 1, 'IS'),
('1047', 47, 33, 'room', 1, 'Room for CS department', 1, 'CS'),
('1048', 44, 34, 'room', 1, 'Room for CS department', 1, 'CS'),
('1045', 50, 35, 'room', 1, 'Room for CS department', 1, 'CS'),
('1050', 46, 36, 'room', 1, 'Room for CS department', 1, 'CS'),
('1043', 39, 37, 'room', 1, 'Room for CS department', 1, 'CS'),
('1052', 42, 38, 'room', 1, 'Room for CS department', 1, 'CS'),
('1042', 100, 39, 'lab', 1, 'Lab for CS department', 1, 'CS'),
('1044', 120, 40, 'lab', 1, 'Lab for CS department', 1, 'CS'),
('1085', 50, 41, 'room', 1, 'Room for CE department', 1, 'CE'),
('1086', 45, 42, 'room', 1, 'Room for CE department', 1, 'CE'),
('1083', 38, 43, 'room', 1, 'Room for CE department', 1, 'CE'),
('1087', 35, 44, 'room', 1, 'Room for CE department', 1, 'CE'),
('1061', 43, 45, 'room', 1, 'Room for CE department', 1, 'CE'),
('1089', 48, 46, 'room', 1, 'Room for CE department', 1, 'CE'),
('1080', 95, 47, 'lab', 1, 'Lab for CE department', 1, 'CE'),
('1082', 110, 48, 'lab', 1, 'Lab for CE department', 1, 'CE'),
('2010', 48, 49, 'room', 1, 'Room for IS department', 2, 'IS'),
('2011', 50, 50, 'room', 1, 'Room for IS department', 2, 'IS'),
('2008', 42, 51, 'room', 1, 'Room for IS department', 2, 'IS'),
('2012', 45, 52, 'room', 1, 'Room for IS department', 2, 'IS'),
('2007', 40, 53, 'room', 1, 'Room for IS department', 2, 'IS'),
('2013', 47, 54, 'room', 1, 'Room for IS department', 2, 'IS'),
('2005', 110, 55, 'lab', 1, 'Lab for IS department', 2, 'IS'),
('2015', 120, 56, 'lab', 1, 'Lab for IS department', 2, 'IS'),
('2048', 48, 57, 'room', 1, 'Room for CS department', 2, 'CS'),
('2049', 50, 58, 'room', 1, 'Room for CS department', 2, 'CS'),
('2045', 45, 59, 'room', 1, 'Room for CS department', 2, 'CS'),
('2050', 49, 60, 'room', 1, 'Room for CS department', 2, 'CS'),
('2045', 44, 61, 'room', 1, 'Room for CS department', 2, 'CS'),
('2051', 46, 62, 'room', 1, 'Room for CS department', 2, 'CS'),
('2043', 100, 63, 'lab', 1, 'Lab for CS department', 2, 'CS'),
('2053', 110, 64, 'lab', 1, 'Lab for CS department', 2, 'CS'),
('2086', 50, 65, 'room', 1, 'Room for CE department', 2, 'CE'),
('2087', 45, 66, 'room', 1, 'Room for CE department', 2, 'CE'),
('2084', 40, 67, 'room', 1, 'Room for CE department', 2, 'CE'),
('2088', 43, 68, 'room', 1, 'Room for CE department', 2, 'CE'),
('2083', 42, 69, 'room', 1, 'Room for CE department', 2, 'CE'),
('2089', 44, 70, 'room', 1, 'Room for CE department', 2, 'CE'),
('2081', 95, 71, 'lab', 1, 'Lab for CE department', 2, 'CE'),
('2091', 110, 72, 'lab', 1, 'Lab for CE department', 2, 'CE');

-- --------------------------------------------------------

--
-- Table structure for table `room_equipment`
--

CREATE TABLE `room_equipment` (
  `Room_equipment_ID` int(11) NOT NULL,
  `Room_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_equipment`
--

INSERT INTO `room_equipment` (`Room_equipment_ID`, `Room_ID`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 49),
(1, 50),
(1, 51),
(1, 52),
(1, 53),
(1, 54),
(1, 55),
(1, 56),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 25),
(2, 26),
(2, 27),
(2, 28),
(2, 29),
(2, 30),
(2, 31),
(2, 32),
(2, 49),
(2, 50),
(2, 51),
(2, 52),
(2, 53),
(2, 54),
(2, 55),
(2, 56),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 25),
(3, 26),
(3, 27),
(3, 28),
(3, 29),
(3, 30),
(3, 31),
(3, 32),
(3, 49),
(3, 50),
(3, 51),
(3, 52),
(3, 53),
(3, 54),
(3, 55),
(3, 56),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 5),
(4, 6),
(4, 7),
(4, 8),
(4, 25),
(4, 26),
(4, 27),
(4, 28),
(4, 29),
(4, 30),
(4, 31),
(4, 32),
(4, 49),
(4, 50),
(4, 51),
(4, 52),
(4, 53),
(4, 54),
(4, 55),
(4, 56),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 40),
(1, 57),
(1, 58),
(1, 59),
(1, 60),
(1, 61),
(1, 62),
(1, 63),
(1, 64),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 33),
(2, 34),
(2, 35),
(2, 36),
(2, 37),
(2, 38),
(2, 39),
(2, 40),
(2, 57),
(2, 58),
(2, 59),
(2, 60),
(2, 61),
(2, 62),
(2, 63),
(2, 64),
(3, 9),
(3, 10),
(3, 11),
(3, 12),
(3, 13),
(3, 14),
(3, 15),
(3, 16),
(3, 33),
(3, 34),
(3, 35),
(3, 36),
(3, 37),
(3, 38),
(3, 39),
(3, 40),
(3, 57),
(3, 58),
(3, 59),
(3, 60),
(3, 61),
(3, 62),
(3, 63),
(3, 64),
(4, 9),
(4, 10),
(4, 11),
(4, 12),
(4, 13),
(4, 14),
(4, 15),
(4, 16),
(4, 33),
(4, 34),
(4, 35),
(4, 36),
(4, 37),
(4, 38),
(4, 39),
(4, 40),
(4, 57),
(4, 58),
(4, 59),
(4, 60),
(4, 61),
(4, 62),
(4, 63),
(4, 64),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(1, 65),
(1, 66),
(1, 67),
(1, 68),
(1, 69),
(1, 70),
(1, 71),
(1, 72),
(2, 17),
(2, 18),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 24),
(2, 41),
(2, 42),
(2, 43),
(2, 44),
(2, 45),
(2, 46),
(2, 47),
(2, 48),
(2, 65),
(2, 66),
(2, 67),
(2, 68),
(2, 69),
(2, 70),
(2, 71),
(2, 72),
(3, 17),
(3, 18),
(3, 19),
(3, 20),
(3, 21),
(3, 22),
(3, 23),
(3, 24),
(3, 41),
(3, 42),
(3, 43),
(3, 44),
(3, 45),
(3, 46),
(3, 47),
(3, 48),
(3, 65),
(3, 66),
(3, 67),
(3, 68),
(3, 69),
(3, 70),
(3, 71),
(3, 72),
(4, 17),
(4, 18),
(4, 19),
(4, 20),
(4, 21),
(4, 22),
(4, 23),
(4, 24),
(4, 41),
(4, 42),
(4, 43),
(4, 44),
(4, 45),
(4, 46),
(4, 47),
(4, 48),
(4, 65),
(4, 66),
(4, 67),
(4, 68),
(4, 69),
(4, 70),
(4, 71),
(4, 72),
(1, 49),
(1, 50),
(1, 51),
(1, 52),
(1, 53),
(1, 54),
(1, 55),
(1, 56),
(2, 49),
(2, 50),
(2, 51),
(2, 52),
(2, 53),
(2, 54),
(2, 55),
(2, 56),
(3, 49),
(3, 50),
(3, 51),
(3, 52),
(3, 53),
(3, 54),
(3, 55),
(3, 56),
(4, 49),
(4, 50),
(4, 51),
(4, 52),
(4, 53),
(4, 54),
(4, 55),
(4, 56),
(1, 57),
(1, 58),
(1, 59),
(1, 60),
(1, 61),
(1, 62),
(1, 63),
(1, 64),
(2, 57),
(2, 58),
(2, 59),
(2, 60),
(2, 61),
(2, 62),
(2, 63),
(2, 64),
(3, 57),
(3, 58),
(3, 59),
(3, 60),
(3, 61),
(3, 62),
(3, 63),
(3, 64),
(4, 57),
(4, 58),
(4, 59),
(4, 60),
(4, 61),
(4, 62),
(4, 63),
(4, 64),
(1, 65),
(1, 66),
(1, 67),
(1, 68),
(1, 69),
(1, 70),
(1, 71),
(1, 72),
(2, 65),
(2, 66),
(2, 67),
(2, 68),
(2, 69),
(2, 70),
(2, 71),
(2, 72),
(3, 65),
(3, 66),
(3, 67),
(3, 68),
(3, 69),
(3, 70),
(3, 71),
(3, 72),
(4, 65),
(4, 66),
(4, 67),
(4, 68),
(4, 69),
(4, 70),
(4, 71),
(4, 72);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Role` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `name` text NOT NULL,
  `ID` int(11) NOT NULL,
  `ProfilePic` varchar(255) DEFAULT NULL,
  `Phone` text NOT NULL DEFAULT '+973 00000000',
  `DoB` date DEFAULT NULL,
  `Department` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Role`, `email`, `password`, `name`, `ID`, `ProfilePic`, `Phone`, `DoB`, `Department`) VALUES
('Admin', 'admin@uob.edu.bh', 'admin_password', 'Admin Name', 1, '0', '+973 00000000', NULL, ''),
('Instructor', 'instructor@uob.edu.bh', 'instructor_password', 'Instructor Name', 2, '0', '+973 00000000', NULL, ''),
('Student', 'student@stu.uob.edu.bh', 'student_password', 'Student Name', 3, '0', '+973 00000000', NULL, ''),
('', 'rshoodkk@gmail.com', '$2y$10$9xrPzlbMBQJWfyF2qtszeuPlHt6bUGGbcrow1z.pq9kLj5Hth6DTe', 'rashid', 5, '0', '+973 00000000', NULL, ''),
('', 'xxx@gmail.com', '$2y$10$AIY1Pl3vXYhjafZOdW9QDuJ/OVcAxOD.LHxsxZhAN1mWiBZiGocIq', 'x4', 6, '0', '+973 00000000', NULL, ''),
('', 'testtest@uob', '$2y$10$J8Q1w2vqx.4l3EHXruN1geVCGaPLZ6CEHRHZZkor.CXzCR441y2fq', 'testtest', 7, '0', '+973 00000000', NULL, ''),
('', 'nay@uob', '$2y$10$aXvz2.iaUgwpajG7soJ4dOdgtz.OAkJPWYqqx/WwUBjUTKBwRS/d6', 'yay', 8, '0', '+973 00000000', NULL, ''),
('', 'hey@uob', '$2y$10$dzSCqLsSnqmAiPz7ZoK5zOtDtEWKx9.1ARRyVB53cPGhjnd6YteUq', 'heyy', 9, '0', '+973 982313', '2004-02-29', ''),
('', 'test1019321@uob', '$2y$10$tKB76miOIN5fnhU/jNxMIOG6Fkek0CBhXFsyXUGQ1VwZRkQfLvUMS', 'Test1011', 10, '../static/uploads/6749b402e705a0.41528320.jpg', '+973 123', '2024-11-05', 'IS'),
('', 'AA@uob', '$2y$10$zTbwL1bvWriFcP.X1tY9l.lMEXbSw4nrjNB/zf2PpSTtw69GFKOIC', 'Ameena', 11, '../static/uploads/6749bd569ccab8.37118584.jpg', '+973 09876', '2024-11-12', 'CS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`Booking_ID`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`Equipment_ID`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`Room_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `Booking_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `Equipment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `Room_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
