<?php
// src/helpers.php
// Funciones auxiliares globales

/**
 * Genera una URL completa con el path base del proyecto
 * 
 * @param string $path Ruta relativa (ej: '/login', '/blog/post1')
 * @return string URL completa con el base path
 */
function url(string $path): string
{
    // Define el base path de tu proyecto
    $basePath = '/ProyectoPHP/public';
    
    // Asegurar que el path empiece con /
    $path = '/' . ltrim($path, '/');
    
    // Si el path es solo '/', no duplicar
    if ($path === '/' && $basePath !== '') {
        return $basePath;
    }
    
    return $basePath . $path;
}

/**
 * Redirecciona a una URL
 * 
 * @param string $path Ruta a la que redirigir
 */
function redirect(string $path): void
{
    header('Location: ' . url($path));
    exit;
}
