<?php
namespace App\Utils;

class FileUploader
{
    private const ALLOWED_MIME = ['image/jpeg', 'image/png', 'image/gif'];
    private const MAX_SIZE = 5 * 1024 * 1024; // 5MB
    private const UPLOAD_DIR = __DIR__ . '/../../public/uploads/';

    public static function upload(array $file): ?string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // Validar tamaño
        if ($file['size'] > self::MAX_SIZE) {
            return null;
        }

        // Validar tipo MIME real
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        if (!in_array($mime, self::ALLOWED_MIME)) {
            return null;
        }

        // Sanitizar nombre del archivo
        $originalName = pathinfo($file['name'], PATHINFO_FILENAME);
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $safeName = preg_replace('/[^a-zA-Z0-9\-]/', '', $originalName) . '-' . uniqid() . '.' . strtolower($extension);

        $target = self::UPLOAD_DIR . $safeName;

        if (move_uploaded_file($file['tmp_name'], $target)) {
            return url('/uploads/' . $safeName);
        }

        return null;
    }
}