-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 01, 2023 at 05:14 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resa`
--

-- --------------------------------------------------------

--
-- Table structure for table `compte`
--

CREATE TABLE `compte` (
  `USER` char(8) NOT NULL,
  `MDP` char(10) DEFAULT NULL,
  `NOMCPTE` char(40) DEFAULT NULL,
  `PRENOMCPTE` char(30) DEFAULT NULL,
  `DATEINSCRIP` date DEFAULT NULL,
  `DATEFERME` date DEFAULT NULL,
  `TYPECOMPTE` char(3) DEFAULT NULL,
  `ADRMAILCPTE` char(60) DEFAULT NULL,
  `NOTELCPTE` char(15) DEFAULT NULL,
  `NOPORTCPTE` char(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `compte`
--

INSERT INTO `compte` (`USER`, `MDP`, `NOMCPTE`, `PRENOMCPTE`, `DATEINSCRIP`, `DATEFERME`, `TYPECOMPTE`, `ADRMAILCPTE`, `NOTELCPTE`, `NOPORTCPTE`) VALUES
('aa', 'aa', 'aa', 'aa', '2023-09-17', '2023-11-15', 'ADM', 'aa@gmail.com', 'aaa', 'aa'),
('bb', 'bb', 'bb', 'bb', '2023-09-17', '2023-10-31', 'GES', 'bb@gmail.com', 'bbb', 'bb'),
('cc', 'cc', 'cc', 'cc', '2023-09-17', '2023-10-31', 'VIS', 'cc@gmail.com', 'ccc', 'cc'),
('dd', 'dd', 'dd', 'dd', '2023-09-17', '2023-10-31', 'AAA', 'dd@gmail.com', 'ddd', 'dd'),
('yy', 'yy', 'yy', 'yy', '2023-09-17', '2023-09-29', 'VIS', 'yy@gmail.com', 'yyy', 'yy'),
('zz', 'zz', 'zz', 'zz', '2023-09-17', '2023-09-29', 'ADM', 'zz@gmail.com', 'zzz', 'zz');

-- --------------------------------------------------------

--
-- Table structure for table `etat_resa`
--

CREATE TABLE `etat_resa` (
  `CODEETATRESA` char(2) NOT NULL,
  `NOMETATRESA` char(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `etat_resa`
--

INSERT INTO `etat_resa` (`CODEETATRESA`, `NOMETATRESA`) VALUES
('AN', 'Annulée'),
('AV', 'Arrhes versées'),
('BL', 'Bloquée'),
('CR', 'Clés retirées'),
('SL', 'Solde'),
('TE', 'Terminée');

-- --------------------------------------------------------

--
-- Table structure for table `hebergement`
--

CREATE TABLE `hebergement` (
  `NOHEB` int NOT NULL,
  `CODETYPEHEB` char(5) NOT NULL,
  `NOMHEB` char(40) DEFAULT NULL,
  `NBPLACEHEB` int DEFAULT NULL,
  `SURFACEHEB` int DEFAULT NULL,
  `INTERNET` tinyint(1) DEFAULT NULL,
  `ANNEEHEB` int DEFAULT NULL,
  `SECTEURHEB` char(15) DEFAULT NULL,
  `ORIENTATIONHEB` char(5) DEFAULT NULL,
  `ETATHEB` char(32) DEFAULT NULL,
  `DESCRIHEB` char(200) DEFAULT NULL,
  `PHOTOHEB` char(50) DEFAULT NULL,
  `TARIFSEMHEB` decimal(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hebergement`
--

INSERT INTO `hebergement` (`NOHEB`, `CODETYPEHEB`, `NOMHEB`, `NBPLACEHEB`, `SURFACEHEB`, `INTERNET`, `ANNEEHEB`, `SECTEURHEB`, `ORIENTATIONHEB`, `ETATHEB`, `DESCRIHEB`, `PHOTOHEB`, `TARIFSEMHEB`) VALUES
(28, 'BUNGA', 'bungalow', 5, 10, 1, 2023, 'Zone pâturage', 'Nord', 'Parfais', 'aa', '653aae9d0b0cb.png', '20.00'),
(29, 'APPAR', 'fullstack', 1, 10, 1, 2023, 'Zone ski', 'Nord', 'Bon', 'yyy', 'default-house-icon.png', '1165.15'),
(30, 'CHALE', '<h1>cheval 2</h1>', 1, 10, 1, 2023, 'Zone pâturage', 'Sud', 'Bon', 'XDDDD', '653bdbb69fcd8.png', '20.00'),
(31, 'APPAR', 'aa', 5, 12, 1, 2023, 'Zone ski', 'Nord', 'Parfais', 'aa', 'default-house-icon.png', '21.00');

-- --------------------------------------------------------

--
-- Table structure for table `resa`
--

