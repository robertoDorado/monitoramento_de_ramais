-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 26-Maio-2021 às 19:22
-- Versão do servidor: 5.7.31
-- versão do PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `monitoramento_ramais`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `ramais`
--

DROP TABLE IF EXISTS `ramais`;
CREATE TABLE IF NOT EXISTS `ramais` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `ramal` varchar(100) NOT NULL,
  `operador` varchar(100) NOT NULL,
  `online_` tinyint(4) NOT NULL,
  `status_` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `ramais`
--

INSERT INTO `ramais` (`id`, `nome`, `ramal`, `operador`, `online_`, `status_`) VALUES
(1, '7000', '7000', 'Percy', 0, 'disponivel'),
(2, '7001', '7001', 'Cindy', 1, 'chamando'),
(3, '7004', '7002', 'Chapolin', 0, 'pausado'),
(4, '7003', '7003', 'Seubarriga', 0, 'indisponivel'),
(5, '7002', '7004', 'Mary', 1, 'indisponivel');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
