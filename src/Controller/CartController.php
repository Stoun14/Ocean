<?php

namespace App\Controller;

use App\Entity\Product;
use App\Services\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/cart')]
class CartController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/', name: 'cart_index')]
    public function index(CartService $cartService): Response
    {
        $cart = $cartService->getFullCart();
        $nbproducts = $cartService->getNbProducts();
        $total = $cartService->getTotal();

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'nbproducts' => $nbproducts,
            'total' => $total
        ]);
    }

    #[Route('/add/{id}', name: 'cart_add')]
    public function add(CartService $cartService, int $id): Response
    {
        $cartService->addOneToCart($id);

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/remove/{id}', name: 'cart_remove')]
    public function remove(CartService $cartService, int $id): Response
    {
        $cartService->deleteOneFromCart($id);

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/clear', name: 'cart_clear')]
    public function clear(CartService $cartService): Response
    {
        $cartService->eraseCart();

        return $this->redirectToRoute('cart_index');
    }
}
