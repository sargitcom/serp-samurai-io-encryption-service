<?php

namespace App\Controller\ResetPassword;

use App\Services\User\Password\IsPasswordComplexEnoughService;
use Symfony\Component\HttpFoundation\Request;

class ResetUserPasswordRequest
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function isValid(): bool
    {
        if ($this->getEmail() !== "") {return true;}
        return false;
    }

    public function getErrors(): array
    {
        $errors = [];

        if ($this->getEmail() === "") {
            $errors['email'] = "email_address_cannot_be_empty";
        }

        return $errors;
    }

    public function getEmail(): string
    {
        $req = json_decode($this->request->getContent(), true);
        return $req['email'] ?? '';
    }
}
