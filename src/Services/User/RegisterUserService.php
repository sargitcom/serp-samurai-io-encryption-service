<?php

namespace App\Services\User;

use App\Controller\RegisterUser\RegisterUserRequest;
use App\Controller\RegisterUser\RegisterUserResponse;
use App\Entity\User;
use App\Entity\UserOutbox;
use App\Entity\ValueObject\Email;
use App\Entity\ValueObject\Password;
use App\Repository\UserOutboxRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;
use Throwable;

class RegisterUserService
{
    public function __construct(
        private LoggerInterface $logger,
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository,
        private UserOutboxRepository $userOutboxRepository,
        private UserPasswordHasherInterface $userPasswordHasher,
    ) {}

    public function registerUser(RegisterUserRequest $request): RegisterUserResponse
    {
        try {
            if ($request->isValid() === false) {
                return RegisterUserResponse::createFromError(
                    $request->getErrors(),
                    400
                );
            }
            $user = $this->userRepository->getByEmail($request->getEmail());

            if ($this->isUserExists($user)) {return RegisterUserResponse::createUserExists();}

            $this->persistUser($request);

            return RegisterUserResponse::createFromSuccess();
        } catch (Throwable $e) {
             $this->logger->error($e->getMessage());
            return RegisterUserResponse::createFromUnknownError();
        }
    }

    private function isUserExists(User|null $user): bool
    {
        return $user !== null;
    }

    private function persistUser(RegisterUserRequest $request): void
    {
        $this->entityManager->beginTransaction();

        try {
            $user = $this->createUser($request);
            $userOutbox = $this->createUserOutbox($user);

            $this->userRepository->persist($user);
            $this->userOutboxRepository->persist($userOutbox);

            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (Throwable $e) {
            $this->entityManager->rollback();
            throw new RuntimeException($e->getMessage());
        }
    }

    private function createUser(RegisterUserRequest $request): User
    {
        $userId = Uuid::v4();
        $email = new Email($request->getEmail());
        $password = new Password($request->getPassword());

        $user = new User(
            $userId,
            $email,
            $password,
        );

        $user->setPassword(new Password($this->userPasswordHasher->hashPassword($user, $request->getPassword())));

        return $user;
    }

    private function createUserOutbox(User $user): UserOutbox
    {
        $outboxId = Uuid::v4();
        return new UserOutbox($outboxId, $user->getId());
    }
}
