-- Adminer 4.8.1 MySQL 5.5.5-10.5.23-MariaDB-1:10.5.23+maria~ubu2004 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `db_techb`;
CREATE DATABASE `db_techb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `db_techb`;

DROP TABLE IF EXISTS `tb_foto`;
CREATE TABLE `tb_foto` (
  `id_foto` int(11) NOT NULL AUTO_INCREMENT,
  `id_jogo` int(11) NOT NULL,
  `arquivo_foto` varchar(100) NOT NULL,
  PRIMARY KEY (`id_foto`),
  KEY `id_jogo` (`id_jogo`),
  CONSTRAINT `tb_foto_ibfk_1` FOREIGN KEY (`id_jogo`) REFERENCES `tb_jogo` (`id_jogo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `tb_jogo`;
CREATE TABLE `tb_jogo` (
  `id_jogo` int(11) NOT NULL AUTO_INCREMENT,
  `preco_jogo` int(11) NOT NULL,
  `desconto` float NOT NULL,
  `titulo_jogo` varchar(30) NOT NULL,
  `capa_jogo` varchar(100) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data_lancamento` date NOT NULL,
  `genero` varchar(30) NOT NULL,
  `descricao` varchar(6000) NOT NULL,
  PRIMARY KEY (`id_jogo`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `tb_jogo_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`Id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `tb_usuario`;
CREATE TABLE `tb_usuario` (
  `Id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `idade_usuario` int(11) NOT NULL,
  `nome_usuario` varchar(30) NOT NULL,
  `senha_usuario` varchar(30) NOT NULL,
  `email_usuario` varchar(30) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `tipo` char(1) NOT NULL,
  PRIMARY KEY (`Id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `tb_venda`;
CREATE TABLE `tb_venda` (
  `id_venda` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_jogo` int(11) NOT NULL,
  `data_compra` date NOT NULL,
  PRIMARY KEY (`id_venda`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_jogo` (`id_jogo`),
  CONSTRAINT `tb_venda_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`Id_usuario`),
  CONSTRAINT `tb_venda_ibfk_2` FOREIGN KEY (`id_jogo`) REFERENCES `tb_jogo` (`id_jogo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- 2024-06-18 13:07:14
