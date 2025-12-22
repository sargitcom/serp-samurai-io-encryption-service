<?php

namespace App\Message\User;

use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage('async')]
class UserRegisteredEvent
{
    public function __construct(
        private string $userId,
        private string $email,
        private string $password,
    ) {}

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
