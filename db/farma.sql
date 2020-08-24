-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-08-2020 a las 21:05:36
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `farma`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallespedidos`
--

CREATE TABLE `detallespedidos` (
  `codDetallesPedidos` int(11) NOT NULL,
  `codPedido` int(11) NOT NULL,
  `codFarmaco` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `farmacias`
--

CREATE TABLE `farmacias` (
  `codFarmacia` int(11) NOT NULL,
  `nombreFarmacia` varchar(255) NOT NULL,
  `contrasenaFarmacia` varchar(255) NOT NULL,
  `localidad` varchar(255) NOT NULL,
  `telefono` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `farmacias`
--

INSERT INTO `farmacias` (`codFarmacia`, `nombreFarmacia`, `contrasenaFarmacia`, `localidad`, `telefono`) VALUES
(1099, 'Farmashop 83', '$2y$09$amgsAasNaXli8fwjcqwwKeDBY96fRVY1v8WkbSbiKWl.RsP5pJOSq', 'calle 18 de Julio 1099', 47235550),
(1224, 'COMEPA', '$2y$09$bBRza5kGu.YFiLgwvWzt..fbckN1POk4i8kNyn59VOQgNjNgbpSRO', 'calle Colón 1224', 47232100),
(1395, 'Farmashop 82', '$2y$09$8ZWbqyWUBjxx9nx6HoFxE.0H3cQHnzClL6CSjNTLuX1HQ4gxb4hVO', 'calle 18 de Julio 1395', 47222645);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `farmacofarmacias`
--

CREATE TABLE `farmacofarmacias` (
  `codFarmacoFarmacia` int(11) NOT NULL,
  `codFarmacia` int(11) NOT NULL,
  `codFarmaco` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `farmacofarmacias`
--

INSERT INTO `farmacofarmacias` (`codFarmacoFarmacia`, `codFarmacia`, `codFarmaco`, `stock`) VALUES
(1, 1224, 0, 10),
(2, 1224, 1, 2),
(3, 1224, 3, 7),
(4, 1224, 5, 4),
(5, 1224, 8, 2),
(6, 1224, 9, 8),
(7, 1224, 10, 6),
(8, 1099, 1, 5),
(9, 1099, 2, 8),
(10, 1099, 6, 9),
(11, 1099, 7, 7),
(12, 1099, 8, 2),
(13, 1395, 1, 2),
(14, 1395, 3, 4),
(15, 1395, 4, 7),
(16, 1395, 5, 1),
(17, 1395, 6, 3),
(18, 1395, 9, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `farmacos`
--

CREATE TABLE `farmacos` (
  `codFarmaco` int(11) NOT NULL,
  `nombreFarmaco` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `precioUnitario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `farmacos`
--

INSERT INTO `farmacos` (`codFarmaco`, `nombreFarmaco`, `descripcion`, `precioUnitario`) VALUES
(0, 'Perifar', 'El analgesico de los uruguayos.\r\nPerifar tiene distintas concentraciones y asociaciones para aliviar dolores de cabeza, musculares, menstruales, dentales y cólicos. Además baja la fiebre en forma gradual.', 40),
(1, 'Simvastatina', 'Para controlar el colestero.\r\nSe emplea para reducir el colesterol y los triglicéridos (tipo de grasa) en la sangre.', 100),
(2, 'Aspirina', 'Casi para todo.\r\nTambién conocida como ácido acetil-salicílico (ASA), reduce las sustancias en el cuerpo que producen dolor, fiebre e inflamación.', 50),
(3, 'Omeprazol', 'Para la acidez de estómago .\rIninhibe la bomba de protones y disminuye la producción de ácido al bloquear la enzima de la pared del estómago que se encarga de producir esta sustancia. Este efecto reviene las úlceras y tiene un resultado curativo sobre las úlceras existentes en el esófago, estómago y duodeno.', 115),
(4, 'Lexotiroxina sódica', 'Para reemplazar la tiroxina.\rSe encarga de sustituir una hormona que se suele producir en nuestra glándula tiroidea para regular la energía y el metabolismo del cuerpo. Es una versión artificial de la hormona tiroxina, responsable de aumentar la tasa metabólica de las células de todos los tejidos del organismo y ayuda a mantener la función cerebral, la absorción de los alimentos y la temperatura corporal, entre otros efectos.', 150),
(5, 'Ramipril', 'Para la hipertensión.\r\nTrata la presión arterial alta (hipertensión) o la insuficiencia cardíaca congestiva. También mejora la supervivencia después de un infarto de miocardio y previene la insuficiencia renal por presión alterial alta y diabetes.', 120),
(6, 'Amlodipina', 'Para la hipertensión y la angina.\r\nEnsancha los vasos sanguíneos y mejora el flujo de la sangre, por lo que se usa para reducir la presión arterial y tratar la hipertensión. Ralentizan el latido cardíaco y, al bloquear la señal de calcio en las células de la corteza adrenal, disminuyen la presión arterial.', 130),
(7, 'Paracetamol', 'Para aliviar el dolor.\r\nMedicamento ampliamente empleado para reducir la fiebre; se usa para tratar diversas dolencias como fiebres, dolor de cabeza, dolores musculares, artritis, dolor de espalda o resfriados. ', 80),
(8, 'Atorvastatina', 'Para controlar el colesterol.\r\nDisminuye la cantidad de colesterol que fabrica el hígado. Sirve para reducir los niveles de trigliricéridos en sangre y colesterol \"malo\", al tiempo que aumenta los niveles de colesterol \"bueno\".', 130),
(9, 'Salbutamol', 'Para el asma.\r\nPopularmente conocido como Ventolin, se usa como prevención de broncoespasmos en pacientes con asma, bronquitis, enfisema y otras enfermedades del pulmón. Alivia la tos, la falta de aire y la respiración dificultosa al aumentar el flujo de aire que pasa a través de los tubos bronquiales.', 110),
(10, 'Lansoprazol', 'Para controlar el ácido del estómago.\r\nSe encarga de disminuir la cantidad de ácido producido en el estómago y se usa para tratar y prevenir las úlceras en este órgano y en el intestino y para controlar el ardor.', 130);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `farmacousuarios`
--

