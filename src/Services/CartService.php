<?php

namespace App\Services;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private $session;
    private $productRepo;

    public function __construct(RequestStack $requestStack, ProductRepository $productRepository)
    {
        $this->session = $requestStack->getSession();
        $this->productRepo = $productRepository;
    }

    public function addOneToCart(int $id)
    {
        $cart = $this->getCart();

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        $this->updateCart($cart);
    }

    public function deleteOneFromCart(int $id)
    {
        $cart = $this->getCart();

        if (!empty($cart[$id])) {
            if ($cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
            $this->updateCart($cart);
        }
    }

    public function deleteAllFromCart(int $id)
    {
        $cart = $this->getCart();

        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }
        $this->updateCart($cart);
    }

    public function eraseCart()
    {
        $this->session->remove('cart');
    }

    public function updateCart($cart)
    {
        $this->session->set('cart', $cart);
    }

    public function getCart()
    {
        return $this->session->get('cart', []);
    }

    public function getFullCart()
    {
        $sessionCart = $this->getCart();
        $cart = [];

        foreach ($sessionCart as $id => $quantity) {
            $element = [
                'product' => $this->productRepo->find($id),
                'quantity' => $quantity
            ];
            $cart = $element;
        }

        return $cart;
    }

    public function getTotal()
    {
        $cart = $this->getCart();
        $total = 0;

        foreach ($cart as $id => $quantity) {
            $product = $this->productRepo->find($id);
            $total = $product->getPrice() * $quantity;
        }
        return $total;
    }

    public function getNbProducts()
    {
        $cart = $this->getCart();
        $nb = 0;

        foreach ($cart as $line) {
            $nb++;
        }
        return $nb;
    }
}
