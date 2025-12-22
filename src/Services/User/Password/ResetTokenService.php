<?php

namespace App\Services\User\Password;

use DateTime;

class ResetTokenService
{
    public static function getToken(string $seed): string
    {
        $token = md5($seed . (new DateTime())->format('Y-m-d H:i:s'));
        $token .= sha1($seed . (new DateTime())->format('Y-m-d H:i:s'));
        return sha1($token);
    }
}
