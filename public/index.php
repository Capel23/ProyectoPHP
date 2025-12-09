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

// Cargar funciones auxiliares
require_once __DIR__ . '/../src/helpers.php';

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\PostController;
use App\Controllers\AuthController;

// Auto-login con cookie
if (!\App\Core\SessionManager::isLoggedIn() && isset($_COOKIE['remember_token'])) {
    $tokenParts = explode(':', $_COOKIE['remember_token']);
    if (count($tokenParts) === 2) {
        list($userId, $hash) = $tokenParts;
        $expectedHash = hash_hmac('sha256', $userId, 'secret_key_123');
        if (hash_equals($expectedHash, $hash)) {
            // Necesitamos el modelo User, ya autoloaded
            $user = \App\Models\User::findById((int)$userId);
            if ($user) {
                \App\Core\SessionManager::login($user->getId(), $user->getUsername());
            }
        }
    }
}

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

// Rutas protegidas (la autenticación se verifica en los controladores)
$router->get('/admin/posts', [PostController::class, 'adminIndex']);
$router->get('/admin/posts/create', [PostController::class, 'create']);
$router->post('/admin/posts', [PostController::class, 'store']);
$router->get('/admin/posts/{id}/edit', [PostController::class, 'edit']);
$router->post('/admin/posts/{id}', [PostController::class, 'update']);
$router->post('/admin/posts/{id}/delete', [PostController::class, 'delete']);

// Obtener URI y método
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Eliminar el path base si existe (/ProyectoPHP/public)
$basePath = '/ProyectoPHP/public';
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}
// Asegurar que siempre empiece con /
if (empty($uri)) {
    $uri = '/';
}

$method = $_SERVER['REQUEST_METHOD'];

// Ejecutar enrutador
$router->dispatch($uri, $method);
