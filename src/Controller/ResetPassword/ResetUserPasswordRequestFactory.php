<?php

namespace App\Controller\ResetPassword;

use Symfony\Component\HttpFoundation\RequestStack;

readonly class ResetUserPasswordRequestFactory
{
    public function __construct(private RequestStack $requestStack) {}

    public function create(): ResetUserPasswordRequest
    {
        return new ResetUserPasswordRequest($this->requestStack->getCurrentRequest());
    }
}
