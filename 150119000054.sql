/*
MySQL Backup
Source Server Version: 3.21.0
Source Database: paineladministrativo
Date: 19/01/2015 00:00:54
*/


-- ----------------------------
--  Table structure for `categorias`
-- ----------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `data_criacao` timestamp NOT NULL,
  `data_modicacao` timestamp NOT NULL,
  `descricao` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `informacoes`
-- ----------------------------
DROP TABLE IF EXISTS `informacoes`;
CREATE TABLE `informacoes` (
  `id` int(11) NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `telefone` varchar(255) NOT NULL,
  `google_analytics` varchar(255) DEFAULT NULL,
  `google_maps` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `youtube` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `paginas`
-- ----------------------------
DROP TABLE IF EXISTS `paginas`;
CREATE TABLE `paginas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) DEFAULT NULL,
  `data_criacao` timestamp NULL DEFAULT NULL,
  `data_modificacao` timestamp NULL DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `content` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `posts`
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cat` int(11) NOT NULL,
  `id_galery` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `ilustracao` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `tags` varchar(255) NOT NULL,
  `data_criacao` timestamp NOT NULL,
  `data_modificacao` timestamp NOT NULL,
  `url` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `usuarios`
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `telefone` varchar(255) NOT NULL,
  `data_criacao` timestamp NOT NULL,
  `data_exclusao` timestamp NOT NULL,
  `email` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `recovery` varchar(255) NOT NULL,
  `exclusao` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records 
-- ----------------------------
INSERT INTO `categorias` VALUES ('8','Novidades TecnolÃ³gicas','novidades-tecnologicas','2015-01-15 14:01:00','0000-00-00 00:00:00','DescriÃ§Ã£o'),  ('11','sem categoria','sem-categoria','2015-01-18 18:01:00','0000-00-00 00:00:00','#'),  ('13','Internet','internet','2015-01-18 18:01:00','0000-00-00 00:00:00','descriÃ§Ã£o internet');
INSERT INTO `informacoes` VALUES ('0','everton@ideiatres.com.br','centro','3252 0000','-- ','-- ','descricao','palavras chave','Painel Administrativo ','facebook.com/','twitter.com/','youtube.com/');
INSERT INTO `paginas` VALUES ('3','Fale conosco','2015-01-19 02:01:01',NULL,'fale-conosco','internet, web, sites, websites','<p>teste</p>'),  ('4','Contato','2015-01-19 02:01:54','2015-01-19 02:01:20','contato','internet, web, sites, websites','<p>teste 2</p>');
INSERT INTO `posts` VALUES ('23','13','0','Novo roteador','novo-roteador-134e7c5265acb82bbda2bbe1d674ab9a.jpg','<p>teste</p>','internet, web, sites, websites','2015-01-18 18:01:19','2015-01-18 18:01:46','novo-roteador','1'),  ('24','13','0','Teste 2','','<p>teste</p>','internet, web, sites, websites','2015-01-18 18:01:12','0000-00-00 00:00:00','teste-2','1');
INSERT INTO `usuarios` VALUES ('1','Everton Bronoski','42 98001827','2015-01-13 00:00:00','0000-00-00 00:00:00','evertonbki@gmail.com','everton','202cb962ac59075b964b07152d234b70','123','1');
