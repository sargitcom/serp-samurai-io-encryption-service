<?php

namespace App\Controller\ResetPassword;

use App\Services\User\ResetUserPasswordService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/user/password/reset-link", name: "reset_user_password", methods: ["POST"])]
class ResetUserPasswordController extends AbstractController
{
    public function __construct(private readonly ResetUserPasswordService $userService) {}

    public function __invoke(ResetUserPasswordRequest $request): ResetUserPasswordResponse
    {
        return $this->userService->resetUserPassword($request);
    }
}
