<?php

namespace App\Entity;

use App\Repository\UserPasswordResetTokenRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserPasswordResetTokenRepository::class)]
#[ORM\Table(name: '`user_password_reset_token`')]
class UserPasswordResetToken
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    #[ORM\Column(type: UuidType::NAME, unique: false)]
    private Uuid $userId;

    #[ORM\Column]
    private string $token;

    #[ORM\Column]
    private DateTime $tokenValidTo;

    public function __construct(Uuid $id, Uuid $userId, string $token, DateTime $tokenValidTo)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->token = $token;
        $this->tokenValidTo = $tokenValidTo;
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getUserId(): Uuid
    {
        return $this->userId;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getTokenValidTo(): string
    {
        return $this->tokenValidTo->format('Y-m-d H:i:s');
    }
}
