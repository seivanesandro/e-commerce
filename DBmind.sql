DROP DATABASE IF EXISTS dbmind;

CREATE DATABASE dbmind;

USE dbmind;



/*ALTER TABLE tablename AUTO_INCREMENT = 1;*/


-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: dbmind
-- ------------------------------------------------------


--
-- Table structure for table `categorias`
--
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;



--
-- Table structure for table `produtos`
--
DROP TABLE IF EXISTS `produtos`;
CREATE TABLE `produtos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `categoria_ID` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `img1` varchar(255) NOT NULL,
  `img2` varchar(255) NOT NULL,
  `img3` varchar(255) NOT NULL,
  `img4` varchar(255) NOT NULL,
  `preco` decimal(6,2) NOT NULL,
  `especial_oferta` int(2) NOT NULL,
  `cor` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_produtos_categoriaID` (`categoria_ID`),
  CONSTRAINT `FK_produtos_categoriaID` FOREIGN KEY (`categoria_ID`) REFERENCES `categorias` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;



--
-- Table structure for table `utilizadores`
--

DROP TABLE IF EXISTS `utilizadores`;
CREATE TABLE `utilizadores` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `telefone` int(11) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `morada` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UX_Constraint` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;



--
-- Table structure for table `encomendas`
--
DROP TABLE IF EXISTS `encomendas`;
CREATE TABLE `encomendas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `preco` decimal(6,2) NOT NULL,
  `estado` varchar(100) NOT NULL DEFAULT 'pendente',
  `data` datetime NOT NULL DEFAULT current_timestamp(),
  `utilizador_ID` int(11) NOT NULL,
  `transaccao_id` varchar(250) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `utilizador_id` (`utilizador_ID`),
  CONSTRAINT `encomendas_ibfk_1` FOREIGN KEY (`utilizador_ID`) REFERENCES `utilizadores` (`ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;



--
-- Table structure for table `encomendas_detalhes`
--
DROP TABLE IF EXISTS `encomendas_detalhes`;
CREATE TABLE `encomendas_detalhes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `encomenda_ID` int(11) NOT NULL,
  `produto_ID` int(11) NOT NULL,
  `preco` decimal(6,2) NOT NULL,
  `quantidade` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `encomendas_detalhes_ibfk_1` (`encomenda_ID`),
  KEY `encomendas_detalhes_ibfk_2` (`produto_ID`),
  CONSTRAINT `encomendas_detalhes_ibfk_1` FOREIGN KEY (`encomenda_ID`) REFERENCES `encomendas` (`ID`),
  CONSTRAINT `encomendas_detalhes_ibfk_2` FOREIGN KEY (`produto_ID`) REFERENCES `produtos` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;




/*DADOS*/
/*categorias*/
INSERT INTO `categorias` (ID, descriçao) 
VALUES (0,'Categoria fantasma'),(1,'Destaques'),(2,'Casacos'),(3,'Tennis'),(4,'Smartwatch'),(5,'Mochilas');




/*produtos*/
/*Destaques categoria 1*/
INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Tennis da moda', 1,'Os Tennis mais destacados','destaque1.png','destaque1.png','destaque1.png','destaque1.png',9.99,50,'Varias Cores');

INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Mochilas da Puma moda', 1,'As Mochilas mais Destacadas','destaque2.png','destaque2.png','destaque2.png','destaque2.png',15.99,50,'Verde Claro');

INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Mochilas da Puma moda', 1,'As Mochilas mais Destacadas','destaque3.png','destaque3.png','destaque3.png','destaque3.png',15.99,50,'Preto');

INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Mochilas da Puma moda', 1,'As Mochilas mais Destacadas','destaque1.png','destaque2.png','destaque3.png','destaque4.png',15.99,50,'Azul Bebé');

INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Clavin Klein', 1,'CCE - "Classe, Conforto e Estilo"','cklein1.png','cklein2.png','cklein3.png','cklein1.png',79.99,35,'Pretos');

/*Casacos categoria 2*/
INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Nike sport', 2, 'casacos nike em promoção', 'n1.png', 'n2.png', 'n3.png', 'n4.png', 19.99, 50, 'Rosa claro');

INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Blazer HB', 2, 'Blazers mais vendidos', 'hb1.png', 'hb2.png', 'hb3.png', 'hb4.png', 29.99 , 50, 'Cinza Brilhante');

INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('JJones', 2,'Moda Outono','jjones1a.png','jjones2a.png','jjones3a.png','jjones4a.png',89.99,15,'Preto');

INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('JJones', 2,'Moda Inverno','jjones1b.png','jjones2b.png','jjones3b.png','jjones4b.png',119.99,35,'Castanho');

INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Blazer', 2,'Os Blazer mais destacados', 'casaco4.png', 'casaco4.png', 'casaco4.png','casaco4.png',29.99,50,'Azul Bebé');

INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Blazer', 2,'Os Blazers mais vendidos','casaco3.png','casaco3.png','casaco3.png','casaco3.png',29.99,50,'Azul');

/*smatwhatch categoria 4*/
INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Garmin Smartwatch', 4,'smartwatch Garmin Venus Varias Cores','Garmin1.png','Garmin2.png','Garmin2.png','Garmin4.png',9.99,50,'Rosa');

INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Garmin Smartwatch', 4,'smartwatch Garmin Venus Varias Cores','Garmin2.png','Garmin1.png','Garmin3.png','Garmin4.png',9.99,50,'Branco');

INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Garmin Smartwatch', 4,'smartwatch Garmin Venus Varias Cores','Garmin3.png','Garmin1.png','Garmin2.png','Garmin4.png',9.99,50,'Cinza');

INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Garmin Smartwatch', 4,'smartwatch Garmin Venus Varias Cores','Garmin4.png','Garmin1.png','Garmin2.png','Garmin3.png',9.99,50,'Preto');


/*	Dyna Fit categoria 3*/
INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Tennis DynaFit', 3,'Tennis desportivos mais destacados','dynafit1.png','dynafit2.png','dynafit3.png','dynafit4.png',19.99,50,'Azul Bebe');

INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Tennis DynaFit', 3,'Tennis desportivos mais destacados','dynafit4.png','dynafit1.png','dynafit2.png','dynafit3.png',19.99,50,'Amarelo');

INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Tennis DynaFit', 3,'Tennis desportivos mais destacados','dynafit3.png','dynafit4.png','dynafit1.png','dynafit2.png',19.99,50,'Azul Preto');

INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Tennis DynaFit', 3,'Tennis desportivos mais destacados','dynafit2.png','dynafit3.png','dynafit4.png','dynafit1.png',19.99,50,'Preto');

INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Nike Max', 3,'Confortaveis e criados para Boa perfomance','nike1.png','nike2.png','nike3.png','nike3.png',49.99,30,'Preto');

INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor)  
VALUES ('Nike Gore Tex', 3,'Confortaveis e criados para grandes caminhadas','nikef1.png','nikef2.png','nikef4.png','nikef1.png',39.99,25,'Beje');

INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Nike Star', 3,'Confortaveis e criados para o seu dia-a-dia','nikea1.png','nikea2.png','nikea3.png','nikea1.png',19.99,35,'Azul');

INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Fila Sports', 3,'Perfomance e conforto','fila1.png','fila2.png','fila3.png','fila1.png',49.99,15,'Azul');


/*mochilas categoria 5*/
/*vans camuflada*/
INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Vans', 5,'Mochila edição especial 2019','vansb1.png','vansb2.png','vansb3.png','vansb1.png',69.99,20,'Camuflada');
/*adidas*/
INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Mala Adidas', 5,'Feita com uma Alça e super espaçosa','addidasb1.png','addidasb2.png','addidasb3.png','addidasb1.png',19.99,5,'Preta');
/*vans preta*/
INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Vans', 5,'Mochila com efeto carbono','vans1.png','vans2.png','vans3.png','vans4.png',59.99,20,'Preto');
/*vans verde claro*/
INSERT INTO produtos(nome, categoria, descricao, img, img2, img3, img4, preco, especial_oferta, cor) 
VALUES ('Vans', 5,'Mochila Evolução com bolsos extra','vansa1.png','vansa2.png','vansa3.png','vansa4.png',55.99,20,'Verde Claro');








/*-outra opçao de insert-*/
-- Dumping data for table `produtos` backup from mysql 
--
INSERT INTO `produtos` VALUES (1,'Tennis moda',1,'Os Tennis mais destacados','destaque1.png','destaque2.png','destaque3.png','destaque4.png',9.99,50,'Varias Cores'),(2,'Mochila Puma',1,'As Mochilas mais Destacadas','destaque2.png','destaque1.png','destaque3.png','destaque4.png',15.99,50,'Verde Claro'),(3,'Mochila Puma',1,'As Mochilas mais Destacadas','destaque3.png','destaque4.png','destaque1.png','destaque2.png',15.99,50,'Preto'),(4,'Mochila Nike',5,'As Mochilas mais Destacadas','destaque4.png','destaque4.png','destaque4.png','destaque4.png',15.99,50,'Azul Bebé'),(5,'Nike sport',2,'casacos nike em promoção','n1.png','n2.png','n3.png','n4.png',19.99,50,'Rosa claro'),(6,'Blazer HB',2,'Blazers mais vendidos','hb1.png','hb2.png','hb3.png','hb4.png',29.99,50,'Cinza Brilhante'),(7,'JJones Casacos',2,'Moda Outono','jjones1a.png','jjones2a.png','jjones3a.png','jjones4a.png',89.99,15,'Preto'),(8,'JJones Casacos',2,'Moda Inverno','jjones1b.png','jjones2b.png','jjones3b.png','jjones4b.png',99.99,35,'Castanho'),(9,'Garmin Venus',4,'Os melhores smartwatches','Garmin1.png','Garmin2.png','Garmin3.png','Garmin4.png',9.99,50,'Varias Cores'),(10,'Garmin Venus',4,'Os melhores smartwatches','Garmin2.png','Garmin1.png','Garmin3.png','Garmin4.png',9.99,50,'Varias Cores'),(11,'Garmin Venus',4,'Os melhores smartwatches','Garmin3.png','Garmin4.png','Garmin1.png','Garmin2.png',9.99,50,'Varias Cores'),(12,'Garmin Venus ',4,'Os melhores smartwatches','Garmin4.png','Garmin3.png','Garmin2.png','Garmin1.png',9.99,50,'Varias Cores'),(13,'DynaFit',3,'Tennis desportivos mais destacados','dynafit1.png','dynafit2.png','dynafit3.png','dynafit4.png',19.99,50,'varios modelos'),(14,'DynaFit',3,'Tennis desportivos mais destacados','dynafit2.png','dynafit3.png','dynafit4.png','dynafit1.png',19.99,50,'varios modelos'),(15,'DynaFit',3,'Tennis desportivos mais destacados','dynafit3.png','dynafit4.png','dynafit1.png','dynafit2.png',19.99,50,'varios modelos'),(16,'DynaFit',3,'Tennis desportivos mais destacados','dynafit4.png','dynafit1.png','dynafit2.png','dynafit3.png',19.99,50,'varios modelos'),(17,'Vans',5,'Mochila edição especial 2019','vansb1.png','vansb2.png','vansb3.png','vansb1.png',69.99,20,'Camuflada'),(18,'Vans',5,'Mochila Evolução com bolsos extra','vansa1.png','vansa2.png','vansa3.png','vansa4.png',55.99,20,'Verde Claro'),(19,'Vans',5,'Mochila com efeto carbono','vans1.png','vans2.png','vans3.png','vans4.png',59.99,20,'Preto'),(20,'Adidas',5,'Feita com uma alça e super espaçosa','addidasb1.png','addidasb2.png','addidasb3.png','addidasb1.png',19.99,5,'Preta'),(21,'Nike Max',3,'Confortáveis e criados para boa performance','nike1.png','nike2.png','nike3.png','nike3.png',49.99,30,'Preto'),(22,'Nike Gore Tex',3,'Confortáveis e criados para grandes caminhadas','nikef1.png','nikef2.png','nikef4.png','nikef1.png',39.99,25,'Beje'),(23,'Nike Star',3,'Confortáveis e criados para o seu dia-a-dia','nikea1.png','nikea2.png','nikea3.png','nikea1.png',19.99,35,'Azul'),(24,'Fila Sports',3,'Performance e conforto','fila1.png','fila2.png','fila3.png','fila1.png',49.99,15,'Azul'),(25,'Clavin Klein',1,'CCE - \"Classe, Conforto e Estilo','cklein1.png','cklein2.png','cklein3.png','cklein1.png',79.99,35,'Pretos');
