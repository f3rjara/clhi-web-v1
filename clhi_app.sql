-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-08-2018 a las 01:35:12
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `toolstic_v2_170718`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE `actividad` (
  `id_actividad` int(2) NOT NULL,
  `actividad` varchar(250) COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_bin NOT NULL,
  `fechaplazo` date NOT NULL,
  `id_tipoactividad` int(2) NOT NULL,
  `id_modalidad` int(2) NOT NULL,
  `linkactividad` mediumtext COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `actividad`
--

INSERT INTO `actividad` (`id_actividad`, `actividad`, `descripcion`, `fechaplazo`, `id_tipoactividad`, `id_modalidad`, `linkactividad`) VALUES
(1, 'Terminar Plataforma', 'esta es la descripcion de la primera actividad, complete por favor plataforma de notas esta es la descripcion de la primera actividad, complete por favor plataforma de notas esta es la descripsasasasa', '2018-08-25', 1, 1, 'https://www.google.com/'),
(2, 'Introduccion a la informática', 'esta es la descripcion de la primera actividad, complete por favor plataforma de notas esta es la descripcion de la primera actividad, complete por favor plataforma de notas esta es la descripsasasasa', '2018-08-26', 1, 3, ''),
(3, 'Terminar Plataforma', 'esta es la descripcion de la primera actividad, complete por favor plataforma de notas esta es la descripcion de la primera actividad, complete por favor plataforma de notas esta es la descripsasasasa', '2018-08-25', 3, 1, ''),
(4, 'Examen introductivo', 'Primer examen dela introduccion a CLHI, por favor estudie esta actividad no tiene recupracion', '2018-08-29', 2, 2, 'http://coes.udenar.edu.co/'),
(5, 'Segundo Examen', 'ES EL SEGUNDO EXAMEN DE clhi', '2018-08-31', 2, 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoriaactividad`
--

CREATE TABLE `categoriaactividad` (
  `id_categoriaActividad` int(3) NOT NULL,
  `categoriaActividad` varchar(50) COLLATE utf8_bin NOT NULL,
  `detallecateactividad` mediumtext COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `categoriaactividad`
--

INSERT INTO `categoriaactividad` (`id_categoriaActividad`, `categoriaActividad`, `detallecateactividad`) VALUES
(2, 'Taller', 'Los talleres hacen referencia a todas las actividades, trabajos, tareas, ejercicios, consultas, ensayos y pruebas objetivas que el estudiante realiza de manera individual o colectiva dentro y fuera del aula de clases.'),
(3, 'Examen', 'Consiste en la prueba oral o escrita que busca jerarquizar, clasificar, seleccionar a grupos o individuos'),
(4, 'Exposición Temática', 'La exposición temática consiste en buscar que los alumnos utilicen sus propias palabras para la exposición de temáticas y situaciones previamente establecidas por el docente. '),
(5, 'Cuestionario', 'A diferencia del examen, el cuestionario es un conjunto de preguntas estructuradas acerca de un tema, su aplicación es de forma escrita, la mayoría de veces tienen opciones para responder (si, no, excelente, malo, verdadero, falso) '),
(6, 'Debate', 'El debate consisten en polemizar, confrontar, y defender ideas y saberes que se han alcanzado a interpretar de un tema, y que se hará con la participación de los alumnos quienes harán de proponentes (ponentes), y opositores de las ideas expuestas. '),
(7, 'Proyecto', 'Se basa en pruebas de potencialidades actitudinales, conceptuales y procedimentales (Saber, Saber Hacer, Ser) por medio de planteamientos reales o simuladas en las cuales el alumno debe expresar sus ideas a partir de trabajos y proyectos que desarrollen su potencial en la adquisición de destrezas que se pretenden evaluar.'),
(8, 'Observación', 'Consiste en el examen atento y riguroso del alumno para evaluar estados de desarrollo del proceso de aprendizaje del alumno (SER) y que ayudan a que las acciones de éste sean de forma correcta y natural, entre estos aspecto se puede evaluar, la responsabilidad, cumplimiento de tareas, puntualidad.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `id_docente` int(10) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_bin NOT NULL,
  `apellido` varchar(100) COLLATE utf8_bin NOT NULL,
  `correo` varchar(200) COLLATE utf8_bin NOT NULL,
  `telefono` varchar(10) COLLATE utf8_bin NOT NULL,
  `foto` varchar(30) COLLATE utf8_bin NOT NULL,
  `clave` varchar(32) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`id_docente`, `nombre`, `apellido`, `correo`, `telefono`, `foto`, `clave`) VALUES
(37086052, 'Maritza', 'Jaramillo', 'maryloin00@hotmail.com', '3137445930', '', '81dc9bdb52d04dc20036dbd8313ed055'),
(1085277365, 'Fernando', 'Jaramillo', 'f3rjara@gmail.com', '3207072863', '', 'cc598895a76714dff4c34b2361569b37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadoactividad`
--

CREATE TABLE `estadoactividad` (
  `id_estadoactividad` int(2) NOT NULL,
  `estadoactividad` varchar(30) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `estadoactividad`
--

INSERT INTO `estadoactividad` (`id_estadoactividad`, `estadoactividad`) VALUES
(1, 'No presentada'),
(2, 'Fuera de Tiempo'),
(3, 'Presentada - Sin revisón'),
(4, 'Falta Calificación'),
(5, 'Finalizada'),
(6, 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadointerpela`
--

CREATE TABLE `estadointerpela` (
  `id_estadointerpela` int(2) NOT NULL,
  `estado` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `estadointerpela`
--

INSERT INTO `estadointerpela` (`id_estadointerpela`, `estado`) VALUES
(1, 'Presentada'),
(2, 'En proceso'),
(3, 'Resuelta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `codigoe` int(12) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_bin NOT NULL,
  `apellido` varchar(100) COLLATE utf8_bin NOT NULL,
  `correo` varchar(200) COLLATE utf8_bin NOT NULL,
  `telefono` varchar(10) COLLATE utf8_bin NOT NULL,
  `foto` varchar(30) COLLATE utf8_bin NOT NULL,
  `id_grupo` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`codigoe`, `nombre`, `apellido`, `correo`, `telefono`, `foto`, `id_grupo`) VALUES
(2180, 'James', 'Rodriguez', 'jamesbro@gmail.com', '3131231234', '', 1),
(3349, 'Andres', 'Mujanajinsoy', 'andresmujana@gmail.com', '3121234325', '', 3),
(6111, 'Angie', ' de la cruz cadena', 'angiecadena@hotmail.com', '3145677654', '', 1),
(8101, 'Adiela ', 'Churta', 'adielabebe@gmail.com', '3456544321', '', 3),
(8245, 'Deisy Pahola', 'Pozo Reina', 'deisyPozo@gmail.com', '3124566543', '', 2),
(123456, 'Pepito', 'Perez', 'lacuentaincognita@gmail.com', '3207072863', '', 1),
(217043538, 'Karen Dayana', 'Luna Ortega', 'karendayaana@gmail.com', '3132456543', '', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `id_grupo` int(2) NOT NULL COMMENT 'autoincremental',
  `detalle` varchar(50) COLLATE utf8_bin NOT NULL,
  `year` year(4) NOT NULL,
  `periodo` varchar(2) COLLATE utf8_bin NOT NULL,
  `aula` varchar(50) COLLATE utf8_bin NOT NULL,
  `horainicio` time NOT NULL,
  `horafin` time NOT NULL,
  `id_docente` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`id_grupo`, `detalle`, `year`, `periodo`, `aula`, `horainicio`, `horafin`, `id_docente`) VALUES
(1, 'G17', 2018, 'A', '405', '08:00:00', '12:00:00', 1085277365),
(2, 'G16', 2018, 'B', '405', '14:00:00', '18:00:00', 37086052),
(3, 'G22', 2018, 'B', '305', '08:00:00', '12:00:00', 1085277365);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `interpelar`
--

CREATE TABLE `interpelar` (
  `id_interpela` int(4) NOT NULL,
  `observacion` varchar(200) COLLATE utf8_bin NOT NULL,
  `fechasolicitud` date NOT NULL,
  `id_notas` int(4) NOT NULL,
  `id_estadointerpela` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `interpelar`
--

INSERT INTO `interpelar` (`id_interpela`, `observacion`, `fechasolicitud`, `id_notas`, `id_estadointerpela`) VALUES
(43, 'Profe quiero que me de solucion a mi nota usted dijo que iba a subir.. esta muy bajita por favor .. ayudeme en este dÃƒÂ­a ÃƒÂ±o sea asÃƒÂ­', '2018-08-30', 6, 1),
(44, 'ProfÃƒÂ© por que la nota esta tan bajita? ayÃƒÂºdeme yo le envie a tiempo', '2018-08-30', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modalidad`
--

CREATE TABLE `modalidad` (
  `id_modalidad` int(2) NOT NULL,
  `modalidad` varchar(30) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `modalidad`
--

INSERT INTO `modalidad` (`id_modalidad`, `modalidad`) VALUES
(1, 'Individual'),
(2, 'Binas'),
(3, 'Grupo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notafinal`
--

CREATE TABLE `notafinal` (
  `id_notafinal` int(4) NOT NULL,
  `codigoe` int(12) NOT NULL,
  `id_tipoactividad` int(2) NOT NULL,
  `NotaFinalTA` float NOT NULL,
  `NumActividadesXT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `notafinal`
--

INSERT INTO `notafinal` (`id_notafinal`, `codigoe`, `id_tipoactividad`, `NotaFinalTA`, `NumActividadesXT`) VALUES
(11, 2180, 1, 0.93, 2),
(12, 2180, 2, 1.09, 2),
(13, 123456, 1, 0.81, 2),
(14, 123456, 2, 1.68, 2),
(15, 8245, 3, 0, 0),
(16, 8245, 4, 0, 0),
(17, 8245, 5, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `id_notas` int(4) NOT NULL,
  `id_actividad` int(2) NOT NULL,
  `codigoe` int(12) NOT NULL,
  `id_estadoactividad` int(2) NOT NULL,
  `notaactividad` float NOT NULL,
  `fechaentrega` date NOT NULL,
  `fechacalificada` date NOT NULL,
  `retroalimentacion` varchar(200) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `notas`
--

INSERT INTO `notas` (`id_notas`, `id_actividad`, `codigoe`, `id_estadoactividad`, `notaactividad`, `fechaentrega`, `fechacalificada`, `retroalimentacion`) VALUES
(2, 1, 2180, 6, 4.1, '2018-08-25', '2018-08-25', 'Pendiente'),
(3, 2, 2180, 4, 2.1, '2018-08-24', '2018-08-26', 'Aun falta'),
(4, 1, 123456, 2, 2.2, '2018-08-25', '2018-08-27', 'eres muy vago por favor ponte pilas con eso '),
(5, 4, 2180, 5, 3.1, '2018-08-28', '2018-08-30', 'Esto es muy lora pero con el update siempre se sabra la nota '),
(6, 2, 123456, 3, 3.2, '2018-08-29', '2018-08-30', 'hjgjggb'),
(7, 4, 123456, 2, 4.8, '2018-08-29', '2018-08-30', 'pinche severo sistema');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticiastoolstic`
--

CREATE TABLE `noticiastoolstic` (
  `id_noticia` int(3) NOT NULL,
  `fecha` date NOT NULL,
  `titulo` varchar(50) COLLATE utf8_bin NOT NULL,
  `mensaje` mediumtext COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `noticiastoolstic`
--

INSERT INTO `noticiastoolstic` (`id_noticia`, `fecha`, `titulo`, `mensaje`) VALUES
(1, '2018-08-29', 'Inicio de Actividades', 'Se informa a la comunidad educativa de Universidad de Nariño, que el inicio de Módulos de Lenguaje y Herramientas Informáticas para el periodo B-2018 iniciaran el próximo 1 de Septiembre de 2018, en los grupos y horarios matriculados por cada estudiante, los cuales se impartirán en las aulas de informática del cuarto piso en el Bloque Tecnológico.'),
(2, '2018-08-24', 'Comenzando A progrmamar', 'se informa que a me puse a progrmar con el fin de que la seman este lista la plataforma');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reinterpelar`
--

CREATE TABLE `reinterpelar` (
  `id_reinterpela` int(3) NOT NULL,
  `id_docente` int(10) NOT NULL,
  `id_interpelar` int(4) NOT NULL,
  `id_esatdointerpela` int(2) NOT NULL,
  `observacion` varchar(200) COLLATE utf8_bin NOT NULL,
  `fechaRespuesta` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoactividad`
--

CREATE TABLE `tipoactividad` (
  `id_tipoactividad` int(2) NOT NULL,
  `id_grupo` int(2) NOT NULL,
  `porcentaje` int(2) NOT NULL,
  `id_categoriaActividad` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `tipoactividad`
--

INSERT INTO `tipoactividad` (`id_tipoactividad`, `id_grupo`, `porcentaje`, `id_categoriaActividad`) VALUES
(1, 1, 30, 2),
(2, 1, 70, 3),
(3, 2, 25, 2),
(4, 2, 25, 4),
(5, 2, 50, 7);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`id_actividad`),
  ADD KEY `id_tipoactividad` (`id_tipoactividad`),
  ADD KEY `id_modalidad` (`id_modalidad`);

--
-- Indices de la tabla `categoriaactividad`
--
ALTER TABLE `categoriaactividad`
  ADD PRIMARY KEY (`id_categoriaActividad`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`id_docente`);

--
-- Indices de la tabla `estadoactividad`
--
ALTER TABLE `estadoactividad`
  ADD PRIMARY KEY (`id_estadoactividad`);

--
-- Indices de la tabla `estadointerpela`
--
ALTER TABLE `estadointerpela`
  ADD PRIMARY KEY (`id_estadointerpela`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`codigoe`),
  ADD KEY `id_grupo` (`id_grupo`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id_grupo`),
  ADD KEY `id_docente` (`id_docente`);

--
-- Indices de la tabla `interpelar`
--
ALTER TABLE `interpelar`
  ADD PRIMARY KEY (`id_interpela`),
  ADD KEY `id_notas` (`id_notas`),
  ADD KEY `id_estadointerpela` (`id_estadointerpela`);

--
-- Indices de la tabla `modalidad`
--
ALTER TABLE `modalidad`
  ADD PRIMARY KEY (`id_modalidad`);

--
-- Indices de la tabla `notafinal`
--
ALTER TABLE `notafinal`
  ADD PRIMARY KEY (`id_notafinal`),
  ADD KEY `codigoe` (`codigoe`),
  ADD KEY `id_tipoactividad` (`id_tipoactividad`);

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id_notas`),
  ADD KEY `id_actividad` (`id_actividad`),
  ADD KEY `codigoe` (`codigoe`),
  ADD KEY `id_estadoactividad` (`id_estadoactividad`);

--
-- Indices de la tabla `noticiastoolstic`
--
ALTER TABLE `noticiastoolstic`
  ADD PRIMARY KEY (`id_noticia`);

--
-- Indices de la tabla `reinterpelar`
--
ALTER TABLE `reinterpelar`
  ADD PRIMARY KEY (`id_reinterpela`),
  ADD KEY `id_docente` (`id_docente`),
  ADD KEY `id_interpelar` (`id_interpelar`),
  ADD KEY `id_esatdointerpela` (`id_esatdointerpela`);

--
-- Indices de la tabla `tipoactividad`
--
ALTER TABLE `tipoactividad`
  ADD PRIMARY KEY (`id_tipoactividad`),
  ADD KEY `id_grupo` (`id_grupo`),
  ADD KEY `id_categoriaActividad` (`id_categoriaActividad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividad`
--
ALTER TABLE `actividad`
  MODIFY `id_actividad` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `categoriaactividad`
--
ALTER TABLE `categoriaactividad`
  MODIFY `id_categoriaActividad` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `estadoactividad`
--
ALTER TABLE `estadoactividad`
  MODIFY `id_estadoactividad` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `estadointerpela`
--
ALTER TABLE `estadointerpela`
  MODIFY `id_estadointerpela` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id_grupo` int(2) NOT NULL AUTO_INCREMENT COMMENT 'autoincremental', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `interpelar`
--
ALTER TABLE `interpelar`
  MODIFY `id_interpela` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `modalidad`
--
ALTER TABLE `modalidad`
  MODIFY `id_modalidad` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `notafinal`
--
ALTER TABLE `notafinal`
  MODIFY `id_notafinal` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `id_notas` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `noticiastoolstic`
--
ALTER TABLE `noticiastoolstic`
  MODIFY `id_noticia` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `reinterpelar`
--
ALTER TABLE `reinterpelar`
  MODIFY `id_reinterpela` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipoactividad`
--
ALTER TABLE `tipoactividad`
  MODIFY `id_tipoactividad` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD CONSTRAINT `actividad_ibfk_2` FOREIGN KEY (`id_modalidad`) REFERENCES `modalidad` (`id_modalidad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `actividad_ibfk_3` FOREIGN KEY (`id_tipoactividad`) REFERENCES `tipoactividad` (`id_tipoactividad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `estudiante_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id_grupo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD CONSTRAINT `grupo_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `interpelar`
--
ALTER TABLE `interpelar`
  ADD CONSTRAINT `interpelar_ibfk_1` FOREIGN KEY (`id_notas`) REFERENCES `notas` (`id_notas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `interpelar_ibfk_2` FOREIGN KEY (`id_estadointerpela`) REFERENCES `estadointerpela` (`id_estadointerpela`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `notafinal`
--
ALTER TABLE `notafinal`
  ADD CONSTRAINT `notafinal_ibfk_1` FOREIGN KEY (`codigoe`) REFERENCES `estudiante` (`codigoe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notafinal_ibfk_2` FOREIGN KEY (`id_tipoactividad`) REFERENCES `tipoactividad` (`id_tipoactividad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`codigoe`) REFERENCES `estudiante` (`codigoe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notas_ibfk_2` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notas_ibfk_3` FOREIGN KEY (`id_estadoactividad`) REFERENCES `estadoactividad` (`id_estadoactividad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reinterpelar`
--
ALTER TABLE `reinterpelar`
  ADD CONSTRAINT `reinterpelar_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reinterpelar_ibfk_2` FOREIGN KEY (`id_interpelar`) REFERENCES `interpelar` (`id_interpela`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reinterpelar_ibfk_3` FOREIGN KEY (`id_esatdointerpela`) REFERENCES `estadointerpela` (`id_estadointerpela`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tipoactividad`
--
ALTER TABLE `tipoactividad`
  ADD CONSTRAINT `tipoactividad_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id_grupo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tipoactividad_ibfk_2` FOREIGN KEY (`id_categoriaActividad`) REFERENCES `categoriaactividad` (`id_categoriaActividad`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
