<?php

namespace App\Entity\ValueObject;

use App\Entity\ValueObject\Exceptions\Password\EmptyPasswordException;
use App\Entity\ValueObject\Exceptions\Password\InvalidPasswordException;
use App\Services\User\Password\IsPasswordComplexEnoughService;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Password
{
    #[ORM\Column(type: "string")]
    private string $password;

    public function __construct(string $password)
    {
        $this->assertValidPassword($password);
        $this->setPassword($password);
    }

    public static function create(string $password): self
    {
        return new self($password);
    }

    public function assertValidPassword(string $password): void
    {
        if ($password !== "" && $this->isComplexEnough($password)) {
            return;
        }

        if ($password === "") {throw new EmptyPasswordException();}

        throw new InvalidPasswordException();
    }

    private function isComplexEnough(string $password): bool
    {
        return IsPasswordComplexEnoughService::isComplexEnough($password);
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function get(): string
    {
        return $this->password;
    }
}
