<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ApiController extends AbstractController
{
    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        JWTTokenManagerInterface $jwtManager
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['username']) || !isset($data['password'])) {
            return new JsonResponse(
                ['error' => 'Les champs username et password sont requis'],
                Response::HTTP_BAD_REQUEST
            );
        }

        $user = $userRepository->findOneBy(['email' => $data['username']]);

        if (!$user || !$passwordHasher->isPasswordValid($user, $data['password'])) {
            return new JsonResponse(
                ['error' => 'Identifiants incorrects'],
                Response::HTTP_UNAUTHORIZED
            );
        }

        if (!$user->isApiEnabled()) {
            return new JsonResponse(
                ['error' => 'Accès API non activé'],
                Response::HTTP_FORBIDDEN
            );
        }

        $token = $jwtManager->create($user);

        return new JsonResponse(['token' => $token], Response::HTTP_OK);
    }

    #[Route('/api/products', name: 'api_products', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function getProducts(ProductRepository $productRepository): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user->isApiEnabled()) {
            return new JsonResponse(
                ['error' => 'Accès API non activé'],
                Response::HTTP_FORBIDDEN
            );
        }

        $products = $productRepository->findAll();
        $productsData = [];

        foreach ($products as $product) {
            $productsData[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'shortDescription' => $product->getShortDescription(),
                'fullDescription' => $product->getLongDescription(),
                'price' => (float) $product->getPrice(),
                'picture' => $product->getImagePath(),
            ];
        }

        return new JsonResponse($productsData, Response::HTTP_OK);
    }
}
