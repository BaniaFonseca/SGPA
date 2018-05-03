/*
Navicat MySQL Data Transfer

Source Server         : controlerConexao
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : esimop_db

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-10-06 05:21:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `curso`
-- ----------------------------
DROP TABLE IF EXISTS `curso`;
CREATE TABLE `curso` (
  `idCurso` int(11) NOT NULL AUTO_INCREMENT,
  `coordenador` int(11) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `idFaculdade` int(11) DEFAULT NULL,
  `codigo` int(11) DEFAULT NULL,
  PRIMARY KEY (`idCurso`),
  KEY `curso_ibfk_1` (`idFaculdade`),
  KEY `curso_ibfk_2` (`coordenador`),
  CONSTRAINT `curso_ibfk_1` FOREIGN KEY (`idFaculdade`) REFERENCES `faculdade` (`idFaculdade`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `curso_ibfk_2` FOREIGN KEY (`coordenador`) REFERENCES `docente` (`idDocente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of curso
-- ----------------------------
INSERT INTO `curso` VALUES ('2', '3', 'Engenharia Informatica', '1', '324');
INSERT INTO `curso` VALUES ('3', '2', 'Engenharia Civil', '1', '432');
INSERT INTO `curso` VALUES ('6', '5', 'Engenharia Geologica', '1', '232');
INSERT INTO `curso` VALUES ('9', '6', 'Engenharia Mecanica', '1', '863');

-- ----------------------------
-- Table structure for `curso_disciplina`
-- ----------------------------
DROP TABLE IF EXISTS `curso_disciplina`;
CREATE TABLE `curso_disciplina` (
  `idDisciplina` int(11) NOT NULL DEFAULT '0',
  `idCurso` int(11) NOT NULL DEFAULT '0',
  `nivel` int(11) DEFAULT NULL,
  `semestre` int(11) DEFAULT NULL,
  PRIMARY KEY (`idDisciplina`,`idCurso`),
  KEY `idCurso` (`idCurso`),
  CONSTRAINT `curso_disciplina_ibfk_1` FOREIGN KEY (`idDisciplina`) REFERENCES `disciplina` (`idDisciplina`),
  CONSTRAINT `curso_disciplina_ibfk_2` FOREIGN KEY (`idCurso`) REFERENCES `curso` (`idCurso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of curso_disciplina
-- ----------------------------

-- ----------------------------
-- Table structure for `data_avaliacao`
-- ----------------------------
DROP TABLE IF EXISTS `data_avaliacao`;
CREATE TABLE `data_avaliacao` (
  `idData` int(11) NOT NULL AUTO_INCREMENT,
  `idavaliacao` int(11) DEFAULT NULL,
  `idDisciplina` int(11) DEFAULT NULL,
  `dataRealizacao` date DEFAULT NULL,
  PRIMARY KEY (`idData`),
  KEY `idavaliacao` (`idavaliacao`),
  KEY `idDisciplina` (`idDisciplina`),
  CONSTRAINT `data_avaliacao_ibfk_1` FOREIGN KEY (`idavaliacao`) REFERENCES `tipoavaliacao` (`idTipoAvaliacao`),
  CONSTRAINT `data_avaliacao_ibfk_2` FOREIGN KEY (`idDisciplina`) REFERENCES `disciplina` (`idDisciplina`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of data_avaliacao
-- ----------------------------
INSERT INTO `data_avaliacao` VALUES ('2', '1', '15', '2015-09-03');
INSERT INTO `data_avaliacao` VALUES ('3', '1', '15', '2015-10-09');
INSERT INTO `data_avaliacao` VALUES ('4', '2', '15', '2015-10-07');
INSERT INTO `data_avaliacao` VALUES ('5', '2', '15', '2015-09-09');
INSERT INTO `data_avaliacao` VALUES ('6', '3', '15', '2015-09-10');
INSERT INTO `data_avaliacao` VALUES ('7', '2', '17', '2015-10-09');
INSERT INTO `data_avaliacao` VALUES ('8', '1', '17', '2015-09-04');
INSERT INTO `data_avaliacao` VALUES ('9', '2', '17', '2015-12-11');
INSERT INTO `data_avaliacao` VALUES ('10', '1', '17', '2015-09-04');
INSERT INTO `data_avaliacao` VALUES ('11', '3', '17', '2015-10-30');
INSERT INTO `data_avaliacao` VALUES ('12', '1', '2', '2015-09-10');
INSERT INTO `data_avaliacao` VALUES ('13', '1', '2', '2015-11-13');
INSERT INTO `data_avaliacao` VALUES ('14', '2', '2', '2015-09-17');
INSERT INTO `data_avaliacao` VALUES ('15', '2', '2', '2015-12-18');
INSERT INTO `data_avaliacao` VALUES ('16', '3', '2', '2015-10-23');
INSERT INTO `data_avaliacao` VALUES ('17', '1', '5', '2015-09-09');
INSERT INTO `data_avaliacao` VALUES ('18', '1', '5', '2015-09-09');
INSERT INTO `data_avaliacao` VALUES ('19', '2', '5', '2015-11-07');
INSERT INTO `data_avaliacao` VALUES ('20', '2', '5', '2015-11-07');
INSERT INTO `data_avaliacao` VALUES ('21', '3', '5', '2015-09-10');
INSERT INTO `data_avaliacao` VALUES ('22', '1', '6', '2015-09-04');
INSERT INTO `data_avaliacao` VALUES ('23', '1', '6', '2015-12-04');
INSERT INTO `data_avaliacao` VALUES ('24', '2', '6', '2015-09-05');
INSERT INTO `data_avaliacao` VALUES ('25', '2', '6', '2015-09-02');
INSERT INTO `data_avaliacao` VALUES ('26', '3', '6', '2015-09-02');
INSERT INTO `data_avaliacao` VALUES ('37', '1', '13', '2015-09-13');
INSERT INTO `data_avaliacao` VALUES ('38', '2', '13', '2015-10-08');
INSERT INTO `data_avaliacao` VALUES ('39', '1', '13', '2015-09-10');
INSERT INTO `data_avaliacao` VALUES ('40', '2', '13', '2015-10-24');
INSERT INTO `data_avaliacao` VALUES ('41', '3', '13', '2015-09-18');

-- ----------------------------
-- Table structure for `disciplina`
-- ----------------------------
DROP TABLE IF EXISTS `disciplina`;
CREATE TABLE `disciplina` (
  `idDisciplina` int(11) NOT NULL AUTO_INCREMENT,
  `ano` int(11) DEFAULT NULL,
  `creditos` int(11) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `codigo` int(11) DEFAULT NULL,
  PRIMARY KEY (`idDisciplina`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of disciplina
-- ----------------------------
INSERT INTO `disciplina` VALUES ('1', '3', '5', 'Engenharia de Software 2', '123');
INSERT INTO `disciplina` VALUES ('2', '3', '4', 'IHC', '73');
INSERT INTO `disciplina` VALUES ('3', '2', '5', 'Fisica Quantica', '646');
INSERT INTO `disciplina` VALUES ('4', '2', '4', 'Mecanica e Ondas', '56');
INSERT INTO `disciplina` VALUES ('5', '3', '6', 'Progrmacao Web', '567');
INSERT INTO `disciplina` VALUES ('6', '3', '6', 'POO', '382');
INSERT INTO `disciplina` VALUES ('7', '2', '4', 'ALGA', '57');
INSERT INTO `disciplina` VALUES ('9', '1', '4', 'Mecanica do Materiais', '856');
INSERT INTO `disciplina` VALUES ('10', '1', '4', 'Desenho ', '3939');
INSERT INTO `disciplina` VALUES ('13', '3', '6', 'LC', '767');
INSERT INTO `disciplina` VALUES ('14', '4', '6', 'PL', '453');
INSERT INTO `disciplina` VALUES ('15', '4', '5', 'LRC', '465');
INSERT INTO `disciplina` VALUES ('16', '1', '3', 'TEC', '6453');
INSERT INTO `disciplina` VALUES ('17', '2', '4', 'RC', '3543');
INSERT INTO `disciplina` VALUES ('18', '2', '3', 'GPI', '133');

-- ----------------------------
-- Table structure for `docente`
-- ----------------------------
DROP TABLE IF EXISTS `docente`;
CREATE TABLE `docente` (
  `idDocente` int(11) NOT NULL AUTO_INCREMENT,
  `idGrauAcademico` int(11) DEFAULT NULL,
  `idUtilizador` int(11) DEFAULT NULL,
  `nomeCompleto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idDocente`),
  KEY `idGrauAcademico` (`idGrauAcademico`),
  KEY `idUtilizador` (`idUtilizador`),
  CONSTRAINT `docente_ibfk_1` FOREIGN KEY (`idGrauAcademico`) REFERENCES `grau_academico` (`idGrau`),
  CONSTRAINT `docente_ibfk_2` FOREIGN KEY (`idUtilizador`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of docente
-- ----------------------------
INSERT INTO `docente` VALUES ('2', '3', '4', 'Jose Cripriano Tafula');
INSERT INTO `docente` VALUES ('3', '3', '5', 'Celso Daudo Danilo Vanimaly');
INSERT INTO `docente` VALUES ('4', '6', '7', 'Heraclito Comia');
INSERT INTO `docente` VALUES ('5', '2', '8', 'Valeriana Joao');
INSERT INTO `docente` VALUES ('6', '5', '9', 'Geraldo Camilo Pedro');
INSERT INTO `docente` VALUES ('7', '5', '10', 'Filermino Aly');
INSERT INTO `docente` VALUES ('8', '2', '11', 'Elidio Tomas da Silva');
INSERT INTO `docente` VALUES ('18', '5', '58', 'Saide Manuel Saide');
INSERT INTO `docente` VALUES ('19', '1', '3', 'Fernado Brando');

-- ----------------------------
-- Table structure for `docentedisciplina`
-- ----------------------------
DROP TABLE IF EXISTS `docentedisciplina`;
CREATE TABLE `docentedisciplina` (
  `idCurso` int(11) NOT NULL,
  `idDisciplina` int(11) NOT NULL,
  `idDocente` int(11) NOT NULL,
  `semestre` int(11) DEFAULT NULL,
  PRIMARY KEY (`idCurso`,`idDisciplina`,`idDocente`),
  KEY `idDisciplina` (`idDisciplina`),
  KEY `idDocente` (`idDocente`),
  CONSTRAINT `docentedisciplina_ibfk_1` FOREIGN KEY (`idCurso`) REFERENCES `curso` (`idCurso`),
  CONSTRAINT `docentedisciplina_ibfk_2` FOREIGN KEY (`idDisciplina`) REFERENCES `disciplina` (`idDisciplina`),
  CONSTRAINT `docentedisciplina_ibfk_3` FOREIGN KEY (`idDocente`) REFERENCES `docente` (`idDocente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of docentedisciplina
-- ----------------------------
INSERT INTO `docentedisciplina` VALUES ('2', '1', '2', '1');
INSERT INTO `docentedisciplina` VALUES ('2', '2', '2', '1');
INSERT INTO `docentedisciplina` VALUES ('2', '4', '5', '1');
INSERT INTO `docentedisciplina` VALUES ('2', '5', '3', '1');
INSERT INTO `docentedisciplina` VALUES ('2', '6', '3', '1');
INSERT INTO `docentedisciplina` VALUES ('2', '13', '8', '2');
INSERT INTO `docentedisciplina` VALUES ('2', '15', '8', '1');
INSERT INTO `docentedisciplina` VALUES ('2', '15', '18', '2');
INSERT INTO `docentedisciplina` VALUES ('2', '17', '18', '2');
INSERT INTO `docentedisciplina` VALUES ('3', '7', '4', '1');
INSERT INTO `docentedisciplina` VALUES ('6', '3', '4', '1');
INSERT INTO `docentedisciplina` VALUES ('6', '7', '4', '1');
INSERT INTO `docentedisciplina` VALUES ('6', '13', '4', '2');

-- ----------------------------
-- Table structure for `estudante`
-- ----------------------------
DROP TABLE IF EXISTS `estudante`;
CREATE TABLE `estudante` (
  `idEstudante` int(11) NOT NULL AUTO_INCREMENT,
  `idUtilizador` int(11) NOT NULL DEFAULT '0',
  `nomeCompleto` varchar(255) DEFAULT NULL,
  `nrEstudante` int(11) DEFAULT NULL,
  PRIMARY KEY (`idEstudante`,`idUtilizador`),
  KEY `idEstudante` (`idEstudante`),
  KEY `idUtilizador` (`idUtilizador`),
  CONSTRAINT `estudante_ibfk_1` FOREIGN KEY (`idUtilizador`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of estudante
-- ----------------------------
INSERT INTO `estudante` VALUES ('1', '1', 'Raimundo Jose', '221');
INSERT INTO `estudante` VALUES ('9', '23', 'Valinho Antonio', '745');
INSERT INTO `estudante` VALUES ('10', '24', 'Esmael Muze', '5424');
INSERT INTO `estudante` VALUES ('11', '25', 'Cabral Jamime', '956');
INSERT INTO `estudante` VALUES ('12', '26', 'Valdimiro Lenine', '9569');
INSERT INTO `estudante` VALUES ('13', '27', 'Joana Ernestro', '332');
INSERT INTO `estudante` VALUES ('14', '28', 'Nadia Merico', '746');
INSERT INTO `estudante` VALUES ('15', '40', 'Felix Januario', '5343');
INSERT INTO `estudante` VALUES ('16', '41', 'Cavaldo Geraldo ', '352');

-- ----------------------------
-- Table structure for `estudante_disciplina`
-- ----------------------------
DROP TABLE IF EXISTS `estudante_disciplina`;
CREATE TABLE `estudante_disciplina` (
  `idestudante` int(11) NOT NULL DEFAULT '0',
  `iddisciplina` int(11) NOT NULL DEFAULT '0',
  `idcurso` int(11) NOT NULL DEFAULT '0',
  `dataReg` date DEFAULT NULL,
  PRIMARY KEY (`idestudante`,`iddisciplina`,`idcurso`),
  KEY `iddisciplina` (`iddisciplina`),
  KEY `idcurso` (`idcurso`),
  CONSTRAINT `estudante_disciplina_ibfk_1` FOREIGN KEY (`iddisciplina`) REFERENCES `disciplina` (`idDisciplina`),
  CONSTRAINT `estudante_disciplina_ibfk_2` FOREIGN KEY (`idcurso`) REFERENCES `curso` (`idCurso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of estudante_disciplina
-- ----------------------------
INSERT INTO `estudante_disciplina` VALUES ('1', '1', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('1', '2', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('1', '6', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('1', '15', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('1', '17', '2', '2015-09-16');
INSERT INTO `estudante_disciplina` VALUES ('10', '15', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('10', '17', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('11', '2', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('11', '5', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('11', '6', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('11', '15', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('11', '16', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('11', '17', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('13', '2', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('13', '5', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('13', '6', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('13', '15', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('13', '16', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('13', '17', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('15', '10', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('15', '14', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('15', '15', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('15', '16', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('15', '17', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('16', '4', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('16', '6', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('16', '7', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('16', '14', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('16', '15', '2', '2015-09-06');
INSERT INTO `estudante_disciplina` VALUES ('16', '17', '2', '2015-09-06');

-- ----------------------------
-- Table structure for `estudante_nota`
-- ----------------------------
DROP TABLE IF EXISTS `estudante_nota`;
CREATE TABLE `estudante_nota` (
  `idNota` int(11) NOT NULL AUTO_INCREMENT,
  `idEstudante` int(11) NOT NULL DEFAULT '0',
  `idPautaNormal` int(11) NOT NULL DEFAULT '0',
  `nota` double DEFAULT NULL,
  PRIMARY KEY (`idNota`,`idEstudante`,`idPautaNormal`),
  KEY `idEstudante` (`idEstudante`),
  KEY `idPautaNormal` (`idPautaNormal`),
  KEY `idNota` (`idNota`),
  CONSTRAINT `estudante_nota_ibfk_1` FOREIGN KEY (`idEstudante`) REFERENCES `estudante` (`idEstudante`),
  CONSTRAINT `estudante_nota_ibfk_2` FOREIGN KEY (`idPautaNormal`) REFERENCES `pautanormal` (`idPautaNormal`)
) ENGINE=InnoDB AUTO_INCREMENT=283 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of estudante_nota
-- ----------------------------
INSERT INTO `estudante_nota` VALUES ('110', '15', '59', '15');
INSERT INTO `estudante_nota` VALUES ('111', '13', '59', '18');
INSERT INTO `estudante_nota` VALUES ('112', '10', '59', '11');
INSERT INTO `estudante_nota` VALUES ('113', '1', '59', '17');
INSERT INTO `estudante_nota` VALUES ('114', '11', '59', '12');
INSERT INTO `estudante_nota` VALUES ('115', '15', '60', '15');
INSERT INTO `estudante_nota` VALUES ('116', '16', '60', '16');
INSERT INTO `estudante_nota` VALUES ('117', '10', '60', '11');
INSERT INTO `estudante_nota` VALUES ('118', '13', '60', '18');
INSERT INTO `estudante_nota` VALUES ('119', '1', '60', '20');
INSERT INTO `estudante_nota` VALUES ('120', '10', '60', '2');
INSERT INTO `estudante_nota` VALUES ('121', '11', '61', '12');
INSERT INTO `estudante_nota` VALUES ('122', '16', '61', '18');
INSERT INTO `estudante_nota` VALUES ('123', '13', '61', '11.3');
INSERT INTO `estudante_nota` VALUES ('124', '15', '61', '15');
INSERT INTO `estudante_nota` VALUES ('125', '1', '61', '19');
INSERT INTO `estudante_nota` VALUES ('126', '11', '62', '17');
INSERT INTO `estudante_nota` VALUES ('127', '15', '62', '17');
INSERT INTO `estudante_nota` VALUES ('128', '13', '62', '11.3');
INSERT INTO `estudante_nota` VALUES ('129', '10', '62', '12');
INSERT INTO `estudante_nota` VALUES ('130', '16', '62', '12');
INSERT INTO `estudante_nota` VALUES ('131', '1', '62', '18');
INSERT INTO `estudante_nota` VALUES ('132', '11', '62', '11');
INSERT INTO `estudante_nota` VALUES ('133', '15', '63', '3');
INSERT INTO `estudante_nota` VALUES ('134', '1', '63', '13');
INSERT INTO `estudante_nota` VALUES ('135', '13', '63', '11.3');
INSERT INTO `estudante_nota` VALUES ('136', '16', '63', '1');
INSERT INTO `estudante_nota` VALUES ('137', '16', '64', '3');
INSERT INTO `estudante_nota` VALUES ('138', '13', '64', '11');
INSERT INTO `estudante_nota` VALUES ('139', '11', '64', '12');
INSERT INTO `estudante_nota` VALUES ('140', '1', '64', '18');
INSERT INTO `estudante_nota` VALUES ('141', '13', '65', '11');
INSERT INTO `estudante_nota` VALUES ('142', '1', '65', '1');
INSERT INTO `estudante_nota` VALUES ('143', '11', '65', '12');
INSERT INTO `estudante_nota` VALUES ('144', '16', '65', '14');
INSERT INTO `estudante_nota` VALUES ('145', '11', '66', '12');
INSERT INTO `estudante_nota` VALUES ('146', '16', '66', '14');
INSERT INTO `estudante_nota` VALUES ('147', '13', '66', '11');
INSERT INTO `estudante_nota` VALUES ('148', '1', '66', '1');
INSERT INTO `estudante_nota` VALUES ('149', '13', '66', '15');
INSERT INTO `estudante_nota` VALUES ('150', '11', '67', '12');
INSERT INTO `estudante_nota` VALUES ('151', '1', '67', '18.9');
INSERT INTO `estudante_nota` VALUES ('152', '11', '68', '12');
INSERT INTO `estudante_nota` VALUES ('153', '13', '68', '15');
INSERT INTO `estudante_nota` VALUES ('156', '1', '69', '12');
INSERT INTO `estudante_nota` VALUES ('157', '16', '69', '17');
INSERT INTO `estudante_nota` VALUES ('158', '13', '70', '15');
INSERT INTO `estudante_nota` VALUES ('159', '1', '70', '16');
INSERT INTO `estudante_nota` VALUES ('160', '11', '70', '11.7');
INSERT INTO `estudante_nota` VALUES ('248', '1', '209', '12');
INSERT INTO `estudante_nota` VALUES ('249', '13', '209', '2');
INSERT INTO `estudante_nota` VALUES ('250', '1', '210', '12');
INSERT INTO `estudante_nota` VALUES ('251', '13', '210', '15');
INSERT INTO `estudante_nota` VALUES ('252', '1', '211', '13');
INSERT INTO `estudante_nota` VALUES ('253', '13', '211', '15');
INSERT INTO `estudante_nota` VALUES ('254', '1', '211', '2');
INSERT INTO `estudante_nota` VALUES ('255', '11', '211', '20');
INSERT INTO `estudante_nota` VALUES ('256', '13', '211', '16');
INSERT INTO `estudante_nota` VALUES ('257', '11', '213', '20');
INSERT INTO `estudante_nota` VALUES ('258', '1', '213', '20');
INSERT INTO `estudante_nota` VALUES ('259', '11', '214', '4');
INSERT INTO `estudante_nota` VALUES ('260', '13', '214', '12');
INSERT INTO `estudante_nota` VALUES ('261', '13', '215', '12');
INSERT INTO `estudante_nota` VALUES ('262', '13', '215', '14');
INSERT INTO `estudante_nota` VALUES ('263', '1', '215', '12');
INSERT INTO `estudante_nota` VALUES ('264', '16', '216', '1.4');
INSERT INTO `estudante_nota` VALUES ('265', '11', '216', '6');
INSERT INTO `estudante_nota` VALUES ('266', '1', '216', '12');
INSERT INTO `estudante_nota` VALUES ('267', '13', '217', '14');
INSERT INTO `estudante_nota` VALUES ('268', '11', '217', '6');
INSERT INTO `estudante_nota` VALUES ('269', '11', '218', '12');
INSERT INTO `estudante_nota` VALUES ('270', '1', '218', '16');
INSERT INTO `estudante_nota` VALUES ('271', '13', '219', '11');
INSERT INTO `estudante_nota` VALUES ('272', '11', '219', '14');
INSERT INTO `estudante_nota` VALUES ('273', '13', '219', '11');
INSERT INTO `estudante_nota` VALUES ('274', '11', '220', '14');
INSERT INTO `estudante_nota` VALUES ('275', '1', '222', '18.8');
INSERT INTO `estudante_nota` VALUES ('276', '13', '222', '18');
INSERT INTO `estudante_nota` VALUES ('277', '16', '222', '16');
INSERT INTO `estudante_nota` VALUES ('278', '11', '222', '3');
INSERT INTO `estudante_nota` VALUES ('279', '13', '223', '2.54');
INSERT INTO `estudante_nota` VALUES ('280', '10', '223', '16');
INSERT INTO `estudante_nota` VALUES ('281', '1', '223', '20');
INSERT INTO `estudante_nota` VALUES ('282', '11', '223', '12');

-- ----------------------------
-- Table structure for `examerecorrencia`
-- ----------------------------
DROP TABLE IF EXISTS `examerecorrencia`;
CREATE TABLE `examerecorrencia` (
  `idExameRec` int(11) NOT NULL,
  `nota_ex_nr` double DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  PRIMARY KEY (`idExameRec`),
  CONSTRAINT `examerecorrencia_ibfk_1` FOREIGN KEY (`idExameRec`) REFERENCES `estudante_nota` (`idNota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of examerecorrencia
-- ----------------------------
INSERT INTO `examerecorrencia` VALUES ('110', '4', '1');
INSERT INTO `examerecorrencia` VALUES ('133', '3', '1');

-- ----------------------------
-- Table structure for `faculdade`
-- ----------------------------
DROP TABLE IF EXISTS `faculdade`;
CREATE TABLE `faculdade` (
  `idFaculdade` int(11) NOT NULL AUTO_INCREMENT,
  `responsavel` int(255) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idFaculdade`),
  KEY `responsavel` (`responsavel`),
  CONSTRAINT `faculdade_ibfk_1` FOREIGN KEY (`responsavel`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of faculdade
-- ----------------------------
INSERT INTO `faculdade` VALUES ('1', '11', 'Faculdade de Engenharia');

-- ----------------------------
-- Table structure for `grau_academico`
-- ----------------------------
DROP TABLE IF EXISTS `grau_academico`;
CREATE TABLE `grau_academico` (
  `idGrau` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idGrau`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of grau_academico
-- ----------------------------
INSERT INTO `grau_academico` VALUES ('1', 'Ph.D');
INSERT INTO `grau_academico` VALUES ('2', 'Msc');
INSERT INTO `grau_academico` VALUES ('3', 'Lic.');
INSERT INTO `grau_academico` VALUES ('4', 'Dr.');
INSERT INTO `grau_academico` VALUES ('5', 'Eng.');
INSERT INTO `grau_academico` VALUES ('6', 'dr.');

-- ----------------------------
-- Table structure for `pautanormal`
-- ----------------------------
DROP TABLE IF EXISTS `pautanormal`;
CREATE TABLE `pautanormal` (
  `idPautaNormal` int(11) NOT NULL AUTO_INCREMENT,
  `idcurso` int(11) NOT NULL,
  `idDisciplina` int(11) NOT NULL,
  `idTipoAvaliacao` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `dataReg` date DEFAULT NULL,
  `dataPub` date DEFAULT NULL,
  PRIMARY KEY (`idPautaNormal`,`idcurso`,`idDisciplina`),
  KEY `idcurso` (`idcurso`),
  KEY `idTipoAvaliacao` (`idTipoAvaliacao`),
  KEY `idDisciplina` (`idDisciplina`),
  KEY `idPautaNormal` (`idPautaNormal`),
  CONSTRAINT `pautanormal_ibfk_1` FOREIGN KEY (`idcurso`) REFERENCES `curso` (`idCurso`),
  CONSTRAINT `pautanormal_ibfk_2` FOREIGN KEY (`idTipoAvaliacao`) REFERENCES `tipoavaliacao` (`idTipoAvaliacao`),
  CONSTRAINT `pautanormal_ibfk_3` FOREIGN KEY (`idDisciplina`) REFERENCES `disciplina` (`idDisciplina`)
) ENGINE=InnoDB AUTO_INCREMENT=224 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pautanormal
-- ----------------------------
INSERT INTO `pautanormal` VALUES ('59', '2', '15', '1', '2', '2015-09-07', '2015-09-07');
INSERT INTO `pautanormal` VALUES ('60', '2', '15', '1', '2', '2015-09-07', '2015-09-07');
INSERT INTO `pautanormal` VALUES ('61', '2', '15', '2', '2', '2015-09-07', '2015-09-07');
INSERT INTO `pautanormal` VALUES ('62', '2', '15', '3', '2', '2015-09-07', '2015-09-07');
INSERT INTO `pautanormal` VALUES ('63', '2', '15', '4', '2', '2015-09-07', '2015-09-07');
INSERT INTO `pautanormal` VALUES ('64', '2', '6', '1', '2', '2015-09-07', '2015-09-07');
INSERT INTO `pautanormal` VALUES ('65', '2', '6', '2', '2', '2015-09-07', '2015-09-07');
INSERT INTO `pautanormal` VALUES ('66', '2', '6', '2', '2', '2015-09-07', '2015-09-07');
INSERT INTO `pautanormal` VALUES ('67', '2', '6', '2', '2', '2015-09-09', '2015-09-19');
INSERT INTO `pautanormal` VALUES ('68', '2', '6', '3', '2', '2015-09-09', '2015-09-12');
INSERT INTO `pautanormal` VALUES ('69', '2', '6', '2', '2', '2015-09-12', '2015-09-12');
INSERT INTO `pautanormal` VALUES ('70', '2', '6', '3', '2', '2015-09-12', '2015-09-12');
INSERT INTO `pautanormal` VALUES ('209', '2', '6', '3', '1', '2015-09-14', null);
INSERT INTO `pautanormal` VALUES ('210', '2', '2', '1', '2', '2015-09-14', '2015-09-16');
INSERT INTO `pautanormal` VALUES ('211', '2', '2', '2', '1', '2015-09-14', null);
INSERT INTO `pautanormal` VALUES ('212', '2', '2', '2', '1', '2015-09-15', null);
INSERT INTO `pautanormal` VALUES ('213', '2', '2', '1', '2', '2015-09-15', '2015-09-19');
INSERT INTO `pautanormal` VALUES ('214', '2', '5', '3', '2', '2015-09-16', '2015-09-16');
INSERT INTO `pautanormal` VALUES ('215', '2', '5', '2', '1', '2015-09-16', null);
INSERT INTO `pautanormal` VALUES ('216', '2', '6', '2', '2', '2015-09-17', '2015-09-19');
INSERT INTO `pautanormal` VALUES ('217', '2', '6', '3', '2', '2015-09-17', '2015-09-19');
INSERT INTO `pautanormal` VALUES ('218', '2', '17', '3', '2', '2015-09-18', '2015-09-19');
INSERT INTO `pautanormal` VALUES ('219', '2', '6', '3', '2', '2015-09-19', '2015-09-19');
INSERT INTO `pautanormal` VALUES ('220', '2', '5', '2', '1', '2015-09-19', null);
INSERT INTO `pautanormal` VALUES ('221', '2', '5', '1', '1', '2015-09-19', null);
INSERT INTO `pautanormal` VALUES ('222', '2', '6', '4', '2', '2015-09-19', '2015-09-19');
INSERT INTO `pautanormal` VALUES ('223', '2', '15', '1', '1', '2015-09-24', null);

-- ----------------------------
-- Table structure for `planoavaliacao`
-- ----------------------------
DROP TABLE IF EXISTS `planoavaliacao`;
CREATE TABLE `planoavaliacao` (
  `idplano` int(11) NOT NULL AUTO_INCREMENT,
  `idDisciplina` int(11) NOT NULL DEFAULT '0',
  `idTipoAvaliacao` int(11) NOT NULL DEFAULT '0',
  `qtdMaxAvaliacao` int(11) DEFAULT NULL,
  `peso` double(255,0) DEFAULT NULL,
  PRIMARY KEY (`idplano`,`idDisciplina`,`idTipoAvaliacao`),
  KEY `idDisciplina` (`idDisciplina`),
  KEY `idTipoAvaliacao` (`idTipoAvaliacao`),
  CONSTRAINT `planoavaliacao_ibfk_1` FOREIGN KEY (`idDisciplina`) REFERENCES `disciplina` (`idDisciplina`),
  CONSTRAINT `planoavaliacao_ibfk_2` FOREIGN KEY (`idTipoAvaliacao`) REFERENCES `tipoavaliacao` (`idTipoAvaliacao`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of planoavaliacao
-- ----------------------------
INSERT INTO `planoavaliacao` VALUES ('7', '15', '2', '2', '10');
INSERT INTO `planoavaliacao` VALUES ('8', '15', '1', '2', '80');
INSERT INTO `planoavaliacao` VALUES ('9', '15', '3', '1', '10');
INSERT INTO `planoavaliacao` VALUES ('10', '17', '2', '2', '10');
INSERT INTO `planoavaliacao` VALUES ('11', '17', '1', '2', '80');
INSERT INTO `planoavaliacao` VALUES ('12', '17', '3', '1', '10');
INSERT INTO `planoavaliacao` VALUES ('13', '2', '1', '2', '80');
INSERT INTO `planoavaliacao` VALUES ('14', '2', '2', '2', '10');
INSERT INTO `planoavaliacao` VALUES ('15', '2', '3', '1', '10');
INSERT INTO `planoavaliacao` VALUES ('16', '5', '1', '2', '80');
INSERT INTO `planoavaliacao` VALUES ('17', '5', '2', '2', '10');
INSERT INTO `planoavaliacao` VALUES ('18', '5', '3', '1', '10');
INSERT INTO `planoavaliacao` VALUES ('19', '6', '1', '2', '70');
INSERT INTO `planoavaliacao` VALUES ('20', '6', '2', '2', '20');
INSERT INTO `planoavaliacao` VALUES ('21', '6', '3', '1', '10');
INSERT INTO `planoavaliacao` VALUES ('22', '13', '2', '2', '20');
INSERT INTO `planoavaliacao` VALUES ('23', '13', '1', '2', '70');
INSERT INTO `planoavaliacao` VALUES ('24', '13', '3', '1', '10');

-- ----------------------------
-- Table structure for `sexo`
-- ----------------------------
DROP TABLE IF EXISTS `sexo`;
CREATE TABLE `sexo` (
  `idSexo` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(155) DEFAULT NULL,
  PRIMARY KEY (`idSexo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sexo
-- ----------------------------
INSERT INTO `sexo` VALUES ('1', 'Masculino');
INSERT INTO `sexo` VALUES ('2', 'Femenino');

-- ----------------------------
-- Table structure for `tipoavaliacao`
-- ----------------------------
DROP TABLE IF EXISTS `tipoavaliacao`;
CREATE TABLE `tipoavaliacao` (
  `idTipoAvaliacao` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idTipoAvaliacao`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tipoavaliacao
-- ----------------------------
INSERT INTO `tipoavaliacao` VALUES ('1', 'Teste');
INSERT INTO `tipoavaliacao` VALUES ('2', 'Mini-Teste');
INSERT INTO `tipoavaliacao` VALUES ('3', 'Trabalho');
INSERT INTO `tipoavaliacao` VALUES ('4', 'Exame Normal');
INSERT INTO `tipoavaliacao` VALUES ('5', 'Exame Recorrencia');

-- ----------------------------
-- Table structure for `utilizador`
-- ----------------------------
DROP TABLE IF EXISTS `utilizador`;
CREATE TABLE `utilizador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(255) NOT NULL,
  `idSexo` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `data_ingresso` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idSexo` (`idSexo`),
  CONSTRAINT `utilizador_ibfk_1` FOREIGN KEY (`idSexo`) REFERENCES `sexo` (`idSexo`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of utilizador
-- ----------------------------
INSERT INTO `utilizador` VALUES ('1', 'estudante', '1', 'rjose@unilurio.ac.mz', '221', '2011-10-04');
INSERT INTO `utilizador` VALUES ('2', 'RA', '2', 'tania@unilurio.ac.mz', '234', null);
INSERT INTO `utilizador` VALUES ('3', 'Director Adj. Pedagogico', '1', 'fernado@unilurio.ac.mz', '298', null);
INSERT INTO `utilizador` VALUES ('4', 'docente', '1', 'tafula@unilurio.ac.mz', '958', null);
INSERT INTO `utilizador` VALUES ('5', 'Director do Curso', '1', 'celso.vanimaly@unilurio.ac.mz', '341', null);
INSERT INTO `utilizador` VALUES ('7', 'Docente', '1', 'heraclito@unilurio.ac.mz', 'h2015', null);
INSERT INTO `utilizador` VALUES ('8', 'Director do Curso', '2', 'valeriana@unilurio.ac.mz', 'v2015', null);
INSERT INTO `utilizador` VALUES ('9', 'Docente', '1', 'geraldo@unilurio.ac.mz', 'g2015', null);
INSERT INTO `utilizador` VALUES ('10', 'Docente', '1', 'fillermino@unilurio.ac.mz', 'fr2015', null);
INSERT INTO `utilizador` VALUES ('11', 'Director da Fauldade', '1', 'elidio.silva@unilurio.ac.mz', 'e2015', null);
INSERT INTO `utilizador` VALUES ('22', 'Estudante', '2', 'emenia@unilurio.ac.mz', '4554', null);
INSERT INTO `utilizador` VALUES ('23', 'Estudante', '1', 'valinho@unilurio.ac.mz', '745', null);
INSERT INTO `utilizador` VALUES ('24', 'Estudante', '1', 'esmael@unilurio.ac.mz', '5424', null);
INSERT INTO `utilizador` VALUES ('25', 'Estudante', '1', 'vabral@unilurio.ac.mz', '956', null);
INSERT INTO `utilizador` VALUES ('26', 'Estudante', '1', 'valdimiro@unilurio.ac.mz', '9569', null);
INSERT INTO `utilizador` VALUES ('27', 'Estudante', '2', 'joana@unilurio.ac.mz', '332', null);
INSERT INTO `utilizador` VALUES ('28', 'Estudante', '2', 'nadia@unilurio.ac.mz', '746', null);
INSERT INTO `utilizador` VALUES ('40', 'Estudante', '1', 'felix@unilurio.ac.mz', '5343', null);
INSERT INTO `utilizador` VALUES ('41', 'Estudante', '1', 'cavaldo@unilurio.ac.mzz', '352', null);
INSERT INTO `utilizador` VALUES ('58', 'Docente', '1', 'saide@unilurio.ac.mz', 's2015', null);
