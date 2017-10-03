-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2017 at 08:50 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wallpaperdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `wallpaper`
--

CREATE TABLE IF NOT EXISTS `wallpaper` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(100) DEFAULT 'not works',
  `ThumbUrl` longtext,
  `IsNew` tinyint(1) DEFAULT '1',
  `AddedBy` varchar(100) DEFAULT 'purefaithstudio',
  `DirectoryName` varchar(100) NOT NULL DEFAULT 'notworks',
  `Downloads` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `wallpaper`
--

INSERT INTO `wallpaper` (`ID`, `Title`, `ThumbUrl`, `IsNew`, `AddedBy`, `DirectoryName`, `Downloads`) VALUES
(1, 'parallax-butterfly', 'butterfly', 1, 'harsimran singh', 'butterfly', 0),
(2, 'parallax-ironman', 'ironman', 1, 'harsimran singh', 'ironman', 0),
(3, 'parallax-transformer', 'transformer', 1, 'harsimran singh', 'transformer', 0),
(4, 'parallax-Hulk-Buster', 'hulkbuster', 0, 'harsimran singh', 'hulkbuster', 0),
(5, 'parallax-Paper Cut-Out', 'papercutout', 0, 'harsimran singh', 'papercutout', 0),
(6, 'parallax-Screen Crack', 'screencrack', 0, 'harsimran singh', 'screencrack', 0),
(7, 'parallax-Earth Crack', 'earthcrack', 0, 'harsimran singh', 'earthcrack', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wallpapergroup`
--

CREATE TABLE IF NOT EXISTS `wallpapergroup` (
  `GroupId` int(11) DEFAULT NULL,
  `LayerUrl` longtext,
  `Type` varchar(9) NOT NULL DEFAULT '.jpg',
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `LayerOrder` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `GroupId` (`GroupId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `wallpapergroup`
--

INSERT INTO `wallpapergroup` (`GroupId`, `LayerUrl`, `Type`, `ID`, `LayerOrder`) VALUES
(1, 'butterfly0', '.png', 1, 0),
(1, 'butterfly1', '.jpg', 2, 1),
(2, 'ironman0', '.png', 3, 1),
(2, 'ironman1', '.png', 4, 2),
(2, 'ironman2', '.jpg', 5, 3),
(2, 'crack', '.png', 6, 0),
(3, 'transformer0', '.png', 7, 0),
(3, 'transformer1', '.png', 8, 1),
(3, 'transformer2', '.jpg', 9, 2),
(4, 'hulkbuster0', '.png', 10, 0),
(4, 'hulkbuster1', '.png', 11, 1),
(4, 'hulkbuster2', '.png', 12, 2),
(4, 'hulkbuster3', '.jpg', 13, 3),
(5, 'cutout0', '.png', 14, 0),
(5, 'cutout1', '.png', 15, 1),
(5, 'cutout2', '.png', 16, 2),
(5, 'cutout3', '.png', 17, 3),
(5, 'cutout4', '.png', 18, 4),
(6, 'screencrack0', '.png', 19, 0),
(6, 'chip', '.png', 20, 1),
(7, 'chip', '.png', 21, 1),
(7, 'earthcrack0', '.png', 22, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `wallpapergroup`
--
ALTER TABLE `wallpapergroup`
  ADD CONSTRAINT `wallpapergroup_ibfk_1` FOREIGN KEY (`GroupId`) REFERENCES `wallpaper` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
