# Host: localhost  (Version: 5.5.24-log)
# Date: 2015-03-08 16:46:17
# Generator: MySQL-Front 5.3  (Build 4.175)

/*!40101 SET NAMES latin1 */;

#
# Structure for table "actividad_economica"
#

CREATE TABLE `actividad_economica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `estado` enum('ACTIVO','INACTIVO') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

#
# Structure for table "ahorro"
#

CREATE TABLE `ahorro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `socio_id` int(11) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` enum('DEUDA','PAGADO') DEFAULT NULL,
  `tipo` enum('OBLIGATORIO','PRIMER_PAGO') NOT NULL,
  `saldo_contra` decimal(10,2) DEFAULT NULL,
  `saldo_favor` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for table "ahorro_deposito"
#

CREATE TABLE `ahorro_deposito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` decimal(10,2) NOT NULL,
  `entidad_bancaria_id` int(11) NOT NULL,
  `cod_comprobante_entidad` varchar(45) NOT NULL,
  `fecha_comprobante_entidad` datetime NOT NULL,
  `sucursal_comprobante_id` int(11) NOT NULL,
  `cod_comprobante_su` varchar(45) NOT NULL,
  `fecha_comprobante_su` datetime NOT NULL,
  `usuario_creacion_id` int(11) NOT NULL,
  `socio_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for table "ahorro_detalle"
#

CREATE TABLE `ahorro_detalle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `usuario_creacion` varchar(45) NOT NULL,
  `ahorro_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ahorro_detalle_ahorro1_idx` (`ahorro_id`),
  CONSTRAINT `fk_ahorro_detalle_ahorro1` FOREIGN KEY (`ahorro_id`) REFERENCES `ahorro` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for table "ahorro_retiro"
#

CREATE TABLE `ahorro_retiro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `socio_id` int(10) NOT NULL,
  `sucursal_id` int(10) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `fecha_retiro` datetime NOT NULL,
  `entidad_bancaria_id` int(11) NOT NULL,
  `usuario_creacion_id` int(11) NOT NULL,
  `numero_cheque` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for table "credito"
#

CREATE TABLE `credito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `socio_id` int(11) NOT NULL,
  `garante_id` int(11) NOT NULL,
  `sucursal_id` int(11) NOT NULL,
  `fecha_credito` datetime NOT NULL,
  `fecha_limite` datetime NOT NULL,
  `cantidad_total` decimal(10,2) NOT NULL,
  `total_pagar` decimal(10,2) NOT NULL,
  `interes` decimal(3,2) NOT NULL,
  `total_interes` decimal(10,2) NOT NULL,
  `estado` enum('DEUDA','PAGADO') NOT NULL,
  `periodos` int(11) NOT NULL,
  `saldo_contra` decimal(10,2) DEFAULT NULL,
  `saldo_favor` decimal(10,2) DEFAULT NULL,
  `anulado` enum('SI','NO') DEFAULT NULL,
  `usuario_creacion_id` int(11) NOT NULL,
  `numero_cheque` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

#
# Structure for table "credito_amortizacion"
#

CREATE TABLE `credito_amortizacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nro_cuota` int(11) NOT NULL,
  `fecha_pago` date NOT NULL,
  `cuota` decimal(10,2) NOT NULL,
  `interes` decimal(10,2) NOT NULL,
  `amortizacion` decimal(10,2) NOT NULL,
  `mora` decimal(10,2) DEFAULT NULL,
  `estado` enum('DEUDA','PAGADO') NOT NULL,
  `saldo_contra` decimal(10,2) DEFAULT NULL,
  `saldo_favor` decimal(10,2) DEFAULT NULL,
  `credito_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_credito_amortizacion_credito1_idx` (`credito_id`),
  CONSTRAINT `fk_credito_amortizacion_credito1` FOREIGN KEY (`credito_id`) REFERENCES `credito` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

#
# Structure for table "credito_deposito"
#

CREATE TABLE `credito_deposito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` decimal(10,2) NOT NULL,
  `entidad_bancaria_id` int(11) NOT NULL,
  `cod_comprobante_entidad` varchar(45) NOT NULL,
  `fecha_comprobante_entidad` datetime NOT NULL,
  `sucursal_comprobante_id` int(11) NOT NULL,
  `cod_comprobante_su` varchar(45) NOT NULL,
  `fecha_comprobante_su` datetime NOT NULL,
  `observaciones` text,
  `credito_id` int(11) NOT NULL,
  `usuario_creacion_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_credito_deposito_credito1_idx` (`credito_id`),
  CONSTRAINT `fk_credito_deposito_credito1` FOREIGN KEY (`credito_id`) REFERENCES `credito` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

#
# Structure for table "credito_devolucion"
#

CREATE TABLE `credito_devolucion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` decimal(10,2) NOT NULL,
  `estado` enum('NO DEVUELTO','DEVUELTO') NOT NULL,
  `usuario_devolucion_id` int(11) DEFAULT NULL,
  `fecha_devolucion` datetime DEFAULT NULL,
  `credito_deposito_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_credito_devolucion_credito_deposito1_idx` (`credito_deposito_id`),
  CONSTRAINT `fk_credito_devolucion_credito_deposito1` FOREIGN KEY (`credito_deposito_id`) REFERENCES `credito_deposito` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for table "cruge_authitem"
#

CREATE TABLE `cruge_authitem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for table "cruge_authitemchild"
#

