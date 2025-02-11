-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2025 at 07:55 AM
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
-- Database: `the_overcooked_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_approval`
--

CREATE TABLE `admin_approval` (
  `approvalId` int(11) NOT NULL,
  `adminId` int(11) NOT NULL,
  `pendingId` int(11) NOT NULL,
  `recipeId` int(11) NOT NULL,
  `status` enum('approved','rejected','pending') DEFAULT 'pending',
  `actionTakenAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `commentId` int(11) NOT NULL,
  `commentContent` varchar(100) NOT NULL,
  `commentDatetime` datetime NOT NULL DEFAULT current_timestamp(),
  `userId` int(11) NOT NULL,
  `recipeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pending_recipe`
--

CREATE TABLE `pending_recipe` (
  `pendingId` int(11) NOT NULL,
  `recipeName` varchar(255) NOT NULL,
  `chefId` int(11) NOT NULL,
  `category` enum('Breakfast','Lunch','Dinner','Dessert','Beverages') NOT NULL,
  `tag` text DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `ingredients` text DEFAULT NULL,
  `instruction` text DEFAULT NULL,
  `submitted_at` datetime NOT NULL DEFAULT current_timestamp(),
  `rejection_reason` text DEFAULT NULL,
  `status` enum('pending','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pending_recipe`
--

INSERT INTO `pending_recipe` (`pendingId`, `recipeName`, `chefId`, `category`, `tag`, `picture`, `note`, `details`, `ingredients`, `instruction`, `submitted_at`, `rejection_reason`, `status`) VALUES
(8, 'AYAM KICAP', 1, 'Breakfast', '1', 'uploads/Teh-Tarik-stock-photo-830x553.jpg', '1', '1', '1', '1', '2025-02-03 13:40:17', NULL, 'rejected'),
(9, 'AYAM KICAP', 1, 'Breakfast', '1', 'uploads/Teh-Tarik-stock-photo-830x553.jpg', '1', '1', '1', '1', '2025-02-03 13:56:26', 'rererereerere', 'rejected'),
(12, '12', 1, 'Breakfast', '1', 'uploads/hpgp3.png', '1', '1', '1', '1', '2025-02-03 14:13:33', '', 'rejected'),
(13, '12', 1, 'Breakfast', '1', 'uploads/hpgp3.png', '1', '1', '1', '1', '2025-02-03 14:17:18', 'ds', 'rejected'),
(16, 'Ayam Pedas', 1, 'Breakfast', '1', 'uploads/resep-sambal-ayam-goreng-tumis.jpg', '1', '1', '1', '1', '2025-02-03 14:24:39', 'rewrer', 'rejected'),
(23, '1', 1, 'Breakfast', '2', 'uploads/63de3289e3876.jpeg', '1', '1', '1', '1', '2025-02-03 14:38:50', 'K', 'rejected'),
(29, 'W', 1, 'Breakfast', '2', 'uploads/hpgp3.png', '1', '1', '1', '1', '2025-02-03 14:54:39', 'KJ', 'rejected'),
(31, 'kucingg sambal kentang ayam pedas', 1, 'Breakfast', 'sedap', '', 'banyuak', 'sedap', 'swedap', 'sedap', '2025-02-03 15:11:45', 'sdsd', 'rejected'),
(34, 'kucingg sambal kentang ayam pedas', 1, 'Breakfast', 'sedap', 'uploads/Resep-Masakan-Sambal-Goreng-Kentang-Pedas-dan-Enak.jpg,uploads/resep-sambal-ayam-goreng-tumis.jpg', '2', '2', '2', '2', '2025-02-03 15:20:45', 'cvcvc', 'rejected'),
(39, 'AYAM KICAP', 1, 'Breakfast', 'ayam', 'uploads/Resep-Masakan-Sambal-Goreng-Kentang-Pedas-dan-Enak.jpg,uploads/resep-sambal-ayam-goreng-tumis.jpg', '2', '2', '2', '2', '2025-02-03 15:39:22', 'sdfdfd', 'rejected'),
(41, 'AYAM KICAP', 1, 'Breakfast', 'ayam', 'uploads/signup-page-background.jpg', '2', '2', '2', '2', '2025-02-03 16:47:03', 'wddwdaad', 'rejected'),
(42, 'ikan manis', 1, 'Breakfast', '#ikan #sedap', 'uploads/63de3289e3876.jpeg', 'cgh', 'ihio', 'khvl', 'gbl;ub', '2025-02-04 09:39:19', 'gdfkdlutdlyutdx', 'rejected'),
(46, 'wda', 1, 'Lunch', 'awd', 'uploads/signup-page-background.jpg', 'daw', 'da', 'awd', 'ad', '2025-02-04 11:52:25', 'adadwwdaw', 'rejected');

-- --------------------------------------------------------

--
-- Table structure for table `posted_recipe`
--

CREATE TABLE `posted_recipe` (
  `recipeId` int(11) NOT NULL,
  `recipeName` varchar(255) NOT NULL,
  `chefId` int(11) NOT NULL,
  `category` enum('Breakfast','Lunch','Dinner','Dessert','Beverages') NOT NULL,
  `tag` text NOT NULL,
  `picture` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL,
  `ingredients` text NOT NULL,
  `instruction` text NOT NULL,
  `approved` tinyint(1) DEFAULT 0,
  `datetime_posted` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posted_recipe`
--

INSERT INTO `posted_recipe` (`recipeId`, `recipeName`, `chefId`, `category`, `tag`, `picture`, `note`, `details`, `ingredients`, `instruction`, `approved`, `datetime_posted`) VALUES
(1, 'AYAM KICAP', 1, 'Breakfast', '1', 'uploads/Teh-Tarik-stock-photo-830x553.jpg', '1', '1', '1', '1', 0, '2025-02-03 12:57:57'),
(2, 'AYAM KICAP', 1, 'Breakfast', '1', 'uploads/Teh-Tarik-stock-photo-830x553.jpg', '1', '1', '1', '1', 0, '2025-02-03 13:57:13'),
(3, '12', 1, 'Breakfast', '1', 'uploads/hpgp3.png', '1', '1', '1', '1', 0, '2025-02-03 14:17:38'),
(4, 'Ayam Pedas', 1, 'Breakfast', '1', 'uploads/resep-sambal-ayam-goreng-tumis.jpg', '1', '1', '1', '1', 0, '2025-02-03 14:24:31'),
(5, '1', 1, 'Breakfast', '2', 'uploads/hpgp2.png', '1', '1', '1', '1', 0, '2025-02-03 14:40:27'),
(7, '1', 1, 'Breakfast', '2', 'uploads/Resep-Masakan-Sambal-Goreng-Kentang-Pedas-dan-Enak.jpg', 'W', 'W', 'W', 'W', 0, '2025-02-03 14:51:30'),
(8, 'ayam Kicap', 1, 'Breakfast', '2', 'uploads/Resep-Masakan-Sambal-Goreng-Kentang-Pedas-dan-Enak.jpg', '2', '2', '2', '2', 0, '2025-02-03 14:35:58'),
(9, 'kucingg sambal kentang ayam pedas', 1, 'Breakfast', 'sedap', 'uploads/Resep-Masakan-Sambal-Goreng-Kentang-Pedas-dan-Enak.jpg', '2', '2', '2', '2', 0, '2025-02-03 15:20:27'),
(10, 'AYAM KICAP', 1, 'Breakfast', 'ayam', 'uploads/resep-sambal-ayam-goreng-tumis.jpg', '2', '2', '2', '2', 0, '2025-02-03 15:39:05'),
(11, 'AYAM KICAP', 1, 'Breakfast', 'ayam', 'uploads/PASSPORT NUFAYL.png', '2', '2', '2', '2', 0, '2025-02-03 16:46:41'),
(13, 'telor', 1, 'Breakfast', 'Egg', 'uploads/fried-eggs.jpg', 'dsgsd', 'fasfsdf', 'sfsdfs', 'dfs', 0, '2025-02-04 11:07:35'),
(15, 'KUCING MASAK LEMAK', 1, 'Lunch', '#makanan indon', 'uploads/63de3289e3876.jpeg', 'sedap', 'meow', 'ksuning', 'masak', 0, '2025-02-04 14:49:31');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `roleId` int(11) NOT NULL,
  `roleName` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`roleId`, `roleName`, `description`) VALUES
(1, 'Registered User', 'A user who can browse, save, and comment on recipes.'),
(2, 'Chef', 'A content creator who can publish, edit, and delete their own recipes.'),
(3, 'Admin', 'A system moderator with full control over users, recipes, and content moderation.');

-- --------------------------------------------------------

--
-- Table structure for table `saved_recipe`
--

CREATE TABLE `saved_recipe` (
  `savedRecipeId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `recipeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `roleId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `name`, `username`, `password`, `email`, `roleId`) VALUES
(1, 'Chef1', 'chef_1', 'password123', 'chef1@email.com', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_approval`
--
ALTER TABLE `admin_approval`
  ADD PRIMARY KEY (`approvalId`),
  ADD KEY `fk_admin_approval.adminId` (`adminId`),
  ADD KEY `fk_admin_approval.recipeId` (`recipeId`),
  ADD KEY `fk_admin_approval.pendingId` (`pendingId`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`commentId`),
  ADD KEY `fk_comment.recipeId` (`recipeId`),
  ADD KEY `fk_comment.userId` (`userId`);

--
-- Indexes for table `pending_recipe`
--
ALTER TABLE `pending_recipe`
  ADD PRIMARY KEY (`pendingId`),
  ADD KEY `fk_pending_recipe.chefId` (`chefId`);

--
-- Indexes for table `posted_recipe`
--
ALTER TABLE `posted_recipe`
  ADD PRIMARY KEY (`recipeId`),
  ADD KEY `fk_approved_recipe.chefId` (`chefId`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`roleId`);

--
-- Indexes for table `saved_recipe`
--
ALTER TABLE `saved_recipe`
  ADD PRIMARY KEY (`savedRecipeId`),
  ADD KEY `fk_saved_recipe.userId` (`userId`),
  ADD KEY `fk_saved_recipe.recipeId` (`recipeId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `idx_unique_username` (`username`),
  ADD KEY `fk_users.roleId` (`roleId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_approval`
--
ALTER TABLE `admin_approval`
  MODIFY `approvalId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `commentId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pending_recipe`
--
ALTER TABLE `pending_recipe`
  MODIFY `pendingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `posted_recipe`
--
ALTER TABLE `posted_recipe`
  MODIFY `recipeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `roleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `saved_recipe`
--
ALTER TABLE `saved_recipe`
  MODIFY `savedRecipeId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_approval`
--
ALTER TABLE `admin_approval`
  ADD CONSTRAINT `fk_admin_approval.adminId` FOREIGN KEY (`adminId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_admin_approval.pendingId` FOREIGN KEY (`pendingId`) REFERENCES `pending_recipe` (`pendingId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_comment.recipeId` FOREIGN KEY (`recipeId`) REFERENCES `recipe` (`recipeId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comment.userId` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON UPDATE CASCADE;

--
-- Constraints for table `pending_recipe`
--
ALTER TABLE `pending_recipe`
  ADD CONSTRAINT `fk_pending_recipe.chefId` FOREIGN KEY (`chefId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posted_recipe`
--
ALTER TABLE `posted_recipe`
  ADD CONSTRAINT `fk_approved_recipe.chefId` FOREIGN KEY (`chefId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `saved_recipe`
--
ALTER TABLE `saved_recipe`
  ADD CONSTRAINT `fk_saved_recipe.recipeId` FOREIGN KEY (`recipeId`) REFERENCES `recipe` (`recipeId`),
  ADD CONSTRAINT `fk_saved_recipe.userId` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users.roleId` FOREIGN KEY (`roleId`) REFERENCES `role` (`roleId`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `cleanup_guests` ON SCHEDULE EVERY 1 DAY STARTS '2025-01-19 01:33:21' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM guest WHERE sessionEnd < NOW() - INTERVAL 7 DAY$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
