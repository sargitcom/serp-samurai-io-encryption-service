<?php

namespace App\Command\User\RegisterUser;

use App\Entity\User;
use App\Entity\UserOutbox;
use SerpSamuraiIo\MessageBus\EventBus;
use SerpSamuraiIo\MessageBus\Events\Auth\UserRegisteredEvent;
use App\Repository\UserOutboxRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Throwable;


#[AsCommand(name: 'app:register-user')]
class UserRegistrationCommand
{
    public function __construct(
        private LoggerInterface $logger,
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository,
        private UserOutboxRepository $outboxRepository,
        private EventBus $eventBus,
    ) {}

    public function __invoke(): int
    {
        try {
            $users = $this->outboxRepository->findAll();

            foreach ($users as $user) {
                $this->registerUser($user);
            }
            return Command::SUCCESS;
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
            return Command::FAILURE;
        }
    }

    private function registerUser(UserOutbox $userOutbox): void
    {
        try {
            $this->entityManager->beginTransaction();

            $userId = $userOutbox->getUserId();

            $user = $this->userRepository->getById($userId);

            if ($this->isUserExists($user) === false) {
                $this->outboxRepository->remove($userOutbox);
                $this->entityManager->commit();
                return;
            }

            $this->eventBus->sendEvent(new UserRegisteredEvent(
                $user->getId()->toString(),
                $user->getEmail(),
                $user->getPassword(),
            '1.0'
            ));

            $this->outboxRepository->remove($userOutbox);
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (Throwable $e) {
            $this->entityManager->rollback();
            $this->logger->error($e->getMessage());
        }
    }

    private function isUserExists(User|null $user): bool
    {
        return $user !== null;
    }
}
