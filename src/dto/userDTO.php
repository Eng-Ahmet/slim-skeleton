<?php

declare(strict_types=1);

namespace API\src\dto;

use InvalidArgumentException;

final class UserDTO
{
    private ?int $id;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $phone;
    private int $age;
    private string $gender;
    private string $password;
    // Default values
    private string $userType = "Student"; // Default user type
    private string $status = "Active"; // Default status
    private string $account_type = 'Normal'; // Default account type
    private bool $isVerified = true; // Default verification status
    // Optional fields
    private ?string $confirmPassword;
    private ?bool $privacyPolicy;
    private ?string $countryCode;
    private ?string $countryName;


    public function __construct(array $data)
    {
        $this->id = isset($data['id']) ? filter_var($data['id'], FILTER_VALIDATE_INT) : null;
        $this->firstName = filter_var($data['first_name'], FILTER_UNSAFE_RAW);
        $this->lastName = filter_var($data['last_name'], FILTER_UNSAFE_RAW);
        $this->email = filter_var($data['email'], FILTER_VALIDATE_EMAIL) ?: throw new InvalidArgumentException("Invalid email format.");
        $this->phone = filter_var($data['phone'], FILTER_UNSAFE_RAW);
        $this->age = filter_var($data['age'], FILTER_VALIDATE_INT) ?: throw new InvalidArgumentException("Invalid age.");
        $this->gender = filter_var($data['gender'] ?? 'Other', FILTER_UNSAFE_RAW) ?: throw new InvalidArgumentException;
        $this->privacyPolicy = filter_var($data['privacy_policy'], FILTER_VALIDATE_BOOLEAN) ?? null;
        $this->countryCode = filter_var($data['country_code'], FILTER_UNSAFE_RAW) ?? null;
        $this->countryName = filter_var($data['country_name'], FILTER_UNSAFE_RAW) ?? null;
        $this->password = filter_var($data['password'], FILTER_UNSAFE_RAW) ?: throw new InvalidArgumentException("Invalid password.");
        $this->confirmPassword = filter_var($data['confirm_password'], FILTER_UNSAFE_RAW) ?? null;
        $this->userType = filter_var($data['user_type'], FILTER_UNSAFE_RAW) ?? "Student";

        if ($this->password != $this->confirmPassword && $this->confirmPassword != null) {
            throw new InvalidArgumentException("Passwords do not match.");
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }
    public function getLastName(): string
    {
        return $this->lastName;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getPhone(): string
    {
        return $this->phone;
    }
    public function getAge(): int
    {
        return $this->age;
    }
    public function getGender(): string
    {
        return $this->gender;
    }
    public function getPrivacyPolicy(): ?bool
    {
        return $this->privacyPolicy;
    }
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }
    public function getCountryName(): ?string
    {
        return $this->countryName;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }
    public function getUserType(): string
    {
        return $this->userType;
    }
    public function getStatus(): string
    {
        return $this->status;
    }
    public function getAccountType(): string
    {
        return $this->account_type;
    }
    public function getisVerified(): bool
    {
        return $this->isVerified;
    }
}
