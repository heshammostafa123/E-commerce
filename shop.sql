-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2022 at 07:39 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `Id` int(11) NOT NULL,
  `User_Id` int(11) NOT NULL,
  `Item_Id` int(11) NOT NULL,
  `Required_Quantity` int(11) NOT NULL DEFAULT 1,
  `Price` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`Id`, `User_Id`, `Item_Id`, `Required_Quantity`, `Price`) VALUES
(146, 35, 50, 1, '$379'),
(149, 1, 63, 1, '$599'),
(154, 2, 48, 1, '$1199');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Describtion` text NOT NULL,
  `Parent` int(11) NOT NULL,
  `Ordering` int(11) NOT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Id`, `Name`, `Describtion`, `Parent`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(1, 'Home Appliances', ' Home Appliances Items', 0, 1, 0, 0, 0),
(2, 'Computers', 'Computers Item', 0, 2, 0, 0, 0),
(3, 'Laptops', 'All Laptops Models In One Place', 0, 3, 0, 0, 0),
(4, 'Cell Phones', 'Cell phones', 0, 4, 0, 0, 0),
(5, 'TVs', 'TVs Items', 0, 5, 0, 0, 0),
(8, 'nokia', 'mobile phone', 4, 4, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `C_Id` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `Comment_Date` date NOT NULL,
  `Item_Id` int(11) NOT NULL,
  `User_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`C_Id`, `Comment`, `Status`, `Comment_Date`, `Item_Id`, `User_Id`) VALUES
(23, 'this is very nice product , i wil be buy', 0, '2021-07-14', 51, 2),
(24, 'It is a global brand', 1, '2021-07-14', 53, 2),
(25, 'It is a great device in gaming', 1, '2021-07-14', 66, 2),
(26, 'Bad device in hot times', 1, '2021-07-14', 63, 2),
(27, 'I hope to buy this product in the future', 1, '2021-07-14', 70, 2),
(28, 'A great device, one of the best brands', 1, '2021-07-14', 52, 1),
(29, 'Excellent screen in terms of high quality', 1, '2021-07-14', 69, 1),
(30, 'ggggg', 1, '2021-08-08', 69, 38);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Describtion` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_id` int(11) NOT NULL,
  `Member_id` int(11) NOT NULL,
  `Tags` varchar(255) NOT NULL,
  `Avatar` varchar(255) NOT NULL,
  `available_quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_Id`, `Name`, `Describtion`, `Price`, `Add_Date`, `Country_Made`, `Image`, `status`, `Rating`, `Approve`, `Cat_id`, `Member_id`, `Tags`, `Avatar`, `available_quantity`) VALUES
(1, 'Speaker', 'very Good Speaker', '$10', '2021-05-19', 'china', '', '1', 0, 1, 2, 22, '', '21312_images.jpg', 2),
(4, 'Mouse', 'wired mouse', '$70', '2021-05-20', 'USA', '', '1', 0, 0, 2, 1, '', '74493_d.jpg', 6),
(5, 'Network Cable', 'Building Network Cable', '$7', '2021-05-20', 'USA', '', '1', 0, 1, 2, 1, '', '984784_oad.jpg', 4),
(24, 'Mouse', 'Acer Wire 2.4GHz Mouse ', '$6', '2021-06-19', 'USA', '', '1', 0, 1, 2, 2, '', '74493_d.jpg', 4),
(25, 'Mouse', 'wirless Mouse Magic ', '$11', '2021-07-01', 'china', '', '3', 0, 1, 2, 2, '', '096676_ad.jpg', 4),
(28, 'nokia', 'nokia phone', '$200', '2021-07-01', 'china', '', '1', 0, 1, 4, 2, 'RGb,fdsfds,fsdfs', '03975_Nokia.jpg', 12),
(42, 'Dell', 'Dell G5 15 5590 Intel Core i7-9750H 16GB DDR4 1TB SSD NVIDIA RTX2070', '$1499', '2021-07-14', 'China', '', '1', 0, 1, 3, 1, 'dell,', '939121_Dell.png', 12),
(43, 'Dell', 'DELL XPS 7590 intel core I7-9750H 16GB 512 SSD NVIDIA GTX 1650 4GB WIND 10', '$1399', '2021-07-14', 'china', '', '1', 0, 1, 3, 2, 'dell,', '569879_DELL-XPS-7590.jpg.png', 10),
(44, 'Samsung', 'Samsung 32 Inch HD Smart LED TV With Built-in Receiver - UA32T5300AUXEG', '$430', '2021-07-14', 'china', '', '1', 0, 1, 5, 1, 'Tvs,', '57795_ua32t5300auxeg_1.png', 12),
(45, 'LG', 'LG 50 Inch 4K UHD Smart LED TV with Built-in Receiver - 50UP7550PVG', '$699', '2021-07-14', 'china', '', '1', 0, 1, 5, 2, 'LG,TVs', '450428_50up7550pvg_eg_en.jpg', 14),
(46, 'Samsung', 'Samsung 55 Inch 4K Crystal UHD Smart Curved LED TV with Built-in Receiver - UA55TU8300FXZA', '$569', '2021-07-14', 'china', '', '1', 0, 1, 5, 2, 'Samsung,TVs', '983378_55tu8300.png', 13),
(47, 'Realme', 'Realme 8 Pro Dual Sim, 128 GB, 8 GB RAM, 4G LTE, Black', '$299', '2021-07-14', 'china', '', '1', 0, 1, 4, 2, 'Realme,Phones', '477502_black_1_1.png', 15),
(48, 'Apple', 'Apple iPhone 12 Pro Max, 256GB, 5G - Pacific Blue', '$1199', '2021-07-14', 'USA', '', '1', 0, 1, 4, 1, 'Apple,Phones', '570802_item_XL_132022623_fafff7501c154.jpg', 9),
(49, 'Samsung Galaxy ', 'Samsung Galaxy A12 Dual Sim, 128GB, 4GB RAM, 4G LTE - Blue', '$299', '2021-07-14', '$china', '', '1', 0, 1, 4, 2, 'Samsung_Galaxy ,Phones', '444624_samsung-galaxy-a12-128gb-blue_1.jpg', 10),
(50, 'Realme 8 Pro Dual Sim', 'Realme 8 Pro Dual Sim, 128 GB, 8 GB RAM, 4G LTE, Blue', '$379', '2021-07-14', 'china', '', '1', 0, 1, 4, 2, 'Realme,Phones', '109756_blue_1.png', 9),
(51, 'Oppo A54 Dual Sim', 'Oppo A54 Dual Sim, 64GB, 4GB RAM, 4G LTE - Crystal Black', '$299', '2021-07-14', 'china', '', '1', 0, 1, 4, 1, 'Oppo_A54,Phones', '351612_oppo_a54_dual_sim_64gb_4gb_black.jpg', 12),
(52, 'Apple iPhone 12 Pro', 'Apple iPhone 12 Pro, 128GB, 5G - Gold', '$999', '2021-07-14', 'USA', '', '1', 0, 1, 4, 2, 'Apple_iPhone_12_Pro,Phones', '959114_apple_iphone_12_pro_128gb_5g_-_gold.jpg', 6),
(53, 'Zanussi Split Air Conditioner', 'Zanussi Split Air Conditioner, 1.5 Hp, Cooling And Heating, Silver- ZS12V69CCHI', '$349', '2021-07-14', 'china', '', '1', 0, 1, 1, 1, 'Zanussi_Split_Air_Conditioner,Home_Appliances', '941858_1_52_1.jpg', 9),
(54, 'Samsung Washing Machine', 'Samsung Top Load Automatic Washing Machine, 14 KG, Inverter Motor Grey- WA14J5730SG/AS', '$444', '2021-07-14', 'china', '', '1', 0, 1, 1, 1, 'Samsung_Automatic_Washing_Machine,Home_Appliances', '687672_samsung_wa14j5730sg_1_.jpg', 19),
(55, 'Gas And Electric Cooker', 'Premium I Chef Plus Gas And Electric Cooker, 5 Burners, Stainless Steel/Black- PRM6090GS-AC-383-IDSH-S-', '$499', '2021-07-14', 'china', '', '1', 0, 1, 1, 1, 'Gas_And_Electric_Cooker,Home_Appliances', '50640_premium_i_chef_plus_1_2_.jpg', 19),
(56, 'Indesit Upright Freezer', 'Indesit No-Frost Upright Freezer, 5 Drawers, White- UI4 F1T W', '$399', '2021-07-14', 'china', '', '1', 0, 1, 1, 1, 'Indesit_Upright_Freezer,Home_Appliances', '260093_dsc_8608.jpg', 15),
(57, 'Zanussi Washing Machine', 'Zanussi Front Load Automatic Washing Machine, 6 KG, Silver- ZWF60830SX', '$299', '2021-07-14', 'china', '', '1', 0, 1, 1, 1, 'Zanussi_Washing_Machine,Home_Appliances', '156500_3j5a1024_copy_copy.jpg', 15),
(58, 'Ariston Refrigerator', 'Ariston No-Frost Freestanding Refrigerator, 342 Liters, Silver- ENTM 18020 F EX', '$399', '2021-07-14', 'china', '', '1', 0, 1, 1, 20, 'Ariston_Freestanding_Refrigerator,Home_Appliances', '270924_3j5a5209_copy.jpg', 20),
(59, 'Samsung Washing Machine', 'Samsung Front Load Automatic Washing Machine, 7 KG, Inverter Motor, Inox- WW70T4020CX1AS', '$399', '2021-07-14', 'china', '', '1', 0, 1, 1, 22, 'Samsung_Washing_Machine,Home_Appliances', '609064_ww90t534dan1as_001_front_inox.jpg', 30),
(60, 'Ariston Built-in Hood', 'Ariston Built-in Hood, 60 CM, Inox- SL161LIX', '$199', '2021-07-14', 'china', '', '1', 0, 1, 1, 20, 'Ariston_Built-in_Hood,Home_Appliances', '365508_sl161lix.jpeg', 20),
(61, 'Zanussi Freestanding Dishwasher', 'Zanussi Freestanding Dishwasher, 13 Place Settings,Stainless Steel- ZDF22002XA', '$599', '2021-07-14', 'USA', '', '1', 0, 1, 1, 23, 'Zanussi_Freestanding_Dishwasher,Home_Appliances', '271014_zanussi-dishwasher-13-persons-zdf22002xa_2_.jpg', 40),
(62, 'Lenovo IdeaPad 3', 'Lenovo IdeaPad 3 15ADA05 Laptop, AMD Athlon 3050U, 15.6 Inch, 1TB, 4GB RAM, AMD Radeon Graphics', '$399', '2021-07-14', 'USA', '', '1', 0, 1, 3, 23, 'Lenovo_IdeaPad_3,Laptops', '64865_lenovo-3-15ada05-athlon-3050u-1tb-bk_1.jpg', 19),
(63, 'HP Notebook ', 'HP Notebook 15-da2380ne Laptop, Intel Core i5-10210U, 15.6 Inch, 1TB+128GB SSD, 8GB RAM, NVIDIA GeForce MX130 4GB', '$599', '2021-07-14', 'china', '', '1', 0, 1, 3, 22, 'HP Notebook ,Laptops', '300112_hp-15-da2380ne-i5-10210u-1tb-128gb-ssd.jpg', 19),
(64, 'HP 290 G2', 'HP 290 G2 INTEL CORE I3-8100 4GB DDR4 500GB HDD INTEL UHD GRAPHICS 630 DOS + MONITOR 18.5\"', '$499', '2021-07-14', 'china', '', '1', 0, 1, 2, 22, 'HP_290_G2,Computers', '252612_HP-290_G2-Intel_Core_i3-EGYPTLAPTOP-1_lspx-o2.jpg', 20),
(65, 'LENOVO THINKCENTER', 'LENOVO THINKCENTER EDGE 73 INTEL PENTIUM-G3250 RAM 2GB H.D 500 GB', '$299', '2021-07-14', 'china', '', '1', 0, 1, 2, 20, 'LENOVO_THINKCENTER_EDGE_73,Computers', '854108_Lenovo-EDGE93-TOWER-Core-i7-4770-4GB-1TB_1137722_12e3fb7986a9cdb6e75e306250713212.jpg.png', 20),
(66, 'HP 24-F0001NE AIO', 'HP 24-F0001NE AIO PC INTEL CORE™ I7-8700T RAM 8 GB DDR4 HARD 1 TB VGA NVIDIA® GEFORCE® MX110 2 GB ', '$399', '2021-07-14', 'china', '', '1', 0, 1, 2, 22, 'HP_24-F0001NE_AIO,Computers', '86186_24-f0001ne_rv6h-5k.gif.png', 20),
(67, 'DELL OPTIPLEX 3080', 'DELL OPTIPLEX 3080 T INTEL CORE I3-10100 4GB DDR4 1TB HDD INTEL UHD GRAPHICS 630', '$399', '2021-07-14', 'USA', '', '1', 0, 1, 2, 20, 'DELL_OPTIPLEX_3080,Computers', '564741_1606137345_IMG_1449979_1e6t-l8.jpg', 20),
(68, 'HUAWEI MATESTATIONS', 'HUAWEI MATE STATIONS AMD RYZEN 5 4600G 8GB DDR4 256GB SSD AMD RADEON GRAPHICS WIN10 + HUAWEI 24 INCH AD80', '$399', '2021-07-14', 'USA', '', '1', 0, 1, 2, 22, 'HUAWEI_MATESTATIONS,Computers', '177186_HUAWEI-MATE-STATION.jpg.png', 40),
(69, 'LG 65 Inch', 'LG 65 Inch 4K UHD Smart LED TV with Built-in Receiver - 65UN7240PVG', '$599', '2021-07-14', 'china', '', '1', 0, 1, 5, 23, 'LG_65_Inch,TVs', '6258_dz_01.jpg', 20),
(70, 'Samsung 32 Inch HD ', 'Samsung 32 Inch HD LED TV with Built-in Receiver - 32N5000', '$299', '2021-07-14', 'china', '', '1', 0, 1, 5, 22, 'Samsung_32_Inch,TVs', '82570_hk-en-full-hd-n5000-100272253_2.jpg', 20),
(71, 'Toshiba 55 Inch', 'Toshiba 55 Inch 4K UHD Smart LED TV with Built-in Receiver - 55U5965 and 3 Months Shahid VIP Subscription', '$499', '2021-07-14', 'china', '', '1', 0, 1, 5, 23, 'Toshiba_55_Inch,TVs', '910215_toshiba-4k-smart-led-tv-55-inch-55u5965-front.jpg', 19),
(72, 'Tornado 55 Inch', 'Tornado 55 Inch 4K UHD Frameless Smart LED TV with Built-in Receiver - 55UA1400E and 6 Months Shahid VIP Subscription', '$299', '2021-07-14', 'china', '', '1', 0, 1, 5, 23, 'Tornado_55_Inch,Tvs ', '340983_tornado-55-4k-smart-led-tv-55ua1400e_1.jpg', 20),
(73, 'phone', 'ppll,,plvfv', '$20', '2021-07-14', 'china', '', '1', 0, 0, 4, 2, 'phone', '611892_oppo_a54_dual_sim_64gb_4gb_black.jpg', 20);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `Order_Number` int(11) NOT NULL,
  `Customer_Id` int(11) NOT NULL,
  `Customer_Name` varchar(255) NOT NULL,
  `Order_Cost` varchar(255) NOT NULL,
  `Deliver_To` varchar(255) NOT NULL,
  `Address` text NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Order_Date` date NOT NULL,
  `delivered` int(11) NOT NULL DEFAULT 0,
  `Comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`Order_Number`, `Customer_Id`, `Customer_Name`, `Order_Cost`, `Deliver_To`, `Address`, `Email`, `Phone`, `Order_Date`, `delivered`, `Comment`) VALUES
(74, 2, 'hesham', '$506', 'asiut', 'Asyut , abnob Tahrir Street Taksim Adel Halim Street Number One', 'hesham@gmial.com', '01126110587', '2021-07-14', 0, ''),
(75, 1, 'Ahmed', '$569', 'assuit', 'Assiut,No. 27 El Gomhoria Street, next to Alexandria Bank', 'Ahmed@gmial.com', '01153372794', '2021-07-14', 0, ''),
(76, 2, 'hesham', '$743', 'assuit', 'assuit , abnob', 'hesham@gmial.com', '12312312312', '2021-07-14', 0, ''),
(77, 2, 'hesham', '$299', 'asuit', 'Assiut,next to Alexandria Bank', 'hesham@gmial.com', '0112611587', '2021-07-14', 0, ''),
(78, 2, 'hesham', '$1097', 'asyt', 'Assiut,No. 27 El Gomhoria Street, next to Alexandria Bank', 'hesham@gmial.com', '01126110587', '2021-07-14', 0, ''),
(79, 38, 'heshammostafa', '$30', 'assuit', 'ddddddddd', 'gamal@gmail.com', '01126110587', '2021-08-08', 0, ''),
(80, 38, 'heshammostafa', '$748', 'csfee', 'xsssssssssssssss', 'gamal@gmail.com', '0112', '2021-08-08', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `Order_Id` int(11) NOT NULL,
  `User_Id` int(11) NOT NULL,
  `Item_Id` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `Order_Id`, `User_Id`, `Item_Id`, `Quantity`) VALUES
(83, 74, 2, 5, 1),
(84, 74, 2, 55, 1),
(85, 75, 1, 46, 1),
(86, 76, 2, 54, 1),
(87, 76, 2, 47, 1),
(88, 77, 2, 47, 1),
(89, 78, 2, 47, 2),
(90, 78, 2, 71, 1),
(91, 78, 2, 47, 2),
(92, 79, 38, 1, 3),
(93, 80, 38, 53, 1),
(94, 80, 38, 62, 1);

-- --------------------------------------------------------

--
-- Table structure for table `problems`
--

CREATE TABLE `problems` (
  `id` int(11) NOT NULL,
  `User_Id` int(11) NOT NULL,
  `problem` varchar(255) NOT NULL,
  `problem_desc` text NOT NULL,
  `Meeting_Date` date NOT NULL,
  `meeting_id` int(11) NOT NULL,
  `pass_code` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `totalcost`
--

CREATE TABLE `totalcost` (
  `id` int(11) NOT NULL,
  `User_Id` int(11) NOT NULL,
  `Total` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `totalcost`
--

INSERT INTO `totalcost` (`id`, `User_Id`, `Total`) VALUES
(56, 35, '$678'),
(57, 1, '$599'),
(60, 2, '$1199');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserId` int(11) NOT NULL COMMENT 'to identify user',
  `UserName` varchar(255) NOT NULL COMMENT 'user to login',
  `Password` varchar(255) NOT NULL COMMENT 'password to login',
  `Email` varchar(255) DEFAULT NULL,
  `FullName` varchar(255) DEFAULT NULL,
  `GroupId` int(11) NOT NULL DEFAULT 0 COMMENT 'ideintify user group',
  `truststatus` int(11) NOT NULL DEFAULT 0 COMMENT 'seller rank',
  `Regstatus` int(11) NOT NULL DEFAULT 0 COMMENT 'user approval',
  `Date` date NOT NULL,
  `Avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `UserName`, `Password`, `Email`, `FullName`, `GroupId`, `truststatus`, `Regstatus`, `Date`, `Avatar`) VALUES
(1, 'Ahmed', '601f1889667efaebb33b8c12572835da3f027f78', 'Ahmed@gmial.com', 'Ahmed Nassar', 1, 0, 1, '0000-00-00', '57579_62305416_1108529742673422_7313034136225054720_n.jpg'),
(2, 'hesham', '601f1889667efaebb33b8c12572835da3f027f78', 'hesham@gmial.com', 'hesham mostafa', 1, 0, 1, '0000-00-00', '428001_IMG-20210405-WA0327.jpg'),
(20, 'mohamed', '601f1889667efaebb33b8c12572835da3f027f78', 'Engmohamed@gmail.com', 'Mohamed Mostafa', 0, 0, 1, '2019-10-19', '13066_118617394_1194620704218740_1477528961762700189_n.jpg'),
(22, 'khalid', '601f1889667efaebb33b8c12572835da3f027f78', 'khalid@gmail.com', 'khalid Abdel-Mohsen', 0, 0, 1, '2019-11-17', ''),
(23, 'Islam', '8cb2237d0679ca88db6464eac60da96345513964', 'Islam@gmail.com', 'Islam', 0, 0, 1, '2019-11-20', '840229_59412294_1907693506002421_2752363211058577408_n.jpg'),
(24, 'mostafa', '444528fc68f99ea0f4fe027cb6cbd262f2a707fe', 'Engmostafa@gmail.com', 'mostafa Mamdouh', 0, 0, 1, '2020-01-13', '37653_84154823_3100753666817473_6440424260602167296_n.jpg'),
(25, 'osama', '601f1889667efaebb33b8c12572835da3f027f78', 'oasma@gmail.com', 'osama Abdel-Mohsen', 0, 0, 1, '2020-01-20', '358271_211789668_571867083842639_1796608140172051839_n.jpg'),
(27, 'Mazher', '601f1889667efaebb33b8c12572835da3f027f78', 'Mazher12@gmail.com', 'Ahmed Mazher', 0, 0, 1, '2020-01-20', '472174_B41A9038.jpg'),
(33, 'Amar', '601f1889667efaebb33b8c12572835da3f027f78', 'Amar@gmail.com', 'Mostafa Amar', 0, 0, 1, '2021-07-12', '891820_B41A9078.jpg'),
(35, 'Haytham', '601f1889667efaebb33b8c12572835da3f027f78', 'haytham12@gmail.com', 'Haytham Asaad', 0, 0, 0, '2021-07-14', '531894_151026223_2858692991039367_8263108555739444729_n.jpg'),
(36, 'Yahya', '601f1889667efaebb33b8c12572835da3f027f78', 'Yahya_Sayed@gmail.com', '', 0, 0, 0, '2021-07-14', ''),
(37, 'ibrahim', '601f1889667efaebb33b8c12572835da3f027f78', 'ibrahim@gmail.com', '', 0, 0, 0, '2021-07-14', ''),
(38, 'heshammostafa', '601f1889667efaebb33b8c12572835da3f027f78', 'gamal@gmail.com', '', 0, 0, 1, '2021-08-08', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `itemid` (`Item_Id`),
  ADD KEY `user_id` (`User_Id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`C_Id`),
  ADD KEY `Items_comment` (`Item_Id`),
  ADD KEY `user_comment` (`User_Id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_Id`),
  ADD KEY `member_1` (`Member_id`),
  ADD KEY `cat_1` (`Cat_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`Order_Number`),
  ADD KEY `order_cost` (`Customer_Id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`Order_Id`);

