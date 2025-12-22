<?php

namespace App\Entity;

use App\Repository\UserOutboxRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserOutboxRepository::class)]
#[ORM\Table(name: '`user_outbox`')]
class UserOutbox
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private Uuid $userId;

    public function __construct(Uuid $id, Uuid $userId)
    {
        $this->id = $id;
        $this->userId = $userId;
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getUserId(): Uuid
    {
        return $this->userId;
    }
}
