-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2021 at 11:31 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proyekpw`
--
CREATE DATABASE IF NOT EXISTS `proyekpw` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `proyekpw`;

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

DROP TABLE IF EXISTS `barang`;
CREATE TABLE `barang` (
  `id_barang` int(10) NOT NULL,
  `nama_barang` varchar(256) DEFAULT NULL,
  `desc_barang` varchar(256) NOT NULL,
  `harga_barang` int(12) NOT NULL,
  `stok_barang` int(12) NOT NULL,
  `id_kategori` int(1) NOT NULL,
  `foto_barang` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `desc_barang`, `harga_barang`, `stok_barang`, `id_kategori`, `foto_barang`) VALUES
(1, 'Astrox 100 ZZ', 'Designed with a slimmer shaft and an advanced Rotational Generator System, this new badminton racquet was created for advanced players.', 3200000, 2, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/202105/8294_MT_1621302575734.jpg'),
(2, 'Voltric Glanz', 'Effortlessly achieve long distance shots, solid feel, exceptional power, and fast handling for attacking shots.', 3000000, 2, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201607/2725_MT_1468987011991.jpg'),
(3, 'Astrox 88 D Pro', 'Evolve Your Game. Yonex has done the impossible and improved on their bestselling Astrox 88D Pro. Built for players that like to play in the back of the court to send powerful smashes and clears, the 88D Pro pairs perfectly with the 88S Pro. With the 88D P', 2900000, 4, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/202103/8097_MT_1615791097878.jpg'),
(4, 'Astrox 99 Pro', '', 2725000, 10, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/202109/8357_MT_1632132801073.jpg'),
(5, 'Duora 10', 'Box-shaped for power. Aerodynamic for speed. Strong forehand smash. Fast backhand drive.', 2629000, 0, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201709/4363_MT_1504853668771.jpg'),
(6, 'Voltric Z-Force II LD', 'Extra Slim Shaft with improved TRI-VOLTAGE SYSTEM that increases smash energy.', 2519000, 15, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201505/2071_MT_1432113831473.jpg'),
(7, 'Astrox 99', 'Overwhelm the opposition with the fast and powerful ASTROX. For players who demand a steep angled and devastating smash, taking the point to their opponent.', 2510000, 44, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201808/4955_MT_1535097064641.jpg'),
(8, 'Nanoflare 800 Light', 'For advanced players looking to take the attack to their opponent with extreme swing speeds and maneuverability from a headlight racquet', 2500000, 3, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/202009/7583_MT_1600226666635.jpg'),
(9, 'Duora 10 LT', 'Box-shaped for power. Aerodynamic for speed. Strong forehand smash. Fast backhand drive.', 2500000, 1, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201805/4825_MT_1526530531230.jpg'),
(10, 'Nanoray 900', 'The frame controls the angle of the shuttlecock for a completely new angle to your smash shots.', 2500000, 4, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201707/4112_MT_1499735527037.jpg'),
(11, 'ArcSaber 11', 'Neo CS CARBON NANOTUBE adds bite to the shuttlecock while SONIC METAL helps deliver a high repulsion, rapid-fire return.', 2474000, 5, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201707/4123_MT_1500014174717.jpg'),
(12, 'Voltric LD Force', 'VOLTRIC LD-FORCE combining incredible power and fast racquet handling for the first time, VOLTRIC is the perfect racquet for players seeking both power and control to dominate the game.', 2400000, 1, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201904/6071_MT_1554435105883.jpg'),
(13, 'Nanoray 800', 'X-FULLERENE combined with SONIC METAL produces a fast and controlled swing that generates powerfully accurate, rapid-fire shots.', 2400000, 8, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201807/4866_MT_1530688388658.jpg'),
(14, 'Astrox 88 D', 'Uniquely designed for the doubles specialist, the “ASTROX 88 D” is aimed at allowing the back court player to “DOMINATE” the opposition.', 2400000, 9, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201802/4612_MT_1517561973512.jpg'),
(15, 'ArcSaber 10', 'Rumored as the latest ultimate weapon in the sport of badminton, the Yonex Arc Saber 10 has the latest and greatest technology to help its user achieve power, speed, and control.', 2364000, 3, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201905/6138_MT_1557202046949.jpg'),
(16, 'Voltric FB', 'Lightweight racquet that provides a solid feel and excellent power.', 2300000, 5, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201702/3593_MT_1487046413792.jpg'),
(17, 'Nanoray Z-Speed', 'HORIZONTAL-A CONCEPT enlarges the sweet spot that enhances the explosive power of the SBZ (SNAP BACK ZONE) to power the shuttle.', 2300000, 2, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201604/2343_MT_1461202000193.jpg'),
(18, 'Duora 9', 'Box-shaped for power. Aerodynamic for speed. Strong forehand smash. Fast backhand drive.', 2400000, 1, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201802/4554_MT_1518504534445.jpg'),
(19, 'Nanoflare 700', '', 2200000, 7, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201902/5714_MT_1550215884950.jpg'),
(20, 'Astrox 77', 'The ASTROX 77 is an attack-orientated model which can lead a high-speed game with a design which can deliver powerful, steep smashes allowing for more chances with the shuttlecock.', 2200000, 17, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201708/4341_MT_1502777747083.jpg'),
(21, 'Duora 7', '', 2179000, 2, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201807/4868_MT_1530688140345.jpg'),
(22, 'Nanoflare 600', '', 2100000, 6, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201912/6970_MT_1576632165343.jpg'),
(23, 'Voltric 80 E-Tune', 'More speed on offensive drives. More power on decisive smashes.', 2100000, 2, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201504/1928_MT_1429862688924.jpg'),
(24, 'ArcSaber 7', 'The ARC7 produces plenty of repulsion power, guided by accuracy and control. CS CARBON NANOTUBE used in the frame creates an extremely elastic racquet that explodes with repulsion power.', 2056000, 1, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201807/4828_MT_1530697363255.jpg'),
(25, 'Astrox 99 Tour', '', 2000000, 5, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/202109/8359_MT_1632132184620.jpg'),
(26, 'Voltric Z-Force II', 'Extra Slim Shaft with improved TRI-VOLTAGE System that increases smash energy.', 1850000, 0, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201504/1197_MT_1429860326098.jpg'),
(27, 'Astrox 100 ZX', 'Designed with a slimmer shaft and an advanced Rotational Generator System, this new badminton racquet was created for advanced players.', 1700000, 5, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/202002/7254_MT_1582863028113.jpg'),
(28, 'Voltric Z-Force Ltd', 'This racquet has been reproduced for a limited time only. All current stock has been manufactured in 2020 and 2021.', 1634000, 14, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201504/69_MT_1429862689637.gif'),
(29, 'Nanoray 200 Aero', '', 1625000, 2, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201712/4498_MT_1513062466218.jpg'),
(30, 'Astrox 22', '', 1400000, 2, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/202002/7081_MT_1582171224492.jpg'),
(31, 'Nanoflare 200', '', 1339000, 1, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/202104/7592_MT_1618974561341.jpg'),
(32, 'ASTROX 22LT', '', 1246000, 5, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/202103/8123_MT_1614655646422.jpg'),
(33, 'Nanoray 100 SH', 'For Advanced players.', 1219000, 12, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201709/4347_MT_1506072324476.jpg'),
(34, 'Astrox 99 Game', '', 1200000, 12, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/202109/8352_MT_1632133946130.jpg'),
(35, 'Astrox 88 D Game', '', 1200000, 11, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/202109/8347_MT_1632130190673.jpg'),
(36, 'ASTROX 100 GAME', '', 1200000, 13, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/202106/8299_MT_1623638834779.jpg'),
(37, 'ArcSaber 71 Lite', '', 399000, 21, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/202003/7258_MT_1585386099745.jpg'),
(38, 'Nanoray Light 11i', 'A racquet which delivers fast handling and high repulsion, responding to high-speed rallies with lightning fast movement.', 399000, 39, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201801/4526_MT_1516592266473.jpg'),
(39, 'Isometric Lite 3', 'AERO Frame and ISOMETIC shape allow for lighter, easier play.', 395000, 25, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201704/3980_MT_1493000862568.jpg'),
(40, 'Muscle Power 22 Light', '', 373000, 27, 1, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201902/5604_MT_1550719231109.jpg'),
(41, 'Power Cushion Infinity', 'All-around comfort and stability for the best-fitting performance', 3099000, 5, 2, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201904/6128_MT_1555317818261.jpg'),
(42, 'Power Cushion Eclipsion Z Wide', '', 2000000, 15, 2, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201912/6989_MT_1577334235251.jpg'),
(43, 'Power Cushion Comfort Z 2 Mens', '', 2100000, 21, 2, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201912/6986_MT_1577091366938.jpg'),
(44, 'Power Cushion 65 Z 2', 'Power Cushion+ equipped Comfortable fit flagship model', 1990000, 19, 2, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201908/6575_MT_1567216096720.jpg'),
(45, 'Power Cushion 88 Dial', '', 1950000, 19, 2, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201912/6980_MT_1577093695384.jpg'),
(46, 'Power Cushion Aerus 3 Men', 'Yonex’s lightest shoe at 270g. Superior ventilation and solid fit.', 1800000, 2, 2, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201907/6518_MT_1564368299064.jpg'),
(47, 'Power Cushion 65 X 3', '', 1200000, 12, 2, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/202109/8432_MT_1632130747165.jpg'),
(48, 'Power Cushion 65 R3', 'Gentle on feet and joints with good grip.', 799000, 4, 2, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201909/6736_MT_1569314062336.jpg'),
(49, '888 SL LTD', '', 999000, 9, 2, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201910/6755_MT_1570094628032.jpg'),
(50, 'Hydro Force 2', '', 679000, 1, 2, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201904/6087_MT_1556272327191.jpg'),
(51, 'Akayu 1', '', 359000, 4, 2, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201901/5403_MT_1547199860031.jpg'),
(52, 'All England 03', '', 399000, 39, 2, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201809/5269_MT_1536986766337.jpg'),
(53, 'Court Ace Light', '', 499000, 26, 2, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201704/3681_MT_1493371333847.jpg'),
(54, 'Super Ace Light', 'Rule the game with Super Ace Light', 499000, 5, 2, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201707/4119_MT_1500975475763.jpg'),
(55, '777', '', 399000, 23, 2, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201910/6750_MT_1570088197778.jpg'),
(56, 'Aeroclub 33 (12 In 1)', 'The Aeroclub series are the ideal shuttlecocks for both practice and tournament.', 430000, 5, 3, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201504/1918_MT_1430133227692.jpg'),
(57, 'Aerosensa 40 (12 In 1)', 'YONEX Feather Shuttlecocks are precision-manufactured to ensure the correct speed, distance and stability performance.', 520000, 3, 3, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201504/718_MT_1429862689006.jpg'),
(58, 'Aeroclub 11 (12 In 1)', 'The Aeroclub series are the ideal shuttlecocks for both practice and tournament.', 399000, 5, 3, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201504/1919_MT_1430133241642.jpg'),
(59, 'Aeroclub Tour (12 In 1)', 'The Aeroclub series are the ideal shuttlecocks for both practice and tournament.', 289000, 2, 3, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201504/1359_MT_1429862688731.jpg'),
(60, 'Aerosensa 50 (12 In 1)', 'YONEX Feather Shuttlecocks are precision-manufactured to ensure the correct speed, distance and stability performance.', 530000, 0, 3, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201504/722_MT_1429862689926.jpg'),
(61, 'Aerosensa 20 (12 In 1)', 'YONEX Feather Shuttlecocks are precision-manufactured to ensure the correct speed, distance and stability performance.', 440000, 0, 3, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201504/713_MT_1429862689555.jpg'),
(62, 'BN143C Pro', '', 469000, 1, 4, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201504/624_MT_1429862689251.jpg'),
(63, 'BN152C PRO', '', 599000, 4, 4, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201504/626_MT_1429862689359.jpg'),
(64, 'BN142C', '', 389000, 5, 4, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201504/622_MT_1429862689478.jpg'),
(65, 'BN141NB', '', 369000, 2, 4, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201504/619_MT_1429862689469.jpg'),
(66, 'BN139A', '', 319000, 2, 4, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201504/618_MT_1429862689608.jpg'),
(67, 'BN136', '', 239000, 1, 4, 'https://cdn-sunriseclick.s3.amazonaws.com/images/model/thumb/201504/616_MT_1429862689650.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori` (
  `id_kategori` int(10) NOT NULL,
  `nama_kategori` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Rackets'),
(2, 'Shoes'),
(3, 'Shuttlecocks'),
(4, 'Nets');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id_user` int(10) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email_user` varchar(256) NOT NULL,
  `nama_user` varchar(256) NOT NULL,
  `nomor_user` int(12) DEFAULT NULL,
  `gender_user` int(1) DEFAULT NULL,
  `tl_user` date DEFAULT NULL,
  `kota_user` varchar(256) DEFAULT NULL,
  `foto_user` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `email_user`, `nama_user`, `nomor_user`, `gender_user`, `tl_user`, `kota_user`, `foto_user`) VALUES
(1, 'kenny', 'kenny', 'kenny@gmail.com', 'Kenny', 0, 0, '0000-00-00', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
