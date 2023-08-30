-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30-Ago-2023 às 23:31
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `allpet`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico`
--

CREATE TABLE `servico` (
  `nome_servico` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `id_servico` int(10) NOT NULL,
  `duracao_servico` int(11) NOT NULL,
  `fx_agenda_servico` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `freq_recomendada_servico` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `preco` float NOT NULL,
  `descricao_servico` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `servico`
--

INSERT INTO `servico` (`nome_servico`, `id_servico`, `duracao_servico`, `fx_agenda_servico`, `freq_recomendada_servico`, `preco`, `descricao_servico`) VALUES
('123213', 28, 12312321, '12321312', '123123', 123213000, '123123'),
('1', 29, 1, '1', '1', 1, '1'),
('12', 30, 12, '12', '12', 12, '12'),
('123', 31, 123, '123', '123', 123, '123'),
('1234', 32, 124, '124123', '12341234', 1232340000, '1231234');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `servico`
--
ALTER TABLE `servico`
  ADD PRIMARY KEY (`id_servico`) USING BTREE,
  ADD UNIQUE KEY `nome_servico` (`nome_servico`) USING BTREE;

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `servico`
--
ALTER TABLE `servico`
  MODIFY `id_servico` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
