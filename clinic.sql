-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2023 at 02:39 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(30) NOT NULL,
  `patient_id` int(30) NOT NULL,
  `date_sched` datetime NOT NULL,
  `ailment` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `date_sched`, `ailment`, `status`, `date_created`) VALUES
(6, 6, '2023-10-27 08:00:00', 'Sample Ailment', 0, '2021-09-02 21:58:59'),
(10, 9, '2023-10-27 09:30:00', 'Stomach ache for about 3 days', 0, '2021-09-02 23:14:50'),
(11, 10, '2023-10-27 11:00:00', 'Flesh wound', 1, '2021-09-02 23:23:05'),
(12, 11, '2023-10-27 13:00:00', 'test', 1, '2021-09-02 23:44:32'),
(127, 3, '2023-11-09 14:45:00', 'sakit', 0, '2023-11-09 00:45:36'),
(128, 3, '2023-11-23 14:48:00', 'sakit', 0, '2023-11-10 04:48:15');

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(100) NOT NULL,
  `title` text NOT NULL,
  `category` varchar(100) NOT NULL,
  `article` longtext NOT NULL,
  `image` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `isActive` tinyint(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `title`, `category`, `article`, `image`, `author`, `date`, `isActive`) VALUES
(1, 'Do gut bacteria contribute to ethnic health disparities\r\n', 'Cardiology', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sit amet est vel orci luctus sollicitudin. Duis eleifend vestibulum justo, varius semper lacus condimentum dictum. Donec pulvinar a magna ut malesuada. In posuere felis diam, vel sodales metus accumsan in. Duis viverra dui eu pharetra pellentesque. Donec a eros leo. Quisque sed ligula vitae lorem efficitur faucibus. Praesent sit amet imperdiet ante. Nulla id tellus auctor, dictum libero a, malesuada nisi. Nulla in porta nibh, id vestibulum ipsum. Praesent dapibus tempus erat quis aliquet. Donec ac purus id sapien condimentum feugiat.\r\n\r\nPraesent vel mi bibendum, finibus leo ac, condimentum arcu. Pellentesque sem ex, tristique sit amet suscipit in, mattis imperdiet enim. Integer tempus justo nec velit fringilla, eget eleifend neque blandit. Sed tempor magna sed congue auctor. Mauris eu turpis eget tortor ultricies elementum. Phasellus vel placerat orci, a venenatis justo. Phasellus faucibus venenatis nisl vitae vestibulum. Praesent id nibh arcu. Vivamus sagittis accumsan felis, quis vulputate', 'article2.jpg', 'Dr. Stein Adeline', '2023-10-17 15:25:45', 1),
(2, 'What are the nonmedical factors most closely linked to death risk?\r\n', 'Neulorogy', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sit amet est vel orci luctus sollicitudin. Duis eleifend vestibulum justo, varius semper lacus condimentum dictum. Donec pulvinar a magna ut malesuada. In posuere felis diam, vel sodales metus accumsan in. Duis viverra dui eu pharetra pellentesque. Donec a eros leo. Quisque sed ligula vitae lorem efficitur faucibus. Praesent sit amet imperdiet ante. Nulla id tellus auctor, dictum libero a, malesuada nisi. Nulla in porta nibh, id vestibulum ipsum. Praesent dapibus tempus erat quis aliquet. Donec ac purus id sapien condimentum feugiat.\r\n\r\nPraesent vel mi bibendum, finibus leo ac, condimentum arcu. Pellentesque sem ex, tristique sit amet suscipit in, mattis imperdiet enim. Integer tempus justo nec velit fringilla, eget eleifend neque blandit. Sed tempor magna sed congue auctor. Mauris eu turpis eget tortor ultricies elementum. Phasellus vel placerat orci, a venenatis justo. Phasellus faucibus venenatis nisl vitae vestibulum. Praesent id nibh arcu. Vivamus sagittis accumsan felis, quis vulputate', 'article1.jpg', 'Dr. Stein Adeline', '2023-10-17 08:49:37', 0),
(3, 'Racism in mental healthcare: An invisible barrier', 'General Health', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sit amet est vel orci luctus sollicitudin. Duis eleifend vestibulum justo, varius semper lacus condimentum dictum. Donec pulvinar a magna ut malesuada. In posuere felis diam, vel sodales metus accumsan in. Duis viverra dui eu pharetra pellentesque. Donec a eros leo. Quisque sed ligula vitae lorem efficitur faucibus. Praesent sit amet imperdiet ante. Nulla id tellus auctor, dictum libero a, malesuada nisi. Nulla in porta nibh, id vestibulum ipsum. Praesent dapibus tempus erat quis aliquet. Donec ac purus id sapien condimentum feugiat.\r\n\r\nPraesent vel mi bibendum, finibus leo ac, condimentum arcu. Pellentesque sem ex, tristique sit amet suscipit in, mattis imperdiet enim. Integer tempus justo nec velit fringilla, eget eleifend neque blandit. Sed tempor magna sed congue auctor. Mauris eu turpis eget tortor ultricies elementum. Phasellus vel placerat orci, a venenatis justo. Phasellus faucibus venenatis nisl vitae vestibulum. Praesent id nibh arcu. Vivamus sagittis accumsan felis, quis vulputate', 'article3.jpg', 'Dr. Stein Adeline', '2023-10-17 15:46:18', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL,
  `discount` int(10) NOT NULL,
  `stock` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`, `discount`, `stock`) VALUES
(25, 5, 12, 'FOREHEALTH Infrared Ear Thermometer 1s', 209, 1, 'tmmt3.PNG', 10, 20),
(29, 3, 12, 'FOREHEALTH Infrared Ear Thermometer 1s', 209, 5, 'tmmt3.PNG', 10, 20),
(31, 3, 11, 'FOREHEALTH ACT3020EX Rapid 10s Digital Thermometer 1s', 36, 1, 'tmmt1.PNG', 0, 30);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `subject`, `message`, `status`) VALUES
(1, 'yinqin', 'yinwin999@gmail.com', 'qqq', 'so sad', 0),
(2, 'yinqin', 'yinwin999@gmail.com', 'qqq', 'so sad', 1),
(3, 'yinqin', 'yinwin999@gmail.com', 'qqq', 'so sad', 0),
(4, 'yinqin', 'yinwin999@gmail.com', 'appointment issue', 'can you help me cancel my appointment i submit wrong time', 0),
(5, '', '', '', '', 0),
(6, '2222', '222@gmail.com', '2222', '2222', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `reference_number` varchar(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT '2',
  `s_status` int(15) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `reference_number`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `status`, `s_status`) VALUES
(1, '031984040839', 3, 'qweqwe', '0123456789', 'weiyi1089@gmail.com', 'cash on delivery', '88, taman inti, gelugor, pinang, malaysia ， 06000', 'Super wheelchair (350 x 1) - ', 350, '2023-10-03 16:46:59', '1', 0),
(2, '650934150280', 3, 'qweqwe', '0123456789', 'weiyi1089@gmail.com', 'cash on delivery', '88, taman inti, gelugor, pinang, malaysia ， 06000', 'Super wheelchair (350 x 1) - ', 350, '2023-12-03 16:47:27', '1', 0),
(3, '125217748992', 3, 'qweqwe', '0123456789', 'weiyi1089@gmail.com', 'cash on delivery', '88, taman inti, gelugor, pinang, malaysia ， 06000', 'Super wheelchair (350 x 1) - ', 315, '2023-10-18 06:33:36', '2', 0),
(4, '824408689607', 3, 'yinqinn', '0123456789', 'weiyi1089@gmail.com', 'cash on delivery', '88, taman inti, gelugor, pinang, malaysia ， 06000', 'Karma Ergo Lite Ultralight Wheelchair (14\") (1899 x 1) - ProDetect® COVID-19 Antigen Rapid Self-Test Kit (Saliva) (9 x 1) - ', 1908, '2023-11-08 03:58:32', '2', 0),
(5, '427321651958', 3, 'yinqinn', '0123456789', 'weiyi1089@gmail.com', 'cash on delivery', '88, taman inti, gelugor, pinang, malaysia ， 06000', 'FOREHEALTH Infrared Ear Thermometer 1s (209 x 4) - ', 836, '2023-11-08 06:58:26', '2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `patient_list`
--

CREATE TABLE `patient_list` (
  `id` int(30) NOT NULL,
  `name` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_list`
--

INSERT INTO `patient_list` (`id`, `name`, `date_created`) VALUES
(3, 'yinqinn', '2023-11-09 00:45:21'),
(6, 'John Smith', '2021-09-02 21:58:59'),
(9, 'Claire Blake', '2021-09-02 23:14:50'),
(10, 'Claire Blake', '2021-09-02 23:23:05'),
(11, 'Mike Williams', '2021-09-02 23:44:32');

-- --------------------------------------------------------

--
-- Table structure for table `patient_meta`
--

CREATE TABLE `patient_meta` (
  `patient_id` int(30) NOT NULL,
  `meta_field` text DEFAULT NULL,
  `meta_value` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_meta`
--

INSERT INTO `patient_meta` (`patient_id`, `meta_field`, `meta_value`, `date_created`) VALUES
(6, 'id', '6', '2023-10-27 02:06:44'),
(6, 'patient_id', '6', '2023-10-27 02:06:44'),
(6, 'name', 'John Smith', '2023-10-27 02:06:44'),
(6, 'email', 'jsmith@sample.com', '2023-10-27 02:06:44'),
(6, 'contact', '09123456789', '2023-10-27 02:06:44'),
(6, 'gender', 'Male', '2023-10-27 02:06:44'),
(6, 'dob', '1997-06-23', '2023-10-27 02:06:44'),
(6, 'address', 'Sample Address', '2023-10-27 02:06:44'),
(11, 'id', '12', '2023-10-27 02:06:50'),
(11, 'patient_id', '11', '2023-10-27 02:06:50'),
(11, 'name', 'Samantha Lou', '2023-10-27 02:06:50'),
(11, 'email', 'slou@sample.com', '2023-10-27 02:06:50'),
(11, 'contact', '09123654456', '2023-10-27 02:06:50'),
(11, 'gender', 'Female', '2023-10-27 02:06:50'),
(11, 'dob', '1990-12-07', '2023-10-27 02:06:50'),
(11, 'address', 'Sample Address', '2023-10-27 02:06:50'),
(9, 'id', '10', '2023-10-27 02:06:56'),
(9, 'patient_id', '9', '2023-10-27 02:06:56'),
(9, 'name', 'Claire Blake', '2023-10-27 02:06:56'),
(9, 'email', 'cblake@sample.com', '2023-10-27 02:06:56'),
(9, 'contact', '09123789456', '2023-10-27 02:06:56'),
(9, 'gender', 'Female', '2023-10-27 02:06:56'),
(9, 'dob', '1997-06-23', '2023-10-27 02:06:56'),
(9, 'address', 'Sample Address', '2023-10-27 02:06:56'),
(10, 'id', '11', '2023-10-27 02:07:13'),
(10, 'patient_id', '10', '2023-10-27 02:07:13'),
(10, 'name', 'Mike Williams', '2023-10-27 02:07:13'),
(10, 'email', 'mwilliams@sample.com', '2023-10-27 02:07:13'),
(10, 'contact', '09789456321', '2023-10-27 02:07:13'),
(10, 'gender', 'Female', '2023-10-27 02:07:13'),
(10, 'dob', '1990-12-10', '2023-10-27 02:07:13'),
(10, 'address', 'Sample Address', '2023-10-27 02:07:13'),
(3, 'name', 'yinqinn', '2023-11-09 00:45:36'),
(3, 'email', 'weiyi1089@gmail.com   ', '2023-11-09 00:45:36'),
(3, 'gender', 'Male', '2023-11-09 00:45:36'),
(3, 'contact', '0123456789   ', '2023-11-09 00:45:36'),
(3, 'dob', '2023-11-02', '2023-11-09 00:45:36'),
(3, 'id', '', '2023-11-09 00:45:36'),
(3, 'patient_id', '', '2023-11-09 00:45:36'),
(3, 'submit', '', '2023-11-09 00:45:36'),
(3, 'name', 'yinqinn', '2023-11-10 04:48:15'),
(3, 'email', 'weiyi1089@gmail.com   ', '2023-11-10 04:48:15'),
(3, 'gender', 'Male', '2023-11-10 04:48:15'),
(3, 'contact', '0123456789   ', '2023-11-10 04:48:15'),
(3, 'dob', '2023-11-09', '2023-11-10 04:48:15'),
(3, 'id', '', '2023-11-10 04:48:15'),
(3, 'patient_id', '', '2023-11-10 04:48:15'),
(3, 'submit', '', '2023-11-10 04:48:15');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(10) NOT NULL,
  `image_01` varchar(100) NOT NULL,
  `image_02` varchar(100) NOT NULL,
  `image_03` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `discount` int(10) DEFAULT NULL,
  `stock` int(100) NOT NULL,
  `isActive` tinyint(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `price`, `image_01`, `image_02`, `image_03`, `category`, `discount`, `stock`, `isActive`) VALUES
(3, 'Super wheelchair', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt neque sit, explicabo vero nulla animi nemo quae cumque, eaque pariatur eum ut maxime! Tenetur aperiam maxime iure explicabo aut consequuntur. Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt neque sit, explicabo vero nulla animi nemo quae cumque, eaque pariatur eum ut maxime! Tenetur aperiam maxime iure explicabo aut consequuntur.\r\n\r\n', 350, 'wheelchair_01.jpg', 'download.jpg', 'download.jpg', 'wheelchair', NULL, 16, 1),
(4, 'Face Mask', '* Correct wearing method\r\n1.Open the mask and fold it\r\n2. Stick the mask on your face, put your nose on the top,\r\n3. Hang on the ear, adjust the size of the mask to completely cover the nose and mouth,\r\n4. Use both hands to adjust the bridge of the nose on both sides of the mask.\r\n\r\n* Features:\r\n1. 3-layer protective mask: lightweight but not bulky, one more layer of protection and one more layer of peace of mind for your health.\r\n2. Comfortable materials: Allows you to wear them for a long time', 1, 'mask1.jpeg', 'mask2.jpeg', '', 'mask', 0, 100, 0),
(5, 'Neutrovis Premium 4 Ply Medical Face Mask 50&#39;s White', 'White - A Wardrobe Staple! Neutrovis Premium Medical Face Mask now comes in 4-ply in Premium White. Made of premium melt-blown filter fabric with 98% BFE (Bacterial Filtration Efficiency) and 96% PFE (Particle Filtration Efficiency), the face mask effectively blocks viable (live) and nonviable (nonliving) particles such as bacteria, pollen and dust particles from our surroundings. Perfect for sensitive skin.', 20, 'Neutrovis1.png', 'Neutrovis2.png', 'Neutrovis3.png', 'mask', 0, 100, 0),
(6, 'First Aid Kits - Medium', 'Features:\r\nMade from high quality plastic box.\r\nSuitable for low risk areas and up to 25 employees.\r\nSize: 300 x 160 x 100mm', 30, 'firaidkitm1.PNG', 'firaidkitm2.PNG', '', 'firstaidkit', NULL, 20, 0),
(7, 'First Aid Kits - Large', 'Features:\r\n\r\nMade from high quality plastic box.\r\nSuitable for low risk areas and up to 25 employees.\r\nSize: 260 x 235 x 88mm', 40, 'firaidkit1.PNG', 'firaidkit2.PNG', '', 'firstaidkit', NULL, 20, 0),
(8, 'ProDetect® COVID-19 Antigen Rapid Self-Test Kit (Saliva)', 'A quick, painless, and accurate screening kit that works as an at-home testing kit.', 9, 'covidteskit1.jpg', 'covidteskit2.jpg', '', 'testingkit', NULL, 50, 0),
(9, 'HPV Self Collection Kit (Cervical Swab)', 'Our self collection kit can be done at the comfort of your home without the inconvenience of going to a hospital or clinic. While more than 100 different types of HPV have been identified, our at-home HPV testing kit screens for 15 high-risk strains that potentially lead to cervical intraepithelial neoplasia or cervical cancer.', 250, 'hpvkit1.jpg', 'hpvkit2.jpg', '', 'testingkit', NULL, 50, 0),
(10, 'Karma Ergo Lite Ultralight Wheelchair (14&#34;)', 'The Karma Ergo Lite Transit Wheelchair is a top selling, ultra-light wheelchair. It folds down to take up virtually no space in the boot of a car and weighs only 8.7 kg – making it easy for anyone to lift into a vehicle. The Karma Ergo Lite is the perfect chair if you&#39;re seeking a solution for outings to the park, shopping mall, or anywhere in the community for that matter, and because its crash test approved, you can go further than ever!\r\n\r\nFoldable Backrest and Frame\r\n', 1899, 'wcc1.PNG', 'wcc2.PNG', '', 'wheelchair', NULL, 10, 0),
(11, 'FOREHEALTH ACT3020EX Rapid 10s Digital Thermometer 1s', 'Fore health ACT3020EX 10s Digital Clinical Thermometer 3 years warranty *Please consult your healthcare professional for the interpretation of result and diagnosis. Registered under ACT 737\r\nProduct Usage\r\nFor external use only', 36, 'tmmt1.PNG', 'tmmt2.PNG', '', 'thermometer', NULL, 30, 0),
(12, 'FOREHEALTH Infrared Ear Thermometer 1s', 'Fore health ACT8000 Infrared Ear Thermometer Infrared Ear Thermometer 1x Dispenser 1x Probe cover 20x Protective Cover 1x User manual 1x 1.5V AAA alkaline (LR03) Battery 2x Features: -Hygienic and hands-free probe cover installation and disposal -1 second measurement -Clinically proven accuracy -Eject used probe cover with one button -Probe cover positioning detective system -Dual scale available -Wider measuring range -Extra jumbo LCD and beeper for easy use.', 209, 'tmmt3.PNG', 'tmmt4.PNG', '', 'thermometer', 10, 20, 0);

-- --------------------------------------------------------

--
-- Table structure for table `schedule_settings`
--

CREATE TABLE `schedule_settings` (
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL,
  `date_create` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule_settings`
--

INSERT INTO `schedule_settings` (`meta_field`, `meta_value`, `date_create`) VALUES
('day_schedule', 'Sunday,Monday,Tuesday,Wednesday,Thursday', '2023-11-06 23:17:51'),
('morning_schedule', '07:00,12:00', '2023-11-06 23:17:51'),
('afternoon_schedule', '13:00,16:00', '2023-11-06 23:17:51'),
('update_schedule', '', '2023-11-06 23:17:51');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Patient Appointment Scheduler System - PHP'),
(6, 'short_name', 'PASS-PHP'),
(11, 'logo', 'uploads/1630631400_clinic-logo.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/1630631400_clinic-cover.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `role_id` int(10) NOT NULL DEFAULT 3 COMMENT '1=admin,2=doctor,3=user',
  `name` varchar(20) NOT NULL,
  `dname` varchar(250) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `avatar` text DEFAULT NULL,
  `phone` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `type` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `dname`, `email`, `password`, `avatar`, `phone`, `address`, `type`) VALUES
(1, 1, 'admin', '', 'admin@gmail.com', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', NULL, '0123456789', '', 0),
(2, 2, 'doctor', 'Dr. Stein Adeline', 'doctor@gmail.com', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', '../assets/img/doctors/doctor_1.jpg', '0123456789', '', 1),
(3, 3, 'yinqinn', '', 'weiyi1089@gmail.com', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', NULL, '0123456789', '88, taman inti, gelugor, pinang, malaysia, 06000', 0),
(5, 3, 'test', '', 'test@gmail.com', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', NULL, '0128888888', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_list`
--
ALTER TABLE `patient_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_meta`
--
ALTER TABLE `patient_meta`
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `patient_list`
--
ALTER TABLE `patient_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `patient_meta`
--
ALTER TABLE `patient_meta`
  ADD CONSTRAINT `patient_meta_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
