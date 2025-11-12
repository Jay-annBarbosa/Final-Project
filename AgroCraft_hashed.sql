-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2020 at 08:55 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
CREATE DATABASE IF NOT EXISTS `impulse101`;
USE `impulse101`;
--
-- Database: `impulse101`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(255) NOT NULL AUTO_INCREMENT,
  `admin_username` varchar(50) NOT NULL UNIQUE,
  `admin_password` VARBINARY(255) NOT NULL,
  `admin_email` varchar(100),
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Updated admin password: plaintext 'password' hashed with SHA-256
-- Stored as binary via UNHEX so it matches VARBINARY column
INSERT INTO `admin` (`admin_username`, `admin_password`, `admin_email`) VALUES 
('admin', UNHEX('5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8'), 'admin@agrocraft.com');

-- --------------------------------------------------------

--
-- Table structure for table `buyerregistration`
--

CREATE TABLE IF NOT EXISTS `buyerregistration` (
  `buyer_id` int(255) NOT NULL AUTO_INCREMENT,
  `buyer_name` varchar(30) NOT NULL,
  `buyer_phone` bigint(10) NOT NULL,
  `buyer_addr` text NOT NULL,
  `buyer_comp` varchar(100) NOT NULL,
  `buyer_license` varchar(100) NOT NULL,
  `buyer_bank` int(16) NOT NULL,
  `buyer_pan` varchar(10) NOT NULL,
  `buyer_mail` varchar(20) NOT NULL,
  `buyer_username` varchar(20) NOT NULL,
  `buyer_password` varchar(255) NOT NULL,
  PRIMARY KEY (`buyer_id`),
  UNIQUE KEY `buyer_username` (`buyer_username`),
  UNIQUE KEY `buyer_phone` (`buyer_phone`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buyerregistration`
--

INSERT INTO `buyerregistration` (`buyer_id`, `buyer_name`, `buyer_phone`, `buyer_addr`, `buyer_comp`, `buyer_license`, `buyer_bank`, `buyer_pan`, `buyer_mail`, `buyer_username`, `buyer_password`) VALUES
(15, 'Abhishek', 1234567890, ' Raj Uday 234', 'Elysian.org', '02082000', 2147483647, '1234567890', 'abhi@hmil.com', 'admin', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/KFm'),
(16, 'Arpit', 7666610976, 'Bhat Mansion', 'Mafia Pvt Ltd', '99', 12345, '987', 'abcd@gmail.com', 'redhawk', '$2y$10$V9.jtLDVWZeT4d.Ky4wkCOYvFH5XK8nR2pL6mN3oQ1sT8uW9xY2'),
(17, 'calista', 2589631472, '4/2,rose building .wadala', 'apple', 'w3566908', 8947, '2436467897', 'rose21@gmail.com', 'melissa', '$2y$10$A1bC2dE3fG4hI5jK6lM7nO8pQ9rS0tU1vW2xY3zA4bC5dE6fG7h'),
(18, 'Lokesh', 9029788504, 'SEC -13 , PALM BEACH ROAD', '', 'MAHARASHTRA', 0, '1234567890', 'abhi@hmil.com', 'lokesh', '$2y$10$B2cD3eF4gH5iJ6kL7mN8oP9qR0sT1uV2wX3yZ4aB5cD6eF7gH8i'),
(19, 'ansh', 9819104641, 'fam', 'Elysian.org', 'MAHARASHTRA', 2147483647, '1234567890', 'abhi@hmil.com', 'ansh', '$2y$10$C3dE4fG5hI6jK7lM8nO9pQ0rS1tU2vV3wX4yZ5aB6cD7eF8gH9i'),
(20, 'bhabalomkar421', 8828071232, 'bj', 'c company', 'just **** off', 1, '1', 'xyz@domain.com', '501807', '$2y$10$D4eF5gH6iJ7kL8mN9oP0qR1sT2uV3wW4xX5yZ6aB7cD8eF9gH0i');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `product_id` int(255) NOT NULL,
  `phonenumber` bigint(10) NOT NULL,
  `qty` int(10) NOT NULL DEFAULT 1,
  `subtotal` int(255) NOT NULL,
  KEY `product_id` (`product_id`),
  KEY `phonenumber` (`phonenumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT IGNORE INTO `cart` (`product_id`, `phonenumber`, `qty`, `subtotal`) VALUES
(32, 8169193101, 2, 10);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_title` varchar(100) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT IGNORE INTO `categories` (`cat_id`, `cat_title`) VALUES
(1, 'Crops'),
(2, 'Vegetables'),
(3, 'Fruits');

-- --------------------------------------------------------

--
-- Table structure for table `consumer`
--

CREATE TABLE IF NOT EXISTS `consumer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL,
  `address` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT IGNORE INTO `consumer` (`id`, `name`, `email`, `pincode`, `password`, `address`, `phone`) VALUES
(5, 'bhabalomkar421', 'bhabalomkar421@gmail', '421202', 'yw==', 'm', '8828071232'),
(6, 'hello world', 'hello@world.com', '421202', 'yw==', 'world', '9999999999'),
(7, 'Abhishek Gupta', 'abhig0209@gmail.com', '400705', 'm8bf5+Y=', 'Test', '1234567890'),
(8, 'int main', 'intmain@g.com', '400705', 'yw==', '704,Raj Uday CHS , Sec-1
Sanpada', '7715802258');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE IF NOT EXISTS `doctor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `password` varchar(10) NOT NULL,
  `clinicName` varchar(15) NOT NULL,
  `clinicAddress` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `startTime` varchar(8) NOT NULL,
  `endTime` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT IGNORE INTO `doctor` (`id`, `name`, `email`, `pincode`, `password`, `clinicName`, `clinicAddress`, `phone`, `startTime`, `endTime`) VALUES
(4, 'bhabalomkar421', 'bhabalomkar421@gmail', '421202', 'yw==', 'xyz', 'xyz', '8828071232', '10:00', '12:00'),
(5, 'int main', 'intmain1221@gmail.co', '421202', 'yw==', 'xyz', 'xyz', '8369619128', '10:00', '12:30'),
(6, 'god', 'es@dd.com', '421205', 'yw==', '1', '1', '9223152967', '10:00', '01:00');

-- --------------------------------------------------------

--
-- Table structure for table `farmerregistration`
--

CREATE TABLE IF NOT EXISTS `farmerregistration` (
  `farmer_id` int(255) NOT NULL AUTO_INCREMENT,
  `farmer_name` varchar(255) NOT NULL,
  `farmer_phone` bigint(10) NOT NULL,
  `farmer_address` text NOT NULL,
  `farmer_state` varchar(50) NOT NULL,
  `farmer_district` varchar(50) NOT NULL,
  `farmer_pan` varchar(10) NOT NULL,
  `farmer_bank` int(16) NOT NULL,
  `farmer_password` varchar(100) NOT NULL,
  PRIMARY KEY (`farmer_id`),
  UNIQUE KEY `farmer_phone` (`farmer_phone`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT IGNORE INTO `farmerregistration` (`farmer_id`, `farmer_name`, `farmer_phone`, `farmer_address`, `farmer_state`, `farmer_district`, `farmer_pan`, `farmer_bank`, `farmer_password`) VALUES
(1, 'Abhishek', 8169193101, 'Mars', 'MAHARASHTRA', 'Thane', '1234567890', 2147483647, 'm8bf5+Y='),
(3, 'omkar', 8169193102, 'SEC -13 , PALM BEACH ROAD', 'KERALA', 'Alappuzha', '123ABC', 45745425, 'nMPb4g=='),
(4, 'Ram', 8169193103, 'Moon', 'MahaRASHTRA', 'Nagpur', '123ABC', 211324654, 'm8bf5+Y='),
(5, 'Lokesh', 8169193104, 'SEC -13 , PALM BEACH ROAD', 'MAHARASHTRA', 'Nagpur', '1325355', 45745425, 'yw==');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(255) NOT NULL AUTO_INCREMENT,
  `product_id` int(255) NOT NULL,
  `qty` int(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `delivery` varchar(10) NOT NULL,
  `phonenumber` bigint(10) NOT NULL,
  `total` int(10) NOT NULL,
  `payment` varchar(10) NOT NULL,
  `buyer_phonenumber` bigint(10) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `product_id` (`product_id`),
  KEY `phonenumber` (`phonenumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT IGNORE INTO `orders` (`order_id`, `product_id`, `qty`, `address`, `delivery`, `phonenumber`, `total`, `payment`, `buyer_phonenumber`) VALUES
(55, 23, 1, ' Raj Uday 234', 'Buyer', 8169193101, 56, 'cod', 1234567890),
(56, 28, 1, ' Raj Uday 234', 'Buyer', 8169193101, 45, 'cod', 1234567890),
(57, 31, 1, 'I am Hungry', 'Buyer', 8169193101, 25, 'cod', 1234567890),
(58, 3, 2, ' Raj Uday 234', 'Farmer', 8169193101, 10, 'paytm', 1234567890),
(60, 32, 1, 'Working', 'Buyer', 8169193101, 10, 'cod', 1234567890);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(100) NOT NULL AUTO_INCREMENT,
  `farmer_fk` int(255) NOT NULL,
  `product_title` varchar(100) NOT NULL,
  `product_cat` varchar(100) NOT NULL,
  `product_type` varchar(100) NOT NULL,
  `product_expiry` varchar(25) NOT NULL,
  `product_image` text NOT NULL,
  `product_stock` int(100) NOT NULL,
  `product_price` int(100) NOT NULL,
  `product_desc` text NOT NULL,
  `product_keywords` text NOT NULL,
  `product_delivery` varchar(5) NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `farmer_fk` (`farmer_fk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT IGNORE INTO `products` (`product_id`, `farmer_fk`, `product_title`, `product_cat`, `product_type`, `product_expiry`, `product_image`, `product_stock`, `product_price`, `product_desc`, `product_keywords`, `product_delivery`) VALUES
(1, 1, 'Ramlal Potato', '2', 'Potato', '2020-04-15', 'Potato.jpg', 1000, 12, 'Best Quality product guarented 100 percent', 'potato', 'yes'),
(3, 1, 'Ramlal Tomato', '2', 'Tomato', '2020-04-15', 'Tomato.jpg', 500, 5, 'Best Quality toamato assured', 'tomato , best quality tomato , Ramlal Tomato', 'no'),
(17, 3, 'Shivneri Bananas', '3', 'Bananas', '2020-04-15', 'Bananas.jpg', 250, 30, 'Best Quality Bananas', 'banana, shivneri ,', 'yes'),
(18, 3, 'Ram Rice', '1', 'Rice', '2020-04-15', 'Rice.jpg', 1500, 2, 'waqd', 'best rice', 'yes'),
(32, 1, 'Abhi Orange', '3', 'Orange', '2020-04-15', 'orange.jpg', 1500, 10, 'Best Oranges grown with love in Nagpur', 'Orange,best Orange', 'yes'),
(37, 1, 'Ram Sugacane', '1', 'Sugarcane', '2020-04-25', 'Sugarcane.jpg', 1000, 50, 'Best Sugarcane', 'Sugarcane', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `shopkeeper`
--

CREATE TABLE IF NOT EXISTS `shopkeeper` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `password` varchar(10) NOT NULL,
  `shopName` varchar(20) NOT NULL,
  `shopAddress` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `startTime` varchar(8) NOT NULL,
  `endTime` varchar(8) NOT NULL,
  `slotInterval` int(11) NOT NULL,
  `slotUser` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT IGNORE INTO `shopkeeper` (`id`, `name`, `email`, `pincode`, `password`, `shopName`, `shopAddress`, `phone`, `startTime`, `endTime`, `slotInterval`, `slotUser`) VALUES
(1, 'bhabalomkar421', 'bhabalomkar421@gmail', '421202', 'yw==', 'xyz', 'xyz', '8828071232', '10:30', '12:30', 30, 5),
(3, 'int main 123', 'intmain1221@gmail.co', '400705', 'yw==', 'hopes', 'no hopes', '101', '10:30', '11:30', 30, 7),
(4, 'kerela', 'es@dd.com', '421200', 'yw==', '1', 'm', '8369674856', '10:00', '12:30', 60, 5),
(5, 'Abhishek Gupta', 'abhig0209@gmail.com', '400705', 'm8bf5+Y=', 'Ganesh Grocery', 'Rose Villa Lane', '1234567890', '12:00', '22:00', 30, 5),
(6, 'omkar bhabal', 'intmain1221@gmail.co', '400705', 'yw==', 'om medical', 'navapada', '9223152967', '10:30', '17:00', 30, 5),
(7, 'Ganesh', 'ganesh@mail.com', '123456', 'm8bf5+Y=', 'Ganesh Grocery', 'Mumbai', '1234567891', '10:00', '14:00', 30, 5);

-- --------------------------------------------------------

--
-- Table structure for table `slot`
--

CREATE TABLE IF NOT EXISTS `slot` (
  `slot_id` int(255) NOT NULL AUTO_INCREMENT,
  `shop_id` int(255) NOT NULL,
  `slot` varchar(10) NOT NULL,
  `vacancy` int(255) NOT NULL,
  `date` varchar(12) NOT NULL,
  `phonenumber` bigint(10) NOT NULL,
  `passcode` int(5) NOT NULL,
  PRIMARY KEY (`slot_id`),
  UNIQUE KEY `passcode` (`passcode`),
  KEY `slot_ibfk_1` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `slot` (`slot_id`, `shop_id`, `slot`, `vacancy`, `date`, `phonenumber`, `passcode`) VALUES
(37, 6, '12:0', 5, '05/05/2020', 1234567890, 82047),
(38, 6, '12:0', 5, '13/07/2020', 1234567890, 95127),
(39, 6, '10:30', 5, '21/04/2020', 1234567890, 40661),
(40, 6, '12:0', 5, '07/04/2020', 1234567890, 27560),
(41, 6, '10:30', 5, '22/04/2020', 1234567890, 67549);

--
-- AUTO_INCREMENT for dumped tables
--

ALTER TABLE `admin` MODIFY `admin_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `buyerregistration` MODIFY `buyer_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
ALTER TABLE `categories` MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `consumer` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
ALTER TABLE `doctor` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
ALTER TABLE `farmerregistration` MODIFY `farmer_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `orders` MODIFY `order_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
ALTER TABLE `products` MODIFY `product_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
ALTER TABLE `shopkeeper` MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
ALTER TABLE `slot` MODIFY `slot_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

ALTER TABLE `slot`
  ADD CONSTRAINT `slot_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shopkeeper` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
