<?php

namespace App\Controller\RegisterUser;

use Symfony\Component\HttpFoundation\RequestStack;

readonly class RegisterUserRequestFactory
{
    public function __construct(private RequestStack $requestStack) {}

    public function create(): CreateSearchRequest
    {
        return new CreateSearchRequest($this->requestStack->getCurrentRequest());
    }
}
