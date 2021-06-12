-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2021 a las 19:02:21
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `final_actas`
--

CREATE TABLE `final_actas` (
  `idacta` int(11) NOT NULL,
  `titulo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `puntuacion` int(11) NOT NULL,
  `descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `idlugar` int(11) NOT NULL,
  `idpais` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `final_admins`
--

CREATE TABLE `final_admins` (
  `idadmin` int(11) NOT NULL,
  `admin` varchar(25) COLLATE utf8_spanish2_ci NOT NULL,
  `clave` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `final_admins`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `final_ciudades`
--

CREATE TABLE `final_ciudades` (
  `idciudad` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `idpais` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `final_comentarios`
--

CREATE TABLE `final_comentarios` (
  `idcomentario` int(11) NOT NULL,
  `cuerpo` text COLLATE utf8_spanish2_ci NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idacta` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `final_comentarios`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `final_fotos`
--

CREATE TABLE `final_fotos` (
  `idfoto` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `ruta` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `idacta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `final_fotos`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `final_fotos_subiendo`
--

CREATE TABLE `final_fotos_subiendo` (
  `idfoto` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `ruta` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `final_lugares`
--

CREATE TABLE `final_lugares` (
  `idlugar` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `idciudad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `final_paises`
--

CREATE TABLE `final_paises` (
  `idpais` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `final_paises`
--



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `final_usuarios`
--

CREATE TABLE `final_usuarios` (
  `idusuario` int(11) NOT NULL,
  `nick` varchar(25) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `apellidos` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `clave` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `final_usuarios`
--


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `final_actas`
--
ALTER TABLE `final_actas`
  ADD PRIMARY KEY (`idacta`);

--
-- Indices de la tabla `final_ciudades`
--
ALTER TABLE `final_ciudades`
  ADD PRIMARY KEY (`idciudad`);

--
-- Indices de la tabla `final_comentarios`
--
ALTER TABLE `final_comentarios`
  ADD PRIMARY KEY (`idcomentario`);

--
-- Indices de la tabla `final_fotos`
--
ALTER TABLE `final_fotos`
  ADD PRIMARY KEY (`idfoto`);

--
-- Indices de la tabla `final_fotos_subiendo`
--
ALTER TABLE `final_fotos_subiendo`
  ADD PRIMARY KEY (`idfoto`);

--
-- Indices de la tabla `final_lugares`
--
ALTER TABLE `final_lugares`
  ADD PRIMARY KEY (`idlugar`);

--
-- Indices de la tabla `final_paises`
--
ALTER TABLE `final_paises`
  ADD PRIMARY KEY (`idpais`);

--
-- Indices de la tabla `final_usuarios`
--
ALTER TABLE `final_usuarios`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `final_actas`
--
ALTER TABLE `final_actas`
  MODIFY `idacta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `final_comentarios`
--
ALTER TABLE `final_comentarios`
  MODIFY `idcomentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `final_fotos`
--
ALTER TABLE `final_fotos`
  MODIFY `idfoto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `final_fotos_subiendo`
--
ALTER TABLE `final_fotos_subiendo`
  MODIFY `idfoto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `final_usuarios`
--
ALTER TABLE `final_usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
