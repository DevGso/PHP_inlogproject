-- phpMyAdmin SQL Dump
-- version 5.2.3deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Gegenereerd op: 12 nov 2026 om 13:37
-- Serverversie: 8.4.11-0ubuntu0.26.04.1
-- PHP-versie: 8.5.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `InlogProject_Giel`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Gebruiker`
--

CREATE TABLE `Gebruiker` (
  `ID` int NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `wachtwoord` varchar(100) NOT NULL,
  `voornaam` varchar(20) NOT NULL,
  `achternaam` varchar(20) NOT NULL,
  `klas` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `rolid` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Rol`
--

CREATE TABLE `Rol` (
  `ID` int NOT NULL,
  `naam` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `Gebruiker`
--
ALTER TABLE `Gebruiker`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `rolld` (`rolid`) USING BTREE;

--
-- Indexen voor tabel `Rol`
--
ALTER TABLE `Rol`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `Gebruiker`
--
ALTER TABLE `Gebruiker`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `Rol`
--
ALTER TABLE `Rol`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `Gebruiker`
--
ALTER TABLE `Gebruiker`
  ADD CONSTRAINT `Gebruiker_ibfk_1` FOREIGN KEY (`rolid`) REFERENCES `Rol` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