CREATE TABLE `resa` (
  `NORESA` int NOT NULL,
  `USER` char(8) NOT NULL,
  `DATEDEBSEM` date NOT NULL,
  `NOHEB` int NOT NULL,
  `CODEETATRESA` char(2) NOT NULL,
  `DATERESA` date DEFAULT NULL,
  `DATEARRHES` date DEFAULT NULL,
  `MONTANTARRHES` decimal(7,2) DEFAULT NULL,
  `NBOCCUPANT` int DEFAULT NULL,
  `TARIFSEMRESA` decimal(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `resa`
--

INSERT INTO `resa` (`NORESA`, `USER`, `DATEDEBSEM`, `NOHEB`, `CODEETATRESA`, `DATERESA`, `DATEARRHES`, `MONTANTARRHES`, `NBOCCUPANT`, `TARIFSEMRESA`) VALUES
(2, 'aa', '2023-12-23', 28, 'AV', '2023-12-23', NULL, '20.00', 1, '20.00'),
(6, 'aa', '2023-12-09', 28, 'AV', '2023-12-09', NULL, '20.00', 1, '20.00'),
(7, 'aa', '2024-01-06', 28, 'AV', '2024-01-06', NULL, '20.00', 3, '20.00');

-- --------------------------------------------------------

--
-- Table structure for table `semaine`
--

CREATE TABLE `semaine` (
  `DATEDEBSEM` date NOT NULL,
  `DATEFINSEM` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `semaine`
--

INSERT INTO `semaine` (`DATEDEBSEM`, `DATEFINSEM`) VALUES
('2023-10-28', '2023-11-04'),
('2023-11-27', '2023-11-05'),
('2023-12-02', '2023-12-09'),
('2023-12-09', '2023-12-16'),
('2023-12-23', '2023-12-30'),
('2024-01-06', '2024-01-13'),
('2024-01-20', '2024-01-27');

-- --------------------------------------------------------

--
-- Table structure for table `type_heb`
--

CREATE TABLE `type_heb` (
  `CODETYPEHEB` char(5) NOT NULL,
  `NOMTYPEHEB` char(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `type_heb`
--

INSERT INTO `type_heb` (`CODETYPEHEB`, `NOMTYPEHEB`) VALUES
('APPAR', 'Appartement'),
('BUNGA', 'Bungalow'),
('CHALE', 'Chalet'),
('MOBHO', 'Mobil home'),
('ZAUTR', 'Autre');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`USER`);

--
-- Indexes for table `etat_resa`
--
ALTER TABLE `etat_resa`
  ADD PRIMARY KEY (`CODEETATRESA`);

--
-- Indexes for table `hebergement`
--
ALTER TABLE `hebergement`
  ADD PRIMARY KEY (`NOHEB`),
  ADD KEY `I_FK_HEBERGEMENT_TYPE_HEB` (`CODETYPEHEB`);

--
-- Indexes for table `resa`
--
ALTER TABLE `resa`
  ADD PRIMARY KEY (`NORESA`),
  ADD KEY `I_FK_RESA_COMPTE` (`USER`),
  ADD KEY `I_FK_RESA_SEMAINE` (`DATEDEBSEM`),
  ADD KEY `I_FK_RESA_HEBERGEMENT` (`NOHEB`),
  ADD KEY `I_FK_RESA_ETAT_RESA` (`CODEETATRESA`);

--
-- Indexes for table `semaine`
--
ALTER TABLE `semaine`
  ADD PRIMARY KEY (`DATEDEBSEM`);

--
-- Indexes for table `type_heb`
--
ALTER TABLE `type_heb`
  ADD PRIMARY KEY (`CODETYPEHEB`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hebergement`
--
ALTER TABLE `hebergement`
  MODIFY `NOHEB` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `resa`
--
ALTER TABLE `resa`
  MODIFY `NORESA` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hebergement`
--
ALTER TABLE `hebergement`
  ADD CONSTRAINT `hebergement_ibfk_1` FOREIGN KEY (`CODETYPEHEB`) REFERENCES `type_heb` (`CODETYPEHEB`);

--
-- Constraints for table `resa`
--
ALTER TABLE `resa`
  ADD CONSTRAINT `resa_ibfk_1` FOREIGN KEY (`USER`) REFERENCES `compte` (`USER`),
  ADD CONSTRAINT `resa_ibfk_2` FOREIGN KEY (`DATEDEBSEM`) REFERENCES `semaine` (`DATEDEBSEM`),
  ADD CONSTRAINT `resa_ibfk_4` FOREIGN KEY (`CODEETATRESA`) REFERENCES `etat_resa` (`CODEETATRESA`),
  ADD CONSTRAINT `resa_ibfk_5` FOREIGN KEY (`NOHEB`) REFERENCES `hebergement` (`NOHEB`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
