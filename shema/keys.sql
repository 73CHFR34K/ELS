-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: 10.246.16.57:3306
-- Generation Time: Oct 21, 2013 at 04:03 PM
-- Server version: 5.1.66-0+squeeze1
-- PHP Version: 5.3.3-7+squeeze15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `els`
--

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE IF NOT EXISTS `keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `key` varchar(255) NOT NULL,
  `Date` int(11) NOT NULL,
  `expireDate` date NOT NULL,
  `hwid` varchar(255) NOT NULL,
  `product` text NOT NULL,
  `registered` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=133 ;

--
-- Dumping data for table `keys`
--

INSERT INTO `keys` (`id`, `created`, `key`, `Date`, `expireDate`, `hwid`, `product`, `registered`) VALUES
(123, '2013-10-21 11:57:28', '5IHY-I51E-RTNB', 30, '0000-00-00', '', '', '0000-00-00 00:00:00'),
(95, '2013-10-20 13:06:39', '2WHR-SZYF-4LA1', 30, '0000-00-00', '', '', '0000-00-00 00:00:00'),
(121, '2013-10-21 11:57:27', '6V1J-UELP-VT0X', 30, '0000-00-00', '', '', '0000-00-00 00:00:00'),
(117, '2013-10-21 10:33:01', 'WBVN-GGGI-QSDC', 80, '0000-00-00', '', '', '0000-00-00 00:00:00'),
(118, '2013-10-21 11:57:26', '0DI5-J77Y-M8MC', 30, '0000-00-00', '', '', '0000-00-00 00:00:00'),
(120, '2013-10-21 11:57:27', 'TMWS-BZ01-39XC', 30, '0000-00-00', '', '', '0000-00-00 00:00:00'),
(125, '2013-10-21 11:57:28', 'V3K9-A2P6-AWVI', 30, '0000-00-00', '', '', '0000-00-00 00:00:00'),
(132, '2013-10-21 15:39:14', 'XN38-JX9V-XHSR', 30, '0000-00-00', '', '', '0000-00-00 00:00:00'),
(128, '2013-10-21 13:33:08', '1IUC-GYPT-P951', 30, '0000-00-00', '', '', '0000-00-00 00:00:00'),
(129, '2013-10-21 13:34:42', 'UKFH-04HV-G8T7', 30, '0000-00-00', '', '', '0000-00-00 00:00:00'),
(130, '2013-10-21 14:07:35', '01VX-33RV-BBXI', 2, '0000-00-00', '', '', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
