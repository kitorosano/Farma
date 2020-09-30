-- Base de datos FARMA
-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-08-2020 a las 21:38:44
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepedidos`
--

CREATE TABLE `detallepedidos` (
  `idDetallePedidos` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `idFarmaco` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `farmacias`
--

CREATE TABLE `farmacias` (
  `idFarmacia` int(11) NOT NULL,
  `codFarmacia` int(11) NOT NULL,
  `nombreFarmacia` varchar(255) NOT NULL,
  `contrasenaFarmacia` varchar(255) NOT NULL,
  `localidad` varchar(255) NOT NULL,
  `telefono` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `farmacias`
--

INSERT INTO `farmacias` (`idFarmacia`, `codFarmacia`, `nombreFarmacia`, `contrasenaFarmacia`, `localidad`, `telefono`) VALUES
(1, 1224, 'COMEPA', '$2y$09$bBRza5kGu.YFiLgwvWzt..fbckN1POk4i8kNyn59VOQgNjNgbpSRO', 'calle Colón 1224', 47232100),
(2, 1395, 'Farmashop 82', '$2y$09$8ZWbqyWUBjxx9nx6HoFxE.0H3cQHnzClL6CSjNTLuX1HQ4gxb4hVO', 'calle 18 de Julio 1395', 47222645),
(3, 1099, 'Farmashop 83', '$2y$09$amgsAasNaXli8fwjcqwwKeDBY96fRVY1v8WkbSbiKWl.RsP5pJOSq', 'calle 18 de Julio 1099', 47235550);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `farmacofarmacias`
--

CREATE TABLE `farmacofarmacias` (
  `idFarmacia` int(11) NOT NULL,
  `idFarmaco` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `farmacofarmacias`
--

INSERT INTO `farmacofarmacias` (`idFarmacia`, `idFarmaco`, `stock`) VALUES
(1, 1, 10),
(1, 2, 2),
(1, 4, 7),
(1, 5, 4),
(1, 9, 2),
(1, 10, 8),
(1, 11, 6),
(2, 2, 2),
(2, 4, 4),
(2, 5, 7),
(2, 6, 1),
(2, 7, 3),
(2, 10, 2),
(3, 2, 5),
(3, 3, 8),
(3, 7, 9),
(3, 8, 7),
(3, 9, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `farmacos`
--

CREATE TABLE `farmacos` (
  `idFarmaco` int(11) NOT NULL,
  `codFarmaco` int(11) NOT NULL,
  `nombreFarmaco` varchar(255) DEFAULT NULL,
  `nombreSugerido` varchar(255) NOT NULL,
  `precioUnitario` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `farmacos`
--

INSERT INTO `farmacos` (`idFarmaco`, `codFarmaco`, `nombreFarmaco`, `nombreSugerido`, `precioUnitario`) VALUES
(1, 0, 'Ibuprofeno y citrato de orfenadrina.', 'Perifar', '40.00'),
(2, 1, 'Hidroximetilglutaril-coenzima A (HMG-CoA)', 'Simvastatina', '100.00'),
(3, 2, 'Ácido acetilsalicílico, 400 mg y ácido ascórbico (vitamina C), 240 mg.', 'Aspirina', '50.00'),
(4, 3, 'Capsula 20mg de Omeprazol', 'Omeprazol', '115.00'),
(5, 4, 'Levotiroxina sódica 50mg', 'Lexotiroxina sódica', '120.00'),
(6, 5, '', 'Ramipril', '120.00'),
(7, 6, '', 'Amlodipina', '130.00'),
(8, 7, '', 'Paracetamol', '80.00'),
(9, 8, '', 'Atorvastatina', '130.00'),
(10, 9, '', 'Salbutamol', '110.00'),
(11, 10, '', 'Lansoprazol', '130.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `farmacousuarios`
--

CREATE TABLE `farmacousuarios` (
  `idUsuario` int(11) NOT NULL,
  `idFarmaco` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fechaInicio` date DEFAULT NULL,
  `fechaFin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `farmacousuarios`
--

INSERT INTO `farmacousuarios` (`idUsuario`, `idFarmaco`, `cantidad`, `fechaInicio`, `fechaFin`) VALUES
(0, 1, 5, NULL, NULL),
(0, 2, 10, NULL, NULL),
(0, 3, 3, NULL, NULL),
(0, 4, 7, NULL, NULL),
(0, 5, 4, NULL, NULL),
(0, 6, 9, NULL, NULL),
(0, 7, 1, NULL, NULL),
(0, 8, 10, NULL, NULL),
(0, 9, 2, NULL, NULL),
(0, 10, 3, NULL, NULL),
(0, 11, 6, NULL, NULL),
(1, 2, 4, '2020-05-12', '2020-09-12'),
(1, 5, 8, '2020-03-04', '2020-07-04'),
(1, 6, 2, '2020-07-25', '2020-09-25'),
(1, 9, 3, '2020-08-19', '2021-01-19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idFarmacia` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `direccion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `ciUsuario` int(8) NOT NULL,
  `nombreUsuario` varchar(255) NOT NULL,
  `contrasenaUsuario` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `ciUsuario`, `nombreUsuario`, `contrasenaUsuario`) VALUES
(0, 0, 'TEST', '$2y$09$BXk1tJHhVAAYEoO0yOMeN.0SdJt589tG6u1KCuMpq4rfUyatoOqtu'),
(1, 53017189, 'Esteban', '$2y$09$RtQtdDAvvnzEwOLfQ8SHwOKI90HMhQ059GDOvw9cJvc4eWbVPk3em');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detallepedidos`
--
ALTER TABLE `detallepedidos`
  ADD PRIMARY KEY (`idDetallePedidos`),
  ADD KEY `idPedido` (`idPedido`),
  ADD KEY `idFarmaco` (`idFarmaco`);

