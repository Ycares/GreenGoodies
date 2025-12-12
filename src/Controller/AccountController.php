<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CustomerOrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccountController extends AbstractController
{
    #[Route('/mon-compte', name: 'app_account', methods: ['GET'])]
    public function index(CustomerOrderRepository $customerOrderRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $orders = $customerOrderRepository->findBy(
            ['user' => $this->getUser()],
            ['createdAt' => 'DESC']
        );

        return $this->render('account/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    #[Route('/mon-compte/supprimer', name: 'app_account_delete', methods: ['POST'])]
    public function deleteAccount(EntityManagerInterface $em, TokenStorageInterface $tokenStorage, SessionInterface $session): RedirectResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();

        $tokenStorage->setToken(null);
        $session->invalidate();

        $em->remove($user);
        $em->flush();

        $this->addFlash('success', 'Compte supprimé avec succès.');

        return $this->redirectToRoute('app_home');
    }

    #[Route('/mon-compte/api/toggle', name: 'app_account_toggle_api', methods: ['POST'])]
    public function toggleApi(EntityManagerInterface $em): RedirectResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();
        // Add user params ?
        $user->setApiEnabled(!$user->isApiEnabled());
        $em->persist($user);
        $em->flush();

        $this->addFlash('success', $user->isApiEnabled() ? 'Accès API activé.' : 'Accès API désactivé.');

        return $this->redirectToRoute('app_account');
    }
}
