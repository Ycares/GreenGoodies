<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirect('/');
        }

        return $this->render('auth/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'has_error' => $authenticationUtils->getLastAuthenticationError() !== null,
        ]);
    }

    #[Route('/deconnexion', name: 'app_logout')]
    public function logout(): void
    {
        // Symfony intercepte cette route pour gérer la déconnexion
        throw new \LogicException('Cette méthode peut rester vide : la déconnexion est gérée par le firewall.');
    }
}
