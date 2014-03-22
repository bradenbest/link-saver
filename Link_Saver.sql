-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 22, 2014 at 08:12 PM
-- Server version: 5.5.31
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Link_Saver`
--
CREATE DATABASE IF NOT EXISTS `Link_Saver` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `Link_Saver`;

-- --------------------------------------------------------

--
-- Table structure for table `temp`
--

CREATE TABLE IF NOT EXISTS `temp` (
  `key` text NOT NULL,
  `name` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isadmin` int(11) NOT NULL DEFAULT '0',
  `verified` int(11) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `pass` text NOT NULL,
  `email` text NOT NULL,
  `data` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
