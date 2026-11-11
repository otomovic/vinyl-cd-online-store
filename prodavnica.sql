-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2023 at 10:30 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prodavnica`
--

-- --------------------------------------------------------

--
-- Table structure for table `izdanje`
--

CREATE TABLE `izdanje` (
  `idIzdanja` int(4) UNSIGNED NOT NULL,
  `naziv` varchar(60) NOT NULL,
  `godina` int(4) NOT NULL,
  `tip` enum('album','single','compilation') NOT NULL,
  `format` enum('cd','vinyl') NOT NULL,
  `cena` int(11) NOT NULL,
  `kolicina` int(11) NOT NULL,
  `naStanju` tinyint(1) NOT NULL,
  `slika` varchar(255) NOT NULL,
  `obrisan` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `izdanje`
--

INSERT INTO `izdanje` (`idIzdanja`, `naziv`, `godina`, `tip`, `format`, `cena`, `kolicina`, `naStanju`, `slika`, `obrisan`) VALUES
(12, 'A Night at the Opera', 1975, 'album', 'vinyl', 2400, 95, 1, 'https___images.genius.com_bc1d2e0fd77810ed54ee87646eba720c.1000x1000x1.png', 0),
(14, 'Aerosmith', 1973, 'album', 'vinyl', 3200, 95, 1, '71rbqasUaOL._UF1000,1000_QL80_.jpg', 0),
(15, 'Bitanga i princeza', 1979, 'album', 'cd', 1300, 492, 1, '293b16a502cf23fb9f49097951030258.1000x1000x1.png', 0),
(17, 'Konji', 1988, 'album', 'cd', 1250, 297, 1, 'mzi.oahvgeci.jpg', 0),
(19, 'Katarina II', 1984, 'album', 'vinyl', 3000, 100, 1, 'a.png', 0),
(21, 'Bijelo dugme', 1984, 'album', 'cd', 1300, 100, 1, '3c85a052e99a7fca9337afa818c30696.1000x1000x1.png', 0),
(29, 'Motori', 1982, 'album', 'vinyl', 3400, 198, 1, 'e073a37e5ffcf442900c023bf4349036.1000x1000x1.png', 0),
(35, 'Guarda Toma', 1996, 'album', 'cd', 1000, 100, 1, 'https___images.genius.com_832d1a71d63d0b5978159c8762f2c541.443x443x1.jpg', 0),
(36, 'Metallica', 1991, 'album', 'vinyl', 1200, 500, 1, 'https___images.genius.com_bd2a4a084693694f70cfec21369c6c19.596x596x1.png', 0),
(38, 'Čokolada', 1983, 'album', 'cd', 1600, 8, 1, '01287dc79281bae4d790162dc0119e7c.1000x1000x1.png', 0),
(39, 'Piloti', 1981, 'album', 'vinyl', 3299, 50, 1, 'FRONT (5).png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `izdanjeizvodjac`
--

CREATE TABLE `izdanjeizvodjac` (
  `idIzdanja` int(4) UNSIGNED NOT NULL,
  `idIzvodjaca` int(4) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `izdanjeizvodjac`
--

INSERT INTO `izdanjeizvodjac` (`idIzdanja`, `idIzvodjaca`) VALUES
(12, 2),
(14, 1),
(15, 4),
(17, 5),
(19, 7),
(21, 4),
(29, 5),
(35, 9),
(36, 10),
(38, 11),
(39, 12);

-- --------------------------------------------------------

--
-- Table structure for table `izdanjezanr`
--

CREATE TABLE `izdanjezanr` (
  `idIzdanja` int(4) UNSIGNED NOT NULL,
  `idZanra` int(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `izdanjezanr`
--

INSERT INTO `izdanjezanr` (`idIzdanja`, `idZanra`) VALUES
(12, 1),
(12, 7),
(14, 1),
(15, 1),
(15, 4),
(17, 1),
(17, 7),
(19, 1),
(21, 1),
(21, 4),
(29, 1),
(29, 7),
(35, 1),
(35, 4),
(36, 1),
(36, 7),
(38, 1),
(39, 1),
(39, 4);

-- --------------------------------------------------------

--
-- Table structure for table `izvodjac`
--

CREATE TABLE `izvodjac` (
  `idIzvodjaca` int(4) UNSIGNED NOT NULL,
  `ime` varchar(60) NOT NULL,
  `bio` text DEFAULT NULL,
  `obrisan` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `izvodjac`
--

INSERT INTO `izvodjac` (`idIzvodjaca`, `ime`, `bio`, `obrisan`) VALUES
(1, 'Aerosmith', NULL, 0),
(2, 'Queen', 'Queen britanski su rok sastav osnovan u Londonu 1970. Njihova klasična postava bila je Fredi Merkjuri (glavni vokal, klavir), Brajan Mej (gitara, vokal), Rodžer Tejlor (bubnjevi, vokal) i Džon Dikon (bas). Na njihova najranija dela uticali su progresivni rok, hard rok i hevi metal, ali se bend postepeno upuštao u konvencionalnija i radijski prilagođena dela uključivanjem drugih stilova, poput arena roka i pop roka.', 0),
(4, 'Bijelo Dugme', 'Bijelo dugme je jugoslovenska rok grupa koja je više od dve decenije bila jedna od najpopularnijih grupa na prostorima bivše SFR Jugoslavije. Osnovana je u Sarajevu 1973. godine. Izdala je devet albuma u periodu od 1974. do 1988. godine. Grupa Bijelo dugme je nastala iz grupe Jutro, a novo ime je usvojila 1. januara 1974. Vođa i jedini stalni član grupe bio je gitarista Goran Bregović, dok su se na mestu pevača menjali Željko Bebek, Tifa Vojičić i Alen Islamović. U grupu su dolazili i iz nje odlazili iz različitih razloga basisti Zoran Redžić, Jadranko Stanković, Sanin Karić i Ljubiša Racić, bubnjari Ipe Ivandić, Milić Vukašinović i Điđi Jankelić, i klavijaturisti Vlado Pravdić i Laza Ristovski.', 0),
(5, 'Divlje Jagode', NULL, 0),
(7, 'Ekatarina Velika', NULL, 0),
(9, 'Kanda Kodža i Nebojša', NULL, 0),
(10, 'Metallica', NULL, 0),
(11, 'Idoli', 'VIS Idoli je bila muzička grupa iz Beograda. Grupa je postojala od 1. marta 1980. godine do kraja marta 1984. godine.', 0),
(12, 'Piloti', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `idKorisnika` int(6) UNSIGNED NOT NULL,
  `ime` varchar(40) NOT NULL,
  `prezime` varchar(60) NOT NULL,
  `email` varchar(30) NOT NULL,
  `lozinka` varchar(20) NOT NULL,
  `adresa` varchar(60) NOT NULL,
  `status` enum('korisnik','administrator') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`idKorisnika`, `ime`, `prezime`, `email`, `lozinka`, `adresa`, `status`) VALUES
(1, 'Ognjen', 'Tomović', 'otomovic14@gmail.com', 'admin', 'Gradski park 1', 'administrator'),
(2, 'Bogdan', 'Lalović', 'blalovic@yahoo.com', 'bokilalovic', 'Cara Dušana 31', 'korisnik');

-- --------------------------------------------------------

--
-- Table structure for table `kupovina`
--

CREATE TABLE `kupovina` (
  `idKupovine` int(10) UNSIGNED NOT NULL,
  `idKorisnika` int(6) UNSIGNED NOT NULL,
  `vreme` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `specifikacija`
--

CREATE TABLE `specifikacija` (
  `idKupovine` int(10) UNSIGNED NOT NULL,
  `idIzdanja` int(4) UNSIGNED NOT NULL,
  `kolicina` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `zanr`
--

CREATE TABLE `zanr` (
  `idZanra` int(3) UNSIGNED NOT NULL,
  `nazivZanra` varchar(30) NOT NULL,
  `obrisan` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `zanr`
--

INSERT INTO `zanr` (`idZanra`, `nazivZanra`, `obrisan`) VALUES
(1, 'Rock', 0),
(4, 'Pop', 0),
(5, 'Jazz', 0),
(6, 'Hip Hop', 0),
(7, 'Heavy Metal', 0),
(8, 'Folk', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `izdanje`
--
ALTER TABLE `izdanje`
  ADD PRIMARY KEY (`idIzdanja`),
  ADD UNIQUE KEY `slika` (`slika`);

--
-- Indexes for table `izdanjeizvodjac`
--
ALTER TABLE `izdanjeizvodjac`
  ADD PRIMARY KEY (`idIzdanja`,`idIzvodjaca`),
  ADD KEY `idIzvodjaca` (`idIzvodjaca`);

--
-- Indexes for table `izdanjezanr`
--
ALTER TABLE `izdanjezanr`
  ADD PRIMARY KEY (`idIzdanja`,`idZanra`),
  ADD KEY `idZanraIZ` (`idZanra`);

--
-- Indexes for table `izvodjac`
--
ALTER TABLE `izvodjac`
  ADD PRIMARY KEY (`idIzvodjaca`);

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`idKorisnika`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `kupovina`
--
ALTER TABLE `kupovina`
  ADD PRIMARY KEY (`idKupovine`),
  ADD KEY `FK_idKorisnika` (`idKorisnika`);

--
-- Indexes for table `specifikacija`
--
ALTER TABLE `specifikacija`
  ADD PRIMARY KEY (`idKupovine`,`idIzdanja`),
  ADD KEY `idIzdanja` (`idIzdanja`);

--
-- Indexes for table `zanr`
--
ALTER TABLE `zanr`
  ADD PRIMARY KEY (`idZanra`),
  ADD UNIQUE KEY `nazivZanra` (`nazivZanra`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `izdanje`
--
ALTER TABLE `izdanje`
  MODIFY `idIzdanja` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `izvodjac`
--
ALTER TABLE `izvodjac`
  MODIFY `idIzvodjaca` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `idKorisnika` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kupovina`
