<?php

namespace App\Controller\Main;

use App\Controller\RegisterUser\ResetUserPasswordRequest;
use App\Controller\RegisterUser\ResetUserPasswordResponse;
use App\Services\User\RegisterUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/", name: "main_page", methods: ["GET"])]
class MainController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    public function __invoke(): RedirectResponse
    {

        phpinfo();

        die;

//        phpinfo();
//        die;

//        return $this->redirect($this->getParameter('main_site'));
    }
}
