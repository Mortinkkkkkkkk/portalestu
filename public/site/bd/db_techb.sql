-- Adminer 4.8.1 MySQL 5.5.5-10.5.25-MariaDB-ubu2004 dump

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
  `id_usuario` int(11) NOT NULL,
  `resposta_id` int(11) DEFAULT NULL,
  `comentario` varchar(1000) NOT NULL,
  PRIMARY KEY (`id_comentario`),
  KEY `id_post` (`id_post`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `tb_comentario_ibfk_3` FOREIGN KEY (`id_post`) REFERENCES `tb_post` (`id_post`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_comentario_ibfk_4` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tb_comentario` (`id_comentario`, `id_post`, `id_usuario`, `resposta_id`, `comentario`) VALUES
(3,	4,	2,	NULL,	'pppppppp'),
(8,	4,	2,	3,	'aaaaaaaaaaaaaa'),
(9,	5,	2,	NULL,	'Navio duh'),
(10,	5,	7,	9,	'nao'),
(11,	6,	7,	NULL,	'se meu '),
(12,	7,	2,	NULL,	'teste'),
(16,	5,	5,	9,	'teste'),
(17,	5,	5,	NULL,	'comentario'),
(18,	5,	5,	NULL,	'outro'),
(19,	5,	5,	NULL,	'resto'),
(21,	5,	5,	17,	'respota'),
(22,	5,	5,	17,	'oiiiiiiiii'),
(23,	5,	2,	22,	'teste');

DROP TABLE IF EXISTS `tb_filtro`;
CREATE TABLE `tb_filtro` (
  `id_filtro` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `filtro` enum('linguagem','matematica','ciencias naturais','ciencia humanas','redacao','edital','dicasdeestudo','testesvocaional','artigos','entrevistas','inscricao','simulados') NOT NULL,
  PRIMARY KEY (`id_filtro`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `tb_filtro_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tb_filtro` (`id_filtro`, `id_usuario`, `filtro`) VALUES
(1,	2,	'redacao'),
(2,	2,	'ciencia humanas'),
(3,	2,	'matematica'),
(7,	4,	'linguagem'),
(8,	4,	'linguagem'),
(9,	4,	'linguagem'),
(10,	5,	'ciencia humanas'),
(11,	5,	'matematica'),
(12,	5,	'ciencias naturais'),
(13,	6,	'ciencias naturais'),
(14,	6,	'ciencias naturais'),
(15,	6,	'ciencias naturais'),
(16,	7,	'matematica'),
(17,	7,	'matematica'),
(18,	7,	'matematica');

DROP TABLE IF EXISTS `tb_midia`;
CREATE TABLE `tb_midia` (
  `id_midia` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) NOT NULL,
  `midia` varchar(1000) NOT NULL,
  PRIMARY KEY (`id_midia`),
  KEY `id_post` (`id_post`),
  CONSTRAINT `tb_midia_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `tb_post` (`id_post`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tb_midia` (`id_midia`, `id_post`, `midia`) VALUES
(3,	4,	'/public/assets/img/1727701137add4462f4ae25e0d50f262f76e14d7a632.jpeg'),
(4,	5,	'/public/assets/img/172770349122bf7672bdf6d94bb2e3514bfcd63d5d23.png'),
(5,	6,	'/public/assets/img/17277041585af90edbdb3fc08a50e8ed6cf7fae21b93.jpeg'),
(6,	7,	'/public/assets/img/1728382589d3ab6dbb1747349bc3cb3f309fbbaf2670.jpeg'),
(7,	8,	'/public/assets/img/1728382731336067bff510caba57fabae15049e0a762.jpeg');

DROP TABLE IF EXISTS `tb_post`;
CREATE TABLE `tb_post` (
  `id_post` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `legenda` varchar(300) NOT NULL,
  `data_postagem` datetime NOT NULL,
  `filtro` enum('linguagem','matematica','ciencias naturais','ciencia humanas','redacao','edital','dicasdeestudo','testesvocaional','artigos','entrevistas','inscricao','simulados') NOT NULL,
  `fixado` int(1) NOT NULL,
  PRIMARY KEY (`id_post`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `tb_post_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tb_post` (`id_post`, `id_usuario`, `legenda`, `data_postagem`, `filtro`, `fixado`) VALUES
(4,	2,	'img',	'2024-09-30 12:58:57',	'linguagem',	0),
(5,	2,	'Nenhuma, palavra do português que começa com N  ',	'2024-09-30 01:38:11',	'linguagem',	0),
(6,	7,	'Como acha a hipotenusa',	'2024-09-30 01:49:18',	'matematica',	0),
(7,	2,	'quimica',	'2024-10-08 10:16:29',	'ciencias naturais',	0),
(8,	2,	'filosofia',	'2024-10-08 10:18:51',	'ciencia humanas',	0);

DROP TABLE IF EXISTS `tb_usuario`;
CREATE TABLE `tb_usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(30) NOT NULL,
  `senha_usuario` varchar(30) NOT NULL,
  `email_usuario` varchar(30) NOT NULL,
  `certificado` varchar(100) DEFAULT NULL,
  `tipo` varchar(1) NOT NULL,
  `foto_usuario` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tb_usuario` (`id_usuario`, `nome_usuario`, `senha_usuario`, `email_usuario`, `certificado`, `tipo`, `foto_usuario`) VALUES
(2,	'Aaaaa',	'aaaa',	'aaaa@gmail.com',	'aaaa',	'X',	NULL),
(4,	'pobre',	'erbop',	'pobre@gmail.com',	'',	'A',	NULL),
(5,	'rico',	'ocir',	'rico@gmail.com',	'',	'A',	NULL),
(6,	'Tree carvalho',	'arvore',	'palmeiras@gmail.com',	'Botanico',	'P',	NULL),
(7,	'X',	'doismaisdois',	'hipotenusa@gmail.com',	'Matematico',	'P',	NULL);

-- 2024-10-15 10:57:37
