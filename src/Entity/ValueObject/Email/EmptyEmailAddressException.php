<?php

namespace App\Entity\ValueObject\Email;

use InvalidArgumentException;

class EmptyEmailAddressException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct("Email address should not be empty");
    }
}
