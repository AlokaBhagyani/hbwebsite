-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2025 at 05:33 AM
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
-- Database: `hbwebsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_cred`
--

CREATE TABLE `admin_cred` (
  `id` int(11) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `admin_pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_cred`
--

INSERT INTO `admin_cred` (`id`, `admin_name`, `admin_pass`) VALUES
(1, 'Aloka_bhagyani', '$2y$10$fY7YLF0KXbQ0LzbfZwYhmurdjgQomdgM9X0v4mub8KrQ.W9TVZHPC');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `status` enum('confirmed','cancelled','completed') DEFAULT 'confirmed',
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `guest_name` varchar(255) NOT NULL,
  `guest_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `room_id`, `status`, `check_in`, `check_out`, `guest_name`, `guest_email`) VALUES
(12, 9, 'confirmed', '2025-08-19', '2025-08-20', 'aloka', 'alokabhagyani@gmail.com'),
(13, 9, 'confirmed', '2025-08-20', '2025-08-21', 'bhagyani', 'amandani@gmail.com'),
(14, 9, 'confirmed', '2025-09-17', '2025-09-18', 'bhagyani', 'alokabhagyani@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `facility_id` int(11) NOT NULL,
  `facility_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`facility_id`, `facility_name`) VALUES
(1, 'AC'),
(3, 'TV'),
(2, 'WiFi');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `subject`, `message`, `submitted_at`) VALUES
(1, 'bhagyani', 'alokabhagyani@gmail.com', 'room facilitys', 'best', '2025-08-08 11:17:09'),
(2, 'pathumi', 'pathumi@gmail.com', 'room', 'good', '2025-08-08 11:20:27');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_number` varchar(50) DEFAULT NULL,
  `room_type` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` enum('available','booked','maintenance') DEFAULT 'available',
  `room_people` int(11) DEFAULT NULL,
  `room_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_number`, `room_type`, `price`, `status`, `room_people`, `room_image`) VALUES
(9, '1', 'Single', 1500.00, 'booked', 1, '6896ef53274f1_luxor-tower-elite-rooms-2.jpg'),
(10, '2', 'Single', 1700.00, 'available', 1, '6896ef6d9c607_luxor-tower-elite-rooms-2.jpg'),
(11, '3', 'Single', 2000.00, 'available', 1, '6896ef88d1c8c_luxor-tower-elite-rooms-2.jpg'),
(12, '4', 'Single', 2500.00, 'available', 1, '6896efa4c1b44_luxor-tower-elite-rooms-2.jpg'),
(13, '5', 'Single', 2500.00, 'available', 1, '6897691d692e4_luxor-tower-elite-rooms-2.jpg'),
(14, '6', 'Single', 2800.00, 'available', 1, '689769b6626e0_luxor-tower-elite-rooms-2.jpg'),
(15, '7', 'Single', 3000.00, 'available', 1, '689769e1e95c6_luxor-tower-elite-rooms-2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `room_facility_mapping`
--

CREATE TABLE `room_facility_mapping` (
  `room_id` int(11) NOT NULL,
  `facility_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_facility_mapping`
--

INSERT INTO `room_facility_mapping` (`room_id`, `facility_id`) VALUES
(9, 1),
(10, 2),
(11, 3),
(12, 2),
(13, 1),
(13, 3),
(14, 2),
(14, 3),
(15, 1),
(15, 2),
(15, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_cred`
--
ALTER TABLE `admin_cred`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_name` (`admin_name`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`facility_id`),
  ADD UNIQUE KEY `facility_name` (`facility_name`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `room_facility_mapping`
--
ALTER TABLE `room_facility_mapping`
  ADD PRIMARY KEY (`room_id`,`facility_id`),
  ADD KEY `facility_id` (`facility_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_cred`
--
ALTER TABLE `admin_cred`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `facility_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);

--
-- Constraints for table `room_facility_mapping`
--
ALTER TABLE `room_facility_mapping`
  ADD CONSTRAINT `room_facility_mapping_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`),
  ADD CONSTRAINT `room_facility_mapping_ibfk_2` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`facility_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
