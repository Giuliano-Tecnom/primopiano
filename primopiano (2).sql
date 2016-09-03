-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-09-2016 a las 18:45:53
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `primopiano`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase`
--

CREATE TABLE `clase` (
  `idClase` int(11) NOT NULL,
  `dia` varchar(10) NOT NULL,
  `hora` int(11) NOT NULL,
  `cupo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clase`
--

INSERT INTO `clase` (`idClase`, `dia`, `hora`, `cupo`) VALUES
(1, 'Jueves', 18, 1),
(2, 'Jueves', 22, 20),
(3, 'Viernes', 18, 20),
(4, 'Viernes', 19, 20),
(6, 'Jueves', 20, 20),
(7, 'Sabado', 11, 20),
(8, 'Viernes', 21, 20),
(9, 'Viernes', 8, 20),
(10, 'Viernes', 9, 20),
(11, 'Viernes', 10, 20),
(12, 'Viernes', 11, 20),
(13, 'Viernes', 12, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `claseusuario`
--

CREATE TABLE `claseusuario` (
  `idUsuario` int(11) NOT NULL,
  `idClase` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `claseusuario`
--

INSERT INTO `claseusuario` (`idUsuario`, `idClase`) VALUES
(1, 1),
(1, 2),
(22, 9),
(19, 7),
(21, 4),
(21, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datosusuario`
--

CREATE TABLE `datosusuario` (
  `idUsuario` int(11) NOT NULL,
  `nombreCompleto` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `cantSemanal` int(11) NOT NULL,
  `celular` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `datosusuario`
--

INSERT INTO `datosusuario` (`idUsuario`, `nombreCompleto`, `apellido`, `email`, `cantSemanal`, `celular`) VALUES
(1, 'Giuliano', 'Mailen', 'giuli@hot.com', 3, 2215485),
(1, 'lucia', 'sanchez', 'lucs', 2, 55),
(1, 'lucia', 'sanchez', 'luc.sanchez@hotmail.com', 2, 54),
(18, 'Lucia', 'Sanchez', 'luc.sanchez@hotmail.com', 2, 5462),
(19, 'Lucia', 'San', 'llll@hotmail.com', 1, 2215623184),
(20, 'Liliana', 'Marquez', 'lili@gmail.com', 3, 2214135),
(21, 'Sebastian', 'Sanchez', 'luc.sanchez@hotmail.com', 5, 2215623184),
(22, 'Fernanda', 'Berri', 'ferberri@hotmail.com', 3, 2147483647),
(23, 'cami', 'sanchez', 'luc.sanchez@hotmail.com', 3, 1234567);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `idPerfil` int(10) NOT NULL,
  `nombrePerfil` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`idPerfil`, `nombrePerfil`) VALUES
(1, 'Administrador'),
(2, 'Profesores'),
(3, 'Alumnos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `privilegio`
--

CREATE TABLE `privilegio` (
  `idPrivilegio` int(10) NOT NULL,
  `idPerfil` int(10) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `archivo` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `privilegio`
--

INSERT INTO `privilegio` (`idPrivilegio`, `idPerfil`, `nombre`, `archivo`) VALUES
(1, 1, 'Inicio', 'indexAdmin'),
(9, 1, 'Usuarios', 'GestionUsuarios'),
(19, 3, 'Inicio', 'indexAlumnos'),
(20, 3, 'Perfil', 'perfilAlumno'),
(21, 3, 'Clases', 'calendario'),
(23, 2, 'Clases', 'calendario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(10) NOT NULL,
  `pass` char(32) NOT NULL,
  `idPerfil` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nombre`, `pass`, `idPerfil`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 1),
(5, 'Giuliano', 'cf8640d1b066e5bcd8e9b03cc4803855', 3),
(18, 'lucsanchez', 'e10adc3949ba59abbe56e057f20f883e', 3),
(19, 'lulusanche', '3ba430337eb30f5fd7569451b5dfdf32', 2),
(20, 'lilimarque', '3ba430337eb30f5fd7569451b5dfdf32', 3),
(21, 'Seba', '3ba430337eb30f5fd7569451b5dfdf32', 3),
(22, 'ferberri', 'b98a5a57d055dbabf959dcd6f36509ef', 3),
(23, 'camila', 'e10adc3949ba59abbe56e057f20f883e', 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clase`
--
ALTER TABLE `clase`
  ADD PRIMARY KEY (`idClase`);

--
-- Indices de la tabla `claseusuario`
--
ALTER TABLE `claseusuario`
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idClase` (`idClase`);

--
-- Indices de la tabla `datosusuario`
--
ALTER TABLE `datosusuario`
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`idPerfil`);

--
-- Indices de la tabla `privilegio`
--
ALTER TABLE `privilegio`
  ADD PRIMARY KEY (`idPrivilegio`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clase`
--
ALTER TABLE `clase`
  MODIFY `idClase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `idPerfil` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `privilegio`
--
ALTER TABLE `privilegio`
  MODIFY `idPrivilegio` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `claseusuario`
--
ALTER TABLE `claseusuario`
  ADD CONSTRAINT `fk_idClase` FOREIGN KEY (`idClase`) REFERENCES `clase` (`idClase`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `idUsuario_fk` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `datosusuario`
--
ALTER TABLE `datosusuario`
  ADD CONSTRAINT `fk_idUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE NO ACTION;

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `vaciar_claseusuario` ON SCHEDULE EVERY 1 WEEK STARTS '2016-08-28 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM claseusuario$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