--
-- Indices de la tabla `farmacias`
--
ALTER TABLE `farmacias`
  ADD PRIMARY KEY (`idFarmacia`),
  ADD UNIQUE KEY `codFarmacia` (`codFarmacia`);

--
-- Indices de la tabla `farmacofarmacias`
--
ALTER TABLE `farmacofarmacias`
  ADD PRIMARY KEY (`idFarmacia`,`idFarmaco`),
  ADD KEY `idFarmaco` (`idFarmaco`);

--
-- Indices de la tabla `farmacos`
--
ALTER TABLE `farmacos`
  ADD PRIMARY KEY (`idFarmaco`),
  ADD UNIQUE KEY `codFarmaco` (`codFarmaco`);

--
-- Indices de la tabla `farmacousuarios`
--
ALTER TABLE `farmacousuarios`
  ADD PRIMARY KEY (`idUsuario`,`idFarmaco`),
  ADD KEY `idFarmaco` (`idFarmaco`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idFarmacia` (`idFarmacia`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `ciUsuario` (`ciUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detallepedidos`
--
ALTER TABLE `detallepedidos`
  MODIFY `idDetallePedidos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `farmacias`
--
ALTER TABLE `farmacias`
  MODIFY `idFarmacia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `farmacos`
--
ALTER TABLE `farmacos`
  MODIFY `idFarmaco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallepedidos`
--
ALTER TABLE `detallepedidos`
  ADD CONSTRAINT `detallepedidos_ibfk_1` FOREIGN KEY (`idPedido`) REFERENCES `pedidos` (`idPedido`) ON DELETE CASCADE,
  ADD CONSTRAINT `detallepedidos_ibfk_2` FOREIGN KEY (`idFarmaco`) REFERENCES `farmacos` (`idFarmaco`);

--
-- Filtros para la tabla `farmacofarmacias`
--
ALTER TABLE `farmacofarmacias`
  ADD CONSTRAINT `farmacofarmacias_ibfk_1` FOREIGN KEY (`idFarmacia`) REFERENCES `farmacias` (`idFarmacia`) ON UPDATE CASCADE,
  ADD CONSTRAINT `farmacofarmacias_ibfk_2` FOREIGN KEY (`idFarmaco`) REFERENCES `farmacos` (`idFarmaco`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `farmacousuarios`
--
ALTER TABLE `farmacousuarios`
  ADD CONSTRAINT `farmacousuarios_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `farmacousuarios_ibfk_2` FOREIGN KEY (`idFarmaco`) REFERENCES `farmacos` (`idFarmaco`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`idFarmacia`) REFERENCES `farmacias` (`idFarmacia`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
