<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/cart', name: 'cart')]
    public function index(): Response
    {
        $session = $this->requestStack->getSession();

        // stores an attribute in the session for later reuse
        $session->set('cart', ['name' => 'session']);

        $cart = $session->get('cart');

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'cart' => $cart
        ]);
    }
}
