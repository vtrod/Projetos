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
-- Table structure for table `veiculos`
--

CREATE TABLE `veiculos` (
  `pkveiculo` int(10) UNSIGNED NOT NULL COMMENT 'PK da Tabela',
  `fktipoveiculo` smallint(6) UNSIGNED DEFAULT NULL COMMENT 'FK indicando o código do tipo de veiculo.',
  `fkfuncionario` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'FK indicando o código do funcionário.',
  `fkmodelo` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'FK indicando o código do modelo.',
  `fkcor` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'FK indicando o código da cor.',
  `ukplaca` char(7) NOT NULL COMMENT 'Placa do carro (somente letras e números)',
  `aotipo` char(1) NOT NULL COMMENT 'Indica se o veículo é C-Carro, O-ônibus ou N-Outro tipo',
  `txapelido` varchar(60) DEFAULT NULL COMMENT 'Nome de apelido do ônibus',
  `qtcapacidade` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'Quantidade de acentos no ônibus',
  `aostatus` char(1) DEFAULT NULL COMMENT 'Indica o status do veículo do Funcionário (P=Principal e S=Secundário).',
  `nuanofabricacao` year(4) NOT NULL COMMENT 'Ano de fabricação do carro',
  `dtcadveiculo` date NOT NULL COMMENT 'Data de geração do registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin COMMENT='veiculos';

--
-- Dumping data for table `veiculos`
--

INSERT INTO `veiculos` (`pkveiculo`, `fktipoveiculo`, `fkfuncionario`, `fkmodelo`, `fkcor`, `ukplaca`, `aotipo`, `txapelido`, `qtcapacidade`, `aostatus`, `nuanofabricacao`, `dtcadveiculo`) VALUES
(2, 1, 20, NULL, 2, 'GKKDA', 'O', 'Onibus', NULL, NULL, '2000', '2023-06-07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `veiculos`
--
ALTER TABLE `veiculos`
  ADD PRIMARY KEY (`pkveiculo`),
  ADD UNIQUE KEY `iukplaca` (`ukplaca`),
  ADD KEY `ifktipoveiculo` (`fktipoveiculo`),
  ADD KEY `ifkfuncionario` (`fkfuncionario`),
  ADD KEY `ifkmodelo` (`fkmodelo`),
  ADD KEY `ifkcor` (`fkcor`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `veiculos`
--
ALTER TABLE `veiculos`
  ADD CONSTRAINT `veiculosfk1` FOREIGN KEY (`fkcor`) REFERENCES `cores` (`pkcor`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `veiculosfk2` FOREIGN KEY (`fkfuncionario`) REFERENCES `funcionarios` (`pkfuncionario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `veiculosfk3` FOREIGN KEY (`fkmodelo`) REFERENCES `veiculosmodelos` (`pkmodelo`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `veiculosfk4` FOREIGN KEY (`fktipoveiculo`) REFERENCES `veiculostipos` (`pktipoveiculo`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
