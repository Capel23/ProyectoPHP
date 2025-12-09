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
-- Contraseñas: admin123, user123 (hasheadas con password_hash)
('admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('user', 'user@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO `posts` (`user_id`, `title`, `slug`, `content`, `image_path`) VALUES
(1, 'Bienvenido al Blog', 'bienvenido-al-blog', 'Este es el primer post de ejemplo. ¡Gracias por visitarnos!\n\nPuedes editar o eliminar este post desde el panel de administración.', NULL),
(1, 'Cómo Funciona el CMS', 'como-funciona-el-cms', 'Este CMS está construido en PHP puro con los siguientes principios:\n\n- Enrutamiento limpio con URLs amigables\n- Programación Orientada a Objetos (POO)\n- Seguridad: password_hash, prepared statements, saneamiento\n- Subida segura de imágenes\n\n¡Esperamos que te sirva como base para tus proyectos!', NULL),
(2, 'Mi Primer Post', 'mi-primer-post', 'Hola mundo 👋\n\nEste post fue creado por un usuario registrado. El sistema permite múltiples autores y gestión completa de contenido.\n\n#PHP #Blog #CMS', NULL);