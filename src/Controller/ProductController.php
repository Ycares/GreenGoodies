<?php

namespace App\Controller;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Repository\CartItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/produit/{id}', name: 'app_product_show', methods: ['GET', 'POST'])]
    public function show(
        Product $product,
        Request $request,
        EntityManagerInterface $em,
        CartItemRepository $cartItemRepository,
    ): Response {
        $user = $this->getUser();

        if ($request->isMethod('POST')) {
            if (!$user) {
                return $this->redirectToRoute('app_login');
            }

            $cartItem = new CartItem();
            $cartItem->setUser($user);
            $cartItem->setProduct($product);
            $cartItem->setQuantity(1);
            $em->persist($cartItem);
            $em->flush();

            return $this->redirectToRoute('app_cart');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
