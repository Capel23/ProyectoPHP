<?php

namespace App\Controllers;

use App\Models\Post;

class HomeController
{
    public function index(): void
    {
        $posts = Post::all();
        $title = 'BlogCap';
        ob_start();
        include __DIR__ . '/../Views/home.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layouts/main.php';
    }
}
