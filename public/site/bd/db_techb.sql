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
  `filtro` enum('linguagem','matematica','ciencias naturais','ciencia humanas','redacao','edital','dicasdeestudo','testesvocaional','artigos','entrevistas','inscricao','simulados') NOT NULL,
  PRIMARY KEY (`id_filtro`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `tb_filtro_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tb_filtro` (`id_filtro`, `id_usuario`, `filtro`) VALUES
(19,	10,	'ciencia humanas'),
(20,	10,	'matematica'),
(21,	10,	'redacao'),
(22,	11,	'matematica'),
(23,	11,	'linguagem'),
(24,	11,	'redacao'),
(25,	12,	'ciencia humanas'),
(26,	12,	'redacao'),
(27,	12,	'ciencias naturais');

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
(8,	9,	'/public/assets/img/1732208259e37a4b25354f73fb15c2db910f66443e44.jpg'),
(9,	9,	'/public/assets/img/1732208259ddab8c9d26ddc8ff02c04028eac4539630.jpg'),
(10,	9,	'/public/assets/img/1732208259f4da7d50bf496f8ba5a564149baafebc64.jpg'),
(11,	9,	'/public/assets/img/1732208259796342f4512ca8b1c1eb09cf991585d062.jpg'),
(12,	9,	'/public/assets/img/1732208259ac1be63e3f454a4418f696a4525b0d1e68.jpg'),
(13,	9,	'/public/assets/img/1732208259aae4d225930954b3fe7b49ca5378a05315.jpg'),
(14,	10,	'/public/assets/img/17322083487ab204ec8bc5e56df5f45ec49ff5988e33.webp'),
(15,	11,	'/public/assets/img/17322084715759634bd7150459f840df4846ec29d23.jpg'),
(16,	11,	'/public/assets/img/1732208471271c33903eddcc2fbe3594fc4b77e06489.jpg'),
(17,	11,	'/public/assets/img/1732208471bf10a011bf4ad63527c5f2242b05e33717.jpg'),
(18,	11,	'/public/assets/img/17322084713b1d9d2a9c4c23cf884331105c04106890.jpg'),
(19,	12,	'/public/assets/img/1732208535985d277fdec624b29224416eab8cad6020.jpg'),
(20,	12,	'/public/assets/img/1732208536b3b8f3c003e1bf6205ac2a27f08b753f62.jpg'),
(21,	13,	'/public/assets/img/1732208844986647dc30a8c2f3f535e89a004c2b5c40.jpg'),
(22,	13,	'/public/assets/img/17322088443c201d119f4bfc40be2e55347c21ae2174.jpg'),
(23,	13,	'/public/assets/img/1732208844e248abd0fc2b78d83581867bb5396edc18.jpg'),
(24,	13,	'/public/assets/img/17322088444df6bd445c03e11aabe8f46845756cad59.jpg'),
(25,	13,	'/public/assets/img/17322088443f9ac49c822327b39b0dd0baf97c830225.jpg'),
(26,	13,	'/public/assets/img/1732208844ac93cdbb210156c3e73e7c196d1a9ebc44.jpg'),
(27,	13,	'/public/assets/img/1732208844d1bea26c18c34052cdd5bfbea27fb9e851.jpg'),
(28,	13,	'/public/assets/img/17322088446e397693649f4db2cfcac200879f186a25.jpg'),
(29,	13,	'/public/assets/img/17322088442ceeecfec0e21986fa98a2fa4860e76b55.jpg'),
(30,	13,	'/public/assets/img/173220884402aea1a74847395b29a1f881604515ae28.jpg'),
(31,	13,	'/public/assets/img/173220884493ba596a4f5cfc9d610b66a976d1198048.jpg'),
(32,	13,	'/public/assets/img/17322088448fb712e0426420ea29f38593f60107676.jpg'),
(33,	13,	'/public/assets/img/1732208844edb569cc6f3ae436beaca9d511029fe02.jpg'),
(34,	13,	'/public/assets/img/1732208844a652bcfc4d98152e7df7786cf0435b7089.jpg'),
(35,	13,	'/public/assets/img/17322088440fde98acad6afbd1142cc3720475f6638.jpg'),
(36,	14,	'/public/assets/img/1732208910bdc0a82feb52122fd871f7a4581cc9b790.heic');

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
(9,	9,	'Nessa reta final para o ENEM_ garantir uma excelente nota na Redação pode ser o diferencial para a sua aprovação_ 📝__Agora é a hora de revisar_ aperfeiçoar e se preparar para entregar ',	'2024-11-21 04:57:39',	'redacao',	0),
(10,	9,	'Confira essa dica sobre as funções dos lipídios que eu trouxe para você não esquecer mais e arrasar no Enem_📝🤩',	'2024-11-21 04:59:44',	'ciencias naturais',	0),
(11,	9,	'Quer saber como usar Inteligência Artificial na redação do ENEM_ 🤖__📝 Preparamos um modelo completo de redação pra te ajudar a dominar esse tema atual e garantir argumentos sólidos ',	'2024-11-21 05:01:11',	'redacao',	0),
(12,	9,	'Tema da redação do ENEM 2024',	'2024-11-21 05:02:15',	'linguagem',	0),
(13,	9,	'Vem gabaritar natureza✨',	'2024-11-21 05:07:23',	'ciencias naturais',	0),
(14,	9,	'Resumo de quimica',	'2024-11-21 05:08:30',	'linguagem',	0);

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
(8,	'fernando josé',	'senha',	'fernando@gmail.com',	'admin',	'X',	'/public/assets/img/perfil/1732206907c049e276609ba5c07ee9f0c8013d02525.jpg'),
(9,	'professor universal',	'universal',	'professor@gmail.com',	'Em tudo',	'P',	'/public/assets/img/perfil/173220713559982d85643648849bab6083b0a15c3348.jpg'),
(10,	'aluno 1',	'aluno',	'aluno1@gmail.com',	'',	'A',	'/public/assets/img/perfil/17322071823fcd751d549d30c8a22fb245c6e5cf1644.jpg'),
(11,	'aluno 2',	'aluno2',	'aluno2@gmail.com',	'',	'A',	'/public/assets/img/perfil/1732207333b418df6c4d6f641efe7fbdabc2a09e6f11.jpg'),
(12,	'aluno 3',	'aluno3',	'aluno3@gmail.com',	'',	'A',	'/public/assets/img/perfil/1732207385dc8c0041f32ec87eeda564fe4830a47f36.jpg');

-- 2024-11-21 17:13:27