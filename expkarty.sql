-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas generowania: 05 Mar 2015, 18:04
-- Wersja serwera: 5.6.21
-- Wersja PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `expkarty`
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

CREATE TABLE IF NOT EXISTS `datadodaniaexp` (
`idDodania` bigint(20) unsigned NOT NULL,
  `kartyNumer` int(10) unsigned DEFAULT NULL,
  `liczbaExp` int(10) unsigned DEFAULT NULL,
  `timeStamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `datadodaniaexp`
--

INSERT INTO `datadodaniaexp` (`idDodania`, `kartyNumer`, `liczbaExp`, `timeStamp`) VALUES
(1, 50, 100, '2014-11-12 16:20:52'),
(2, 50, 100, '2015-03-03 16:14:17'),
(3, 50, 100, '2015-03-03 16:57:25'),
(4, 50, 100, '2015-03-03 16:57:43'),
(5, 50, 100, '2015-03-03 16:57:45'),
(6, 50, 100, '2015-03-03 16:57:46'),
(7, 50, 100, '2015-03-03 16:57:48'),
(8, 51, 124, '2015-03-03 17:03:03');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `elementyrachunku`
--

CREATE TABLE IF NOT EXISTS `elementyrachunku` (
`idKolejnegoElementu` int(11) NOT NULL,
  `elementyRachunkucol` varchar(45) DEFAULT NULL,
  `cenaElementu` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `linki`
--

CREATE TABLE IF NOT EXISTS `linki` (
`idlinki` int(11) NOT NULL,
  `sciezkaDoLokalizacji` varchar(500) NOT NULL,
  `kartaID` int(11) NOT NULL,
  `idRodzaju` int(11) NOT NULL,
  `rodzajeLinkow_idrodzajeLinkow` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `loginy`
--

CREATE TABLE IF NOT EXISTS `loginy` (
`idLoginy` int(11) NOT NULL,
  `login` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `lvlOfAcces` tinyint(3) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `loginy`
--

INSERT INTO `loginy` (`idLoginy`, `login`, `password`, `lvlOfAcces`) VALUES
(1, 'test', 'test', 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nazwystatusow`
--

CREATE TABLE IF NOT EXISTS `nazwystatusow` (
`idnazwyStatusow` int(11) NOT NULL,
  `nazwyStatusow` varchar(455) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nrkart`
--

CREATE TABLE IF NOT EXISTS `nrkart` (
  `idnrKart` int(10) unsigned NOT NULL,
  `nick` varchar(45) NOT NULL,
  `linki_idlinki` int(11) DEFAULT NULL,
  `dataDodatania` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `poziomy_idKlienta` int(11) DEFAULT NULL,
  `kluczIdExpa` bigint(20) unsigned DEFAULT NULL,
  `rachunki_idrachunki` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `nrkart`
--

INSERT INTO `nrkart` (`idnrKart`, `nick`, `linki_idlinki`, `dataDodatania`, `poziomy_idKlienta`, `kluczIdExpa`, `rachunki_idrachunki`) VALUES
(20, 'marian', NULL, '2015-03-03 16:26:43', 20, NULL, NULL),
(34, 'marian', NULL, '2015-03-03 16:26:33', 34, NULL, NULL),
(50, 'marianer', NULL, '2015-03-03 16:57:37', 50, NULL, NULL),
(51, 'marian2', NULL, '2015-03-03 17:03:20', 51, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `poziomy`
--

CREATE TABLE IF NOT EXISTS `poziomy` (
  `idKlienta` int(11) NOT NULL,
  `poziom` int(11) NOT NULL DEFAULT '1',
  `mnoznik` float NOT NULL DEFAULT '1',
  `exp` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `poziomy`
--

INSERT INTO `poziomy` (`idKlienta`, `poziom`, `mnoznik`, `exp`) VALUES
(20, 5, 1, 2666),
(34, 6, 1, 8686),
(50, 4, 1, 1166),
(51, 9, 1, 100123);

--
-- Wyzwalacze `poziomy`
--
DELIMITER //
CREATE TRIGGER `ai_updejtPoziomow` AFTER INSERT ON `poziomy`
 FOR EACH ROW CALL updejtPoziomu()
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `updejtPoziomu` AFTER UPDATE ON `poziomy`
 FOR EACH ROW CALL updejtPoziomu()
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rachunki`
--

CREATE TABLE IF NOT EXISTS `rachunki` (
`idrachunki` int(10) unsigned NOT NULL,
  `statusRachunku` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rachunki_has_elementyrachunku`
--

CREATE TABLE IF NOT EXISTS `rachunki_has_elementyrachunku` (
`idKolejnejKombinacji` int(10) unsigned NOT NULL,
  `rachunki_idrachunki` int(10) unsigned NOT NULL,
  `elementyRachunku_idKolejnegoElementu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rodzajelinkow`
--

CREATE TABLE IF NOT EXISTS `rodzajelinkow` (
  `idrodzajeLinkow` int(11) NOT NULL,
  `opisCHAR` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `datadodaniaexp`
--
ALTER TABLE `datadodaniaexp`
 ADD UNIQUE KEY `iddodania` (`idDodania`), ADD KEY `kartynumer` (`kartyNumer`);

--
-- Indexes for table `elementyrachunku`
--
ALTER TABLE `elementyrachunku`
 ADD PRIMARY KEY (`idKolejnegoElementu`), ADD UNIQUE KEY `idKolejnegoElementu_UNIQUE` (`idKolejnegoElementu`);

--
-- Indexes for table `linki`
--
ALTER TABLE `linki`
 ADD PRIMARY KEY (`idlinki`,`rodzajeLinkow_idrodzajeLinkow`), ADD KEY `poIdKarty` (`kartaID`), ADD KEY `idRodzaju` (`idRodzaju`), ADD KEY `fk_linki_rodzajeLinkow1_idx` (`rodzajeLinkow_idrodzajeLinkow`);

--
-- Indexes for table `loginy`
--
ALTER TABLE `loginy`
 ADD PRIMARY KEY (`idLoginy`), ADD UNIQUE KEY `name_UNIQUE` (`login`);

--
-- Indexes for table `nazwystatusow`
--
ALTER TABLE `nazwystatusow`
 ADD PRIMARY KEY (`idnazwyStatusow`), ADD UNIQUE KEY `idnazwyStatusow_UNIQUE` (`idnazwyStatusow`);

--
-- Indexes for table `nrkart`
--
ALTER TABLE `nrkart`
 ADD PRIMARY KEY (`idnrKart`), ADD UNIQUE KEY `idnrKart_UNIQUE` (`idnrKart`), ADD KEY `nickIndex` (`nick`), ADD KEY `fk_nrKart_linki_idx` (`linki_idlinki`), ADD KEY `fk_nrKart_poziomy1_idx` (`poziomy_idKlienta`), ADD KEY `fk_nrKart_rachunki1_idx` (`rachunki_idrachunki`), ADD KEY `idDodaniaEXPA` (`kluczIdExpa`);

--
-- Indexes for table `poziomy`
--
ALTER TABLE `poziomy`
 ADD PRIMARY KEY (`idKlienta`), ADD KEY `poPoziomach` (`poziom`);

--
-- Indexes for table `rachunki`
--
ALTER TABLE `rachunki`
 ADD PRIMARY KEY (`idrachunki`), ADD UNIQUE KEY `idrachunki_UNIQUE` (`idrachunki`);

--
-- Indexes for table `rachunki_has_elementyrachunku`
--
ALTER TABLE `rachunki_has_elementyrachunku`
 ADD PRIMARY KEY (`idKolejnejKombinacji`), ADD UNIQUE KEY `idKolejnejKombinacji_UNIQUE` (`idKolejnejKombinacji`), ADD KEY `fk_rachunki_has_elementyRachunku_elementyRachunku1_idx` (`elementyRachunku_idKolejnegoElementu`), ADD KEY `fk_rachunki_has_elementyRachunku_rachunki1_idx` (`rachunki_idrachunki`);

--
-- Indexes for table `rodzajelinkow`
--
ALTER TABLE `rodzajelinkow`
 ADD PRIMARY KEY (`idrodzajeLinkow`), ADD UNIQUE KEY `opisCHAR_UNIQUE` (`opisCHAR`), ADD UNIQUE KEY `idrodzajeLinkow_UNIQUE` (`idrodzajeLinkow`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `datadodaniaexp`
--
ALTER TABLE `datadodaniaexp`
MODIFY `idDodania` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT dla tabeli `elementyrachunku`
--
ALTER TABLE `elementyrachunku`
MODIFY `idKolejnegoElementu` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `linki`
--
ALTER TABLE `linki`
MODIFY `idlinki` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `loginy`
--
ALTER TABLE `loginy`
MODIFY `idLoginy` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `nazwystatusow`
--
ALTER TABLE `nazwystatusow`
MODIFY `idnazwyStatusow` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `rachunki`
--
ALTER TABLE `rachunki`
MODIFY `idrachunki` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `rachunki_has_elementyrachunku`
--
ALTER TABLE `rachunki_has_elementyrachunku`
MODIFY `idKolejnejKombinacji` int(10) unsigned NOT NULL AUTO_INCREMENT;
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
-- Ograniczenia dla tabeli `rachunki_has_elementyrachunku`
--
ALTER TABLE `rachunki_has_elementyrachunku`
ADD CONSTRAINT `fk_rachunki_has_elementyRachunku_elementyRachunku1` FOREIGN KEY (`elementyRachunku_idKolejnegoElementu`) REFERENCES `elementyrachunku` (`idKolejnegoElementu`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_rachunki_has_elementyRachunku_rachunki1` FOREIGN KEY (`rachunki_idrachunki`) REFERENCES `rachunki` (`idrachunki`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
