<?php

namespace App\Command\Encryption;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;

#[AsCommand(name: 'app:create-hex-encryption-key')]
class CreateHexEncryptionKeyCommand
{
    public function __invoke(): int
    {

        

        return Command::SUCCESS;
    }
}
