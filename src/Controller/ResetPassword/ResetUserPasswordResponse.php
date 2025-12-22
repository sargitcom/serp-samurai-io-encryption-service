<?php

namespace App\Controller\ResetPassword;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResetUserPasswordResponse extends JsonResponse
{
    public static function createFromError(array $errors, int $statusCode): self
    {
        return new self(
            $errors,
            $statusCode,
        );
    }

    public static function createFromEmptyEmailError(): self
    {
        return new self(
            ['msg' => 'user_does_not_exist'],
            REsponse::HTTP_BAD_REQUEST,
        );
    }

    public static function createFromUserDoesNotExistError(): self
    {
        return new self(
            ['msg' => 'user_does_not_exist'],
            REsponse::HTTP_BAD_REQUEST,
        );
    }

    public static function createFromUnknownError(): self
    {
        return new self(
            ['msg' => 'unknown_error'],
            500,
        );
    }

    public static function createFromSuccess(): self
    {
        return new self(
            ['msg' => 'user_password_reset_done'],
            Response::HTTP_OK
        );
    }
}