CREATE TABLE `cruge_authitemchild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `crugeauthitemchild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `cruge_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `crugeauthitemchild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `cruge_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for table "cruge_field"
#

CREATE TABLE `cruge_field` (
  `idfield` int(11) NOT NULL AUTO_INCREMENT,
  `fieldname` varchar(20) NOT NULL,
  `longname` varchar(50) DEFAULT NULL,
  `position` int(11) DEFAULT '0',
  `required` int(11) DEFAULT '0',
  `fieldtype` int(11) DEFAULT '0',
  `fieldsize` int(11) DEFAULT '20',
  `maxlength` int(11) DEFAULT '45',
  `showinreports` int(11) DEFAULT '0',
  `useregexp` varchar(512) DEFAULT NULL,
  `useregexpmsg` varchar(512) DEFAULT NULL,
  `predetvalue` mediumblob,
  PRIMARY KEY (`idfield`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for table "cruge_session"
#

CREATE TABLE `cruge_session` (
  `idsession` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `created` bigint(30) DEFAULT NULL,
  `expire` bigint(30) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `ipaddress` varchar(45) DEFAULT NULL,
  `usagecount` int(11) DEFAULT '0',
  `lastusage` bigint(30) DEFAULT NULL,
  `logoutdate` bigint(30) DEFAULT NULL,
  `ipaddressout` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idsession`),
  KEY `crugesession_iduser` (`iduser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

#
# Structure for table "cruge_system"
#

CREATE TABLE `cruge_system` (
  `idsystem` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `largename` varchar(45) DEFAULT NULL,
  `sessionmaxdurationmins` int(11) DEFAULT '30',
  `sessionmaxsameipconnections` int(11) DEFAULT '10',
  `sessionreusesessions` int(11) DEFAULT '1' COMMENT '1yes 0no',
  `sessionmaxsessionsperday` int(11) DEFAULT '-1',
  `sessionmaxsessionsperuser` int(11) DEFAULT '-1',
  `systemnonewsessions` int(11) DEFAULT '0' COMMENT '1yes 0no',
  `systemdown` int(11) DEFAULT '0',
  `registerusingcaptcha` int(11) DEFAULT '0',
  `registerusingterms` int(11) DEFAULT '0',
  `terms` blob,
  `registerusingactivation` int(11) DEFAULT '1',
  `defaultroleforregistration` varchar(64) DEFAULT NULL,
  `registerusingtermslabel` varchar(100) DEFAULT NULL,
  `registrationonlogin` int(11) DEFAULT '1',
  PRIMARY KEY (`idsystem`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

#
# Structure for table "cruge_user"
#

CREATE TABLE `cruge_user` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `regdate` bigint(30) DEFAULT NULL,
  `actdate` bigint(30) DEFAULT NULL,
  `logondate` bigint(30) DEFAULT NULL,
  `username` varchar(64) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL COMMENT 'Hashed password',
  `authkey` varchar(100) DEFAULT NULL COMMENT 'llave de autentificacion',
  `state` int(11) DEFAULT '0',
  `totalsessioncounter` int(11) DEFAULT '0',
  `currentsessioncounter` int(11) DEFAULT '0',
  PRIMARY KEY (`iduser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

#
# Structure for table "cruge_fieldvalue"
#

CREATE TABLE `cruge_fieldvalue` (
  `idfieldvalue` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `idfield` int(11) NOT NULL,
  `value` blob,
  PRIMARY KEY (`idfieldvalue`),
  KEY `fk_cruge_fieldvalue_cruge_user1` (`iduser`),
  KEY `fk_cruge_fieldvalue_cruge_field1` (`idfield`),
  CONSTRAINT `fk_cruge_fieldvalue_cruge_field1` FOREIGN KEY (`idfield`) REFERENCES `cruge_field` (`idfield`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_cruge_fieldvalue_cruge_user1` FOREIGN KEY (`iduser`) REFERENCES `cruge_user` (`iduser`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for table "cruge_authassignment"
#

CREATE TABLE `cruge_authassignment` (
  `userid` int(11) NOT NULL,
  `bizrule` text,
  `data` text,
  `itemname` varchar(64) NOT NULL,
  PRIMARY KEY (`userid`,`itemname`),
  KEY `fk_cruge_authassignment_cruge_authitem1` (`itemname`),
  KEY `fk_cruge_authassignment_user` (`userid`),
  CONSTRAINT `fk_cruge_authassignment_cruge_authitem1` FOREIGN KEY (`itemname`) REFERENCES `cruge_authitem` (`name`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cruge_authassignment_user` FOREIGN KEY (`userid`) REFERENCES `cruge_user` (`iduser`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for table "cruge_user_sucursal"
#

CREATE TABLE `cruge_user_sucursal` (
  `cruge_id` int(11) NOT NULL,
  `sucursal_id` int(11) NOT NULL,
  PRIMARY KEY (`cruge_id`,`sucursal_id`),
  UNIQUE KEY `cruge_id_UNIQUE` (`cruge_id`),
  UNIQUE KEY `sucursal_id_UNIQUE` (`sucursal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for table "persona_etapa"
#

CREATE TABLE `persona_etapa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) NOT NULL,
  `peso` int(3) DEFAULT NULL,
  `estado` enum('ACTIVO','INACTIVO') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for table "provincia"
#

CREATE TABLE `provincia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(21) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for table "canton"
#

CREATE TABLE `canton` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `provincia_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_canton_provincia1_idx` (`provincia_id`),
  CONSTRAINT `fk_canton_provincia1` FOREIGN KEY (`provincia_id`) REFERENCES `provincia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

#
# Structure for table "parroquia"
#

CREATE TABLE `parroquia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(32) NOT NULL,
  `canton_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_parroquia_canton1_idx` (`canton_id`),
  CONSTRAINT `fk_parroquia_canton1` FOREIGN KEY (`canton_id`) REFERENCES `canton` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

#
# Structure for table "barrio"
#

CREATE TABLE `barrio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `parroquia_id` int(11) NOT NULL,
  `tipo` enum('B','C') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_barrio_parroquia1_idx` (`parroquia_id`),
  CONSTRAINT `fk_barrio_parroquia1` FOREIGN KEY (`parroquia_id`) REFERENCES `parroquia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for table "direccion"
#

CREATE TABLE `direccion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `calle_1` varchar(128) DEFAULT NULL,
  `calle_2` varchar(128) DEFAULT NULL,
  `numero` varchar(8) DEFAULT NULL,
  `referencia` text,
  `tipo` enum('C','S','E') NOT NULL,
  `barrio_id` int(11) DEFAULT NULL,
  `parroquia_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_direccion_barrio1_idx` (`barrio_id`),
  KEY `fk_direccion_parroquia1_idx` (`parroquia_id`),
  CONSTRAINT `fk_direccion_barrio1` FOREIGN KEY (`barrio_id`) REFERENCES `barrio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_direccion_parroquia1` FOREIGN KEY (`parroquia_id`) REFERENCES `parroquia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

#
# Structure for table "entidad_bancaria"
#

CREATE TABLE `entidad_bancaria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `direccion_id` int(11) NOT NULL,
  `estado` enum('ACTIVO','INACTIVO') NOT NULL,
  `num_cuenta` varchar(45) NOT NULL,
  `tipo_cuenta` enum('AHORRO','CORRIENTE') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_entidad_bacaria_direccion1_idx` (`direccion_id`),
  CONSTRAINT `fk_entidad_bacaria_direccion1` FOREIGN KEY (`direccion_id`) REFERENCES `direccion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

#
# Structure for table "sucursal"
#

CREATE TABLE `sucursal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `direccion_id` int(11) NOT NULL,
  `estado` enum('ACTIVO','INACTIVO') NOT NULL,
  `valor_inscripcion` double NOT NULL,
  `valor_ahorro` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sucursal_direccion1_idx` (`direccion_id`),
  CONSTRAINT `fk_sucursal_direccion1` FOREIGN KEY (`direccion_id`) REFERENCES `direccion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

#
# Structure for table "persona"
#

CREATE TABLE `persona` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `primer_nombre` varchar(20) NOT NULL,
  `segundo_nombre` varchar(20) DEFAULT NULL,
  `apellido_paterno` varchar(30) NOT NULL,
  `apellido_materno` varchar(30) DEFAULT NULL,
  `cedula` varchar(20) NOT NULL,
  `ruc` varchar(13) DEFAULT NULL,
  `telefono` varchar(24) DEFAULT NULL,
  `celular` varchar(24) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `descripcion` text,
  `tipo` enum('FUNDADOR','NUEVO') DEFAULT NULL,
  `estado` enum('ACTIVO','INACTIVO','RETIRADO') NOT NULL DEFAULT 'ACTIVO',
  `fecha_creacion` datetime NOT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  `usuario_creacion_id` int(11) NOT NULL,
  `usuario_actualizacion_id` int(11) DEFAULT NULL,
  `aprobado` tinyint(4) DEFAULT '0',
  `sucursal_id` int(11) NOT NULL,
  `persona_etapa_id` int(11) DEFAULT NULL,
  `direccion_domicilio_id` int(11) DEFAULT NULL,
  `direccion_negocio_id` int(11) DEFAULT NULL,
  `sexo` enum('M','F') DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `carga_familiar` int(3) DEFAULT NULL,
  `discapacidad` enum('SI','NO') DEFAULT NULL,
  `estado_civil` enum('SOLTERO','CASADO','DIVORCIADO','VIUDO') DEFAULT NULL,
  `actividad_economica_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_sucursal1_idx` (`sucursal_id`),
  KEY `fk_cliente_direccion1_idx` (`direccion_domicilio_id`),
  KEY `fk_cliente_direccion2_idx` (`direccion_negocio_id`),
  KEY `fk_persona_persona_etapa1_idx` (`persona_etapa_id`),
  KEY `fk_persona_actividad_economica1_idx` (`actividad_economica_id`),
  CONSTRAINT `fk_cliente_direccion1` FOREIGN KEY (`direccion_domicilio_id`) REFERENCES `direccion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_direccion2` FOREIGN KEY (`direccion_negocio_id`) REFERENCES `direccion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_sucursal1` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursal` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_persona_actividad_economica1` FOREIGN KEY (`actividad_economica_id`) REFERENCES `actividad_economica` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_persona_persona_etapa1` FOREIGN KEY (`persona_etapa_id`) REFERENCES `persona_etapa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
