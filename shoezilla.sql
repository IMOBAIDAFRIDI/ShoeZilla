-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2025 at 08:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shoezilla`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category` varchar(50) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `old_price`, `image_url`, `category`, `stock`, `is_featured`, `created_at`) VALUES
(1, 'Nike Air Jordan 1 Red', 'Iconic basketball sneaker with stylish design.', 149.99, 180.00, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-air-jordan-1-red-and-black/1.webp', 'Men', 50, 1, '2025-12-24 19:46:48'),
(2, 'Nike Baseball Cleats', 'Maximum traction and performance.', 79.99, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-baseball-cleats/1.webp', 'Men', 30, 0, '2025-12-24 19:46:48'),
(3, 'Puma Future Rider', 'Retro style and modern comfort.', 89.99, 100.00, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/1.webp', 'Men', 40, 0, '2025-12-24 19:46:48'),
(4, 'Sports Sneakers Off White', 'Fashionable choice for sports.', 119.99, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-&-red/1.webp', 'Men', 20, 0, '2025-12-24 19:46:48'),
(5, 'Off White Red Sneakers', 'Unique design and comfort.', 109.99, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-red/1.webp', 'Men', 25, 1, '2025-12-24 19:46:48'),
(6, 'Classic Air Jordan', 'High-performance features.', 155.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-air-jordan-1-red-and-black/2.webp', 'Men', 45, 0, '2025-12-24 19:46:48'),
(7, 'Pro Baseball Cleats', 'Stability and support.', 85.00, 95.00, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-baseball-cleats/2.webp', 'Men', 35, 0, '2025-12-24 19:46:48'),
(8, 'Puma Rider Blue', 'Casual everyday wear.', 95.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/2.webp', 'Men', 50, 0, '2025-12-24 19:46:48'),
(9, 'Athletic Sneakers', 'Bold and energetic touch.', 125.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-&-red/2.webp', 'Men', 30, 0, '2025-12-24 19:46:48'),
(10, 'Red Casual Kicks', 'Style for casual occasions.', 115.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-red/2.webp', 'Men', 40, 0, '2025-12-24 19:46:48'),
(11, 'Jordan 1 High', 'Favorite among sneaker enthusiasts.', 160.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-air-jordan-1-red-and-black/3.webp', 'Men', 25, 1, '2025-12-24 19:46:48'),
(12, 'Varsity Cleats', 'Designed for players.', 90.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-baseball-cleats/3.webp', 'Men', 30, 0, '2025-12-24 19:46:48'),
(13, 'Puma Rider Mix', 'Blend of materials.', 92.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/3.webp', 'Men', 45, 0, '2025-12-24 19:46:48'),
(14, 'Sporty White Red', 'Functionality meets style.', 122.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-&-red/3.webp', 'Men', 35, 0, '2025-12-24 19:46:48'),
(15, 'Urban Red Sneakers', 'Stand out from the crowd.', 112.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-red/3.webp', 'Men', 50, 0, '2025-12-24 19:46:48'),
(16, 'Jordan Retro', 'Timeless basketball style.', 165.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-air-jordan-1-red-and-black/4.webp', 'Men', 20, 0, '2025-12-24 19:46:48'),
(17, 'Field Cleats', 'Superior grip.', 88.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-baseball-cleats/4.webp', 'Men', 40, 0, '2025-12-24 19:46:48'),
(18, 'Puma Future Lite', 'Lightweight comfort.', 98.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/4.webp', 'Men', 35, 0, '2025-12-24 19:46:48'),
(19, 'Pro Active Sneakers', 'For the active lifestyle.', 128.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-&-red/4.webp', 'Men', 30, 0, '2025-12-24 19:46:48'),
(20, 'City Red Walker', 'Comfortable city walking.', 118.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-red/4.webp', 'Men', 25, 0, '2025-12-24 19:46:48'),
(21, 'Nike AJ1 Special', 'Special edition colorway.', 152.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-air-jordan-1-red-and-black/1.webp', 'Men', 15, 0, '2025-12-24 19:46:48'),
(22, 'Elite Cleats', 'Professional grade.', 95.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-baseball-cleats/2.webp', 'Men', 20, 0, '2025-12-24 19:46:48'),
(23, 'Puma Street Rider', 'Streetwear essential.', 105.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/3.webp', 'Men', 40, 1, '2025-12-24 19:46:48'),
(24, 'Court Sneakers', 'Court ready performance.', 130.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-&-red/4.webp', 'Men', 30, 0, '2025-12-24 19:46:48'),
(25, 'Red Octobers Style', 'Vibrant and bold.', 125.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-red/1.webp', 'Men', 35, 0, '2025-12-24 19:46:48'),
(26, 'Jordan 1 Classic', 'Must have for collectors.', 170.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-air-jordan-1-red-and-black/2.webp', 'Men', 25, 0, '2025-12-24 19:46:48'),
(27, 'Turf Cleats', 'Great for turf fields.', 82.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-baseball-cleats/3.webp', 'Men', 45, 0, '2025-12-24 19:46:48'),
(28, 'Puma Fast Rider', 'Speed and style.', 92.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/4.webp', 'Men', 50, 0, '2025-12-24 19:46:48'),
(29, 'Runner Sneaker', 'Daily running shoe.', 115.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-&-red/1.webp', 'Men', 30, 0, '2025-12-24 19:46:48'),
(30, 'Red Fashion Kicks', 'Fashion forward.', 108.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-red/2.webp', 'Men', 40, 0, '2025-12-24 19:46:48'),
(31, 'Black & Brown Slipper', 'Comfortable and stylish slipper.', 19.99, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/black-&-brown-slipper/1.webp', 'Women', 50, 0, '2025-12-24 19:46:48'),
(32, 'Calvin Klein Heels', 'Elegant and sophisticated.', 79.99, 90.00, 'https://cdn.dummyjson.com/product-images/womens-shoes/calvin-klein-heel-shoes/1.webp', 'Women', 40, 1, '2025-12-24 19:46:48'),
(33, 'Golden Shoes', 'Glamorous choice for special occasions.', 49.99, 60.00, 'https://cdn.dummyjson.com/product-images/womens-shoes/golden-shoes-woman/1.webp', 'Women', 35, 1, '2025-12-24 19:46:48'),
(34, 'Pampi Casuals', 'Blend of comfort and style.', 29.99, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/pampi-shoes/1.webp', 'Women', 60, 0, '2025-12-24 19:46:48'),
(35, 'Vibrant Red Shoes', 'Make a bold statement.', 34.99, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/red-shoes/1.webp', 'Women', 25, 0, '2025-12-24 19:46:48'),
(36, 'Comfy Slippers', 'Sophistication for relaxation.', 22.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/black-&-brown-slipper/2.webp', 'Women', 45, 0, '2025-12-24 19:46:48'),
(37, 'CK Classic Heels', 'Classic design.', 85.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/calvin-klein-heel-shoes/2.webp', 'Women', 30, 0, '2025-12-24 19:46:48'),
(38, 'Gold Luxury', 'Adds a touch of luxury.', 55.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/golden-shoes-woman/2.webp', 'Women', 30, 0, '2025-12-24 19:46:48'),
(39, 'Pampi Everyday', 'Trendy and relaxed look.', 32.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/pampi-shoes/2.webp', 'Women', 55, 0, '2025-12-24 19:46:48'),
(40, 'Red Party Shoes', 'Pop of color.', 38.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/red-shoes/2.webp', 'Women', 40, 0, '2025-12-24 19:46:48'),
(41, 'Lounge Slippers', 'Perfect for home.', 21.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/black-&-brown-slipper/3.webp', 'Women', 50, 0, '2025-12-24 19:46:48'),
(42, 'Formal Heels', 'For formal occasions.', 82.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/calvin-klein-heel-shoes/3.webp', 'Women', 35, 0, '2025-12-24 19:46:48'),
(43, 'Golden Shine', 'Shine bright.', 52.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/golden-shoes-woman/3.webp', 'Women', 25, 0, '2025-12-24 19:46:48'),
(44, 'Pampi Walkers', 'Great for walking.', 30.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/pampi-shoes/3.webp', 'Women', 60, 0, '2025-12-24 19:46:48'),
(45, 'Red Stilettos', 'Stylish and chic.', 36.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/red-shoes/3.webp', 'Women', 20, 0, '2025-12-24 19:46:48'),
(46, 'Warm Slippers', 'Cozy feet.', 24.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/black-&-brown-slipper/4.webp', 'Women', 45, 0, '2025-12-24 19:46:48'),
(47, 'CK Black Heels', 'High quality materials.', 88.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/calvin-klein-heel-shoes/4.webp', 'Women', 30, 0, '2025-12-24 19:46:48'),
(48, 'Gold Party Pump', 'Party ready.', 58.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/golden-shoes-woman/4.webp', 'Women', 20, 0, '2025-12-24 19:46:48'),
(49, 'Pampi Comfort', 'All day comfort.', 28.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/pampi-shoes/4.webp', 'Women', 50, 0, '2025-12-24 19:46:48'),
(50, 'Red Night Out', 'Perfect for a night out.', 40.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/red-shoes/4.webp', 'Women', 35, 0, '2025-12-24 19:46:48'),
(51, 'Home Slippers', 'Relax in style.', 20.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/black-&-brown-slipper/1.webp', 'Women', 40, 0, '2025-12-24 19:46:48'),
(52, 'Designer Heels', 'Top fashion brand.', 95.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/calvin-klein-heel-shoes/2.webp', 'Women', 25, 1, '2025-12-24 19:46:48'),
(53, 'Gold Elegant', 'Elegant choice.', 60.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/golden-shoes-woman/3.webp', 'Women', 30, 0, '2025-12-24 19:46:48'),
(54, 'Pampi Soft', 'Soft material.', 31.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/pampi-shoes/4.webp', 'Women', 55, 0, '2025-12-24 19:46:48'),
(55, 'Red Bold', 'Be bold.', 39.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/red-shoes/1.webp', 'Women', 45, 0, '2025-12-24 19:46:48'),
(56, 'Bedroom Slide', 'Easy to wear.', 18.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/black-&-brown-slipper/2.webp', 'Women', 50, 0, '2025-12-24 19:46:48'),
(57, 'Evening Heels', 'Perfect for dinner.', 89.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/calvin-klein-heel-shoes/3.webp', 'Women', 35, 0, '2025-12-24 19:46:48'),
(58, 'Gold Sparkle', 'Sparkle all night.', 54.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/golden-shoes-woman/4.webp', 'Women', 25, 0, '2025-12-24 19:46:48'),
(59, 'Pampi Daily', 'Daily essentials.', 29.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/pampi-shoes/1.webp', 'Women', 60, 0, '2025-12-24 19:46:48'),
(60, 'Red Passion', 'Passionate color.', 42.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/red-shoes/2.webp', 'Women', 30, 0, '2025-12-24 19:46:48'),
(61, 'Kids Red Shoes', 'Bright red shoes for kids.', 29.99, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/red-shoes/1.webp', 'Kids', 50, 1, '2025-12-24 19:46:48'),
(62, 'Junior Cleats', 'Sports cleats for juniors.', 45.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-baseball-cleats/1.webp', 'Kids', 40, 0, '2025-12-24 19:46:48'),
(63, 'Kids Comfort', 'Comfortable daily wear.', 25.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/pampi-shoes/1.webp', 'Kids', 60, 0, '2025-12-24 19:46:48'),
(64, 'Little Jordan', 'Style for the little ones.', 80.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-air-jordan-1-red-and-black/1.webp', 'Kids', 20, 1, '2025-12-24 19:46:48'),
(65, 'Kids Puma', 'Mini version of the classic.', 40.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/1.webp', 'Kids', 35, 0, '2025-12-24 19:46:48'),
(66, 'Red Kids Sneakers', 'Fun and colorful.', 32.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/red-shoes/2.webp', 'Kids', 45, 0, '2025-12-24 19:46:48'),
(67, 'Youth Cleats', 'Ready for the game.', 48.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-baseball-cleats/2.webp', 'Kids', 30, 0, '2025-12-24 19:46:48'),
(68, 'Kids Casuals', 'Soft and easy.', 26.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/pampi-shoes/2.webp', 'Kids', 55, 0, '2025-12-24 19:46:48'),
(69, 'Active Kids', 'For active play.', 85.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-air-jordan-1-red-and-black/2.webp', 'Kids', 25, 0, '2025-12-24 19:46:48'),
(70, 'Junior Puma', 'Sporty look.', 42.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/2.webp', 'Kids', 40, 0, '2025-12-24 19:46:48'),
(71, 'Kids Party Shoes', 'For parties.', 35.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/red-shoes/3.webp', 'Kids', 40, 0, '2025-12-24 19:46:48'),
(72, 'Little League Cleats', 'Start them young.', 50.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-baseball-cleats/3.webp', 'Kids', 20, 0, '2025-12-24 19:46:48'),
(73, 'School Shoes', 'Great for school.', 28.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/pampi-shoes/3.webp', 'Kids', 60, 0, '2025-12-24 19:46:48'),
(74, 'Playground Kicks', 'Durable for play.', 75.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-air-jordan-1-red-and-black/3.webp', 'Kids', 30, 0, '2025-12-24 19:46:48'),
(75, 'Kids Trainer', 'Easy to run in.', 38.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/3.webp', 'Kids', 35, 0, '2025-12-24 19:46:48'),
(76, 'Red Fun', 'Shiny red.', 33.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/red-shoes/4.webp', 'Kids', 45, 0, '2025-12-24 19:46:48'),
(77, 'Field Ready', 'Grass grip.', 52.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-baseball-cleats/4.webp', 'Kids', 25, 0, '2025-12-24 19:46:48'),
(78, 'Soft Walk', 'Gentle on feet.', 24.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/pampi-shoes/4.webp', 'Kids', 50, 0, '2025-12-24 19:46:48'),
(79, 'Court Kids', 'Ball game ready.', 82.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-air-jordan-1-red-and-black/4.webp', 'Kids', 22, 0, '2025-12-24 19:46:48'),
(80, 'Small Steps', 'First steps in style.', 41.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/4.webp', 'Kids', 33, 0, '2025-12-24 19:46:48'),
(81, 'Festive Shoes', 'Holiday ready.', 36.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/red-shoes/1.webp', 'Kids', 40, 0, '2025-12-24 19:46:48'),
(82, 'Sport Star', 'Future athlete.', 49.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-baseball-cleats/1.webp', 'Kids', 30, 0, '2025-12-24 19:46:48'),
(83, 'Everyday Kid', 'Everyday wear.', 25.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/pampi-shoes/1.webp', 'Kids', 55, 0, '2025-12-24 19:46:48'),
(84, 'Pro Kid', 'Pro style.', 81.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-air-jordan-1-red-and-black/2.webp', 'Kids', 20, 0, '2025-12-24 19:46:48'),
(85, 'Fast Kid', 'Run fast.', 43.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/2.webp', 'Kids', 30, 0, '2025-12-24 19:46:48'),
(86, 'Ruby Red', 'Gem of a shoe.', 34.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/red-shoes/2.webp', 'Kids', 42, 0, '2025-12-24 19:46:48'),
(87, 'Cleat Elite', 'Top tier.', 51.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-baseball-cleats/3.webp', 'Kids', 28, 0, '2025-12-24 19:46:48'),
(88, 'Pampi Junior', 'Junior size.', 27.00, NULL, 'https://cdn.dummyjson.com/product-images/womens-shoes/pampi-shoes/3.webp', 'Kids', 48, 0, '2025-12-24 19:46:48'),
(89, 'Basket Kid', 'Basketball fan.', 79.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/nike-air-jordan-1-red-and-black/4.webp', 'Kids', 24, 0, '2025-12-24 19:46:48'),
(90, 'Street Kid', 'Street smart.', 39.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/4.webp', 'Kids', 32, 0, '2025-12-24 19:46:48'),
(91, 'Pro Jogger', 'High performance running shoe.', 120.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-&-red/1.webp', 'Joggers', 50, 1, '2025-12-24 19:46:48'),
(92, 'Speed Runner', 'Built for speed.', 90.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/1.webp', 'Joggers', 45, 0, '2025-12-24 19:46:48'),
(93, 'Red Flash', 'Flashy running shoe.', 110.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-red/1.webp', 'Joggers', 40, 0, '2025-12-24 19:46:48'),
(94, 'Marathon One', 'Long distance comfort.', 125.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-&-red/2.webp', 'Joggers', 35, 1, '2025-12-24 19:46:48'),
(95, 'Sprint Master', 'Short distance sprints.', 95.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/2.webp', 'Joggers', 42, 0, '2025-12-24 19:46:48'),
(96, 'Urban Jogger', 'City running.', 115.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-red/2.webp', 'Joggers', 38, 0, '2025-12-24 19:46:48'),
(97, 'Track Star', 'Track field ready.', 130.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-&-red/3.webp', 'Joggers', 30, 0, '2025-12-24 19:46:48'),
(98, 'Daily Run', 'Daily exercise.', 88.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/3.webp', 'Joggers', 50, 0, '2025-12-24 19:46:48'),
(99, 'Red Racer', 'Race day shoe.', 112.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-red/3.webp', 'Joggers', 35, 0, '2025-12-24 19:46:48'),
(100, 'Endurance Pro', 'Maximum endurance.', 135.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-&-red/4.webp', 'Joggers', 25, 1, '2025-12-24 19:46:48'),
(101, 'Lite Runner', 'Lightweight.', 92.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/4.webp', 'Joggers', 48, 0, '2025-12-24 19:46:48'),
(102, 'City Dash', 'Quick dash.', 118.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-red/4.webp', 'Joggers', 33, 0, '2025-12-24 19:46:48'),
(103, 'Trail Blazer', 'Blaze the trails.', 122.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-&-red/1.webp', 'Joggers', 40, 0, '2025-12-24 19:46:48'),
(104, 'Puma Speed', 'Puma engineered.', 91.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/1.webp', 'Joggers', 44, 0, '2025-12-24 19:46:48'),
(105, 'Red Streak', 'Leave a streak.', 108.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-red/1.webp', 'Joggers', 39, 0, '2025-12-24 19:46:48'),
(106, 'Victory Run', 'Run to victory.', 128.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-&-red/2.webp', 'Joggers', 32, 0, '2025-12-24 19:46:48'),
(107, 'Rapid Rider', 'Ride the wind.', 96.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/2.webp', 'Joggers', 41, 0, '2025-12-24 19:46:48'),
(108, 'Metro Jogger', 'Metro style.', 114.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-red/2.webp', 'Joggers', 36, 0, '2025-12-24 19:46:48'),
(109, 'Olympia', 'Olympic dreams.', 132.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-&-red/3.webp', 'Joggers', 28, 0, '2025-12-24 19:46:48'),
(110, 'Easy Run', 'Easy going.', 89.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/3.webp', 'Joggers', 49, 0, '2025-12-24 19:46:48'),
(111, 'Crimson Run', 'Crimson tide.', 111.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-red/3.webp', 'Joggers', 34, 0, '2025-12-24 19:46:48'),
(112, 'Distance X', 'Go the distance.', 138.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-&-red/4.webp', 'Joggers', 24, 0, '2025-12-24 19:46:48'),
(113, 'Feather Lite', 'Feather weight.', 93.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/4.webp', 'Joggers', 47, 0, '2025-12-24 19:46:48'),
(114, 'Urban Dash', 'Dash through.', 117.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-red/4.webp', 'Joggers', 32, 0, '2025-12-24 19:46:48'),
(115, 'Alpha Run', 'Alpha male.', 121.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-&-red/1.webp', 'Joggers', 38, 0, '2025-12-24 19:46:48'),
(116, 'Beta Speed', 'Beta test.', 90.50, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/1.webp', 'Joggers', 43, 0, '2025-12-24 19:46:48'),
(117, 'Gamma Red', 'Gamma raiders.', 109.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-red/1.webp', 'Joggers', 37, 0, '2025-12-24 19:46:48'),
(118, 'Delta Force', 'Delta run.', 127.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-&-red/2.webp', 'Joggers', 31, 0, '2025-12-24 19:46:48'),
(119, 'Omega Sprint', 'Omega fast.', 94.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/puma-future-rider-trainers/2.webp', 'Joggers', 40, 0, '2025-12-24 19:46:48'),
(120, 'Zeta Jogger', 'Zeta run.', 113.00, NULL, 'https://cdn.dummyjson.com/product-images/mens-shoes/sports-sneakers-off-white-red/2.webp', 'Joggers', 35, 0, '2025-12-24 19:46:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `is_admin`, `created_at`) VALUES
(1, 'admin', 'emily.davis@email.com', '$2y$10$l8xVz5hRGodzaY4haaIfYunz3LvXZYZFQlabUVLpzeBnZZTBkdjsG', 0, '2025-12-24 19:09:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
