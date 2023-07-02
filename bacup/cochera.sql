-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-06-2023 a las 22:15:41
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
(24, '1'),
(64, '11'),
(8, '1111'),
(37, '11111'),
(9, '111141141'),
(28, '12'),
(6, '123'),
(16, '12312'),
(19, '123123'),
(21, '12313'),
(10, '1231421'),
(3, '1234'),
(59, '132'),
(48, '1321'),
(25, '2'),
(39, '21313'),
(1, '2134'),
(4, '213456'),
(14, '2232'),
(43, '2234'),
(26, '23'),
(42, '231'),
(67, '23123'),
(12, '232'),
(47, '2323'),
(53, '233'),
(11, '2332'),
(17, '234'),
(46, '2342'),
(57, '3'),
(35, '3123'),
(40, '31231'),
(56, '3123123'),
(41, '312313'),
(66, '31321'),
(13, '321'),
(38, '3213'),
(15, '321312'),
(23, '323'),
(54, '3232'),
(65, '33'),
(22, '333'),
(20, '3331'),
(52, '33333'),
(45, '3345'),
(7, '34'),
(33, '345'),
(34, '3453'),
(68, '34665859'),
(58, '4'),
(5, '415'),
(49, '4234'),
(29, '43'),
(30, '434'),
(55, '435'),
(31, '45'),
(27, '4545'),
(36, '456'),
(60, '5'),
(44, '5345'),
(18, '546'),
(2, '5542343'),
(32, '56'),
(51, '565'),
(61, '6'),
(62, '7'),
(63, '8'),
(50, '<br />\r\n<b>Warning</');

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
(1, 5, '1', 1, 1),
(2, 22, '1000', 0, 1),
(3, 3, '999', 0, 1),
(4, 3, '999', 0, 1),
(5, 1, '5', 1, 1),
(6, 6, '999', 1, 1),
(19, 11, '999', 1, 0),
(20, 3, '9999', 0, 0),
(21, 3, '9999', 0, 0),
(22, 1, '9999', 0, 0),
(23, 123, '9999', 0, 0),
(24, 1234, '9999', 0, 0),
(333, 1, '999', 1, 0);

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
('paiva', 1, 'agustin', 2, 'paiva', '1', 0),
('criadorota', 2, 'mateo', 1, 'criado', '1', 1),
('aiello', 3, 'agustin', 1, 'aiello', '1', 1),
('gonzalez', 4, 'juan', 1, 'gonzalezz', '1', 0);

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
(1, 231, '2023-06-15 21:30:20', 10, 1, 0),
(1, 232, '2023-06-15 21:36:29', 11, 1, 0),
(1, 233, '2023-06-15 21:37:28', 12, 1, 0),
(1, 234, '2023-06-15 21:37:41', 13, 1, 0),
(1, 235, '2023-06-15 21:44:35', 14, 1, 0),
(1, 236, '2023-06-15 22:00:56', 15, 1, 0),
(1, 237, '2023-06-15 22:02:19', 16, 1, 0),
(1, 238, '2023-06-15 22:06:54', 17, 1, 0),
(1, 239, '2023-06-15 22:08:32', 18, 1, 4),
(1, 240, '2023-06-16 14:09:50', 19, 1, 531),
(1, 241, '2023-06-16 14:13:27', 20, 1, 5),
(1, 242, '2023-06-16 15:06:02', 21, 1, 5),
(1, 242, '2023-06-16 15:10:21', 22, 1, 5),
(1, 242, '2023-06-16 15:11:18', 23, 1, 5),
(1, 242, '2023-06-16 15:14:02', 24, 1, 10),
(1, 242, '2023-06-16 15:14:38', 25, 1, 10),
(1, 243, '2023-06-16 15:17:50', 26, 1, 5),
(1, 243, '2023-06-16 15:17:59', 27, 1, 5),
(1, 244, '2023-06-16 15:19:48', 28, 1, 5),
(1, 245, '2023-06-16 15:52:00', 29, 1, 30),
(1, 245, '2023-06-16 15:53:16', 30, 1, 30),
(1, 245, '2023-06-16 16:04:24', 31, 1, 45),
(1, 246, '2023-06-16 16:07:15', 32, 1, 5),
(1, 246, '2023-06-16 16:09:32', 33, 1, 5),
(1, 248, '2023-06-16 21:38:20', 34, 1, 5),
(1, 247, '2023-06-16 21:38:39', 35, 1, 320),
(1, 247, '2023-06-16 21:38:39', 36, 1, 320),
(1, 249, '2023-06-16 21:58:06', 37, 1, 20),
(1, 250, '2023-06-16 21:58:21', 38, 1, 5),
(1, 251, '2023-06-16 21:59:38', 39, 1, 5),
(1, 251, '2023-06-16 21:59:38', 40, 1, 5),
(1, 251, '2023-06-16 22:04:27', 41, 1, 5),
(1, 252, '2023-06-16 22:11:19', 42, 1, 5),
(1, 253, '2023-06-16 22:17:53', 43, 1, 5),
(1, 254, '2023-06-16 22:18:33', 44, 1, 5),
(1, 255, '2023-06-16 22:25:25', 45, 1, 5),
(1, 255, '2023-06-16 22:34:34', 46, 1, 10),
(1, 255, '2023-06-16 22:35:12', 47, 1, 10),
(1, 256, '2023-06-16 23:23:34', 48, 1, 35),
(1, 283, '2023-06-17 00:14:59', 49, 1, 10),
(1, 283, '2023-06-17 00:19:10', 50, 1, 15),
(1, 283, '2023-06-17 00:19:16', 51, 1, 15),
(1, 283, '2023-06-17 00:19:21', 52, 1, 15),
(1, 283, '2023-06-17 00:19:51', 53, 1, 15),
(1, 283, '2023-06-17 00:20:09', 54, 1, 15),
(1, 283, '2023-06-17 00:20:24', 55, 1, 15),
(1, 284, '2023-06-17 00:21:02', 56, 1, 15),
(1, 290, '2023-06-18 12:31:08', 57, 1, 2170),
(1, 285, '2023-06-18 19:05:15', 58, 1, 86),
(1, 286, '2023-06-18 19:05:21', 59, 1, 2580),
(1, 294, '2023-06-18 19:15:37', 60, 1, 5),
(1, 297, '2023-06-19 02:31:01', 61, 1, 194),
(1, 298, '2023-06-19 03:09:43', 62, 1, 40),
(1, 287, '2023-06-19 03:16:17', 63, 1, 3070),
(1, 288, '2023-06-19 17:59:46', 64, 1, 3940),
(1, 292, '2023-06-19 17:59:51', 65, 1, 1370),
(1, 300, '2023-06-19 17:59:54', 66, 1, 1499),
(1, 289, '2023-06-19 18:01:32', 67, 1, 3940),
(2, 293, '2023-06-19 19:07:09', 68, 1, 1440),
(2, 303, '2023-06-19 19:11:26', 69, 1, 1),
(1, 295, '2023-06-19 19:15:56', 70, 1, 1040),
(2, 304, '2023-06-19 19:24:24', 71, 1, 5),
(2, 296, '2023-06-19 21:12:16', 72, 1, 1155),
(2, 299, '2023-06-19 21:12:46', 73, 1, 1080),
(2, 299, '2023-06-19 21:12:46', 74, 1, 1080),
(1, 301, '2023-06-19 21:32:02', 75, 1, 27),
(1, 309, '2023-06-20 00:08:56', 76, 1, 1),
(2, 302, '2023-06-20 14:38:43', 77, 1, 1170),
(1, 305, '2023-06-20 17:07:41', 78, 1, 1195),
(1, 306, '2023-06-20 17:07:45', 79, 1, 1195),
(1, 307, '2023-06-20 17:07:50', 80, 1, 1180),
(1, 308, '2023-06-20 17:07:54', 81, 1, 1170),
(1, 310, '2023-06-20 17:19:55', 82, 1, 916),
(1, 311, '2023-06-20 17:20:01', 83, 1, 29),
(1, 312, '2023-06-20 17:20:04', 84, 1, 2),
(1, 313, '2023-06-20 17:20:07', 85, 1, 2),
(1, 314, '2023-06-20 17:20:11', 86, 1, 2),
(1, 315, '2023-06-20 17:20:15', 87, 1, 2),
(1, 316, '2023-06-20 17:20:21', 88, 1, 2),
(1, 317, '2023-06-20 17:22:29', 89, 1, 1),
(1, 318, '2023-06-20 17:22:33', 90, 1, 1),
(1, 319, '2023-06-20 17:22:37', 91, 1, 1),
(1, 320, '2023-06-20 17:22:40', 92, 1, 1),
(1, 321, '2023-06-20 17:22:43', 93, 1, 1),
(1, 322, '2023-06-20 17:27:10', 94, 1, 1),
(1, 323, '2023-06-20 17:27:14', 95, 1, 1),
(1, 324, '2023-06-20 17:27:20', 96, 1, 1),
(1, 325, '2023-06-20 17:27:22', 97, 1, 1),
(1, 327, '2023-06-20 17:27:27', 98, 1, 1),
(1, 339, '2023-06-20 17:41:22', 99, 1, 56),
(1, 340, '2023-06-20 17:54:02', 100, 1, 5),
(1, 341, '2023-06-20 17:54:06', 101, 1, 5),
(1, 347, '2023-06-20 17:54:20', 102, 1, 5),
(1, 348, '2023-06-20 17:55:36', 103, 1, 1),
(2, 349, '2023-06-20 22:59:51', 104, 1, 56),
(2, 342, '2023-06-20 23:00:12', 105, 1, 1832),
(1, 355, '2023-06-22 21:14:07', 106, 1, 3),
(1, 357, '2023-06-22 22:12:35', 107, 1, 11),
(1, 365, '2023-06-22 22:49:01', 108, 1, 5),
(1, 366, '2023-06-22 23:11:22', 109, 1, 5),
(1, 367, '2023-06-23 00:16:29', 110, 1, 5),
(2, 368, '2023-06-23 00:32:20', 111, 1, 3),
(2, 369, '2023-06-23 00:32:25', 112, 1, 5),
(2, 370, '2023-06-23 00:32:39', 113, 1, 1),
(2, 371, '2023-06-23 00:59:54', 114, 1, 6),
(1, 372, '2023-06-23 14:22:29', 115, 1, 830);

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
(367, '2023-06-23 00:16:24', 0, 6, 35, '12', 1),
(368, '2023-06-23 00:19:52', 0, 1, 6, '123', 2),
(369, '2023-06-23 00:31:58', 0, 5, 6, '123', 2),
(370, '2023-06-23 00:32:07', 0, 3, 6, '1231', 2),
(371, '2023-06-23 00:32:14', 0, 3, 6, '12312', 2),
(372, '2023-06-23 00:32:30', 0, 3, 6, '12312', 2),
(373, '2023-06-23 00:32:34', 1, 5, 6, '321', 2),
(374, '2023-06-23 00:42:03', 1, 3, 6, '123', 2),
(375, '2023-06-23 00:42:09', 1, 4, 35, '12312', 2),
(376, '2023-06-23 00:42:13', 1, 4, 66, '1231', 2),
(377, '2023-06-23 00:59:14', 1, 4, 67, '23131', 2),
(378, '2023-06-23 14:22:11', 1, 1, 68, 'ABC123', 1);

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
(1, 11, 60, 60, 60, 60, 60, 0),
(2, 333, 333, 33, 2, 2, 44, 0),
(10, 50, 333, 0, 0, 0, 0, 0),
(11, 50, 333, 0, 0, 0, 0, 0),
(12, 0, 0, 0, 0, 0, 0, 0),
(13, 0, 0, 0, 0, 0, 0, 0),
(14, 0, 0, 0, 0, 0, 0, 1),
(15, 0, 0, 0, 0, 0, 0, 1);

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
(3, 'mercadolibre', 0);

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
(1, 'moto', 1, 1, 1),
(2, 'auto', 2, 2, 0),
(3, 'camioneta', 3, 1, 0),
(4, 'aut', 2, 14, 1),
(15, 'auto', 2, 13, 0);

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
('1', 1),
('11', 1),
('12', 1),
('123', 1),
('1231', 1),
('12312', 1),
('2', 1),
('23131', 1),
('3', 1),
('321', 1),
('6', 1),
('7', 1),
('8', 1),
('ABC123', 1),
('4', 2),
('5', 2),
('1111', 3),
('33', 3);

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
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `cochera`
--
ALTER TABLE `cochera`
  MODIFY `id_cochera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=334;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `cod_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `codigo_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=379;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tarifa`
--
ALTER TABLE `tarifa`
  MODIFY `id_tarifa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  MODIFY `id_tipopago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  MODIFY `id_tipovehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
