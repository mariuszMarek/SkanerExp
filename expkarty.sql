-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 26 Paź 2014, 19:23
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `expkarty`
--

DELIMITER $$
--
-- Procedury
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `updejtPoziomu`()
    MODIFIES SQL DATA
UPDATE `poziomy`
SET `poziom` = CASE
	WHEN `exp` <= '200' THEN 1
	WHEN `exp` <= '500' THEN 2
	WHEN `exp` <= '1000' THEN 3
	WHEN `exp` <= '2000' THEN 4
	WHEN `exp` <= '5000' THEN 5
	WHEN `exp` <= '10000' THEN 6
	WHEN `exp` <= '20000' THEN 7
	WHEN `exp` <= '30000' THEN 8
	else  9
	END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `datadodaniaexp`
--

CREATE TABLE `datadodaniaexp` (
  `idDodania` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kartyNumer` int(10) unsigned DEFAULT NULL,
  `liczbaExp` int(10) unsigned DEFAULT NULL,
  `timeStamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `iddodania` (`idDodania`),
  KEY `kartynumer` (`kartyNumer`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `elementyrachunku`
--

CREATE TABLE `elementyrachunku` (
  `idKolejnegoElementu` int(11) NOT NULL AUTO_INCREMENT,
  `elementyRachunkucol` varchar(45) DEFAULT NULL,
  `cenaElementu` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idKolejnegoElementu`),
  UNIQUE KEY `idKolejnegoElementu_UNIQUE` (`idKolejnegoElementu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `linki`
--

CREATE TABLE `linki` (
  `idlinki` int(11) NOT NULL AUTO_INCREMENT,
  `sciezkaDoLokalizacji` varchar(500) NOT NULL,
  `kartaID` int(11) NOT NULL,
  `idRodzaju` int(11) NOT NULL,
  `rodzajeLinkow_idrodzajeLinkow` int(11) NOT NULL,
  PRIMARY KEY (`idlinki`,`rodzajeLinkow_idrodzajeLinkow`),
  KEY `poIdKarty` (`kartaID`),
  KEY `idRodzaju` (`idRodzaju`),
  KEY `fk_linki_rodzajeLinkow1_idx` (`rodzajeLinkow_idrodzajeLinkow`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `loginy`
--

CREATE TABLE `loginy` (
  `idLoginy` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `lvlOfAcces` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`idLoginy`),
  UNIQUE KEY `name_UNIQUE` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nazwystatusow`
--

CREATE TABLE `nazwystatusow` (
  `idnazwyStatusow` int(11) NOT NULL AUTO_INCREMENT,
  `nazwyStatusow` varchar(455) DEFAULT NULL,
  PRIMARY KEY (`idnazwyStatusow`),
  UNIQUE KEY `idnazwyStatusow_UNIQUE` (`idnazwyStatusow`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nrkart`
--

CREATE TABLE `nrkart` (
  `idnrKart` int(10) unsigned NOT NULL,
  `nick` varchar(45) NOT NULL,
  `linki_idlinki` int(11) DEFAULT NULL,
  `dataDodatania` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `poziomy_idKlienta` int(11) DEFAULT NULL,
  `kluczIdExpa` bigint(20) unsigned DEFAULT NULL,
  `rachunki_idrachunki` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idnrKart`),
  UNIQUE KEY `idnrKart_UNIQUE` (`idnrKart`),
  KEY `nickIndex` (`nick`),
  KEY `fk_nrKart_linki_idx` (`linki_idlinki`),
  KEY `fk_nrKart_poziomy1_idx` (`poziomy_idKlienta`),
  KEY `fk_nrKart_rachunki1_idx` (`rachunki_idrachunki`),
  KEY `idDodaniaEXPA` (`kluczIdExpa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nrkart_has_rodzajestatosow`
--

CREATE TABLE `nrkart_has_rodzajestatosow` (
  `nrKart_idnrKart` int(10) unsigned NOT NULL,
  `RodzajeStatosow_idRodzajeStatosow` int(11) NOT NULL,
  PRIMARY KEY (`nrKart_idnrKart`,`RodzajeStatosow_idRodzajeStatosow`),
  KEY `fk_nrKart_has_RodzajeStatosow_RodzajeStatosow1_idx` (`RodzajeStatosow_idRodzajeStatosow`),
  KEY `fk_nrKart_has_RodzajeStatosow_nrKart1_idx` (`nrKart_idnrKart`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `poziomy`
--

CREATE TABLE `poziomy` (
  `idKlienta` int(11) NOT NULL,
  `poziom` int(11) NOT NULL DEFAULT '1',
  `mnoznik` float NOT NULL DEFAULT '1',
  `exp` float NOT NULL,
  PRIMARY KEY (`idKlienta`),
  KEY `poPoziomach` (`poziom`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rachunki`
--

CREATE TABLE `rachunki` (
  `idrachunki` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `statusRachunku` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idrachunki`),
  UNIQUE KEY `idrachunki_UNIQUE` (`idrachunki`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rachunki_has_elementyrachunku`
--

CREATE TABLE `rachunki_has_elementyrachunku` (
  `idKolejnejKombinacji` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rachunki_idrachunki` int(10) unsigned NOT NULL,
  `elementyRachunku_idKolejnegoElementu` int(11) NOT NULL,
  PRIMARY KEY (`idKolejnejKombinacji`),
  UNIQUE KEY `idKolejnejKombinacji_UNIQUE` (`idKolejnejKombinacji`),
  KEY `fk_rachunki_has_elementyRachunku_elementyRachunku1_idx` (`elementyRachunku_idKolejnegoElementu`),
  KEY `fk_rachunki_has_elementyRachunku_rachunki1_idx` (`rachunki_idrachunki`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rodzajelinkow`
--

CREATE TABLE `rodzajelinkow` (
  `idrodzajeLinkow` int(11) NOT NULL,
  `opisCHAR` varchar(45) NOT NULL,
  PRIMARY KEY (`idrodzajeLinkow`),
  UNIQUE KEY `opisCHAR_UNIQUE` (`opisCHAR`),
  UNIQUE KEY `idrodzajeLinkow_UNIQUE` (`idrodzajeLinkow`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rodzajestatosow`
--

CREATE TABLE `rodzajestatosow` (
  `idRodzajeStatosow` int(11) NOT NULL AUTO_INCREMENT,
  `typy` varchar(255) DEFAULT NULL,
  `nazwyStatusow_idnazwyStatusow` int(11) NOT NULL,
  PRIMARY KEY (`idRodzajeStatosow`,`nazwyStatusow_idnazwyStatusow`),
  KEY `fk_RodzajeStatosow_nazwyStatusow1_idx` (`nazwyStatusow_idnazwyStatusow`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `linki`
--
ALTER TABLE `linki`
  ADD CONSTRAINT `fk_linki_rodzajeLinkow1` FOREIGN KEY (`rodzajeLinkow_idrodzajeLinkow`) REFERENCES `rodzajelinkow` (`idrodzajeLinkow`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `nrkart`
--
ALTER TABLE `nrkart`
  ADD CONSTRAINT `fk_nrKart_linki` FOREIGN KEY (`linki_idlinki`) REFERENCES `linki` (`idlinki`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nrKart_rachunki1` FOREIGN KEY (`rachunki_idrachunki`) REFERENCES `rachunki` (`idrachunki`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nrkart_ibfk_1` FOREIGN KEY (`poziomy_idKlienta`) REFERENCES `poziomy` (`idKlienta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `nrkart_has_rodzajestatosow`
--
ALTER TABLE `nrkart_has_rodzajestatosow`
  ADD CONSTRAINT `fk_nrKart_has_RodzajeStatosow_nrKart1` FOREIGN KEY (`nrKart_idnrKart`) REFERENCES `nrkart` (`idnrKart`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nrKart_has_RodzajeStatosow_RodzajeStatosow1` FOREIGN KEY (`RodzajeStatosow_idRodzajeStatosow`) REFERENCES `rodzajestatosow` (`idRodzajeStatosow`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `rachunki_has_elementyrachunku`
--
ALTER TABLE `rachunki_has_elementyrachunku`
  ADD CONSTRAINT `fk_rachunki_has_elementyRachunku_elementyRachunku1` FOREIGN KEY (`elementyRachunku_idKolejnegoElementu`) REFERENCES `elementyrachunku` (`idKolejnegoElementu`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rachunki_has_elementyRachunku_rachunki1` FOREIGN KEY (`rachunki_idrachunki`) REFERENCES `rachunki` (`idrachunki`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `rodzajestatosow`
--
ALTER TABLE `rodzajestatosow`
  ADD CONSTRAINT `fk_RodzajeStatosow_nazwyStatusow1` FOREIGN KEY (`nazwyStatusow_idnazwyStatusow`) REFERENCES `nazwystatusow` (`idnazwyStatusow`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
