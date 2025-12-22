<?php

namespace App\Entity\ValueObject\Password;

use InvalidArgumentException;

class InvalidPasswordException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct("Invalid password");
    }
}
