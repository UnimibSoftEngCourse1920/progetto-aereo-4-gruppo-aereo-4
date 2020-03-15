-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Mar 15, 2020 alle 20:19
-- Versione del server: 10.3.16-MariaDB
-- Versione PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id12704943_compagniaaerea`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Acquisto`
--

CREATE TABLE `Acquisto` (
  `OID` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `puntiAccumulati` int(11) DEFAULT NULL,
  `pagamento` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `Aereo`
--

CREATE TABLE `Aereo` (
  `OID` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `numeroPosti` int(11) DEFAULT NULL,
  `numeroSerie` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `marcaModello` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Struttura della tabella `Aeroporto`
--

CREATE TABLE `Aeroporto` (
  `OID` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `continente` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nazione` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `citta` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nome` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codice` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `Biglietto`
--

CREATE TABLE `Biglietto` (
  `OID` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `tariffa` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nominativo` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numPosto` int(11) DEFAULT NULL,
  `prezzo` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `Cliente`
--

CREATE TABLE `Cliente` (
  `OID` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cognome` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dataNascita` date DEFAULT NULL,
  `indirizzo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codiceFedelta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stato` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `saldoPunti` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `Impiegato`
--

CREATE TABLE `Impiegato` (
  `OID` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cognome` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `Pagamento`
--

CREATE TABLE `Pagamento` (
  `OID` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `importo` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `puntiUtilizzati` int(11) DEFAULT NULL,
  `istitutoDiCredito` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `Posto`
--

CREATE TABLE `Posto` (
  `OID` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `stato` bit(1) DEFAULT NULL,
  `numeroPosto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `Prenotazione`
--

CREATE TABLE `Prenotazione` (
  `OID` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `PrenotazioneAcquisto`
--

CREATE TABLE `PrenotazioneAcquisto` (
  `prenotazione` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `acquisto` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `PrenotazioneBiglietto`
--

CREATE TABLE `PrenotazioneBiglietto` (
  `prenotazione` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `biglietto` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `PrenotazioneCliente`
--

CREATE TABLE `PrenotazioneCliente` (
  `prenotazione` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `cliente` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `PrenotazionePosto`
--

CREATE TABLE `PrenotazionePosto` (
  `prenotazione` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `posto` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `PrenotazioneVolo`
--

CREATE TABLE `PrenotazioneVolo` (
  `prenotazione` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `volo` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `Promozione`
--

CREATE TABLE `Promozione` (
  `OID` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `dataInizio` date DEFAULT NULL,
  `dataFine` date DEFAULT NULL,
  `nome` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `percentualeSconto` int(11) DEFAULT NULL,
  `promozioneFedelta` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `Volo`
--

CREATE TABLE `Volo` (
  `OID` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `dataOraPartenza` datetime DEFAULT NULL,
  `dataOraArrivo` datetime DEFAULT NULL,
  `stato` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `miglia` int(11) DEFAULT NULL,
  `aereo` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `promozione` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codiceVolo` varchar(5) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `VoloAeroporto`
--

CREATE TABLE `VoloAeroporto` (
  `volo` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `aeroportoPartenza` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `aeroportoDestinazione` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `VoloPosto`
--

CREATE TABLE `VoloPosto` (
  `volo` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `posto` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `Acquisto`
--
ALTER TABLE `Acquisto`
  ADD PRIMARY KEY (`OID`);

--
-- Indici per le tabelle `Aereo`
--
ALTER TABLE `Aereo`
  ADD PRIMARY KEY (`OID`);

--
-- Indici per le tabelle `Aeroporto`
--
ALTER TABLE `Aeroporto`
  ADD PRIMARY KEY (`OID`);

--
-- Indici per le tabelle `Biglietto`
--
ALTER TABLE `Biglietto`
  ADD PRIMARY KEY (`OID`);

--
-- Indici per le tabelle `Cliente`
--
ALTER TABLE `Cliente`
  ADD PRIMARY KEY (`OID`);

--
-- Indici per le tabelle `Impiegato`
--
ALTER TABLE `Impiegato`
  ADD PRIMARY KEY (`OID`);

--
-- Indici per le tabelle `Pagamento`
--
ALTER TABLE `Pagamento`
  ADD PRIMARY KEY (`OID`);

--
-- Indici per le tabelle `Posto`
--
ALTER TABLE `Posto`
  ADD PRIMARY KEY (`OID`);

--
-- Indici per le tabelle `Prenotazione`
--
ALTER TABLE `Prenotazione`
  ADD PRIMARY KEY (`OID`);

--
-- Indici per le tabelle `PrenotazioneAcquisto`
--
ALTER TABLE `PrenotazioneAcquisto`
  ADD PRIMARY KEY (`prenotazione`,`acquisto`),
  ADD KEY `acquisto` (`acquisto`);

--
-- Indici per le tabelle `PrenotazioneBiglietto`
--
ALTER TABLE `PrenotazioneBiglietto`
  ADD PRIMARY KEY (`prenotazione`,`biglietto`),
  ADD KEY `biglietto` (`biglietto`);

--
-- Indici per le tabelle `PrenotazioneCliente`
--
ALTER TABLE `PrenotazioneCliente`
  ADD PRIMARY KEY (`prenotazione`,`cliente`),
  ADD KEY `cliente` (`cliente`);

--
-- Indici per le tabelle `PrenotazionePosto`
--
ALTER TABLE `PrenotazionePosto`
  ADD PRIMARY KEY (`prenotazione`,`posto`),
  ADD KEY `posto` (`posto`);

--
-- Indici per le tabelle `PrenotazioneVolo`
--
ALTER TABLE `PrenotazioneVolo`
  ADD PRIMARY KEY (`prenotazione`,`volo`),
  ADD KEY `volo` (`volo`);

--
-- Indici per le tabelle `Promozione`
--
ALTER TABLE `Promozione`
  ADD PRIMARY KEY (`OID`);

--
-- Indici per le tabelle `Volo`
--
ALTER TABLE `Volo`
  ADD PRIMARY KEY (`OID`);

--
-- Indici per le tabelle `VoloAeroporto`
--
ALTER TABLE `VoloAeroporto`
  ADD PRIMARY KEY (`volo`,`aeroportoPartenza`,`aeroportoDestinazione`),
  ADD KEY `aeroportoPartenza` (`aeroportoPartenza`),
  ADD KEY `aeroportoDestinazione` (`aeroportoDestinazione`);

--
-- Indici per le tabelle `VoloPosto`
--
ALTER TABLE `VoloPosto`
  ADD PRIMARY KEY (`volo`,`posto`),
  ADD KEY `posto` (`posto`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `PrenotazioneAcquisto`
--
ALTER TABLE `PrenotazioneAcquisto`
  ADD CONSTRAINT `PrenotazioneAcquisto_ibfk_1` FOREIGN KEY (`prenotazione`) REFERENCES `Prenotazione` (`OID`),
  ADD CONSTRAINT `PrenotazioneAcquisto_ibfk_2` FOREIGN KEY (`acquisto`) REFERENCES `Acquisto` (`OID`);

--
-- Limiti per la tabella `PrenotazioneBiglietto`
--
ALTER TABLE `PrenotazioneBiglietto`
  ADD CONSTRAINT `PrenotazioneBiglietto_ibfk_1` FOREIGN KEY (`prenotazione`) REFERENCES `Prenotazione` (`OID`),
  ADD CONSTRAINT `PrenotazioneBiglietto_ibfk_2` FOREIGN KEY (`biglietto`) REFERENCES `Biglietto` (`OID`);

--
-- Limiti per la tabella `PrenotazioneCliente`
--
ALTER TABLE `PrenotazioneCliente`
  ADD CONSTRAINT `PrenotazioneCliente_ibfk_1` FOREIGN KEY (`prenotazione`) REFERENCES `Prenotazione` (`OID`),
  ADD CONSTRAINT `PrenotazioneCliente_ibfk_2` FOREIGN KEY (`cliente`) REFERENCES `Cliente` (`OID`);

--
-- Limiti per la tabella `PrenotazionePosto`
--
ALTER TABLE `PrenotazionePosto`
  ADD CONSTRAINT `PrenotazionePosto_ibfk_1` FOREIGN KEY (`prenotazione`) REFERENCES `Prenotazione` (`OID`),
  ADD CONSTRAINT `PrenotazionePosto_ibfk_2` FOREIGN KEY (`posto`) REFERENCES `Posto` (`OID`);

--
-- Limiti per la tabella `PrenotazioneVolo`
--
ALTER TABLE `PrenotazioneVolo`
  ADD CONSTRAINT `PrenotazioneVolo_ibfk_1` FOREIGN KEY (`prenotazione`) REFERENCES `Prenotazione` (`OID`),
  ADD CONSTRAINT `PrenotazioneVolo_ibfk_2` FOREIGN KEY (`volo`) REFERENCES `Volo` (`OID`);

--
-- Limiti per la tabella `VoloAeroporto`
--
ALTER TABLE `VoloAeroporto`
  ADD CONSTRAINT `VoloAeroporto_ibfk_1` FOREIGN KEY (`volo`) REFERENCES `Volo` (`OID`),
  ADD CONSTRAINT `VoloAeroporto_ibfk_2` FOREIGN KEY (`aeroportoPartenza`) REFERENCES `Aeroporto` (`OID`),
  ADD CONSTRAINT `VoloAeroporto_ibfk_3` FOREIGN KEY (`aeroportoDestinazione`) REFERENCES `Aeroporto` (`OID`);

--
-- Limiti per la tabella `VoloPosto`
--
ALTER TABLE `VoloPosto`
  ADD CONSTRAINT `VoloPosto_ibfk_1` FOREIGN KEY (`volo`) REFERENCES `Volo` (`OID`),
  ADD CONSTRAINT `VoloPosto_ibfk_2` FOREIGN KEY (`posto`) REFERENCES `Posto` (`OID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
