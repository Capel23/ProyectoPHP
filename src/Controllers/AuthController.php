<?php
namespace App\Controllers;

use App\Models\User;
use App\Core\SessionManager;
use App\Utils\Validator;

class AuthController
{
    public function showLogin(): void
    {
        $title = 'Iniciar Sesión';
        ob_start();
        include __DIR__ . '/../Views/auth/login.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layouts/main.php';
    }

    public function login(): void
    {
        $username = Validator::sanitizeString($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $_SESSION['error'] = 'Usuario y contraseña requeridos';
            header('Location: ' . url('/login'));
            exit;
        }

        $user = User::findByUsername($username);
        if ($user && $user->verifyPassword($password)) {
            SessionManager::login($user->getId(), $user->getUsername());
            header('Location: ' . url('/admin/posts'));
            exit;
        } else {
            $_SESSION['error'] = 'Credenciales incorrectas';
            header('Location: ' . url('/login'));
            exit;
        }
    }

    public function showRegister(): void
    {
        $title = 'Registrarse';
        ob_start();
        include __DIR__ . '/../Views/auth/register.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layouts/main.php';
    }

    public function register(): void
    {
        $username = Validator::sanitizeString($_POST['username'] ?? '');
        $email = Validator::sanitizeString($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';

        if (empty($username) || empty($email) || empty($password)) {
            $_SESSION['error'] = 'Todos los campos son obligatorios';
            header('Location: ' . url('/register'));
            exit;
        }

        if (!Validator::validateEmail($email)) {
            $_SESSION['error'] = 'Email inválido';
            header('Location: ' . url('/register'));
            exit;
        }

        if ($password !== $password2) {
            $_SESSION['error'] = 'Las contraseñas no coinciden';
            header('Location: ' . url('/register'));
            exit;
        }

        if (!Validator::validateLength($password, 6, 100)) {
            $_SESSION['error'] = 'La contraseña debe tener al menos 6 caracteres';
            header('Location: ' . url('/register'));
            exit;
        }

        if (User::create($username, $email, $password)) {
            $_SESSION['success'] = 'Registro exitoso. Ahora inicia sesión.';
            header('Location: ' . url('/login'));
        } else {
            $_SESSION['error'] = 'Error al registrar. ¿Ya existe el usuario o email?';
            header('Location: ' . url('/register'));
        }
        exit;
    }

    public function logout(): void
    {
        SessionManager::logout();
        header('Location: ' . url('/'));
        exit;
    }
}
