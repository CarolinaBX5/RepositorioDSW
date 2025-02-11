CREATE DATABASE IF NOT EXISTS `libros`;
USE `libros`;

CREATE TABLE IF NOT EXISTS `usuarios` (
    `id_usuario` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `usuario` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS `libros` (
    `id_libro` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(255) NOT NULL,
    `descripcion` TEXT,
    `precio` DECIMAL(10,2) NOT NULL
);

CREATE TABLE IF NOT EXISTS `votos` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `id_libro` INT(11) NOT NULL,
    `id_usuario` INT(11) NOT NULL,
    `valoracion` INT(1) NOT NULL CHECK (`valoracion` BETWEEN 1 AND 5),
    FOREIGN KEY (`id_libro`) REFERENCES `libros`(`id_libro`) ON DELETE CASCADE,
    FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id_usuario`) ON DELETE CASCADE
);

INSERT INTO `usuarios` (`usuario`, `password`, `email`) VALUES
('carolina', 'carolina', 'carolinabetancor55@gmail.com'),
('admin', 'admin', 'admin@gmail.com');

INSERT INTO `libros` (`nombre`, `descripcion`, `precio`) VALUES
('El Camino de los Reyes', 'Primer libro de la saga El Archivo de las Tormentas, de Brandon Sanderson.', 25.99),
('Palabras Radiantes', 'Segundo libro de la saga El Archivo de las Tormentas, de Brandon Sanderson.', 27.50),
('Mort', 'Cuarto libro de la saga Mundodisco, centrado en la Muerte, de Terry Pratchett.', 15.75),
('Guardias! ¡Guardias!', 'Octavo libro de Mundodisco, inicio de la serie de la Guardia de Ankh-Morpork.', 14.99),
('Juego de Tronos', 'Primer libro de la saga Canción de Hielo y Fuego, de George R.R. Martin.', 22.95),
('Choque de Reyes', 'Segundo libro de la saga Canción de Hielo y Fuego, de George R.R. Martin.', 23.50);
