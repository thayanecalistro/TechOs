-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04/08/2026 às 01:19
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
(3, '', 1, '1231435462462462', '1'),
(6, '', 10, '87586754632', '2'),
(12, '', 12, '76567435735764', '8'),
(13, '', 11, '53673587537257253', '9');

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
(10, 'Lucas Berto', '31265479890', '', '299999999999', '44444444', 'Rua Via Coletora B', '123', '', 'Nossa Senhora das Graças', 'Santo Antônio de Jesus', 'BA'),
(11, 'ana luiza camargo', '98765432132', '', '479876543213', '44444444', 'Rua Via Coletora B', '654', 'apto 101', 'Nossa Senhora das Graças', 'Santo Antônio de Jesus', 'BA'),
(12, 'Vinicis Luz', '98765786745', '', '47976543234', '44444444', 'Rua Via Coletora B', '543', 'casa ', 'Nossa Senhora das Graças', 'Santo Antônio de Jesus', 'BA');

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

--
-- Despejando dados para a tabela `estoque`
--

INSERT INTO `estoque` (`idEstoque`, `NomeFornecedor`, `peca`, `valor`, `quantidade`, `total`) VALUES
(1, 'X3 Distribuidora', 'Bateria Xiaomi Mi 11 Lite (BP42) Deji', 75.00, 5, 300.00),
(2, 'X3 Distribuidora', 'Frontal Tela Display Samsung S23 Ultra S918 Com Aro Original', 1899.00, 4, 7596.00),
(3, 'X3 Distribuidora', 'Bateria Samsung A23 / M23 / M33 / M52 / M53 / A73 (M526) Original', 85.00, 4, 255.00),
(4, 'X3 Distribuidora', 'Cabo Samsung Tipo C para Tipo C (1 Metro) Original', 29.00, 15, 435.00),
(5, 'X3 Distribuidora', 'Frontal Tela Display Samsung A26 5G A266 Com Aro Original', 460.00, 3, 1380.00),
(6, 'Central Peças', 'Tela Display Lcd Frontal Iphone 17 Pro Oled WEKEEP CI', 830.00, 3, 2490.00),
(7, 'Central Peças', 'Bateria Iphone 15 Pro Modelo Vip', 125.00, 4, 500.00),
(8, 'Central Peças', 'Tela Display Lcd Samsung A10 A105 Incell', 48.00, 10, 480.00),
(9, 'Central Peças', 'Tela Display Lcd Samsung A12 Original Retirada', 105.00, 4, 420.00),
(10, 'Central Peças', 'Tela Display Lcd Motorola Moto G10 G20 G30 Xt2127 Xt2129 Com Aro', 58.00, 7, 406.00),
(11, 'Central Peças', 'Tela Display Lcd Xiaomi Redmi Note 8', 52.00, 6, 312.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `idFuncionario` int(11) NOT NULL COMMENT 'Chave primária de identificação do funcionário',
  `tipoFuncionario` varchar(50) DEFAULT NULL COMMENT 'Cargo, nível de acesso ou perfil do funcionário',
  `nomeFuncionario` varchar(150) NOT NULL COMMENT 'Nome completo do funcionário',
  `cpfFuncionario` varchar(20) DEFAULT NULL COMMENT 'CPF do funcionário',
  `telefoneFuncionario` int(20) NOT NULL,
  `emailFuncionario` varchar(150) DEFAULT NULL COMMENT 'E-mail para contato e comunicação interna',
  `cepFuncionario` int(11) NOT NULL,
  `enderecoFuncionario` varchar(255) DEFAULT NULL COMMENT 'Endereço residencial completo do funcionário',
  `numeroFuncionario` int(11) NOT NULL,
  `complementoFuncionario` varchar(50) NOT NULL,
  `bairroFuncionario` varchar(30) NOT NULL,
  `cidadeFuncionario` varchar(30) NOT NULL,
  `estadoFuncionario` varchar(30) NOT NULL,
  `login` varchar(100) DEFAULT NULL COMMENT 'Nome do usuário utilizado para autentificação no sistema',
  `senha` varchar(255) DEFAULT NULL COMMENT 'Senha de acesso criptografada do funcionário para login no sistema',
  `fotoFuncionario` varchar(225) DEFAULT NULL COMMENT 'Foto do funcionário'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionario`
--

INSERT INTO `funcionario` (`idFuncionario`, `tipoFuncionario`, `nomeFuncionario`, `cpfFuncionario`, `telefoneFuncionario`, `emailFuncionario`, `cepFuncionario`, `enderecoFuncionario`, `numeroFuncionario`, `complementoFuncionario`, `bairroFuncionario`, `cidadeFuncionario`, `estadoFuncionario`, `login`, `senha`, `fotoFuncionario`) VALUES
(4, 'Atendente', 'Maria Clara', '12345678990', 99437521, 'maria@gmail', 44444444, 'Rua Via Coletora B', 1343, 'Sobrado', 'Nossa Senhora das Graças', 'Santo Antônio de Jesus', 'BA', 'maria.clara', '202cb962ac59075b964b07152d234b70', 'func_6a6fde00b30b1.png'),
(6, 'Administrador', 'Nicolly Fernanda Aureliano Pereira', '05490056165', 99437521, 'nicolly@fernanda', 44444444, 'Rua Via Coletora B', 1343, 'Sobrado', 'Nossa Senhora das Graças', 'Santo Antônio de Jesus', 'BA', 'nicolly.pereira', '202cb962ac59075b964b07152d234b70', 'padrao.png'),
(7, 'Administrador', 'thayane', '12345678098', 2147483647, 'thyaane@teste.com', 44444444, 'Rua Via Coletora B', 678, 'casa', 'Nossa Senhora das Graças', 'Santo Antônio de Jesus', 'BA', 'thay.teste', '202cb962ac59075b964b07152d234b70', 'func_6a7115d4194d0.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `logs`
--

CREATE TABLE `logs` (
  `idLog` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `acao` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `dataHora` datetime DEFAULT current_timestamp(),
  `ip` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `logs`
--

INSERT INTO `logs` (`idLog`, `usuario`, `acao`, `descricao`, `dataHora`, `ip`) VALUES
(1, 'Sistema', 'Novo Aparelho', 'Cadastrou o aparelho IMEI: 76567435735764', '2026-08-03 20:09:07', '::1'),
(2, 'Sistema', 'Exclusão de Aparelho', 'Excluiu o aparelho ID: #7', '2026-08-03 20:09:10', '::1'),
(3, 'Sistema', 'Novo Aparelho', 'Cadastrou o aparelho IMEI: 53673587537257253', '2026-08-03 20:10:05', '::1');

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
(2, '16', 2),
(3, 'S23', 1),
(4, '14', 2),
(5, 'Galaxy A15', 1),
(6, 'modelo', 1),
(7, 'Galaxy S26', 2),
(8, 'A12', 1),
(9, 'Moto G10', 4);

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

--
-- Despejando dados para a tabela `orcamento`
--

INSERT INTO `orcamento` (`idOrcamento`, `diagnostico`, `peca`, `valorUni`, `maoObra`, `valorTotal`, `status`, `OS_idOS`, `Cliente_idCliente`, `Aparelho_idAparelho`, `dataOrcamento`) VALUES
(3, 'trocar tela e bateria', 'Múltiplas Peças', 1984.00, 50.00, 2034.00, 'aberto', NULL, 1, 3, '2026-08-03 20:17:57'),
(4, 'trocar tela', 'Tela Display Lcd Motorola Moto G10 G20 G30 Xt2127 Xt2129 Com Aro', 58.00, 50.00, 108.00, 'aberto', NULL, 11, 13, '2026-08-03 20:18:20'),
(5, 'tela com defeito no display', 'Tela Display Lcd Frontal Iphone 17 Pro Oled WEKEEP CI', 830.00, 50.00, 880.00, 'aberto', NULL, 10, 6, '2026-08-03 20:19:06');

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

--
-- Despejando dados para a tabela `orcamento_peca`
--

INSERT INTO `orcamento_peca` (`idOrcamentoPeca`, `Orcamento_idOrcamento`, `Estoque_idEstoque`, `peca`, `quantidade`, `valorUnitario`, `total`) VALUES
(2, 3, 2, 'Frontal Tela Display Samsung S23 Ultra S918 Com Aro Original', 1, 1899.00, 1899.00),
(3, 3, 3, 'Bateria Samsung A23 / M23 / M33 / M52 / M53 / A73 (M526) Original', 1, 85.00, 85.00),
(4, 4, 10, 'Tela Display Lcd Motorola Moto G10 G20 G30 Xt2127 Xt2129 Com Aro', 1, 58.00, 58.00),
(5, 5, 6, 'Tela Display Lcd Frontal Iphone 17 Pro Oled WEKEEP CI', 1, 830.00, 830.00);

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
-- Índices de tabela `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`idLog`);

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
  MODIFY `idAparelho` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Número identificador do aparelho dentro do sistema', AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Número de identificação do cliente', AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `idEstoque` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária de identificaçãodo registro de estoque', AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `idFuncionario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária de identificação do funcionário', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `logs`
--
ALTER TABLE `logs`
  MODIFY `idLog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `marca`
--
ALTER TABLE `marca`
  MODIFY `idMarca` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária de identificação da marca', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `modelo`
--
ALTER TABLE `modelo`
  MODIFY `idModelo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária de identificação do modelo do aparelho', AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `orcamento`
--
ALTER TABLE `orcamento`
  MODIFY `idOrcamento` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária de identificação do orçamento', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `orcamento_peca`
--
ALTER TABLE `orcamento_peca`
  MODIFY `idOrcamentoPeca` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária de identificação do item do orçamento', AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
