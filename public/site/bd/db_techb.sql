-- Adminer 4.8.1 MySQL 5.5.5-10.5.26-MariaDB-ubu2004 dump

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


DROP TABLE IF EXISTS `tb_filtro`;
CREATE TABLE `tb_filtro` (
  `id_filtro` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `filtro` enum('liguagem','matematica','ciencias naturais','ciencia humanas','redacao') NOT NULL,
  PRIMARY KEY (`id_filtro`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `tb_filtro_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tb_filtro` (`id_filtro`, `id_usuario`, `filtro`) VALUES
(1,	2,	'redacao'),
(2,	2,	'ciencia humanas'),
(3,	2,	'matematica');

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
(1,	2,	'imagem2.png');

DROP TABLE IF EXISTS `tb_post`;
CREATE TABLE `tb_post` (
  `id_post` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `legenda` varchar(300) NOT NULL,
  `data_postagem` datetime NOT NULL,
  `filtro` enum('liguagem','matematica','ciencias naturais','ciencia humanas','redacao') NOT NULL,
  PRIMARY KEY (`id_post`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `tb_post_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tb_post` (`id_post`, `id_usuario`, `legenda`, `data_postagem`, `filtro`) VALUES
(2,	2,	'mudeimesmo',	'2024-09-13 07:44:15',	'ciencias naturais');

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
(1,	'usuariofantasma',	'lIlIllI',	'qwerty@gami.com',	'MLBB',	'U',	NULL),
(2,	'Aaaaa',	'aaaa',	'aaaa@gmail.com',	'aaaa',	'A',	NULL);

-- 2024-09-13 19:49:50