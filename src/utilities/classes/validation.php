<?php

declare(strict_types=1);

namespace API\src\utilities\classes;

use Psr\Http\Message\ServerRequestInterface;

class Validation
{
    private array $errors = [];
    private array $data = [];

    public function __construct(ServerRequestInterface $request)
    {
        $this->data = $request->getParsedBody() ?? [];
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

    private function validateEnum(string $field, $value, array $allowed): void
    {
        $this->validateIn($field, $value, $allowed);
    }

    private function validateBoolean(string $field, $value): void
    {
        if (!in_array($value, [true, false, 0, 1, '0', '1'], true)) {
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
        // Placeholder: replace this with actual DB query
        $exists = false;

        if ($exists) {
            $this->addError($field, "The '{$field}' field must be unique in the '{$table}' table.");
        }
    }

    private function validateType(string $field, $value, string $type): void
    {
        switch (strtolower($type)) {
            case 'int':
            case 'integer':
                if (filter_var($value, FILTER_VALIDATE_INT) === false) {
                    $this->addError($field, "The '{$field}' field must be an integer.");
                }
                break;

            case 'float':
            case 'double':
                if (filter_var($value, FILTER_VALIDATE_FLOAT) === false) {
                    $this->addError($field, "The '{$field}' field must be a float.");
                }
                break;

            case 'bool':
            case 'boolean':
                if (!in_array($value, [true, false, 0, 1, '0', '1'], true)) {
                    $this->addError($field, "The '{$field}' field must be boolean.");
                }
                break;

            case 'string':
            case 'text':
                if (!is_string($value)) {
                    $this->addError($field, "The '{$field}' field must be a string.");
                }
                break;

            case 'array':
                if (!is_array($value)) {
                    $this->addError($field, "The '{$field}' field must be an array.");
                }
                break;

            default:
                $this->addError($field, "Invalid type specified for '{$field}': '{$type}'.");
        }
    }
}
