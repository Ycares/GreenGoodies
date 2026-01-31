<?php

namespace App\Controller;

use App\Entity\CustomerOrder;
use App\Repository\CartItemRepository;
use App\Repository\CustomerOrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/panier', name: 'app_cart', methods: ['GET'])]
    public function index(CartItemRepository $cartItemRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();

        $items = $cartItemRepository->findBy(['user' => $user]);

        $groupedItems = [];
        $total = 0;
        foreach ($items as $item) {
            $product = $item->getProduct();
            if (!$product) {
                continue;
            }

            $productId = $product->getId();
            $unitPrice = (float) $product->getPrice();
            $quantity = $item->getQuantity();

            if (!isset($groupedItems[$productId])) {
                $groupedItems[$productId] = [
                    'product' => $product,
                    'quantity' => 0,
                    'unitPrice' => $unitPrice,
                    'lineTotal' => 0,
                ];
            }

            $groupedItems[$productId]['quantity'] += $quantity;
            $groupedItems[$productId]['lineTotal'] = $groupedItems[$productId]['quantity'] * $unitPrice;
        }

        foreach ($groupedItems as $groupedItem) {
            $total += $groupedItem['lineTotal'];
        }

        return $this->render('cart/index.html.twig', [
            'items' => $groupedItems,
            'total' => $total,
        ]);
    }

    #[Route('/panier/vider', name: 'app_cart_clear', methods: ['POST'])]
    public function clear(CartItemRepository $cartItemRepository, EntityManagerInterface $em): RedirectResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $items = $cartItemRepository->findBy(['user' => $this->getUser()]);

        foreach ($items as $item) {
            $em->remove($item);
        }
        $em->flush();

        $this->addFlash('success', 'Panier vidé.');

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/panier/valider', name: 'app_cart_validate', methods: ['POST'])]
    public function validateCart(
        CartItemRepository $cartItemRepository,
        CustomerOrderRepository $customerOrderRepository,
        EntityManagerInterface $em
    ): RedirectResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();
        $items = $cartItemRepository->findBy(['user' => $user]);

        if (count($items) === 0) {
            $this->addFlash('warning', 'Votre panier est vide.');
            return $this->redirectToRoute('app_cart');
        }

        $total = 0;
        foreach ($items as $item) {
            $total += $item->getQuantity() * (float) $item->getProduct()->getPrice();
        }

        $order = new CustomerOrder();
        $order->setUser($user);
        $order->setCreatedAt(new \DateTimeImmutable());
        $order->setTotal((string) $total);
        $orderCountForUser = $customerOrderRepository->count(['user' => $user]);
        $order->setNumber((string) ($orderCountForUser + 1));
        $em->persist($order);

        foreach ($items as $item) {
            $em->remove($item);
        }

        $em->flush();

        $this->addFlash('success', 'Commande validée. Merci !');

        return $this->redirectToRoute('app_account');
    }
}
