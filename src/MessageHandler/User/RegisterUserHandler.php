<?php

namespace App\MessageHandler\User;

use App\Message\User\UserRegisteredEvent;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RegisterUserHandler
{
    public function __invoke(
        UserRegisteredEvent $message,
    ) {
        var_dump($message);
    }
}
