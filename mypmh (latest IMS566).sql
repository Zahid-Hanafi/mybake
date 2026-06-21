-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 02, 2026 at 03:40 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mypmh`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `cgpa` decimal(3,2) NOT NULL,
  `semester` int NOT NULL,
  `gender` varchar(10) NOT NULL,
  `home_address` text NOT NULL,
  `achievement` text NOT NULL,
  `relative_experience` text,
  `interview_slot_id` int DEFAULT NULL,
  `status` enum('pending','rejected','accepted') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'pending',
  `rejection_reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `user_id`, `cgpa`, `semester`, `gender`, `home_address`, `achievement`, `relative_experience`, `interview_slot_id`, `status`, `rejection_reason`, `created_at`, `modified_at`) VALUES
(20, 2, '3.50', 1, 'Male', '2-04-10 JALAN 9/118B BLOCK 2 RUMAH PANGSA ', 'My contributions to student life are highlighted by the successful revitalization of the annual Campus Tech Symposium, where I oversaw a restructuring of the event format that led to a 40% increase in student attendance. I also pioneered a digital tracking system for volunteer hours that improved administrative accuracy by 30% and was eventually adopted by three other campus organizations. Furthermore, I secured over $5,000 in external sponsorship within a single semester through targeted outreach and professional pitching. My efforts in membership engagement were also recognized when I led a recruitment drive that expanded the association\'s active base by 25% in a six-month period.', 'During my tenure as a lead coordinator for the Student Activity Council, I managed the end-to-end planning and execution of large-scale campus events involving multiple internal and external stakeholders. My responsibilities included chairing weekly strategy meetings, managing a departmental budget, and facilitating communication between student volunteers and university administration. I specialized in streamlining recruitment processes for new members and developing training modules to ensure a high standard of event delivery. Additionally, I served as a primary liaison for corporate sponsors, negotiating terms for equipment and funding to support extracurricular initiatives.', 1, 'pending', NULL, '2026-02-01 12:43:04', '2026-02-01 12:43:04'),
(21, 3, '3.60', 2, 'Female', '2-04-10 JALAN 9/118B BLOCK 2 RUMAH PANGSA', 'My contributions to student life are highlighted by the successful revitalization of the annual Campus Tech Symposium, where I oversaw a restructuring of the event format that led to a 40% increase in student attendance. I also pioneered a digital tracking system for volunteer hours that improved administrative accuracy by 30% and was eventually adopted by three other campus organizations. Furthermore, I secured over $5,000 in external sponsorship within a single semester through targeted outreach and professional pitching. My efforts in membership engagement were also recognized when I led a recruitment drive that expanded the association\'s active base by 25% in a six-month period.', 'During my tenure as a lead coordinator for the Student Activity Council, I managed the end-to-end planning and execution of large-scale campus events involving multiple internal and external stakeholders. My responsibilities included chairing weekly strategy meetings, managing a departmental budget, and facilitating communication between student volunteers and university administration. I specialized in streamlining recruitment processes for new members and developing training modules to ensure a high standard of event delivery. Additionally, I served as a primary liaison for corporate sponsors, negotiating terms for equipment and funding to support extracurricular initiatives.', 2, 'pending', NULL, '2026-02-01 12:46:21', '2026-02-01 12:46:21'),
(22, 4, '3.70', 3, 'Male', '2-04-10 JALAN 9/118B BLOCK 2 RUMAH PANGSA\r\n', 'My contributions to student life are highlighted by the successful revitalization of the annual Campus Tech Symposium, where I oversaw a restructuring of the event format that led to a 40% increase in student attendance. I also pioneered a digital tracking system for volunteer hours that improved administrative accuracy by 30% and was eventually adopted by three other campus organizations. Furthermore, I secured over $5,000 in external sponsorship within a single semester through targeted outreach and professional pitching. My efforts in membership engagement were also recognized when I led a recruitment drive that expanded the association\'s active base by 25% in a six-month period.\r\n', 'During my tenure as a lead coordinator for the Student Activity Council, I managed the end-to-end planning and execution of large-scale campus events involving multiple internal and external stakeholders. My responsibilities included chairing weekly strategy meetings, managing a departmental budget, and facilitating communication between student volunteers and university administration. I specialized in streamlining recruitment processes for new members and developing training modules to ensure a high standard of event delivery. Additionally, I served as a primary liaison for corporate sponsors, negotiating terms for equipment and funding to support extracurricular initiatives.', 3, 'pending', NULL, '2026-02-01 12:47:53', '2026-02-01 12:47:53'),
(24, 6, '3.90', 1, 'Male', '2-04-10 JALAN 9/118B BLOCK 2 RUMAH PANGSA', 'My contributions to student life are highlighted by the successful revitalization of the annual Campus Tech Symposium, where I oversaw a restructuring of the event format that led to a 40% increase in student attendance. I also pioneered a digital tracking system for volunteer hours that improved administrative accuracy by 30% and was eventually adopted by three other campus organizations. Furthermore, I secured over $5,000 in external sponsorship within a single semester through targeted outreach and professional pitching. My efforts in membership engagement were also recognized when I led a recruitment drive that expanded the association\'s active base by 25% in a six-month period.', 'During my tenure as a lead coordinator for the Student Activity Council, I managed the end-to-end planning and execution of large-scale campus events involving multiple internal and external stakeholders. My responsibilities included chairing weekly strategy meetings, managing a departmental budget, and facilitating communication between student volunteers and university administration. I specialized in streamlining recruitment processes for new members and developing training modules to ensure a high standard of event delivery. Additionally, I served as a primary liaison for corporate sponsors, negotiating terms for equipment and funding to support extracurricular initiatives.', 5, 'pending', NULL, '2026-02-01 12:52:30', '2026-02-01 12:52:30'),
(25, 7, '3.95', 2, 'Male', '2-04-10 JALAN 9/118B BLOCK 2 RUMAH PANGSA\r\n', 'My contributions to student life are highlighted by the successful revitalization of the annual Campus Tech Symposium, where I oversaw a restructuring of the event format that led to a 40% increase in student attendance. I also pioneered a digital tracking system for volunteer hours that improved administrative accuracy by 30% and was eventually adopted by three other campus organizations. Furthermore, I secured over $5,000 in external sponsorship within a single semester through targeted outreach and professional pitching. My efforts in membership engagement were also recognized when I led a recruitment drive that expanded the association\'s active base by 25% in a six-month period.', 'During my tenure as a lead coordinator for the Student Activity Council, I managed the end-to-end planning and execution of large-scale campus events involving multiple internal and external stakeholders. My responsibilities included chairing weekly strategy meetings, managing a departmental budget, and facilitating communication between student volunteers and university administration. I specialized in streamlining recruitment processes for new members and developing training modules to ensure a high standard of event delivery. Additionally, I served as a primary liaison for corporate sponsors, negotiating terms for equipment and funding to support extracurricular initiatives.', 6, 'pending', NULL, '2026-02-01 12:54:44', '2026-02-01 12:54:44'),
(26, 8, '3.40', 3, 'Male', '2-04-10 JALAN 9/118B BLOCK 2 RUMAH PANGSA', 'My contributions to student life are highlighted by the successful revitalization of the annual Campus Tech Symposium, where I oversaw a restructuring of the event format that led to a 40% increase in student attendance. I also pioneered a digital tracking system for volunteer hours that improved administrative accuracy by 30% and was eventually adopted by three other campus organizations. Furthermore, I secured over $5,000 in external sponsorship within a single semester through targeted outreach and professional pitching. My efforts in membership engagement were also recognized when I led a recruitment drive that expanded the association\'s active base by 25% in a six-month period.', 'During my tenure as a lead coordinator for the Student Activity Council, I managed the end-to-end planning and execution of large-scale campus events involving multiple internal and external stakeholders. My responsibilities included chairing weekly strategy meetings, managing a departmental budget, and facilitating communication between student volunteers and university administration. I specialized in streamlining recruitment processes for new members and developing training modules to ensure a high standard of event delivery. Additionally, I served as a primary liaison for corporate sponsors, negotiating terms for equipment and funding to support extracurricular initiatives.', 7, 'pending', NULL, '2026-02-01 12:57:00', '2026-02-01 12:57:00'),
(27, 9, '3.30', 4, 'Male', '2-04-10 JALAN 9/118B BLOCK 2 RUMAH PANGSA', 'My contributions to student life are highlighted by the successful revitalization of the annual Campus Tech Symposium, where I oversaw a restructuring of the event format that led to a 40% increase in student attendance. I also pioneered a digital tracking system for volunteer hours that improved administrative accuracy by 30% and was eventually adopted by three other campus organizations. Furthermore, I secured over $5,000 in external sponsorship within a single semester through targeted outreach and professional pitching. My efforts in membership engagement were also recognized when I led a recruitment drive that expanded the association\'s active base by 25% in a six-month period.\r\n', 'During my tenure as a lead coordinator for the Student Activity Council, I managed the end-to-end planning and execution of large-scale campus events involving multiple internal and external stakeholders. My responsibilities included chairing weekly strategy meetings, managing a departmental budget, and facilitating communication between student volunteers and university administration. I specialized in streamlining recruitment processes for new members and developing training modules to ensure a high standard of event delivery. Additionally, I served as a primary liaison for corporate sponsors, negotiating terms for equipment and funding to support extracurricular initiatives.', 8, 'pending', NULL, '2026-02-01 12:58:34', '2026-02-01 12:58:34'),
(28, 10, '3.20', 1, 'Female', '2-04-10 JALAN 9/118B BLOCK 2 RUMAH PANGSA', 'My contributions to student life are highlighted by the successful revitalization of the annual Campus Tech Symposium, where I oversaw a restructuring of the event format that led to a 40% increase in student attendance. I also pioneered a digital tracking system for volunteer hours that improved administrative accuracy by 30% and was eventually adopted by three other campus organizations. Furthermore, I secured over $5,000 in external sponsorship within a single semester through targeted outreach and professional pitching. My efforts in membership engagement were also recognized when I led a recruitment drive that expanded the association\'s active base by 25% in a six-month period.', 'During my tenure as a lead coordinator for the Student Activity Council, I managed the end-to-end planning and execution of large-scale campus events involving multiple internal and external stakeholders. My responsibilities included chairing weekly strategy meetings, managing a departmental budget, and facilitating communication between student volunteers and university administration. I specialized in streamlining recruitment processes for new members and developing training modules to ensure a high standard of event delivery. Additionally, I served as a primary liaison for corporate sponsors, negotiating terms for equipment and funding to support extracurricular initiatives.', 9, 'pending', NULL, '2026-02-01 12:59:43', '2026-02-01 12:59:43'),
(29, 11, '3.10', 2, 'Female', '2-04-10 JALAN 9/118B BLOCK 2 RUMAH PANGSA', 'My contributions to student life are highlighted by the successful revitalization of the annual Campus Tech Symposium, where I oversaw a restructuring of the event format that led to a 40% increase in student attendance. I also pioneered a digital tracking system for volunteer hours that improved administrative accuracy by 30% and was eventually adopted by three other campus organizations. Furthermore, I secured over $5,000 in external sponsorship within a single semester through targeted outreach and professional pitching. My efforts in membership engagement were also recognized when I led a recruitment drive that expanded the association\'s active base by 25% in a six-month period.\r\n', 'During my tenure as a lead coordinator for the Student Activity Council, I managed the end-to-end planning and execution of large-scale campus events involving multiple internal and external stakeholders. My responsibilities included chairing weekly strategy meetings, managing a departmental budget, and facilitating communication between student volunteers and university administration. I specialized in streamlining recruitment processes for new members and developing training modules to ensure a high standard of event delivery. Additionally, I served as a primary liaison for corporate sponsors, negotiating terms for equipment and funding to support extracurricular initiatives.', 10, 'rejected', 'The information provided was found to be false or manipulated', '2026-02-01 13:01:14', '2026-02-01 13:22:57'),
(30, 12, '4.00', 4, 'Male', '2-04-10 JALAN 9/118B BLOCK 2 RUMAH PANGSA', 'My contributions to student life are highlighted by the successful revitalization of the annual Campus Tech Symposium, where I oversaw a restructuring of the event format that led to a 40% increase in student attendance. I also pioneered a digital tracking system for volunteer hours that improved administrative accuracy by 30% and was eventually adopted by three other campus organizations. Furthermore, I secured over $5,000 in external sponsorship within a single semester through targeted outreach and professional pitching. My efforts in membership engagement were also recognized when I led a recruitment drive that expanded the association\'s active base by 25% in a six-month period.', 'During my tenure as a lead coordinator for the Student Activity Council, I managed the end-to-end planning and execution of large-scale campus events involving multiple internal and external stakeholders. My responsibilities included chairing weekly strategy meetings, managing a departmental budget, and facilitating communication between student volunteers and university administration. I specialized in streamlining recruitment processes for new members and developing training modules to ensure a high standard of event delivery. Additionally, I served as a primary liaison for corporate sponsors, negotiating terms for equipment and funding to support extracurricular initiatives.', 11, 'accepted', NULL, '2026-02-01 13:03:44', '2026-02-01 13:21:46'),
(31, 5, '3.80', 4, 'Male', '2-04-10 JALAN 9/118B BLOCK 2 RUMAH PANGSA', 'My contributions to student life are highlighted by the successful revitalization of the annual Campus Tech Symposium, where I oversaw a restructuring of the event format that led to a 40% increase in student attendance. I also pioneered a digital tracking system for volunteer hours that improved administrative accuracy by 30% and was eventually adopted by three other campus organizations. Furthermore, I secured over $5,000 in external sponsorship within a single semester through targeted outreach and professional pitching. My efforts in membership engagement were also recognized when I led a recruitment drive that expanded the association\'s active base by 25% in a six-month period.', 'During my tenure as a lead coordinator for the Student Activity Council, I managed the end-to-end planning and execution of large-scale campus events involving multiple internal and external stakeholders. My responsibilities included chairing weekly strategy meetings, managing a departmental budget, and facilitating communication between student volunteers and university administration. I specialized in streamlining recruitment processes for new members and developing training modules to ensure a high standard of event delivery. Additionally, I served as a primary liaison for corporate sponsors, negotiating terms for equipment and funding to support extracurricular initiatives.', 4, 'pending', NULL, '2026-02-01 17:31:50', '2026-02-01 17:31:50');