--
ALTER TABLE `kupovina`
  MODIFY `idKupovine` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `zanr`
--
ALTER TABLE `zanr`
  MODIFY `idZanra` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `izdanjeizvodjac`
--
ALTER TABLE `izdanjeizvodjac`
  ADD CONSTRAINT `idIzdanja` FOREIGN KEY (`idIzdanja`) REFERENCES `izdanje` (`idIzdanja`),
  ADD CONSTRAINT `idIzvodjaca` FOREIGN KEY (`idIzvodjaca`) REFERENCES `izvodjac` (`idIzvodjaca`),
  ADD CONSTRAINT `izdanjeizvodjac_ibfk_1` FOREIGN KEY (`idIzdanja`) REFERENCES `izdanje` (`idIzdanja`);

--
-- Constraints for table `izdanjezanr`
--
ALTER TABLE `izdanjezanr`
  ADD CONSTRAINT `idIzdanjaIZ` FOREIGN KEY (`idIzdanja`) REFERENCES `izdanje` (`idIzdanja`),
  ADD CONSTRAINT `idZanraIZ` FOREIGN KEY (`idZanra`) REFERENCES `zanr` (`idZanra`);

--
-- Constraints for table `kupovina`
--
ALTER TABLE `kupovina`
  ADD CONSTRAINT `FK_idKorisnika` FOREIGN KEY (`idKorisnika`) REFERENCES `korisnik` (`idKorisnika`);

--
-- Constraints for table `specifikacija`
--
ALTER TABLE `specifikacija`
  ADD CONSTRAINT `specifikacija_ibfk_1` FOREIGN KEY (`idKupovine`) REFERENCES `kupovina` (`idKupovine`),
  ADD CONSTRAINT `specifikacija_ibfk_2` FOREIGN KEY (`idIzdanja`) REFERENCES `izdanje` (`idIzdanja`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
