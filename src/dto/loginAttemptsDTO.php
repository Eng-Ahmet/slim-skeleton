<?php

declare(strict_types=1);

namespace API\src\dto;

use InvalidArgumentException;

final class LoginAttemptsDTO
{
    private ?int $userId;
    private string $emailEntered;
    private string $ipAddress;
    private ?string $userAgent;
    private string $status;
    private ?string $errorMessage;

    public function __construct(array $data)
    {
        $this->userId = isset($data['user_id']) ? filter_var($data['user_id'], FILTER_VALIDATE_INT) : null;
        $this->emailEntered = filter_var($data['email_entered'], FILTER_UNSAFE_RAW) ?: throw new InvalidArgumentException("Username is required.");
        $this->ipAddress = filter_var($data['ip_address'], FILTER_UNSAFE_RAW) ?: throw new InvalidArgumentException("IP address is required.");
        $this->userAgent = filter_var($data['user_agent'], FILTER_UNSAFE_RAW) ?? null;
        $this->status = filter_var($data['status'], FILTER_UNSAFE_RAW) ?: 'failure';
        $this->errorMessage = filter_var($data['error_message'], FILTER_UNSAFE_RAW) ?? null;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getEmailEntered(): string
    {
        return $this->emailEntered;
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }


}
