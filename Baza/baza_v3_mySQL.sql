-- MySQL dump 10.13  Distrib 8.0.13, for Win64 (x86_64)
--
-- Host: localhost    Database: restoran
-- ------------------------------------------------------
-- Server version	8.0.13

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `administrator`
--

DROP TABLE IF EXISTS `administrator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `administrator` (
  `IdKorisnik` int(11) NOT NULL,
  PRIMARY KEY (`IdKorisnik`),
  CONSTRAINT `R_3` FOREIGN KEY (`IdKorisnik`) REFERENCES `korisnik` (`idkorisnik`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrator`
--

LOCK TABLES `administrator` WRITE;
/*!40000 ALTER TABLE `administrator` DISABLE KEYS */;
/*!40000 ALTER TABLE `administrator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `drzava`
--

DROP TABLE IF EXISTS `drzava`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `drzava` (
  `IdDrzava` int(11) NOT NULL,
  `Naziv` varchar(20) NOT NULL,
  PRIMARY KEY (`IdDrzava`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drzava`
--

LOCK TABLES `drzava` WRITE;
/*!40000 ALTER TABLE `drzava` DISABLE KEYS */;
/*!40000 ALTER TABLE `drzava` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grad`
--

DROP TABLE IF EXISTS `grad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `grad` (
  `IdDrzava` int(11) NOT NULL,
  `IdGrad` int(11) NOT NULL,
  `Naziv` varchar(20) NOT NULL,
  PRIMARY KEY (`IdGrad`),
  KEY `R_9` (`IdDrzava`),
  CONSTRAINT `R_9` FOREIGN KEY (`IdDrzava`) REFERENCES `drzava` (`iddrzava`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grad`
--

LOCK TABLES `grad` WRITE;
/*!40000 ALTER TABLE `grad` DISABLE KEYS */;
/*!40000 ALTER TABLE `grad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gurman`
--

DROP TABLE IF EXISTS `gurman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `gurman` (
  `IdKorisnik` int(11) NOT NULL,
  `Ime` varchar(20) NOT NULL,
  `Prezime` varchar(20) NOT NULL,
  `Pol` char(1) NOT NULL,
  `IdSlika` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdKorisnik`),
  KEY `R_12` (`IdSlika`),
  CONSTRAINT `R_12` FOREIGN KEY (`IdSlika`) REFERENCES `slika` (`idslika`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `R_2` FOREIGN KEY (`IdKorisnik`) REFERENCES `korisnik` (`idkorisnik`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gurman`
--

LOCK TABLES `gurman` WRITE;
/*!40000 ALTER TABLE `gurman` DISABLE KEYS */;
/*!40000 ALTER TABLE `gurman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jelo`
--

DROP TABLE IF EXISTS `jelo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `jelo` (
  `Naziv` varchar(30) NOT NULL,
  `Opis` varchar(250) NOT NULL,
  `IdJelo` int(11) NOT NULL,
  `IdKorisnik` int(11) NOT NULL,
  `IdSlika` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdJelo`),
  KEY `R_13` (`IdSlika`),
  KEY `R_5` (`IdKorisnik`),
  CONSTRAINT `R_13` FOREIGN KEY (`IdSlika`) REFERENCES `slika` (`idslika`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `R_5` FOREIGN KEY (`IdKorisnik`) REFERENCES `restoran` (`idkorisnik`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jelo`
--

LOCK TABLES `jelo` WRITE;
/*!40000 ALTER TABLE `jelo` DISABLE KEYS */;
/*!40000 ALTER TABLE `jelo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `korisnik`
--

DROP TABLE IF EXISTS `korisnik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `korisnik` (
  `IdKorisnik` int(11) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Email` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`IdKorisnik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `korisnik`
--

LOCK TABLES `korisnik` WRITE;
/*!40000 ALTER TABLE `korisnik` DISABLE KEYS */;
/*!40000 ALTER TABLE `korisnik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `radnovreme`
--

DROP TABLE IF EXISTS `radnovreme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `radnovreme` (
  `IdKorisnik` int(11) NOT NULL,
  `IdRadnoVreme` int(11) NOT NULL,
  `DanIVreme` varchar(40) NOT NULL,
  PRIMARY KEY (`IdRadnoVreme`),
  KEY `R_4` (`IdKorisnik`),
  CONSTRAINT `R_4` FOREIGN KEY (`IdKorisnik`) REFERENCES `restoran` (`idkorisnik`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `radnovreme`
--

LOCK TABLES `radnovreme` WRITE;
/*!40000 ALTER TABLE `radnovreme` DISABLE KEYS */;
/*!40000 ALTER TABLE `radnovreme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recenzija`
--

DROP TABLE IF EXISTS `recenzija`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `recenzija` (
  `IdKorisnik` int(11) NOT NULL,
  `Ocena` int(11) NOT NULL,
  `Komentar` varchar(250) NOT NULL,
  `IdJelo` int(11) NOT NULL,
  PRIMARY KEY (`IdJelo`,`IdKorisnik`),
  KEY `R_7` (`IdKorisnik`),
  CONSTRAINT `R_7` FOREIGN KEY (`IdKorisnik`) REFERENCES `gurman` (`idkorisnik`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `R_8` FOREIGN KEY (`IdJelo`) REFERENCES `jelo` (`idjelo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recenzija`
--

LOCK TABLES `recenzija` WRITE;
/*!40000 ALTER TABLE `recenzija` DISABLE KEYS */;
/*!40000 ALTER TABLE `recenzija` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restoran`
--

DROP TABLE IF EXISTS `restoran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `restoran` (
  `IdKorisnik` int(11) NOT NULL,
  `Telefon` varchar(20) DEFAULT NULL,
  `Naziv` varchar(30) NOT NULL,
  `Adresa` varchar(30) NOT NULL,
  `Grad` varchar(20) NOT NULL,
  `Drzava` varchar(20) NOT NULL,
  `IdGrad` int(11) NOT NULL,
  `IdSlika` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdKorisnik`),
  KEY `R_10` (`IdGrad`),
  KEY `R_11` (`IdSlika`),
  CONSTRAINT `R_1` FOREIGN KEY (`IdKorisnik`) REFERENCES `korisnik` (`idkorisnik`) ON DELETE CASCADE,
  CONSTRAINT `R_10` FOREIGN KEY (`IdGrad`) REFERENCES `grad` (`idgrad`) ON UPDATE CASCADE,
  CONSTRAINT `R_11` FOREIGN KEY (`IdSlika`) REFERENCES `slika` (`idslika`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restoran`
--

LOCK TABLES `restoran` WRITE;
/*!40000 ALTER TABLE `restoran` DISABLE KEYS */;
/*!40000 ALTER TABLE `restoran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sastojak`
--

DROP TABLE IF EXISTS `sastojak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sastojak` (
  `IdJelo` int(11) NOT NULL,
  `IdSastojak` int(11) NOT NULL,
  `Naziv` varchar(20) NOT NULL,
  PRIMARY KEY (`IdSastojak`),
  KEY `R_6` (`IdJelo`),
  CONSTRAINT `R_6` FOREIGN KEY (`IdJelo`) REFERENCES `jelo` (`idjelo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sastojak`
--

LOCK TABLES `sastojak` WRITE;
/*!40000 ALTER TABLE `sastojak` DISABLE KEYS */;
/*!40000 ALTER TABLE `sastojak` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `slika`
--

DROP TABLE IF EXISTS `slika`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `slika` (
  `IdSlika` int(11) NOT NULL,
  `Putanja` varchar(300) NOT NULL,
  PRIMARY KEY (`IdSlika`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slika`
--

LOCK TABLES `slika` WRITE;
/*!40000 ALTER TABLE `slika` DISABLE KEYS */;
/*!40000 ALTER TABLE `slika` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-16 19:47:18
