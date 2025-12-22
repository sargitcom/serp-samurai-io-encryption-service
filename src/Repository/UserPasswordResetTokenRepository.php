<?php

namespace App\Repository;

use App\Entity\UserPasswordResetToken;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class UserPasswordResetTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserPasswordResetToken::class);
    }

    public function createToken(Uuid $userId, string $token, DateTime $tokenValidTo): void
    {
        $this->getEntityManager()->persist(new UserPasswordResetToken(Uuid::v4(), $userId, $token, $tokenValidTo));
    }

    public function getToken(Uuid $id): ?UserPasswordResetToken
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
