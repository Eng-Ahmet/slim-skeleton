<?php

declare(strict_types=1);

namespace API\src\utilities\classes;

use Psr\Http\Message\ServerRequestInterface;

class Validation
{
    private array $errors = [];
    private array $data = [];

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function validate(array $rules): bool
    {
        foreach ($rules as $field => $fieldRules) {
            $value = $this->data[$field] ?? null;

            foreach ($fieldRules as $rule => $ruleValue) {
                if (is_int($rule)) {
                    $rule = $ruleValue;
                    $ruleValue = null;
                }

                $method = 'validate' . ucfirst($rule);
                if (method_exists($this, $method)) {
                    // Skip optional fields if not required
                    if ($rule !== 'required' && (!isset($this->data[$field]) || $this->data[$field] === '')) {
                        continue;
                    }

                    $this->$method($field, $value, $ruleValue);
                } else {
                    throw new \Exception("Unknown validation rule: '{$rule}'.");
                }
            }
        }

        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function failed(): bool
    {
        return !empty($this->errors);
    }

    public function getData(): array
    {
        return $this->data;
    }

    private function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    // === Rules ===
    private function validateRequired(string $field, $value): void
    {
        if (is_null($value) || trim((string)$value) === '') {
            $this->addError($field, "The '{$field}' field is required.");
        }
    }

    private function validateEmail(string $field, $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, "The '{$field}' field must be a valid email.");
        }
    }

    private function validateMin(string $field, $value, int $min): void
    {
        if (strlen((string)$value) < $min) {
            $this->addError($field, "The '{$field}' field must be at least {$min} characters.");
        }
    }

    private function validateMax(string $field, $value, int $max): void
    {
        if (strlen((string)$value) > $max) {
            $this->addError($field, "The '{$field}' field must not exceed {$max} characters.");
        }
    }

    private function validateNumeric(string $field, $value): void
    {
        if (!is_numeric($value)) {
            $this->addError($field, "The '{$field}' field must be numeric.");
        }
    }

    private function validateRegex(string $field, $value, string $pattern): void
    {
        if (!preg_match($pattern, (string)$value)) {
            $this->addError($field, "The '{$field}' field format is invalid.");
        }
    }

    private function validateConfirmed(string $field, $value): void
    {
        $confirmationField = $field . '_confirmation';
        if (!isset($this->data[$confirmationField]) || $value !== $this->data[$confirmationField]) {
            $this->addError($field, "The '{$field}' field must be confirmed.");
        }
    }

    private function validateIn(string $field, $value, array $allowed): void
    {
        if (!in_array($value, $allowed, true)) {
            $this->addError($field, "The '{$field}' field must be one of: " . implode(', ', $allowed) . '.');
        }
    }

    private function validateBoolean(string $field, $value): void
    {
        if (!in_array($value, [true, false, 0, 1, '0', '1',"true",], true)) {
            $this->addError($field, "The '{$field}' field must be boolean.");
        }
    }

    private function validateDate(string $field, $value): void
    {
        if (!strtotime($value)) {
            $this->addError($field, "The '{$field}' field must be a valid date.");
        }
    }

    private function validateDateFormat(string $field, $value, string $format): void
    {
        $dateTime = \DateTime::createFromFormat($format, $value);
        if (!$dateTime || $dateTime->format($format) !== $value) {
            $this->addError($field, "The '{$field}' field must be a valid date in the format '{$format}'.");
        }
    }

    private function validateUnique(string $field, $value, string $table): void
    {
        // Assuming you have a database connection and a method to check uniqueness
        // This is a placeholder implementation
        $exists = false; // Replace with actual database check

        if ($exists) {
            $this->addError($field, "The '{$field}' field must be unique in the '{$table}' table.");
        }
    }

    private function validateString(string $field, $value): void
    {
        if (!is_string($value)) {
            $this->addError($field, "The '{$field}' field must be a string.");
        }
    }

    private function validateInteger(string $field, $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            $this->addError($field, "The '{$field}' field must be an integer.");
        }
    }

    private function validateBetween(string $field, $value, array $range): void
    {
        $min = $range[0];
        $max = $range[1];
        if (!is_numeric($value) || $value < $min || $value > $max) {
            $this->addError($field, "The '{$field}' field must be between {$min} and {$max}.");
        }
    }
    private function validateNullable(string $field, $value): void
    {
        // This rule allows the field to be null or empty, so no action needed
        if ($value === null || $value === '') {
            return;
        }
        // If the field is not null or empty, you can apply other validations if needed
    }
    private function validateArray(string $field, $value): void
    {
        if (!is_array($value)) {
            $this->addError($field, "The '{$field}' field must be an array.");
        }
    }
    private function validateFile(string $field, $value): void
    {
        if (!is_array($value) || !isset($value['tmp_name']) || !file_exists($value['tmp_name'])) {
            $this->addError($field, "The '{$field}' field must be a valid file.");
        }
    }
    private function validateUrl(string $field, $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            $this->addError($field, "The '{$field}' field must be a valid URL.");
        }
    }
    private function validateIp(string $field, $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_IP)) {
            $this->addError($field, "The '{$field}' field must be a valid IP address.");
        }
    }
    private function validateJson(string $field, $value): void
    {
        json_decode($value);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->addError($field, "The '{$field}' field must be a valid JSON string.");
        }
    }
    private function validateUuid(string $field, $value): void
    {
        if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $value)) {
            $this->addError($field, "The '{$field}' field must be a valid UUID.");
        }
    }
}
