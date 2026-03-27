-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 20-03-2026 a las 13:40:46
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `etn1040v14`
--
CREATE DATABASE IF NOT EXISTS etn1040v14 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
--
USE etn1040v14;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesos`
--

DROP TABLE IF EXISTS `accesos`;
CREATE TABLE IF NOT EXISTS `accesos` (
  `acceso_usuario_id` int NOT NULL,
  `acceso_rol_id` int NOT NULL,
  `acceso_nivel` int NOT NULL,
  UNIQUE KEY `acceso_usuario_rol_id_UK` (`acceso_usuario_id`,`acceso_rol_id`),
  KEY `acceso_rol_id_FK` (`acceso_rol_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `accesos`
--

INSERT INTO `accesos` (`acceso_usuario_id`, `acceso_rol_id`, `acceso_nivel`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 2),
(5, 2, 3),
(6, 2, 3),
(7, 2, 1),
(7, 4, 1),
(8, 4, 1),
(9, 4, 1),
(10, 3, 1),
(10, 5, 1),
(11, 3, 1),
(11, 5, 1),
(12, 5, 1),
(13, 4, 1),
(14, 4, 1),
(15, 4, 1),
(16, 4, 1),
(17, 4, 1),
(18, 4, 1),
(19, 4, 1),
(20, 4, 1),
(21, 4, 1),
(22, 4, 1),
(23, 4, 1),
(24, 4, 1),
(25, 4, 1),
(26, 4, 1),
(27, 2, 1),
(27, 4, 1),
(28, 4, 1),
(29, 4, 1),
(30, 4, 1),
(31, 4, 1),
(32, 4, 1),
(33, 4, 1),
(34, 4, 1),
(35, 4, 1),
(36, 4, 1),
(37, 4, 1),
(38, 4, 1),
(39, 4, 1),
(40, 4, 1),
(41, 4, 1),
(42, 4, 1),
(43, 4, 1),
(44, 4, 1),
(45, 4, 1),
(46, 4, 1),
(47, 4, 1),
(48, 4, 1),
(49, 4, 1),
(50, 4, 1),
(51, 4, 1),
(52, 4, 1),
(53, 4, 1),
(54, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

DROP TABLE IF EXISTS `actividades`;
CREATE TABLE IF NOT EXISTS `actividades` (
  `actividad_id` int NOT NULL AUTO_INCREMENT,
  `actividad_usuario_id` int DEFAULT NULL,
  `actividad_modulo` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `actividad_accion` enum('Crear','Leer','Actualizar','Eliminar','Iniciar Sesión','Cerrar Sesión','Exportar') COLLATE utf8mb4_spanish_ci NOT NULL COMMENT '(1)Crear, (2)Leer, (3)Actualizar, (4)Eliminar, (5)Iniciar Sesión, (6)Cerrar Sesión, (7)Exportar',
  `actividad_resultado` enum('Éxito','Error','Interrumpido') COLLATE utf8mb4_spanish_ci NOT NULL COMMENT '(1)Éxito, (2)Error, (3)Interrumpido',
  `actividad_descripcion` text COLLATE utf8mb4_spanish_ci,
  `actividad_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actividad_ip` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `actividad_navegador` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`actividad_id`),
  KEY `actividad_usuario_id_FK` (`actividad_usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrativos`
--

DROP TABLE IF EXISTS `administrativos`;
CREATE TABLE IF NOT EXISTS `administrativos` (
  `administrativo_id` int NOT NULL AUTO_INCREMENT,
  `administrativo_persona_id` int NOT NULL,
  `administrativo_cargo_id` int NOT NULL,
  `administrativo_estado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`administrativo_id`),
  UNIQUE KEY `administrativo_persona_id_UK` (`administrativo_persona_id`),
  KEY `administrativo_cargo_id_FK` (`administrativo_cargo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `administrativos`
--

INSERT INTO `administrativos` (`administrativo_id`, `administrativo_persona_id`, `administrativo_cargo_id`, `administrativo_estado`) VALUES
(1, 4, 2, 1),
(2, 5, 3, 1),
(3, 6, 3, 1),
(4, 1015, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aperturas`
--

DROP TABLE IF EXISTS `aperturas`;
CREATE TABLE IF NOT EXISTS `aperturas` (
  `apertura_id` int NOT NULL AUTO_INCREMENT,
  `apertura_periodo_id` int NOT NULL,
  `apertura_asignatura_id` int NOT NULL,
  `apertura_campo` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `apertura_extraordinario` tinyint(1) DEFAULT NULL,
  `apertura_paralelo` char(1) COLLATE utf8mb4_spanish_ci NOT NULL,
  `apertura_inscripcion` tinyint(1) DEFAULT NULL,
  `apertura_estado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`apertura_id`),
  UNIQUE KEY `apertura_UK` (`apertura_periodo_id`,`apertura_asignatura_id`,`apertura_campo`,`apertura_paralelo`),
  KEY `apertura_asignatura_id_FK` (`apertura_asignatura_id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `aperturas`
--

INSERT INTO `aperturas` (`apertura_id`, `apertura_periodo_id`, `apertura_asignatura_id`, `apertura_campo`, `apertura_extraordinario`, `apertura_paralelo`, `apertura_inscripcion`, `apertura_estado`) VALUES
(1, 26, 1, 'Teoría', NULL, 'A', 0, 1),
(2, 26, 1, 'Laboratorio', NULL, 'A', NULL, 1),
(3, 26, 2, 'Teoría', NULL, 'A', 0, 1),
(4, 26, 3, 'Teoría', NULL, 'A', 0, 1),
(5, 26, 4, 'Teoría', NULL, 'A', 0, 1),
(6, 26, 4, 'Laboratorio', NULL, 'A', NULL, 1),
(7, 26, 5, 'Teoría', NULL, 'A', 0, 1),
(8, 26, 6, 'Teoría', NULL, 'A', 0, 1),
(9, 26, 7, 'Teoría', NULL, 'A', 0, 1),
(10, 26, 7, 'Laboratorio', NULL, 'A', NULL, 1),
(11, 26, 8, 'Teoría', NULL, 'A', 0, 1),
(12, 26, 9, 'Teoría', NULL, 'A', 0, 1),
(13, 26, 10, 'Teoría', NULL, 'A', 0, 1),
(14, 26, 11, 'Teoría', NULL, 'A', 0, 1),
(15, 26, 12, 'Teoría', NULL, 'A', 0, 1),
(16, 26, 12, 'Laboratorio', NULL, 'A', NULL, 1),
(17, 26, 13, 'Teoría', NULL, 'A', 0, 1),
(18, 26, 14, 'Teoría', NULL, 'A', 0, 1),
(19, 26, 15, 'Teoría', NULL, 'A', 0, 1),
(20, 26, 16, 'Teoría', NULL, 'A', 0, 1),
(21, 26, 17, 'Teoría', NULL, 'A', 0, 1),
(22, 26, 18, 'Teoría', NULL, 'A', 0, 1),
(23, 26, 19, 'Teoría', NULL, 'A', 0, 1),
(24, 26, 20, 'Teoría', NULL, 'A', 0, 1),
(25, 26, 21, 'Teoría', NULL, 'A', 0, 1),
(26, 26, 21, 'Laboratorio', NULL, 'A', NULL, 1),
(27, 26, 22, 'Teoría', NULL, 'A', 0, 1),
(28, 26, 23, 'Teoría', NULL, 'A', 0, 1),
(29, 26, 23, 'Laboratorio', NULL, 'A', NULL, 1),
(30, 26, 24, 'Teoría', NULL, 'A', 0, 1),
(31, 26, 25, 'Teoría', NULL, 'A', 0, 1),
(32, 26, 26, 'Teoría', NULL, 'A', 0, 1),
(33, 26, 27, 'Teoría', NULL, 'A', 0, 1),
(34, 26, 28, 'Teoría', NULL, 'A', 0, 1),
(35, 26, 28, 'Laboratorio', NULL, 'A', NULL, 1),
(36, 26, 29, 'Teoría', NULL, 'A', 0, 1),
(37, 26, 29, 'Laboratorio', NULL, 'A', NULL, 1),
(38, 26, 30, 'Teoría', NULL, 'A', 0, 1),
(39, 26, 31, 'Teoría', NULL, 'A', 0, 1),
(40, 26, 31, 'Laboratorio', NULL, 'A', NULL, 1),
(41, 26, 32, 'Teoría', NULL, 'A', 0, 1),
(42, 26, 32, 'Laboratorio', NULL, 'A', NULL, 1),
(43, 26, 33, 'Teoría', NULL, 'A', 0, 1),
(44, 26, 33, 'Laboratorio', NULL, 'A', NULL, 1),
(45, 26, 34, 'Teoría', NULL, 'A', 0, 1),
(46, 26, 34, 'Laboratorio', NULL, 'A', NULL, 1),
(47, 26, 35, 'Teoría', NULL, 'A', 0, 1),
(48, 26, 36, 'Teoría', NULL, 'A', 0, 1),
(49, 26, 36, 'Laboratorio', NULL, 'A', NULL, 1),
(50, 26, 37, 'Teoría', NULL, 'A', 0, 1),
(51, 26, 37, 'Laboratorio', NULL, 'A', NULL, 1),
(52, 26, 38, 'Teoría', NULL, 'A', 0, 1),
(53, 26, 39, 'Teoría', NULL, 'A', 0, 1),
(54, 26, 39, 'Laboratorio', NULL, 'A', NULL, 1),
(55, 26, 40, 'Teoría', NULL, 'A', 0, 1),
(56, 26, 41, 'Teoría', NULL, 'A', 0, 1),
(57, 26, 41, 'Laboratorio', NULL, 'A', NULL, 1),
(58, 26, 42, 'Teoría', NULL, 'A', 0, 1),
(59, 26, 43, 'Teoría', NULL, 'A', 0, 1),
(60, 26, 43, 'Laboratorio', NULL, 'A', NULL, 1),
(61, 26, 44, 'Teoría', NULL, 'A', 0, 1),
(62, 26, 45, 'Teoría', NULL, 'A', 0, 1),
(63, 26, 46, 'Teoría', NULL, 'A', 0, 1),
(64, 26, 47, 'Teoría', NULL, 'A', 0, 1),
(65, 26, 48, 'Teoría', NULL, 'A', 0, 1),
(66, 26, 48, 'Laboratorio', NULL, 'A', NULL, 1),
(67, 26, 49, 'Teoría', NULL, 'A', 0, 1),
(68, 26, 50, 'Teoría', NULL, 'A', 0, 1),
(69, 26, 50, 'Laboratorio', NULL, 'A', NULL, 1),
(70, 26, 51, 'Teoría', NULL, 'A', 0, 1),
(71, 26, 52, 'Teoría', NULL, 'A', 0, 1),
(72, 26, 53, 'Teoría', NULL, 'A', 0, 1),
(73, 26, 54, 'Teoría', NULL, 'A', 0, 1),
(74, 26, 55, 'Teoría', NULL, 'A', 0, 1),
(75, 26, 56, 'Teoría', NULL, 'A', 0, 1),
(76, 26, 57, 'Teoría', NULL, 'A', 0, 1),
(77, 26, 58, 'Teoría', NULL, 'A', 0, 1),
(78, 26, 59, 'Teoría', NULL, 'A', 0, 1),
(79, 26, 60, 'Teoría', NULL, 'A', 0, 1),
(80, 26, 61, 'Teoría', NULL, 'A', 0, 1),
(81, 26, 62, 'Teoría', NULL, 'A', 0, 1),
(82, 26, 63, 'Teoría', NULL, 'A', 0, 1),
(83, 26, 63, 'Laboratorio', NULL, 'A', NULL, 1),
(84, 26, 64, 'Teoría', NULL, 'A', 0, 1),
(85, 26, 64, 'Laboratorio', NULL, 'A', NULL, 1),
(86, 26, 65, 'Teoría', NULL, 'A', 0, 1),
(87, 26, 65, 'Laboratorio', NULL, 'A', NULL, 1),
(88, 26, 66, 'Teoría', NULL, 'A', 0, 1),
(89, 26, 66, 'Laboratorio', NULL, 'A', NULL, 1),
(90, 26, 67, 'Teoría', NULL, 'A', 0, 1),
(91, 26, 68, 'Teoría', NULL, 'A', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas`
--

DROP TABLE IF EXISTS `asignaturas`;
CREATE TABLE IF NOT EXISTS `asignaturas` (
  `asignatura_id` int NOT NULL AUTO_INCREMENT,
  `asignatura_plan_estudio_id` int NOT NULL,
  `asignatura_sigla` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `asignatura_nombre` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `asignatura_teoria` tinyint(1) NOT NULL,
  `asignatura_laboratorio` tinyint(1) NOT NULL,
  `asignatura_auxiliatura` tinyint(1) NOT NULL,
  `asignatura_proteccion` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`asignatura_id`),
  UNIQUE KEY `asignatura_UK` (`asignatura_plan_estudio_id`,`asignatura_sigla`,`asignatura_nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `asignaturas`
--

INSERT INTO `asignaturas` (`asignatura_id`, `asignatura_plan_estudio_id`, `asignatura_sigla`, `asignatura_nombre`, `asignatura_teoria`, `asignatura_laboratorio`, `asignatura_auxiliatura`, `asignatura_proteccion`) VALUES
(1, 4, 'FIS 100', 'FISICA BÁSICA I Y LABORATORIO', 1, 1, 1, 1),
(2, 4, 'MAT 100', 'ALGEBRA', 1, 0, 1, 1),
(3, 4, 'MAT 101', 'CALCULO I', 1, 0, 1, 1),
(4, 4, 'QMC 100', 'QUÍMICA GENERAL Y LABORATORIO', 1, 1, 1, 1),
(5, 4, 'MEC 101', 'DIBUJO TÉCNICO', 1, 0, 1, 1),
(6, 4, 'ETN 507', 'HISTORIA CRÍTICA DE AMÉRICA LATINA Y BOLIVIA', 1, 0, 1, 1),
(7, 4, 'FIS 102', 'FÍSICA BÁSICA II Y LABORATORIO', 1, 1, 1, 1),
(8, 4, 'MAT 102', 'CALCULO II', 1, 0, 1, 1),
(9, 4, 'MAT 103', 'ÁLGEBRA LINEAL Y TEORÍA MATRICIAL', 1, 0, 1, 1),
(10, 4, 'MAT 218', 'ANÁLISIS DE VARIABLE COMPLEJO', 1, 0, 1, 1),
(11, 4, 'ETN 401', 'PROBABILIDAD Y ESTADÍSTICA', 1, 0, 1, 1),
(12, 4, 'FIS 200', 'FÍSICA BÁSICA III Y LABORATORIO', 1, 1, 1, 1),
(13, 4, 'MAT 207', 'ECUACIONES DIFERENCIALES', 1, 0, 1, 1),
(14, 4, 'MAT 313', 'ANÁLISIS VECTORIAL Y TENSORIAL', 1, 0, 1, 1),
(15, 4, 'ETN 302', 'TEORÍA DE REDES I', 1, 0, 1, 1),
(16, 4, 'ETN 406', 'TECNOLOGÍA DE LOS COMPONENTES', 1, 0, 1, 1),
(17, 4, 'ETN 307', 'PROGRAMACIÓN', 1, 0, 1, 1),
(18, 4, 'ETN 340', 'PROYECTO I', 1, 0, 1, 1),
(19, 4, 'MAT 315', 'TRANSFORMADAS INTEGRALES', 1, 0, 1, 1),
(20, 4, 'ETN 402', 'TEORIA DE REDES II', 1, 0, 1, 1),
(21, 4, 'ETN 404', 'MEDICIONES ELÉCTRICAS', 1, 1, 1, 1),
(22, 4, 'ETN 501', 'FÍSICA DEL ESTADO SÓLIDO', 1, 0, 1, 1),
(23, 4, 'ETN 503', 'ELECTRÓNICA I', 1, 1, 1, 1),
(24, 4, 'ETN 505', 'PROGRAMACIÓN Y MÉTODOS NUMÉRICOS', 1, 0, 1, 1),
(25, 4, 'ETN 607', 'MECÁNICA APLICADA', 1, 0, 1, 1),
(26, 4, 'ETN 502', 'CAMPOS ELECTROMAGNÉTICOS', 1, 0, 1, 1),
(27, 4, 'ETN 506', 'ANÁLISIS DE SISTEMAS LINEALES', 1, 0, 1, 1),
(28, 4, 'ETN 601', 'SISTEMAS DIGITALES I', 1, 1, 1, 1),
(29, 4, 'ETN 603', 'ELECTRÓNICA II', 1, 1, 1, 1),
(30, 4, 'ETN 805', 'INVESTIGACIÓN DE OPERACIONES', 1, 0, 1, 1),
(31, 4, 'ETN 606', 'CONVERSIÓN ELECTROMAGNÉTICA DE ENERGÍA', 1, 1, 1, 1),
(32, 4, 'ETN 702', 'SISTEMAS DE CONTROL I', 1, 1, 1, 1),
(33, 4, 'ETN 703', 'TEORIA DE TELECOMUNICACIONES I', 1, 1, 1, 1),
(34, 4, 'ETN 821', 'SISTEMAS DIGITALES II', 1, 1, 1, 1),
(35, 4, 'ETN 640', 'PROYECTO II', 1, 0, 1, 1),
(36, 4, 'ETN 704', 'ELECTRÓNICA DE PULSOS', 1, 1, 1, 1),
(37, 4, 'ETN 801', 'MICROPROCESADORES', 1, 1, 1, 1),
(38, 4, 'ETN 806', 'PROCESOS ESTOCÁSTICOS', 1, 0, 1, 1),
(39, 4, 'ETN 832', 'ELECTRÓNICA INDUSTRIAL', 1, 1, 1, 1),
(40, 4, 'ETN 902', 'SISTEMAS DE CONTROL II', 1, 0, 1, 1),
(41, 4, 'ETN 903', 'SISTEMAS DE COMPUTACIÓN', 1, 1, 1, 1),
(42, 4, 'ETN 921', 'TEORIA DE SISTEMAS OPERATIVOS', 1, 0, 1, 1),
(43, 4, 'ETN 933', 'CONTROL Y REGULACIÓN INDUSTRIAL', 1, 1, 1, 1),
(44, 4, 'ETN 1015', 'PROCESAMIENTO DIGITAL DE SEÑALES', 1, 0, 1, 1),
(45, 4, 'ETN 1022', 'INTERACCION HARDWARE SOFTWARE', 1, 0, 1, 1),
(46, 4, 'ETN 840', 'PREPARACIÓN Y EVALUACIÓN DE PROYECTOS', 1, 0, 1, 1),
(47, 4, 'ETN 935', 'REDES DE DATOS', 1, 0, 1, 1),
(48, 4, 'ETN 1034', 'APLICACIÓN DE TÉCNICAS DE CONTROL', 1, 1, 1, 1),
(49, 4, 'ETN 1036', 'SIMULACIÓN DE PROCESOS INDUSTRIALES', 1, 0, 1, 1),
(50, 4, 'ETN 1037', 'INSTRUMENTOS INDUSTRIALES', 1, 1, 1, 1),
(51, 4, 'ETN 1039', 'SEMINARIOS DE CONTROL', 1, 0, 1, 1),
(52, 4, 'REC 92', 'ESTUDIO DE LOS RECURSOS NATURALES', 1, 0, 1, 1),
(53, 4, 'ETN 906', 'PRÁCTICA INDUSTRIAL', 1, 0, 1, 1),
(54, 4, 'ETN 1040', 'PROYECTO DE GRADO', 1, 0, 1, 1),
(55, 4, 'ETN 1016', 'TEORÍA DE TELECOMUNICACIONES II', 1, 0, 1, 1),
(56, 4, 'ETN 825', 'ORGANIZACIÓN Y DISEÑO DE COMPUTADORAS', 1, 0, 1, 1),
(57, 4, 'ETN 1000', 'BASES DE DATOS', 1, 0, 1, 1),
(58, 4, 'ETN 1050', 'REDES DE COMPUTADORES', 1, 0, 1, 1),
(59, 4, 'ETN 1010', 'INTELIGENCIA ARTIFICIAL', 1, 0, 1, 1),
(60, 4, 'ETN 1001', 'INGENIERÍA DE SOFTWARE', 1, 0, 1, 1),
(61, 4, 'ETN 1012', 'TELEFONÍA', 1, 0, 1, 1),
(62, 4, 'ETN 2000', 'ESTRATEGIA EMPRESARIAL', 1, 0, 1, 1),
(63, 4, 'ETN 814', 'LINEAS DE TRANSMISIÓN Y GUÍAS DE ONDA', 1, 1, 1, 1),
(64, 4, 'ETN 911', 'SISTEMAS DE COMUNICACIONES I', 1, 1, 1, 1),
(65, 4, 'ETN 913', 'ANTENAS Y PROPAGACIÓN', 1, 1, 1, 1),
(66, 4, 'ETN 1011', 'SISTEMAS DE COMUNICACION II', 1, 1, 1, 1),
(67, 4, 'ETN 1024', 'SEMINARIO TALLER DE TELECOMUNICACIONES', 1, 0, 1, 1),
(68, 4, 'ETN 1038', 'TECNOLOGÍA DE TELECOMUNICACIONES', 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aulas`
--

DROP TABLE IF EXISTS `aulas`;
CREATE TABLE IF NOT EXISTS `aulas` (
  `aula_id` int NOT NULL AUTO_INCREMENT,
  `aula_nombre` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `aula_capacidad` int NOT NULL,
  `aula_estado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`aula_id`),
  UNIQUE KEY `aula_nombre_UK` (`aula_nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `aulas`
--

INSERT INTO `aulas` (`aula_id`, `aula_nombre`, `aula_capacidad`, `aula_estado`) VALUES
(1, '304', 100, 1),
(2, '305', 50, 1),
(3, '306', 50, 1),
(4, '307', 50, 1),
(5, '308', 40, 1),
(6, 'Laboratorio de Computación', 80, 1),
(7, 'Laboratorio de Electrónica', 50, 1),
(8, 'Laboratorio de Control', 30, 1),
(9, 'Laboratorio de Sistemas', 20, 1),
(10, 'Laboratorio de Telecomunicaciones', 20, 1),
(11, 'Laboratorio de Multimedia', 20, 1),
(12, 'Aula de Maestría', 20, 1),
(13, 'Aula de Docentes', 20, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auxiliares`
--

DROP TABLE IF EXISTS `auxiliares`;
CREATE TABLE IF NOT EXISTS `auxiliares` (
  `auxiliar_id` int NOT NULL AUTO_INCREMENT,
  `auxiliar_estudiante_id` int NOT NULL,
  `auxiliar_estado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`auxiliar_id`),
  UNIQUE KEY `auxiliar_estudiante_id_UK` (`auxiliar_estudiante_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `auxiliares`
--

INSERT INTO `auxiliares` (`auxiliar_id`, `auxiliar_estudiante_id`, `auxiliar_estado`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auxiliaturas`
--

DROP TABLE IF EXISTS `auxiliaturas`;
CREATE TABLE IF NOT EXISTS `auxiliaturas` (
  `auxiliatura_id` int NOT NULL AUTO_INCREMENT,
  `auxiliatura_auxiliar_id` int DEFAULT NULL,
  `auxiliatura_apertura_id` int NOT NULL,
  `auxiliatura_grupo` int NOT NULL DEFAULT '1',
  `auxiliatura_ponderacion` json DEFAULT NULL,
  PRIMARY KEY (`auxiliatura_id`),
  UNIQUE KEY `auxiliatura_grupo_apertura_id_UK` (`auxiliatura_grupo`,`auxiliatura_apertura_id`),
  UNIQUE KEY `auxiliatura_auxiliar_apertura_id_UK` (`auxiliatura_auxiliar_id`,`auxiliatura_apertura_id`),
  KEY `auxiliatura_apertura_id_FK` (`auxiliatura_apertura_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Disparadores `auxiliaturas`
--
DROP TRIGGER IF EXISTS `ponderacion_auxiliatura`;
DELIMITER $$
CREATE TRIGGER `ponderacion_auxiliatura` BEFORE INSERT ON `auxiliaturas` FOR EACH ROW BEGIN
    IF NEW.auxiliatura_ponderacion IS NULL THEN
        SET NEW.auxiliatura_ponderacion = JSON_OBJECT(
            'ponderacionPrincipal', 90,
            'ponderacionesPrincipal', JSON_OBJECT(
                '1', 33.3,
                '2', 33.3,
                '3', 33.4
            ),
            'ponderacionSecundaria', 10,
            'ponderacionesSecundaria', JSON_OBJECT(
                '1', 33.3
            )
        );
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

DROP TABLE IF EXISTS `cargos`;
CREATE TABLE IF NOT EXISTS `cargos` (
  `cargo_id` int NOT NULL AUTO_INCREMENT,
  `cargo_nombre` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`cargo_id`),
  UNIQUE KEY `cargo_nombre_UK` (`cargo_nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cargos`
--

INSERT INTO `cargos` (`cargo_id`, `cargo_nombre`) VALUES
(1, 'Director'),
(3, 'Mensajería'),
(2, 'Secetaría');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `categoria_id` int NOT NULL AUTO_INCREMENT,
  `categoria_nombre` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`categoria_id`),
  UNIQUE KEY `categoria_nombre_UK` (`categoria_nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`categoria_id`, `categoria_nombre`) VALUES
(3, 'Contratado'),
(1, 'Emérito'),
(2, 'Titular');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `celulares`
--

DROP TABLE IF EXISTS `celulares`;
CREATE TABLE IF NOT EXISTS `celulares` (
  `celular_id` int NOT NULL AUTO_INCREMENT,
  `celular_persona_id` int NOT NULL,
  `celular_pais_id` int NOT NULL,
  `celular_numero` int NOT NULL,
  PRIMARY KEY (`celular_id`),
  UNIQUE KEY `celular_persona_id_UK` (`celular_persona_id`),
  UNIQUE KEY `celular_numero_UK` (`celular_numero`),
  KEY `celular_pais_id_FK` (`celular_pais_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `celulares`
--

INSERT INTO `celulares` (`celular_id`, `celular_persona_id`, `celular_pais_id`, `celular_numero`) VALUES
(1, 1, 591, 75818001),
(2, 2, 591, 75818002),
(3, 3, 591, 75818003),
(4, 4, 591, 75818004),
(5, 5, 591, 75818005),
(6, 6, 591, 75818006),
(7, 7, 591, 75818007),
(8, 8, 591, 75818008),
(9, 9, 591, 75818009),
(10, 10, 591, 75818010),
(11, 11, 591, 75818011),
(12, 12, 330, 75818012),
(13, 1001, 591, 67080690),
(14, 1002, 591, 70634345),
(15, 1003, 591, 73274934),
(16, 1004, 591, 71537214),
(17, 1005, 591, 79106826),
(18, 1006, 591, 72050499),
(19, 1007, 591, 77294845),
(20, 1008, 591, 72010402),
(21, 1009, 591, 67022211),
(22, 1010, 591, 77292007),
(23, 1011, 591, 68104882),
(24, 1012, 591, 67349971),
(25, 1013, 591, 69878515),
(26, 1014, 591, 72565811),
(27, 1015, 591, 77296881),
(28, 1016, 591, 72055151),
(29, 1017, 591, 71539950),
(30, 1018, 591, 75272720),
(31, 1019, 591, 71557290),
(32, 1020, 591, 72034828),
(33, 1021, 591, 70544990),
(34, 1022, 591, 72550472),
(35, 1023, 591, 77225519),
(36, 1024, 591, 74070114),
(37, 1025, 591, 77569799),
(38, 1026, 591, 75887633),
(39, 1027, 591, 72557658),
(40, 1028, 591, 78960703),
(41, 1029, 591, 76539685),
(42, 1030, 591, 70581953),
(43, 1031, 591, 72532323),
(44, 1032, 591, 75801032),
(45, 1033, 591, 75801033),
(46, 1034, 591, 77514775),
(47, 1035, 591, 69701279),
(48, 1036, 591, 75801036),
(49, 1037, 591, 75801037),
(50, 1038, 591, 75801038),
(51, 1039, 591, 75801039),
(52, 1040, 591, 75801040),
(53, 1041, 591, 75801041),
(54, 1042, 591, 75801042);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases_auxiliaturas`
--

DROP TABLE IF EXISTS `clases_auxiliaturas`;
CREATE TABLE IF NOT EXISTS `clases_auxiliaturas` (
  `clase_auxiliatura_id` int NOT NULL AUTO_INCREMENT,
  `clase_auxiliatura_auxiliatura_id` int NOT NULL,
  `clase_auxiliatura_numero` int NOT NULL DEFAULT '1',
  `clase_auxiliatura_dia` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `clase_auxiliatura_hora_inicio` time DEFAULT NULL,
  `clase_auxiliatura_hora_fin` time DEFAULT NULL,
  `clase_auxiliatura_aula_id` int DEFAULT NULL,
  PRIMARY KEY (`clase_auxiliatura_id`),
  UNIQUE KEY `clase_auxiliatura_auxiliatura_id_numero_UK` (`clase_auxiliatura_auxiliatura_id`,`clase_auxiliatura_numero`),
  KEY `clase_auxiliatura_aula_id_FK` (`clase_auxiliatura_aula_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases_docencias`
--

DROP TABLE IF EXISTS `clases_docencias`;
CREATE TABLE IF NOT EXISTS `clases_docencias` (
  `clase_docencia_id` int NOT NULL AUTO_INCREMENT,
  `clase_docencia_docencia_id` int NOT NULL,
  `clase_docencia_numero` int NOT NULL DEFAULT '1',
  `clase_docencia_dia` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `clase_docencia_hora_inicio` time DEFAULT NULL,
  `clase_docencia_hora_fin` time DEFAULT NULL,
  `clase_docencia_aula_id` int DEFAULT NULL,
  PRIMARY KEY (`clase_docencia_id`),
  UNIQUE KEY `clase_docencia_docencia_id_numero_UK` (`clase_docencia_docencia_id`,`clase_docencia_numero`),
  KEY `clase_docencia_aula_id_FK` (`clase_docencia_aula_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigos`
--

DROP TABLE IF EXISTS `codigos`;
CREATE TABLE IF NOT EXISTS `codigos` (
  `codigo_id` int NOT NULL AUTO_INCREMENT,
  `codigo_usuario_id` int NOT NULL,
  `codigo_fecha` timestamp NOT NULL,
  `codigo_estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`codigo_id`),
  KEY `codigo_usuario_id_FK` (`codigo_usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correos`
--

DROP TABLE IF EXISTS `correos`;
CREATE TABLE IF NOT EXISTS `correos` (
  `correo_id` int NOT NULL AUTO_INCREMENT,
  `correo_persona_id` int NOT NULL,
  `correo_direccion` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`correo_id`),
  UNIQUE KEY `correo_persona_id_UK` (`correo_persona_id`),
  UNIQUE KEY `correo_direccion_UK` (`correo_direccion`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `correos`
--

INSERT INTO `correos` (`correo_id`, `correo_persona_id`, `correo_direccion`) VALUES
(1, 1, 'jluis.vs01@gmail.com'),
(2, 2, 'jluis.vs02@gmail.com'),
(3, 3, 'jluis.vs03@gmail.com'),
(4, 4, 'jluis.vs04@gmail.com'),
(5, 5, 'jluis.vs05@gmail.com'),
(6, 6, 'jluis.vs06@gmail.com'),
(7, 7, 'jluis.vs07@gmail.com'),
(8, 8, 'jluis.vs08@gmail.com'),
(9, 9, 'jluis.vs09@gmail.com'),
(10, 10, 'jluis.vs10@gmail.com'),
(11, 11, 'jluis.vs11@gmail.com'),
(12, 12, 'jluis.vs12@gmail.com'),
(13, 1001, 'j.albertoaguilera@gmail.com'),
(14, 1002, 'mauricioamestegui@gmail.com'),
(15, 1003, 'wamusca@yahoo.com'),
(16, 1004, 'riosjose29@gmail.com'),
(17, 1005, 'h.balderramabarrios@gmail.com'),
(18, 1006, 'hborjao@gmail.com'),
(19, 1007, 'goncabam@hotmail.com'),
(20, 1008, 'docente1008@gmail.com'),
(21, 1009, 'camperojose268@gmail.com'),
(22, 1010, 'docente1010@gmail.com'),
(23, 1011, 'contrerascjg@gmail.com'),
(24, 1012, 'teodorobuschdekovice@gmail.com'),
(25, 1013, 'franzalvarezg@gmail.com'),
(26, 1014, 'wsflores@umsa.bo'),
(27, 1015, 'mar2g6ut@gmail.com'),
(28, 1016, 'juradoalfonso05@gmail.com'),
(29, 1017, 'docente1017@gmail.com'),
(30, 1018, 'docente1018@gmail.com'),
(31, 1019, 'docente1019@gmail.com'),
(32, 1020, 'ammayori@gmail.com'),
(33, 1021, 'lm21650@hotmail.com'),
(34, 1022, 'eduardomolina2503@gmail.com'),
(35, 1023, 'jorgeantonio.navaamador@gmail.com'),
(36, 1024, 'robertooropezac@gmail.com'),
(37, 1025, 'clipar@gmail.com'),
(38, 1026, 'ramiro.puch@hotmail.com'),
(39, 1027, 'docente1027@gmail.com'),
(40, 1028, 'marcelo.ramirez.lpz@gmail.com'),
(41, 1029, 'rosas.luis.armando@gmail.com'),
(42, 1030, 'javisanabria@gmail.com'),
(43, 1031, 'fabiantito@gmail.com'),
(44, 1032, 'motorrez1@umsa.bo'),
(45, 1033, 'docente1033@gmail.com'),
(46, 1034, 'docente1034@gmail.com'),
(47, 1035, 'rzambrana@gmail.com'),
(48, 1036, 'vizotau@yahoo.com'),
(49, 1037, 'docente1037@gmail.com'),
(50, 1038, 'docente1038@gmail.com'),
(51, 1039, 'docente1039@gmail.com'),
(52, 1040, 'docente1040@gmail.com'),
(53, 1041, 'docente1041@gmail.com'),
(54, 1042, 'docente1042@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docencias`
--

DROP TABLE IF EXISTS `docencias`;
CREATE TABLE IF NOT EXISTS `docencias` (
  `docencia_id` int NOT NULL AUTO_INCREMENT,
  `docencia_docente_id` int DEFAULT NULL,
  `docencia_apertura_id` int NOT NULL,
  `docencia_grupo` int NOT NULL DEFAULT '1',
  `docencia_ponderacion` json DEFAULT NULL,
  PRIMARY KEY (`docencia_id`),
  UNIQUE KEY `docencia_grupo_apertura_id_UK` (`docencia_grupo`,`docencia_apertura_id`),
  UNIQUE KEY `docencia_docente_apertura_id_UK` (`docencia_docente_id`,`docencia_apertura_id`),
  KEY `docencia_apertura_id_FK` (`docencia_apertura_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Disparadores `docencias`
--
DROP TRIGGER IF EXISTS `ponderacion_docencia`;
DELIMITER $$
CREATE TRIGGER `ponderacion_docencia` BEFORE INSERT ON `docencias` FOR EACH ROW BEGIN
    IF NEW.docencia_ponderacion IS NULL THEN
        SET NEW.docencia_ponderacion = JSON_OBJECT(
            'ponderacionPrincipal', 90,
            'ponderacionesPrincipal', JSON_OBJECT(
                '1', 33.3,
                '2', 33.3,
                '3', 33.4
            ),
            'ponderacionSecundaria', 10,
            'ponderacionesSecundaria', JSON_OBJECT(
                '1', 33.3
            )
        );
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

DROP TABLE IF EXISTS `docentes`;
CREATE TABLE IF NOT EXISTS `docentes` (
  `docente_id` int NOT NULL AUTO_INCREMENT,
  `docente_persona_id` int NOT NULL,
  `docente_categoria_id` int NOT NULL,
  `docente_grado` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `docente_estado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`docente_id`),
  UNIQUE KEY `docente_persona_id_UK` (`docente_persona_id`),
  KEY `docente_categoria_id_FK` (`docente_categoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`docente_id`, `docente_persona_id`, `docente_categoria_id`, `docente_grado`, `docente_estado`) VALUES
(1, 1001, 1, 'ING.', 1),
(2, 1002, 1, 'ING.', 1),
(3, 1003, 1, 'ING.', 1),
(4, 1004, 1, 'ING.', 1),
(5, 1005, 1, 'ING.', 1),
(6, 1006, 1, 'ING.', 1),
(7, 1007, 1, 'ING.', 1),
(8, 1008, 1, 'ING.', 1),
(9, 1009, 1, 'ING.', 1),
(10, 1010, 1, 'ING.', 1),
(11, 1011, 1, 'LIC.', 1),
(12, 1012, 1, 'ING.', 1),
(13, 1013, 1, 'ING.', 1),
(14, 1014, 1, 'ING.', 1),
(15, 1015, 1, 'ING.', 1),
(16, 1016, 1, 'ING.', 1),
(17, 1017, 1, 'ING.', 1),
(18, 1018, 1, 'ING.', 1),
(19, 1019, 1, 'ING.', 1),
(20, 1020, 1, 'ING.', 1),
(21, 1021, 1, 'LIC.', 1),
(22, 1022, 1, 'ING.', 1),
(23, 1023, 1, 'ING.', 1),
(24, 1024, 1, 'ING.', 1),
(25, 1025, 1, 'ING.', 1),
(26, 1026, 1, 'ING.', 1),
(27, 1027, 1, 'ING.', 1),
(28, 1028, 1, 'ING.', 1),
(29, 1029, 1, 'ING.', 1),
(30, 1030, 1, 'ING.', 1),
(31, 1031, 1, 'ING.', 1),
(32, 1032, 1, 'ING.', 1),
(33, 1033, 1, 'ING.', 1),
(34, 1034, 1, 'ING.', 1),
(35, 1035, 1, 'ING.', 1),
(36, 1036, 1, 'LIC.', 1),
(37, 1037, 1, 'ING.', 1),
(38, 1038, 1, 'ING.', 1),
(39, 1039, 1, 'ING.', 1),
(40, 1040, 1, 'ING.', 1),
(41, 1041, 1, 'ING.', 1),
(42, 1042, 1, 'ING.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `domicilios`
--

DROP TABLE IF EXISTS `domicilios`;
CREATE TABLE IF NOT EXISTS `domicilios` (
  `domicilio_id` int NOT NULL AUTO_INCREMENT,
  `domicilio_persona_id` int NOT NULL,
  `domicilio_direccion` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`domicilio_id`),
  UNIQUE KEY `domicilio_persona_id_UK` (`domicilio_persona_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `domicilios`
--

INSERT INTO `domicilios` (`domicilio_id`, `domicilio_persona_id`, `domicilio_direccion`) VALUES
(1, 1, 'C. José Ávila Z. Franz Tamayo #3792'),
(2, 2, 'C. José Ávila Z. Franz Tamayo #3792'),
(3, 3, 'C. José Ávila Z. Franz Tamayo #3792'),
(4, 4, 'C. José Ávila Z. Franz Tamayo #3792'),
(5, 5, 'C. José Ávila Z. Franz Tamayo #3792'),
(6, 6, 'C. José Ávila Z. Franz Tamayo #3792'),
(7, 7, 'C. José Ávila Z. Franz Tamayo #3792'),
(8, 8, 'C. José Ávila Z. Franz Tamayo #3792'),
(9, 9, 'C. José Ávila Z. Franz Tamayo #3792'),
(10, 10, 'C. José Ávila Z. Franz Tamayo #3792'),
(11, 11, 'C. José Ávila Z. Franz Tamayo #3792'),
(12, 12, 'C. José Ávila Z. Franz Tamayo #3792'),
(13, 1001, 'C. José Ávila Z. Franz Tamayo #3792'),
(14, 1002, 'C. José Ávila Z. Franz Tamayo #3792'),
(15, 1003, 'C. José Ávila Z. Franz Tamayo #3792'),
(16, 1004, 'C. José Ávila Z. Franz Tamayo #3792'),
(17, 1005, 'C. José Ávila Z. Franz Tamayo #3792'),
(18, 1006, 'C. José Ávila Z. Franz Tamayo #3792'),
(19, 1007, 'C. José Ávila Z. Franz Tamayo #3792'),
(20, 1008, 'C. José Ávila Z. Franz Tamayo #3792'),
(21, 1009, 'C. José Ávila Z. Franz Tamayo #3792'),
(22, 1010, 'C. José Ávila Z. Franz Tamayo #3792'),
(23, 1011, 'C. José Ávila Z. Franz Tamayo #3792'),
(24, 1012, 'C. José Ávila Z. Franz Tamayo #3792'),
(25, 1013, 'C. José Ávila Z. Franz Tamayo #3792'),
(26, 1014, 'C. José Ávila Z. Franz Tamayo #3792'),
(27, 1015, 'C. José Ávila Z. Franz Tamayo #3792'),
(28, 1016, 'C. José Ávila Z. Franz Tamayo #3792'),
(29, 1017, 'C. José Ávila Z. Franz Tamayo #3792'),
(30, 1018, 'C. José Ávila Z. Franz Tamayo #3792'),
(31, 1019, 'C. José Ávila Z. Franz Tamayo #3792'),
(32, 1020, 'C. José Ávila Z. Franz Tamayo #3792'),
(33, 1021, 'C. José Ávila Z. Franz Tamayo #3792'),
(34, 1022, 'C. José Ávila Z. Franz Tamayo #3792'),
(35, 1023, 'C. José Ávila Z. Franz Tamayo #3792'),
(36, 1024, 'C. José Ávila Z. Franz Tamayo #3792'),
(37, 1025, 'C. José Ávila Z. Franz Tamayo #3792'),
(38, 1026, 'C. José Ávila Z. Franz Tamayo #3792'),
(39, 1027, 'C. José Ávila Z. Franz Tamayo #3792'),
(40, 1028, 'C. José Ávila Z. Franz Tamayo #3792'),
(41, 1029, 'C. José Ávila Z. Franz Tamayo #3792'),
(42, 1030, 'C. José Ávila Z. Franz Tamayo #3792'),
(43, 1031, 'C. José Ávila Z. Franz Tamayo #3792'),
(44, 1032, 'C. José Ávila Z. Franz Tamayo #3792'),
(45, 1033, 'C. José Ávila Z. Franz Tamayo #3792'),
(46, 1034, 'C. José Ávila Z. Franz Tamayo #3792'),
(47, 1035, 'C. José Ávila Z. Franz Tamayo #3792'),
(48, 1036, 'C. José Ávila Z. Franz Tamayo #3792'),
(49, 1037, 'C. José Ávila Z. Franz Tamayo #3792'),
(50, 1038, 'C. José Ávila Z. Franz Tamayo #3792'),
(51, 1039, 'C. José Ávila Z. Franz Tamayo #3792'),
(52, 1040, 'C. José Ávila Z. Franz Tamayo #3792'),
(53, 1041, 'C. José Ávila Z. Franz Tamayo #3792'),
(54, 1042, 'C. José Ávila Z. Franz Tamayo #3792');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

DROP TABLE IF EXISTS `estudiantes`;
CREATE TABLE IF NOT EXISTS `estudiantes` (
  `estudiante_id` int NOT NULL AUTO_INCREMENT,
  `estudiante_persona_id` int NOT NULL,
  `estudiante_ru` int NOT NULL,
  `estudiante_estado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`estudiante_id`),
  UNIQUE KEY `estudiante_persona_id_UK` (`estudiante_persona_id`),
  UNIQUE KEY `estudiante_ru_UK` (`estudiante_ru`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`estudiante_id`, `estudiante_persona_id`, `estudiante_ru`, `estudiante_estado`) VALUES
(1, 10, 1649010, 1),
(2, 11, 1649011, 1),
(3, 12, 1649012, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos`
--

DROP TABLE IF EXISTS `fotos`;
CREATE TABLE IF NOT EXISTS `fotos` (
  `foto_id` int NOT NULL AUTO_INCREMENT,
  `foto_persona_id` int NOT NULL,
  `foto_archivo` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`foto_id`),
  UNIQUE KEY `foto_persona_id_UK` (`foto_persona_id`),
  UNIQUE KEY `foto_archivo_numero_UK` (`foto_archivo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historiales`
--

DROP TABLE IF EXISTS `historiales`;
CREATE TABLE IF NOT EXISTS `historiales` (
  `historial_id` int NOT NULL AUTO_INCREMENT,
  `historial_estudiante_id` int NOT NULL,
  `historial_asignatura_id` int DEFAULT NULL,
  `historial_nota` int NOT NULL,
  `historial_convalidacion` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`historial_id`),
  KEY `historial_estudiante_id_FK` (`historial_estudiante_id`),
  KEY `historial_asignatura_id_FK` (`historial_asignatura_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `horario_id` int NOT NULL AUTO_INCREMENT,
  `horario_dia` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `horario_inicio` time NOT NULL,
  `horario_fin` time NOT NULL,
  PRIMARY KEY (`horario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=325 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`horario_id`, `horario_dia`, `horario_inicio`, `horario_fin`) VALUES
(1, 'Lunes', '07:30:00', '07:45:00'),
(2, 'Lunes', '07:45:00', '08:00:00'),
(3, 'Lunes', '08:00:00', '08:15:00'),
(4, 'Lunes', '08:15:00', '08:30:00'),
(5, 'Lunes', '08:30:00', '08:45:00'),
(6, 'Lunes', '08:45:00', '09:00:00'),
(7, 'Lunes', '09:00:00', '09:15:00'),
(8, 'Lunes', '09:15:00', '09:30:00'),
(9, 'Lunes', '09:30:00', '09:45:00'),
(10, 'Lunes', '09:45:00', '10:00:00'),
(11, 'Lunes', '10:00:00', '10:15:00'),
(12, 'Lunes', '10:15:00', '10:30:00'),
(13, 'Lunes', '10:30:00', '10:45:00'),
(14, 'Lunes', '10:45:00', '11:00:00'),
(15, 'Lunes', '11:00:00', '11:15:00'),
(16, 'Lunes', '11:15:00', '11:30:00'),
(17, 'Lunes', '11:30:00', '11:45:00'),
(18, 'Lunes', '11:45:00', '12:00:00'),
(19, 'Lunes', '12:00:00', '12:15:00'),
(20, 'Lunes', '12:15:00', '12:30:00'),
(21, 'Lunes', '12:30:00', '12:45:00'),
(22, 'Lunes', '12:45:00', '13:00:00'),
(23, 'Lunes', '13:00:00', '13:15:00'),
(24, 'Lunes', '13:15:00', '13:30:00'),
(25, 'Lunes', '13:30:00', '13:45:00'),
(26, 'Lunes', '13:45:00', '14:00:00'),
(27, 'Lunes', '14:00:00', '14:15:00'),
(28, 'Lunes', '14:15:00', '14:30:00'),
(29, 'Lunes', '14:30:00', '14:45:00'),
(30, 'Lunes', '14:45:00', '15:00:00'),
(31, 'Lunes', '15:00:00', '15:15:00'),
(32, 'Lunes', '15:15:00', '15:30:00'),
(33, 'Lunes', '15:30:00', '15:45:00'),
(34, 'Lunes', '15:45:00', '16:00:00'),
(35, 'Lunes', '16:00:00', '16:15:00'),
(36, 'Lunes', '16:15:00', '16:30:00'),
(37, 'Lunes', '16:30:00', '16:45:00'),
(38, 'Lunes', '16:45:00', '17:00:00'),
(39, 'Lunes', '17:00:00', '17:15:00'),
(40, 'Lunes', '17:15:00', '17:30:00'),
(41, 'Lunes', '17:30:00', '17:45:00'),
(42, 'Lunes', '17:45:00', '18:00:00'),
(43, 'Lunes', '18:00:00', '18:15:00'),
(44, 'Lunes', '18:15:00', '18:30:00'),
(45, 'Lunes', '18:30:00', '18:45:00'),
(46, 'Lunes', '18:45:00', '19:00:00'),
(47, 'Lunes', '19:00:00', '19:15:00'),
(48, 'Lunes', '19:15:00', '19:30:00'),
(49, 'Lunes', '19:30:00', '19:45:00'),
(50, 'Lunes', '19:45:00', '20:00:00'),
(51, 'Lunes', '20:00:00', '20:15:00'),
(52, 'Lunes', '20:15:00', '20:30:00'),
(53, 'Lunes', '20:30:00', '20:45:00'),
(54, 'Lunes', '20:45:00', '21:00:00'),
(55, 'Martes', '07:30:00', '07:45:00'),
(56, 'Martes', '07:45:00', '08:00:00'),
(57, 'Martes', '08:00:00', '08:15:00'),
(58, 'Martes', '08:15:00', '08:30:00'),
(59, 'Martes', '08:30:00', '08:45:00'),
(60, 'Martes', '08:45:00', '09:00:00'),
(61, 'Martes', '09:00:00', '09:15:00'),
(62, 'Martes', '09:15:00', '09:30:00'),
(63, 'Martes', '09:30:00', '09:45:00'),
(64, 'Martes', '09:45:00', '10:00:00'),
(65, 'Martes', '10:00:00', '10:15:00'),
(66, 'Martes', '10:15:00', '10:30:00'),
(67, 'Martes', '10:30:00', '10:45:00'),
(68, 'Martes', '10:45:00', '11:00:00'),
(69, 'Martes', '11:00:00', '11:15:00'),
(70, 'Martes', '11:15:00', '11:30:00'),
(71, 'Martes', '11:30:00', '11:45:00'),
(72, 'Martes', '11:45:00', '12:00:00'),
(73, 'Martes', '12:00:00', '12:15:00'),
(74, 'Martes', '12:15:00', '12:30:00'),
(75, 'Martes', '12:30:00', '12:45:00'),
(76, 'Martes', '12:45:00', '13:00:00'),
(77, 'Martes', '13:00:00', '13:15:00'),
(78, 'Martes', '13:15:00', '13:30:00'),
(79, 'Martes', '13:30:00', '13:45:00'),
(80, 'Martes', '13:45:00', '14:00:00'),
(81, 'Martes', '14:00:00', '14:15:00'),
(82, 'Martes', '14:15:00', '14:30:00'),
(83, 'Martes', '14:30:00', '14:45:00'),
(84, 'Martes', '14:45:00', '15:00:00'),
(85, 'Martes', '15:00:00', '15:15:00'),
(86, 'Martes', '15:15:00', '15:30:00'),
(87, 'Martes', '15:30:00', '15:45:00'),
(88, 'Martes', '15:45:00', '16:00:00'),
(89, 'Martes', '16:00:00', '16:15:00'),
(90, 'Martes', '16:15:00', '16:30:00'),
(91, 'Martes', '16:30:00', '16:45:00'),
(92, 'Martes', '16:45:00', '17:00:00'),
(93, 'Martes', '17:00:00', '17:15:00'),
(94, 'Martes', '17:15:00', '17:30:00'),
(95, 'Martes', '17:30:00', '17:45:00'),
(96, 'Martes', '17:45:00', '18:00:00'),
(97, 'Martes', '18:00:00', '18:15:00'),
(98, 'Martes', '18:15:00', '18:30:00'),
(99, 'Martes', '18:30:00', '18:45:00'),
(100, 'Martes', '18:45:00', '19:00:00'),
(101, 'Martes', '19:00:00', '19:15:00'),
(102, 'Martes', '19:15:00', '19:30:00'),
(103, 'Martes', '19:30:00', '19:45:00'),
(104, 'Martes', '19:45:00', '20:00:00'),
(105, 'Martes', '20:00:00', '20:15:00'),
(106, 'Martes', '20:15:00', '20:30:00'),
(107, 'Martes', '20:30:00', '20:45:00'),
(108, 'Martes', '20:45:00', '21:00:00'),
(109, 'Miércoles', '07:30:00', '07:45:00'),
(110, 'Miércoles', '07:45:00', '08:00:00'),
(111, 'Miércoles', '08:00:00', '08:15:00'),
(112, 'Miércoles', '08:15:00', '08:30:00'),
(113, 'Miércoles', '08:30:00', '08:45:00'),
(114, 'Miércoles', '08:45:00', '09:00:00'),
(115, 'Miércoles', '09:00:00', '09:15:00'),
(116, 'Miércoles', '09:15:00', '09:30:00'),
(117, 'Miércoles', '09:30:00', '09:45:00'),
(118, 'Miércoles', '09:45:00', '10:00:00'),
(119, 'Miércoles', '10:00:00', '10:15:00'),
(120, 'Miércoles', '10:15:00', '10:30:00'),
(121, 'Miércoles', '10:30:00', '10:45:00'),
(122, 'Miércoles', '10:45:00', '11:00:00'),
(123, 'Miércoles', '11:00:00', '11:15:00'),
(124, 'Miércoles', '11:15:00', '11:30:00'),
(125, 'Miércoles', '11:30:00', '11:45:00'),
(126, 'Miércoles', '11:45:00', '12:00:00'),
(127, 'Miércoles', '12:00:00', '12:15:00'),
(128, 'Miércoles', '12:15:00', '12:30:00'),
(129, 'Miércoles', '12:30:00', '12:45:00'),
(130, 'Miércoles', '12:45:00', '13:00:00'),
(131, 'Miércoles', '13:00:00', '13:15:00'),
(132, 'Miércoles', '13:15:00', '13:30:00'),
(133, 'Miércoles', '13:30:00', '13:45:00'),
(134, 'Miércoles', '13:45:00', '14:00:00'),
(135, 'Miércoles', '14:00:00', '14:15:00'),
(136, 'Miércoles', '14:15:00', '14:30:00'),
(137, 'Miércoles', '14:30:00', '14:45:00'),
(138, 'Miércoles', '14:45:00', '15:00:00'),
(139, 'Miércoles', '15:00:00', '15:15:00'),
(140, 'Miércoles', '15:15:00', '15:30:00'),
(141, 'Miércoles', '15:30:00', '15:45:00'),
(142, 'Miércoles', '15:45:00', '16:00:00'),
(143, 'Miércoles', '16:00:00', '16:15:00'),
(144, 'Miércoles', '16:15:00', '16:30:00'),
(145, 'Miércoles', '16:30:00', '16:45:00'),
(146, 'Miércoles', '16:45:00', '17:00:00'),
(147, 'Miércoles', '17:00:00', '17:15:00'),
(148, 'Miércoles', '17:15:00', '17:30:00'),
(149, 'Miércoles', '17:30:00', '17:45:00'),
(150, 'Miércoles', '17:45:00', '18:00:00'),
(151, 'Miércoles', '18:00:00', '18:15:00'),
(152, 'Miércoles', '18:15:00', '18:30:00'),
(153, 'Miércoles', '18:30:00', '18:45:00'),
(154, 'Miércoles', '18:45:00', '19:00:00'),
(155, 'Miércoles', '19:00:00', '19:15:00'),
(156, 'Miércoles', '19:15:00', '19:30:00'),
(157, 'Miércoles', '19:30:00', '19:45:00'),
(158, 'Miércoles', '19:45:00', '20:00:00'),
(159, 'Miércoles', '20:00:00', '20:15:00'),
(160, 'Miércoles', '20:15:00', '20:30:00'),
(161, 'Miércoles', '20:30:00', '20:45:00'),
(162, 'Miércoles', '20:45:00', '21:00:00'),
(163, 'Jueves', '07:30:00', '07:45:00'),
(164, 'Jueves', '07:45:00', '08:00:00'),
(165, 'Jueves', '08:00:00', '08:15:00'),
(166, 'Jueves', '08:15:00', '08:30:00'),
(167, 'Jueves', '08:30:00', '08:45:00'),
(168, 'Jueves', '08:45:00', '09:00:00'),
(169, 'Jueves', '09:00:00', '09:15:00'),
(170, 'Jueves', '09:15:00', '09:30:00'),
(171, 'Jueves', '09:30:00', '09:45:00'),
(172, 'Jueves', '09:45:00', '10:00:00'),
(173, 'Jueves', '10:00:00', '10:15:00'),
(174, 'Jueves', '10:15:00', '10:30:00'),
(175, 'Jueves', '10:30:00', '10:45:00'),
(176, 'Jueves', '10:45:00', '11:00:00'),
(177, 'Jueves', '11:00:00', '11:15:00'),
(178, 'Jueves', '11:15:00', '11:30:00'),
(179, 'Jueves', '11:30:00', '11:45:00'),
(180, 'Jueves', '11:45:00', '12:00:00'),
(181, 'Jueves', '12:00:00', '12:15:00'),
(182, 'Jueves', '12:15:00', '12:30:00'),
(183, 'Jueves', '12:30:00', '12:45:00'),
(184, 'Jueves', '12:45:00', '13:00:00'),
(185, 'Jueves', '13:00:00', '13:15:00'),
(186, 'Jueves', '13:15:00', '13:30:00'),
(187, 'Jueves', '13:30:00', '13:45:00'),
(188, 'Jueves', '13:45:00', '14:00:00'),
(189, 'Jueves', '14:00:00', '14:15:00'),
(190, 'Jueves', '14:15:00', '14:30:00'),
(191, 'Jueves', '14:30:00', '14:45:00'),
(192, 'Jueves', '14:45:00', '15:00:00'),
(193, 'Jueves', '15:00:00', '15:15:00'),
(194, 'Jueves', '15:15:00', '15:30:00'),
(195, 'Jueves', '15:30:00', '15:45:00'),
(196, 'Jueves', '15:45:00', '16:00:00'),
(197, 'Jueves', '16:00:00', '16:15:00'),
(198, 'Jueves', '16:15:00', '16:30:00'),
(199, 'Jueves', '16:30:00', '16:45:00'),
(200, 'Jueves', '16:45:00', '17:00:00'),
(201, 'Jueves', '17:00:00', '17:15:00'),
(202, 'Jueves', '17:15:00', '17:30:00'),
(203, 'Jueves', '17:30:00', '17:45:00'),
(204, 'Jueves', '17:45:00', '18:00:00'),
(205, 'Jueves', '18:00:00', '18:15:00'),
(206, 'Jueves', '18:15:00', '18:30:00'),
(207, 'Jueves', '18:30:00', '18:45:00'),
(208, 'Jueves', '18:45:00', '19:00:00'),
(209, 'Jueves', '19:00:00', '19:15:00'),
(210, 'Jueves', '19:15:00', '19:30:00'),
(211, 'Jueves', '19:30:00', '19:45:00'),
(212, 'Jueves', '19:45:00', '20:00:00'),
(213, 'Jueves', '20:00:00', '20:15:00'),
(214, 'Jueves', '20:15:00', '20:30:00'),
(215, 'Jueves', '20:30:00', '20:45:00'),
(216, 'Jueves', '20:45:00', '21:00:00'),
(217, 'Viernes', '07:30:00', '07:45:00'),
(218, 'Viernes', '07:45:00', '08:00:00'),
(219, 'Viernes', '08:00:00', '08:15:00'),
(220, 'Viernes', '08:15:00', '08:30:00'),
(221, 'Viernes', '08:30:00', '08:45:00'),
(222, 'Viernes', '08:45:00', '09:00:00'),
(223, 'Viernes', '09:00:00', '09:15:00'),
(224, 'Viernes', '09:15:00', '09:30:00'),
(225, 'Viernes', '09:30:00', '09:45:00'),
(226, 'Viernes', '09:45:00', '10:00:00'),
(227, 'Viernes', '10:00:00', '10:15:00'),
(228, 'Viernes', '10:15:00', '10:30:00'),
(229, 'Viernes', '10:30:00', '10:45:00'),
(230, 'Viernes', '10:45:00', '11:00:00'),
(231, 'Viernes', '11:00:00', '11:15:00'),
(232, 'Viernes', '11:15:00', '11:30:00'),
(233, 'Viernes', '11:30:00', '11:45:00'),
(234, 'Viernes', '11:45:00', '12:00:00'),
(235, 'Viernes', '12:00:00', '12:15:00'),
(236, 'Viernes', '12:15:00', '12:30:00'),
(237, 'Viernes', '12:30:00', '12:45:00'),
(238, 'Viernes', '12:45:00', '13:00:00'),
(239, 'Viernes', '13:00:00', '13:15:00'),
(240, 'Viernes', '13:15:00', '13:30:00'),
(241, 'Viernes', '13:30:00', '13:45:00'),
(242, 'Viernes', '13:45:00', '14:00:00'),
(243, 'Viernes', '14:00:00', '14:15:00'),
(244, 'Viernes', '14:15:00', '14:30:00'),
(245, 'Viernes', '14:30:00', '14:45:00'),
(246, 'Viernes', '14:45:00', '15:00:00'),
(247, 'Viernes', '15:00:00', '15:15:00'),
(248, 'Viernes', '15:15:00', '15:30:00'),
(249, 'Viernes', '15:30:00', '15:45:00'),
(250, 'Viernes', '15:45:00', '16:00:00'),
(251, 'Viernes', '16:00:00', '16:15:00'),
(252, 'Viernes', '16:15:00', '16:30:00'),
(253, 'Viernes', '16:30:00', '16:45:00'),
(254, 'Viernes', '16:45:00', '17:00:00'),
(255, 'Viernes', '17:00:00', '17:15:00'),
(256, 'Viernes', '17:15:00', '17:30:00'),
(257, 'Viernes', '17:30:00', '17:45:00'),
(258, 'Viernes', '17:45:00', '18:00:00'),
(259, 'Viernes', '18:00:00', '18:15:00'),
(260, 'Viernes', '18:15:00', '18:30:00'),
(261, 'Viernes', '18:30:00', '18:45:00'),
(262, 'Viernes', '18:45:00', '19:00:00'),
(263, 'Viernes', '19:00:00', '19:15:00'),
(264, 'Viernes', '19:15:00', '19:30:00'),
(265, 'Viernes', '19:30:00', '19:45:00'),
(266, 'Viernes', '19:45:00', '20:00:00'),
(267, 'Viernes', '20:00:00', '20:15:00'),
(268, 'Viernes', '20:15:00', '20:30:00'),
(269, 'Viernes', '20:30:00', '20:45:00'),
(270, 'Viernes', '20:45:00', '21:00:00'),
(271, 'Sábado', '07:30:00', '07:45:00'),
(272, 'Sábado', '07:45:00', '08:00:00'),
(273, 'Sábado', '08:00:00', '08:15:00'),
(274, 'Sábado', '08:15:00', '08:30:00'),
(275, 'Sábado', '08:30:00', '08:45:00'),
(276, 'Sábado', '08:45:00', '09:00:00'),
(277, 'Sábado', '09:00:00', '09:15:00'),
(278, 'Sábado', '09:15:00', '09:30:00'),
(279, 'Sábado', '09:30:00', '09:45:00'),
(280, 'Sábado', '09:45:00', '10:00:00'),
(281, 'Sábado', '10:00:00', '10:15:00'),
(282, 'Sábado', '10:15:00', '10:30:00'),
(283, 'Sábado', '10:30:00', '10:45:00'),
(284, 'Sábado', '10:45:00', '11:00:00'),
(285, 'Sábado', '11:00:00', '11:15:00'),
(286, 'Sábado', '11:15:00', '11:30:00'),
(287, 'Sábado', '11:30:00', '11:45:00'),
(288, 'Sábado', '11:45:00', '12:00:00'),
(289, 'Sábado', '12:00:00', '12:15:00'),
(290, 'Sábado', '12:15:00', '12:30:00'),
(291, 'Sábado', '12:30:00', '12:45:00'),
(292, 'Sábado', '12:45:00', '13:00:00'),
(293, 'Sábado', '13:00:00', '13:15:00'),
(294, 'Sábado', '13:15:00', '13:30:00'),
(295, 'Sábado', '13:30:00', '13:45:00'),
(296, 'Sábado', '13:45:00', '14:00:00'),
(297, 'Sábado', '14:00:00', '14:15:00'),
(298, 'Sábado', '14:15:00', '14:30:00'),
(299, 'Sábado', '14:30:00', '14:45:00'),
(300, 'Sábado', '14:45:00', '15:00:00'),
(301, 'Sábado', '15:00:00', '15:15:00'),
(302, 'Sábado', '15:15:00', '15:30:00'),
(303, 'Sábado', '15:30:00', '15:45:00'),
(304, 'Sábado', '15:45:00', '16:00:00'),
(305, 'Sábado', '16:00:00', '16:15:00'),
(306, 'Sábado', '16:15:00', '16:30:00'),
(307, 'Sábado', '16:30:00', '16:45:00'),
(308, 'Sábado', '16:45:00', '17:00:00'),
(309, 'Sábado', '17:00:00', '17:15:00'),
(310, 'Sábado', '17:15:00', '17:30:00'),
(311, 'Sábado', '17:30:00', '17:45:00'),
(312, 'Sábado', '17:45:00', '18:00:00'),
(313, 'Sábado', '18:00:00', '18:15:00'),
(314, 'Sábado', '18:15:00', '18:30:00'),
(315, 'Sábado', '18:30:00', '18:45:00'),
(316, 'Sábado', '18:45:00', '19:00:00'),
(317, 'Sábado', '19:00:00', '19:15:00'),
(318, 'Sábado', '19:15:00', '19:30:00'),
(319, 'Sábado', '19:30:00', '19:45:00'),
(320, 'Sábado', '19:45:00', '20:00:00'),
(321, 'Sábado', '20:00:00', '20:15:00'),
(322, 'Sábado', '20:15:00', '20:30:00'),
(323, 'Sábado', '20:30:00', '20:45:00'),
(324, 'Sábado', '20:45:00', '21:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios_aulas`
--

DROP TABLE IF EXISTS `horarios_aulas`;
CREATE TABLE IF NOT EXISTS `horarios_aulas` (
  `horario_aula_id` int NOT NULL AUTO_INCREMENT,
  `horario_aula_periodo_id` int NOT NULL,
  `horario_aula_aula_id` int NOT NULL,
  `horario_aula_archivo` varchar(255) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`horario_aula_id`),
  UNIQUE KEY `horario_aula_periodo_aula_id_UK` (`horario_aula_periodo_id`,`horario_aula_aula_id`),
  UNIQUE KEY `horario_aula_archivo_UK` (`horario_aula_archivo`),
  KEY `horario_aula_aula_id_FK` (`horario_aula_aula_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `horarios_aulas`
--

INSERT INTO `horarios_aulas` (`horario_aula_id`, `horario_aula_periodo_id`, `horario_aula_aula_id`, `horario_aula_archivo`) VALUES
(1, 14, 1, 'Horario_Aula_304_1-2023.pdf'),
(2, 14, 2, 'Horario_Aula_305_1-2023.pdf'),
(3, 14, 3, 'Horario_Aula_306_1-2023.pdf'),
(4, 14, 4, 'Horario_Aula_307_1-2023.pdf'),
(5, 14, 5, 'Horario_Aula_308_1-2023.pdf'),
(6, 14, 6, 'Horario_Aula_Sala_Computación_1-2023.pdf'),
(7, 14, 7, 'Horario_Aula_Lab_Electrónica_1-2023.pdf'),
(8, 14, 8, 'Horario_Aula_Lab_Control_1-2023.pdf'),
(9, 14, 9, 'Horario_Aula_Lab_Sistemas_1-2023.pdf'),
(10, 14, 10, 'Horario_Aula_Lab_Telecomunicaaciones_1-2023.pdf'),
(11, 14, 11, 'Horario_Aula_Lab_Multimedia_1-2023.pdf'),
(12, 14, 12, 'Horario_Aula_Sala_Maestría_1-2023.pdf'),
(13, 14, 13, 'Horario_Aula_Sala_Docentes_1-2023.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios_semestres`
--

DROP TABLE IF EXISTS `horarios_semestres`;
CREATE TABLE IF NOT EXISTS `horarios_semestres` (
  `horario_seme_id` int NOT NULL AUTO_INCREMENT,
  `horario_seme_periodo_id` int NOT NULL,
  `horario_seme_semestre_id` int NOT NULL,
  `horario_seme_mencion_id` int NOT NULL,
  `horario_seme_archivo` varchar(255) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`horario_seme_id`),
  UNIQUE KEY `horario_seme_periodo_semestre_mencion_id_UK` (`horario_seme_periodo_id`,`horario_seme_semestre_id`,`horario_seme_mencion_id`),
  UNIQUE KEY `horario_seme_archivo_UK` (`horario_seme_archivo`),
  KEY `horario_seme_semestre_id_FK` (`horario_seme_semestre_id`),
  KEY `horario_seme_mencion_id_FK` (`horario_seme_mencion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `horarios_semestres`
--

INSERT INTO `horarios_semestres` (`horario_seme_id`, `horario_seme_periodo_id`, `horario_seme_semestre_id`, `horario_seme_mencion_id`, `horario_seme_archivo`) VALUES
(1, 14, 1, 1, 'Horario_Semestre_1_1-2023.pdf'),
(2, 14, 2, 1, 'Horario_Semestre_2_1-2023.pdf'),
(3, 14, 3, 1, 'Horario_Semestre_3_1-2023.pdf'),
(4, 14, 4, 1, 'Horario_Semestre_4_1-2023.pdf'),
(5, 14, 5, 1, 'Horario_Semestre_5_1-2023.pdf'),
(6, 14, 6, 1, 'Horario_Semestre_6_1-2023.pdf'),
(7, 14, 7, 1, 'Horario_Semestre_7_Control_1-2023.pdf'),
(8, 14, 7, 2, 'Horario_Semestre_7_Sistemas_1-2023.pdf'),
(9, 14, 7, 3, 'Horario_Semestre_7_Telecomunicaciones_1-2023.pdf'),
(10, 14, 8, 1, 'Horario_Semestre_8_Control_1-2023.pdf'),
(11, 14, 8, 2, 'Horario_Semestre_8_Sistemas_1-2023.pdf'),
(12, 14, 8, 3, 'Horario_Semestre_8_Telecomunicaciones_1-2023.pdf'),
(13, 14, 9, 1, 'Horario_Semestre_9_Control_1-2023.pdf'),
(14, 14, 9, 2, 'Horario_Semestre_9_Sistemas_1-2023.pdf'),
(15, 14, 9, 3, 'Horario_Semestre_9_Telecomunicaciones_1-2023.pdf'),
(16, 14, 10, 1, 'Horario_Semestre_10_Control_1-2023.pdf'),
(17, 14, 10, 2, 'Horario_Semestre_10_Sistemas_1-2023.pdf'),
(18, 14, 10, 3, 'Horario_Semestre_10_Telecomunicaciones_1-2023.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iconos`
--

DROP TABLE IF EXISTS `iconos`;
CREATE TABLE IF NOT EXISTS `iconos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `icono` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `fuente` varchar(255) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

DROP TABLE IF EXISTS `inscripciones`;
CREATE TABLE IF NOT EXISTS `inscripciones` (
  `inscripcion_id` int NOT NULL AUTO_INCREMENT,
  `inscripcion_estudiante_id` int NOT NULL,
  `inscripcion_apertura_id` int NOT NULL,
  `inscripcion_fecha` timestamp NOT NULL,
  `inscripcion_nota_docencia` json DEFAULT NULL,
  `inscripcion_nota_auxiliatura` json DEFAULT NULL,
  `inscripcion_estado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`inscripcion_id`),
  KEY `inscripcion_estudiante_id_FK` (`inscripcion_estudiante_id`),
  KEY `inscripcion_apertura_id_FK` (`inscripcion_apertura_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Disparadores `inscripciones`
--
DROP TRIGGER IF EXISTS `notas_inscripciones`;
DELIMITER $$
CREATE TRIGGER `notas_inscripciones` BEFORE INSERT ON `inscripciones` FOR EACH ROW BEGIN
    IF NEW.inscripcion_nota_docencia IS NULL THEN
        SET NEW.inscripcion_nota_docencia = JSON_OBJECT(
            'notaPrincipal', JSON_OBJECT(
                
            ),
            'notaSecundaria', JSON_OBJECT(
     
            )
        );
    END IF;
    IF NEW.inscripcion_nota_auxiliatura IS NULL THEN
        SET NEW.inscripcion_nota_auxiliatura = JSON_OBJECT(
            'notaPrincipal', JSON_OBJECT(
                
            ),
            'notaSecundaria', JSON_OBJECT(
     
            )
        );
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menciones`
--

DROP TABLE IF EXISTS `menciones`;
CREATE TABLE IF NOT EXISTS `menciones` (
  `mencion_id` int NOT NULL AUTO_INCREMENT,
  `mencion_nombre` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `mencion_proteccion` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mencion_id`),
  UNIQUE KEY `mencion_nombre_UK` (`mencion_nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `menciones`
--

INSERT INTO `menciones` (`mencion_id`, `mencion_nombre`, `mencion_proteccion`) VALUES
(1, 'Control', 1),
(2, 'Sistemas de Computación', 1),
(3, 'Telecomunicaciones', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `blade` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `etiqueta` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `mensaje` varchar(255) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

DROP TABLE IF EXISTS `notas`;
CREATE TABLE IF NOT EXISTS `notas` (
  `nota_id` int NOT NULL AUTO_INCREMENT,
  `nota_inscripcion_id` int NOT NULL,
  `nota_teoria` int DEFAULT NULL,
  `nota_laboratorio` int DEFAULT NULL,
  `nota_auxiliar` int DEFAULT NULL,
  `nota_progreso` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT ((case when (`nota_teoria` is null) then _utf8mb4'Abandono' else _utf8mb4'Activo' end)),
  `nota_estado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`nota_id`),
  UNIQUE KEY `nota_inscripcion_id_UK` (`nota_inscripcion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

DROP TABLE IF EXISTS `paises`;
CREATE TABLE IF NOT EXISTS `paises` (
  `pais_id` int NOT NULL,
  `pais_nombre` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`pais_id`),
  UNIQUE KEY `pais_nombre_UK` (`pais_nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`pais_id`, `pais_nombre`) VALUES
(308, 'Afgahanistan'),
(518, 'Albania'),
(563, 'Alemania'),
(525, 'Andorra'),
(140, 'Angola'),
(242, 'Anguila'),
(240, 'Antigua y Barbuda'),
(247, 'Antillas Neerlandesas'),
(302, 'Arabia Saudita'),
(127, 'Argelia'),
(224, 'Argentina'),
(540, 'Armenia'),
(243, 'Aruba'),
(406, 'Australia'),
(509, 'Austria'),
(541, 'Azerbaijan'),
(207, 'Bahamas'),
(313, 'Bahrein'),
(321, 'Bangladesh'),
(204, 'Barbados'),
(542, 'Belarus'),
(420, 'Belau'),
(514, 'Bélgica'),
(236, 'Belice'),
(150, 'Benin'),
(244, 'Bermudas'),
(591, 'Bolivia'),
(543, 'Bosnia  y Herzegovina'),
(113, 'Botswana'),
(220, 'Brasil'),
(344, 'Brunei'),
(527, 'Bulgaria'),
(161, 'Burkina Faso'),
(141, 'Burundi'),
(318, 'Bután'),
(129, 'Cabo verde'),
(315, 'Cambodia'),
(149, 'Camerún'),
(226, 'Canadá'),
(130, 'Chad'),
(997, 'Chile'),
(336, 'China'),
(305, 'Chipre'),
(162, 'Ciskey'),
(202, 'Colombia'),
(118, 'Comoras'),
(144, 'Congo'),
(334, 'Corea del Norte'),
(333, 'Corea del Sur'),
(107, 'Costa de Marfil'),
(211, 'Costa Rica'),
(547, 'Croacia'),
(209, 'Cuba'),
(507, 'Dinamarca'),
(155, 'Djibouti'),
(231, 'Dominica'),
(218, 'Ecuador'),
(124, 'Egipto'),
(213, 'El salvador'),
(341, 'Emiratos Árabes Unidos'),
(163, 'Eritrea'),
(548, 'Eslovenia'),
(517, 'España'),
(225, 'Estados Unidos de América'),
(549, 'Estonia'),
(139, 'Etiopia'),
(401, 'Fiji'),
(335, 'Filipinas'),
(512, 'Finlandia'),
(505, 'Francia'),
(145, 'Gabon'),
(102, 'Gambia'),
(550, 'Georgia'),
(108, 'Ghana'),
(565, 'Gibraltar'),
(232, 'Granada'),
(520, 'Grecia'),
(253, 'Groenlandia'),
(425, 'Guam'),
(215, 'Guatemala'),
(566, 'Guernsey'),
(104, 'Guinea'),
(147, 'Guinea Ecuatorial'),
(103, 'Guinea-Bissau'),
(217, 'Guyana'),
(208, 'Haití'),
(515, 'Holanda'),
(214, 'Honduras'),
(342, 'Hong Kong'),
(530, 'Hungría'),
(317, 'India'),
(328, 'Indonesia'),
(307, 'Irak'),
(309, 'Irán'),
(506, 'Irlanda'),
(516, 'Islandia'),
(246, 'Islas Cayman'),
(427, 'Islas Cook'),
(567, 'Islas de Man'),
(327, 'Islas Malvinas'),
(424, 'Islas Marianas del Norte'),
(164, 'Islas Marshall'),
(418, 'Islas Salomon'),
(403, 'Islas Tonga'),
(249, 'Islas Vírgenes (Estados Unidos de América)'),
(245, 'Islas Vírgenes Británicas'),
(306, 'Israel'),
(504, 'Italia'),
(205, 'Jamaica'),
(331, 'Japon'),
(568, 'Jersey'),
(301, 'Jordania'),
(551, 'Kasajstan'),
(137, 'Kenia'),
(552, 'Kirgistan'),
(416, 'Kiribati'),
(303, 'Kuwait'),
(316, 'Laos'),
(114, 'Lesotho'),
(553, 'Letonia'),
(311, 'Líbano'),
(106, 'Liberia'),
(125, 'Libia'),
(534, 'Liechtenstein'),
(554, 'Lituania'),
(532, 'Luzemburgo'),
(345, 'Macao'),
(555, 'Macedonia'),
(120, 'Madagascar'),
(329, 'Malasia'),
(115, 'Malawi'),
(133, 'Mali'),
(523, 'Malta'),
(128, 'Marruecos'),
(250, 'Martinica'),
(119, 'Mauricio'),
(134, 'Mauritania'),
(216, 'México'),
(417, 'Micronesia'),
(556, 'Moldova'),
(535, 'Mónaco'),
(337, 'Mongolia'),
(252, 'Monserrat'),
(121, 'Mozambique'),
(326, 'Myanmar (ex Birmania)'),
(159, 'Namibia'),
(402, 'Nauru'),
(320, 'Nepal'),
(212, 'Nicaragua'),
(131, 'Niger'),
(111, 'Nigeria'),
(421, 'Niue'),
(513, 'Noruega'),
(423, 'Nueva Caledonia'),
(405, 'Nueva Zelandia'),
(304, 'Oman'),
(999, 'Otros (Países Desconocidos)'),
(324, 'Pakistan'),
(210, 'Panamá'),
(412, 'Papúa, Nueva Guinea'),
(222, 'Paraguay'),
(219, 'Perú'),
(422, 'Polinesia Francesa'),
(528, 'Polonia'),
(501, 'Portugal'),
(251, 'Puerto Rico'),
(312, 'Qatar'),
(510, 'Reino Unido'),
(148, 'Republica Centro Áfricana'),
(544, 'Republica Checa'),
(346, 'Republica de Yemen'),
(143, 'Republica Democrática del Congo'),
(206, 'Republica Dominicana'),
(545, 'Republica Eslovaca'),
(564, 'Republica Federal de Yugoslavia'),
(519, 'Rumania'),
(562, 'Rusia'),
(142, 'Rwanda'),
(165, 'Saharavi'),
(241, 'Saint Kitts & Nevis'),
(404, 'Samoa Occidental'),
(536, 'San Marino'),
(234, 'San Vicente y Las Granadinas'),
(233, 'Santa Lucia'),
(524, 'Santa Sede'),
(146, 'Sao Tome y Príncipe'),
(101, 'Senegal'),
(156, 'Seychelles'),
(105, 'Sierra Leona'),
(332, 'Singapur'),
(310, 'Siria'),
(138, 'Somalia'),
(314, 'Sri Lanka'),
(112, 'Sudáfrica'),
(123, 'Sudan'),
(511, 'Suecia'),
(508, 'Suiza'),
(235, 'Surinam'),
(122, 'Swazilandia'),
(557, 'Tadjikistan'),
(330, 'Taiwan (Formosa)'),
(135, 'Tanzania'),
(151, 'Territorio Británico en África'),
(227, 'Territorio Británico en América'),
(407, 'Territorio Británico en Australia'),
(230, 'Territorio de Dinamarca'),
(152, 'Territorio Español en África'),
(153, 'Territorio Francés en África'),
(228, 'Territorio Francés en América'),
(408, 'Territorio Francés en Australia'),
(229, 'Territorio Holandés en América'),
(409, 'Territorio Norteaméricano en Australia'),
(343, 'Territorio Portugués en Asia'),
(319, 'Thailandia'),
(426, 'Timor Oriental'),
(109, 'Togo'),
(166, 'Transkei'),
(203, 'Trinidad y Tobago'),
(126, 'Tunez'),
(248, 'Turcas y Caicos'),
(558, 'Turkmenistan'),
(522, 'Turquía'),
(419, 'Tuvalu'),
(559, 'Ucrania'),
(136, 'Uganda'),
(223, 'Uruguay'),
(560, 'Uzbekistan'),
(415, 'Vanuatu'),
(201, 'Venezuela'),
(158, 'Vienda'),
(325, 'Vietnam'),
(117, 'Zambia'),
(116, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `panel_control`
--

DROP TABLE IF EXISTS `panel_control`;
CREATE TABLE IF NOT EXISTS `panel_control` (
  `panel_control_id` int NOT NULL AUTO_INCREMENT,
  `panel_control_periodo_id` int NOT NULL,
  `panel_control_plan_estudio_id` int NOT NULL,
  `panel_control_apertura` tinyint(1) NOT NULL DEFAULT '0',
  `panel_control_inscripcion` tinyint(1) DEFAULT NULL,
  `panel_control_estado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`panel_control_id`),
  UNIQUE KEY `panel_control_periodo_id_UK` (`panel_control_periodo_id`),
  KEY `panel_control_plan_estudio_id_FK` (`panel_control_plan_estudio_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `panel_control`
--

INSERT INTO `panel_control` (`panel_control_id`, `panel_control_periodo_id`, `panel_control_plan_estudio_id`, `panel_control_apertura`, `panel_control_inscripcion`, `panel_control_estado`) VALUES
(1, 1, 4, 0, NULL, 0),
(2, 2, 4, 0, NULL, 0),
(3, 3, 4, 0, NULL, 0),
(4, 4, 4, 0, NULL, 0),
(5, 5, 4, 0, NULL, 0),
(6, 6, 4, 0, NULL, 0),
(7, 7, 4, 0, NULL, 0),
(8, 8, 4, 0, NULL, 0),
(9, 9, 4, 0, NULL, 0),
(10, 10, 4, 0, NULL, 0),
(11, 11, 4, 0, NULL, 0),
(12, 12, 4, 0, NULL, 0),
(13, 13, 4, 0, NULL, 0),
(14, 14, 4, 0, NULL, 0),
(15, 15, 4, 0, NULL, 0),
(16, 16, 4, 0, NULL, 0),
(17, 17, 4, 0, NULL, 0),
(18, 18, 4, 0, NULL, 0),
(19, 19, 4, 0, NULL, 0),
(20, 20, 4, 0, NULL, 0),
(21, 21, 4, 0, NULL, 0),
(22, 22, 4, 0, NULL, 0),
(23, 23, 4, 0, NULL, 0),
(24, 24, 4, 0, NULL, 0),
(25, 25, 4, 0, NULL, 0),
(26, 26, 4, 1, NULL, 1),
(27, 27, 4, 0, NULL, 0),
(28, 28, 4, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pensum`
--

DROP TABLE IF EXISTS `pensum`;
CREATE TABLE IF NOT EXISTS `pensum` (
  `pensum_id` int NOT NULL AUTO_INCREMENT,
  `pensum_asignatura_id` int NOT NULL,
  `pensum_semestre_id` int NOT NULL,
  `pensum_mencion_id` int NOT NULL,
  PRIMARY KEY (`pensum_id`),
  UNIQUE KEY `pensum_UK` (`pensum_asignatura_id`,`pensum_semestre_id`,`pensum_mencion_id`),
  KEY `pensum_semestre_id_FK` (`pensum_semestre_id`),
  KEY `pensum_mencion_id_FK` (`pensum_mencion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `pensum`
--

INSERT INTO `pensum` (`pensum_id`, `pensum_asignatura_id`, `pensum_semestre_id`, `pensum_mencion_id`) VALUES
(1, 1, 1, 1),
(55, 1, 1, 2),
(110, 1, 1, 3),
(2, 2, 1, 1),
(56, 2, 1, 2),
(111, 2, 1, 3),
(3, 3, 1, 1),
(57, 3, 1, 2),
(112, 3, 1, 3),
(4, 4, 1, 1),
(58, 4, 1, 2),
(113, 4, 1, 3),
(5, 5, 1, 1),
(59, 5, 1, 2),
(114, 5, 1, 3),
(6, 6, 1, 1),
(60, 6, 1, 2),
(115, 6, 1, 3),
(7, 7, 2, 1),
(61, 7, 2, 2),
(116, 7, 2, 3),
(8, 8, 2, 1),
(62, 8, 2, 2),
(117, 8, 2, 3),
(9, 9, 2, 1),
(63, 9, 2, 2),
(118, 9, 2, 3),
(10, 10, 2, 1),
(64, 10, 2, 2),
(119, 10, 2, 3),
(11, 11, 2, 1),
(65, 11, 2, 2),
(120, 11, 2, 3),
(12, 12, 3, 1),
(66, 12, 3, 2),
(121, 12, 3, 3),
(13, 13, 3, 1),
(67, 13, 3, 2),
(122, 13, 3, 3),
(14, 14, 3, 1),
(68, 14, 3, 2),
(123, 14, 3, 3),
(15, 15, 3, 1),
(69, 15, 3, 2),
(124, 15, 3, 3),
(16, 16, 3, 1),
(70, 16, 3, 2),
(125, 16, 3, 3),
(17, 17, 3, 1),
(71, 17, 3, 2),
(126, 17, 3, 3),
(18, 18, 3, 1),
(72, 18, 3, 2),
(127, 18, 3, 3),
(19, 19, 4, 1),
(73, 19, 4, 2),
(128, 19, 4, 3),
(20, 20, 4, 1),
(74, 20, 4, 2),
(129, 20, 4, 3),
(21, 21, 4, 1),
(75, 21, 4, 2),
(130, 21, 4, 3),
(22, 22, 4, 1),
(76, 22, 4, 2),
(131, 22, 4, 3),
(23, 23, 4, 1),
(77, 23, 4, 2),
(132, 23, 4, 3),
(24, 24, 4, 1),
(78, 24, 4, 2),
(133, 24, 4, 3),
(25, 25, 4, 1),
(79, 25, 4, 2),
(134, 25, 4, 3),
(26, 26, 5, 1),
(80, 26, 5, 2),
(135, 26, 5, 3),
(27, 27, 5, 1),
(81, 27, 5, 2),
(136, 27, 5, 3),
(28, 28, 5, 1),
(82, 28, 5, 2),
(137, 28, 5, 3),
(29, 29, 5, 1),
(83, 29, 5, 2),
(138, 29, 5, 3),
(30, 30, 5, 1),
(84, 30, 5, 2),
(139, 30, 5, 3),
(31, 31, 6, 1),
(85, 31, 6, 2),
(140, 31, 6, 3),
(32, 32, 6, 1),
(86, 32, 6, 2),
(141, 32, 6, 3),
(33, 33, 6, 1),
(87, 33, 6, 2),
(142, 33, 6, 3),
(34, 34, 6, 1),
(88, 34, 6, 2),
(143, 34, 6, 3),
(35, 35, 6, 1),
(89, 35, 6, 2),
(144, 35, 6, 3),
(36, 36, 7, 1),
(145, 36, 7, 3),
(37, 37, 7, 1),
(91, 37, 7, 2),
(146, 37, 7, 3),
(38, 38, 7, 1),
(92, 38, 7, 2),
(147, 38, 7, 3),
(39, 39, 7, 1),
(93, 39, 7, 2),
(40, 40, 7, 1),
(41, 41, 8, 1),
(95, 41, 8, 2),
(150, 41, 8, 3),
(42, 42, 8, 1),
(96, 42, 8, 2),
(43, 43, 8, 1),
(44, 44, 8, 1),
(98, 44, 8, 2),
(153, 44, 8, 3),
(45, 45, 8, 1),
(46, 46, 8, 1),
(100, 46, 8, 2),
(154, 46, 8, 3),
(47, 47, 9, 1),
(155, 47, 9, 3),
(48, 48, 9, 1),
(49, 49, 9, 1),
(102, 49, 9, 2),
(50, 50, 9, 1),
(97, 51, 8, 2),
(51, 51, 9, 1),
(52, 52, 9, 1),
(103, 52, 9, 2),
(160, 52, 9, 3),
(53, 53, 10, 1),
(107, 53, 10, 2),
(161, 53, 10, 3),
(54, 54, 10, 1),
(108, 54, 10, 2),
(162, 54, 10, 3),
(90, 55, 7, 2),
(149, 55, 7, 3),
(94, 56, 7, 2),
(99, 57, 8, 2),
(101, 58, 9, 2),
(104, 59, 9, 2),
(105, 60, 9, 2),
(106, 61, 9, 2),
(157, 61, 9, 3),
(109, 62, 10, 2),
(148, 63, 7, 3),
(151, 64, 8, 3),
(152, 65, 8, 3),
(156, 66, 9, 3),
(158, 67, 9, 3),
(159, 68, 9, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodos`
--

DROP TABLE IF EXISTS `periodos`;
CREATE TABLE IF NOT EXISTS `periodos` (
  `periodo_id` int NOT NULL AUTO_INCREMENT,
  `periodo_nombre` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `periodo_gestion` int NOT NULL,
  PRIMARY KEY (`periodo_id`),
  UNIQUE KEY `periodo_UK` (`periodo_nombre`,`periodo_gestion`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `periodos`
--

INSERT INTO `periodos` (`periodo_id`, `periodo_nombre`, `periodo_gestion`) VALUES
(2, '1', 2020),
(6, '1', 2021),
(10, '1', 2022),
(14, '1', 2023),
(18, '1', 2024),
(22, '1', 2025),
(26, '1', 2026),
(4, '2', 2020),
(8, '2', 2021),
(12, '2', 2022),
(16, '2', 2023),
(20, '2', 2024),
(24, '2', 2025),
(28, '2', 2026),
(3, 'Invierno', 2020),
(7, 'Invierno', 2021),
(11, 'Invierno', 2022),
(15, 'Invierno', 2023),
(19, 'Invierno', 2024),
(23, 'Invierno', 2025),
(27, 'Invierno', 2026),
(1, 'Verano', 2020),
(5, 'Verano', 2021),
(9, 'Verano', 2022),
(13, 'Verano', 2023),
(17, 'Verano', 2024),
(21, 'Verano', 2025),
(25, 'Verano', 2026);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

DROP TABLE IF EXISTS `personas`;
CREATE TABLE IF NOT EXISTS `personas` (
  `persona_id` int NOT NULL AUTO_INCREMENT,
  `persona_primer_apellido` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `persona_segundo_apellido` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `persona_nombres` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `persona_ci` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`persona_id`),
  UNIQUE KEY `persona_ci_UK` (`persona_ci`)
) ENGINE=InnoDB AUTO_INCREMENT=1043 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`persona_id`, `persona_primer_apellido`, `persona_segundo_apellido`, `persona_nombres`, `persona_ci`) VALUES
(1, 'V01', 'S01', 'JL01', '6068901'),
(2, 'V02', 'S02', 'JL02', '6068902'),
(3, 'V03', 'S03', 'JL03', '6068903'),
(4, 'V04', 'S04', 'JL04', '6068904'),
(5, 'V05', 'S05', 'JL05', '6068905'),
(6, 'V06', 'S06', 'JL06', '6068906'),
(7, 'V07', 'S07', 'JL07', '6068907'),
(8, 'V08', 'S08', 'JL08', '6068908'),
(9, 'V09', 'S09', 'JL09', '6068909'),
(10, 'V10', 'S10', 'JL10', '6068910'),
(11, 'V11', 'S11', 'JL11', '6068911'),
(12, 'V12', 'S12', 'JL12', '6068912'),
(1001, 'Aguilera', 'Rios', 'Juan Alberto', '10001001'),
(1002, 'Amestegui', 'Moreno', 'Oscar Mauricio', '10001002'),
(1003, 'Amusquivar', 'Caballero', 'Wilma', '10001003'),
(1004, 'Rios', '', 'Jose', '10001004'),
(1005, 'Balderrama', 'Barrios', 'Hugo', '10001005'),
(1006, 'Borja', 'Omonte', 'Hernán', '10001006'),
(1007, 'Caba', 'M.', 'Gonzalo', '10001007'),
(1008, 'Cala', '', 'Jhonny', '10001008'),
(1009, 'Campero', '', 'Jose', '10001009'),
(1010, 'Cañaviri', 'Mendoza', 'Wilmer', '10001010'),
(1011, 'Contreras', 'Candia', 'Juan Gonzalo', '10001011'),
(1012, 'Busch', 'Teodoro', 'Decovice', '10001012'),
(1013, 'Duchen', '', 'Juan Carlos', '10001013'),
(1014, 'Flores', 'Bustillos', 'Wilber', '10001014'),
(1015, 'Gutierrez', '', 'Marcelo', '10001015'),
(1016, 'Jurado', '', 'Alfonzo', '10001016'),
(1017, 'Laredo', '', 'Victor', '10001017'),
(1018, 'León', 'Gómez', 'Jorge', '10001018'),
(1019, 'Lozano', '', 'Cesar', '10001019'),
(1020, 'Mayori', 'Machicao', 'Alejandro Martin', '10001020'),
(1021, 'Medina', 'Riveros', 'Luis', '10001021'),
(1022, 'Molina', '', 'David', '10001022'),
(1023, 'Nava', 'Amador', 'Jorge Antonio', '10001023'),
(1024, 'Oropeza', 'Crespo', 'Roberto', '10001024'),
(1025, 'Paravicini', 'Hurtado', 'Clifford', '10001025'),
(1026, 'Puch', 'Terán', 'Ramiro', '10001026'),
(1027, 'Quiroga', '', 'Jorge', '10001027'),
(1028, 'Ramirez', 'Molina', 'Marcelo', '10001028'),
(1029, 'Rosas', 'Rivera', 'Luis Armando', '10001029'),
(1030, 'Sanabria', 'Garcia', 'Javier', '10001030'),
(1031, 'Tito', 'Luque', 'Fabian', '10001031'),
(1032, 'Torrez', '', 'Máximo', '10001032'),
(1033, 'Vicente', 'Sanches', 'Gerardo', '10001033'),
(1034, 'Villanueva', 'Arce', 'Edwin', '10001034'),
(1035, 'Zambrana', 'Flores', 'Roberto', '10001035'),
(1036, 'Zota', 'Uño', 'Virginia', '10001036'),
(1037, 'Mamani', '', 'NN', '10001037'),
(1038, 'Huanca', '', 'NN', '10001038'),
(1039, 'Argani', '', 'Karminia', '10001039'),
(1040, 'Quispe', '', 'NN', '10001040'),
(1041, 'Tarqui', '', 'NN', '10001041'),
(1042, 'Cáceres', '', 'NN', '10001042');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan_estudios`
--

DROP TABLE IF EXISTS `plan_estudios`;
CREATE TABLE IF NOT EXISTS `plan_estudios` (
  `plan_estudio_id` int NOT NULL AUTO_INCREMENT,
  `plan_estudio_nombre` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `plan_estudio_proteccion` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`plan_estudio_id`),
  UNIQUE KEY `plan_estudio_nombre_UK` (`plan_estudio_nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `plan_estudios`
--

INSERT INTO `plan_estudios` (`plan_estudio_id`, `plan_estudio_nombre`, `plan_estudio_proteccion`) VALUES
(1, '1974', 1),
(2, '1981', 1),
(3, '1985', 1),
(4, '2000', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prerrequisitos`
--

DROP TABLE IF EXISTS `prerrequisitos`;
CREATE TABLE IF NOT EXISTS `prerrequisitos` (
  `prerrequisito_id` int NOT NULL AUTO_INCREMENT,
  `prerrequisito_pensum_id` int NOT NULL,
  `prerrequisito_asignatura_id` int DEFAULT NULL,
  `prerrequisito_comentario` varchar(255) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`prerrequisito_id`),
  UNIQUE KEY `prerrequisito_UK` (`prerrequisito_pensum_id`,`prerrequisito_asignatura_id`),
  KEY `prerrequisito_asignatura_id_FK` (`prerrequisito_asignatura_id`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `prerrequisitos`
--

INSERT INTO `prerrequisitos` (`prerrequisito_id`, `prerrequisito_pensum_id`, `prerrequisito_asignatura_id`, `prerrequisito_comentario`) VALUES
(1, 1, NULL, 'Admisión'),
(2, 2, NULL, 'Admisión'),
(3, 3, NULL, 'Admisión'),
(4, 4, NULL, 'Admisión'),
(5, 5, NULL, 'Admisión'),
(6, 6, NULL, 'Admisión'),
(7, 7, 1, NULL),
(8, 8, 3, NULL),
(9, 9, 2, NULL),
(10, 10, 3, NULL),
(11, 11, 2, NULL),
(12, 12, 7, NULL),
(13, 13, 8, NULL),
(14, 14, 8, NULL),
(15, 15, 10, NULL),
(16, 16, 7, NULL),
(17, 17, 9, NULL),
(18, 18, NULL, 'APROBAR 10 ASIGNATURAS DEL AREA DE FORMACIÓN BASICA'),
(19, 19, 13, NULL),
(20, 20, 15, NULL),
(21, 21, 16, NULL),
(22, 22, 12, NULL),
(23, 23, 15, NULL),
(24, 24, 17, NULL),
(25, 25, 18, NULL),
(26, 26, 22, NULL),
(27, 27, 19, NULL),
(28, 28, 23, NULL),
(29, 29, 23, NULL),
(30, 30, 24, NULL),
(31, 31, 26, NULL),
(32, 32, 27, NULL),
(33, 33, 27, NULL),
(34, 34, 28, NULL),
(35, 35, NULL, 'APROBAR TODAS LAS ASIGNATURAS DEL ÁREA DE FORMACIÓN BÁSICA'),
(36, 36, 29, NULL),
(37, 37, 34, NULL),
(38, 38, 27, NULL),
(39, 39, 31, NULL),
(40, 40, 32, NULL),
(41, 41, 37, NULL),
(42, 42, 37, NULL),
(43, 43, 39, NULL),
(44, 44, 38, NULL),
(45, 45, 36, NULL),
(46, 46, NULL, 'HABER APROBADO POR LO MENOS DOS MATERIAS DE MENCIÓN'),
(47, 47, 41, NULL),
(48, 48, 41, NULL),
(49, 49, 44, NULL),
(50, 50, 43, NULL),
(51, 51, 42, NULL),
(52, 52, NULL, 'HABER APROBADO POR LO MENOS UNA MATERIAS DE MENCIÓN'),
(53, 53, NULL, 'HABER APROBADO POR LO MENOS 48 ASIGNATURAS'),
(54, 54, NULL, 'HABER VENCIDO 40 ASIGNATURAS DE LA MENCIÓN'),
(55, 55, NULL, 'Admisión'),
(56, 56, NULL, 'Admisión'),
(57, 57, NULL, 'Admisión'),
(58, 58, NULL, 'Admisión'),
(59, 59, NULL, 'Admisión'),
(60, 60, NULL, 'Admisión'),
(61, 61, 1, NULL),
(62, 62, 3, NULL),
(63, 63, 2, NULL),
(64, 64, 3, NULL),
(65, 65, 2, NULL),
(66, 66, 7, NULL),
(67, 67, 8, NULL),
(68, 68, 8, NULL),
(69, 69, 10, NULL),
(70, 70, 7, NULL),
(71, 71, 9, NULL),
(72, 72, NULL, 'APROBAR 10 ASIGNATURAS DEL AREA DE FORMACIÓN BASICA'),
(73, 73, 13, NULL),
(74, 74, 15, NULL),
(75, 75, 16, NULL),
(76, 76, 12, NULL),
(77, 77, 15, NULL),
(78, 78, 17, NULL),
(79, 79, 18, NULL),
(80, 80, 22, NULL),
(81, 81, 19, NULL),
(82, 82, 23, NULL),
(83, 83, 23, NULL),
(84, 84, 24, NULL),
(85, 85, 26, NULL),
(86, 86, 27, NULL),
(87, 87, 27, NULL),
(88, 88, 28, NULL),
(89, 89, NULL, 'APROBAR TODAS LAS ASIGNATURAS DEL ÁREA DE FORMACIÓN BÁSICA'),
(90, 90, 33, NULL),
(91, 91, 34, NULL),
(92, 92, 27, NULL),
(93, 93, 31, NULL),
(94, 94, 34, NULL),
(95, 95, 37, NULL),
(96, 96, 37, NULL),
(97, 97, NULL, 'COREQUISITO ETN 921'),
(98, 98, 38, NULL),
(99, 99, 24, NULL),
(100, 100, NULL, 'HABER APROBADO POR LO MENOS DOS MATERIAS DE MENCIÓN'),
(101, 101, 41, NULL),
(102, 102, 44, NULL),
(103, 103, NULL, 'HABER APROBADO POR LO MENOS UNA MATERIAS DE MENCIÓN'),
(104, 104, 38, NULL),
(105, 105, 57, NULL),
(106, 106, 55, NULL),
(107, 107, NULL, 'HABER APROBADO POR LO MENOS 48 ASIGNATURAS'),
(108, 108, NULL, 'HABER VENCIDO 40 ASIGNATURAS DE LA MENCIÓN'),
(109, 109, 46, NULL),
(110, 110, NULL, 'Admisión'),
(111, 111, NULL, 'Admisión'),
(112, 112, NULL, 'Admisión'),
(113, 113, NULL, 'Admisión'),
(114, 114, NULL, 'Admisión'),
(115, 115, NULL, 'Admisión'),
(116, 116, 1, NULL),
(117, 117, 3, NULL),
(118, 118, 2, NULL),
(119, 119, 3, NULL),
(120, 120, 2, NULL),
(121, 121, 7, NULL),
(122, 122, 8, NULL),
(123, 123, 8, NULL),
(124, 124, 10, NULL),
(125, 125, 7, NULL),
(126, 126, 9, NULL),
(127, 127, NULL, 'APROBAR 10 ASIGNATURAS DEL AREA DE FORMACIÓN BASICA'),
(128, 128, 13, NULL),
(129, 129, 15, NULL),
(130, 130, 16, NULL),
(131, 131, 12, NULL),
(132, 132, 15, NULL),
(133, 133, 17, NULL),
(134, 134, 18, NULL),
(135, 135, 22, NULL),
(136, 136, 19, NULL),
(137, 137, 23, NULL),
(138, 138, 23, NULL),
(139, 139, 24, NULL),
(140, 140, 26, NULL),
(141, 141, 27, NULL),
(142, 142, 27, NULL),
(143, 143, 28, NULL),
(144, 144, NULL, 'APROBAR TODAS LAS ASIGNATURAS DEL ÁREA DE FORMACIÓN BÁSICA'),
(145, 145, 29, NULL),
(146, 146, 34, NULL),
(147, 147, 27, NULL),
(148, 148, 33, NULL),
(149, 149, 33, NULL),
(150, 150, 37, NULL),
(151, 151, 55, NULL),
(152, 152, 63, NULL),
(153, 153, 38, NULL),
(154, 154, NULL, 'HABER APROBADO POR LO MENOS DOS MATERIAS DE MENCIÓN'),
(155, 155, 41, NULL),
(156, 156, 64, NULL),
(157, 157, 55, NULL),
(158, 158, 44, NULL),
(159, 159, 64, NULL),
(160, 160, NULL, 'HABER APROBADO POR LO MENOS UNA MATERIAS DE MENCIÓN'),
(161, 161, NULL, 'HABER APROBADO POR LO MENOS 48 ASIGNATURAS'),
(162, 162, NULL, 'HABER VENCIDO 40 ASIGNATURAS DE LA MENCIÓN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

DROP TABLE IF EXISTS `publicaciones`;
CREATE TABLE IF NOT EXISTS `publicaciones` (
  `publicacion_id` int NOT NULL AUTO_INCREMENT,
  `publicacion_tipo` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `publicacion_numero` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `publicacion_titulo` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `publicacion_archivo` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `publicacion_estado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`publicacion_id`),
  UNIQUE KEY `publicacion_numero_UK` (`publicacion_numero`),
  UNIQUE KEY `publicacion_archivo_UK` (`publicacion_archivo`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`publicacion_id`, `publicacion_tipo`, `publicacion_numero`, `publicacion_titulo`, `publicacion_archivo`, `publicacion_estado`) VALUES
(1, 'Comunicado', 'Comu-001-2023', 'Comunicado auxiliares 1', 'Comunicado_001-2023.pdf', 1),
(2, 'Comunicado', 'Comu-002-2023', 'Comunicado auxiliares 2', 'Comunicado_002-2023.pdf', 0),
(3, 'Comunicado', 'Comu-003-2023', 'Comunicado auxiliares 3', 'Comunicado_003-2023.pdf', 1),
(4, 'Comunicado', 'Comu-004-2023', 'Comunicado auxiliares 4', 'Comunicado_004-2023.pdf', 1),
(5, 'Comunicado', 'Comu-005-2023', 'Comunicado auxiliares 5', 'Comunicado_005-2023.pdf', 1),
(6, 'Comunicado', 'Comu-006-2023', 'Comunicado auxiliares 6', 'Comunicado_006-2023.pdf', 1),
(7, 'Comunicado', 'Comu-007-2023', 'Comunicado auxiliares 7', 'Comunicado_007-2023.pdf', 1),
(8, 'Comunicado', 'Comu-008-2023', 'Comunicado auxiliares 8', 'Comunicado_008-2023.pdf', 1),
(9, 'Comunicado', 'Comu-009-2023', 'Comunicado auxiliares 9', 'Comunicado_009-2023.pdf', 1),
(10, 'Comunicado', 'Comu-010-2023', 'Comunicado auxiliares 10', 'Comunicado_010-2023.pdf', 1),
(11, 'Convocatoria', 'Conv-001-2023', 'Convocatoria auxiliares 1', 'Convocatoria_001-2023.pdf', 1),
(12, 'Convocatoria', 'Conv-002-2023', 'Convocatoria auxiliares 2', 'Convocatoria_002-2023.pdf', 1),
(13, 'Convocatoria', 'Conv-003-2023', 'Convocatoria auxiliares 3', 'Convocatoria_003-2023.pdf', 1),
(14, 'Convocatoria', 'Conv-004-2023', 'Convocatoria auxiliares 4', 'Convocatoria_004-2023.pdf', 1),
(15, 'Convocatoria', 'Conv-005-2023', 'Convocatoria auxiliares 5', 'Convocatoria_005-2023.pdf', 1),
(16, 'Convocatoria', 'Conv-006-2023', 'Convocatoria auxiliares 6', 'Convocatoria_006-2023.pdf', 1),
(17, 'Convocatoria', 'Conv-007-2023', 'Convocatoria auxiliares 7', 'Convocatoria_007-2023.pdf', 1),
(18, 'Convocatoria', 'Conv-008-2023', 'Convocatoria auxiliares 8', 'Convocatoria_008-2023.pdf', 1),
(19, 'Convocatoria', 'Conv-009-2023', 'Convocatoria auxiliares 9', 'Convocatoria_009-2023.pdf', 1),
(20, 'Convocatoria', 'Conv-010-2023', 'Convocatoria auxiliares 10', 'Convocatoria_010-2023.pdf', 1),
(21, 'Invitación', 'Invi-001-2023', 'invitación sesion de honor', 'Invitación_001-2023.pdf', 1),
(22, 'Pasantía', 'Pasa-001-2023', 'Pasantia Axes', 'Pasantia_001-2023.pdf', 1),
(23, 'Pasantía', 'Pasa-002-2023', 'Pasantia Telecom', 'Pasantia_002-2023.pdf', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicar_horarios_aulas`
--

DROP TABLE IF EXISTS `publicar_horarios_aulas`;
CREATE TABLE IF NOT EXISTS `publicar_horarios_aulas` (
  `publicar_hora_aula_usuario_id` int NOT NULL,
  `publicar_hora_aula_horario_aula_id` int NOT NULL,
  `publicar_hora_aula_accion` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `publicar_hora_aula_fecha` timestamp NOT NULL,
  KEY `publicar_hora_aula_usuario_id_FK` (`publicar_hora_aula_usuario_id`),
  KEY `publicar_hora_aula_horario_aula_id_Fk` (`publicar_hora_aula_horario_aula_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `publicar_horarios_aulas`
--

INSERT INTO `publicar_horarios_aulas` (`publicar_hora_aula_usuario_id`, `publicar_hora_aula_horario_aula_id`, `publicar_hora_aula_accion`, `publicar_hora_aula_fecha`) VALUES
(1, 1, 'Insertar', '2023-03-29 00:01:00'),
(1, 2, 'Insertar', '2023-03-29 00:02:00'),
(1, 3, 'Insertar', '2023-03-29 00:03:00'),
(1, 4, 'Insertar', '2023-03-29 00:04:00'),
(1, 5, 'Insertar', '2023-03-29 00:05:00'),
(1, 6, 'Insertar', '2023-03-29 00:06:00'),
(1, 7, 'Insertar', '2023-03-29 00:07:00'),
(1, 8, 'Insertar', '2023-03-29 00:08:00'),
(1, 9, 'Insertar', '2023-03-29 00:09:00'),
(4, 10, 'Insertar', '2023-03-29 00:10:00'),
(1, 11, 'Insertar', '2023-03-29 00:09:00'),
(1, 12, 'Insertar', '2023-03-29 00:09:00'),
(1, 13, 'Insertar', '2023-03-29 00:09:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicar_horarios_semestres`
--

DROP TABLE IF EXISTS `publicar_horarios_semestres`;
CREATE TABLE IF NOT EXISTS `publicar_horarios_semestres` (
  `publicar_hora_seme_usuario_id` int NOT NULL,
  `publicar_hora_seme_horario_seme_id` int NOT NULL,
  `publicar_hora_seme_accion` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `publicar_hora_seme_fecha` timestamp NOT NULL,
  KEY `publicar_hora_seme_usuario_id_FK` (`publicar_hora_seme_usuario_id`),
  KEY `publicar_hora_seme_horario_seme_id_FK` (`publicar_hora_seme_horario_seme_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `publicar_horarios_semestres`
--

INSERT INTO `publicar_horarios_semestres` (`publicar_hora_seme_usuario_id`, `publicar_hora_seme_horario_seme_id`, `publicar_hora_seme_accion`, `publicar_hora_seme_fecha`) VALUES
(1, 1, 'Insertar', '2023-03-29 00:01:00'),
(1, 2, 'Insertar', '2023-03-29 00:02:00'),
(1, 3, 'Insertar', '2023-03-29 00:03:00'),
(1, 4, 'Insertar', '2023-03-29 00:04:00'),
(1, 5, 'Insertar', '2023-03-29 00:05:00'),
(1, 6, 'Insertar', '2023-03-29 00:06:00'),
(1, 7, 'Insertar', '2023-03-29 00:07:00'),
(1, 8, 'Insertar', '2023-03-29 00:08:00'),
(1, 9, 'Insertar', '2023-03-29 00:09:00'),
(4, 10, 'Insertar', '2023-03-29 00:10:00'),
(1, 11, 'Insertar', '2023-03-29 00:09:00'),
(1, 12, 'Insertar', '2023-03-29 00:09:00'),
(1, 13, 'Insertar', '2023-03-29 00:09:00'),
(1, 14, 'Insertar', '2023-03-29 00:09:00'),
(1, 15, 'Insertar', '2023-03-29 00:09:00'),
(1, 16, 'Insertar', '2023-03-29 00:09:00'),
(1, 17, 'Insertar', '2023-03-29 00:09:00'),
(1, 18, 'Insertar', '2023-03-29 00:09:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registrar_publicaciones`
--

DROP TABLE IF EXISTS `registrar_publicaciones`;
CREATE TABLE IF NOT EXISTS `registrar_publicaciones` (
  `registrar_publ_id` int NOT NULL AUTO_INCREMENT,
  `registrar_publ_usuario_id` int NOT NULL,
  `registrar_publ_publicacion_id` int NOT NULL,
  `registrar_publ_archivo` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `registrar_publ_accion` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `registrar_publ_fecha` timestamp NOT NULL,
  PRIMARY KEY (`registrar_publ_id`),
  KEY `registrar_publ_usuario_id_FK` (`registrar_publ_usuario_id`),
  KEY `registrar_publ_publicacion_id_FK` (`registrar_publ_publicacion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `registrar_publicaciones`
--

INSERT INTO `registrar_publicaciones` (`registrar_publ_id`, `registrar_publ_usuario_id`, `registrar_publ_publicacion_id`, `registrar_publ_archivo`, `registrar_publ_accion`, `registrar_publ_fecha`) VALUES
(1, 1, 1, 'Comunicado_001-2023.pdf', 'Insertar', '2023-03-29 00:01:00'),
(2, 1, 2, 'Comunicado_002-2023.pdf', 'Insertar', '2023-03-29 00:02:00'),
(3, 1, 3, 'Comunicado_003-2023.pdf', 'Insertar', '2023-03-29 00:03:00'),
(4, 1, 4, 'Comunicado_004-2023.pdf', 'Insertar', '2023-03-29 00:04:00'),
(5, 1, 5, 'Comunicado_005-2023.pdf', 'Insertar', '2023-03-29 00:05:00'),
(6, 1, 6, 'Comunicado_006-2023.pdf', 'Insertar', '2023-03-29 00:06:00'),
(7, 1, 7, 'Comunicado_007-2023.pdf', 'Insertar', '2023-03-29 00:07:00'),
(8, 1, 8, 'Comunicado_008-2023.pdf', 'Insertar', '2023-03-29 00:08:00'),
(9, 1, 9, 'Comunicado_009-2023.pdf', 'Insertar', '2023-03-29 00:09:00'),
(10, 4, 10, 'Comunicado_010-2023.pdf', 'Insertar', '2023-03-29 00:10:00'),
(11, 1, 11, 'Convocatoria_001-2023.pdf', 'Insertar', '2023-03-11 00:01:00'),
(12, 1, 12, 'Convocatoria_002-2023.pdf', 'Insertar', '2023-03-11 00:02:00'),
(13, 1, 13, 'Convocatoria_003-2023.pdf', 'Insertar', '2023-03-11 00:03:00'),
(14, 1, 14, 'Convocatoria_004-2023.pdf', 'Insertar', '2023-03-11 00:04:00'),
(15, 1, 15, 'Convocatoria_005-2023.pdf', 'Insertar', '2023-03-11 00:05:00'),
(16, 1, 16, 'Convocatoria_006-2023.pdf', 'Insertar', '2023-03-11 00:06:00'),
(17, 1, 17, 'Convocatoria_007-2023.pdf', 'Insertar', '2023-03-11 00:07:00'),
(18, 1, 18, 'Convocatoria_008-2023.pdf', 'Insertar', '2023-03-11 00:08:00'),
(19, 1, 19, 'Convocatoria_009-2023.pdf', 'Insertar', '2023-03-11 00:09:00'),
(20, 4, 20, 'Convocatoria_010-2023.pdf', 'Insertar', '2023-03-11 00:10:00'),
(21, 1, 21, 'Invitación_001-2023.pdf', 'Insertar', '2023-03-12 00:08:00'),
(22, 1, 22, 'Pasantia_001-2023.pdf', 'Insertar', '2023-03-13 00:09:00'),
(23, 4, 23, 'Pasantia_002-2023.pdf', 'Insertar', '2023-03-14 00:10:00'),
(24, 1, 2, 'Comunicado_002-2023.pdf', 'Actualizar', '2023-04-11 23:02:00'),
(25, 1, 2, 'Comunicado_002-2023.pdf', 'Eliminar', '2023-04-12 00:02:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `retiros`
--

DROP TABLE IF EXISTS `retiros`;
CREATE TABLE IF NOT EXISTS `retiros` (
  `retiro_estudiante_id` int NOT NULL,
  `retiro_apertura_id` int NOT NULL,
  `retiro_fecha` timestamp NOT NULL,
  KEY `retiro_estudiante_id_FK` (`retiro_estudiante_id`),
  KEY `retiro_apertura_id_FK` (`retiro_apertura_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `rol_id` int NOT NULL AUTO_INCREMENT,
  `rol_nombre` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`rol_id`),
  UNIQUE KEY `rol_nombre_UK` (`rol_nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`rol_id`, `rol_nombre`) VALUES
(1, 'Administrador'),
(2, 'Administrativo'),
(3, 'Auxiliar'),
(4, 'Docente'),
(5, 'Estudiante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `semestres`
--

DROP TABLE IF EXISTS `semestres`;
CREATE TABLE IF NOT EXISTS `semestres` (
  `semestre_id` int NOT NULL AUTO_INCREMENT,
  `semestre_numerico` int NOT NULL,
  `semestre_literal` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `semestre_ordinal` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`semestre_id`),
  UNIQUE KEY `semestre_numerico_UK` (`semestre_numerico`),
  UNIQUE KEY `semestre_literal_UK` (`semestre_literal`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `semestres`
--

INSERT INTO `semestres` (`semestre_id`, `semestre_numerico`, `semestre_literal`, `semestre_ordinal`) VALUES
(1, 1, 'Primero', 'Primer'),
(2, 2, 'Segundo', 'Segundo'),
(3, 3, 'Tercero', 'Tercer'),
(4, 4, 'Cuarto', 'Cuarto'),
(5, 5, 'Quinto', 'Quinto'),
(6, 6, 'Sexto', 'Sexto'),
(7, 7, 'Séptimo', 'Séptimo'),
(8, 8, 'Octavo', 'Octavo'),
(9, 9, 'Noveno', 'Noveno'),
(10, 10, 'Décimo', 'Décimo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `test`
--

DROP TABLE IF EXISTS `test`;
CREATE TABLE IF NOT EXISTS `test` (
  `test_id` int NOT NULL AUTO_INCREMENT,
  `test_numero` int DEFAULT NULL,
  `test_cadena` varchar(255) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `test_texto` text COLLATE utf8mb4_spanish_ci,
  `test_booleano` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`test_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `usuario_id` int NOT NULL AUTO_INCREMENT,
  `usuario_persona_id` int NOT NULL,
  `usuario_usuario` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `usuario_clave` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `usuario_intentos_fallidos` int NOT NULL DEFAULT '0',
  `usuario_estado` tinyint(1) NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `usuario_persona_id_UK` (`usuario_persona_id`),
  UNIQUE KEY `usuario_usuario_UK` (`usuario_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `usuario_persona_id`, `usuario_usuario`, `usuario_clave`, `usuario_intentos_fallidos`, `usuario_estado`) VALUES
(1, 1, '6068901', '$2y$10$rq42FJY97qE4cI3kvIyGtO2pACH49UzELVC2prgLTfzVRVbUkfAVm', 0, NULL),
(2, 2, '6068902', '$2y$12$xnmQ.tBU3nYqq3oULJLA9egKGCew8/Ny0nCQA4zFuP99slUih.78u', 0, NULL),
(3, 3, '6068903', '$2y$10$/Vw52rdlyP/cxM5Umjw0auYdG3YjXB2gtvP.yNPi57kioTfpW63Ei', 0, NULL),
(4, 4, '6068904', '$2y$10$7ZKI8mgJpGqz3CoZfsN20.atz2.QHJaqoL1BMRgaYQrsLmAFu13te', 0, NULL),
(5, 5, '6068905', '$2y$10$ZlS5NMsYRq938xIIMR72se81X29ZGKPLvwqFgitlEoPyqQzVvvpZK', 0, NULL),
(6, 6, '6068906', '$2y$10$wyWkhqz6wFQe17VC2Kjxq.QxdrGZj8Wazwog8FAVaLWt/PP0gnS/q', 0, NULL),
(7, 7, '6068907', '$2y$10$5e5/jhRM1XEfVNtLPcPeZO02qLD7oZZUzKsnBDdMZjgHy/Oym8tve', 0, NULL),
(8, 8, '6068908', '$2y$10$rFC7Frer7F4p3ceaR1AxmOliddPLEpS3LRhttU4nY7hPPSHljD1vW', 0, NULL),
(9, 9, '6068909', '$2y$10$iwcZo7eQ/6KJ9U7ag9Kw5OA3dLmznbtzUpERL/h03010G5imDlJ1e', 0, NULL),
(10, 10, '6068910', '$2y$10$BUzTOSI9ayN47TfHcYf7lO.Qt99sd1DqAFmzbUO0oOZubikTJzqIm', 0, NULL),
(11, 11, '6068911', '$2y$10$W/JhfMSPsOVv/4sNWNFyI.jWudBCVAAfubA.Rfv/UhQ3MJYy7fHSm', 0, NULL),
(12, 12, '6068912', '$2y$10$KnqSzZ7BYAxiCufMO802ke4Q1Wkd/hyYeGVAyWaHQPIm3oFh40kDW', 0, NULL),
(13, 1001, '10001001', '$2y$10$RvxV/Z1llAlCEyzYf/j0yeo8EjuUDC9b6sl5gq6k2FTk7vpvYbLPi', 0, NULL),
(14, 1002, '10001002', '$2y$10$s3szM0AlH1ZL98qK2xSO6enot4oHHcZK7hrv/rWfDmvdx2VBR5MEO', 0, NULL),
(15, 1003, '10001003', '$2y$10$T955Cqp2NfsnxN.SvsRE3u3DRbeWlakkxdoIErbH4sFl/Bb/feahy', 0, NULL),
(16, 1004, '10001004', '$2y$10$nQ765yh4Ua2JjRoGH5qUhOoZDQDSz1sm.3qq6Q3F8fcSyqVBNSbra', 0, NULL),
(17, 1005, '10001005', '$2y$10$tasJofLHuZ0wKfzqBUfk7.Tin14khFRFLEKlFteP5uJ2JtRfyfExS', 0, NULL),
(18, 1006, '10001006', '$2y$10$GX74efzT7X.3Gl1qdwKnce3v41BrklzKx2FVRfmwZ5FTlelsdODRG', 0, NULL),
(19, 1007, '10001007', '$2y$10$3e92PyNakPNN8ULuJG66fuFOVgQg2LF3/40k89zPbeTku4SoQV3GC', 0, NULL),
(20, 1008, '10001008', '$2y$10$VG8yFoHS0nA.uZWfcMTFE.FsuAQ5D8NN6unDUDUgZTfJ/NYTKJrCO', 0, NULL),
(21, 1009, '10001009', '$2y$10$CHncsWVM8H9tc4NdGOK19.YQ460Z4npwXIWosn1XfcPFFD/0dZTQi', 0, NULL),
(22, 1010, '10001010', '$2y$10$gYgNDxL1j9dMN3XgilLYeubh3XnM9T2Au2SCTZZaAXUy2OaU/CTM.', 0, NULL),
(23, 1011, '10001011', '$2y$10$16vldl7FK0sRgdUf8BHgb.DQa3RLq0SYjJPH5VzVpQZH67p.bTXG2', 0, NULL),
(24, 1012, '10001012', '$2y$10$E2rGchfzE1pbfH/7qkJzFOy9mgbye7wvuxyzRp5RW9hsQ7GLknyJ2', 0, NULL),
(25, 1013, '10001013', '$2y$10$l6X1Uz9As80CUPG5su0gmOT4mavlBnXiDA4Foli8aKub3T9JLGoy6', 0, NULL),
(26, 1014, '10001014', '$2y$10$N5jCOr3ISAkIupUvYeehAeA1t8GiPfAhUEWo/aeig2/ODoVCkBrgO', 0, NULL),
(27, 1015, '10001015', '$2y$10$JT1Mjs2L6FoLWz02D5jtH.7Fdoq1GEDJj158./TWWLwaGpJhempoq', 0, NULL),
(28, 1016, '10001016', '$2y$10$4UBf/jKvuJhoSFhi7AFC9e7l9d2Xk.CeHw1D.ARASn0H3BtOpx.Rq', 0, NULL),
(29, 1017, '10001017', '$2y$10$4wvlmB5p/LAMd5pvWKgD6u3SgWfOKOm6X7yijt1x.3xieP.usxdOa', 0, NULL),
(30, 1018, '10001018', '$2y$10$LgS5xWfvn3rfhHz9FtwhWe8wj8F42qLt4nSq55BBUB6FYwa7TU.CO', 0, NULL),
(31, 1019, '10001019', '$2y$10$l6AUwKO51LvRIEnYF9hdX.gNIW0v6OixdJRR2AwWa.I4lHfVJydCu', 0, NULL),
(32, 1020, '10001020', '$2y$10$7jLPzz18MQ/SMJyUroCexuWLEclfaWp/5NBx13ZF4Au1iWODITjzm', 0, NULL),
(33, 1021, '10001021', '$2y$10$.H7Wyb09b7Ap36twtPKkD.MDMGeai6BGGEjeHzBgLWwpUningvh.6', 0, NULL),
(34, 1022, '10001022', '$2y$10$XBA8k9btSSl/d4iEgYuOL.EqxsH8yuNws0aADYoz3dVB9mk/7Oit2', 0, NULL),
(35, 1023, '10001023', '$2y$10$1DlHT2c2tuk.osT3cLiBCu0MU2DNUG7bvqbw.IowcbQzghvZNh.EK', 0, NULL),
(36, 1024, '10001024', '$2y$10$Cl63Bb.Dpf9sbIh4ouRWYuCcXisgHFdNI5k2.lDQ9Wc/8LE1L2uqO', 0, NULL),
(37, 1025, '10001025', '$2y$10$ko24tiuU3VROfF3kOZV3veD.QzokQJZjXKOaTgU5kOuhgMD2eoBES', 0, NULL),
(38, 1026, '10001026', '$2y$10$bKOcCfqpeX4Clu9noX1FReFuPtj7VBMLGkvldROpAIRgJZXBS/Ksu', 0, NULL),
(39, 1027, '10001027', '$2y$10$qgRmOApUKQJkryXKMI2sxOQHsBXFRspP8.vE3L6DvTQ0e.zO8JVbW', 0, NULL),
(40, 1028, '10001028', '$2y$10$nWHJr8qgPJHWAF.9t/vN3eY6FBn3a.ouIk6sV9mcDbuX7xt/c7uA2', 0, NULL),
(41, 1029, '10001029', '$2y$10$VY2e3ndkQPZFcT82R1Ng8OtS4pSQu07hUMqo9xyY5O/z390PbqCmK', 0, NULL),
(42, 1030, '10001030', '$2y$10$TnCgeVX7CsaXxKix2vXgIOWtjQs0do94sBkiaLCpsx4SW0LoizX7C', 0, NULL),
(43, 1031, '10001031', '$2y$10$AgIGAB1pkGjo88d3I3kHmuWvcjnci2424ihvIfBS3ZjxGBeLKDov6', 0, NULL),
(44, 1032, '10001032', '$2y$10$vCj0lz4APudV.QSa59rFHeGucHv1JW4QJJHWtPMww4DXWR7zuaKdu', 0, NULL),
(45, 1033, '10001033', '$2y$10$wIaByT02ztnQkhJVC1FqfezItFGi3E7j2JG5R70aNZkxR4/eOoVLO', 0, NULL),
(46, 1034, '10001034', '$2y$10$4j4T.dDgA8ruq51TM/4PEOPvRGJAySRhqrL220EwS9votzB6SGVOi', 0, NULL),
(47, 1035, '10001035', '$2y$10$p0P451b5gMivc/ZND9uCputGMnrkC/EwsCzd9k38iCG0XUnS6dQ9W', 0, NULL),
(48, 1036, '10001036', '$2y$10$wlcMUP/2T7w.wKgPO3z3xeLbSuWyDaBLAlASTKBLTHiHDkrDd1.6q', 0, NULL),
(49, 1037, '10001037', '$2y$10$c7dTnmKlS6c2bb7cFv9uyuB74gXLMpqWBrI6at.ReXIoE1Bu82bfO', 0, NULL),
(50, 1038, '10001038', '$2y$10$/KdUysdUQXip1ZEII4P84upmiAKFqskAkypvNQhYxemIC8SIhT57C', 0, NULL),
(51, 1039, '10001039', '$2y$10$NQoUuMIegEW1iX1zDhE7dulvoS6xupGv1ZgNicoYBjcDJED5IjyuG', 0, NULL),
(52, 1040, '10001040', '$2y$10$dJ5NSHfmSNsxooPjwnuveOTG7N40nH4D4W4x6GQJaUS7vR.7sV0n2', 0, NULL),
(53, 1041, '10001041', '$2y$10$9zusjplfNPeemKJm0s/1k.KS8xTC706O2MWjWJujU7Id2jV3LKDeC', 0, NULL),
(54, 1042, '10001042', '$2y$10$ZEVDO/J9UUmO7nkvP4ajPuCoJPIIUsnzcISX8ZSwz9Wllvt0wkykS', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_inscripciones`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vista_inscripciones`;
CREATE TABLE IF NOT EXISTS `vista_inscripciones` (
`vista_apertura_asignatura_id` int
,`vista_apertura_inscripcion` tinyint(1)
,`vista_estudiante_id` int
,`vista_apertura_id` int
,`vista_periodo_nombre` varchar(45)
,`vista_periodo_gestion` int
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_prerrequisitos`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vista_prerrequisitos`;
CREATE TABLE IF NOT EXISTS `vista_prerrequisitos` (
`vista_prerrequisito_id` int
,`vista_prerrequisito_pensum_id` int
,`vista_prerrequisito_sigla` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_prerrequisitos_nombres`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vista_prerrequisitos_nombres`;
CREATE TABLE IF NOT EXISTS `vista_prerrequisitos_nombres` (
`vista_prerrequisito_id` int
,`vista_pensum_id` int
,`vista_comentario` varchar(255)
,`vista_asignatura_id` int
,`vista_asignatura_sigla` varchar(45)
,`vista_asignatura_nombre` varchar(255)
,`vista_plan_estudio_id` int
,`vista_plan_estudio_nombre` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_inscripciones`
--
DROP TABLE IF EXISTS `vista_inscripciones`;

DROP VIEW IF EXISTS `vista_inscripciones`;
CREATE ALGORITHM=UNDEFINED DEFINER=`jluis_db`@`localhost` SQL SECURITY DEFINER VIEW `vista_inscripciones`  AS SELECT `aperturas`.`apertura_asignatura_id` AS `vista_apertura_asignatura_id`, `aperturas`.`apertura_inscripcion` AS `vista_apertura_inscripcion`, `inscripciones`.`inscripcion_estudiante_id` AS `vista_estudiante_id`, `aperturas`.`apertura_id` AS `vista_apertura_id`, `periodos`.`periodo_nombre` AS `vista_periodo_nombre`, `periodos`.`periodo_gestion` AS `vista_periodo_gestion` FROM ((`inscripciones` join `aperturas` on((`inscripciones`.`inscripcion_apertura_id` = `aperturas`.`apertura_id`))) join `periodos` on((`aperturas`.`apertura_periodo_id` = `periodos`.`periodo_id`))) WHERE ((`aperturas`.`apertura_inscripcion` is not null) AND (`inscripciones`.`inscripcion_estado` = 1))  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_prerrequisitos`
--
DROP TABLE IF EXISTS `vista_prerrequisitos`;

DROP VIEW IF EXISTS `vista_prerrequisitos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`jluis_db`@`localhost` SQL SECURITY DEFINER VIEW `vista_prerrequisitos`  AS SELECT `prerrequisitos`.`prerrequisito_id` AS `vista_prerrequisito_id`, `prerrequisitos`.`prerrequisito_pensum_id` AS `vista_prerrequisito_pensum_id`, (case when (`asignaturas`.`asignatura_sigla` is null) then `prerrequisitos`.`prerrequisito_comentario` else `asignaturas`.`asignatura_sigla` end) AS `vista_prerrequisito_sigla` FROM (`prerrequisitos` left join `asignaturas` on((`asignaturas`.`asignatura_id` = `prerrequisitos`.`prerrequisito_asignatura_id`)))  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_prerrequisitos_nombres`
--
DROP TABLE IF EXISTS `vista_prerrequisitos_nombres`;

DROP VIEW IF EXISTS `vista_prerrequisitos_nombres`;
CREATE ALGORITHM=UNDEFINED DEFINER=`jluis_db`@`localhost` SQL SECURITY DEFINER VIEW `vista_prerrequisitos_nombres`  AS SELECT `prerrequisitos`.`prerrequisito_id` AS `vista_prerrequisito_id`, `prerrequisitos`.`prerrequisito_pensum_id` AS `vista_pensum_id`, `prerrequisitos`.`prerrequisito_comentario` AS `vista_comentario`, `asignaturas`.`asignatura_id` AS `vista_asignatura_id`, `asignaturas`.`asignatura_sigla` AS `vista_asignatura_sigla`, `asignaturas`.`asignatura_nombre` AS `vista_asignatura_nombre`, `plan_estudios`.`plan_estudio_id` AS `vista_plan_estudio_id`, `plan_estudios`.`plan_estudio_nombre` AS `vista_plan_estudio_nombre` FROM ((`prerrequisitos` left join `asignaturas` on((`prerrequisitos`.`prerrequisito_asignatura_id` = `asignaturas`.`asignatura_id`))) left join `plan_estudios` on((`asignaturas`.`asignatura_plan_estudio_id` = `plan_estudios`.`plan_estudio_id`)))  ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accesos`
--
ALTER TABLE `accesos`
  ADD CONSTRAINT `acceso_rol_id_FK` FOREIGN KEY (`acceso_rol_id`) REFERENCES `roles` (`rol_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `acceso_usuario_id_FK` FOREIGN KEY (`acceso_usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `actividad_usuario_id_FK` FOREIGN KEY (`actividad_usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `administrativos`
--
ALTER TABLE `administrativos`
  ADD CONSTRAINT `administrativo_cargo_id_FK` FOREIGN KEY (`administrativo_cargo_id`) REFERENCES `cargos` (`cargo_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `administrativo_persona_id_FK` FOREIGN KEY (`administrativo_persona_id`) REFERENCES `personas` (`persona_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `aperturas`
--
ALTER TABLE `aperturas`
  ADD CONSTRAINT `apertura_asignatura_id_FK` FOREIGN KEY (`apertura_asignatura_id`) REFERENCES `asignaturas` (`asignatura_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `apertura_periodo_id_FK` FOREIGN KEY (`apertura_periodo_id`) REFERENCES `periodos` (`periodo_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD CONSTRAINT `asignatura_plan_estudio_id_FK` FOREIGN KEY (`asignatura_plan_estudio_id`) REFERENCES `plan_estudios` (`plan_estudio_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `auxiliares`
--
ALTER TABLE `auxiliares`
  ADD CONSTRAINT `auxiliar_estudiante_id_FK` FOREIGN KEY (`auxiliar_estudiante_id`) REFERENCES `estudiantes` (`estudiante_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `auxiliaturas`
--
ALTER TABLE `auxiliaturas`
  ADD CONSTRAINT `auxiliatura_apertura_id_FK` FOREIGN KEY (`auxiliatura_apertura_id`) REFERENCES `aperturas` (`apertura_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `auxiliatura_auxiliar_id_FK` FOREIGN KEY (`auxiliatura_auxiliar_id`) REFERENCES `auxiliares` (`auxiliar_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `celulares`
--
ALTER TABLE `celulares`
  ADD CONSTRAINT `celular_pais_id_FK` FOREIGN KEY (`celular_pais_id`) REFERENCES `paises` (`pais_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `celular_persona_id_FK` FOREIGN KEY (`celular_persona_id`) REFERENCES `personas` (`persona_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `clases_auxiliaturas`
--
ALTER TABLE `clases_auxiliaturas`
  ADD CONSTRAINT `clase_auxiliatura_aula_id_FK` FOREIGN KEY (`clase_auxiliatura_aula_id`) REFERENCES `aulas` (`aula_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `clase_auxiliatura_auxiliatura_id_FK` FOREIGN KEY (`clase_auxiliatura_auxiliatura_id`) REFERENCES `auxiliaturas` (`auxiliatura_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `clases_docencias`
--
ALTER TABLE `clases_docencias`
  ADD CONSTRAINT `clase_docencia_aula_id_FK` FOREIGN KEY (`clase_docencia_aula_id`) REFERENCES `aulas` (`aula_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `clase_docencia_docencia_id_FK` FOREIGN KEY (`clase_docencia_docencia_id`) REFERENCES `docencias` (`docencia_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `codigos`
--
ALTER TABLE `codigos`
  ADD CONSTRAINT `codigo_usuario_id_FK` FOREIGN KEY (`codigo_usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `correos`
--
ALTER TABLE `correos`
  ADD CONSTRAINT `correo_persona_id_FK` FOREIGN KEY (`correo_persona_id`) REFERENCES `personas` (`persona_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `docencias`
--
ALTER TABLE `docencias`
  ADD CONSTRAINT `docencia_apertura_id_FK` FOREIGN KEY (`docencia_apertura_id`) REFERENCES `aperturas` (`apertura_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `docencia_docente_id_FK` FOREIGN KEY (`docencia_docente_id`) REFERENCES `docentes` (`docente_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD CONSTRAINT `docente_categoria_id_FK` FOREIGN KEY (`docente_categoria_id`) REFERENCES `categorias` (`categoria_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `docente_persona_id_FK` FOREIGN KEY (`docente_persona_id`) REFERENCES `personas` (`persona_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `domicilios`
--
ALTER TABLE `domicilios`
  ADD CONSTRAINT `domicilio_persona_id_FK` FOREIGN KEY (`domicilio_persona_id`) REFERENCES `personas` (`persona_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `estudiante_persona_id_FK` FOREIGN KEY (`estudiante_persona_id`) REFERENCES `personas` (`persona_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD CONSTRAINT `foto_persona_id_FK` FOREIGN KEY (`foto_persona_id`) REFERENCES `personas` (`persona_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `historiales`
--
ALTER TABLE `historiales`
  ADD CONSTRAINT `historial_asignatura_id_FK` FOREIGN KEY (`historial_asignatura_id`) REFERENCES `asignaturas` (`asignatura_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `historial_estudiante_id_FK` FOREIGN KEY (`historial_estudiante_id`) REFERENCES `estudiantes` (`estudiante_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `horarios_aulas`
--
ALTER TABLE `horarios_aulas`
  ADD CONSTRAINT `horario_aula_aula_id_FK` FOREIGN KEY (`horario_aula_aula_id`) REFERENCES `aulas` (`aula_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `horario_aula_periodo_id_FK` FOREIGN KEY (`horario_aula_periodo_id`) REFERENCES `periodos` (`periodo_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `horarios_semestres`
--
ALTER TABLE `horarios_semestres`
  ADD CONSTRAINT `horario_seme_mencion_id_FK` FOREIGN KEY (`horario_seme_mencion_id`) REFERENCES `menciones` (`mencion_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `horario_seme_periodo_id_FK` FOREIGN KEY (`horario_seme_periodo_id`) REFERENCES `periodos` (`periodo_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `horario_seme_semestre_id_FK` FOREIGN KEY (`horario_seme_semestre_id`) REFERENCES `semestres` (`semestre_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD CONSTRAINT `inscripcion_apertura_id_FK` FOREIGN KEY (`inscripcion_apertura_id`) REFERENCES `aperturas` (`apertura_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `inscripcion_estudiante_id_FK` FOREIGN KEY (`inscripcion_estudiante_id`) REFERENCES `estudiantes` (`estudiante_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `nota_inscripcion_id_FK` FOREIGN KEY (`nota_inscripcion_id`) REFERENCES `inscripciones` (`inscripcion_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `panel_control`
--
ALTER TABLE `panel_control`
  ADD CONSTRAINT `panel_control_periodo_id_FK` FOREIGN KEY (`panel_control_periodo_id`) REFERENCES `periodos` (`periodo_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `panel_control_plan_estudio_id_FK` FOREIGN KEY (`panel_control_plan_estudio_id`) REFERENCES `plan_estudios` (`plan_estudio_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `pensum`
--
ALTER TABLE `pensum`
  ADD CONSTRAINT `pensum_asignatura_id_FK` FOREIGN KEY (`pensum_asignatura_id`) REFERENCES `asignaturas` (`asignatura_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `pensum_mencion_id_FK` FOREIGN KEY (`pensum_mencion_id`) REFERENCES `menciones` (`mencion_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `pensum_semestre_id_FK` FOREIGN KEY (`pensum_semestre_id`) REFERENCES `semestres` (`semestre_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `prerrequisitos`
--
ALTER TABLE `prerrequisitos`
  ADD CONSTRAINT `prerrequisito_asignatura_id_FK` FOREIGN KEY (`prerrequisito_asignatura_id`) REFERENCES `asignaturas` (`asignatura_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `prerrequisito_pensum_id_FK` FOREIGN KEY (`prerrequisito_pensum_id`) REFERENCES `pensum` (`pensum_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `publicar_horarios_aulas`
--
ALTER TABLE `publicar_horarios_aulas`
  ADD CONSTRAINT `publicar_hora_aula_horario_aula_id_Fk` FOREIGN KEY (`publicar_hora_aula_horario_aula_id`) REFERENCES `horarios_aulas` (`horario_aula_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `publicar_hora_aula_usuario_id_FK` FOREIGN KEY (`publicar_hora_aula_usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `publicar_horarios_semestres`
--
ALTER TABLE `publicar_horarios_semestres`
  ADD CONSTRAINT `publicar_hora_seme_horario_seme_id_FK` FOREIGN KEY (`publicar_hora_seme_horario_seme_id`) REFERENCES `horarios_semestres` (`horario_seme_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `publicar_hora_seme_usuario_id_FK` FOREIGN KEY (`publicar_hora_seme_usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `registrar_publicaciones`
--
ALTER TABLE `registrar_publicaciones`
  ADD CONSTRAINT `registrar_publ_publicacion_id_FK` FOREIGN KEY (`registrar_publ_publicacion_id`) REFERENCES `publicaciones` (`publicacion_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `registrar_publ_usuario_id_FK` FOREIGN KEY (`registrar_publ_usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `retiros`
--
ALTER TABLE `retiros`
  ADD CONSTRAINT `retiro_apertura_id_FK` FOREIGN KEY (`retiro_apertura_id`) REFERENCES `aperturas` (`apertura_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `retiro_estudiante_id_FK` FOREIGN KEY (`retiro_estudiante_id`) REFERENCES `estudiantes` (`estudiante_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuario_persona_id_FK` FOREIGN KEY (`usuario_persona_id`) REFERENCES `personas` (`persona_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_usuario_FK` FOREIGN KEY (`usuario_usuario`) REFERENCES `personas` (`persona_ci`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
