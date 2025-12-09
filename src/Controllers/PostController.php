<?php
namespace App\Controllers;

use App\Models\Post;
use App\Core\SessionManager;
use App\Utils\FileUploader;
use App\Utils\Validator;

class PostController
{
    public function index(): void
    {
        $posts = Post::all();
        $title = 'Blog';
        ob_start();
        include __DIR__ . '/../Views/home.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layouts/main.php';
    }

    public function show(string $slug): void
    {
        $post = Post::findBySlug($slug);
        if (!$post) {
            http_response_code(404);
            echo "<h1>404 - Post no encontrado</h1>";
            return;
        }

        $title = $post->getTitle();
        ob_start();
        include __DIR__ . '/../Views/posts/show.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layouts/main.php';
    }

    public function adminIndex(): void
    {
        if (!SessionManager::isLoggedIn()) {
            $_SESSION['error'] = 'Acceso denegado. Debes iniciar sesión.';
            header('Location: /login');
            exit;
        }

        $posts = Post::all();
        $title = 'Administrar Posts';
        ob_start();
        include __DIR__ . '/../Views/posts/admin_index.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layouts/main.php';
    }

    public function create(): void
    {
        if (!SessionManager::isLoggedIn()) {
            $_SESSION['error'] = 'Acceso denegado. Debes iniciar sesión.';
            header('Location: /login');
            exit;
        }

        $title = 'Crear Post';
        ob_start();
        include __DIR__ . '/../Views/posts/create.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layouts/main.php';
    }

    public function store(): void
    {
        if (!SessionManager::isLoggedIn()) {
            http_response_code(403);
            echo "Acceso denegado";
            exit;
        }

        $title = Validator::sanitizeString($_POST['title'] ?? '');
        $content = Validator::sanitizeString($_POST['content'] ?? '');

        if (empty($title) || empty($content)) {
            $_SESSION['error'] = 'Título y contenido son obligatorios';
            header('Location: /admin/posts/create');
            exit;
        }

        $imagePath = null;
        if (!empty($_FILES['image']['name'])) {
            $imagePath = FileUploader::upload($_FILES['image']);
            if (!$imagePath) {
                $_SESSION['error'] = 'Error al subir la imagen (tipo, tamaño o nombre inválido)';
                header('Location: /admin/posts/create');
                exit;
            }
        }

        if (Post::create(SessionManager::getUserId(), $title, $content, $imagePath)) {
            $_SESSION['success'] = 'Post creado exitosamente';
            header('Location: /admin/posts');
        } else {
            $_SESSION['error'] = 'Error al crear el post';
            header('Location: /admin/posts/create');
        }
        exit;
    }

    public function edit(int $id): void
    {
        if (!SessionManager::isLoggedIn()) {
            $_SESSION['error'] = 'Acceso denegado. Debes iniciar sesión.';
            header('Location: /login');
            exit;
        }

        $post = Post::findById($id);
        if (!$post || $post->getUserId() !== SessionManager::getUserId()) {
            $_SESSION['error'] = 'Post no encontrado o acceso denegado';
            header('Location: /admin/posts');
            exit;
        }

        $title = 'Editar Post';
        ob_start();
        include __DIR__ . '/../Views/posts/edit.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layouts/main.php';
    }

    public function update(int $id): void
    {
        if (!SessionManager::isLoggedIn()) {
            http_response_code(403);
            echo "Acceso denegado";
            exit;
        }

        $title = Validator::sanitizeString($_POST['title'] ?? '');
        $content = Validator::sanitizeString($_POST['content'] ?? '');

        if (empty($title) || empty($content)) {
            $_SESSION['error'] = 'Título y contenido son obligatorios';
            header("Location: /admin/posts/$id/edit");
            exit;
        }

        $imagePath = null;
        if (!empty($_FILES['image']['name'])) {
            $imagePath = FileUploader::upload($_FILES['image']);
            if (!$imagePath) {
                $_SESSION['error'] = 'Error al subir la imagen';
                header("Location: /admin/posts/$id/edit");
                exit;
            }
        } else {
            // Conservar imagen actual
            $post = Post::findById($id);
            $imagePath = $post ? $post->getImagePath() : null;
        }

        if (Post::update($id, $title, $content, $imagePath)) {
            $_SESSION['success'] = 'Post actualizado';
            header('Location: /admin/posts');
        } else {
            $_SESSION['error'] = 'Error al actualizar';
            header("Location: /admin/posts/$id/edit");
        }
        exit;
    }

    public function delete(int $id): void
    {
        if (!SessionManager::isLoggedIn()) {
            http_response_code(403);
            echo "Acceso denegado";
            exit;
        }

        $post = Post::findById($id);
        if (!$post || $post->getUserId() !== SessionManager::getUserId()) {
            $_SESSION['error'] = 'Post no encontrado o acceso denegado';
            header('Location: /admin/posts');
            exit;
        }

        if (Post::delete($id)) {
            $_SESSION['success'] = 'Post eliminado';
        } else {
            $_SESSION['error'] = 'Error al eliminar';
        }
        header('Location: /admin/posts');
        exit;
    }
}