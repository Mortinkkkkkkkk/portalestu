-- Adminer 4.8.1 MySQL 5.5.5-10.5.24-MariaDB-1:10.5.24+maria~ubu2004 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `bd_estudatil`;
CREATE DATABASE `bd_estudatil` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `bd_estudatil`;

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

INSERT INTO `tb_comentario` (`id_comentario`, `id_post`, `resposta_id`, `comentario`) VALUES
(1,	1,	NULL,	'testettetete'),
(2,	1,	NULL,	'tetststste'),
(3,	1,	NULL,	'omaga'),
(4,	1,	NULL,	'omg'),
(5,	2,	NULL,	''),
(6,	1,	1,	'resposta'),
(7,	10,	NULL,	'ttt');

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

INSERT INTO `tb_midia` (`id_midia`, `id_post`, `midia`) VALUES
(6,	1,	'matematica.jpeg'),
(7,	2,	'quimic.jpeg'),
(8,	3,	'redacao.jpeg'),
(9,	4,	'images.png'),
(10,	5,	'imagem2.png'),
(11,	4,	'redacao.jpeg'),
(12,	10,	'golden.jpeg');

DROP TABLE IF EXISTS `tb_post`;
CREATE TABLE `tb_post` (
  `id_post` int(11) NOT NULL AUTO_INCREMENT,
  `legenda` varchar(1000) NOT NULL,
  `data_postagem` datetime NOT NULL,
  `filtro` enum('liguagem','matematica','ciencias naturais','ciencia humanas','redacao') NOT NULL,
  PRIMARY KEY (`id_post`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tb_post` (`id_post`, `legenda`, `data_postagem`, `filtro`) VALUES
(1,	'Este é um post sobre matemática',	'2024-09-01 00:00:00',	'matematica'),
(2,	'Descubra os fundamentos das ciências naturais',	'2024-09-02 00:00:00',	'ciencias naturais'),
(3,	'Como dominar a redação de forma eficaz',	'2024-09-03 00:00:00',	'redacao'),
(4,	'Explorando os conceitos básicos de linguagens',	'2024-09-04 00:00:00',	'liguagem'),
(5,	'top 10 sociologos da atualidade',	'2024-09-02 00:00:00',	'ciencia humanas'),
(8,	'post teste',	'2444-09-09 00:00:00',	'matematica'),
(9,	'post teste',	'2444-09-09 00:00:00',	'matematica'),
(10,	'post teste',	'2311-02-12 00:00:00',	'matematica');

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


-- 2024-09-09 13:48:12
