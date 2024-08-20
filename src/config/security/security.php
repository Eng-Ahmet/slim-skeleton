<?php

declare(strict_types=1);

namespace API\src\config\security;

class Security
{
    public static function enforceHttps(): void
    {
        if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
            $redirectUrl = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            header('Location: ' . $redirectUrl);
            exit;
        }
    }

    public static function sanitizeInput(string $data): string
    {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    public static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }


    // Security Headers
    public static function setSecurityHeaders(): void
    {
        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: DENY");
        header("X-XSS-Protection: 1; mode=block");
        header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'");
    }

    // Secure Session Management
    public static function secureSessionStart(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            $sessionParams = [
                'httponly' => true,
                'secure' => true,
                'samesite' => 'Strict'
            ];
            session_start($sessionParams);
            session_regenerate_id(true);
        }
    }

    // Prepared Statements for SQL
    public static function prepareAndExecute(\PDO $pdo, string $query, array $params): \PDOStatement
    {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }


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
