-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2016 at 12:15 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `primopiano`
--

-- --------------------------------------------------------

--
-- Table structure for table `digesto`
--

CREATE TABLE `digesto` (
  `idDigesto` int(11) NOT NULL,
  `idTipoNorma` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `tema` varchar(50) NOT NULL,
  `fechaPromulgada` date NOT NULL,
  `palabraClave` varchar(15) NOT NULL,
  `norma` text NOT NULL,
  `firma` varchar(25) NOT NULL,
  `publicadaEn` varchar(25) NOT NULL,
  `fechaUltMod` date NOT NULL,
  `usuarioLog` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `digesto`
--

INSERT INTO `digesto` (`idDigesto`, `idTipoNorma`, `numero`, `tema`, `fechaPromulgada`, `palabraClave`, `norma`, `firma`, `publicadaEn`, `fechaUltMod`, `usuarioLog`) VALUES
(1, 3, 11, 'ACUERDOS - HERMANAMIENTOS', '2015-05-17', 'Palabra Clavee', '<p class="primero" style="text-align: center; padding-left: 30px;">Dirigente de la Coalici&oacute;n C&iacute;vica, Elisa Carri&oacute;, sali&oacute; a cuestionar los datos a boca de urna que dio a conocer el kirchnerismo y advirti&oacute; que el candidato de ECO, <a class="tag topico martin-lousteau" title="Ver todas las notas de Mart&iacute;n Lousteau" href="http://www.lanacion.com.ar/martin-lousteau-t47579">Mart&iacute;n Lousteau</a>, se alzar&aacute; como el segundo candidato m&aacute;s votado en las primarias.</p>\r\n<p style="text-align: center;">"Me da pena An&iacute;bal [Fern&aacute;ndez]. Los candidatos ya consolidados son el candidato del PRO y Mart&iacute;n Lousteau como candidato en segundo lugar. Muy lejos est&aacute; el presidente o no s&eacute; qu&eacute; de Aerol&iacute;neas", dispar&oacute; Carri&oacute; al comenzar su discurso en el bunker.</p>\r\n<p style="text-align: center;">"Reci&eacute;n arranca la campa&ntilde;a en la Ciudad. Mart&iacute;n Lousteau gana en el ballotage. No se asusten con lo que dice el Frente para la Victoria. La Capital es de la Rep&uacute;blica y no de La C&aacute;mpora ni de An&iacute;bal Fern&aacute;ndez", concluy&oacute;.</p>\r\n<p style="text-align: center;">Por su parte, El dirigente y senador nacional por la UCR, Ernesto Sanz, tambi&eacute;n aventur&oacute; que "Lousteau es el candidato m&aacute;s votado de la oposici&oacute;n en la Ciudad. En la elecci&oacute;n de hoy ha tenido piso, pero no techo"</p>\r\n<p style="text-align: center;">&nbsp;</p>\r\n<p style="padding-left: 30px;"><img src="http://bucket1.clanacion.com.ar/anexos/fotos/89/data-elecciones-2015-2032589w300.jpg" alt="" width="300" height="186" /></p>', 'Saveriano', 'Palabra Clave', '2015-11-24', 'admin'),
(9, 1, 1231456, 'EDUCACIÃ“N', '2015-06-06', 'gnc', '<p>aljdalsdasjdasdasmdn</p>', 'Arteaga', 'gnc', '2015-11-24', 'admin'),
(10, 1, 1, 'ACUERDOS - HERMANAMIENTOS', '2015-11-24', 'Ejemplo', '<p>Ejemplo!</p>', 'Piazzese', 'Ejemplo', '2015-11-24', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `noticias`
--

CREATE TABLE `noticias` (
  `idNoticia` int(11) NOT NULL,
  `noticia` text NOT NULL,
  `fechaAlta` date NOT NULL,
  `fechaUltMod` date NOT NULL,
  `usuarioLog` varchar(15) NOT NULL,
  `tematica` varchar(50) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `comision` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `noticias`
--

INSERT INTO `noticias` (`idNoticia`, `noticia`, `fechaAlta`, `fechaUltMod`, `usuarioLog`, `tematica`, `titulo`, `comision`) VALUES
(11, '<p><strong>18/05/2015&nbsp;</strong></p>\n<p>El Concejo Deliberante de La Plata decidi&oacute; sumarse activamente a la campa&ntilde;a nacional de vacunaci&oacute;n antigripal y en ese marco se realizar&aacute; una aplicaci&oacute;n de dosis a los integrantes del cuerpo y a quienes se acerquen a la sesi&oacute;n ordinaria del pr&oacute;ximo mi&eacute;rcoles.&nbsp;</p>', '2015-07-05', '2015-07-09', 'admin', 'VacunaciÃ³n', '<h2 style="font-size:18px;  font-family: ''MuseoSans300''; color: #5CB9FF;">VacunaciÃ³n Antigripal</h2>', 'ninguna'),
(13, '<p><strong>04/05/15</strong></p>\r\n<p>El Concejo adhiri&oacute; a la convocatoria &ldquo;Ni una Menos&rdquo;. Adem&aacute;s del acompa&ntilde;amiento generalizado a la lucha por erradicar la violencia de g&eacute;nero, se aprob&oacute; un decreto impulsado por el intendente Pablo Bruera y presentado por el concejal, Fabi&aacute;n Lugli, que declar&oacute; de inter&eacute;s Municipal a la marcha organizada para hoy.</p>', '2015-07-09', '2015-07-09', 'admin', 'Ni una Menos', '<h2 style="font-size:18px;  font-family: ''MuseoSans300''; color: #5CB9FF;">SesiÃ³n Ordinaria NÂº 7</h2>', 'ninguna'),
(14, '<p>&nbsp;<strong>20/06/15</strong></p>\r\n<p>El Concejo adhiri&oacute; a la convocatoria &ldquo;Ni una Menos&rdquo;. Adem&aacute;s del acompa&ntilde;amiento generalizado a la lucha por erradicar la violencia de g&eacute;nero, se aprob&oacute; un decreto impulsado por el intendente Pablo Bruera y presentado por el concejal, Fabi&aacute;n Lugli, que declar&oacute; de inter&eacute;s Municipal a la marcha organizada para hoy.</p>', '2015-07-09', '2015-07-09', 'admin', 'Ni una Menos', '<h2 style="font-size:18px;  font-family: ''MuseoSans300''; color: #5CB9FF;">SesiÃ³n Ordinaria NÂº 8 </h2>', 'ninguna'),
(15, '<p><strong>15/05/15</strong></p>\r\n<p>El Concejo adhiri&oacute; a la convocatoria &ldquo;Ni una Menos&rdquo;. Adem&aacute;s del acompa&ntilde;amiento generalizado a la lucha por erradicar la violencia de g&eacute;nero, se aprob&oacute; un decreto impulsado por el intendente Pablo Bruera y presentado por el concejal, Fabi&aacute;n Lugli, que declar&oacute; de inter&eacute;s Municipal a la marcha organizada para hoy.</p>', '2015-07-09', '2015-07-09', 'admin', 'Ni una Menos', '<h2 style="font-size:18px;  font-family: ''MuseoSans300''; color: #5CB9FF;">SesiÃ³n Ordinaria NÂº 6 </h2>', 'Seguridad Publica y Derechos Humanos'),
(16, '<p>El Concejo Deliberante de La Plata decidi&oacute; sumarse activamente a la campa&ntilde;a nacional de vacunaci&oacute;n antigripal y en ese marco se realizar&aacute; una aplicaci&oacute;n de dosis a los integrantes del cuerpo y a quienes se acerquen a la sesi&oacute;n ordinaria del pr&oacute;ximo mi&eacute;rcoles.&nbsp;</p>', '2015-07-09', '2015-07-09', 'admin', 'VacunaciÃ³n', '<h2 style="font-size:18px; font-family: ''MuseoSans300''; color: #5CB9FF;">VacunaciÃ³n Antigripal II</h2>', 'Seguridad Publica y Derechos Humanos');

-- --------------------------------------------------------

--
-- Table structure for table `perfil`
--

CREATE TABLE `perfil` (
  `idPerfil` int(10) NOT NULL,
  `nombrePerfil` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `perfil`
--

INSERT INTO `perfil` (`idPerfil`, `nombrePerfil`) VALUES
(1, 'Administrador'),
(2, 'Profesores'),
(3, 'Alumnos');

-- --------------------------------------------------------

--
-- Table structure for table `privilegio`
--

CREATE TABLE `privilegio` (
  `idPrivilegio` int(10) NOT NULL,
  `idPerfil` int(10) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `archivo` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `privilegio`
--

INSERT INTO `privilegio` (`idPrivilegio`, `idPerfil`, `nombre`, `archivo`) VALUES
(1, 1, 'Inicio', 'indexAdmin'),
(9, 1, 'Usuarios', 'GestionUsuarios'),
(19, 3, 'Inicio', 'indexAlumnos');

-- --------------------------------------------------------

--
-- Table structure for table `tiponorma`
--

CREATE TABLE `tiponorma` (
  `idTipoNorma` int(11) NOT NULL,
  `tipo` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tiponorma`
--

INSERT INTO `tiponorma` (`idTipoNorma`, `tipo`) VALUES
(1, 'Ordenanza'),
(2, 'Ordenanza General'),
(3, 'Decreto Municipal');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(10) NOT NULL,
  `pass` char(32) NOT NULL,
  `idPerfil` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nombre`, `pass`, `idPerfil`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 1),
(5, 'Giuliano', 'cf8640d1b066e5bcd8e9b03cc4803855', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `digesto`
--
ALTER TABLE `digesto`
  ADD PRIMARY KEY (`idDigesto`);

--
-- Indexes for table `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`idNoticia`);

--
-- Indexes for table `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`idPerfil`);

--
-- Indexes for table `privilegio`
--
ALTER TABLE `privilegio`
  ADD PRIMARY KEY (`idPrivilegio`);

--
-- Indexes for table `tiponorma`
--
ALTER TABLE `tiponorma`
  ADD PRIMARY KEY (`idTipoNorma`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `digesto`
--
ALTER TABLE `digesto`
  MODIFY `idDigesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `noticias`
--
ALTER TABLE `noticias`
  MODIFY `idNoticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `perfil`
--
ALTER TABLE `perfil`
  MODIFY `idPerfil` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `privilegio`
--
ALTER TABLE `privilegio`
  MODIFY `idPrivilegio` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `tiponorma`
--
ALTER TABLE `tiponorma`
  MODIFY `idTipoNorma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;