CREATE TABLE `farmacousuarios` (
  `codFarmacoUsuario` int(11) NOT NULL,
  `codFarmaco` int(11) NOT NULL,
  `ciUsuario` int(8) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fechaInicio` date DEFAULT NULL,
  `fechaFin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `farmacousuarios`
--

INSERT INTO `farmacousuarios` (`codFarmacoUsuario`, `codFarmaco`, `ciUsuario`, `cantidad`, `fechaInicio`, `fechaFin`) VALUES
(1, 0, 0, 5, NULL, NULL),
(2, 1, 0, 10, NULL, NULL),
(3, 2, 0, 3, NULL, NULL),
(4, 3, 0, 7, NULL, NULL),
(5, 4, 0, 4, NULL, NULL),
(6, 5, 0, 9, NULL, NULL),
(7, 6, 0, 1, NULL, NULL),
(8, 7, 0, 10, NULL, NULL),
(9, 8, 0, 2, NULL, NULL),
(10, 9, 0, 3, NULL, NULL),
(11, 10, 0, 6, NULL, NULL),
(12, 2, 53017189, 4, '2020-05-12', '2020-09-12'),
(13, 5, 53017189, 8, '2020-03-04', '2020-07-04'),
(14, 6, 53017189, 2, '2020-07-25', '2020-09-25'),
(15, 9, 53017189, 3, '2020-08-19', '2021-01-19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `codPedido` int(11) NOT NULL,
  `ciUsuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `direccion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ciUsuario` int(8) NOT NULL,
  `nombreUsuario` varchar(255) NOT NULL,
  `contrasenaUsuario` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ciUsuario`, `nombreUsuario`, `contrasenaUsuario`) VALUES
(0, 'TEST', '$2y$09$BXk1tJHhVAAYEoO0yOMeN.0SdJt589tG6u1KCuMpq4rfUyatoOqtu'),
(53017189, 'Esteban', '$2y$09$RtQtdDAvvnzEwOLfQ8SHwOKI90HMhQ059GDOvw9cJvc4eWbVPk3em');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detallespedidos`
--
ALTER TABLE `detallespedidos`
  ADD PRIMARY KEY (`codDetallesPedidos`),
  ADD KEY `pedido_idx` (`codPedido`),
  ADD KEY `farmaco_idx` (`codFarmaco`);

--
-- Indices de la tabla `farmacias`
--
ALTER TABLE `farmacias`
  ADD PRIMARY KEY (`codFarmacia`);

--
-- Indices de la tabla `farmacofarmacias`
--
ALTER TABLE `farmacofarmacias`
  ADD PRIMARY KEY (`codFarmacoFarmacia`),
  ADD KEY `farmaco_idx` (`codFarmaco`),
  ADD KEY `farmacia_idx` (`codFarmacia`);

--
-- Indices de la tabla `farmacos`
--
ALTER TABLE `farmacos`
  ADD PRIMARY KEY (`codFarmaco`);

--
-- Indices de la tabla `farmacousuarios`
--
ALTER TABLE `farmacousuarios`
  ADD PRIMARY KEY (`codFarmacoUsuario`),
  ADD KEY `farmaco_idx` (`codFarmaco`),
  ADD KEY `usuario_idx` (`ciUsuario`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`codPedido`),
  ADD KEY `usuario_idx` (`ciUsuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ciUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detallespedidos`
--
ALTER TABLE `detallespedidos`
  MODIFY `codDetallesPedidos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `farmacofarmacias`
--
ALTER TABLE `farmacofarmacias`
  MODIFY `codFarmacoFarmacia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `farmacousuarios`
--
ALTER TABLE `farmacousuarios`
  MODIFY `codFarmacoUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallespedidos`
--
ALTER TABLE `detallespedidos`
  ADD CONSTRAINT `farmaco3` FOREIGN KEY (`codFarmaco`) REFERENCES `farmacos` (`codFarmaco`),
  ADD CONSTRAINT `pedido1` FOREIGN KEY (`codPedido`) REFERENCES `pedidos` (`codPedido`);

--
-- Filtros para la tabla `farmacofarmacias`
--
ALTER TABLE `farmacofarmacias`
  ADD CONSTRAINT `farmacia1` FOREIGN KEY (`codFarmacia`) REFERENCES `farmacias` (`codFarmacia`),
  ADD CONSTRAINT `farmaco1` FOREIGN KEY (`codFarmaco`) REFERENCES `farmacos` (`codFarmaco`);

--
-- Filtros para la tabla `farmacousuarios`
--
ALTER TABLE `farmacousuarios`
  ADD CONSTRAINT `farmaco2` FOREIGN KEY (`codFarmaco`) REFERENCES `farmacos` (`codFarmaco`),
  ADD CONSTRAINT `usuario1` FOREIGN KEY (`ciUsuario`) REFERENCES `usuarios` (`ciUsuario`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `usuario2` FOREIGN KEY (`ciUsuario`) REFERENCES `usuarios` (`ciUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
