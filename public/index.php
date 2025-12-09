<?php
// public/index.php

// Iniciar sesión
session_start();

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    if (strpos($class, $prefix) !== 0) return;

    $relative_class = substr($class, strlen($prefix));
    $file = __DIR__ . '/../src/' . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\PostController;
use App\Controllers\AuthController;

$router = new Router();

// Rutas públicas
$router->get('/', [HomeController::class, 'index']);
$router->get('/blog/{slug}', [PostController::class, 'show']);

// Rutas de autenticación
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);

// Rutas protegidas
if (\App\Core\SessionManager::isLoggedIn()) {
    $router->get('/admin/posts', [PostController::class, 'adminIndex']);
    $router->get('/admin/posts/create', [PostController::class, 'create']);
    $router->post('/admin/posts', [PostController::class, 'store']);
    $router->get('/admin/posts/{id}/edit', [PostController::class, 'edit']);
    $router->post('/admin/posts/{id}', [PostController::class, 'update']);
    $router->post('/admin/posts/{id}/delete', [PostController::class, 'delete']);
}

// Obtener URI y método
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Ejecutar enrutador
$router->dispatch($uri, $method);