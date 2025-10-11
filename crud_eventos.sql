-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/10/2025 às 04:53
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
-- Banco de dados: `crud_eventos`
--
CREATE DATABASE IF NOT EXISTS `crud_eventos` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `crud_eventos`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `bloqueiosalao`
--

DROP TABLE IF EXISTS `bloqueiosalao`;
CREATE TABLE IF NOT EXISTS `bloqueiosalao` (
  `id_bloqueio` int(11) NOT NULL AUTO_INCREMENT,
  `id_salao` int(11) NOT NULL,
  `inicio` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fim` timestamp NULL DEFAULT NULL,
  `motivo` text DEFAULT NULL,
  `tipo_bloqueio` enum('manutencao','reservado_exclusivo') NOT NULL,
  `criado_por` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_bloqueio`),
  KEY `id_salao` (`id_salao`),
  KEY `criado_por` (`criado_por`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoriaevento`
--

DROP TABLE IF EXISTS `categoriaevento`;
CREATE TABLE IF NOT EXISTS `categoriaevento` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  PRIMARY KEY (`id_categoria`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `elemento`
--

DROP TABLE IF EXISTS `elemento`;
CREATE TABLE IF NOT EXISTS `elemento` (
  `id_elemento` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_elemento` int(11) NOT NULL,
  `nome_elemento` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `unidade_medida` varchar(50) DEFAULT NULL,
  `preco_base` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_elemento`),
  KEY `id_tipo_elemento` (`id_tipo_elemento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `elementoopcao`
--

DROP TABLE IF EXISTS `elementoopcao`;
CREATE TABLE IF NOT EXISTS `elementoopcao` (
  `id_opcao` int(11) NOT NULL AUTO_INCREMENT,
  `id_elemento` int(11) NOT NULL,
  `nome_opcao` varchar(255) NOT NULL,
  `adicional_preco` decimal(10,2) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  PRIMARY KEY (`id_opcao`),
  KEY `id_elemento` (`id_elemento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `enderecosalao`
--

DROP TABLE IF EXISTS `enderecosalao`;
CREATE TABLE IF NOT EXISTS `enderecosalao` (
  `id_endereco_salao` int(11) NOT NULL AUTO_INCREMENT,
  `id_salao` int(11) NOT NULL,
  `logradouro` varchar(255) NOT NULL,
  `numero` varchar(50) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  PRIMARY KEY (`id_endereco_salao`),
  UNIQUE KEY `id_salao` (`id_salao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `enderecousuario`
--

DROP TABLE IF EXISTS `enderecousuario`;
CREATE TABLE IF NOT EXISTS `enderecousuario` (
  `id_endereco` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) NOT NULL,
  `logradouro` varchar(255) NOT NULL,
  `numero` varchar(50) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `tipo` enum('residencial','cobranca') NOT NULL,
  PRIMARY KEY (`id_endereco`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `logalteracaosalao`
--

DROP TABLE IF EXISTS `logalteracaosalao`;
CREATE TABLE IF NOT EXISTS `logalteracaosalao` (
  `id_log` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_salao` int(11) NOT NULL,
  `id_usuario` bigint(20) DEFAULT NULL,
  `campo_alterado` varchar(100) NOT NULL,
  `valor_antigo` text DEFAULT NULL,
  `valor_novo` text DEFAULT NULL,
  `data_alteracao` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo_operacao` varchar(50) NOT NULL,
  PRIMARY KEY (`id_log`),
  KEY `id_salao` (`id_salao`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `midiasalao`
--

DROP TABLE IF EXISTS `midiasalao`;
CREATE TABLE IF NOT EXISTS `midiasalao` (
  `id_midia` int(11) NOT NULL AUTO_INCREMENT,
  `id_salao` int(11) NOT NULL,
  `tipo` enum('imagem','video','planta') NOT NULL,
  `url_armazenamento` varchar(500) NOT NULL,
  `legenda` varchar(255) DEFAULT NULL,
  `principal` tinyint(1) NOT NULL,
  `ordem` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_midia`),
  KEY `id_salao` (`id_salao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamento`
--

DROP TABLE IF EXISTS `pagamento`;
CREATE TABLE IF NOT EXISTS `pagamento` (
  `id_pagamento` int(11) NOT NULL AUTO_INCREMENT,
  `id_reserva` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_pagamento` timestamp NOT NULL DEFAULT current_timestamp(),
  `metodo` enum('cartao','pix','boleto','transferencia') NOT NULL,
  `status_pagamento` varchar(50) NOT NULL,
  `transacao_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_pagamento`),
  UNIQUE KEY `transacao_id` (`transacao_id`),
  KEY `id_reserva` (`id_reserva`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `reserva`
--

DROP TABLE IF EXISTS `reserva`;
CREATE TABLE IF NOT EXISTS `reserva` (
  `id_reserva` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) NOT NULL,
  `id_salao` int(11) NOT NULL,
  `data_evento_inicio` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `data_evento_fim` timestamp NULL DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pendente','confirmada','cancelada','concluida') NOT NULL,
  `numero_participantes_est` int(11) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `forma_pagamento` varchar(100) DEFAULT NULL,
  `total_previsto` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`id_reserva`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_salao` (`id_salao`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `reserva`
--

INSERT INTO `reserva` (`id_reserva`, `id_usuario`, `id_salao`, `data_evento_inicio`, `data_evento_fim`, `data_criacao`, `status`, `numero_participantes_est`, `observacoes`, `forma_pagamento`, `total_previsto`) VALUES
(1, 1, 1, '2025-10-09 14:36:00', '2025-10-10 18:40:00', '2025-10-09 14:37:32', 'pendente', 5000, 'cachorro chines', NULL, 37800.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `reservacontato`
--

DROP TABLE IF EXISTS `reservacontato`;
CREATE TABLE IF NOT EXISTS `reservacontato` (
  `id_reserva_contato` int(11) NOT NULL AUTO_INCREMENT,
  `id_reserva` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_reserva_contato`),
  KEY `id_reserva` (`id_reserva`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `reservaelemento`
--

DROP TABLE IF EXISTS `reservaelemento`;
CREATE TABLE IF NOT EXISTS `reservaelemento` (
  `id_reserva` int(11) NOT NULL,
  `id_elemento` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `observacao` text DEFAULT NULL,
  `id_opcao_selecionada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_reserva`,`id_elemento`),
  KEY `id_elemento` (`id_elemento`),
  KEY `id_opcao_selecionada` (`id_opcao_selecionada`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `salao`
--

DROP TABLE IF EXISTS `salao`;
CREATE TABLE IF NOT EXISTS `salao` (
  `id_salao` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `capacidade_max` int(11) DEFAULT NULL,
  `area_m2` decimal(10,2) DEFAULT NULL,
  `endereco_id` int(11) DEFAULT NULL,
  `status` enum('ativo','manutencao','inativo') NOT NULL,
  `horario_abertura` time DEFAULT NULL,
  `horario_fechamento` time DEFAULT NULL,
  PRIMARY KEY (`id_salao`),
  KEY `FK_Salao_EnderecoSalao` (`endereco_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `salao`
--

INSERT INTO `salao` (`id_salao`, `nome`, `descricao`, `capacidade_max`, `area_m2`, `endereco_id`, `status`, `horario_abertura`, `horario_fechamento`) VALUES
(1, 'Salão Principal', 'Espaço amplo para grandes eventos', 300, NULL, NULL, 'ativo', NULL, NULL),
(2, 'Salão de Festas Kids', 'Espaço para festas infantis', 80, NULL, NULL, 'ativo', NULL, NULL),
(3, 'Salão VIP', 'Espaço exclusivo e reservado', 50, NULL, NULL, 'ativo', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `salaocategoria`
--

DROP TABLE IF EXISTS `salaocategoria`;
CREATE TABLE IF NOT EXISTS `salaocategoria` (
  `id_salao` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `apropriacao` varchar(100) DEFAULT NULL,
  `observacao` text DEFAULT NULL,
  PRIMARY KEY (`id_salao`,`id_categoria`),
  KEY `id_categoria` (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `salaoelemento`
--

DROP TABLE IF EXISTS `salaoelemento`;
CREATE TABLE IF NOT EXISTS `salaoelemento` (
  `id_salao` int(11) NOT NULL,
  `id_elemento` int(11) NOT NULL,
  `disponibilidade` tinyint(1) NOT NULL,
  `preco_salao` decimal(10,2) DEFAULT NULL,
  `configuracao` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`configuracao`)),
  `quantidade_max` int(11) DEFAULT NULL,
  `tempo_montagem_minutos` int(11) DEFAULT NULL,
  `observacao` text DEFAULT NULL,
  PRIMARY KEY (`id_salao`,`id_elemento`),
  KEY `id_elemento` (`id_elemento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `salaoelementoopcao`
--

DROP TABLE IF EXISTS `salaoelementoopcao`;
CREATE TABLE IF NOT EXISTS `salaoelementoopcao` (
  `id_salao` int(11) NOT NULL,
  `id_elemento` int(11) NOT NULL,
  `id_opcao` int(11) NOT NULL,
  `preco_local` decimal(10,2) DEFAULT NULL,
  `disponivel` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_salao`,`id_elemento`,`id_opcao`),
  KEY `id_opcao` (`id_opcao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `salaotelefone`
--

DROP TABLE IF EXISTS `salaotelefone`;
CREATE TABLE IF NOT EXISTS `salaotelefone` (
  `id_salao_telefone` int(11) NOT NULL AUTO_INCREMENT,
  `id_salao` int(11) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `tipo_telefone` varchar(50) DEFAULT NULL,
  `contato_nome` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_salao_telefone`),
  KEY `id_salao` (`id_salao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `telefoneusuario`
--

DROP TABLE IF EXISTS `telefoneusuario`;
CREATE TABLE IF NOT EXISTS `telefoneusuario` (
  `id_telefone` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `tipo_telefone` enum('residencial','comercial','celular') NOT NULL,
  `principal` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_telefone`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipoelemento`
--

DROP TABLE IF EXISTS `tipoelemento`;
CREATE TABLE IF NOT EXISTS `tipoelemento` (
  `id_tipo_elemento` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  PRIMARY KEY (`id_tipo_elemento`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `ativo` tinyint(1) NOT NULL,
  `senha` varchar(255) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome`, `data_criacao`, `ativo`, `senha`) VALUES
(1, 'daniel', '2025-10-09 14:37:32', 1, '1234'),
(2, 'mellissa ', '2025-10-09 15:13:04', 1, '1234'),
(3, 'daniel', '2025-10-09 15:27:47', 1, '1234'),
(4, 'mellissa ', '2025-10-10 15:38:33', 1, '1234'),
(5, 'daniel', '2025-10-10 17:09:34', 1, '1234'),
(6, 'daniel', '2025-10-10 20:06:25', 1, '1234'),
(7, 'Administrador', '2025-10-10 20:39:20', 1, '1234'),
(8, 'danielvictor', '2025-10-11 02:50:26', 1, '$2y$10$ClxbpZkF8OXls56iEl6xReOC1OeJ5HxrwfSDRDXALkIgcjJufSs.e');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuariofavoritosalao`
--

DROP TABLE IF EXISTS `usuariofavoritosalao`;
CREATE TABLE IF NOT EXISTS `usuariofavoritosalao` (
  `id_usuario` bigint(20) NOT NULL,
  `id_salao` int(11) NOT NULL,
  `data_favoritou` timestamp NOT NULL DEFAULT current_timestamp(),
  `nota_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`,`id_salao`),
  KEY `id_salao` (`id_salao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `bloqueiosalao`
--
ALTER TABLE `bloqueiosalao`
  ADD CONSTRAINT `bloqueiosalao_ibfk_1` FOREIGN KEY (`id_salao`) REFERENCES `salao` (`id_salao`),
  ADD CONSTRAINT `bloqueiosalao_ibfk_2` FOREIGN KEY (`criado_por`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `elemento`
--
ALTER TABLE `elemento`
  ADD CONSTRAINT `elemento_ibfk_1` FOREIGN KEY (`id_tipo_elemento`) REFERENCES `tipoelemento` (`id_tipo_elemento`);

--
-- Restrições para tabelas `elementoopcao`
--
ALTER TABLE `elementoopcao`
  ADD CONSTRAINT `elementoopcao_ibfk_1` FOREIGN KEY (`id_elemento`) REFERENCES `elemento` (`id_elemento`);

--
-- Restrições para tabelas `enderecosalao`
--
ALTER TABLE `enderecosalao`
  ADD CONSTRAINT `enderecosalao_ibfk_1` FOREIGN KEY (`id_salao`) REFERENCES `salao` (`id_salao`);

--
-- Restrições para tabelas `enderecousuario`
--
ALTER TABLE `enderecousuario`
  ADD CONSTRAINT `enderecousuario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `logalteracaosalao`
--
ALTER TABLE `logalteracaosalao`
  ADD CONSTRAINT `logalteracaosalao_ibfk_1` FOREIGN KEY (`id_salao`) REFERENCES `salao` (`id_salao`),
  ADD CONSTRAINT `logalteracaosalao_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `midiasalao`
--
ALTER TABLE `midiasalao`
  ADD CONSTRAINT `midiasalao_ibfk_1` FOREIGN KEY (`id_salao`) REFERENCES `salao` (`id_salao`);

--
-- Restrições para tabelas `pagamento`
--
ALTER TABLE `pagamento`
  ADD CONSTRAINT `pagamento_ibfk_1` FOREIGN KEY (`id_reserva`) REFERENCES `reserva` (`id_reserva`);

--
-- Restrições para tabelas `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`id_salao`) REFERENCES `salao` (`id_salao`);

--
-- Restrições para tabelas `reservacontato`
--
ALTER TABLE `reservacontato`
  ADD CONSTRAINT `reservacontato_ibfk_1` FOREIGN KEY (`id_reserva`) REFERENCES `reserva` (`id_reserva`);

--
-- Restrições para tabelas `reservaelemento`
--
ALTER TABLE `reservaelemento`
  ADD CONSTRAINT `reservaelemento_ibfk_1` FOREIGN KEY (`id_reserva`) REFERENCES `reserva` (`id_reserva`),
  ADD CONSTRAINT `reservaelemento_ibfk_2` FOREIGN KEY (`id_elemento`) REFERENCES `elemento` (`id_elemento`),
  ADD CONSTRAINT `reservaelemento_ibfk_3` FOREIGN KEY (`id_opcao_selecionada`) REFERENCES `elementoopcao` (`id_opcao`);

--
-- Restrições para tabelas `salao`
--
ALTER TABLE `salao`
  ADD CONSTRAINT `FK_Salao_EnderecoSalao` FOREIGN KEY (`endereco_id`) REFERENCES `enderecosalao` (`id_endereco_salao`);

--
-- Restrições para tabelas `salaocategoria`
--
ALTER TABLE `salaocategoria`
  ADD CONSTRAINT `salaocategoria_ibfk_1` FOREIGN KEY (`id_salao`) REFERENCES `salao` (`id_salao`),
  ADD CONSTRAINT `salaocategoria_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categoriaevento` (`id_categoria`);

--
-- Restrições para tabelas `salaoelemento`
--
ALTER TABLE `salaoelemento`
  ADD CONSTRAINT `salaoelemento_ibfk_1` FOREIGN KEY (`id_salao`) REFERENCES `salao` (`id_salao`),
  ADD CONSTRAINT `salaoelemento_ibfk_2` FOREIGN KEY (`id_elemento`) REFERENCES `elemento` (`id_elemento`);

--
-- Restrições para tabelas `salaoelementoopcao`
--
ALTER TABLE `salaoelementoopcao`
  ADD CONSTRAINT `salaoelementoopcao_ibfk_1` FOREIGN KEY (`id_salao`,`id_elemento`) REFERENCES `salaoelemento` (`id_salao`, `id_elemento`),
  ADD CONSTRAINT `salaoelementoopcao_ibfk_2` FOREIGN KEY (`id_opcao`) REFERENCES `elementoopcao` (`id_opcao`);

--
-- Restrições para tabelas `salaotelefone`
--
ALTER TABLE `salaotelefone`
  ADD CONSTRAINT `salaotelefone_ibfk_1` FOREIGN KEY (`id_salao`) REFERENCES `salao` (`id_salao`);

--
-- Restrições para tabelas `telefoneusuario`
--
ALTER TABLE `telefoneusuario`
  ADD CONSTRAINT `telefoneusuario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `usuariofavoritosalao`
--
ALTER TABLE `usuariofavoritosalao`
  ADD CONSTRAINT `usuariofavoritosalao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `usuariofavoritosalao_ibfk_2` FOREIGN KEY (`id_salao`) REFERENCES `salao` (`id_salao`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
