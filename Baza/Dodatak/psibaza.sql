-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 15, 2019 at 11:59 AM
-- Server version: 8.0.13
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `psibaza`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

DROP TABLE IF EXISTS `administrator`;
CREATE TABLE IF NOT EXISTS `administrator` (
  `IdKorisnik` int(11) NOT NULL,
  PRIMARY KEY (`IdKorisnik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`IdKorisnik`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `drzava`
--

DROP TABLE IF EXISTS `drzava`;
CREATE TABLE IF NOT EXISTS `drzava` (
  `IdDrzava` int(11) NOT NULL,
  `Naziv` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`IdDrzava`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `drzava`
--

INSERT INTO `drzava` (`IdDrzava`, `Naziv`) VALUES
(1, 'Srbija');

-- --------------------------------------------------------

--
-- Table structure for table `grad`
--

DROP TABLE IF EXISTS `grad`;
CREATE TABLE IF NOT EXISTS `grad` (
  `IdDrzava` int(11) NOT NULL,
  `IdGrad` int(11) NOT NULL,
  `Naziv` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`IdGrad`),
  KEY `R_9` (`IdDrzava`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `grad`
--

INSERT INTO `grad` (`IdDrzava`, `IdGrad`, `Naziv`) VALUES
(1, 1, 'Beograd'),
(1, 2, 'Pančevo');

-- --------------------------------------------------------

--
-- Table structure for table `gurman`
--

DROP TABLE IF EXISTS `gurman`;
CREATE TABLE IF NOT EXISTS `gurman` (
  `IdKorisnik` int(11) NOT NULL,
  `Ime` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Prezime` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Pol` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IdSlika` int(11) NOT NULL,
  PRIMARY KEY (`IdKorisnik`),
  KEY `R_12` (`IdSlika`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `gurman`
--

INSERT INTO `gurman` (`IdKorisnik`, `Ime`, `Prezime`, `Pol`, `IdSlika`) VALUES
(2, 'Nenad', 'Babin', 'M', 1),
(4, 'Lazar', 'Lazić', 'M', 1),
(5, 'Dunja', 'Ćulafić', 'Z', 1),
(6, 'Nikola', 'Božović', 'M', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ima_sastojak`
--

DROP TABLE IF EXISTS `ima_sastojak`;
CREATE TABLE IF NOT EXISTS `ima_sastojak` (
  `IdJelo` int(11) NOT NULL,
  `IdSastojak` int(11) NOT NULL,
  PRIMARY KEY (`IdJelo`,`IdSastojak`),
  KEY `R_15` (`IdSastojak`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ima_sastojak`
--

INSERT INTO `ima_sastojak` (`IdJelo`, `IdSastojak`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `jelo`
--

DROP TABLE IF EXISTS `jelo`;
CREATE TABLE IF NOT EXISTS `jelo` (
  `Naziv` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Opis` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IdJelo` int(11) NOT NULL,
  `IdKorisnik` int(11) NOT NULL,
  `IdSlika` int(11) NOT NULL,
  `Pregledano` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`IdJelo`),
  KEY `R_5` (`IdKorisnik`),
  KEY `R_13` (`IdSlika`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jelo`
--

INSERT INTO `jelo` (`Naziv`, `Opis`, `IdJelo`, `IdKorisnik`, `IdSlika`, `Pregledano`) VALUES
('Calzone', 'Danas poznati italijanski specijalitet, ali malo ko zna da je nastao za vreme starog Rima. Prvi čovek koji ju je probao bio je, ni manje ni više, nego Gaj Julije Cezar.', 1, 3, 3, 'P');

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

DROP TABLE IF EXISTS `korisnik`;
CREATE TABLE IF NOT EXISTS `korisnik` (
  `IdKorisnik` int(11) NOT NULL,
  `KorisnickoIme` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Lozinka` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Email` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`IdKorisnik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`IdKorisnik`, `KorisnickoIme`, `Lozinka`, `Email`) VALUES
(1, 'admin', 'admin', NULL),
(2, 'nenad', 'nenad', NULL),
(3, 'madera', 'madera', NULL),
(4, 'lazar', 'lazar', NULL),
(5, 'dunja', 'dunja', NULL),
(6, 'nikola', 'nikola', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recenzija`
--

DROP TABLE IF EXISTS `recenzija`;
CREATE TABLE IF NOT EXISTS `recenzija` (
  `IdKorisnik` int(11) NOT NULL,
  `Ocena` int(11) DEFAULT NULL,
  `Komentar` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IdJelo` int(11) NOT NULL,
  `Pregledano` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`IdJelo`,`IdKorisnik`),
  KEY `R_7` (`IdKorisnik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `recenzija`
--

INSERT INTO `recenzija` (`IdKorisnik`, `Ocena`, `Komentar`, `IdJelo`, `Pregledano`) VALUES
(2, 5, 'Omiljeni ukus u omiljenom restoranu.', 1, 'P'),
(4, 4, 'Pesma za moja nepca. Definitivno najbolji kalcone u gradu, a i sire.', 1, 'P'),
(5, 5, 'Bila sam u Parizu, Londonu, Lisabonu, Kijevu, Moskvi, Pragu, Rimu, Kopenhagenu i Bukurestu, ali ovakav ukus jos nisam srela. ', 1, 'P'),
(6, 2, 'Meeeh. Jeo sam i boljih svari u ovom restoranu. 2/5', 1, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `restoran`
--

DROP TABLE IF EXISTS `restoran`;
CREATE TABLE IF NOT EXISTS `restoran` (
  `IdKorisnik` int(11) NOT NULL,
  `Telefon` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Naziv` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Adresa` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IdGrad` int(11) NOT NULL,
  `IdSlika` int(11) NOT NULL,
  `RadnoVreme` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Pregledano` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`IdKorisnik`),
  KEY `R_10` (`IdGrad`),
  KEY `R_11` (`IdSlika`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `restoran`
--

INSERT INTO `restoran` (`IdKorisnik`, `Telefon`, `Naziv`, `Adresa`, `IdGrad`, `IdSlika`, `RadnoVreme`, `Pregledano`) VALUES
(3, '011 3231332', 'Restoran Madera', 'Bulevar kralja Aleksandra 43', 1, 2, '\r\nponedeljak	10:00-00:00\r\nutorak	10:00-00:00\r\nsreda	10:00-00:00\r\nčetvrtak	10:00-00:00\r\npetak	10:00-01:00\r\nsubota	10:00-01:00\r\nnedelja	10:00-00:00', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `sastojak`
--

DROP TABLE IF EXISTS `sastojak`;
CREATE TABLE IF NOT EXISTS `sastojak` (
  `IdSastojak` int(11) NOT NULL,
  `Naziv` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`IdSastojak`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sastojak`
--

INSERT INTO `sastojak` (`IdSastojak`, `Naziv`) VALUES
(1, 'chicago testo'),
(2, 'sir'),
(3, 'šunka'),
(4, 'pančeta'),
(5, 'kisela pavlaka'),
(6, 'šampinjoni');

-- --------------------------------------------------------

--
-- Table structure for table `slika`
--

DROP TABLE IF EXISTS `slika`;
CREATE TABLE IF NOT EXISTS `slika` (
  `IdSlika` int(11) NOT NULL,
  `Putanja` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`IdSlika`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `slika`
--

INSERT INTO `slika` (`IdSlika`, `Putanja`) VALUES
(1, 'Projekat\\pics\\genericGruman.jpg'),
(2, 'Projekat\\pics\\genericRestoran.jpg'),
(3, 'Projekat\\pics\\genericJelo.jpg');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `R_3` FOREIGN KEY (`IdKorisnik`) REFERENCES `korisnik` (`idkorisnik`) ON DELETE CASCADE;

--
-- Constraints for table `grad`
--
ALTER TABLE `grad`
  ADD CONSTRAINT `R_9` FOREIGN KEY (`IdDrzava`) REFERENCES `drzava` (`iddrzava`);

--
-- Constraints for table `gurman`
--
ALTER TABLE `gurman`
  ADD CONSTRAINT `R_12` FOREIGN KEY (`IdSlika`) REFERENCES `slika` (`idslika`),
  ADD CONSTRAINT `R_2` FOREIGN KEY (`IdKorisnik`) REFERENCES `korisnik` (`idkorisnik`) ON DELETE CASCADE;

--
-- Constraints for table `ima_sastojak`
--
ALTER TABLE `ima_sastojak`
  ADD CONSTRAINT `R_14` FOREIGN KEY (`IdJelo`) REFERENCES `jelo` (`idjelo`) ON DELETE CASCADE,
  ADD CONSTRAINT `R_15` FOREIGN KEY (`IdSastojak`) REFERENCES `sastojak` (`idsastojak`);

--
-- Constraints for table `jelo`
--
ALTER TABLE `jelo`
  ADD CONSTRAINT `R_13` FOREIGN KEY (`IdSlika`) REFERENCES `slika` (`idslika`),
  ADD CONSTRAINT `R_5` FOREIGN KEY (`IdKorisnik`) REFERENCES `restoran` (`idkorisnik`) ON DELETE CASCADE;

--
-- Constraints for table `recenzija`
--
ALTER TABLE `recenzija`
  ADD CONSTRAINT `R_7` FOREIGN KEY (`IdKorisnik`) REFERENCES `gurman` (`idkorisnik`) ON DELETE CASCADE,
  ADD CONSTRAINT `R_8` FOREIGN KEY (`IdJelo`) REFERENCES `jelo` (`idjelo`) ON DELETE CASCADE;

--
-- Constraints for table `restoran`
--
ALTER TABLE `restoran`
  ADD CONSTRAINT `R_1` FOREIGN KEY (`IdKorisnik`) REFERENCES `korisnik` (`idkorisnik`) ON DELETE CASCADE,
  ADD CONSTRAINT `R_10` FOREIGN KEY (`IdGrad`) REFERENCES `grad` (`idgrad`),
  ADD CONSTRAINT `R_11` FOREIGN KEY (`IdSlika`) REFERENCES `slika` (`idslika`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
