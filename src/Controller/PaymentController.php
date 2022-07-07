<?php

namespace App\Controller;

use Stripe\StripeClient;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/payment')]
class PaymentController extends AbstractController
{
    #[Route('/', name: 'payment')]
    public function index(RequestStack $requestStack, ProductRepository $productRepository): Response
    {
        $cart = $requestStack->getSession()->get('cart');
        $stripeCart = [];

        foreach ($cart as $id => $quantity) {
            $product = $productRepository->find($id);
            $stripeElement = [
                'amount' => $product->getPrice(),
                'quantity' => $quantity,
                'currency' => 'EUR',
                'name' => $product->getName()
            ];
            $stripeCart[] = $stripeElement;
        }

        $stripe = new StripeClient('sk_test_51L6I6JE5uA7WDwqFsR5sM3QfWT7x5oHRJNQMfrNPvTjdUs8XqjsJou9t6MC6AtmgcOZNTVsYdrWynXX3V56guR2h00MYUTDZNP');

        $stripeSession = $stripe->checkout->sessions->create([
            'line_items' => $stripeCart,
            'mode' => 'payment',
            'success_url' => 'https://127.0.0.1:8000/payment/success',
            'cancel_url' => 'https://127.0.0.1:8000/payment/cancel',
            'payment_method_types' => ['card']
        ]);

        return $this->render('payment/index.html.twig', [
            'sessionId' => $stripeSession->id,
        ]);
    }
}
