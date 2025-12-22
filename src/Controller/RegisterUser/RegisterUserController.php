<?php

namespace App\Controller\RegisterUser;

use App\Services\User\RegisterUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/user", name: "register_user", methods: ["POST"])]
class RegisterUserController extends AbstractController
{
    public function __construct(private readonly RegisterUserService $userService) {}

    public function __invoke(RegisterUserRequest $request): RegisterUserResponse
    {
        return $this->userService->registerUser($request);
    }
}
