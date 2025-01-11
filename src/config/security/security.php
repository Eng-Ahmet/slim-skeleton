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
    public static function sanitizeInput($data)
    {
        // إذا كان المدخل نصًا، نظفه
        if (is_string($data)) {
            return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        }

        // إذا كان المدخل عددًا صحيحًا، تحويله إلى نص
        if (is_int($data)) {
            return (string)$data;
        }

        // إذا كان المدخل عددًا عائمًا، تحويله إلى نص
        if (is_float($data)) {
            return (string)$data;
        }

        // إذا كان المدخل بوليانيًا، إرجاعه كـ نص
        if (is_bool($data)) {
            return $data ? 'true' : 'false';
        }

        // إذا كان المدخل JSON، محاولة فك تشفيره
        if (is_string($data) && self::isJson($data)) {
            $decoded = json_decode($data, true);
            return json_encode($decoded, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        // إذا كان المدخل ملفًا، يمكنك اتخاذ إجراء مناسب (مثل التحقق من نوع الملف)
        if (is_array($data) && isset($data['tmp_name'])) {
            // تنفيذ أي معالجة خاصة بالملفات حسب الحاجة، مثل التحقق من نوع الملف أو مسار التخزين
            return $data; // أو أي معالجة أخرى ترغب في إجرائها
        }

        // إذا كان المدخل نوع آخر، إرجاع نص فارغ
        return '';
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

    // دالة لمساعدتك في التحقق مما إذا كان النص هو JSON صالح
    private static function isJson($string): bool
    {
        json_decode($string);
        return (json_last_error() === JSON_ERROR_NONE);
    }
}
