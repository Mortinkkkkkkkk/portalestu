-- Adminer 4.8.1 MySQL 5.5.5-10.5.23-MariaDB-1:10.5.23+maria~ubu2004 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `bd_estudantil`;
CREATE DATABASE `bd_estudantil` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `bd_estudantil`;

DROP TABLE IF EXISTS `tb_comentario`;
CREATE TABLE `tb_comentario` (
  `id_comentario` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) NOT NULL,
  `resposta_id` int(11) DEFAULT NULL,
  `comentario` varchar(1000) NOT NULL,
  PRIMARY KEY (`id_comentario`),
  KEY `id_post` (`id_post`),
  CONSTRAINT `tb_comentario_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `tb_post` (`id_post`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `tb_filtro`;
CREATE TABLE `tb_filtro` (
  `id_filtro` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `filtro` enum('linguagem,matematica') NOT NULL,
  PRIMARY KEY (`id_filtro`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `tb_filtro_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `tb_midia`;
CREATE TABLE `tb_midia` (
  `id_midia` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) NOT NULL,
  `midia` varchar(1000) NOT NULL,
  PRIMARY KEY (`id_midia`),
  KEY `id_post` (`id_post`),
  CONSTRAINT `tb_midia_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `tb_post` (`id_post`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `tb_post`;
CREATE TABLE `tb_post` (
  `id_post` int(11) NOT NULL AUTO_INCREMENT,
  `legenda` varchar(1000) NOT NULL,
  `curtida` int(11) NOT NULL,
  `data_postagem` date NOT NULL,
  `filtro` enum('liguagem,matematica') NOT NULL,
  PRIMARY KEY (`id_post`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `tb_usuario`;
CREATE TABLE `tb_usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(30) NOT NULL,
  `senha_usuario` varchar(30) NOT NULL,
  `email_usuario` varchar(30) NOT NULL,
  `certificado` varchar(100) DEFAULT NULL,
  `tipo` varchar(1) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- 2024-07-01 10:56:51
