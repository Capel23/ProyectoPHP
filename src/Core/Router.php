<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    // Registrar rutas GET
    public function get(string $path, $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    // Registrar rutas POST
    public function post(string $path, $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    // Ejecutar el handler correspondiente según la URI y método
    public function dispatch(string $uri, string $method): void
    {
        // Normalizar URI
        $uri = rtrim($uri, '/');
        $uri = $uri === '' ? '/' : $uri;

        // 1️⃣ RUTA EXACTA
        if (isset($this->routes[$method][$uri])) {
            $handler = $this->routes[$method][$uri];
            $this->executeHandler($handler); // ✅ sin return
            return;
        }

        // 2️⃣ RUTAS DINÁMICAS CON PARÁMETROS
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $route => $handler) {
                $regex = '#^' . preg_replace('/\{[^}]+\}/', '([^/]+)', $route) . '$#';

                if (preg_match($regex, $uri, $matches)) {
                    array_shift($matches); // quitar coincidencia completa
                    $this->executeHandler($handler, $matches); // ✅ sin return
                    return;
                }
            }
        }

        // 404
        http_response_code(404);
        echo "<h1>404 - Página no encontrada</h1>";
    }

    /**
     * Ejecuta un handler que puede ser:
     *  - función simple
     *  - array [ControllerClass::class, 'method']
     */
    private function executeHandler($handler, array $params = []): void
    {
        // Si es un controlador [Controller::class, 'method']
        if (is_array($handler) && count($handler) === 2) {
            $controller = new $handler[0]();  // instanciar controlador
            $method = $handler[1];
            call_user_func_array([$controller, $method], $params);
            return;
        }

        // Si es una función simple
        call_user_func_array($handler, $params);
    }
}
