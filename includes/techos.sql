-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/07/2026 às 03:06
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
-- Estrutura para tabela `aparelho`
--

CREATE TABLE `aparelho` (
  `idAparelho` int(11) NOT NULL COMMENT 'Número identificador do aparelho dentro do sistema',
  `historicoAparelho` varchar(500) NOT NULL COMMENT 'histórico do aparelho',
  `Cliente_idCliente` int(11) NOT NULL COMMENT 'identificador do cliente cadastrado com esse aparelho',
  `imeiAparelho` varchar(50) NOT NULL COMMENT 'número do identificador do aparelho',
  `Modelo_idModelo` varchar(25) NOT NULL COMMENT 'identificador do modelo cadastrado deste aparelho'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aparelho`
--

INSERT INTO `aparelho` (`idAparelho`, `historicoAparelho`, `Cliente_idCliente`, `imeiAparelho`, `Modelo_idModelo`) VALUES
(1, 'tela quebrada 3 vezes. peça original', 2, '987654321234567', 'S26'),
(2, '', 3, '1231435462462462', '2');

-- --------------------------------------------------------

--
-- Estrutura para tabela `atividade`
--

CREATE TABLE `atividade` (
  `idAtividade` int(11) NOT NULL COMMENT 'chave primária de identificação da atividade',
  `observacaoAtividade` varchar(1000) DEFAULT NULL COMMENT 'Detalhes, descrição ou observações gerais sobre a atividade realizada.',
  `dataAtividade` date DEFAULT NULL COMMENT 'Data em que a atividade foi ou será realizada',
  `horaAtividade` time DEFAULT NULL COMMENT 'Horário de registro da atividade',
  `OS_idOS` int(11) NOT NULL COMMENT 'Chave estrangeira. Vincula esta atividade a uma Ordem de Serviço'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `idCliente` int(11) NOT NULL COMMENT 'Número de identificação do cliente',
  `nomeCliente` varchar(150) NOT NULL COMMENT 'Nome do cliente que será cadastrado ',
  `cpfCliente` varchar(15) NOT NULL COMMENT 'CPF completo do cliente',
  `emailCliente` varchar(150) NOT NULL COMMENT 'Endereço de email principal para contato e notificações',
  `telefoneCliente` varchar(20) NOT NULL COMMENT 'O número para contato com o cliente',
  `cepCliente` varchar(10) NOT NULL COMMENT 'O CEP para identificar o endereço do cliente',
  `enderecoCliente` varchar(30) NOT NULL COMMENT 'O nome da rua em que mora',
  `numeroCliente` varchar(20) NOT NULL COMMENT 'Número da residência',
  `complementoCliente` varchar(50) NOT NULL COMMENT 'O complemento opcional para identificar onde o cliente mora',
  `bairroCliente` varchar(40) NOT NULL COMMENT 'O bome do Bairro do cliente',
  `cidadeCliente` varchar(30) NOT NULL COMMENT 'O nome da cidade em que reside',
  `estadoCliente` varchar(30) NOT NULL COMMENT 'O nome do Estado em que mora'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`idCliente`, `nomeCliente`, `cpfCliente`, `emailCliente`, `telefoneCliente`, `cepCliente`, `enderecoCliente`, `numeroCliente`, `complementoCliente`, `bairroCliente`, `cidadeCliente`, `estadoCliente`) VALUES
(1, 'Nicolly Fernanda', '09657885454', '', '999999999', '77777777', 'Rua jacupiranga', '1343', 'Sobrado', 'Aventureiro', 'Joinville', 'Santa catarina'),
(2, 'Nicolly Fernanda Aureliano Pereira', '054900', '', '999437521', '054289', 'Rua jacupiranga', '55555555', 'sobrado', 'Morro do meio', 'Itajaí', 'SC'),
(3, 'Dérik Patrik ', '1444521', '', '1548789', '159458', 'Rua Marilnada', '1254', 'De frente ao posto', 'Aventureiro', 'Joinville', 'SC'),
(8, '', '', '', '', '', '', '', '', '', '', ''),
(9, '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `estoque`
--

CREATE TABLE `estoque` (
  `idEstoque` int(11) NOT NULL COMMENT 'Chave primária de identificaçãodo registro de estoque',
  `NomeFornecedor` varchar(100) DEFAULT NULL COMMENT 'Nome da empresa ou pessoa que forneceu a peça',
  `peca` varchar(100) DEFAULT NULL COMMENT 'Nome, descrição ou modelo do produto armazenado',
  `valor` decimal(10,2) NOT NULL COMMENT 'Valor unitário do produto',
  `quantidade` int(11) NOT NULL COMMENT 'Quantidade de itens disponíveis em estoque',
  `total` decimal(10,2) DEFAULT NULL COMMENT 'valor total acumulado(cauculado  multiplicando valor unitário por quantidade)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `idFuncionario` int(11) NOT NULL COMMENT 'Chave primária de identificação do funcionário',
  `tipoFuncionario` varchar(50) DEFAULT NULL COMMENT 'Cargo, nível de acesso ou perfil do funcionário',
  `nomeFuncionario` varchar(150) NOT NULL COMMENT 'Nome completo do funcionário',
  `cpfFuncionario` varchar(20) DEFAULT NULL COMMENT 'CPF do funcionário',
  `emailFuncionario` varchar(150) DEFAULT NULL COMMENT 'E-mail para contato e comunicação interna',
  `telefoneFuncionario` varchar(30) DEFAULT NULL COMMENT 'Telefone ou celular de contato do funcionário',
  `enderecoFuncionario` varchar(255) DEFAULT NULL COMMENT 'Endereço residencial completo do funcionário',
  `login` varchar(100) DEFAULT NULL COMMENT 'Nome do usuário utilizado para autentificação no sistema',
  `senha` varchar(255) DEFAULT NULL COMMENT 'Senha de acesso criptografada do funcionário para login no sistema',
  `foto` varchar(120) DEFAULT NULL COMMENT 'Foto do funcionário'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionario`
--

INSERT INTO `funcionario` (`idFuncionario`, `tipoFuncionario`, `nomeFuncionario`, `cpfFuncionario`, `emailFuncionario`, `telefoneFuncionario`, `enderecoFuncionario`, `login`, `senha`, `foto`) VALUES
(1, '1', 'Nicolly Fernanda', '05490056165', 'Nico@gmail ', '37999567564', 'Rua jacupiranga', 'nicolly.pereira', '123', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `gastos`
--

CREATE TABLE `gastos` (
  `idGastos` int(11) NOT NULL COMMENT 'Chave primária de identificação do gasto',
  `descricaoGastos` varchar(500) DEFAULT NULL COMMENT 'Detalhes ou descrição do que foi comprado ou pago com este recurso',
  `valorGastos` decimal(10,2) NOT NULL COMMENT 'Valor monetário total da despesa',
  `dataGastos` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Data e hora em que a despesa foi registrada ou realizada',
  `Orcamento_idOrcamento` int(11) DEFAULT NULL COMMENT 'Chave estrangeira. Vincula este gasto a um Orçamento especifico'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `marca`
--

CREATE TABLE `marca` (
  `idMarca` int(11) NOT NULL COMMENT 'Chave primária de identificação da marca',
  `nomeMarca` varchar(100) NOT NULL COMMENT 'Marca do produto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `marca`
--

INSERT INTO `marca` (`idMarca`, `nomeMarca`) VALUES
(1, 'Samsung'),
(2, 'Apple'),
(3, 'Xiaomi'),
(4, 'Motorola'),
(5, 'LG'),
(6, 'Asus'),
(7, 'Realme');

-- --------------------------------------------------------

--
-- Estrutura para tabela `modelo`
--

CREATE TABLE `modelo` (
  `idModelo` int(11) NOT NULL COMMENT 'Chave primária de identificação do modelo do aparelho',
  `nomeModelo` varchar(100) NOT NULL COMMENT 'nome do modelo do aparelho',
  `Marca_idMarca` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `modelo`
--

INSERT INTO `modelo` (`idModelo`, `nomeModelo`, `Marca_idMarca`) VALUES
(1, 'Galaxy S26', 1),
(2, '16', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `orcamento`
--

CREATE TABLE `orcamento` (
  `idOrcamento` int(11) NOT NULL COMMENT 'Chave primária de identificação do orçamento',
  `diagnostico` varchar(255) DEFAULT NULL COMMENT 'Avaliação técnica inicial, defeito constatado ou parecer profissional sobre o problema',
  `peca` varchar(255) DEFAULT NULL COMMENT 'Descrição das peças principais necessárias',
  `valorUni` decimal(10,2) DEFAULT 0.00 COMMENT 'Valor unitário associado(subtotal das peças)',
  `maoObra` decimal(10,2) DEFAULT 0.00 COMMENT 'Valor cobrado pelo serviço',
  `valorTotal` decimal(10,2) DEFAULT 0.00 COMMENT 'Valor total do orçamento',
  `status` varchar(50) DEFAULT 'aberto' COMMENT 'Situação atual do orçamento(aberto,aprovado, reprovado, finalizado).',
  `OS_idOS` int(11) DEFAULT NULL COMMENT 'Chave estrangeira.Vincula este orçamento à Ordem de Serviço correspondente, se houver.',
  `Cliente_idCliente` int(11) NOT NULL COMMENT 'Chave estrangeira. Identifica o cliente que solicitou o orçamento',
  `Aparelho_idAparelho` int(11) NOT NULL COMMENT 'Chave estrangeira. Vincula o orçamento ao aparelho que passará pelo serviço',
  `dataOrcamento` datetime DEFAULT current_timestamp() COMMENT 'Data e hora de criação ou registro do orçamento no sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `orcamento_peca`
--

CREATE TABLE `orcamento_peca` (
  `idOrcamentoPeca` int(11) NOT NULL COMMENT 'Chave primária de identificação do item do orçamento',
  `Orcamento_idOrcamento` int(11) NOT NULL COMMENT 'Chave estrangeira. Vincula este item ao Orçamento principal correspondente',
  `Estoque_idEstoque` int(11) NOT NULL COMMENT 'Chave estrangeira. Vincula este item à peça cadastrada no Estoque',
  `peca` varchar(100) DEFAULT NULL COMMENT 'Nome ou descrição da peça utilizada',
  `quantidade` int(11) NOT NULL DEFAULT 1 COMMENT 'Quantidade de peça que foi incluída neste orçamento específico',
  `valorUnitario` decimal(10,2) NOT NULL COMMENT 'Preço de uma unidade da peça no momento da criação do orçamento',
  `total` decimal(10,2) NOT NULL COMMENT 'Valor total deste item(multiplicação da quantidade pelo valor unitário)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `os`
--

CREATE TABLE `os` (
  `idOS` int(11) NOT NULL COMMENT 'Chave primária de identificação da Ordem de Serviço',
  `aberturaOS` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Data e hora em que a Ordem de Serviço foi aberta',
  `fechamentoOS` datetime DEFAULT NULL COMMENT 'Data e hora em que o serviço foi finalizado e a OS foi encerrada',
  `descricaoOS` varchar(500) DEFAULT NULL COMMENT 'Relato detalhado informado pleo cliente da situaçção do equipamento',
  `servicoOS` varchar(255) DEFAULT NULL COMMENT 'Nome, tipo ou resumo do serviço principal que será executado.',
  `valorOS` decimal(10,2) DEFAULT 0.00 COMMENT 'Valor financeiro total cobrado pela execução desta Ordem de Serviço',
  `observacoesOS` varchar(500) DEFAULT NULL COMMENT 'Notas adicionais sobre o andamento do serviço',
  `status` varchar(50) DEFAULT 'aberto' COMMENT 'Situação atual da OS',
  `Aparelho_idAparelho` int(11) NOT NULL COMMENT 'Chave estrangeira. Vincula a OS ao aparelho que receberá a manutenção',
  `Funcionario_idFuncionario` int(11) DEFAULT NULL COMMENT 'Chave estrangeira. Identifica o funcionário responsável por executar o serviço',
  `Cliente_idCliente` int(11) NOT NULL COMMENT 'Chave estrangeira. Identifica o cliente que solicitou a Ordem de Serviço'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `aparelho`
--
ALTER TABLE `aparelho`
  ADD PRIMARY KEY (`idAparelho`);

--
-- Índices de tabela `atividade`
--
ALTER TABLE `atividade`
  ADD PRIMARY KEY (`idAtividade`),
  ADD KEY `idx_Atividade_OS` (`OS_idOS`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idCliente`);

--
-- Índices de tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`idEstoque`);

--
-- Índices de tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`idFuncionario`);

--
-- Índices de tabela `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`idGastos`),
  ADD KEY `idx_Gastos_Orcamento` (`Orcamento_idOrcamento`);

--
-- Índices de tabela `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`idMarca`);

--
-- Índices de tabela `modelo`
--
ALTER TABLE `modelo`
  ADD PRIMARY KEY (`idModelo`);

--
-- Índices de tabela `orcamento`
--
ALTER TABLE `orcamento`
  ADD PRIMARY KEY (`idOrcamento`),
  ADD KEY `idx_Orcamento_OS` (`OS_idOS`),
  ADD KEY `idx_Orcamento_Cliente` (`Cliente_idCliente`),
  ADD KEY `idx_Orcamento_Aparelho` (`Aparelho_idAparelho`);

--
-- Índices de tabela `orcamento_peca`
--
ALTER TABLE `orcamento_peca`
  ADD PRIMARY KEY (`idOrcamentoPeca`),
  ADD KEY `idx_OP_Orcamento` (`Orcamento_idOrcamento`),
  ADD KEY `idx_OP_Estoque` (`Estoque_idEstoque`);

--
-- Índices de tabela `os`
--
ALTER TABLE `os`
  ADD PRIMARY KEY (`idOS`),
  ADD KEY `idx_OS_Aparelho` (`Aparelho_idAparelho`),
  ADD KEY `idx_OS_Funcionario` (`Funcionario_idFuncionario`),
  ADD KEY `idx_OS_Cliente` (`Cliente_idCliente`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aparelho`
--
ALTER TABLE `aparelho`
  MODIFY `idAparelho` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Número identificador do aparelho dentro do sistema', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `atividade`
--
ALTER TABLE `atividade`
  MODIFY `idAtividade` int(11) NOT NULL AUTO_INCREMENT COMMENT 'chave primária de identificação da atividade';

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Número de identificação do cliente', AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `idEstoque` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária de identificaçãodo registro de estoque';

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `idFuncionario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária de identificação do funcionário', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `gastos`
--
ALTER TABLE `gastos`
  MODIFY `idGastos` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária de identificação do gasto';

--
-- AUTO_INCREMENT de tabela `marca`
--
ALTER TABLE `marca`
  MODIFY `idMarca` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária de identificação da marca', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `modelo`
--
ALTER TABLE `modelo`
  MODIFY `idModelo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária de identificação do modelo do aparelho', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `orcamento`
--
ALTER TABLE `orcamento`
  MODIFY `idOrcamento` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária de identificação do orçamento';

--
-- AUTO_INCREMENT de tabela `orcamento_peca`
--
ALTER TABLE `orcamento_peca`
  MODIFY `idOrcamentoPeca` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária de identificação do item do orçamento';

--
-- AUTO_INCREMENT de tabela `os`
--
ALTER TABLE `os`
  MODIFY `idOS` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária de identificação da Ordem de Serviço';

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `atividade`
--
ALTER TABLE `atividade`
  ADD CONSTRAINT `fk_Atividade_OS` FOREIGN KEY (`OS_idOS`) REFERENCES `os` (`idOS`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `gastos`
--
ALTER TABLE `gastos`
  ADD CONSTRAINT `fk_Gastos_Orcamento` FOREIGN KEY (`Orcamento_idOrcamento`) REFERENCES `orcamento` (`idOrcamento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `orcamento_peca`
--
ALTER TABLE `orcamento_peca`
  ADD CONSTRAINT `fk_OP_Estoque` FOREIGN KEY (`Estoque_idEstoque`) REFERENCES `estoque` (`idEstoque`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_OP_Orcamento` FOREIGN KEY (`Orcamento_idOrcamento`) REFERENCES `orcamento` (`idOrcamento`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
