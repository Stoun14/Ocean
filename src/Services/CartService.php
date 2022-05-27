<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function addToCart($id)
    {
        $session = $this->requestStack->getSession();
    }

    public function deleteFromCart($id)
    {
    }

    public function deleteCart()
    {
    }
}
