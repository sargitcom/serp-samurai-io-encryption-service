<?php

namespace App\Controller\RegisterUser;

use App\Services\User\Password\IsPasswordComplexEnoughService;
use Symfony\Component\HttpFoundation\Request;

class RegisterUserRequest
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function isValid(): bool
    {
        if (
            $this->getEmail() !== "" &&
            $this->getPassword() !== "" &&
            IsPasswordComplexEnoughService::isComplexEnough($this->getPassword())
        ) {
            return true;
        }

        return false;
    }

    public function getErrors(): array
    {
        $errors = [];

        if ($this->getEmail() === "") {
            $errors['email'] = "invalid_email_address";
        }

        if ($this->getPassword() === "") {
            $errors['password'] = "invalid_password";
        }

        if (IsPasswordComplexEnoughService::isComplexEnough($this->getPassword()) === false) {
            $errors['password'] = "password_not_complex_enough";
        }

        return $errors;
    }

    public function getEmail(): string
    {
        $req = json_decode($this->request->getContent(), true);
        return $req['email'] ?? '';
    }

    public function getPassword(): string
    {
        $req = json_decode($this->request->getContent(), true);
        return $req['password'] ?? '';
    }
}
