-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tempo de Geração: Set 22, 2017 as 01:24 PM
-- Versão do Servidor: 5.1.45
-- Versão do PHP: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
 
--
-- Banco de Dados: `agenda`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `contatos`
--

CREATE TABLE IF NOT EXISTS `contatos` (
  `con_cod` int(10) NOT NULL AUTO_INCREMENT,
  `con_nome` varchar(80) DEFAULT NULL,
  `con_apelido` varchar(100) NOT NULL,
  `con_email` varchar(100) NOT NULL,
  `con_end_rua` varchar(120) DEFAULT NULL,
  `con_end_complemento` varchar(100) DEFAULT NULL,
  `con_end_bairro` varchar(80) DEFAULT NULL,
  `con_end_cidade` varchar(50) DEFAULT NULL,
  `con_end_estado` varchar(2) DEFAULT NULL,
  `con_end_cep` varchar(20) DEFAULT NULL,
  `con_ativo` tinyint(1) unsigned DEFAULT '1',
  `con_data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `con_observacao` varchar(255) DEFAULT NULL,
  `con_data_nascimento` date DEFAULT '0000-00-00' COMMENT 'data de nascimento',
  PRIMARY KEY (`con_cod`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=109 ;

--
-- Extraindo dados da tabela `contatos`
--

INSERT INTO `contatos` (`con_cod`, `con_nome`, `con_apelido`, `con_email`, `con_end_rua`, `con_end_complemento`, `con_end_bairro`, `con_end_cidade`, `con_end_estado`, `con_end_cep`, `con_ativo`, `con_data_cadastro`, `con_observacao`, `con_data_nascimento`) VALUES
(107, 'Fernando Basilio', 'Nando', 'fer@bol.com', 'Rua Francisco Toczek, 300', 'Bloco 1 B Ap 401', 'Afonso Pena', 'São José Dos Pinhais', 'PR', '83045100', 1, '2017-09-21 14:10:57', 'Teste de Gravação.', '1980-05-28'),
(108, 'Ciclano', 'Ciclo', 'ciclo@bol.com', 'Rua Waldemar Kost, 200', 'Esquina', 'Hauer', 'Curitiba', 'SC', '81630180', 1, '2017-09-21 16:51:59', 'Segundo.', '1998-04-30');

-- --------------------------------------------------------

--
-- Estrutura da tabela `telefones`
--

CREATE TABLE IF NOT EXISTS `telefones` (
  `tel_cod` int(10) NOT NULL AUTO_INCREMENT,
  `con_cod` int(10) NOT NULL,
  `tel_pais` varchar(3) DEFAULT '+55',
  `tel_ddd` varchar(3) DEFAULT NULL,
  `tel_numero` varchar(20) DEFAULT NULL,
  `tel_tipo` tinyint(1) DEFAULT '1' COMMENT 'Tipo de telefone',
  PRIMARY KEY (`tel_cod`),
  KEY `con_cod` (`con_cod`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Extraindo dados da tabela `telefones`
--

INSERT INTO `telefones` (`tel_cod`, `con_cod`, `tel_pais`, `tel_ddd`, `tel_numero`, `tel_tipo`) VALUES
(10, 107, '+55', '41', '3147-0009', 1),
(18, 107, '+55', '41', '996-267-615', 2),
(19, 108, '+55', '41', '3222-2665', 1),
(20, 108, '+55', '45', '988-778-876', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `usr_cod` int(11) NOT NULL AUTO_INCREMENT,
  `usr_nivel` tinyint(4) NOT NULL,
  `usr_nome` varchar(45) NOT NULL,
  `usr_login` varchar(20) DEFAULT NULL,
  `usr_password` varchar(32) DEFAULT NULL,
  `usr_ativo` tinyint(1) NOT NULL COMMENT 'Define se o usuário esta ativo no sistema',
  `usr_email` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`usr_cod`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=104 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`usr_cod`, `usr_nivel`, `usr_nome`, `usr_login`, `usr_password`, `usr_ativo`, `usr_email`) VALUES
(100, 2, 'Fernando Basilio', 'nandobas', 'e8d95a51f3af4a3b134bf6bb680a213a', 1, 'fernando.basilio@gmail.com'),
(101, 2, 'Administrador', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 'admin@gmail.com');

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `telefones`
--
ALTER TABLE `telefones`
  ADD CONSTRAINT `contato_telefone_fk` FOREIGN KEY (`con_cod`) REFERENCES `contatos` (`con_cod`) ON DELETE CASCADE ON UPDATE CASCADE;
