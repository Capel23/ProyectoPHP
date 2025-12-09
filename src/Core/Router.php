<?php
namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, callable $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $uri, string $method): void
    {
        // Normalizar URI
        $uri = rtrim($uri, '/');
        $uri = $uri === '' ? '/' : $uri;

        // Buscar ruta exacta
        if (isset($this->routes[$method][$uri])) {
            call_user_func($this->routes[$method][$uri]);
            return;
        }

        // Buscar rutas dinámicas (con parámetros)
        foreach ($this->routes[$method] as $route => $handler) {
            if (preg_match('#^' . preg_replace('/\{.*?\}/', '([^/]+)', $route) . '$#', $uri, $matches)) {
                array_shift($matches); // Eliminar coincidencia completa
                call_user_func_array($handler, $matches);
                return;
            }
        }

        // 404
        http_response_code(404);
        echo "<h1>404 - Página no encontrada</h1>";
        exit;
    }
}