-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2019 at 09:26 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inspekcija`
--

-- --------------------------------------------------------

--
-- Table structure for table `inspekcijska_kontrola`
--

CREATE TABLE `inspekcijska_kontrola` (
  `id` int(11) NOT NULL,
  `datum` date NOT NULL,
  `nadlezno_inspekcijsko_tijelo` int(11) NOT NULL,
  `kontrolisani_proizvod` int(11) NOT NULL,
  `rezultati_kontrole` text COLLATE utf8_slovenian_ci NOT NULL,
  `proizvod_siguran` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `inspekcijska_kontrola`
--

INSERT INTO `inspekcijska_kontrola` (`id`, `datum`, `nadlezno_inspekcijsko_tijelo`, `kontrolisani_proizvod`, `rezultati_kontrole`, `proizvod_siguran`) VALUES
(1, '2015-01-01', 1, 1, '', 0),
(2, '2015-10-01', 1, 1, '1', 1),
(4, '2016-02-01', 1, 3, 'lsk', 0),
(5, '2014-12-12', 1, 3, '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inspekcijsko_tijelo`
--

CREATE TABLE `inspekcijsko_tijelo` (
  `id` int(11) NOT NULL,
  `naziv` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `inspektorat` enum('FBIH','RS','Distrikt Brcko') COLLATE utf8_slovenian_ci NOT NULL,
  `nadleznost` enum('Trzisna inspekcija','Zdravstveno sanitarna inspekcija') COLLATE utf8_slovenian_ci NOT NULL,
  `kontakt_osoba` varchar(100) COLLATE utf8_slovenian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `inspekcijsko_tijelo`
--

INSERT INTO `inspekcijsko_tijelo` (`id`, `naziv`, `inspektorat`, `nadleznost`, `kontakt_osoba`) VALUES
(1, 'kjsdf', 'FBIH', 'Trzisna inspekcija', 'kjsdkfj');

-- --------------------------------------------------------

--
-- Table structure for table `proizvod`
--

CREATE TABLE `proizvod` (
  `id` int(11) NOT NULL,
  `naziv` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `proizvodac` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `serijski_broj` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `zemlja_porijekla` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `opis` text COLLATE utf8_slovenian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `proizvod`
--

INSERT INTO `proizvod` (`id`, `naziv`, `proizvodac`, `serijski_broj`, `zemlja_porijekla`, `opis`) VALUES
(1, 'Sjekira', 'Zeljezara', '12345679', 'Bosna i Hercegovina', ''),
(3, 'Knjige', 'Svjetlost', '09405', 'BiH', 'Puno knjiga'),
(4, '', '', '', '', ''),
(5, '', '', '', '', ''),
(6, '', '', '', '', ''),
(7, '', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inspekcijska_kontrola`
--
ALTER TABLE `inspekcijska_kontrola`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kontrolisani_proizvod` (`kontrolisani_proizvod`),
  ADD KEY `nadlezno_inspekcijsko_tijelo` (`nadlezno_inspekcijsko_tijelo`);

--
-- Indexes for table `inspekcijsko_tijelo`
--
ALTER TABLE `inspekcijsko_tijelo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proizvod`
--
ALTER TABLE `proizvod`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inspekcijska_kontrola`
--
ALTER TABLE `inspekcijska_kontrola`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inspekcijsko_tijelo`
--
ALTER TABLE `inspekcijsko_tijelo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `proizvod`
--
ALTER TABLE `proizvod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inspekcijska_kontrola`
--
ALTER TABLE `inspekcijska_kontrola`
  ADD CONSTRAINT `inspekcijska_kontrola_ibfk_1` FOREIGN KEY (`kontrolisani_proizvod`) REFERENCES `proizvod` (`id`),
  ADD CONSTRAINT `inspekcijska_kontrola_ibfk_2` FOREIGN KEY (`nadlezno_inspekcijsko_tijelo`) REFERENCES `inspekcijsko_tijelo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
