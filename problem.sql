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
-- Tabellstruktur `problem`
--

CREATE TABLE `problem` (
  `id` int(255) NOT NULL,
  `Prioritet` int(255) NOT NULL,
  `Emne` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Ansvarig` varchar(255) NOT NULL,
  `Inskickat` datetime(6) NOT NULL,
  `beskrivning` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `problem`
--

INSERT INTO `problem` (`id`, `Prioritet`, `Emne`, `Status`, `Ansvarig`, `Inskickat`, `beskrivning`) VALUES
(46, 5, 'sdfsdf', 'Stängd', 'Albert@brohede.se', '2024-05-26 17:19:18.000000', 'dsfdsfsdfs'),
(47, 5, 'aaaaaaaaaaaaaaaaaaaa', 'Stängd', 'admin@gmail.com', '2024-05-26 17:25:47.000000', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'),
(48, 3, 'bbbbbbbbbbbbbbbbbbbb', 'Öppen', 'Albert@brohede.se', '2024-05-26 17:26:12.000000', 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb'),
(49, 5, 'cccccccccccccccccccc', 'Stängd', 'Albert@brohede.se', '2024-05-26 17:26:22.000000', 'ccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc'),
(50, 5, 'dddddddddddddddddddd', 'Stängd', 'Albert@brohede.se', '2024-05-26 17:26:34.000000', 'ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `problem`
--
ALTER TABLE `problem`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `problem`
--
ALTER TABLE `problem`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
