-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01/07/2026 às 02:42
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `techos`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `modelo`
--

CREATE TABLE `modelo` (
  `idModelo` int(11) NOT NULL COMMENT 'Chave primária de identificação do modelo do aparelho',
  `nomeModelo` varchar(100) NOT NULL COMMENT 'nome do modelo do aparelho'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `modelo`
--

INSERT INTO `modelo` (`idModelo`, `nomeModelo`) VALUES
(1, '16 pro max');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `modelo`
--
ALTER TABLE `modelo`
  ADD PRIMARY KEY (`idModelo`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `modelo`
--
ALTER TABLE `modelo`
  MODIFY `idModelo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária de identificação do modelo do aparelho', AUTO_INCREMENT=2;
COMMIT;

-- 1. Primeiro, cria um índice para a coluna na tabela aparelho (melhora o desempenho)
ALTER TABLE `aparelho`
  ADD KEY `idx_Aparelho_Modelo` (`Modelo_idModelo`);

-- 2. Depois, cria o vínculo oficial (Chave Estrangeira) entre aparelho e modelo
ALTER TABLE `aparelho`
  ADD CONSTRAINT `fk_Aparelho_Modelo` 
  FOREIGN KEY (`Modelo_idModelo`) REFERENCES `modelo` (`idModelo`) 
  ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
