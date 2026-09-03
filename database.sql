
CREATE DATABASE IF NOT EXISTS `portafolio`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `portafolio`;


-- 1 Tabla users

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombreUser` VARCHAR(100) NOT NULL,
  `emailUser` VARCHAR(150) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `rol` VARCHAR(50) NOT NULL DEFAULT 'user',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 2 Tabla `materias`

DROP TABLE IF EXISTS `materias`;

CREATE TABLE `materias` (
  `MateriaId` INT AUTO_INCREMENT PRIMARY KEY,
  `NombreMateria` VARCHAR(150) NOT NULL,
  `Estado` VARCHAR(50) NOT NULL DEFAULT 'Cursando',
  `Anio` INT NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 3 Carga inicial de usuarios (Seeds)
-- usuario 'admin@portafolio.com
-- Clave en texto plano para ambos: 'password'


INSERT INTO `users` (`nombreUser`, `emailUser`, `password`, `rol`) VALUES
('Luciano Admin', 'admin@portafolio.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Alumno Invitado', 'alumno@portafolio.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');


-- 4 Carga inicial de materias (Seeds)

INSERT INTO `materias` (`NombreMateria`, `Estado`, `Anio`) VALUES
('Programación I', 'Aprobada', 1),
('Elementos de Programación', 'Regular', 1),
('Bases de Datos I', 'Cursando', 3),
('Redes ', 'Cursando', 2),
('Programacion orientada a objetos', 'Libre', 2);