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

-- Usuarios con contraseñas hasheadas (admin123 y usuario123)
INSERT INTO `users` (`username`, `email`, `password`) VALUES
('admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('usuario', 'user@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Posts de ejemplo
INSERT INTO `posts` (`user_id`, `title`, `slug`, `content`, `image_path`) VALUES
(1, 'Bienvenido a mi Blog CMS', 'bienvenido-a-mi-blog-cms', 
'¡Hola! Bienvenido a mi Blog CMS
Este es un proyecto de Blog CMS desarrollado con PHP utilizando conceptos de programación orientada a objetos, routing, autenticación con sesiones y mucho más.
Características principales:
Sistema de autenticación seguro
Gestión de posts con CRUD completo
URLs amigables con routing personalizado
Subida de imágenes
Panel de administración
Siéntete libre de explorar y crear tus propios artículos.', NULL),

(1, 'Aprendiendo PHP y MySQL', 'aprendiendo-php-mysql',
'Desarrollo Web con PHP y MySQL
PHP es un lenguaje de programación del lado del servidor muy popular para el desarrollo web. Combinado con MySQL, puedes crear aplicaciones web dinámicas y poderosas.
¿Por qué aprender PHP?
Es fácil de aprender para principiantes
Tiene una gran comunidad
Es usado por millones de sitios web
Se integra perfectamente con MySQL
Este blog es un ejemplo práctico de lo que puedes crear con PHP.', NULL),

(2, 'Mi primer post', 'mi-primer-post',
'¡Hola mundo!
Este es mi primer post en este increíble CMS. Estoy aprendiendo sobre desarrollo web y me encanta poder crear contenido de esta manera.
Las posibilidades son infinitas cuando aprendes a programar. ¡Sigamos adelante!', NULL);

