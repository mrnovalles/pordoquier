-- phpMyAdmin SQL Dump
-- version 3.1.2deb1ubuntu0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 31, 2009 at 09:50 AM
-- Server version: 5.0.75
-- PHP Version: 5.2.6-3ubuntu4.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pfinal`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(60) NOT NULL,
  `description` varchar(60) NOT NULL,
  `parent` int(10) NOT NULL,
  `photo` varchar(60) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `parent`, `photo`) VALUES
(1, 'Food & Drinks', '', 1, ''),
(2, 'Transport', '', 2, ''),
(3, 'Entertainment', '', 3, ''),
(4, 'Conectivity', '', 4, ''),
(5, 'Restaurant', '', 1, ''),
(6, 'Delivery', '', 1, ''),
(7, 'Bus', '', 2, ''),
(8, 'Taxi', '', 2, ''),
(9, 'Wifi', '', 4, ''),
(10, 'Bluetooth', '', 4, ''),
(11, 'Movies', '', 3, ''),
(12, 'Theater', '', 3, ''),
(13, 'Music', '', 3, '');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) NOT NULL auto_increment,
  `comment` varchar(255) NOT NULL,
  `user_id` int(10) NOT NULL,
  `id_2user` int(10) NOT NULL,
  `created` datetime NOT NULL,
  `read` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `user_id`, `id_2user`, `created`, `read`) VALUES
(1, 'How are you doing? Im having a blast at this site. See ya round.', 36, 38, '2009-03-24 18:05:50', 0),
(2, 'You should check Il Panino out.<a href="/pordoquier/places/view/3">Click here</a>', 36, 38, '2009-03-24 18:08:50', 0),
(3, 'Hello neo, My name is Mr. Anderson. Some people call me neo. See ya in the matrix.', 36, 36, '2009-03-25 09:44:40', 1),
(4, 'You should check Cinemark Mendoza out.<a href="/pordoquier/places/view/13">Click here</a>', 36, 38, '2009-03-25 09:58:07', 0),
(5, 'Como estas? Yo todo bien', 36, 36, '2009-05-04 22:44:29', 1),
(6, 'Estoy viendo una peli.', 36, 36, '2009-05-04 22:45:19', 1),
(7, 'You should check Village Cines out.<a href="/pordoquier/places/view/11">Click here</a>', 36, 36, '2009-05-04 22:46:56', 1),
(8, 'Hey me encanto tu lugar.', 36, 36, '2009-07-21 23:21:52', 1),
(9, 'Como estas? Esta todo bien.', 36, 38, '2009-07-22 11:02:23', 0);

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL,
  `friend_id` int(10) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `user_id`, `friend_id`, `status`) VALUES
(1, 37, 36, 0),
(2, 38, 37, 0),
(3, 38, 36, 1),
(4, 36, 38, 1),
(5, 36, 36, 1),
(6, 36, 36, 1),
(7, 36, 37, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pcomments`
--

CREATE TABLE IF NOT EXISTS `pcomments` (
  `id` int(10) NOT NULL auto_increment,
  `comment` tinytext NOT NULL,
  `place_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `pcomments`
--

INSERT INTO `pcomments` (`id`, `comment`, `place_id`, `user_id`, `created`) VALUES
(1, 'Excelent cinema option. 10 rooms, all the premiers. Great cinema.', 13, 0, '2009-03-24 17:30:52'),
(2, 'Great sandwiches and drinks. Tip the waiter good for some extra peanuts!', 4, 0, '2009-03-24 17:32:27'),
(3, 'I didn''t like this place at all.It''s dirty and ugly. I''d rather stay home than spend money on something not worth it.', 4, 0, '2009-03-24 17:33:43'),
(4, 'I liked the Movie called. "The Matrix"', 13, 0, '2009-03-25 09:57:37'),
(5, 'Esta bueno pero esta mejor cinemark', 11, 0, '2009-05-04 22:46:25'),
(6, 'Me encanto ese lugar. Se come excelente', 3, 0, '2009-06-26 01:56:18');

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE IF NOT EXISTS `places` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(60) NOT NULL,
  `address` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `zoom` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `rating` float NOT NULL,
  `user_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `name`, `address`, `description`, `latitude`, `longitude`, `zoom`, `tags`, `rating`, `user_id`, `category_id`, `created`) VALUES
