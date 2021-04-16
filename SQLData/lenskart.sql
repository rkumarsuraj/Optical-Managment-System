-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2019 at 04:52 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lenskart`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateDeliveryDate` ()  begin
    declare mWeekday int;
    DECLARE mOrderID INT;
    DECLARE mDeliveryDays int;
    DECLARE done INT DEFAULT FALSE;
    DECLARE order_id_cursor CURSOR FOR SELECT ORDERID FROM orders;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    open Order_id_cursor;

    order_loop: LOOP
        fetch order_id_cursor into mOrderID;
        IF done THEN
            LEAVE order_loop;
        END IF;
        select weekday(OrderDate) into mWeekday from orders where OrderID = mOrderID;

        if(mWeekday <=> 4) then
            SET mDeliveryDays = 4;
        elseif(mWeekday <=> 5) then
            SET mDeliveryDays = 3;
        else 
            SET mDeliveryDays = 2;
        end if;

        UPDATE orders
        set DeliveryDate = adddate(OrderDate,mDeliveryDays), TotalCost = Quantity * (SELECT Price from products where products.productCode = orders.ProductCode)
        where OrderID = mOrderID;

    end loop;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `AddressID` int(4) NOT NULL,
  `Line1` varchar(100) DEFAULT NULL,
  `Line2` varchar(100) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `Zipcode` int(6) DEFAULT NULL,
  `State` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`AddressID`, `Line1`, `Line2`, `City`, `Zipcode`, `State`) VALUES
(3005, '', '', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CartID` int(4) NOT NULL,
  `CustomerID` int(4) NOT NULL,
  `ProductCode` int(4) DEFAULT NULL,
  `Quantity` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CustomerID` int(4) NOT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `AddressID` int(4) DEFAULT NULL,
  `Phone` bigint(10) DEFAULT NULL,
  `RightEyeSight` decimal(4,2) DEFAULT NULL,
  `LeftEyeSight` decimal(4,2) DEFAULT NULL,
  `EmailID` varchar(50) DEFAULT NULL,
  `Password` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerID`, `Name`, `AddressID`, `Phone`, `RightEyeSight`, `LeftEyeSight`, `EmailID`, `Password`) VALUES
(1019, 'Praveen', 3005, 8197305400, NULL, NULL, 'praveen@gmail.com', 'abc');

-- --------------------------------------------------------

--
-- Table structure for table `frames`
--

CREATE TABLE `frames` (
  `framecode` int(4) NOT NULL,
  `FrameType` varchar(20) DEFAULT NULL,
  `FrameBrand` varchar(20) DEFAULT NULL,
  `Price` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `frames`
--

INSERT INTO `frames` (`framecode`, `FrameType`, `FrameBrand`, `Price`) VALUES
(5000, 'Rectangular', 'RayBan', 6000),
(5001, 'Avaitor', 'RayBan', 4200);

-- --------------------------------------------------------

--
-- Table structure for table `glasses`
--

CREATE TABLE `glasses` (
  `glasscode` int(4) NOT NULL,
  `GlassType` varchar(20) DEFAULT NULL,
  `GlassBrand` varchar(20) DEFAULT NULL,
  `Price` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `glasses`
--

INSERT INTO `glasses` (`glasscode`, `GlassType`, `GlassBrand`, `Price`) VALUES
(1, 'Rectangular', 'RayBan', 5500),
(2, 'Cat Eye', 'John Jacob', 4500),
(3, 'Avaitor', 'RayBan', 4000),
(4, 'Avaitor', 'Vincent', 4000),
(1000, 'Avaitor', 'John Jacob', 3900),
(1001, 'Avaitor', 'John Jacob', 4000),
(1002, 'Rectangular', 'John Jacob', 4000);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(4) NOT NULL,
  `CustomerID` int(4) DEFAULT NULL,
  `ProductCode` int(4) DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `DeliveryDate` date DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `TotalCost` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `CustomerID`, `ProductCode`, `OrderDate`, `DeliveryDate`, `Quantity`, `TotalCost`) VALUES
(4, 1019, 1, '2019-11-10', '2019-11-14', 1, 5500),
(5, 1019, 3, '2019-11-10', '2019-11-14', 4, 16000),
(6, 1019, 5000, '2019-11-10', '2019-11-14', 3, 18000),
(7, 1019, 5001, '2019-11-10', '2019-11-14', 2, 8400),
(8, 1019, 1001, '2019-11-10', '2019-11-14', 4, 16000),
(9, 1019, 1, '2019-11-10', '2019-11-14', 1, 5500),
(10, 1019, 3, '2019-11-10', '2019-11-14', 1, 4000);

-- --------------------------------------------------------

--
-- Stand-in structure for view `products`
-- (See below for the actual view)
--
CREATE TABLE `products` (
`productCode` int(11)
,`Type` varchar(20)
,`Brand` varchar(20)
,`Price` int(11)
);

-- --------------------------------------------------------

--
-- Structure for view `products`
--
DROP TABLE IF EXISTS `products`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `products`  AS  select `glasses`.`glasscode` AS `productCode`,`glasses`.`GlassType` AS `Type`,`glasses`.`GlassBrand` AS `Brand`,`glasses`.`Price` AS `Price` from `glasses` union select `frames`.`framecode` AS `ProductCode`,`frames`.`FrameType` AS `Type`,`frames`.`FrameBrand` AS `Brand`,`frames`.`Price` AS `Price` from `frames` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`AddressID`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartID`,`CustomerID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerID`),
  ADD KEY `AddressID` (`AddressID`);

--
-- Indexes for table `frames`
--
ALTER TABLE `frames`
  ADD PRIMARY KEY (`framecode`);

--
-- Indexes for table `glasses`
--
ALTER TABLE `glasses`
  ADD PRIMARY KEY (`glasscode`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `AddressID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3006;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CartID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1020;

--
-- AUTO_INCREMENT for table `frames`
--
ALTER TABLE `frames`
  MODIFY `framecode` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5002;

--
-- AUTO_INCREMENT for table `glasses`
--
ALTER TABLE `glasses`
  MODIFY `glasscode` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1003;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`CustomerID`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`AddressID`) REFERENCES `addresses` (`AddressID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`CustomerID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
