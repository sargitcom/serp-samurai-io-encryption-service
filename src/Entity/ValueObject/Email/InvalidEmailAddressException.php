<?php

namespace App\Entity\ValueObject\Email;

use InvalidArgumentException;

class InvalidEmailAddressException extends InvalidArgumentException
{
    public function __construct(string $email)
    {
        parent::__construct("Invalid email address '{$email}'");
    }
}
