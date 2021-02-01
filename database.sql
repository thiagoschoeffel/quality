-- MySQL dump 10.13  Distrib 5.5.62, for Win64 (AMD64)
--
-- Host: 162.241.135.147    Database:
-- ------------------------------------------------------
-- Server version	5.7.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `derivacoes`
--

DROP TABLE IF EXISTS `derivacoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `derivacoes` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `familias`
--

DROP TABLE IF EXISTS `familias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `familias` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fornecedores`
--

DROP TABLE IF EXISTS `fornecedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fornecedores` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `imagens`
--

DROP TABLE IF EXISTS `imagens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagens` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `inspecao` int(11) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `imagens_fk` (`inspecao`),
  CONSTRAINT `imagens_fk` FOREIGN KEY (`inspecao`) REFERENCES `inspecoes` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=5271 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inspecoes`
--

DROP TABLE IF EXISTS `inspecoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inspecoes` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `fornecedor` int(11) NOT NULL,
  `local` int(11) DEFAULT NULL,
  `familia` int(11) NOT NULL,
  `espessura` int(11) NOT NULL,
  `largura` int(11) NOT NULL,
  `comprimento` int(11) NOT NULL,
  `produto` varchar(255) NOT NULL,
  `derivacao` int(11) NOT NULL,
  `nota_fiscal` int(11) DEFAULT NULL,
  `pedido` int(11) DEFAULT NULL,
  `observacao` longtext,
  `datahora` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `inspetor` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `situacao` char(1) NOT NULL DEFAULT 'A',
  `liberacao` char(1) DEFAULT NULL,
  `sincronizado` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=1007 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `leituras`
--

DROP TABLE IF EXISTS `leituras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leituras` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `inspecao` int(11) NOT NULL,
  `parametro` int(11) NOT NULL,
  `amostras` int(11) NOT NULL,
  `amostra` int(11) DEFAULT NULL,
  `ponto` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `leituras_fk` (`inspecao`),
  KEY `leituras_fk_1` (`parametro`),
  CONSTRAINT `leituras_fk` FOREIGN KEY (`inspecao`) REFERENCES `inspecoes` (`codigo`),
  CONSTRAINT `leituras_fk_1` FOREIGN KEY (`parametro`) REFERENCES `parametros` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=190001 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `parametros`
--

DROP TABLE IF EXISTS `parametros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parametros` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` char(1) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `pontos` int(11) NOT NULL,
  `tolerancia_minima` decimal(10,2) NOT NULL,
  `tolerancia_maxima` decimal(10,2) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nome_usuario` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `administrador` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database ''
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-02-01 12:19:21