-- --------------------------------------------------------

--
-- Table structure for table `interview_slots`
--

CREATE TABLE `interview_slots` (
  `id` int NOT NULL,
  `interview_date` date NOT NULL,
  `slot_time` varchar(20) NOT NULL COMMENT '8pm-9pm or 9pm-10pm',
  `is_booked` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `interview_slots`
--

INSERT INTO `interview_slots` (`id`, `interview_date`, `slot_time`, `is_booked`, `created_at`, `modified_at`) VALUES
(1, '2026-03-09', '8pm-9pm', 1, '2026-01-31 16:01:58', '2026-02-01 12:43:04'),
(2, '2026-03-09', '9pm-10pm', 1, '2026-01-31 16:02:09', '2026-02-01 12:46:21'),
(3, '2026-03-10', '8pm-9pm', 1, '2026-01-31 16:02:20', '2026-02-01 12:47:53'),
(4, '2026-03-10', '9pm-10pm', 1, '2026-01-31 16:02:42', '2026-02-01 17:31:50'),
(5, '2026-03-11', '8pm-9pm', 1, '2026-01-31 16:02:53', '2026-02-01 12:52:30'),
(6, '2026-03-11', '9pm-10pm', 1, '2026-01-31 16:03:04', '2026-02-01 12:54:44'),
(7, '2026-03-16', '8pm-9pm', 1, '2026-01-31 16:03:55', '2026-02-01 12:57:00'),
(8, '2026-03-16', '9pm-10pm', 1, '2026-01-31 16:04:11', '2026-02-01 12:58:34'),
(9, '2026-03-17', '8pm-9pm', 1, '2026-01-31 16:05:38', '2026-02-01 12:59:43'),
(10, '2026-03-17', '9pm-10pm', 1, '2026-01-31 16:05:47', '2026-02-01 13:01:14'),
(11, '2026-03-18', '8pm-9pm', 1, '2026-01-31 16:08:28', '2026-02-01 13:03:44');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `size` varchar(10) DEFAULT NULL,
  `quantity` int NOT NULL,
  `shipping_address` text,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','waiting for pickup','complete') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `size`, `quantity`, `shipping_address`, `total_price`, `status`, `created_at`, `modified_at`) VALUES
(27, 12, 180, 'M', 9, 'Self-Pickup at Kolej Jasmine', '495.00', 'pending', '2026-01-31 17:27:29', '2026-01-31 17:27:29'),
(28, 2, 180, 'XS', 6, 'Self-Pickup at Kolej Jasmine', '330.00', 'pending', '2026-02-01 12:43:22', '2026-02-01 12:43:22'),
(29, 2, 208, 'N/A', 6, 'Self-Pickup at Kolej Jasmine', '30.00', 'pending', '2026-02-01 12:43:34', '2026-02-01 12:43:34'),
(30, 2, 202, 'N/A', 10, 'Self-Pickup at Kolej Jasmine', '50.00', 'pending', '2026-02-01 12:43:57', '2026-02-01 12:43:57'),
(31, 2, 195, 'N/A', 4, 'Self-Pickup at Kolej Jasmine', '100.00', 'pending', '2026-02-01 12:44:07', '2026-02-01 12:44:07'),
(32, 2, 193, 'L', 3, 'Self-Pickup at Kolej Jasmine', '150.00', 'pending', '2026-02-01 12:44:17', '2026-02-01 12:44:17'),
(33, 2, 188, 'XL', 2, 'Self-Pickup at Kolej Jasmine', '76.00', 'pending', '2026-02-01 12:44:29', '2026-02-01 12:44:29'),
(34, 2, 181, 'L', 1, 'Self-Pickup at Kolej Jasmine', '50.00', 'pending', '2026-02-01 12:44:36', '2026-02-01 12:44:36'),
(35, 3, 209, 'N/A', 1, 'Self-Pickup at Kolej Jasmine', '5.00', 'pending', '2026-02-01 12:46:44', '2026-02-01 12:46:44'),
(36, 8, 182, 'M', 10, 'Self-Pickup at Kolej Jasmine', '600.00', 'waiting for pickup', '2026-02-01 12:55:51', '2026-02-01 18:32:12'),
(37, 12, 181, 'L', 4, 'Self-Pickup at Kolej Jasmine', '200.00', 'complete', '2026-02-01 18:20:09', '2026-02-01 18:32:08');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `category` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` enum('open','closed') DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `image`, `status`, `created_at`, `modified_at`) VALUES
(180, 'Ronin Cat (Limited)', 'New Arrival', '55.00', 'RONIN CAT.png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(181, 'Scientific Revolution', 'New Arrival', '50.00', 'SCIENTIFIC REVOLUTION.png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(182, 'Shuten Douji (Mythic)', 'New Arrival', '60.00', 'SHUTEN DOUJI.png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(183, 'Year of Snake (Edition A)', 'New Arrival', '55.00', 'YEAR OF SNAKE.png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(184, 'Year of Snake (Edition B)', 'New Arrival', '55.00', 'YEAR OF SNAKE (3).png', 'closed', '2026-01-11 21:35:39', '2026-01-29 06:12:19'),
(185, 'Street Graffiti Ivory', 'T-Shirt Ivory Edition', '35.00', 'STREET GRAFITTI.png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(186, 'The Racer Ivory', 'T-Shirt Ivory Edition', '40.00', 'THE RACER.png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(187, 'Couple Dream Ivory', 'T-Shirt Ivory Edition', '35.00', 'COUPLE DREAM.png', 'closed', '2026-01-11 21:35:39', '2026-01-31 16:09:39'),
(188, 'Never Stray Ivory', 'T-Shirt Ivory Edition', '38.00', 'NEVER STRAY OF PATH.png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(189, 'Burning Skull Ivory', 'T-Shirt Ivory Edition', '45.00', 'BURNING SKULL.png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(190, 'Bear Badonkers Raven', 'T-Shirt Raven Edition', '45.00', 'BEAR BADONKERS.png', 'closed', '2026-01-11 21:35:39', '2026-01-31 16:09:57'),
(191, 'King Apes Raven', 'T-Shirt Raven Edition', '45.00', 'KING APES.png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(192, 'Original Design Raven', 'T-Shirt Raven Edition', '35.00', 'ORIGINAL DESIGN.png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(193, 'Penelope Odyssey Raven', 'T-Shirt Raven Edition', '50.00', 'PENELOPE ODYSSEY.png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(194, 'Believer Raven', 'T-Shirt Raven Edition', '40.00', 'BELIEVER.png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(195, 'Better Days Ahead Bag', 'Tote Bags', '25.00', 'TOTE BAG.png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(196, 'Reality Reality Reality Bag', 'Tote Bags', '25.00', 'TOTE BAG (2).png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(197, 'Early Brewers Club Bag', 'Tote Bags', '28.00', 'TOTE BAG 2.png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(198, 'Self-Care Definition Bag', 'Tote Bags', '22.00', 'TOTE BAG (3).png', 'closed', '2026-01-11 21:35:39', '2026-01-31 16:11:48'),
(199, 'Push Your Limit Bag', 'Tote Bags', '25.00', 'TOTE BAG (4).png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(200, 'Happiness Love Badge', 'Badges Ivory Edition', '5.00', '99.png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(201, 'Not Lazy Badge', 'Badges Ivory Edition', '5.00', 'BADGES (5).png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(202, 'Chase Your Dream Badge', 'Badges Ivory Edition', '5.00', 'BADGES (2).png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(203, 'Limited Edition Badge', 'Badges Ivory Edition', '5.00', 'BADGES (3).png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(204, 'Enjoy Summer Badge', 'Badges Ivory Edition', '5.00', 'BADGES (4).png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(205, 'Own Your Story Badge', 'Badges Raven Edition', '5.00', 'BADGES (9).png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(206, 'Love Music Badge', 'Badges Raven Edition', '5.00', 'BADGES (10).png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(207, 'Purrfectly Cute Badge', 'Badges Raven Edition', '5.00', 'BADGES (7).png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(208, 'Apex Street Badge', 'Badges Raven Edition', '5.00', 'BADGES (8).png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39'),
(209, 'Just Be Cool Badge', 'Badges Raven Edition', '5.00', 'BADGES (6).png', 'open', '2026-01-11 21:35:39', '2026-01-11 21:35:39');

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `venue` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `google_form_url` varchar(500) DEFAULT NULL,
  `created_by` int NOT NULL,
  `status` enum('upcoming','complete') DEFAULT 'upcoming',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `name`, `venue`, `date`, `description`, `google_form_url`, `created_by`, `status`, `created_at`, `modified_at`) VALUES
(38, 'Pengurusan Mayat', 'Surau Puncak Perdana', '2026-03-01', 'Organized by Persatuan Mahasiswa Hadhari and Unit Hal Ehwal Islam UiTM, this program offers Puncak Perdana students free access to spiritual and morale-boosting sessions. Participants earn e-merit while enhancing their holistic well-being. It’s a premier platform designed to foster a balanced, resilient, and spiritually grounded campus community.', 'https://forms.gle/jzfYaKfX5xmVprNK8', 1, 'upcoming', '2026-02-01 13:10:00', '2026-02-01 13:10:00'),
(39, 'Oh My Tajwid', 'Surau Puncak Perdana', '2026-03-02', 'Organized by Persatuan Mahasiswa Hadhari and Unit Hal Ehwal Islam UiTM, this program offers Puncak Perdana students free access to spiritual and morale-boosting sessions. Participants earn e-merit while enhancing their holistic well-being. It’s a premier platform designed to foster a balanced, resilient, and spiritually grounded campus community.', 'https://forms.gle/jzfYaKfX5xmVprNK8', 1, 'upcoming', '2026-02-01 13:10:34', '2026-02-01 13:10:34'),
(40, 'Oh My Tajwid', 'Surau Puncak Perdana', '2026-03-03', 'Organized by Persatuan Mahasiswa Hadhari and Unit Hal Ehwal Islam UiTM, this program offers Puncak Perdana students free access to spiritual and morale-boosting sessions. Participants earn e-merit while enhancing their holistic well-being. It’s a premier platform designed to foster a balanced, resilient, and spiritually grounded campus community.', 'https://forms.gle/jzfYaKfX5xmVprNK8', 1, 'upcoming', '2026-02-01 13:11:03', '2026-02-01 13:11:03'),
(41, 'The Taranum Finale', 'DEWAN SERBAGUNA KOLEJ JASMINE', '2026-03-04', 'Organized by Persatuan Mahasiswa Hadhari and Unit Hal Ehwal Islam UiTM, this program offers Puncak Perdana students free access to spiritual and morale-boosting sessions. Participants earn e-merit while enhancing their holistic well-being. It’s a premier platform designed to foster a balanced, resilient, and spiritually grounded campus community.', 'https://forms.gle/jzfYaKfX5xmVprNK8', 1, 'upcoming', '2026-02-01 13:11:26', '2026-02-01 13:11:26'),
(42, 'Pengurusan Jenazah', 'Masjid Sendayan', '2026-03-05', 'Organized by Persatuan Mahasiswa Hadhari and Unit Hal Ehwal Islam UiTM, this program offers Puncak Perdana students free access to spiritual and morale-boosting sessions. Participants earn e-merit while enhancing their holistic well-being. It’s a premier platform designed to foster a balanced, resilient, and spiritually grounded campus community.', '', 1, 'upcoming', '2026-02-01 13:12:05', '2026-02-01 17:08:53'),
(43, 'MAJLIS TILAWAH ALQURAN PERINGKAT KEBANGSAAN', 'DEWAN SERBAGUNA KOLEJ JASMINE', '2026-02-28', 'Organized by Persatuan Mahasiswa Hadhari and Unit Hal Ehwal Islam UiTM, this program offers Puncak Perdana students free access to spiritual and morale-boosting sessions. Participants earn e-merit while enhancing their holistic well-being. It’s a premier platform designed to foster a balanced, resilient, and spiritually grounded campus community.', 'https://forms.gle/jzfYaKfX5xmVprNK8', 1, 'upcoming', '2026-02-01 13:13:27', '2026-02-01 13:13:27'),
(45, 'Word of Wisdom', 'Surau Puncak Perdana', '2025-02-01', 'Organized by Persatuan Mahasiswa Hadhari and Unit Hal Ehwal Islam UiTM, this program offers Puncak Perdana students free access to spiritual and morale-boosting sessions. Participants earn e-merit while enhancing their holistic well-being. It’s a premier platform designed to foster a balanced, resilient, and spiritually grounded campus community.', 'https://forms.gle/jzfYaKfX5xmVprNK8', 1, 'complete', '2026-02-01 13:14:36', '2026-02-01 13:14:36'),
(46, 'Word of Wisdom', 'Surau Puncak Perdana', '2025-03-01', 'Organized by Persatuan Mahasiswa Hadhari and Unit Hal Ehwal Islam UiTM, this program offers Puncak Perdana students free access to spiritual and morale-boosting sessions. Participants earn e-merit while enhancing their holistic well-being. It’s a premier platform designed to foster a balanced, resilient, and spiritually grounded campus community.', 'https://forms.gle/jzfYaKfX5xmVprNK8', 1, 'complete', '2026-02-01 13:15:10', '2026-02-01 13:15:10'),
(47, 'Word of Wisdom', 'Surau Puncak Perdana', '2025-04-01', 'Organized by Persatuan Mahasiswa Hadhari and Unit Hal Ehwal Islam UiTM, this program offers Puncak Perdana students free access to spiritual and morale-boosting sessions. Participants earn e-merit while enhancing their holistic well-being. It’s a premier platform designed to foster a balanced, resilient, and spiritually grounded campus community.', 'https://forms.gle/jzfYaKfX5xmVprNK8', 1, 'complete', '2026-02-01 13:15:26', '2026-02-01 13:15:52'),
(48, 'Word of Wisdom', 'Surau Puncak Perdana', '2025-07-01', 'Organized by Persatuan Mahasiswa Hadhari and Unit Hal Ehwal Islam UiTM, this program offers Puncak Perdana students free access to spiritual and morale-boosting sessions. Participants earn e-merit while enhancing their holistic well-being. It’s a premier platform designed to foster a balanced, resilient, and spiritually grounded campus community.', 'https://forms.gle/jzfYaKfX5xmVprNK8', 1, 'complete', '2026-02-01 13:17:07', '2026-02-01 13:17:07'),
(49, 'Word of Wisdom', 'Surau Puncak Perdana', '2025-01-03', 'Organized by Persatuan Mahasiswa Hadhari and Unit Hal Ehwal Islam UiTM, this program offers Puncak Perdana students free access to spiritual and morale-boosting sessions. Participants earn e-merit while enhancing their holistic well-being. It’s a premier platform designed to foster a balanced, resilient, and spiritually grounded campus community.', 'https://forms.gle/jzfYaKfX5xmVprNK8', 1, 'complete', '2026-02-01 13:17:51', '2026-02-01 13:17:51'),
(50, 'Word of Wisdom', 'Surau Puncak Perdana', '2025-08-01', 'Organized by Persatuan Mahasiswa Hadhari and Unit Hal Ehwal Islam UiTM, this program offers Puncak Perdana students free access to spiritual and morale-boosting sessions. Participants earn e-merit while enhancing their holistic well-being. It’s a premier platform designed to foster a balanced, resilient, and spiritually grounded campus community.', 'https://forms.gle/jzfYaKfX5xmVprNK8', 1, 'complete', '2026-02-01 13:18:52', '2026-02-01 13:18:52'),
(51, 'Word of Wisdom', 'Surau Puncak Perdana', '2025-09-01', 'Organized by Persatuan Mahasiswa Hadhari and Unit Hal Ehwal Islam UiTM, this program offers Puncak Perdana students free access to spiritual and morale-boosting sessions. Participants earn e-merit while enhancing their holistic well-being. It’s a premier platform designed to foster a balanced, resilient, and spiritually grounded campus community.', 'https://forms.gle/jzfYaKfX5xmVprNK8', 1, 'complete', '2026-02-01 13:19:14', '2026-02-01 13:19:14'),
(52, 'Word of Wisdom', 'Surau Puncak Perdana', '2025-12-01', 'Organized by Persatuan Mahasiswa Hadhari and Unit Hal Ehwal Islam UiTM, this program offers Puncak Perdana students free access to spiritual and morale-boosting sessions. Participants earn e-merit while enhancing their holistic well-being. It’s a premier platform designed to foster a balanced, resilient, and spiritually grounded campus community.', 'https://forms.gle/jzfYaKfX5xmVprNK8', 1, 'complete', '2026-02-01 13:19:54', '2026-02-01 13:19:54'),
(53, 'Word of Wisdom', 'Surau Puncak Perdana', '2025-12-19', 'Organized by Persatuan Mahasiswa Hadhari and Unit Hal Ehwal Islam UiTM, this program offers Puncak Perdana students free access to spiritual and morale-boosting sessions. Participants earn e-merit while enhancing their holistic well-being. It’s a premier platform designed to foster a balanced, resilient, and spiritually grounded campus community.', 'https://forms.gle/jzfYaKfX5xmVprNK8', 1, 'complete', '2026-02-01 13:20:14', '2026-02-01 13:20:14'),
(54, 'Word of Wisdom', 'Surau Puncak Perdana', '2025-12-26', 'Organized by Persatuan Mahasiswa Hadhari and Unit Hal Ehwal Islam UiTM, this program offers Puncak Perdana students free access to spiritual and morale-boosting sessions. Participants earn e-merit while enhancing their holistic well-being. It’s a premier platform designed to foster a balanced, resilient, and spiritually grounded campus community.', 'https://forms.gle/jzfYaKfX5xmVprNK8', 1, 'upcoming', '2026-02-01 13:20:34', '2026-02-01 13:20:34'),
(55, 'Word of Wisdom', 'Surau Puncak Perdana', '2025-01-02', 'Organized by Persatuan Mahasiswa Hadhari and Unit Hal Ehwal Islam UiTM, this program offers Puncak Perdana students free access to spiritual and morale-boosting sessions. Participants earn e-merit while enhancing their holistic well-being. It’s a premier platform designed to foster a balanced, resilient, and spiritually grounded campus community.', 'https://forms.gle/jzfYaKfX5xmVprNK8', 1, 'complete', '2026-02-01 17:08:41', '2026-02-01 17:08:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `matric_no` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','student') NOT NULL DEFAULT 'student',
  `status` varchar(50) DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `matric_no`, `email`, `phone_no`, `password`, `role`, `status`, `created_at`, `modified_at`) VALUES
(1, 'ADMIN PMH', 'ADMIN01', 'admin@pmh.uitm.edu.my', '0380008000', '$2y$10$HioaC9QbOqiLUZ5c0Ea5zeFKXT7QD2SZi53XtReLoeBig7G0XeDKu', 'admin', 'active', '2026-01-11 16:01:35', '2026-01-31 15:54:57'),
(2, 'Jamal Abdillah', '2025111222', 'student01@gmail.com', '0178436055', '$2y$10$fFPb.5qC0lxzpbmxbglhjeqBSlOwwYl3dV/y4.BOBhD6jTaK9qbwW', 'student', 'active', '2026-01-31 15:30:02', '2026-01-31 15:36:36'),
(3, 'Siti Ramlah', '2025222333', 'student02@gmail.com', '0178436055', '$2y$10$j5RMzbX22Fg2f/OjbhHTXOlGmzSWr5eDe.B/6aldikvrRgrpOlsxy', 'student', 'active', '2026-01-31 15:39:36', '2026-01-31 15:40:31'),
(4, 'Abdul Wahab', '2025333444', 'student03@gmail.com', '0178436055', '$2y$10$MfrlAfiQMV7jNivh3Pl.wuZD58bdObvARprF3pbSE9ijG0mnltrR.', 'student', 'active', '2026-01-31 15:40:09', '2026-01-31 15:40:31'),
(5, 'Wafiq Jamaludin', '2025444555', 'student04@gmail.com', '0178436055', '$2y$10$lALXG1DlRaZMcVApBZog7.Z5pfgDeQILa867EG5jDWQMd1BYY55Gq', 'student', 'active', '2026-01-31 15:41:37', '2026-01-31 15:56:37'),
(6, 'Mahathir Razak', '2025555444', 'student05@gmail.com', '0178436055', '$2y$10$Ewwv23np0kMNI28Q8KWqpOjmiMk8NdG.NxSh/LN0C27JUMill1IJa', 'student', 'active', '2026-01-31 15:42:31', '2026-01-31 15:56:37'),
(7, 'Anwar Yassin', '2025666777', 'student06@gmail.com', '0178436055', '$2y$10$WQWyKU3TUxiS6DI9pZubAO94gqfvd0rT6ECnSdo4AH7XJjjXFgHZm', 'student', 'active', '2026-01-31 15:43:13', '2026-01-31 15:56:37'),
(8, 'Hadi Sanusi', '2025777888', 'student07@gmail.com', '0178436055', '$2y$10$U3MSXX3TVIUcUJpjcDKn/O1sIA0GRUQB/BUW3SocewqKNMKo2.SAi', 'student', 'active', '2026-01-31 15:44:35', '2026-01-31 15:56:37'),
(9, 'Jokowi Trump', '2025888999', 'student08@gmail.com', '0178436055', '$2y$10$ma7Zb8zxHH9duc.0pUHCheotvz054Gl5BX48mEFjfguKBGH4f402e', 'student', 'active', '2026-01-31 15:46:23', '2026-01-31 15:56:37'),
(10, 'Nur Bainun', '2025999000', 'student09@gmail.com', '0178436055', '$2y$10$1RaqF28B.feVN.nCoQEwo.T5j5dSoIZniHM.7eE7IOx0NkwMmlIGu', 'student', 'active', '2026-01-31 15:47:21', '2026-01-31 15:56:37'),
(11, 'Rosmah Norhaliza', '2025000111', 'student10@gmail.com', '0178436055', '$2y$10$daLTqSGRKdQaMXL8u55MDO0fGInc4bvD.qFIYYQvgBTHXrvtL7Yi.', 'student', 'active', '2026-01-31 15:48:52', '2026-01-31 15:56:37'),
(12, 'Muhammad Zahid Hanafi', '2025127713', 'zahidhanafi52@gmail.com', '0178436055', '$2y$10$v5nZfG3UF8io6wSu3y1lk./ByygoHEE96nfXO81O3ySp/emVgO/mm', 'student', 'active', '2026-01-31 15:49:17', '2026-01-31 15:56:37'),
(13, 'Testing', '2025123456', 'testing@gmail.com', '0178436055', '$2y$10$6T/at/hAj8WC1coVrLezKewLHpJNOwJ2xWYU15a/CYL95GDSuQAQy', 'student', 'active', '2026-01-31 15:52:51', '2026-01-31 15:56:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_user` (`user_id`),
  ADD KEY `fk_applications_interview_slots` (`interview_slot_id`);

--
-- Indexes for table `interview_slots`
--
ALTER TABLE `interview_slots`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_date_slot` (`interview_date`,`slot_time`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_user` (`user_id`),
  ADD KEY `fk_order_product` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_program_admin` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `matric_no` (`matric_no`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `interview_slots`
--
ALTER TABLE `interview_slots`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `fk_app_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_applications_interview_slots` FOREIGN KEY (`interview_slot_id`) REFERENCES `interview_slots` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_order_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `fk_program_admin` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
