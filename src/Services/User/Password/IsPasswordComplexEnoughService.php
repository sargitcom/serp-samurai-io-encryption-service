<?php

namespace App\Services\User\Password;

class IsPasswordComplexEnoughService
{
    public static function isComplexEnough(string $password): bool
    {
        if (mb_strlen($password) < 8) {
            return false;
        }

        return true;
    }
}
