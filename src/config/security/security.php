<?php

declare(strict_types=1);

namespace API\src\config\security;


class Security
{
    // Enforce HTTPS
    public static function enforceHttps(): void
    {
        if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
            $redirectUrl = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            header('Location: ' . $redirectUrl);
            exit;
        }
    }
    // Sanitize Input
    public static function sanitizeInput(string $data): string
    {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    // Email Validation
    public static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    // Prepared Statements for SQL
    public static function prepareAndExecute(\PDO $pdo, string $query, array $params): \PDOStatement
    {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    // Escape SQL
    public static function escapeSQL(\PDO $pdo, string $data): string
    {
        return $pdo->quote($data);
    }

    // File Upload Validation
    public static function validateUploadedFile(array $file, array $allowedTypes): bool
    {
        $fileType = mime_content_type($file['tmp_name']);
        return in_array($fileType, $allowedTypes);
    }
}
