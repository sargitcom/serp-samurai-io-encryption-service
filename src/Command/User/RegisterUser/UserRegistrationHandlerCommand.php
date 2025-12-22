<?php

namespace App\Command\User\RegisterUser;


use SerpSamuraiIo\MessageBus\EventBus;
use SerpSamuraiIo\MessageBus\Events\Auth\UserRegisteredEvent;
use App\Repository\UserOutboxRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Throwable;

#[AsCommand(name: 'app:register-user-handler')]
class UserRegistrationHandlerCommand
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
            $this->eventBus->listenEvent(function (UserRegisteredEvent $event) {
                var_dump($event);
            }, UserRegisteredEvent::class);

            return Command::SUCCESS;
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
            return Command::FAILURE;
        }
    }
}

