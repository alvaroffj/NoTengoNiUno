INSERT INTO TIPO_REGISTRO (TIPO_REGISTRO, ESTADO_TIPO_REGISTRO) VALUES ('Ingreso', 0), ('Gasto', 0);
INSERT INTO TIPO_MONEDA (TIPO_MONEDA, SIMBOLO_MONEDA, ESTADO_TIPO_MONEDA) VALUES ('Peso Chileno', '$', 0);
INSERT INTO USUARIO (ID_TIPO_MONEDA, FECHA_SIGN, NOM_USUARIO, APE_USUARIO, EMA_USUARIO) VALUES (1, '2010-12-24', 'Alvaro', 'Flores', 'super.neeph@gmail.com');
INSERT INTO CATEGORIA (ID_USUARIO, CATEGORIA, COLOR_CATEGORIA, ESTADO_CATEGORIA) VALUES (1, 'Comida', '000000', 0);

CREATE TABLE IF NOT EXISTS `CATEGORIA` (
  `ID_CATEGORIA` int(11) NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int(11) NOT NULL,
  `CATEGORIA` varchar(100) DEFAULT NULL,
  `COLOR_CATEGORIA` varchar(6) DEFAULT NULL,
  `ESTADO_CATEGORIA` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID_CATEGORIA`),
  KEY `FK_RELATIONSHIP_8` (`ID_USUARIO`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Volcar la base de datos para la tabla `CATEGORIA`
--

INSERT INTO `CATEGORIA` (`ID_CATEGORIA`, `ID_USUARIO`, `CATEGORIA`, `COLOR_CATEGORIA`, `ESTADO_CATEGORIA`) VALUES
(1, 1, 'Comida', '000000', 0),
(2, 1, 'Cuentas', 'ff0000', 0),
(3, 1, 'Otros', 'cccccc', 0),
(4, 1, 'Celular', '000000', 0),
(5, 1, 'Diversion', '000000', 0),
(6, 1, 'Ropa', '000000', 0),
(7, 1, 'Sueldo', '000000', 0),
(8, 1, 'Transporte', '000000', 0),
(9, 1, 'Diezmo', '000000', 0),
(10, 1, 'Prestamos', '000000', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `REGISTRO`
--

CREATE TABLE IF NOT EXISTS `REGISTRO` (
  `ID_REGISTRO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_TIPO_REGISTRO` int(11) NOT NULL,
  `ID_CATEGORIA` int(11) NOT NULL,
  `ID_USUARIO` int(11) DEFAULT NULL,
  `MONTO_REGISTRO` decimal(8,0) DEFAULT NULL,
  `FECHA_REGISTRO` date DEFAULT NULL,
  `DESC_REGISTRO` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`ID_REGISTRO`),
  KEY `FK_RELATIONSHIP_10` (`ID_TIPO_REGISTRO`),
  KEY `FK_RELATIONSHIP_11` (`ID_CATEGORIA`),
  KEY `FK_RELATIONSHIP_3` (`ID_USUARIO`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Volcar la base de datos para la tabla `REGISTRO`
--

INSERT INTO `REGISTRO` (`ID_REGISTRO`, `ID_TIPO_REGISTRO`, `ID_CATEGORIA`, `ID_USUARIO`, `MONTO_REGISTRO`, `FECHA_REGISTRO`, `DESC_REGISTRO`) VALUES
(1, 2, 8, 1, '1400', '2010-12-23', 'Colectivo desde plaza italia a mi casa'),
(2, 2, 10, 1, '60000', '2010-12-22', 'a Mama (generos)'),
(3, 2, 3, 1, '2000', '2010-12-21', 'amigo secreto tacto'),
(4, 2, 1, 1, '3000', '2010-12-21', 'Otros'),
(5, 2, 1, 1, '850', '2010-12-21', 'Colacion'),
(6, 2, 1, 1, '1690', '2010-12-20', 'Almuerzo'),
(7, 2, 2, 1, '12000', '2010-12-19', 'digitalsupplystore.com'),
(8, 2, 4, 1, '3000', '2011-01-17', 'recarga'),
(9, 2, 6, 1, '13000', '2010-12-17', 'Camisa'),
(18, 2, 1, 1, '2400', '2010-12-26', 'Helado'),
(16, 2, 3, 1, '480', '2010-12-26', 'Loratadina'),
(17, 2, 1, 1, '1440', '2010-12-26', 'Munchkins');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `REGISTRO_TAG`
--

CREATE TABLE IF NOT EXISTS `REGISTRO_TAG` (
  `ID_REGISTRO_TAG` int(11) NOT NULL AUTO_INCREMENT,
  `ID_TAG` int(11) NOT NULL,
  `ID_REGISTRO` int(11) NOT NULL,
  PRIMARY KEY (`ID_REGISTRO_TAG`),
  KEY `FK_RELATIONSHIP_6` (`ID_REGISTRO`),
  KEY `FK_RELATIONSHIP_7` (`ID_TAG`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `REGISTRO_TAG`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tag`
--

CREATE TABLE IF NOT EXISTS `TAG` (
  `ID_TAG` int(11) NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int(11) NOT NULL,
  `TAG` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID_TAG`),
  KEY `FK_RELATIONSHIP_9` (`ID_USUARIO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `tag`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TIPO_MONEDA`
--

CREATE TABLE IF NOT EXISTS `TIPO_MONEDA` (
  `ID_TIPO_MONEDA` int(11) NOT NULL AUTO_INCREMENT,
  `TIPO_MONEDA` varchar(20) DEFAULT NULL,
  `SIMBOLO_MONEDA` varchar(10) DEFAULT NULL,
  `ESTADO_TIPO_MONEDA` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID_TIPO_MONEDA`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `TIPO_MONEDA`
--

INSERT INTO `TIPO_MONEDA` (`ID_TIPO_MONEDA`, `TIPO_MONEDA`, `SIMBOLO_MONEDA`, `ESTADO_TIPO_MONEDA`) VALUES
(1, 'Peso Chileno', '$', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TIPO_REGISTRO`
--

CREATE TABLE IF NOT EXISTS `TIPO_REGISTRO` (
  `ID_TIPO_REGISTRO` int(11) NOT NULL AUTO_INCREMENT,
  `TIPO_REGISTRO` varchar(20) DEFAULT NULL,
  `ESTADO_TIPO_REGISTRO` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID_TIPO_REGISTRO`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `TIPO_REGISTRO`
--

INSERT INTO `TIPO_REGISTRO` (`ID_TIPO_REGISTRO`, `TIPO_REGISTRO`, `ESTADO_TIPO_REGISTRO`) VALUES
(1, 'Ingreso', 0),
(2, 'Egreso', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USUARIO`
--

CREATE TABLE IF NOT EXISTS `USUARIO` (
  `ID_USUARIO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_TIPO_MONEDA` int(11) NOT NULL,
  `FECHA_SIGN` datetime DEFAULT NULL,
  `NOM_USUARIO` varchar(100) DEFAULT NULL,
  `APE_USUARIO` varchar(100) DEFAULT NULL,
  `EMA_USUARIO` varchar(200) DEFAULT NULL,
  `FB_ACCESS_TOKEN` varchar(200) NOT NULL,
  `FB_SECRET` varchar(100) NOT NULL,
  `FB_SESSION_KEY` varchar(100) NOT NULL,
  `FB_SIG` varchar(100) NOT NULL,
  `FB_UID` varchar(100) NOT NULL,
  PRIMARY KEY (`ID_USUARIO`),
  KEY `FK_RELATIONSHIP_12` (`ID_TIPO_MONEDA`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `USUARIO`
--

INSERT INTO `USUARIO` (`ID_USUARIO`, `ID_TIPO_MONEDA`, `FECHA_SIGN`, `NOM_USUARIO`, `APE_USUARIO`, `EMA_USUARIO`, `FB_ACCESS_TOKEN`, `FB_SECRET`, `FB_SESSION_KEY`, `FB_SIG`, `FB_UID`) VALUES
(1, 1, '2010-12-24 00:00:00', 'Alvaro', 'Flores', 'super.neeph@gmail.com', '', '', '', '', '');
