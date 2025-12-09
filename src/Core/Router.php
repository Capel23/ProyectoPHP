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
      
        $uri = rtrim($uri, '/');
        $uri = $uri === '' ? '/' : $uri;

        // 1️⃣ RUTA EXACTA
        if (isset($this->routes[$method][$uri])) {
            $handler = $this->routes[$method][$uri];
            $this->executeHandler($handler); // 
            return;
        }

        // 2️⃣ RUTAS DINÁMICAS CON PARÁMETROS
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $route => $handler) {
                $regex = '#^' . preg_replace('/\{[^}]+\}/', '([^/]+)', $route) . '$#';

                if (preg_match($regex, $uri, $matches)) {
                    array_shift($matches); 
                    $this->executeHandler($handler, $matches);
                    return;
                }
            }
        }

     
        http_response_code(404);
        echo "<h1>404 - Página no encontrada</h1>";
    }

 
    private function executeHandler($handler, array $params = []): void
    {
        
        if (is_array($handler) && count($handler) === 2) {
            $controller = new $handler[0]();  
            $method = $handler[1];
            call_user_func_array([$controller, $method], $params);
            return;
        }

      
        call_user_func_array($handler, $params);
    }
}
