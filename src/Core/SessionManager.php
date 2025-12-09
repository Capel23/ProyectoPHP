<?php
namespace App\Core;

class SessionManager
{
    public static function login(int $userId, string $username): void
    {
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['logged_in'] = true;
        session_regenerate_id(true); // Prevenir fijación de sesión
    }

    public static function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    public static function getUserId(): ?int
    {
        return self::isLoggedIn() ? (int)($_SESSION['user_id'] ?? null) : null;
    }
}