SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `ques_preguntas`;
CREATE TABLE `ques_preguntas` (
  `cpregunta` int(10) UNSIGNED ZEROFILL NOT NULL,
  `pregunta` varchar(80) COLLATE utf8_bin NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `crea_user` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `crea_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mod_user` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `mod_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TRIGGER IF EXISTS `set_crea_ques_preguntas`;
DELIMITER $$
CREATE TRIGGER `set_crea_ques_preguntas` BEFORE INSERT ON `ques_preguntas` FOR EACH ROW IF (NEW.crea_user IS NULL || NEW.crea_user='') THEN SET NEW.crea_user = UPPER(SUBSTR(USER(), 1,(LOCATE('@', USER())-1))); END IF
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `set_mod_ques_preguntas`;
DELIMITER $$
CREATE TRIGGER `set_mod_ques_preguntas` BEFORE UPDATE ON `ques_preguntas` FOR EACH ROW IF (NEW.mod_user IS NULL || NEW.mod_user='') THEN SET NEW.mod_user = UPPER(SUBSTR(USER(), 1,(LOCATE('@', USER())-1))); END IF
$$
DELIMITER ;

ALTER TABLE `ques_preguntas`
  ADD PRIMARY KEY (`cpregunta`);

ALTER TABLE `ques_preguntas`
  MODIFY `cpregunta` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

DROP TABLE IF EXISTS `ques_repuestas`;
CREATE TABLE `ques_repuestas` (
  `crepuesta` int(10) UNSIGNED ZEROFILL NOT NULL,
  `cconjunto` int(10) UNSIGNED ZEROFILL NOT NULL,
  `valor` int(1) NOT NULL,
  `texto` varchar(150) COLLATE utf8_bin NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `crea_user` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `crea_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mod_user` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `mod_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TRIGGER IF EXISTS `set_crea_ques_repuestas`;
DELIMITER $$
CREATE TRIGGER `set_crea_ques_repuestas` BEFORE INSERT ON `ques_repuestas` FOR EACH ROW IF (NEW.crea_user IS NULL || NEW.crea_user='') THEN SET NEW.crea_user = UPPER(SUBSTR(USER(), 1,(LOCATE('@', USER())-1))); END IF
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `set_mod_ques_repuestas`;
DELIMITER $$
CREATE TRIGGER `set_mod_ques_repuestas` BEFORE UPDATE ON `ques_repuestas` FOR EACH ROW IF (NEW.mod_user IS NULL || NEW.mod_user='') THEN SET NEW.mod_user = UPPER(SUBSTR(USER(), 1,(LOCATE('@', USER())-1))); END IF
$$
DELIMITER ;

ALTER TABLE `ques_repuestas`
  ADD PRIMARY KEY (`crepuesta`),
  ADD KEY `cconjunto` (`cconjunto`);

ALTER TABLE `ques_repuestas`
  MODIFY `crepuesta` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

DROP TABLE IF EXISTS `ques_cuestionario`;
CREATE TABLE `ques_cuestionario` (
  `ccuestionario` int(10) UNSIGNED ZEROFILL NOT NULL,
  `tipo` varchar(3) COLLATE utf8_bin NOT NULL DEFAULT 'VYF',
  `cpregunta` int(10) UNSIGNED ZEROFILL NOT NULL,
  `cconjunto` int(10) UNSIGNED ZEROFILL NOT NULL,
  `req_is` int(1) NOT NULL DEFAULT '1',
  `min_fotos` int(2) NOT NULL DEFAULT '0',
  `req_obs` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `crea_user` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `crea_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mod_user` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `mod_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TRIGGER IF EXISTS `set_crea_ques_cuestionario`;
DELIMITER $$
CREATE TRIGGER `set_crea_ques_cuestionario` BEFORE INSERT ON `ques_cuestionario` FOR EACH ROW IF (NEW.crea_user IS NULL || NEW.crea_user='') THEN SET NEW.crea_user = UPPER(SUBSTR(USER(), 1,(LOCATE('@', USER())-1))); END IF
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `set_mod_ques_cuestionario`;
DELIMITER $$
CREATE TRIGGER `set_mod_ques_cuestionario` BEFORE UPDATE ON `ques_cuestionario` FOR EACH ROW IF (NEW.mod_user IS NULL || NEW.mod_user='') THEN SET NEW.mod_user = UPPER(SUBSTR(USER(), 1,(LOCATE('@', USER())-1))); END IF
$$
DELIMITER ;

ALTER TABLE `ques_cuestionario`
  ADD PRIMARY KEY (`ccuestionario`),
  ADD KEY `cpregunta` (`cpregunta`),
  ADD KEY `cconjunto` (`cconjunto`);

ALTER TABLE `ques_cuestionario`
  MODIFY `ccuestionario` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

ALTER TABLE `ques_cuestionario`
  ADD CONSTRAINT `fk_cconjunto_ques_cuestionario` FOREIGN KEY (`cconjunto`) REFERENCES `ques_repuestas` (`cconjunto`),
  ADD CONSTRAINT `fk_cpregunta_ques_cuestionario` FOREIGN KEY (`cpregunta`) REFERENCES `ques_preguntas` (`cpregunta`);


SET FOREIGN_KEY_CHECKS=1;
COMMIT;
