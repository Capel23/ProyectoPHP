-- --------------------------------------------------------
-- Base de datos: `blog_cms`
-- --------------------------------------------------------
CREATE DATABASE IF NOT EXISTS `blog_cms` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `blog_cms`;

-- --------------------------------------------------------
-- Tabla `users`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL UNIQUE,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Tabla `posts`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL UNIQUE,
  `content` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `published_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Datos de ejemplo
-- --------------------------------------------------------
INSERT INTO `users` (`username`, `email`, `password`) VALUES
-- Contraseñas: admin123, usuario123 (hasheadas con password_hash)
('admin', 'admin@example.com', 'admin123'),
('usuario', 'user@example.com', 'usuario123');