--
-- Indexes for table `problems`
--
ALTER TABLE `problems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`User_Id`);

--
-- Indexes for table `totalcost`
--
ALTER TABLE `totalcost`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`User_Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`),
  ADD UNIQUE KEY `UserName` (`UserName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `C_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `Order_Number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `problems`
--
ALTER TABLE `problems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `totalcost`
--
ALTER TABLE `totalcost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'to identify user', AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `itemid` FOREIGN KEY (`Item_Id`) REFERENCES `items` (`Item_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`User_Id`) REFERENCES `users` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Items_comment` FOREIGN KEY (`Item_Id`) REFERENCES `items` (`Item_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_comment` FOREIGN KEY (`User_Id`) REFERENCES `users` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_id`) REFERENCES `categories` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_id`) REFERENCES `users` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `order_cost` FOREIGN KEY (`Customer_Id`) REFERENCES `users` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_id` FOREIGN KEY (`Order_Id`) REFERENCES `orders` (`Order_Number`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `problems`
--
ALTER TABLE `problems`
  ADD CONSTRAINT `id` FOREIGN KEY (`User_Id`) REFERENCES `users` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `totalcost`
--
ALTER TABLE `totalcost`
  ADD CONSTRAINT `userid` FOREIGN KEY (`User_Id`) REFERENCES `users` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