(1, 'La Massa Delivery', 'Av. Mariano Moreno Ciudad Mendoza', '', -32.9022, -68.8567, 0, 'Food, Delivery, Pizza', 0, 36, 6, '0000-00-00 00:00:00'),
(2, 'Mi Tierra', 'Av. Mitre 794 Ciudad Mendoza Argentina', '', -32.8905, -68.8163, 0, 'Food, Restaurant, Mendoza', 0, 36, 5, '0000-00-00 00:00:00'),
(3, 'Il Panino', 'Paso de Los Andes 153 Ciudad Mendoza', '', -32.8987, -68.8595, 0, 'Food, Restaurant, Sandwich', 0, 36, 5, '0000-00-00 00:00:00'),
(4, 'La India', 'San Martin Sur 566 Godoy Cruz Mendoza', '', -32.9304, -68.8497, 0, 'Food, Delivery, Sandwich', 1, 36, 6, '0000-00-00 00:00:00'),
(5, 'La Marchigiana', 'Patricias Mendocinas 1550 Ciudad Mendoza', '', -32.891, -68.8132, 0, 'Restaurant, Food, Mendoza', 0, 36, 5, '0000-00-00 00:00:00'),
(6, 'De la Ostia', 'Aristides Villanueva y Granaderos Mendoza Argentina', '', -32.8907, -68.8579, 0, 'Food, Delivery, Pizza, Sandwich', 0, 36, 6, '0000-00-00 00:00:00'),
(7, 'Taxis', 'San Martin y Catamarca Ciudad Mendoza', '', -32.8895, -68.8387, 0, 'Taxi, Mendoza', 0, 36, 8, '0000-00-00 00:00:00'),
(8, 'Taxi Stop', 'Av J. Vicente Zapata  y San Martin Mendoza ', '', -32.8949, -68.8402, 0, 'Taxi, Mendoza, Centro', 0, 36, 8, '0000-00-00 00:00:00'),
(9, 'Bus Stop Line 30 & 70', 'Paso de los andes 170 Ciudad Mendoza', '', -32.9121, -68.86, 0, 'Bus, Mendoza, Centro', 0, 36, 7, '0000-00-00 00:00:00'),
(10, 'Line 50 & 70', 'Sobremonte 550', '', -32.8957, -68.8588, 0, 'Mendoza, Bus, Downtown', 0, 36, 7, '0000-00-00 00:00:00'),
(11, 'Village Cines', 'Av. Acceso Este Guaymallen Mendoza', '', -32.9021, -68.7975, 0, 'Cinema, Shopping', 4, 36, 11, '0000-00-00 00:00:00'),
(12, 'Cine Universidad', 'Av. Lavalle Mendoza', '', -32.8889, -68.8377, 0, 'Cinema, Downtown', 0, 36, 11, '0000-00-00 00:00:00'),
(13, 'Cinemark Mendoza', 'Palmares Mall Av. San MartÃ­n Sur Mendoza Argentina', '', -32.9604, -68.8675, 0, 'Cinema, Palmares, Shopping', 5, 36, 11, '0000-00-00 00:00:00'),
(14, 'Teatro Independencia', 'Chile y Espejo Mendoza Argentina', '', -32.8887, -68.8458, 0, 'Theater, Downtown', 0, 36, 12, '0000-00-00 00:00:00'),
(15, 'Teatro Selectro', 'Av. 9 de Julio Mendoza', '', -32.9011, -68.8437, 0, 'Theater', 0, 36, 12, '0000-00-00 00:00:00'),
(16, 'BananaRana Rock', 'San Martin Godoy Cruz Mendoza', '', -32.8992, -68.8405, 0, 'Music, Rock, Bar', 0, 37, 13, '0000-00-00 00:00:00'),
(17, 'Tajamar', 'San MartÃ­n 1921 - Mendoza Capital ', '', -32.8809, -68.8368, 0, 'Music, Theater, Food', 0, 37, 12, '0000-00-00 00:00:00'),
(18, 'Alameda Resto Bar', 'San MartÃ­n 1921 - Mendoza Capital ', '', -32.8748, -68.8351, 0, 'Alameda, Restaurant, Food', 0, 37, 5, '0000-00-00 00:00:00'),
(19, 'Hotel Argentino', 'Espejo 455 Mendoza Argentina', '', -32.8883, -68.8448, 0, 'Wifi, Hotel', 0, 37, 9, '0000-00-00 00:00:00'),
(20, 'Bonafide Wifi', 'Peatonal Sarmiento Mendoza Argentina', '', -32.8903, -68.8411, 0, 'Cafe, Wifi', 0, 37, 9, '0000-00-00 00:00:00'),
(21, 'Bremen Pils Wifi', 'Paseo Sarmiento 65 mendoza', '', -32.8905, -68.84, 0, 'Bar, Cafe, Wifi', 0, 37, 9, '0000-00-00 00:00:00'),
(22, 'Francesco Restaurant', 'Chile 1268 Mendoza Capital - Mendoza', '', -32.8876, -68.8453, 0, 'Wifi, Restaurant', 4, 37, 5, '0000-00-00 00:00:00'),
(23, 'Alamo Hostel Wifi', 'Necochea 740 Mendoza Capital - Mendoza', '', -32.8857, -68.848, 0, 'Wifi, Hostel', 0, 37, 9, '0000-00-00 00:00:00'),
(24, 'Cine Optico', 'Cnel. Rodriguez 300 Ciudad Mendoza Argentina', '', -32.8974, -68.8538, 0, 'Cine, Pelis, Arte', 0, 36, 11, '0000-00-00 00:00:00'),
(25, 'Casa Parma', 'Av. Beltran 1616 Mendoza Argentina', '', -32.879, -68.831, 0, 'Teatro, Parma, Mago, Charly', 0, 36, 12, '0000-00-00 00:00:00'),
(26, 'Casa Flor', 'Olascoaga 120 Ciudad MendozaArgentina', '', -32.8988, -68.8558, 0, 'Casa, Flor, Muchacha', 0, 36, 5, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `places_tags`
--

CREATE TABLE IF NOT EXISTS `places_tags` (
  `tag_id` int(10) NOT NULL,
  `place_id` int(10) NOT NULL,
  PRIMARY KEY  (`tag_id`,`place_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `places_tags`
--

INSERT INTO `places_tags` (`tag_id`, `place_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 17),
(1, 18),
(2, 1),
(2, 4),
(2, 6),
(3, 1),
(3, 6),
(4, 2),
(4, 3),
(4, 5),
(4, 18),
(4, 22),
(5, 2),
(5, 5),
(5, 7),
(5, 8),
(5, 9),
(5, 10),
(6, 3),
(6, 4),
(6, 6),
(7, 7),
(7, 8),
(8, 8),
(8, 9),
(9, 9),
(9, 10),
(10, 10),
(10, 12),
(10, 14),
(11, 11),
(11, 12),
(11, 13),
(12, 11),
(12, 13),
(13, 13),
(14, 14),
(14, 15),
(14, 17),
(15, 16),
(15, 17),
(16, 16),
(17, 16),
(17, 21),
(18, 18),
(19, 19),
(19, 20),
(19, 21),
(19, 22),
(19, 23),
(20, 19),
(21, 20),
(21, 21),
(22, 23),
(23, 24),
(24, 24),
(25, 24),
(26, 25),
(27, 25),
(28, 25),
(29, 25),
(30, 26),
(31, 26),
(32, 26);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int(10) NOT NULL auto_increment,
  `place_id` varchar(10) NOT NULL,
  `value` varchar(2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `place_id`, `value`) VALUES
(1, '13', '5'),
(2, '4', '1'),
(3, '11', '4'),
(4, '22', '4');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(4) NOT NULL auto_increment,
  `tag` varchar(60) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `tag`) VALUES
(1, 'Food'),
(2, 'Delivery'),
(3, 'Pizza'),
(4, 'Restaurant'),
(5, 'Mendoza'),
(6, 'Sandwich'),
(7, 'Taxi'),
(8, 'Centro'),
(9, 'Bus'),
(10, 'Downtown'),
(11, 'Cinema'),
(12, 'Shopping'),
(13, 'Palmares'),
(14, 'Theater'),
(15, 'Music'),
(16, 'Rock'),
(17, 'Bar'),
(18, 'Alameda'),
(19, 'Wifi'),
(20, 'Hotel'),
(21, 'Cafe'),
(22, 'Hostel'),
(23, 'Cine'),
(24, 'Pelis'),
(25, 'Arte'),
(26, 'Teatro'),
(27, 'Parma'),
(28, 'Mago'),
(29, 'Charly'),
(30, 'Casa'),
(31, 'Flor'),
(32, 'Muchacha');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(60) NOT NULL,
  `lastname` varchar(60) NOT NULL,
  `birthdate` date NOT NULL,
  `country` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(40) NOT NULL,
  `last_login` datetime NOT NULL,
  `group_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `birthdate`, `country`, `email`, `username`, `password`, `last_login`, `group_id`) VALUES
(36, 'neo', 'neo', '2009-03-24', 'United States', 'neo@neo.com', 'neo', '2a16e4f5efee258d283791b7dca94ccfec592b87', '0000-00-00 00:00:00', 2),
(37, 'trin', 'trin', '2009-03-24', 'Algeria', 'trin@thematrix.org', 'trinity', '2cb5e19c349975d434a019b704c2fe4b826dd8fa', '0000-00-00 00:00:00', 1),
(38, 'Mariano', 'Valles', '2009-02-06', 'Argentina', 'zucaritas@pordoquier.com.ar', 'zucaritas', 'ba9439c60868ee5dfcb2260b153c775f1750c8dd', '0000-00-00 00:00:00', 2);
