<?php

namespace App\Entity\ValueObject\Password;

use InvalidArgumentException;

class EmptyPasswordException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct("Password should not be empty");
    }
}
