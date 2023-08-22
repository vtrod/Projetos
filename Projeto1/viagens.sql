-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 05, 2023 at 01:42 AM
-- Server version: 10.11.3-MariaDB-1
-- PHP Version: 8.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ilp540`
--

-- --------------------------------------------------------

--
-- Table structure for table `viagens`
--

CREATE TABLE `viagens` (
  `pkviagem` smallint(5) UNSIGNED NOT NULL COMMENT 'PK da Tabela',
  `fkonibus` int(10) UNSIGNED DEFAULT NULL COMMENT 'FK com o código do ônibus que realiza a Viagem.',
  `fkrota` mediumint(8) UNSIGNED DEFAULT NULL COMMENT 'FK com o código da rota viária da viagem.',
  `dtviagem` date NOT NULL COMMENT 'Data de realização da viagem',
  `hrsaida` time NOT NULL COMMENT 'Hora de saída da viagem',
  `dtcadviagem` date NOT NULL COMMENT 'Data de geração do registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin COMMENT='viagensx';

--
-- Dumping data for table `viagens`
--

INSERT INTO `viagens` (`pkviagem`, `fkonibus`, `fkrota`, `dtviagem`, `hrsaida`, `dtcadviagem`) VALUES
(3, 2, NULL, '2023-06-20', '19:15:47', '2023-06-06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `viagens`
--
ALTER TABLE `viagens`
  ADD PRIMARY KEY (`pkviagem`),
  ADD KEY `ifkrota` (`fkrota`),
  ADD KEY `ifkonibus` (`fkonibus`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `viagens`
--
ALTER TABLE `viagens`
  ADD CONSTRAINT `viagensfk1` FOREIGN KEY (`fkonibus`) REFERENCES `veiculos` (`pkveiculo`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `viagensfk2` FOREIGN KEY (`fkrota`) REFERENCES `rotasviarias` (`pkrota`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
