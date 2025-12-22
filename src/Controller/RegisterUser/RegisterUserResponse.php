<?php

namespace App\Controller\RegisterUser;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RegisterUserResponse extends JsonResponse
{
    public static function createFromError(array $errors, int $statusCode): self
    {
        return new self(
            $errors,
            $statusCode,
        );
    }

    public static function createFromUnknownError(): self
    {
        return new self(
            ['msg' => 'unknown_error'],
            500,
        );
    }

    public static function createUserExists(): self
    {
        return new self(
            ['msg' => 'user_already_registered'],
            Response::HTTP_BAD_REQUEST
        );
    }

    public static function createFromSuccess(): self
    {
        return new self(
            ['msg' => 'user_registered'],
            Response::HTTP_OK
        );
    }
}

