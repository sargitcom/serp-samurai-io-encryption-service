<?php

namespace App\Services\User;

use App\Controller\ResetPassword\ResetUserPasswordRequest;
use App\Controller\ResetPassword\ResetUserPasswordResponse;
use App\Repository\UserPasswordResetTokenRepository;
use App\Repository\UserRepository;
use App\Services\Email\EmailService;
use App\Services\User\Password\ResetTokenService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;
use Throwable;

class ResetUserPasswordService
{
    public function __construct(
        private LoggerInterface $logger,
        private EmailService $emailService,
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository,
        private UserPasswordResetTokenRepository $userPasswordResetTokenRepository
    ) {}

    public function resetUserPassword(ResetUserPasswordRequest $request): ResetUserPasswordResponse
    {
        $this->entityManager->beginTransaction();

        try {
            if (!$request->isValid()) {
                return ResetUserPasswordResponse::createFromEmptyEmailError();
            }

            $userEmail = $request->getEmail();
            $user = $this->userRepository->findOneBy(['email.email' => $userEmail]);
            if ($user === null) {
                return ResetUserPasswordResponse::createFromUserDoesNotExistError();
            }


            $token = ResetTokenService::getToken($request->getEmail());
            $currentDateTime = (new \DateTime())->add(new \DateInterval('P15M'));
            $this->userPasswordResetTokenRepository->createToken($user->getId(), $token, $currentDateTime);

            $this->emailService->sendPasswordResetEmail();

            $this->entityManager->flush();
            $this->entityManager->commit();

            return ResetUserPasswordResponse::createFromSuccess();
        } catch (Throwable $e) {
            $this->entityManager->rollback();
            $this->logger->error($e->getMessage());
            return ResetUserPasswordResponse::createFromUnknownError();
        }
    }
}
