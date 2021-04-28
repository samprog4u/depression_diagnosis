-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 20, 2021 at 11:20 AM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bot`
--

-- --------------------------------------------------------

--
-- Table structure for table `chatbot`
--

CREATE TABLE IF NOT EXISTS `chatbot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `chatbot`
--

INSERT INTO `chatbot` (`id`, `query`) VALUES
(1, 'Little interest or pleasure in doing things?'),
(2, 'Feeling down, depressed and hopeless?'),
(3, 'Trouble falling or staying asleep, or sleeping too much?'),
(4, 'Feeling tired or having little energy?'),
(5, 'Poor appetite or overeating?'),
(6, 'Feeling bad about yourself or that you are a failure Or have let yourself or family down?'),
(7, 'Moving or speaking so slowly that other people have noticed or the opposite-being so fidgety or restless that you have been moving around a lot more than usual?'),
(8, 'Trouble concentrating on things such as school work?'),
(9, 'Thoughts that you are better off dead or of hurting yourself in someway?');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE IF NOT EXISTS `replies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `reply_value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `name`, `reply_value`) VALUES
(1, 'Not at all', 0),
(2, 'Several days', 1),
(3, 'More than half the days', 2),
(4, 'Nearly everyday', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `date_created`) VALUES
(1, 'Azeezat Fatai', '2021-04-20 11:03:43'),
(2, 'samo', '2021-04-20 11:19:47');

-- --------------------------------------------------------

--
-- Table structure for table `user_response`
--

CREATE TABLE IF NOT EXISTS `user_response` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `query_id` int(11) NOT NULL,
  `reply_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user_response`
--

