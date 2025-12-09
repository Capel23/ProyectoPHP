<?php
namespace App\Utils;

class Validator
{
    public static function sanitizeString(string $input): string
    {
        return trim(htmlspecialchars($input, ENT_QUOTES, 'UTF-8'));
    }

    public static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validateLength(string $input, int $min, int $max): bool
    {
        $len = strlen($input);
        return $len >= $min && $len <= $max;
    }
}