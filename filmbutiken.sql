-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 20 maj 2017 kl 02:38
-- Serverversion: 10.1.16-MariaDB
-- PHP-version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `filmbutiken`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `accounts`
--

CREATE TABLE `accounts` (
  `Username` varchar(30) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `Adress` varchar(256) NOT NULL,
  `Admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `accounts`
--

INSERT INTO `accounts` (`Username`, `Password`, `Adress`, `Admin`) VALUES
('Admin', '1234', '', 1),
('Christopher', '1234', 'gatan 1', 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `carts`
--

CREATE TABLE `carts` (
  `Username` varchar(30) NOT NULL,
  `MovieID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `movies`
--

CREATE TABLE `movies` (
  `MovieID` int(10) NOT NULL,
  `Title` varchar(256) NOT NULL,
  `Releaseyear` int(4) NOT NULL,
  `Description` text NOT NULL,
  `Price` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `movies`
--

INSERT INTO `movies` (`MovieID`, `Title`, `Releaseyear`, `Description`, `Price`) VALUES
(1, 'Guardians of the Galaxy', 2014, 'A group of intergalactic criminals are forced to work together to stop a fanatical warrior from taking control of the universe.', 499),
(2, 'Avatar', 2009, 'A paraplegic marine dispatched to the moon Pandora on a unique mission becomes torn between following his orders and protecting the world he feels is his home.', 299),
(3, 'The Shawshank Redemption', 1994, 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.', 169),
(4, 'Pulp Fiction', 1994, 'The lives of two mob hit men, a boxer, a gangster''s wife, and a pair of diner bandits intertwine in four tales of violence and redemption.', 169),
(5, 'La La Land', 2016, 'A jazz pianist falls for an aspiring actress in Los Angeles.', 299),
(6, 'Star Wars: The Force Awakens', 2015, 'Three decades after the defeat of the Galactic Empire, a new threat arises. The First Order attempts to rule the galaxy and only a ragtag group of heroes can stop them, along with the help of the Resistance.', 169),
(7, 'Inception', 2010, 'A thief, who steals corporate secrets through use of dream-sharing technology, is given the inverse task of planting an idea into the mind of a CEO.', 199),
(9, 'Pineapple Express', 2008, 'A process server and his marijuana dealer wind up on the run from hitmen and a corrupt police officer after he witnesses his dealer''s boss murder a competitor while trying to serve papers on him.', 99),
(10, 'As Good as it Gets', 1997, 'A single mother/waitress, a misanthropic author, and a gay artist form an unlikely friendship after the artist is assaulted in a robbery.', 199),
(13, 'Zootopia', 2016, 'In a city of anthropomorphic animals, a rookie bunny cop and a cynical con artist fox must work together to uncover a conspiracy.', 189),
(14, 'The Impossible', 2012, 'The story of a tourist family in Thailand caught in the destruction and chaotic aftermath of the 2004 Indian Ocean tsunami.', 199),
(15, 'Kingsman: The Golden Circle', 2017, 'When their headquarters are destroyed and the world is held hostage, the Kingsman''s journey leads them to the discovery of an allied spy organization in the US. These two elite secret organizations must band together to defeat a common enemy.', 299),
(16, 'The Sword in the Stone', 1963, 'A poor boy named Arthur learns the power of love, kindness, knowledge and bravery with the help of a wizard called Merlin in the path to become one of the most beloved kings in England history.', 69),
(18, 'Die Another Day', 2002, 'James Bond is sent to investigate the connection between a North Korean terrorist and a diamond mogul who is funding the development of an international space weapon.', 199);

-- --------------------------------------------------------

--
-- Tabellstruktur `ordercontents`
--

CREATE TABLE `ordercontents` (
  `OrderID` int(11) NOT NULL,
  `MovieID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `ordercontents`
--

INSERT INTO `ordercontents` (`OrderID`, `MovieID`) VALUES
(2, 3),
(2, 4),
(3, 3),
(3, 4),
(5, 1),
(5, 2),
(8, 1),
(8, 5),
(8, 16),
(9, 10),
(10, 15),
(11, 13),
(11, 14);

-- --------------------------------------------------------

--
-- Tabellstruktur `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(10) NOT NULL,
  `Status` varchar(30) NOT NULL,
  `Username` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `orders`
--

INSERT INTO `orders` (`OrderID`, `Status`, `Username`) VALUES
(9, 'Order mottagen', 'Christopher'),
(10, 'Order mottagen', 'Christopher'),
(11, 'Order mottagen', 'Christopher');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`Username`);

--
-- Index för tabell `carts`
--
ALTER TABLE `carts`
  ADD KEY `Username` (`Username`,`MovieID`);

--
-- Index för tabell `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`MovieID`);

--
-- Index för tabell `ordercontents`
--
ALTER TABLE `ordercontents`
  ADD KEY `OrderID` (`OrderID`,`MovieID`);

--
-- Index för tabell `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `Username` (`Username`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `movies`
--
ALTER TABLE `movies`
  MODIFY `MovieID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT för tabell `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
