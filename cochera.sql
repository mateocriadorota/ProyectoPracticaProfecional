-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-06-2023 a las 12:05:49
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cochera`
--
CREATE DATABASE IF NOT EXISTS `cochera` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cochera`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `dni` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `dni`) VALUES
(83, '11545695'),
(81, '1545659595'),
(80, '15458595'),
(79, '17848595'),
(78, '33656956'),
(77, '34959686'),
(82, '3695859');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cochera`
--

CREATE TABLE `cochera` (
  `id_cochera` int(11) NOT NULL,
  `tamaniomax` int(11) NOT NULL,
  `ubicacion` varchar(12) NOT NULL,
  `techado` int(11) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cochera`
--

INSERT INTO `cochera` (`id_cochera`, `tamaniomax`, `ubicacion`, `techado`, `activo`) VALUES
(1, 2, '444', 1, 1),
(2, 2, '1000', 0, 1),
(3, 2, '999', 0, 1),
(4, 2, '999', 0, 1),
(5, 2, '5', 1, 1),
(6, 2, '999', 1, 1),
(7, 3, '999', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `apellido` varchar(22) NOT NULL,
  `cod_empleado` int(11) NOT NULL,
  `nombre` varchar(22) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`apellido`, `cod_empleado`, `nombre`, `id_rol`, `username`, `password`, `activo`) VALUES
('PAIVA', 1, 'AGUSTIN', 2, 'PAIVA', '1', 0),
('CRIADOROTA', 2, 'MATEO', 1, 'CRIADO', '1', 1),
('AIELLO', 3, 'AGUSTIN', 1, 'AIELLO', '1', 1),
('GONZALEZ', 4, 'JUAN', 1, 'GONZALEZ', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `cod_empleado` int(11) NOT NULL,
  `cod_reserva` int(11) NOT NULL,
  `horario_salida` datetime NOT NULL,
  `id_factura` int(11) NOT NULL,
  `id_tipopago` int(11) NOT NULL,
  `monto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`cod_empleado`, `cod_reserva`, `horario_salida`, `id_factura`, `id_tipopago`, `monto`) VALUES
(1, 410, '2023-06-24 06:35:05', 136, 1, 5),
(1, 409, '2023-06-24 06:35:11', 137, 2, 63),
(1, 408, '2023-06-24 06:35:15', 138, 2, 83),
(1, 407, '2023-06-24 06:35:25', 139, 3, 63),
(1, 406, '2023-06-24 06:35:30', 140, 4, 50),
(1, 405, '2023-06-24 06:35:33', 141, 1, 50),
(1, 411, '2023-06-24 07:02:07', 142, 1, 83);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `codigo_reserva` int(11) NOT NULL,
  `hora_entrada` datetime NOT NULL,
  `estado` int(11) NOT NULL,
  `id_cochera` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `patente` varchar(12) NOT NULL,
  `cod_empleado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`codigo_reserva`, `hora_entrada`, `estado`, `id_cochera`, `id_cliente`, `patente`, `cod_empleado`) VALUES
(405, '2023-06-24 06:33:02', 0, 1, 77, 'AB123BC', 1),
(406, '2023-06-24 06:33:21', 0, 1, 78, 'MCL321L', 1),
(407, '2023-06-24 06:33:36', 0, 2, 79, 'AB610BW', 1),
(408, '2023-06-24 06:33:53', 0, 7, 80, 'QR155S', 1),
(409, '2023-06-24 06:34:20', 0, 3, 81, '548QWS', 1),
(410, '2023-06-24 06:34:52', 0, 4, 82, 'FDS155D', 1),
(411, '2023-06-24 07:01:59', 0, 7, 83, 'AJK132A', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre`) VALUES
(1, 'admin'),
(2, 'empleado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarifa`
--

CREATE TABLE `tarifa` (
  `id_tarifa` int(11) NOT NULL,
  `hora` int(11) NOT NULL,
  `6horas` int(11) NOT NULL,
  `12horas` int(11) NOT NULL,
  `24horas` int(11) NOT NULL,
  `semana` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tarifa`
--

INSERT INTO `tarifa` (`id_tarifa`, `hora`, `6horas`, `12horas`, `24horas`, `semana`, `mes`, `activo`) VALUES
(21, 0, 0, 0, 0, 0, 0, 0),
(22, 0, 0, 0, 0, 0, 0, 0),
(23, 600, 580, 550, 530, 0, 0, 1),
(24, 750, 730, 710, 660, 0, 0, 1),
(25, 1000, 970, 950, 920, 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_pago`
--

CREATE TABLE `tipo_pago` (
  `id_tipopago` int(11) NOT NULL,
  `nombre` varchar(22) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_pago`
--

INSERT INTO `tipo_pago` (`id_tipopago`, `nombre`, `activo`) VALUES
(1, 'efectivo', 0),
(2, 'transferencia', 0),
(3, 'mercadopago', 0),
(4, 'tarjeta', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_vehiculo`
--

CREATE TABLE `tipo_vehiculo` (
  `id_tipovehiculo` int(11) NOT NULL,
  `nombre` varchar(22) NOT NULL,
  `tamanio` int(11) NOT NULL,
  `id_tarifa` int(3) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_vehiculo`
--

INSERT INTO `tipo_vehiculo` (`id_tipovehiculo`, `nombre`, `tamanio`, `id_tarifa`, `activo`) VALUES
(24, 'MOTO', 1, 23, 1),
(25, 'AUTO', 2, 24, 1),
(26, 'CAMION', 3, 25, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `patente` varchar(10) NOT NULL,
  `id_tipovehiculo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`patente`, `id_tipovehiculo`) VALUES
('AB123BC', 24),
('MCL321L', 24),
('548QWS', 25),
('AB610BW', 25),
('FDS155D', 25),
('AJK132A', 26),
('QR155S', 26);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `dni` (`dni`);

--
-- Indices de la tabla `cochera`
--
ALTER TABLE `cochera`
  ADD PRIMARY KEY (`id_cochera`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`cod_empleado`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id_factura`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`codigo_reserva`),
  ADD KEY `hora_entrada` (`hora_entrada`),
  ADD KEY `estado` (`estado`),
  ADD KEY `id_cochera` (`id_cochera`),
  ADD KEY `dni` (`id_cliente`),
  ADD KEY `patente` (`patente`),
  ADD KEY `FK_Reserva_Empleado` (`cod_empleado`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `tarifa`
--
ALTER TABLE `tarifa`
  ADD PRIMARY KEY (`id_tarifa`);

--
-- Indices de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  ADD PRIMARY KEY (`id_tipopago`);

--
-- Indices de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  ADD PRIMARY KEY (`id_tipovehiculo`),
  ADD KEY `id_tarifa` (`id_tarifa`);

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`patente`),
  ADD KEY `id_tipoveiculo` (`id_tipovehiculo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT de la tabla `cochera`
--
ALTER TABLE `cochera`
  MODIFY `id_cochera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=334;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `cod_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `codigo_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=412;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tarifa`
--
ALTER TABLE `tarifa`
  MODIFY `id_tarifa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  MODIFY `id_tipopago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  MODIFY `id_tipovehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
