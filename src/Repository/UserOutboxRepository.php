<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserOutbox;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserOutboxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserOutbox::class);
    }

    public function persist(UserOutbox $userOutbox): void
    {
        $em = $this->getEntityManager();
        $em->persist($userOutbox);
    }

    public function remove(UserOutbox $userOutbox): void
    {
        $em = $this->getEntityManager();
        $em->remove($userOutbox);
    }
}
