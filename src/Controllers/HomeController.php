<?php
namespace App\Controllers;

use App\Models\Post;
use App\Core\SessionManager;

class HomeController
{
    public function index(): void
    {
        $posts = Post::all();
        $title = 'Inicio';
        ob_start();
        include __DIR__ . '/../Views/home.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layouts/main.php';
    }
}