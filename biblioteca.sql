-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-10-2025 a las 04:42:46
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autores`
--

CREATE TABLE `autores` (
  `id_autor` int(11)  AUTO_INCREMENT PRIMARY KEY,
  `nombre` varchar(100) NOT NULL,
  `nacimiento` date NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `autores`
--

INSERT INTO `autores` (`id_autor`, `nombre`, `nacimiento`, `email`) VALUES
(1, 'Luciano Añon', '2004-08-03', 'luciano@gmail.com'),
(2, 'Julio Verne', '2000-01-01', 'julioverne32@gmail.com'),
(3, 'Jose Perez', '1995-06-21', 'joseperez@gmail.com'),
(4, 'Juana Rodriguez', '1999-03-08', 'juanarodriguez@gmail.com'),
(5, 'Emma', '2025-10-15', '20.emma.lop@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id_libro` int(11)  AUTO_INCREMENT PRIMARY KEY,
  `id_autor` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `genero` varchar(100) NOT NULL,
  `paginas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id_libro`, `id_autor`, `titulo`, `genero`, `paginas`) VALUES
(1, 1, 'El Alquimista', 'Aventura', 100),
(2, 3, 'Crimen y castigo', 'Clasico', 500),
(3, 3, 'Sherlock Holmes', 'Crimen', 800),
(4, 3, 'Hamlet', 'Teatro', 1000),
(5, 4, 'El principito', 'Clasico', 2000),
(6, 1, 'Martín Fierro', 'Poesia', 500),
(7, 2, 'La vuelta al mundo en 80 días', 'Aventura', 4000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login`
--

CREATE TABLE `login` (
  `id` int(11)  AUTO_INCREMENT PRIMARY KEY,
  `usuario` varchar(100) CHARACTER SET utf16 COLLATE utf16_spanish_ci NOT NULL,
  `contrasena` varchar(200) CHARACTER SET utf16 COLLATE utf16_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `login`
--

INSERT INTO `login` (`id`, `usuario`, `contrasena`) VALUES
(1, 'webadmin', '$2y$10$ax3bLQBWYdfetJxumbdezuE/Q0OmSwYwSYeNRPsMYuy.svLI8NjZe');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `autores`
--
ALTER TABLE `autores`
  ADD PRIMARY KEY (`id_autor`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id_libro`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `autores`
--
ALTER TABLE `autores`
  MODIFY `id_autor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id_libro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

ALTER TABLE `libros` 
  ADD CONSTRAINT `autor` FOREIGN KEY (`id_autor`) REFERENCES `autores`(`id_autor`) 
ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
