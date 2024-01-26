
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `autores` (
  `idAutor` int UNSIGNED NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pais` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabla de autores';


CREATE TABLE `libros` (
  `idLibro` int UNSIGNED NOT NULL COMMENT 'Clave primaria de la tabla',
  `titulo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `genero` enum('Narrativa','Lírica','Teatro','Científico-Técnico') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idAutor` int UNSIGNED DEFAULT NULL COMMENT 'Clave foránea de la tabla autor',
  `numeroPaginas` int UNSIGNED NOT NULL,
  `numeroEjemplares` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='La tabla de libros de nuestra biblioteca';



CREATE TABLE `usuarios` (
  `login` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salt` int NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol` enum('administrador','bibliotecario','registrado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `autores`
  ADD PRIMARY KEY (`idAutor`);


ALTER TABLE `libros`
  ADD PRIMARY KEY (`idLibro`),
  ADD KEY `idAutor` (`idAutor`);


ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`login`);


ALTER TABLE `autores`
  MODIFY `idAutor` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

ALTER TABLE `libros`
  MODIFY `idLibro` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Clave primaria de la tabla', AUTO_INCREMENT=73;

ALTER TABLE `libros`
  ADD CONSTRAINT `libros_ibfk_1` FOREIGN KEY (`idAutor`) REFERENCES `autores` (`idAutor`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;
