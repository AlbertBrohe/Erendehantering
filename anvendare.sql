-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 26 maj 2024 kl 17:50
-- Serverversion: 10.4.32-MariaDB
-- PHP-version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `kundsupport`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `anvendare`
--

CREATE TABLE `anvendare` (
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nivo` int(255) NOT NULL,
  `id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `anvendare`
--

INSERT INTO `anvendare` (`name`, `password`, `email`, `nivo`, `id`) VALUES
('Admin', '12345', 'admin@gmail.com', 10, 1),
('albert', '12345', 'Albert@brohede.se', 0, 2),
('max', '12345', 'Max@max.se', 0, 3),
('axel', '12345', 'axel@AXEL.se', 0, 4),
('klas', '12345', 'klas@klas.se', 0, 5),
('jhsadkjsdahjkdashjdsakdh', '12345', 'hej@hej.se', 0, 6),
('hej', '12345', 'abbe.gamer@brohede.se', 0, 7),
('gabbe', '12345', 'gabbe@gmail.com', 0, 8);

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `anvendare`
--
ALTER TABLE `anvendare`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `anvendare`
--
ALTER TABLE `anvendare`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
